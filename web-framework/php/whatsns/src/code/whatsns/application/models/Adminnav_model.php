<?php
class Adminnav_model extends CI_Model {
	public function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	public function get($id) {
		$query = $this->db->get_where ( 'admin_nav', array (
				'id' => $id 
		) );
		$row = $query->row_array ();
		return $row;
	}
	
	/**
	 *
	 * 查询后台菜单列表
	 *
	 * @date: 2020年10月4日 上午10:44:07
	 *
	 * @author : 61703
	 *        
	 * @param : $wherenum
	 *        	1 表示一级菜单
	 *        	
	 * @return :
	 *
	 */
	public function get_list($arr, $start = 0, $limit = 1000) {
		$navlist = array ();
		$type = $arr ['type'];
		switch ($type) {
			case 1 :
				$query = $this->db->select ( '*' )->where ( array (
						'pid' => 0 
				) )->from ( 'admin_nav' )->order_by ( 'ordernum asc' )->limit ( $limit, $start )->get ();
				break;
			case 2 :
				$query = $this->db->select ( '*' )->where ( array (
						'pid' => $arr ['navid'] 
				) )->from ( 'admin_nav' )->order_by ( 'ordernum asc' )->limit ( $limit, $start )->get ();
				break;
		}
		
		foreach ( $query->result_array () as $nav ) {
			
			$navlist [] = $nav;
		}
		return $navlist;
	}
}

?>
