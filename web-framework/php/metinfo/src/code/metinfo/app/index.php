<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

//接口
if(@!$_GET['a'])$_GET['a']="doindex";
if(@!$_GET['c'])$_GET['c']="index";
@define('M_NAME', @$_GET['n']);
@define('M_MODULE', 'web');
@define('M_CLASS', @$_GET['c']);
@define('M_ACTION', $_GET['a']);
require_once './app/entrance.php';

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>