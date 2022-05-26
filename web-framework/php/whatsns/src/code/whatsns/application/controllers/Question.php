<?php
/**
 
 * 问题控制器
 
 * @date: 2018年7月5日 下午6:07:55
 
 * @author: 61703
 
 */
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

// 0、未审核 1、待解决、2、已解决 4、悬赏的 9、 已关闭问题
class Question extends CI_Controller {
	private $serach_num = '';
	var $whitelist;
	function __construct() {
		$this->whitelist = "invatebysearch,invatemyattention,loadinavterbyanswerincid,cancelinvateuseranswer,getinvatelist,invateuseranswer,delete,loadinvateuser,postmedia,voice,postanswerreward,deleteanswer";
		parent::__construct ();
		$this->load->model ( "question_model" );
		$this->load->model ( "category_model" );
		$this->load->model ( "answer_model" );
		$this->load->model ( "expert_model" );
		$this->load->model ( "tag_model" );
		$this->load->model ( "topic_tag_model" );
		$this->load->model ( "user_model" );
		$this->load->model ( "userlog_model" );
		$this->load->model ( "doing_model" );
		$this->load->model ( "topic_model" );
		$this->serach_num = isset ( $this->setting ['search_shownum'] ) ? $this->setting ['search_shownum'] : '5';
	}
	/* 付费偷看 */
	function ajaxviewanswer() {
		$answerid = intval ( $this->uri->segment ( 3 ) );
		
		$answer = $this->answer_model->get ( $answerid );
		if ($answer ['reward'] == 0)
			exit ( '-1' );
		

		$isvip = false;
		
		$lastviewnum = 0;

		include template ( "viewanswer" );
	}
	function postanswerreward() {
		$answerid = intval ( $this->input->post ( 'answerid' ) );
		$answer = $this->answer_model->get ( $answerid );
		// 用户没登录
		if ($this->user ['uid'] == 0)
			exit ( '-2' );
		
		// 此问题不需要付费
		if ($answer ['reward'] == 0)
			exit ( '-1' );
		$qid = $answer ['qid'];
		$quid = $this->user ['uid'];
		$this->load->model ( 'paylog_model' );
		$one = $this->paylog_model->selectbyfromuid ( $quid, $answerid );
		
		if ($one != null) {
			// 已经付费过了
			exit ( '2' );
		}

		$isvip = false;
		
		$lastviewnum = 0;

		
		$jine = $this->user ['jine'] / 100;
		if ($jine < $answer ['reward']) {
			// 用户余额不足
			exit ( '0' );
		}
		
		$time = time ();
		$needpay = $answer ['reward'];
		$quid = $this->user ['uid'];
		$touid = $answer ['authorid'];
		$cash_fee = $needpay * 100;
		
		// 获取回答的问题
		$question = $this->question_model->get ( $qid );
		// 获取提问者
		$q_authorid = $question ['authorid'];
		// 获取付费偷看相关配置
		$weixin_fenceng_toutingpingtai = doubleval ( $this->setting ['weixin_fenceng_toutingpingtai'] ); // 偷听平台分成
		$weixin_fenceng_toutingtiwen = doubleval ( $this->setting ['weixin_fenceng_toutingtiwen'] ); // 偷听提问者分成
		$weixin_fenceng_toutinghuida = doubleval ( $this->setting ['weixin_fenceng_toutinghuida'] ); // 偷听回答者分成
		
		$pingtaicash_fee = $cash_fee * $weixin_fenceng_toutingpingtai; // 总费用*平台抽成 单位分
		$tiwencash_fee = $cash_fee * $weixin_fenceng_toutingtiwen; // 总费用*提问者抽成 单位分
		$huidacash_fee = $cash_fee * $weixin_fenceng_toutinghuida; // 总费用*回答者抽成 单位分
		                                                           
		// 平台抽成
		$needpingtaincash_fee = $needpay * $weixin_fenceng_toutingpingtai; // 单位元
		                                                                   // 提问者抽成
		$needtiwencash_fee = $needpay * $weixin_fenceng_toutingtiwen; // 单位元
		                                                              // 回答者抽成
		$needhuidacash_fee = $needpay * $weixin_fenceng_toutinghuida; // 单位元
		                                                              // 回答者账户钱包增加金额
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET  `jine`=jine+'$huidacash_fee' WHERE `uid`=$touid" );
		// 提问者账户钱包增加金额
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET  `jine`=jine+'$tiwencash_fee' WHERE `uid`=$q_authorid" );
		
		// 偷看的人钱包减钱
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET  `jine`=jine-'$cash_fee' WHERE `uid`=$quid" );
		// 插入支付日志表
		$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "paylog SET type='myviewaid',typeid=$answerid,money=$needpay,openid='',fromuid=$touid,touid=$quid,`time`=$time" );
		
		// 抽成给回答者插入支付日志表
		$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "paylog SET type='viewaid',typeid=$answerid,money=$needhuidacash_fee,openid='',fromuid=$quid,touid=$touid,`time`=$time" );
		// 抽成给提问者插入支付日志表
		$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "paylog SET type='viewaid',typeid=$answerid,money=$needtiwencash_fee,openid='',fromuid=$quid,touid=$q_authorid,`time`=$time" );
		$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "paylog SET type='paysite_toukan',typeid=$answerid,money=$needpingtaincash_fee,openid='',fromuid=$quid,touid=$touid,`time`=$time" );
		// 极光推送
		$url = url ( "question/view/$qid" );
		jpushmsg ( "您的回答有人偷看了", $answer ['authorid'], "回答被偷看", $url );
		// 偷看成功
		exit ( '1' );
	}
	/* 提交回答 */
	function ajaxanswer() {
		$message = array ();
		// 只允许专家回答问题
		if (isset ( $this->setting ['allow_expert'] ) && $this->setting ['allow_expert'] && ! $this->user ['expert']) {
			
			$message ['message'] = '站点已设置为只允许专家回答问题，如有疑问请联系站长.';
			echo json_encode ( $message );
			exit ();
		}
		if ($this->user ['uid'] == 0) {
			
			$message ['message'] = '游客先登录在回答！';
			echo json_encode ( $message );
			exit ();
		}
		// $this->check_apikey ();
		// 判断是否有权限回答
		$regulars = explode ( ',', $this->user ['regulars'] );
		if (! in_array ( 'question/answer', $regulars ) && $this->user ['groupid'] != 1) {
			$message ['message'] = '你目前的等级没有权限回答问题.';
			echo json_encode ( $message );
			exit ();
		}
		$qid = $this->input->post ( 'qid' );
		
		$question = $this->question_model->get ( $qid );
		if (! $question) {
			
			$message ['message'] = '提交回答失败,问题不存在!';
			echo json_encode ( $message );
			exit ();
		}
		// 对于一对一邀请专家问题，判断是否开启只允许一对一邀请专家回答
		if ($question ['askuid'] > 0 && isset ( $this->setting ['question_expert_answerlimit'] ) && $this->setting ['question_expert_answerlimit'] == 1) {
			if ($question ['askuid'] != $this->user ['uid']) {
				$message ['message'] = '一对一咨询需邀请人才能回答!';
				echo json_encode ( $message );
				exit ();
			}
		}
		// 悬赏问题如果被采纳就禁止编辑
		if ($question ['shangjin'] > 0 && $question ['status'] == 2 || $question ['shangjin'] > 0 && $question ['status'] == 9) {
			$message ['message'] = "悬赏问题已经被解决，无法在继续回答!";
			echo json_encode ( $message );
			exit ();
		}
		
		if ($question ['shangjin'] > 0) {
			// 判断悬赏问题回答个数是否大于最大数
			if (! isset ( $this->setting ['xuanshang_question_answers'] ) || ! $this->setting ['xuanshang_question_answers']) {
				$this->setting ['xuanshang_question_answers'] = 0;
			}
			// 判断问题是否有悬赏且有回答
			$answerconut = $this->db->query ( "select count(id) as num from " . $this->db->dbprefix . "answer where qid=$qid" )->row_array ();
			
			$maxxuanshanganswer = intval ( $this->setting ['xuanshang_question_answers'] );
			if ($maxxuanshanganswer != 0 && $maxxuanshanganswer > 0 && $answerconut ['num'] >= $maxxuanshanganswer) {
				$message ['message'] = '已超过平台设置悬赏问题最大回答人数，不允许继续回答!';
				echo json_encode ( $message );
				exit ();
			}
		}
		if ($this->setting ['cananswerselfquestion'] == 0 && $this->user ['uid'] == $question ['authorid']) {
			$message ['message'] = '平台设置不允许自己回答自己问题!';
			echo json_encode ( $message );
			exit ();
		}
		
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		
		if (isset ( $this->setting ['code_ask'] ) && $this->setting ['code_ask'] == '1' && $this->user ['credit1'] < $this->setting ['jingyan'] && $this->user ['grouptype'] != 1) {
			if (strtolower ( trim ( $this->input->post ( 'code' ) ) ) != $this->user_model->get_code ()) {
				
				$message ['message'] = "验证码错误!";
				echo json_encode ( $message );
				exit ();
			}
		}
		
		if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1') {
			if ($this->user ['active'] != 1 && $this->user ['groupid'] != 1) {
				
				$message ['message'] = "必须激活邮箱才能回复!";
				echo json_encode ( $message );
				exit ();
			}
		}

		$already = $this->question_model->already ( $qid, $this->user ['uid'] );
		
		if ($already) {
			$message ['message'] = '不能重复回答同一个问题，可以修改自己的回答！';
			echo json_encode ( $message );
			exit ();
			
			//
		}
		// 老子故意让你这种发广告的验证完所有信息，最后告诉你丫的进入网站黑名单不能回答
		if ($this->user ['isblack'] == 1) {
			
			$message ['message'] = "黑名单用户无法回答问题!";
			echo json_encode ( $message );
			exit ();
		}
		
		$title = $this->input->post ( 'title' );
		$chakanjine = doubleval ( $this->input->post ( 'chakanjine' ) );
		
		$content = $this->input->post ( 'content' );
		$content = str_replace ( "&lt;video", "<video ", $content );
		$content = str_replace ( "&gt;&lt;/video&gt;", "</video> ", $content );
		// 检查审核和内容外部URL过滤
		$status = intval ( 2 != (2 & $this->setting ['verify_question']) );
		$allow = $this->setting ['allow_outer'];
		if (3 != $allow && has_outer ( $content )) {
			
			if (0 == $allow) {
				$message ['message'] = '内容包含外部链接，发布失败!';
				echo json_encode ( $message );
				exit ();
			}
			1 == $allow && $status = 0;
			2 == $allow && $content = filter_outer ( $content );
		}
		// 检查违禁词
		$contentarray = checkwords ( $content );
		1 == $contentarray [0] && $status = 0;
		
		if (2 == $contentarray [0]) {
			$message ['message'] = '内容包含非法关键词，发布失败!';
			echo json_encode ( $message );
			exit ();
		}
		$content = $contentarray [1];
		
		/* 检查提问数是否超过组设置 */
		if ($this->user ['answerlimits'] && ($this->userlog_model->rownum_by_time ( 'answer' ) >= $this->user ['answerlimits'])) {
			
			$message ['message'] = "你已超过每小时最大回答数" . $this->user ['answerlimits'] . ',请稍后再试！';
			echo json_encode ( $message );
			exit ();
		}
		
		$content_temp = str_replace ( '<p>', '', $content );
		$content_temp = str_replace ( '</p>', '', $content_temp );
		$content_temp = str_replace ( '&nbsp;', '', $content_temp );
		$content_temp = preg_replace ( "/\s+/", '', $content_temp );
		$content_temp = preg_replace ( '/s(?=s)/', '', $content_temp );
		$content_temp = trim ( $content_temp );
		if (strip_tags ( trim ( $content_temp ) ) == '') {
			
			$message ['message'] = '回答不能为空！';
			echo json_encode ( $message );
			exit ();
		}
		if ($this->user ['groupid'] == 1) {
			$status = 2;
		}
		
		$viewurl = urlmap ( 'question/view/' . $qid, 2 );
		if ($chakanjine > 0) {
			$tmp = strip_tags ( $content_temp );
			if (mb_strlen ( $tmp ) < 20) {
				$message ['message'] = '付费偷看设置内容需不低于20个字！';
				echo json_encode ( $message );
				exit ();
			}
		}
		
		$this->answer_model->add ( $qid, $title, $content, $status, $chakanjine );
		
		// 回答问题，添加积分
		$this->credit ( $this->user ['uid'], $this->setting ['credit1_answer'], $this->setting ['credit2_answer'] );
		// 如果设置回答问题自动关注问题那么就添加关注问题
		if ($this->user ['notify'] ['follow_after_answer'] == 1) {
			$this->user_model->follow ( $qid, $this->user ['uid'], $this->user ['username'] );
		}
		$emails = array ();
		// 推送新回答通知给所有关注者
		$followerlist = $this->question_model->get_follower ( $qid );
		foreach ( $followerlist as $follower ) {
			// 获取回答者通知情况
			$quser = $this->user_model->get_by_uid ( $follower ['followerid'] );
			
			if ($quser ['fromsite'] != 1 && $quser ['notify'] ['answer'] == 1 && $quser ['uid'] != $this->user ['uid']) {
				
				array_push ( $emails, $quser ['email'] );
			}
		}
		
		// 如果关注者接受回答邮件提醒就发送邮件
		$subject = "您关注的问题[" . $title . "]有新回答！";
		$mymessage = $content . '<p>现在您可以点击<a swaped="true" target="_blank" href="' . url ( 'question/view/' . $qid ) . '">查看最新回复</a>。</p>';
		$status && sendmutiemail ( $emails, $subject, $mymessage );
		
		// 如果是行家回答并且对行家提问就自动给行家转钱
		$this->load->model ( 'depositmoney_model' );
		$touid = $this->user ['uid'];
		$quid = $question ['authorid'];
		// 提问悬赏金额
		$cash_fee = doubleval ( $question ['shangjin'] ) * 100; // 单位分
		$adoptmoeny = $question ['shangjin']; // 提问悬赏金额 单位元
		                                      // 最佳答案平台分成
		$weixin_fenceng_zuijia = doubleval ( $this->setting ['weixin_fenceng_zuijia'] );
		// 行家解答平台分成
		$weixin_fenceng_hangjia = doubleval ( $this->setting ['weixin_fenceng_hangjia'] );
		// 最终给用户悬赏金额
		$finalcash_fee = $cash_fee - $cash_fee * $weixin_fenceng_zuijia;
		$finaladoptmoeny = $adoptmoeny - $adoptmoeny * $weixin_fenceng_zuijia;
		$time = time ();
		$model = $this->depositmoney_model->get ( $quid, 'eqid', $question ['id'] );
		if ($model != null) {
			if ($model ['touid'] == $touid) {
				$cash_fee = doubleval ( $model ['needpay'] ) * 100;
				$needpay = $model ['needpay'];
				$this->depositmoney_model->update ( $quid, 'eqid', $question ['id'] );
				// 最终行家能获得金额=对行家付费提问金额-平台对行家抽成金额
				$finalcash_fee = $cash_fee - $cash_fee * $weixin_fenceng_hangjia;
				$finalneedpay = $needpay - $needpay * $weixin_fenceng_hangjia;
				$finalneedpingtaipay = $needpay * $weixin_fenceng_hangjia;
				$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET  `jine`=jine+'$finalcash_fee' WHERE `uid`=$touid" );
				// 如果专家回答了问题，记录获奖记录
				
				$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "paylog SET type='paysite_zhuanjia',typeid=$qid,money=$finalneedpingtaipay,openid='',fromuid=$quid,touid=$touid,`time`=$time" );
				$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "paylog SET type='eqid',typeid=$qid,money=$finalneedpay,openid='',fromuid=$quid,touid=$touid,`time`=$time" );
			} else {
			}
		}
		
		// 回答的时候如果在微信里，就微信推送通知
		$url = url ( 'question/view/' . $qid );
		$text = "您的提问[$title]有新的回答，<a href='$url'>请点击查看详情!</a>";
		$quser = $this->user_model->get_by_uid ( $question ['authorid'] );
		$wx = $this->fromcache ( 'cweixin' );
	
		$this->load->model ( "message_model" );
		$this->message_model->add ( $this->user ['username'], $this->user ['uid'], $question ['authorid'], "您的提问[$title]有新的回答", $this->user ['username'] . '对您的提问进行了回答,' . "<a href='$url'>请点击查看详情!</a>", 'answer' );
		


		$this->userlog_model->add ( 'answer' );
		$this->doing_model->add ( $this->user ['uid'], $this->user ['username'], 2, $qid, $content );
		if (0 == $status) {
			$message ['message'] = '回答发布成功！为了确保问答的质量，我们会对您的回答内容进行审核。请耐心等待......';
			echo json_encode ( $message );
			exit ();
		} else {
			$message ['emal'] = '1';
			$message ['message'] = '回答发布成功';
			echo json_encode ( $message );
			exit ();
		}
	}
	/* 提交问题 */
	function add() {
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		
		$iswxbrower = false;
		if (strstr ( $useragent, 'MicroMessenger' )) {
			$iswxbrower = true;
		} else {
			if ($this->user ['uid'] == 0) {
				header ( "Location:" . url ( 'user/login' ) );
			}
		}
		$navtitle = "提出问题";
		
		
		if (0 == $this->user ['uid']) {
			$this->setting ["ucenter_open"] && $this->message ( "UCenter开启后游客不能提问!", 'BACK' );
		}
		$categoryjs = $this->category_model->get_js ( 0, 1 );
		
		$askfromuid = intval ( $this->uri->segment ( 3 ) );
		if ($askfromuid) {
			
			$touser = $this->user_model->get_by_uid ( $askfromuid );
			
			if ($touser ['uid'] == $this->user ['uid']) {
				$this->message ( "不能对自己提问!", 'BACK' );
			}
		} else {
			
			// $_SESSION["asksid"]= '==========='.getRandChar(56);
		}
		
		if (is_mobile ()) {
			$catetree = $this->category_model->get_categrory_tree ( 1 );
		}
		
		if (! isset ( $_SESSION )) {
			session_start ();
		}
		$_SESSION ['addquestiontoken'] = md5 ( time () );
		include template ( 'ask' );
	}
	function ajaxgetcat() {
		$msg = array ();
		if (intval ( $this->input->post ( 'category' ) )) {
			$cid = intval ( $this->input->post ( 'category' ) );
			$cid1 = 0;
			$cid2 = 0;
			$cid3 = 0;
			
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
				$msg ['message'] = 'error';
				echo json_encode ( $msg );
				exit ();
			}
			
			$msg ['message'] = 'ok';
			$msg ['cid'] = $cid;
			$msg ['cid1'] = $cid1;
			$msg ['cid2'] = $cid2;
			$msg ['cid3'] = $cid3;
			
			echo json_encode ( $msg );
			exit ();
		}
	}
	function ajaxchoosetag() {
		$_content = strip_tags ( $this->input->post ( 'content', FALSE ) );
		$data = dz_segment ( $_content );
		if ($data != false) {
			echo json_encode ( $data );
		} else {
			$message = array ();
			$message ['msg'] = "-1";
			
			echo json_encode ( $message );
		}
	}
	// 检查http请求的主机和请求的来路域名是否相同，不相同拒绝请求
	function check_apikey() {
		session_start ();
		if ($_SESSION ["answertoken"] == null || $this->input->post ( 'tokenkey' ) == null) {
			$message ['message'] = "非法操作!";
			echo json_encode ( $message );
			exit ();
		}
		if ($_SESSION ["answertoken"] != $this->input->post ( 'tokenkey' )) {
			$message ['message'] = "页面过期，请保存数据刷新页面在操作!";
			echo json_encode ( $message );
			exit ();
		}
	}
	// 检查http请求的主机和请求的来路域名是否相同，不相同拒绝请求
	function check_addquestionapikey() {
		session_start ();
		if ($_SESSION ["addquestiontoken"] == null || $this->input->post ( 'tokenkey' ) == null) {
			$message ['message'] = "非法操作!";
			echo json_encode ( $message );
			exit ();
		}
		if ($_SESSION ["addquestiontoken"] != $this->input->post ( 'tokenkey' )) {
			$message ['message'] = "页面过期，请保存数据刷新页面在操作!";
			echo json_encode ( $message );
			exit ();
		}
	}
	function ajaxquickadd() {
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		$iswxbrower = false;
		if (strstr ( $useragent, 'MicroMessenger' )) {
			$iswxbrower = true;
		}
		
		$message = array ();
		if ($this->user ['uid'] == 0) {
			
			$message ['message'] = '游客先登录在回答！';
			echo json_encode ( $message );
			exit ();
		}
		
		if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1') {
			if ($this->user ['active'] != 1) {
				$viewhref = urlmap ( 'user/editemail', 1 );
				
				$message ['message'] = "必须激活邮箱才能提问!";
				echo json_encode ( $message );
				exit ();
			}
		}
		
		// if (! $iswxbrower) {
		// if (isset ( $this->setting ['code_ask'] ) && $this->setting ['code_ask'] == '1' && $this->user ['credit1'] < $this->setting ['jingyan']) {
		// if (strtolower ( trim ( $this->input->post ( 'code' ) ) ) != $this->user_model->get_code ()) {
		//
		// $message ['message'] = "验证码错误!";
		// echo json_encode ( $message );
		// exit ();
		// }
		// }
		// }
		
		// 老子故意让你这种发广告的验证完所有信息，最后告诉你丫的进入网站黑名单不能提问
		if ($this->user ['isblack'] == 1) {
			
			$message ['message'] = "黑名单用户无法发布问题!";
			echo json_encode ( $message );
			exit ();
		}
		
		$title = strip_tags ( htmlspecialchars ( $this->input->post ( 'quicktitle' ) ) );
		if ($title == '') {
			
			$message ['message'] = "标题不能为空!";
			echo json_encode ( $message );
			exit ();
		}
		if ($this->setting ['canrepeatquestion'] != 1) {
			$q = $this->question_model->get_by_title ( htmlspecialchars ( $title ) );
			if ($q != null) {
				$viewurl = urlmap ( 'question/view/' . $q ['id'], 2 );
				
				$mpurl = SITE_URL . $this->setting ['seo_prefix'] . $viewurl . $this->setting ['seo_suffix'];
				$message ['url'] = "$mpurl";
				$message ['message'] = "已有同样问题存在!";
				echo json_encode ( $message );
				exit ();
			}
		}
		if (strlen ( $title ) > 240) {
			$message ['message'] = "标题不能超过80个字!";
			echo json_encode ( $message );
			exit ();
		}
		$description = '';
		
		$cid1 = intval ( $this->input->post ( 'quickcid' ) ); // isset ( $this->category [1] ) ? $this->category [1] ['id'] : $this->category [2] ['id'];
		$cid2 = 0;
		$cid3 = 0;
		$cid = $cid1;
		if ($cid == 0) {
			$message ['message'] = "请选择分类";
			echo json_encode ( $message );
			exit ();
		}
		$hidanswer = 0;
		$price = 0;
		$jine = 0;
		$needpay = 0;
		
		$askfromuid = $_POST ['askfromuid'] ? intval ( $_POST ['askfromuid'] ) : 0;
		if ($askfromuid) {
			
			// 获取提问人信息
			$fromuser = $this->user_model->get_by_uid ( $askfromuid );
			// 获取付费提问金额
			$needpay = $fromuser ['mypay'];
			if ($needpay > 0) {
				$currentuser = $this->user_model->get_by_uid ( $this->user ['uid'] );
				
				// 判断用户余额是否足够支付
				$useryue = $currentuser ['jine'] / 100;
				if ($useryue >= $needpay) {
				} else {
					// 余额不足
					$message ['message'] = "您账户余额" . $useryue . "元,需付费" . $needpay . "元咨询";
					echo json_encode ( $message );
					exit ();
				}
			}
		}
		
		$offerscore = $price;
		
		$shangjin = $jine;
		
		if ($hidanswer == 1) {
			if (intval ( $this->user ['credit2'] ) < $offerscore) {
				
				$message ['message'] = "匿名发布财富值不够!匿名时会多消耗10财富值";
				echo json_encode ( $message );
				exit ();
			}
		} else {
			if (intval ( $this->user ['credit2'] ) < $offerscore) {
				
				$message ['message'] = "财富值不够!";
				echo json_encode ( $message );
				exit ();
			}
		}
		// 检查审核和内容外部URL过滤
		$status = intval ( 1 != (1 & $this->setting ['verify_question']) );
		$allow = $this->setting ['allow_outer'];
		if (3 != $allow && has_outer ( $description )) {
			if (0 == $allow) {
				
				$message ['message'] = "内容包含外部链接，发布失败!";
				echo json_encode ( $message );
				exit ();
			}
			1 == $allow && $status = 0;
			2 == $allow && $description = filter_outer ( $description );
		}
		// 检查标题违禁词
		$contentarray = checkwords ( $title );
		1 == $contentarray [0] && $status = 0;
		if (2 == $contentarray [0]) {
			
			$message ['message'] = "问题包含非法关键词，发布失败!";
			echo json_encode ( $message );
			exit ();
		}
		$title = $contentarray [1];
		
		// 检查问题描述违禁词
		$descarray = checkwords ( $description );
		1 == $descarray [0] && $status = 0;
		if (2 == $descarray [0]) {
			
			$message ['message'] = "问题描述包含非法关键词，发布失败!";
			echo json_encode ( $message );
			exit ();
		}
		$description = $descarray [1];
		
		/* 检查提问数是否超过组设置 */
		if ($this->user ['questionlimits'] && ($this->userlog_model->rownum_by_time ( 'ask' ) >= $this->user ['questionlimits'])) {
			
			$message ['message'] = "你已超过每小时最大提问数" . $this->user ['questionlimits'] . ',请稍后再试！';
			echo json_encode ( $message );
			exit ();
		}
		
		if ($this->user ['groupid'] == 1) {
			$status = 1;
		}
		$qid = $this->question_model->add ( strip_tags ( $title ), $description, $hidanswer, $price, $cid, $cid1, $cid2, $cid3, $status, $shangjin, $askfromuid );
		if ($qid > 0) {
			$this->load->model ( 'depositmoney_model' );
			$uid = $this->user ['uid'];
			if (isset ( $fromuser ['mypay'] )) {
			} else {
				$fromuser ['mypay'] = 0;
			}
			$neemayzhuanjia = $fromuser ['mypay'] * 100;
			if ($askfromuid) {
				$id = $this->depositmoney_model->add ( $this->user ['uid'], $fromuser ['mypay'], 'eqid', $qid, $fromuser ['uid'] );
				if ($id > 0) {
					$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET  `jine`=jine-'$neemayzhuanjia' WHERE `uid`=$uid" );
					$xsmoney = $fromuser ['mypay'];
					$time = time ();
					$fromuid = $fromuser ['uid']; // 专家uid
					$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "paylog SET type='fufeitiwen',typeid=$qid,money=$xsmoney,openid='',fromuid=$fromuid,touid=$uid,`time`=$time" );
					// 极光推送
					$url = url ( "question/view/$qid" );
					jpushmsg ( "有人付费对您咨询", $fromuid, "付费咨询", $url );
				}
				
				/* 如果是向别人提问，则需要发个消息给别人 */
				
				// 插入邀请
				$data = array (
						'qid' => $qid,
						'uid' => $askfromuid,
						'cid' => $cid,
						'invateuid' => $this->user ['uid'],
						'invatetime' => time () 
				);
				$id = $this->db->insert ( 'user_invateanswer', $data );
				
				$this->load->model ( "message_model" );
				$question_url = url ( "question/view/$qid" );
				$username = addslashes ( $this->user ['username'] );
				$this->message_model->add ( $username, $this->user ['uid'], $fromuser ['uid'], '问题求助:' . $title, $description . '<br /> <a href="' . $question_url . '">点击查看问题</a>', 'questiontouser' );
		
				if (isset ( $this->setting ['notify_mail'] ) && $this->setting ['notify_mail'] == '1' && $fromuser ['active'] == 1) {
					sendmail ( $fromuser, '问题求助:' . $title, $description . '<br /> <a href="' . $question_url . '">点击查看问题</a>' );
				}
			}
		}
		$tags = trim ( $this->input->post ( 'quicktags' ), ',' );
		if ($tags != '' && $tags != null) {
			$taglist = explode ( ",", $tags );
			$taglist && $this->tag_model->multi_addquestion ( array_unique ( $taglist ), $qid, $cid, $this->user ['uid'] );
		}
		$this->user_model->follow ( $qid, $this->user ['uid'], $this->user ['username'] );
		
		// 增加用户积分，扣除用户悬赏的财富
		if ($this->user ['uid']) {
			$this->credit ( $this->user ['uid'], 0, - $offerscore, 0, 'offer' );
			$this->credit ( $this->user ['uid'], $this->setting ['credit1_ask'], $this->setting ['credit2_ask'] );
		}
		$viewurl = urlmap ( 'question/view/' . $qid, 2 );
		
		$this->userlog_model->add ( 'ask' );
		$this->doing_model->add ( $this->user ['uid'], $this->user ['username'], 1, $qid, $description );
		// 如果ucenter开启，则postfeed
		if ($this->setting ["ucenter_open"] && $this->setting ["ucenter_ask"]) {
			$this->load->model ( 'ucenter_model' );
			$this->ucenter_model->ask_feed ( $qid, $title, $description );
		}
		
		if (0 == $status) {
			
			$message ['url'] = url ( $viewurl );
			$message ['sh'] = 1;
			$message ['message'] = 'ok';
			echo json_encode ( $message );
			exit ();
		} else {
			
			if (isset ( $_SESSION ["asksid"] )) {
				unset ( $_SESSION ["asksid"] );
			}
			$message ['url'] = url ( $viewurl );
			$message ['message'] = "ok";
			
			echo json_encode ( $message );
			exit ();
		}
	}
	function ajaxadd() {
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		
		$iswxbrower = false;
		if (strstr ( $useragent, 'MicroMessenger' )) {
			$iswxbrower = true;
		}
		
		$message = array ();
		if ($this->user ['uid'] == 0) {
			
			$message ['message'] = '游客先登录在回答！';
			echo json_encode ( $message );
			exit ();
		}
		$this->check_addquestionapikey ();
		if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1') {
			if ($this->user ['active'] != 1) {
				$viewhref = urlmap ( 'user/editemail', 1 );
				$message ['message'] = "必须激活邮箱才能提问!";
				echo json_encode ( $message );
				exit ();
			}
		}
		
		if (! $iswxbrower) {
			if (isset ( $this->setting ['code_ask'] ) && $this->setting ['code_ask'] == '1' && $this->user ['credit1'] < $this->setting ['jingyan']) {
				if (strtolower ( trim ( $this->input->post ( 'code' ) ) ) != $this->user_model->get_code ()) {
					
					$message ['message'] = "验证码错误!";
					echo json_encode ( $message );
					exit ();
				}
			}
		}
		
		// 老子故意让你这种发广告的验证完所有信息，最后告诉你丫的进入网站黑名单不能提问
		if ($this->user ['isblack'] == 1) {
			
			$message ['message'] = "黑名单用户无法发布问题!";
			echo json_encode ( $message );
			exit ();
		}
		
		$title = htmlspecialchars ( $this->input->post ( 'title' ) );
		if ($title == '') {
			
			$message ['message'] = "标题不能为空!";
			echo json_encode ( $message );
			exit ();
		}
		if ($this->setting ['canrepeatquestion'] != 1) {
			$q = $this->question_model->get_by_title ( htmlspecialchars ( $title ) );
			if ($q != null) {
				$viewurl = urlmap ( 'question/view/' . $q ['id'], 2 );
				
				$mpurl = SITE_URL . $this->setting ['seo_prefix'] . $viewurl . $this->setting ['seo_suffix'];
				$message ['url'] = "$mpurl";
				$message ['message'] = "已有同样问题存在!";
				echo json_encode ( $message );
				exit ();
			}
		}
		$description = $this->input->post ( 'description' );
		$description = str_replace ( "&lt;video", "<video ", $description );
		$description = str_replace ( "&gt;&lt;/video&gt;", "</video> ", $description );
		$tags = trim ( $this->input->post ( 'tags' ), ',' );
		$cid1 = intval ( $this->input->post ( 'cid1' ) );
		$cid2 = intval ( $this->input->post ( 'cid2' ) );
		$cid3 = intval ( $this->input->post ( 'cid3' ) );
		$cid = intval ( $this->input->post ( 'cid' ) );
		if ($cid == 0) {
			$message ['message'] = "请选择分类";
			echo json_encode ( $message );
			exit ();
		}
		$hidanswer = intval ( $this->input->post ( 'hidanswer' ) ) ? 1 : 0;
		$price = abs ( $this->input->post ( 'givescore' ) );
		$jine = floatval ( $this->input->post ( 'jine' ) );
		$askfromuid = intval ( $this->input->post ( 'askfromuid' ) );
		$needpay = 0;
		if ($askfromuid != 0) {
			$touser = $this->user_model->get_by_uid ( $askfromuid );
			
			if (isset ( $touser ['uid'] )) {
				if ($touser ['uid'] == $this->user ['uid']) {
					
					$message ['message'] = "不能对自己提问!";
					echo json_encode ( $message );
					exit ();
				}
				if (isset ( $touser ['mypay'] )) {
					$needpay = doubleval ( $touser ['mypay'] );
				} else {
					$needpay = 0;
				}
			}
		}
		$offerscore = $price;
		($hidanswer) && $offerscore += 10;
		if ($jine == 0.1) {
			$message ['message'] = "太扣了，金额不能小于0.2元";
			echo json_encode ( $message );
			exit ();
		}
		if ($jine > 200) {
			$message ['message'] = "金额不能大于200";
			echo json_encode ( $message );
			exit ();
		}
		$tmjine = ($jine + $needpay) * 100;
		if ($this->user ['jine'] < $tmjine) {
			$message ['message'] = "您在平台账户钱包金额不够，请充值在提问";
			echo json_encode ( $message );
			exit ();
		}
		$shangjin = $jine;
		
		if ($hidanswer == 1) {
			if (intval ( $this->user ['credit2'] ) < $offerscore) {
				
				$message ['message'] = "匿名发布财富值不够!匿名时会多消耗10财富值";
				echo json_encode ( $message );
				exit ();
			}
		} else {
			if (intval ( $this->user ['credit2'] ) < $offerscore) {
				
				$message ['message'] = "财富值不够!";
				echo json_encode ( $message );
				exit ();
			}
		}
		// 检查审核和内容外部URL过滤
		$status = intval ( 1 != (1 & $this->setting ['verify_question']) );
		$allow = $this->setting ['allow_outer'];
		if (3 != $allow && has_outer ( $description )) {
			if (0 == $allow) {
				
				$message ['message'] = "内容包含外部链接，发布失败!";
				echo json_encode ( $message );
				exit ();
			}
			1 == $allow && $status = 0;
			2 == $allow && $description = filter_outer ( $description );
		}
		// 检查标题违禁词
		$contentarray = checkwords ( $title );
		1 == $contentarray [0] && $status = 0;
		if (2 == trim ( $contentarray [0] )) {
			
			$message ['message'] = "问题包含非法关键词，发布失败!";
			echo json_encode ( $message );
			exit ();
		}
		$title = $contentarray [1];
		// 检查问题描述违禁词
		$descarray = checkwords ( $description );
		1 == $descarray [0] && $status = 0;
		if (2 == $descarray [0]) {
			
			$message ['message'] = "问题描述包含非法关键词，发布失败!";
			echo json_encode ( $message );
			exit ();
		}
		$description = $descarray [1];
		
		/* 检查提问数是否超过组设置 */
		if ($this->user ['questionlimits'] && ($this->userlog_model->rownum_by_time ( 'ask' ) >= $this->user ['questionlimits'])) {
			
			$message ['message'] = "你已超过每小时最大提问数" . $this->user ['questionlimits'] . ',请稍后再试！';
			echo json_encode ( $message );
			exit ();
		}
		
		if ($this->user ['groupid'] == 1) {
			$status = 1;
		}
		
		$qid = $this->question_model->add ( $title, $description, $hidanswer, $price, $cid, $cid1, $cid2, $cid3, $status, $shangjin, $askfromuid );
		
		if ($tags != '' && $tags != null) {
			$taglist = explode ( ",", $tags );
			$taglist && $this->tag_model->multi_addquestion ( array_unique ( $taglist ), $qid, $cid, $this->user ['uid'] );
		}
		
		if ($hidanswer == 0) {
			$this->user_model->follow ( $qid, $this->user ['uid'], $this->user ['username'] );
		}
		// 增加用户积分，扣除用户悬赏的财富
		if ($this->user ['uid']) {
			$this->credit ( $this->user ['uid'], 0, - $offerscore, 0, 'offer' );
			$this->credit ( $this->user ['uid'], $this->setting ['credit1_ask'], $this->setting ['credit2_ask'] );
		}
		$viewurl = urlmap ( 'question/view/' . $qid, 2 );
		$question_url = url ( 'question/view/' . $qid );
		/* 如果是向别人提问，则需要发个消息给别人 */
		if ($askfromuid) {
			// 插入邀请
			$data = array (
					'qid' => $qid,
					'uid' => $askfromuid,
					'cid' => $cid,
					'invateuid' => $this->user ['uid'],
					'invatetime' => time () 
			);
			$id = $this->db->insert ( 'user_invateanswer', $data );
			
			$this->load->model ( "message_model" );
			
			$username = addslashes ( $this->user ['username'] );
			$this->message_model->add ( $username, $this->user ['uid'], $touser ['uid'], '问题求助:' . $title, $description . '<br /> <a href="' . $question_url . '">点击查看问题</a>', 'questiontouser' );
	
			if (isset ( $this->setting ['notify_mail'] ) && $this->setting ['notify_mail'] == '1' && $touser ['active'] == 1) {
				sendmail ( $touser, '问题求助:' . $title, $description . '<br /> <a href="' . $question_url . '">点击查看问题</a>' );
			}
		}
		$this->userlog_model->add ( 'ask' );
		
		// 如果ucenter开启，则postfeed
		if ($this->setting ["ucenter_open"] && $this->setting ["ucenter_ask"]) {
			$this->load->model ( 'ucenter_model' );
			$this->ucenter_model->ask_feed ( $qid, $title, $description );
		}
		
		if (0 == $status) {
			
			$message ['url'] = $question_url;
			$message ['sh'] = 1;
			$message ['message'] = 'ok';
			echo json_encode ( $message );
			exit ();
		} else {
			$this->doing_model->add ( $this->user ['uid'], $this->user ['username'], 1, $qid, $description );
			
			if (isset ( $_SESSION ["asksid"] )) {
				unset ( $_SESSION ["asksid"] );
			}
			
			$message ['url'] = $question_url;
			$message ['message'] = "ok";
			echo json_encode ( $message );
			exit ();
		}
	}
	function sendmessagetoexpert($cid) {
		$expertlist = $this->expert_model->getlist_by_cid ( $cid );
		
		return $expertlist;
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
	/**
	 *
	 * 函数用途描述
	 *
	 * @date: 2019年2月11日 下午5:49:59
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function answer() {
		$qid = intval ( $this->uri->rsegments [3] ); // 接收qid参数
		$aid = intval ( $this->uri->rsegments [4] ); // 接收aid参数
		
		$question = $this->question_model->get ( $qid );
		
		if (empty ( $question )) {
			show_404 ();
			exit ();
		}
		$useranswer = $this->answer_model->get ( $aid );
		if (empty ( $useranswer )) {
			show_404 ();
			exit ();
		}
		(0 == $question ['status']) && $this->message ( '问题正在审核中,请耐心等待！' );
		
		$useragent = $_SERVER ['HTTP_USER_AGENT'];

		$is_followed = $this->question_model->is_followed ( $qid, $this->user ['uid'] );
		
		$this->question_model->add_views ( $qid ); // 更新问题浏览次数
		$taglist = $this->tag_model->get_by_qid ( $qid );
		// 获取相关问题
		if ($taglist) {
			$tagstr = '';
			foreach ( $taglist as $tag ) {
				$tagstr .= $tag ['id'] . ",";
			}
			$tagstr = trim ( $tagstr, ',' );
			
			// 如果标签存在就取标签里的问题
			$topiclist = $this->tag_model->getlistbytagid ( $tagstr, 0, 8, 'article' );
		} else {
			$topiclist = $this->topic_model->get_bycatid ( $question ['cid'], 0, 8 );
		}
		
		$asktime = tdate ( $question ['time'] );
		$endtime = timeLength ( $question ['endtime'] - time () );
		$solvetime = tdate ( $question ['endtime'] );
		$supplylist = $this->question_model->get_supply ( $question ['id'] );
		// 获取相关问题
		if ($taglist) {
			$tagstr = '';
			foreach ( $taglist as $tag ) {
				$tagstr .= $tag ['id'] . ",";
			}
			$tagstr = trim ( $tagstr, ',' );
			
			// 如果标签存在就取标签里的问题
			$solvelist = $this->tag_model->getlistbytagid ( $tagstr, 0, 5, 'question' );
		} else {
			$solvelist = null; // $this->question_model->list_by_cfield_cvalue_status ( 'cid', $question ['cid'], 2 );
		}
		
		$expertlist = $this->expert_model->get_by_cid ( $question ['cid'] );
		
		$is_followedauthor = $this->user_model->is_followed ( $question ['authorid'], $this->user ['uid'] );
		
		// 获取问题回答
		$this->load->model ( 'paylog_model' );
		
		$user = $this->user_model->get_by_uid ( $useranswer ['authorid'] );
		$useranswer ['signature'] = $user ['signature'];
		$useranswer ['viewnum'] = $this->paylog_model->getviewanswersnum ( 'myviewaid', $useranswer ['id'] );
		$one = $this->paylog_model->selectbyfromuid ( $this->user ['uid'], $useranswer ['id'] );
		if ($one != null) {
			$useranswer ['canview'] = 1;
		} else {
			if ($this->user ['canfreereadansser'] == 1 || $this->user ['grouptype'] == 1) {
				$useranswer ['canview'] = 1;
			} else {
				$useranswer ['canview'] = 0;
			}
		}
		$tagkeystr = '';
		if ($taglist) {
			$tagkeystr = '';
			foreach ( $taglist as $tag ) {
				$tagkeystr .= $tag ['tagname'] . ",";
			}
		}
		$categoryjs = $this->category_model->get_js ( 0, 1 );
		$seo_title = $question ['title'] . "-" . $useranswer ['author'] . "的回答";
		$seo_description = clearhtml ( $useranswer ['content'] );
		$seo_keywords = $tagkeystr;
		/* 非悬赏问题过期处理,如果问题在过期时间后还没有被采纳则关闭问题 */
		if ($question ['shangjin'] <= 0 && $question ['endtime'] < time () && ($question ['status'] == 1 || $question ['status'] == 4)) {
			$question ['status'] = 9;
			$this->question_model->update_status ( $qid, 9 );
			$this->send ( $question ['authorid'], $question ['id'], 2 );
			// 重新刷新页面
			$currenturl = url ( "question/view/$qid" );
			header ( "Location:$currenturl" );
			exit ();
		}
		include template ( 'viewquestionanswer' );
	}
	/**
	 *
	 * 查看问题详情
	 *
	 * @date: 2019年2月11日 下午5:49:04
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function view() {
		$qid = intval ( $this->uri->rsegments [3] ); // 接收qid参数
		$question = $this->question_model->get ( $qid );
		
		if (empty ( $question )) {
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
		// 判断是否是悬赏问题且已被采纳
		if ($question ['shangjin'] > 0 && $question ['status'] == 2) {
			// 如果被采纳就关闭此问题不在增加新回答
			$this->question_model->update_status ( $qid, 9 );
			$question = $this->question_model->get ( $qid );
		}
		$cananswerthisquestion = true; // 默认允许回答问题
		                               // 如果是一对一咨询问题
		if ($question ['askuid'] > 0 && isset ( $this->setting ['question_expert_answerlimit'] ) && $this->setting ['question_expert_answerlimit'] == 1) {
			if ($question ['askuid'] != $this->user ['uid']) {
				$cananswerthisquestion = false; // 如果当前不是邀请本人不允许回答
			}
		}
		if ($question ['status'] == 9 || $question ['status'] == 0) {
			$cananswerthisquestion = false; // 审核状态和关闭状态不允许回答
		}
		if ($question ['shangjin'] > 0 && $question ['answers'] >= $this->setting ['xuanshang_question_answers'] && $this->setting ['xuanshang_question_answers'] != 0) {
			$cananswerthisquestion = false; // 回答数大于悬赏最大回答人数
		}
		$panneltype = "hidefixed";
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		
		
		$is_followed = $this->question_model->is_followed ( $qid, $this->user ['uid'] );
		
		$this->question_model->add_views ( $qid ); // 更新问题浏览次数
		$taglist = $this->tag_model->get_by_qid ( $qid );
		// 获取相关问题
		if ($taglist) {
			$tagstr = '';
			foreach ( $taglist as $tag ) {
				$tagstr .= $tag ['id'] . ",";
			}
			$tagstr = trim ( $tagstr, ',' );
			
			// 如果标签存在就取标签里的问题
			$topiclist = $this->tag_model->getlistbytagid ( $tagstr, 0, 8, 'article' );
		} else {
			$topiclist = $this->topic_model->get_bycatid ( $question ['cid'], 0, 8 );
		}
		
		$asktime = tdate ( $question ['time'] );
		$endtime = timeLength ( $question ['endtime'] - time () );
		$solvetime = tdate ( $question ['endtime'] );
		$supplylist = $this->question_model->get_supply ( $question ['id'] );
		
		$ordertype = 1;
		if (strpos ( $this->uri->segments [4], 'u' ) == false) {
			if (null !== $this->uri->segments [4] && $this->uri->segments [4] == 1) {
				$ordertype = 2;
				$ordertitle = '倒序查看回答';
			} else {
				
				$ordertype = 1;
				$ordertitle = '正序查看回答';
			}
		} else {
		}
		$seo_userinfo = "";
		$seo_answerinfo = "";
		
		// 回答分页
		@$page = 0;
		@$page = max ( 1, intval ( $this->uri->rsegments [4] ) );
		
		$pagesize = isset ( $this->setting ['list_answernum'] ) ? $this->setting ['list_answernum'] : 3;
		$startindex = ($page - 1) * $pagesize;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( "answer", " qid=$qid AND status>0 AND adopttime =0", $this->db->dbprefix ) )->row_array () );
		$answerlistarray = $this->answer_model->list_by_qid ( $qid, $ordertype, $rownum, $startindex, $pagesize );
		$departstr = page ( $rownum, $pagesize, $page, "question/view/$qid" );
		$answerlist = $answerlistarray [0];
		$already = $answerlistarray [1];
		if ($already) {
			$cananswerthisquestion = false;
		}
		
		// 定义熊掌号推送的url数组
		$tuiurls = array ();
		$_url = url ( "question/view/$qid" );
		array_push ( $tuiurls, $_url );
		$nosolvelist = null; // $this->question_model->list_by_cfield_cvalue_status ( 'cid', $question ['cid'], 1 );
		
		$this->load->model ( 'paylog_model' );
		
		foreach ( $answerlist as $k => $v ) {
			$_url = url ( "question/answer/$qid/" . $answerlist [$k] ['id'] );
			array_push ( $tuiurls, $_url );
			$user = $this->user_model->get_by_uid ( $answerlist [$k] ['authorid'] );
			$answerlist [$k] ['signature'] = $user ['signature'];
			if ($answerlist [$k] ['reward'] == 0) {
				
				$answerlist [$k] ['canview'] = 1;
				$answerlist [$k] ['viewnum'] = 0;
			} else {
				// 查询这个回答偷看总人数
				$answerlist [$k] ['viewnum'] = $this->paylog_model->getviewanswersnum ( 'myviewaid', $answerlist [$k] ['id'] );
				$one = $this->paylog_model->selectbyfromuid ( $this->user ['uid'], $answerlist [$k] ['id'] );
				if ($one != null) {
					$answerlist [$k] ['canview'] = 1;
				} else {
					if ($this->user ['canfreereadansser'] == 1 || $this->user ['grouptype'] == 1) {
						$answerlist [$k] ['canview'] = 1;
					} else {
						$answerlist [$k] ['canview'] = 0;
					}
				}
			}
			if (function_exists ( "codehightline" )) {
				
				if ($answerlist [$k] ['content'] != '' && $answerlist [$k] ['content'] != null) {
					$answerlist [$k] ['content'] = codehightline ( $answerlist [$k] ['content'] );
				}
			}
		}
		
		$navlist = $this->category_model->get_navigation ( $question ['cid'], true );
		
		$typearray = array (
				'1' => 'nosolve',
				'2' => 'solve',
				'4' => 'nosolve',
				'6' => 'solve',
				'9' => 'close' 
		);
		$typedescarray = array (
				'1' => '待解决',
				'2' => '已解决',
				'4' => '高悬赏',
				'6' => '已推荐',
				'9' => '已关闭' 
		);
		$navtitle = $question ['title'];
		$dirction = $typearray [$question ['status']];
		$bestanswer = $this->answer_model->get_best ( $qid );
		
		
		
		$canedit = true;
		if ($question ['status'] == 9 || $question ['status'] == 0) {
			$canedit = false;
		}
		$categoryjs = $this->category_model->get_js ( 0, 1 );
		
		// 获取相关问题
		if ($taglist) {
			$tagstr = '';
			foreach ( $taglist as $tag ) {
				$tagstr .= $tag ['id'] . ",";
			}
			$tagstr = trim ( $tagstr, ',' );
			
			// 如果标签存在就取标签里的问题
			$solvelist = $this->tag_model->getlistbytagid ( $tagstr, 0, 8, 'question' );
		} else {
			$solvelist = null; // $this->question_model->list_by_cfield_cvalue_status ( 'cid', $question ['cid'], 2, 0, 8 );
		}
		
		$expertlist = $this->expert_model->get_by_cid ( $question ['cid'] );
		
		$is_followedauthor = $this->user_model->is_followed ( $question ['authorid'], $this->user ['uid'] );
		
		$is_followed = $this->question_model->is_followed ( $qid, $this->user ['uid'] );
		
		$followerlist = $this->question_model->get_follower ( $qid );
		
		/* SEO */
		$curnavname = $navlist [count ( $navlist ) - 1] ['name'];
		if (! $bestanswer) {
			$bestanswer = array ();
			$bestanswer ['content'] = '';
		} else {
			$_url = url ( "question/answer/$qid/" . $bestanswer ['id'] );
			array_push ( $tuiurls, $_url );
			$user = $this->user_model->get_by_uid ( $bestanswer ['authorid'] );
			$bestanswer ['signature'] = $user ['signature'];
			$bestanswer ['viewnum'] = $this->paylog_model->getviewanswersnum ( 'myviewaid', $bestanswer ['id'] );
			$one = $this->paylog_model->selectbyfromuid ( $this->user ['uid'], $bestanswer ['id'] );
			if ($one != null) {
				$bestanswer ['canview'] = 1;
			} else {
				if ($this->user ['canfreereadansser'] == 1 || $this->user ['grouptype'] == 1) {
					$bestanswer ['canview'] = 1;
				} else {
					$bestanswer ['canview'] = 0;
				}
			}
		}
		
		// 收藏的人
		$this->load->model ( "favorite_model" );
		$favoritelist = $this->favorite_model->get_list_byqid ( $qid );
		
		if ($this->setting ['seo_question_title']) {
			$seo_title = str_replace ( "{wzmc}", $this->setting ['site_name'], $this->setting ['seo_question_title'] );
			$seo_title = str_replace ( "{wtbt}", $question ['title'], $seo_title );
			$seo_title = str_replace ( "{wtzt}", $typedescarray [$question ['status']], $seo_title );
			$seo_title = str_replace ( "{flmc}", $curnavname, $seo_title );
			if ($page != 1) {
				$seo_title = $seo_title . "-第" . $page . "页回答" . $seo_userinfo;
			} else {
				$seo_title = $seo_title . $seo_userinfo;
			}
		} else {
			if ($page != 1) {
				$navtitle = $navtitle . "-第" . $page . "页回答" . $seo_userinfo;
			} else {
				$navtitle = $navtitle . $seo_userinfo;
			}
		}
		
		if (! isset ( $seo_answerinfo ['content'] )) {
			$seo_description = strip_tags ( $question ['description'] );
		} else {
			$seo_description = $seo_answerinfo ['content'];
		}
		$seo_description = clearhtml ( $seo_description );
		$tagkeystr = '';
		if ($taglist) {
			$tagkeystr = '';
			foreach ( $taglist as $tag ) {
				$tagkeystr .= $tag ['tagname'] . ",";
			}
		}
		$seo_keywords = trim ( $tagkeystr, ',' );
		$seo_description = str_replace ( '&nbsp;', '，', $seo_description );
		if ($this->user ['uid'] > 0) {
			if (! isset ( $_SESSION )) {
				session_start ();
			}
			$_SESSION ['answertoken'] = md5 ( time () );
		}
		// 如果包含代码格式化那就高亮设置
		
		if (function_exists ( "codehightline" )) {
			$question ['description'] = codehightline ( $question ['description'] );
			if ($bestanswer ['content'] != '' && $bestanswer ['content'] != null) {
				$bestanswer ['content'] = codehightline ( $bestanswer ['content'] );
			}
		}

		$isvip =false;
		
		$lastviewnum = 0;
	
		(0 == $question ['status']) && $this->message ( '问题正在审核中,请耐心等待！' );
		
		// 推送给熊掌号
		// xiongzhangtuisong ( $tuiurls );
		/* 非悬赏问题过期处理,如果问题在过期时间后还没有被采纳则关闭问题 */
		if ($question ['shangjin'] <= 0 && $question ['endtime'] < time () && ($question ['status'] == 1 || $question ['status'] == 4)) {
			$question ['status'] = 9;
			$this->question_model->update_status ( $qid, 9 );
			$this->send ( $question ['authorid'], $question ['id'], 2 );
			// 重新刷新页面
			$currenturl = url ( "question/view/$qid" );
			header ( "Location:$currenturl" );
			exit ();
		}
		include template ( 'solve' );
	}

	function sendweixinnotify($openid, $text) {

	}
	// 检索用户
	function invatebysearch() {
		$message = array ();
		// 如果还没有登录
		if ($this->user ['uid'] == 0) {
			$message ['code'] = 20001;
			$message ['message'] = '登录后可邀请回答';
			echo json_encode ( $message );
			exit ();
		}
		$qid = intval ( $_POST ['qid'] );
		$question = $this->question_model->get ( $qid );
		if (! $question) {
			$message ['code'] = 20001;
			$message ['message'] = '问题不存在';
			echo json_encode ( $message );
			exit ();
		}
		$username = strip_tags ( $_POST ['username'] );
		if (strlen ( $username ) < 1) {
			$message ['code'] = 20002;
			$message ['message'] = '至少输入一个字';
			echo json_encode ( $message );
			exit ();
		}
		// 根据用户名检索
		// $userlist = $this->db->select("u.uid,u.username,u.answers")->where('uf.followerid',$this->user['uid'])->from('user u')->join ( 'user_attention as uf', 'uf.uid=u.uid' )->group_by("u.uid")->limit ( 20, 0 )->get ()->result_array ();
		$userlist = $this->db->select ( "u.uid,u.username,u.answers" )->like ( 'u.username', $username, 'both' )->from ( 'user u' )->limit ( 20, 0 )->get ()->result_array ();
		if (! $userlist) {
			$message ['code'] = 20003;
			$message ['message'] = '没有数据';
			echo json_encode ( $message );
			exit ();
		} else {
			$tmpsrt = '';
			foreach ( $userlist as $_user ) {
				// 获取当前用户该话题下的回答数
				// $query = $this->db->query ( "select count(a.id) as num from " . $this->db->dbprefix . "answer as a," . $this->db->dbprefix . "question as q where a.qid=q.id and q.cid=" . $question ['cid']." and a.authorid=".$_user ['uid'] );
				// $tmpmodel = $query->row_array ();
				// $cur_num = $tmpmodel ['num'];
				$userspace = url ( "user/space/" . $_user ['uid'] );
				$strtmp = '<div class="row m_item"> <div class="col-sm-2 m_i_useravatar"><a href="' . $userspace . '">
              <img class="m_i_avatar" src="' . get_avatar_dir ( $_user ['uid'] ) . '"/>
               </a>
               </div>
                <div class="col-sm-16 m_info_show">
                <a>
                <span class="m_i_username">
                          ' . $_user ['username'] . '
                </span>

                <div class="m_i_user_baseinfo">
                                    该用户一共参与了 ' . $_user ['answers'] . ' 个回答
                </div>
               </div>
                 <div class="col-sm-4">
                 <button class=" m_invate_user" data-back="0" data-qid="' . $qid . '" data-uid="' . $_user ['uid'] . '" data-cid="' . $_user ['cid'] . '">邀请回答</button>
               </div>
               </div>';
				$tmpsrt .= $strtmp;
			}
			$mintime = strtotime ( date ( 'Y-m-d' ) );
			$maxtime = time ();
			// 获取当前邀请人数
			$query = $this->db->query ( "select count(*) as num from " . $this->db->dbprefix . "user_invateanswer where state=1 and qid=$qid and invateuid=" . $this->user ['uid'] . " and invatetime>$mintime and invatetime<=$maxtime" );
			$model = $query->row_array ();
			// 获取当前邀请列表
			$invateuserlist = $this->db->select ( "  u.uid,u.username" )->where ( array (
					'ui.invateuid' => $this->user ['uid'],
					'ui.qid' => $qid,
					'state' => 1 
			) )->from ( 'user_invateanswer ui' )->join ( 'user u', 'u.uid=ui.uid' )->get ()->result_array ();
			$this->db->distinct ();
			$tmpstrlist = '<ul class="pop_userlist">';
			foreach ( $invateuserlist as $invater ) {
				$tmpstr = '<li><img src="' . get_avatar_dir ( $invater ['uid'] ) . '"><span class="m_li_username">' . $invater ['username'] . '</span><span onclick="cancelinvateuser(this,' . $qid . ',' . $invater ['uid'] . ')" data-qid="' . $qid . '" data-uid="' . $invater ['uid'] . '" class="m_li_invate btn">取消邀请</span></li>';
				$tmpstrlist .= $tmpstr;
			}
			$tmpstrlist .= "</ul>";
			$message ['code'] = 20000;
			$message ['message'] = $tmpsrt;
			$message ['invatenum'] = $model ['num'];
			$message ['invateuserlist'] = $tmpstrlist;
			echo json_encode ( $message );
			exit ();
		}
	}
	// 邀请我关注的人
	function invatemyattention() {
		$message = array ();
		// 如果还没有登录
		if ($this->user ['uid'] == 0) {
			$message ['code'] = 20001;
			$message ['message'] = '登录后可邀请回答';
			echo json_encode ( $message );
			exit ();
		}
		$qid = intval ( $_POST ['qid'] );
		$question = $this->question_model->get ( $qid );
		if (! $question) {
			$message ['code'] = 20001;
			$message ['message'] = '问题不存在';
			echo json_encode ( $message );
			exit ();
		}
		
		// 根据我关注的人
		$userlist = $this->db->select ( "u.uid,u.username,u.answers" )->where ( 'uf.followerid', $this->user ['uid'] )->from ( 'user u' )->join ( 'user_attention as uf', 'uf.uid=u.uid' )->group_by ( "u.uid" )->limit ( 20, 0 )->get ()->result_array ();
		
		if (! $userlist) {
			$message ['code'] = 20003;
			$message ['message'] = '没有数据';
			echo json_encode ( $message );
			exit ();
		} else {
			$tmpsrt = '';
			foreach ( $userlist as $_user ) {
				// 获取当前用户该话题下的回答数
				// $query = $this->db->query ( "select count(a.id) as num from " . $this->db->dbprefix . "answer as a," . $this->db->dbprefix . "question as q where a.qid=q.id and q.cid=" . $question ['cid']." and a.authorid=".$_user ['uid'] );
				// $tmpmodel = $query->row_array ();
				// $cur_num = $tmpmodel ['num'];
				$userspace = url ( "user/space/" . $_user ['uid'] );
				$strtmp = '<div class="row m_item"> <div class="col-sm-2 m_i_useravatar"><a href="' . $userspace . '">
              <img class="m_i_avatar" src="' . get_avatar_dir ( $_user ['uid'] ) . '"/>
               </a>
               </div>
                <div class="col-sm-16 m_info_show">
                <a>
                <span class="m_i_username">
                          ' . $_user ['username'] . '
                </span>

                <div class="m_i_user_baseinfo">
                                    该用户一共参与了 ' . $_user ['answers'] . ' 个回答
                </div>
               </div>
                 <div class="col-sm-4">
                 <button class=" m_invate_user" data-back="0" data-qid="' . $qid . '" data-uid="' . $_user ['uid'] . '" data-cid="' . $_user ['cid'] . '">邀请回答</button>
               </div>
               </div>';
				$tmpsrt .= $strtmp;
			}
			$mintime = strtotime ( date ( 'Y-m-d' ) );
			$maxtime = time ();
			// 获取当前邀请人数
			$query = $this->db->query ( "select count(*) as num from " . $this->db->dbprefix . "user_invateanswer where state=1 and qid=$qid and invateuid=" . $this->user ['uid'] . " and invatetime>$mintime and invatetime<=$maxtime" );
			$model = $query->row_array ();
			// 获取当前邀请列表
			$invateuserlist = $this->db->select ( "  u.uid,u.username" )->where ( array (
					'ui.invateuid' => $this->user ['uid'],
					'ui.qid' => $qid,
					'state' => 1 
			) )->from ( 'user_invateanswer ui' )->join ( 'user u', 'u.uid=ui.uid' )->get ()->result_array ();
			$this->db->distinct ();
			$tmpstrlist = '<ul class="pop_userlist">';
			foreach ( $invateuserlist as $invater ) {
				$tmpstr = '<li><img src="' . get_avatar_dir ( $invater ['uid'] ) . '"><span class="m_li_username">' . $invater ['username'] . '</span><span onclick="cancelinvateuser(this,' . $qid . ',' . $invater ['uid'] . ')" data-qid="' . $qid . '" data-uid="' . $invater ['uid'] . '" class="m_li_invate btn">取消邀请</span></li>';
				$tmpstrlist .= $tmpstr;
			}
			$tmpstrlist .= "</ul>";
			$message ['code'] = 20000;
			$message ['message'] = $tmpsrt;
			$message ['invatenum'] = $model ['num'];
			$message ['invateuserlist'] = $tmpstrlist;
			echo json_encode ( $message );
			exit ();
		}
	}
	// 根据分类获取在该分类下回答过的人
	function loadinavterbyanswerincid() {
		$message = array ();
		// 如果还没有登录
		if ($this->user ['uid'] == 0) {
			$message ['code'] = 20001;
			$message ['message'] = '登录后可邀请回答';
			echo json_encode ( $message );
			exit ();
		}
		$qid = intval ( $_POST ['qid'] );
		$question = $this->question_model->get ( $qid );
		if (! $question) {
			$message ['code'] = 20001;
			$message ['message'] = '问题不存在';
			echo json_encode ( $message );
			exit ();
		}
		// 根据分类获取相关擅长分类的人
		$userlist = $this->question_model->getinvatebyanswer ( $question ['cid'] );
		if (! $userlist) {
			$message ['code'] = 20003;
			$message ['message'] = '没有数据';
			echo json_encode ( $message );
			exit ();
		} else {
			$tmpsrt = '';
			foreach ( $userlist as $_user ) {
				// 获取当前用户该话题下的回答数
				$query = $this->db->query ( "select count(a.id) as num from " . $this->db->dbprefix . "answer as a," . $this->db->dbprefix . "question as q where a.qid=q.id and q.cid=" . $question ['cid'] . " and a.authorid=" . $_user ['uid'] );
				$tmpmodel = $query->row_array ();
				$cur_num = $tmpmodel ['num'];
				$userspace = url ( "user/space/" . $_user ['uid'] );
				$strtmp = '<div class="row m_item"> <div class="col-sm-2 m_i_useravatar"><a href="' . $userspace . '">
              <img class="m_i_avatar" src="' . get_avatar_dir ( $_user ['uid'] ) . '"/>
               </a>
               </div>
                <div class="col-sm-16 m_info_show">
                <a>
                <span class="m_i_username">
                          ' . $_user ['username'] . '
                </span>

                <div class="m_i_user_baseinfo">
                                     在话题<span class="m_tag">' . $_user ['name'] . '</span>下有 ' . $cur_num . ' 个回答
                </div>
               </div>
                 <div class="col-sm-4">
                 <button class=" m_invate_user" data-back="0" data-qid="' . $qid . '" data-uid="' . $_user ['uid'] . '" data-cid="' . $_user ['cid'] . '">邀请回答</button>
               </div>
               </div>';
				$tmpsrt .= $strtmp;
			}
			$mintime = strtotime ( date ( 'Y-m-d' ) );
			$maxtime = time ();
			// 获取当前邀请人数
			$query = $this->db->query ( "select count(*) as num from " . $this->db->dbprefix . "user_invateanswer where state=1 and qid=$qid and invateuid=" . $this->user ['uid'] . " and invatetime>$mintime and invatetime<=$maxtime" );
			$model = $query->row_array ();
			// 获取当前邀请列表
			$invateuserlist = $this->db->select ( "  u.uid,u.username" )->where ( array (
					'ui.invateuid' => $this->user ['uid'],
					'ui.qid' => $qid,
					'state' => 1 
			) )->from ( 'user_invateanswer ui' )->join ( 'user u', 'u.uid=ui.uid' )->get ()->result_array ();
			$this->db->distinct ();
			$tmpstrlist = '<ul class="pop_userlist">';
			foreach ( $invateuserlist as $invater ) {
				$tmpstr = '<li><img src="' . get_avatar_dir ( $invater ['uid'] ) . '"><span class="m_li_username">' . $invater ['username'] . '</span><span onclick="cancelinvateuser(this,' . $qid . ',' . $invater ['uid'] . ')" data-qid="' . $qid . '" data-uid="' . $invater ['uid'] . '" class="m_li_invate btn">取消邀请</span></li>';
				$tmpstrlist .= $tmpstr;
			}
			$tmpstrlist .= "</ul>";
			$message ['code'] = 20000;
			$message ['message'] = $tmpsrt;
			$message ['invatenum'] = $model ['num'];
			$message ['invateuserlist'] = $tmpstrlist;
			echo json_encode ( $message );
			exit ();
		}
	}
	// 邀请回答
	function loadinvateuser() {
		// 如果还没有登录
		if ($this->user ['uid'] == 0) {
			$message ['code'] = 20001;
			$message ['message'] = '登录后可邀请回答';
			echo json_encode ( $message );
			exit ();
		}
		
		$qid = intval ( $_POST ['qid'] );
		$question = $this->question_model->get ( $qid );
		if (! $question) {
			$message ['code'] = 20001;
			$message ['message'] = '问题不存在';
			echo json_encode ( $message );
			exit ();
		}
		// 看看是不是匿名下状态
		if ($question ['authorid'] == $this->user ['uid'] && $question ['authorid'] && $question ['hidden'] == 1) {
			$message ['code'] = 20001;
			$message ['message'] = '匿名下无法邀请用户回答';
			echo json_encode ( $message );
			exit ();
		}
		
		// 根据分类获取相关擅长分类的人
		$userlist = $this->question_model->getinvatebycid ( $question ['cid'] );
		if (! $userlist) {
			$message ['code'] = 20003;
			$message ['message'] = '没有数据';
			echo json_encode ( $message );
			exit ();
		} else {
			
			$tmpsrt = '';
			foreach ( $userlist as $_user ) {
				// 获取当前用户该话题下的回答数
				$query = $this->db->query ( "select count(a.id) as num from " . $this->db->dbprefix . "answer as a," . $this->db->dbprefix . "question as q where a.qid=q.id and q.cid=" . $question ['cid'] . " and a.authorid=" . $_user ['uid'] );
				$tmpmodel = $query->row_array ();
				$cur_num = $tmpmodel ['num'];
				
				$userspace = url ( "user/space/" . $_user ['uid'] );
				$strtmp = '<div class="row m_item"> <div class="col-sm-2 m_i_useravatar"><a href="' . $userspace . '">
              <img class="m_i_avatar" src="' . get_avatar_dir ( $_user ['uid'] ) . '"/>
               </a>
               </div>
                <div class="col-sm-16 m_info_show">
                <a>
                <span class="m_i_username">
                          ' . $_user ['username'] . '
                </span>

                <div class="m_i_user_baseinfo">
                                     在话题<span class="m_tag">' . $_user ['name'] . '</span>下有 ' . $cur_num . ' 个回答
                </div>
               </div>
                 <div class="col-sm-4">
                 <button class=" m_invate_user" data-back="0" data-qid="' . $qid . '" data-uid="' . $_user ['uid'] . '" data-cid="' . $_user ['cid'] . '">邀请回答</button>
               </div>
               </div>';
				$tmpsrt .= $strtmp;
			}
			
			$mintime = strtotime ( date ( 'Y-m-d' ) );
			$maxtime = time ();
			
			// 获取当前邀请人数
			$query = $this->db->query ( "select count(*) as num from " . $this->db->dbprefix . "user_invateanswer where state=1 and qid=$qid and invateuid=" . $this->user ['uid'] . " and invatetime>$mintime and invatetime<=$maxtime" );
			$model = $query->row_array ();
			
			// 获取当前邀请列表
			$invateuserlist = $this->db->select ( "  u.uid,u.username" )->where ( array (
					'ui.invateuid' => $this->user ['uid'],
					'ui.qid' => $qid,
					'state' => 1 
			) )->from ( 'user_invateanswer ui' )->join ( 'user u', 'u.uid=ui.uid' )->get ()->result_array ();
			$this->db->distinct ();
			
			$tmpstrlist = '<ul class="pop_userlist">';
			foreach ( $invateuserlist as $invater ) {
				$tmpstr = '<li><img src="' . get_avatar_dir ( $invater ['uid'] ) . '"><span class="m_li_username">' . $invater ['username'] . '</span><span onclick="cancelinvateuser(this,' . $qid . ',' . $invater ['uid'] . ')" data-qid="' . $qid . '" data-uid="' . $invater ['uid'] . '" class="m_li_invate btn">取消邀请</span></li>';
				$tmpstrlist .= $tmpstr;
			}
			$tmpstrlist .= "</ul>";
			$message ['code'] = 20000;
			$message ['message'] = $tmpsrt;
			$message ['invatenum'] = $model ['num'];
			$message ['invateuserlist'] = $tmpstrlist;
			echo json_encode ( $message );
			exit ();
		}
	}
	// 获取邀请列表
	function getinvatelist() {
		// 如果还没有登录
		if ($this->user ['uid'] == 0) {
			$message ['code'] = 20001;
			$message ['message'] = '登录后可邀请回答';
			echo json_encode ( $message );
			exit ();
		}
		$qid = intval ( $_POST ['qid'] );
		// 获取当前邀请列表
		$invateuserlist = $this->db->select ( " u.uid,u.username" )->where ( array (
				'ui.invateuid' => $this->user ['uid'],
				'ui.qid' => $qid,
				'state' => 1 
		) )->from ( 'user_invateanswer ui' )->join ( 'user u', 'u.uid=ui.uid' )->get ()->result_array ();
		$this->db->distinct ();
		$tmpstrlist = '<ul class="pop_userlist">';
		foreach ( $invateuserlist as $invater ) {
			$tmpstr = '<li><img src="' . get_avatar_dir ( $invater ['uid'] ) . '"><span class="m_li_username">' . $invater ['username'] . '</span><span onclick="cancelinvateuser(this,' . $qid . ',' . $invater ['uid'] . ')" data-qid="' . $qid . '" data-uid="' . $invater ['uid'] . '" class="m_li_invate btn">收回邀请</span></li>';
			$tmpstrlist .= $tmpstr;
		}
		$tmpstrlist .= "</ul>";
		$message ['code'] = 20000;
		$message ['invateuserlist'] = $tmpstrlist;
		echo json_encode ( $message );
		exit ();
	}
	// 取消邀请回答
	function cancelinvateuseranswer() {
		
		// 如果还没有登录
		if ($this->user ['uid'] == 0) {
			$message ['code'] = 20001;
			$message ['message'] = '登录后可邀请回答';
			echo json_encode ( $message );
			exit ();
		}
		$qid = intval ( $_POST ['qid'] );
		$uid = intval ( $_POST ['uid'] );
		// 获取问题
		$question = $this->question_model->get ( $qid );
		// 看看是不是匿名下状态
		if ($question ['authorid'] == $this->user ['uid'] && $question ['authorid'] && $question ['hidden'] == 1) {
			$message ['code'] = 20001;
			$message ['message'] = '匿名下无法取消邀请用户回答';
			echo json_encode ( $message );
			exit ();
		}
		// $this->db->where ( array ('qid' => $qid, 'uid' => $uid, 'invateuid' => $this->user ['uid'] ) )->delete ( "user_invateanswer" );
		// 将邀请状态设置为0
		$this->db->set ( 'state', '0', FALSE )->where ( array (
				'qid' => $qid,
				'uid' => $uid,
				'invateuid' => $this->user ['uid'] 
		) )->update ( 'user_invateanswer' );
		// 同时删除发送私信
		$title = $question ['title'];
		$this->db->query ( "delete from " . $this->db->dbprefix . "message where typename='invateanswer' and touid=$uid and fromuid=" . $this->user ['uid'] . " and content like '%$title%'" );
		
		$message ['code'] = 20000;
		$message ['message'] = '取消邀请成功';
		echo json_encode ( $message );
		exit ();
	}
	// 添加邀请回答
	function invateuseranswer() {
		
		// 如果还没有登录
		if ($this->user ['uid'] == 0) {
			$message ['code'] = 20001;
			$message ['message'] = '登录后可邀请回答';
			echo json_encode ( $message );
			exit ();
		}
		$message = array ();
		$qid = intval ( $_POST ['qid'] );
		$cid = intval ( $_POST ['cid'] );
		$uid = intval ( $_POST ['uid'] );
		// 获取问题
		$question = $this->question_model->get ( $qid );
		// 看看是不是匿名下状态
		if ($question ['authorid'] == $this->user ['uid'] && $question ['authorid'] && $question ['hidden'] == 1) {
			$message ['code'] = 20001;
			$message ['message'] = '匿名下无法邀请用户回答';
			echo json_encode ( $message );
			exit ();
		}
		
		// 判断是否邀请过了
		$_user = $this->db->select ( "*" )->from ( 'user_invateanswer' )->where ( array (
				'qid' => $qid,
				'uid' => $uid,
				'state' => 1 
		) )->get ()->row_array ();
		if ($_user) {
			$message ['code'] = 20001;
			$message ['message'] = '此用户已经被邀请过回答了';
			echo json_encode ( $message );
			exit ();
		}
		// 判断是否已经回答过问题
		$_user = $this->db->select ( '*' )->from ( 'answer' )->where ( array (
				'qid' => $qid,
				'authorid' => $uid 
		) )->get ()->row_array ();
		if ($_user) {
			$message ['code'] = 20001;
			$message ['message'] = '该用户已经回答过了';
			echo json_encode ( $message );
			exit ();
		}
		// 判断邀请的是不是自己
		if ($uid == $this->user ['uid']) {
			$message ['code'] = 20001;
			$message ['message'] = '不能邀请自己哦';
			echo json_encode ( $message );
			exit ();
		}
		// 判断当日这个问题我邀请了多少人--最多15个
		$mintime = strtotime ( date ( 'Y-m-d' ) );
		$maxtime = time ();
		$query = $this->db->query ( "select count(*) as num from " . $this->db->dbprefix . "user_invateanswer where qid=$qid and invateuid=" . $this->user ['uid'] . " and invatetime>$mintime and invatetime<=$maxtime" );
		$model = $query->row_array ();
		if ($model != null) {
			if ($model ['num'] > 15) {
				$message ['code'] = 20001;
				$message ['message'] = '同一个问题每天最多邀请15个人回答，取消也包括在内';
				echo json_encode ( $message );
				exit ();
			}
		}
		// 每天最多邀请30个人回答
		$query = $this->db->query ( "select count(*) as num from " . $this->db->dbprefix . "user_invateanswer where  invateuid=" . $this->user ['uid'] . " and invatetime>$mintime and invatetime<=$maxtime" );
		$model = $query->row_array ();
		if ($model != null) {
			if ($model ['num'] > 30) {
				$message ['code'] = 20001;
				$message ['message'] = '您今天的邀请名额已经用完，暂时无法邀请更多的人';
				echo json_encode ( $message );
				exit ();
			}
		}
		
		$invateuser = $this->user_model->get_by_uid ( $uid );
		
		// 如果需要关注才能邀请回答
		if ($invateuser ['notify'] ['invite_permission'] == 1) {
			$is_followed = $this->user_model->is_followed ( $uid, $this->user ['uid'] );
			
			if (! $is_followed) {
				$message ['code'] = 20001;
				$message ['message'] = '此用户设置需要关注Ta才能邀请回答!';
				echo json_encode ( $message );
				exit ();
			}
		}
		// 插入邀请
		$data = array (
				'qid' => $qid,
				'uid' => $uid,
				'cid' => $cid,
				'invateuid' => $this->user ['uid'],
				'invatetime' => time () 
		);
		$id = $this->db->insert ( 'user_invateanswer', $data );
		if ($id > 0) {
			// 获取问题
			$question = $this->question_model->get ( $qid );
			$qurl = url ( "question/view/" . $question ['id'] );
			$content = "尊敬的用户您好，" . $this->user ['username'] . "邀请您回答问题【" . $question ['title'] . "】,<a href='$qurl'>点击回答问题</a>";
			// 给邀请的人发 私信
			$data = array (
					'typename' => 'invateanswer',
					'from' => $this->user ['username'],
					'fromuid' => $this->user ['uid'],
					'touid' => $uid,
					'new' => 1,
					'subject' => "有网友邀请您回答问题《" . $question ['title'] . "》",
					'time' => time (),
					'content' => $content 
			);
			$this->db->insert ( 'message', $data );
			$usermodel = $this->user_model->get_by_uid ( $uid );
			
			// 发送邮件通知
			
			// 如果作者开启问题邀请邮件通知，且邀请人不是作者本人
			if ($usermodel ['notify'] ['invite'] == 1 && $usermodel ['uid'] != $this->user ['uid']) {
				$subject = "尊敬的用户您好，" . $this->user ['username'] . "邀请您回答问题[" . $question ['title'] . "]";
				$sendmessage = $question ['description'] . '<p>现在您可以点击<a swaped="true" target="_blank" href="' . $qurl . '">查看最新问题详情</a>。</p>';
				sendmailto ( $usermodel ['email'], $subject, $sendmessage, $usermodel ['username'] );
				// sendmail( $usermodel, $subject, $sendmessage );
			}
			
			$tmpstr = '<li><img src="' . get_avatar_dir ( $uid ) . '"><span class="m_li_username">' . $usermodel ['username'] . '</span><span onclick="cancelinvateuser(this,' . $qid . ',' . $uid . ')" data-qid="' . $qid . '" data-uid="' . $uid . '" class="m_li_invate btn">取消邀请</span></li>';
			
			$message ['code'] = 20000;
			$message ['message'] = '邀请成功';
			$message ['datastr'] = $tmpstr;
			echo json_encode ( $message );
			exit ();
		} else {
			$message ['code'] = 20000;
			$message ['message'] = '邀请失败';
			echo json_encode ( $message );
			exit ();
		}
	}
	function cancelinvateuser() {
	}
	/* 采纳答案 */
	function ajaxadopt() {
		$message = array ();
		$qid = intval ( $this->input->post ( 'qid' ) );
		$aid = intval ( $this->input->post ( 'aid' ) );
		$comment = $this->input->post ( 'content', FALSE );
		$question = $this->question_model->get ( $qid );
		$answer = $this->answer_model->get ( $aid );
		// 如果还没有登录
		if ($this->user ['uid'] == 0) {
			$message ['message'] = '登录后可邀请回答';
			echo json_encode ( $message );
			exit ();
		}
		// 如果采纳人不是本人或者超级管理员
		if ($this->user ['grouptype'] != 1) {
			
			if ($this->user ['uid'] != $question ['authorid']) {
				$message ['message'] = '您不是提问人';
				echo json_encode ( $message );
				exit ();
			}
		}
		if ($this->user ['uid'] == $answer ['authorid'] && $this->user ['grouptype'] != 1) {
			$message ['message'] = '不能采纳自己的回答';
			echo json_encode ( $message );
			exit ();
		}
		// 判断问题是否被采纳过了
		if ($question ['status'] == 2) {
			$message ['message'] = '此问题已经采纳过了';
			echo json_encode ( $message );
			exit ();
		}
		// 判断这个回答是否被采纳过了
		if ($answer ['adopttime'] > 0) {
			$message ['message'] = '此回答已经采纳过了';
			echo json_encode ( $message );
			exit ();
		}
		$ret = $this->answer_model->adopt ( $qid, $answer );
		$touid = $answer ['authorid'];
		$quid = $question ['authorid'];
		// 提问悬赏金额
		$cash_fee = doubleval ( $question ['shangjin'] ) * 100; // 单位分
	
		if ($ret) {
			$this->load->model ( "answer_comment_model" );
			$this->answer_comment_model->add ( $aid, $comment, $question ['authorid'], $question ['author'] );
			
			$this->credit ( $answer ['authorid'], $this->setting ['credit1_adopt'], intval ( $question ['price'] + $this->setting ['credit2_adopt'] ), 0, 'adopt' );
			
			// $this->send ( $answer ['authorid'], $question ['id'], 1 );
			$viewurl = urlmap ( 'question/view/' . $qid, 2 );
			$this->doing_model->add ( $question ['authorid'], $question ['author'], 8, $qid, $comment, $answer ['id'], $answer ['authorid'], $answer ['content'] );
		}
		
		$quser = $this->user_model->get_by_uid ( $answer ['authorid'] );
		global $setting;
		$mpurl = url ( 'question/view/' . $qid );
		// 极光推送
		$url = url ( "question/view/$qid" );
		
		// 回答的时候如果在微信里，就微信推送通知
		$url = SITE_URL . $this->setting ['seo_prefix'] . $viewurl . $this->setting ['seo_suffix'];
		$text = "你的回答被采纳(" . $question ['title'] . ")，<a href='$url'>请点击查看详情!</a>";
		
		
		// 如果作者开启回答被采纳邮件通知，且采纳操作不是作者本人
		$quser = $this->user_model->get_by_uid ( $answer ['authorid'] );
		if ($quser ['notify'] ['content_handled'] == 1 && $quser ['uid'] != $this->user ['uid']) {
			// 发送邮件通知
			$subject = "你的问题[" . $question ['title'] . "]被采纳！";
			$emailmessage = $comment . '<p>现在您可以点击<a swaped="true" target="_blank" href="' . $mpurl . '">查看详情</a>。</p>';
			try {
				
				sendmail ( $quser, $subject, $emailmessage );
			} catch ( Exception $e ) {
				$message ['message'] = 'ok';
				echo json_encode ( $message );
				exit ();
			}
		}
	
		$message ['message'] = 'ok';
		echo json_encode ( $message );
		exit ();
	}
	/* 结束问题，没有满意的回答，还可直接结束提问，关闭问题。 */
	function close() {
		$qid = intval ( $this->uri->segment ( 3 ) ) ? intval ( $this->uri->segment ( 3 ) ) : $this->input->post ( 'qid' );
		$question = $this->question_model->get ( $qid );
		
		if ($question ['status'] == 9) {
			$this->message ( '问题已经是关闭状态！' );
		}
		// 如果不是超级管理员操作
		if ($this->user ['groupid'] != 1) {
			if ($question ['authorid'] != $this->user ['uid'] || $this->user ['uid'] == 0) {
				$this->message ( "操作非提问者本人!", "STOP" );
			}
		}
		
		if ($question ['answers'] > 0 && $question ['shangjin'] > 0 && $question ['status'] != 2) {
			$this->message ( "悬赏问题已经有回答且没被采纳，不能关闭！" );
		}
		$this->question_model->update_status ( $qid, 9 );
		$viewurl = urlmap ( 'question/view/' . $qid, 2 );
		
		// 发送邮件通知
		$quser = $this->user_model->get_by_uid ( $question ['authorid'] );
		// 如果作者开启问题关闭邮件通知，且关闭操作不是作者本人
		if ($quser ['notify'] ['content_handled'] == 1 && $quser ['uid'] != $this->user ['uid']) {
			$subject = "问题[" . $question ['title'] . "]已被关闭";
			$sendmessage = '<p>现在您可以点击<a swaped="true" target="_blank" href="' . url ( 'question/view/' . $qid ) . '">查看问题详情</a>。</p>';
			sendmail ( $quser, $subject, $sendmessage );
		}
		
		$this->message ( '关闭问题成功！', $viewurl );
	}
	
	/* 补充提问细节 */
	function supply() {
		$qid = $this->uri->segment ( 3 ) ? $this->uri->segment ( 3 ) : $this->input->post ( 'qid' );
		$qid = intval ( $qid );
		$question = $this->question_model->get ( $qid );
		if (! $question) {
			$this->message ( "问题不存在或已被删除!", "STOP" );
		}
		if ($question ['authorid'] != $this->user ['uid'] || $this->user ['uid'] == 0) {
			$this->message ( "非法操作!", "STOP" );
			exit ();
		}
		
		if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1') {
			if ($this->user ['active'] != 1) {
				
				$this->message ( "必须激活邮箱才能补充!", 'question/view/' . $qid );
			}
		}
		$navlist = $this->category_model->get_navigation ( $question ['cid'], true );
		if (null !== $this->input->post ( 'submit' )) {
			if ($this->user ['grouptype'] != 1) {
				if (strtolower ( trim ( $this->input->post ( 'code' ) ) ) != $this->user_model->get_code ()) {
					$this->message ( $this->input->post ( 'state' ) . "验证码错误!", 'BACK' );
				}
			}
			$content = $this->input->post ( 'content', FALSE );
			// 检查审核和内容外部URL过滤
			$status = intval ( 1 != (1 & $this->setting ['verify_question']) );
			$allow = $this->setting ['allow_outer'];
			if (3 != $allow && has_outer ( $content )) {
				0 == $allow && $this->message ( "内容包含外部链接，发布失败!", 'BACK' );
				1 == $allow && $status = 0;
				2 == $allow && $content = filter_outer ( $content );
			}
			// 检查违禁词
			$contentarray = checkwords ( $content );
			1 == $contentarray [0] && $status = 0;
			2 == $contentarray [0] && $this->message ( "内容包含非法关键词，发布失败!", 'BACK' );
			$content = $contentarray [1];
			
			$question = $this->question_model->get ( $qid );
			// 问题最大补充数限制
			(count ( unserialize ( $question ['supply'] ) ) >= $this->setting ['apend_question_num']) && $this->message ( "您已超过问题最大补充次数" . $this->setting ['apend_question_num'] . ",发布失败！", 'BACK' );
			if ($this->user ['groupid'] == 1) {
				$status = 1;
			}
			
			$this->question_model->add_supply ( $qid, $question ['supply'], $content, $status ); // 添加问题补充
			$viewurl = urlmap ( 'question/view/' . $qid, 2 );
			if (0 == $status) {
				$this->message ( '补充问题成功！为了确保问答的质量，我们会对您的提问内容进行审核。请耐心等待......', 'BACK' );
			} else {
				$this->message ( '补充问题成功！', $viewurl );
			}
		}
		include template ( "supply" );
	}
	function ajaxsupply() {
		$message = array ();
		$qid = $this->uri->segment ( 3 ) ? $this->uri->segment ( 3 ) : $this->input->post ( 'qid' );
		$qid = intval ( $qid );
		$question = $this->question_model->get ( $qid );
		if (! $question) {
			
			$message ['message'] = "问题不存在或已被删除!";
			echo json_encode ( $message );
			exit ();
		}
		if ($question ['authorid'] != $this->user ['uid'] || $this->user ['uid'] == 0) {
			
			$message ['message'] = "非法操作!";
			echo json_encode ( $message );
			exit ();
		}
		
		if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1') {
			if ($this->user ['active'] != 1) {
				
				$message ['message'] = "必须激活邮箱才能补充!";
				echo json_encode ( $message );
				exit ();
			}
		}
		
		if ($this->user ['grouptype'] != 1) {
			if (strtolower ( trim ( $this->input->post ( 'code' ) ) ) != $this->user_model->get_code () && $this->user ['credit1'] < $this->setting ['jingyan']) {
				
				$message ['message'] = "验证码错误!";
				echo json_encode ( $message );
				exit ();
			}
		}
		$content = $this->input->post ( 'content' );
		// 检查审核和内容外部URL过滤
		$status = intval ( 1 != (1 & $this->setting ['verify_question']) );
		$allow = $this->setting ['allow_outer'];
		if (3 != $allow && has_outer ( $content )) {
			if (0 == $allow) {
				
				$message ['message'] = "内容包含外部链接，发布失败!";
				echo json_encode ( $message );
				exit ();
			}
			1 == $allow && $status = 0;
			2 == $allow && $content = filter_outer ( $content );
		}
		// 检查违禁词
		$contentarray = checkwords ( $content );
		1 == $contentarray [0] && $status = 0;
		if (2 == $contentarray [0]) {
			
			$message ['message'] = "内容包含非法关键词，发布失败!";
			echo json_encode ( $message );
			exit ();
		}
		$content = $contentarray [1];
		
		$question = $this->question_model->get ( $qid );
		// 问题最大补充数限制
		if (count ( unserialize ( $question ['supply'] ) ) >= $this->setting ['apend_question_num']) {
			
			$message ['message'] = "您已超过问题最大补充次数" . $this->setting ['apend_question_num'] . ",发布失败！";
			
			echo json_encode ( $message );
			exit ();
		}
		if ($this->user ['groupid'] == 1) {
			$status = 1;
		}
		
		$this->question_model->add_supply ( $qid, $question ['supply'], $content, $status ); // 添加问题补充
		$viewurl = urlmap ( 'question/view/' . $qid, 2 );
		if (0 == $status) {
			
			$message ['url'] = SITE_URL . $this->setting ['seo_prefix'] . $viewurl . $this->setting ['seo_suffix'];
			$message ['sh'] = 1;
			$message ['message'] = 'ok';
			
			echo json_encode ( $message );
			exit ();
		} else {
			
			$message ['url'] = SITE_URL . $this->setting ['seo_prefix'] . $viewurl . $this->setting ['seo_suffix'];
			
			$message ['message'] = 'ok';
			echo json_encode ( $message );
			exit ();
		}
	}
	/* 追加悬赏 */
	function addscore() {
		$qid = intval ( $this->input->post ( 'qid' ) );
		$score = abs ( $this->input->post ( 'score' ) );
		if ($this->user ['credit2'] < $score) {
			$this->message ( "财富值不足!", 'BACK' );
		}
		$this->question_model->update_score ( $qid, $score );
		$this->credit ( $this->user ['uid'], 0, - $score, 0, 'offer' );
		$viewurl = urlmap ( 'question/view/' . $qid, 2 );
		$this->message ( '追加悬赏成功！', $viewurl );
	}
	
	/* 修改回答 */
	function editanswer() {
		$navtitle = '修改回答';
		$aid = $this->uri->segment ( 3 ) ? $this->uri->segment ( 3 ) : $this->input->post ( 'aid' );
		$answer = $this->answer_model->get ( $aid );
		
		// 判断当前用户是不是超级管理员
		$candone = false;
		if ($this->user ['grouptype'] == 1) {
			$candone = true;
		} else {
			// 判断当前用户是不是回答者本人
			
			if ($this->user ['uid'] == $answer ['authorid']) {
				$candone = true;
			}
		}
		
		if ($candone == false) {
			$this->message ( "非法操作,您的ip已被系统记录！", "STOP" );
		}
		
		if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1') {
			if ($this->user ['active'] != 1) {
				
				$this->message ( "必须激活邮箱才能修改回答!", 'question/view/' . $answer ['qid'] );
			}
		}
		
		(! $answer) && $this->message ( "回答不存在或已被删除！", "STOP" );
		$question = $this->question_model->get ( $answer ['qid'] );
		$navlist = $this->category_model->get_navigation ( $question ['cid'], true );
		
		include template ( "editanswer" );
	}
	function ajaxeditanswer() {
		$message = array ();
		$aid = $this->uri->segment ( 3 ) ? $this->uri->segment ( 3 ) : $this->input->post ( 'aid' );
		$answer = $this->answer_model->get ( $aid );
		
		// 判断当前用户是不是超级管理员
		$candone = false;
		if ($this->user ['grouptype'] == 1) {
			$candone = true;
		} else {
			// 判断当前用户是不是回答者本人
			
			if ($this->user ['uid'] == $answer ['authorid']) {
				$candone = true;
			}
		}
		
		if ($candone == false) {
			
			$message ['message'] = "非法操作,您的ip已被系统记录！";
			echo json_encode ( $message );
			exit ();
		}
		
		if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1') {
			if ($this->user ['active'] != 1) {
				
				$message ['message'] = "必须激活邮箱才能修改回答!";
				echo json_encode ( $message );
				exit ();
			}
		}
		
		if (! $answer) {
			
			$message ['message'] = "回答不存在或已被删除！";
			echo json_encode ( $message );
			exit ();
		}
		$question = $this->question_model->get ( $answer ['qid'] );
		
		// 悬赏问题如果被采纳就禁止编辑
		if ($question ['shangjin'] > 0 && $question ['status'] == 2 || $question ['shangjin'] > 0 && $question ['status'] == 9) {
			$message ['message'] = "悬赏问题已经被解决，无法在编辑!";
			echo json_encode ( $message );
			exit ();
		}
		$navlist = $this->category_model->get_navigation ( $question ['cid'], true );
		if (null !== $this->input->post ( 'submit' )) {
			if ($this->user ['grouptype'] != 1 && $this->setting ['code_ask']) {
				if (strtolower ( trim ( $this->input->post ( 'code' ) ) ) != $this->user_model->get_code () && $this->user ['credit1'] < $this->setting ['jingyan']) {
					
					$message ['message'] = "验证码错误!";
					echo json_encode ( $message );
					exit ();
				}
			}
			$content = $this->input->post ( 'content' ); // false关闭 xss过滤检测
			$content = str_replace ( "<script", "<code><script", $content );
			$content = str_replace ( "</script>", "</code></script>", $content );
			$content = str_replace ( "&lt;video", "<video ", $content );
			$content = str_replace ( "&gt;&lt;/video&gt;", "</video> ", $content );
			$viewurl = urlmap ( 'question/view/' . $question ['id'], 2 );
			
			// 检查审核和内容外部URL过滤
			$status = intval ( 2 != (2 & $this->setting ['verify_question']) );
			$allow = $this->setting ['allow_outer'];
			if (3 != $allow && has_outer ( $content )) {
				if (0 == $allow) {
					
					$message ['message'] = "内容包含外部链接，发布失败!";
					echo json_encode ( $message );
					exit ();
				}
				1 == $allow && $status = 0;
				2 == $allow && $content = filter_outer ( $content );
			}
			// 检查违禁词
			$contentarray = checkwords ( $content );
			1 == $contentarray [0] && $status = 0;
			if (2 == $contentarray [0]) {
				
				$message ['message'] = "内容包含非法关键词，发布失败!";
				echo json_encode ( $message );
				exit ();
			}
			$content = $contentarray [1];
			
			if ($this->user ['groupid'] == 1) {
				$status = 2;
			}
			$this->answer_model->update_content ( $aid, $content, $status );
			$quser = $this->user_model->get_by_uid ( $question ['authorid'] );
			global $setting;
			$mpurl = SITE_URL . $setting ['seo_prefix'] . $viewurl . $setting ['seo_suffix'];
			// 发送邮件通知
			$subject = "问题有新回答！";
			$emailmessage = $content . '<p>现在您可以点击<a swaped="true" target="_blank" href="' . $mpurl . '">查看最新回复</a>。</p>';
			if (isset ( $this->setting ['notify_mail'] ) && $this->setting ['notify_mail'] == '1' && $quser ['active'] == 1) {
				sendmail ( $quser, $subject, $emailmessage );
			}
			if (0 == $status) {
				$message ['sh'] = 1;
			}
			
			$message ['url'] = $mpurl;
			
			$message ['message'] = 'ok';
			
			echo json_encode ( $message );
			exit ();
		}
	}
	// 搜索全部问题
	
	// 搜索问题
	function searchquestion($word, $qstatus) {
		$questionlist = $this->question_model->search_title ( $word, $qstatus, 0, 0, $this->serach_num );
		
		$lis = '';
		
		foreach ( $questionlist as $key => $val ) {
			$title = $questionlist [$key] ['title'];
			$suffix = '?';
			if ($this->setting ['seo_on']) {
				$suffix = '';
			}
			$fix = $this->setting ['seo_suffix'];
			$title = str_replace ( '<em>', '', strtolower ( $title ) );
			$title = str_replace ( '</em>', '', strtolower ( $title ) );
			$title = str_replace ( '&lt;font color=red&gt;', '', strtolower ( $title ) );
			$title = str_replace ( '&lt;/font&gt;', '', strtolower ( $title ) );
			$li = ' <li class="item qitem" data-index="' . $key . '"><a href="' . SITE_URL . $suffix . 'q-' . $questionlist [$key] ['id'] . $fix . '" text="网页提问词语联想第' . $key . '条">' . strip_tags ( $title ) . '</a> </li>';
			$lis = $lis . $li;
		}
		echo $lis;
		exit ();
	}
	// 搜索文章
	function searcharticle($word) {
		$topiclist = $this->topic_model->list_by_tag ( $word, 0, $this->serach_num );
		if ($topiclist == null) {
			
			$topiclist = $this->topic_model->get_bylikename ( $word, 0, $this->serach_num );
		}
		
		$lis = '';
		
		$suffix = '?';
		if ($this->setting ['seo_on']) {
			$suffix = '';
		}
		$fix = $this->setting ['seo_suffix'];
		
		foreach ( $topiclist as $key => $val ) {
			$title = $topiclist [$key] ['title'];
			$imgurl = $topiclist [$key] ['image'];
			
			$index = strpos ( $imgurl, 'http' );
			if ($index != 0) {
				$imgurl = SITE_URL . $imgurl;
			}
			$title = str_replace ( '<em>', '', strtolower ( $title ) );
			$title = str_replace ( '</em>', '', strtolower ( $title ) );
			$title = str_replace ( '&lt;font color=red&gt;', '', strtolower ( $title ) );
			$title = str_replace ( '&lt;/font&gt;', '', strtolower ( $title ) );
			$li = ' <li class="item articleitem" data-index="' . $key . '">
          	  <a href="' . SITE_URL . $suffix . 'article-' . $topiclist [$key] ['id'] . $fix . '" text="网页提问词语联想第' . $key . '条">' . '<div class="row"><div class="col-sm-3">
          	  <img class="img-rounded pull-left" width="80" height="50" src="' . $imgurl . '" />
          	  </div><div class="col-sm-9 "><p class="art-desc pull-left color-white">' . str_replace ( '&nbsp;', '', strip_tags ( $title ) ) . '</p>


          	  </div></div>' . '</a> </li>';
			$lis = $lis . $li;
		}
		echo $lis;
		exit ();
	}
	// 搜索标签
	function searchtag($word) {
		$taglist = $this->tag_model->list_by_tagname ( $word, 0, $this->serach_num );
		$lis = '';
		
		$suffix = '?';
		if ($this->setting ['seo_on']) {
			$suffix = '';
		}
		$fix = $this->setting ['seo_suffix'];
		if ($taglist) {
			$lis = '<li class="list-group-item bold nopadding">问题话题<hr><li>';
		}
		foreach ( $taglist as $key => $val ) {
			$title = $taglist [$key] ['name'];
			$qcountarr = $taglist [$key] ['count'];
			$qcount = $qcountarr ['sum'];
			$title = str_replace ( '<em>', '', strtolower ( $title ) );
			$title = str_replace ( '</em>', '', strtolower ( $title ) );
			$title = str_replace ( '&lt;font color=red&gt;', '', strtolower ( $title ) );
			$title = str_replace ( '&lt;/font&gt;', '', strtolower ( $title ) );
			$li = ' <li class="item tagitem" data-index="' . $key . '"><a href="' . SITE_URL . $suffix . 'tag-' . $taglist [$key] ['name'] . $fix . '" ><span class="label label-danger pull-left mar-l-05 mar-t-05">' . strip_tags ( $title ) . '</span><span class="pull-right  mar-r-1 font-12">' . $qcount . '个讨论</span></a> </li>';
			$lis = $lis . $li;
		}
		
		$topictaglist = $this->topic_tag_model->list_by_tagname ( $word, 0, $this->serach_num );
		if ($topictaglist) {
			$lis = '<li class="list-group-item bold nopadding">文章话题<hr><li>';
		}
		foreach ( $topictaglist as $key => $val ) {
			$title = $topictaglist [$key] ['name'];
			$qcountarr = $topictaglist [$key] ['count'];
			$qcount = $qcountarr ['sum'];
			$title = str_replace ( '<em>', '', strtolower ( $title ) );
			$title = str_replace ( '</em>', '', strtolower ( $title ) );
			$title = str_replace ( '&lt;font color=red&gt;', '', strtolower ( $title ) );
			$title = str_replace ( '&lt;/font&gt;', '', strtolower ( $title ) );
			$li = ' <li class="item tagitem" data-index="' . $key . '"><a href="' . SITE_URL . $suffix . 'tag-' . $topictaglist [$key] ['name'] . $fix . '" ><span class="label label-danger pull-left mar-l-05 mar-t-05">' . strip_tags ( $title ) . '</span><span class="pull-right  mar-r-1 font-12">' . $qcount . '个讨论</span></a> </li>';
			$lis = $lis . $li;
		}
		
		echo $lis;
		exit ();
	}
	// 搜索用户
	function searchuser($word) {
		$userlist = $this->user_model->list_by_search_condition ( " username like '%$word%'", 0, $this->serach_num );
		
		$lis = '';
		
		$suffix = '?';
		if ($this->setting ['seo_on']) {
			$suffix = '';
		}
		$fix = $this->setting ['seo_suffix'];
		
		foreach ( $userlist as $key => $val ) {
			$username = $userlist [$key] ['username'];
			$avatar = $userlist [$key] ['avatar'];
			$uid = $userlist [$key] ['uid'];
			$answers = $userlist [$key] ['answers'];
			$followers = $userlist [$key] ['followers'];
			
			$li = ' <li class="useritem" data-index="' . $key . '">
          	  <div class="row clear"><div class="col-sm-2"><img width="45" height="45" class="img-rounded" src="' . $avatar . '" alt="' . $username . '" /></div>
          	  <div class="col-sm-10">
          	  <a class="text-danger clear bold font-12" href="' . SITE_URL . $suffix . 'u-' . $uid . $fix . '">' . $username . '</a>

          	  <span class="text-danger mar-ly-05">回答( ' . $answers . ')</span><span class="text-danger mar-ly-05">关注(' . $followers . ')</span>

          	  </div>
          	  </div>
          	   </li>';
			$lis = $lis . $li;
		}
		echo $lis;
		exit ();
	}
	/* 搜索页面 */
	function searchkey() {
		if ($this->input->post ( 'word' )) {
			if (is_mobile ()) {
				header ( "Location:" . SITE_URL . '?q=' . urlencode ( $this->input->post ( 'word' ) ) );
				
				exit ();
			}
			$tagid = $this->input->post ( 'tagid' );
			$qstatus = $status = $this->uri->segment ( 4 ) ? $this->uri->segment ( 4 ) : 1;
			(1 == $status) && ($qstatus = "1,2,6,9");
			(2 == $status) && ($qstatus = "2,6");
			$word = trim ( $this->input->post ( 'word' ) ) ? trim ( $this->input->post ( 'word' ) ) : urldecode ( $this->uri->segment ( 3 ) );
			$word = str_replace ( array (
					"\\",
					"'",
					" ",
					"/",
					"&" 
			), "", $word );
			$word = strip_tags ( $word );
			$word = htmlspecialchars ( $word );
			$word = taddslashes ( $word, 1 );
			switch ($tagid) {
				case '0' :
					$this->searchquestion ( $word, $qstatus );
					break;
				case '1' :
					$this->searchquestion ( $word, $qstatus );
					break;
				case '2' :
					$this->searcharticle ( $word );
					break;
				case '3' :
					$this->searchtag ( $word );
					break;
				case '4' :
					$this->searchuser ( $word );
					break;
			}
		} else {
			include template ( "searchkey" );
		}
	}
	/* 搜索问题 */
	function search() {
		$hidefooter = 'hidefooter';
		$type = "question";
		$qstatus = $status = $this->uri->rsegments [4] ? $this->uri->rsegments [4] : 1;
		(1 == $status) && ($qstatus = "1,2,6,9");
		(2 == $status) && ($qstatus = "2,6");
		if ($this->input->post ( 'word' )) {
			$tmpstr = $this->input->post ( 'word' );
			// $_tmpword=explode('.', $tmpstr);
			
			// if(is_array($_tmpword)){
			// $tmpstr=$_tmpword[0];
			// }
			header ( "Location:" . url ( 'question/search' ) . '?word=' . urlencode ( $tmpstr ) );
			
			exit ();
		}
		
		$this->load->helper ( 'security' );
		
		if ($this->uri->rsegments [3]) {
			$word = xss_clean ( $this->uri->rsegments [3] );
		} else {
			if ($_GET ['word']) {
				$word = xss_clean ( $_GET ['word'] );
			} else {
				$word = xss_clean ( $_GET [0] );
			}
		}
		if (isset ( $_SERVER ['HTTP_X_REWRITE_URL'] )) {
			
			if (function_exists ( "iconv" ) && $this->uri->rsegments [3] != null) {
				$_word = iconv ( "GB2312", "UTF-8//IGNORE", $this->uri->rsegments [3] );
			}
		} else if (isset ( $_SERVER ['ORIG_PATH_INFO'] )) {
			$_word = iconv ( "GB2312", "UTF-8//IGNORE", $this->uri->rsegments [3] );
		}
		if (! $_word) {
			
			$_word = null !== $word ? urldecode ( $word ) : $this->setting ['site_name'];
		}
		
		$tagpre = substr ( $_word, 0, 2 );
		if ($tagpre == 'q_') {
			$tagpinyin = substr ( $_word, 2, strlen ( $_word ) - 1 ); // 获取tag拼音
			
			$this->load->model ( 'tag_model' );
			$_word = $this->tag_model->getname_by_pinyin ( $_word );
		}
		
		$word = trim ( $this->input->post ( 'word' ) ) ? trim ( $this->input->post ( 'word' ) ) : urldecode ( $_word );
		
		(! $word) && $this->message ( "搜索关键词不能为空!", 'BACK' );
		if (strpos ( $this->uri->segment ( 2 ), 'tag' ) > 0) {
			$navtitle = $word;
		} else {
			$navtitle = $word;
		}
		$seo_keywords = $word;
		if ($_GET ['pageindex']) {
			@$page = max ( 1, intval ( $_GET ['pageindex'] ) );
		} else {
			@$page = max ( 1, intval ( $this->uri->rsegments [5] ) );
		}
		
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		if (preg_match ( "/^tag:(.+)/", $word, $tagarr )) {
			$tag = $tagarr [1];
			$word = $tag;
			
			// $rownum = $_ENV['question']->rownum_by_tag($tag, $qstatus);
			// $questionlist1 = $_ENV['question']->list_by_tag($tag, $qstatus, $startindex, $pagesize);
		}
		$geshiword = addslashes ( $word );
		$questionlist1 = $this->question_model->search_title ( $geshiword, $qstatus, 0, $startindex, $pagesize );
		
		$rownum = $this->question_model->search_title_num ( $geshiword, $qstatus );
		
		// if(count($questionlist)==0){
		// $tagarr=dz_segment($word);
		// print_r($tagarr);
		// exit();
		// if(count($tagarr)>0){
		// $tag = $tagarr[0];
		// $rownum = $_ENV['question']->rownum_by_tag($tag, $qstatus);
		// $questionlist2=$_ENV['question']->list_by_tag($tag,$qstatus, $startindex, $pagesize);
		// }
		
		// }
		$questionlist = $questionlist1; // array_merge($questionlist1,$questionlist2);
		if (is_array ( $rownum )) {
			$rownum = $rownum ['num'];
		}
		
		if ($rownum == 0) {
			$seo_keywords = "";
			$navtitle = '暂无搜索相关信息';
		} else {
			
			$navtitle = "问答关于-$word-的相关搜索";
		}
		$related_words = $this->question_model->get_related_words ();
		$hot_words = $this->question_model->get_hot_words ();
		$corrected_words = $this->question_model->get_corrected_word ( $word );
		// $departstr = page ( $rownum, $pagesize, $page, "question/search/$word/$status" );
		$pageurl = url ( 'question/search' ) . "?word=$word";
		$departstr = cpage ( $rownum, $pagesize, $page, $pageurl );
		
		include template ( 'search' );
	}
	
	/* 提问自动搜索已经解决的问题 */
	function ajaxsearch() {
		$title = $this->uri->segment ( 3 );
		$questionlist = $this->question_model->search_title ( $title, 2, 1, 0, 5 );
		include template ( 'ajaxsearch' );
	}
	function delete() {
		$qid = intval ( $this->uri->segment ( 3 ) );
		$question = $this->question_model->get ( $qid );
		
		// 判断当前用户是不是超级管理员
		$candone = false;
		if ($this->user ['grouptype'] == 1) {
			$candone = true;
		} else {
			// 判断当前用户是不是回答者本人
			
			if ($this->user ['uid'] == $question ['authorid']) {
				$candone = true;
			}
		}
		
		if ($candone == false) {
			$this->message ( "非法操作,您的ip已被系统记录！", "STOP" );
		}
		// if ($question ['shangjin'] > 0) {
		// $this->message ( "此问题有悬赏金额，不能删除！" );
		// }
		$touser = $this->user_model->get_by_uid ( $question ['authorid'] );
		if ($touser ['notify'] ['content_handled'] == 1 && $touser ['uid'] != $this->user ['uid']) {
			$sendmessage = '<p>现在您可以进个人中心点击<a swaped="true" target="_blank" href="' . url ( "user/ask" ) . '">查看我的问题</a>。</p>';
			sendmail ( $touser, '您的问题[' . $question ['title'] . ']已被删除', $sendmessage );
		}
		if ($question ['price'] > 0) {
			$this->credit ( $question ['authorid'], 0, $question ['price'], 0, 'back' );
		}
		
		if ($question ['hidden'] > 0) {
			$this->credit ( $question ['authorid'], 0, 10, 0, 'hiddenback' );
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
		
		$this->credit ( $question ['authorid'], - $koujiancredit1, - $koujiancredit2, 0, 'delquestion' );
		
		$this->question_model->remove ( intval ( $qid ) );
		// 问题用户提问数-1
		$this->db->query ( "update " . $this->db->dbprefix . "user set questions=questions-1 where uid=" . $question ['authorid'] );
		$this->load->model ( 'depositmoney_model' );
		// 删除这个问题没有被采纳的悬赏，返回到用户钱包里
		$this->depositmoney_model->remove ( $question ['authorid'], 'qid', $question ['id'] );
		// 删除这个问题没有被专家回答的，返回到用户钱包里
		$this->depositmoney_model->remove ( $question ['authorid'], 'eqid', $question ['id'] );
		$this->message ( '问题删除成功！', 'index' );
	}
	
	// 问题推荐
	function recommend() {
		$qid = intval ( $this->uri->segment ( 3 ) );
		$this->question_model->change_recommend ( $qid, 6, 2 );
		$viewurl = urlmap ( 'question/view/' . $qid, 2 );
		$this->message ( '问题推荐成功!', $viewurl );
	}
	
	// 编辑问题
	function edit() {
		$navtitle = '编辑问题';
		$qid = $this->uri->segment ( 3 ) ? $this->uri->segment ( 3 ) : $this->input->post ( 'qid' );
		$qid = intval ( $qid );
		$question = $this->question_model->get ( $qid );
		// 判断当前用户是不是超级管理员
		$candone = false;
		if ($this->user ['grouptype'] == 1) {
			$candone = true;
		} else {
			// 判断当前用户是不是回答者本人
			
			if ($this->user ['uid'] == $question ['authorid']) {
				$candone = true;
			}
		}
		
		if ($candone == false) {
			$this->message ( "非法操作,您的ip已被系统记录！", "STOP" );
		}
		
		if (! $question)
			$this->message ( "问题不存在或已被删除!", "STOP" );
		
		if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1') {
			if ($this->user ['active'] != 1 && $this->user ['credit1'] < $this->setting ['jingyan']) {
				
				$this->message ( "必须激活邮箱才能编辑问题!", urlmap ( 'question/view/' . $qid, 2 ) );
			}
		}
		if (is_mobile ()) {
			$catetree = $this->category_model->get_categrory_tree ( 1 );
		}
		$navlist = $this->category_model->get_navigation ( $question ['cid'], true );
		if (null !== $this->input->post ( 'submit' )) {
			if ($this->user ['grouptype'] != 1 && $this->user ['credit1'] < $this->setting ['jingyan']) {
				if (strtolower ( trim ( $this->input->post ( 'code' ) ) ) != $this->user_model->get_code ()) {
					$this->message ( "验证码错误!", 'BACK' );
				}
			}
			$viewurl = urlmap ( 'question/view/' . $qid, 2 );
			$title = trim ( $this->input->post ( 'title' ) );
			(! trim ( $title )) && $this->message ( '问题标题不能为空!', $viewurl );
			
			// 更新问题详情
			$tags = trim ( $this->input->post ( 'tags' ), ',' );
			$cid1 = intval ( $this->input->post ( 'cid1' ) );
			$cid2 = intval ( $this->input->post ( 'cid2' ) );
			$cid3 = intval ( $this->input->post ( 'cid3' ) );
			$cid = intval ( $this->input->post ( 'cid' ) );
			if ($cid == 0) {
				$this->message ( '请选择分类!', $viewurl );
			}
			$datapos = array (
					'title' => $title,
					'cid' => $cid,
					'cid1' => $cid1,
					'cid2' => $cid2,
					'cid3' => $cid3,
					'description' => htmlspecialchars ( $this->input->post ( 'content' ) ) 
			
			);
			$this->db->wehre ( array (
					'id' => $qid 
			) )->update ( 'question', $datapos );
			if ($tags != '' && $tags != null) {
				$taglist = explode ( ",", $tags );
				$taglist && $this->tag_model->multi_addquestion ( array_unique ( $taglist ), $qid, $cid, $this->user ['uid'] );
			}
			// $this->question_model->update_content ( $qid, $title, $this->input->post ( 'content', FALSE ) );
			$this->message ( '问题编辑成功!', $viewurl );
		}
		$taglist = $this->tag_model->get_by_qid ( $qid );
		
		$categoryjs = $this->category_model->get_js ( 0, 1 );
		
		include template ( "editquestion" );
	}
	function ajaxedit() {
		$message = array ();
		$qid = $this->uri->segment ( 3 ) ? $this->uri->segment ( 3 ) : $this->input->post ( 'qid' );
		$qid = intval ( $qid );
		$question = $this->question_model->get ( $qid );
		if (! $question) {
			$message ['message'] = "问题不存在或已被删除!";
			echo json_encode ( $message );
			exit ();
		}
		// 判断当前用户是不是超级管理员
		$candone = false;
		if ($this->user ['grouptype'] == 1) {
			$candone = true;
		} else {
			// 判断当前用户是不是回答者本人
			
			if ($this->user ['uid'] == $question ['authorid']) {
				$candone = true;
			}
		}
		
		if ($candone == false) {
			$message ['message'] = "error!";
			echo json_encode ( $message );
			exit ();
		}
		
		if ($this->user ['grouptype'] != 1 && $this->user ['credit1'] < $this->setting ['jingyan']) {
			if (strtolower ( trim ( $this->input->post ( 'code' ) ) ) != $this->user_model->get_code ()) {
				
				$message ['message'] = "验证码错误!";
				echo json_encode ( $message );
				exit ();
			}
		}
		if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1') {
			if ($this->user ['active'] != 1) {
				
				$message ['message'] = "必须激活邮箱才能编辑问题!";
				echo json_encode ( $message );
				exit ();
			}
		}
		// 悬赏问题如果被采纳就禁止编辑
		if ($question ['shangjin'] > 0 && $question ['status'] == 2 || $question ['shangjin'] > 0 && $question ['status'] == 9) {
			$message ['message'] = "悬赏问题已经被解决，无法在编辑!";
			echo json_encode ( $message );
			exit ();
		}
		$navlist = $this->category_model->get_navigation ( $question ['cid'], true );
		if (null !== $this->input->post ( 'submit' )) {
			$viewurl = urlmap ( 'question/view/' . $qid, 2 );
			$title = trim ( $this->input->post ( 'title' ) );
			if (! trim ( $title )) {
				
				$message ['message'] = '问题标题不能为空!';
				echo json_encode ( $message );
				exit ();
			}
			$content = $this->input->post ( 'content' );
			$content = str_replace ( "&lt;video", "<video ", $content );
			$content = str_replace ( "&gt;&lt;/video&gt;", "</video> ", $content );
			// 更新问题详情
			$tags = trim ( $this->input->post ( 'tags' ), ',' );
			$cid1 = intval ( $this->input->post ( 'cid1' ) );
			$cid2 = intval ( $this->input->post ( 'cid2' ) );
			$cid3 = intval ( $this->input->post ( 'cid3' ) );
			$cid = intval ( $this->input->post ( 'cid' ) );
			if ($cid == 0) {
				$message ['message'] = '分类没有选择!';
				echo json_encode ( $message );
				exit ();
			}
			$datapos = array (
					'title' => $title,
					'cid' => $cid,
					'cid1' => $cid1,
					'cid2' => $cid2,
					'cid3' => $cid3,
					'description' => $content 
			
			);
			$this->db->where ( array (
					'id' => $qid 
			) )->update ( 'question', $datapos );
			if ($tags != '' && $tags != null) {
				$taglist = explode ( ",", $tags );
				$taglist && $this->tag_model->multi_addquestion ( array_unique ( $taglist ), $qid, $cid, $this->user ['uid'] );
			}
			
			// $this->question_model->update_content ( $qid, $title, $content );
			global $setting;
			$message ['url'] = url ( $viewurl );
			$message ['message'] = 'ok';
			echo json_encode ( $message );
			exit ();
		}
	}
	
	// 编辑标签
	function edittag() {
		$tag = trim ( $this->input->post ( 'qtags' ) );
		$qid = intval ( $this->input->post ( 'qid' ) );
		$question = $this->question_model->get ( $qid );
		$cid = $question ['cid'];
		$viewurl = urlmap ( "question/view/$qid", 2 );
		$message = $tag ? "标签修改成功!" : "标签不能为空!";
		$taglist = explode ( ",", $tag );
		if ($question ['authorid'] != $this->user ['uid'] && $this->user ['groupid'] != 1) {
			$this->message ( "您无权限操作", $viewurl );
		}
		$taglist && $this->tag_model->multi_addquestion ( array_unique ( $taglist ), $qid, $cid, $this->user ['uid'] );
		
		$this->message ( $message, $viewurl );
	}
	
	// 移动分类
	function movecategory() {
		if (intval ( $this->input->post ( 'category' ) )) {
			$cid = intval ( $this->input->post ( 'category' ) );
			$cid1 = 0;
			$cid2 = 0;
			$cid3 = 0;
			$qid = intval ( $this->input->post ( 'qid' ) );
			$viewurl = urlmap ( 'question/view/' . $qid, 2 );
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
				$this->message ( '分类不存在，请更下缓存!', $viewurl );
			}
			$this->question_model->update_category ( $qid, $cid, $cid1, $cid2, $cid3 );
			$this->message ( '问题分类修改成功!', $viewurl );
		}
	}
	
	// 前台删除问题回答
	function deleteanswer() {
		if ($this->user ['uid'] == 0) {
			$this->message ( "你还没登录!", 'user/login' );
		}
		$qid = intval ( $this->uri->segment ( 4 ) );
		$aid = intval ( $this->uri->segment ( 3 ) );
		$viewurl = urlmap ( 'question/view/' . $qid, 2 );
		$answer = $this->answer_model->get ( $aid );
		if ($answer ['authorid'] != $this->user ['uid'] && $this->user ['grouptype'] != 1) {
			$this->message ( "非法操作!", $viewurl );
		}
		$question = $this->question_model->get ( $answer ['qid'] );
		// 悬赏问题如果被采纳就禁止编辑
		if ($question ['shangjin'] > 0 && $question ['status'] == 2 || $question ['shangjin'] > 0 && $question ['status'] == 9) {
			$this->message ( "悬赏问题已经被解决，无法在编辑!" );
		}
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
		
		$this->answer_model->remove_by_qid ( $aid, $qid );
		$this->message ( "回答删除成功!", $viewurl );
	}
	
	// 前台审核回答
	function verifyanswer() {
		$qid = intval ( $this->uri->segment ( 4 ) );
		$aid = intval ( $this->uri->segment ( 3 ) );
		$viewurl = urlmap ( 'question/view/' . $qid, 2 );
		$this->answer_model->change_to_verify ( $aid );
		$this->message ( "回答审核完成!", $viewurl );
	}
	
	// 问题关注
	function attentto() {
		$qid = intval ( $this->uri->segment ( 3 ) );
		if (! $qid) {
			$this->message ( "问题不存在!" );
		}
		if ($this->user ['uid'] == 0) {
			$this->message ( "游客不能收藏!" );
		}
		$is_followed = $this->question_model->is_followed ( $qid, $this->user ['uid'] );
		if ($is_followed) {
			$this->user_model->unfollow ( $qid, $this->user ['uid'] );
			$this->doing_model->deletedoing ( $this->user ['uid'], 4, $qid );
			$this->message ( "已取消收藏!" );
		} else {
			$this->user_model->follow ( $qid, $this->user ['uid'], $this->user ['username'] );
			$question = $this->question_model->get ( $qid );
			$msgfrom = $this->setting ['site_name'] . '管理员';
			$username = addslashes ( $this->user ['username'] );
			$authorid = $question ['authorid']; // 获取作者uid
			$touser = $this->user_model->get_by_uid ( $authorid );
			// 如果设置有人收藏我问题私信我
			if ($touser ['notify'] ['bookmark_object'] == 1) {
				$this->load->model ( "message_model" );
				$viewurl = url ( 'question/view/' . $qid, 1 );
				$this->message_model->add ( $msgfrom, 0, $question ['authorid'], $username . "刚刚收藏了您的问题", '<a target="_blank" href="' . url ( 'user/space/' . $this->user ['uid'], 1 ) . '">' . $username . '</a> 刚刚关注了您的问题' . $question ['title'] . '"<br /> <a href="' . $viewurl . '">点击查看</a>', 'attentionquestion' );
			}
			
			$this->doing_model->add ( $this->user ['uid'], $this->user ['username'], 4, $qid );
			
			$this->message ( "问题收藏成功!" );
		}
	}
	function follow() {
		$qid = intval ( $this->uri->segment ( 3 ) );
		$question = taddslashes ( $this->question_model->get ( $qid ), 1 );
		if (! $question) {
			$this->message ( "问题不存在!" );
			exit ();
		}
		$page = max ( 1, intval ( $this->uri->segment ( 4 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$followerlist = $this->question_model->get_follower ( $qid, $startindex, $pagesize );
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'question_attention', " qid=$qid ", $this->db->dbprefix ) )->row_array () );
		;
		$departstr = page ( $rownum, $pagesize, $page, "question/follow/$qid" );
		include template ( "question_follower" );
	}
}

?>