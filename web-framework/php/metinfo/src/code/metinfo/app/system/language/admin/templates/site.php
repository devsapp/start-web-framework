<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-lang-web">
  <button type="button" class="btn btn-primary btn-add" data-toggle="modal" data-target=".langweb-add-modal"
    data-modal-url="language/add" data-modal-size="lg" data-modal-title="{$word.langadd}"
    data-modal-tablerefresh="#lang-table" data-modal-loading="1">
    {$word.langadd}
  </button>
  <table class="dataTable table table-hover w-100 mt-2" id="lang-table" data-ajaxurl="{$url.own_name}c=language_web&a=doGetWebLanguage" data-table-pagelength="20" data-datatable_order="#lang-table">
    <thead>
      <tr>
        <th data-table-columnclass="text-center">{$word.sort}</th>
        <th data-table-columnclass="text-center">{$word.langname}</th>
        <th data-table-columnclass="text-center">{$word.langflag}</th>
        <th data-table-columnclass="text-center">{$word.open}</th>
        <th data-table-columnclass="text-center">{$word.langhome}</th>
        <th width="200" data-table-columnclass="text-center">{$word.langouturl}</th>
        <th data-table-columnclass="text-center">{$word.operate}</th>
        <th>{$word.langpara}</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>