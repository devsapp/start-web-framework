<?php

class Tixian_model extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	function get_list($start = 0, $limit = 10) {
		$mdlist = array ();

		$query = '';

		$query = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "user_tixian`  WHERE state=0 ORDER BY `time` DESC limit $start,$limit" );

			foreach ( $query->result_array () as $md ) {

			$user = $this->get_by_uid ( $md ['uid'] );
			$md ['time'] = tdate ( $md ['time'] );
			$md ['uid'] = $user ['uid'];
			$md ['username'] = $user ['username'];

			$mdlist [] = $md;
		}

		return $mdlist;
	}
	function get_by_uid($uid, $loginstatus = 1) {
		global $usergroup;
		$user = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user WHERE uid='$uid'" )->row_array();
		$user ['avatar'] = get_avatar_dir ( $uid );
		$user ['register_time'] = tdate ( $user ['regtime'] );
		$user ['lastlogin'] = tdate ( $user ['lastlogin'] );
		$user ['grouptitle'] = $usergroup [$user ['groupid']] ['grouptitle'];

		return $user;
	}
	function get_viewlist($uid, $start = 0, $limit = 10, $begintime = 0, $endtime = 0) {
		$total = 0;
		$mdlist = array ();

		$query = '';

		$query = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "weixin_notify` where touid=$uid and haspay=0 ORDER BY `time_end` DESC limit $start,$limit" );

			foreach ( $query->result_array () as $md ) {

			$md ['format_time'] = tdate ( $md ['time_end'] );
			$md ['cash_fee'] = $md ['cash_fee'] / 100;
			$total = $total + $md ['cash_fee'];
			$arr = split ( '_', $md ['attach'] );

			$type = $arr [0];
			$md ['type'] = $type;
			$dashangren = $this->f_get ( $md ['openid'] );
			$md ['nickname'] = $dashangren ['nickname'];
			$md ['headimgurl'] = $dashangren ['headimgurl'];
			switch ($type) {
				case 'aid' :
					$md ['type'] = "打赏回答";
					$md ['model'] = $this->getanswer ( $arr [1] );
					break;
				case 'qid' :
					$md ['type'] = "打赏提问";
					break;
				case 'tid' :
					$md ['type'] = "打赏文章";
					$md ['model'] = $this->gettopic ( $arr [1] );
					break;

			}

			switch ($md ['trade_trye']) {
				case "NATIVE" :
					$md ['laiyuan'] = "扫码支付";
					break;
				case "JSAPI" :
					$md ['laiyuan'] = "微信浏览器请求";
					break;
			}

			$mdlist [] = $md;
		}

		$list = array ($mdlist, $total );
		return $list;
	}
	/* 根据aid获取一个答案的内容，暂时无用 */

	function getanswer($id) {
		$answer = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "answer WHERE id='$id'" )->row_array();

		if ($answer) {

			$answer ['title'] = checkwordsglobal ( $answer ['title'] );
			$answer ['content'] = checkwordsglobal ( $answer ['content'] );
		}
		return $answer;
	}
	function f_get($openid) {
		$model = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "weixin_follower where openid='$openid' limit 0,1" )->row_array();

		return $model;
	}

	function gettopic($id) {
		$topic = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic WHERE id='$id'" )->row_array();

		if ($topic) {
			$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
			$topic ['title'] = checkwordsglobal ( $topic ['title'] );

		}
		return $topic;
	}

}

?>
