<?php defined('IN_MET') or exit('No permission'); ?>
<list data="$result" num="$c['met_news_list']" name="$v">
<li class="media media-lg border-bottom1">
<if value="$lang['news_imgok']">
	<div class="media-left">
		<a href="{$v.url}" title="{$v.title}" {$g.urlnew}>
			<img class="media-object" <if value="$v['_index'] gt 3 || $data['page'] gt 1">data-original<else/>src</if>="{$v.imgurl|thumb:$c['met_newsimg_x'],$c['met_newsimg_y']}" alt="{$v.title}"></a>
	</div>
</if>
	<div class="media-body">
		<h4>
			<a href="{$v.url}" {$v.urlnew} title="{$v.title}"  {$g.urlnew}>{$v._title}</a>
		</h4>
		<p class="des font-weight-300">
			{$v.description}
		</p>
		<p class="info font-weight-300">
			<span>{$v.updatetime}</span>
			<span>{$v.issue}</span>
			<span>
				<i class="icon wb-eye m-r-5 font-weight-300" aria-hidden="true"></i>
				{$v.hits}
			</span>
		</p>
	</div>
</li>
</list>