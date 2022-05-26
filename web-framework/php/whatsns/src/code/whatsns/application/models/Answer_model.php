<?php

class Answer_model extends CI_Model {

	var $arrstatustable = array ('all' => array ('status!=' => 0 ), '0' => array ('status' => 0 ), '1' => array ('status!=' => 0, 'adopttime' => 0 ), '2' => array ('status!=' => 0, 'adopttime>' => 0 ) );
	var $statustable = array ('all' => ' AND status!=0', '0' => ' AND status=0', '1' => ' AND status!=0 AND adopttime=0', '2' => ' AND status!=0 AND adopttime>0' );
	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	/* 根据aid获取一个答案的内容，暂时无用 */

	function get($id) {

		$query = $this->db->get_where ( 'answer', array ('id' => $id ) );
		$answer = $query->row_array ();
		if ($answer) {
			$answer ['author_avartar'] = get_avatar_dir ( $answer['authorid'] );
			$answer ['author_has_vertify'] = get_vertify_info ( $answer['authorid'] ); //用户是否认证
			$answer ['authorname'] =$answer ['author'];
			$answer ['format_adopttime'] = tdate ( $answer ['adopttime'] );
			$answer ['format_time'] = tdate ( $answer ['time'] );
			$answer ['appends'] = $this->get_appends ( $answer ['id'] );
			$answer ['title'] = checkwordsglobal ( $answer ['title'] );
			$answer ['content'] = checkwordsglobal ( $answer ['content'] );
		}
		return $answer;
	}
	//获取某人是否回答了问题
	function getanswerbyuid($uid, $qid) {
		$query = $this->db->get_where ( 'answer', array ('qid' => $qid, 'authorid' => $uid ) );
		$answer = $query->row_array ();
		return $answer;
	}

	//获取得最佳答案
	function get_best($qid) {
		global $usergroup;
		$query = $this->db->get_where ( 'answer', array ('qid' => $qid, 'adopttime >' => 0 ) );

		$bestanswer = $query->row_array ();
		if ($bestanswer) {

			$bestanswer ['format_adopttime'] = tdate ( $bestanswer ['adopttime'] );
			$bestanswer ['format_time'] = tdate ( $bestanswer ['time'] );
			$bestanswer ['author_avartar'] = get_avatar_dir ( $bestanswer ['authorid'] );
			$bestanswer ['author_has_vertify'] = get_vertify_info ( $bestanswer ['authorid'] ); //用户是否认证
			
			$bestanswer ['appends'] = $this->get_appends ( $bestanswer ['id'] );
			try {
				$bestanswer ['total'] = $this->getmoneybyaid ( $bestanswer ['id'] );
				$bestanswer ['payuser'] = $this->getmoneyuserbyaid ( $bestanswer ['id'] );
			} catch ( Exception $e ) {
				$bestanswer ['total'] = 0;
			}

			if (! $bestanswer ['total']) {
				$bestanswer ['total'] = 0;
			}
			$bestanswer ['title'] = checkwordsglobal ( $bestanswer ['title'] );
			$bestanswer ['content'] = checkwordsglobal ( $bestanswer ['content'] );
			$bestanswer ['userinfo'] = array ();

			$query = $this->db->get_where ( 'user', array ('uid' => $bestanswer ['authorid'] ) );

			$author = $query->row_array ();
			if ($author) {
				$bestanswer ['author_groupname'] = $usergroup [$author ['groupid']] ['grouptitle'];
				$bestanswer ['author_grouptype'] = $usergroup [$author ['groupid']] ['grouptype'];
				$bestanswer ['adoption_rate'] = round ( $author ['adopts'] / $author ['answers'], 2 ) * 100;
			}
		}
		return $bestanswer;
	}

	function get_comment_options($groupcredit, $type = 1) {
		$maxcredit = ($groupcredit == 0 || $groupcredit > 10) ? 10 : $groupcredit;
		$optionlist = range ( 1, $maxcredit );
		$optionstr = '<select name="credit3">';
		foreach ( $optionlist as $val ) {
			if ($type)
				$optionstr .= '<option value="' . $val . '">+' . $val . '</option>';
			else
				$optionstr .= '<option value="-' . $val . '">-' . $val . '</option>';
		}
		$optionstr .= '</select>';
		return $optionstr;
	}

	/* 根据qid获取答案的列表，用于在浏览一个问题的时候显示用 */

	function list_by_qid($qid, $ordertype = 1, $rownum = 0, $start = 0, $limit = 10) {
		global $user, $usergroup;
		$answerlist = array ();
		$already = 0;
		if (1 == $ordertype) {
			$timeorder = 'ASC';
			$floor = $start + 1;
		} else {
			$timeorder = 'DESC';
			$floor = ($start) ? ($rownum - $start) : $rownum;
		}
		$query = $this->db->select ( '*' )->from ( 'answer' )->where ( array ('qid' => $qid, 'status>' => 0, 'adopttime' => 0 ) )->order_by ( "supports DESC,time $timeorder" )->limit ( $limit, $start )->get ();

		foreach ( $query->result_array () as $answer ) {
			if ($answer ['authorid'] == $user ['uid']) {
				$already = 1;
			}
			$answer ['floor'] = $floor;
			try {
				$answer ['total'] = $this->getmoneybyaid ( $answer ['id'] );
				$answer ['payuser'] = $this->getmoneyuserbyaid ( $answer ['id'] );
			} catch ( Exception $e ) {
				$answer ['total'] = 0;
			}

			if (! $answer ['total']) {
				$answer ['total'] = 0;
			}
			$answer ['time'] = tdate ( $answer ['time'] );
			$answer ['ip'] = formatip ( $answer ['ip'] );
			$answer ['content'] = checkwordsglobal ( $answer ['content']);
			$answer ['title'] = checkwordsglobal ( $answer ['title'] );
			$answer ['author_has_vertify'] = get_vertify_info ( $answer ['authorid'] ); //用户是否认证
			$answer ['author_avartar'] = get_avatar_dir ( $answer ['authorid'] );
			$answer ['appends'] = $this->get_appends ( $answer ['id'] );

			$query = $this->db->get_where ( 'user', array ('uid' => $answer ['authorid'] ) );

			$author = $query->row_array ();
			if ($author) {
				$answer ['author_groupname'] = $usergroup [$author ['groupid']] ['grouptitle'];
				$answer ['author_grouptype'] = $usergroup [$author ['groupid']] ['grouptype'];
				if ($author ['answers'] == 0) {
					$answer ['adoption_rate'] = 0;
				} else {
					$answer ['adoption_rate'] = round ( $author ['adopts'] / $author ['answers'], 2 ) * 100;
				}

			}
			$answerlist [] = $answer;
			if (1 == $floor) {
				$floor ++;
			} else {
				$floor --;
			}
		}
		return array ($answerlist, $already );
	}

	function getmoneybyaid($aid) {
		//ask_weixin_notify
		$query = $this->db->select_sum ( 'money', 'total' )->where ( array ('type' => 'aid', 'typeid' => $aid ) )->get ( 'paylog' );

		$mod = $query->row_array ();

		return $mod ['total'] ;
	}
	function getmoneyuserbyaid($aid) {
		$mdlist = array ();
		$query = $this->db->distinct ()->select ( array ('openid' ) )->where ( array ('type' => 'aid', 'typeid' => $aid ) )->get ( 'weixin_notify' );
		foreach ( $query->result_array () as $md ) {
			$dashangren = $this->f_get ( $md ['openid'] );
			$md ['nickname'] = $dashangren ['nickname'];
			$md ['headimgurl'] = $dashangren ['headimgurl'];
			$mdlist [] = $md;
		}
		return $mdlist;
	}
	function f_get($openid) {
		$query = $this->db->from ( 'weixin_follower' )->where ( array ('openid' => $openid ) )->get ();
		$model = $query->row_array ();
		return $model;
	}

	/* 根据uid获取答案的列表，用于在用户中心，我的回答显示 */

	function list_by_uid($uid, $status, $start = 0, $limit = 5) {
		$answerlist = array ();
		$query = $this->db->select ( '*' )->where ( array ('authorid' => $uid ) )->where ( $this->arrstatustable [$status] )->order_by ( 'time', 'DESC' )->limit ( $limit, $start )->get ( 'answer' );

		foreach ( $query->result_array () as $answer ) {
			$answer ['time'] = tdate ( $answer ['time'] );
			$answer ['author_has_vertify'] = get_vertify_info ( $answer ['authorid'] ); //用户是否认证


			$answer ['content'] = checkwordsglobal ( $answer ['content'] );
			$answer ['image'] = getfirstimg ( $answer ['content'] );
			$answer ['avatar'] = get_avatar_dir ( $answer ['authorid'] );
			if ($answer ['reward'] > 0) {
				$answer ['description'] ="此回答需要付费才能查看";
			} else {
				$answer ['description'] =clearhtml($answer ['content']) ;
			}
            //判断是否是匿名
			$question=$this->db->get_where('question',array('id'=>$answer['qid']))->row_array();
			if($question['hidden']){
				$answer['hidden']=1;
				$answer['title']="此匿名问题只对作者本人可见";
			}
			
			$answerlist [] = $answer;
		}
		return $answerlist;
	}

	/* 添加答案 */

	function add($qid, $title, $content, $status = 0, $chakanjine = 0) {
		$content = checkwordsglobal ( $content );
		$uid = $this->user ['uid'];
		$username = $this->user ['username'];
		$data = array ('qid' => $qid, 'title' => $title, 'author' => $username, 'authorid' => $uid, 'time' => time (), 'content' => $content, 'reward' => $chakanjine, 'status' => $status, 'ip' => getip () );
		$this->db->insert ( 'answer', $data );
		$aid = $this->db->insert_id ();
		$this->db->set ( 'answers', 'answers+1', FALSE )->where ( array ('id' => $qid ) )->update ( 'question' );
		$this->db->set ( 'answers', 'answers+1', FALSE )->where ( array ('uid' => $uid ) )->update ( 'user' );
		return $aid;
	}
	/* 添加语音答案 */

	function addvoice($qid, $title, $content, $status = 0, $chakanjine = 0, $voicetime, $serverid, $openid, $mediafile = '') {
		$content = checkwordsglobal ( $content );
		global $user;
		$uid = $user ['uid'];
		$username = $user ['username'];

		$data = array ('qid' => $qid, 'title' => $title, 'mediafile' => $mediafile, 'author' => $username, 'authorid' => $uid, 'time' => time (), 'serverid' => $serverid, 'openid' => $openid, 'content' => $content, 'voicetime' => $voicetime, 'reward' => $chakanjine, 'status' => $status, 'ip' => getip () );

		$sql = $this->db->insert ( 'answer', $data );
		$aid = $this->db->insert_id ();
		$this->db->set ( 'hasvoice', 1 );
		$this->db->set ( 'answers', 'answers+1',FALSE );
		$this->db->where ( 'id', $qid );
		$this->db->update ( 'question' );

		$this->db->where ( 'uid', $uid );
		$this->db->set ( 'answers', 'answers+1',FALSE );
		$this->db->update ( 'user' );

		return $aid;
	}
	function addapp($qid, $title, $content, $uid, $username, $status = 0) {
		$qid = intval ( $qid );
		$uid = intval ( $uid );
		$data = array ('qid' => $qid, 'title' => $title, 'author' => $username, 'authorid' => $uid, 'time' => time (), 'content' => $content, 'status' => $status, 'ip' => getip () );
		$this->db->insert ( 'answer', $data );
		$aid = $this->db->insert_id ();
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "question SET  answers=answers+1  WHERE id=" . $qid );
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET answers=answers+1 WHERE  uid =$uid" );
		return $aid;
	}
	function add_seo($qid, $title, $content, $uid1, $username1, $status = 0, $supports = 13, $mtime) {
		try {
			$uid = $uid1;
			$username = $username1;
			$qid = intval ( $qid );
			$uid = intval ( $uid );
			$data = array ('qid' => $qid, 'title' => $title, 'author' => $username, 'authorid' => $uid, 'time' => $mtime, 'content' => $content, 'supports' => $supports, 'status' => $status, 'ip' => getip () );
			$this->db->insert ( 'answer', $data );
			$aid = $this->db->insert_id ();
			$this->db->query ( "UPDATE " . $this->db->dbprefix . "question SET  answers=answers+1  WHERE id=" . $qid );
			$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET answers=answers+1 WHERE  uid =$uid" );
			return $aid;
		} catch ( Exception $er ) {
			return '0';
		}
	}
	/* 采纳指定的答案，问题状态变为2 已解决 */

	function adopt($qid, $answer) {
		$time = time ();
		$qid = intval ( $qid );
		$ret = $this->db->query ( "UPDATE " . $this->db->dbprefix . "answer SET adopttime='' WHERE  qid=$qid" );
        $ret = $this->db->query ( "UPDATE " . $this->db->dbprefix . "answer SET adopttime=$time WHERE id=" . $answer['id'] . " AND qid=$qid" );
		if ($ret) {
			$this->db->query ( "UPDATE " . $this->db->dbprefix . "question SET status=2 ,`endtime`='$time' WHERE id=" . $qid );
			$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET adopts=adopts+1 WHERE  uid=" . $answer ['authorid'] );
		}
		return $ret;
	}

	/* 添加追问--追问--回答 */

	function append($answerid, $author, $authorid, $content) {
		$content = checkwordsglobal ( $content );
		$data = array ('appendanswerid' => NULL, 'answerid' => $answerid, 'time' => time (), 'author' => $author, 'authorid' => $authorid, 'content' => $content );
		$this->db->insert ( 'answer_append', $data );
		return $this->db->insert_id ();
	}

	/* 获取追问信息列表 */

	function get_appends($answerid, $start = 0, $limit = 20) {
		$appendlist = array ();
		$answerid = intval ( $answerid );
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "answer_append WHERE answerid='$answerid' ORDER BY time ASC LIMIT $start,$limit" );
		foreach ( $query->result_array () as $append ) {
			$append ['format_time'] = tdate ( $append ['time'] );
			$append ['avatar'] = get_avatar_dir ( $append ['authorid'] );
			$append ['content'] = checkwordsglobal ( htmlspecialchars_decode($append ['content']) );
			$appendlist [] = $append;
		}
		return $appendlist;
	}

	/* 修改回答，同时重置回答的状态 */

	function update_content($aid, $content, $status = 0) {
		$this->db->set ( array ('content' => $content, 'status' => $status ) )->where ( array ('id' => $aid ) )->update ( 'answer' );

	}

	/* 后台回答搜索 */

	function list_by_search($title = '', $author = '', $keyword = '', $datestart = '', $dateend = '', $start = 0, $limit = 10) {
		$sql = "SELECT * FROM `" . $this->db->dbprefix . "answer` WHERE 1=1 ";
		$title && ($sql .= " AND `title` like '$title%' ");
		$author && ($sql .= " AND `author`='$author'");
		$keyword && ($sql .= " AND `content` like '%$keyword%' ");
		$datestart && ($sql .= " AND `time`>= " . strtotime ( $datestart ));
		$dateend && ($sql .= " AND `time`<= " . strtotime ( $dateend ));
		$sql .= " ORDER BY `id` DESC LIMIT $start,$limit ";
		$answerlist = array ();
		$query = $this->db->query ( $sql );
		foreach ( $query->result_array () as $answer ) {
			$answer ['time'] = tdate ( $answer ['time'] );
			$answer ['author_has_vertify'] = get_vertify_info ( $answer ['authorid'] ); //用户是否认证
			$answer ['content'] = checkwordsglobal ( $answer ['content'] );
			$answerlist [] = $answer;
		}
		return $answerlist;
	}

	function rownum_by_search($title = '', $author = '', $keyword = '', $datestart = '', $dateend = '') {
		$condition = " 1=1 ";
		$title && ($condition .= " AND `title` like '$title%' ");
		$author && ($condition .= " AND `author`='$author'");
		$keyword && ($condition .= " AND `content` like '$keyword%' ");
		$datestart && ($condition .= " AND `time`>= " . strtotime ( $datestart ));
		$dateend && ($condition .= " AND `time`<= " . strtotime ( $dateend ));
		$query = $this->db->query ( "select count(*) as num from " . $this->db->dbprefix . "answer where $condition" );
		$m = $query->row_array ();
		return $m ['num'];
	}

	/* 时间段内问题数目 */

	function rownum_by_time($uid, $hours = 1) {
		$starttime = strtotime ( date ( "Y-m-d H:00:00", time () ) );
		$endtime = $starttime + $hours * 3600;
		return $this->db->where ( array ('time>' => $starttime, 'time<' => $endtime, 'authorid' => $uid ) )->from ( 'answer' )->count_all_results ();
	}

	function list_by_condition($condition, $start = 0, $limit = 10) {
		$answerlist = array ();
		$query = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "answer` WHERE $condition ORDER BY `time` DESC limit $start,$limit" );
		foreach ( $query->result_array () as $answer ) {
			$answer ['time'] = tdate ( $answer ['time'] );
			$answer ['content'] = checkwordsglobal ( $answer ['content'] );
			$answer ['author_has_vertify'] = get_vertify_info ( $answer ['authorid'] ); //用户是否认证
			$answerlist [] = $answer;
		}
		return $answerlist;
	}

	function remove($aids) {
		//更新问题回答数
		$query = $this->db->select ( array ('qid', 'count(*) as answers' ) )->from ( 'answer' )->where_in ( 'id', explode ( ',', $aids ) )->group_by ( 'qid' )->get ();
		foreach ( $query->result_array () as $answer ) {
			list ( $qid, $answers ) = $answer;
			$this->db->set ( 'answers', "answers-$answers", FALSE )->where ( array ('id' => $qid ) )->update ( 'question' );
		}
		//更新回答人回答数
		$query = $this->db->select ( array ('authorid', 'count(*) as answers' ) )->from ( 'answer' )->where_in ( 'id', explode ( ',', $aids ) )->group_by ( 'authorid' )->get ();
		foreach ( $query->result_array () as $answer ) {
			list ( $authorid, $answers ) = $answer;
			$this->db->set ( 'answers', "answers-$answers", FALSE )->where ( array ('uid' => $authorid ) )->update ( 'user' );
		}

		//删除回答
		$this->db->where_in ( 'aid', explode ( ',', $aids ) )->delete ( 'answer_comment' );
		$this->db->where_in ( 'aid', explode ( ',', $aids ) )->delete ( 'answer_support' );
		$this->db->where_in ( 'id', explode ( ',', $aids ) )->delete ( 'answer' );
	}

	function remove_by_qid($aid, $qid) {
		$this->db->where ( array ('id' => $aid ) )->delete ( 'answer' );
		$this->db->set ( 'answers', 'answers-1', FALSE )->where ( array ('id' => $qid ) )->update ( 'question' );
	}

	function update_time_content($aid, $time, $content) {
		$this->db->set ( array ('content' => $content, 'time' => $time ) )->where ( array ('id' => $aid ) )->update ( 'answer' );
	}

	function change_to_verify($aids) {
		$this->db->set ( 'status', 1 )->where_in ( 'id', explode ( ',', $aids ) )->where ( array ('status' => 0 ) )->update ( 'answer' );

	}

	function get_support_by_sid_aid($sid, $aid) {
		return $this->db->where ( array ('sid' => $sid, 'aid' => $aid ) )->count_all_results ( 'answer_support' );
	}

	function add_support($sid, $aid, $authorid) {
		$this->db->replace ( 'answer_support', array ('sid' => $sid, 'aid' => $aid, 'time' => time () ) );
		$this->db->set ( 'supports', 'supports+1', FALSE )->where ( array ('id' => $aid ) )->update ( 'answer' );
		$this->db->set ( 'supports', 'supports+1', FALSE )->where ( array ('uid' => $authorid ) )->update ( 'user' );
	}

}

?>
