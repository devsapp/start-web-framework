<?php

class Datacall_model extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	function get($id) {
		return $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "datacall WHERE id='$id'" )->row_array ();
	}

	function get_list($limit = 100) {
		$datacalllist = array ();
		$query = $this->db->query ( "select * from " . $this->db->dbprefix . "datacall order by id desc limit $limit" );
		foreach ( $query->result_array () as $datacall ) {
			$datacall ['time_format'] = tdate ( $datacall ['time'] );
			$datacalllist [] = $datacall;
		}
		return $datacalllist;
	}

	function add($title, $expression) {
		$time = time ();
		$this->db->query ( 'INSERT INTO ' . $this->db->dbprefix . "datacall(title,expression,time) values ('$title','$expression','{$time}')" );
		return $this->db->insert_id ();
	}

	function update($id, $title, $expression) {
		$time = time ();
		$this->db->query ( 'update  ' . $this->db->dbprefix . "datacall  set title='$title',expression='$expression',time='{$time}' where id=$id " );
	}

	function remove_by_id($ids) {
		$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "datacall` WHERE `id` IN ($ids)" );
	}

}
?>
