<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-recovery">
  <div class="met-recovery-list">
    <form action="javascript:;">
    <table class="dataTable table table-hover w-100" id="recovery-table"
      data-ajaxurl="{$url.own_name}c=index&a=dorecovery" data-datatable_order="#recovery-table" data-table-sdom='t'>
      <thead>
        <tr>
          <th data-table-columnclass="text-center">{$word.smstips17}</th>
          <th width="150" data-table-columnclass="text-center">{$word.setdbFilename}</th>
          <th data-table-columnclass="text-center">{$word.webupate6}</th>
          <th data-table-columnclass="text-center">{$word.setdbsysver}</th>
          <th data-table-columnclass="text-center">{$word.setdbFilesize}</th>
          <th data-table-columnclass="text-center">{$word.setdbTime}</th>
          <th data-table-columnclass="text-center">{$word.setdbNumber}</th>
          <th width="600">{$word.operate}</th>
        </tr>
      </thead>
      <tbody>
        <?php $colspan=8; ?>
      <include file="pub/content_list/table_loader"/>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="8" data-no_column_defs class="btn_group">
            <div class='form-group clearfix font-weight-normal'>
              <div class="mr-2 d-inline-block">
                <input type="file" name="recovery_file" data-plugin='fileinput' data-drop-zone-enabled="false"
                  data-noimage='1' data-preview-class='hide' data-noprogress="1" data-url="{$url.own_name}c=index&a=doUploadDataback"
                  data-callback="recoveryFileFun" accept="*">
              </div>
              <span class="text-help mt-2">{$word.dataexplain2}</span>
            </div>
          </th>
        </tr>
      </tfoot>
    </table>
    </form>
  </div>
</div>