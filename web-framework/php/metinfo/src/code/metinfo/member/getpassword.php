<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

//接口
if(@!$_GET['a'])$_GET['a']="doindex";
@define('M_NAME', 'user');
@define('M_MODULE', 'web');
@define('M_CLASS', 'getpassword');
@define('M_ACTION', $_GET['a']);
require_once '../app/system/entrance.php';
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>