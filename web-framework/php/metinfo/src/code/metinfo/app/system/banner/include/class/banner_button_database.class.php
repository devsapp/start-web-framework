<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * 系统标签类
 */

load::mod_class('base/base_database');

class  banner_button_database extends base_database
{
    public $table;

    public function __construct()
    {
        global $_M;
        $this->table = $_M['table']['flash_button'];
    }

    public function getOneButtonByFlashId($flash_id = '')
    {
        global $_M;
        $query = "SELECT * FROM {$this->table} WHERE flash_id = '{$flash_id}' AND lang = '{$_M['lang']}'";
        $data = DB::get_all($query);
        return $data;
    }

    public function table_para()
    {
        return 'id|flash_id|but_text|but_url|but_text_size|but_text_color|but_text_hover_color|but_color|but_hover_color|but_size|is_mobile|no_order|target|lang';
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
