<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');
// 兼容6.2.0的应用
load::sys_class('admin');
class app extends admin
{
    private $sql = array();

    public $error;

    public $version;

    public function __construct()
    {
        parent::__construct();
    }

    protected function show($file, $data = '')
    {
        global $_M;
        $view = load::sys_class('engine', 'new');
        $view->dodisplay($file, $data);
    }

    protected function table($tableName)
    {
        global $_M;
        $this->sql["table"] = $_M['table'][$tableName];
        return $this;
    }

    protected function where($_where = '1=1')
    {
        global $_M;
        $this->sql["where"] = "WHERE " . $_where;
        return $this;
    }

    protected function order($_order = 'id DESC')
    {
        global $_M;
        $this->sql["order"] = "ORDER BY " . $_order;
        return $this;
    }

    protected function limit($_start = '0', $_limit = '')
    {
        global $_M;
        if (!$_limit) {
            $_limit = 20;
            $_start = 0;
        }
        $this->sql["limit"] = "LIMIT {$_start}," . $_limit;
        return $this;
    }

    protected function get($_select = '*')
    {
        global $_M;
        $query = trim("SELECT " . $_select . " FROM " . (implode(" ", $this->sql)));
        $res = DB::get_all($query);
        unset($this->sql);
        return $res;
    }

    protected function find($_find = '*')
    {
        $query = trim("SELECT " . $_find . " FROM " . (implode(" ", $this->sql)));
        unset($this->sql);
        return DB::get_one($query);
    }

    protected function insert($data = array())
    {
        if (!is_array($data)) {
            return;
        }

        if (empty($data)) {
            return;
        }

        $sql = "";
        foreach ($data as $key => $value) {
            $value = str_replace("'", "\'", $value);
            $sql .= " {$key} = '{$value}',";
        }
        $sql = trim($sql, ',');

        $query = "INSERT INTO " . (implode(" ", $this->sql)) . " SET {$sql}";
        unset($this->sql);
        return DB::query($query);
    }

    protected function update($data = array())
    {
        if (!is_array($data)) {
            return;
        }

        if (empty($data)) {
            return;
        }

        $sql = "";
        foreach ($data as $key => $value) {
            $value = str_replace("'", "\'", $value);
            $sql .= " {$key} = '{$value}',";
        }
        $sql = trim($sql, ',');

        $query = trim("UPDATE " . $this->sql['table'] . " SET {$sql} {$this->sql['where']}");
        unset($this->sql);
        return DB::query($query);
    }

    protected function delete()
    {
        $query = trim("DELETE FROM  " . $this->sql['table'] . " {$this->sql['where']}");
        unset($this->sql);
        return DB::query($query);
    }

    /**
     * 获取标准数据库文件
     * @return mixed
     */
    public function get_base_table()
    {
        $json_sql = "https://www.metinfo.cn/upload/json/v{$this->version}mysql.json";
        $table_json = file_get_contents($json_sql);
        if (!$table_json) {
            $table_json = self::app_curl($json_sql);
        }
        $base = json_decode($table_json, true);
        return $base;
    }

    public function get_diff_tables()
    {
        global $_M;
        $tables = self::list_tables();
        $base = self::get_base_table();

        /*$json_sql = "https://www.metinfo.cn/upload/json/v{$this->version}mysql.json";
        $json = file_get_contents($json_sql);
        $base = json_decode($json,true);*/

        $baseTables = array_keys($base);
        $diffTables = array_diff($baseTables, $tables);

        $noTables = array();
        $data = array();
        foreach ($diffTables as $noTable) {
            $table_name = $noTable;
            $noTable = str_replace('met_', $_M['config']['tablepre'], $noTable);
            $data['table'][$noTable] = $base[$table_name];
            $noTables[] = $noTable;
        }

        foreach ($base as $table => $val) {
            if (!in_array($table, $noTables)) {
                $table = str_replace('met_', $_M['config']['tablepre'], $table);
                $fields = self::list_fields($table);
                $diff_field = array_diff_key($val, $fields);
                if ($diff_field) {
                    $data['field'][$table] = $diff_field;
                }
            }
        }
        return $data;
    }

    public function list_tables()
    {
        global $_M;
        $query = "SHOW TABLE status";
        $tables = array();
        foreach (DB::get_all($query) as $key => $v) {
            $tables[] = str_replace($_M['config']['tablepre'], 'met_', $v['Name']);
        }
        return $tables;
    }

    public function list_fields($table)
    {
        global $_M;
        $query = "SHOW FULL FIELDS FROM {$table}";
        $fields = DB::get_all($query);
        $data = array();
        foreach ($fields as $key => $v) {
            $data[$v['Field']] = $v;
        }
        return $data;
    }

    protected function app_curl($url = '', $data = array(), $timeout = 10)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
