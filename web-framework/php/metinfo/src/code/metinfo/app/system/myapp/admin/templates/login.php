<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-myapp-login mw-100">
  <form method="POST" action="{$url.own_name}c=index&a=doLogin" class="login-form">
    <div class="metadmin-fmbx">
      <h3 class="example-title text-center">{$word.application_market}</h3>
      <dl>
        <dt class="text-right">
          <label class="form-control-label">{$word.loginusename}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <div class="form-group clearfix">
              <div class="input-group">
                <div class="input-group-append">
                  <div class="input-group-text btn bg-none px-2"><i class="fa fa-user"></i></div>
                </div>
                <input type="text" name="username" class="form-control" placeholder="{$word.enter_user_name}" data-safety required
                  data-fv-notEmpty-message="{$word.js41}" />
              </div>

            </div>
          </div>
        </dd>
      </dl>
      <dl>
        <dt class="text-right">
          <label class="form-control-label">{$word.loginpassword}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <div class="input-group">
              <div class="input-group-append">
                <div class="input-group-text btn bg-none px-2"><i class="fa fa-lock"></i></div>
              </div>
              <input type="password" name="password" class="form-control" placeholder="{$word.Prompt_password}" data-safety required
                data-fv-notEmpty-message="{$word.js41}" />
            </div>
          </div>
        </dd>
      </dl>
      <dl>
        <dd class="text-center">
          <button type="submit" data-loading="1" class="btn btn-primary">{$word.landing}</button>
          <button class="btn btn-default ml-2">
            <a href="https://u.mituo.cn/#/user/register" target="_blank">{$word.register}</a>
          </button>
        </dd>
      </dl>
    </div>
  </form>
</div>