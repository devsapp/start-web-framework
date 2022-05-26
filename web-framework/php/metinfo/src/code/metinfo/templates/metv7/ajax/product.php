<?php defined('IN_MET') or exit('No permission'); ?>
<if value="$c['met_product_page'] && $data['sub'] && !$_M['form']['search']">
	<list data="$result" num="100" name="$m">
	<li class="shown">
		<div class="card card-shadow">
			<figure class="card-header cover">
				<a href="{$m.url}" title="{$m.name}" {$m.urlnew}>
					<img class="cover-image" <if value="$m['_index'] gt 3 || $data['page'] gt 1">data-original<else/>src</if>="{$m.columnimg|thumb:$c['met_productimg_x'],$c['met_productimg_y']}" alt="{$m.name}">
				</a>
			</figure>
			<h4 class="card-title m-0 p-x-10 font-size-16 text-xs-center">
				<a href="{$m.url}" {$m.urlnew} title="{$m.name}" class="block text-truncate">{$m._name}</a>
			</h4>
		</div>
	</li>
	</list>
<else/>
	<list data="$result" num="$c['met_product_list']" name="$v">
	<li class=" shown">
		<div class="card card-shadow">
			<figure class="card-header cover">
				<a href="{$v.url}" title="{$v.title}" {$g.urlnew}>
					<img class="cover-image" <if value="$v['_index'] gt 3 || $data['page'] gt 1">data-original<else/>src</if>="{$v.imgurl|thumb:$c['met_productimg_x'],$c['met_productimg_y']}" alt="{$v.title}">
				</a>
			</figure>
			<h4 class="card-title m-0 p-x-10 font-size-16 text-xs-center">
				<a href="{$v.url}" title="{$v.title}" class="block text-truncate" {$g.urlnew}>{$v._title}</a>
			</h4>
		</div>
	</li>
	</list>
</if>