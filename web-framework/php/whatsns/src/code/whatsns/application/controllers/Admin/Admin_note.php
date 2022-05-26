<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_note extends ADMIN_Controller {

	function __construct() {
		parent::__construct ();
		$this->load->model ( 'note_model' );
	}

	function index($message = '') {
		if (empty ( $message ))
			unset ( $message );
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$notelist = $this->note_model->get_list ( $startindex, $pagesize );
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( "note", "1=1", $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "admin_note/index" );
		include template ( 'notelist', 'admin' );
	}

	function add() {
		if (null !== $this->input->post ( 'submit' )) {
			$title = $this->input->post ( 'title' );
			$url = $this->input->post ( 'url' );
			$content = $this->input->post ( 'content' );
			$this->note_model->add ( $title, $url, $content );
			$this->index ( '公告添加成功！' );
		} else {
			include template ( 'addnote', 'admin' );
		}
	}

	function edit() {
		if (null !== $this->input->post ( 'submit' )) {
			$id = $this->input->post ( 'id' );
			$title = $this->input->post ( 'title' );
			$url = $this->input->post ( 'url' );
			$content = $this->input->post ( 'content' );
			$this->note_model->update ( $id, $title, $url, $content );
			$this->index ( '公告编辑成功！' );
		} else {
			$note = $this->note_model->get ( $this->uri->segment ( 3 ) );
			include template ( 'editnote', 'admin' );
		}
	}

	function remove() {
		$message = '没有选择公告！';
		if (null !== $this->input->post ( 'delete' )) {
			$ids = implode ( ",", $this->input->post ( 'delete' ) );
			$this->note_model->remove_by_id ( $ids );
			$message = '公告刪除成功！';
		}
		$this->index ( $message );
	}

}

?>