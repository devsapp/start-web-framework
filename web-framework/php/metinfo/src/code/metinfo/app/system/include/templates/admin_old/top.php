<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
$navhtml = nav::get_select_navhtml();
echo <<<EOT
-->
<div class="metappcontentbox">
	<div class="metinfotop">
		{$navhtml}
	</div>
	<div class="clear"></div>
<!--
EOT;
$navlist = nav::get_nav();
if($navlist){
echo <<<EOT
-->
	<div class="stat_list">
<!--
EOT;
	foreach($navlist as $key => $val){
echo <<<EOT
-->
		<a {$val['classnow']} title="{$val['title']}" href="{$val['url']}" target="{$val['target']}">{$val['title']}</a>
<!--
EOT;
	}
echo <<<EOT
-->
	</div>
	<div class="clear"></div>
<!--
EOT;
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>