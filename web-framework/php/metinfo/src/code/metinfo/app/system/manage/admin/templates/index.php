<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="position-relative">
	<button type="button" class="btn btn-default position-absolute btn-column-control" title="{$word.manage_tips1}"><i class="fa-angle-left"></i></button>
</div>
<div class="d-flex">
	<div class="column-view-wrapper transition500">
		<div class="column-view transition500 mr-4">
			<div class="input-group">
				<input type="search" name="search" placeholder="{$word.column_searchname}" data-url="{$url.own_name}c=index&a=dosearch" class="form-control column-search">
				<div class="input-group-append">
					<div class="input-group-text btn bg-none px-2"><i class="input-search-icon fa-search"></i></div>
				</div>
			</div>
			<div class="d-flex justify-content-between w-100 py-3 nav content-btn-group">
				<a href="#content-view-module" title="{$word.columnarrangement2}{$word.columnarrangement3}" data-toggle="tab" data-view_type="module" class="btn-content-module"><i class="fa-th-large"></i> {$word.columnarrangement3}</a>
				<a href="#content-view-column" title="{$word.columnarrangement2}{$word.columnarrangement4}" data-toggle="tab" data-view_type="column" class="active btn-content-module"><i class="fa-th"></i> {$word.columnarrangement4}</a>
			</div>
			<div class="py-3 d-flex align-items-center justify-content-between">
				<select name="default_show_column" class="form-control form-control-sm" style="width: 120px;">
				</select>
				<a href="#/recycle" class="btn-content-recycle text-content"><i class="fa-recycle"></i> {$word.upfiletips25}</a>
			</div>
			<div class="tab-content met-scrollbar scrollbar-grey">
				<div class="tab-pane fade" id="content-view-module">
					<ul class="list-group ulstyle list-group-flush column-view-list">
					</ul>
			    </div>
			    <div class="tab-pane fade active show" id="content-view-column">
			    	<ul class="list-group ulstyle list-group-flush column-view-list">
					</ul>
			    </div>
			</div>
		</div>
	</div>
	<div class="content-show media-body">
		<div class="h-100 d-flex align-items-center justify-content-center hide met-loader"><div class="loader loader-round-circle"></div></div>
		<div class="h-100 content-show-item tips">
			<div class="h-100 d-flex align-items-center justify-content-center">
				<div class="h5 mb-0">{$word.admin_manage1}</div>
			</div>
		</div>
	</div>
</div>