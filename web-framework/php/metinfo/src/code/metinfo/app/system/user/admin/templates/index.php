<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$head_tab_active=isset($data['head_tab_active'])?$data['head_tab_active']:0;
$head_tab_ajax=1;
$head_tab=array(
array('title'=>$word['memberist'],'url'=>'user/list'),
array('title'=>$word['membergroup'],'url'=>'user/group'),
array('title'=>$word['memberattribute'],'url'=>'user/attr'),
array('title'=>$word['memberfunc'],'url'=>'user/func/?nocommon=1'),
array('title'=>$word['thirdlogin'],'url'=>'user/login'),
array('title'=>$word['mailcontentsetting'],'url'=>'user/email/?nocommon=1'),
);
?>
<div class="met-user">
	<include file="pub/head_tab"/>
</div>