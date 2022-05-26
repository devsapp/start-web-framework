<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-lang-admin">
<button
type="button"
class="btn btn-primary btn-add"
data-toggle="modal"
data-target=".lang-adminAdd-modal"
data-modal-url="language/admin_add"
data-modal-size="lg"
data-modal-title="{$word.langadd}"
data-modal-tablerefresh="#lang-admin-table"
data-modal-loading="1"
>
{$word.langadd}
</button>
<table
	class="dataTable table table-hover w-100 mt-2"
	id="lang-admin-table"
	data-ajaxurl="{$url.own_name}c=language_admin&a=doGetAdminLanguage"
	data-table-pagelength="1000"
	data-plugin="checkAll"
	data-datatable_order="#lang-admin-table"
>
	<thead>
		<tr>
			<th width="100" data-table-columnclass="text-center">{$word.sort}</th>
			<th width="150" data-table-columnclass="text-center">{$word.langname}</th>
			<th width="100" data-table-columnclass="text-center">{$word.open}</th>
			<th width="100" data-table-columnclass="text-center">{$word.langhome}</th>
			<th width="600" data-table-columnclass="text-center">{$word.sys_lang_operate}</th>
			<th width="150" data-table-columnclass="text-center">{$word.langpara}</th>
		</tr>
	</thead>
	<tbody></tbody>
</table>
</div>
