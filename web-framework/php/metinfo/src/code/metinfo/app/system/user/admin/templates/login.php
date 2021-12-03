<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-user-func">
	<form method="POST" action="{$url.own_name}c=admin_set&a=doSaveThirdParty" class="info-form" data-submit-ajax='1'>
		<div class="metadmin-fmbx">
			<h3 class="example-title">{$word.user_global_set}</h3>
            <dl>
                <dt>
                    <label class="form-control-label">{$word.user_auto_register}</label>
                </dt>
                <dd>
                    <div class="form-group clearfix">
                        <input type="checkbox" data-plugin="switchery" name="met_auto_register" value="0"  />
                        <span class="text-help">{$word.user_auto_register_tips}</span>
                    </div>
                </dd>
            </dl>

			<h3 class="example-title">QQ</h3>
			<dl>
				<dd>
					<span class="text-help">
                        {$word.user_tips8_v6}
						<a href="http://connect.qq.com/" target="_blank">{$word.user_QQinterconnect_v6}</a>
						{$word.user_tips9_v6}
                    </span>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">{$word.qqlogin}</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="checkbox" data-plugin="switchery" name="met_qq_open" value="0"  />
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">App ID</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="text" name="met_qq_appid" class="form-control" />
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">App Key</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="text" name="met_qq_appsecret" class="form-control" />
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">{$word.user_backurl_v6}</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						{$url.web_site}member/login.php
					</div>
				</dd>
			</dl>
			<h3 class="example-title">{$word.pay_WeChat_v6}</h3>
			<dl>
				<dd>
					<span class="text-help"
						>{$word.user_tips8_v6}
						<a href="https://mp.weixin.qq.com/" target="_blank"
							>{$_M['word']['user_publicplatform_v6']}</a
						>
						{$word.user_Apply_v6}</span
					>
					<span class="text-help">{$_M['word']['user_tips13_v6']}{$_M['word']['user_tips14_v6']}</span>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">{$word.weixinlogin}</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="checkbox" data-plugin="switchery" name="met_weixin_open" value="0"   />
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">{$word.user_publicplatform_v6}App ID</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="text" name="met_weixin_gz_appid" class="form-control" />
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">{$word.user_publicplatform_v6}App Secret</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="text" name="met_weixin_gz_appsecret" class="form-control" />
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">{$word.user_publicplatform_v6}Token</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="text" name="met_weixin_gz_token" class="form-control"/>
						<span class="text-help ml-2">填写的Token跟微信公众平台配置的Token一样</span>
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">{$word.user_publicplatform_v6}接口URL</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="text" name="met_weixin_gz_url" class="form-control" readonly="true" />
						<span class="text-help ml-2">复制到公众平台-基本配置-服务器地址（URL）</span>
					</div>
				</dd>
			</dl>
			<h3 class="example-title">{$word.user_tips15_v6}</h3>
			<dl>
				<dd>
					<span class="text-help"
						>{$word.user_tips8_v6}
						<a href="http://open.weibo.com/authentication/" target="_blank">{$word.user_tips16_v6}</a>
						{$word.user_tips9_v6}</span
					>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">{$word.sinalogin}</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="checkbox" data-plugin="switchery" name="met_weibo_open" value="0"   />
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">App Key</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="text" name="met_weibo_appkey" class="form-control" />
					</div>
				</dd>
			</dl>
			<dl>
				<dt>
					<label class="form-control-label">App Secret</label>
				</dt>
				<dd>
					<div class="form-group clearfix">
						<input type="text" name="met_weibo_appsecret" class="form-control" />
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
