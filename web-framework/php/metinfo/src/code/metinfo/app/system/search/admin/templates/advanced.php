<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$checkbox_time = time();
$data = $data['handle'];
?>
<form method="POST" action="{$url.own_name}c=index&a=doSaveAdvancedSearch" data-submit-ajax="1">
  <div class="metadmin-fmbx">
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