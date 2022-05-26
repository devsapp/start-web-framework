<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
echo <<<EOT
-->
<link href="../public/fonts/font-awesome/font-awesome.min.css" rel='stylesheet' type='text/css'>
<div class="p-4 border">
	<p>检查你的数据库设置情况，请在相应栏目仔细输入配置内容。</p>
	<form method="post">
		<input name="setup" type="hidden" value="1">
		<input name="db_type" type="hidden" value="mysql">
		<fieldset class="border pb-3 px-3">
			<legend class="h6 text-primary w-auto px-1"><strong>数据库信息</strong></legend>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label text-right">数据表前缀</label>
				<div class="col-sm-8">
					<input type="text" name="db_prefix" value="met_" required class="form-control w-auto d-inline-block">
					<span class="text-muted ml-1">例如：met_ 请不要留空，且使用“_”结尾</span>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label text-right">数据库连接地址</label>
				<div class="col-sm-8">
					<input type="text" name="db_host" value="localhost" required class="form-control w-auto d-inline-block align-top">
					<span class="text-muted ml-1 d-inline-block align-top" style="width:calc(100% - 190px)">一般不需要更改，参考主机或服务器MYSQL控制面板</span>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label text-right">数据库名</label>
				<div class="col-sm-8">
					<input type="text" name="db_name" required class="form-control w-auto d-inline-block">
					<span class="text-muted ml-1">例如'met'或'my_met',请确保用字母开头</span>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label text-right">数据库用户名</label>
				<div class="col-sm-8">
					<input type="text" name="db_username" value="root" required class="form-control w-auto d-inline-block">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label text-right">数据库密码</label>
				<div class="col-sm-8">
					<input type="password" name="db_pass" class="form-control w-auto d-inline-block">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label text-right">前台语言</label>
				<div class="col-sm-8" style="padding-top: 5px;">
					<div class="custom-control custom-checkbox custom-control-inline">
						<input type="checkbox" id="cndata" name='cndata' value='yes' checked class="custom-control-input">
						<label class="custom-control-label" for="cndata">安装中文语言包</label>
					</div>
					<div class="custom-control custom-checkbox custom-control-inline">
						<input type="checkbox" id="endata" name='endata' value='yes' checked class="custom-control-input">
						<label class="custom-control-label" for="endata">安装英文语言包</label>
					</div>
					<div class="custom-control custom-checkbox custom-control-inline">
						<input type="checkbox" id="showdata" name='showdata' value='yes' checked class="custom-control-input">
						<label class="custom-control-label" for="showdata">安装官方演示数据</label>
					</div>
				</div>
			</div>
			<div class="row">
				<label class="col-sm-4 col-form-label text-right">后台语言</label>
				<div class="col-sm-8" style="padding-top: 5px;">
					<div class="custom-control custom-checkbox custom-control-inline">
						<input type="checkbox" id="admin_cndata" name='admin_cndata' value='yes' checked class="custom-control-input">
						<label class="custom-control-label" for="admin_cndata">安装中文语言包</label>
					</div>
					<div class="custom-control custom-checkbox custom-control-inline">
						<input type="checkbox" id="admin_endata" name='admin_endata' value='yes' checked class="custom-control-input">
						<label class="custom-control-label" for="admin_endata">安装英文语言包</label>
					</div>
				</div>
			</div>
		</fieldset>
		<button type="submit" id="formsubmit" onClick="formSubmit()" hidden></button>
	</form>
</div>
<div class="text-center mt-3">
	<button type="submit" class="btn btn-success btn-lg btn-nextprocess" onClick="formsubmit.click()">保存数据库设置并继续</button>
</div>
<script language="javascript">
setTimeout(function(){
	window.formValidate=function(){
		return $('[name="db_prefix"]').val()!='' && $('[name="db_host"]').val()!='' && $('[name="db_name"]').val()!='' && $('[name="db_username"]').val()!='';
	};
	$('form input.form-control').on('change input',function(){
		formValidate()?$('.btn-nextprocess').removeClass('disabled'):$('.btn-nextprocess').addClass('disabled');
	});
	window.formSubmit=function(e){
		if($('.btn-nextprocess').hasClass('disabled')) return false;
		if(formValidate()){
			$('.btn-nextprocess').addClass('disabled').append(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		}else{
			$('.btn-nextprocess').removeClass('disabled');
		}
	};
},500);
</script>
<!--
EOT;
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>