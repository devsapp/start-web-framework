<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$data = $data['handle'];
$data['value']=$data['modules']?$data['modules']:$data['columns'];
$table_order='tags_table';
$table_ajaxurl=$url['adminurl'].'n=tags&c=index&a=doGetTagsList';
$form_action=$url['adminurl'].'n=tags&c=index&a=doDelTags';
?>
<div class="alert alert-primary">
    {$word.admin_tag_setting8} <a href="{$url.site}tags/" target="_blank">{$url.site}tags/</a>
</div>
<div class="metadmin-content-min bg-white p-4">
<div class="d-flex justify-content-between">
    <div>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".tags-edit-modal" data-modal-url="tags/edit/?c=index&a=doGetParentColumns" data-modal-title="{$word.mobiletips3}">{$word.add_tag}</button>
    </div>
    <div>
        <!-- 筛选 -->
        <select name="cid" data-table-search="#tags_table" class="form-control d-inline-block w-a float-left mr-1">
            <list data="$data['value']">
                <option value="{$val.id}">{$val.name}</option>
            </list>
        </select>
        <div class="input-group w-a float-left">
            <input type="search" name="keyword" placeholder="{$word.search}" class="form-control" data-table-search="#tags_table" />
            <div class="input-group-append">
                <div class="input-group-text btn bg-none px-2"> <i class="input-search-icon fa-search" aria-hidden="true"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<include file="pub/content_list/form_head"/>
        <include file="pub/content_list/checkall_all"/>
            <th data-table-columnclass="text-center">{$word.sort}</th>
            <th data-table-columnclass="text-center">{$word.tag_name}</th>
            <th data-table-columnclass="text-center">{$word.columnhtmlname}</th>
            <th data-table-columnclass="text-center">{$word.font_size}</th>
            <th data-table-columnclass="text-center">{$word.text_color}</th>
            <th data-table-columnclass="text-center">
                {$word.source}
                <select name="source" data-table-search="#tags_table" class="form-control">
                    <option value="0">{$word.cvall}</option>
                    <option value="1">{$word.content}</option>
                    <option value="2">{$word.add_manully}</option>
                </select>
            </th>
            <th data-table-columnclass="text-center">{$word.aggregation_range}</th>
            <th>{$word.operate}</th>
        </tr>
    </thead>
    <tbody>
    <?php $colspan=9; ?>
    <include file="pub/content_list/table_loader"/>
    </tbody>
    <?php $colspan=8;$foot_save_no=1; ?>
    <include file="pub/content_list/tfoot_common"/>
                </th>
            </tr>
        </tfoot>
    </table>
</form>
</div>