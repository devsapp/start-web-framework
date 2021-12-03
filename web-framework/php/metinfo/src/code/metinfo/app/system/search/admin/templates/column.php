<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$checkbox_time = time();
$data = $data['handle'];
?>
<form method="POST" action="{$url.own_name}c=index&a=doSaveColumnSearch" class="info-form" data-submit-ajax="1">
    <div class="metadmin-fmbx">
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
                    <input type="text" name="search_placeholder" class="form-control" value="{$data.search_placeholder}"></div>
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