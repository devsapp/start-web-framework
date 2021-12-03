<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<h3 class='example-title clearfix'><span class="my-1 d-inline-block">SEO{$word.seting}</span><button type='button' data-toggle="collapse" data-target=".{$data.n}-details-seo" class='btn btn-default btn-sm float-right'>{$word.moreSettings}<i class="icon fa-caret-right ml-2"></i></button></h3>
<div class="collapse {$data.n}-details-seo">
	<dl>
		<dt>
			<label class='form-control-label'>{$word.managertyp5}{$word.columnmtitle}</label>
		</dt>
		<dd>
			<div class='form-group clearfix'>
				<input type="text" name="ctitle" value="{$data.list.ctitle}" class="form-control mr-2">
				<span class="text-help">{$word.tips6_v6}</span>
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
				<span class="text-help">{$word.setseoTip1}</span>
			</div>
		</dd>
	</dl>
	<dl>
		<dt>
			<label class='form-control-label'>{$word.desctext}</label>
		</dt>
		<dd class="clearfix">
			<textarea name="description" rows="4" class='form-control'>{$data.list.description}</textarea>
			<span class="text-help ml-2">{$word.tips1_v6}</span>
		</dd>
	</dl>
	<if value="$data['list']['module'] neq 1">
	<dl>
		<dt>
			<label class='form-control-label'><abbr title="{$word.tips2_v6}">{$word.tag}</abbr></label>
		</dt>
		<dd>
			<div class="float-left mr-2">
				<input type="text" name="tag" value="{$data.list.tag}" class="form-control mr-2"/>
			</div>
			<span class="text-help">{$word.tips3_v6}</span>
		</dd>
	</dl>
	</if>
	<dl>
		<dt>
			<label class='form-control-label'>{$word.columnhtmlname}</label>
		</dt>
		<dd>
			<div class='form-group clearfix'>
				<input type="text" name="filename" value="{$data.list.filename}" class="form-control mr-2"
				data-fv-remote="true"
				data-fv-remote-url="{$url.own_name}c={$data.c}&a=docheck_filename&id={$data.list.id}"
				>
				<span class="text-help">{$word.js74}</span>
			</div>
		</dd>
	</dl>
</div>