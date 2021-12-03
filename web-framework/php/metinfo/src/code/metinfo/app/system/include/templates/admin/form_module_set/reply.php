<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$checkbox_time=time();
$filed_name=$data['module']=='job'?'cv':'fd';
$met_fd_email_name=$data['module']=='message'?'met_message_fd_email':'met_'.$filed_name.'_email';
$met_fd_email=$data['list'][$met_fd_email_name];
$met_fd_back_name='met_'.$filed_name.'_back';
$met_fd_back=$data['list'][$met_fd_back_name];
$met_fd_title_name='met_'.$filed_name.'_title';
$met_fd_title=$data['list'][$met_fd_title_name];
$met_fd_content_name='met_'.$filed_name.'_content';
$met_fd_content=$data['list'][$met_fd_content_name];
$met_fd_sms_back_name=$data['module']=='job'?'met_cv_sms_back':'met_fd_sms_back';
$met_fd_sms_back=$data['list'][$met_fd_sms_back_name];
$met_fd_sms_name=$data['module']=='message'?'met_message_fd_sms':($data['module']=='job'?'met_cv_sms_tell':'met_fd_sms_tell');
$met_fd_sms=$data['list'][$met_fd_sms_name];
$met_fd_sms_content_name=$data['module']=='job'?'met_cv_sms_content':'met_fd_sms_content';
$met_fd_sms_content=$data['list'][$met_fd_sms_content_name];
?>
<dl>
	<dt>
		<label class='form-control-label'>{$accepttype_title}{$word.marks}</label>
	</dt>
	<dd>
		<div class="custom-control custom-checkbox custom-control-inline">
			<input type="checkbox" id="{$met_fd_type_name}1-{$checkbox_time}" name='{$met_fd_type_name}' value='1' data-checked='{$met_fd_type}' class="custom-control-input"/>
			<label class="custom-control-label" for="{$met_fd_type_name}1-{$checkbox_time}">{$word.fdincAccept}</label>
		</div>
		<div class="custom-control custom-checkbox custom-control-inline">
			<input type="checkbox" id="{$met_fd_type_name}2-{$checkbox_time}" name='{$met_fd_type_name}' value='2' class="custom-control-input"/>
			<label class="custom-control-label" for="{$met_fd_type_name}2-{$checkbox_time}">{$word.fdincTip7}</label>
		</div>
	</dd>
</dl>
<if value="$data['module'] eq 'job'">
<dl>
    <dt>
        <label class='form-control-label'>{$word.cvincTip2}{$word.marks}</label>
    </dt>
    <dd>
        <div class="custom-control custom-radio">
            <input type="radio" id="met_cv_emtype0-{$checkbox_time}" name='met_cv_emtype' value='0' data-checked='{$data.list.met_cv_emtype}' class="custom-control-input"/>
            <label class="custom-control-label" for="met_cv_emtype0-{$checkbox_time}">{$word.cvincTip3}</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" id="met_cv_emtype1-{$checkbox_time}" name='met_cv_emtype' value='1' class="custom-control-input"/>
            <label class="custom-control-label mr-2" for="met_cv_emtype1-{$checkbox_time}">{$word.cvincTip4}</label>
            <span class="text-help" style="margin-top:2px;">{$word.admin_job1}</span>
        </div>
    </dd>
</dl>
</if>
<dl <if value="isset($data['list']['met_cv_emtype']) && $data['list']['met_cv_emtype']">class="hide"</if>>
	<dt>
		<label class='form-control-label'>{$acceptmail_title}{$word.marks}</label>
	</dt>
	<dd>
		<input type="text"  name="{$met_fd_to_name}" value='{$met_fd_to}' class="form-control">
		<span class="text-help ml-2">{$word.fdincTip9}</span>
	</dd>
</dl>
<dl>
    <dt>
        <label class='form-control-label'>{$admin_tel_title}{$word.marks}</label>
    </dt>
    <dd>
        <input type="text"  name="{$met_fd_admin_tel_name}" value='{$met_fd_admin_tel}' class="form-control">
        <span class="text-help ml-2">{$word.module_reply1}</span>
    </dd>
</dl>
<h3 class='example-title'>{$word.feedbackauto}</h3>
<dl>
	<dt>
		<label class='form-control-label'>{$word.fdincAuto}{$word.marks}</label>
	</dt>
	<dd>
		<div class="custom-control custom-checkbox custom-control-inline">
			<input type="checkbox" id="{$met_fd_back_name}1-{$checkbox_time}" name='{$met_fd_back_name}' value='1' data-checked='{$met_fd_back}' class="custom-control-input"/>
			<label class="custom-control-label" for="{$met_fd_back_name}1-{$checkbox_time}">{$word.fdincTip10}</label>
		</div>
	</dd>
</dl>
<dl>
	<dt>
		<label class='form-control-label'>{$word.fdincEmailName}{$word.marks}</label>
	</dt>
	<dd>
		<select name='{$met_fd_email_name}' data-checked='{$met_fd_email.val}' class="form-control w-a">
			<list data="$met_fd_email['options']" name="$v">
			<option value='{$v.val}'>{$v.name}</option>
			</list>
		</select>
		<span class="text-help ml-2">{$word.fdincTip11}</span>
	</dd>
</dl>
<dl>
	<dt>
		<label class='form-control-label'>{$word.fdincFeedbackTitle}{$word.marks}</label>
	</dt>
	<dd>
		<input type="text"  name="{$met_fd_title_name}" value='{$met_fd_title}' class="form-control">
		<span class="text-help ml-2">{$word.fdincAutoFbTitle}</span>
	</dd>
</dl>
<dl>
	<dt>
		<label class='form-control-label'>{$word.fdincAutoContent}{$word.marks}</label>
	</dt>
	<dd>
		<textarea name="{$met_fd_content_name}" rows="5" class="form-control">{$met_fd_content}</textarea>
	</dd>
</dl>
<h3 class='example-title'>{$word.feedbackautosms}</h3>
<dl>
	<dt>
		<label class='form-control-label'>{$word.fdincAutosms}{$word.marks}</label>
	</dt>
	<dd>
		<div class="custom-control custom-checkbox custom-control-inline">
			<input type="checkbox" id="{$met_fd_sms_back_name}1-{$checkbox_time}" name='{$met_fd_sms_back_name}' value='1' data-checked='{$met_fd_sms_back}' class="custom-control-input"/>
			<label class="custom-control-label" for="{$met_fd_sms_back_name}1-{$checkbox_time}">{$word.fdincTipsms}</label>
		</div>
	</dd>
</dl>
<dl>
	<dt>
		<label class='form-control-label'>{$word.fdinctellsms}{$word.marks}</label>
	</dt>
	<dd>
		<select name='{$met_fd_sms_name}' data-checked='{$met_fd_sms.val}' class="form-control w-a">
			<list data="$met_fd_sms['options']" name="$v">
			<option value='{$v.val}'>{$v.name}</option>
			</list>
		</select>
		<span class="text-help ml-2">{$word.fdinctells}</span>
	</dd>
</dl>
<dl>
	<dt>
		<label class='form-control-label'>{$word.fdincAutoContentsms}{$word.marks}</label>
	</dt>
	<dd>
		<textarea name="{$met_fd_sms_content_name}" rows="5" placeholder="{$word.message_tips1_v6}" class="form-control">{$met_fd_sms_content}</textarea>
		<span class="text-help ml-2">{$word.module_reply2}</span>
	</dd>
</dl>
<include file="pub/content_details/submit"/>