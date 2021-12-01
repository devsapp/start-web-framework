<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$head_tab_active=2;
$head_tab=array(
	array('title'=>"短信配置",'url'=>'#/app/met_sms'),
	array('title'=>"短信群发",'url'=>'#/app/met_sms/mass'),
	array('title'=>"发送记录",'url'=>'#/app/met_sms/log'),
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
      <div class="met_sms-container hide">
        <table class="dataTable table table-hover w-100 mt-2" id="sms-table"
          data-ajaxurl="{$url.own_name}c=index&a=doLogs" data-table-pagelength="20"
          data-datatable_order="#sms-table">
          <thead>
            <tr>
              <th >发送时间</th>
              <th >发送类型</th>
              <th >短信内容</th>
              <th >对方号码</th>
              <th >发送结果</th>
            </tr>
          </thead>
          <tbody></tbody>
          <tfoot>
            <tr>
              <th colspan="5" data-no_column_defs class="btn_group">

              </th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>