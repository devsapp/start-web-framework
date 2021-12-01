<?php

class Note_model extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	function get($id) {
		$id=intval($id);
		$note = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "note WHERE id='$id'" )->row_array ();
		$note ['format_time'] = tdate ( $note ['time'], 3, 0 );
		$note ['author_has_vertify'] = get_vertify_info ( $note['authorid'] ); //用户是否认证
		$note ['user'] = $this->get_by_uid ( $note['authorid'] );
		$note ['title'] = checkwordsglobal ( $note ['title'] );
		$note ['content'] = checkwordsglobal ( $note ['content'] );
		$note ['artlen'] = strlen ( strip_tags ( $note ['content'] ) );
		$note ['avatar'] = get_avatar_dir ( $note ['authorid'] );
		return $note;
	}
	//查找我是否评论过
	function getbyuid($uid, $id) {
		$id=intval($id);
		$uid=intval($uid);
		$note = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "note_comment WHERE authorid='$uid' and noteid='$id'" )->row_array ();
 
		return $note;
	}
	/**
	
	* 获取用户信息
	
	* @date: 2018年11月5日 下午1:58:11
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function get_by_uid($uid) {
		$uid=intval($uid);
		$user = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user WHERE uid='$uid'" )->row_array ();
		$user ['avatar'] = get_avatar_dir ( $uid );
		$user ['groupname']=$this->usergroup [$user['groupid']]['grouptitle'];
		return $user;
	}
	function get_list($start = 0, $limit = 10) {
		$notelist = array ();
		$query = $this->db->query ( "select * from " . $this->db->dbprefix . "note order by id desc limit $start,$limit" );
		foreach ( $query->result_array () as $note ) {
			$note ['format_time'] = tdate ( $note ['time'], 3, 0 );
			$note ['title'] = checkwordsglobal ( $note ['title'] );
			$note ['avatar'] = get_avatar_dir ( $note ['authorid'] );
			$note ['image'] = getfirstimg ( $note ['content'] );
			$note ['images'] = getfirstimgs ( $note ['content'] );
			$note ['content'] = cutstr ( checkwordsglobal ( strip_tags ( $note ['content'] ) ), 240, '...' );

			$notelist [] = $note;
		}
		return $notelist;
	}

	function add($title, $url, $content) {
		$username = $this->base->user ['username'];
		$uid = $this->base->user ['uid'];
		$data=array(
				'title'=>$title,
				'authorid'=>$uid,
				'author'=>$username,
				'url'=>$url,
				'content'=>$content,
				'time'=>time()
		);
		$this->db->insert('note',$data);
		
		return $this->db->insert_id ();
	}

	function update_views($noteid) {
		$noteid=intval($noteid);
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "note SET views=views+1 WHERE `id`='$noteid'" );
	}

	function update_comments($noteid) {
		$noteid=intval($noteid);
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "note SET comments=comments+1 WHERE `id`='$noteid'" );
	}

	function update($id, $title, $url, $content) {
		$username = $this->base->user ['username'];
		$data=array(
				'title'=>$title,
			
				'author'=>$username,
				'url'=>$url,
				'content'=>$content,
				'time'=>time()
		);
		$this->db->where(array('id'=>$id))->update('note',$data);
	}

	function remove_by_id($ids) {
		$ids=explode(',', $ids);
		$this->db->where_in('id',$ids)->delete("note");
		$this->db->where_in('typeid',$ids)->where(array('type'=>'note'))->delete("topdata");
	
	}

}

?>
