<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
if($data['handle']){
	$data=array_merge($data,$data['handle']);
	unset($data['handle']);
}
$checkbox_time=time();
$submit_wrapper_class='text-right';
?>
<div class='alert dark alert-primary radius0'>{$word.uiset_descript_v6}</div>
<form action="{$url.own_name}&c=index&a=dosave_pageset_nav" id="pageset-nav-set" data-submit-ajax="1">
	<div class="metadmin-fmbx metadmin-content-min p-4 bg-white">
		<dl>
			<dd class="row">
				<list data="$data['applist']" name="$v">
				<if value="$v['display']">
				<?php $v['info']=mb_substr($v['info'],0,40,'utf-8'); ?>
				<div class="col-12 col-sm-6 col-md-4 col-lg-3 my-2">
					<div class="custom-control custom-checkbox mt-0">
						<input type="checkbox" id="checkbox{$v._index}-{$checkbox_time}" name="applist" value='{$v.id}' <if value="$v['display'] eq 2">checked</if> data-delimiter="," class="custom-control-input" />
						<label class="custom-control-label" for="checkbox{$v._index}-{$checkbox_time}">
							<div class="media">
								<img src="{$v.ico}" alt="{$v.appname}" width="80" class="mr-3">
								<div class="media-body">
									<h4 class="media-heading h6">{$v.appname}</h4>
									<p class="mb-0 text-grey" style="line-height: 1.5;">{$v.info}</p>
								</div>
							</div>
						</label>
					</div>
				</div>
				</if>
				</list>
			</dd>
		</dl>
		<include file="pub/content_details/submit"/>
	</div>
</form>