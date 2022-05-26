<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$checkbox_time=time();
?>
<dl>
	<dt>
		<label class='form-control-label'>{$word.smstips64}{$displaytype.marks}</label>
	</dt>
	<dd>
		<div class='form-group clearfix'>
			<div class="custom-control custom-checkbox custom-control-inline">
				<input type="checkbox" id="displaytype1-{$checkbox_time}" name='displaytype' value='1' data-checked='{$data.list.displaytype}' class="custom-control-input"/>
				<label class="custom-control-label" for="displaytype1-{$checkbox_time}">{$word.displaytype}</label>
			</div>
			<if value="$data['n'] neq 'job'">
			<div class="custom-control custom-checkbox custom-control-inline">
				<input type="checkbox" id="com_ok1-{$checkbox_time}" name='com_ok' value='1' data-checked='{$data.list.com_ok}' class="custom-control-input"/>
				<label class="custom-control-label" for="com_ok1-{$checkbox_time}">{$word.recom}</label>
			</div>
			</if>
			<div class="custom-control custom-checkbox custom-control-inline">
				<input type="checkbox" id="top_ok1-{$checkbox_time}" name='top_ok' value='1' data-checked='{$data.list.top_ok}' class="custom-control-input"/>
				<label class="custom-control-label" for="top_ok1-{$checkbox_time}">{$word.top}</label>
			</div>
		</div>
	</dd>
</dl>
<?php unset($displaytype); ?>