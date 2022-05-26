<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$head_tab_active=0;
$head_tab=array(
  array('title'=>"短信配置",'url'=>'#/app/met_sms'),
  array('title'=>"短信群发",'url'=>'#/app/met_sms/mass'),
  array('title'=>"发送记录",'url'=>'#/app/met_sms/log'),
);
$domain=HTTP_HOST;
?>
<div class="met_sms">
    <div class="head">
        <include file="pub/head_tab" />
        <if value="$c['met_agents_metmsg']">
        <div class="met_sms-right"></div>
        </if>
    </div>
    <div class="content">
        <div class="met_sms-list">
            <div class="met-tips" data-url="{$domain}"></div>
            <div class="met_sms-container hide">
                <form method="POST" action="{$url.own_name}c=index&a=dosave" data-submit-ajax="1" class='info-form mt-3'
          id="info-form" data-validate_order="#info-form">
                    <div class="metadmin-fmbx">
                        <dl>
                            <dt>
                                <label class='form-control-label'>短信发送码</label>
                            </dt>
                            <dd>
                                <div class='form-group clearfix'>
                                    <input type="text" name="met_sms_token" class="form-control" value="{$_M['config']['met_sms_token']}">
                                    <if value="$c.met_agents_metmsg eq '1'">
                                        <a href="https://u.mituo.cn/#/api/sms" target="_blank" class="ml-3" style="line-height:35px;">查看</a>
                                    </if>
                                </div>
                            </dd>
                        </dl>
                        <dl>
                            <dt></dt>
                            <dd>
                                <button type="submit" class='btn btn-primary'>{$word.save}</button>
                            </dd>
                        </dl>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>