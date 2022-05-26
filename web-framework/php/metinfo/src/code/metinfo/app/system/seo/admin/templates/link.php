<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$table_order='seo-link-table';
$table_ajaxurl=$url['adminurl'].'n=link&c=link_admin&a=doGetList';
$form_action=$url['adminurl'].'n=link&c=link_admin&a=doDelLinks';
?>
<div class="clearfix">
    <div class="float-left">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".link-edit-modal" data-modal-url="link/add/?n=link&c=link_admin&a=doGetColumnList" data-modal-title="{$word.mobiletips3}">{$word.mobiletips3}</button>
    </div>
    <div class="float-right">
        <select name="search_type" data-table-search="#seo-link-table" class="form-control d-inline-block w-a float-left mr-1">
            <option value="0">{$word.smstips64}</option>
            <option value="1">{$word.linkType1}</option>
            <option value="2">{$word.linkType2}</option>
            <option value="3">{$word.linkType4}</option>
            <option value="4">{$word.linkType5}</option>
        </select>
        <div class="input-group w-a">
            <input type="search" name="keyword" placeholder="{$word.search}" class="form-control" data-table-search="#{$table_order}">
            <div class="input-group-append">
                <div class="input-group-text btn bg-none px-2"><i class="input-search-icon fa-search" aria-hidden="true"></i></div>
            </div>
        </div>
    </div>
</div>
<include file="pub/content_list/form_head"/>
        <include file="pub/content_list/checkall_all"/>
        <th data-table-columnclass="text-center">{$word.sort}</th>
        <th data-table-columnclass="text-center">{$word.linkType}</th>
        <th data-table-columnclass="text-center">{$word.linkName}</th>
        <th data-table-columnclass="text-center">{$word.linkUrl}</th>
        <th data-table-columnclass="text-center">{$word.linkCheck}</th>
        <th data-table-columnclass="text-center">{$word.recom}</th>
        <th>{$word.operate}</th>
    </tr>
</thead>
<tbody>
    <?php $colspan=8; ?>
    <include file="pub/content_list/table_loader"/>
</tbody>
<?php $colspan=7;$foot_save_no=1; ?>
<include file="pub/content_list/tfoot_common"/>
                </th>
            </tr>
        </tfoot>
    </table>
</form>