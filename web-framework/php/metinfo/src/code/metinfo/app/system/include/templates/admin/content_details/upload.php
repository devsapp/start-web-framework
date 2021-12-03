<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<dl>
	<dt>
		<label class='form-control-label'>
			<if value="$upload['required']"><span class="text-danger">*</span></if>
			{$upload.title}
		</label>
	</dt>
	<dd>
		<div class='form-group clearfix'>
			<if value="$upload['name'] eq 'downloadurl1'">
			<input type="text" name="downloadurl" value="{$upload.value}" class="form-control mr-1">
			</if>
			<div class="d-inline-block mr-2">
				<input type="file" name="{$upload.name}" value="{$upload.value}"
				<if value="$upload['required']">data-filerequired='1' data-notEmpty-message="{$word.js15}"</if>
				data-plugin='fileinput'
				<if value="$upload['drop_zone_enabled']">data-drop-zone-enabled="false"</if>
				<if value="$upload['preview_class']">data-preview-class='{$upload.preview_class}'</if>
				<if value="$upload['noprogress']">data-noprogress='1'</if>
				<if value="$upload['noimage']">data-noimage='1'</if>
				<if value="$upload['size']">data-size='1'</if>
				<if value="$upload['multiple']">multiple</if>
				<if value="$upload['delimiter']">data-delimiter='{$upload.delimiter}'</if>
				<if value="$upload['type'] eq 'file'">
				accept="*"
				<elseif value="$upload['type'] eq 'image' || !$upload['type']" />
				accept="image/*"
				<else/>
				accept="{$upload.type}"
				</if>
				<if value="$upload['format']">data-format="{$upload.format}"</if>
				<if value="$upload['callback']">data-callback="{$upload.callback}"</if>
				<if value="$upload['attr']">{$upload.attr}</if>
				>
			</div>
			<if value="$upload['tips']">
			<span class="text-help">{$upload.tips}</span>
			</if>
		</div>
		<if value="$data['n'] eq 'product' && $upload['name'] eq 'imgurl'">
		<div class="mb-2">
			<button type="button" class="btn btn-primary" data-target=".product-video-collapse" data-toggle="collapse">{$word.show_video}<i class="icon fa-caret-right ml-2"></i></button>
			<a href="{$url.site_admin}#/safe/?head_tab_active=0" class="btn btn-outline-primary ml-2" target="_blank">{$word.video_switch}</a>
		</div>
		<div class="collapse product-video-collapse">
			<textarea name="video" data-plugin='editor' data-editor-y='200' hidden>{$data.list.video}</textarea>
			<span class="text-help ml-1">{$word.show_video_tips}</span>
		</div>
		</if>
	</dd>
</dl>
<?php unset($upload); ?>