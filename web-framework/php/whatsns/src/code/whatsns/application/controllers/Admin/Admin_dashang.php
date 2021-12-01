<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_dashang extends ADMIN_Controller {

	function __construct() {
		parent::__construct ();
		$this->load->model ( 'dashang_model' );
	}

	function index($message = '') {

		if (empty ( $message ))
			unset ( $message );

		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 100;
		$startindex = ($page - 1) * $pagesize;

		if (null !== $this->input->post ( 'submit' )) {

			if ($this->input->post ( 'srchdatestart' ) && $this->input->post ( 'srchdateend' )) {
				$srchdatestart = $this->input->post ( 'srchdatestart' );
				$srchdateend = $this->input->post ( 'srchdateend' );
				$starttime = strtotime ( $this->input->post ( 'srchdatestart' ) );
				$endtime = strtotime ( $this->input->post ( 'srchdateend' ) );
				$shanglist = $this->dashang_model->get_list ( $startindex, $pagesize, $starttime, $endtime );
			}

		} else {
			$shanglist = $this->dashang_model->get_list ( $startindex, $pagesize );

		}

		if ($this->input->post ( 'srchdatestart' ) && $this->input->post ( 'srchdateend' )) {
			$starttime = strtotime ( $this->input->post ( 'srchdatestart' ) );
			$endtime = strtotime ( $this->input->post ( 'srchdateend' ) );
			$rownum = returnarraynum ( $this->db->query ( getwheresql ( "weixin_notify", " time_end>=$starttime and time_end <=$endtime", $this->db->dbprefix ) )->row_array () );
		} else {
			$rownum = returnarraynum ( $this->db->query ( getwheresql ( "weixin_notify", " 1=1", $this->db->dbprefix ) )->row_array () );
		}
		$departstr = page ( $rownum, $pagesize, $page, "admin_dashang/default" );
		include template ( "dashang", "admin" );
	}

	function select() {
		include template ( "dashang", "admin" );
	}
}

?>