<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Ask extends CI_Controller {
	var $whitelist;
	function __construct() {
		$this->whitelist = "index";
		parent::__construct ();
		$this->load->model ( 'question_model' );
	}
	function index() {
		
		// 回答分页
		@$page = 1;
	
		@$page = max ( 1, intval (  $this->uri->segment ( 4 ) ) );
		$pagesize = 15;
		$startindex = ($page - 1) * $pagesize;
		$paixuname = strip_tags ( addslashes ( $this->uri->segment ( 3 )) ); // 0 全部，1，积分悬赏，2 现金悬赏，3 语音悬赏，4 解决问题，5为解决
		                                                      // 根据分类目录拼音或者id获取分类，如果没有默认设置cid=all
		if (intval ( $this->uri->rsegments [3] ) == 0) {
			$catdir = addslashes ( strip_tags (  $this->uri->segment ( 2 ) ) ); // 获取目录
			if (! empty ( $catdir )) {
				$_cat = $this->db->get_where ( 'category', array (
						'dir' => $catdir 
				) )->row_array ();
			}
			
			if ($_cat) {
				$cid = $_cat ['id'];
			} else {
				$cid = 'all';
			}
		} else {
			$cid = intval ( $this->uri->rsegments [3] ) ? intval ( $this->uri->rsegments [3] ) : 'all';
		}
		
		switch ($paixuname) {
			case 'all' :
				$paixu = 'all';
				
				break;
			case 'caifu' :
				$paixu = 1;
				
				break;
			case 'xuanshang' :
				$paixu = 2;
				
				break;
			case 'voice' :
				$paixu = 3;
				
				break;
			case 'solve' :
				$paixu = 4;
				
				break;
			case 'nosolve' :
				$paixu = 5;
				
				break;
			default :
				$paixu = 'all';
				$paixuname='all';
				break;
		}
		if ($cid != 'all') {
			$category = $this->category [$cid]; // 得到分类信息
			$navtitle = $category ['name'];
			$cfield = 'cid' . $category ['grade'];
		} else {
			$category = $this->category;			
			$cfield = '';
			$category ['pid'] = 0;
		}
		$rownum = $this->question_model->rownum_by_cfield_cvalue_status ( $cfield, $cid, 'all', intval ( $paixu ) ); // 获取总的记录数
		$questionlist = $this->question_model->list_by_cfield_cvalue_status ( $cfield, $cid, 'all', $startindex, $pagesize, intval ( $paixu ) ); // 问题列表数据
	
		$departstr = page ( $rownum, $pagesize, $page, "ask/index/$cid/$paixuname" ); // 得到分页字符串
		if ($cid != 'all') {
		
			//设置网站TDK
			/* SEO */
			if ($category ['alias']) {
				$navtitle = $category ['alias'];
			}
			$seo_keywords = $category ['name'];
			$seo_description = $this->setting ['site_name']  . '，提供' . $navtitle . '相关问题及答案，' . '第' . $page . "页。";
			
			/* SEO */
			if ($category ['miaosu']) {
				$seo_description = strip_tags ( $category ['miaosu'] );
			}
		}else{
			
			$navtitle = "站内问题库列表";
			$this->setting ['seo_index_description'] && $seo_description = str_replace ( "{wzmc}", $this->setting ['site_name'], $this->setting ['seo_index_description'] );
			$this->setting ['seo_index_keywords'] && $seo_keywords = str_replace ( "{wzmc}", $this->setting ['site_name'], $this->setting ['seo_index_keywords'] );
			
		}
		include template ( 'askcategory' );
	}
}