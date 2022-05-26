<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-anchor-list">
  <div class="alert dark alert-primary radius0">{$word.applies_paper}</div>
  <div class="metadmin-content-min bg-white p-4">
  <button type="button" class="btn btn-primary btn-add" >
    {$word.anchor_textadd}
  </button>
    <table class="dataTable table table-hover w-100 mt-2"
    id="anchor-table" data-ajaxurl="{$url.own_name}c=anchor&a=doGetAnchor"
    data-table-pagelength="20" data-plugin="checkAll"
    data-datatable_order="#anchor-table">
      <thead>
        <tr>
          <th width="50" data-table-columnclass="text-center">
            <div class="custom-control custom-checkbox">
              <input class="checkall-all custom-control-input" type="checkbox" />
              <label class="custom-control-label"></label>
            </div>
          </th>
          <th width="200" data-table-columnclass="text-center">{$word.labelOld}</th>
          <th width="200" data-table-columnclass="text-center">{$word.labelNew}</th>
          <th width="200" data-table-columnclass="text-center">Title</th>
          <th width="200" data-table-columnclass="text-center">{$word.labelUrl}</th>
          <th width="100" data-table-columnclass="text-center">{$word.labelnum}</th>
          <th width="200">{$word.operate}</th>
        </tr>
      </thead>
      <tbody></tbody>
      <tfoot>
        <tr class="tr-add">
          <textarea table-addlist-data hidden>
							<tr class="class-add">
								<td class="text-center">
									<div class="custom-control custom-checkbox">
										<input class="checkall-item custom-control-input" type="checkbox" checked="checked" name="id">
										<label class="custom-control-label"></label>
									</div>
								</td>
								<td class="text-center">
										<input type="text" name="oldwords"   class="form-control" required>
								</td>
								<td class="text-center">
										<input type="text" name="newwords"   class="form-control">
								</td>
								<td class="text-center">
										<input type="text" name="newtitle"  class="form-control">
								</td>
								<td class="text-center">
										<input type="text" name="url" value=""  class="form-control">
								</td>
								<td class="text-center">
										<input type="text" name="num" value="999"  class="form-control text-center">
								</td>
								<td >

								</td>

							</tr>
						</textarea
          >
          <th>
            <div class="custom-control custom-checkbox">
              <input class="checkall-all custom-control-input" type="checkbox" />
              <label class="custom-control-label"></label>
            </div>
          </th>
          <th colspan="6" data-no_column_defs class="btn_group">
            <button type="submit" class="btn btn-primary mr-2 btn-save">
              {$word.Submit}
            </button>
            <button type="button" class="btn btn-delete-all">
              {$word.delete}
            </button>
          </th>
        </tr>
      </tfoot>
    </table>
    </div>
</div>
