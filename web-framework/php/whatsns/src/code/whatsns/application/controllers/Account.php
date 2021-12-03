<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Account extends CI_Controller {
	var $whitelist;
	function __construct() {
		$this->whitelist = "index,bind,bindregister";
		parent::__construct ();
		$this->load->model ( 'weixin_setting_model' );
	}
	function index() {
		$this->message ( '亲，你进错地方了', 'index' );
	}
	function bind() {
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		if (! strstr ( $useragent, 'MicroMessenger' )) {

			$this->message ( '只能微信里绑定哟，您就别费劲想耍花招了', 'index' );
		}
		$wx = $this->weixin_setting_model->get ();

		if (empty ( $wx ['appsecret'] ) || empty ( $wx ['appid'] )) {
			exit ( "公众号配置中 appid和appsecret没有填写，创建菜单必须认证公众号!" );
		}

		$appid = $wx ['appid'];
		$appsecret = $wx ['appsecret'];
		//獲取openid代碼
		$code = $_GET ['code'];
		if (! isset ( $code )) {
			//如果沒有code走網頁授權獲取
			$rurl = SITE_URL . 'index.php?account/bind';
			$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$rurl&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
			header ( "Location:$url" );
		} else {
			$weixin = file_get_contents ( "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=" . $code . "&grant_type=authorization_code" ); //通过code换取网页授权access_token
			$jsondecode = json_decode ( $weixin ); //对JSON格式的字符串进行编码
			$array = get_object_vars ( $jsondecode ); //转换成数组
			$openid = $array ['openid']; //输出openid

		}
		$getone = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user where openid='$openid' limit 0,1" )->row_array ();
		if ($getone != null) {
			$this->message ( '您已经绑定账号了', 'index' );
		}
		include template ( 'bindaccount' );
	}
	function bindregister() {
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		if (! strstr ( $useragent, 'MicroMessenger' )) {
			$this->message ( '只能微信里绑定哟，您就别费劲想耍花招了', 'index' );
		}
		$wx = $this->weixin_setting_model->get ();

		if (empty ( $wx ['appsecret'] ) || empty ( $wx ['appid'] )) {
			exit ( "公众号配置中 appid和appsecret没有填写，创建菜单必须认证公众号!" );
		}

		$appid = $wx ['appid'];
		$appsecret = $wx ['appsecret'];
		//獲取openid代碼
		$code = $_GET ['code'];
		if (! isset ( $code )) {
			//如果沒有code走網頁授權獲取
			$rurl = SITE_URL . $this->setting ['seo_prefix'].'account/bindregister'.$this->config->item ( 'url_suffix' );
			$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$rurl&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
			header ( "Location:$url" );
		} else {
			$weixin = file_get_contents ( "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=" . $code . "&grant_type=authorization_code" ); //通过code换取网页授权access_token
			$jsondecode = json_decode ( $weixin ); //对JSON格式的字符串进行编码
			$array = get_object_vars ( $jsondecode ); //转换成数组
			$openid = $array ['openid']; //输出openid

		}
		$getone = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user where openid='$openid' limit 0,1" )->row_array ();
		if ($getone != null) {
			$this->message ( '您已经绑定账号了', 'index' );
		}
		include template ( 'bindaccountreg' );
	}
}
