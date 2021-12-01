<?php

// MetInfo Enterprise Content Management System
// Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * 数据库操作类.
 */
class DB
{
    public static $querynum = 0;
    public static $link;

    /**
     * 数据库连接函数.
     *
     * @param string $con_db_host 主机地址
     * @param string $con_db_id   用户名
     * @param string $con_db_pass 密码
     * @param string $con_db_name 数据库名
     * @param string $db_charset  字符编码
     * @param string $pconnect    是否打开永久链接
     */
    public static function dbconn($db_name)
    {
        self::$link = @new SQLite3($db_name);

        if (!self::$link) {
            self::halt(self::$link->lastErrorMsg());
        }
        self::$link->busyTimeout(3000);
    }

    /**
     * 获取一条数据.
     *
     * @param string $sql  select sql语句
     * @param string $type 为UNBUFFERED时，不获取缓存结果
     *
     * @return array 返回执行sql语句后查询到的数据
     */
    public static function get_one($sql)
    {
        $rs = self::$link->querySingle($sql, true);
        //如果是前台可视化编辑模式
        if (IN_ADMIN !== true && $_GET['pageset'] == 1) {
            $rs = load::sys_class('view/met_datatags', 'new')->replace_sql_one($sql, $rs);
        }

        if ($rs && is_array($rs)) {
            foreach ($rs as &$val) {
                if (is_numeric($val)) {
                    $val = (string) $val;
                }
            }
        }

        return $rs;
    }

    public static function get_all($sql, $type = '')
    {
        $result = self::query($sql);
        if (!$result) {
            return;
        }
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            if ($row && is_array($row)) {
                foreach ($row as &$val) {
                    if (is_numeric($val)) {
                        $val = (string) $val;
                    }
                }
            }
            $rs[] = $row;
        }
        $result->finalize();
        if (IN_ADMIN !== true && $_GET['pageset'] == 1) {
            $rs = load::sys_class('view/met_datatags', 'new')->replace_sql_all($sql, $rs);
        }

        return $rs;
    }

    public static function fetch_array($result)
    {
        if (!$result) {
            return false;
        }
        $res = $result->fetchArray(SQLITE3_ASSOC);

        // $result->finalize();
        return $res;
    }

    public static function query($sql)
    {
        if (strstr($sql, 'rand()')) {
            $sql = str_replace('rand()', 'random()', $sql);
        }
        if (strstr($sql, 'char_length(')) {
            $sql = str_replace('char_length(', 'length(', $sql);
        }
        $sql = self::escapeSqlite($sql);

        if (strtoupper(substr($sql, 0, 6)) == 'INSERT') {
            $sql = str_replace(array("\n", "\r"), '', $sql);
            self::$link->exec('begin;');
            preg_match('/insert\s+into\s+([`a-z0-9A-Z_]+)\s+set\s+(.*)/i', $sql, $match);

            if (isset($match[1]) && isset($match[2]) && $match[2]) {
                $list = array();
                $table = trim($match[1], '`');
                foreach (explode(',', $match[2]) as $val) {
                    if (!trim($val)) {
                        continue;
                    }

                    $param = explode('=', $val);
                    if (trim($param[0])) {
                        $list[trim($param[0])] = str_replace("'", '', trim($param[1]));
                    }
                }

                $row = self::insert($table, $list);

                return $row;
            }

            $result = self::$link->exec($sql);
            if (!$result) {
                self::$link->exec('rollback;');

                error($sql.self::$link->lastErrorMsg());
            }
            self::$link->exec('commit;');
            if (!self::$link->lastInsertRowId()) {
                error($sql.self::$link->lastErrorMsg());
            }

            return self::$link->lastInsertRowId();
        }

        if (strtoupper(substr($sql, 0, 6)) == 'UPDATE') {
            self::$link->exec('begin;');
            $result = self::$link->exec($sql);
            if (!$result) {
                self::$link->exec('rollback;');
            }

            return self::$link->exec('commit;');
        }

        if (strtoupper(substr($sql, 0, 12)) == 'CREATE TABLE') {
            $sql = load::mod_class('databack/transfer', 'new')->mysqlToSqlite($sql);
        }

        $result = self::$link->query($sql);

        return $result;
    }

    public static function insert($table, $bind = array())
    {
        $set = array();

        foreach ($bind as $col => $val) {
            $col = trim($col, '`');

            if ($col == 'id' && (!$val || $val == 'NULL')) {
                continue;
            }
            $val = self::escapeSqlite($val);
            $set[] = "`$col`";
            $vals[] = "'$val'";
        }
        $sql = 'INSERT INTO '
            .$table
            .' ('.implode(', ', $set).') '
            .'VALUES ('.implode(', ', $vals).')';

        self::$link->exec('begin;');
        $result = self::$link->exec($sql);

        if (!$result) {
            self::$link->exec('rollback;');
        }

        self::$link->exec('commit;');

        return self::$link->lastInsertRowId();
    }

    public static function update($table = '', $bind = array(), $condition = array())
    {
        die();
        $sql1 = '';
        foreach ($bind as $key => $val) {
            if ($key != 'id') {
                $sql1 .= " $key = '{$val}',";
            }
        }
        $sql1 = trim($sql1, ',');

        $sql2 = '';
        foreach ($condition as $key => $val) {
            if ($key != 'id') {
                $sql2 .= " $key = '{$val}',";
            }
        }
        $sql2 = trim($sql2, ',');

        $sql = "UPDATE {$table} SET $sql1 WHERE $sql2";

        $res = self::query($sql);

        return $res;
    }

    /**
     * 获取指定条数数据.
     *
     * @param string $table       表名称
     * @param string $where       where条件
     * @param string $order       order条件
     * @param string $limit_start 开始条数
     * @param string $limit_num   取条数数量
     * @param string $field_name  获取的字段
     *
     * @return array 查询得到的数据
     */
    public static function get_data($table, $where, $order, $limit_start = 0, $limit_num = 20, $field_name = '*')
    {
        if ($limit_start < 0) {
            return false;
        }
        $limit_start = $limit_start ? $limit_start : 0;
        $where = str_ireplace('WHERE', '', $where);
        $order = str_ireplace('ORDER BY', '', $order);
        if ($where) {
            $conds .= " WHERE {$where} ";
        }
        if ($order) {
            $conds .= " ORDER BY {$order} ";
        }

        $conds .= " LIMIT {$limit_start},{$limit_num}";
        $query = "SELECT {$field_name} FROM {$table} {$conds}";
        $data = DB::get_all($query);
        if ($data) {
            return $data;
        } else {
            if ($limit_start == 0) {
                return $data;
            } else {
                return false;
            }
        }
    }

    /**
     * 统计条数.
     *
     * @param string $table_name insert、update等 sql语句
     * @param string $where_str  where条件,建议添加上WEHER
     * @param string $field_name 统计的字段
     *
     * @return int 统计条数
     */
    public static function counter($table_name, $where_str = '', $field_name = '*')
    {
        $where_str = trim($where_str);
        if (strtolower(substr($where_str, 0, 5)) != 'where' && $where_str) {
            $where_str = 'WHERE '.$where_str;
        }
        $query = " SELECT COUNT($field_name) FROM $table_name $where_str ";
        $result = self::$link->querySingle($query);

        return $result;
    }

    public static function affected_rows()
    {
        return self::$link->affected_rows;
    }

    public static function error()
    {
        return self::$link->lastErrorMsg();
    }

    public static function errno()
    {
        return self::$link->lastErrorCode();
    }

    public static function errorlist()
    {
        return self::$link->error_list;
    }

    public static function result($query, $row)
    {
        die('method disable');
    }

    public static function num_rows($result)
    {
        $nums = array();
        while ($row = DB::fetch_row($result)) {
            $nums[] = $row;
        }

        return count($nums);
    }

    public static function fields($result)
    {
        if ($result instanceof mysqli_result) {
            return $result->fetch_fields();
        } else {
            self::errno();
        }
    }

    public static function num_fields($result)
    {
        if (!$result) {
            return;
        }
        $res = $result->numColumns();
        // $result->finalize();

        return $res;
    }

    public static function free_result($result)
    {
        return $result->finalize();
    }

    public static function insert_id()
    {
        return self::$link->lastInsertRowId();
    }

    public static function fetch_row($result)
    {
        if ($result instanceof SQLite3Result) {
            return $result->fetchArray(SQLITE3_NUM);
        } else {
            self::errno();
        }
    }

    public function escapeString($result, $sql)
    {
        // return str_replace("'", "\'", $result->escapeString($sql));
        return str_replace("'", "\'", $sql);
    }

    public function escapeSqlite($sql)
    {
        $sql = str_replace("\\'", "''", $sql);
        $sql = str_replace('\\', '', $sql);

        return $sql;
    }

    public static function version()
    {
        $info = @self::$link->version();

        return 'sqlite'.$info['versionString'];
    }

    /**
     * 关闭连接.
     */
    public static function close()
    {
        return @self::$link->close();
    }

    /**
     * 无法连接数据库报错.
     */
    public static function halt($dbhost)
    {
        $sqlerror = self::$link->lastErrorMsg();
        $sqlerrno = self::$link->lastErrorCode();
        $sqlerror = str_replace($dbhost, 'dbhost', $sqlerror);

        header('HTTP/1.1 500 Internal Server Error');
        halt("$sqlerror  ( $sqlerrno )");
        exit;
    }
}

// This program is an open source system, commercial use, please consciously to purchase commercial license.
// Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
