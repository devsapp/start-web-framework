<?php
// MetInfo Enterprise Content Management System
// Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-update">
  	<div class="metadmin-fmbx">
		<h3 class='example-title'>{$word.program_information}</h3>
    	<dl>
			<dt>
				<label class='form-control-label'>{$word.checkupdate}</label>
			</dt>
			<dd>
				<div class='form-group clearfix update'>
					<span class="text-help ml-2"><i class="fa fa-refresh fa-spin mr-2"></i>{$word.jsx20}</span>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.current_version}</label>
			</dt>
			<dd>
				<div class='form-group clearfix version'>
				<span class="text-help ml-2"></span>
				</div>
			</dd>
		</dl>
    	<dl>
			<dt>
				<label class='form-control-label'>{$word.update_log}</label>
			</dt>
			<dd>
				<div class='form-group clearfix '>
				<a class="log_url text-help ml-2 " target="_blank">{$word.View}</a>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.reserved}</label>
			</dt>
			<dd>
				<div class='form-group clearfix copyright'>
				<a class="text-help ml-2" href="{$_M['config']['copyright_url']}" target="_blank"></a>
				</div>
			</dd>
		</dl>
		<dl class="update-met_template hide">
			<dt>
				<label class='form-control-label'>{$word.appearance}</label>
			</dt>
			<dd>
				<a href="#/app/met_template" title="{$word.appearance}" onclick="$(this).parents('.update-modal').modal('hide')" class="text-help">{$word.checkupdate}</a>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.myapp}</label>
			</dt>
			<dd>
				<a href="#/myapp" title="{$word.myapp}" onclick="$(this).parents('.update-modal').modal('hide')" class="text-help">{$word.checkupdate}</a>
			</dd>
		</dl>
		<h3 class='example-title'>{$word.upfiletips38}</h3>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.Operating}</label>
			</dt>
			<dd>
				<div class='form-group clearfix os'>
				<span class="text-help ml-2"></span>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>Web{$word.the_server}</label>
			</dt>
			<dd>
				<div class='form-group clearfix software'>

				<span class="text-help ml-2"></span>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>PHP{$word.the_version}</label>
			</dt>
			<dd>
				<div class='form-group clearfix php'>

				<span class="text-help ml-2"></span>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.database}{$word.the_version}</label>
			</dt>
			<dd>
				<div class='form-group clearfix mysql'>

				<span class="text-help ml-2"></span>
				</div>
			</dd>
		</dl>
    </div>
</div>