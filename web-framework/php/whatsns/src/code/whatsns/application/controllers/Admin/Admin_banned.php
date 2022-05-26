<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Admin_banned extends ADMIN_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( "banned_model" );
	}

	function add($msg = '') {
		if (null !== $this->input->post ( 'submit' )) {
			$this->banned_model->add ( $this->input->post ( 'ip' ), $this->input->post ( 'expiration' ) );
			$message = "IP添加成功!";
		}
		$iplist = $this->banned_model->get_list ();
		$msg && $message = $msg;
		include template ( "addbanned", "admin" );
	}

	function remove() {
		if (null !== $this->input->post ( 'id' )) {
			$this->banned_model->remove ( $this->input->post ( 'id' ) );
		}
		$this->add ( "IP地址删除成功" );
	}

}

?>