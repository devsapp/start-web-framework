<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
if (is_array($data) && is_array($data['handle'])) {
    $data = array_merge($data, $data['handle']);
    unset($data['handle']);
}
$data['page_type'] = $data['a'] == 'doeditor' ? 'details' : 'add';
?>
<form method="POST" action="{$url.own_name}c={$data.c}&a={$data.a}save&id={$data.list.id}&addtime_l={$data.list.addtime}&no_order={$data.list.no_order}" class='{$data.n}-{$data.page_type}-form' data-validate_order=".{$data.n}-{$data.page_type}-form" data-submit-ajax='1' enctype="multipart/form-data">
	<div class="metadmin-fmbx">
		<if value="$data['displayimgs']"><div hidden></if>
		<h3 class='example-title'>{$word.upfiletips7}</h3>
		<dl>
			<dt>
				<label class='form-control-label'>
					<span class="text-danger">*</span>
					{$word.category}
				</label>
			</dt>
			<dd>
				<div class='form-group clearfix'>
					<if value="$data['n'] eq 'product'">
					<div class="content-details-column">
						<select name="class" class="form-control mr-3 met-scrollbar scrollbar-grey" data-checked="{$data.list.class1}-{$data.list.class2}-{$data.list.class3}{$data.list.classother_str}" required multiple data-fv-notEmpty-message="{$word.selectcolumn}" style="min-height:250px;">
							<list data="$data['columnlist']" name="$a" num="500">
							<if value="$a['p']['value']">
							<option value="{$a.p.value}-0-0" class="text-wrap">{$a.p.name}</option>
								<if value="$a['c']">
								<list data="$a['c']" name="$b" num="500">
								<if value="$b['n']['value']">
								<option value="{$a.p.value}-{$b.n.value}-0" class="text-wrap sub sub2 <if value="$b['_index'] eq 1">first</if>">{$b.n.name}</option>
									<if value="$b['a']">
									<list data="$b['a']" name="$d" num="500">
									<if value="$d['s']['value']">
									<option value="{$a.p.value}-{$b.n.value}-{$d.s.value}" class="text-wrap sub sub3 <if value="$d['_index'] eq 1">first</if>">{$d.s.name}</option>
									</if>
									</list>
									</if>
								</if>
								</list>
								</if>
							</if>
							</list>
						</select>
						<input type="hidden" name="class1" value="{$data.list.class1}">
						<input type="hidden" name="class2" value="{$data.list.class2}">
						<input type="hidden" name="class3" value="{$data.list.class3}">
						<input type="hidden" name="classother" value="{$data.list.classother}">
					</div>
					<else/>
					<?php
					!$data['list']['class1'] && $data['list']['class1']='';
					!$data['list']['class2'] && $data['list']['class2']='';
					!$data['list']['class3'] && $data['list']['class3']='';
					?>
					<div data-plugin='select-linkage' data-select-url="json" data-required="1" data-value_key="value" class="clearfix float-left mr-3 content-details-column">
						<textarea class="select-linkage-data" hidden>{$data.columnlist_json}</textarea>
						<select name="class1" class="form-control mr-1 w-a prov" data-checked="{$data.list.class1}" required data-fv-notEmpty-message="{$word.selectcolumn}"></select>
						<select name="class2" class="form-control mr-1 w-a city" data-checked="{$data.list.class2}" required data-fv-notEmpty-message="{$word.selectcolumn}"></select>
						<select name="class3" class="form-control mr-1 w-a dist" data-checked="{$data.list.class3}" required data-fv-notEmpty-message="{$word.selectcolumn}"></select>
					</div>
					</if>
					<?php
					$arrlanguage=$_COOKIE['arrlanguage'];
					$arrlanguage=explode('|',$arrlanguage);
					?>
					<if value="in_array('metinfo',$arrlanguage)||in_array('1201',$arrlanguage)">
					<a href="{$url.site_admin}#/column" target="_blank" class="text-help">{$word.admin_colunmmanage_v6}</a>
					</if>
				</div>
				<if value="$data['n'] eq 'product'">
				<span class="text-help">{$word.tips12_v6}</span>
				</if>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>
					<span class="text-danger">*</span>
					<if value="$data['n'] eq 'news'">{$word.articletitle}<elseif value="$data['n'] eq 'product'"/>{$word.titletips}<else/>{$word.title}</if>
				</label>
			</dt>
			<dd>
				<div class='form-group clearfix'>
					<input type="text" name="title" value="{$data.list.title}" required class="form-control">
				</div>
				<div class="clearfix">
					<span class="text-help text-content float-left">{$word.text_size}{$word.marks}</span>
					<input type="text" name="text_size" value="{$data.list.text_size}" data-plugin="select-fontsize" class="form-control d-inline-block mr-2" style="width:100px;">
					<span class="text-help text-content float-left">{$word.text_color}{$word.marks}</span>
					<input type="text" name="text_color" value="{$data.list.text_color}" data-plugin="minicolors" class="form-control w-a d-inline-block">
					<span class="text-help ml-2">{$word.content_style_tips}</span>
				</div>
			</dd>
		</dl>