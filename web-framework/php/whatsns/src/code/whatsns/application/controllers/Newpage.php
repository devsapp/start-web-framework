<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Newpage extends CI_Controller {

	var $whitelist;
	function __construct() {
		$this->whitelist = "";
		parent::__construct ();
		$this->load->model ( 'question_model' );
	}
	function index() {
$url=url("ask/index");
header("Location: $url");
exit();
		$navtitle = "站内问题库列表_";
		$seo_description = $this->setting ['site_name'] . '最近更新相关内容。';
		$seo_keywords = '站内问题库列表';
		//回答分页
		@$page = 1;

		@$page = max ( 1, intval ( $this->uri->rsegments [4]  ) );
		$pagesize = 15;
		$startindex = ($page - 1) * $pagesize;
		$paixu = intval ( $this->uri->rsegments [3]  ); //0 全部，1，积分悬赏，2 现金悬赏，3 语音悬赏，4 解决问题，5为解决


		$rownum = $this->question_model->rownum_by_cfield_cvalue_status ( '', 'all', 'all', $paixu ); //获取总的记录数
		$questionlist = $this->question_model->list_by_cfield_cvalue_status ( '', 'all', 'all', $startindex, $pagesize, $paixu ); //问题列表数据
		
		$departstr = page ( $rownum, $pagesize, $page, "new/default/$paixu" ); //得到分页字符串
// 		$this->load->model ( 'tag_model' );
// 		foreach ( $questionlist as $key => $val ) {

// 			$taglist = $this->tag_model->get_by_qid ( $val ['id'] );

// 			$questionlist [$key] ['tags'] = $taglist;

// 		}
		include template ( 'new' );
	}
	
	function catname(){
		$navtitle = "最近更新_";
		
		$paixu = intval ( $this->uri->rsegments [3]  ); //0 全部，1，积分悬赏，2 现金悬赏，3 语音悬赏，4 解决问题，5为解决
		$paixuname='';
		switch ($paixu){
			case 0:
				$paixuname="全部";
				break;
			case 1:
				$paixuname="积分悬赏";
				break;
			case 2:
				$paixuname="现金悬赏";
				break;
			case 3:
				$paixuname="语音回答";
				break;
			case 4:
				$paixuname="已解决";
				break;
			case 5:
				$paixuname="未解决";
				break;
		}
		//回答分页
		@$page = 1;
		$cid = intval ( $this->uri->rsegments[4] ) ? intval ( $this->uri->rsegments[4])  : 'all';
		$pid=0;
		if ($cid != 'all') {
			$category = $this->category [$cid]; //得到分类信息
			$navtitle = $category['name']."相关".$paixuname."问题";
			$cfield = 'cid' . $category ['grade'];
			$seo_keywords =$category['name'].",".$paixuname."问题";
			
			
			$pid=$category['pid'];
		} else {
			$cfield = '';
			$navtitle = '全部分类问题';
			$seo_keywords ="站内全部问题";
		}
		$seo_description =$navtitle;
		@$page = max ( 1, intval ( $this->uri->rsegments [5]  ) );
		$pagesize = 15;
		$startindex = ($page - 1) * $pagesize;
	
		
		$rownum = $this->question_model->rownum_by_cfield_cvalue_status ($cfield, $cid, 'all', $paixu ); //获取总的记录数
		$questionlist = $this->question_model->list_by_cfield_cvalue_status ( $cfield,$cid, 'all', $startindex, $pagesize, $paixu ); //问题列表数据
		
		$departstr = page ( $rownum, $pagesize, $page, "new/question/$paixu/$cid" ); //得到分页字符串
// 		$this->load->model ( 'tag_model' );
// 		foreach ( $questionlist as $key => $val ) {
			
// 			$taglist = $this->tag_model->get_by_qid ( $val ['id'] );
			
// 			$questionlist [$key] ['tags'] = $taglist;
			
// 		}
		include template ( 'new' );
	}

	function maketag() {
		$navtitle = "最近更新_";
		$seo_description = $this->setting ['site_name'] . '最近更新相关内容。';
		$seo_keywords = '最近更新';
		//回答分页
		@$page = 1;
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 50;
		$startindex = ($page - 1) * $pagesize;
		$rownum = $this->question_model->rownum_by_cfield_cvalue_status ( '', 'all', 1 ); //获取总的记录数


		$questionlist = $this->question_model->list_by_cfield_cvalue_status ( '', 'all', 1, $startindex, $pagesize ); //问题列表数据
		$departstr = page ( $rownum, $pagesize, $page, "new/maketag" ); //得到分页字符串
		//
// 		$this->load->model ( 'tag_model' );
// 		foreach ( $questionlist as $key => $val ) {

// 			$taglist = dz_segment ( htmlspecialchars ( $val ['title'] ) );
// 			$questionlist [$key] ['tags'] = $taglist;
// 			$taglist && $this->tag_model->multi_add ( array_unique ( $taglist ), $val ['id'] );

// 		}

		include template ( 'maketag' );
	}
}