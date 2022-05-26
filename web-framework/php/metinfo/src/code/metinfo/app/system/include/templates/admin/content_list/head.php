<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
if($data['handle']){
    $data = array_merge($data, $data['handle']);
    unset($data['handle']);
}
$table_order = $table_order ? $table_order : $data['module'] . '-list';
$btn_add_file = $btn_add_file ? $btn_add_file : 'edit';
$btn_add_text = $btn_add_text ? $btn_add_text : $word['addinfo'];
?>
<div class="clearfix">
    <if value="!$head_add_none || $dragsort_ok">
        <div class="float-left">
            <if value="!$head_add_none">
                <button type="button" class="btn btn-primary btn-content-list-add" data-toggle="modal" data-target=".{$data.module}-add-modal" data-modal-title="{$btn_add_text}" data-modal-size="xl" data-modal-url="{$data.module}/{$btn_add_file}/?c={$data.module}_admin&a=doadd&class1={$data.class1}&class2={$data.class2}&class3={$data.class3}" data-modal-fullheight="1">{$btn_add_text}</button>
            </if>
            <if value="$dragsort_ok"><font class="text-danger ml-2">{$word.admin_content_list1}</font></if>
        </div>
        <div class="float-right">
    </if>
    <if value="!$head_column_none">
        <div data-plugin='select-linkage' data-select-url="json" data-required="1" data-value_key="value" class="d-inline-block mr-2 column-select">
            <textarea class="select-linkage-data" hidden>{$data.columnlist_json}</textarea>
            <select name="class1" class="form-control float-left mr-1 w-a prov" data-checked="{$data.class1}" data-table-search="#{$table_order}" data-table-noreset></select>
            <select name="class2" class="form-control float-left mr-1 w-a city" data-checked="{$data.class2}" data-table-search="#{$table_order}" data-table-noreset></select>
            <select name="class3" class="form-control float-left mr-1 w-a dist" data-checked="{$data.class3}" data-table-search="#{$table_order}" data-table-noreset></select>
        </div>
    </if>
    <if value="!$head_search_none">
        <div class="input-group w-a<if value="!$head_add_none || $search_right">float-right<else/>float-left</if> <if value="$search_right"> content-list-search-right</if>">
            <input type="search" name="keyword" placeholder="{$word.search}" class="form-control" data-table-search="#{$table_order}">
            <div class="input-group-append">
                <div class="input-group-text btn bg-none px-2"><i class="input-search-icon fa-search" aria-hidden="true"></i></div>
            </div>
        </div>
    </if>
    <if value="!$head_add_none || $dragsort_ok">
    </div>
    </if>
</div>
<include file="pub/content_list/form_head"/>