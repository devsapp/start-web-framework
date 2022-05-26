<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Admin_nav extends ADMIN_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'nav_model' );
		$this->load->model ( 'adminnav_model' );
	}
	function index($message = '') {
		if (empty ( $message ))
			unset ( $message );
		$navlist = $this->nav_model->get_list ( 0, 100 );
		include template ( 'navlist', 'admin' );
	}
	function add() {
		if (null !== $this->input->post ( 'submit' )) {
			$name = $this->input->post ( 'name' );
			$title = $this->input->post ( 'title' );
			$url = $this->input->post ( 'url' );
			$target = $this->input->post ( 'target' );
			$navtype = $this->input->post ( 'type' );
			if (! $name || ! $url) {
				$type = 'errormsg';
				$message = '导航名称或导航地址不能为空!';
				include template ( 'addnav', 'admin' );
				exit ();
			}
			$this->nav_model->add ( $name, $url, $title, $target, 1, $navtype );
			$this->cache->remove ( 'nav' );
			$this->index ( '导航添加成功！' );
		} else {
			include template ( 'addnav', 'admin' );
		}
	}
	function edit() {
		if (null !== $this->input->post ( 'submit' )) {
			$name = $this->input->post ( 'name' );
			$title = $this->input->post ( 'title' );
			$url = $this->input->post ( 'url' );
			$target = $this->input->post ( 'target' );
			$navtype = $this->input->post ( 'type' );
			$nid = intval ( $this->input->post ( 'nid' ) );
			if (! $name || ! $url) {
				$type = 'errormsg';
				$message = '导航名称或导航地址不能为空!';
				$curnav = $this->nav_model->get ( $nid );
				include template ( 'addnav', 'admin' );
				exit ();
			}
			$this->nav_model->update ( $name, $url, $title, $target, $navtype, intval ( $nid ) );
			$this->cache->remove ( 'nav' );
			$this->index ( '导航修改成功！' );
		} else {
			$curnav = $this->nav_model->get ( intval ( $this->uri->segment ( 3 ) ) );
			include template ( 'addnav', 'admin' );
		}
	}
	function remove() {
		$this->nav_model->remove_by_id ( intval ( $this->uri->segment ( 3 ) ) );
		$this->cache->remove ( 'nav' );
		$this->index ( '导航刪除成功！' );
	}
	function reorder() {
		$orders = explode ( ",", $this->input->post ( 'order' ) );
		$hid = intval ( $this->input->post ( 'hiddencid' ) );
		foreach ( $orders as $order => $lid ) {
			$this->nav_model->order_nav ( intval ( $lid ), $order );
		}
	}
	function available() {
		$available = intval ( $this->uri->segment ( 4 ) ) ? 0 : 1;
		$this->nav_model->update_available ( intval ( $this->uri->segment ( 3 ) ), $available );
		$this->cache->remove ( 'nav' );
		$message = $available ? '导航栏启用成功!' : '导航栏禁用成功!';
		$this->index ( $message );
	}
	/**
	 *
	 * 后台菜单管理
	 *
	 * @date: 2020年10月4日 上午10:33:09
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function manager() {
		$arr=array('type'=>1,'navid'=>0);
		$navlist = $this->adminnav_model->get_list ( $arr, 0, 100 );
		include template ( 'admin_navlist', 'admin' );
	}
	/**
	
	* 获取指定导航id下的子导航
	
	* @date: 2020年10月4日 下午3:32:12
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function managerviewchildnav($navid) {
		$navid=intval($navid);
		$parentnav = $this->db->get_where ( 'admin_nav', array (
				'id' => $navid
		) )->row_array ();
		$arr=array('type'=>2,'navid'=>$navid);
		$navlist = $this->adminnav_model->get_list ( $arr, 0, 100 );
		include template ( 'admin_navsublist', 'admin' );
	}
	/**
	 *
	 * 添加导航
	 *
	 * @date: 2020年10月4日 上午11:18:18
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function manageradd() {
		$type="add";
		$arr=array('type'=>1,'navid'=>0);
		$navlist = $this->adminnav_model->get_list ( $arr, 0, 100 );
		if (null !== $this->input->post ( 'submit' )) {
			$name = $this->input->post ( 'name' );
			$url = $this->input->post ( 'url' );
			$pid = intval ( $this->input->post ( 'pid' ) );
			if (! $name) {
				$message = '导航名称不能为空!';
				include template ( 'admin_navlist_add', 'admin' );
				exit ();
			}
			$nav = $this->db->get_where ( 'admin_nav', array (
					'name' => trim ( $name )
			) )->row_array ();
			if ($nav) {
				$message = $name.'--导航名称已存在!';
				include template ( 'admin_navlist_add', 'admin' );
				exit ();
			}
			
			$adddata = array (
					'name' => $name,
					'url' => $url,
					'pid' => $pid 
			);
			$this->db->insert ( "admin_nav", $adddata );
			$id = $this->db->insert_id ();
			if ($id > 0) {
				// 更新排序
				$this->db->where ( array (
						'id' => $id 
				) )->update ( 'admin_nav', array (
						'ordernum' => $id 
				) );
				
				// 更新子导航个数
				$navnums = returnarraynum ( $this->db->query ( getwheresql ( 'admin_nav', "pid=$pid", $this->db->dbprefix ) )->row_array () );
				
				$this->db->where ( array (
						'id' => $pid 
				) )->update ( 'admin_nav', array (
						'childs' => $navnums 
				) );
				$this->message ( '导航添加成功！', "admin_nav/manager" );
			} else {
				$message = '导航添加失败!';
				include template ( 'admin_navlist_add', 'admin' );
				exit ();
			}
		} else {
			
			include template ( 'admin_navlist_add', 'admin' );
		}
	}
	/**
	 *
	 * 更新导航信息
	 *
	 * @date: 2020年10月4日 下午12:30:18
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function managerdo() {
		foreach ( $_POST ['cid'] as $navid ) {
			$name = trim ( strip_tags ( $_POST ['cname' . $navid] ) );
			if ($name == '' || empty ( $name )) {
				continue;
			}
			$ordernum = intval ( $_POST ['corder' . $navid] );
			if ($ordernum == 0) {
				$ordernum = 1;
			}
			$status = intval ( $_POST ['cstatus' . $navid] );
			if($_POST['updateseccat']){
				$url = strip_tags($_POST ['curl' . $navid] );
				$this->db->where ( array (
						'id' => $navid
				) )->update ( 'admin_nav', array (
						'name' => $name,
						'ordernum' => $ordernum,
						'status' => $status,
						'url'=>$url
				) );
			}else{
				$this->db->where ( array (
						'id' => $navid
				) )->update ( 'admin_nav', array (
						'name' => $name,
						'ordernum' => $ordernum,
						'status' => $status
				) );
			}
		
		}
		$this->message ( "更新完成" );
	}
	/**
	
	* 批量删除导航
	
	* @date: 2020年10月4日 下午3:43:33
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function managerdoremove(){
		foreach ( $_POST ['cid'] as $navid ) {
			$nav = $this->db->get_where ( 'admin_nav', array (
					'id' => $navid
			) )->row_array ();
			if($nav){
				$pid=$nav['pid'];//获取父级导航id
				if($pid!=0){
					//如果不是顶级导航执行删除
					$this->db->where(array('id'=>$navid))->delete('admin_nav');
					//更新顶级导航子导航的数量
					$this->db->set('childs', 'childs-1', false)
					->where('id', $pid)
					->update("admin_nav");
				}
			}
		}
		$this->message ( "删除完成" );
	}
	/**
	
	* 添加子导航
	
	* @date: 2020年10月4日 下午3:19:24
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function manageraddchildnav($navpid){
		$type="add";
		$navpid=intval($navpid);
		$parentnav = $this->db->get_where ( 'admin_nav', array (
				'id' => $navpid
		) )->row_array ();
		if(!$parentnav){
			$this->message("父级导航不存在");
			exit();
		}
		$arr=array('type'=>1,'navid'=>0);
		$navlist = $this->adminnav_model->get_list ( $arr, 0, 100 );
		include template ( 'admin_navlist_add', 'admin' );
	}
	/**
	 *
	 * ajaxpost提交静态菜单
	 *
	 * @date: 2020年10月4日 下午2:06:47
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function managerpost() {
		$name = $this->input->post ( 'name' );
		$url = $this->input->post ( 'url' );
		$pid = intval ( $this->input->post ( 'pid' ) );
		if (! $name) {
			$message ['code'] = 400;
			$message ['message'] = '导航名称不能为空!';
			echo json_encode ( $message );
			exit ();
		}
		$nav = $this->db->get_where ( 'admin_nav', array (
				'name' => trim ( $name ) 
		) )->row_array ();
		if ($nav) {
			$message ['code'] = 200;
			if ($nav ['pid'] == 0) {
				$message ['pid'] = $nav ['id'];
			} else {
				$message ['pid'] = 0;
			}
			
			$message ['message'] = $name . '--导航名称已存在!';
			echo json_encode ( $message );
			exit ();
		}
		$adddata = array (
				'name' => $name,
				'url' => $url ? $url : '',
				'pid' => $pid 
		);
		$this->db->insert ( "admin_nav", $adddata );
		$id = $this->db->insert_id ();
		if ($id > 0) {
			// 更新排序
			$this->db->where ( array (
					'id' => $id 
			) )->update ( 'admin_nav', array (
					'ordernum' => $id 
			) );
			// 更新子导航个数
			$navnums = returnarraynum ( $this->db->query ( getwheresql ( 'admin_nav', "pid=$pid", $this->db->dbprefix ) )->row_array () );
			
			$this->db->where ( array (
					'id' => $pid 
			) )->update ( 'admin_nav', array (
					'childs' => $navnums 
			) );
			$message ['code'] = 200;
			if ($pid == 0) {
				$message ['pid'] = $id;
			} else {
				$message ['pid'] = 0;
			}
			
			$message ['message'] = $name . '-添加成功!';
			echo json_encode ( $message );
			exit ();
		} else {
			$message ['code'] = 400;
			$message ['message'] = '导航添加失败!';
			echo json_encode ( $message );
			exit ();
		}
	}
}

?>