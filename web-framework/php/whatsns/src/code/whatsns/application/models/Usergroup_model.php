<?php

class Usergroup_model extends CI_Model {

	public function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	function get($groupid) {

		$query = $this->db->get_where ( 'usergroup', array ('groupid' => $groupid ) );
		$usergroup = $query->row_array ();
		return $usergroup;
	}

	function add($grouptitle, $grouptype = 2, $creditslower = 0, $questionlimits = 0, $answerlimits = 0, $regulars = '') {
		$data = array ('grouptitle' => $grouptitle, 'creditslower' => $creditslower, 'questionlimits' => $questionlimits, 'answerlimits' => $answerlimits, 'regulars' => $regulars, 'grouptype' => $grouptype );
		$this->db->insert ( 'usergroup', $data );
	}

	function update($groupid, $group) {
		echo $group ['canfreereadansser'];
		$data = array ('canfreereadansser' => $group ['canfreereadansser'],'grouptitle' => $group ['grouptitle'], 'creditslower' => $group ['creditslower'], 'creditshigher' => $group ['creditshigher'], 'doarticle' => $group ['doarticle'], 'articlelimits' => $group ['articlelimits'], 'questionlimits' => $group ['questionlimits'], 'answerlimits' => $group ['answerlimits'], 'credit3limits' => $group ['credit3limits'], 'regulars' => $group ['regulars'] );
		$this->db->set ( $data )->where ( array ('groupid' => $groupid ) )->update ( 'usergroup' );
		
	}
	/**
	 * 得到用户组信息
	 *
	 * @param int $grouptype
	 * @param int $id 系统超级管理员id
	 * @return array $grouplist
	 */
	function get_list($grouptype = 2) {
		$grouplist = array ();
		if (is_array ( $grouptype )) {
			$grouptype = implode ( ",", $grouptype );
		}
		$query = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "usergroup` WHERE grouptype IN ($grouptype) ORDER BY `groupid`  " );
		foreach ( $query->result_array () as $group ) {
			$grouplist [] = $group;
		}
		return $grouplist;
	}

	function remove($groupid) {
		return $this->db->where ( array ('groupid' => $groupid ) )->delete ( 'usergroup' );

	}

}
?>
