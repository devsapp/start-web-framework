<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_expert extends ADMIN_Controller {

	function __construct() {
		parent::__construct ();
		$this->load->model ( 'expert_model' );
		$this->load->model ( 'user_model' );
		$this->load->model ( 'category_model' );
	}

	function index($msg = '') {
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$expertlist = $this->expert_model->get_expertlist ( $startindex, $pagesize );
		$giftnum = returnarraynum ( $this->db->query ( getwheresql ( 'user', " expert=1", $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $giftnum, $pagesize, $page, "admin_expert/default" );
		$categoryjs = $this->category_model->get_js ();
		$msg && $message = $msg;
		include template ( 'expertlist', 'admin' );
	}

	function add() {
		$type = 'correctmsg';
		$message = '';
		$cids = explode ( " ", trim ( $this->input->post ( 'goodatcategory' ) ) );
		$cids = array_unique ( $cids );
		$username = $this->input->post ( 'username' );
		if (count ( $cids ) > 5 || count ( $cids ) < 1) {
			$type = 'errormsg';
			$message .= "<br />擅长分类不能超过5个不能小于1个";
		}
		$user = $this->user_model->get_by_username ( trim ( $username ) );
		if (! $user) {
			$type = 'errormsg';
			$message = $user ['uid'] . "抱歉，用户名 [$username] 不存在";
		}
		if ($user ['expert']) {
			$type = 'errormsg';
			$message = "用户" . $user ['username'] . '已经是专家了，不能重复设置！';
		}
		//添加专家
		if ('correctmsg' == $type) {
			$this->expert_model->add ( $user ['uid'], $cids );
		}
		$this->index ( $message, $type );
	}
	function update() {
		$type = 'correctmsg';
		$message = '';
		$cids = explode ( ",", trim ( $this->input->post ( 'mycid' ) ) );
		//  echo $this->post['mycid'];
		$uid = intval ( $this->input->post ( 'myuid' ) );
		//  echo '<br>'.$uid;
		//exit();
		$cids = array_unique ( $cids );
		$username = $this->input->post ( 'username' );
		if (count ( $cids ) > 5 || count ( $cids ) < 1) {
			$type = 'errormsg';
			$message .= "<br />擅长分类不能超过5个不能小于1个";
		}

		//更新专家信息
		if ('correctmsg' == $type) {
			$this->expert_model->remove ( $uid );
			$this->expert_model->add ( $uid, $cids );
		}
		$this->index ( $message, $type );
	}
	function delcid() {
		$message = array ();
		$cid = intval ( $this->input->post ( 'cid' ) );
		$uid = intval ( $this->input->post ( 'uid' ) );
		$this->user_model->remove_category ( $cid, $uid );
		$message ['code'] = 200;
		//$message['msg']=$cid.'---'.$uid;
		echo json_encode ( $message );
		exit ();
	}
	function remove() {
		if (count ( $this->input->post ( 'delete' ) )) {
			$this->expert_model->remove ( implode ( ',', $this->input->post ( 'delete' ) ) );
			$type = 'correctmsg';
			$message = "删除成功！";
			$this->index ( $message );
		}
	}
	function selectexpert() {

		$uid = intval ( $this->input->post ( 'uid' ) );
		$expert = $this->user_model->get_by_uid ( $uid );
		echo json_encode ( $expert );
		exit ();
	}

	function ajaxgetname() {
		if (null !== $this->input->post ( 'cid' ) && intval ( $this->input->post ( 'cid' ) )) {
			$categorylist = $this->category_model->get_navigation ( $this->input->post ( 'cid' ), true );
			$categorystr = '';
			foreach ( $categorylist as $category ) {
				$categorystr .= $category ['name'] . ' > ';
			}
			echo substr ( $categorystr, 0, - 2 );
		}
	}

}

?>