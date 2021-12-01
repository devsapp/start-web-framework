<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$data['page_title']=$_M['word']['activesuc'].$data['page_title'];
?>
<include file="sys_web/head"/>
<include file="app/style"/>
<div class="valid-email met-member">
	<div class="container">
		<div class="valid-email-content">
			<p class="text-center">{$_M['word']['emailchecktips1']}</p>
			<p class="text-center"><strong>{$_M['user']['username']}</strong></p>
			<p class="text-center">{$_M['word']['emailchecktips2']}</p>
		</div>
		<ol class="breadcrumb">
			<li class="active"><strong>{$_M['word']['emailchecktips3']}</strong></li>
			<li class="active">{$_M['word']['emailchecktips4']}</li>
			<li><a href="{$_M['url']['valid_email_repeat']}" class="send-email">{$_M['word']['emailchecktips5']}</a></li>
		</ol>
	</div>
</div>
<include file="sys_web/foot"/>