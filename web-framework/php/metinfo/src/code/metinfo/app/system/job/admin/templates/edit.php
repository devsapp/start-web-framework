<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
if($data['handle']){
	$data=array_merge($data,$data['handle']);
	unset($data['handle']);
}
?>
<div class="metadmin-fmbx">
	<list data="$data['list']['plist']" name="$v">
	<dl>
		<dt>
			<label class='form-control-label'>{$v.name}{$word.marks}</label>
		</dt>
		<dd>
			<div class="text-help text-dark">
			<if value="$v['type'] eq 5">
			<a href="{$v.val}" target="_blank">{$v.val}</a>
			<else/>
			{$v.val}
			</if>
			</div>
		</dd>
	</dl>
	</list>
	<dl>
		<dt>
			<label class='form-control-label'>{$word.cvAddtime}{$word.marks}</label>
		</dt>
		<dd>
			<div class="text-help text-dark">{$data.list.addtime}</div>
		</dd>
	</dl>
</div>