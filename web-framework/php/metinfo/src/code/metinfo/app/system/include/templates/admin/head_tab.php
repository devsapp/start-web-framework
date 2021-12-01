<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$head_tab_active=isset($data['head_tab_active'])?$data['head_tab_active']:(isset($head_tab_active)?$head_tab_active:0);
$content_time=time();
?>
<if value="$head_tab">
<nav class="nav nav-underline mb-3 met-headtab rounded-xs<if value="$head_tab_ajax && !$no_bg">metadmin-content-min bg-white py-2</if>"<if value="$head_tab_ajax">data-ajaxchange='1'</if> <if value="$head_tab_reload">data-reload="1"</if>>
	<list data="$head_tab" name="$v">
	  <a
		class="nav-link<if value="$head_tab_active eq $v['_index']">active</if>"
	  	<if value="$head_tab_ajax && !$v['target']">
		data-url="{$v.url}" data-toggle="pill" href="#met-headtab-content-{$content_time}-{$v._index}"
		<else/>
		href="{$v.url}"
		</if>
		<if value="$v['reload']">data-reload="1"</if>
		<if value="$v['target']">target="_blank"</if>
		>{$v.title}</a>
  	</list>
</nav>
<if value="$head_tab_ajax">
<?php $head_tab_url=$head_tab[$head_tab_active]['url']; ?>
<div class="tab-content">
	<list data="$head_tab" name="$v">
	<if value="!$v['target']">
	<div class="tab-pane fade <if value="!$no_bg">bg-white p-4</if><if value="$v['_index'] eq $head_tab_active">show active</if>" id="met-headtab-content-{$content_time}-{$v._index}">
	</div>
	</if>
	</list>
</div>
</if>
<?php
unset($head_tab_ajax);
unset($head_tab_active);
unset($head_tab);
?>
</if>