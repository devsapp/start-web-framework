<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Plugin_attention extends CI_Controller {

	var $whitelist;

	function __construct() {
		$this->whitelist = "attentionset,attentionhuati,attentionquestion";
		parent::__construct ();
		$this->load->model ( "favorite_model" );
		$this->load->model ( "user_model" );
		$this->load->model ( "topic_model" );
		$this->load->model ( "category_model" );
		$this->load->model ( "question_model" );
	}
	//关注文章
	function attentionset() {
		//获取最新的20篇文章
		$topiclist = $this->topic_model->get_list ( 2, 0, 5 );

		//随机抽取马甲用户100个
		$nummajia = 500;
		$mixnummajia = 60;
		$caijiuserlist = $this->user_model->get_caiji_list ( 1, $nummajia );
		foreach ( $topiclist as $key => $val ) {
			$tid = $val ['id'];
			$curnum = mt_rand ( $mixnummajia, $nummajia );
			$i = 0;
			foreach ( $caijiuserlist as $key1 => $val1 ) {
				if ($i < $curnum) {
					$views = $val ['views'] + mt_rand ( 30, 400 );
					$this->topic_model->updatetopicviews ( $tid, $views );
					if (! $this->favorite_model->plugin_get_by_tid ( $val1 ['uid'], $tid )) {
						echo $val1 ['username'] . "关注文章《" . $val ['title'] . "》---成功<br>";
						$this->favorite_model->plugin_addtopiclikes ( $val1 ['uid'], $tid );
					} else {
						echo $val1 ['username'] . "已关注过文章《" . $val ['title'] . "》<br>";
					}
				} else {
					break;
				}
				$i ++;
			}

		}
		exit ( "ok chengg" );

	}
	//关注话题
	function attentionhuati() {

		$catlist = $this->category_model->listtopic ( 'hot', 0, 100 );
		//随机抽取马甲用户100个
		$nummajia = 500;
		$mixnummajia = 60;
		$caijiuserlist = $this->user_model->get_caiji_list ( 0, $nummajia );

		foreach ( $catlist as $key => $val ) {
			$cid = $val ['id'];
			$curnum = mt_rand ( $mixnummajia, $nummajia );
			$i = 0;
			foreach ( $caijiuserlist as $key1 => $val1 ) {
				if ($i < $curnum) {
					$is_followed = $this->category_model->is_followed ( $cid, $val1 ['uid'] );
					if ($is_followed) {
						$this->category_model->unfollow ( $cid, $val1 ['uid'] );
						$this->load->model ( "doing_model" );
						$this->doing_model->deletedoing ( $val1 ['uid'], 10, $cid );
					} else {
						$this->load->model ( "doing_model" );
						$category = $this->category [$cid]; //得到分类信息
						$this->doing_model->add ( $val1 ['uid'], $val1 ['username'], 10, $cid, $category ['name'] );
						$this->category_model->follow ( $cid, $val1 ['uid'] );

					}
				}
				$i ++;
			}

		}

		exit ( 'ok' );
	}
	//关注问题
	function attentionquestion() {
		//获取最新的20篇文章
		$questionlist = $this->question_model->list_by_cfield_cvalue_status ( '', 'all', 'all', 0, 100, 0 ); //问题列表数据


		//随机抽取马甲用户100个
		$nummajia = 500;
		$mixnummajia = 60;
		$caijiuserlist = $this->user_model->get_caiji_list ( 1, $nummajia );
		foreach ( $questionlist as $key => $val ) {
			$qid = $val ['id'];
			$curnum = mt_rand ( $mixnummajia, $nummajia );
			$i = 0;
			foreach ( $caijiuserlist as $key1 => $val1 ) {
				if ($i < $curnum) {
					$views = $val ['views'] + mt_rand ( 100, 400 );
					$this->question_model->pluginadd_views ( $qid, $views );
					$is_followed = $this->question_model->is_followed ( $qid, $val1 ['uid'] );
					if ($is_followed) {
						$this->user_model->unfollow ( $qid, $val1['uid'] );


					} else {
						$this->user_model->follow ( $qid, $val1 ['uid'], $val1 ['username'] );




					}
				} else {
					break;
				}
				$i ++;
			}

		}
		exit ( "ok chengg" );
	}
}