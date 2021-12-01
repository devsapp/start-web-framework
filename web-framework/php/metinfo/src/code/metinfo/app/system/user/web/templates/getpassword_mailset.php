<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$data['page_title']=$_M['word']['getTip5'].$data['page_title'];
?>
<include file="sys_web/head"/>
<div class="register-index met-member page p-y-50 bg-pagebg1">
	<div class="container">
	<form class="form-register ui-from met-form-validation p-30 bg-white" method="post" action="{$_M['url']['password_valid']}">
		<input type="hidden" name="p" value="{$_M['form']['p']}" />
		<h1 class='m-t-0 m-b-20 font-size-24 text-xs-center'>{$_M['word']['getTip5']}</h1>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
				<input type="password" name="password" class="form-control" placeholder="{$_M['word']['newpassword']}" required
				data-fv-notempty-message="{$_M['word']['noempty']}"
				data-fv-identical="true"
				data-fv-identical-field="confirmpassword"
				data-fv-identical-message="{$_M['word']['passwordsame']}"
				data-fv-stringlength="true"
				data-fv-stringlength-min="3"
				data-fv-stringlength-max="30"
				data-fv-stringlength-message="{$_M['word']['passwordcheck']}"
				>
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
				<input type="password" name="confirmpassword" data-password="password" class="form-control" placeholder="{$_M['word']['renewpassword']}" required
				data-fv-notempty-message="{$_M['word']['noempty']}"
				data-fv-identical="true"
				data-fv-identical-field="password"
				data-fv-identical-message="{$_M['word']['passwordsame']}"
				>
			</div>
		</div>
		<button class="btn btn-lg btn-primary btn-squared btn-block" type="submit">{$_M['word']['Submit']}</button>
		<div class="login_link m-t-10 text-xs-right"><a href="{$_M['url']['login']}">{$_M['word']['relogin']}</a></div>
	</form>
	</div>
</div>
<include file="sys_web/foot"/>