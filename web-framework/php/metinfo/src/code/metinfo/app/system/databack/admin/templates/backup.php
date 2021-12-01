<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="metadmin-fmbx met-databack">
	<h3 class="example-title">{$word.dataexplain5}</h3>
	<dl>
		<dt>
			<label class="form-control-label">{$word.dataexplain10}</label>
		</dt>
		<dd>
			<div class="form-group clearfix">
				<button class="btn btn-primary btn-backdata" data-action="dopackdata">{$word.databackup4}</button>
			</div>
		</dd>
	</dl>
	<h3 class="example-title">{$word.dataexplain6}</h3>
	<dl>
		<dt>
			<label class="form-control-label">{$word.databackup6}</label>
		</dt>
		<dd>
			<div class="form-group clearfix">
				<button class="btn btn-primary btn-backupload" data-action="dopackupload">{$word.databackup4}</button>
			</div>
		</dd>
	</dl>
	<h3 class="example-title">{$word.dataexplain7}</h3>
	<dl>
		<dt>
			<label class="form-control-label">{$word.databackup7}</label>
		</dt>
		<dd>
			<div class="form-group clearfix">
				<button class="btn btn-primary btn-backsite" data-action="doallfile">{$word.databackup8}</button>
				<span class="text-help ml-2">备份时不会将已备份过的整站文件压缩包打包进来</span>
			</div>
		</dd>
	</dl>
</div>