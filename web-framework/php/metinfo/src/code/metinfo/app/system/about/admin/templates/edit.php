<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$data=array_merge($data,$data['handle']);
unset($data['handle']);
?>
<form method="POST" action="{$url.own_name}c=about_admin&a=doeditorsave" data-submit-ajax='1' enctype="multipart/form-data">
	<input type="hidden" name='id' value="{$data.list.id}" />
	<input type="hidden" name="addtime_l" value="{$data.list.addtime}">
	<input type="hidden" name="no_order" value="{$data.list.no_order}">
	<div class="metadmin-fmbx">
		<include file="pub/content_details/editor"/>
		<include file="pub/content_details/seo"/>
		<if value="$data['class1']">
		<include file="pub/content_details/submit"/>
		</if>
	</div>
</form>