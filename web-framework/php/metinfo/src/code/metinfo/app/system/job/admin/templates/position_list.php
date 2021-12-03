<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
if($data['handle']){
	$data=array_merge($data,$data['handle']);
	unset($data['handle']);
}
$head_column_none=1;
$btn_add_file='position_edit';
$table_order='job-position-list-'.$data['class1'].'-'.$data['class2'].'-'.$data['class3'];
?>
<include file="pub/content_list/head"/>
				<include file="pub/content_list/checkall_all"/>
				<th>{$word.jobposition}</th>
				<th data-table-columnclass="text-center" width="50">{$word.jobnum}</th>
				<th data-table-columnclass="text-center" width="90">
					<select name="search_type" data-table-search class="form-control w-a d-inline-block">
						<option value="0">{$word.state}</option>
						<option value="1">{$word.fronthidden}</option>
						<option value='2'>{$word.top}</option>
					</select>
				</th>
				<th data-table-columnclass="text-center" width="80">{$word.joblife}</th>
				<th data-table-columnclass="text-center" width="100">{$word.updated_date}</th>
				<th data-table-columnclass="text-center" width="50">{$word.webaccess}</th>
				<include file="pub/content_list/thead_sort"/>
				<th width="180">{$word.operate}</th>
			</tr>
		</thead>
		<tbody>
			<?php $colspan=9; ?>
			<include file="pub/content_list/table_loader"/>
		</tbody>
		<input type="hidden" name="class1" value="{$data.class1}" data-table-search="#{$table_order}">
		<input type="hidden" name="class2" value="{$data.class2}" data-table-search="#{$table_order}">
		<input type="hidden" name="class3" value="{$data.class3}" data-table-search="#{$table_order}">
		<?php $colspan--; ?>
		<include file="pub/content_list/foot"/>