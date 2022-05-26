<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-user-func">
	<div class="alert alert-primary ">
		{$word.user_tips5_v6}<br />
		{webname} {$word.linkName}<br />
		{weburl} {$word.linkUrl}<br />
		{opurl} {$word.user_tips6_v6}<br />
	</div>
	<div class="metadmin-content-min bg-white p-4">
		<form method="POST" action="{$url.own_name}c=admin_set&a=doSaveEmailSetup" class="info-form mt-3" data-submit-ajax='1'>
			<div class="metadmin-fmbx">
				<h3 class="example-title">{$word.user_Registeredmail_v6}</h3>
				<dl>
					<dt>
						<label class="form-control-label">{$word.title}</label>
					</dt>
					<dd>
						<div class="form-group clearfix">
							<input type="text" name="met_member_email_reg_title" class="form-control"/>
						</div>
					</dd>
				</dl>
				<dl>
					<dt>
						<label class="form-control-label">{$word.content}</label>
					</dt>
					<dd>
						<div class="form-group clearfix">
							<textarea name="met_member_email_reg_content" data-plugin="editor" data-editor-x="700" hidden></textarea>
						</div>
					</dd>
				</dl>
				<h3 class="example-title">{$word.user_tips7_v6}</h3>
				<dl>
					<dt>
						<label class="form-control-label">{$word.title}</label>
					</dt>
					<dd>
						<div class="form-group clearfix">
							<input type="text" name="met_member_email_password_title" class="form-control"/>
						</div>
					</dd>
				</dl>
				<dl>
					<dt>
						<label class="form-control-label">{$word.content}</label>
					</dt>
					<dd>
						<div class="form-group clearfix">
							<textarea name="met_member_email_password_content" data-plugin="editor" data-editor-x="700" hidden></textarea>
						</div>
					</dd>
				</dl>
				<h3 class="example-title">{$word.modifyaccemail}</h3>
				<dl>
					<dt>
						<label class="form-control-label">{$word.title}</label>
					</dt>
					<dd>
						<div class="form-group clearfix">
							<input type="text" name="met_member_email_safety_title" class="form-control"/>
						</div>
					</dd>
				</dl>
				<dl>
					<dt>
						<label class="form-control-label">{$word.content}</label>
					</dt>
					<dd>
						<div class="form-group clearfix">
							<textarea name="met_member_email_safety_content" data-plugin="editor" data-editor-x="700" hidden></textarea>
						</div>
					</dd>
				</dl>

				<dl>
					<dt></dt>
					<dd>
						<button type="submit" class="btn btn-primary">{$word.save}</button>
					</dd>
				</dl>
			</div>
		</form>
	</div>
</div>
