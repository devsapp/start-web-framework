<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$html_class=$body_class='h-100';
$html_class.=' met-login';
$body_class.=' d-flex align-items-center justify-content-center';
$met_title=$word['logintitle'];
$login_logo_filemtime=filemtime(str_replace($url['site'], PATH_WEB, $data['met_agents_logo_login']));

$basic_admin_css_filemtime = filemtime(PATH_PUBLIC_ADMIN.'css/basic_admin.css');
$met_title.='-'.$word['metinfo'];
$synchronous=$_M['langlist']['admin'][$_M['langset']]['synchronous'];
$favicon_filemtime = filemtime(PATH_WEB."favicon.ico");
?>
<!DOCTYPE HTML>
<html class="{$html_class}">
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit">
<meta name="robots" content="noindex,nofllow">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0,minimal-ui">
<meta name="format-detection" content="telephone=no">
<title>{$met_title}</title>
<meta name="generator" content="MetInfo {$c.metcms_v}" data-variable="{$url.site}|{$_M['lang']}|{$synchronous}|{$c.met_skin_user}||||">
<link href="{$url.site}favicon.ico?{$favicon_filemtime}" rel="shortcut icon" type="image/x-icon">
<link href="{$url.public_admin}css/basic_admin.css?{$basic_admin_css_filemtime}" rel='stylesheet' type='text/css'>
</head>
<body class="{$body_class}">
<div>
    <style>.met-ie-tips a{color: #fff;}</style>
    <div class="text-center mb-0 bg-danger alert hide mb-3 met-ie-tips">
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">×</span>
        </button>
        你正在使用一个 <strong>过时</strong> 的浏览器。请 <a href='https://browsehappy.com/' target=_blank>升级您的浏览器</a>，以提高您的体验。
    </div>
    <div class="d-flex text-left align-items-center">
        <a href="{$data.met_agents_linkurl}" title="{$word.metinfo}" target="_blank">
            <img src="{$data.met_agents_logo_login}?{$login_logo_filemtime}" alt="{$word.metinfo}" width="200">
        </a>
        <form action="{$url.own_form}a=dologin" class="border-left pl-2 ml-4 met-login-form" style="border-color: #eee !important;" data-submit-ajax="1">
            <div class="row mb-4">
                <label class="col-form-label" style="width: 100px;"></label>
                <div class="mb-3">
                    <h1 class="h5">{$word.loginadmin}</h1>
                </div>
            </div>
            <if value="$c['met_admin_type_ok']">
                <div class="row">
                    <label class="col-form-label pr-3 text-right" style="width: 100px;">{$word.loginlanguage}</label>
                    <div class="form-group mb-4">
                        <select name="langset" data-checked="{$data.langset}" class="form-control" onchange="javascript:location.href=M.url.admin+'?langset='+this.value">
                            <list data="$data['met_langadmin']" name="$v">
                                <option value="{$v.mark}">{$v.name}</option>
                            </list>
                        </select>
                    </div>
                </div>
            </if>
            <div class="row">
                <label class="col-form-label pr-3 text-right" style="width: 100px;">{$word.loginusename}</label>
                <div class="form-group mb-4">
                    <input type="text" name="login_name" data-safety required class="form-control" style="width: 200px;">
                </div>
            </div>
            <div class="row">
                <label class="col-form-label pr-3 text-right" style="width: 100px;">{$word.loginpassword}</label>
                <div class="form-group mb-4">
                    <input type="password" name="login_pass" data-safety required class="form-control" style="width: 200px;">
                </div>
            </div>
            <if value="$c['met_login_code']">
                <?php $random = random(4, 1); ?>
                <div class="row">
                    <label class="col-form-label pr-3 text-right" style="width: 100px;">{$word.logincode}</label>
                    <div class="form-group mb-4">
                        <div class="input-group" style="width: 200px;">
                            <input name='code' type='text' class='form-control' placeholder='{$word.memberImgCode}' required>
                            <div class="input-group-append">
                                <div class="input-group-text py-0 px-1">
                                    <img src='{$url.entrance}?m=include&c=ajax_pin&a=dogetpin&random={$random}' title='{$word.memberTip1}' align='absmiddle' role='button' class="met-getcode">
                                    <input type="hidden" name="random" value="{$random}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </if>
            <div class="row">
                <label class="col-form-label" style="width: 100px;"></label>
                <div class="">
                    <button type="submit" class="btn btn-primary px-4">{$word.loginconfirm}</button>
                    <a href="{$url.get_pass}" class="ml-3">{$word.loginforget}</a>
                </div>
            </div>
        </form>
    </div>
    <footer class="metadmin-foot text-grey text-center mt-5 pt-5">{$data.copyright}</footer>
</div>
<?php
$basic_admin_js_time = filemtime(PATH_PUBLIC_ADMIN.'js/basic_admin.js');
$lang_json_admin_js_time = filemtime(PATH_WEB.'cache/lang_json_admin_'.$_M['lang'].'.js');
?>
</body>
<script>window.MET={$data.met_para};</script>
<script src="{$url.public_admin}js/basic_admin.js?{$basic_admin_js_time}"></script>
<script src="{$url.site}cache/lang_json_admin_{$_M['langset']}.js?{$lang_json_admin_js_time}"></script>
<script>(function(){M.is_ie&&$('.met-ie-tips').removeClass('hide');})();</script>
</html>