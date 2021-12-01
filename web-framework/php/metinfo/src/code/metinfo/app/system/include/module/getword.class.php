<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

load::sys_class('admin');
load::sys_func('array');

class getword extends admin
{
    function __construct()
    {
        parent::__construct();
    }

    public function dogetword()
    {
        global $_M;
        $lang = $_M['form']['lang'] ? $_M['form']['lang'] : $_M['lang'];
        $word = $_M['form']['word'];
        $site = $_M['form']['site'];
        if (!file_get_contents(PATH_WEB . 'cache/lang_' . $lang . '.php')) {
            $query = "select * from {$_M['table'][language]} where lang='{$lang}' and site='{$site}' and name='{$word}'";
            $result = DB::get_one($query);
            $getword = $result['value'];
        } else {
            if ($site == 1) {
                require_once PATH_WEB . 'cache/langadmin_' . $lang . '.php';
            } else {
                require_once PATH_WEB . 'cache/lang_' . $lang . '.php';
            }
            $word = "lang_{$word}";
            $getword = $$word;
        }
        if ($getword) {
            $back['error'] = 0;
            $back['word'] = $getword;
        } else {
            $back['error'] = 1;
        }
        jsoncallback($back);
    }
}


# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>