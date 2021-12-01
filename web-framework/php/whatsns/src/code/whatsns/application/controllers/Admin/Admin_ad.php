<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Admin_ad extends ADMIN_Controller {

	function __construct() {
		parent::__construct ();
		$this->load->model ( 'ad_model' );
	}

	function index() {

		if (null !== $this->input->post ( 'submit' )) {
			$page = $this->input->post ( 'page',FALSE );
			$adlist = $this->input->post ( $page ,FALSE );
		
			$this->ad_model->add ( $page, $adlist );
			$this->cache->remove ( 'adlist' );
		} else {
			$sql = "describe " . $this->db->dbprefix . "ad";
			$query = $this->db->query ( $sql );
			$num = 0;
			foreach ( $query->result_array () as $row ) {
				if ($row ['Key'] == 'PRI') {
					++ $num;
					break;
				}
			}
			if ($num > 0) {
				$this->db->query ( "alter table  " . $this->db->dbprefix . "ad drop primary key;" );
			}

		}
		include template ( "adlist", "admin" );
	}

}

?>