<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<if value="$c['shopv2_open']">
<iframe src="{$url.adminurl}n=product&c=product_admin&a=doindex&module=3&class1={$data.class1}&class2={$data.class2}&class3={$data.class3}&pageset=1&head_no=1" width="100%" style="height:calc(100vh - 182px);" frameborder="0">
<else/>
<include file="pub/content_list/head"/>
		<include file="pub/content_list/checkall_all"/>
		<th>{$word.goods}</th>
		<include file="pub/content_list/thead_common"/>
	</tr>
</thead>
<tbody>
	<?php $colspan=7; ?>
	<include file="pub/content_list/table_loader"/>
</tbody>
<?php $colspan=6;$del_type=1; ?>
<include file="pub/content_list/foot"/>
</if>