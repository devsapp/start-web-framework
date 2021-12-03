<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$data['page_title']=$_M['word']['getTip5'].$data['page_title'];
?>
<include file="sys_web/head"/>
<include file="app/style"/>
<div class="register-index met-member page p-y-50 bg-pagebg1">
	<div class="container ">
	<form class="form-register ui-from met-form-validation panel panel-body" method="post" action="{$url.password_email}">
		<h1 class='m-t-0 m-b-20 font-size-24 text-xs-center'>{$word.getTip5}</h1>
		<div class="form-group">
			<input type="text" name="username" class="form-control" placeholder="{$word.getpasswordtips}" required data-fv-notempty-message="{$word.noempty}">
		</div>
		<?php
		if($_M['config']['met_memberlogin_code']){
			$random = random(4, 1);
		?>
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
		<?php } ?>
		<button class="btn btn-lg btn-primary btn-squared btn-block" type="submit">{$word.next}</button>
		<div class="login_link m-t-10 text-xs-right"><a href="{$url.login}">{$word.relogin}</a></div>
	</form>
	</div>
</div>
<include file="sys_web/foot"/>