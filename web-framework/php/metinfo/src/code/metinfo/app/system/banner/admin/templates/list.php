<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
if($data['handle']){
	$data=array_merge($data,$data['handle']);
	unset($data['handle']);
}
$data['module']='banner';
$table_order='banner-list';
$pagelength=1000;
?>
<div class='alert alert-primary'>{$word.admin_content_list1}</div>
<div class="metadmin-content-min bg-white p-4">
<div class="clearfix">
	<div class="float-left">
		<button type="button" class="btn btn-primary btn-banner-list-add" data-toggle="modal" data-target=".banner-add-modal" data-modal-title="{$word.indexflashaddflash}" data-modal-size="xl" data-modal-url="banner/edit/?c=banner_admin&a=doadd" data-modal-fullheight="1" data-modal-tablerefresh="#{$table_order}">{$word.indexflashaddflash}</button>
	</div>
	<div class="float-right">
		<select name="module" data-table-search="#{$table_order}" class="form-control">
			<option value="">{$word.allcategory}</option>
			<option value="10001">{$word.flashHome}</option>
			<list data="$data['columnlist']" name="$v">
			<option value="{$v.id}">{$v.name}</option>
			<if value="$v['subcolumn']">
			<list data="$v['subcolumn']" name="$a">
			<option value="{$a.id}">--{$a.name}</option>
			<if value="$a['subcolumn']">
			<list data="$a['subcolumn']" name="$b">
			<option value="{$b.id}">----{$b.name}</option>
			</list>
			</if>
			</list>
			</if>
			</list>
		</select>
	</div>
</div>
<include file="pub/content_list/form_head"/>
				<include file="pub/content_list/checkall_all"/>
				<th width="150">{$word.category}</th>
				<th data-table-columnclass="text-center">{$word.setflashName}</th>
				<th data-table-columnclass="text-center" width="80">{$word.banner_pcheight_v6}</th>
				<th data-table-columnclass="text-center" width="80">{$word.banner_pidheight_v6}</th>
				<th data-table-columnclass="text-center" width="80">{$word.banner_phoneheight_v6}</th>
				<th width="250">{$word.operate}</th>
			</tr>
		</thead>
		<tbody data-plugin="dragsort" data-dragsort_order="#{$table_order}">
			<?php $colspan=7; ?>
			<include file="pub/content_list/table_loader"/>
		</tbody>
		<?php $colspan--; ?>
		<include file="pub/content_list/tfoot_common"/>
				</th>
			</tr>
		</tfoot>
	</table>
</form>
</div>