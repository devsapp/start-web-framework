<?php defined('IN_MET') or exit('No permission'); ?>
<list data="$result" num="$c['met_download_list']" name="$v">
<li class="list-group-item">
	<div class="media">
		<div class="media-left p-r-5 p-l-10 hidden-xs-down">
			<a href="{$v.url}" title="{$v.title}"  {$g.urlnew}>
				<i class="icon fa-file-archive-o blue-grey-400"></i>
			</a>
		</div>
		<div class="media-body">
			<a class="btn btn-outline btn-primary btn-squared pull-xs-right" href="{$v.downloadurl}" title="{$v.title}"  {$g.urlnew}>{$lang.download}</a>
			<h4 class="media-heading font-size-16">
				<a class="name" href="{$v.url}"  {$g.urlnew} title="{$v.title}">{$v._title}</a>
			</h4>
			<small class='font-size-14 blue-grey-500'>
				<span>{$v.filesize} kb</span>
				<span class="m-l-10">{$v.updatetime}</span>
			</small>
		</div>
	</div>
</li>
</list>