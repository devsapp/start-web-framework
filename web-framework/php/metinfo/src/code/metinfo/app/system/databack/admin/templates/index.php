<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$head_tab_active=isset($data['head_tab_active'])?$data['head_tab_active']:0;
$head_tab=array(
	array('title'=>$word['databackup4'],'url'=>'databack/backup'),
	array('title'=>$word['databackup2'],'url'=>'databack/recovery')
);
$head_tab_ajax = 1;
?>
<include file="pub/head_tab"/>