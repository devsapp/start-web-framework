<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('base/base_database');

/**
 * 系统标签类
 */

class online_database extends base_database
{

    public function __construct()
    {
        global $_M;
        $this->construct($_M['table']['online']);
    }

    public function table_para()
    {
        return 'id|no_order|name|value|icon|type|lang';
    }

    public function getList()
    {
        global $_M;
        $order = " ORDER BY no_order ";
        $query = "SELECT * FROM {$this->table} WHERE  {$this->langsql} {$order}";
        return DB::get_all($query);
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
