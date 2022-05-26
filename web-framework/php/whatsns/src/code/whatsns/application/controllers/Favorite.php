<?php
/**
 
 * 收藏控制器
 
 * @date: 2018年7月5日 下午6:31:24
 
 * @author: 61703
 
 */
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Favorite extends CI_Controller {
	var $whitelist;
	function __construct() {
		$this->whitelist = "index,topicadd,deletetopiclikes,delfavoratequestion,delfavoratearticle";
		parent::__construct ();
		$this->load->model ( "favorite_model" );
	}
	function index() {
		if ($this->user ['uid'] == 0) {
			$this->message ( "游客禁止访问", "index" );
		}
		$navtitle = '我的收藏';
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize; // 每页面显示$pagesize条
		$favoritelist = $this->favorite_model->get_list ( $startindex, $pagesize );
		$total = $this->favorite_model->rownum_by_uid ();
		$departstr = page ( $total, $pagesize, $page, "favorite/default" ); // 得到分页字符串
		include template ( 'favorite' );
	}
	function delete() {
		if ($this->user ['uid'] == 0) {
			$this->message ( "游客禁止访问", "index" );
		}
		if (null !== $this->input->post ( 'submit' )) {
			$ids = $this->input->post ( 'id' );
			
			$this->favorite_model->remove ( $ids, $this->user ['uid'] );
			$this->message ( "收藏删除成功！", 'favorite/default' );
		}
	}
	function deletetopiclikes() {
		if ($this->user ['uid'] == 0) {
			$this->message ( "游客禁止访问", "index" );
		}
		if (null !== $this->input->post ( 'submit' )) {
			$ids = $this->input->post ( 'id' );
			
			$this->favorite_model->remove_topiclikes ( $ids, $this->user ['uid'] );
			$this->message ( "收藏删除成功！", 'favorite/topic' );
		}
	}
	function add() {
		$qid = intval ( $this->uri->segment ( 3 ) );
		$cid = intval ( $this->uri->segment ( 4 ) );
		$viewurl = urlmap ( 'question/view/' . $qid, 2 );
		$message = "该问题已经收藏，不能重复收藏！";
		$this->load ( "favorite" );
		if (! $this->favorite_model->get_by_qid ( $qid )) {
			$this->favorite_model->add ( $qid );
			$message = '问题收藏成功!';
		}
		$this->message ( $message, $viewurl );
	}
	function delfavoratequestion() {
		if ($this->user ['uid'] == 0) {
			$this->message ( "游客禁止访问", "index" );
		}
		$this->load->model ( "question_model" );
		$qid = intval ( $this->uri->segment ( 3 ) );
		$this->question_model->removequestionattention ( $qid, $this->user ['uid'] );
		$this->message ( "收藏删除成功！", 'user/attention/question' );
	}
	function delfavoratearticle() {
		if ($this->user ['uid'] == 0) {
			$this->message ( "游客禁止访问", "index" );
		}
		$this->load->model ( "favorite_model" );
		$tid = intval ( $this->uri->segment ( 3 ) );
		$this->favorite_model->remove_topiclikes ( $tid, $this->user ['uid'] );
		$this->message ( "收藏删除成功！" );
	}
	function topicadd() {
		if ($this->user ['uid'] == 0) {
			$this->message ( "先登录在收藏", "user/login" );
		}
		
		$tid = intval ( $this->uri->segment ( 3 ) );
		$cid = intval ( $this->uri->segment ( 4 ) );
		$viewurl = urlmap ( 'topic/getone/' . $tid, 2 );
		$message = "该文章已经收藏，不能重复收藏！";
		
		if (! $this->favorite_model->get_by_tid ( $tid )) {
			$this->favorite_model->addtopiclikes ( $tid );
			$this->load->model ( "doing_model" );
			$this->doing_model->add ( $this->user ['uid'], $this->user ['username'], 13, $tid, "收藏了文章" );
			$message = '文章收藏成功!';
			$this->load->model ( "topic_model" );
			$topicone = $this->topic_model->get ( $tid );
			$authorid=$topicone['authorid'];//获取作者uid
			$touser=$this->user_model->get_by_uid($authorid);
			//如果设置有人收藏我问题私信我
			if($touser['notify']['like_object']==1){
				$msgfrom = $this->setting ['site_name'] . '管理员';
				$username = addslashes ( $this->user ['username'] );
				$this->load->model ( "message_model" );
				$viewurl1 = url ( 'topic/getone/'.$tid);
				$this->message_model->add ( $msgfrom, 0, $topicone['authorid'], $username . "刚刚收藏了您的文章", '<a target="_blank" href="' . url ( 'user/space/' . $this->user ['uid']) . '">' . $username . '</a> 刚刚收藏了您的文章' . $topicone['title'] . '"<br /> <a href="' . $viewurl1 . '">点击查看</a>', 'attentionarticle' );
				
			}
		}
		$this->message ( $message,$viewurl );
	}
}

?>