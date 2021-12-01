<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$data=array_merge($data,$data['handle']);
unset($data['handle']);
?>
<input type="hidden" name="admin_folder_safe" value="{$data.admin_folder_safe}" data-toggle="modal" data-target=".admin-folder-safe-modal">
<div class="card d-none d-md-flex">
	<div class="card-header">
		<h3 class="h6 mb-0 float-left">{$word.website_overview}</h3>
	</div>
	<div class="card-body py-4">
		<div class="row text-center mx-0 site-summarize-list">
			<list data="$data['summarize']" name="$v">
			<?php
			$url='#/manage/?view_type=module&module='.$v['_index'];
			$v['_index']=='job' && $url.='&head_tab_active=1';
			?>
			<div class="col-4" style="width: 20%;max-width: 20%;">
				<div class="card border-none transition500">
					<a href="{$url}" class="card-body">
						<p class="h6 text-content">{$v.name}</p>
						<span class="h3">{$v.total}</span>
					</a>
				</div>
			</div>
			</list>
		</div>
	</div>
</div>
<if value="$data['home_app_ok']">
<div class="card mt-3">
	<div class="card-header">
		<h3 class="h6 mb-0 float-left">{$word.recom}</h3>
		<a href="{$c.market_url}" target="_blank" class="float-right">{$word.columnmore} <i class="fa fa-angle-right"></i></a>
	</div>
	<div class="card-body py-3">
		<ul class="home-app-list row list-unstyled mb-0">
			<?php $loader_class='w-100'; ?>
			<include file="pub/loader"/>
		</ul>
	</div>
</div>
</if>
<if value="$data['home_app_ok']">
<div class="card mt-3">
	<div class="card-header">
		<h3 class="h6 mb-0 float-left">MetInfo {$word.upfiletips37}</h3>
		<a href="https://www.metinfo.cn/" target="_blank" class="float-right">{$word.columnmore} <i class="fa fa-angle-right"></i></a>
	</div>
	<div class="card-body py-2 home-news-list" data-url="https://www.metinfo.cn/metv5news.php?action=json&listnum=6">
		<include file="pub/loader"/>
	</div>
</div>
</if>