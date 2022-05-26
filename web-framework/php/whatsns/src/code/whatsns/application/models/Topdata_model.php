<?php
class Topdata_model extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	function get_list($start = 0, $limit = 10, $where = '') {
		$mdlist = array ();
		$query = $this->db->query ( "select * from " . $this->db->dbprefix . "topdata $where order by  `order` asc limit $start,$limit" );
		foreach ( $query->result_array () as $md ) {
			
			switch ($md ['type']) {
				case 'note' :
					$note = $this->getnote ( $md ['typeid'] );
					$md ['author_has_vertify'] = get_vertify_info ( $note ['authorid'] ); // 用户是否认证
					$md ['model'] = $note;
					$md ['title'] = $note ['title'];
					$md ['views'] = $note ['views'];
					$md ['answers'] = $note ['comments'];
					$md ['attentions'] = 0;
					$md ['image'] = getfirstimg ( $note ['content'] );
					$md ['description'] = cutstr ( checkwordsglobal ( strip_tags ( htmlspecialchars_decode ($note ['content'] ))), 240, '...' );
					$md ['url'] = urlmap ( 'note/view/' . $note ['id'], 2 );
					break;
				case 'qid' :
					$question = $this->getquestionbyqid ( $md ['typeid'] );
					$md ['author_has_vertify'] = get_vertify_info ( $question ['authorid'] ); // 用户是否认证
					$md ['model'] = $question;
					$md ['title'] = $question ['title'];
					$md ['views'] = $question ['views'];
					$md ['answers'] = $question ['answers'];
					$md ['attentions'] = $question ['attentions'];
					$md ['image'] = getfirstimg ( $question ['description'] );
					$md ['description'] = cutstr ( checkwordsglobal ( strip_tags (htmlspecialchars_decode ( $question ['description'] )) ), 240, '...' );
					$md ['url'] = urlmap ( 'question/view/' . $question ['id'], 2 );
					break;
				case 'aid' :
					$answer = $this->getanswer ( $md ['typeid'] );
					$md ['author_has_vertify'] = get_vertify_info ( $answer ['authorid'] ); // 用户是否认证
					$md ['model'] = $answer;
					$md ['title'] = $answer ['title'];
					$md ['description'] = cutstr ( checkwordsglobal ( strip_tags ( htmlspecialchars_decode ($answer ['content'] )) ), 240, '...' );
					$md ['url'] = urlmap ( 'question/view/' . $question ['id'], 2 );
					$md ['image'] = getfirstimg ( $answer ['content'] );
					break;
				case 'topic' :
					$topic = $this->gettopic ( $md ['typeid'] );
					$md ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); // 用户是否认证
					$md ['model'] = $topic;
					$md ['title'] = $topic ['title'];
					$md ['views'] = $topic ['views'];
					$md ['answers'] = $topic ['articles'];
					$md ['attentions'] = $topic ['likes'];
					if ($topic ['price'] > 0) {
						$md ['description'] = "付费后阅读";
					} else {
						$md ['description'] = clearhtml ( htmlspecialchars_decode ( $topic ['describtion'] ) );
					}
					
					$md ['url'] = urlmap ( 'topic/getone/' . $topic ['id'], 2 );
					if (isset ( $topic ['images'] ))
						$md ['image'] = $topic ['images'];
					break;
			}
			$md ['url'] = url ( $md ['url'] );
			$md ['format_time'] = tdate ( $md ['time'] );
			$mdlist [] = $md;
		}
		return $mdlist;
	}
	function getnote($id) {
		$note = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "note WHERE id='$id'" )->row_array ();
		$note ['format_time'] = tdate ( $note ['time'], 3, 0 );
		$note ['title'] = checkwordsglobal ( $note ['title'] );
		$note ['content'] = checkwordsglobal ( htmlspecialchars_decode ($note ['content'] ));
		$note ['artlen'] = strlen ( strip_tags ( $note ['content'] ) );
		$note ['avatar'] = get_avatar_dir ( $note ['authorid'] );
		return $note;
	}
	
	/* 根据aid获取一个答案的内容，暂时无用 */
	function getanswer($id) {
		$answer = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "answer WHERE id='$id'" )->row_array ();
		$answer ['avatar'] = get_avatar_dir ( $answer ['authorid'] );
		
		return $answer;
	}
	function getquestionbyqid($id) {
		$question = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "question WHERE id='$id'" )->row_array ();
		$question ['avatar'] = get_avatar_dir ( $question ['authorid'] );
		return $question;
	}
	function gettopic($id) {
		$topic = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic WHERE id='$id'" )->row_array ();
		$topic ['avatar'] = get_avatar_dir ( $topic ['authorid'] );
		
		return $topic;
	}
	function add($typeid, $type, $order = 1) {
		$this->remove ( $typeid, $type );
		$time = time ();
		$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "topdata SET typeid=$typeid,type='$type',`time`=$time" );
		
		return $this->db->insert_id ();
	}
	function update($typeid, $type, $orderid) {
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "topdata SET order=$orderid WHERE `typeid`='$typeid' and type='$type' " );
	}
	function remove_by_id($ids) {
		$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "topdata` WHERE `id` IN ($ids)" );
	}
	function remove($typeid, $type) {
		$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "topdata` WHERE `typeid`=$typeid and type='$type' " );
	}
	function order_topdata($id, $orderid) {
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "topdata SET `order`=$orderid WHERE `id`=$id  " );
	}
}

?>
