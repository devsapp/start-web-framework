<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

load::mod_class('user/web/class/other');

class weixin extends other {

	public function __construct() {
		global $_M;
		if(!$_M['config']['met_weixin_open']){
			okinfo($_M['url']['login'], $_M['word']['userwenxinclose']);
		}
		if(is_weixin_client()){
			$this->appid = $_M['config']['met_weixin_gz_appid'];
			$this->appkey = $_M['config']['met_weixin_gz_appsecret'];
		}else{
			$this->appid = $_M['config']['met_weixin_appid'];
			$this->appkey = $_M['config']['met_weixin_appsecret'];
		}
		$this->table = $_M['table']['user_other'];
		$this->type = 'weixin';
	}	
	
	public function get_login_url(){
		global $_M;
		$redirect_uri = $_M['url']['web_site'].'member/login.php?a=doother_login&type=weixin';
        $url = '';
		if(is_weixin_client()){
			$url .= "https://open.weixin.qq.com/connect/oauth2/authorize?";
			$url .= "appid={$this->appid}";
			$url .= "&redirect_uri=".urlencode($redirect_uri);
			$url .= "&response_type=code";	
			$url .= "&scope=snsapi_userinfo";	
			$url .= "&state=".$this->get_state();	
			$url .= '#wechat_redirect';
		}else{
			$url .= "https://open.weixin.qq.com/connect/qrconnect?";
			$url .= "appid={$this->appid}";
			$url .= "&redirect_uri=".urlencode($redirect_uri);
			$url .= "&response_type=code";	
			$url .= "&scope=snsapi_login";	
			$url .= "&state=".$this->get_state();	
			$url .= '#wechat_redirect';
		}
            return $url;
	}
	
	public function get_access_token_by_curl($code){
		global $_M;		
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token";
		$send['code'] = $code;
		$send['appid'] = $this->appid;
		$send['secret'] = $this->appkey;
		$send['grant_type'] = 'authorization_code';

        $data = json_decode(load::mod_class('user/web/class/curl_ssl', 'new')->curl_post($url, $send), true);
        //$data['unionid'] = $data['openid'];

		if($this->error_curl($data)){
			return false;
		}else{
			return $data;
		}		
	}
	
	public function get_info_by_curl($openid){
		global $_M;
		$data = $this->get_other_user($openid);
		$url = "https://api.weixin.qq.com/sns/userinfo";
		$send['access_token'] = $data['access_token'];
		$send['openid'] = $data['openid'];
        $data = json_decode(load::mod_class('user/web/class/curl_ssl', 'new')->curl_post($url, $send, 'get'), true);
		$data['username'] = $data['nickname'];
		if($this->error_curl($data)){
			return false;
		}else{
			return $data;	
		}
	}
	
	public function error_curl($data){
		if($data['errcode']){
			$this->errorno = $data['errmsg'] ? $data['errmsg'] : $data['errcode'];
			return true;
		}else{
			return false;
		}
	}
}


# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>