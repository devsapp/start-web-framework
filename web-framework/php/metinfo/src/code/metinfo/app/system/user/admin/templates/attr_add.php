<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$colspan=3;
$foot_save_no=1;
?>
<form action="javascript:;" class="form-inline">
  <input type="hidden" name="para_id">
  <table class="table table-hover dataTable w-100" id="user-para-options-list" data-plugin="checkAll">
    <thead>
      <tr>
        <include file="pub/content_list/checkall_all"/>
        <th>
          {$word.parametervalueinfo}
        </th>
        <th width="80">
          {$word.operate}
        </th>
      </tr>
    </thead>
    <tbody data-plugin="dragsort" data-dragsort_order="#user-para-options-list">
      <include file="pub/content_list/table_loader"/>
    </tbody>
    <?php $colspan--; ?>
    <include file="pub/content_list/tfoot_first"/>
          <button type="button" class="btn btn-default btn-para-delete-all">
            {$word.delete}
          </button>
          <button type="button" class="btn btn-primary ml-1" table-addlist data-nocancel="1">
            {$word.add}
          </button>
          <textarea table-addlist-data hidden>
              <tr>
                <td class="text-center">
                  <div class="custom-control custom-checkbox">
                    <input class="checkall-item custom-control-input" type="checkbox" name="id">
                    <label class="custom-control-label"></label>
                  </div>
                  <input type="hidden" name="order">
                </td>
                <td>
                    <div class="form-group"><input class="form-control" type="text" name="value" required /></div>
                </td>
                <td><button type="button" class="btn btn-sm btn-default btn-para-delete" >{$word.delete}</button></td>
                </tr>
          </textarea>
        </th>
      </tr>
    </tfoot>
  </table>
</form>
