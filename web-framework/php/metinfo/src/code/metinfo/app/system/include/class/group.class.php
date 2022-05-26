<?php

// MetInfo Enterprise Content Management System
// Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/*
 * 前台会员类
 * @param string $user  当前登录用户信息
 */
load::sys_func('power'); //兼容以前函数用，新版中不要调用里面函数

class group
{
    public $grouplist;
    public $lang;

    public function __construct()
    {
        global $_M;
        $this->set_lang($_M['lang']);
    }

    public function set_lang($lang)
    {
        $this->lang = $lang;
    }

    public function get_group_list()
    {
        global $_M;
        if (!$this->grouplist[$this->lang]) {
            $this->grouplist[$this->lang] = buffer::getGroup($this->lang);
            if (!$this->grouplist[$this->lang]) {
                $query = "SELECT * FROM {$_M['table']['user_group']} WHERE lang='{$this->lang}' order by access ASC";
                $result = DB::get_all($query);
                foreach ($result as $key => $list) {
                    $this->grouplist[$this->lang][$list['id']] = $list;
                }
                buffer::setGroup($this->lang, $this->grouplist[$this->lang]);
            }
        }

        return $this->grouplist[$this->lang];
    }

    public function get_max_access()
    {
        global $_M;
        $query = "SELECT max(`access`) as `access`  FROM {$_M['table']['user_group']} WHERE lang='{$this->lang}'";
        $result = DB::get_one($query);

        return $result['access'];
    }

    public function get_group($groupid)
    {
        if ($groupid == '-1') {
            $max_access = $this->get_max_access();
            $admin_access = array('access' => $max_access + 1);

            return $admin_access;
        }
        $this->get_group_list();

        return $this->grouplist[$this->lang][$groupid];
    }

    public function get_default_group()
    {
        $this->get_group_list();
        foreach ($this->grouplist[$this->lang] as $key => $val) {
            return $val;
        }
    }
}

// This program is an open source system, commercial use, please consciously to purchase commercial license.
// Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
