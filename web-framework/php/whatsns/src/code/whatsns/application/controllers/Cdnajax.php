<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Cdnajax extends CI_Controller {
	var $whitelist;
	function __construct() {
		$this->whitelist = "getarticlecaozuo,getquestioncaozuo";
		parent::__construct ();
	}
	/**
	 *
	 * 获取文章详情页面操作状态
	 *
	 * @date: 2019年10月16日 下午2:53:05
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function getarticlecaozuo() {
		$this->load->model ( 'topic_model' );
		
		$type = intval ( $this->uri->segment ( 3 ) );
		$tid = intval ( $this->uri->segment ( 4 ) );
		if (! $tid) {
			echo ""; // 如果没文章返回空字符串
			exit ();
		}
		$user = $this->user;
		
		switch ($type) {
			case 1 : // topicone.php文章详情模板文件-文章详情页面--操作菜单
				$topicone = $this->topic_model->get ( $tid );
				include template ( 'cdn_articlecaozuo' );
				break;
			case 2 : // topicone.php文章详情模板文件-文章详情页面--可收藏和可评论和可举报按钮状态
				$topicone = $this->topic_model->get ( $tid );
				$this->load->model ( 'favorite_model' );
				$isfollowarticle = $this->favorite_model->get_by_tid ( $tid );
				include template ( 'cdn_articlefavorite' );
				break;
			case 3 : // topicone.php文章详情模板文件-文章详情页面--评论+评论框
				$this->load->model ( 'articlecomment_model' );
				$topicone = $this->topic_model->get ( $tid );
				if ($topicone) {
					// 评论分页
					@$page = 0;
					
					$pagesize = 5;
					$startindex = 0;
					if(isset($_SESSION['commentpageindex'])){
						$startindex = $_SESSION['commentpageindex'];
						unset($_SESSION['commentpageindex']);
						$page=$page+$startindex;
					}
					$commentlist = $this->articlecomment_model->list_by_tid ( $tid, 1, $startindex, $pagesize );
					
					$commentrownum = returnarraynum ( $this->db->query ( getwheresql ( "articlecomment", " tid=$tid AND state=1 ", $this->db->dbprefix ) )->row_array () );
					$departstr = page ( $commentrownum, $pagesize, $page, "topic/getone/$tid" );
					include template ( 'cdn_articleaddcomment' );
				}
				break;
			case 4 : // topicone.php文章详情模板文件-文章详情页面--发布文章作者信息
				$topicone = $this->topic_model->get ( $tid );
				$member = $this->user_model->get_by_uid ( $topicone ['authorid'], 2 );
				$is_followedauthor = $this->user_model->is_followed ( $member ['uid'], $this->user ['uid'] );
				
				include template ( 'cdn_articleuserinfo' );
				break;
			case 5 : // topicone.php文章详情模板文件-文章详情页面--文章详情顶部固定文章信息提示
				$this->load->model ( 'favorite_model' );
				$topicone = $this->topic_model->get ( $tid );
				$isfollowarticle = $this->favorite_model->get_by_tid ( $tid );
				include template ( 'cdn_articletop' );
				break;
			case 6 : // widescreen模板文件夹中得侧边作者列表栏 site_author.php文件
			         // 首页右侧推荐作者
				$this->load->model ( 'topic_model' );
				
				$userarticle = $this->topic_model->get_user_articles ( 0, 5 );
				include template ( 'cdn_hotauthor' );
				break;
			case 7 :
				include template ( 'cdn_index_userinfo' );
				break;
			default :
				echo "<span></span>";
				break;
		}
		exit ();
	}
	/**
	 *
	 * 问题相关得cdn异步调用操作
	 *
	 * @date: 2019年10月20日 下午6:45:09
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function getquestioncaozuo() {
		$this->load->model ( 'question_model' );
		
		$type = intval ( $this->uri->segment ( 3 ) );
		$qid = intval ( $this->uri->segment ( 4 ) );
		if (! $qid) {
			echo ""; // 如果没问题id返回空字符串
			exit ();
		}
		$user = $this->user;
		$setting = $this->setting;
		
		switch ($type) {
			case 1 :
				$is_followed = $this->question_model->is_followed ( $qid, $this->user ['uid'] );
				$question = $this->question_model->get ( $qid );
				include template ( 'cdn_question_fixtitle' );
				break;
			case 2:
				$question = $this->question_model->get ( $qid );
				include template ( 'cdn_question_caozuo' );
				break;
			case 3:
				$question = $this->question_model->get ( $qid );
				$is_followedauthor = $this->user_model->is_followed ( $question ['authorid'], $this->user ['uid'] );
				
				include template ( 'cdn_question_userinfo' );
				break;
			case 4:
				$iswxbrower = false;
				$useragent = $_SERVER ['HTTP_USER_AGENT'];
				if (strstr ( $useragent, 'MicroMessenger' )) {
					$iswxbrower = true;
				}
				$question = $this->question_model->get ( $qid );
				$cananswerthisquestion=true;//默认允许回答问题
				//如果是一对一咨询问题
				if($question['askuid']>0&&isset($this->setting['question_expert_answerlimit'])&&$this->setting['question_expert_answerlimit']==1){
					if($question['askuid']!=$this->user['uid']){
						$cananswerthisquestion=false;//如果当前不是邀请本人不允许回答
					}
				}
				if($question['status']==9||$question['status']==0){
					$cananswerthisquestion=false;//审核状态和关闭状态不允许回答
				}
				$is_followed = $this->question_model->is_followed ( $qid, $this->user ['uid'] );
				include template ( 'cdn_question_button' );
				break;
			case 5:
				$useragent = $_SERVER ['HTTP_USER_AGENT'];
				$wx = $this->fromcache ( 'cweixin' );
				
				if (strstr ( $useragent, 'MicroMessenger' ) && $wx ['appsecret'] != '' && $wx ['appsecret'] != null) {
					
					$appid = $wx ['appid'];
					$appsecret = $wx ['appsecret'];
					
					require FCPATH . '/lib/php/jssdk.php';
					$jssdk = new JSSDK ( $appid, $appsecret );
					$signPackage = $jssdk->GetSignPackage ();
				}
				
				$this->load->model ( 'answer_model' );
				
				$aid = intval ( $this->uri->segment ( 5) );
				$question = $this->question_model->get ( $qid );
				$answer = $this->answer_model->get ( $aid );
				include template ( 'cdn_question_answer' );
				break;
			case 6:
				$this->load->model ( 'answer_model' );
				
				$aid = intval ( $this->uri->segment ( 5) );
				$question = $this->question_model->get ( $qid );
				$bestanswer = $this->answer_model->get ( $aid );
				include template ( 'cdn_question_bestanswer' );
				break;
			case 7:
			
				$question = $this->question_model->get ( $qid );
				$cananswerthisquestion=true;//默认允许回答问题
				//如果是一对一咨询问题
				if($question['askuid']>0&&isset($this->setting['question_expert_answerlimit'])&&$this->setting['question_expert_answerlimit']==1){
					if($question['askuid']!=$this->user['uid']){
						$cananswerthisquestion=false;//如果当前不是邀请本人不允许回答
					}
				}
				include template ( 'cdn_question_invate' );
				break;
			default :
				echo "<span></span>";
				break;
		}
	}
}