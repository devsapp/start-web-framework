<?php
// MetInfo Enterprise Content Management System
// Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$head_tab_active = 1;
$head_tab = array(
    array('title' => '短信配置', 'url' => '#/app/met_sms'),
    array('title' => '短信群发', 'url' => '#/app/met_sms/mass'),
    array('title' => '发送记录', 'url' => '#/app/met_sms/log'),
);
?>
<div class="met_sms">
  <div class="head">
    <include file="pub/head_tab" />
    <if value="$c['met_agents_metmsg']">
    <div class="met_sms-right">
    </div>
    </if>
  </div>
  <div class="content">
    <div class="met_sms-list">
      <div class="met-tips"></div>
      <div class="met_sms-container hide">
        <form method="POST" action="{$url.own_name}c=index&a=dosend" data-submit-ajax="1" class='info-form mt-3'
          id="info-form" data-validate_order="#info-form">
          <div class="metadmin-fmbx">
          <dl>
              <dt>
                <label class='form-control-label'>短信签名</label>
              </dt>
              <dd>
                  <div class='form-group clearfix'>
                      <span class="signature text-help"></span>
                  </div>
              </dd>
            </dl>
            <dl>
              <dt>
                <label class='form-control-label'>可用条数</label>
              </dt>
              <dd>
                <div class='form-group clearfix'>
                  <span class="avalible"></span>
                    <if value="$c.met_agents_metmsg eq '1'">
                        <a href="https://u.mituo.cn/#/api/sms" target="_blank" class="ml-3" style="line-height:35px;">购买</a>
                    </if>
                </div>
              </dd>
            </dl>
            <dl>
              <dt>
                <label class='form-control-label'>短信内容</label>
              </dt>
              <dd>
                <div class='form-group clearfix'>
                  <textarea name="sms_content" rows="5" class='form-control'></textarea>
                  <span class="text-help ml-2">中文/英文第一条<span class="first_word"></span>个字，第二条起64个字,超过字数算将切分为多条短信</span>
                  <span class="text-help ml-2"> 当前字数：<b class="text-danger">
                      <span class="current"></span>
                      /
                      <span class="word"></span></b> 个字 (共 <b class="red str_count">1</b>条短信)</span>
                </div>
              </dd>
            </dl>
            <dl>
              <dt>
                <label class='form-control-label'>手机号码</label>
              </dt>
              <dd>
                <div class='form-group clearfix'>
                  <textarea name="sms_phone" rows="5" class='form-control'></textarea>

                  <span class="text-help ml-2">请填写接收短信的手机号码
                    多个手机号码请换行
                    一次不超过800个手机号码 当前共 <b class="red phone_count">0</b> 个号码</span>
                </div>
              </dd>
            </dl>
            <dl>
              <dt></dt>
              <dd>
                <button type="submit" class='btn btn-primary'>发送</button>
              </dd>
            </dl>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>