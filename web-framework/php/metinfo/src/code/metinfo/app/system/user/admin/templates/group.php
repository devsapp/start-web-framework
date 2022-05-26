<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-user-group">
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
	id="group-table"
	data-ajaxurl="{$url.own_name}c=admin_group&a=doGetUserGroup"
	data-table-pagelength="1000"
  data-plugin="checkAll"
  data-datatable_order="#group-table"
>
	<thead>
		<tr>
        <th width="50" data-table-columnclass="text-center">
            <div class="custom-control custom-checkbox">
              <input class="checkall-all custom-control-input" type="checkbox" />
              <label class="custom-control-label"></label>
            </div>
        </th>
			<th width="150">{$word.memberarayname}</th>
			<th width="300" data-table-columnclass="text-center">{$word.usegroupauto1}</th>
			<th width="300" data-table-columnclass="text-center">{$word.usegroupbuy}</th>
      <th width="300">
          <abbr title="{$word.user_tips21_v6}">{$word.reading_authority}</abbr>
      </th>
      <th width="300">
          {$word.operate}
      </th>
		</tr>
	</thead>
	<tbody></tbody>
	<tfoot>
      <tr class="tr-add">
      <th width="50" data-table-columnclass="text-center">
          <div class="custom-control custom-checkbox">
            <input class="checkall-all custom-control-input" type="checkbox" />
            <label class="custom-control-label"></label>
          </div>
      </th>
			<th colspan="5" data-no_column_defs class="btn_group">
          <button
          type="button"
          class="btn btn-primary btn-save"

        >

          {$word.save}
        </button>
          <button
          type="button"
          class="btn btn-delete-all ml-2"
        >
          {$word.delete}
        </button>
        <textarea table-addlist-data hidden>
              <tr class="class-add">
                <td class="text-center">
                  <div class="custom-control custom-checkbox">
                    <input class="checkall-item custom-control-input" type="checkbox" name="id" checked="checked" value="0">
                    <label class="custom-control-label"></label>
                  </div>
                </td>
                <td class="td-column-name">
                    <input type="text" name="name"  class="form-control">
                </td>
                <td class="text-center recharge-add">
                    {$word.useinfopay}
                </td>
                <td class="text-center buy-add">
                    {$word.useinfopay}
                </td>
                <td class="text-center">
                    <input type="text" name="access"  class="form-control text-center">
                </td>
                <td>
                </td>
              </tr>
            </textarea
      >
			</th>
		</tr>
	</tfoot>
</table>
</div>