<?php defined('IN_MET') or exit('No permission'); ?>
<tag action='search.list' num="$c['met_search_list']">
<li class="list-group-item">
	<h4>
		<a href="{$v.url}" title='{$v.ctitle}' {$g.urlnew}>
			<if value="$v['ctitle']">{$v.ctitle}<else/>{$v.title}</if>
		</a>
	</h4>
	<a class="search-result-link" href="{$v.url}" {$g.urlnew}>{$v.url}</a>
	<if value="$v['content']">
	<p>{$v.content}</p>
	</if>
</li>
</tag>