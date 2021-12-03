<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
// dump($data);
$html_class=$body_class='h-100';
$html_class.=' met-login';
$body_class.=' d-flex align-items-center justify-content-center';
$met_title=$word['getTip5'];
$login_logo_filemtime=filemtime(str_replace($url['site'], PATH_WEB, $data['met_agents_logo_login']));
?>
<include file="pub/header"/>
<div style="width: 400px;">
	<div class="text-center">
		<a href="{$data.met_agents_linkurl}" title="{$word.metinfo}" target="_blank">
			<img src="{$data.met_agents_logo_login}?{$login_logo_filemtime}" alt="{$word.metinfo}" width="200">
		</a>
	</div>
	<form action="{$data.url}&langset={$data.langset}" method="post" <if value="$data['abt_type'] eq 1 || $data['abt_type'] eq 2 || M_ACTION eq 'doCodeCheck'">data-submit-ajax="1"</if> class="met-getpassword-form mt-4">
		<div class="alert alert-warning mt-4 py-4">
			<p class="<if value="$data['admin_name']">text-success<else/>text-dark</if>">{$data.description}</p>
			<if value="($data['abt_type'] eq 1 || $data['abt_type'] eq 2) && !$data['admin_name']">
            <!-- 输入用户名、邮箱地址、手机号码 -->
			<input type="hidden" name="abt_type" value="{$data.abt_type}">
			<div class="form-group mb-0">
				<input type="text" name="admin_id" placeholder="{$data.title}" required class='form-control'>
			</div>
            <elseif value="M_ACTION eq 'doCodeCheck'"/>
            <!-- 输入验证码 -->
            <div class="form-group mb-0">
                <input type="text" name="code" placeholder="{$data.title}" required class='form-control'>
            </div>
			<elseif value="$data['admin_name']"/>
            <!-- 输入修改密码 -->
            <div class="row mb-2">
                <label class="col-form-label col-3 pr-0 text-right">{$word.password24}</label>
                <div class="col-9 col-form-label">{$data.admin_name}</div>
            </div>
            <div class="row">
                <label class="col-form-label col-3 pr-0 text-right">{$word.password25}</label>
                <div class="col-9 form-group">
                    <input type="password" name="password" required class='form-control'>
                </div>
            </div>
            <div class="row">
                <label class="col-form-label col-3 pr-0 text-right">{$word.password26}</label>
                <div class="col-9 form-group mb-0">
                    <input type="password" name="passwordsr" required data-fv-identical="true" data-fv-identical-field="password" class='form-control'>
                </div>
            </div>
			<else/>
            <!-- 选择验证修改密码方式 -->
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="abt_type1" name="abt_type" value='1' data-checked="2" class="custom-control-input" />
                <label class="custom-control-label" for="abt_type1">{$word.password27}</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="abt_type2" name="abt_type" value='2' class="custom-control-input" />
                <label class="custom-control-label" for="abt_type2">{$word.password29}</label>
		    </div>
			</if>
		</div>
		<div class="clearfix">
			<a href="{$url.site_admin}?lang={$_M['lang']}&langset={$_M['langset']}" title="{$word.password21}" class="float-left mt-2">{$word.password21}</a>
			<button type="submit" class="btn btn-primary px-4 float-right">{$word.password20}</button>
		</div>
	</form>
	<footer class="metadmin-foot text-grey text-center mt-5 pt-5">{$data.copyright}</footer>
</div>
<include file="pub/footer"/>