<?php

// MetInfo Enterprise Content Management System
// Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * Class tables
 * 数据库对比
 */
class tables
{
    public $version;

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

    /**
     * @param string $url
     * @param array $data
     * @param int $timeout
     * @return mixed
     */
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

// This program is an open source system, commercial use, please consciously to purchase commercial license.;
// Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
