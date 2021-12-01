<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-user-list">
  <div class="clearfix">
    <button type="button" class="btn btn-primary btn-add" data-toggle="modal" data-modal-url="user/user_add"
      data-modal-loading="1" data-modal-title="{$word.memberAdd}" data-target=".user-add-modal"
      data-modal-tablerefresh="#user-table">
      {$word.memberAdd}
    </button>
    <div class="input-group w-a float-right">
      <input type="search" name="keyword" placeholder="{$word.search}" class="form-control"
        data-table-search="#user-table" />
      <div class="input-group-append">
        <div class="input-group-text btn bg-none px-2"><i class="input-search-icon fa-search" aria-hidden="true"></i></div>
      </div>
    </div>
  </div>
  <table class="dataTable table table-hover w-100 mt-2" id="user-table"
    data-ajaxurl="{$url.own_name}c=admin_user&a=doGetUserList" data-table-pagelength="20" data-plugin="checkAll"
    data-datatable_order="#user-table">
    <thead>
      <tr>
        <th width="50" data-table-columnclass="text-center">
          <div class="custom-control custom-checkbox">
            <input class="checkall-all custom-control-input" type="checkbox" />
            <label class="custom-control-label"></label>
          </div>
        </th>
        <th width="150">{$word.adminusername}</th>
        <th width="100" data-table-columnclass="text-center">
          {$word.membergroup}
          <select name="groupid" data-table-search="" class="form-control d-inline-block w-a ml-2 select-groupid">
            <option value="">{$word.cvall}</option>
          </select>
        </th>
        <th width="150" data-table-columnclass="text-center">{$word.membertips1}</th>
        <th width="150" data-table-columnclass="text-center">{$word.lastactive}</th>
        <th width="100" data-table-columnclass="text-center">{$word.adminLoginNum}</th>
        <th width="100" data-table-columnclass="text-center">{$word.memberCheck}</th>
        <th width="100" data-table-columnclass="text-center">{$word.source}</th>
        <th width="400">{$word.operate}</th>
      </tr>
    </thead>
    <tbody></tbody>
    <tfoot>
      <tr>
        <th>
          <div class="custom-control custom-checkbox">
            <input class="checkall-all custom-control-input" type="checkbox" />
            <label class="custom-control-label"></label>
          </div>
        </th>
        <th colspan="8" data-no_column_defs class="btn_group">
          <div class="justify-content-between row m-0">
            <button type="button" class="btn btn-delete-all">
              {$word.delete}
            </button>
            <a class="btn btn-default" href="{$url.own_name}c=admin_user&a=doExportUser">
              {$word.user_Exportmember_v6}
            </a>
          </div>
        </th>
      </tr>
    </tfoot>
  </table>
</div>