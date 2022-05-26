<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$data['page_title']=$_M['word']['getTip5'].$data['page_title'];
?>
<include file="sys_web/head"/>
<?php $random = random(4, 1); ?>
<div class="register-index met-member page p-y-50 bg-pagebg1">
	<div class="container">
		<form class="form-register ui-from met-form-validation p-30 bg-white" method="post" action="{$url.password_telvalid}">
			<input type="hidden" name="username" value="{$_M['form']['username']}" />
			<h1 class='m-t-0 m-b-20 font-size-24 text-xs-center'>{$word.getTip5}</h1>
			<div class="form-group">
			    <div class="input-group input-group-icon">
			        <span class="input-group-addon"><i class="fa fa-shield"></i></span>
			        <input type="text" name="code" required class="form-control" placeholder="{$word.memberImgCode}" data-fv-notempty-message="{$word.js14}">
			        <div class="input-group-addon p-5 user-code-img">
			            <img src="{$url.entrance}?m=include&c=ajax_pin&a=dogetpin&random={$random}" title="{$word.memberTip1}" class='met-getcode' align="absmiddle" role="button">
			            <input type="hidden" name="random" value="{$random}">
			        </div>
			    </div>
			</div>
			<div class="form-group">
	            <div class="input-group input-group-icon">
	                <input type="text" name="phonecode" required class="form-control" placeholder="{$word.memberImgCode}" data-fv-notempty-message="{$word.noempty}">
	                <div class="input-group-addon p-0">
	                    <button type="button" data-url="{$url.password_valid_phone}" class="btn btn-success btn-squared w-full phone-code" data-retxt="{$word.rememberImgCode}">
	                        {$word.getmemberImgCode}
	                        <span class="badge"></span>
	                    </button>
	                </div>
	            </div>
	        </div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
					<input type="password" name="password" class="form-control" placeholder="{$word.newpassword}" required
						data-fv-notempty-message="{$word.noempty}"
						data-fv-identical="true"
						data-fv-identical-field="confirmpassword"
						data-fv-identical-message="{$word.passwordsame}"
						data-fv-stringlength="true"
						data-fv-stringlength-min="3"
						data-fv-stringlength-max="30"
						data-fv-stringlength-message="{$word.passwordcheck}"
					>
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
					<input type="password" name="confirmpassword" data-password="password" class="form-control" placeholder="{$word.renewpassword}" required
					data-fv-notempty-message="{$word.noempty}"
					data-fv-identical="true"
					data-fv-identical-field="password"
					data-fv-identical-message="{$word.passwordsame}"
					>
				</div>
			</div>
			<button class="btn btn-lg btn-primary btn-squared btn-block" type="submit">{$word.Submit}</button>
			<div class="login_link m-t-10 text-xs-right"><a href="{$url.login}">{$word.relogin}</a></div>
		</form>
	</div>
</div>
<include file="sys_web/foot"/>