<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$colspan=6;
$table_addlist='online-list';
?>
<div class="alert alert-danger">{$word.online_tips1_v6}</div>
<div class="alert alert-primary">{$word.admin_content_list1}</div>
<div class="metadmin-content-min bg-white p-4">
    <button type="button" class="btn btn-primary btn-add" table-addlist="#{$table_addlist}" data-table-newid='1'><i class="fa fa-plus-circle"></i> {$word.online_addkefu_v6}</button>
    <form method="POST" action="{$url.own_name}c=online&a=dolistsave" data-submit-ajax="1">
        <table class="dataTable table table-hover w-100 mt-2" id="{$table_addlist}"
        data-ajaxurl="{$url.own_name}c=online&a=doGetList" data-plugin="checkAll" data-datatable_order="#{$table_addlist}" data-table-pagelength="1000">
            <thead>
                <tr>
                    <include file="pub/content_list/checkall_all"/>
                    <th>{$word.online_csname_v6}</th>
                    <th width="50" data-table-columnclass="text-center">{$word.type}</th>
                    <th>{$word.online_list1}</th>
                    <th width="130" data-table-columnclass="text-center">{$word.onlineimg}</th>
                    <th width="50">{$word.operate}</th>
                </tr>
            </thead>
            <tbody data-plugin="dragsort" data-dragsort_order="#{$table_addlist}">
                <include file="pub/content_list/table_loader"/>
            </tbody>
            <?php
            $colspan--;
            $table_newid=1;
            ?>
            <include file="pub/content_list/tfoot_common"/>
                        <textarea table-addlist-data hidden>
                            <tr>
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox">
                                        <input class="checkall-item custom-control-input" type="checkbox" name="id">
                                        <label class="custom-control-label"></label>
                                    </div>
                                    <input type="hidden" name="no_order"></td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="name" required class="form-control">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <select name="type" class="form-control w-a d-inline-block">
                                        <option value="0">QQ</option>
                                        <option value="8">{$word.enterprise_qq}</option>
                                        <option value="1">{$word.online_taobaocs_v6}</option>
                                        <option value="2">{$word.online_alics_v6}</option>
                                        <option value="3">{$word.parameter8}</option>
                                        <option value="4">{$word.unitytxt_71}</option>
                                        <option value="5">Skype</option>
                                        <option value="6">Facebook</option>
                                        <option value="7">{$word.external_links}</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="value" required class="form-control">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <input type="hidden" name="icon" data-plugin="iconset" data-btn_size="sm" data-icon_class="mb-1 mr-0" class="form-control">
                                </td>
                                <td></td>
                            </tr>
                        </textarea>
                    </th>
                </tr>
            </tfoot>
        </table>
    </form>
</div>