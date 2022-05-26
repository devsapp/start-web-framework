<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * url处理类
 */
class url
{
    /**
     * 为字段赋值
     * @param  string $module模型名称
     * @param  array $input 所有输入变量
     * @return array          合法的页面变量
     */
    public function get_input($module, $input)
    {
        global $_M;

        $output = load::mod_class($module . '/include/class/' . $module . '_url.class.php', 'new')->get_input($input);

        if ($input['lang']) {
            $output['lang'] = $input['lang'];
        } else {
            $output['lang'] = $_M['lang'];
        }

        return $output;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
