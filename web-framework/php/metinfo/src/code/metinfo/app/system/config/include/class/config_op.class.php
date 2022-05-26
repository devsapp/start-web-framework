<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');
load::sys_func('file');
/**
 * 栏目标签类
 */

class config_op
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
    public function copy_column_config($classnow, $toclass, $tolang)
    {
        $config = $this->database->get_value_by_columnid($classnow);
        foreach ($config as $key => $val) {
            $list = $val;
            $list['id'] = '';
            $list['lang'] = $tolang;
            $list['columnid'] = $toclass;
            $this->database->insert($list);
        }
        return true;
    }

    /**
     * 获取单个栏目篇配置
     * @param string $name
     * @param string $class
     * @param string $lang
     * @return mixed
     */
    public function getColumnConf($class = '', $name = '')
    {
        global $_M;
        $data = $this->database->get_value_by_classid($class, $name);
        return $data;
    }

    /**
     * 获取栏目篇配置
     * @param string $class
     * @param string $lang
     */
    public function getColumnConfArry($class = '')
    {
        global $_M;
        $config = $this->database->get_value_by_columnid($class);
        $list = array();
        foreach ($config as $key => $val) {
            $list[$val['name']] = $val['value'];
        }
     

        return $list;
    }

    /**
     * @param string $name
     * @param string $class
     * @param string $lang
     */
    public function saveColumnConf($class = '', $name = '', $value = '')
    {
        global $_M;
        $data = $this->database->update_by_classid($class, $name, $value);
        return $data;
    }

}
# This program is an open source system, commercial use, please consciously to purchase commercial license.;
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>

