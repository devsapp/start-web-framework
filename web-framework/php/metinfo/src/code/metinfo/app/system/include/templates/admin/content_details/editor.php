<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$editor['title']=$editor['title']?$editor['title']:$word['contentdetail'];
$editor['name']=$editor['name']?$editor['name']:'content';
$editor['value']=$editor['value']?$editor['value']:$data['list']['content'];
$data['classnow']=intval($data['list']['class3'])?$data['list']['class3']:(intval($data['list']['class2'])?$data['list']['class2']:$data['list']['class1']);
?>
<h3 class='example-title'>{$editor.title}<if value="$data['n'] eq 'about'"><a href="{$url.site_admin}#/column" target="_blank" class="text-help ml-2">{$word.admin_colunmmanage_v6}</a></if></h3>
<dl>
	<dd>
		<if value="$data['n'] eq 'product'">
		<?php
		$checkbox_time=time();
		for ($i = 1; $i < 5; $i++) {
			$product_content[]=array(
				'value'=>$data['list']['content'.$i]
			);
		}
		?>
		<div class="nav nav-underline product-details-navtab position-relative" data-url="{$url.own_name}c=product_admin&a=doGetColumnSeting">
			<a class="nav-link active" data-toggle="tab" href="#product-content-{$checkbox_time}"></a>
			<list data="$product_content" name="$v">
			<?php $v['sort']=$v['_index']+1; ?>
			<a class="nav-link" data-toggle="tab" href="#product-content{$v.sort}-{$checkbox_time}"></a>
			</list>
			<button type="button" class="btn btn-outline-primary ml-2 position-absolute" style="right:0;top: 0;" data-toggle="modal" data-target=".product-details-tabset-modal" data-modal-url="ui_set/page_config/?n=column&c=index&a=doGetClassExtInfo&module=3&id=0&from=admin&classnow={$data.classnow}" data-modal-title="{$word.settings_tab}" data-modal-style="z-index:1702;">{$word.settings_tab}</button>
		</div>
		<div class="tab-content mt-2 product-details-content hide">
			<div class="tab-pane fade show active" id="product-content-{$checkbox_time}">
				<textarea name="{$editor.name}" data-plugin='editor' data-editor-y='<if value="$editor['height']">{$editor.height}<else/>500</if>' hidden>{$editor.value}</textarea>
			</div>
			<list data="$product_content" name="$v">
			<?php $v['sort']=$v['_index']+1; ?>
			<div class="tab-pane fade" id="product-content{$v.sort}-{$checkbox_time}">
				<textarea name="content{$v.sort}" data-plugin='editor' data-editor-y='<if value="$editor['height']">{$editor.height}<else/>500</if>' hidden>{$v.value}</textarea>
			</div>
			</list>
		</div>
		<else/>
		<textarea name="{$editor.name}" data-plugin='editor' data-editor-y='<if value="$editor['height']">{$editor.height}<else/>500</if>' hidden>{$editor.value}</textarea>
		</if>
	</dd>
</dl>
<?php unset($editor); ?>