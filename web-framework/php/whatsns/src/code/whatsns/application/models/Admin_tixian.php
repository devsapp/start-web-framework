<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_tixian extends CI_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'tixian_model' );
	}

	function index($message = '') {

		if (empty ( $message ))
			unset ( $message );

		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 100;
		$startindex = ($page - 1) * $pagesize;

		$tixianlist = $this->tixian_model->get_list ( $startindex, $pagesize );

		$rownum = returnarraynum ( $this->db->query ( getwheresql ( "user_tixian", " state=0", $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "admin_tixian/default" );
		include template ( "tixianshenhe", "admin" );
	}
	function ganxie() {
		$uid = intval ( $this->uri->segment ( 3 ) );

		$user = $this->user_model->get_by_uid ( $uid );
		$username = $user ['username'];
		if ($user ['openid'] == '' || $user ['openid'] == null) {
			exit ( "此用户没有绑定微信" );
		}

		require_once FCPATH."lib/wxpay/lib/WxPay.Api.php";

		$data ['mch_appid'] = WxPayConfig::APPID; //商户的应用appid
		$data ['mchid'] = WxPayConfig::MCHID; //商户ID
		$data ['nonce_str'] = WxPayApi::getNonceStr (); //unicode();//这个据说是唯一的字符串下面有方法
		$data ['partner_trade_no'] = time (); //.time();//这个是订单号。
		$data ['openid'] = $user ['openid']; //这个是授权用户的openid。。这个必须得是用户授权才能用
		$data ['check_name'] = 'NO_CHECK'; //这个是设置是否检测用户真实姓名的


		$data ['amount'] = 100; //感谢金额
		$data ['desc'] = '亲爱的' . $username . '，欢迎注册' . $this->setting ['site_name'] . ',站长赠送你1元表示感谢'; //描述
		$data ['spbill_create_ip'] = $_SERVER ['SERVER_ADDR']; //这个最烦了，，还得获取服务器的ip
		$secrect_key = WxPayConfig::KEY; ///这个就是个API密码。32位的。。随便MD5一下就可以了
		//echo $secrect_key;
		//var_dump($data);
		$data = array_filter ( $data );
		ksort ( $data );
		$str = '';
		foreach ( $data as $k => $v ) {
			$str .= $k . '=' . $v . '&';
		}
		$str .= 'key=' . $secrect_key;

		$data ['sign'] = strtoupper ( md5 ( $str ) );
		$xml = $this->arraytoxml ( $data );

		$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
		$res = $this->curl ( $xml, $url );
		$return = $this->xmltoarray ( $res );
		if ($return ['result_code'] == 'FAIL') {
			echo $return ['err_code_des'] . ",<a style='color:red;cursor:pointer;' onclick='window.history.go(-1)'>返回</a>";
			exit ();
		}

		//Array ( [return_code] => SUCCESS [return_msg] => Array ( ) [mch_appid] => wx7bf8d49854dee219 [mchid] => 1247313701 [device_info] => Array ( ) [nonce_str] => y1q8sybyp32uh182hjco2x5on16k32hn [result_code] => SUCCESS [partner_trade_no] => 1486458905 [payment_no] => 1000018301201702076307569052 [payment_time] => 2017-02-07 17:15:06 )
		if ($return ['result_code'] == 'SUCCESS') {

			exit ( "感谢成功,<a style='color:red;cursor:pointer;' onclick='window.history.go(-1)'>返回</a>" );
		}
	}
	function queren() {
		$uid = intval ( $this->uri->segment ( 3 ) );

		$user = $this->user_model->get_by_uid ( $uid );
		$username = $user ['username'];
		if ($user ['openid'] == '' || $user ['openid'] == null) {
			exit ( "此用户没有绑定微信" );
		}
		//获取提现金额--资金托管
		$tixianfei = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user_depositmoney WHERE `state`=0 and type='usertixian' and touid='$uid'" )->row_array ();
		//托管金额
		$tgjine = doubleval ( $tixianfei ['needpay'] );

		//返回到用户账户里
		$tpshangjin = $tgjine * 100;
		$usertotalmoney = $tpshangjin + $user ['jine'];
		$tixianfei = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user_tixian WHERE `state`=0 and uid='$uid'" )->row_array ();
		$rmb = 0;
		$user_rmb = doubleval ( $tixianfei ['jine'] ) * 100;
		if ($usertotalmoney < $tixianfei ['jine']) {
			exit ( "用户钱包可以用金额小于提现金额，提现失败，可能有部分资金托管中,<a style='color:red;cursor:pointer;' onclick='window.history.go(-1)'>返回</a>" );
		}
		if (! isset ( $user_rmb )) {
			$rmb = 0;
		} else {
			$rmb = $user_rmb;
		}
		$tixianjine = $this->setting ['tixianjine'] ? $this->setting ['tixianjine'] : 1;
		$tixianjine = doubleval ( $tixianjine );
		if ($rmb < ($tixianjine * 100)) {
			exit ( "Ta的提现金额小于平台设置的最小可提现金额" . $tixianjine . "块钱，无法提现,<a  style='color:red;cursor:pointer;' onclick='window.history.go(-1)'>返回</a>" );
		}

		// $rmb=$rmb*100;
		$tixianfeilv = $this->setting ['tixianfeilv'] ? $this->setting ['tixianfeilv'] : 0;
		$tixianfeilv = doubleval ( $tixianfeilv );
		$lastrmb = $rmb - $rmb * $tixianfeilv; //最终可以提现金额=初始金额-扣除手续费
		if ($lastrmb < 100) {
			exit ( "微信规定最小提现金额不能小于1元，当前提现金额为" . ($lastrmb / 100) . "元此次提现失败,<a style='color:red;cursor:pointer;' onclick='window.history.go(-1)'>返回</a>" );
		}
		require_once FCPATH."lib/wxpay/lib/WxPay.Api.php";

		$data ['mch_appid'] = WxPayConfig::APPID; //商户的应用appid
		$data ['mchid'] = WxPayConfig::MCHID; //商户ID
		$data ['nonce_str'] = WxPayApi::getNonceStr (); //unicode();//这个据说是唯一的字符串下面有方法
		$data ['partner_trade_no'] = time (); //.time();//这个是订单号。
		$data ['openid'] = $user ['openid']; //这个是授权用户的openid。。这个必须得是用户授权才能用
		$data ['check_name'] = 'NO_CHECK'; //这个是设置是否检测用户真实姓名的


		$data ['amount'] = $lastrmb; //提现金额
		$data ['desc'] = '打赏' . $username . '提现支付,扣除手续费' . (($rmb * $tixianfeilv) / 100) . "元"; //订单描述
		$data ['spbill_create_ip'] = $_SERVER ['SERVER_ADDR']; //这个最烦了，，还得获取服务器的ip
		$secrect_key = WxPayConfig::KEY; ///这个就是个API密码。32位的。。随便MD5一下就可以了
		//echo $secrect_key;
		//var_dump($data);
		$data = array_filter ( $data );
		ksort ( $data );
		$str = '';
		foreach ( $data as $k => $v ) {
			$str .= $k . '=' . $v . '&';
		}
		$str .= 'key=' . $secrect_key;

		$data ['sign'] = strtoupper ( md5 ( $str ) );
		$xml = $this->arraytoxml ( $data );

		$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
		$res = $this->curl ( $xml, $url );
		$return = $this->xmltoarray ( $res );
		if ($return ['result_code'] == 'FAIL') {
			echo $return ['err_code_des'] . ",<a style='color:red;cursor:pointer;' onclick='window.history.go(-1)'>返回</a>";
			exit ();
		}

		if ($return ['result_code'] == 'SUCCESS') {
			$this->db->query ( "UPDATE " . $this->db->dbprefix . "weixin_notify SET  `haspay`=1 WHERE `touid`=$uid" );
			$this->db->query ( "UPDATE " . $this->db->dbprefix . "user_tixian SET  `state`=1 WHERE `uid`=$uid" );
			//删除托管金额
			$this->db->query ( "DELETE FROM " . $this->db->dbprefix . "user_depositmoney WHERE `state`=0 and type='usertixian' and fromuid='$uid'" );
			$time_end=time();
			$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "paylog SET type='confirmtixian',typeid=0,money=" . doubleval($lastrmb/100). ",openid='',fromuid=0,touid=$uid,`time`=$time_end" );
			
			$this->index ( "提现处理成功" );
		}
	}
	function arraytoxml($data) {
		$str = '<xml>';
		foreach ( $data as $k => $v ) {
			$str .= '<' . $k . '>' . $v . '</' . $k . '>';
		}
		$str .= '</xml>';
		return $str;
	}
	function xmltoarray($xml) {
		//禁止引用外部xml实体
		libxml_disable_entity_loader ( true );
		$xmlstring = simplexml_load_string ( $xml, 'SimpleXMLElement', LIBXML_NOCDATA );
		$val = json_decode ( json_encode ( $xmlstring ), true );
		return $val;
	}
	function curl($param = "", $url) {

		$postUrl = $url;
		$curlPost = $param;
		$ch = curl_init (); //初始化curl
		curl_setopt ( $ch, CURLOPT_URL, $postUrl ); //抓取指定网页
		curl_setopt ( $ch, CURLOPT_HEADER, 0 ); //设置header
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 ); //要求结果为字符串且输出到屏幕上
		curl_setopt ( $ch, CURLOPT_POST, 1 ); //post提交方式
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $curlPost ); // 增加 HTTP Header（头）里的字段
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE ); // 终止从服务端进行验证
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
		curl_setopt ( $ch, CURLOPT_SSLCERT, WxPayConfig::SSLCERT_PATH ); //这个是证书的位置
		curl_setopt ( $ch, CURLOPT_SSLKEY, WxPayConfig::SSLKEY_PATH ); //这个也是证书的位置
		$data = curl_exec ( $ch ); //运行curl
		curl_close ( $ch );
		return $data;
	}
	//不合规提现取消操作
	function deletetixian() {
		$uid = intval ( $this->uri->segment ( 3 ) );
		//获取提现金额--资金托管
		$tixianfei = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user_depositmoney WHERE `state`=0 and type='usertixian' and fromuid='$uid'" )->row_array ();
		//托管金额
		$tgjine = doubleval ( $tixianfei ['needpay'] );

		//返回到用户账户里
		$tpshangjin = $tgjine * 100;
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET  `jine`=jine+'$tpshangjin' WHERE `uid`=$uid" );
		//删除托管金额
		$this->db->query ( "DELETE FROM " . $this->db->dbprefix . "user_depositmoney WHERE `state`=0 and type='usertixian' and fromuid='$uid'" );
		//记录删除日志
		$time = time ();
		$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "paylog SET type='thusertixian',typeid=$uid,money=$tgjine,openid='',fromuid=0,touid=$uid,`time`=$time" );

		//删掉提现请求
		$rqtixianfei = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user_tixian WHERE `state`=0 and `uid`=$uid" )->row_array ();

		$id = $rqtixianfei ['id'];

		$this->db->query ( "DELETE FROM " . $this->db->dbprefix . "user_tixian where id=$id" );

		//提现用户发起通知
		$url = '';
		$text = "您申请提现$tgjine元请求被驳回!如有问题请联系客服<br>驳回时间:".date ( "Y-m-d H:i" );
		$quser = $this->user_model->get_by_uid ( $uid );
		$wx = $this->fromcache ( 'cweixin' );
		//
		if ($wx ['appsecret'] != '' && $wx ['appsecret'] != null && $wx ['winxintype'] != 2) {
			require FCPATH . '/lib/php/jssdk.php';
			$appid = $wx ['appid'];
			$appsecret = $wx ['appsecret'];
			$jssdk = new JSSDK ( $appid, $appsecret );

			if ($quser ['openid'] != '' && $quser ['openid'] != null) {
				if (! $this->setting ['weixin_tpl_tixianjieguo']) {
					$returnmesage = $jssdk->sendtexttouser ( $quser ['openid'], $text );
				} else {
					$returnmesage = $jssdk->sendtixianjieguotpltouser ( $quser ['openid'], $this->setting ['weixin_tpl_tixianjieguo'], $url, "您申请提现请求被驳回!",$tgjine."元","微信零钱",date("Y-m-d H:i",$tixianfei ['time']), "驳回",date ( "Y-m-d H:i" ), "有任何疑问，请联系客服。" );
				}

			}
		}
		$this->message ( '驳回成功！', 'admin_tixian' );
	}
	function view() {

		@$page = max ( 1, intval ( $this->uri->segment ( 4 ) ) );
		$pagesize = 200;
		$startindex = ($page - 1) * $pagesize;

		$uid = intval ( $this->uri->segment ( 3 ) );
		$touser = $this->user_model->get_by_uid ( $uid );

		$tixianfei = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user_tixian WHERE `state`=0 and uid='$uid'" )->row_array ();
		$this->load->model ( 'userbank_model' );

		$moenylist = $this->userbank_model->getzhangdan ( $uid, $startindex, $pagesize );

		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'paylog', " touid=$uid", $this->db->dbprefix ) )->row_array () );

		$departstr = page ( $rownum, $pagesize, $page, "admin_tixian/view" );
		include template ( "tixianview", "admin" );
	}

}

?>