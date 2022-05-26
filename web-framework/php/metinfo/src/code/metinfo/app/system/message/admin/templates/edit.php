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
<form method="POST" action="{$url.own_name}c={$data.c}&a=doEditorsave&class1={$data.list.class1}&id={$data.list.id}" class='message-details-form' data-validate_order=".message-details-form" data-submit-ajax='1' enctype="multipart/form-data">
	<div class="metadmin-fmbx">
		<list data="$data['list']['plist']" name="$v">
		<dl>
			<dt>
				<label class='form-control-label'>
					<if value="$v['message_fd_content']"><span class="text-danger">*</span></if>
					{$v.name}{$word.marks}
				</label>
			</dt>
			<dd>
				<if value="$v['message_fd_content']">
				<textarea name="fd_content" placeholder="{$word.message_tips1_v6}" rows="5" class="form-control">{$v.val}</textarea>
				<elseif value="$v['type'] eq 5"/>
				<a href="{$v.val}" target="_blank">{$v.val}</a>
				<else/>
				<div class="text-help text-dark">{$v.val}</div>
				</if>
			</dd>
		</dl>
		</list>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.messageTime}{$word.marks}</label>
			</dt>
			<dd><div class="text-help text-dark">{$data.list.addtime}</div></dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.messageID}{$word.marks}</label>
			</dt>
			<dd><div class="text-help text-dark">{$data.list.customerid}</div></dd>
		</dl>
		<if value="$c['met_member_use']">
		<?php
		$webaccess=array(
			'value'=>$data['list']['access'],
			'access'=>$data['access_option'],
			'marks'=>$word['marks']
		);
		?>
		<include file="pub/content_details/webaccess"/>
		</if>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.messageeditorReply}{$word.marks}</label>
			</dt>
			<dd>
				<textarea name="useinfo" placeholder="{$word.message_tips1_v6}" rows="5" class="form-control">{$data.list.useinfo}</textarea>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.messageeditorCheck}{$word.marks}</label>
			</dt>
			<dd>
				<div class='form-group clearfix'>
					<div class="custom-control custom-checkbox custom-control-inline">
						<input type="checkbox" id="checkok1-{$checkbox_time}" name='checkok' value='1' data-checked='{$data.list.checkok}' class="custom-control-input"/>
						<label class="custom-control-label" for="checkok1-{$checkbox_time}">{$word.messageeditorShow}</label>
					</div>
				</div>
			</dd>
		</dl>
	</div>
</form>