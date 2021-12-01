<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
if($data['handle']){
	$data=array_merge($data,$data['handle']);
	unset($data['handle']);
}
?>
<div class="clearfix">
	<a href="{$url.site_admin}#/column" target="_blank" class="btn btn-primary">{$word.configuration_section}</a>
	<font class="text-grey ml-2">{$word.js76}</font>
</div>
<table class="table table-hover w-100 mt-2" id="about-list">
	<thead>
		<tr>
			<th>{$word.title}</th>
			<th>{$word.operate}</th>
		</tr>
	</thead>
	<tbody>
		<if value="count($data['list'])">
		<list data="$data['list']" name="$a">
		<tr>
			<td>{$a.name}</td>
			<td><button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".about-details-modal" data-modal-title="{$word.editor}" data-modal-size="xl" data-modal-url="about/edit/?c=about_admin&a=doeditor&id={$a.id}" data-modal-fullheight="1">{$word.editor}</button></td>
		</tr>
		</list>
		<else/>
		<tr><td colspan="2" class="text-center">{$word.csvnodata}</td></tr>
		</if>
	</tbody>
</table>