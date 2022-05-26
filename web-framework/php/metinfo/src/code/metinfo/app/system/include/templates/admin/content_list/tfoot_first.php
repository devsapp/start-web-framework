<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$submit_text=$submit_text?$submit_text:$word['Submit'];
?>
<tfoot>
	<tr class="text-wrap">
		<include file="pub/content_list/checkall_all"/>
		<th colspan="{$colspan}" data-no_column_defs>
			<if value="!$foot_save_no"><button type="submit" class='btn btn-success'<if value="$foot_submit_type">data-submit_type="{$foot_submit_type}"</if>>{$submit_text}</button></if>
