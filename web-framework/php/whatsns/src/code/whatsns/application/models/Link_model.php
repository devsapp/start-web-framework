<?php

class Link_model extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	function get($id) {
		return $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "link WHERE id='$id'" )->row_array();
	}

	function get_list($start = 0, $limit = 1000) {
		$linklist = array ();
		$query = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "link` ORDER BY `displayorder` ASC,`id` ASC limit $start,$limit" );
		foreach ( $query->result_array () as $link ) {
			$link ['stitle'] = substr ( $link ['name'], 0, 24 );
			$linklist [] = $link;
		}
		return $linklist;
	}

	function add($name, $url, $desrc = '', $logo = '') {
		$this->db->query ( 'REPLACE INTO `' . $this->db->dbprefix . "link`(`name`,`url`,`description`,`logo`) values ('$name','$url','$desrc','$logo')" );
		return $this->db->insert_id ();
	}

	function update($name, $url, $desrc = '', $logo = '', $id) {
		$this->db->query ( 'UPDATE  `' . $this->db->dbprefix . "link`  set `name`='$name',`url`='$url',`description`='$desrc',`logo`='$logo' where id=$id " );
	}

	function remove_by_id($ids) {
		$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "link` WHERE `id` IN ($ids)" );
	}
	function order_link($id, $order) {
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "link` SET 	`displayorder` = '{$order}' WHERE `id` = '{$id}'" );
	}

}
?>
