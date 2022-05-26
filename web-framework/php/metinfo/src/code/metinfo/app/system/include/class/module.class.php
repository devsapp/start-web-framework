<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * 系统模块类
 */

class module
{
    public function get_module($module, $input)
    {
        //load::mod_class($module.'/include/class/'.$module.'_module.class.php', 'new')->get_module($input);
        $mod['file'][] = PATH_WEB . 'app/system/include/compatible/metv5_top.php';
        $mod['input'] = $input;
        return $mod;

    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
