<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

class menu_op
{
    public function __construct()
    {
        global $_M;
        $this->database = load::mod_class('menu/menu', 'new');
    }

    //获取菜单信息列表
    public function getMenuList($type = '')
    {
        global $_M;
        $list = $this->database->get_menu_list($type);
        return $list;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
