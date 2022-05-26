<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('base/base_op');

class job_op extends base_op
{
    public function __construct()
    {
        global $_M;
        $this->database = load::mod_class('job/job_database', 'new');
    }

    /**
     * 复制栏目列表内容至新语言
     * @param string $classnow
     * @param string $toclass1
     * @param string $toclass2
     * @param string $toclass3
     * @param string $tolang
     * @param array $paras
     * @return mixed
     */
    public function list_copy($classnow = '', $toclass1 = '', $toclass2 = '', $toclass3 = '', $tolang = '', $paras = array())
    {
        global $_M;
        $contents = $this->database->get_list_by_class_no_next($classnow);

        foreach ($contents as $list) {
            $id = $list['id'];
            $list['id'] = '';
            $list['filename'] = '';
            $list['lang'] = $tolang ? $tolang : $list['lang'];
            $list['class1'] = $toclass1 ? $toclass1 : $list['lang'];
            $list['class2'] = $toclass2 ? $toclass2 : $list['lang'];
            $list['class3'] = $toclass3 ? $toclass3 : $list['lang'];

            $id_array[$id] = $this->database->insert($list);
        }
        return $id_array;
    }

    /**
     * 移动栏目列表内容
     * @param $id
     * @param $class1
     * @param $class2
     * @param $class3
     * @return bool
     */
    public function list_move($nowclass1 = '', $nowclass2 = '', $nowclass3 = '', $toclass1 ='', $toclass2 ='', $toclass3 = '')
    {
        return true;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
