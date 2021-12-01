<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

function template($template)
{
    global $_M, $metinfover;
    if ($metinfover) {
        $uifile = $metinfover;//修改赋值（新模板框架v2）
        $uisuffix = 'php';
    } else {
        $uifile = "met";
        $uisuffix = 'html';
    }
    $path = PATH_WEB . "templates/{$_M['config']['met_skin_user']}/{$template}.{$uisuffix}";
    if (!file_exists($path) && $metinfover == 'v2') {
        if (M_NAME == 'product') {
            $path = PATH_APP_FILE . "web/templates/{$template}.php";// 商城V3使用默认模板时
        } else {
            $path = PATH_OWN_FILE . "templates/{$template}.php";
            !file_exists($path) && $path = PATH_PUBLIC_ADMINOLD . "{$template}.php";
        }
    }
    !file_exists($path) && $path = PATH_PUBLIC_ADMINOLD."{$uifile}/{$template}.{$uisuffix}";
    return $path;
}

function tmpcentarr($cd)
{
    global $class_list, $module_listall;
    $hngy5 = explode('-', $cd);
    if ($hngy5[1] == 'cm') $metinfo = $class_list[$hngy5[0]];
    if ($hngy5[1] == 'md') $metinfo = $module_listall[$hngy5[0]][0];
    return $metinfo;
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>