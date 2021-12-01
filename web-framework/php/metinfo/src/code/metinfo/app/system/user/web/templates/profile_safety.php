<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$data['page_title']=$_M['word']['accsafe'].$data['page_title'];
?>
<include file="sys_web/head"/>
<div class="page bg-pagebg1 member-profile met-member">
    <div class="container">
        <div class="page-content row">
            <include file='app/sidebar'/>
            <div class="col-lg-9">
                <div class="panel panel-default m-b-0" boxmh-mh>
                    <div class='panel-body met-member-safety met-member-profile'>
                        <div class="media">
                            <div class="media-left media-middle"><i class="fa fa-unlock-alt"></i></div>
                            <div class="media-body">
                                <div class="row m-x-0">
                                    <div class="col-xs-8 col-sm-9 col-md-10">
                                        <h4 class="media-heading">{$word.accpassword}</h4>
                                        {$word.accsaftips1}
                                    </div>
                                    <div class="col-xs-4 col-sm-3 col-md-2 text-xs-center">
                                        <button type="button" class="btn btn-primary btn-outline btn-squared" data-toggle="modal" data-target=".safety-modal-pass">{$word.modify}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left media-middle"><i class="fa fa-envelope"></i></div>
                            <div class="media-body">
                                <div class="row m-x-0">
                                    <div class="col-xs-8 col-sm-9 col-md-10">
                                        <h4 class="media-heading">
                                            {$word.accemail}
                                            <span class="tag tag-outline tag-warning">{$_M['profile_safety']['emailtxt']}</span>
                                        </h4>
                                        {$word.accsaftips2}
                                    </div>
                                    <div class="col-xs-4 col-sm-3 col-md-2 text-xs-center">
                                        <button type="button" class="btn btn-primary btn-outline btn-squared btn-{$_M['profile_safety']['emailclass']}" {$_M['profile_safety']['disabled']} data-target=".safety-modal-{$_M['profile_safety']['emailclass']}" data-toggle="modal" data-mailedit="{$url.emailedit}" data-mailadd="{$url.profile_safety_emailadd}">{$_M['profile_safety']['emailbut']}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left media-middle"><i class="fa fa-mobile"></i></div>
                            <div class="media-body">
                                <div class="row m-x-0">
                                    <div class="col-xs-8 col-sm-9 col-md-10">
                                        <h4 class="media-heading">
                                            {$word.acctel}
                                            <span class="tag tag-outline tag-warning">{$_M['profile_safety']['teltxt']}</span>
                                        </h4>
                                        {$word.accsaftips3}
                                    </div>
                                    <div class="col-xs-4 col-sm-3 col-md-2 text-xs-center">
                                        <button type="button" class="btn btn-primary btn-outline btn-squared btn-{$_M['profile_safety']['telclass']}" data-target=".safety-modal-{$_M['profile_safety']['telclass']}" data-toggle="modal">{$_M['profile_safety']['telbut']}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--实名认证-->
                        <if value="$c['met_member_idvalidate'] eq 1">
                            <div class="media">
                                <div class="media-left media-middle"><i class="fa fa-user"></i></div>
                                <div class="media-body">
                                    <div class="row m-x-0">
                                        <div class="col-xs-8 col-sm-9 col-md-10">
                                            <h4 class="media-heading">
                                                {$word.rnvalidate}
                                                <span class="tag tag-outline tag-warning">{$_M['profile_safety']['idvalitxt']}</span>
                                            </h4>
                                            {$word.accsaftips4}
                                        </div>
                                        <div class="col-xs-4 col-sm-3 col-md-2 text-xs-center">
                                            <button type="button" class="btn btn-primary btn-outline btn-squared btn-{$_M['profile_safety']['idvaliclass']}" data-target=".safety-modal-{$_M['profile_safety']['idvaliclass']}" data-toggle="modal">{$_M['profile_safety']['idvalibut']}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </if>
                        <!--微信绑定-->
                        <if value="$c['met_weixin_open'] eq 1">
                            <div class="media">
                                <div class="media-left media-middle"><i class="fa fa-weixin"></i></div>
                                <div class="media-body">
                                    <div class="row m-x-0">
                                        <div class="col-xs-8 col-sm-9 col-md-10">
                                            <h4 class="media-heading">
                                                {$word.bindweixin}
                                                <span class="tag tag-outline tag-warning">{$_M['profile_safety']['weixintxt']}</span>
                                            </h4>
                                            {$word.accsaftips5}
                                        </div>
                                        <div class="col-xs-4 col-sm-3 col-md-2 text-xs-center">
                                            <button type="button" class="btn btn-primary btn-outline btn-squared btn-{$_M['profile_safety']['weixinclass']}"<if value="$_M['profile_safety']['weixinclass'] eq 'weixinadd'">data-target=".safety-modal-{$_M['profile_safety']['weixinclass']}" data-toggle="modal"</if>>{$_M['profile_safety']['weixinbut']}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </if>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade safety-modal-idvalview">
        <div class="modal-dialog modal-sm modal-center modal-primary">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">{$word.rnvalidate}</h4>
                </div>
                <div class="modal-body">
                    <div class="col-xs-8 col-sm-9 col-md-10">
                        <h4 class="media-heading">{$word.realname}：</h4>
                        {$_M['user']['realidinfo']['realname']}
                    </div>
                    <div class="form-group">
                        <div class="col-xs-8 col-sm-9 col-md-10">
                            <h4 class="media-heading">{$word.idcode}：</h4>
                            {$_M['user']['realidinfo']['idcode']}
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <div class="col-xs-8 col-sm-9 col-md-10">
                            <h4 class="media-heading">{$word.telnum}：</h4>
                            {$_M['user']['realidinfo']['phone']}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--修改密码-->
    <div class="modal fade safety-modal-pass">
        <div class="modal-dialog modal-sm modal-center modal-primary">
            <div class="modal-content">
                <form method="post" action="{$url.pass_save}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">{$word.modifypassword}</h4>
                    </div>
                    <div class="modal-body">
                        <!--社会化登陆账号不验证原密码-->
                        <if value="$data.user.source eq ''">
                            <div class="form-group">
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-unlock-alt"></i>
                                </span>
                                    <input type="password" name="oldpassword" class="form-control" placeholder="{$word.oldpassword}" required
                                           data-fv-notempty-message="{$word.noempty}"
                                    >
                                </div>
                            </div>
                        </if>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-unlock-alt"></i>
                                </span>
                                <input type="password" name="password" required class="form-control" placeholder="{$word.newpassword}"
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
                        <div class="form-group m-b-0">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-unlock-alt"></i>
                                </span>
                                <input type="password" name="confirmpassword" required data-password="password" class="form-control" placeholder="{$word.renewpassword}"
                                       data-fv-notempty-message="{$word.noempty}"
                                       data-fv-identical="true"
                                       data-fv-identical-field="password"
                                       data-fv-identical-message="{$word.passwordsame}"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-squared">{$word.confirm}</button>
                        <button type="button" class="btn btn-default btn-squared" data-dismiss="modal">{$word.cancel}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--邮箱绑定-->
    <div class="modal fade safety-modal-emailadd">
        <div class="modal-dialog modal-sm modal-center modal-primary">
            <div class="modal-content">
                <form method="post" action="{$url.profile_safety_emailadd}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">{$word.accemail}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group m-b-0">
                            <input type="email" name="email" required class="form-control" placeholder="{$word.emailaddress}"
                                   data-fv-notempty-message="{$word.noempty}"
                                   data-fv-emailAddress-message="{$word.emailvildtips3}"
                            >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-squared">{$word.confirm}</button>
                        <button type="button" class="btn btn-default btn-squared" data-dismiss="modal">{$word.cancel}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--手机号码绑定-->
    <div class="modal fade safety-modal-teladd">
        <div class="modal-dialog modal-sm modal-center modal-primary">
            <div class="modal-content">
                <form method="post" action="{$url.profile_safety_teladd}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">{$word.acctel}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" name="tel" required class="form-control" placeholder="{$word.telnum}"
                                   data-fv-notempty-message="{$word.noempty}"
                                   data-fv-remote="true"
                                   data-fv-remote-url="{$url.profile_safety_telok}"
                                   data-fv-remote-message="{$word.teluse}"
                                   data-fv-phone="true"
                                   data-fv-phone-message="{$word.telok}"
                            >
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-icon">
                                <span class="input-group-addon"><i class="fa fa-shield"></i></span>
                                <input type="text" name="code" required class="form-control" placeholder="{$word.memberImgCode}" data-fv-notempty-message="{$word.inputcode}">
                                <div class="input-group-addon p-5 user-code-img">
                                    <?php $random = random(4, 1); ?>
                                    <img src="{$url.entrance}?m=include&c=ajax_pin&a=dogetpin&random={$random}" title="{$word.memberTip1}" class='met-getcode' align="absmiddle" role="button">
                                    <input type="hidden" name="random" value="{$random}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-b-0">
                            <div class="input-group input-group-icon">
                                <input type="text" name="phonecode" required class="form-control" placeholder="{$word.memberImgCode}" data-fv-notempty-message="{$word.noempty}">
                                <div class="input-group-addon p-0">
                                    <button type="button" data-url="{$url.profile_safety_telvalid}" class="btn btn-success btn-squared w-full phone-code" data-retxt="{$word.resend}">
                                        {$word.getmemberImgCode}
                                        <span class="badge"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-squared">{$word.confirm}</button>
                        <button type="button" class="btn btn-default btn-squared" data-dismiss="modal">{$word.cancel}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- 手机号码修改 -->
    <div class="modal fade safety-modal-teledit">
        <div class="modal-dialog modal-sm modal-center modal-primary">
            <div class="modal-content">
                <form method="post" action="{$url.profile_safety_teledit}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">{$word.modifyacctel}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">{$_M['profile_safety']['teltxt']}</div>
                        <div class="form-group m-b-0">
                            <div class="input-group input-group-icon">
                                <input type="text" name="code" required class="form-control" placeholder="{$word.memberImgCode}" data-fv-notempty-message="{$word.noempty}">
                                <div class="input-group-addon p-0">
                                    <button type="button" data-url="{$url.profile_safety_teledit}" class="btn btn-success btn-squared w-full phone-code" data-retxt="{$word.resend}">
                                        {$word.getmemberImgCode}
                                        <span class="badge"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-squared">{$word.confirm}</button>
                        <button type="button" class="btn btn-default btn-squared" data-dismiss="modal">{$word.cancel}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--实名认证-->
    <div class="modal fade safety-modal-idvaliadd">
        <div class="modal-dialog modal-sm modal-center modal-primary">
            <div class="modal-content">
                <form method="post" action="{$url.profile_safety_idvalid}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">{$word.rnvalidate}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="input" name="realname" required class="form-control" placeholder="{$word.realname}" data-fv-notempty-message="{$word.noempty}">
                        </div>
                        <div class="form-group">
                            <input type="input" name="idcode" required class="form-control" placeholder="{$word.idcode}" data-fv-notempty-message="{$word.noempty}"
                            >
                        </div>
                        <div class="form-group">
                            <input type="tel" name="phone" required class="form-control" placeholder="{$word.telnum}" data-fv-notempty-message="{$word.noempty}">
                        </div>
                        <div class="form-group m-b-0">
                            <div class="input-group input-group-icon">
                                <span class="input-group-addon"><i class="fa fa-shield"></i></span>
                                <input type="text" name="code" required class="form-control" placeholder="{$word.memberImgCode}" data-fv-notempty-message="{$word.noempty}">
                                <div class="input-group-addon p-5 user-code-img">
                                    <?php $random = random(4, 1); ?>
                                    <img src="{$url.entrance}?m=include&c=ajax_pin&a=dogetpin&random={$random}" title="{$word.memberTip1}" class='met-getcode' align="absmiddle" role="button">
                                    <input type="hidden" name="random" value="{$random}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-squared">{$word.confirm}</button>
                        <button type="button" class="btn btn-default btn-squared" data-dismiss="modal">{$word.cancel}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <if value="$c['met_weixin_open'] eq 1">
    <div class="modal fade modal-primary safety-modal-weixinadd">
        <div class="modal-dialog modal-center modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">微信扫码绑定</h4>
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
</div>
<include file="sys_web/foot"/>