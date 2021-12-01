<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<dl>
	<dt>
		<label class='form-control-label'>{$iconset.title}</label>
	</dt>
	<dd>
		<div class='form-group clearfix'>
			<input type="hidden" name="{$iconset.name}" value="{$iconset.value}" data-plugin="iconset" class="form-control">
		</div>
	</dd>
</dl>
<?php unset($iconset); ?>