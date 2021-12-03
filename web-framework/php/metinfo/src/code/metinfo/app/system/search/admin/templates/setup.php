<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$checkbox_time = time();
$data = $data['handle'];
?>
<form method="POST" action="{$url.own_name}c=index&a=doGetSearchSave" data-submit-ajax="1">
    <div class="metadmin-fmbx">
        <!--全局搜索-->
        <h3 class="example-title">{$word.mod11}</h3>
        <dl>
            <dt>
                <label class='form-control-label'>{$word.search_range}</label></dt>
                <dd class="form-group">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="global_search_range_1" name="global_search_range" value='all'
                               data-checked="{$c.global_search_range}" required class="custom-control-input" />
                        <label class="custom-control-label" for="global_search_range_1">{$word.cvall}</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="global_search_range_2" name="global_search_range" value='module'
                               class="custom-control-input" />
                        <label class="custom-control-label" for="global_search_range_2">{$word.by_module}</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="global_search_range_3" name="global_search_range" value='column'
                               class="custom-control-input"  />
                        <label class="custom-control-label" for="global_search_range_3">{$word.by_column}</label>
                    </div>
                </dd>
        </dl>
        <dl id="module-collapse" class='collapse <if value="$c['global_search_range'] eq 'module'">show</if>'>
        <dt>
            <label class='form-control-label'>{$word.by_module}</label>
        </dt>
        <dd>
            <div class="form-group">
                <select name="global_search_module" class="form-control mr-1 prov w-a" required
                        data-checked="{$c.global_search_module}">
                    <option value="2">{$word.mod2}</option>
                    <option value="3">{$word.mod3}</option>
                    <option value="5">{$word.mod5}</option>
                    <option value="4">{$word.mod4}</option>
                </select>
            </div>
        </dd>
        </dl>
        <dl id="column-collapse" class='collapse <if value="$c['global_search_range'] eq 'column'">show</if>'>
        <dt>
            <label class='form-control-label'>{$word.by_column}</label>
        </dt>
        <dd>
            <div class="form-group">
                <select name="global_search_column" class="form-control mr-1 prov w-a" required
                        data-checked="{$c.global_search_column}">
                    <list data="$data['column']">
                        <option value="{$val.id}">{$val.name}</option>
                    </list>
                </select>
            </div>
        </dd>
        </dl>
        <dl>
            <dt><label class='form-control-label'>{$word.admin_search6}</label></dt>
            <dd class="form-group">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="global_search_type_1" name="global_search_type" value='0'
                           data-checked="{$c.global_search_type}" class="custom-control-input" />
                    <label class="custom-control-label" for="global_search_type_1">{$word.cvall}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="global_search_type_2" name="global_search_type" value='1'
                           class="custom-control-input" />
                    <label class="custom-control-label" for="global_search_type_2">{$word.title}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="global_search_type_3" name="global_search_type" value='2'
                           class="custom-control-input" />
                    <label class="custom-control-label" for="global_search_type_3">{$word.content}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="global_search_type_4" name="global_search_type" value='3'
                           class="custom-control-input" data-toggle="collapse" data-target="#more-collapse" />
                    <label class="custom-control-label" for="global_search_type_4">{$word.admin_search7}</label>
                </div>
            </dd>
        </dl>
        <dl>
            <dt>{$word.admin_search4}</dt>
            <dd>
                <div class='form-group clearfix'>
                    <input type="text" name="SearchInfo1" class="form-control" value="{$data.SearchInfo1}"></div>
            </dd>
        </dl>

        <!--栏目搜索-->
        <h3 class="example-title">{$word.column_search}</h3>
        <dl>
            <dt>
                <label class='form-control-label'>{$word.search_range}</label>
            </dt>
            <dd class="form-group">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="column_search_range_1" name="column_search_range" value='current' data-checked="{$c.column_search_range}" required class="custom-control-input"/>
                    <label class="custom-control-label" for="column_search_range_1">{$word.setequivalentcolumns}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="column_search_range_2" name="column_search_range" value='parent' class="custom-control-input"  data-toggle="collapse" data-target="#module-collapse"/>
                    <label class="custom-control-label" for="column_search_range_2">{$word.admin_search5}</label>
                </div>
            </dd>
        </dl>
        <dl>
            <dt>
                <label class='form-control-label'>{$word.admin_search6}</label>
            </dt>
            <dd class="form-group">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="column_search_type_1" name="column_search_type" value='0' data-checked="{$c.column_search_type}"  class="custom-control-input"/>
                    <label class="custom-control-label" for="column_search_type_1">{$word.cvall}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="column_search_type_2" name="column_search_type" value='1' class="custom-control-input"/>
                    <label class="custom-control-label" for="column_search_type_2">{$word.title}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="column_search_type_3" name="column_search_type" value='2' class="custom-control-input"/>
                    <label class="custom-control-label" for="column_search_type_3">{$word.content}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="column_search_type_4" name="column_search_type" value='3' class="custom-control-input"  data-toggle="collapse" data-target="#more-collapse"/>
                    <label class="custom-control-label" for="column_search_type_4">{$word.admin_search7}</label>
                </div>

            </dd>
        </dl>
        <dl>
            <dt>{$word.admin_search4}</dt>
            <dd>
                <div class='form-group clearfix'>
                    <input type="text" name="columnSearchInfo" class="form-control" value="{$data.columnSearchInfo}"></div>
            </dd>
        </dl>

        <!--高级搜索-->
        <h3 class="example-title">{$word.advanced_search}</h3>
        <dl>
            <dt><label class='form-control-label'>{$word.search_range}</label></dt>
            <dd class="form-group">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="advanced_search_range_1" name="advanced_search_range" value='all'
                           data-checked="{$c.advanced_search_range}" required class="custom-control-input" />
                    <label class="custom-control-label" for="advanced_search_range_1">{$word.cvall}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="advanced_search_range_2" name="advanced_search_range" value='parent'
                           class="custom-control-input" />
                    <label class="custom-control-label" for="advanced_search_range_2">{$word.admin_search1}</label>
                </div>
            </dd>
        </dl>
        <dl class="advanced_search_range_2 <if value="$c['advanced_search_range'] eq 'all'">hide</if>">
        <dt>
            <label class='form-control-label'>{$word.columnselect1}</label>
        </dt>
        <dd class="form-group">
            <list data="$data['column']">
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" id="column_{$val.id}" name='advanced_search_column' value='{$val.id}'
                           data-checked='{$c.advanced_search_column}' class="custom-control-input" />
                    <label class="custom-control-label" for="column_{$val.id}">{$val.name}</label>
                </div>
            </list>
        </dd>
        </dl>
        <dl class="advanced_search_type">
            <dt><label class='form-control-label'>{$word.admin_search2}</label></dt>
            <dd class="form-group">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="type_1" name="advanced_search_type" value='1'
                           data-checked="{$c.advanced_search_type}" required class="custom-control-input" />
                    <label class="custom-control-label" for="type_1">{$word.open}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="type_2" name="advanced_search_type" value='0' class="custom-control-input"
                           data-toggle="collapse" data-target="#module-collapse" />
                    <label class="custom-control-label" for="type_2">{$word.close}</label>
                </div>
            </dd>
        </dl>

        <dl>
            <dt><label class='form-control-label'>{$word.admin_search3}</label></dt>
            <dd class="form-group">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="advanced_search_linkage_1" name="advanced_search_linkage" value='1'
                           data-checked="{$c.advanced_search_linkage}" required class="custom-control-input" />
                    <label class="custom-control-label" for="advanced_search_linkage_1">{$word.open}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="advanced_search_linkage_2" name="advanced_search_linkage" value='0'
                           class="custom-control-input" data-toggle="collapse" data-target="#module-collapse" />
                    <label class="custom-control-label" for="advanced_search_linkage_2">{$word.close}</label>
                </div>
            </dd>
        </dl>
        <dl>
            <dt>{$word.admin_search4}</dt>
            <dd>
                <div class='form-group clearfix'>
                    <input type="text" name="advancedSearchInfo" class="form-control" value="{$data.advancedSearchInfo}"></div>
            </dd>

        </dl>

        <dl>
            <dt></dt>
            <dd>
                <button type="submit" class="btn btn-primary">{$word.Submit}</button>
            </dd>
        </dl>
    </div>
</form>