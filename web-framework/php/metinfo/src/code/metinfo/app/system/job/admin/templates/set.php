<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
if($data['handle']){
	$data=array_merge($data,$data['handle']);
	unset($data['handle']);
}
$checkbox_time=time();
?>
<form method="POST" action="{$url.own_name}c={$data.c}&a=dosaveinc&class1={$data.class1}&class2={$data.class2}&class3={$data.class3}&classnow={$data.list.classnow}" id="job-set-form" data-validate_order="#job-set-form" data-submit-ajax='1' enctype="multipart/form-data">
	<div class="metadmin-fmbx">
		<dl>
			<dt>
				<label class='form-control-label'>{$word.fdincTime}{$word.marks}</label>
			</dt>
			<dd>
				<input type="text" name="met_cv_time" value='{$data.list.met_cv_time}' class="form-control">
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.jobtip8}{$word.marks}</label>
			</dt>
			<dd>
				<select name='met_cv_image' data-checked='{$data.list.met_cv_image.val}' class="form-control w-a">
					<list data="$data['list']['met_cv_image']['options']" name="$v">
					<option value='{$v.val}'>{$v.name}</option>
					</list>
				</select>
				<span class="text-help ml-2">{$word.jobtip9}</span>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.fdincTip12}{$word.marks}</label>
			</dt>
			<dd>
				<list data="$data['list']['met_cv_showcol']['options']" name="$v">
				<div class="custom-control custom-checkbox custom-control-inline">
					<input type="checkbox" id="met_cv_showcol{$v._index}" name='met_cv_showcol' value='{$v.id}'<if value="!$v['_index']">data-checked='{$data.list.met_cv_showcol.val}'</if>data-delimiter="|" class="custom-control-input"/>
					<label class="custom-control-label" for="met_cv_showcol{$v._index}">{$v.name}</label>
				</div>
				</list>
			</dd>
		</dl>
        <?php
		$accepttype_title=$word['cvincAcceptType'];
		$met_fd_type_name='met_cv_type';
		$met_fd_type=$data['list'][$met_fd_type_name];
		$acceptmail_title=$word['cvincAcceptMail'];
		$met_fd_to_name='met_cv_to';
		$met_fd_to=$data['list'][$met_fd_to_name];
		$admin_tel_title=$word['fdincTip14'];
		$met_fd_admin_tel_name='met_cv_job_tel';
		$met_fd_admin_tel=$data['list'][$met_fd_admin_tel_name];
		?>
		<include file="pub/form_module_set/reply"/>
	</div>
</form>