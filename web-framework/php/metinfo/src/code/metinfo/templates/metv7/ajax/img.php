<?php defined('IN_MET') or exit('No permission'); ?>
<if value="$c['met_img_page'] && $data['sub'] && !$_M['form']['search']">
<list data="$result" num="100" name="$m">
	<li class="widget">
		<div class="cover overlay overlay-hover">
			<a href='{$m.url}' title='{$m.name}' {$m.urlnew}>
				<img class="cover-image overlay-scale" <if value="$m['_index'] gt 3 || $data['page'] gt 1">data-original<else/>src</if>="{$m.columnimg|thumb:$c['met_imgs_x'],$c['met_imgs_y']}" alt="{$m.name}"/>
			</a>
		</div>
	    <div class="cover-title">
		  <h3><a href='{$m.url}' title='{$m.name}' {$m.urlnew}>{$m.name}</a></h3>
		</div>
	</li>
</list>
<else/>
<list data="$result" num="$c['met_img_list']" name="$v">
	<li class="widget {$v['page']}">
		<div class="cover overlay overlay-hover">
			<a href='{$v.url}' title='{$v.title}'  {$g.urlnew} class="btn btn-outline btn-inverse met-img-showbtn">
				<img class="cover-image overlay-scale" <if value="$v['_index'] gt 3 || $data['page'] gt 1">data-original<else/>src</if>="{$v.imgurl|thumb:$c['met_imgs_x'],$c['met_imgs_y']}" alt="{$v.title}"/>
			</a>
		</div>
	    <div class="cover-title">
		  <h3><a href='{$v.url}' {$g.urlnew} title='{$v.title}'>{$v._title}</a></h3>
		</div>
	</li>
</list>
</if>