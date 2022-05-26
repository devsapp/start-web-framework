<?php

class Nav_model extends CI_Model {

	public function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	public function get($id) {
		$query = $this->db->get_where ( 'nav', array ('id' => $id ) );
		$row = $query->row_array ();
		return $row;
	}

	public function get_list($start = 0, $limit = 1000) {

		$navlist = array ();

		$query = $this->db->select ( '*' )->from ( 'nav' )->order_by ( 'displayorder ASC,id ASC' )->limit ( $limit, $start )->get ();

		foreach ( $query->result_array () as $nav ) {

			$navlist [] = $nav;
		}
		return $navlist;
	}

	function add($name, $url, $title = '', $target = 0, $aval = 1, $type = 2) {
		$data = array ('name' => $name, 'url' => $url, 'title' => $title, 'target' => $target, 'available' => $aval, 'type' => $type );

		$this->db->insert ( 'nav', $data );

		return $this->db->insert_id ();
	}

	function update($name, $url, $title = '', $target = 0, $type = 2, $id) {
		$data = array ('name' => $name, 'url' => $url, 'title' => $title, 'target' => $target, 'type' => $type );
		$this->db->where ( 'id', $id );
		$this->db->update ( 'nav', $data );
	}

	function remove_by_id($ids) {
		$this->db->where_in ( 'id', explode ( ',', $ids ) );
		$this->db->delete ( 'nav' );
	}

	function order_nav($id, $order) {
		$data = array ('displayorder' => $order );
		$this->db->where ( 'id', $id );
		$this->db->update ( 'nav', $data );
	}

	function update_available($id, $available) {
		$data = array ('available' => $available );
		$this->db->where ( 'id', $id );
		$this->db->update ( 'nav', $data );

	}

	public function get_format_url() {

		$navlist = $this->get_list ();
		foreach ( $navlist as &$nav ) {
			if (! stristr ( $nav ['url'], "http" )) {
				if ($nav ['url'] == 'index/default') {
					$nav ['format_url'] = base_url ();
				} else {
					$nav ['format_url'] = url ( $nav ['url'], 1 );
				}
			} else {
				$nav ['format_url'] = $nav ['url'];
			}
		}
		return $navlist;
	}
}

?>
