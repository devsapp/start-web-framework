<?php

class Answer_comment_model extends CI_Model {

	function __construct() {
		$this->load->database ();
	}
    //获取用户回答评论
	function get_by_uid($uid, $aid) {
		$query = $this->db->get_where ( 'answer_comment', array ('authorid' => $uid, 'aid' => $aid ) );
		$answer_comment = $query->row_array ();

		if ($answer_comment) {
			$answer_comment ['content'] = checkwordsglobal ( $answer_comment ['content'] );
		}
		return $answer_comment;
	}
    //根据回答uid获取评论
	function get_by_aid($aid, $start = 0, $limit = 10) {
		$commentlist = array ();
		$query = $this->db->select ( '*' )->from ( 'answer_comment' )->where ( array ('aid' => $aid ) )->order_by ( 'time DESC' )->limit ( $limit, $start )->get ();

		foreach ( $query->result_array () as $comment ) {
			$comment ['ishidden'] =0;
			$comment ['avatar'] = get_avatar_dir ( $comment ['authorid'] );
			//根据回答id查询当前回答
			$answer=$this->db->get_where('answer',array('id'=>$comment['aid'] ))->row_array();
			if($answer){
				//获取当前问题id
				$qid=$answer['qid'];
				//查询当前问题
				$question=$this->db->get_where('question',array('id'=>$qid ))->row_array();
				if($question){
					if($question['hidden']==1&&$comment['authorid']==$question['authorid']){
						//判断是否匿名
						$comment['ishidden'] =1;
						$comment['author'] ="匿名用户";
						$comment ['avatar'] = get_avatar_dir ( 0);
						$comment ['authorid']=0;
					}
					
				}
			}
		
			$comment ['format_time'] = tdate ( $comment ['time'] );
			$comment ['content'] = checkwordsglobal ( $comment ['content'] );
			$commentlist [] = $comment;
		}
		return $commentlist;
	}
   //添加回答评论
	function add($answerid, $conmment, $authorid, $author) {
		$conmment = checkwordsglobal ( $conmment );
		$data = array ('aid' => $answerid, 'authorid' => $authorid, 'author' => $author, 'content' => $conmment, 'time' => time () );

		$this->db->insert ( 'answer_comment', $data );
		$id = $this->db->insert_id ();
		$this->db->set('comments', 'comments+1', false)->where ( 'id', $answerid );
		$this->db->update ( 'answer' );
		return $id;
	}
    //删除回答评论
	function remove($commentids, $answerid) {
		$commentcount = 1;
		if (is_array ( $commentids )) {
			$commentcount = count ( $commentids );
			$commentids = implode ( ",", $commentids );
		}
		$this->db->where_in ( 'id', $commentids );
		$this->db->delete ( 'answer_comment' );
		$data = array ('comments' => "comments -$commentcount" );
		$this->db->where ( 'id', $answerid );
		$this->db->update ( 'answer', $data );

	}

}

?>
