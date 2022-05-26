<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * 反馈标签类
 */

class language_op
{

    public $lang;//语言

    /**
     * 初始化
     */
    public function __construct()
    {
        global $_M;
        $this->lang = $_M['lang'];
    }

    /**
     * 获取语言导航
     * @return array 返回语言导航数组
     */
    public function get_lang()
    {
        global $_M;
        foreach ($_M['langlist']['web'] as $key => $val) {
            $return[] = array(
                'name' => $val['name'],
                'met_weburl' => $val['met_weburl'] . 'index.php?lang=' . $val['mark'],
                'mark' => $val['mark'],
            );
        }
        return $return;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
