<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
if($data['handle']){
	$data=array_merge($data,$data['handle']);
	unset($data['handle']);
}
!isset($data['banner']['img_text_position']) && $data['banner']['img_text_position']=4;
!isset($data['banner']['img_text_position_mobile']) && $data['banner']['img_text_position_mobile']=4;
!isset($data['banner']['target']) && $data['banner']['target']=1;
$checkbox_time=time();
$action=$data['id']?'editor':'add';
if(!$data['banner']['height']){
	$data['banner']['height']=$word['adaptive'];
}
if(!$data['banner']['height_t']){
	$data['banner']['height_t']=$word['adaptive'];
}
if(!$data['banner']['height_m']){
	$data['banner']['height_m']=$word['adaptive'];
}
?>
<form method="POST" action="{$url.own_name}c=banner_admin&a=doeditorsave&action={$action}&id={$data.id}&no_order={$data.banner.no_order}" class='banner-details-form' data-submit-ajax='1' enctype="multipart/form-data">
	<input type="hidden" name="no_order" value="{$data.no_order}">
	<div class="metadmin-fmbx">
		<dl>
			<dt>
				<label class='form-control-label'>{$word.setflashSize}</label>
			</dt>
			<dd>
				<div class='form-group clearfix'>
					<input type="text" name="height" value="{$data.banner.height}" required class="form-control w-a">
					<span class="text-help text-muted float-left mx-2">{$word.banner_pcheight_v6}</span>
					<span class="text-help">{$word.banner_setalert_v6}</span>
				</div>
				<div class='form-group clearfix'>
					<input type="text" name="height_t" value="{$data.banner.height_t}" required class="form-control w-a">
					<span class="text-help text-muted float-left mx-2">{$word.banner_pidheight_v6}</span>
					<span class="text-help">{$word.banner_setalert_v6}</span>
				</div>
				<div class='form-group clearfix'>
					<input type="text" name="height_m" value="{$data.banner.height_m}" required class="form-control w-a">
					<span class="text-help text-muted float-left mx-2">{$word.banner_phoneheight_v6}</span>
					<span class="text-help">{$word.banner_setalert_v6}</span>
				</div>
			</dd>
		</dl>
		<?php
		$upload=array(
			'title'=>$word['setflashImgUrl'],
			'name'=>'img_path',
			'value'=>$data['banner']['img_path'],
			'required'=>1,
			'tips'=>$word['indexflashexplain4']
		);
		?>
		<include file="pub/content_details/upload"/>
		<?php
		$upload=array(
			'title'=>$word['banner_setmobileImgUrl_v6'],
			'name'=>'mobile_img_path',
			'value'=>$data['banner']['mobile_img_path'],
			'tips'=>$word['indexflashexplain4'].' '.$word['mobile_banner_tips1']
		);
		?>
		<include file="pub/content_details/upload"/>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.setflashImgHref}</label>
			</dt>
			<dd>
				<div class="clearfix">
					<input type="text" name="img_link" value="{$data.banner.img_link}" class="form-control">
					<span class="text-help ml-2">{$word.indexflashexplain9}</span>
				</div>
				<div class="form-group">
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="target0-{$checkbox_time}" name='target' value='0' data-checked='{$data.banner.target}' required class="custom-control-input"/>
						<label class="custom-control-label" for="target0-{$checkbox_time}">{$word.setseodopen}</label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="target1-{$checkbox_time}" name='target' value='1' class="custom-control-input"/>
						<label class="custom-control-label" for="target1-{$checkbox_time}">{$word.setseonewopen}</label>
					</div>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.setflashName}</label>
			</dt>
			<dd>
				<div class="form-group"><input type="text" name="img_title" value="{$data.banner.img_title}" class="form-control"></div>
				<div class="clearfix">
					<span class="text-help text-content float-left">{$word.banner_imgtitlecolor_v6}{$word.marks}</span>
					<input type="text" name="img_title_color" value="{$data.banner.img_title_color}" data-plugin="minicolors" class="form-control d-inline-block mr-2" style="width:100px;">
					<span class="text-help text-content float-left">{$word.image_title_font_size}{$word.marks}</span>
					<input type="text" name="img_title_fontsize" value="{$data.banner.img_title_fontsize}" data-plugin="select-fontsize" class="form-control d-inline-block" style="width:100px;">
					<span class="text-help text-content ml-2">{$word.setimgPixel}</span>
					<span class="text-help ml-2">{$word.banner_needtempsupport_v6}</span>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.banner_imgdesc_v6}</label>
			</dt>
			<dd>
				<div class="form-group"><input type="text" name="img_des" value="{$data.banner.img_des}" class="form-control"></div>
				<div class="clearfix">
					<span class="text-help text-content float-left">{$word.banner_imgdesccolor_v6}{$word.marks}</span>
					<input type="text" name="img_des_color" value="{$data.banner.img_des_color}" data-plugin="minicolors" class="form-control d-inline-block mr-2" style="width:100px;">
					<span class="text-help text-content float-left">{$word.image_description_font_size}{$word.marks}</span>
					<input type="text" name="img_des_fontsize" value="{$data.banner.img_des_fontsize}" data-plugin="select-fontsize" class="form-control d-inline-block" style="width:100px;">
					<span class="text-help text-content ml-2">{$word.setimgPixel}</span>
					<span class="text-help ml-2">{$word.banner_needtempsupport_v6}</span>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.banner_imgwordpos_v6}</label>
			</dt>
			<dd>
				<div class='form-group clearfix'>
					<div class="custom-control custom-radio">
						<input type="radio" id="img_text_position0-{$checkbox_time}" name='img_text_position' value='0' data-checked='{$data.banner.img_text_position}' required class="custom-control-input"/>
						<label class="custom-control-label" for="img_text_position0-{$checkbox_time}">{$word.posleft}</label>
					</div>
					<div class="custom-control custom-radio">
						<input type="radio" id="img_text_position1-{$checkbox_time}" name='img_text_position' value='1' class="custom-control-input"/>
						<label class="custom-control-label" for="img_text_position1-{$checkbox_time}">{$word.posright}</label>
					</div>
					<div class="custom-control custom-radio">
						<input type="radio" id="img_text_position2-{$checkbox_time}" name='img_text_position' value='2' class="custom-control-input"/>
						<label class="custom-control-label" for="img_text_position2-{$checkbox_time}">{$word.posup}</label>
					</div>
					<div class="custom-control custom-radio">
						<input type="radio" id="img_text_position3-{$checkbox_time}" name='img_text_position' value='3' class="custom-control-input"/>
						<label class="custom-control-label" for="img_text_position3-{$checkbox_time}">{$word.poslower}</label>
					</div>
					<div class="custom-control custom-radio">
						<input type="radio" id="img_text_position4-{$checkbox_time}" name='img_text_position' value='4' class="custom-control-input"/>
						<label class="custom-control-label" for="img_text_position4-{$checkbox_time}">{$word.poscenter}</label>
					</div>
				</div>
				<span class="text-help ml-2">{$word.banner_needtempsupport_v6}</span>
			</dd>
		</dl>
		<h3 class='example-title clearfix'><button type='button' data-toggle="collapse" data-target=".banner-details-other" class='btn btn-outline-primary btn-sm'>{$word.mobile_terminal_settings}<i class="icon fa-caret-right ml-2"></i></button></h3>
		<div class="collapse banner-details-other">
			<dl>
				<dt>
					<label class='form-control-label'>{$word.mobile_phone_picture_title}</label>
				</dt>
				<dd>
					<div class="form-group">
						<input type="text" name="img_title_mobile" value="{$data.banner.img_title_mobile}" class="form-control">
						<span class="text-help ml-2">{$word.banner_edit1}</span>
					</div>
					<div class="clearfix">
						<span class="text-help text-content float-left">{$word.banner_edit2}{$word.marks}</span>
						<input type="text" name="img_title_color_mobile" value="{$data.banner.img_title_color_mobile}" data-plugin="minicolors" class="form-control d-inline-block mr-2" style="width:100px;">
						<span class="text-help text-content float-left">{$word.banner_edit3}{$word.marks}</span>
						<input type="text" name="img_title_fontsize_mobile" value="{$data.banner.img_title_fontsize_mobile}" data-plugin="select-fontsize" class="form-control d-inline-block" style="width:100px;">
						<span class="text-help text-content ml-2">{$word.setimgPixel}</span>
						<span class="text-help ml-2">{$word.banner_edit1}</span>
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class='form-control-label'>{$word.banner_edit5}</label>
				</dt>
				<dd>
					<div class="form-group">
						<input type="text" name="img_des_mobile" value="{$data.banner.img_des_mobile}" class="form-control">
						<span class="text-help ml-2">{$word.banner_edit1}</span>
					</div>
					<div class="clearfix">
						<span class="text-help text-content float-left">{$word.banner_edit6}{$word.marks}</span>
						<input type="text" name="img_des_color_mobile" value="{$data.banner.img_des_color_mobile}" data-plugin="minicolors" class="form-control d-inline-block mr-2" style="width:100px;">
						<span class="text-help text-content float-left">{$word.banner_edit7}{$word.marks}</span>
						<input type="text" name="img_des_fontsize_mobile" value="{$data.banner.img_des_fontsize_mobile}" data-plugin="select-fontsize" class="form-control d-inline-block" style="width:100px;">
						<span class="text-help text-content ml-2">{$word.setimgPixel}</span>
						<span class="text-help ml-2">{$word.banner_edit1}</span>
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class='form-control-label'>{$word.banner_edit8}</label>
				</dt>
				<dd>
					<div class='form-group clearfix'>
						<div class="custom-control custom-radio">
							<input type="radio" id="img_text_position_mobile0-{$checkbox_time}" name='img_text_position_mobile' value='0' data-checked='{$data.banner.img_text_position_mobile}' required class="custom-control-input"/>
							<label class="custom-control-label" for="img_text_position_mobile0-{$checkbox_time}">{$word.posleft}</label>
						</div>
						<div class="custom-control custom-radio">
							<input type="radio" id="img_text_position_mobile1-{$checkbox_time}" name='img_text_position_mobile' value='1' class="custom-control-input"/>
							<label class="custom-control-label" for="img_text_position_mobile1-{$checkbox_time}">{$word.posright}</label>
						</div>
						<div class="custom-control custom-radio">
							<input type="radio" id="img_text_position_mobile2-{$checkbox_time}" name='img_text_position_mobile' value='2' class="custom-control-input"/>
							<label class="custom-control-label" for="img_text_position_mobile2-{$checkbox_time}">{$word.posup}</label>
						</div>
						<div class="custom-control custom-radio">
							<input type="radio" id="img_text_position_mobile3-{$checkbox_time}" name='img_text_position_mobile' value='3' class="custom-control-input"/>
							<label class="custom-control-label" for="img_text_position_mobile3-{$checkbox_time}">{$word.poslower}</label>
						</div>
						<div class="custom-control custom-radio">
							<input type="radio" id="img_text_position_mobile4-{$checkbox_time}" name='img_text_position_mobile' value='4' class="custom-control-input"/>
							<label class="custom-control-label" for="img_text_position_mobile4-{$checkbox_time}">{$word.poscenter}</label>
						</div>
					</div>
				</dd>
			</dl>
		</div>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.category}</label>
			</dt>
			<dd class='form-group'>
				<div class="border" data-plugin="checkAll">
					<div class='px-3'>
						<div class="custom-control custom-checkbox">
							<input class="checkall-all custom-control-input" type="checkbox" name="met_clumid_all" value="1" id="met_clumid_all-{$checkbox_time}" data-checked="{$data.met_clumid_all}">
							<label class="custom-control-label" for="met_clumid_all-{$checkbox_time}">{$word.allcategory}</label>
						</div>
					</div>
					<hr class="my-1">
					<div class='px-3 met-scrollbar scrollbar-grey' style="max-height: 300px;">
						<div class="custom-control custom-checkbox">
							<input class="checkall-item custom-control-input" type="checkbox" name="module" id="module10001-{$checkbox_time}" value="10001" required data-fv-notEmpty-message="{$word.js67}" data-checked='{$data.banner.module}' data-delimiter=",">
							<label class="custom-control-label" for="module10001-{$checkbox_time}">{$word.flashHome}</label>
						</div>
						<list data="$data['columnlist']" name="$v" num="1000">
						<div class="custom-control custom-checkbox">
							<input class="checkall-item custom-control-input" type="checkbox" name="module" id="module{$v._index}-{$checkbox_time}" value="{$v.id}" data-delimiter=",">
							<label class="custom-control-label" for="module{$v._index}-{$checkbox_time}">{$v.name}</label>
						</div>
						<if value="$v['subcolumn']">
						<list data="$v['subcolumn']" name="$a" num="1000">
						<div class="custom-control custom-checkbox ml-3">
							<input class="checkall-item custom-control-input" type="checkbox" name="module" id="module{$v._index}-{$a._index}-{$checkbox_time}" value="{$a.id}" data-delimiter=",">
							<label class="custom-control-label" for="module{$v._index}-{$a._index}-{$checkbox_time}">{$a.name}</label>
						</div>
						<if value="$a['subcolumn']">
						<list data="$a['subcolumn']" name="$b" num="1000">
						<div class="custom-control custom-checkbox ml-5">
							<input class="checkall-item custom-control-input" type="checkbox" name="module" id="module{$v._index}-{$a._index}-{$b._index}-{$checkbox_time}" value="{$b.id}" data-delimiter=",">
							<label class="custom-control-label" for="module{$v._index}-{$a._index}-{$b._index}-{$checkbox_time}">{$b.name}</label>
						</div>
						</list>
						</if>
						</list>
						</if>
						</list>
					</div>
				</div>
			</dd>
		</dl>
	</div>
</form>