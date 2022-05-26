<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-lang-setting">
	<form method="POST" action="{$url.own_name}c=language_general&a=doSave" class="info-form" data-submit-ajax="1">
		<div class="metadmin-fmbx">
			<dl>
				<dt>
					<label class="form-control-label">{$word.language_backlangchange_v6}</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="checkbox" data-plugin="switchery" name="met_admin_type_ok" value="0"/>
						<span class="text-help ml-2">{$word.langadminyes}</span>
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">{$word.langsw}</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="checkbox" data-plugin="switchery" name="met_lang_mark" value="0"/>
						<span class="text-help ml-2">{$word.langchok}</span>
					</div>
				</dd>
			</dl>

			<dl>
				<dt>
					<label class="form-control-label">{$word.langch}</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="checkbox" data-plugin="switchery" name="met_ch_lang" value="0"/>
						<span class="text-help ml-2">{$word.unitytxt_10}</span>
					</div>
				</dd>
			</dl>
			<dl>
				<dt></dt>
				<dd>
					<button type="submit" class="btn btn-primary">{$word.Submit}</button>
				</dd>
			</dl>
		</div>
	</form>
</div>
