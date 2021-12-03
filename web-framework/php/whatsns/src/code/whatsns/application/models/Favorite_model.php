<?php

class Favorite_model extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	function get_by_qid($qid) {
		global $user;
		$uid = $user ['uid'];
		return $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "favorite WHERE `qid`=$qid AND `uid`=" . $user ['uid'] )->row_array ();
	}

	function get_by_tid($tid) {
		global $user;
		$uid = $user ['uid'];
		return $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic_likes WHERE `tid`=$tid AND `uid`=" . $user ['uid'] )->row_array ();
	}
	function plugin_get_by_tid($uid,$tid) {

		return $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic_likes WHERE `tid`=$tid AND `uid`=" . $uid )->row_array ();
	}
	function get_list($start = 0, $limit = 10) {
		global $user;
		$uid = $user ['uid'];
		$questionlist = array ();
		$query = $this->db->query ( "SELECT q.answers,q.title,f.qid,f.id,f.time,f.uid FROM `" . $this->db->dbprefix . "question` as q ,`" . $this->db->dbprefix . "favorite` as f  WHERE q.id=f.qid AND f.uid=$uid  LIMIT $start,$limit" );
		foreach ( $query->result_array () as $question ) {
			$question ['format_time'] = tdate ( $question ['time'] );
			$questionlist [] = $question;
		}
		return $questionlist;
	}
	function get_list_byalltid($start = 0, $limit = 10) {
		global $user;
		$uid = $user ['uid'];
		$topiclist = array ();

		$query = $this->db->query ( "SELECT t.likes, t.image,t.views,t.describtion,t.author,t.authorid,t.articles,t.title,f.tid,f.id,f.time,f.uid FROM `" . $this->db->dbprefix . "topic` as t ,`" . $this->db->dbprefix . "topic_likes` as f  WHERE t.id=f.tid AND f.uid=$uid  LIMIT $start,$limit" );
		foreach ( $query->result_array () as $topic ) {
			$topic ['format_time'] = tdate ( $topic ['time'] );
			$topic ['images'] = getfirstimgs( $topic ['describtion'] );
			$topic ['avatar'] = get_avatar_dir ( $topic ['authorid'] );
			$topiclist [] = $topic;
		}
		return $topiclist;
	}
	function get_list_byalltidtotal() {
		global $user;
		$uid = $user ['uid'];
		$m= $this->db->query ( "SELECT count(*) as num FROM `" . $this->db->dbprefix . "topic` as t ,`" . $this->db->dbprefix . "topic_likes` as f  WHERE t.id=f.tid AND f.uid=$uid " )->row_array ();
	    return $m['num'];
	}

	function get_list_byqid($qid, $start = 0, $limit = 10) {
		global $user;
		$uid = $user ['uid'];
		$userlist = array ();
		$query = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "favorite`  WHERE qid=$qid  LIMIT $start,$limit" );
		foreach ( $query->result_array () as $usermodel ) {
			$usermodel ['format_time'] = tdate ( $usermodel ['time'] );
			$usermodel ['avatar'] = get_avatar_dir ( $usermodel ['uid'] );
			$_user = $this->get_by_uid ( $usermodel ['uid'] );
			$usermodel ['username'] = $_user ['username'];

			$userlist [] = $usermodel;
		}
		return $userlist;
	}
	function get_list_bytid($tid, $start = 0, $limit = 10) {
		$userlist = array ();
		$query = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "topic_likes`  WHERE tid=$tid  LIMIT $start,$limit" );
		foreach ( $query->result_array () as $usermodel ) {
			$usermodel ['format_time'] = tdate ( $usermodel ['time'] );
			$usermodel ['avatar'] = get_avatar_dir ( $usermodel ['uid'] );
			$_user = $this->get_by_uid ( $usermodel ['uid'] );
			$usermodel ['username'] = $_user ['username'];

			$userlist [] = $usermodel;
		}
		return $userlist;
	}

	function get_by_uid($uid, $loginstatus = 1) {
		$user = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user WHERE uid='$uid'" )->row_array ();

		return $user;
	}
	function rownum_by_uid($uid = 0) {
		global $user;
		(! $uid) && $uid = $user ['uid'];
		$query = $this->db->query ( "SELECT count(*) as size  FROM `" . $this->db->dbprefix . "question` as q ,`" . $this->db->dbprefix . "favorite` as f  WHERE q.id=f.qid AND f.uid=$uid " );
		$favorite = $query->row_array ();
		return $favorite ['size'];
	}

	function add($qid) {
		global $user;
		$uid = $user ['uid'];
		$time = time ();
		$this->db->query ( 'REPLACE INTO `' . $this->db->dbprefix . "favorite`(`qid`,`uid`,`time`) values ($qid,$uid,{$time})" );
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "question` set attentions=attentions+1  WHERE `id` =$qid" );
		return $this->db->insert_id ();
	}
	function addtopiclikes($tid) {
		global $user;
		$uid = $user ['uid'];
		$time = time ();
		$this->db->query ( 'REPLACE INTO `' . $this->db->dbprefix . "topic_likes`(`tid`,`uid`,`time`) values ($tid,$uid,{$time})" );
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "topic` set likes=likes+1  WHERE `id` =$tid" );
		return $this->db->insert_id ();

	}
    function plugin_addtopiclikes($uid,$tid) {

		$time = time ();
		$this->db->query ( 'REPLACE INTO `' . $this->db->dbprefix . "topic_likes`(`tid`,`uid`,`time`) values ($tid,$uid,{$time})" );
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "topic` set likes=likes+1  WHERE `id` =$tid" );
		return $this->db->insert_id ();

	}
	function remove_topiclikes($ids, $uid) {
		if (is_array ( $ids )) {
			$ids = implode ( ",", $ids );
		}
		 $this->db->where_in('tid',$ids)->where(array('uid'=>$uid))->delete('topic_likes');
	
	}

	function remove($ids, $uid) {
         $this->db->where_in('id',$ids)->where(array('uid'=>$uid))->delete('favorite');

	}

}

?>
