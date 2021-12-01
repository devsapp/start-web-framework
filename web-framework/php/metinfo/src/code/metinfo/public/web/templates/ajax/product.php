<?php defined('IN_MET') or exit('No permission'); ?>
<if value="$c['met_product_page'] && $data['sub'] && !$_M['form']['search']">
<list data="$result" num="100" name="$m">
	<li <if value="$m['_index'] lt 4">class="shown"</if>>
		<div class="card card-shadow">
			<figure class="card-header cover">
				<a href="{$m.url}" title="{$m.name}" {$m.urlnew}>
					<img class="cover-image" <if value="$m['_index'] gt 3">data-original<else/>src</if>="{$m.columnimg|thumb:$c['met_productimg_x'],$c['met_productimg_y']}" alt="{$m.name}">
				</a>
			</figure>
			<h4 class="card-title m-0 p-x-10 font-size-16 text-xs-center">
				<a href="{$m.url}" title="{$m.name}" class="block" {$m.urlnew}>{$m.name}</a>
			</h4>
		</div>
	</li>
</list>
<else/>
<list data="$result" num="$c['met_product_list']" name="$v">
<if value="$ui['product_pagetype'] eq 1">
<li <if value="$v['_index'] lt 4">class="shown"</if>>
	<div class="card card-shadow">

		<figure class="card-header cover">
			<a href="{$v.url}" title="{$v.title}" {$g.urlnew}>
				<img class="cover-image" <if value="$v['_index'] gt 3 || $data['page'] gt 1">data-original<else/>src</if>="{$v.imgurl|thumb:$c['met_productimg_x'],$c['met_productimg_y']}" alt="{$v.title}">
			</a>
		</figure>
		<h4 class="card-title m-0 p-x-10 font-size-16 text-xs-center">
			<a href="{$v.url}" title="{$v.title}" class="block" {$g.urlnew}>{$v._title}</a>
			<p class='m-b-0 m-t-5 red-600'>{$v.price_str}</p>
		</h4>
	</div>
</li>
</if>
<if value="$ui['product_pagetype'] eq 2">
<li class="widget<if value="$v['_index'] lt 4"> shown</if>">
	<div class="cover-body">
		<div class="cover overlay overlay-hover animation-hover">
			<a href="{$v.url}" title="{$v.title}" {$g.urlnew}>
				<img class="cover-image" <if value="$v['_index'] gt 3 || $data['page'] gt 1">data-original<else/>src</if>="{$v.imgurl|thumb:$c['met_productimg_x'],$c['met_productimg_y']}" alt="{$v.title}">
				<figcaption class="overlay-panel overlay-background overlay-fade text-xs-center vertical-align" met-imgmask>
					<div class="vertical-align-middle">
						<h4 class="animation-slide-bottom">
							{$v._title}
						</h4>
						<p class='m-b-0 m-t-5 red-600'>{$v.price_str}</p>
					</div>
				</figcaption>
			</a>
		</div>
	</div>
</li>
</if>
<if value="$ui['product_pagetype'] eq 3">
<li <if value="$v['_index'] lt 4">class="shown"</if>>
	<div class="widget widget-shadow">
		<figure class="widget-header cover">
			<a href="{$v.url}" title="{$v.title}" {$g.urlnew}>
				<img class="cover-image" <if value="$v['_index'] gt 3 || $data['page'] gt 1">data-original<else/>src</if>="{$v.imgurl|thumb:$c['met_productimg_x'],$c['met_productimg_y']}" alt="{$v.title}">
			</a>
		</figure>
		<div class="widget-body">
			<h4 class="widget-title">{$v._title}</h4>
			<p class='m-b-0 m-t-5 red-600'>{$v.price_str}</p>
			<list data="$v['para']"  name='$para'>
			<if value="$para['value']">
        	<p class="card-text">{$para.name}&nbsp;:&nbsp;{$para.value}</p>
            </if>
            </list>
            <if value="$v['para_url']">
			<div class='m-y-10'>
                <list data="$v['para_url']" name="$s" num='100'>
                <if value="$s['value']">
                <a href="{$s.value}" class="btn btn-danger m-r-10" target="_blank">{$s.name}</a>
                </if>
                </list>
            </div>
            </if>
            <if value="$v['description']">
        	<p>{$v.description}</p>
            </if>
			<div class="widget-body-footer">
				<div class="widget-actions pull-right">
					<a href="{$v.url}" title="{$v.title}" >
						<i class="icon wb-eye" aria-hidden="true"></i>
						<span>{$v.hits}</span>
					</a>
				</div>
				<a href="{$v.url}" title="{$v.title}" {$g.urlnew} class="btn btn-outline btn-primary btn-squared">{$ui.product_listlook}</a>
			</div>
		</div>
	</div>
</li>
</if>
</list>
</if>