<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Expert extends CI_Controller {
    var $whitelist;
	function __construct() {
		$this->whitelist = "index";
		parent::__construct (  );
		$this->load->model ( 'category_model' );
		$this->load->model ( "expert_model" );
	}

	/* 添加举报 */

	function index() {

		$navtitle = "问题专家";
		$seo_description = $this->setting['site_name']."汇聚知名专家，在线帮您一对一解决问题。";
		$seo_keywords = "专家咨询,认证专家,专家解答";
		$cid = intval ( $this->uri->segment ( 3 ) ) ? intval($this->uri->segment ( 3 )) : 'all'; //分类id
		$status = null!== $this->uri->segment ( 4 ) ? $this->uri->segment ( 4 ) : 'all'; //排序


		if ($cid != 'all') {
			$category = $this->category [$cid]; //得到分类信息
			$navtitle = $category ['name'] . "专家列表";
			$cfield = 'cid' . $category ['grade'];
		} else {
			$category ['name'] = '';
			$category ['id'] = 'all';
			$cfield = '';
			$category ['pid'] = 0;
		}
		if ($cid != 'all') {
			$category = $this->category_model->get ( $cid );
		}

		$sublist = $this->category_model->list_by_cid_pid ( $cid, $category ['pid'] ); //获取子分类


		$page = max ( 1, intval ( $this->uri->segment ( 5 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$orderwhere = '';
		switch ($status) {
			case 'all' : //全部
				$orderwhere = '';
				break;
			case '1' : //付费
				$orderwhere = ' and mypay>0 ';
				break;
			case '2' : //免费
				$orderwhere = " and mypay=0 ";
				break;
				default:
				$orderwhere = '';
				break;
		}

		$rownum = $cid == 'all' ? returnarraynum ( $this->db->query ( getwheresql ( 'user', " expert=1 " . $orderwhere , $this->db->dbprefix ) )->row_array () ) : returnarraynum ( $this->db->query ( getwheresql ( 'user', " expert=1 " . $orderwhere . "and uid IN (SELECT uid FROM " . $this->db->dbprefix . "user_category WHERE cid=$cid)" , $this->db->dbprefix ) )->row_array () );
		$expertlist = $this->expert_model->get_list ( 1, $startindex, $pagesize, $cid, $status );
		$departstr = page ( $rownum, $pagesize, $page, "expert/default/$cid/$status" );
		//$questionlist = $this->expert_model->get_solves ( 0, 15 );

		include template ( 'expert' );
	}


}

?>