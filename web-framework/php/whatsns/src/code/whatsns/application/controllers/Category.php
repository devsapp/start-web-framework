<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Category extends CI_Controller {
	var $whitelist;
	function __construct() {
		$this->whitelist = "attentto,search,viewtopic,clist";
		parent::__construct ();
		$this->load->model ( 'category_model' );
		$this->load->model ( 'question_model' );
		$this->load->model ( "topic_model" );
	}

	function viewtopic() {
		$navtitle = "热门专题";
		$status = null!== $this->uri->segment ( 3 )  ? $this->uri->segment ( 3 ) : 'hot';
		@$page = max ( 1, intval ( $this->uri->segment ( 4 ) ) );
		$pagesize = 21;
		$startindex = ($page - 1) * $pagesize;
		
		$where = "and grade=1 ";
		switch ($status) {
	
			case 'question' :
				$where=$where." and isuseask=1 ";
				break;
		}

		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'category', " 1=1 $where ", $this->db->dbprefix ) )->row_array () );
		//$userarticle = $this->topic_model->get_user_articles ( 0, 5 );
		$catlist = $this->category_model->listtopic ( $status, $startindex, $pagesize );
		$departstr = page ( $rownum, $pagesize, $page, "category/viewtopic/$status" );
		include template ( 'category_all' );
	}
function view() {
		$this->load->model ( "expert_model" );
		
		if(intval ( $this->uri->rsegments[3] )==0){
			$catdir=addslashes(strip_tags($this->uri->rsegments[3]));//获取目录
		
			$_cat=$this->db->get_where('category',array('dir'=>$catdir))->row_array();
			if($_cat){
				$cid=$_cat['id'];
			}else{
				show_404();
			}
		}else{
			$cid = intval ( $this->uri->rsegments[3] ) ? intval ( $this->uri->rsegments[3])  : 'all';
		}
		
		$status = null!==  $this->uri->rsegments[4]  ? $this->uri->rsegments[4]: 'all';
		@$page = max ( 1, intval ( $this->uri->rsegments[5]) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize; //每页面显示$pagesize条
		if ($cid != 'all') {
			$category = $this->category [$cid]; //得到分类信息
			$navtitle = $category ['name'];
			$cfield = 'cid' . $category ['grade'];
		} else {
			$category = $this->category;
			$navtitle = '全部分类';
			$cfield = '';
			$category ['pid'] = 0;
		}
	
		if ($category ['name'] == '') {
			header ( 'HTTP/1.1 404 Not Found' );
			header ( "status: 404 Not Found" );
			echo '<!DOCTYPE html><html><head><meta charset=utf-8 /><title>404-您访问的页面不存在</title>';
			echo "<style>body { background-color: #ECECEC; font-family: 'Open Sans', sans-serif;font-size: 14px; color: #3c3c3c;}";
			echo ".nullpage p:first-child {text-align: center; font-size: 150px;  font-weight: bold;  line-height: 100px; letter-spacing: 5px; color: #fff;}";
			echo ".nullpage p:not(:first-child) {text-align: center;color: #666;";
			echo "font-family: cursive;font-size: 20px;text-shadow: 0 1px 0 #fff;  letter-spacing: 1px;line-height: 2em;margin-top: -50px;}";
			echo ".nullpage p a{margin-left:10px;font-size:20px;}";
			echo '</style></head><body> <div class="nullpage"><p><span>4</span><span>0</span><span>4</span></p><p>抱歉，话题不存在！⊂((δ⊥δ))⊃<a href="/">返回主页</a></p></div></body></html>';
			exit ();
		}
		$statusword = "";
		switch ($status) {
			case '1' :
				$statusword = '待解决';
				break;
			case '2' :
				$statusword = '已解决';
				break;
			case '4' :
				$statusword = '高悬赏';
				break;
			case '6' :
				$statusword = '推荐';
				break;
			case 'all' :
				$statusword = '全部';
				break;
		}
		$is_followed = $this->category_model->is_followed ( $cid, $this->user ['uid'] );

		$rownum = $this->question_model->rownum_by_cfield_cvalue_status ( $cfield, $cid, $status ); //获取总的记录数
		$questionlist = $this->question_model->list_by_cfield_cvalue_status ( $cfield, $cid, $status, $startindex, $pagesize ); //问题列表数据
		$topiclist = $this->topic_model->get_bycatid ( $cid, 0, 8 );
		$followerlist = $this->category_model->get_followers ( $cid, 0, 8 ); //获取导航
		if($catdir){
		    	$departstr = page ( $rownum, $pagesize, $page, "category/view/$catdir/$status" ); //得到分页字符串
		}else{
		    	$departstr = page ( $rownum, $pagesize, $page, "category/view/$cid/$status" ); //得到分页字符串
		}
	
		$navlist = $this->category_model->get_navigation ( $cid ); //获取导航
		$sublist = $this->category_model->list_by_cid_pid ( $cid, $category ['pid'] ); //获取子分类
		$expertlist = $this->expert_model->get_by_cid ( $cid ); //分类专家

		$cids = array ();
		//如果这是顶级分类
		if ($category ['pid'] == 0) {
			
			//获取当前分类下的子分类--二级分类
			$catlist = $this->category_model->list_by_pid ( $cid );
			
			//把顶级分类id写入数组
			array_push ( $cids, $cid );
			//循环获取顶级分类下的子分类
			foreach ( $catlist as $key => $val ) {
				
				//子分类写入数组
				array_push ( $cids, $val ['id'] );
				//获取子分类下的三级分类
				$catlist1 = $this->category_model->list_by_pid ( $val ['id'] );
				foreach ( $catlist1 as $key1 => $val1 ) {
					array_push ( $cids, $val1 ['id'] );
				}
				
			}
			
		} else {
			
			//如果不是顶级分类，先将分类id写入数组
			array_push ( $cids, $cid );
			
			//获取该分类下的父亲级别的分类
			// $catlist=$this->category_model->list_by_pid($catmodel['pid']);
			
			
			//获取该分类下的子分类
			$catlist = $this->category_model->list_by_pid ( $cid );
			
			if ($catlist) {
				
				//遍历子分类写入数组
				foreach ( $catlist as $key => $val ) {
					array_push ( $cids, $val ['id'] );
				}
				
			}
			
		
			
			// var_dump($catmodel);exit();
		}
		
		$cidsp = implode ( ',', $cids );
		$trownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', " articleclassid in($cidsp) ", $this->db->dbprefix ) )->row_array () );
		/* SEO */
		if ($category ['alias']) {
			$navtitle = $category ['alias'];
		}
		$seo_keywords = $navtitle;
		$seo_description = $this->setting ['site_name'] . $navtitle . '频道，提供' . $navtitle . '相关问题及答案，' . $statusword . '问题，第' . $page . "页。";
		;
		/* SEO */
		if ($category ['miaosu']) {
			$seo_description =strip_tags( $category ['miaosu']);
		}
		if ($this->setting ['seo_category_title']) {
			$seo_title = str_replace ( "{wzmc}", $this->setting ['site_name'], $this->setting ['seo_category_title'] );
			$seo_title = str_replace ( "{flmc}", $navtitle, $seo_title );

			$seo_title = $seo_title . '_' . $statusword . '_第' . $page . "页";
		} else {
			$navtitle = $navtitle . '_' . $statusword . '_第' . $page . "页";
		}

		if ($this->setting ['seo_category_description']) {
			$seo_description = str_replace ( "{wzmc}", $this->setting ['site_name'], $this->setting ['seo_category_description'] );
			$seo_description = str_replace ( "{flmc}", $navtitle, $seo_description );
		}
		if ($this->setting ['seo_category_keywords']) {
			$seo_keywords = str_replace ( "{wzmc}", $this->setting ['site_name'], $this->setting ['seo_category_keywords'] );
			$seo_keywords = str_replace ( "{flmc}", $navtitle, $seo_keywords );
		}
		$category['bigimage'] = get_cid_dir ( $category['id'], 'big' );
	
		//相关分类标签
		$this->load->model ( "tag_model" );
		$relativetags = $this->tag_model->gettaglistbycid ( $cid );
		include template ( 'category' );
	}

function search() {

		$hidefooter = 'hidefooter';
		$type = "category";
		$this->load->helper ( 'security' );
		if ($_GET ['word']) {
			$word = xss_clean ( $_GET ['word'] );
		} else {
			$word = xss_clean ( $_GET [0] );
		}
		$word = str_replace ( array ("\\", "'", " ", "/", "&" ), "", $word );
		$word = strip_tags ( $word );
		$word = htmlspecialchars ( $word );
				if (isset ( $_SERVER ['HTTP_X_REWRITE_URL'] )&&$_GET ['word']==null) {

			if (function_exists ( "iconv" ) && $this->uri->rsegments [3] != null) {
				$word = iconv ( "GB2312", "UTF-8//IGNORE",$this->uri->rsegments [3]  );

			}
		}else if(isset($_SERVER['ORIG_PATH_INFO'])&&$_GET ['word']==null) {
			$word = iconv ( "GB2312", "UTF-8//IGNORE",$this->uri->rsegments [3]  );
		}
		$word = taddslashes ( $word, 1 );
		(! $word) && $this->message ( "搜索关键词不能为空!", 'BACK' );
		$navtitle = $word;
		@$page = max ( 1, intval ( $this->uri->rsegments [4] ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$seo_description = $word;
		$seo_keywords = $word;
		$word=addslashes($word);
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'category', " `name` like '%$word%' ", $this->db->dbprefix ) )->row_array () );

		$catlist = $this->category_model->list_by_name ( $word, $startindex, $pagesize );

		$departstr = page ( $rownum, $pagesize, $page, "category/search/$word" );
		include template ( 'serach_category' );
	}
	function clist() {
		$status = null!==  $this->uri->segment ( 3 )  ? $this->uri->segment ( 3 ) : 'all';
		$navtitle = $statustitle = $this->statusarray [$status];
		@$page = max ( 1, intval ( $this->uri->segment ( 4 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize; //每页面显示$pagesize条


		$rownum = $this->question_model->rownum_by_cfield_cvalue_status ( '', 0, $status ); //获取总的记录数
		$questionlist = $this->question_model->list_by_cfield_cvalue_status ( '', 0, $status, $startindex, $pagesize ); //问题列表数据
		$departstr = page ( $rownum, $pagesize, $page, "category/list/$status" ); //得到分页字符串
		$metakeywords = $navtitle;
		$metadescription = '问题列表' . $navtitle;
		include template ( 'list' );
	}

	function recommend() {
		$this->load ( 'topic' );
		$navtitle = '专题列表';
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', ' 1=1 ', $this->db->dbprefix ) )->row_array () );
		;
		$topiclist = $this->topic_model->get_list ( 2, $startindex, $pagesize );
		$departstr = page ( $rownum, $pagesize, $page, "category/recommend" );
		$metakeywords = $navtitle;
		$metadescription = '精彩推荐列表';
		include template ( 'recommendlist' );
	}
	function attentto() {
		$cid = intval ( $this->input->post ( 'cid' ) );
		if (! $cid) {
			exit ( 'error' );
		}
		if ($this->user ['uid'] == 0) {
			exit ( "-1" );
		}
		$is_followed = $this->category_model->is_followed ( $cid, $this->user ['uid'] );
		if ($is_followed) {
			$this->category_model->unfollow ( $cid, $this->user ['uid'] );
			$this->load->model ( "doing_model" );
			$this->doing_model->deletedoing ( $this->user ['uid'], 10, $cid );
		} else {
			$this->load->model ( "doing_model" );
			$category = $this->category [$cid]; //得到分类信息
			$this->doing_model->add ( $this->user ['uid'], $this->user ['username'], 10, $cid, $category ['name'] );
			$this->category_model->follow ( $cid, $this->user ['uid'] );

		}
		exit ( 'ok' );
	}

}

?>