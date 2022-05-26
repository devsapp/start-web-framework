<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_vertifyuser extends ADMIN_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'vertify_model' );
	}

	function index($message = '') {
		if (empty ( $message ))
			unset ( $message );
		$status =0;
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$vertifylist = $this->vertify_model->get_list ( $status, $startindex, $pagesize );
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( "vertify", "status=0", $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "admin_vertifyuser/default" );

		include template ( "vertifylist", "admin" );
	}
	function userlist($message = '') {
		if (empty ( $message ))
			unset ( $message );
			$status = 1;
			@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
			$pagesize = $this->setting ['list_default'];
			$startindex = ($page - 1) * $pagesize;
			$vertifylist = $this->vertify_model->get_list ( $status, $startindex, $pagesize );
			$rownum = returnarraynum ( $this->db->query ( getwheresql ( "vertify", "status=1", $this->db->dbprefix ) )->row_array () );
			$departstr = page ( $rownum, $pagesize, $page, "admin_vertifyuser/userlist" );
			
			include template ( "vertifyuserlist", "admin" );
	}
	function bohui() {
		$id = intval ( $this->input->post ( 'id' ) );
		$uid = intval ( $this->input->post ( 'uid' ) );
		$liyou = strip_tags ( addslashes ( $this->input->post ( 'liyou' ) ) );
		$status = 2;
		$this->vertify_model->save ( $id, $uid, $status, $liyou ); //驳回请求


		//取消设置为行家/专家
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET `expert`=0 WHERE uid=$uid" );

		//发送私信
		$redirect = url ( "user/vertify" );
		$subject = "您的认证信息被驳回".$uid;
		$content = '对不起，您的认证信息被平台驳回，<br /><a href="' . $redirect . '">请点击查看具体原因!</a>';
		$this->db->query ( 'INSERT INTO ' . $this->db->dbprefix . "message  SET `from`='" . $this->setting ['site_name'] . "' , `fromuid`=0 , `touid`=$uid  , `subject`='$subject' , `time`=" . time () . " , `content`='$content'" );
		//极光推送
	
		jpushmsg("对不起，您的认证信息被平台驳回",$this->input->post( 'uid' ),$subject,$redirect);
		
		//微信通知
		$wx = $this->fromcache ( 'cweixin' );

		if ($wx['appsecret'] != '' &&$wx ['appsecret'] != null && $wx['winxintype'] != 2) {

			$touser = $this->user_model->get_by_uid ( $uid );

			$appid = $wx ['appid'];
			$appsecret = $wx ['appsecret'];

			require FCPATH . '/lib/php/jssdk.php';
			$jssdk = new JSSDK ( $appid, $appsecret );

			if ($touser ['openid'] != '' && $touser ['openid'] != null) {

				$text = $content;

				$returnmesage = $jssdk->sendtexttouser ( $touser ['openid'], $text );

			}

		}

		if (file_exists (FCPATH.'data/attach/vertify/' . $uid . ".txt" )) {
		unlink ( FCPATH . 'data/attach/vertify/' . $uid . ".txt" );
		}

		$message = array ();
		$message ['result'] = '驳回成功!'  ;
		echo json_encode ( $message );
		exit ();
	}
	function vertifysave() {
		$id = intval ( $this->input->post ( 'id' ) );
		$uid = intval ( $this->input->post ( 'uid' ) );
		$type = $this->input->post ( 'type' );
		$status = 1;
		$this->vertify_model->save ( $id, $uid, $status, '' );
		//设置为行家/专家
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET `expert`=1 WHERE uid=$uid" );
		//发送私信
		$redirect = url ( "user/vertify");
		$subject = "您的认证信息已通过审核";
		$content = '您的认证信息已通过审核!';
	
		$this->db->query ( 'INSERT INTO ' . $this->db->dbprefix . "message  SET `from`='" . $this->setting ['site_name'] . "' , `fromuid`=0 , `touid`=$uid  , `subject`='$subject' , `time`=" . time () . " , `content`='$content'" );
		//微信通知
		$wx = $this->fromcache ( 'cweixin' );

		if ($wx ['appsecret'] != '' && $wx ['appsecret'] != null && $wx ['winxintype'] != 2) {

			$touser = $this->user_model->get_by_uid ( $uid );

			$appid = $wx ['appid'];
			$appsecret = $wx ['appsecret'];

			require FCPATH . '/lib/php/jssdk.php';
			$jssdk = new JSSDK ( $appid, $appsecret );

			if ($touser ['openid'] != '' && $touser ['openid'] != null) {

				$text = $content;

				$returnmesage = $jssdk->sendtexttouser ( $touser ['openid'], $text );

			}

		}

		$time = time ();
		file_put_contents ( FCPATH . 'data/attach/vertify/' . $uid . ".txt", $type . "|" . $time );
		$message = array ();
		$message ['result'] = '通过成功!';
		echo json_encode ( $message );
	}
}

?>