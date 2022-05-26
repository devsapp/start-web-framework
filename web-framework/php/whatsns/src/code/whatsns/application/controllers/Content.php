<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Content extends CI_Controller {
	var $whitelist;
	function __construct() {
		$this->whitelist = "index";
		parent::__construct ();
		$this->load->model ( 'question_model' );
	}
	function index() {
		/* SEO */
		$this->setting ['seo_index_title'] && $seo_title = str_replace ( "{wzmc}", $this->setting ['site_name'], $this->setting ['seo_index_title'] );
		$this->setting ['seo_index_description'] && $seo_description = str_replace ( "{wzmc}", $this->setting ['site_name'], $this->setting ['seo_index_description'] );
		$this->setting ['seo_index_keywords'] && $seo_keywords = str_replace ( "{wzmc}", $this->setting ['site_name'], $this->setting ['seo_index_keywords'] );
		$navtitle = $this->setting ['site_alias'];
		@$page = 1;
		
		@$page = max ( 1, intval ( $this->uri->rsegments [4] ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
	
		$_valname = urldecode ( $this->uri->rsegments [3] );
		switch ($_valname) {
			case 'xuanshang' :
				$paixu = 2; //悬赏
				break;
			case 'tuijian' :
				$paixu = 6; //后台问题管理设置的手动推荐问题
				break;
			case 'solve' :
				$paixu = 4; //已解决
				break;
			case 'nosolve' :
				$paixu = 5; //未解决
				break;
		
			default :
				$paixu = 0;
				break;
		}
		if($_valname!='new'){
		
			$rownum = $this->question_model->rownum_by_cfield_cvalue_status ( '', 'all', 'all', $paixu ); // 获取总的记录数
			$questionlist = $this->question_model->list_by_cfield_cvalue_status ( '', 'all', 'all', $startindex, $pagesize, $paixu ); // 问题列表数据
			
			if($_valname=='xuanshang'){
				if(!$rownum){
					$rownum = $this->question_model->rownum_by_cfield_cvalue_status ( '', 'all', 'all', 1 ); // 获取总的记录数
					$questionlist = $this->question_model->list_by_cfield_cvalue_status ( '', 'all', 'all', $startindex, $pagesize, 1 ); // 问题列表数据
					
				}
			}
			$departstr = page ( $rownum, $pagesize, $page, "content/index/$_valname" ); // 得到分页字符串
			
		}else if($_valname=='new'){
			$this->load->model ( 'doing_model' );
			$rownum=$this->doing_model->list_by_type_andquestionorartilce_cache_num();
			$departstr = page($rownum, $this->setting['list_default'], $page, "content/index/$_valname");
			$doinglist = $this->doing_model->list_by_type_andquestionorartilce_cache ( $startindex, $this->setting ['list_default'] );
			
		}

		include template ( 'index' );
	}
}