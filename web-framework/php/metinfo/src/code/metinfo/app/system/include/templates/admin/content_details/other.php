<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$checkbox_time=time();
?>
<h3 class='example-title clearfix'><span class="my-1 d-inline-block">{$word.unitytxt_15}</span><button type='button' data-toggle="collapse" data-target=".{$data.n}-details-other" class='btn btn-default btn-sm float-right'>{$word.moreSettings}<i class="icon fa-caret-right ml-2"></i></button></h3>
<div class="collapse {$data.n}-details-other">
	<if value="$data['n'] eq 'news'">
	<dl>
		<dt>
			<label class='form-control-label'>{$word.modpublish}</label>
		</dt>
		<dd>
			<div class='form-group clearfix'>
				<input type="text" name="publisher" value="{$data.list.publisher}" class="form-control">
			</div>
		</dd>
	</dl>
	</if>
	<dl>
		<dt>
			<label class='form-control-label'>{$word.js79}</label>
		</dt>
		<dd>
			<div class='form-group clearfix'>
				<input type="text" name="hits" value="{$data.list.hits}" class="form-control">
			</div>
		</dd>
	</dl>
	<dl>
		<dt>
			<label class='form-control-label'>{$word.linkto}</label>
		</dt>
		<dd>
			<div class="float-left mr-2">
				<input type="text" name="links" value="{$data.list.links}" class="form-control"/>
			</div>
			<span class="text-help">{$word.tips4_v6}</span>
		</dd>
	</dl>
	<if value="$data['list']['module'] neq 1">
	<dl>
        <dt>
            <label class='form-control-label'>{$word.setfootOther}</label>
        </dt>
        <dd>
            <div class='form-group clearfix'>
                <input type="text" name="other_info" value="{$data.list.other_info}" class="form-control">
                <span class="text-help ml-2">{$word.banner_needtempsupport_v6}</span>
            </div>
        </dd>
    </dl>
    <dl>
        <dt>
            <label class='form-control-label'>{$word.custom_info}</label>
        </dt>
        <dd>
            <textarea name="custom_info" rows="3" class='form-control'>{$data.list.custom_info}</textarea>
            <span class="text-help ml-2">{$word.banner_needtempsupport_v6}</span>
        </dd>
    </dl>
    </if>
	<?php
	$webaccess=array(
		'value'=>$data['list']['access'],
		'access'=>$data['access_option']
	);
	?>
	<include file="pub/content_details/webaccess"/>
	<if value="$data['n'] eq 'download'">
	<?php
	$webaccess=array(
		'title'=>$word['dowloadauthority'],
		'name'=>'downloadaccess',
		'value'=>$data['list']['downloadaccess'],
		'access'=>$data['access_option']
	);
	?>
	<include file="pub/content_details/webaccess"/>
	</if>
	<include file="pub/content_details/displaytype"/>
	<dl>
		<dt>
			<label class='form-control-label'>{$word.updatetime}</label>
		</dt>
		<dd>
			<input type="text" name="updatetime" value="{$data.list.updatetime}" class="form-control w-a" data-plugin='datetimepicker' data-day-type="2">
		</dd>
	</dl>
	<dl>
		<dt>
			<label class='form-control-label'>{$word.addtime}</label>
		</dt>
		<dd>
			<div class='form-group clearfix'>
				<?php
				if($c['met_webhtm']){
					$disabled = 'disabled';
				}
				?>
				<div class="custom-control custom-radio">
					<input type="radio" id="addtype0-{$checkbox_time}" name='addtype' value='1' data-checked='{$data.list.addtype}' required class="custom-control-input"/>
					<label class="custom-control-label" for="addtype0-{$checkbox_time}">{$word.releasenow}</label>
				</div>
				<div class="custom-control custom-radio">
					<input type="radio" id="addtype1-{$checkbox_time}" name='addtype' value='2' class="custom-control-input" {$disabled}/>
					<label class="custom-control-label mr-2" for="addtype1-{$checkbox_time}">{$word.timedrelease}</label>
					<input type="text" name="addtime" value="{$data.list.addtime}" class="form-control w-a float-none d-inline-block" {$disabled} data-plugin='datetimepicker' data-day-type="2">
				</div>
				<if value="$c['met_webhtm']">
				<span class="text-help">{$word.tips5_v6}</span>
				</if>
			</div>
		</dd>
	</dl>
</div>