<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('base/base_database');

/**
 * 菜单数据类
 */

class menu_database extends base_database
{

    public function __construct()
    {
        global $_M;
        $this->construct($_M['table']['menu']);
    }

    public function table_para()
    {
        return 'id|name|alt|url|icon|info|text_size|text_color|text_hover_color|but_color|but_hover_color|but_size|type|enabled|target|no_order|lang';
    }

    public function get_menu_list($endabled = 1)
    {
        global $_M;
        $where = " lang = '{$_M['lang']}' AND enabled = {$endabled} ";
        $order = " no_order ";
        $query = "SELECT * FROM {$_M['table']['menu']} WHERE {$where} ORDER BY {$order}";
        return DB::get_all($query);
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
