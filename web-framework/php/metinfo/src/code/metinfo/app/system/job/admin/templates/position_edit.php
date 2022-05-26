<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
if($data['handle']){
	$data=array_merge($data,$data['handle']);
	unset($data['handle']);
}
$data['page_type']=$data['a']=='doeditor'?'details':'add';
?>
<form method="POST" action="{$url.own_name}c={$data.c}&a={$data.a}save&id={$data.list.id}&no_order={$data.list.no_order}&addtype=2" class='job-{$data.page_type}-form' data-validate_order=".job-{$data.page_type}-form" data-submit-ajax='1' enctype="multipart/form-data">
	<div class="metadmin-fmbx">
		<dl>
			<dt>
				<label class='form-control-label'>
					<span class="text-danger">*</span>
					{$word.category}
				</label>
			</dt>
			<dd>
				<div class='form-group clearfix'>
					<?php
					!$data['list']['class1'] && $data['list']['class1']='';
					!$data['list']['class2'] && $data['list']['class2']='';
					!$data['list']['class3'] && $data['list']['class3']='';
					?>
					<div data-plugin='select-linkage' data-select-url="json" data-required="1" data-value_key="value" class="clearfix float-left mr-3 content-details-column">
						<textarea class="select-linkage-data" hidden>{$data.columnlist_json}</textarea>
						<select name="class1" class="form-control mr-1 w-a prov" data-checked="{$data.list.class1}" required data-fv-notEmpty-message="{$word.selectcolumn}"></select>
						<select name="class2" class="form-control mr-1 w-a city" data-checked="{$data.list.class2}" required data-fv-notEmpty-message="{$word.selectcolumn}"></select>
						<select name="class3" class="form-control mr-1 w-a dist" data-checked="{$data.list.class3}" required data-fv-notEmpty-message="{$word.selectcolumn}"></select>
					</div>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.jobposition}{$word.marks}</label>
			</dt>
			<dd>
				<div class="form-group">
					<input type="text" name="position" value='{$data.list.position}' required class="form-control">
				</div>
				<div>
					<span class="text-help text-content float-left">{$word.font_size}{$word.marks}</span>
					<input type="text" name="text_size" value="{$data.list.text_size}" data-plugin="select-fontsize" class="form-control d-inline-block mr-2" style="width:100px;">
					<span class="text-help text-content float-left">{$word.text_color}{$word.marks}</span>
					<input type="text" name="text_color" value="{$data.list.text_color}" data-plugin="minicolors" class="form-control w-a d-inline-block">
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.jobaddress}{$word.marks}</label>
			</dt>
			<dd>
				<input type="text" name="place" value='{$data.list.place}' class="form-control">
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.jobdeal}{$word.marks}</label>
			</dt>
			<dd>
				<input type="text" name="deal" value='{$data.list.deal}' class="form-control">
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.jobnum}{$word.marks}</label>
			</dt>
			<dd>
				<input type="text" name="count" value='{$data.list.count}' class="form-control">
				<span class="text-help ml-2">{$word.jobtip1}</span>
			</dd>
		</dl>
		<if value="$data['met_cv_emtype']">
		<dl>
			<dt>
				<label class='form-control-label'>{$word.cvemail}{$word.marks}</label>
			</dt>
			<dd>
				<input type="text" name="email" value='{$data.list.email}' class="form-control">
				<span class="text-help ml-2">{$word.jobtip5} {$word.fdincTip9}</span>
			</dd>
		</dl>
		</if>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.joblife}{$word.marks}</label>
			</dt>
			<dd>
				<input type="text" name="useful_life" value='{$data.list.useful_life}' class="form-control">
				<span class="text-help ml-2">{$word.jobtip3}</span>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.jobpublish}{$word.marks}</label>
			</dt>
			<dd>
				<input type="text" name="addtime" value='{$data.list.addtime}' class="form-control w-a" data-plugin='datetimepicker'>
				<span class="text-help ml-2">{$word.jobnow} {$data.now_time} {$word.jobtip2}</span>
			</dd>
		</dl>
        <dl>
			<dt>
				<label class='form-control-label'>{$word.updatetime}{$word.marks}</label>
			</dt>
            <dd>
                <input type="text" name="updatetime" value='{$data.list.updatetime}' class="form-control w-a" data-plugin='datetimepicker'>
            </dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.columnhtmlname}{$word.marks}</label>
			</dt>
			<dd class="form-group">
				<input type="text" name="filename" value='{$data.list.filename}' class="form-control" data-fv-remote="true" data-fv-remote-url="{$url.own_name}c={$data.c}&a=docheck_filename&id={$data.list.id}">
				<span class="text-help ml-2">{$word.columntip14}</span>
			</dd>
		</dl>
		<include file="pub/content_details/editor"/>
		<h3 class='example-title'>{$word.unitytxt_33}</h3>
		<if value="$c['met_member_use']">
		<?php
		$webaccess=array(
			'value'=>$data['list']['access'],
			'access'=>$data['access_option'],
			'marks'=>$word['marks']
		);
		?>
		<include file="pub/content_details/webaccess"/>
		</if>
		<?php $displaytype['marks']=$word['marks']; ?>
		<include file="pub/content_details/displaytype"/>
	</div>
</form>