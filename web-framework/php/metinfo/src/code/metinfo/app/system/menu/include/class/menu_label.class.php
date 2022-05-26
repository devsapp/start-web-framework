<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * 友情链接标签类
 */

class menu_label
{

    public $lang;
    public $handle;
    public $database;

    /**
     * 初始化
     */
    public function __construct()
    {
        global $_M;
        $this->lang = $_M['lang'];
        $this->handle = load::mod_class('menu/menu_handle', 'new');
        $this->database = load::mod_class('menu/menu_database', 'new');
    }

    /**
     * 菜单列表
     * @param string $type
     * @return mixed
     */
    public function get_list($type = '')
    {
        global $_M;
        return $this->handle->para_handle(
            $this->database->get_menu_list($type, 1)
        );
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
