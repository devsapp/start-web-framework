<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');
load::sys_func('file');
/**
 * 栏目标签类
 */

class config_label
{

    /**
     * 初始化
     */
    public function __construct()
    {
        global $_M;
        $this->lang = $_M['lang'];
        $this->database = load::mod_class('config/config_database', 'new');
    }

    //
    public function get_column_config($classnow)
    {
        $config = $this->database->get_value_by_columnid($classnow);
        $list = array();
        foreach ($config as $key => $val) {
            $list[$val['name']] = $val['value'];
        }
        return $list;
    }

}
# This program is an open source system, commercial use, please consciously to purchase commercial license.; # Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>

