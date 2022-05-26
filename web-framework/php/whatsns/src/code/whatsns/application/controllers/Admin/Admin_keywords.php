<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_keywords extends ADMIN_Controller {

	function __construct() {
		parent::__construct ();
		$this->load->model ( 'setting_model' );
		$this->load->model ( "keywords_model" );
	}

	function index($message = '') {

		$this->cache->remove ( 'keyword' );
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$wordlist = $this->keywords_model->get_list ( $startindex, $pagesize );
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( "keywords", " 1=1", $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "admin_keywords/default" );
		include template ( 'keywordlist', 'admin' );
	}

	function add() {
		if (null !== $this->input->post ( 'submit' ) && $this->input->post ( 'id' )) {
			$ids = implode ( ",", $this->input->post ( 'id' ) );
			$this->keywords_model->remove_by_id ( $ids );
			$message = "删除成功!";
		} else {
			$this->keywords_model->add ( $this->input->post ( 'wid' ), $this->input->post ( 'find' ), $this->input->post ( 'replacement' ), $this->user ['username'] );
			$message = "修改成功!";
		}
		$this->index ( $message );
	}

	function editindexkeyword() {
		if (null !== $this->input->post ( 'submit' )) {
			$this->setting ['maxindex_keywords'] = $this->input->post ( 'maxindex_keywords' );
			$this->setting ['pagemaxindex_keywords'] = $this->input->post ( 'pagemaxindex_keywords' );

			$this->setting_model->update ( $this->setting );
			$message = '设置更新成功！';
		}
		$this->index ( $message );
	}

	function muladd() {
		if (null !== $this->input->post ( 'submit' )) {
			$lines = explode ( "\n", $this->input->post ( 'badwords' ) );
			$this->keywords_model->multiadd ( $lines, $this->user ['username'] );
			$this->index ( "添加成功!" );
		} else {
			include template ( 'addkeyword', "admin" );
		}
	}

}

?>