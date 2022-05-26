<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Admin_question extends ADMIN_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( "question_model" );
		$this->load->model ( "category_model" );
		$this->load->model ( "answer_model" );
	}
	function index() {
		$this->searchquestion ();
	}
	/**
	 *
	 * 发布回答
	 *
	 * @date: 2020年6月13日 下午12:21:37
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function addanswer() {
		$qid = intval ( $_POST ['qid'] );
		$content = $_POST ['content'];
		$author = addslashes ( $_POST ['author'] );
		$question = $this->db->get_where ( 'question', array (
				'id' => $qid 
		) )->row_array ();
		if (! $question) {
			$message ['code'] = 2001;
			
			$message ['msg'] = "问题不存在";
			echo json_encode ( $message );
			exit ();
		}
		//悬赏问题如果被采纳就禁止编辑
		if($question['shangjin']>0&&$question['status']==2||$question['shangjin']>0&&$question['status']==9){
			$message ['code'] = 2001;
			$message ['msg'] = "悬赏问题已经被解决，无法在继续回答!";
			echo json_encode ( $message );
			exit ();
		}
		if($question['shangjin']>0){
			//判断悬赏问题回答个数是否大于最大数
			if(!isset($this->setting['xuanshang_question_answers'])||!$this->setting['xuanshang_question_answers']){
				$this->setting['xuanshang_question_answers']=0;
			}
			// 判断问题是否有悬赏且有回答
			$answerconut = $this->db->query ( "select count(id) as num from " . $this->db->dbprefix . "answer where qid=$qid" )->row_array ();
			
			$maxxuanshanganswer=intval($this->setting['xuanshang_question_answers']);
			if($maxxuanshanganswer!=0&&$maxxuanshanganswer>0&&$answerconut['num']>=$maxxuanshanganswer){
				$message ['code'] = 2001;
				$message ['msg'] = "已超过平台设置悬赏问题最大回答人数".$maxxuanshanganswer."人，不允许继续回答!";
				echo json_encode ( $message );
				exit ();
			}
		}
		$user = $this->db->get_where ( 'user', array (
				'username' => $author 
		) )->row_array ();
		if (! $user) {
			$message ['code'] = 2002;
			
			$message ['msg'] = "回答用户[$author]不存在";
			echo json_encode ( $message );
			exit ();
		}
		if (empty ( $content ) || strip_tags ( $content ) == '') {
			$message ['code'] = 2003;
			
			$message ['msg'] = "回答内容不能为空且必须包含文字描述";
			echo json_encode ( $message );
			exit ();
		}
		// 判断此人是否已经回答过该问题
		$useransser = $this->db->get_where ( 'answer', array (
				'author' => $author,
				'qid' => $qid 
		) )->row_array ();
		if ($useransser) {
			$message ['code'] = 2004;
			
			$message ['msg'] = "该用户已经回答过此问题";
			echo json_encode ( $message );
			exit ();
		}
		
		// 插入回答问题
		$adddata = array (
				'author' => $user ['username'],
				'authorid' => $user ['uid'],
				'content' => $content,
				'qid' => $qid,
				'title' => $question ['title'],
				'time' => time (),
				'ip' => getip () 
		);
		$this->db->insert ( 'answer', $adddata );
		$aid = $this->db->insert_id ();
		if ($aid > 0) {
			// 问题回答数+1
			$sql = "update " . $this->db->dbprefix . "question set answers=answers+1 where id=$qid";
			$this->db->query ( $sql );			
			$this->load->model ( "doing_model" );
			$this->doing_model->add ( $user ['uid'], $user ['username'], 2, $qid, $content );
			$message ['code'] = 2000;
			
			$message ['msg'] = "提交成功";
			echo json_encode ( $message );
			exit ();
		} else {
			$message ['code'] = 2005;
			
			$message ['msg'] = "发布问题失败";
			echo json_encode ( $message );
			exit ();
		}
	}
	function searchquestion($msg = '', $ty = '') {
		if ($this->uri->rsegments [3] != '' && $this->uri->rsegments [3] != '0') {
			$srchtitle = trim ( urldecode ( $this->uri->rsegments [3] ) );
		} else {
			$srchtitle = trim ( $this->input->post ( 'srchtitle' ) );
		}
		
		if ($this->uri->rsegments [4] != '' && $this->uri->rsegments [4] != '0') {
			$srchauthor = trim ( urldecode ( $this->uri->rsegments [4] ) );
		} else {
			$srchauthor = trim ( $this->input->post ( 'srchauthor' ) );
		}
		
		if ($this->uri->rsegments [5] != '' && $this->uri->rsegments [5] != '0') {
			$srchdatestart = trim ( urldecode ( $this->uri->rsegments [5] ) );
		} else {
			$srchdatestart = $this->input->post ( 'srchdatestart' );
		}
		
		if ($this->uri->rsegments [6] != '' && $this->uri->rsegments [6] != '0') {
			$srchdateend = trim ( urldecode ( $this->uri->rsegments [6] ) );
		} else {
			$srchdateend = $this->input->post ( 'srchdateend' );
		}
		if ($this->uri->rsegments [7] != '' && $this->uri->rsegments [7] != '0') {
			$srchstatus = trim ( urldecode ( $this->uri->rsegments [7] ) );
		} else {
			$srchstatus = $this->input->post ( 'srchstatus' );
		}
		if ($this->uri->rsegments [8] != '' && $this->uri->rsegments [8] != '0') {
			$srchcategory = trim ( urldecode ( $this->uri->rsegments [8] ) );
		} else {
			$srchcategory = $this->input->post ( 'srchcategory' );
		}
		
		@$page = max ( 1, intval ( $this->uri->rsegments [9] ) );
		
		$pagesize = isset ( $this->setting ['admin_list_default'] ) ? $this->setting ['admin_list_default'] : $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		
		$questionlist = $this->question_model->list_by_search ( $srchtitle, $srchauthor, $srchdatestart, $srchdateend, $srchstatus, $srchcategory, $startindex, $pagesize );
		
		$rownum = $this->question_model->rownum_by_search ( $srchtitle, $srchauthor, $srchdatestart, $srchdateend, $srchstatus, $srchcategory );
		
		if (! $srchtitle) {
			$srchtitle = 0;
		}
		if (! $srchauthor) {
			$srchauthor = 0;
		}
		if (! $srchdatestart) {
			$srchdatestart = 0;
		}
		if (! $srchdateend) {
			$srchdateend = 0;
		}
		if (! $srchstatus) {
			$srchstatus = 0;
		}
		if (! $srchcategory) {
			$srchcategory = 0;
		}
		$departstr = page ( $rownum, $pagesize, $page, "admin_question/searchquestion/$srchtitle/$srchauthor/$srchdatestart/$srchdateend/$srchstatus/$srchcategory" );
		
		$ty && $type = $ty;
		$catetree = $this->category_model->get_categrory_tree ();
		if (! $srchtitle) {
			$srchtitle = '';
		}
		if (! $srchauthor) {
			$srchauthor = '';
		}
		if (! $srchdatestart) {
			$srchdatestart = '';
		}
		if (! $srchdateend) {
			$srchdateend = '';
		}
		if (! $srchstatus) {
			$srchstatus = '';
		}
		if (! $srchcategory) {
			$srchcategory = '';
		}
		include template ( 'questionlist', 'admin' );
	}
	function searchanswer($msg = '', $ty = '') {
		if ($this->uri->rsegments [3] != '' && $this->uri->rsegments [3] != '0') {
			$srchtitle = trim ( urldecode ( $this->uri->rsegments [3] ) );
		} else {
			$srchtitle = trim ( $this->input->post ( 'srchtitle' ) );
		}
		
		if ($this->uri->rsegments [4] != '' && $this->uri->rsegments [4] != '0') {
			$srchauthor = trim ( urldecode ( $this->uri->rsegments [4] ) );
		} else {
			$srchauthor = trim ( $this->input->post ( 'srchauthor' ) );
		}
		
		if ($this->uri->rsegments [5] != '' && $this->uri->rsegments [5] != '0') {
			$srchdatestart = trim ( urldecode ( $this->uri->rsegments [5] ) );
		} else {
			$srchdatestart = $this->input->post ( 'srchdatestart' );
		}
		
		if ($this->uri->rsegments [6] != '' && $this->uri->rsegments [6] != '0') {
			$srchdateend = trim ( urldecode ( $this->uri->rsegments [6] ) );
		} else {
			$srchdateend = $this->input->post ( 'srchdateend' );
		}
		if ($this->uri->rsegments [7] != '' && $this->uri->rsegments [7] != '0') {
			$keywords = trim ( urldecode ( $this->uri->rsegments [7] ) );
		} else {
			$keywords = $this->input->post ( 'keywords' );
		}
		@$page = max ( 1, intval ( $this->uri->rsegments [8] ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$answerlist = $this->answer_model->list_by_search ( $srchtitle, $srchauthor, $keywords, $srchdatestart, $srchdateend, $startindex, $pagesize );
		$rownum = $this->answer_model->rownum_by_search ( $srchtitle, $srchauthor, $keywords, $srchdatestart, $srchdateend );
		if (! $srchtitle) {
			$srchtitle = 0;
		}
		if (! $srchauthor) {
			$srchauthor = 0;
		}
		if (! $srchdatestart) {
			$srchdatestart = 0;
		}
		if (! $srchdateend) {
			$srchdateend = 0;
		}
		if (! $keywords) {
			$keywords = 0;
		}
		$departstr = page ( $rownum, $pagesize, $page, "admin_question/searchanswer/$srchtitle/$srchauthor/$srchdatestart/$srchdateend/$keywords" );
		if (! $srchtitle) {
			$srchtitle = '';
		}
		if (! $srchauthor) {
			$srchauthor = '';
		}
		if (! $srchdatestart) {
			$srchdatestart = '';
		}
		if (! $srchdateend) {
			$srchdateend = '';
		}
		if (! $keywords) {
			$keywords = '';
		}
		$msg && $message = $msg;
		$ty && $type = $ty;
		include template ( 'answerlist', 'admin' );
	}
	function removequestion() {
		if (null !== $this->input->post ( 'qid' )) {
			$qids = implode ( ",", $this->input->post ( 'qid' ) );
			if (is_array ( $this->input->post ( 'qid' ) )) {
				foreach ( $this->input->post ( 'qid' ) as $qid ) {
					$question = $this->question_model->get ( $qid );
					if ($question ['price'] > 0) {
						$this->credit ( $question ['authorid'], 0, $question ['price'], 0, 'back' );
					}
					
					if ($question ['hidden'] > 0) {
						$this->credit ( $question ['authorid'], 0, 10, 0, 'back' );
					}
					$touser = $this->user_model->get_by_uid ( $question ['authorid'] );
					$koujiancredit1 = intval ( $this->setting ['credit1_ask'] );
					if ($touser ['credit1'] < $koujiancredit1) {
						$koujiancredit1 = $touser ['credit1'] >= 0 ? $touser ['credit1'] : 0;
					}
					
					$koujiancredit2 = intval ( $this->setting ['credit2_ask'] );
					if ($touser ['credit2'] < $koujiancredit2) {
						$koujiancredit2 = $touser ['credit2'] >= 0 ? $touser ['credit2'] : 0;
					}
					
					$this->credit ( $question ['authorid'], - $koujiancredit1, - $koujiancredit2, 0, 'back' );
				}
			} else {
				$qid = $this->input->post ( 'qid' );
				$question = $this->question_model->get ( $qid );
				if ($question ['price'] > 0) {
					$this->credit ( $question ['authorid'], 0, $question ['price'], 0, 'back' );
				}
				
				if ($question ['hidden'] > 0) {
					$this->credit ( $question ['authorid'], 0, 10, 0, 'back' );
				}
				$touser = $this->user_model->get_by_uid ( $question ['authorid'] );
				$koujiancredit1 = intval ( $this->setting ['credit1_ask'] );
				if ($touser ['credit1'] < $koujiancredit1) {
					$koujiancredit1 = $touser ['credit1'] >= 0 ? $touser ['credit1'] : 0;
				}
				
				$koujiancredit2 = intval ( $this->setting ['credit2_ask'] );
				if ($touser ['credit2'] < $koujiancredit2) {
					$koujiancredit2 = $touser ['credit2'] >= 0 ? $touser ['credit2'] : 0;
				}
				
				$this->credit ( $question ['authorid'], - $koujiancredit1, - $koujiancredit2, 0, 'back' );
			}
			
			$this->question_model->remove ( $qids );
		}
		$this->index ();
	}
	function removeanswer() {
		if (null !== $this->input->post ( 'aid' )) {
			$aids = implode ( ",", $this->input->post ( 'aid' ) );
			if (is_array ( $this->input->post ( 'aid' ) )) {
				foreach ( $this->input->post ( 'aid' ) as $aid ) {
					$answer = $this->answer_model->get ( $aid );
					// 删除回答问题，扣减积分
					$uid = $answer ['authorid'];
					$touser = $this->user_model->get_by_uid ( $uid );
					$koujiancredit1 = intval ( $this->setting ['credit1_answer'] );
					if ($touser ['credit1'] < $koujiancredit1) {
						$koujiancredit1 = $touser ['credit1'] >= 0 ? $touser ['credit1'] : 0;
					}
					
					$koujiancredit2 = intval ( $this->setting ['credit2_answer'] );
					if ($touser ['credit2'] < $koujiancredit2) {
						$koujiancredit2 = $touser ['credit2'] >= 0 ? $touser ['credit2'] : 0;
					}
					
					$this->credit ( $uid, - $koujiancredit1, - $koujiancredit2, 0, 'delanswer' );
				}
			} else {
				$aid = $this->input->post ( 'aid' );
				$answer = $this->answer_model->get ( $aid );
				// 删除回答问题，扣减积分
				$uid = $answer ['authorid'];
				$touser = $this->user_model->get_by_uid ( $uid );
				$koujiancredit1 = intval ( $this->setting ['credit1_answer'] );
				if ($touser ['credit1'] < $koujiancredit1) {
					$koujiancredit1 = $touser ['credit1'] >= 0 ? $touser ['credit1'] : 0;
				}
				
				$koujiancredit2 = intval ( $this->setting ['credit2_answer'] );
				if ($touser ['credit2'] < $koujiancredit2) {
					$koujiancredit2 = $touser ['credit2'] >= 0 ? $touser ['credit2'] : 0;
				}
				
				$this->credit ( $uid, - $koujiancredit1, - $koujiancredit2, 0, 'delanswer' );
			}
			$this->answer_model->remove ( $aids );
		}
		$this->searchanswer ();
	}
	function edit() {
		$qid = null !== $this->input->post ( 'submit' ) ? $this->input->post ( 'qid' ) : $this->uri->segment ( 3 );
		if (null !== $this->input->post ( 'submit' )) {
			$title = $this->input->post ( 'title' );
			$description = $this->input->post ( 'description' );
			$cid1 = $this->input->post ( 'classlevel1' );
			$cid2 = $this->input->post ( 'classlevel2' );
			$cid3 = $this->input->post ( 'classlevel3' );
			$cid = $this->input->post ( 'cid' );
			$hidden = intval ( null !== $this->input->post ( 'hidden' ) );
			$price = intval ( $this->input->post ( 'price' ) );
			$status = intval ( null !== $this->input->post ( 'status' ) );
			$this->question_model->update ( $qid, $title, $description, $hidden, $price, $status, $cid, $cid1, $cid2, $cid3, $this->input->post ( 'time' ) );
			$message = '问题编辑成功!';
		}
		$question = $this->question_model->get ( $qid );
		$question ['date'] = date ( "Y-m-d", $question ['time'] );
		$question_status = array (
				array (
						0,
						'未审核' 
				),
				array (
						1,
						'待解决' 
				),
				array (
						6,
						'推荐问题' 
				),
				array (
						9,
						'已关闭问题' 
				) 
		);
		$prices = array (
				0,
				5,
				10,
				15,
				20,
				30,
				50,
				80,
				100 
		);
		include template ( 'editquestion', 'admin' );
	}
	function editanswer() {
		$aid = null !== $this->input->post ( 'submit' ) ? $this->input->post ( 'aid' ) : $this->uri->segment ( 3 );
		if (null !== $this->input->post ( 'submit' )) {
			$content = $this->input->post ( 'content' );
			$answertime = strtotime ( $this->input->post ( 'time' ) );
			$this->answer_model->update_time_content ( $aid, $answertime, $content );
		}
		$answer = $this->answer_model->get ( $aid );
		$answer ['date'] = date ( "Y-m-d", $answer ['time'] );
		include template ( 'editanswer', 'admin' );
	}
	
	// 回答审核
	function verifyanswer() {
		if (null !== $this->input->post ( 'aid' )) {
			$aids = implode ( ",", $this->input->post ( 'aid' ) );
			$this->answer_model->change_to_verify ( $aids );
			$type = 'correctmsg';
			$message = '回答审核完成!';
			// 邮件通知审核结果
			foreach ( $this->input->post ( 'aid' ) as $aid ) {
				// 获取回答者通知情况
				$answer = $this->answer_model->get ( $aid );
				$myquser = $this->user_model->get_by_uid ( $answer ['authorid'] );
				// 如果关注者接受回答邮件提醒就发送邮件
				$title = $answer ['title'];
				$subject = "您回答的问题[" . $title . "]已通过审核！";
				$qid = $answer ['qid'];
				$mymessage = $answer ['content'] . '<p>现在您可以点击<a swaped="true" target="_blank" href="' . url ( 'question/view/' . $qid ) . '">查看问题详情</a>。</p>';
				
				sendmail ( $myquser, $subject, $mymessage );
			}
		}
		
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 20;
		$startindex = ($page - 1) * $pagesize;
		$answerlist = $this->answer_model->list_by_condition ( '`status`=0', $startindex, $pagesize );
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'answer', ' `status`=0', $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "admin_question/verifyanswer" );
		include template ( "verifyanswers", "admin" );
	}
	
	// 问题审核
	function verify() {
		$this->load->model ( "doing_model" );
		if (null !== $this->input->post ( 'qid' )) {
			$qids = implode ( ",", $this->input->post ( 'qid' ) );
			$this->question_model->change_to_verify ( $qids );
			// 邮件通知审核结果
			foreach ( $this->input->post ( 'qid' ) as $qid ) {
				// 获取回答者通知情况
				$question = $this->question_model->get ( $qid );
				$myquser = $this->user_model->get_by_uid ( $question ['authorid'] );
				// 如果关注者接受回答邮件提醒就发送邮件
				$title = $question ['title'];
				$subject = "您发布的问题[" . $title . "]已通过审核！";
				$qid = $question ['id'];
				$mymessage = '<p>现在您可以点击<a swaped="true" target="_blank" href="' . url ( 'question/view/' . $qid ) . '">查看问题详情</a>。</p>';
				$this->doing_model->add ( $question ['authorid'], $question ['author'], 1, $qid, $question ['description'] );
				sendmail ( $myquser, $subject, $mymessage );
			}
			$this->message ( '问题审核成功!' );
			exit ();
		}
	}
	/* 百度推送 */
	function baidutui() {
		$urls = array ();
		
		if (null !== $this->input->post ( 'qid' )) {
			// SITE_URL.$suffix."q-$item[id]$fix
			$qids = $this->input->post ( 'qid' );
			$q_size = count ( $qids );
			for($i = 0; $i < $q_size; $i ++) {
				array_push ( $urls, url ( "question/view/" . $qids [$i] ) );
			}
		} else {
			$this->searchquestion ( '您还没选择推送问题!' );
		}
		if (trim ( $this->setting ['baidu_api'] ) != '' && $this->setting ['baidu_api'] != null) {
			
			$api = $this->setting ['baidu_api'];
			$result = baidusend ( $api, $urls );
			$this->searchquestion ( '问题推送成功!' );
		} else {
			$this->searchquestion ( '问题推送不成功，您还没设置百度推送的api地址，前往系统设置--seo设置里配置!' );
		}
	}
	
	// 问题推荐
	function recommend() {
		if (null !== $this->input->post ( 'qid' )) {
			foreach ( $this->input->post ( 'qid' ) as $qid ) {
				// 获取问题记录
				$question = $this->question_model->get ( $qid );
		
				// 判断悬赏问题是否已经被采纳过
				if ($question ['shangjin'] > 0 ) {
					$this->message ( "悬赏问题【" . $question ['title'] . "】不能设置推荐。" );
					exit ();
				}
			
				//悬赏问题金额大于0且回答等于0或者悬赏等于0可以关闭问题
				if($question ['shangjin'] == 0){
					$this->question_model->change_recommend ( $qid, 6, 2 );
				}
				
			}
			
			$this->message ('问题推荐成功!');
			exit ();
		}
		
	
	}
	
	// 取消推荐
	function inrecommend() {
		if (null !== $this->input->post ( 'qid' )) {
			foreach ( $this->input->post ( 'qid' ) as $qid ) {
				// 获取问题记录
				$question = $this->question_model->get ( $qid );
				
				// 判断悬赏问题是否已经被采纳过
				if ($question ['shangjin'] > 0 ) {
					$this->message ( "悬赏问题【" . $question ['title'] . "】不能操作。" );
					exit ();
				}
				
				if($question ['shangjin'] == 0){
					$this->question_model->change_recommend ( $qid, 2, 6 );
				}
				
			}
			
			$this->message ('取消问题推荐成功!');
			exit ();
		}
		
	
	}
	
	// 关闭问题
	function close() {
		if (null !== $this->input->post ( 'qid' )) {
			foreach ( $this->input->post ( 'qid' ) as $qid ) {
				// 获取问题记录
				$question = $this->question_model->get ( $qid );
				// 判断问题是否有悬赏且有回答
				$answerconut = $this->db->query ( "select count(id) as num from " . $this->db->dbprefix . "answer where qid=$qid" )->row_array ();
				
				// 判断悬赏问题是否已经被采纳过
				if ($question ['shangjin'] > 0 && $question ['status'] == 9 || $question ['shangjin'] > 0 && $question ['status'] == 2) {
					$this->message ( "悬赏问题【" . $question ['title'] . "】已经采纳或关闭，不能操作。" );
					exit ();
				}
				// 判断悬赏问题是否有答案且没被采纳
				if ($question ['shangjin'] > 0 && $question ['status'] != 2 && $answerconut ['num'] > 0 && $question ['status'] == 9) {
					$this->message ( "悬赏问题【" . $question ['title'] . "】已经有问答且没被作者采纳不能关闭。" );
					exit ();
				}
				//悬赏问题金额大于0且回答等于0或者悬赏等于0可以关闭问题
				if($question ['shangjin'] > 0&&$answerconut ['num'] == 0||$question ['shangjin'] == 0){
					$this->question_model->update_status ( $qid, 9 );
				}
				
			}
			
			$this->message ( '问题关闭成功!' );
			exit ();
		}
	}
	
	// 删除问题
	function delete() {
		if (null !== $this->input->post ( 'qid' )) {
			foreach ( $this->input->post ( 'qid' ) as $qid ) {
				// 获取问题记录
				$question = $this->question_model->get ( $qid );
				// 判断问题是否有悬赏且有回答
				$answerconut = $this->db->query ( "select count(id) as num from " . $this->db->dbprefix . "answer where qid=$qid" )->row_array ();
				if ($question ['shangjin'] > 0 && $answerconut ['num'] > 0) {
					$this->message ( "悬赏问题【" . $question ['title'] . "】已经有回答，不能删除。" );
					exit ();
				}
				// 如果悬赏财富值大于0，收回悬赏财富值
				if ($question ['price'] > 0) {
					$this->credit ( $question ['authorid'], 0, $question ['price'], 0, 'back' );
				}
				// 如果问题设置隐藏，收回扣除隐藏财富值
				if ($question ['hidden'] > 0) {
					$this->credit ( $question ['authorid'], 0, 10, 0, 'hiddenback' );
				}
				// 获取当前提问人记录
				$touser = $this->user_model->get_by_uid ( $question ['authorid'] );
				// 获取发布问题经验值
				$koujiancredit1 = intval ( $this->setting ['credit1_ask'] );
				if ($touser ['credit1'] < $koujiancredit1) {
					$koujiancredit1 = $touser ['credit1'] >= 0 ? $touser ['credit1'] : 0;
				}
				// 获取发布问题财富值
				$koujiancredit2 = intval ( $this->setting ['credit2_ask'] );
				if ($touser ['credit2'] < $koujiancredit2) {
					$koujiancredit2 = $touser ['credit2'] >= 0 ? $touser ['credit2'] : 0;
				}
				// 回收财富值
				$this->credit ( $question ['authorid'], - $koujiancredit1, - $koujiancredit2, 0, 'delquestion' );
				$touser = $this->user_model->get_by_uid ( $question ['authorid'] );
				$credit1 = $touser ['credit1'];
				if ($touser ['credit1'] < 0) {
					$credit1 = 0;
				}
				$credit2 = $touser ['credit2'];
				if ($touser ['credit2'] < 0) {
					$credit2 = 0;
				}
				if ($credit1 == 0 || $credit2 == 0) {
					$this->db->where ( array (
							'uid' => $question ['authorid'] 
					) )->update ( 'user', array (
							'credit1' => $credit1,
							'credit2' => $credit2 
					) );
				}
			}
			
			$qids = implode ( ",", $this->input->post ( 'qid' ) );
			$this->question_model->remove ( $qids );
			$this->message ( '问题删除成功!' );
			exit ();
		}
	}
	
	// 修改问题标题
	function renametitle() {
		if (null !== $this->input->post ( 'title' )) {
			$title = trim ( $this->input->post ( 'title' ) );
			if ('' == $title) {
				$this->searchquestion ( '问题标题不能为空!', 'errormsg' );
			} else {
				$this->question_model->renametitle ( intval ( $this->input->post ( 'qid' ) ), $title );
				$this->searchquestion ( '问题编辑成功!' );
			}
		}
	}
	
	// 修改问题内容
	function editquescont() {
		if (null !== $this->input->post ( 'content' )) {
			$content = trim ( $this->input->post ( 'content' ) );
			if ('' == $content) {
				$this->searchquestion ( '问题内容不能为空!', 'errormsg' );
				exit ();
			}
			$this->question_model->update_content ( intval ( $this->input->post ( 'qid' ) ), $content );
			$this->searchquestion ( '问题内容修改成功!' );
		}
	}
	
	// 移动分类
	function movecategory() {
		if (intval ( $this->input->post ( 'category' ) )) {
			$cid = intval ( $this->input->post ( 'category' ) );
			$cid1 = 0;
			$cid2 = 0;
			$cid3 = 0;
			$qids = $this->input->post ( 'qids' );
			$category = $this->cache->load ( 'category' );
			if ($category [$cid] ['grade'] == 1) {
				$cid1 = $cid;
			} else if ($category [$cid] ['grade'] == 2) {
				$cid2 = $cid;
				$cid1 = $category [$cid] ['pid'];
			} else if ($category [$cid] ['grade'] == 3) {
				$cid3 = $cid;
				$cid2 = $category [$cid] ['pid'];
				$cid1 = $category [$cid2] ['pid'];
			} else {
				$this->searchquestion ( '分类不存在，请更下缓存!', 'errormsg' );
				exit ();
			}
			$this->question_model->update_category ( $qids, $cid, $cid1, $cid2, $cid3 );
			$this->searchquestion ( '问题分类修改成功!' );
			exit ();
		}
	}
	
	// 设为未解决
	function nosolve() {
		if (null !== $this->input->post ( 'qid' )) {
			$this->load->model ( 'depositmoney_model' );
			foreach ( $this->input->post ( 'qid' ) as $qid ) {
				// 获取问题记录
				$question = $this->question_model->get ( $qid );
				// 判断问题是否有悬赏且有回答
				$answerconut = $this->db->query ( "select count(id) as num from " . $this->db->dbprefix . "answer where qid=$qid" )->row_array ();
				
				// 判断悬赏问题是否已经被采纳过
				if ($question ['shangjin'] > 0 && $question ['status'] == 9 || $question ['shangjin'] > 0 && $question ['status'] == 2) {
					$this->message ( "悬赏问题【" . $question ['title'] . "】已经采纳或关闭，不能设置为未解决。" );
					exit ();
				}
				if ($question ['price'] > 0 && $question ['status'] == 2 || $question ['price'] > 0 && $question ['status'] == 6) {
					$this->message ( "财富值悬赏问题【" . $question ['title'] . "】已经采纳或被推荐，不能设置为未解决。" );
					exit ();
				}
				// 其它普通回答
				if ($question ['shangjin'] == 0) {
					$this->question_model->change_to_nosolve ( $qid );
				}
			}
			
			$this->message ( '问题状态设置成功!' );
			exit ();
		}
	}
	/**
	 *
	 * 将问题设置为已解决
	 *
	 * @date: 2020年10月25日 下午5:20:13
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function solve() {
		if (null !== $this->input->post ( 'qid' )) {
			$this->load->model ( 'depositmoney_model' );
			foreach ( $this->input->post ( 'qid' ) as $qid ) {
				// 获取问题记录
				$question = $this->question_model->get ( $qid );
				// 判断问题是否有悬赏且有回答
				$answerconut = $this->db->query ( "select count(id) as num from " . $this->db->dbprefix . "answer where qid=$qid" )->row_array ();
				if ($question ['shangjin'] > 0 && $answerconut ['num'] == 0) {
					$this->message ( "悬赏问题【" . $question ['title'] . "】没有回答不能被采纳。" );
					exit ();
				}
				// 判断悬赏问题是否已经被采纳过
				if ($question ['shangjin'] > 0 && $question ['status'] == 9 || $question ['shangjin'] > 0 && $question ['status'] == 2) {
					$this->message ( "悬赏问题【" . $question ['title'] . "】已经采纳或者关闭，不能重复采纳。" );
					exit ();
				}
				// 判断悬赏问题没被采纳就采纳下,回答需大于0
				if ($question ['shangjin'] > 0 && $question ['status'] == 1 && $answerconut ['num'] >= 0) {
					$this->question_model->setbestanswer ( $question );
					$bestanswer = $this->answer_model->get_best ( $qid );
					// ===
					$touid = $bestanswer ['authorid'];
					$quid = $question ['authorid'];
					// 提问悬赏金额
					$cash_fee = doubleval ( $question ['shangjin'] ) * 100; // 单位分
					if ($cash_fee > 0) {
						
						$adoptmoeny = $question ['shangjin']; // 提问悬赏金额 单位元
						                                      // 最佳答案分成
						$weixin_fenceng_zuijia = doubleval ( $this->setting ['weixin_fenceng_zuijia'] );
						// 平台分成
						$weixin_fenceng_answersite = doubleval ( $this->setting ['weixin_fenceng_answersite'] );
						// 行家解答平台分成
						$weixin_fenceng_hangjia = doubleval ( $this->setting ['weixin_fenceng_hangjia'] );
						// 最终给用户悬赏金额
						$finalcash_fee = $cash_fee * $weixin_fenceng_zuijia;
						$finaladoptmoeny = $adoptmoeny * $weixin_fenceng_zuijia;
						$time = time ();
						// 将悬赏金额给被采纳者
						$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET  `jine`=jine+'$finalcash_fee' WHERE `uid`=$touid" );
						// 更新最佳答案分成金额
						$this->db->where ( array (
								'id' => $bestanswer ['id'] 
						) )->update ( 'answer', array (
								'commission' => $finaladoptmoeny 
						) );
						try {
							// 悬赏问题其它回答平分比例
							$weixin_fenceng_answerother = doubleval ( $this->setting ['weixin_fenceng_answerother'] );
							// 剩余平分金额=悬赏总金额-平台分成-最佳答案分成
							$last_answer_money = $adoptmoeny - $adoptmoeny * $weixin_fenceng_answersite - $finaladoptmoeny;
							// 判断有没有其它回答，如果有就设置分成
							$answerlist = $this->db->get_where ( 'answer', array (
									'qid' => $qid,
									'adopttime' => 0 
							) )->result_array ();
							if ($answerlist && count ( $answerlist ) > 0) {
								$total_answerlist = count ( $answerlist );
								// 平分金额单个回答
								$anvegemoney = round ( floatval ( $last_answer_money / $total_answerlist ), 2 );
								foreach ( $answerlist as $_answer ) {
									// 更新每个回答分佣
									$this->db->where ( array (
											'id' => $_answer ['id'] 
									) )->update ( 'answer', array (
											'commission' => $anvegemoney 
									) );
									$_answeruid = $_answer ['authorid'];
									$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "paylog SET type='otheranswercommission',typeid=$qid,money=$anvegemoney,openid='',fromuid=$quid,touid=$_answeruid,`time`=$time" );
								}
							}
						} catch ( Exception $e ) {
						}
						// 被采纳获得赏金记录
						if ($adoptmoeny > 0) {
							$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "paylog SET type='adoptqid',typeid=$qid,money=$finaladoptmoeny,openid='',fromuid=$quid,touid=$touid,`time`=$time" );
							$sitemoney = $adoptmoeny * $weixin_fenceng_answersite;
							$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "paylog SET type='paysite_xuanshang',typeid=$qid,money=$sitemoney,openid='',fromuid=$quid,touid=$touid,`time`=$time" );
						}
					}
					$this->load->model ( 'depositmoney_model' );
					$this->depositmoney_model->update ( $quid, 'qid', $question ['id'] );
					$model = $this->depositmoney_model->get ( $quid, 'eqid', $question ['id'] );
					if ($model != null) {
						if ($model ['touid'] != $touid) {
							// 先判断行家是否回答问题
							$answer = $this->answer_model->getanswerbyuid ( $touid, $question ['id'] );
							if (! $answer) {
								// 如果回答被采纳，并且回答者不是行家，那么就删除行家提问金额
								$this->depositmoney_model->remove ( $quid, 'eqid', $question ['id'] ); // 删除托管记录
							}
						} else {
						}
					}
					$this->question_model->update_status ( $qid, 9 );
				}
				// 其它普通回答
				if ($question ['shangjin'] == 0) {
					$overdue_days = intval ( $this->setting ['overdue_days'] );
					$endtime = time () + $overdue_days * 86400;
					$adoptime = time ();
					// 先判断是否已经有采纳回答
					$adoptanswer = $this->db->query ( "SELECT id,qid,supports FROM " . $this->db->dbprefix . "answer WHERE qid='$qid' and adopttime>0 order by supports desc " )->row_array ();
					if (! $adoptanswer) {
						$answer = $this->db->query ( "SELECT id,qid,supports FROM " . $this->db->dbprefix . "answer WHERE qid='$qid' order by supports desc " )->row_array ();
						if ($answer) {
							$aid = $answer ['id'];
							$this->db->query ( "UPDATE `" . $this->db->dbprefix . "question` set status=2, `endtime`=$endtime WHERE status=1 AND answers>0 AND `id`=$qid" );
							$this->db->query ( "UPDATE `" . $this->db->dbprefix . "answer` SET `adopttime`=$adoptime WHERE `id`=$aid" );
						}
					}
				}
			}
			
			$this->message ( '问题状态设置成功!' );
			exit ();
		}
	}
	// 编辑回答内容
	function editanswercont() {
		if (null !== $this->input->post ( 'content' )) {
			$content = trim ( $this->input->post ( 'content' ) );
			if ('' == $content) {
				$this->searchanswer ( '回答内容不能为空!', 'errormsg' );
				exit ();
			}
			$this->answer_model->update_content ( intval ( $this->input->post ( 'aid' ) ), $content );
			$this->searchanswer ( '回答内容修改成功!' );
		}
	}
	
	// 删除回答
	function deleteanswer() {
		if (null !== $this->input->post ( 'aid' )) {
			$aids = implode ( ",", $this->input->post ( 'aid' ) );
			if (is_array ( $this->input->post ( 'aid' ) )) {
				foreach ( $this->input->post ( 'aid' ) as $aid ) {
					$answer = $this->answer_model->get ( $aid );
					// 删除回答问题，扣减积分
					$uid = $answer ['authorid'];
					$touser = $this->user_model->get_by_uid ( $uid );
					$koujiancredit1 = intval ( $this->setting ['credit1_answer'] );
					if ($touser ['credit1'] < $koujiancredit1) {
						$koujiancredit1 = $touser ['credit1'] >= 0 ? $touser ['credit1'] : 0;
					}
					
					$koujiancredit2 = intval ( $this->setting ['credit2_answer'] );
					if ($touser ['credit2'] < $koujiancredit2) {
						$koujiancredit2 = $touser ['credit2'] >= 0 ? $touser ['credit2'] : 0;
					}
					
					$this->credit ( $uid, - $koujiancredit1, - $koujiancredit2, 0, 'delanswer' );
				}
			} else {
				$aid = $this->input->post ( 'aid' );
				$answer = $this->answer_model->get ( $aid );
				// 删除回答问题，扣减积分
				$uid = $answer ['authorid'];
				$touser = $this->user_model->get_by_uid ( $uid );
				$koujiancredit1 = intval ( $this->setting ['credit1_answer'] );
				if ($touser ['credit1'] < $koujiancredit1) {
					$koujiancredit1 = $touser ['credit1'] >= 0 ? $touser ['credit1'] : 0;
				}
				
				$koujiancredit2 = intval ( $this->setting ['credit2_answer'] );
				if ($touser ['credit2'] < $koujiancredit2) {
					$koujiancredit2 = $touser ['credit2'] >= 0 ? $touser ['credit2'] : 0;
				}
				
				$this->credit ( $uid, - $koujiancredit1, - $koujiancredit2, 0, 'delanswer' );
			}
			$this->answer_model->remove ( $aids );
			$this->message ( '删除回答成功!', "admin_question/examineanswer" );
			exit ();
		}
	}
	function addtotopic() {
		$this->load->model ( "topic_model" );
		if (null !== $this->input->post ( 'qids' )) {
			$this->topic_model->addtotopic ( $this->input->post ( 'qids' ), $this->input->post ( 'topiclist' ) );
			$this->searchquestion ( '专题添加成功!' );
		}
	}
	
	/* 问题审核 */
	function examine($msg = '', $ty = '') {
		$msg && $message = $msg;
		$ty && $type = $ty;
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 20;
		$startindex = ($page - 1) * $pagesize;
		$questionlist = $this->question_model->list_by_search ( 0, 0, 0, 0, 0, 0, $startindex, $pagesize );
		$rownum = $this->question_model->rownum_by_search ( 0, 0, 0, 0, 0 );
		$departstr = page ( $rownum, $pagesize, $page, "admin_question/examine" );
		include template ( "verifyquestions", "admin" );
	}
	
	/* 回答审核 */
	function examineanswer($msg = '', $ty = '') {
		$msg && $message = $msg;
		$ty && $type = $ty;
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 20;
		$startindex = ($page - 1) * $pagesize;
		$answerlist = $this->answer_model->list_by_condition ( '`status`=0', $startindex, $pagesize );
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'answer', ' `status`=0', $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "admin_question/examineanswer" );
		include template ( "verifyanswers", "admin" );
	}
	function makeindex() {
		$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 1000;
		$startindex = ($page - 1) * $pagesize;
		ignore_user_abort ();
		set_time_limit ( 0 );
		$this->question_model->makeindex ( $startindex, $pagesize );
		echo 'ok';
		exit ();
	}
}

?>