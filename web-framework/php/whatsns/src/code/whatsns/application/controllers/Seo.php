<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Seo extends CI_Controller {
	var $whitelist;
	function __construct() {
		$this->whitelist = "index";
		parent::__construct ();
		$this->load->model ( 'seo_model' );
		$this->load->model ( 'category_model' );
	}
	function index() {
		if ($this->uri->rsegments [3] && intval ( $this->uri->rsegments [3] ) == 0) {
			
			$catdir = addslashes ( strip_tags ( $this->uri->rsegments [3] ) ); // 获取目录
			if (! empty ( $catdir )) {
				$_cat = $this->db->get_where ( 'category', array (
						'dir' => $catdir 
				) )->row_array ();
			}
			
			if ($_cat) {
				$catid = $_cat ['id'];
			} else {
				$catid = 'all';
			}
		} else {
			$catid = $this->uri->rsegments [3] ? intval ( $this->uri->rsegments [3] ) : 'all';
		}
		
		$paixu = strip_tags ( addslashes ( $this->uri->rsegments [4] ) );
		if (empty ( $paixu )) {
			$paixu = "new";
		}
		
		@$page = max ( 1, intval ( $this->uri->rsegments [5] ) );
		$cids = array ();
		$pid = 0;
		if ($catid == 'all') {
			$_catid = 0;
		} else {
			$_catid = $catid;
		}
		if ($_catid) {
			
			$catmodel = $this->category_model->get ( $_catid );
			$navtitle = $catmodel ['name'];
			
			// 如果这是顶级分类
			if ($catmodel ['pid'] == 0) {
				
				// 获取当前分类下的子分类--二级分类
				$catlist = $this->category_model->list_by_pid ( $_catid );
				
				// 把顶级分类id写入数组
				array_push ( $cids, $_catid );
				// 循环获取顶级分类下的子分类
				foreach ( $catlist as $key => $val ) {
					
					// 子分类写入数组
					array_push ( $cids, $val ['id'] );
					// 获取子分类下的三级分类
					$catlist1 = $this->category_model->list_by_pid ( $val ['id'] );
					foreach ( $catlist1 as $key1 => $val1 ) {
						array_push ( $cids, $val1 ['id'] );
					}
				}
			} else {
				
				$pid = $catmodel ['pid'];
				// 如果不是顶级分类，先将分类id写入数组
				array_push ( $cids, $_catid );
				
				// 获取该分类下的子分类
				$catlist = $this->category_model->list_by_pid ( $_catid );
				
				if ($catlist) {
					
					// 遍历子分类写入数组
					foreach ( $catlist as $key => $val ) {
						array_push ( $cids, $val ['id'] );
					}
				}
				
				if ($catmodel ['grade'] == 3) {
					
					$catmodel = $this->category_model->get ( $catmodel ['pid'] );
				}
			}
			$cid = implode ( ',', $cids );
		}
		
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		
		$alltopiclist = $this->seo_model->get_bycatid ( $cid, $paixu, $startindex, $pagesize );
		$topiclist = $alltopiclist ['list'];
		$rownum = $alltopiclist ['allnum'];
		$departstr = page ( $rownum, $pagesize, $page, "seo/index/$catid/$paixu" );
		$departstr = str_replace ( '.html', '', $departstr );
		$paixuname='';
		switch ($paixu){
			case 'new' :
				$paixuname="最新";
				break;
			case 'weeklist' :
				$paixuname="热门";
				break;
			case 'hotlist' :
				$paixuname="精选";
				break;
			case 'money' :
				$paixuname="付费阅读";
				break;
			case 'credit' :
				$paixuname="财富阅读";
				break;
			default :
				$paixuname="最新";
				break;
		}
		if ($catid != 'all') {
			
			// 设置网站TDK
			/* SEO */
			if ($catmodel ['alias']) {
				$navtitle = $catmodel ['alias'];
			}
			$seo_keywords = $catmodel ['name'];

			$seo_description = $this->setting ['site_name'] . '，提供' . $navtitle .'-'.$paixuname. '相关栏目信息，' . '第' . $page . "页。";
			
			/* SEO */
			if ($catmodel['miaosu']) {
				$seo_description = strip_tags ( $catmodel ['miaosu'] );
			}
		} else {
			
			$navtitle = "资讯专栏".$paixuname."列表";
			$this->setting ['seo_index_description'] && $seo_description = str_replace ( "{wzmc}", $this->setting ['site_name'], $this->setting ['seo_index_description'] );
			$this->setting ['seo_index_keywords'] && $seo_keywords = str_replace ( "{wzmc}", $this->setting ['site_name'], $this->setting ['seo_index_keywords'] );
		}
		include template ( 'seoarticlelist' );
	}
	function pushindex() {
		$this->load->model ( "topdata_model" );
		$id = intval ( $this->uri->segment ( 3 ) );
		$type = htmlspecialchars ( $this->uri->segment ( 4 ) );
		$this->topdata_model->add ( $id, $type );
		cleardir ( FCPATH . 'data/cache' ); // 清除缓存文件
		$this->message ( "首页顶置成功!" );
	}
	function cancelindex() {
		$this->load->model ( "topdata_model" );
		$id = intval ( $this->uri->segment ( 3 ) );
		$type = htmlspecialchars ( $this->uri->segment ( 4 ) );
		$this->topdata_model->remove ( $id, $type );
		cleardir ( FCPATH . 'data/cache' ); // 清除缓存文件
		$this->message ( "取消首页顶置成功!" );
	}
	function cancelhot() {
		$id = intval ( $this->uri->segment ( 3 ) );
		$this->topic_model->updatetopichot ( $id, '0' );
		$this->message ( "取消顶置成功!", urlmap ( 'seo/index/all/hotlist' ) );
	}
	function pushhot() {
		$id = intval ( $this->uri->segment ( 3 ) );
		$this->topic_model->updatetopichot ( $id, '1' );
		$this->message ( "推荐到首页成功!", urlmap ( 'seo/index/all/hotlist' ) );
	}
}