<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$data['page_title']=$_M['word']['js16'].$data['page_title'];
?>
<include file="sys_web/head"/>
<include file="app/style"/>
<div class="valid-email met-member">
	<div class="container">
		<div class="valid-email-content">
			<p class="text-center"><strong>{$_M['user']['username']}</strong></p>
			<p class="text-center">{$_M['word']['membernodo']}</p>
		</div>
	</div>
</div>
<include file="sys_web/foot"/>