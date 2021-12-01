<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$webaccess['title']=$webaccess['title']?$webaccess['title']:$word['webaccess'];
$webaccess['name']=$webaccess['name']?$webaccess['name']:'access';
$webaccess['value']=$webaccess['value']?$webaccess['value']:$data['list']['access'];
$webaccess['access']=$webaccess['access']?$webaccess['access']:$data['access'];
?>
<dl>
	<dt>
		<label class='form-control-label'>{$webaccess.title}{$webaccess.marks}</label>
	</dt>
	<dd class="form-group">
		<select class="form-control w-a" name='{$webaccess.name}' data-checked="{$webaccess.value}">
			<list data="$webaccess['access']" name="$v">
			<option value="{$v.val}"<if value="$v['checked']">selected</if>>{$v.name}</option>
			</list>
		</select>
	</dd>
</dl>
<?php unset($webaccess); ?>