<?php

class Expert_model extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	function get_list($showquestion = 0, $start = 0, $limit = 3, $cid = 'all', $status = 'all') {

		$expertlist = array ();
		$orderwhere = '';
		switch ($status) {
			case 'all' : //全部
				$orderwhere = '';
				break;
			case '1' : //付费
				$orderwhere = ' and mypay>0 ';
				break;
			case '2' : //免费
				$orderwhere = " and mypay=0 ";
				break;
		}

		$query = ($cid == 'all') ? $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user WHERE expert=1 $orderwhere and uid IN (SELECT uid FROM " . $this->db->dbprefix . "user_category) ORDER BY answers DESC LIMIT $start,$limit" ) : $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user WHERE expert=1 $orderwhere and uid IN (SELECT uid FROM " . $this->db->dbprefix . "user_category WHERE cid=$cid) ORDER BY answers DESC  LIMIT $start,$limit" );
		foreach ( $query->result_array () as $expert ) {
			$expert ['avatar'] = get_avatar_dir ( $expert ['uid'] );
			$expert ['author_has_vertify'] = get_vertify_info ( $expert ['uid'] ); //用户是否认证
			$expert ['lastlogin'] = tdate ( $expert ['lastlogin'] );
			$is_followed = $this->is_followed ( $expert ['uid'], $this->user ['uid'] );
			$expert ['hasfollower'] = $is_followed == 0 ? "0" : "1";
			$expert ['category'] = $this->get_category ( $expert ['uid'] );

			$showquestion && $expert ['bestanswer'] = $this->get_solve_answer ( $expert ['uid'], 0, 6 );
			$expertlist [] = $expert;
		}
		return $expertlist;
	}
	function get_expertlist($start = 0, $limit = 3) {
		global $user;
		$expertlist = array ();
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user WHERE expert=1 LIMIT $start,$limit" );
		foreach ( $query->result_array () as $expert ) {
			$expert ['avatar'] = get_avatar_dir ( $expert ['uid'] );
			$expert ['author_has_vertify'] = get_vertify_info ( $expert ['uid'] ); //用户是否认证
			$expert ['lastlogin'] = tdate ( $expert ['lastlogin'] );
			$is_followed = $this->is_followed ( $expert ['uid'], $user ['uid'] );
			$expert ['hasfollower'] = $is_followed == 0 ? "0" : "1";
			$expert ['category'] = $this->get_category ( $expert ['uid'] );

			$expertlist [] = $expert;
		}
		return $expertlist;
	}

	/* 是否关注用户 */

	function is_followed($uid, $followerid) {
		$m= $this->db->query ( "SELECT COUNT(*) as num FROM " . $this->db->dbprefix . "user_attention WHERE uid=$uid AND followerid=$followerid" )->row_array ();
	    return $m['num'];
	}

	function get_by_uid($uid) {
		return  $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user_category WHERE `uid`=$uid" )->result_array ();
	}
	function getusername_by_uid($uid) {
		return $this->db->query ( $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user WHERE `uid`=$uid" ) )->result_array ();
	}

	function get_by_username($username) {
		return $this->db->query ( $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user_category WHERE `username`='$username'" ) )->result_array ();
	}

	function get_by_cid($cid, $start = 0, $limit = 10) {
		$expertlist = array ();
		$query = ($cid == 'all') ? $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user WHERE uid IN (SELECT uid FROM " . $this->db->dbprefix . "user_category) ORDER BY answers DESC LIMIT $start,$limit" ) : $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user WHERE uid IN (SELECT uid FROM " . $this->db->dbprefix . "user_category WHERE cid=$cid) ORDER BY answers DESC  LIMIT $start,$limit" );
		foreach ( $query->result_array () as $expert ) {
			$expert ['avatar'] = get_avatar_dir ( $expert ['uid'] );
			$expert ['category'] = $this->get_category ( $expert ['uid'] );
			$expertlist [] = $expert;
		}
		return $expertlist;
	}

	function getlist_by_cid($cid) {

		$expertlist = array ();
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user_category WHERE cid=$cid" );
		foreach ( $query->result_array () as $expert ) {

			$expertlist [] = $expert;
		}
		return $expertlist;
	}

	function add($uid, $cids) {
		$sql = "INSERT INTO " . $this->db->dbprefix . "user_category(`uid`,`cid`) VALUES ";
		foreach ( $cids as $cid ) {
			$sql .= "($uid,$cid),";
		}
		$this->db->query ( substr ( $sql, 0, - 1 ) );
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET `expert`=1 WHERE uid=$uid" );
	}

	function remove($uids) {
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET `expert`=0 WHERE uid IN ($uids)" );
		$this->db->query ( "DELETE FROM " . $this->db->dbprefix . "user_category WHERE uid IN ($uids)" );
	}

	function get_category($uid) {

		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user_category WHERE uid=$uid" );
		$categorylist = array ();
		foreach ( $query->result_array () as $categorymodel ) {
			if(isset($this->category [$categorymodel ['cid']])){
				$categorymodel ['categoryname'] = $this->category [$categorymodel ['cid']] ['name'];
			}else{
				$categorymodel ['categoryname']='';
			}

			$categorylist [] = $categorymodel;
		}
		return $categorylist;
	}

	function get_solves($start = 0, $limit = 20) {
		$solvelist = array ();
		$query = $this->db->query ( "SELECT distinct a.qid,a.title,a.authorid,a.time FROM " . $this->db->dbprefix . "answer  as a ,`" . $this->db->dbprefix . "user_category` as f WHERE a.authorid=f.uid ORDER BY a.time DESC LIMIT $start ,$limit" );
		foreach ( $query->result_array () as $solve ) {
			$solvelist [] = $solve;
		}
		return $solvelist;
	}

	function get_solve_answer($uid, $start = 0, $limit = 3) {
		$solvelist = array ();
		$query = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "answer` WHERE `authorid`=" . $uid . "  ORDER BY `adopttime` DESC,`supports` DESC LIMIT $start,$limit" );
		foreach ( $query->result_array () as $solve ) {
			$solvelist [] = $solve;
		}
		return $solvelist;
	}

}

?>
