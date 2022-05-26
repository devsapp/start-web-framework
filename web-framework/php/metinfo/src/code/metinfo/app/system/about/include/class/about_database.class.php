<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('column/column_database');

/**
 * 简介模块数据库类
 */

class about_database extends column_database
{
    public function __construct()
    {
        global $_M;
        $this->construct($_M['table']['column']);
    }

    /**
     * 获取静态页面名称
     * @param  array $filename 静态页面名称
     * @param  array $lang 语言
     * @return bool                 当前静态页面名称个数
     */
    public function get_list_by_filename($filename)
    {
        $query = "SELECT * FROM {$this->table} WHERE {$this->langsql} AND filename='{$filename}'";
        return DB::get_all($query);
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
