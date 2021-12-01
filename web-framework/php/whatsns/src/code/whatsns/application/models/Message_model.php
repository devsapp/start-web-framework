<?php
class Message_model extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	/* 读取一条消息内容 */

	function get($id) {
		$id = intval ( $id );
		$message = $this->db->query ( 'SELECT * FROM ' . $this->db->dbprefix . 'message WHERE `id`=' . $id )->row_array ();
		$message ['date'] = tdate ( $message ['time'] );
		return $message;
	}

	/* 发送一条消息 invateanswer-邀请回答，attentionquestion--关注问题,attentionuser--关注用户 ,questioncomment--回答评论,answer--回答问题，questiontouser--对用户提问，adoptanswer-采纳回答*/

	function add($msgfrom, $msgfromid, $msgtoid, $subject, $message,$typename='') {
		$msgtoid = intval ( $msgtoid );
		$user = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user WHERE uid='$msgtoid'" )->row_array ();

		if ($user ['isnotify']) {
			$time = time ();
			$data = array ('typename' => $typename,'from' => $msgfrom, 'fromuid' => $msgfromid, 'touid' => $msgtoid, 'subject' => $subject, 'time' => $time, 'content' => $message );
			$this->db->insert ( 'message', $data );
			return $this->db->insert_id ();
		} else {
			return 0;
		}
	}

	function list_by_touid($touid, $start = 0, $limit = 10) {
		$messagelist = array ();
		$touid = intval ( $touid );
		$sql = "SELECT * FROM " . $this->db->dbprefix . "message WHERE touid=$touid AND fromuid!=$touid AND status<>2 AND fromuid=0 ORDER BY `new` DESC,`time` DESC LIMIT $start,$limit";
		$query = $this->db->query ( $sql );
		foreach ( $query->result_array () as $message ) {
			$message ['format_time'] = tdate ( $message ['time'] );
			$message ['from_avatar'] = get_avatar_dir ( $message ['fromuid'] );
			switch($message['typename']){
				case 'questioncomment':
					$message['text']="回答评论 ";
					break;
				case 'invateanswer':
					$message['text']="邀请回答";
					break;
				case 'attentionquestion':
					$message['text']="关注问题";
					break;
				case 'attentionuser':
					$message['text']="关注用户";
					break;
				case 'answer':
					$message['text']="问题回答";
					break;
				case 'questiontouser':
					$message['text']="对用户提问";
					break;
				case 'adoptanswer':
					$message['text']="采纳回答";
					break;
				default:
					$message['text']="默认消息";
					break;
			}
			$messagelist [] = $message;
		}
		return $messagelist;
	}

	/* 获取消息列表
      fromuid为0，表示是系统消息
      new：1表示新消息,0为已读消息。
      status:0都没删除；1发消息者删除；2收消息者删除；
     */

	function group_by_touid($touid, $start = 0, $limit = 10) {
		$messagelist = array ();
		$touid = intval ( $touid );
		$sql = "SELECT * FROM " . $this->db->dbprefix . "message  WHERE touid=$touid AND fromuid!=$touid AND status<>2 AND fromuid<>0 ORDER BY `new` DESC,`time` DESC LIMIT $start,$limit";
		$query = $this->db->query ( $sql );
		foreach ( $query->result_array () as $message ) {
			$message ['format_time'] = tdate ( $message ['time'] );
			$message ['from_avatar'] = get_avatar_dir ( $message ['fromuid'] );
			$message ['content'] = clearhtml ( $message ['content'] );
			switch($message['typename']){
				case 'questioncomment':
					$message['text']="回答评论 ";
					break;
				case 'invateanswer':
					$message['text']="邀请回答";
					break;
				case 'attentionquestion':
					$message['text']="关注问题";
					break;
				case 'attentionuser':
					$message['text']="关注用户";
					break;
				case 'answer':
					$message['text']="问题回答";
					break;
				case 'questiontouser':
					$message['text']="对用户提问";
					break;
				case 'adoptanswer':
					$message['text']="采纳回答";
					break;
				default:
					$message['text']="默认消息";
					break;
			}
			$messagelist [] = $message;
		}

		return $messagelist;
	}

	function rownum_by_touid($touid) {
		return $this->db->from ( 'message' )->where ( array ('touid' => $touid, 'fromuid!=' => $touid, 'status!=' => 2, 'status!=' => 0 ) )->count_all_results ();

	}

	function list_by_fromuid($fromuid, $start = 0, $limit = 10) {
		global $user;
		$messagelist = array ();
		$fromuid = intval ( $fromuid );
		$sql = "SELECT * FROM " . $this->db->dbprefix . "message WHERE fromuid<>touid AND ((fromuid=$fromuid AND touid=" . $user ['uid'] . ") AND status IN (0,1)) OR ((fromuid=" . $user ['uid'] . " AND touid=" . $fromuid . ") AND  status IN (0,2)) ORDER BY time DESC LIMIT $start,$limit";
		$query = $this->db->query ( $sql );
		foreach ( $query->result_array () as $message ) {
			$message ['format_time'] = tdate ( $message ['time'] );
			$message ['from_avatar'] = get_avatar_dir ( $message ['fromuid'] );
			$message ['touser'] = $this->db->query ( "SELECT username FROM " . $this->db->dbprefix . "user WHERE uid=" . $message ['touid'] )->row_array ();
			$messagelist [] = $message;
		}
		return $messagelist;
	}

	/* 得到新消息总数 */

	function get_num($uid) {
		$num = $this->db->query ( "SELECT count(*) as num FROM " . $this->db->dbprefix . "message WHERE touid='$uid'  AND new=1 " )->row_array ();
		return $num;
	}

	/**
	 * 0都未删除;1发消息者删除；2收消息者删除；
	 * @param type $type
	 * @param type $msgids
	 */
	function remove($type, $msgids) {
		$messageid = ($msgids && is_array ( $msgids )) ? implode ( ",", $msgids ) : $msgids;
		if ('inbox' == $type) {
			$this->db->where ( array ('fromuid' => 0 ) )->where_in ( 'id', $msgids )->delete ( 'message' );
			$this->db->where ( array ('status' => 1 ) )->where_in ( 'id', $msgids )->delete ( 'message' );
			$this->db->set ( 'status', 2 )->where ( array ('status' => 0 ) )->where_in ( 'id', $msgids )->update ( 'message' );

		} else {
			$this->db->where ( array ('status' => 2 ) )->where_in ( 'id', $msgids )->delete ( 'message' );
			$this->db->set ( 'status', 1 )->where ( array ('status' => 0 ) )->where_in ( 'id', $msgids )->update ( 'message' );
		}
	}
	/**
	
	* 删除用户消息
	
	* @date: 2018年12月22日 下午5:52:02
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
    function delmessage($uid,$subject,$typename){
    	$this->db->query ( "DELETE FROM " . $this->db->dbprefix . "message WHERE touid=$uid and subject='$subject' and typename='$typename' " );
       
    }
	/**
	 * 根据发件人删除整个对话
	 * @param type $authors
	 */
	function remove_by_author($authors) {
		global $user;
		foreach ( $authors as $fromuid ) {
			$fromuid = intval ( $fromuid );
			$this->db->query ( "DELETE FROM " . $this->db->dbprefix . "message WHERE fromuid<>touid AND ((fromuid=$fromuid AND touid=" . $user ['uid'] . ") AND status=1)" );
			$this->db->query ( "DELETE FROM " . $this->db->dbprefix . "message WHERE fromuid<>touid AND ((fromuid=" . $user ['uid'] . " AND touid=" . $fromuid . ") AND  status=2" );
			$this->db->query ( "UPDATE " . $this->db->dbprefix . "message SET status=2 WHERE fromuid<>touid AND ((fromuid=$fromuid AND touid=" . $user ['uid'] . ") AND status IN (0,1))" );
			$this->db->query ( "UPDATE " . $this->db->dbprefix . "message SET status=1 WHERE fromuid<>touid AND ((fromuid=" . $user ['uid'] . " AND touid=" . $fromuid . ") AND  status IN (0,2))" );
		}
	}

	/* 更新消息为已读状态 */

	function read_by_fromuid($fromuid, $touid = 0, $id = 0) {
		$fromuid = intval ( $fromuid );
		$touid = intval ( $touid );
		$id = intval ( $id );
		if ($fromuid != 0) {
			$this->db->query ( "UPDATE `" . $this->db->dbprefix . "message` set new=0  WHERE `fromuid` =$fromuid AND  `touid` =$touid AND  `id` =$id " );
		} else {

			$this->db->query ( "UPDATE `" . $this->db->dbprefix . "message` set new=0  WHERE `fromuid` =$fromuid AND  `touid` =$touid  " );
		}

	}

	function update_status($id, $status) {
		$id = intval ( $id );
		$status = intval ( $status );
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "message SET status=$status WHERE id=$id" );
	}

	function update_allstatus($touid, $status) {
		$touid = intval ( $touid );
		$status = intval ( $status );
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "message SET new=0,status=$status WHERE touid=$touid" );
	}

	function read_user_recommend($uid, $user_categorys) {
		if (! $user_categorys) {
			return 0;
		}
		$cids = implode ( ",", $user_categorys );
		$sql = "SELECT id FROM " . $this->db->dbprefix . "question WHERE cid IN ($cids) AND id NOT IN (SELECT qid FROM " . $this->db->dbprefix . "user_readlog WHERE uid=$uid)";
		$query = $this->db->query ( $sql );
		$questionlist = array ();
		foreach ( $query->result_array () as $question ) {
			$questionlist [] = $question;
		}
		if ($questionlist) {
			$insertsql = "INSERT INTO " . $this->db->dbprefix . "user_readlog(qid,uid) VALUES ";
			foreach ( $questionlist as $question ) {
				$insertsql .= "(" . $question ['id'] . ",$uid),";
			}
			$this->db->query ( substr ( $insertsql, 0, - 1 ) );
		}
	}

	function rownum_user_recommend($uid, $user_categorys, $type = 'all') {
		if (! $user_categorys) {
			return 0;
		}
		$timestart = time () - 30 * 24 * 3600;
		$cids = implode ( ",", $user_categorys );
		if($cids!=''){
			$wherecid="cid IN ($cids) AND";
		}
		$sql = "SELECT COUNT(*) as num FROM " . $this->db->dbprefix . "question WHERE $wherecid  authorid<>$uid";
		($type == 'notread') && $sql .= "  AND id NOT IN (SELECT qid FROM " . $this->db->dbprefix . "user_readlog WHERE uid=$uid) AND time>$timestart";

		$m = $this->db->query ( $sql )->row_array ();
		return $m ['num'];
	}

	function list_user_recommend($uid, $user_categorys, $start = 0, $limit = 20) {
		global $category;
		$questionlist = array ();
		if (! $user_categorys) {
			return $questionlist;
		}
		$cids = implode ( ",", $user_categorys );

		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "question WHERE cid IN ($cids) AND authorid<>$uid ORDER BY time DESC LIMIT $start,$limit" );
		foreach ( $query->result_array () as $question ) {
			$question ['format_time'] = tdate ( $question ['time'] );
			$question ['category_name'] = $category [$question ['cid']] ['name'];
			$question ['avatar'] = get_avatar_dir ( $question ['authorid'] );
			$question ['url'] = url ( 'question/view/' . $question ['id'], $question ['url'] );
			$question ['title'] = checkwordsglobal ( $question ['title'] );
			$question ['image'] = getfirstimg ( $question ['description'] );
			$question ['description'] = cutstr ( checkwordsglobal ( strip_tags ( $question ['description'] ) ), 240, '...' );
			$questionlist [] = $question;
		}
		return $questionlist;
	}

}

?>
