<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<include file="sys_web/head"/>
<include file="app/style"/>
<div class="register-index met-member page p-y-50">
	<div class="container">
		<form class="form-register met-form met-form-validation p-30 bg-white" method="post" action="{$data.submit_url}">
			<input type="hidden" name="type" value="{$data.type}"/>
			<input type="hidden" name="other_id" value="{$data.other_id}"/>
			<h1 class='m-t-0 m-b-20 font-size-24 text-xs-center'>{$_M['word']['memberReg']}</h1>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" name="username"  required class="form-control" placeholder="{$word.memberName}"
                        data-fv-remote="true"
                        data-fv-remote-url="{$url.register_userok}"
                        data-fv-remote-message="{$word.userhave}"
                        data-fv-notempty-message="{$word.noempty}"
                        data-fv-stringlength="true"
                        data-fv-stringlength-min="2"
                        data-fv-stringlength-max="30"
                        data-fv-stringlength-message="{$word.usernamecheck}"
                    />
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
                    <input type="password" name="password" required class="form-control" placeholder="{$word.password}"
                        data-fv-notempty-message="{$word.noempty}"
                        data-fv-identical="true"
                        data-fv-identical-field="confirmpassword"
                        data-fv-identical-message="{$word.passwordsame}"
                        data-fv-stringlength="true"
                        data-fv-stringlength-min="6"
                        data-fv-stringlength-max="30"
                        data-fv-stringlength-message="{$word.passwordcheck}"
                    />
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
                    <input type="password" name="confirmpassword" required data-password="password" class="form-control" placeholder="{$word.renewpassword}"
                    data-fv-identical="true"
                    data-fv-identical-field="password"
                    data-fv-identical-message="{$word.passwordsame}"
                    data-fv-notempty-message="{$word.noempty}"
                    >
                </div>
            </div>
			<button class="btn btn-lg btn-primary btn-squared btn-block" type="submit">{$word.memberRegister}</button>
		</form>
	</div>
</div>
<include file="sys_web/foot"/>