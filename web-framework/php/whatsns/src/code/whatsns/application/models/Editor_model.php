<?php

class Editor_model extends CI_Model {

	var $filelist = array ();
	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	function get($id) {
		return $this->db->query ( 'SELECT * FROM ' . $this->db->dbprefix . 'editor WHERE id=' . $id )->row_array ();
	}

	function get_list($available = 1) {
		$toolbarlist = array ();
		$sql = 'SELECT * FROM ' . $this->db->dbprefix . 'editor';
		$available && $sql .= ' where available=1 ';
		$sql .= ' ORDER BY displayorder ASC';
		$query = $this->db->query ( $sql );
		foreach ( $query->result_array () as $toolbar ) {
			$toolbarlist [] = $toolbar;
		}
		return $toolbarlist;
	}

	/*
     * '-'会自动换一行
     * '|'自动分割相关功能
     */

	function get_items() {
		$tags = array ();
		$query = $this->db->query ( 'SELECT * FROM ' . $this->db->dbprefix . 'editor where available=1 ORDER BY displayorder ASC' );
		foreach ( $query->result_array () as $item ) {
			$tags [] = $item ['tag'];
		}
		return implode ( ',', $tags );
	}

	function update($id, $available = 1) {
		$this->db->query ( 'UPDATE ' . $this->db->dbprefix . 'editor SET available=' . $available . '  WHERE id=' . $id );
	}

	function order($order) {
		$order = explode ( ',', $order );
		$count = count ( $order );
		for($i = 0; $i < $count; $i ++) {
			$this->db->query ( "UPDATE " . $this->db->dbprefix . "editor SET displayorder=$i WHERE id=" . $order [$i] );
		}
	}
}

?>
