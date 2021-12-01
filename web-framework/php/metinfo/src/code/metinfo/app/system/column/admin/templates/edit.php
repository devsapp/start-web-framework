<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$data=$data['handle'];
$checkbox_time=time();
$data['list']['thumb_list']=explode('|', $data['list']['thumb_list']);
$data['list']['thumb_list_default']=explode('|', $data['list']['thumb_list_default']);
$data['list']['thumb_detail']=explode('|', $data['list']['thumb_detail']);
$data['list']['thumb_detail_default']=explode('|', $data['list']['thumb_detail_default']);
?>
<form method="POST" action="{$url.own_name}c=index&a=doEditorsave" class='column-details-form' data-validate_order=".column-details-form" data-submit-ajax='1' enctype="multipart/form-data">
	<input type="hidden" name='id' value="{$data.list.id}" />
	<input type="hidden" name="wap_ok" value="{$data.list.wap_ok}">
	<input type="hidden" name="no_order" value="{$data.list.no_order}">
	<div class="metadmin-fmbx">
		<h3 class='example-title'>{$word.upfiletips7}</h3>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.columnname}</label>
			</dt>
			<dd>
				<div class='form-group clearfix'>
					<input type="text" name="name" value="{$data.list.name}" required class="form-control">
				</div>
				<div class="clearfix">
					<span class="text-help text-content float-left">{$word.text_size}{$word.marks}</span>
					<input type="text" name="text_size" value="{$data.list.text_size}" data-plugin="select-fontsize" class="form-control d-inline-block mr-2" style="width:80px;">
					<span class="text-help text-content float-left">{$word.text_color}{$word.marks}</span>
					<input type="text" name="text_color" value="{$data.list.text_color}" data-plugin="minicolors" class="form-control w-a d-inline-block">
					<span class="text-help ml-2">{$word.column_style_tips}</span>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.columnnav}</label>
			</dt>
			<dd>
				<div class='form-group clearfix'>
					<div class="custom-control custom-radio">
						<input type="radio" id="nav0-{$checkbox_time}" name='nav' value='0' data-checked='{$data.list.nav}' required class="custom-control-input"/>
						<label class="custom-control-label" for="nav0-{$checkbox_time}">{$word.columnnav1}</label>
					</div>
					<div class="custom-control custom-radio">
						<input type="radio" id="nav1-{$checkbox_time}" name='nav' value='1' class="custom-control-input"/>
						<label class="custom-control-label" for="nav1-{$checkbox_time}">{$word.columnnav2}</label>
					</div>
					<div class="custom-control custom-radio">
						<input type="radio" id="nav2-{$checkbox_time}" name='nav' value='2' class="custom-control-input"/>
						<label class="custom-control-label" for="nav2-{$checkbox_time}">{$word.columnnav3}</label>
					</div>
					<div class="custom-control custom-radio">
						<input type="radio" id="nav3-{$checkbox_time}" name='nav' value='3' class="custom-control-input"/>
						<label class="custom-control-label" for="nav3-{$checkbox_time}">{$word.columnnav4}</label>
					</div>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.columnnewwindow}</label>
			</dt>
			<dd>
				<div class='form-group clearfix'>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="new_windows1-{$checkbox_time}" name='new_windows' value='1' data-checked='{$data.list.new_windows}' required class="custom-control-input"/>
						<label class="custom-control-label" for="new_windows1-{$checkbox_time}">{$word.yes}</label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="new_windows0-{$checkbox_time}" name='new_windows' value='0' class="custom-control-input"/>
						<label class="custom-control-label" for="new_windows0-{$checkbox_time}">{$word.no}</label>
					</div>
				</div>
			</dd>
		</dl>
		<if value="$data['list']['module'] egt 2 && $data['list']['module'] elt 6">
		<dl>
			<dt>
				<label class='form-control-label'>{$word.columncontentorder}</label>
			</dt>
			<dd>
				<div class='form-group clearfix'>
					<if value="$data['list']['module'] elt 6">
					<div class="custom-control custom-radio">
						<input type="radio" id="list_order1-{$checkbox_time}" name='list_order' value='1' required class="custom-control-input"/>
						<label class="custom-control-label" for="list_order1-{$checkbox_time}">{$word.updatetime}</label>
					</div>
					</if>
					<div class="custom-control custom-radio">
						<input type="radio" id="list_order2-{$checkbox_time}" name='list_order' value='2' data-checked='{$data.list.list_order}' class="custom-control-input"/>
						<label class="custom-control-label" for="list_order2-{$checkbox_time}">{$word.addtime}</label>
					</div>
					<if value="$data['list']['module'] elt 6">
					<div class="custom-control custom-radio">
						<input type="radio" id="list_order3-{$checkbox_time}" name='list_order' value='3' class="custom-control-input"/>
						<label class="custom-control-label" for="list_order3-{$checkbox_time}">{$word.hits}</label>
					</div>
					</if>
					<div class="custom-control custom-radio">
						<input type="radio" id="list_order4-{$checkbox_time}" name='list_order' value='4' class="custom-control-input"/>
						<label class="custom-control-label" for="list_order4-{$checkbox_time}">ID {$word.columnReverseSort}</label>
					</div>
					<div class="custom-control custom-radio">
						<input type="radio" id="list_order5-{$checkbox_time}" name='list_order' value='5' class="custom-control-input"/>
						<label class="custom-control-label" for="list_order5-{$checkbox_time}">ID {$word.columnaddOrder}</label>
					</div>
				</div>
			</dd>
		</dl>
		</if>
		<if value="$data['list']['module'] eq 1">
		<dl>
			<dt>
				<label class='form-control-label'>{$word.columnshow}</label>
			</dt>
			<dd>
				<div class='form-group clearfix'>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="isshow1-{$checkbox_time}" name='isshow' value='1' data-checked='{$data.list.isshow}' required class="custom-control-input"/>
						<label class="custom-control-label" for="isshow1-{$checkbox_time}">{$word.columnmallow}</label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="isshow0-{$checkbox_time}" name='isshow' value='0' class="custom-control-input"/>
						<label class="custom-control-label" for="isshow0-{$checkbox_time}">{$word.columnmnotallow}</label>
					</div>
				</div>
			</dd>
		</dl>
		</if>
		<if value="$data['list']['if_in'] eq 1">
		<dl>
			<dt>
				<label class='form-control-label'>{$word.columnhref}</label>
			</dt>
			<dd>
				<div class='form-group clearfix'>
					<input type="text" name="out_url" value="{$data.list.out_url}" class="form-control">
					<span class="text-help">{$word.columntip7}</span>
				</div>
			</dd>
		</dl>
		</if>
		<h3 class='example-title'>{$word.columnSEO}</h3>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.columnctitle}</label>
			</dt>
			<dd>
				<div class='form-group clearfix'>
					<input type="text" name="ctitle" value="{$data.list.ctitle}" class="form-control">
					<span class="text-help">{$word.ctitleinfo}</span>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.keywords}</label>
			</dt>
			<dd>
				<div class='form-group clearfix'>
					<input type="text" name="keywords" value="{$data.list.keywords}" class="form-control mr-2">
					<span class="text-help">{$word.keywordsinfo}</span>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.description}</label>
			</dt>
			<dd>
				<textarea name="description" rows="3" class='form-control'>{$data.list.description}</textarea>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.columnhtmlname}</label>
			</dt>
			<dd>
				<div class='form-group clearfix'>
					<input type="text" name="filename" value="{$data.list.filename}" data-fv-remote="true" data-fv-remote-url="{$url.own_name}c={$data.c}&a=doCheckFilename&id={$data.list.id}" class="form-control mr-2">
					<span class="text-help d-block float-left">{$word.columntip14}</span>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.columnnofollow}</label>
			</dt>
			<dd>
				<div class='form-group clearfix'>
					<div class="custom-control custom-checkbox custom-control-inline">
						<input type="checkbox" id="nofollow1-{$checkbox_time}" name='nofollow' value='1' data-checked='{$data.list.nofollow}' class="custom-control-input"/>
						<label class="custom-control-label" for="nofollow1-{$checkbox_time}">{$word.columnmallow}</label>
					</div>
					<span class="text-help">{$word.columnnofollowinfo}</span>
				</div>
			</dd>
		</dl>
		<h3 class='example-title'>{$word.columnnamemarkinfo}</h3>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.columnmark}</label>
			</dt>
			<dd>
				<div class='form-group clearfix'>
					<input type="text" name="index_num" value="{$data.list.index_num}" class="form-control">
					<span class="text-help">{$word.columnexplain7}</span>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.columnnamemark}</label>
			</dt>
			<dd>
				<div class='form-group clearfix'>
					<input type="text" name="namemark" value="{$data.list.namemark}" class="form-control">
				</div>
			</dd>
		</dl>
		<?php
		$upload=array(
			'title'=>$word['columnImg1'],
			'name'=>'indeximg',
			'value'=>$data['list']['indeximg']
		);
		?>
		<include file="pub/content_details/upload"/>
		<?php
		$upload=array(
			'title'=>$word['columnImg2'],
			'name'=>'columnimg',
			'value'=>$data['list']['columnimg']
		);
		?>
		<include file="pub/content_details/upload"/>
		<?php
		$iconset=array(
			'title'=>$word['column_littleicon_v6'],
			'name'=>'icon',
			'value'=>$data['list']['icon']
		);
		?>
		<include file="pub/content_details/iconset"/>
		<if value="$data['list']['module'] egt 2 && $data['list']['module'] elt 6">
		<?php $data['list']['list_length']=$data['list']['list_length']?$data['list']['list_length']:''; ?>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.unitytxt_42}</label>
			</dt>
			<dd>
				<div class='form-group clearfix'>
					<input type="text" name="list_length" value="{$data.list.list_length}" placeholder="{$word.default_values}{$word.marks}{$data.list.list_length_default}" class="form-control">
				</div>
			</dd>
		</dl>
		</if>
		<if value="$data['list']['module'] eq 2 || $data['list']['module'] eq 3 || $data['list']['module'] eq 5">
		<dl>
			<dt>
				<label class='form-control-label'>{$word.thumb_size_list}</label>
			</dt>
			<dd class="form-group">
				<input type="text" name="thumb_list_x" value="{$data.list.thumb_list.0}" placeholder="{$word.default_values}{$word.marks}{$data.list.thumb_list_default.0}" class="form-control w-a">
				<span class="float-left text-help text-muted mx-2">x</span>
				<input type="text" name="thumb_list_y" value="{$data.list.thumb_list.1}" placeholder="{$word.default_values}{$word.marks}{$data.list.thumb_list_default.1}" class="form-control w-a">
				<span class="text-help ml-2">{$word.setimgWidth}x{$word.setimgHeight}({$word.setimgPixel})</span>
			</dd>
		</dl>
		<if value="$data['list']['module'] neq 2">
		<dl>
			<dt>
				<label class='form-control-label'>{$word.page_for_details}{$word.modimgurls}{$word.wapdimensionalsize}</label>
			</dt>
			<dd class="form-group">
				<input type="text" name="thumb_detail_x" value="{$data.list.thumb_detail.0}" placeholder="{$word.default_values}{$word.marks}{$data.list.thumb_detail_default.0}" class="form-control w-a">
				<span class="float-left text-help text-muted mx-2">x</span>
				<input type="text" name="thumb_detail_y" value="{$data.list.thumb_detail.1}" placeholder="{$word.default_values}{$word.marks}{$data.list.thumb_detail_default.1}" class="form-control w-a">
				<span class="text-help ml-2">{$word.setimgWidth}x{$word.setimgHeight}({$word.setimgPixel})</span>
			</dd>
		</dl>
		</if>
		</if>
		<if value="$data['list']['module'] egt 2 && $data['list']['module'] elt 5">
		<?php
		$editor=array(
			'title'=>$word['columnmappend'],
			'height'=>150
		);
		?>
		<include file="pub/content_details/editor"/>
		</if>
		<dl>
            <dt>
                <label class='form-control-label'>{$word.column_other_info}</label>
            </dt>
            <dd>
                <input type="text" name="other_info" value="{$data.list.other_info}" class="form-control">
                <span class="text-help ml-2">{$word.banner_needtempsupport_v6}</span>
            </dd>
        </dl>
        <dl>
            <dt>
                <label class='form-control-label'>{$word.column_custom_info}</label>
            </dt>
            <dd>
                <textarea name="custom_info" rows="3" class='form-control'>{$data.list.custom_info}</textarea>
                <span class="text-help ml-2">{$word.banner_needtempsupport_v6}</span>
            </dd>
        </dl>
		<h3 class='example-title'>{$word.unitytxt_33}</h3>
		<include file="pub/content_details/webaccess"/>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.displaytype}</label>
			</dt>
			<dd>
				<div class='form-group clearfix'>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="display0-{$checkbox_time}" name='display' value='0' data-checked='{$data.list.display}' required class="custom-control-input"/>
						<label class="custom-control-label" for="display0-{$checkbox_time}">{$word.yes}</label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="display1-{$checkbox_time}" name='display' value='1' class="custom-control-input"/>
						<label class="custom-control-label" for="display1-{$checkbox_time}">{$word.no}</label>
					</div>
				</div>
			</dd>
		</dl>
	</div>
</form>