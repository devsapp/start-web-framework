<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
if($data['handle']){
	$data=array_merge($data,$data['handle']);
	unset($data['handle']);
}
$checkbox_time=time();
switch ($data['module']) {
	case 2:
		$data['module_name']='news';
		break;
	case 3:
		$data['module_name']='product';
		break;
	case 4:
		$data['module_name']='download';
		break;
	case 5:
		$data['module_name']='img';
		$data['module_img']='imgs';
		break;
	case 6:
		$data['module_name']='job';
		break;
	case 7:
		$data['module_name']='message';
		break;
}
$data['module_page']=$c['met_'.$data['module_name'].'_page'];
$data['tab_name']=explode('|', $data['tab_name']);
$data['tab_name_default']=explode('|', $data['tab_name_default']);
$data['thumb_list']=explode('|', $data['thumb_list']);
$data['thumb_list_default']=explode('|', $data['thumb_list_default']);
$data['thumb_detail']=explode('|', $data['thumb_detail']);
$data['thumb_detail_default']=explode('|', $data['thumb_detail_default']);
if(!$data['module_img']){
	$data['module_img']=$data['module_name'].'img';
}
$data['module_img_x']=$c['met_'.$data['module_img'].'_x'];
$data['module_img_y']=$c['met_'.$data['module_img'].'_y'];
$data['module_imgdetail_x']=$c['met_'.$data['module_name'].'detail_x'];
$data['module_imgdetail_y']=$c['met_'.$data['module_name'].'detail_y'];
?>
<form action="{$url.own_name}c=index&a=doset_page_config&classnow={$data.classnow}&id={$data.id}" data-submit-ajax="1">
	<div class="metadmin-fmbx">
		<if value="$data['id']">
		<if value="$data['module'] eq 3 || $data['module'] eq 5">
		<dl>
			<dd>
				<span class="text-help">{$word.thumb_seting_tips}</span>
			</dd>
		</dl>
		</if>
		<else/>
		<if value="$data['from']"><div hidden></if>
		<if value="$data['module'] eq 2 || $data['module'] eq 3 || $data['module'] eq 5">
		<dl>
			<dt>
				<label class='form-control-label'>{$word.thumb_size_list}</label>
			</dt>
			<dd class="form-group">
				<input type="text" name="thumb_list_x" value="{$data.thumb_list.0}" placeholder="{$word.default_values}{$word.marks}{$data.thumb_list_default.0}" class="form-control w-a">
				<span class="float-left text-help text-muted mx-2">x</span>
				<input type="text" name="thumb_list_y" value="{$data.thumb_list.1}" placeholder="{$word.default_values}{$word.marks}{$data.thumb_list_default.1}" class="form-control w-a">
				<span class="text-help ml-2">{$word.setimgWidth}x{$word.setimgHeight}({$word.setimgPixel})</span>
			</dd>
		</dl>
		<if value="$data['module'] eq 3 || $data['module'] eq 5">
		<dl>
			<dt>
				<label class='form-control-label'>{$word.thumb_size_showpage}</label>
			</dt>
			<dd class="form-group">
				<input type="text" name="thumb_detail_x" value="{$data.thumb_detail.0}" placeholder="{$word.default_values}{$word.marks}{$data.thumb_detail_default.0}" class="form-control w-a">
				<span class="float-left text-help text-muted mx-2">x</span>
				<input type="text" name="thumb_detail_y" value="{$data.thumb_detail.1}" placeholder="{$word.default_values}{$word.marks}{$data.thumb_detail_default.1}" class="form-control w-a">
				<span class="text-help ml-2">{$word.setimgWidth}x{$word.setimgHeight}({$word.setimgPixel})</span>
			</dd>
		</dl>
		</if>
		</if>
		<if value="($data['module'] egt 2 && $data['module'] elt 7) || $data['module'] eq 11">
		<dl>
			<dt>
				<label class='form-control-label'>{$word.unitytxt_42}</label>
			</dt>
			<dd class="form-group">
				<input type="text" name="list_length" value="{$data.list_length}" placeholder="{$word.default_values}{$word.marks}{$data.list_length_default}" class="form-control w-a">
			</dd>
		</dl>
		</if>
		<if value="$data['module'] eq 3 || $data['module'] eq 5">
		<dl>
			<dt>
				<label class='form-control-label'>{$word.setskinListPage}</label>
			</dt>
			<dd class="form-group">
				<div class="custom-control custom-radio">
					<input type="radio" id="met_{$data.module_name}_page0-{$checkbox_time}" name='met_{$data.module_name}_page' value='0' data-checked='{$data.module_page}' required class="custom-control-input"/>
					<label class="custom-control-label" for="met_{$data.module_name}_page0-{$checkbox_time}">{$word.setskinproduct1}</label>
				</div>
				<div class="custom-control custom-radio">
					<input type="radio" id="met_{$data.module_name}_page1-{$checkbox_time}" name='met_{$data.module_name}_page' value='1' class="custom-control-input"/>
					<label class="custom-control-label" for="met_{$data.module_name}_page1-{$checkbox_time}">{$word.setskinproduct2}</label>
				</div>
				<span class="text-help ml-2">{$word.sys_navigation2}</span>
			</dd>
		</dl>
		</if>
		<if value="$data['from']"></div></if>
		<if value="$data['module'] eq 3">
		<dl>
			<dt>
				<label class='form-control-label'>{$word.display_number}</label>
			</dt>
			<dd class="form-group">
				<select name="tab_num" data-checked="{$data.tab_num}" class="form-control w-a">
					<option value="0">{$word.default_values}{$word.marks}{$data.tab_num_default}</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
				<span class="text-help ml-2">{$word.corresponding_products}</span>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.tab_title1}</label>
			</dt>
			<dd class="form-group">
				<input type="text" name="tab_name_0" value="{$data.tab_name.0}" placeholder="{$word.default_values}{$word.marks}{$data.tab_name_default.0}" class="form-control">
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.tab_title2}</label>
			</dt>
			<dd class="form-group">
				<input type="text" name="tab_name_1" value="{$data.tab_name.1}" placeholder="{$word.default_values}{$word.marks}{$data.tab_name_default.1}" class="form-control">
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.tab_title3}</label>
			</dt>
			<dd class="form-group">
				<input type="text" name="tab_name_2" value="{$data.tab_name.2}" placeholder="{$word.default_values}{$word.marks}{$data.tab_name_default.2}" class="form-control">
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.tab_title4}</label>
			</dt>
			<dd class="form-group">
				<input type="text" name="tab_name_3" value="{$data.tab_name.3}" placeholder="{$word.default_values}{$word.marks}{$data.tab_name_default.3}" class="form-control">
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.tab_title5}</label>
			</dt>
			<dd class="form-group">
				<input type="text" name="tab_name_4" value="{$data.tab_name.4}" placeholder="{$word.default_values}{$word.marks}{$data.tab_name_default.4}" class="form-control">
			</dd>
		</dl>
		</if>
		</if>
		<if value="(($data['module'] eq 2 || $data['module'] eq 4) && $data['id'])||(($data['module'] lt 2 || $data['module'] gt 7) && $data['module'] neq 11)">
		<dl><dd class="text-danger">{$word.uisetTips3}</dd></dl>
		</if>
	</div>
</form>