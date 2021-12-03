<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

$M_MODULE='web';
if(@$_GET['m'])$M_MODULE=$_GET['m'];
if(@!$_GET['n'])$_GET['n']="user";
if(@!$_GET['c'])$_GET['c']="profile";
if(@!$_GET['a'])$_GET['a']="doindex";
@define('M_NAME', $_GET['n']);
@define('M_MODULE', $M_MODULE);
@define('M_CLASS', $_GET['c']);
@define('M_ACTION', $_GET['a']);
require_once '../app/system/entrance.php';
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>