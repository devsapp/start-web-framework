<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-web-set">
	<form method="POST" action="{$url.own_name}c=email&a=doSaveEmail"  class='email-form' data-submit-ajax='1'>
		<div class="metadmin-fmbx">
			<h3 class='example-title'>{$word.setbasicTip6}</h3>
			<dl>
				<dt>
					<label class='form-control-label'>{$word.setbasicFromName}</label>
				</dt>
				<dd>
					<div class='form-group clearfix'>
					<input type="text" name="met_fd_fromname" class="form-control"  >
					<span class="text-help ml-3">{$word.setbasicTip7}</span>
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class='form-control-label'>{$word.setbasicEmailAccount}</label>
				</dt>
				<dd>
					<div class='form-group clearfix'>
					<input type="text" name="met_fd_usename" class="form-control"  >
					<span class="text-help ml-3">{$word.setbasicTip8}</span>
					</div>
				</dd>
			</dl>

		<dl>
				<dt>
					<label class='form-control-label'>{$word.setbasicSMTPPassword}</label>
				</dt>
				<dd>
					<div class='form-group clearfix'>
					<input type="password" name="met_fd_password" class="form-control"  >
					<span class="text-help ml-3">{$word.setbasicTip11}</span>
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class='form-control-label'>{$word.setbasicSMTPServer}</label>
				</dt>
				<dd>
					<div class='form-group clearfix'>
					<input type="text" name="met_fd_smtp" class="form-control"  >
					<span class="text-help ml-3">{$word.setbasicTip10}</span>
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class='form-control-label'>{$word.setbasicSMTPPort}</label>
				</dt>
				<dd>
					<div class='form-group clearfix'>
					<input type="text" name="met_fd_port" class="form-control"  >
					<span class="text-help ml-2">{$word.setbasicTip12}</span>
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class='form-control-label'>{$word.setbasicSMTPWay}</label>
				</dt>
				<dd>
					<div class='form-group clearfix'>
					<div class="custom-control custom-radio ">
						<input type="radio" id="radio_ssl" name="met_fd_way" value='ssl'   class="custom-control-input" />
						<label class="custom-control-label" for="radio_ssl">{$word.ssl}</label>
					</div>
					<div class="custom-control custom-radio ">
						<input type="radio" id="radio_tls" name="met_fd_way" value='tls' class="custom-control-input"/>
						<label class="custom-control-label" for="radio_tls">{$word.tls}</label>
					</div>
					<span class="text-help ml-3">{$word.setbasicTip13}</span>
					</div>
				</dd>
			</dl>
			<dl>
				<dt></dt>
				<dd>
					<button  type="submit" class='btn btn-default' id="btn-test" data-url="{$url.own_name}c=email&a=doTestEmail">{$word.upfiletips16}</button>
					<button  type="submit"  class='btn btn-primary' id="btn-save" >{$word.save}</button>
				</dd>
			</dl>
		</div>
	</form>
</div>