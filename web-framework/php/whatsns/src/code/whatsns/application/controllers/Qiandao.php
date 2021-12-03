<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Qiandao extends CI_Controller {
	var $whitelist;
	function __construct() {
		$this->whitelist = "index,gethongbao";
		parent::__construct ();

	}
	function index() {
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		$wx = $this->fromcache ( 'cweixin' );

		if (strstr ( $useragent, 'MicroMessenger' ) && $wx ['appsecret'] != '' && $wx ['appsecret'] != null) {

			$appid = $wx ['appid'];
			$appsecret = $wx ['appsecret'];

			require FCPATH . '/lib/php/jssdk.php';
			$jssdk = new JSSDK ( $appid, $appsecret );
			$signPackage = $jssdk->GetSignPackage ();

		} else {
			$result= "请在微信公众号里签到，谢谢！" ;
			
			include template ( 'huodongresult' );
			
			exit ();
			
			
		}
		$navtitle = "端午节领红包活动";
		include template ( 'qiandao' );
	}

	function gethongbao() {
		
		//入口文件
		@require FCPATH . 'lib/wxpay/hongbao/pay.php';
		$packet = new Packet ();
		//获取用户信息
		$get = $this->uri->segment ( 3 );

		$code = $_GET ['code'];

		//判断code是否存在
		if ($get == 'access_token' && ! empty ( $code )) {
			$param ['param'] = 'access_token';
			$param ['code'] = $code;

			//获取用户openid信息
			$userinfo = $packet->_route ( 'userinfo', $param );

			if (empty ( $userinfo ['openid'] )) {
				
				$result= "网页授权失败，请重新打开网页!";
				include template ( 'huodongresult' );
				
				exit ();
			}
		    //获取中奖名单
			$modellist = array ();
			$query = $this->db->query ( "SELECT distinct a.openid,a.nickname,a.headimgurl,b.time,b.jine FROM " . $this->db->dbprefix . "weixin_follower as a, " . $this->db->dbprefix . "weixin_hongbao as b where a.openid=b.opneid and b.state=2 order by b.time desc LIMIT 0,10" );
			foreach ( $query->result_array () as $model ) {
				$model['time']=tdate($model['time']);
				$modellist [] = $model;
			}
		
			$ttime = time ();
			if ($ttime < "1529323200"||$ttime > "1529326800") {
				$result= "感谢参与，本轮活动已经结束，红包已经领取完毕!";
				include template ( 'huodongresult' );
			
				exit ();
				
			}
			$openid = $userinfo ['openid'];
			$username = $userinfo ['nickname'];
			$one = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "weixin_hongbao WHERE opneid='$openid' and state=2 " )->row_array();
			//$this->db->fetch_first ( "SELECT * FROM " . $this->db->dbprefix . "weixin_hongbao WHERE opneid='$openid'" );

			if ($one) {
				$result= "您已经领取过红包了!";
			
				include template ( 'huodongresult' );
				
				exit ();
			}
			$jine=rand(100,1500);
			//调取支付方法
			$result = $packet->_route ( 'wxpacket', array ('openid' => $userinfo ['openid'] ,'jine'=>$jine) );
			//
			switch ($result) {
				case 'SUCCESS' :
 $time=time();
 $jine=$jine/100;
					$this->db->query ( 'INSERT INTO ' . $this->db->dbprefix . "weixin_hongbao(opneid,username,time,state,jine) values ('$openid','$username',$time,2,$jine)" );
					// echo 'INSERT INTO ' . $this->db->dbprefix . "weixin_hongbao(opneid,username,time) values ('$openid','$username','{$this->base->time}')";
					$result= "红包已经发放到公众号内，请点击领取，感谢参与!";
					
					include template ( 'huodongresult' );
					
					exit ();

					break;
				default :
					$result= "来晚了，红包已经领完!";
					
					include template ( 'huodongresult' );
					
					exit ();
					break;
			}
			exit ();
		} else {

			$packet->_route ( 'userinfo' );
		}
	}

}