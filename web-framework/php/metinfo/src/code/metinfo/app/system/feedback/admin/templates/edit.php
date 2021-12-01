<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
if($data['handle']){
	$data=array_merge($data,$data['handle']);
	unset($data['handle']);
}
?>
<form method="POST" action="{$url.own_name}c={$data.c}&a=doeditorsave&class1={$data.list.class1}&id={$data.list.id}" class='feedback-details-form' data-validate_order=".feedback-details-form" data-submit-ajax='1' enctype="multipart/form-data">
	<div class="metadmin-fmbx">
		<list data="$data['list']['plist']" name="$v">
		<dl>
			<dt>
				<label class='form-control-label'>
					<if value="$v['feedback_fd_content']"><span class="text-danger">*</span></if>
					{$v.name}{$word.marks}
				</label>
			</dt>
			<dd>
				<if value="$v['feedback_fd_content']">
				<textarea name="fd_content" placeholder="{$word.feedback_tips1_v6}" rows="5" class="form-control">{$v.val}</textarea>
				<else/>
				<div class="text-help text-dark">{$v.val}</div>
				</if>
			</dd>
		</dl>
		</list>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.fdeditorTime}{$word.marks}</label>
			</dt>
			<dd><div class="text-help text-dark">{$data.list.addtime}</div></dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.fdeditorFrom}{$word.marks}</label>
			</dt>
			<dd><div class="text-help text-dark">{$data.list.fromurl}</div></dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.feedbackID}{$word.marks}</label>
			</dt>
			<dd><div class="text-help text-dark">{$data.list.customerid}</div></dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>IP{$word.marks}</label>
			</dt>
			<dd><div class="text-help text-dark">{$data.list.ip}</div></dd>
		</dl>
		<h3 class='example-title'>{$word.fdeditorRecord}{$word.marks}</h3>
		<dl>
			<dd>
				<textarea name="useinfo" data-plugin='editor' data-editor-y='150' hidden>{$data.list.useinfo}</textarea>
			</dd>
		</dl>
	</div>
</form>