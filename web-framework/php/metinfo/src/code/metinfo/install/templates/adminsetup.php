<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
echo <<<EOT
-->
<div class="p-4 border">
	<p>请设置网站后台管理员帐号，该管理员帐号拥有最高管理权限且不能被删除。</p>
	<form method="post">
		<input name="setup" type="hidden" value="1">
		<input name="cndata" type="hidden" value="$cndata">
		<input name="endata" type="hidden" value="$endata">
		<input name="showdata" type="hidden" value="$showdata">
		<input name="met_index_type" type="hidden" value="$met_index_type">
		<input name="met_admin_type" type="hidden" value="$met_admin_type">
		<fieldset class="border pb-3 px-3">
			<legend class="h6 text-primary w-auto px-1"><strong>管理员信息</strong></legend>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label text-right">管理员用户名</label>
				<div class="col-sm-8">
					<input type="text" name="regname" class="form-control w-auto d-inline-block">
					<span class="text-muted ml-1">系统创始人管理员帐号,建议不要使用admin</span>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label text-right">管理员密码</label>
				<div class="col-sm-8">
					<input type="password" name="regpwd" class="form-control w-auto d-inline-block">
					<span class="text-muted ml-1">输入系统管理员帐号的密码</span>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label text-right">确认管理员密码</label>
				<div class="col-sm-8">
					<input type="password" name="aginpwd" class="form-control w-auto d-inline-block">
					<span class="text-muted ml-1">确认系统管理员帐号的密码</span>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label text-right">手机号码</label>
				<div class="col-sm-8">
					<input type="text" name="tel" class="form-control w-auto d-inline-block">
					<span class="text-muted ml-1">网站后台启用短信功能后可用于密码找回</span>
				</div>
			</div>
			<div class="row">
				<label class="col-sm-4 col-form-label text-right">电子邮件</label>
				<div class="col-sm-8">
					<input type="text" name="email" class="form-control w-auto d-inline-block align-top">
					<span class="text-muted ml-1 d-inline-block align-top" style="width:calc(100% - 190px)">网站后台配置好邮件发送功能后，可用于忘记密码时找回密码</span>
				</div>
			</div>
		</fieldset>
<!--
EOT;
if($langnum==2){
if(($cndata=='yes'&&$endata!=='yes'&&$tcdata!=='yes')||($cndata=='yes'&&($endata=='yes'||$tcdata=='yes'))){
	$lang_cn='checked';
}
if(($endata=='yes'&&$cndata!=='yes'&&$tcdata!=='yes')||($cndata!='yes'&&$endata=='yes'&&$tcdata=='yes')){
	$lang_en='checked';
}

echo <<<EOT
-->
		<fieldset class="border pb-3 px-3 mt-3">
			<legend class="h6 text-primary w-auto px-1"><strong>网站默认语言</strong></legend>
			<div style="padding-top: 5px;">
<!--
EOT;
if($cndata=='yes'){
echo <<<EOT
-->
				<div class="custom-control custom-radio custom-control-inline">
					<input type="radio" id="lang_index_type_cn" name='lang_index_type' value='cn' {$lang_cn} class="custom-control-input">
					<label class="custom-control-label" for="lang_index_type_cn">中文</label>
				</div>
<!--
EOT;
}
if($endata=='yes'){
echo <<<EOT
-->
				<div class="custom-control custom-radio custom-control-inline">
					<input type="radio" id="lang_index_type_en" name='lang_index_type' value='en' {$lang_en} class="custom-control-input">
					<label class="custom-control-label" for="lang_index_type_en">英文</label>
				</div>
<!--
EOT;
}
if($tcdata=='yes'){
echo <<<EOT
-->
				<div class="custom-control custom-radio custom-control-inline">
					<input type="radio" id="lang_index_type_tc" name='lang_index_type' value='tc' {$lang_tc} class="custom-control-input">
					<label class="custom-control-label" for="lang_index_type_tc">繁体中文</label>
				</div>
<!--
EOT;
}
echo <<<EOT
-->
			</div>
		</fieldset>
<!--
EOT;
}
if($cndata=='yes'){
echo <<<EOT
-->
		<fieldset class="border pb-3 px-3 mt-3">
			<legend class="h6 text-primary w-auto px-1"><strong>网站基本信息（中文）</strong></legend>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label text-right">网站名称</label>
				<div class="col-sm-8">
					<input type="text" name="webname_cn" value="网站名称" class="form-control w-auto d-inline-block">
					<span class="text-muted ml-1">输入网站名称</span>
				</div>
			</div>
			<div class="row">
				<label class="col-sm-4 col-form-label text-right">网站关键词</label>
				<div class="col-sm-8">
					<input type="text" name="webkeywords_cn" value="网站关键词" class="form-control w-auto d-inline-block">
					<span class="text-muted ml-1">多个关键词请用逗号','隔开，建议3到4个关键词</span>
				</div>
			</div>
		</fieldset>
<!--
EOT;
}
if($endata=='yes'){
echo <<<EOT
-->
		<fieldset class="border pb-3 px-3 mt-3">
			<legend class="h6 text-primary w-auto px-1"><strong>网站基本信息（英文）</strong></legend>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label text-right">网站名称</label>
				<div class="col-sm-8">
					<input type="text" name="webname_en" value="Website Name" class="form-control w-auto d-inline-block">
					<span class="text-muted ml-1">输入网站名称</span>
				</div>
			</div>
			<div class="row">
				<label class="col-sm-4 col-form-label text-right">网站关键词</label>
				<div class="col-sm-8">
					<input type="text" name="webkeywords_en" value="Website Keywords" class="form-control w-auto d-inline-block">
					<span class="text-muted ml-1">多个关键词请用逗号','隔开，建议3到4个关键词</span>
				</div>
			</div>
		</fieldset>
<!--
EOT;
}
echo <<<EOT
-->
<!--
EOT;

if($tcdata=='yes'){
echo <<<EOT
-->
		<fieldset class="border pb-3 px-3 mt-3">
			<legend class="h6 text-primary w-auto px-1"><strong>网站基本信息（中文繁体）</strong></legend>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label text-right">网站名称</label>
				<div class="col-sm-8">
					<input type="text" name="webname_tc" value="網站名稱" class="form-control w-auto d-inline-block">
					<span class="text-muted ml-1">输入网站名称</span>
				</div>
			</div>
			<div class="row">
				<label class="col-sm-4 col-form-label text-right">网站关键词</label>
				<div class="col-sm-8">
					<input type="text" name="webkeywords_tc" value="網站關鍵詞" class="form-control w-auto d-inline-block">
					<span class="text-muted ml-1">多个关键词请用逗号','隔开，建议3到4个关键词</span>
				</div>
			</div>
		</fieldset>
<!--
EOT;
}
echo <<<EOT
-->
		<button type="submit" id="formsubmit" onClick="return adminsubmit()" hidden></button>
	</form>
</div>
<div class="text-center mt-3">
	<button type="submit" class="btn btn-success btn-lg" onClick="formsubmit.click()">保存管理设置</button>
</div>
<script language="javascript">
setTimeout(function(){
	jQuery.myPlugin={Client:function(){var a={ie:0,webkit:0,gecko:0,opera:0,khtml:0};var b={se360:0,se:0,maxthon:0,qq:0,tt:0,theworld:0,cometbrowser:0,greenbrowser:0,ie:0,chrome:0,netscape:0,firefox:0,opera:0,safari:0,konq:0};var c=navigator.userAgent.toLowerCase();for(var d in a){if(typeof d==='string'){var e='gecko'===d?/rv:([\w.]+)/:RegExp(d+'[ \\/]([\\w.]+)');if(e.test(c)){a.version=window.opera?window.opera.version():RegExp.$1;a[d]=parseFloat(a.version);a.type=d;break}}};for(var d in b){if(typeof d==='string'){var e=null;switch(d){case'se360':e=/360se(?:[ \/]([\w.]+))?/;break;case'se':e=/se ([\w.]+)/;break;case'qq':e=/qqbrowser\/([\w.]+)/;break;case'tt':e=/tencenttraveler ([\w.]+)/;break;case'safari':e=/version\/([\w.]+)/;break;case'konq':e=/konqueror\/([\w.]+)/;break;case'netscape':e=/navigator\/([\w.]+)/;break;default:e=RegExp(d+'(?:[ \\/]([\\w.]+))?')};if(e.test(c)){b.metversion=window.opera?window.opera.version():RegExp.$1?RegExp.$1:'';b[d]=parseFloat(b.metversion);b.type=d;break}}};return{engine:a,metshell:b}}};
	function broversion(){
		var bro=jQuery.myPlugin.Client();
			t=bro.metshell.type;
			v=bro.metshell.metversion;
			//bro=t=='ie'?t+v:t;
			if(t=='ie'&&v==''){
				e=/ie(?:[ \\/]([\\w.]+))?/;
				v=e.exec(navigator.userAgent.toLowerCase())[1];
			}
			bro=t=='ie'?t+v:t;
			if(typeof window.external !='undefined' && typeof window.external.twGetRunPath!='unknown'&& typeof window.external.twGetRunPath!='undefined'){
				var r=external.twGetRunPath();
				if(r&&r.toLowerCase().indexOf('360se')> -1) bro='se360';
			}
			if(t=='ie'&&typeof external.addChannel=='undefined'){
				bro='se360';
			}
		return bro;
	}
	function emailtest(email){
		var x = /^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
		return x.test(email);
	}
	window.METLANG={};
	$('body').append('<script src="{$url_public}plugins/alertify/alertify.min.js" type="text/javascript"><\/script>');
	$('head').append('<link rel="stylesheet" href="{$url_public}plugins/alertify/alertify.min.css">');
	window.adminsubmit=function(){
		var bro=broversion();
		$("input[name='se360']").val(bro);
		var regname=$("input[name='regname']");
		var regpwd=$("input[name='regpwd']");
		var aginpwd=$("input[name='aginpwd']");
		var email=$("input[name='email']");
		if(regname.val()==''){
			alertify.error('管理员帐号不能为空');regname.focus();
			return false;
		}else if(regpwd.val()==''){
			alertify.error('管理员密码不能为空');regpwd.focus();
			return false;
		}else if(aginpwd.val()==''){
			alertify.error('请再次填写管理员密码');aginpwd.focus();
			return false;
		}else if(aginpwd.val()!=regpwd.val()){
			alertify.error('两次输入的密码不一致！');aginpwd.focus();
			return false;
		}/*else if(email.val()==''){
			alertify.error('请填写管理员邮箱地址！');email.focus();
			return false;
		}else if(!emailtest(email.val())){
			alertify.error('邮箱地址无效，请正确填写！');email.focus();
			return false;
		}*/
		return true;
	};
	setTimeout(function(){
		$("input[name='regpwd'],input[name='aginpwd']").change(function(){
			var regpwd_val=$('input[name="regpwd"]').val(),
				aginpwd_val=$('input[name="aginpwd"]').val();
			regpwd_val!=aginpwd_val && regpwd_val!='' && aginpwd_val!='' && ($(this).focus(),alertify.error('两次输入的密码不一致！'));
		});
	},1000);
},500);
</script>
<!--
EOT;
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>