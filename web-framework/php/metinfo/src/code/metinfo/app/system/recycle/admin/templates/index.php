<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$data['module']=$class_name='recycle';
$table_order='recycle-list';
$table_ajaxurl=$url['own_name'].'&c='.$data['module'].'&a=dojson_list';
$foot_submit_type='restore';
?>
<div class="clearfix">
    <select name="module" data-table-search="#{$table_order}" class="form-control w-a float-left">
        <option value="0">{$word.columnmodule}</option>
        <option value="news">{$word.mod2}</option>
        <option value="product">{$word.mod3}</option>
        <option value="download">{$word.mod4}</option>
        <option value="img">{$word.mod5}</option>
    </select>
    <div class="input-group w-a float-right">
        <input type="search" name="title" placeholder="{$word.title}" class="form-control" data-table-search="#{$table_order}">
        <div class="input-group-append">
            <div class="input-group-text btn"><i class="input-search-icon fa-search" aria-hidden="true"></i></div>
        </div>
    </div>
</div>
<include file="pub/content_list/form_head"/>
                <include file="pub/content_list/checkall_all"/>
                <th>{$word.title}</th>
                <th data-table-columnclass="text-center">{$word.recycledietime}</th>
                <th data-table-columnclass="text-center">{$word.category}</th>
                <th width="200">{$word.operate}</th>
            </tr>
        </thead>
        <tbody>
            <?php $colspan=5; ?>
            <include file="pub/content_list/table_loader"/>
        </tbody>
        <?php $colspan--;$submit_text=$word['recyclere']; ?>
        <include file="pub/content_list/tfoot_common"/>
                </th>
            </tr>
        </tfoot>
    </table>
</form>