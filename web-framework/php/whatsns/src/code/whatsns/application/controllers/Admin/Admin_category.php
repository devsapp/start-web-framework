<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Admin_category extends ADMIN_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'category_model' );
	}
	function index($_message = '') {
		$message = $_message;
		$category ['grade'] = $pid = 0;
		$tcategorylist = $this->category_model->list_by_pid ( $pid );
		$categorylist = array ();
		foreach ( $tcategorylist as $cat ) {
			if ($cat ['isshowindex'] == null || $cat ['isshowindex'] == 0) {
				$cat ['isshowindex'] = "首页显示";
			} else {
				$cat ['isshowindex'] = "首页不显示";
			}
			if ($cat ['isusearticle'] == null || $cat ['isusearticle'] == 0) {
				$cat ['isusearticle'] = "不应用到文章发布";
			} else {
				$cat ['isusearticle'] = "应用到文章发布";
			}
			if ($cat ['isuseask'] == null || $cat ['isuseask'] == 0) {
				$cat ['isuseask'] = "不应用到问答发布";
			} else {
				$cat ['isuseask'] = "应用到问答发布";
			}
			if (! isset ( $cat ['onlybackground'] ) || $cat ['onlybackground'] == 0) {
				$cat ['onlybackground'] = "前端可发布";
			} else {
				$cat ['onlybackground'] = "只后台发布";
			}
			$categorylist [] = $cat;
		}
		
		include template ( 'categorylist', 'admin' );
	}
	function updateCatTmplate() {
		// $tmpname='catlist_topic';//htmlspecialchars( $this->input->post ('tmpname'));
		$id = intval ( htmlspecialchars ( $this->input->post ( 'id' ) ) );
		$tmpname = htmlspecialchars ( $this->input->post ( 'tmpname' ) );
		$cat = $this->category_model->get ( $id );
		if ($cat ['template'] != null && $cat ['template'] != '') {
			$tmpname = '';
		}
		$this->category_model->update_by_id_tmplate ( $id, $tmpname );
		cleardir ( FCPATH . '/data/cache' ); // 清除缓存文件
		echo "1";
	}
	// 更新首页是否显示分类
	function updatecatbyindex() {
		if (null !== $this->input->post ( 'cid' )) {
			$cids = implode ( ",", $this->input->post ( 'cid' ) );
			$pid = intval ( $this->input->post ( 'hiddencid' ) );
			foreach ( $this->input->post ( 'cid' ) as $val ) {
				$type = 'isshowindex';
				$category = $this->category [$val];
				// 状态值
				$typevalue = $category ['isshowindex'] == 1 ? 0 : 1;
				$this->category_model->update_by_type ( $val, $type, $typevalue );
			}
			cleardir ( FCPATH . '/data/cache' ); // 清除缓存文件
			$this->index ( "设置成功" );
		}
	}
	// 更新问答是否显示分类
	function updatecatbywenda() {
		if (null !== $this->input->post ( 'cid' )) {
			$cids = implode ( ",", $this->input->post ( 'cid' ) );
			$pid = intval ( $this->input->post ( 'hiddencid' ) );
			foreach ( $this->input->post ( 'cid' ) as $val ) {
				$type = 'isuseask';
				$category = $this->category [$val];
				// 状态值
				$typevalue = $category ['isuseask'] == 1 ? 0 : 1;
				$this->category_model->update_by_type ( $val, $type, $typevalue );
			}
			cleardir ( FCPATH . '/data/cache' ); // 清除缓存文件
			$this->index ( "设置成功" );
		}
	}
	function updatecatbyorder() {
		if (null !== $this->input->post ( 'cid' )) {
			$cids = implode ( ",", $this->input->post ( 'cid' ) );
			$pid = intval ( $this->input->post ( 'hiddencid' ) );
			$orders = $this->input->post ( 'corder' );
			// var_dump($orders);exit();
			
			foreach ( $this->input->post ( 'cid' ) as $val ) {
				// echo $val.'--'.$orders[$i].'--'.$i."<br>";
				$orderval = $this->input->post ( 'corder' . $val );
				$this->category_model->order_category ( intval ( $val ), intval ( $orderval ) );
			}
			// exit();
			cleardir ( FCPATH . '/data/cache' ); // 清除缓存文件
			$this->message ( "设置成功" );
		}
	}
	// 更新问答是否显示分类
	function updatecatbywenzhang() {
		if (null !== $this->input->post ( 'cid' )) {
			$cids = implode ( ",", $this->input->post ( 'cid' ) );
			$pid = intval ( $this->input->post ( 'hiddencid' ) );
			foreach ( $this->input->post ( 'cid' ) as $val ) {
				$type = 'isusearticle';
				$category = $this->category [$val];
				// 状态值
				$typevalue = $category ['isusearticle'] == 1 ? 0 : 1;
				$this->category_model->update_by_type ( $val, $type, $typevalue );
			}
			cleardir ( FCPATH . '/data/cache' ); // 清除缓存文件
			$this->message ( "设置成功" );
		}
	}
	// 更新问答是否只在后台发布分类
	function updatecatbybackground() {
		if (null !== $this->input->post ( 'cid' )) {
			$cids = implode ( ",", $this->input->post ( 'cid' ) );
			$pid = intval ( $this->input->post ( 'hiddencid' ) );
			foreach ( $this->input->post ( 'cid' ) as $val ) {
				$type = 'onlybackground';
				$category = $this->category [$val];
				// 状态值
				$typevalue = $category ['onlybackground'] == 1 ? 0 : 1;
				$this->category_model->update_by_type ( $val, $type, $typevalue );
			}
			cleardir ( FCPATH . '/data/cache' ); // 清除缓存文件
			$this->message ( "设置成功" );
		}
	}
	function updatecatbytype() {
		$cid = intval ( $this->input->post ( 'cid' ) );
		// type 1:是否首页显示，2：是否应用问答，3：是否应用文章
		$type = intval ( $this->input->post ( 'type' ) );
		// 状态值
		$typevalue = intval ( $this->input->post ( 'typevalue' ) );
		$typevalue = $typevalue == 1 ? 0 : 1;
		switch ($type) {
			case 1 :
				$type = 'isshowindex';
				break;
			case 2 :
				$type = 'isuseask';
				break;
			case 3 :
				$type = 'isusearticle';
				break;
		}
		$this->category_model->update_by_type ( $cid, $type, $typevalue );
		cleardir ( FCPATH . '/data/cache' ); // 清除缓存文件
		echo "1";
	}
	function postadd() {
		if (null !== $this->input->post ( 'submit' )) {
			$pid = 0;
			$category1 = $this->input->post ( 'category1' );
			$category2 = $this->input->post ( 'category2' );
			
			if (isset ( $category2 ) && trim ( $category2 ) != '') {
				$pid = $category2;
			} else if (isset ( $category1 ) && trim ( $category1 ) != '') {
				$pid = $category1;
			}
			$lines = explode ( "\n", $this->input->post ( 'categorys' ) );
			$this->category_model->add ( $lines, $pid );
			cleardir ( FCPATH . '/data/cache' ); // 清除缓存文件
			
			exit ( '1' );
		} else {
			exit ( '0' );
		}
	}
	function add() {
		$id = intval ( $this->uri->segment ( 3 ) );
		$selectedarray = array ();
		if ($id) {
			$category = $this->category [$id];
			$item = $category;
			for($grade = $category ['grade']; $grade > 0; $grade --) {
				$selectedarray [] = $item ['id'];
				$item ['pid'] && $item = $this->category [$item ['pid']];
			}
		}
		
		if (isset ( $selectedarray ) && count ( $selectedarray ) > 0) {
			switch (count ( $selectedarray )) {
				case 1 :
					list ( $category1 ) = array_reverse ( $selectedarray );
					break;
				case 2 :
					list ( $category1, $category2 ) = array_reverse ( $selectedarray );
					break;
				case 3 :
					list ( $category1, $category2, $category3 ) = array_reverse ( $selectedarray );
					break;
			}
		}
		$categoryjs = $this->category_model->get_js ();
		include template ( 'addcategory', 'admin' );
	}
	// 获取分类描述
	function getmiaosu() {
		$id = intval ( htmlspecialchars ( $this->input->post ( 'id' ) ) );
		$category = $this->category [$id];
		echo $category ['miaosu'];
		exit ();
	}
	function editalias() {
		$alias = htmlspecialchars ( $this->input->post ( 'alias' ) );
		$id = intval ( htmlspecialchars ( $this->input->post ( 'id' ) ) );
		$this->category_model->update_by_id_alias ( $id, $alias );
		cleardir ( FCPATH . '/data/cache' ); // 清除缓存文件
		echo "更新成功";
	}
	function editmiaosu() {
		$miaosu = $this->input->post ( 'miaosu' );
		
		$id = intval ( $this->input->post ( 'id' ) );
		// runlog('miaosu.txt', $id.'----.'.$miaosu);
		$this->category_model->update_by_id_miaosu ( $id, $miaosu );
		cleardir ( FCPATH . '/data/cache' ); // 清除缓存文件
		echo "更新成功";
	}
	function edit() {
		$id = intval ( $this->uri->segment ( 3 ) ) == 0 ? intval ( $this->input->post ( 'id' ) ) : intval ( $this->uri->segment ( 3 ) );
		if (null !== $this->input->post ( 'submit' )) {
			$name = trim ( $this->input->post ( 'name' ) ); // 分类名称
			$aliasname = trim ( $this->input->post ( 'aliasname' ) ); // 分类别名
			$edit_miaosu = trim ( $this->input->post ( 'edit_miaosu' ) ); // 分类描述
			$s_tmplist = trim ( $this->input->post ( 's_tmplist' ) ); // 文章分类模板名字
			$s_articletmplist = trim ( $this->input->post ( 's_articletmplist' ) ); // 文章详情模板名字
			$dir= trim ( $this->input->post ( 'dir' ) ); // 分类目录名称
			$categorydir = '';
			$categorydir = empty($dir) ? '':$dir;
			$cid = 0;
			$category1 = $this->input->post ( 'category1' );
			$category2 = $this->input->post ( 'category2' );
			$category3 = $this->input->post ( 'category3' );
			if ($category3) {
				$cid = $category3;
			} else if ($category2) {
				$cid = $category2;
			} else if ($category1) {
				$cid = $category1;
			}
			if ($cid > 0) {
				$category = $this->category [$cid]; // 得到分类信息
			} else {
				$category = $this->category [$id]; // 得到分类信息
			}
			if ($_FILES ["catimage"] ['name'] != '') {
				$uid = $id;
				
				$avatardir = "/data/category/";
				$extname = extname ( $_FILES ["catimage"] ["name"] );
				if (! isimage ( $extname ))
					$this->message ( "图片扩展名不正确!", 'admin_category/editimg' );
				$upload_tmp_file = FCPATH . '/data/tmp/cat_' . $uid . '.' . $extname;
				$uid = abs ( $uid );
				$uid = sprintf ( "%09d", $uid );
				$dir1 = $avatardir . substr ( $uid, 0, 3 );
				$dir2 = $dir1 . '/' . substr ( $uid, 3, 2 );
				$dir3 = $dir2 . '/' . substr ( $uid, 5, 2 );
				(! is_dir ( FCPATH . $dir1 )) && forcemkdir ( FCPATH . $dir1 );
				(! is_dir ( FCPATH . $dir2 )) && forcemkdir ( FCPATH . $dir2 );
				(! is_dir ( FCPATH . $dir3 )) && forcemkdir ( FCPATH . $dir3 );
				$bigimg = $dir3 . "/big_" . $uid . '.' . $extname;
				$smallimg = $dir3 . "/small_" . $uid . '.' . $extname;
				unlink ( FCPATH . $dir3 . "/big_" . $uid . '.jpg' );
				unlink ( FCPATH . $dir3 . "/big_" . $uid . '.png' );
				unlink ( FCPATH . "/small_" . $uid . '.png' );
				unlink ( FCPATH . "/small_" . $uid . '.jpg' );
				if (move_uploaded_file ( $_FILES ["catimage"] ["tmp_name"], $upload_tmp_file )) {
					
					$avatar_dir = glob ( FCPATH . $dir3 . "/small_{$uid}.*" );
					
					foreach ( $avatar_dir as $imgfile ) {
						
						if (strtolower ( $extname ) != extname ( $imgfile ))
							unlink ( $imgfile );
					}
					
					image_resize ( $upload_tmp_file, FCPATH . $bigimg, 195, 195, 1 );
					
					image_resize ( $upload_tmp_file, FCPATH . $smallimg, 32, 32, 1 );
				}
			}
			$data=array(
					'name'=>$name,
					'dir'=>$categorydir,
					'alias'=>$aliasname,
					'miaosu'=>$edit_miaosu,
					'template'=>$s_tmplist,
					'articletemplate'=>$s_articletmplist,
			);
			$this->db->where(array('id'=>$id))->update('category',$data);
			//$this->category_model->update_by_id ( $id, $name, $categorydir, $category ['pid'], $aliasname, $edit_miaosu, $s_tmplist );
			cleardir ( FCPATH . '/data/cache' ); // 清除缓存文件
			$pid = $category ['pid'];
			if ($pid != 0) {
				$this->input->post ( 'cid' ) ? $this->myview ( $this->input->post ( 'cid' ) ) : $this->message ( "操作成功", "admin_category/myview/$pid" );
			} else {
				$this->input->post ( 'cid' ) ? $this->myview ( $this->input->post ( 'cid' ) ) : $this->message ( "操作成功", "admin_category" );
			}
		} else {
			$category = $this->category_model->get ( $id );
			$item = $category;
			$selectedarray = array ();
			for($grade = $category ['grade']; $grade > 1; $grade --) {
				$selectedarray [] = $item ['pid'];
				$item = $this->category [$item ['pid']];
			}
			if (isset ( $selectedarray ) && count ( $selectedarray ) > 0) {
				switch (count ( $selectedarray )) {
					case 1 :
						list ( $category1 ) = array_reverse ( $selectedarray );
						break;
					case 2 :
						list ( $category1, $category2 ) = array_reverse ( $selectedarray );
						break;
					case 3 :
						list ( $category1, $category2, $category3 ) = array_reverse ( $selectedarray );
						break;
				}
			}
			
			$categoryjs = $this->category_model->get_js ();
			$file_dir = APPPATH . "views/" . $this->setting ['tpl_dir'];
			$files = scandir ( $file_dir );
			$catlistfiles = array ();
			$articlelistfiles = array ();
			foreach ( $files as $file ) {
				if (strstr ( $file, 'catlist' )) {
					array_push ( $catlistfiles, $file );
				}
				if (strstr ( $file, 'topicone' )) {
					array_push ( $articlelistfiles, $file );
				}
			}
		
			include template ( 'editcategory', 'admin' );
		}
	}
	
	// 后台分类管理查看一个分类
	function myview($cid = 0, $msg = '') {
		$cid = $cid ? $cid : intval ( $this->uri->segment ( 3 ) );
		$navlist = $this->category_model->get_navigation ( $cid ); // 获取导航
		if (isset ( $this->category [$cid] )) {
			$category = $this->category [$cid];
		} else {
			$category = null;
		}
		
		$categorylist = $this->category_model->list_by_cid ( $cid, $category ['pid'] ); // 获取子分类
		$pid = $cid;
		$msg && $message = $msg;
		include template ( 'categorylist', 'admin' );
	}
	
	// 删除分类
	function remove() {
		if (null !== $this->input->post ( 'cid' )) {
			$cids = implode ( ",", $this->input->post ( 'cid' ) );
			$pid = intval ( $this->input->post ( 'hiddencid' ) );
			$this->category_model->remove ( $cids );
			$this->message ( '分类删除成功!' );
		}
	}
	
	/* 后台分类排序 */
	function reorder() {
		$orders = explode ( ",", $this->input->post ( 'order' ) );
		foreach ( $orders as $order => $cid ) {
			$this->category_model->order_category ( intval ( $cid ), $order );
		}
		$this->cache->remove ( 'category' );
	}
	// 修改封面图
	function editimg() {
		if (isset ( $_FILES ["catimage"] )) {
			$uid = intval ( $this->input->post ( 'catid' ) );
			
			$avatardir = "/data/category/";
			$extname = extname ( $_FILES ["catimage"] ["name"] );
			if (! isimage ( $extname ))
				$this->message ( "图片扩展名不正确!", 'admin_category/editimg' );
			$upload_tmp_file = FCPATH . '/data/tmp/cat_' . $uid . '.' . $extname;
			$uid = abs ( $uid );
			$uid = sprintf ( "%09d", $uid );
			$dir1 = $avatardir . substr ( $uid, 0, 3 );
			$dir2 = $dir1 . '/' . substr ( $uid, 3, 2 );
			$dir3 = $dir2 . '/' . substr ( $uid, 5, 2 );
			(! is_dir ( FCPATH . $dir1 )) && forcemkdir ( FCPATH . $dir1 );
			(! is_dir ( FCPATH . $dir2 )) && forcemkdir ( FCPATH . $dir2 );
			(! is_dir ( FCPATH . $dir3 )) && forcemkdir ( FCPATH . $dir3 );
			$bigimg = $dir3 . "/big_" . $uid . '.' . $extname;
			$smallimg = $dir3 . "/small_" . $uid . '.' . $extname;
			
			if (move_uploaded_file ( $_FILES ["catimage"] ["tmp_name"], $upload_tmp_file )) {
				
				$avatar_dir = glob ( FCPATH . $dir3 . "/small_{$uid}.*" );
				
				foreach ( $avatar_dir as $imgfile ) {
					
					if (strtolower ( $extname ) != extname ( $imgfile ))
						unlink ( $imgfile );
				}
				
				image_resize ( $upload_tmp_file, FCPATH . $bigimg, 195, 195, 1 );
				
				image_resize ( $upload_tmp_file, FCPATH . $smallimg, 32, 32, 1 );
			}
		}
		header ( "Location:" . SITE_URL . 'index.php?admin_category.html' );
	}
}

?>