<?php

// MetInfo Enterprise Content Management System
// Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * download标签类.
 */
class transfer
{
    public function mysqlExportSqlite()
    {
        global $_M;
        $sqlite = new SQLite3(PATH_WEB.$_M['config']['db_name']);

        foreach ($_M['table'] as $key => $table) {
            $this->transferMysqlTable($sqlite, $table);
        }
    }

    public function transferMysqlTable($sqlite, $table)
    {
        global $_M;

        $sql = "DROP TABLE IF EXISTS $table;\n";
        $res = DB::query('SHOW CREATE TABLE '.$table);

        $create = DB::fetch_row($res);
        if (!$create) {
            return;
        }

        $sql .= str_replace(strtolower($table), $table, $create[1]).";\n\n";

        $sql = $this->mysqlToSqlite($sql);

        $sqlite->exec('begin;');
        $result = $sqlite->exec($sql);
        if (!$result) {
            $error = $sql.$sqlite->lastErrorMsg();
            $sqlite->exec('rollback;');
            error($error);
        }
        $sqlite->exec('commit;');
        $this->tranferMysqlRows($sqlite, $table);
    }

    public function tranferMysqlRows($sqlite, $table, $start = 0)
    {
        global $_M;

        $sql = '';
        $offset = 1000;
        $sqlite->exec('begin;');
        $rows = DB::query("SELECT * FROM {$table} LIMIT {$start},{$offset}");
        $numfields = DB::num_fields($rows);
        $numrows = DB::num_rows($rows);
        if ($numrows <= 0) {
            return;
        }
        while ($row = DB::fetch_row($rows)) {
            $values = '';
            $sql .= "INSERT INTO $table VALUES(";
            for ($i = 0; $i < $numfields; ++$i) {
                $sql .= $values."'".str_replace("'", "''", $row[$i])."'";
                $values = ',';
            }
            $sql .= ");\n";
        }

        $result = $sqlite->exec($sql);
        if (!$result) {
            $error = $sqlite->lastErrorMsg();
            $sqlite->exec('rollback;');
            error($error);
        }
        $sqlite->exec('commit;');
        $start += $offset;
        $this->tranferMysqlRows($sqlite, $table, $start);
    }

    public function sqliteExportMysql($config)
    {
        global $_M;

        @extract($config);
        $mysql = @new mysqli($con_db_host, $con_db_id, $con_db_pass, $con_db_name, $con_db_port);
        if ($mysql->connect_error) {
            halt($con_db_host);
        }
        if ($mysql->server_info > '4.1') {
            if (!$db_charset) {
                $db_charset = 'utf8';
            }
            if ($db_charset != 'latin1') {
                $mysql->query("SET character_set_connection=$db_charset, character_set_results=$db_charset, character_set_client=binary");
            }

            if ($mysql->server_info > '5.0.1') {
                $mysql->query("SET sql_mode=''");
            }
        }

        if ($con_db_name) {
            $mysql->select_db($con_db_name);
        }

        // $this->diff_fields($mysql, $_M['config']['metcms_v']);
        foreach ($_M['table'] as $key => $table) {
            $newTable = str_replace($_M['config']['tablepre'], $tablepre, $table);

            $drop = "DROP TABLE IF EXISTS $newTable;";
            $mysql->query($drop);
            $res = DB::$link->query("PRAGMA table_info(${table})");
            $tabledump = "CREATE TABLE IF NOT EXISTS `{$newTable}` (";
            while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
                if ($row['name'] == 'id') {
                    $tabledump .= '`id` int(11) NOT NULL AUTO_INCREMENT,';
                    continue;
                }
                $type = str_replace('text(', 'varchar(', $row['type']);
                $type = str_replace('integer(', 'int(', $type);
                $notnull = $row['notnull'] ? '' : 'NOT NULL';
                $notnull = '';
                $default = $row['dflt_value'] == 'NULL' ? '' : "DEFAULT {$row['dflt_value']}";
                if (trim($default) == 'DEFAULT') {
                    $default = '';
                }
                $tabledump .= "`{$row['name']}` {$type} {$notnull} {$default},";
            }
            if (!strstr($tabledump, 'AUTO_INCREMENT')) {
                continue;
            }
            $tabledump .= 'PRIMARY KEY (`id`)';
            $tabledump .= ') ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;';
            $res->finalize();
            $res = $mysql->query($tabledump);

            $this->tranferSqliteRows($mysql, $table, $newTable);
        }
        $mysql->close();
    }

    public function tranferSqliteRows($mysql, $table, $newTable, $start = 0)
    {
        global $_M;

        $offset = 1000;
        $rows = DB::query("SELECT * FROM {$table} LIMIT {$start},{$offset}");

        $numfields = DB::num_fields($rows);

        while ($row = DB::fetch_row($rows)) {
            $sql = '';
            $values = '';
            $sql .= "INSERT INTO $newTable VALUES(";
            for ($i = 0; $i < $numfields; ++$i) {
                // $sql .= $values."'".str_replace("'", "''", $row[$i])."'";
                $sql .= $values."'".mysqli_real_escape_string($mysql, $row[$i])."'";
                $values = ',';
            }
            $sql .= ");\n";
            $result = $mysql->query($sql);
            if ($result !== true) {
                error($mysql->error.$sql);
            }
        }

        $sql = trim($sql);
        if (!$sql) {
            return;
        }

        $start += $offset;
        $this->tranferSqliteRows($mysql, $table, $newTable, $start);
    }

    public function diff_fields($mysql, $version)
    {
        global $_M;
        $app = load::sys_class('app', 'new');
        $app->version = $version;
        $diffs = $this->get_diff_tables($app, $mysql);
        if (isset($diffs['table'])) {
            foreach ($diffs['table'] as $table => $detail) {
                $sql = "CREATE TABLE IF NOT EXISTS `{$table}` (";
                foreach ($detail as $k => $v) {
                    if ($k == 'id') {
                        $sql .= "`{$k}` {$v['Type']} {$v['Extra']} ,";
                    } else {
                        $sql .= "`{$k}` {$v['Type']} ";

                        if ($v['Default'] === null) {
                            $sql .= ' DEFAULT NULL ';
                        } else {
                            $sql .= " DEFAULT '{$v['Default']}' ";
                        }

                        $sql .= "  {$v['Extra']},";
                    }
                }
                $sql .= 'PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;';
                $row = $mysql->query($sql);
                if (!$row) {
                    error($mysql->error.'-'.$sql);
                }
                $list = explode('|', str_replace($_M['config']['tablepre'], '', $table));
                foreach ($list as $key => $val) {
                    $tablename = $val;
                    if (strpos("|{$_M['config']['met_tablename']}|", "|{$tablename}|") === false) {
                        $_M['config']['met_tablename'] = "{$_M['config']['met_tablename']}|{$tablename}";
                        $query = "UPDATE {$_M['table']['config']} SET value = '{$_M['config']['met_tablename']}' WHERE name='met_tablename'";
                        $mysql->query($query);
                        $_M['table'][$tablename] = $_M['config']['tablepre'].$tablename;
                    }
                }
            }
        }

        if (isset($diffs['field'])) {
            foreach ($diffs['field'] as $table => $v) {
                foreach ($v as $field => $f) {
                    $sql = "ALTER TABLE `{$table}` ADD COLUMN `{$field}`  {$f['Type']} ";

                    if ($f['Default'] === null) {
                        $sql .= ' Default NULL ';
                    } else {
                        $sql .= " Default '{$f['Default']}' ";
                    }
                    $row = $mysql->query($sql);
                    if (!$row) {
                        error($mysql->error.'-'.$sql);
                    }
                }
            }
        }
    }

    public function get_diff_tables($app, $mysql)
    {
        global $_M;
        $tables = $this->list_tables($mysql);
        $base = $app->get_base_table();

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
                $fields = $this->list_fields($mysql, $table);
                $diff_field = array_diff_key($val, $fields);
                if ($diff_field) {
                    $data['field'][$table] = $diff_field;
                }
            }
        }

        return $data;
    }

    public function list_tables($mysql)
    {
        global $_M;
        $query = 'SHOW TABLE status';
        $tables = array();
        $data = $this->get_all($mysql, $query);
        foreach ($data as $key => $v) {
            $tables[] = str_replace($_M['config']['tablepre'], 'met_', $v['Name']);
        }

        return $tables;
    }

    public function list_fields($mysql, $table)
    {
        global $_M;
        $query = "SHOW FULL FIELDS FROM {$table}";
        $fields = $this->get_all($mysql, $query);
        $data = array();
        foreach ($fields as $key => $v) {
            $data[$v['Field']] = $v;
        }

        return $data;
    }

    public function get_all($mysql, $query)
    {
        $result = $mysql->query($query);
        $rs = array();
        if ($result instanceof mysqli_result) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $rs[] = $row;
            }
        } else {
            die($mysql->error());
        }

        return $rs;
    }

    public function mysqlToSqlite($sql)
    {
        $expr = array(
            '/`(\w+)`\s/' => '[$1] ',
            '/\s+UNSIGNED/i' => '',
            '/\s+[A-Z]*INT(\([0-9]+\))/i' => ' integer$1',
            '/\s+INTEGER\(\d+\)(.+AUTO_INCREMENT)/i' => ' integer$1',
            '/\s+AUTO_INCREMENT(?!=)/i' => ' PRIMARY KEY AUTOINCREMENT',
            '/\s+CHARACTER\s+SET\s+utf8\s+COLLATE\s+utf8_bin/i' => ' ',
            '/\s+ROW_FORMAT\s*=\s*DYNAMIC/i' => ' ',
            '/\s+ENUM\([^)]+\)/i' => ' text(255)',
            '/\s+varchar\((\d+)\)/i' => ' text($1)',
            '/\s+double/i' => ' REAL',
            '/\s+ON\s+UPDATE\s+[^,]*/i' => ' ',
            '/\s+COMMENT\s+(["\']).+\1/iU' => ' ',
            '/[\r\n]+\s+PRIMARY\s+KEY\s+[^\r\n]+/i' => '',
            '/[\r\n]+\s+UNIQUE\s+KEY\s+[^\r\n]+/i' => '',
            '/[\r\n]+\s+KEY\s+[^\r\n]+/i' => '',
            '/,([\s\r\n])+\)/i' => '$1)',
            '/\s+ENGINE\s*=\s*\w+/i' => ' ',
            '/DEFAULT\s+CHARSET\s*=\s*\w+/i' => ' ',
            '/\s+AUTO_INCREMENT\s*=\s*\d+/i' => ' ',
            '/\s+DEFAULT\s+;/i' => ';',
            '/\)([\s\r\n])+;/i' => ');',
            '/,?PRIMARY\sKEY\s\(`id`\)/i' => '',
            '/,\s+\)/i' => ')',
            '/\s+zerofill/i' => '',
        );

        foreach ($expr as $key => $value) {
            $sql = preg_replace_callback($key, function ($match) use ($value) {
                return str_replace('$1', $match[1], $value);
            }, $sql);
        }

        return $sql === null ? '' : $sql;
    }

    public function getQuery($string)
    {
        global $_M;
        $sqls = array();
        preg_match_all('/DROP\s+TABLE\s+IF\s+EXISTS\s+\w+;/i', $string, $matchA);
        preg_match_all('/CREATE\s+TABLE[\s\S]+?;/i', $string, $matchB);
        //$sqls = array_merge($matchA[0], $matchB[0]);
        if (is_array($matchA)) {
            $sqls = array_merge($sqls, $matchA[0]);
        }

        if (is_array($matchB)) {
            $sqls = array_merge($sqls, $matchB[0]);
        }

        $sqlArray = explode("');\n", $string);

        foreach ($sqlArray as $sql) {
            //dumpfile / outfile 过滤
            $matchC_res = preg_match('/into\s+(dumpfile|outfile)\s+/i', $sql, $matchC);
            if ($matchC_res) {
                continue;
            }

            $sql = $sql."');";
            if (strstr($sql, 'CREATE') || strstr($sql, 'DROP')) {
                foreach (explode(";\n", $sql) as $query) {
                    if (trim($query)) {
                        $query = $query.';';
                        $query = str_replace(';;', ';', $query);
                        if (strstr($query, 'CREATE') || strstr($query, 'DROP')) {
                            continue;
                        }
                        $new_sql = $query;
                    }
                }
            } else {
                if (trim($sql)) {
                    $query = str_replace(';;', ';', $sql);
                    $new_sql = $query;
                }
            }

            $matched = preg_match('/\w+/', $new_sql, $match);
            if (!$matched) {
                continue;
            }

            $sqls[] = str_replace("\n", '', $new_sql);
        }

        return $sqls;
    }

    public function importSql($string)
    {
        global $_M;
        preg_match("/^#[^\r\n]+\//im", $string, $match);
        $site_url = trim($match[0], '#');
        $tablepre = $_M['config']['tablepre'];
        $string = str_replace($site_url, $_M['url']['site'], $string);
        $old = array('DROP TABLE IF EXISTS met_', 'CREATE TABLE `met_', 'INSERT INTO met_');
        $new = array("DROP TABLE IF EXISTS {$tablepre}", "CREATE TABLE `{$tablepre}", "INSERT INTO {$tablepre}");
        $string = str_replace($old, $new, $string);
        if ($_M['config']['db_type'] == 'sqlite') {
            $this->importSqlite($string);
        } else {
            $this->importMysql($string);
        }
    }

    public function importSqlite($string)
    {
        global $_M;
        $tablepre = $_M['config']['tablepre'];
        DB::$link->exec('begin;');
        $sqls = $this->getQuery($string);
        foreach ($sqls as $query) {
            if (trim($query)) {
                if (stristr($query, 'CREATE TABLE')) {
                    $query = $this->mysqlToSqlite($query);
                }
                if (strstr($query, $tablepre.'admin_table')) {
                    continue;
                }

                if (strstr($query, $tablepre.'templates')) {
                    continue;
                }

                if (strstr($query, $tablepre.'admin_column')) {
                    continue;
                }

                if (strstr($query, $tablepre.'language')) {
                    continue;
                }
                $query = trim($query, ';');
                if (!$query) {
                    continue;
                }
                $query .= ';';
                $query = DB::escapeSqlite($query);

                $rs = DB::$link->exec($query);
                if (!$rs) {
                    file_put_contents(PATH_WEB.getAdminDir().'/sqlite_error.txt', $query.DB::$link->lastErrorMsg()."\n", FILE_APPEND);
                }
            }
        }
        DB::$link->exec('commit;');
    }

    public function importMysql($string)
    {
        global $_M;
        $tablepre = $_M['config']['tablepre'];
        $sqls = $this->getQuery($string);
        foreach ($sqls as $query) {
            if (trim($query)) {
                if (strstr($query, $tablepre.'admin_table')) {
                    continue;
                }

                if (strstr($query, $tablepre.'templates')) {
                    continue;
                }

                if (strstr($query, $tablepre.'admin_column')) {
                    continue;
                }

                if (strstr($query, $tablepre.'language')) {
                    continue;
                }
                $query = trim($query, ';');
                if (!$query) {
                    continue;
                }
                $query .= ';';
                DB::query($query);
            }
        }
    }
}

// This program is an open source system, commercial use, please consciously to purchase commercial license.;
// Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
