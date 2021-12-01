<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
if($data['handle']){
	$data=array_merge($data,$data['handle']);
	unset($data['handle']);
}
$table_order='banner-button-list';
$colspan=12;
?>
<p class="text-danger">{$word.admin_content_list1}</p>
<form method="POST" action="{$url.own_name}c=banner_admin&a=doFlashButtonSave&flash_id={$data.id}" data-submit-ajax='1'>
	<table class="table table-hover dataTable w-100 {$table_order}" id="{$table_order}" data-ajaxurl="{$url.own_name}c=banner_admin&a=doGetFlashButton&flash_id={$data.id}" data-table-pageLength="1000" data-plugin="checkAll" data-datatable_order="#{$table_order}">
		<thead>
			<tr>
				<include file="pub/content_list/checkall_all"/>
				<th>{$word.button_text}</th>
				<th width="150">{$word.parameter10}</th>
				<th data-table-columnclass="text-center">{$word.open_mode}</th>
				<th data-table-columnclass="text-center">{$word.button_size}<br>（{$word.setimgWidth}x{$word.setimgHeight}）（{$word.setimgPixel}）</th>
				<th data-table-columnclass="text-center">{$word.button_color}</th>
				<th data-table-columnclass="text-center">{$word.mouse_over_button_color}
                </th>
				<th data-table-columnclass="text-center" width="100">{$word.font_size}<br>（{$word.setimgPixel}）</th>
				<th data-table-columnclass="text-center">{$word.text_color}</th>
				<th data-table-columnclass="text-center">{$word.mouse_over_text_color}</th>
				<th data-table-columnclass="text-center">{$word.display_client}</th>
				<th>{$word.operate}</th>
			</tr>
		</thead>
		<tbody data-plugin="dragsort" data-dragsort_order="#{$table_order}">
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
									<input type="text" name="but_text" required class="form-control">
								</div>
							</td>
							<td>
								<input type="text" name="but_url" class="form-control">
							</td>
							<td>
								<select name="target" class="form-control">
									<option value="0">{$word.original_window}</option>
									<option value="1">{$word.new_window}</option>
								</select>
							</td>
							<td class="text-center">
								<div class="text-nowrap">
									<input type="text" value="" placeholder="{$word.default_values}" name="but_size_x" style="width:70px" class="d-inline-block text-center banner-size form-control"><span class="mx-1">x</span><input type="text" value="" placeholder="{$word.default_values}" name="but_size_y" style="width:70px" class="d-inline-block text-center banner-size form-control">
									<input type="hidden" value="" name="but_size">
								</div>
							</td>
							<td class="text-center">
								<input type="text" name="but_color" data-plugin='minicolors' class="form-control">
							</td>
							<td class="text-center">
								<input type="text" name="but_hover_color" data-plugin='minicolors' class="form-control">
							</td>
							<td class="td-btntext-size text-center">
								<input type="text" name="but_text_size" data-plugin="select-fontsize" class="form-control">
							</td>
							<td class="text-center">
								<input type="text" name="but_text_color" data-plugin='minicolors' class="form-control">
							</td>
							<td class="text-center">
								<input type="text" name="but_text_hover_color" data-plugin='minicolors' class="form-control">
							</td>
							<td>
								<select name="is_mobile" class="form-control">
									<option value="0">{$word.funNav4}</option>
									<option value="1">{$word.PC}</option>
									<option value="2">{$word.mobile_terminal}</option>
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