<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$colspan=8;
?>
<div class="met-user-attr">
	<div class="alert alert-primary">{$word.admin_content_list1}</div>
	<div class="metadmin-content-min bg-white p-4">
		<div>
			<button
			type="button"
			class="btn btn-primary btn-add"
		>
			{$word.added}
		</button>
		</div>
		<table
			class="dataTable table table-hover w-100 mt-2"
			id="user-attr-table"
			data-ajaxurl="{$url.own_name}c=parameter&a=doGetParaList"
			data-table-pagelength="1000"
			data-plugin="checkAll"
			data-datatable_order="#user-attr-table"
		>
			<thead>
				<tr>
					<include file="pub/content_list/checkall_all"/>
					<th>{$word.paraname}</th>
					<th data-table-columnclass="text-center">{$word.parametertype}</th>
		<!-- 			<th width="100" data-table-columnclass="text-center">{$word.category}</th> -->
					<th data-table-columnclass="text-center">{$word.webaccess}</th>
					<th data-table-columnclass="text-center">{$word.edit_authority}</th>
					<th data-table-columnclass="text-center">{$word.user_must_v6}</th>
					<th width="100">{$word.operate}</th>
				</tr>
			</thead>
			<tbody data-plugin="dragsort" data-dragsort_order="#user-attr-table">
				<include file="pub/content_list/table_loader"/>
			</tbody>
			<tfoot>
				<tr>
					<th class="text-center">
						<div class="custom-control custom-checkbox">
							<input class="checkall-all custom-control-input" type="checkbox" />
							<label class="custom-control-label"></label>
						</div>
					</th>
					<th colspan="6" data-no_column_defs class="btn_group">
						<button
						type="button"
						class="btn btn-primary btn-save"
						>{$word.save}</button>
						<button
						type="button"
						class="btn btn-default ml-2 btn-delete-all"
						>{$word.delete}</button>
					</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>