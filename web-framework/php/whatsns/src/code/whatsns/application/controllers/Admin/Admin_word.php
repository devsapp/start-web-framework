<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_word extends ADMIN_Controller {

	function __construct() {
		parent::__construct ();
		$this->load->model ( "badword_model" );

	}

	function index($message = '') {
		$this->cache->remove ( 'word' );

		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$wordlist = $this->badword_model->get_list ( $startindex, $pagesize );
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( "badword", " 1=1", $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "admin_word/index" );
		include template ( 'wordlist', 'admin' );
	}

	function add() {
		if (null !== $this->input->post ( 'submit' ) && $this->input->post ( 'id' )) {

			$ids = implode ( ",", $this->input->post ( 'id' ) );
			$this->badword_model->remove_by_id ( $ids );
			$message = "删除成功!";
		} else {
			$this->badword_model->add ( $this->input->post ( 'wid' ), $this->input->post ( 'find' ), $this->input->post ( 'replacement' ), $this->user ['username'] );
			$message = "修改成功!";
		}
		$this->index ( $message );
	}

	function muladd() {
		if (null !== $this->input->post ( 'submit' )) {
			$lines = explode ( "\n", $this->input->post ( 'badwords' ) );
			$this->badword_model->multiadd ( $lines, $this->user ['username'] );
			$this->index ( "添加成功!" );
		} else {
			include template ( 'addword', "admin" );
		}
	}

}

?>