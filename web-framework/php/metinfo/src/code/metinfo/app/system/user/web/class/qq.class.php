<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

load::mod_class('user/web/class/other');

class qq extends other {

	public function __construct() {
		global $_M;
		if(!$_M['config']['met_qq_open']){
			okinfo($_M['url']['login'], $_M['word']['userqqclose']);
		}
		$this->appid = $_M['config']['met_qq_appid'];
		$this->appkey = $_M['config']['met_qq_appsecret'];
		$this->table = $_M['table']['user_other'];
		$this->type = 'qq';
	}	
	
	public function get_login_url(){
		global $_M;

		$redirect_uri = $_M['url']['web_site'].'member/login.php?a=doother_login&type=qq';
		$url = "https://graph.qq.com/oauth2.0/authorize?";
		$url .= "client_id={$this->appid}";
		$url .= "&redirect_uri=".urlencode($redirect_uri);
		$url .= "&response_type=code";	
		$url .= "&scope=get_user_info";	
		$url .= "&state=".$this->get_state();	
		return $url;
	}
	
	public function get_access_token_by_curl($code){
		global $_M;		
        $redirect_uri = $_M['url']['web_site'].'member/login.php?a=doother_login&type=qq';
		$url = "https://graph.qq.com/oauth2.0/token";
		$send['code'] = $code;
		$send['client_id'] = $this->appid;
		$send['client_secret'] = $this->appkey;
		$send['grant_type'] = 'authorization_code';
		$send['redirect_uri'] = $redirect_uri;
		$result = str_replace('callback' , '',load::mod_class('user/web/class/curl_ssl', 'new')->curl_post($url, $send));
		if(strstr($result , 'access_token')){
			$strs = explode('&', $result);
			foreach($strs as $key=>$val){
				list($k, $v) = explode('=', $val);
				$data[$k] = $v;
			}
		}else{
            $data = json_decode($result, true);
		}
		if($this->error_curl($data)){
			return false;
		}
		$url = "https://graph.qq.com/oauth2.0/me";
		$send = array();
		$send['access_token'] = $data['access_token'];
		$result = json_decode(str_replace('callback' , '',load::mod_class('user/web/class/curl_ssl', 'new')->curl_post($url, $send)),true);
		if($this->error_curl($result)){
			return false;
		}
		$data['openid'] = $result['openid'];
		return $data;
	}
	
	public function get_info_by_curl($unionid){
		global $_M;
		$data = $this->get_other_user($unionid);
		$url = "https://graph.qq.com/user/get_user_info";
		$send['access_token'] = $data['access_token'];
		$send['oauth_consumer_key'] = $this->appid;
		$send['openid'] = $data['openid'];
		$data = json_decode(load::mod_class('user/web/class/curl_ssl', 'new')->curl_post($url, $send, 'get'),true);
		$data['username'] = $data['nickname'];
		if($this->error_curl($data)){
			return false;
		}else{
			return $data;	
		}
	}
	
	public function error_curl($data){
		if($data['error']){
			$this->errorno = $data['error_description'] ? $data['error_description'] : $data['error'];
			return true;
		}else{
			return false;
		}
	}
}


# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>