<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$submit_text=$submit_text?$submit_text:$word['Submit'];
?>
<dl>
	<if value="$submit_dt"><dt></dt></if>
	<dd class="{$submit_wrapper_class}">
		<button type="submit" class='btn btn-primary {$submit_class}'>{$submit_text}</button>
	</dd>
</dl>
<?php unset($submit_wrapper_class);unset($submit_class);unset($submit_dt); ?>