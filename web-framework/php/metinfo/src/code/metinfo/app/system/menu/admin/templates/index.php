<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
if($data['handle']){
	$data=array_merge($data,$data['handle']);
	unset($data['handle']);
}
$table_order='bottommenu-list';
$colspan=8;
?>
<div class='alert alert-primary'>{$word.admin_menu1}</div>
<div class="metadmin-content-min bg-white p-4">
<form method="POST" action="{$url.own_name}c=menu_admin&a=doSaveMenu" data-submit-ajax='1'>
	<table class="table table-hover dataTable w-100 {$table_order}" id="{$table_order}" data-ajaxurl="{$url.own_name}c=menu_admin&a=doGetList" data-table-pageLength="1000" data-plugin="checkAll" data-datatable_order="#{$table_order}">
		<thead>
			<tr>
				<include file="pub/content_list/checkall_all"/>
				<th width="150">{$word.button_text}</th>
				<th>{$word.parameter10}</th>
				<th width="150" data-table-columnclass="text-center">{$word.onlineimg}</th>
				<th width="100" data-table-columnclass="text-center" class="text-wrap">{$word.button_color}</th>
				<th width="100" data-table-columnclass="text-center" class="text-wrap">{$word.text_color}</th>
				<th width="50" data-table-columnclass="text-center">{$word.skinusenow}</th>
				<th>{$word.operate}</th>
			</tr>
		</thead>
		<tbody data-plugin="dragsort" data-dragsort_order=".{$table_order}">
			<include file="pub/content_list/table_loader"/>
		</tbody>
		<?php
		$colspan--;
		$table_newid=1;
		?>
		<include file="pub/content_list/tfoot_common"/>
					<include file="pub/content_list/btn_table_add"/>
					<textarea table-addlist-data hidden>
						<tr>
							<td class="text-center">
								<div class="custom-control custom-checkbox">
									<input class="checkall-item custom-control-input" type="checkbox" name="id">
									<label class="custom-control-label"></label>
								</div>
								<input type="hidden" name="no_order">
							</td>
							<td>
								<div class="form-group">
									<input type="text" name="name" required class="form-control">
								</div>
							</td>
							<td>
								<input type="text" name="url" class="form-control">
							</td>
							<td class="text-center">
								<input type="hidden" name="icon" data-plugin="iconset" data-btn_size="sm" data-icon_class="mb-1 mr-0" class="form-control">
							</td>
							<td class="text-center">
								<input type="text" name="but_color" data-plugin='minicolors' class="form-control">
							</td>
							<td class="text-center">
								<input type="text" name="text_color" data-plugin='minicolors' class="form-control">
							</td>
							<td class="text-center">
								<select name="enabled" class="form-control">
									<option value="1">{$word.yes}</option>
									<option value="0">{$word.no}</option>
								</select>
							</td>
							<td></td>
						</tr>
					</textarea>
				</th>
			</tr>
		</tfoot>
	</table>
</form>
</div>