<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Topic extends CI_Controller {
	var $whitelist;
	function __construct() {
		$this->whitelist = "articlelist,putyuyin,paylist,wappayarticle,deletearticlecomment,getuserarticles,getnewlist,getbycatidanduid,posttopicreward";
		parent::__construct ();
		$this->load->model ( 'topic_model' );
		$this->load->model ( 'topic_tag_model' );
		$this->load->model ( 'articlecomment_model' );
		$this->load->model ( 'category_model' );
		$this->load->model ( 'question_model' );
	}
	
	// 文章点赞
	function ajaxhassupport() {
		$answerid = intval ( $this->uri->segment ( 3 ) );
		$supports = $this->topic_model->get_support_by_sid_aid ( $this->user ['sid'], $answerid );
		$ret = $supports ? '1' : '-1';
		exit ( $ret );
	}
	function ajaxaddsupport() {
		$tid = intval ( $this->uri->segment ( 3 ) );
		$article = $this->topic_model->get ( $tid );
		$this->topic_model->add_support ( $this->user ['sid'], $tid, $article ['authorid'] );
		$answer = $this->topic_model->getcomment ( $tid );
		
		exit ( $answer ['supports'] );
	}
	// 添加文章评论
	function ajaxaddarticlecomment() {
		$tid = isset ( $_POST ['tid'] ) ? intval ( $_POST ['tid'] ) : 0;
		if ($tid == 0) {
			$message ['code'] = 201;
			$message ['msg'] = '文章不存在';
			echo json_encode ( $message );
			exit ();
		}
		$aid = isset ( $_POST ['aid'] ) ? intval ( $_POST ['aid'] ) : 0;
		if ($aid == 0) {
			$message ['code'] = 201;
			$message ['msg'] = '文章评论不存在';
			echo json_encode ( $message );
			exit ();
		}
		if ($this->user ['uid'] == 0) {
			$message ['code'] = 201;
			$message ['msg'] = '请先登录';
			echo json_encode ( $message );
			exit ();
		}
		if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1') {
			if ($this->user ['active'] != 1) {
				$message ['code'] = 201;
				$message ['msg'] = "必须激活邮箱才能评论!";
				echo json_encode ( $message );
				exit ();
			}
		}
		$touid = isset ( $_POST ['touid'] ) ? intval ( $_POST ['touid'] ) : 0;
		
		$content = $this->input->post ( 'content' ) != null ? strip_tags ( $this->input->post ( 'content' ) ) : '';
		if ($content == '') {
			$message ['code'] = 201;
			$message ['msg'] = '评论不能为空';
			echo json_encode ( $message );
			exit ();
		}
		if (strlen ( $content ) > 300) {
			$message ['code'] = 201;
			$message ['msg'] = '评论不能超过100字';
			echo json_encode ( $message );
			exit ();
		}
		// 获取当前的文章
		$article = $this->topic_model->get ( $tid );
		if (! $article) {
			$message ['code'] = 201;
			$message ['msg'] = '文章不存在';
			echo json_encode ( $message );
			exit ();
		}
		// 检查评论内容
		$mywords = checkwords ( $content );
		if ($mywords [0] == 2) {
			$message ['code'] = 201;
			$message ['msg'] = '评论包含敏感信息';
			echo json_encode ( $message );
			exit ();
		}
		if ($touid) {
			if ($touid == $this->user ['uid']) {
				$message ['code'] = 201;
				$message ['msg'] = '不能@自己';
				echo json_encode ( $message );
				exit ();
			}
			$this->load->model ( 'user_model' );
			$touser = $this->user_model->get_by_uid ( $touid );
			$userspaceurl = url ( 'user/space/' . $touser ['uid'] );
			$tousername = $touser ['username'];
			$content = "<a href='$userspaceurl' class='maleskine-author' target='_blank' >@$tousername</a>  " . $content;
		}
		$data ['tid'] = intval ( $tid );
		$data ['aid'] = intval ( $aid );
		$data ['authorid'] = $this->user ['uid'];
		$data ['author'] = $this->user ['username'];
		$data ['content'] = $content;
		$data ['time'] = time ();
		
		$id = $this->articlecomment_model->addarticlecomment ( $data );
		if ($id) {
			if ($touid) {
				// 如果有@别，发私信过去
				$this->load->model ( "message_model" );
				$subject = "您的文章评论有新回复";
				$title = $article ['title'];
				$aurl = url ( "topic/getone/" . $article ['id'] );
				$contentmsg = "您对文章[$title]的评论，对方回复：<br>$content" . "<a href='$aurl'>点击查看详情</a>";
				$this->message_model->add ( $this->user ['username'], $this->user ['uid'], $touser ['uid'], $subject, $contentmsg, 'questioncomment' );
			
				//发送邮件通知
				$quser=$this->user_model->get_by_uid($article['authorid']);
				//如果作者开启文章评论邮件通知，且评论不是作者本人
				if($quser['notify']['comment_reply']==1&&$quser['uid']!=$this->user ['uid']){
					$subject = "文章[".$title."]有新评论！[评论回复通知]";
					$sendmessage = $content. '<p>现在您可以点击<a swaped="true" target="_blank" href="' . $aurl . '">查看最新评论回复</a>。</p>';
					sendmail ( $quser, $subject, $sendmessage );
					
				}
			
			}
			$message ['code'] = 200;
			$message ['msg'] = '评论成功';
			echo json_encode ( $message );
			exit ();
		}
	}
	// 获取文章评论的回复
	function ajaxgetcommentlist() {
		$tid = isset ( $_POST ['tid'] ) ? intval ( $_POST ['tid'] ) : 0;
		if ($tid == 0) {
			$message ['code'] = 201;
			$message ['msg'] = '文章不存在';
			echo json_encode ( $message );
			exit ();
		}
		$aid = isset ( $_POST ['aid'] ) ? intval ( $_POST ['aid'] ) : 0;
		if ($aid == 0) {
			$message ['code'] = 201;
			$message ['msg'] = '文章评论不存在';
			echo json_encode ( $message );
			exit ();
		}
		$commentlist = $this->articlecomment_model->getarticlecommentlist ( $tid, $aid );
		$message ['code'] = 200;
		$message ['msg'] = json_encode ( $commentlist );
		echo json_encode ( $message );
		exit ();
	}
	// 删除文章评论回复
	function ajaxdelartcomment() {
		$id = isset ( $_POST ['id'] ) ? intval ( $_POST ['id'] ) : 0;
		if ($id == 0) {
			$message ['code'] = 201;
			$message ['msg'] = '文章评论不存在';
			echo json_encode ( $message );
			exit ();
		}
		// 获取当前评论
		$comment = $this->articlecomment_model->getoneartcomment ( $id );
		if (! $comment) {
			$message ['code'] = 201;
			$message ['msg'] = '文章评论回复不存在';
			echo json_encode ( $message );
			exit ();
		} else {
			if ($this->user ['grouptype'] != 1) {
				if ($comment ['authorid'] != $this->user ['uid']) {
					$message ['code'] = 201;
					$message ['msg'] = '只有作者本人才能删除评论';
					echo json_encode ( $message );
					exit ();
				}
			}
			
			$this->articlecomment_model->delartcomment ( $id, $comment ['aid'] );
			$message ['code'] = 200;
			$message ['msg'] = '删除成功';
			echo json_encode ( $message );
			exit ();
		}
	}
	// 删除评论
	function deletearticlecomment() {
		if ($this->user ['uid'] == 0) {
			$this->message ( "你还没登录!", 'user/login' );
		}
		$tid = intval ( $this->uri->segment ( 4 ) );
		$id = intval ( $this->uri->segment ( 3 ) );
		$viewurl = urlmap ( 'topic/getone/' . $tid, 2 );
		$article = $this->topic_model->getcomment ( $id );
		if ($this->user ['grouptype'] != 1) {
			if ($article ['authorid'] != $this->user ['uid']) {
				$this->message ( "非法操作!", $viewurl );
			}
		}
		$this->topic_model->remove_by_tid ( $id, $tid );
		$this->message ( "文章评论删除成功!", $viewurl );
	}
	function ajaxviewtopic() {
		$tid = intval ( $this->uri->segment ( 3 ) );
		
		$topic = $this->topic_model->get ( $tid );
		if ($topic ['price'] == 0)
			exit ( '-1' );
		
		include template ( "viewtopic" );
	}
	function posttopicreward() {
		$tid = intval ( $this->input->post ( 'tid' ) );
		$topic = $this->topic_model->get ( $tid );
		$readmode = $topic ['readmode'];
		// 用户没登录
		if ($this->user ['uid'] == 0)
			exit ( '-2' );
		
		// 此文章不需要付费
		if ($topic ['price'] == 0)
			exit ( '-1' );
		
		$cash_fee = $topic ['price'];
		if ($readmode == '2') {
			if ($this->user ['credit2'] < $topic ['price']) {
				// 用户积分不足
				exit ( '0' );
			}
		}
		if ($readmode == '3') {
			if (round ( $this->user ['jine'] / 100 ) < $topic ['price']) {
				// 用户账户余额不足
				exit ( '7' );
			}
		}
		
		if ($this->user ['uid'] == $topic ['authorid']) {
			// 偷看的是本人
			exit ( '-3' );
		}
		
		$readuid = $this->user ['uid'];
		$authorid = $topic ['authorid'];
		$one = $this->topic_model->getreaduser ( $readuid, $tid );
		if ($one != null) {
			// 已经付费过了
			exit ( '2' );
		}
		// addtopicviewhistory
		$id = $this->topic_model->addtopicviewhistory ( $this->user ['uid'], $this->user ['username'], $tid );
		if ($id > 0) {
			if ($readmode == '2') {
				// 阅读的人积分扣减
				$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET  `credit2`=credit2-$cash_fee WHERE `uid`=$readuid" );
				
				// 作者获得积分
				
				$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET  `credit2`=credit2+$cash_fee WHERE `uid`=$authorid" );
				
				$this->load->model ( "doing_model" );
				$this->doing_model->add ( $this->user ['uid'], $this->user ['username'], 15, $tid, $topic ['title'] );
			}
			if ($readmode == '3') {
				$paycash_fee = $cash_fee * 100;
				// 阅读的人金额扣减
				$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET  `jine`=jine-$paycash_fee WHERE `uid`=$readuid" );
				$useruid = $this->user ['uid'];
				$time = time ();
				$authorid = $topic ['authorid'];
				// 作者获得金额
				$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET  `jine`=jine+$paycash_fee WHERE `uid`=$authorid" );
				$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "paylog SET type='topayarticle',typeid=$tid,money=$cash_fee,openid='',fromuid=$authorid,touid=$useruid,`time`=$time" );
				$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "paylog SET type='payarticle',typeid=$tid,money=$cash_fee,openid='',fromuid=$useruid,touid=$authorid,`time`=$time" );
			}
			exit ( '1' );
		} else {
			exit ( '-4' );
		}
	}
	
	function search() {
		$hidefooter = 'hidefooter';
		
		$type = "topic";
		$this->load->helper ( 'security' );
		if ($_GET ['word']) {
			$word = xss_clean ( $_GET ['word'] );
		} else {
			$word = xss_clean ( $_GET [0] );
		}
		
		
		
		if (isset ( $_SERVER ['HTTP_X_REWRITE_URL'] ) && $_GET ['word'] == null) {
			
			if (function_exists ( "iconv" ) && $this->uri->rsegments [3] != null) {
				$word = iconv ( "GB2312", "UTF-8//IGNORE", $this->uri->rsegments [3] );
			}
		} else if (isset ( $_SERVER ['ORIG_PATH_INFO'] ) && $_GET ['word'] == null) {
			$word = iconv ( "GB2312", "UTF-8//IGNORE", $this->uri->rsegments [3] );
		}
		
		if ($word == null) {
			if ($this->uri->segment ( 3 ) != null) {
				$word = urldecode ( $this->uri->rsegments [3] );
			}
		}
		if ($word == null) {
			$word = trim ( $this->input->post ( 'word' ) ) ? trim ( $this->input->post ( 'word' ) ) : urldecode ( $_word );
		}
		(! $word) && $this->message ( "搜索关键词不能为空!", 'BACK' );
		
		$navtitle = $word;
		if($_GET['pageindex']){
			@$page = max ( 1, intval ($_GET['pageindex']) );
		}else{
			@$page = max ( 1, intval ( $this->uri->rsegments [4] ) );
		}
		
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$seo_description = $word;
		$seo_keywords = $word;
		$topiclist = null; // 定义空文章数组
		// $rownum = $this->topic_model->rownum_by_tag($word);
		
		// $topiclist = $this->topic_model->list_by_tag($word, $startindex, $pagesize);
		// if($topiclist==null){
		
		$topiclist = $this->topic_model->get_bylikename ( $word, $startindex, $pagesize );
		// }
		$rownum = $this->topic_model->rownum_by_title ( $word );
		foreach ( $topiclist as $key => $val ) {
			
			$taglist = $this->topic_tag_model->get_by_aid ( $val ['id'] );
			
			$topiclist [$key] ['tags'] = $taglist;
		}
		$pageurl = url ( 'topic/search' ) . "?word=$word";
		$departstr = cpage ( $rownum, $pagesize, $page, $pageurl );
		
		
		include template ( 'topictag' );
	}
	function cancelhot() {
		$id = intval ( $this->uri->segment ( 3 ) );
		$this->topic_model->updatetopichot ( $id, '0' );
		$this->message ( "取消顶置成功!", urlmap ( 'topic/hotlist' ) );
	}
	function pushhot() {
		$id = intval ( $this->uri->segment ( 3 ) );
		$this->topic_model->updatetopichot ( $id, '1' );
		$this->message ( "推荐到首页成功!", urlmap ( 'topic/hotlist' ) );
	}
	function ajaxpostsupportcomment() {
		$message = array ();
		$cmid = intval ( $this->input->post ( 'cmid' ) );
		$this->load->model ( "articlecomment_model" );
		$this->articlecomment_model->updatecmsupport ( $cmid );
		
		$message ['state'] = 1;
		
		echo json_encode ( $message );
		exit ();
	}
	function ajaxpostcomment() {
		$message = array ();
		if ($this->user ['uid'] <= 0) {
			$message ['state'] = - 1;
			$message ['msg'] = "登录后可发布评论";
			echo json_encode ( $message );
			exit ();
		}
		if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1') {
			if ($this->user ['active'] != 1) {
				$message ['code'] = 201;
				$message ['msg'] = "必须激活邮箱才能评论!";
				echo json_encode ( $message );
				exit ();
			}
		}
		$content = $this->input->post ( 'content' );
		$title = strip_tags ( $this->input->post ( 'title' ) );
		$tid = intval ( $this->input->post ( 'tid' ) );
		$this->load->model ( "articlecomment_model" );
		
		$onecorder = $this->articlecomment_model->checkhascomment ( $tid, $this->user ['uid'] );
		if ($onecorder != null) {
			$message ['state'] = 0;
			$message ['msg'] = "您已经评论过了!";
			echo json_encode ( $message );
			exit ();
		}
		// 检查评论内容
		$mywords = checkwords ( $content );
		if ($mywords [0] == 2) {
			$message ['code'] = 201;
			$message ['msg'] = '评论包含敏感信息';
			echo json_encode ( $message );
			exit ();
		}
		$status = 1;
		$supports = rand ( 1, 5 );
		$id = $this->articlecomment_model->add_seo ( $tid, $title, $content, $this->user ['uid'], $this->user ['username'], $status, $supports );
		if ($id > 0) {
			$message ['state'] = 1;
			$message ['msg'] = "评论成功!";
			
			$state = intval ( $this->setting ['publisharticlecommentcheck'] ) > 0 ? 0 : 1;
			if ($state == 1) {
				$topicone = $this->topic_model->get ( $tid );

				$message ['msg'] = "评论成功!";
				$this->load->model ( "doing_model" );
				
				$this->doing_model->add ( $this->user ['uid'], $this->user ['username'], 14, $tid, $content );
			
				//发送邮件通知
				$quser=$this->user_model->get_by_uid($topicone['authorid']);
				//如果作者开启文章评论邮件通知，且评论不是作者本人
				if($quser['notify']['comment']==1&&$quser['uid']!=$this->user ['uid']){
					$subject = "文章[".$title."]有新评论！";
					$sendmessage = $content. '<p>现在您可以点击<a swaped="true" target="_blank" href="' . $url . '">查看最新评论</a>。</p>';
					sendmail ( $quser, $subject, $sendmessage );
					
				}
		
				
			} else {
		
				$message ['msg'] = "评论成功,等待审核!";
			}
		} else {
			$message ['state'] = 0;
			$message ['msg'] = "评论失败!";
		}
		
		echo json_encode ( $message );
		exit ();
	}
	function paylist() {
		$navtitle = "付费阅读文章专栏";
		$typename="pay";
		@$page = max ( 1, intval ( $this->uri->segment ( 4 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$readmode=$this->uri->segment ( 3 )=='money' ? 3:2;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', ' readmode='.$readmode.' and state=1 ', $this->db->dbprefix ) )->row_array () );
	
		$topiclist = $this->topic_model->get_paylist ( $startindex, $pagesize,$readmode );
	
		$departstr = page ( $rownum, $pagesize, $page, "topic/paylist" );
		
		$sublist = $this->category_model->list_by_cid_pid_all ( 0, 0 ); // 获取子分类
		include template ( 'topic' );
	}
	function hotlist() {
		$navtitle = "最新文章推荐";
		$typename="top";
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', ' ispc=1 and state=1 ', $this->db->dbprefix ) )->row_array () );
		
		
		$topiclist = $this->topic_model->get_hotlist ( 1, $startindex, $pagesize, 12 );
		$departstr = page ( $rownum, $pagesize, $page, "topic/hotlist" );
		
		$sublist = $this->category_model->list_by_cid_pid_all ( 0, 0 ); // 获取子分类
		include template ( 'topic' );
	}
	function weeklist() {
		$navtitle = "热门文章";
		$typename="hot";
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$timeweekstart = time() - 7 * 24 * 3600;
		$timedaystart =  time()- 1 * 24 * 3600;
		$timemonthstart =  time() - 30 * 24 * 3600;
		$timeyearstart =  time() - 365 * 24 * 3600;
		$timeend =  time();
		$query = null;
		$rownum=0;
		// 先看一天内文章是否超过10条
		$dayrownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', " state=1 AND  `viewtime`>$timedaystart AND `viewtime`<$timeend ", $this->db->dbprefix ) )->row_array () );
		if ($dayrownum >= 10) {
			$rownum=$dayrownum;
		} else {
			
			// 看这一周是否超过10条
			$weekrownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', " state=1 AND  `viewtime`>$timeweekstart AND `viewtime`<$timeend ", $this->db->dbprefix ) )->row_array () );
			if ($weekrownum >= 10) {
				$rownum=$weekrownum;
			} else {
				// 看这一月是否超过10条
				$monthrownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', " state=1 AND  `viewtime`>$timemonthstart AND `viewtime`<$timeend ", $this->db->dbprefix ) )->row_array () );
				
				if ($monthrownum >= 10) {
					$rownum=$monthrownum;
				}else{
					// 看这一月是否超过10条
					$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', " state=1 AND  `viewtime`>$timeyearstart AND `viewtime`<$timeend ", $this->db->dbprefix ) )->row_array () );
					
					
				}
			}
		}
		
		$topiclist = $this->topic_model->get_weeklist ( $startindex, $pagesize );
		$departstr = page ( $rownum, $pagesize, $page, "topic/weeklist" );
		
		$sublist = $this->category_model->list_by_cid_pid_all ( 0, 0 ); // 获取子分类
	
		include template ( 'topic' );
	}
	// 获取最新文章
	function getnewlist() {
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 6;
		$startindex = ($page - 1) * $pagesize;
		$wzrownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', '1=1 and state=1 ', $this->db->dbprefix ) )->row_array () );
		$topiclist = $this->topic_model->get_list ( 2, $startindex, $pagesize );
		
		echo json_encode ( $topiclist );
		exit ();
	}
	function getbycatidanduid() {
		$pagesize = 6;
		$muid = intval ( $this->uri->segment ( 3 ) );
		
		@$page = max ( 1, intval ( $this->uri->segment ( 5 ) ) );
		$startindex = ($page - 1) * $pagesize;
		if ($this->uri->segment ( 4 ) == 'all') {
			
			$topiclist = $this->topic_model->get_list_byuid ( $muid, $startindex, $pagesize );
			echo json_encode ( $topiclist );
			exit ();
		}
		$cid = intval ( $this->uri->segment ( 4 ) );
		
		$topiclist = $this->topic_model->get_list_bycidanduid ( $cid, $muid, $startindex, $pagesize );
		
		echo json_encode ( $topiclist );
		exit ();
	}
	
	// 获取用户相关的文章数和关注数
	function getuserarticles() {
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 8;
		$startindex = ($page - 1) * $pagesize;
		$userrownum = $this->topic_model->rownum_by_user_article ();
		
		$topiclist = $this->topic_model->get_user_articles ( $startindex, $pagesize );
		echo json_encode ( $topiclist );
		exit ();
	}
	function index() {
		$url=url("seo/index");
header("Location: $url");
exit();
		$navtitle = "最新文章专栏推荐";
		$seo_description = "推荐问答最新文章专栏，热门文章和最新文章推荐。";
		$seo_keywords = "问答文章专栏";
		$typename="new";
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
	
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', ' id>0 and state=1 ', $this->db->dbprefix ) )->row_array () );
		$pages = @ceil ( $rownum / $pagesize );
		$topiclist = $this->topic_model->get_list ( 2, $startindex, $pagesize );
	
		$departstr = page ( $rownum, $pagesize, $page, "topic/default" );
		$metakeywords = $navtitle;
		$metadescription = '精彩推荐列表';
		$sublist = $this->category_model->list_by_cid_pid_all ( 0, 0 ); // 获取子分类
	
		include template ( 'topic' );
	}
	/**
	
	* 获取文章列表根据分类
	
	* @date: 2019年5月19日 下午1:38:33
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function articlelist(){
		$catid = intval ( $this->uri->rsegments [3] );
		
		@$page = max ( 1, intval ( $this->uri->rsegments [4] ) );
		$catmodel = $this->category_model->get ( $catid );
		$navtitle = $catmodel ['name'];
		$cids = array ();
		$pid=0;
		// 如果这是顶级分类
		if ($catmodel ['pid'] == 0) {
			
			// 获取当前分类下的子分类--二级分类
			$catlist = $this->category_model->list_by_pid ( $catid );
			
			// 把顶级分类id写入数组
			array_push ( $cids, $catid );
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
			
			$pid=$catmodel['pid'];
			// 如果不是顶级分类，先将分类id写入数组
			array_push ( $cids, $catid );
			
		
			// 获取该分类下的子分类
			$catlist = $this->category_model->list_by_pid ( $catid );
			
			if ($catlist) {
				
				// 遍历子分类写入数组
				foreach ( $catlist as $key => $val ) {
					array_push ( $cids, $val ['id'] );
				}
			}
			
			if ($catmodel ['grade'] == 3) {
				
				$catlist = $this->category_model->list_by_pid ( $catmodel ['pid'] );
				
				$catmodel = $this->category_model->get ( $catmodel ['pid'] );
			}
			
			
		}
		
		$cid = implode ( ',', $cids );
		
		$pagesize = $catmodel ['template'] == 'catlist_text' ? 40 : $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', "articleclassid in($cid) and state=1 ", $this->db->dbprefix ) )->row_array () );
		$trownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', " articleclassid in($cid) and state=1  ", $this->db->dbprefix ) )->row_array () );
		$topiclist = $this->topic_model->get_bycatid ( $cid, $startindex, $pagesize );
		
	
		$departstr = page ( $rownum, $pagesize, $page, "topic/catlist/$catid" );
		
		/* SEO */
		$seo_keywords = $navtitle;
		$seo_description = $this->setting ['site_name'] . $navtitle . '频道，提供' . $navtitle . '相关文章。';
		if ($this->setting ['seo_category_title']) {
			$seo_title = str_replace ( "{wzmc}", $this->setting ['site_name'], $this->setting ['seo_category_title'] );
			$seo_title = str_replace ( "{flmc}", $navtitle, $seo_title );
			if ($page == 1) {
			} else {
				$seo_title = $seo_title . '_第' . $page . "页";
			}
		} else {
			if ($page == 1) {
			} else {
				$navtitle = $navtitle . '_第' . $page . "页";
			}
		}
		
		if ($this->setting ['seo_category_description']) {
			$seo_description = str_replace ( "{wzmc}", $this->setting ['site_name'], $this->setting ['seo_category_description'] );
			$seo_description = str_replace ( "{flmc}", $navtitle, $seo_description );
		}
		if ($this->setting ['seo_category_keywords']) {
			$seo_keywords = str_replace ( "{wzmc}", $this->setting ['site_name'], $this->setting ['seo_category_keywords'] );
			$seo_keywords = str_replace ( "{flmc}", $navtitle, $seo_keywords );
		}
		
		include template ( 'topic' );
	}
	function catlist() {
		if(intval ( $this->uri->rsegments[3] )==0){
			$catdir=addslashes(strip_tags($this->uri->rsegments[3]));//获取目录
			$_cat=$this->db->get_where('category',array('dir'=>$catdir))->row_array();
			if($_cat){
				$catid=$_cat['id'];
			}else{
				show_404();
			}
		}else{
			$catid = intval ( $this->uri->rsegments [3] );
		}
		
		//相关分类标签
		$this->load->model ( "tag_model" );
		$relativetags = $this->tag_model->gettaglistbycid ( $catid );
		
		$is_followed = $this->category_model->is_followed ( $catid, $this->user ['uid'] );
		$followerlist = $this->category_model->get_followers ( $catid, 0, 8 ); // 获取导航
		@$page = max ( 1, intval ( $this->uri->rsegments [4] ) );
		$catmodel = $this->category_model->get ( $catid );
		$navtitle = $catmodel ['name'];
		$cids = array ();
		
		// 如果这是顶级分类
		if ($catmodel ['pid'] == 0) {
			
			// 获取当前分类下的子分类--二级分类
			$catlist = $this->category_model->list_by_pid ( $catid );
			
			// 把顶级分类id写入数组
			array_push ( $cids, $catid );
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
			
			// 如果不是顶级分类，先将分类id写入数组
			array_push ( $cids, $catid );
			
			// 获取该分类下的父亲级别的分类
			// $catlist=$this->category_model->list_by_pid($catmodel['pid']);
			
		
			
			if ($catmodel ['grade'] == 3) {
				
				//$catlist = $this->category_model->list_by_pid ( $catmodel ['pid'] );
				
				$parentcatmodel = $this->category_model->get ( $catmodel ['pid'] );
			}else{
				// 获取该分类下的子分类
				$catlist = $this->category_model->list_by_pid ( $catid );
				
				if ($catlist) {
					
					// 遍历子分类写入数组
					foreach ( $catlist as $key => $val ) {
						array_push ( $cids, $val ['id'] );
					}
				}
			}
			
			// var_dump($catmodel);exit();
		}
		
		$cid = implode ( ',', $cids );
		
		$pagesize = $catmodel ['template'] == 'catlist_text' ? 40 : $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', "articleclassid in($cid) and state=1 ", $this->db->dbprefix ) )->row_array () );
		$trownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', " articleclassid in($cid) and state=1  ", $this->db->dbprefix ) )->row_array () );
		$topiclist = $this->topic_model->get_bycatid ( $cid, $startindex, $pagesize );
		
		foreach ( $topiclist as $key => $val ) {
			
			$taglist = $this->topic_tag_model->get_by_aid ( $val ['id'] );
			
			$topiclist [$key] ['tags'] = $taglist;
		}
		if($catdir){
		    	$departstr = page ( $rownum, $pagesize, $page, "topic/catlist/$catdir" );
		}else{
		    	$departstr = page ( $rownum, $pagesize, $page, "topic/catlist/$catid" );
		}
	
		
		/* SEO */
		$seo_keywords = $navtitle;
		$seo_description = $this->setting ['site_name'] . $navtitle . '频道，提供' . $navtitle . '相关文章。';
		if ($this->setting ['seo_category_title']) {
			$seo_title = str_replace ( "{wzmc}", $this->setting ['site_name'], $this->setting ['seo_category_title'] );
			$seo_title = str_replace ( "{flmc}", $navtitle, $seo_title );
			if ($page == 1) {
			} else {
				$seo_title = $seo_title . '_第' . $page . "页";
			}
		} else {
			if ($page == 1) {
			} else {
				$navtitle = $navtitle . '_第' . $page . "页";
			}
		}
		
		if ($this->setting ['seo_category_description']) {
			$seo_description = str_replace ( "{wzmc}", $this->setting ['site_name'], $this->setting ['seo_category_description'] );
			$seo_description = str_replace ( "{flmc}", $navtitle, $seo_description );
		}
		if ($this->setting ['seo_category_keywords']) {
			$seo_keywords = str_replace ( "{wzmc}", $this->setting ['site_name'], $this->setting ['seo_category_keywords'] );
			$seo_keywords = str_replace ( "{flmc}", $navtitle, $seo_keywords );
		}
	
		// 如果分类模板没有为空，就应用新模板
		if ($catmodel ['template'] == null || trim ( $catmodel ['template'] ) == '') {
			include template ( 'catlist' );
		} else {
			include template ( trim ( $catmodel ['template'] ) );
		}
	}
	
	
	function convertUrlQuery($query) {
		$queryParts = explode ( '&', $query );
		$params = array ();
		foreach ( $queryParts as $param ) {
			$item = explode ( '=', $param );
			$params [$item [0]] = $item [1];
		}
		return $params;
	}
	/**
	 * 将参数变为字符串
	 * 
	 * @param
	 *        	$array_query
	 * @return string string 'm=content&c=index&a=lists&catid=6&area=0&author=0&h=0®ion=0&s=1&page=1' (length=73)
	 */
	function getUrlQuery($array_query) {
		$key = '';
		foreach ( $array_query as $k => $param ) {
			$key = $k;
			break;
		}
		
		return $key;
	}
	function getone() {
		$topicid = intval ( $this->uri->rsegments [3] );
		$panneltype = "hidefixed";
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
	
		
		$menu = "topic";
		
		$topicone = $this->topic_model->get ( $topicid );
		if ($topicone == null) {
			header ( 'HTTP/1.1 404 Not Found' );
			header ( "status: 404 Not Found" );
			echo '<!DOCTYPE html><html><head><meta charset=utf-8 /><title>404-您访问的页面不存在</title>';
			echo "<style>body { background-color: #ECECEC; font-family: 'Open Sans', sans-serif;font-size: 14px; color: #3c3c3c;}";
			echo ".nullpage p:first-child {text-align: center; font-size: 150px;  font-weight: bold;  line-height: 100px; letter-spacing: 5px; color: #fff;}";
			echo ".nullpage p:not(:first-child) {text-align: center;color: #666;";
			echo "font-family: cursive;font-size: 20px;text-shadow: 0 1px 0 #fff;  letter-spacing: 1px;line-height: 2em;margin-top: -50px;}";
			echo ".nullpage p a{margin-left:10px;font-size:20px;}";
			echo '</style></head><body> <div class="nullpage"><p><span>4</span><span>0</span><span>4</span></p><p>问题已经被删除！⊂((δ⊥δ))⊃<a href="/">返回主页</a></p></div></body></html>';
			exit ();
		}
		if (intval ( $topicone ['state'] ) == 0) {
			$this->message ( "文章在审核中", "topic/default" );
		}
		$readuid = $this->user ['uid'];
		$haspayprice = 0;
		$one = $this->topic_model->getreaduser ( $readuid, $topicid );
		if ($one != null) {
			// 已经付费过了
			$haspayprice = 1;
		}
		
		$topicone ['describtion'] = $topicone ['describtion'];
		
		$cat_model = $this->category_model->get ( $topicone ['articleclassid'] );
		$taglist = $this->topic_tag_model->get_by_aid ( $topicone ['id'] );
		$cid = $topicone ['articleclassid'];
		$category = $this->category [$cid]; // 得到分类信息
		$ctopiclist = $this->topic_model->get_bycatid ( $cid );
		$cfield = 'cid' . $category ['grade'];
		// $questionlist=$this->question_model->list_by_condition(" ");
		$questionlist = $this->question_model->list_by_cfield_cvalue_status ( $cfield, $cid, 'all', 0, 8 ); // 问题列表数据
		$topicone ['tags'] = $taglist;
		$views = $topicone ['views'] + 1;
		$topic_price = $topicone ['price'];
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "topic` SET  `views`=$views WHERE `id`=$topicid" );
		
		$navtitle = $topicone ['title'];
		$this->load->model ( "favorite_model" );
		$followerlist = $this->favorite_model->get_list_bytid ( $topicid ); // 收藏的人

		$tagkeystr='';
		if ($taglist) {
			$tagkeystr='';
			foreach ( $taglist as $tag ) {
				$tagkeystr .= $tag['tagname'].",";
			}
			
		}
		$seo_keywords =trim($tagkeystr,',');
		if ($topicone ['price'] != 0 && $haspayprice == 0 && $this->user ['uid'] != $topicone ['authorid']) {
			$seo_description = "付费后可查看文章内容";
		} else {
			$seo_description = cutstr ( trim ( clearhtml ( $topicone ['describtion'] ) ), 240 );
		}
		
		$member = $this->user_model->get_by_uid ( $topicone ['authorid'], 2 );
		// $is_followed = $this->user_model->is_followed($member['uid'], $this->user['uid']);
		 $topiclist1 = $this->topic_model->get_list_byuid ( $member ['uid'], 0, 8 );
		// $topiclist3 = $this->topic_model->get_list ( 1, 8 );
		$is_followedauthor = $this->user_model->is_followed ( $member ['uid'], $this->user ['uid'] );
		$this->load->model ( "articlecomment_model" );
		$tid = $topicone ['id'];
		$isfollowarticle=$this->favorite_model->get_by_tid($tid);
		// 评论分页
		@$page = 0;
		if (strpos ( $this->uri->rsegments [5], 'a' ) !== false) {
			@$page = 1;
		} else {
			@$page = max ( 1, intval ( $this->uri->rsegments [4]) );
		}
		$pagesize = 5; // $this->setting['list_default'];
		$startindex = ($page - 1) * $pagesize;
		
		$commentlist = $this->articlecomment_model->list_by_tid ( $tid, 1, $startindex, $pagesize );
		
		$commentrownum = returnarraynum ( $this->db->query ( getwheresql ( "articlecomment", " tid=$tid AND state=1 ", $this->db->dbprefix ) )->row_array () );
			//更新评论数
		$this->db->where(array('id'=>$tid))->update('topic',array('articles'=>$commentrownum));
		$departstr = page ( $commentrownum, $pagesize, $page, "topic/getone/$topicid" );
		// if(is_mobile()){
		// include template('getonetopic','wap');
		// }else{
		$this->load->model ( "paylog_model" );
		$shanglist = $this->paylog_model->getlist_bytype ( 'tid', $topicone ['id'] );
		$totalmoney = $this->paylog_model->gettotalmoney ( 'tid', $topicone ['id'] ); // 获取全部的钱
		$totalmoney = doubleval ( $totalmoney );
		$message ['type'] = 'article';
		$message ['touid'] = $member ['uid'];
		$message ['content'] = "给" . $member ['username'] . "的文章打赏";
		$_SESSION ["type"] = json_encode ( $message );
		$desc=$topicone['describtion'];

		$newct = $this->get_img_thumb_url($desc,SITE_URL."static/images/pcload.jpg");
	
		$topicone['describtion']=$newct;
		
		//定义熊掌号推送的url数组
		$tuiurls=array();
		$_url=url("topic/getone/$tid"); //此问题的url
		array_push($tuiurls, $_url);
		
		//推送给熊掌号
		xiongzhangtuisong($tuiurls);
		
		if($cat_model['articletemplate']&&$cat_model['articletemplate']!=''){
			include template ( $cat_model['articletemplate']);
		}else{
			
			include template ( 'topicone' );
		}
		
		
		// ob_start ();
		// include template ( 'topicone' );
		//
		// $content = ob_get_contents (); //取得php页面输出的全部内容
		// $fp = fopen ( "./article/$topicid.html", "w" );
		// fwrite ( $fp, $content );
		// fclose ( $fp );
	}
	
	function get_img_thumb_url($content="",$suffix="")
	{
		$pregRule = "/<img.*?src=[\'|\"](.*?(?:[\.jpg|\.jpeg|\.png|\.gif|\.bmp]))[\'|\"].*?[\/]?>/";
		$content = preg_replace($pregRule, '<img  data-original="${1}" src="'.$suffix.'" style="max-width:100%" class="lazy">', $content);
		return $content;
	}
	
	// 打印输出数组信息
	function printf_info($data) {
		foreach ( $data as $key => $value ) {
			echo "<font color='#00ff55;'>$key</font> : $value <br/>";
		}
	}
	function userxinzhi() {
		$uid = intval ( $this->uri->rsegments [3] );
		
		if ($uid == null) {
			exit ( "非法操作" );
		}
		$member = $this->user_model->get_by_uid ( $uid, 2 );
		if($member['isblack']||!$member){
			show_404();
			exit();
		}
		$is_followed = $this->user_model->is_followed ( $member ['uid'], $this->user ['uid'] );
		$navtitle = $member ['username'] . '的专栏列表';
		
		@$page = max ( 1, intval ( $this->uri->rsegments [4] ) );
		$pagesize = 5; // $this->setting['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', "authorid=$uid", $this->db->dbprefix ) )->row_array () );
		$topiclist = $this->topic_model->get_list_byuid ( $uid, $startindex, $pagesize );
		$pages = @ceil ( $rownum / $pagesize );
		$catags = $this->topic_model->get_article_by_uid ( $uid );
		foreach ( $topiclist as $key => $val ) {
			
			$taglist = $this->topic_tag_model->get_by_aid ( $val ['id'] );
			
			$topiclist [$key] ['tags'] = $taglist;
		}
		$departstr = page ( $rownum, 5, $page, "topic/userxinzhi/$uid" );
		$metakeywords = $navtitle;
		$metadescription = $member ['username'] . '的专栏列表';
		
		if ($uid == $this->user ['uid']) {
			include template ( 'myuserxinzhi' );
		} else {
			include template ( 'userxinzhi' );
		}
	}
	
	/**
	
	* 语音文字合成处理
	
	* @date: 2019年1月3日 下午4:37:59
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function putyuyin(){
		set_time_limit(0);
		require_once FCPATH.'lib/apispeech/AipSpeech.php';
		$str=$_POST['content'];
		$tid=intval($_POST['tid']);
		$paystr=$_POST['paycontent']? $_POST['paycontent']:'';
		if(!$this->user['uid']){
			$message['code']=201;
			$message['msg']="游客先登录后在生成";
			echo json_encode($message);
			exit();
		}
		$strword=strip_tags($str);
		$len=strlen($strword);
		
		$maxlen=200;
		$pages= @ceil ( $len / $maxlen );
		
		$result='';
		for($i=0;$i<$pages;$i++){
			if(($i+1)>=$pages){
				$result .= $client->synthesis(substr($strword,$i*$maxlen), 'zh', 1, array(
						'vol' => 5,
				));
			}else{
				$result .= $client->synthesis(substr($strword,$i*$maxlen,$maxlen), 'zh', 1, array(
						'vol' => 5,
				));
			}
			
		}
		
		
		// 识别正确返回语音二进制 错误则返回json 参照下面错误码
		if(!is_array($result)){
			$yuyinfile=FCPATH."data/weixinrecord/free".$tid.".mp3";
			file_put_contents($yuyinfile, $result);
			if($paystr==''){
				$message['code']=200;
				$message['msg']="语音生成成功";
				echo json_encode($message);
				exit();
			}
		
		}
		
		
		$strword=strip_tags($paystr);
		$len=strlen($strword);
		
		$maxlen=200;
		$pages= @ceil ( $len / $maxlen );
		
		$result='';
		for($i=0;$i<$pages;$i++){
			if(($i+1)>=$pages){
				$result .= $client->synthesis(substr($strword,$i*$maxlen), 'zh', 1, array(
						'vol' => 5,
				));
			}else{
				$result .= $client->synthesis(substr($strword,$i*$maxlen,$maxlen), 'zh', 1, array(
						'vol' => 5,
				));
			}
			
		}
		
		// 识别正确返回语音二进制 错误则返回json 参照下面错误码
		if(!is_array($result)){
			$yuyinfile=FCPATH."data/weixinrecord/pay".$tid.".mp3";
			file_put_contents($yuyinfile, $result);
			if($paystr!=''){
				$message['code']=200;
				$message['msg']="语音生成成功";
				echo json_encode($message);
				exit();
			}
			
		}
	}
}

?>