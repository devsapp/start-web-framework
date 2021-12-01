<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('database');

/**
 * 搜索标签类
 */

class search_database extends database
{


    /**
     * 对banner/config数组进行处理
     * @param  string $id 语言
     * @return array        配置数组
     */
    public function get_search_list($lang, $title, $contents, $paras, $moudel, $class1, $class2, $class3, $start = 0, $rows = '')
    {
        $sql = '';
        $sql .= " lang='{$lang}' ";
        $sql .= "AND title   ='{$title}' ";
        $sql .= "AND contents='{$contents}' ";
        $sql .= "AND paras   ='{$paras}' ";
        $sql .= "AND moudel  ='{$moudel}' ";
        $sql .= "AND class1  ='{$class1}' ";
        $sql .= "AND class2  ='{$class2}' ";
        $sql .= "AND class3  ='{$class3}' ";
        $query = "";
        return DB::get_all($query);
    }

    public function get_search_list_by_module_listid($module, $listid)
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['search']} WHERE module='{$module}' AND listid='{$listid}'";
        return DB::get_one($query);
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
