<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$head_tab_active=isset($data['head_tab_active'])?$data['head_tab_active']:0;
$head_tab=array(
	array('title'=>$word['website_information'],'url'=>'webset/webset/?nocommon=1'),
	array('title'=>$word['email_Settings'],'url'=>'webset/email'),
	array('title'=>$word['third_party_code'],'url'=>'webset/thirdparty')
);
$head_tab_ajax = 1;
?>
<include file="pub/head_tab"/>