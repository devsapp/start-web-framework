<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$data['page_title']=$_M['word']['memberLogin'].$data['page_title'];
$login_position=$c['met_login_box_position']==1?'m-x-auto':($c['met_login_box_position']==2?'pull-xs-right':'');
?>
<include file="sys_web/head"/>
<include file="app/style"/>
<div class="met-member login-index page p-y-50">
	<div class="container">
		<form method="post" action="{$url.login_check}" class='met-form met-form-validation {$login_position}'>
			<input type="hidden" name="gourl" value="{$_M['form']['gourl']}" />
			<div class="form-group">
				<input type="text" name="username" class="form-control" placeholder="{$word.logintips}" data-safety required
				data-fv-notempty-message="{$word.noempty}"
				>
			</div>
			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="{$word.password}" data-safety required
				data-fv-notempty-message="{$word.noempty}"
				>
			</div>
			<?php
			if($_M['code']){
				$random = random(4, 1);
			?>
			<div class="form-group">
				<div class="input-group input-group-icon">
					<input type="text" name="code" class="form-control" placeholder="{$word.memberImgCode}" required data-fv-notempty-message="{$word.noempty}">
					<div class="input-group-addon p-5 user-code-img">
						<img src="{$url.entrance}?m=include&c=ajax_pin&a=dogetpin&random={$random}" title="{$word.memberTip1}" class='met-getcode' align="absmiddle" role="button">
						<input type="hidden" name="random" value="{$random}">
					</div>
				</div>
			</div>
			<?php } ?>
			<div class="login_link text-xs-right m-b-15"><a href="{$url.getpassword}">{$word.memberForget}</a></div>
			<button type="submit" class="btn btn-lg btn-primary btn-squared btn-block">{$word.memberGo}</button>
			<?php if($c['met_qq_open']||$c['met_weixin_open']||$c['met_weibo_open']){ ?>
			<div class="login_type text-xs-center m-t-20">
				<p>{$word.otherlogin}</p>
				<ul class="blocks-3 m-0">
					<?php if($c['met_qq_open']){ ?>
                    <li class='m-b-0'><a title="QQ{$word.login}" href="{$url.login_other}&type=qq"><i class="fa fa-qq font-size-30"></i></a></li>
					<?php
				    }
				    if($c['met_weixin_open'] && !(!is_weixin_client() && is_mobile_client())){
					?>
                    <li class='m-b-0'><a <if value="is_weixin_client()">href="{$url.login_other}&type=weixin"<else/>href="javascript:;" data-toggle="modal" data-target=".met-user-login-weixin-modal"</if> class="met-user-login-weixin"><i class="fa fa-weixin light-green-600 font-size-30"></i></a></li>
					<?php
				    }
				    if($c['met_weibo_open']){
					?>
                    <li class='m-b-0'><a href="{$url.login_other}&type=weibo"><i class="fa fa-weibo red-600 font-size-30"></i></a></li>
					<?php } ?>
				</ul>
			</div>
			<?php } ?>
			<?php if($c['met_member_register']){ ?>
			<a class="btn btn-lg btn-info btn-squared btn-block m-t-20" href="{$url.register}">{$word.logintips1}</a>
			<?php } ?>
		</form>
	</div>
</div>
<if value="$c['met_weixin_open'] eq 1">
<div class="modal fade modal-primary met-user-login-weixin-modal">
    <div class="modal-dialog modal-center modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">微信扫码登录</h4>
            </div>
            <div class="modal-body text-xs-center">
                <div class="h-250 vertical-align">
                  <div class="loader vertical-align-middle loader-round-circle"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</if>
<include file="sys_web/foot"/>