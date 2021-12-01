<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-logs-list">
    <div class="table-div">
        <table
                class="dataTable table table-hover w-100"
                id="logs-table"
                data-ajaxurl="{$url.site_admin}?n=logs&c=index&a=dolist"
                data-table-pagelength="20"
                data-plugin="checkAll"
                data-datatable_order="#logs-table"
        >
            <thead>
            <tr>
                <th width="50" data-table-columnclass="text-center">
                    <div class="custom-control custom-checkbox">
                        <input class="checkall-all custom-control-input" type="checkbox" />
                        <label class="custom-control-label"></label>
                    </div>
                </th>
                <th width="150">{$word.smstips24}</th>
                <th width="100" data-table-columnclass="text-center">
                    {$word.adminusername}
                </th>
                <th width="150" data-table-columnclass="text-center">IP</th>
                <th width="150" data-table-columnclass="text-center">{$word.request_address}</th>
                <th width="100" data-table-columnclass="text-center">{$word.systemModule}</th>
                <th width="100" data-table-columnclass="text-center">{$word.operate}</th>
                <th width="100" data-table-columnclass="text-center">{$word.request_result}</th>
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
                <th colspan="7" data-no_column_defs class="btn_group">
                    <div class="justify-content-between row m-0">
                        <button type="button" class="btn btn-default btn-delete-all" >{$word.delete}</button>
                        <button type="button" class="btn btn-default btn-clear-all">清空日志</button>
                    </div>
                </th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>