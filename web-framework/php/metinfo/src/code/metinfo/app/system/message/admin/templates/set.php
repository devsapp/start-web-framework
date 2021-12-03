<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
if($data['handle']){
	$data=array_merge($data,$data['handle']);
	unset($data['handle']);
}
$checkbox_time=time();
?>
<form method="POST" action="{$url.own_name}c={$data.c}&a=dosaveinc&class1={$data.class1}&class2={$data.class2}&class3={$data.class3}&classnow={$data.list.classnow}" class='message-details-form' data-validate_order=".message-details-form" data-submit-ajax='1' enctype="multipart/form-data">
	<div class="metadmin-fmbx">
		<dl>
			<dt>
				<label class='form-control-label'>{$word.messagesubmit}{$word.marks}</label>
			</dt>
			<dd>
				<input type="checkbox" data-plugin="switchery" name="met_msg_ok" value='{$data.list.met_msg_ok}' data-checked='1' hidden>
			</dd>
		</dl>
        <dl>
            <dt>
                <label class='form-control-label'>{$word.fdincTime}{$word.marks}</label>
            </dt>
            <dd>
                <input type="text" name="met_msg_time" value='{$data.list.met_msg_time}' class="form-control">
            </dd>
        </dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.message_name}{$word.marks}</label>
			</dt>
			<dd>
				<select name='met_msg_name_field' data-checked='{$data.list.met_msg_name_field.val}' class="form-control w-a">
					<list data="$data['list']['met_msg_name_field']['options']" name="$v">
					<option value='{$v.val}'>{$v.name}</option>
					</list>
				</select>
				<span class="text-help ml-2">{$word.message_name1}</span>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.message_content}{$word.marks}</label>
			</dt>
			<dd>
				<select name='met_msg_content_field' data-checked='{$data.list.met_msg_content_field.val}' class="form-control w-a">
					<list data="$data['list']['met_msg_content_field']['options']" name="$v">
					<option value='{$v.val}'>{$v.name}</option>
					</list>
				</select>
				<span class="text-help ml-2">{$word.message_content1}</span>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.messageincShow}{$word.marks}</label>
			</dt>
			<dd>
				<div class="custom-control custom-checkbox custom-control-inline">
					<input type="checkbox" id="met_msg_show_type1-{$checkbox_time}" name='met_msg_show_type' value='1' data-checked='{$data.list.met_msg_show_type}' class="custom-control-input"/>
					<label class="custom-control-label" for="met_message_show1-{$checkbox_time}">{$word.messageincTip3}</label>
				</div>
			</dd>
		</dl>
        <dl>
            <dt>
                <label class='form-control-label'>{$word.fdincAcceptType}{$word.marks}</label>
            </dt>
            <dd>
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" id="met_msg_type1-{$checkbox_time}" name='met_msg_type' value='1' data-checked='{$data.list.met_msg_type}' class="custom-control-input"/>
                    <label class="custom-control-label" for="met_msg_type1-{$checkbox_time}">{$word.fdincAccept}</label>
                </div>
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" id="met_msg_type2-{$checkbox_time}" name='met_msg_type' value='2' class="custom-control-input"/>
                    <label class="custom-control-label" for="met_msg_type2-{$checkbox_time}">{$word.fdincTip7}</label>
                </div>
            </dd>
        </dl>
        <dl>
            <dt>
                <label class='form-control-label'>{$word.message_AcceptMail}{$word.marks}</label>
            </dt>
            <dd>
                <input type="text"  name="met_msg_to" value='{$data.list.met_msg_to}' class="form-control">
                <span class="text-help ml-2">{$word.fdincTip9}</span>
            </dd>
        </dl>
        <dl>
            <dt>
                <label class='form-control-label'>{$word.fdincTip14}{$word.marks}</label>
            </dt>
            <dd>
                <input type="text"  name="met_msg_admin_tel" value='{$data.list.met_msg_admin_tel}' class="form-control">
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
                    <input type="checkbox" id="met_msg_back1-{$checkbox_time}" name='met_msg_back' value='1' data-checked='{$data.list.met_msg_back}' class="custom-control-input"/>
                    <label class="custom-control-label" for="met_msg_back1-{$checkbox_time}">{$word.fdincTip10}</label>
                </div>
            </dd>
        </dl>
        <dl>
            <dt>
                <label class='form-control-label'>{$word.fdincEmailName}{$word.marks}</label>
            </dt>
            <dd>
                <select name='met_msg_email_field' data-checked='{$data.list.met_msg_email_field.val}' class="form-control w-a">
                    <list data="$data.list.met_msg_email_field.options" name="$v">
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
                <input type="text"  name="met_msg_title" value='{$data.list.met_msg_title}' class="form-control">
                <span class="text-help ml-2">{$word.fdincAutoFbTitle}</span>
            </dd>
        </dl>
        <dl>
            <dt>
                <label class='form-control-label'>{$word.fdincAutoContent}{$word.marks}</label>
            </dt>
            <dd>
                <textarea name="met_msg_content" rows="5" class="form-control">{$data.list.met_msg_content}</textarea>
                <span class="text-help ml-2">{$word.fdinc_msg_content}</span>
            </dd>
        </dl>
        <h3 class='example-title'>{$word.feedbackautosms}</h3>
        <dl>
            <dt>
                <label class='form-control-label'>{$word.fdincAutosms}{$word.marks}</label>
            </dt>
            <dd>
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" id="met_msg_sms_back1-{$checkbox_time}" name='met_msg_sms_back' value='1' data-checked='{$data.list.met_msg_sms_back}' class="custom-control-input"/>
                    <label class="custom-control-label" for="met_msg_sms_back1-{$checkbox_time}">{$word.fdincTipsms}</label>
                </div>
            </dd>
        </dl>
        <dl>
            <dt>
                <label class='form-control-label'>{$word.fdinctellsms}{$word.marks}</label>
            </dt>
            <dd>
                <select name='met_msg_sms_field' data-checked='{$data.list.met_msg_sms_field.val}' class="form-control w-a">
                    <list data="$data.list.met_msg_sms_field.options" name="$v">
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
                <textarea name="met_msg_sms_content" rows="5" placeholder="{$word.message_tips1_v6}" class="form-control">{$data.list.met_msg_sms_content}</textarea>
                <span class="text-help ml-2">{$word.module_reply2}</span>
            </dd>
        </dl>
        <include file="pub/content_details/submit"/>
	</div>
</form>