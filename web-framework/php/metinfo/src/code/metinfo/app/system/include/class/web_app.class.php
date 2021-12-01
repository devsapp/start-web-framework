<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('web');
class web_app extends web
{
    private $sql = array();

    public $error;

    public $version;

    public function __construct()
    {
        parent::__construct();
    }

    protected function show($file, $data)
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

            $_limit = $_start;
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

    protected function app_curl($url, $data, $timeout = 10)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
