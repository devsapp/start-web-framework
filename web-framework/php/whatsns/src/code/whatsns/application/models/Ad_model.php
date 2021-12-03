<?php
class Ad_model extends CI_Model {


	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	function get_list() {
		$adlist = array ();

		$query = $this->db->select ( '*' )->from ( 'ad' )->limit ( 100, 0 )->get ();

		foreach ( $query->result_array () as $ad ) {

			$adlist [$ad ['page']] [$ad ['position']] = $ad ['html'];
		}
		return $adlist;
	}

	function add($page, $adlist) {

		$data = array ();
		foreach ( $adlist as $position => $html ) {
			$this->db->where ( array ('page' => $page, 'position' => $position ) )->delete ( 'ad' );
			
			$tmp = array ('page' => $page, 'position' => $position, 'html' => $html );
			$data [] = $tmp;
		}

		$this->db->insert_batch ( 'ad', $data );
	}

}

?>
