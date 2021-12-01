<?php

class Vertify_model extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	function get_by_uid($uid, $loginstatus = 1) {
		$uid=intval($uid);
		$vertify = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "vertify WHERE uid='$uid'" )->row_array ();
		if($vertify){
		$vertify ['avatar'] = get_avatar_dir ( $uid );
		$vertify ['time'] = tdate ( $vertify ['time'] );
		if ($vertify ['status'] == null) {
			$vertify ['status'] = - 1;
		}
		switch ($vertify ['status']) {
			case 0 :
				$vertify ['msg'] = "等待审核";
				break;
			case 1 :
				$vertify ['msg'] = "审核通过";
				break;
			case 2 :
				$vertify ['msg'] = "审核被退回";
				break;
			default :
				$vertify ['msg'] = "未认证";
				break;
		}
		}

		return $vertify;
	}
	//获取审核列表
	function get_list($status, $start = 0, $limit = 10) {
		$vertifylist = array ();
		$query=$this->db->order_by("time asc")->get_where('vertify',array('status'=>$status),$limit, $start);
	
		foreach ( $query->result_array () as $vertify ) {
			$vertify ['vcategory'] = $this->get_category ( $vertify ['uid'] );
			$vertify ['avatar'] = get_avatar_dir ( $vertify ['uid'] );
			$vertify ['time'] = tdate ( $vertify ['time'] );
			$vertify ['jieshao'] = cutstr ( checkwordsglobal ( strip_tags ( $vertify ['jieshao'] ) ), 120, '...' );
			$vertifylist [] = $vertify;
		}
		return $vertifylist;
	}
	//插入审核信息
	function add($uid, $type, $name, $idcode, $jieshao, $zhaopian1, $zhaopian2, $status) {
		$uid=intval($uid);
		$this->db->where(array('uid'=>$uid))->delete('vertify');
		
		$status = 0;
		$datainsert=array(
				'uid'=>$uid,
				'type'=>$type,
				'name'=>$name,
				'id_code'=>$idcode,
				'jieshao'=>$jieshao,
				'zhaopian1'=>$zhaopian1,
				'zhaopian2'=>$zhaopian2,
				'status'=>$status,
				'time'=>time()
		);
		$this->db->insert('vertify',$datainsert);
		$id = $this->db->insert_id ();
		$data1=array('hasvertify'=>0);
		$this->db->where(array('uid'=>$uid))->update('vertify',$data1);
	
		return $id;
	}

	//更新审核信息
	function save($id, $uid, $status, $yuanyin) {
		$data1=array('status'=>$status,'shibaiyuanyin'=>$yuanyin);
		$this->db->where(array('id'=>$id,'uid'=>$uid))->update('vertify',$data1);

		if ($status == 1) {
			$data1=array('hasvertify'=>1);
			$this->db->where(array('uid'=>$uid))->update('vertify',$data1);
			
		}
	}
	//获取用户擅长分类
	function get_category($uid) {
		$uid=intval($uid);
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user_category WHERE uid=$uid" );
		$categorystr = '';
		foreach ( $query->result_array () as $category ) {
			$category ['categoryname'] = $this->base->category [$category ['cid']] ['name'];
			$categorystr .= "<span class='label'>" . $category ['categoryname'] . "</span>,";
		}
		return $categorystr;
	}
}

?>
