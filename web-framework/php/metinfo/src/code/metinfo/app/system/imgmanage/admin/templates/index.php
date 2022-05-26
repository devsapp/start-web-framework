<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$head_tab_active=isset($data['head_tab_active'])?$data['head_tab_active']:0;
$head_tab_ajax=1;
$head_tab=array(
	array('title'=>$word['upfiletips19'],'url'=>'imgmanage/watermark/?nocommon=1'),
	array('title'=>$word['modimgurls'],'url'=>'imgmanage/thumbs'),
);
$checkbox_time=time();
?>
<div class="met-web-set">
	<include file="pub/head_tab"/>
</div>