<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<th data-table-columnclass="text-center" width="50" data-order_info="hits|asc,desc">{$word.visitcount}</th>
<th data-table-columnclass="text-center" width="100" data-order_info="updatetime|asc,desc">{$word.updatetime}</th>
<th data-table-columnclass="text-center" width="100">
	<select class="form-control w-a d-inline-block" name='search_type' data-table-search>
		<option value=''>{$word.smstips64}</option>
		<option value='1'>{$word.displaytype2}</option>
		<option value='2'>{$word.recom}</option>
		<option value='3'>{$word.top}</option>
	</select>
</th>
<include file="pub/content_list/thead_sort"/>
<th width="120">{$word.operate}</th>