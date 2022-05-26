<?php
// MetInfo Enterprise Content Management System
// Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<form method="POST" action="{$url.own_name}c=index&a=doSaveDatabase" class="database-form">
  <div class="metadmin-fmbx">
    <h3 class="example-title">{$word.database_switch}</h3>
    <dl>
      <dt>
        <label class="form-control-label">{$word.database_type}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <div class="custom-control custom-radio ">
            <input type="radio" id="db_type-mysql" name="db_type" value="mysql" class="custom-control-input"
              data-checked="{$c['db_type']}">
            <label class="custom-control-label" for="db_type-mysql">mysql</label>
          </div>
          <div class="custom-control custom-radio ">
            <input type="radio" id="db_type-sqlite" name="db_type" value="sqlite" class="custom-control-input">
            <label class="custom-control-label" for="db_type-sqlite">sqlite</label>
          </div>
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class="form-control-label">{$word.dataexplain10}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <div class="custom-control custom-checkbox ">

            <input type="checkbox" id="backup" name='checkbox' value='1' checked="true" class="custom-control-input" />
            <label class="custom-control-label" for="backup">{$word.dataexplain10}</label>
          </div>

        </div>
        <span class="text-help">{$word.database_switch_tips}</span>
      </dd>
    </dl>
    <dl>
      <dt></dt>
      <dd class="btn-savegroup">
        <button type="submit" class="btn btn-primary btn-db_type-mysql hide" data-toggle="modal"
          data-target=".database-form-modal">{$word.Submit}</button>
        <button type="submit" class="btn btn-primary btn-db_type-sqlite hide">{$word.Submit}</button>

      </dd>
    </dl>
  </div>
</form>
<textarea name="database-info-form" hidden>
    <form action="{$url.own_name}c=index&a=doSaveDatabase" method="POST" >
        <p class="text-danger">{$word.database_switch_tips1}</p>
        <input type="hidden" name="db_type" value="mysql">
        <div class="form-group row">
            <label class="col-sm-4 col-form-label text-right">{$word.table_prefix}</label>
            <div class="col-sm-8">
                <input type="text" name="db_prefix" value="{$c.tablepre}" required class="form-control w-auto d-inline-block">
                <span class="text-muted ml-1">{$word.database_switch_tips2}</span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label text-right">{$word.database_address}</label>
            <div class="col-sm-8">
                <input type="text" name="db_host" value="{$c.con_db_host}" required class="form-control w-auto d-inline-block align-top">
                <span class="text-muted ml-1 d-inline-block align-top" style="width:calc(100% - 190px)">{$word.database_switch_tips3}</span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label text-right">{$word.database_name}</label>
            <div class="col-sm-8">
                <input type="text" name="db_name" value="{$c.con_db_name}" required class="form-control w-auto d-inline-block">
                <span class="text-muted ml-1">{$word.database_switch_tips4}</span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label text-right">{$word.database_user}</label>
            <div class="col-sm-8">
                <input type="text" name="db_username" value="{$c.con_db_id}" required class="form-control w-auto d-inline-block">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label text-right">{$word.database_password}</label>
            <div class="col-sm-8">
                <input type="password" name="db_pass" value="{$c.con_db_pass}" class="form-control w-auto d-inline-block">
            </div>
        </div>
        <button type="reset" hidden></button>
    </form>
</textarea>