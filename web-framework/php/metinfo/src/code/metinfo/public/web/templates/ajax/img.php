<?php defined('IN_MET') or exit('No permission'); ?>
<if value="$c['met_img_page'] && $data['sub'] && !$_M['form']['search']">
	<list data="$result" num="100" name="$m">
	<li>
		<div class="card card-shadow">
			<figure class="card-header cover">
				<a href="{$m.url}" title="{$m.name}" {$m.urlnew}>
					<img class="cover-image" <if value="$m['_index'] gt 3 || $data['page'] gt 1">data-original<else/>src</if>="{$m.columnimg|thumb:$c['met_imgs_x'],$c['met_imgs_y']}" alt="{$m.name}">
				</a>
			</figure>
			<h4 class="card-title m-0 p-x-10 font-size-16 text-xs-center">
				<a href="{$m.url}" {$m.urlnew} title="{$m.name}" class="block text-truncate">{$m.name}</a>
			</h4>
		</div>
	</li>
	</list>
<else/>
	<list data="$result" num="$c['met_img_list']" name="$v">
	<li class="card">
		<div class="cover overlay overlay-hover">
			<img class="cover-image overlay-scale" <if value="$v['_index'] gt 3 || $data['page'] gt 1">data-original<else/>src</if>="{$v.imgurl|thumb:$c['met_imgs_x'],$c['met_imgs_y']}" alt="{$v.title}">
			<div class="overlay-panel overlay-fade overlay-background overlay-background-fixed text-xs-center vertical-align" met-imgmask>
				<div class="vertical-align-middle">
					<h3 class="card-title m-b-20">{$v._title}</h3>
					<a href='{$v.url}' title='{$v.title}' class="btn btn-outline btn-squared btn-inverse" {$g.urlnew}>{$ui.img_listlook}</a>
				</div>
			</div>
		</div>
	</li>
	</list>
</if>