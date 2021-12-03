<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

define('IN_ADMIN', true);

$M_MODULE='admin';
if(@$_GET['m'])$M_MODULE=$_GET['m'];
if(@!$_GET['n'])$_GET['n']="index";
if(@!$_GET['c'])$_GET['c']="index";
if(@!$_GET['a'])$_GET['a']="doindex";
@define('M_NAME', $_GET['n']);
@define('M_MODULE', $M_MODULE);
@define('M_CLASS', $_GET['c']);
@define('M_ACTION', $_GET['a']);
require_once '../app/system/entrance.php';
if ($_GET['n'] == 'index' && $_GET['c'] == 'index' && $_GET['a'] == 'doindex'){
    if (is_mobile()){
        $_GET['n'] = 'mobile';
        $_GET['a'] = 'domobile';
    }
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>