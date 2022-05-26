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
<form method="POST" action="{$url.own_name}c={$data.c}&a=dosaveinc&class1={$data.class1}&class2={$data.class2}&class3={$data.class3}&classnow={$data.list.classnow}" id="feedback-set-form-{$checkbox_time}" data-validate_order="#feedback-set-form-{$checkbox_time}" data-submit-ajax='1' enctype="multipart/form-data">
	<div class="metadmin-fmbx">
		<dl>
			<dt>
				<label class='form-control-label'>{$word.feedbacksubmit}{$word.marks}</label>
			</dt>
			<dd>
				<input type="checkbox" data-plugin="switchery" name="met_fd_ok" value='{$data.list.met_fd_ok}' hidden>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.fdincName}{$word.marks}</label>
			</dt>
			<dd>
				<input type="text" name="met_fdtable" value='{$data.list.met_fdtable}' class="form-control">
				<span class="text-help ml-2">{$word.feedbackexplain1}</span>
			</dd>
		</dl>
        <dl>
            <dt>
                <label class='form-control-label'>{$word.fdincTime}{$word.marks}</label>
            </dt>
            <dd>
                <input type="text" name="met_fd_time" value='{$data.list.met_fd_time}' class="form-control">
            </dd>
        </dl>
		<!--
		<dl>
			<dt>
				<label class='form-control-label'>{$word.fdincClassName}{$word.marks}</label>
			</dt>
			<dd>
				<select name='met_fd_class' data-checked='{$data.list.met_fd_class.val}' class="form-control w-a">
					<list data="$data['list']['met_fd_class']['options']" name="$v">
					<option value='{$v.val}'>{$v.name}</option>
					</list>
				</select>
				<span class="text-help ml-2">{$word.fdincTip6}</span>
			</dd>
		</dl>
		-->
		<dl>
			<dt>
				<label class='form-control-label'>{$word.listproductre}{$word.marks}</label>
			</dt>
			<dd>
				<select name='met_fd_related' data-checked='{$data.list.met_fd_related.val}' class="form-control w-a">
					<list data="$data['list']['met_fd_related']['options']" name="$v">
					<option value='{$v.val}'>{$v.name}</option>
					</list>
				</select>
				<span class="text-help ml-2">{$word.fdincTip13}</span>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.fdincTip12}{$word.marks}</label>
			</dt>
			<dd>
				<list data="$data['list']['met_fd_showcol']['options']" name="$v">
				<div class="custom-control custom-checkbox custom-control-inline">
					<input type="checkbox" id="met_fd_showcol{$v._index}-{$checkbox_time}" name='met_fd_showcol' value='{$v.id}'<if value="!$v['_index']">data-checked='{$data.list.met_fd_showcol.val}'</if>data-delimiter="|" class="custom-control-input"/>
					<label class="custom-control-label" for="met_fd_showcol{$v._index}-{$checkbox_time}">{$v.name}</label>
				</div>
				</list>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.feedbackinquiry}{$word.marks}</label>
			</dt>
			<dd>
				<input type="checkbox" data-plugin="switchery" name="met_fd_inquiry" value='{$data.list.met_fd_inquiry}' data-checked='1' hidden>
                <span class="text-help ml-2">{$word.feedbackinquiryinfo}</span>
			</dd>
		</dl>
		<?php
		$accepttype_title=$word['fdincAcceptType'];
		$met_fd_type_name='met_fd_type';
		$met_fd_type=$data['list'][$met_fd_type_name];
		$acceptmail_title=$word['fdincAcceptMail'];
		$met_fd_to_name='met_fd_to';
		$met_fd_to=$data['list'][$met_fd_to_name];
		$admin_tel_title=$word['fdincTip14'];
		$met_fd_admin_tel_name='met_fd_admin_tel';
		$met_fd_admin_tel=$data['list'][$met_fd_admin_tel_name];
		?>
		<include file="pub/form_module_set/reply"/>
	</div>
</form>