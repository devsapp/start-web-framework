<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class User extends CI_Controller {
	var $whitelist;
	public function __construct() {
		$this->whitelist = "getphonepass,usernotify,home,invatelist,myjifen,invateme,search,spacefollower,vertifyemail,creditrecharge,vertify,editemail,editphone,sendcheckmail,space_attention,userzhangdan,userbank,postrequestmoney,getpwdsmscode,getsmscode";
		parent::__construct ();
		$this->load->model ( 'user_model' );
		
		$this->load->model ( 'topic_model' );
		$this->load->model ( 'question_model' );
		$this->load->model ( 'answer_model' );
		$this->load->model ( "category_model" );
		$this->load->model ( "favorite_model" );
	}
	/**
	 *
	 * 用户中心主页
	 *
	 * @date: 2018年12月22日 上午10:39:12
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function index() {
		$this->score ();
	}
	function code() {
		ob_clean ();
		$code = random ( 4 );
		$this->user_model->save_code ( strtolower ( $code ) );
		makecode ( $code );
	}
	// 发送短信验证码
	function getpwdsmscode() {
		// $startime=tcookie('smstime');
		// $timespan=time()-$startime;
		// echo $timespan;exit();
		if ($this->setting ['smscanuse'] == 0) {
			echo '0';
			exit ();
		}
		$phone = $this->input->post ( 'phone' );
		if (! preg_match ( "/^1[23456789]{1}\d{9}$/", $phone )) {
			
			exit ( "3" );
		}
		
		$userone = $this->user_model->get_by_phone ( $phone );
		if ($userone == null) {
			exit ( '2' );
		}
		
		session_start ();
		if ($_SESSION ["time"] != null) {
			$startime = $_SESSION ['time'];
			
			$timespan = time () - $startime;
			
			if ($timespan < 60) {
				
				echo '两次发送时间间隔太短';
				exit ();
			} else {
				$phone = $this->input->post ( 'phone' );
				$_SESSION ["time"] = null;
				$_SESSION ["time"] = time ();
				$code = random ( 4, 1 );
				$this->user_model->save_code ( strtolower ( $code ), "phonecode" );
				$codenum = $this->setting ['smstmpvalue'];
				$codenum = str_replace ( '{code}', $code, $codenum );
				
				switch ($this->setting ['allow_smsplatform']) {
					case 'aliyun' :
						$smsresult = aliyunsms ( $phone, $this->setting ['aliyunsmsfindpwdtmpid'], $code );
						if ($smsresult ['Message'] == 'OK') {
							exit ( '1' );
						} else {
							exit ( $smsresult ['Message'] );
						}
						
						break;
					case 'juhe' :
						$msg = sendsms ( $this->setting ['smskey'], $phone, $this->setting ['smstmpid'], $codenum );
						
						exit ( '1' );
						break;
				}
			}
		} else {
			// $phone=$this->post['phone'];
			// $userone=$_ENV['user']->get_by_phone($phone);
			// if($userone!=null){
			// exit("2");
			// }
			
			$code = random ( 4, 1 );
			$this->user_model->save_code ( strtolower ( $code ), "phonecode" );
			$codenum = $this->setting ['smstmpvalue'];
			$codenum = str_replace ( '{code}', $code, $codenum );
			
			switch ($this->setting ['allow_smsplatform']) {
				case 'aliyun' :
					$smsresult = aliyunsms ( $phone, $this->setting ['aliyunsmsfindpwdtmpid'], $code );
					if ($smsresult ['Message'] == 'OK') {
						$_SESSION ["time"] = time ();
						exit ( '1' );
					} else {
						exit ( $smsresult ['Message'] );
					}
					
					break;
				case 'juhe' :
					$msg = sendsms ( $this->setting ['smskey'], $phone, $this->setting ['smstmpid'], $codenum );
					$_SESSION ["time"] = time ();
					exit ( '1' );
					break;
			}
		}
		
		echo $timespan;
		exit ();
	}
	
	// 发送短信验证码
	function getsmscode() {
		// $startime=tcookie('smstime');
		// $timespan=time()-$startime;
		// echo $timespan;exit();
		if ($this->setting ['smscanuse'] == 0) {
			echo '0';
			exit ();
		}
		$phone = $this->input->post ( 'phone' );
		if (! preg_match ( "/^1[23456789]{1}\d{9}$/", $phone )) {
			
			exit ( "3" );
		}
		if ($_POST ['type'] && $_POST ['type'] == 'reg') {
			$userone = $this->user_model->get_by_phone ( $phone );
			if ($userone != null) {
				exit ( '2' );
			}
		} else {
			if ($_POST ['type'] && $_POST ['type'] == 'edit') {
				// 判断是否是当前手机号被别的用户使用
				$tmpphoeuser = $this->user_model->get_by_phone ( $phone );
				if ($tmpphoeuser && $tmpphoeuser ['uid'] != $this->user ['uid']) {
					exit ( "此手机号已被别的用户使用" );
				}
				// 如果是原来的号码
				if ($tmpphoeuser && $tmpphoeuser ['phoneactive'] == 1) {
					exit ( "您已经激活过此号码" );
				}
			}
		}

		// $userone=$_ENV['user']->get_by_phone($phone);
		// if($userone!=null){
		// exit("2");
		// }
		session_start ();
		if ($_SESSION ["time"] != null) {
			$startime = $_SESSION ['time'];
			
			$timespan = time () - $startime;
			
			if ($timespan < 60) {
				
				echo '两次发送时间间隔太短';
				exit ();
			} else {
				$phone = $this->input->post ( 'phone' );
				$_SESSION ["time"] = null;
				$_SESSION ["time"] = time ();
				$code = random ( 4, 1 );
				$this->user_model->save_code ( strtolower ( $code ), "phonecode" );
				$codenum = $this->setting ['smstmpvalue'];
				$codenum = str_replace ( '{code}', $code, $codenum );
				
				switch ($this->setting ['allow_smsplatform']) {
					case 'aliyun' :
						$smsresult = aliyunsms ( $phone, $this->setting ['aliyunsmsregtmpid'], $code );
						if ($smsresult ['Message'] == 'OK') {
							exit ( '1' );
						} else {
							exit ( $smsresult ['Message'] );
						}
						
						break;
					case 'juhe' :
						$msg = sendsms ( $this->setting ['smskey'], $phone, $this->setting ['smstmpid'], $codenum );
						
						exit ( '1' );
						break;
				}
			}
		} else {
			// $phone=$this->post['phone'];
			// $userone=$_ENV['user']->get_by_phone($phone);
			// if($userone!=null){
			// exit("2");
			// }
			
			$code = random ( 4, 1 );
			$this->user_model->save_code ( strtolower ( $code ), "phonecode" );
			$codenum = $this->setting ['smstmpvalue'];
			$codenum = str_replace ( '{code}', $code, $codenum );
			
			switch ($this->setting ['allow_smsplatform']) {
				case 'aliyun' :
					$smsresult = aliyunsms ( $phone, $this->setting ['aliyunsmsregtmpid'], $code );
					if ($smsresult ['Message'] == 'OK') {
						$_SESSION ["time"] = time ();
						exit ( '1' );
					} else {
						exit ( $smsresult ['Message'] );
					}
					
					break;
				case 'juhe' :
					$msg = sendsms ( $this->setting ['smskey'], $phone, $this->setting ['smstmpid'], $codenum );
					$_SESSION ["time"] = time ();
					exit ( '1' );
					break;
			}
		}
		
		echo $timespan;
		exit ();
	}
	/**
	 *
	 * 用户认证页面
	 *
	 * @date: 2018年12月22日 上午10:39:28
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function vertify() {
		$navtitle = "我的认证中心";
		$uid = $this->user ['uid'];
		if ($uid <= 0) {
			// 没用登录跳转登录
			$this->message ( "请先登录在认证!", 'user/login' );
		}
		$this->load->model ( "vertify_model" );
		$vertify = $this->vertify_model->get_by_uid ( $uid );
		
		if ($vertify ['status'] == null) {
			$vertify ['status'] = - 1;
		}
		$categoryjs = $this->category_model->get_js ();
		include template ( 'myvertify' );
	}
	/**
	 *
	 * ajax认证用户
	 *
	 * @date: 2018年12月22日 上午10:39:47
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function ajaxvertify() {
		$message = array ();
		$uid = $this->user ['uid'];
		if ($uid <= 0) {
			$message ['code'] = 300;
			$message ['result'] = '用户没有登录!';
			exit ();
		}
		
	
		
		$this->load->model ( "vertify_model" );
		$vertify = $this->vertify_model->get_by_uid ( $uid );
		$needpay = doubleval ( $this->setting ['vertifyjine'] ); // 认证费用
		$myyue = round ( doubleval ( $this->user ['jine'] ) / 100 ); // 我的余额
		                                                             // 如果是新认证需要支付费用
		if (! $vertify) {
			// 判断是否付费
			if ($needpay > 0) {
				// 如果需要付费，判断自己账户金额是否足够支付付费认证
				if ($myyue < $needpay) {
					$message ['code'] = 300;
					$message ['result'] = "认证费用" . $needpay . "元，请先充值在认证";
					echo json_encode ( $message );
					exit ();
				}
			}
		}
		$uploadpath = 'data/attach/vertify/';
		if (! is_dir ( $uploadpath )) {
			mkdir ( $uploadpath );
		}
		checkattack ( $_POST ['zhaopian1'] );
		$file = $_POST ['zhaopian1'];
		if(empty($file)){
			$message ['code'] = 300;
			$message ['result'] = "附件一认证图片不能为空";
			echo json_encode ( $message );
			exit ();
		}
		$fileext=strtolower(pathinfo( parse_url($file)['path'] )['extension']);
		$filetype = array (
				"png",
				"jpg",
				"jpeg"
		);
		if (! in_array ( $fileext, $filetype )) {
			$message ['code'] = 300;
			$message ['result'] = "文件格式只允许为png,jpg,jpeg";
			echo json_encode ( $message );
			exit ();
		}
		checkattack ( $_POST ['zhaopian2'] );
		$file2 = $_POST ['zhaopian2'];

		if (!empty($file2)) {
			$file2ext=strtolower(pathinfo( parse_url($file2)['path'] )['extension']);
			$filetype = array (
					"png",
					"jpg",
					"jpeg"
			);
			if (! in_array ( $file2ext, $filetype )) {
				$message ['code'] = 300;
				$message ['result'] = "文件格式只允许为png,jpg,jpeg";
				echo json_encode ( $message );
				exit ();
			}
			
	
		}else{
			if(!empty($vertify ['zhaopian2'])){
				$file2 = $vertify ['zhaopian2'];
			}else{
				$file2='';
			}
		}
		
		$type = intval ( $this->input->post ( 'type' ) );
		$name = strip_tags ( $this->input->post ( 'name' ) );
		$idcode = strip_tags ( $this->input->post ( 'idcode' ) );
		$jieshao = strip_tags ( $this->input->post ( 'jieshao' ) );
		
		$id = $this->vertify_model->add ( $uid, $type, $name, $idcode, $jieshao, $file, $file2, 0 );
		
		if ($id > 0) {
			// 如果提交资料成功
			// 判断是否付费
			if ($needpay > 0) {
				// 判断是否支付过认证费用
				$vertifyone = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "paylog WHERE type='vertify' and typeid=$uid and touid=$uid and fromuid=$uid" )->row_array ();
				if (! $vertifyone) { // 没支付就扣钱
				                     // 需要付费扣除自己账户余额
					$shengyujine = $myyue - $needpay;
					$mycurrentyue = $shengyujine * 100;
					$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET  `jine`=$mycurrentyue WHERE `uid`=$uid" );
					$time = time ();
					$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "paylog SET type='vertify',typeid=$uid,money=$needpay,openid='',fromuid=$uid,touid=$uid,`time`=$time" );
				}
			}
			$message ['code'] = 200;
			$message ['result'] = '提交成功，等待审核!';
			// 取消设置为行家/专家
			$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET `expert`=0 WHERE uid=$uid" );
			if (file_exists ( $uploadpath . $uid . ".txt" ))
				unlink ( $uploadpath . $uid . ".txt" );
		} else {
			$message ['code'] = 300;
			$message ['result'] = '提交失败!';
		}
		echo json_encode ( $message );
	}
	/**
	 *
	 * 搜索用户
	 *
	 * @date: 2018年12月22日 上午10:40:05
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function search() {
		$hidefooter = 'hidefooter';
		$type = "user";
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
		
		if (isset ( $_SERVER ['HTTP_X_REWRITE_URL'] ) && $_GET ['word'] == null) {
			
			if (function_exists ( "iconv" ) && $this->uri->rsegments [3] != null) {
				$word = iconv ( "GB2312", "UTF-8//IGNORE", $this->uri->rsegments [3] );
			}
		} else if (isset ( $_SERVER ['ORIG_PATH_INFO'] ) && $_GET ['word'] == null) {
			$word = iconv ( "GB2312", "UTF-8//IGNORE", $this->uri->rsegments [3] );
		}
		
		$word = taddslashes ( $word, 1 );
		(! $word) && $this->message ( "搜索关键词不能为空!", 'BACK' );
		$navtitle = $word;
		@$page = max ( 1, intval ( $this->uri->rsegments [4] ) );
		// var_dump($this->get);exit();
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$seo_description = $word;
		$seo_keywords = $word;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'user', " username like '%$word%'", $this->db->dbprefix ) )->row_array () );
		$userlist = $this->user_model->list_by_search_condition ( " username like '%$word%'", $startindex, $pagesize );
		
		$departstr = page ( $rownum, $pagesize, $page, "user/search/$word" );
		include template ( 'serach_huser' );
	}
	// 检查http请求的主机和请求的来路域名是否相同，不相同拒绝请求
	function check_apikey() {
		session_start ();
		if ($_SESSION ["tokenid"] == null || $this->input->post ( 'tokenkey' ) == null) {
			$this->message ( '非法操作!', user / addxinzhi );
			exit ();
		}
		if ($_SESSION ["tokenid"] != $this->input->post ( 'tokenkey' )) {
			
			$this->message ( '页面过期，请保存数据刷新页面在操作!', user / addxinzhi );
		}
	}
	
	// 发布文章
	function addxinzhi() {
		if ($this->user ['uid'] == 0) {
			header ( "Location:" . url ( 'user/login' ) );
		}
		$navtitle = "添加文章";
		if (is_mobile ()) {
			
			$catetree = $this->category_model->get_categrory_tree ( 2 );
		}
		$canpublish = intval ( $this->setting ['publisharticleforexpert'] );
		if ($canpublish && $this->user ['grouptype'] != 1) {
			if ($this->user ['expert'] == 0) { // 0 不是专家，1是专家
				$this->message ( '发布文章只对认证专家开放！', 'topic/default' );
			}
		}
		
		if ($this->user ['expert'] == 0) {
			
			if ($this->user ['doarticle'] == 0 && $this->user ['grouptype'] != 1) {
				$this->message ( '您所在用户组站长设置不允许发布文章！', 'topic/default' );
			}
		}
		// 判断财富值是否够
		$neetcredit2 = doubleval ( $this->setting ['credit2_article'] );
		if ($neetcredit2 < 0) {
			if (($this->user ['credit2'] + $neetcredit2) < 0) {
				$this->message ( '您的财富值不够!', "BACK" );
				
				exit ();
			}
		}
		if ($this->input->post ( 'submit' ) !== null) {
			if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1' && $this->user ['grouptype'] != 1) {
				if ($this->user ['active'] != 1) {
					$viewhref = urlmap ( 'user/editemail', 1 );
					$this->message ( "必须激活邮箱才能发布文章!", $viewhref );
				}
			}
			if ($this->user ['isblack'] == 1) {
				$this->message ( '黑名单用户无法发布文章！', 'index/default' );
			}
			/* 检查提问数是否超过组设置 */
			$this->load->model ( "userlog_model" );
			if ($this->user ['articlelimits'] && ($this->userlog_model->rownum_by_time ( 'topic' ) >= $this->user ['articlelimits']) && $this->user ['grouptype'] != 1) {
				
				$this->message ( '你已超过每小时最大文章发布数,请稍后再试！', 'user/addxinzhi' );
				exit ();
			}
			
			$this->load->model ( "tag_model" );
			
			$title = $this->input->post ( 'title' );
			$topic_price = intval ( $this->input->post ( 'topic_price' ) ); // 付费阅读值
			$readmode = intval ( $this->input->post ( 'readmode' ) );
			if ($readmode != '1' && $topic_price < 0) {
				if ($readmode)
					$this->message ( '付费阅读值不能小于0!', "BACK" );
				
				exit ();
			}
			
			if ($readmode == '1') { // 如果是免费阅读将付费阅读值设置为0
				$topic_price = 0;
			}
			$freeconent = $this->input->post ( 'freeconent' );
			$topic_tag = $this->input->post ( 'topic_tag' );
			$ataglist = explode ( ",", str_replace ( '，', ',', $topic_tag ) );
			
			$desrc = htmlspecialchars ( $_POST ['content'] );
			
			$outimgurl = $this->input->post ( 'outimgurl' );
			// $tagarr= dz_segment($title,$desrc);
			$acid = $this->input->post ( 'topicclass' );
			
			// if($ataglist!=null){
			// $tagarr=array_merge($ataglist,$tagarr);
			// }
			
			if ($acid == null)
				$acid = 1;
			
			if (isset ( $_POST ["editor-html-code"] )) {
				
				$desrc = htmlspecialchars ( $_POST ["editor-html-code"] );
			}
			if ('' == $title || '' == strip_tags ( $desrc )) {
				$this->message ( '请完整填写专题相关参数!', 'user/addxinzhi' );
				
				exit ();
			}
			if ($_FILES ['image'] ['name'] == null && trim ( $outimgurl ) == '') {
				$this->message ( '封面图和外部图片至少填写一个!', 'user/addxinzhi' );
				
				exit ();
			}
			if ($_FILES ['image'] ['name'] != null) {
				
				$imgname = strtolower ( $_FILES ['image'] ['name'] );
				$type = substr ( strrchr ( $imgname, '.' ), 1 );
				if (! isimage ( $type )) {
					$this->message ( '当前图片格式不支持，目前仅支持jpg、gif、png格式！', 'user/addxinzhi' );
					
					exit ();
				}
				// 大小验证
				$file_size = 1024 * 1024 * 4;
				if ($_FILES ['image'] ["size"] > $file_size) {
					$this->message ( '当前图片尺寸大于上传最大限制4M！' );
					
					exit ();
				}
				$upload_tmp_file = FCPATH . 'data/tmp/topic_' . random ( 6, 0 ) . '.' . $type;
				
				$filepath = '/data/attach/topic/topic' . random ( 6, 0 ) . '.' . $type;
				forcemkdir ( FCPATH . 'data/attach/topic' );
				
				if (move_uploaded_file ( $_FILES ['image'] ['tmp_name'], $upload_tmp_file )) {
					
					image_resize ( $upload_tmp_file, FCPATH . $filepath, 300, 240, 1 );
					
					$filepath = SITE_URL . $filepath;
				} else {
					
					$this->message ( '服务器忙，请稍后再试！', 'user/addxinzhi' );
				}
			}
			if (trim ( $outimgurl ) != '' && $_FILES ['image'] ['name'] == null) {
				if (strstr ( $outimgurl, '/default.jpg' )) {
					$filepath = $outimgurl;
				} else {
					$filepath = '/data/attach/topic/topic' . random ( 6, 0 ) . '.jpg';
					image_resize ( $outimgurl, FCPATH . $filepath, 300, 240 );
					
					if (! file_exists ( FCPATH . $filepath )) {
						$filepath = $outimgurl;
					} else {
						$filepath = SITE_URL . $filepath;
					}
				}
			}
			
			$aid = $this->topic_model->addtopic ( $title, $desrc, $filepath, $this->user ['username'], $this->user ['uid'], 1, $acid, $topic_price, $readmode, $freeconent );
			$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET articles=articles+1 WHERE  uid =" . $this->user ['uid'] );
			// 发布文章，添加积分
			$this->credit ( $this->user ['uid'], $this->setting ['credit1_article'], $this->setting ['credit2_article'], 0, 'addarticle' );
			
			$this->userlog_model->add ( 'topic' );
			$ataglist && $this->tag_model->multi_addarticle ( array_unique ( $ataglist ), $aid, $acid, $this->user ['uid'] );
			
			$state = 1;
			if ($this->setting ['publisharticlecheck'] && $this->user ['groupid'] >= 6) {
				$state = intval ( $this->setting ['publisharticlecheck'] ) > 0 ? 0 : 1;
			}
			if ($state) {
				$this->load->model ( "doing_model" );
				$this->doing_model->add ( $this->user ['uid'], $this->user ['username'], 9, $aid, $title );
				
				$this->message ( '添加成功！', 'topic/getone/' . $aid );
			} else {
				$this->message ( "文章在审核中", "topic/default" );
			}
		} else {
			// $this->load("topicclass");
			// $topiclist= $_ENV['topicclass']->get_list();
			if ($this->user ['uid'] == 0 || $this->user ['uid'] == null) {
				$this->message ( '您还没有登录！', 'user/login' );
			}
			
			$categoryjs = $this->category_model->get_js ( 0, 2 );
			include template ( 'addxinzhi' );
		}
	}
	// 删除文章
	function deletexinzhi() {
		if ($this->user ['uid'] == 0 || $this->user ['uid'] == null) {
			$this->message ( '非法操作，你的ip已被记录' );
		}
		
		$this->load->model ( "doing_model" );
		$topic = $this->topic_model->get ( intval ( $this->uri->segment ( 3 ) ) );
		
		if ($this->user ['uid'] != $topic ['authorid'] && $this->user ['grouptype'] != 1) {
			$this->message ( '非法操作，你的ip已被记录' );
		}
		
		$this->topic_model->remove ( intval ( $this->uri->segment ( 3 ) ) );
		$this->load->model ( 'topdata_model' );
		$this->topdata_model->remove ( $topic ['id'], 'topic' );
		$uid = $topic ['authorid'];
		
		$this->doing_model->deletedoing ( $uid, 9, $topic ['id'] ); // 删除动态
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET articles=articles-1 WHERE  uid =$uid" );
		// 删除文章，扣减财富值
		$touser = $this->user_model->get_by_uid ( $uid );
		$koujiancredit1 = intval ( $this->setting ['credit1_article'] );
		if ($touser ['credit1'] < $koujiancredit1) {
			$koujiancredit1 = $touser ['credit1'] >= 0 ? $touser ['credit1'] : 0;
		}
		
		$koujiancredit2 = intval ( $this->setting ['credit2_article'] );
		if ($touser ['credit2'] < $koujiancredit2) {
			$koujiancredit2 = $touser ['credit2'] >= 0 ? $touser ['credit2'] : 0;
		}
		
		$this->credit ( $uid, - $koujiancredit1, - $koujiancredit2, 0, 'delarticle' );
		
		$this->message ( '文章删除成功！', 'topic/default' );
	}
	// 编辑文章
	function editxinzhi() {
		if ($this->user ['uid'] == 0) {
			header ( "Location:" . url ( 'user/login' ) );
		}
		if (is_mobile ()) {
			$catetree = $this->category_model->get_categrory_tree ( 2 );
		}
		session_start ();
		$this->load->model ( "tag_model" );
		$this->load->model ( "topic_tag_model" );
		$tid = intval ( $this->uri->segment ( 3 ) ) > 0 ? intval ( $this->uri->segment ( 3 ) ) : intval ( $this->input->post ( 'id' ) );		
		$topic = $this->topic_model->get ( intval ( $tid ) );
		if ($topic ['state'] == 0) {
			$this->message ( "文章正在审核！", "topic/default" );
		}		
		// 判断当前用户是不是超级管理员
		$candone = false;
		if ($this->user ['grouptype'] == 1) {
			$candone = true;
		} else {
			// 判断当前用户是不是回答者本人
			
			if ($this->user ['uid'] == $topic ['authorid']) {
				$candone = true;
			}
		}
		
		if ($candone == false) {
			$this->message ( "非法操作,您的ip已被系统记录！", "STOP" );
		}
		if (null !== $this->input->post ( 'submit' )) {
			if ($this->user ['uid'] == 0 || $this->user ['uid'] == null) {
				$this->message ( '您还没有登录！', 'user/login' );
			}
			// $this->check_apikey();
			$tid = intval ( $this->input->post ( 'id' ) );
			$topic = $this->topic_model->get ( $tid );
			
			if ($topic ['authorid'] != $this->user ['uid'] && $candone == false) {
				$this->message ( '非法操作，你的ip已被记录' );
			}
			if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1') {
				if ($this->user ['active'] != 1) {
					$viewhref = urlmap ( 'user/editemail', 1 );
					$this->message ( "必须激活邮箱才能修改文章!", $viewhref );
				}
			}
			$title = $this->input->post ( 'title' );
			$topic_price = intval ( $this->input->post ( 'topic_price' ) );
			if ($topic_price < 0) {
				$this->message ( '积分不能小于0!', "BACK" );
				
				exit ();
			}
			$topic_tag = $this->input->post ( 'topic_tag' );
			$taglist = explode ( ",", $topic_tag );
			$desrc = htmlspecialchars ( $_POST ['content'] );
			$outimgurl = $this->input->post ( 'outimgurl' );
			$upimg = $this->input->post ( 'upimg' );
			$views = $this->input->post ( 'views' );
			$isphone = $this->input->post ( 'isphone' );
			if ($isphone == 'on') {
				$isphone = 1;
			} else {
				$isphone = 0;
			}
			$acid = $this->input->post ( 'topicclass' );
			if ($acid == null)
				$acid = 1;
			$imgname = strtolower ( $_FILES ['image'] ['name'] );
			if (isset ( $_POST ["editor-html-code"] )) {
				
				$desrc = htmlspecialchars ( $_POST ["editor-html-code"] );
			}
			if ('' == $title || '' == strip_tags ( $desrc )) {
				$this->message ( '请完整填写专题相关参数!', 'BACK' );
				exit ();
			}
			// print_r($tagarr);
			// exit();
			if ($imgname) {
				$type = substr ( strrchr ( $imgname, '.' ), 1 );
				if (! isimage ( $type )) {
					$this->message ( '当前图片图片格式不支持，目前仅支持jpg、gif、png格式！', 'errormsg' );
					exit ();
				}
				// 大小验证
				$file_size = 1024 * 1024 * 4;
				if ($_FILES ['image'] ["size"] > $file_size) {
					$this->message ( '当前图片尺寸大于上传最大限制4M！' );
					
					exit ();
				}
				$filepath = '/data/attach/topic/topic' . random ( 6, 0 ) . '.' . $type;
				$upload_tmp_file = FCPATH . 'data/tmp/topic_' . random ( 6, 0 ) . '.' . $type;
				forcemkdir ( FCPATH . 'data/attach/topic' );
				if (move_uploaded_file ( $_FILES ['image'] ['tmp_name'], $upload_tmp_file )) {
					image_resize ( $upload_tmp_file, FCPATH . $filepath, 300, 240 );
					$filepath = SITE_URL . $filepath;
					$ispc = $topic ['ispc'];
					
					$this->topic_model->updatetopic ( $tid, $title, $desrc, $filepath, $isphone, $views, $acid, $ispc, $topic_price );
					//更新试读内容
					$this->db->where(array('id'=>$tid))->update('topic',array('freeconent'=>$freeconent));					
					$taglist && $this->tag_model->multi_addarticle ( array_unique ( $taglist ), $tid, $acid, $this->user ['uid'] );
					
					$state = 1;
					if ($this->setting ['publisharticlecheck']) {
						$state = intval ( $this->setting ['publisharticlecheck'] ) > 0 ? 0 : 1;
					}
					if ($state) {
						$this->message ( '文章修改成功！', 'topic/getone/' . $tid );
					} else {
						$this->message ( "文章在审核中", "topic/default" );
					}
				} else {
					$this->message ( '服务器忙，请稍后再试！' );
				}
			} else {
				if (trim ( $outimgurl ) == '') {
					$this->message ( '封面图不能为空！', "BACK" );
				}
				// if($outimgurl!=$upimg&&trim($upimg)!=''){
				if (trim ( $outimgurl ) != '' && $_FILES ['image'] ['name'] == null) {
			
					if (strstr ( $outimgurl, '/default.jpg' )) {
						$filepath = $outimgurl;
					} else {
						$filepath = '/data/attach/topic/topic' . random ( 6, 0 ) . '.jpg';
						image_resize ( $outimgurl, FCPATH . $filepath, 300, 240 );
						
						if (! file_exists ( FCPATH . $filepath )) {
							$filepath = $outimgurl;
						} else {
							$filepath = SITE_URL . $filepath;
						}
					}
				}
				
				$upimg = $filepath;
				// }
				$ispc = $topic ['ispc'];
				$freeconent = $this->input->post ( 'freeconent' );
				$this->topic_model->updatetopic ( $tid, $title, $desrc, $upimg, $isphone, $views, $acid, $ispc, $topic_price );
				//更新试读内容
				$this->db->where(array('id'=>$tid))->update('topic',array('freeconent'=>$freeconent));			
				$taglist && $this->tag_model->multi_addarticle ( array_unique ( $taglist ), $tid, $acid, $this->user ['uid'] );
				$state = 1;
				if ($this->setting ['publisharticlecheck'] && $this->user ['groupid'] >= 6) {
					$state = intval ( $this->setting ['publisharticlecheck'] ) > 0 ? 0 : 1;
				}
				if ($state) {
					$this->message ( '文章修改成功！', 'topic/getone/' . $tid );
				} else {
					$this->message ( "文章在审核中", "topic/default" );
				}
			}
		} else {
			
			$topic ['tags'] = $this->tag_model->gettaglistbytypeid ( $topic ['id'], 'article' );
			$tagstr = '';
			foreach ( $topic ['tags'] as $tag ) {
				$tagstr .= $tag ['id'] . ",";
			}
			$topic ['topic_tag'] = trim ( $tagstr, ',' );
			
			$_SESSION ["userid"] = getRandChar ( 56 );
			$catmodel = $this->category_model->get ( $topic ['articleclassid'] );
			$categoryjs = $this->category_model->get_js ( 0, 2 );
			
			include template ( 'editxinzhi' );
		}
	}
	// 注册ip
	function regtip() {
		include template ( 'regtip' );
	}
	function register() {
		if ($this->user ['uid']) {
			header ( "Location:" . SITE_URL );
		}
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		if (strstr ( $useragent, 'MicroMessenger' )) {
			$wxbrower = true;
		}
		$navtitle = '注册新用户';
		
		if (! $this->setting ['allow_register']) {
			$this->message ( "系统注册功能暂时处于关闭状态!", 'STOP' );
		}
		if (isset ( $this->setting ['max_register_num'] ) && $this->setting ['max_register_num'] && ! $this->user_model->is_allowed_register ()) {
			$this->message ( "您的当前的IP已经超过当日最大注册数目，如有疑问请联系管理员!", 'STOP' );
			exit ();
		}
		$forward = isset ( $_SERVER ['HTTP_REFERER'] ) ? $_SERVER ['HTTP_REFERER'] : SITE_URL;
		
		$this->setting ['passport_open'] && ! $this->setting ['passport_type'] && $this->user_model->passport_client (); // 通行证处理
		if (! isset ( $_SESSION )) {
			session_start ();
		}
		$_SESSION ['registrtokenid'] = md5 ( time () );
		$invatecode = strip_tags ( $this->uri->segment ( 3 ) );
		$_SESSION ['invatecode'] = $invatecode;
		include template ( 'register' );
	}
	function login() {
		if ($this->user ['uid']) {
			
			header ( "Location:" . SITE_URL );
		}
		
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		if (strstr ( $useragent, 'MicroMessenger' )) {
			$wxbrower = true;
		}
		$navtitle = '用户登录';
		$forward = isset ( $_SERVER ['HTTP_REFERER'] ) ? $_SERVER ['HTTP_REFERER'] : SITE_URL;
		if (! isset ( $_SESSION )) {
			session_start ();
		}
		$_SESSION ['logintokenid'] = md5 ( time () );
		$_SESSION ['forward'] =$forward;
		include template ( 'login' );
	}
	
	/* 用于ajax检测用户名是否存在 */
	function ajaxusername() {
		$username = $this->input->post ( 'username' );
		// ucenter注册。
		if ($this->setting ["ucenter_open"]) {
			include FCPATH . 'data/ucconfig.inc.php';
			! defined ( 'UC_API' ) && define ( 'UC_API', '1' );
			require_once FCPATH . 'uc_client/client.php';
			$ucenter_user = uc_get_user ( $username );
			if($ucenter_user){
				exit ( '-1' );
			}
		}
	
		$user = $this->user_model->get_by_username ( $username );
		if (is_array ( $user ))
			exit ( '-1' );
		$usernamecensor = $this->user_model->check_usernamecensor ( $username );
		if (FALSE == $usernamecensor)
			exit ( '-2' );
		exit ( '1' );
	}
	/* 用于ajax检测用户名是否存在 */
	function ajaxupdateusername() {
		if ($this->user ['uid'] == 0) {
			exit ( '0' );
		}
		$username = $this->input->post ( 'username' );
		
		$user = $this->user_model->get_by_username ( $username );
		if (is_array ( $user ))
			exit ( '-1' );
		$usernamecensor = $this->user_model->check_usernamecensor ( $username );
		if (FALSE == $usernamecensor)
			exit ( '-2' );
		
		$useremail = $this->input->post ( 'useremail' );
		$emailaccess = $this->user_model->check_emailaccess ( $useremail );
		if (FALSE == $emailaccess) {
			exit ( "-3" );
		}
		$user = $this->user_model->get_by_email ( $useremail );
		if (is_array ( $user )) {
			exit ( '-4' );
		}
		
		// 更新用户名
		$this->user_model->update_username ( $this->user ['uid'], $username, $useremail );
		
		// 发送邮件确认
		$sitename = $this->setting ['site_name'];
		$activecode = md5 ( rand ( 10000, 50000 ) );
		$url = SITE_URL . 'index.php?user/checkemail/' . $this->user ['uid'] . '/' . $activecode;
		$message = "这是一封来自" . $sitename . "邮箱验证，<a target='_blank' href='$url'>请点击此处验证邮箱邮箱账号</a>";
		$v = md5 ( "yanzhengask2email" );
		$v1 = md5 ( "yanzhengask2time" );
		setcookie ( "emailsend" );
		setcookie ( "useremailcheck" );
		$expire1 = time () + 20; // 设置1分钟的有效期
		setcookie ( "emailsend", $v1, $expire1 ); // 设置一个名字为var_name的cookie，并制定了有效期
		$expire = time () + 86400; // 设置24小时的有效期
		setcookie ( "useremailcheck", $v, $expire ); // 设置一个名字为var_name的cookie，并制定了有效期
		$this->user_model->update_emailandactive ( $useremail, $activecode, $this->user ['uid'] );
		$this->user_model->refresh ( $this->user ['uid'], 1 );
		sendmailto ( $useremail, "邮箱验证提醒-$sitename", $message, $this->user ['username'] );
		
		exit ( '1' );
	}
	function ajaxpopwxpay() {
		$type = htmlspecialchars ( $this->uri->segment ( 3 ) );
		$typevalue = htmlspecialchars ( $this->uri->segment ( 4 ) );
		$touser = htmlspecialchars ( $this->uri->segment ( 5 ) );
		
		include template ( "wxpay" );
	}
	function ajaxrequestresult() {
		$message = array ();
		$logdir = FCPATH . '/data/logs/';
		$yearmonth = gmdate ( 'Ym', $_SERVER ['REQUEST_TIME'] );
		$logfile = $logdir . $yearmonth . '_' . $_POST ['name'] . '.php';
		if (! file_exists ( $logfile )) {
			$message ['code'] = 201;
			
			// $message ['filename'] = $logfile;
		} else {
			$message ['code'] = 200;
		}
		echo json_encode ( $message );
		exit ();
	}
	function ajaxgetpaycode() {
		$t1 = htmlspecialchars ( $this->input->post ( 'type' ) );
		$t2 = htmlspecialchars ( $this->input->post ( 'typevalue' ) );
		$t3 = htmlspecialchars ( $this->input->post ( 'touser' ) );
		$t4 = htmlspecialchars ( $this->input->post ( 'money' ) );
		
		$t5 = rand ( 111111111, 999999999 );
		require_once FCPATH . "/lib/wxpay/lib/WxPay.Api.php";
		require_once FCPATH . "/lib/wxpay/WxPay.NativePay.php";
		require_once FCPATH . '/lib/wxpay/log.php';
		$notify = new NativePay ();
		
		$proid = $t1 . "_" . $t2 . "_" . $t3 . "_" . $t4 . "_" . $t5;
		$username = $this->user ['username'];
		$shangjin = $t4 * 100;
		$input = new WxPayUnifiedOrder ();
		$input->SetBody ( "打赏" );
		$input->SetAttach ( "$proid" );
		$input->SetOut_trade_no ( WxPayConfig::MCHID . date ( "YmdHis" ) );
		$input->SetTotal_fee ( "$shangjin" );
		// $input->SetTime_start ( date ( "YmdHis" ) );
		// $input->SetTime_expire ( date ( "YmdHis", time () + 3600 ) );
		$input->SetGoods_tag ( "打赏" );
		$input->SetNotify_url ( WxPayConfig::Notify_Url );
		$input->SetTrade_type ( "NATIVE" );
		$input->SetProduct_id ( "$proid" );
		$result = $notify->GetPayUrl ( $input );
		$url2 = $result ["code_url"];
		if ($url2 == null || $url2 == '') {
			$url2 = $notify->GetPrePayUrl ( $t1 . "_" . $t2 . "_" . $t3 . "_" . $t4 . "_" . $t5 );
		}
		// $url1 = $notify->GetPrePayUrl($t1."_".$t2."_".$t3."_".$t4."_".$t5);
		// echo urlencode($url1);
		$message = array ();
		$message ['prepay_id'] = $result ['prepay_id'];
		$message ['proid'] = $proid;
		$message ['data'] = urlencode ( $url2 );
		echo json_encode ( $message );
		exit ();
	}
	
	/* 用于ajax检测用户名是否存在 */
	function ajaxemail() {
		$email = $this->input->post ( 'email' );
		$user = $this->user_model->get_by_email ( $email );
		if (is_array ( $user ))
			exit ( '-1' );
		$emailaccess = $this->user_model->check_emailaccess ( $email );
		if (FALSE == $emailaccess)
			exit ( '-2' );
		exit ( '1' );
	}
	
	/* 用于ajax检测验证码是否匹配 */
	function ajaxcode() {
		$code = strtolower ( trim ( $this->uri->segment ( 3 ) ) );
		if ($code == $this->user_model->get_code ()) {
			exit ( '1' );
		}
		exit ( '0' );
	}
	/* 用于ajax设置用户提问金额 */
	function ajaxsetmypay() {
		$uid = $this->user ['uid'];
		
		$mypay = floatval ( $this->input->post ( 'mypay' ) );
		if ($uid == 0) {
			exit ( "-1" );
		}
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET `mypay`='$mypay' WHERE `uid`=$uid" );
		exit ( "1" );
	}
	
	/* 退出系统 */
	function logout() {
		$navtitle = '登出系统';
		// ucenter退出成功，则不会继续执行后面的代码。
		if ($this->setting ["ucenter_open"]) {
			$this->load->model ( 'ucenter_model' );
			$this->ucenter_model->ajaxlogout ();
		}
		$forward = isset ( $_SERVER ['HTTP_REFERER'] ) ? $_SERVER ['HTTP_REFERER'] : SITE_URL;
		$this->user_model->logout ();
	
		$this->message ( '成功退出！', "index" );
	}
	/**
	 *
	 * 发送邮箱验证码找回密码
	 *
	 * @date: 2019年8月12日 下午8:11:11
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function ajaxsendpwdmail() {
		$code = trim ( $this->input->post ( 'code' ) );
		if (empty ( $code )) {
			$message ['code'] = 2002;
			$message ['msg'] = "验证码不能为空";
			echo json_encode ( $message );
			exit ();
		}
		
		if ($code != $this->user_model->get_code ()) {
			$message ['code'] = 2001;
			$message ['msg'] = "图片验证码不对";
			echo json_encode ( $message );
			exit ();
		}
		
		$email = trim ( $this->input->post ( 'email' ) );
		if (empty ( $email )) {
			$message ['code'] = 2003;
			$message ['msg'] = "邮箱不能为空";
			echo json_encode ( $message );
			exit ();
		}
		
		$useremail = $this->user_model->get_by_email ( $email );
		if (! $useremail) {
			$message ['code'] = 2004;
			$message ['msg'] = "此邮箱未注册本站用户";
			echo json_encode ( $message );
			exit ();
		}
		
		if ($_COOKIE ['emailpas']) {
			$message ['code'] = 2008;
			$message ['msg'] = "请一分钟后在尝试重新发送";
			echo json_encode ( $message );
			exit ();
		}
		$sitename = $this->setting ['site_name'];
		$code = random ( 6, 1 );
		$this->user_model->save_code ( strtolower ( $code ), "emailcode" );
		$smsmessage = "这是一封来自【" . $sitename . "】邮箱验证，您当前正在找回网站密码，当前验证码为：$code";
		if ($_COOKIE ['findwpdbyemail']) {
			$v = 2;
		} else {
			$v = 1;
		}
		
		setcookie ( "emailpas", time (), time () + 60 );
		$expire = time () + 600; // 设置10分钟的有效期
		setcookie ( "findwpdbyemail", $v, $expire ); // 设置一个名字为var_name的cookie，并制定了有效期
		
		sendmailto ( $email, "邮箱验证提醒-$sitename", $smsmessage, $this->user ['username'] );
		$message ['code'] = 2000;
		$message ['msg'] = "邮箱验证码已经发送，请前往邮箱查收";
		echo json_encode ( $message );
		exit ();
	}
	/* 找回密码 */
	function getpass() {
		$navtitle = '找回密码';
		if (null !== $this->input->post ( 'submit' )) {
			$email = addslashes ( $this->input->post ( 'email' ) );
			
			if (strtolower ( trim ( $this->input->post ( 'seccode_verify' ) ) ) != $this->user_model->get_code ( "emailcode" )) {
				$this->message ( "邮箱验证码错误!", 'BACK' );
			}
			$touser = $this->user_model->get_by_email ( $email );
			if ($touser) {
				if ($_COOKIE ['findwpdbyemail']) {
					$password = trim ( $this->input->post ( 'password' ) ); // 用户注册密码
					
					$repassword = trim ( $this->input->post ( 'repassword' ) ); // 用户注册密码
					if (empty ( $password )) {
						$this->message ( "请输入需要修改的密码!" );
					}
					if ($password != $repassword) {
						$this->message ( "两次输入密码不一致!" );
					}
					if ($touser) {
						$data = array (
								'password' => md5 ( $password ) 
						);
						$this->db->where ( array (
								'email' => $email 
						) )->update ( 'user', $data );
						setcookie ( 'findwpdbyemail', '', time () - 3600 );
						$this->message ( "密码修改成功，请重新登录!", "user/default" );
					}
				} else {
					$this->message ( "邮箱找回密码超时，请刷新页面重试!", 'BACK' );
				}
			}
			$this->message ( "此邮箱没有注册账号，请核实!", 'BACK' );
		}
		include template ( 'getpass' );
	}
	/**
	 *
	 * 通过手机号找回密码
	 *
	 * @date: 2019年8月2日 下午5:29:19
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function getphonepass() {
		$navtitle = '手机号找回密码';
		if (null !== $this->input->post ( 'submit' )) {
			$userphone = addslashes ( $this->input->post ( 'userphone' ) );
			
			if (strtolower ( trim ( $this->input->post ( 'seccode_verify' ) ) ) != $this->user_model->get_code ( "phonecode" )) {
				$this->message ( $this->input->post ( 'state' ) . "验证码错误!", 'BACK' );
			}
			if (! preg_match ( "/^1[2345789]{1}\d{9}$/", $userphone )) {
				
				$this->message ( "手机号码不正确!" );
			}
			$touser = $this->user_model->get_by_phone ( $userphone );
			$password = trim ( $this->input->post ( 'password' ) ); // 用户注册密码
			
			$repassword = trim ( $this->input->post ( 'repassword' ) ); // 用户注册密码
			if (empty ( $password )) {
				$this->message ( "请输入需要修改的密码!" );
			}
			if ($password != $repassword) {
				$this->message ( "两次输入密码不一致!" );
			}
			if ($touser) {
				$data = array (
						'password' => md5 ( $password ) 
				);
				$this->db->where ( array (
						'phone' => $userphone 
				) )->update ( 'user', $data );
				$this->message ( "密码修改成功，请重新登录!", "user/default" );
			}
			$this->message ( "此手机号没有注册账号，请核实!" );
		}
		include template ( 'getphonepass' );
	}
	function ask() {
		$navtitle = '我的问题';
		$status = intval ( $this->uri->segment ( 3 ) ) == 0 ? 'all' : intval ( $this->uri->segment ( 3 ) );
		
		@$page = max ( 1, intval ( $this->uri->segment ( 4 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize; // 每页面显示$pagesize条
		$questionlist = $this->question_model->list_by_uid ( $this->user ['uid'], $status, $startindex, $pagesize );
		$questiontotal = intval ( returnarraynum ( $this->db->query ( getwheresql ( 'question', 'authorid=' . $this->user ['uid'] . $this->question_model->statustable [$status], $this->db->dbprefix ) )->row_array () ) );
		$departstr = page ( $questiontotal, $pagesize, $page, "user/ask/$status" ); // 得到分页字符串
		include template ( 'myask' );
	}
	function recommend() {
		$this->load->model ( 'message_model' );
		$navtitle = '为我推荐的问题';
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$user_categorys = array_per_fields ( $this->user ['category'], 'cid' );
		$this->message_model->read_user_recommend ( $this->user ['uid'], $user_categorys );
		$questionlist = $this->message_model->list_user_recommend ( $this->user ['uid'], $user_categorys, $startindex, $pagesize );
		$questiontotal = $this->message_model->rownum_user_recommend ( $this->user ['uid'], $user_categorys );
		$departstr = page ( $questiontotal, $pagesize, $page, "user/recommend" );
		include template ( 'myrecommend' );
	}
	function space_ask() {
		$uid = intval ( $this->uri->rsegments [3] );
		$member = $this->user_model->get_by_uid ( $uid, 0 );
		if ($member ['isblack'] || ! $member) {
			show_404 ();
			exit ();
		}
		$is_followed = $this->user_model->is_followed ( $member ['uid'], $this->user ['uid'] );
		$navtitle = $member ['username'] . '的提问';
		$seo_description = $member ['username'] . '，' . $member ['introduction'] . '，' . $member ['signature'];
		$seo_keywords = $member ['username'];
		// $status = $this->uri->rsegments [4] ? $this->uri->rsegments [4] : 'all';
		// 升级进度
		$membergroup = $this->usergroup [$member ['groupid']];
		@$page = max ( 1, intval ( $this->uri->rsegments [4] ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize; // 每页面显示$pagesize条
		$questionlist = $this->question_model->list_by_uid ( $uid, 'all', $startindex, $pagesize );
		$where = '';
		if ($this->user ['uid'] != $uid) {
			$where = ' hidden!=1 and ';
		}
		$questiontotal = returnarraynum ( $this->db->query ( getwheresql ( 'question', $where . ' authorid=' . $uid . $this->question_model->statustable ['all'], $this->db->dbprefix ) )->row_array () );
		
		$departstr = page ( $questiontotal, $pagesize, $page, "user/space_ask/$uid" ); // 得到分页字符串
		include template ( 'space_ask' );
	}
	function answer() {
		$navtitle = '我的回答';
		$status = intval ( $this->uri->rsegments [3] ) == 0 ? 'all' : intval ( $this->uri->rsegments [3] );
		
		@$page = max ( 1, intval ( $this->uri->rsegments [4] ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize; // 每页面显示$pagesize条
		$answerlist = $this->answer_model->list_by_uid ( $this->user ['uid'], $status, $startindex, $pagesize );
		$answersize = returnarraynum ( $this->db->query ( getwheresql ( 'answer', 'authorid=' . $this->user ['uid'] . $this->answer_model->statustable [$status], $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $answersize, $pagesize, $page, "user/answer/$status" ); // 得到分页字符串
		include template ( 'myanswer' );
	}
	function space_answer() {
		$uid = intval ( $this->uri->rsegments [3] );
		// $status = $this->uri->rsegments [4] ? $this->uri->rsegments [4] : 'all';
		$member = $this->user_model->get_by_uid ( $uid, 0 );
		if ($member ['isblack'] || ! $member) {
			show_404 ();
			exit ();
		}
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		$wx = $this->fromcache ( 'cweixin' );
		
		if (strstr ( $useragent, 'MicroMessenger' ) && $wx ['appsecret'] != '' && $wx ['appsecret'] != null && $wx ['winxintype'] != 2) {
			
			$appid = $wx ['appid'];
			$appsecret = $wx ['appsecret'];
			
			require FCPATH . '/lib/php/jssdk.php';
			$jssdk = new JSSDK ( $appid, $appsecret );
			$signPackage = $jssdk->GetSignPackage ();
		}
		if (strstr ( $useragent, 'MicroMessenger' ) && $wx ['appsecret'] != '' && $wx ['appsecret'] != null) {
			
			// if ($bid>0&&strstr($useragent, 'MicroMessenger')&&$wx['appsecret']!=''&&$wx['appsecret']!=null) {
			if ($this->setting ['openwxpay'] == 1) {
				
				require_once FCPATH . "/lib/wxpay/lib/WxPay.Api.php";
				require_once FCPATH . "/lib/wxpay/WxPay.JsApiPay.php";
				
				require_once FCPATH . '/lib/wxpay/log.php';
				
				if (is_mobile ()) {
					
					$tools = new JsApiPay ();
					
					$openId = $tools->GetOpenid ();
					if (! isset ( $openId )) {
						
						$baseUrl = SITE_URL . 'index.php?' . urlmap ( $_SERVER ['QUERY_STRING'], 1 );
						header ( "Location:$baseUrl" );
					}
				}
			}
		}
		$is_followed = $this->user_model->is_followed ( $member ['uid'], $this->user ['uid'] );
		$navtitle = $member ['username'] . '的回答';
		$seo_description = $member ['username'] . '，' . $member ['introduction'] . '，' . $member ['signature'];
		$seo_keywords = $member ['username'];
		// 升级进度
		$membergroup = $this->usergroup [$member ['groupid']];
		@$page = max ( 1, intval ( $this->uri->rsegments [4] ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize; // 每页面显示$pagesize条
		$answerlist = $this->answer_model->list_by_uid ( $uid, 'all', $startindex, $pagesize );
		$answersize = intval ( returnarraynum ( $this->db->query ( getwheresql ( 'answer', 'authorid=' . $uid . $this->answer_model->statustable ['all'], $this->db->dbprefix ) )->row_array () ) );
		$departstr = page ( $answersize, $pagesize, $page, "user/space_answer/$uid" ); // 得到分页字符串
		include template ( 'space_answer' );
	}
	function follower() {
		$navtitle = '关注者';
		$page = max ( 1, intval ( $this->uri->rsegments [3] ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$followerlist = $this->user_model->get_follower ( $this->user ['uid'], $startindex, $pagesize );
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'user_attention', " uid=" . $this->user ['uid'], $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "user/follower" );
		include template ( "myfollower" );
	}
	function spacefollower() {
		$uid = intval ( $this->uri->rsegments [3] );
		$member = $this->user_model->get_by_uid ( $uid, 0 );
		if ($member ['isblack'] || ! $member) {
			show_404 ();
			exit ();
		}
		$is_followed = $this->user_model->is_followed ( $member ['uid'], $this->user ['uid'] );
		$navtitle = $member ['username'] . '的粉丝';
		$page = max ( 1, intval ( $this->uri->rsegments [4] ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		
		$followerlist = $this->user_model->get_follower ( $uid, $startindex, $pagesize );
		
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'user_attention', " uid=" . $uid, $this->db->dbprefix ) )->row_array () );
		
		$departstr = page ( $rownum, $pagesize, $page, "user/spacefollower/$uid" );
		include template ( "space_follower" );
	}
	function attention() {
		$navtitle = '已关注';
		$attentiontype = null !== $this->uri->rsegments [3] ? $this->uri->rsegments [3] : '';
		
		if ($attentiontype == 'article') {
			$this->load->model ( 'favorite_model' );
			$navtitle = "我关注的文章";
			$seo_description = "";
			$seo_keywords = "";
			@$page = max ( 1, intval ( $this->uri->rsegments [4] ) );
			$pagesize = $this->setting ['list_default'];
			$startindex = ($page - 1) * $pagesize;
			$rownum = $this->favorite_model->get_list_byalltidtotal ();
			
			$topiclist = $this->favorite_model->get_list_byalltid ( $startindex, $pagesize );
			
			$departstr = page ( $rownum, $pagesize, $page, "user/attention/article" );
			include template ( 'myattention_article' );
		} else if ($attentiontype == 'question') {
			$navtitle = '已关注问题';
			$page = max ( 1, intval ( $this->uri->rsegments [4] ) );
			$pagesize = $this->setting ['list_default'];
			$startindex = ($page - 1) * $pagesize;
			$questionlist = $this->user_model->get_attention_question ( $this->user ['uid'], $startindex, $pagesize );
			$rownum = $this->user_model->rownum_attention_question ( $this->user ['uid'] );
			$departstr = page ( $rownum, $pagesize, $page, "user/attention/$attentiontype" );
			include template ( "myattention_question" );
		} else if ($attentiontype == 'topic') {
			
			$navtitle = '已关注话题';
			$page = max ( 1, intval ( $this->uri->rsegments [4] ) );
			$pagesize = $this->setting ['list_default'];
			$startindex = ($page - 1) * $pagesize;
			$categorylist = $this->user_model->get_attention_category ( $this->user ['uid'], $startindex, $pagesize );
			$rownum = $this->user_model->rownum_attention_category ( $this->user ['uid'] );
			$departstr = page ( $rownum, $pagesize, $page, "user/attention/$attentiontype" );
			include template ( "myattention_category" );
		} else {
			$navtitle = '已关注用户';
			$page = max ( 1, intval ( $this->uri->rsegments [3] ) );
			$pagesize = $this->setting ['list_default'];
			$startindex = ($page - 1) * $pagesize;
			$attentionlist = $this->user_model->get_attention ( $this->user ['uid'], $startindex, $pagesize );
			$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'user_attention', " followerid=" . $this->user ['uid'], $this->db->dbprefix ) )->row_array () );
			$departstr = page ( $rownum, $pagesize, $page, "user/attention" );
			include template ( "myattention" );
		}
	}
	function space_attention() {
		$navtitle = '已关注';
		$attentiontype = null !== $this->uri->segment ( 3 ) ? $this->uri->segment ( 3 ) : '';
		$uid = intval ( $this->uri->segment ( 4 ) );
		$member = $this->user_model->get_by_uid ( $uid, 0 );
		if ($member ['isblack'] || ! $member) {
			show_404 ();
			exit ();
		}
		$is_followed = $this->user_model->is_followed ( $member ['uid'], $this->user ['uid'] );
		if ($attentiontype == 'question') {
			$navtitle = '已关注问题';
			$page = max ( 1, intval ( $this->uri->segment ( 5 ) ) );
			$pagesize = $this->setting ['list_default'];
			$startindex = ($page - 1) * $pagesize;
			$questionlist = $this->user_model->get_attention_question ( $uid, $startindex, $pagesize );
			$rownum = $this->user_model->rownum_attention_question ( $uid );
			$departstr = page ( $rownum, $pagesize, $page, "user/attention/$attentiontype" );
			include template ( "space_myattention_question" );
		} else if ($attentiontype == 'topic') {
	
			$navtitle = '已关注话题';
			$page = max ( 1, intval ( $this->uri->segment ( 5 ) ) );
			$pagesize = $this->setting ['list_default'];
			$startindex = ($page - 1) * $pagesize;
			$categorylist = $this->user_model->get_attention_category ( $uid, $startindex, $pagesize );
			$rownum = $this->user_model->rownum_attention_category ( $uid );
			$departstr = page ( $rownum, $pagesize, $page, "user/attention/$attentiontype" );
			include template ( "space_myattention_category" );
		} else {
			$navtitle = '已关注用户';
			$page = max ( 1, intval ( $this->uri->segment ( 5 ) ) );
			$pagesize = $this->setting ['list_default'];
			$startindex = ($page - 1) * $pagesize;
			$attentionlist = $this->user_model->get_attention ( $uid, $startindex, $pagesize );
			$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'user_attention', " followerid=" . $uid, $this->db->dbprefix ) )->row_array () );
			$departstr = page ( $rownum, $pagesize, $page, "user/attention" );
		
			include template ( "space_myattention" );
		}
	}
	function home() {
		if ($this->user ['uid'] == 0) {
			$this->message ( "请先登录 !", 'user/login' );
		}
		$navtitle = '我的个人中心';
		include template ( 'userhome' );
	}
	function score() {
		$navtitle = '我的个人中心';
		if (isset ( $this->setting ['outextcredits'] ) && $this->setting ['outextcredits']) {
			$outextcredits = unserialize ( $this->setting ['outextcredits'] );
		}
		$higherneeds = intval ( $this->user ['creditshigher'] - $this->user ['credit1'] );
		$adoptpercent = $this->user_model->adoptpercent ( $this->user );
		$highergroupid = $this->user ['groupid'] + 1;
		isset ( $this->usergroup [$highergroupid] ) && $nextgroup = $this->usergroup [$highergroupid];
		$credit_detail = $this->user_model->credit_detail ( $this->user ['uid'] );
		
		if ($credit_detail) {
			$detail1 = isset ( $credit_detail [0] ) && $credit_detail [0];
			$detail2 = isset ( $credit_detail [1] ) && $credit_detail [1];
		}
		
		$status = 'all';
		@$page = max ( 1, intval ( $this->uri->segment ( 4 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize; // 每页面显示$pagesize条
		$userid = $this->user ['uid'];
		$this->load->model ( 'doing_model' );
		
		$doinglist = $this->doing_model->list_by_type ( "my", $userid, $startindex, $pagesize );
		
		$rownum = $this->doing_model->rownum_by_type ( "my", $userid );
		
		$departstr = page ( $rownum, $pagesize, $page, "user/score/$userid" );
		
		// $answerlist = $this->answer_model->list_by_uid ( $userid, 'all', $startindex, $pagesize );
		// $questionlist = $this->question_model->list_by_uid ( $userid, 'all', $startindex, $pagesize );
		
		// $topiclist = $this->topic_model->get_list_byuid ( $userid, $startindex, $pagesize );
		// $followerlist = $this->user_model->get_follower ( $userid, $startindex, $pagesize );
		// $attentionlist = $this->user_model->get_attention ( $userid, $startindex, $pagesize );
		// 更新他的数据统计
		$questions = returnarraynum ( $this->db->query ( getwheresql ( 'question', 'authorid=' . $userid, $this->db->dbprefix ) )->row_array () );
		$answers = returnarraynum ( $this->db->query ( getwheresql ( 'answer', 'authorid=' . $userid, $this->db->dbprefix ) )->row_array () );
		$articles = returnarraynum ( $this->db->query ( getwheresql ( 'topic', 'authorid=' . $userid, $this->db->dbprefix ) )->row_array () );
		$attentions = $this->user_model->rownum_attention_question ( $userid );
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET articles=$articles,questions=$questions,answers=$answers,attentions=$attentions where uid=" . $userid );
		
		include template ( 'myscore' );
	}
	function level() {
		$navtitle = '我的等级';
		$usergroup = $this->usergroup;
		include template ( "mylevel" );
	}
	function exchange() {
		$navtitle = '积分兑换';
		if ($this->setting ['outextcredits']) {
			$outextcredits = unserialize ( $this->setting ['outextcredits'] );
		} else {
			$this->message ( "系统没有开启积分兑换!", 'BACK' );
		}
		$exchangeamount = $this->input->post ( 'exchangeamount' ); // 先要兑换的积分数
		$outextindex = $this->input->post ( 'outextindex' ); // 读取相应积分配置
		$outextcredit = $outextcredits [$outextindex];
		$creditsrc = $outextcredit ['creditsrc']; // 积分兑换的源积分编号
		$appiddesc = $outextcredit ['appiddesc']; // 积分兑换的目标应用程序 ID
		$creditdesc = $outextcredit ['creditdesc']; // 积分兑换的目标积分编号
		$ratio = $outextcredit ['ratio']; // 积分兑换比率
		$needamount = $exchangeamount / $ratio; // 需要扣除的积分数
		
		if ($needamount <= 0) {
			$this->message ( "兑换的积分必需大于0 !", 'BACK' );
		}
		if (1 == $creditsrc) {
			$titlecredit = '经验值';
			if ($this->user ['credit1'] < $needamount) {
				$this->message ( "{$titlecredit}不足!", 'BACK' );
			}
			$this->credit ( $this->user ['uid'], - $needamount, 0, 0, 'exchange' ); // 扣除本系统积分
		} else {
			$titlecredit = '财富值';
			if ($this->user ['credit2'] < $needamount) {
				$this->message ( "{$titlecredit}不足!", 'BACK' );
			}
			$this->credit ( $this->user ['uid'], 0, - $needamount, 0, 'exchange' ); // 扣除本系统积分
		}
		$this->load->model ( 'ucenter_model' );
		$this->ucenter_model->exchange ( $this->user ['uid'], $creditsrc, $creditdesc, $appiddesc, $exchangeamount );
		$this->message ( "积分兑换成功!  你在“{$this->setting[site_name]}”的{$titlecredit}减少了{$needamount}。" );
	}
	
	/* 个人中心修改资料 */
	function profile() {
		$navtitle = '个人资料';
		if (null !== $this->input->post ( 'submit' )) {
			$gender = $this->input->post ( 'gender' );
			$bday = $this->input->post ( 'birthyear' ) . '-' . $this->input->post ( 'birthmonth' ) . '-' . $this->input->post ( 'birthday' );
			$phone = trim ( $this->input->post ( 'phone' ) );
			$truename = $this->input->post ( 'truename' ) ? $this->input->post ( 'truename' ) : $this->user ['truename'];
			$conpanyname = $this->input->post ( 'conpanyname' ) ? $this->input->post ( 'conpanyname' ) : $this->user ['conpanyname'];
			$qq = $this->input->post ( 'qq' );
			$msn = $this->input->post ( 'msn' );
			$messagenotify = null !== $this->input->post ( 'messagenotify' ) ? 1 : 0;
			$mailnotify = null !== $this->input->post ( 'mailnotify' ) ? 2 : 0;
			$isnotify = $messagenotify + $mailnotify;
			$introduction = htmlspecialchars ( $this->input->post ( 'introduction' ) );
			$signature = htmlspecialchars ( $this->input->post ( 'signature' ) );
			if (! empty ( $phone )) {
				if (! preg_match ( '/^1([0-9]{9})/', $phone )) {
					$this->message ( "手机号不正确!", 'user/profile' );
				}
				
				$userone = $this->user_model->get_by_phone ( $phone );
				if ($userone != null && $phone != $this->user ['phone']) {
					$this->message ( "手机号已被占用!", 'user/profile' );
				}
			}
			
			$data = array (
					'truename' => $truename,
					'conpanyname' => $conpanyname,
					'gender' => $gender,
					'bday' => $bday,
					'phone' => $phone,
					'qq' => $qq,
					'msn' => $msn,
					'introduction' => $introduction,
					'signature' => $signature,
					'isnotify' => $isnotify 
			);
			$this->db->set ( $data )->where ( array (
					'uid' => $this->user ['uid'] 
			) )->update ( 'user' );
			
			$this->message ( "个人资料更新成功", 'user/profile' );
		}
		include template ( 'profile' );
	}
	function uppass() {
		// $this->load("ucenter");
		$navtitle = "修改密码";
		if (null !== $this->input->post ( 'submit' )) {
			if (strtolower ( trim ( $this->input->post ( 'code' ) ) ) != $this->user_model->get_code ()) {
				$this->message ( $this->input->post ( 'state' ) . "验证码错误!", 'BACK' );
			}
			if (trim ( $this->input->post ( 'newpwd' ) ) == '') {
				$this->message ( "新密码不能为空！", 'user/uppass' );
			} else if (trim ( $this->input->post ( 'newpwd' ) ) != trim ( $this->input->post ( 'confirmpwd' ) )) {
				$this->message ( "两次输入不一致", 'user/uppass' );
			} else if (trim ( $this->input->post ( 'oldpwd' ) ) == trim ( $this->input->post ( 'newpwd' ) )) {
				$this->message ( '新密码不能跟当前密码重复!', 'user/uppass' );
			} else if (md5 ( trim ( $this->input->post ( 'oldpwd' ) ) ) == $this->user ['password']) {
				if ($this->setting ["ucenter_open"]) {
					$this->load->model ( "ucenter_model" );
					$this->ucenter_model->uppass ( $this->user ['username'], $this->input->post ( 'oldpwd' ), $this->input->post ( 'newpwd' ), $this->user ['email'] );
				}
				
				$this->user_model->uppass ( $this->user ['uid'], trim ( $this->input->post ( 'newpwd' ) ) );
				$this->message ( "密码修改成功,请重新登录系统!", 'user/login' );
			} else {
				$this->message ( "旧密码错误！", 'user/uppass' );
			}
		}
		include template ( 'uppass' );
	}
	
	/**
	 *
	 * 用户空间主页
	 *
	 * @date: 2018年7月23日 下午1:15:04
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function space() {
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		$navtitle = "个人空间";
		$userid = intval ( $this->uri->rsegments [3] );
		$member = $this->user_model->get_by_uid ( $userid, 2 );
		
		if ($member ['isblack'] || ! $member) {
			show_404 ();
			exit ();
		}
	
		if ($member) {
			// 判断是不是专家
			if ($member ['expert'] && is_mobile ()) {
				$askurl = url ( "user/space_answer/" . $member ['uid'] );
				header ( "location:$askurl" );
			}
			$this->load->model ( 'doing_model' );
			$membergroup = $this->usergroup [$member ['groupid']];
			$adoptpercent = $this->user_model->adoptpercent ( $member );
			$page = max ( 1, intval ( $this->uri->rsegments [4] ) );
			$pagesize = 15;
			$startindex = ($page - 1) * $pagesize;
			
			$doinglist = $this->doing_model->list_by_type ( "my", $userid, $startindex, $pagesize );
			$rownum = $this->doing_model->rownum_by_type ( "my", $userid );
			
			$is_followed = $this->user_model->is_followed ( $member ['uid'], $this->user ['uid'] );
			
			$departstr = page ( $rownum, $pagesize, $page, "user/space/$userid" );
			

		
			$navtitle = $member ['username'] . $navtitle;
			$seo_description = $member ['username'] . '，' . $member ['introduction'] . '，' . $member ['signature'];
			$seo_keywords = $member ['username'];
			include template ( 'space' );
		} else {
			
			header ( 'HTTP/1.1 404 Not Found' );
			header ( "status: 404 Not Found" );
			echo '<!DOCTYPE html><html><head><meta charset=utf-8 /><title>404-您访问的页面不存在</title>';
			echo "<style>body { background-color: #ECECEC; font-family: 'Open Sans', sans-serif;font-size: 14px; color: #3c3c3c;}";
			echo ".nullpage p:first-child {text-align: center; font-size: 150px;  font-weight: bold;  line-height: 100px; letter-spacing: 5px; color: #fff;}";
			echo ".nullpage p:not(:first-child) {text-align: center;color: #666;";
			echo "font-family: cursive;font-size: 20px;text-shadow: 0 1px 0 #fff;  letter-spacing: 1px;line-height: 2em;margin-top: -50px;}";
			echo ".nullpage p a{margin-left:10px;font-size:20px;}";
			echo '</style></head><body> <div class="nullpage"><p><span>4</span><span>0</span><span>4</span></p><p>抱歉，该用户个人空间不存在！⊂((δ⊥δ))⊃<a href="/">返回主页</a></p></div></body></html>';
			exit ();
		}
	}
	
	// 0总排行、1上周排行 、2上月排行
	// user/scorelist/1/
	function scorelist() {
		$navtitle = "乐帮排行榜";
		$seo_description = "乐帮排行榜展示问答最活跃的用户列表，包括达人财富榜，并推荐最新文章和关注问题排行榜。";
		$seo_keywords = "活跃用户,达人财富,最新文章推荐,关注问题排行榜";
		$type = null !== $this->uri->segment ( 3 ) ? $this->uri->segment ( 3 ) : 0;
		$userlist = $this->user_model->list_by_credit ( $type, 100 );
		
		$useractivelistlist = $this->user_model->get_active_list ( 0, 6 );
		$usercount = count ( $userlist );
		
		include template ( 'scorelist' );
	}
	function activelist() {
		$cid = intval ( $this->uri->segment ( 3 ) ) ? intval ( $this->uri->segment ( 3 ) ) : 'all'; // 分类id
		$status = null !== $this->uri->segment ( 4 ) ? $this->uri->segment ( 4 ) : 'all'; // 排序
		
		if ($cid != 'all') {
			$category = $this->category [$cid]; // 得到分类信息
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
		
		$sublist = $this->category_model->list_by_cid_pid_all ( $cid, $category ['pid'] ); // 获取子分类
		$page = max ( 1, intval ( $this->uri->segment ( 5 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$userlist = $this->user_model->get_active_list ( $startindex, $pagesize, $cid, $status );
		$answertop = $this->user_model->get_answer_top ();
		$orderwhere = '';
		switch ($status) {
			case 'all' : // 全部
				$orderwhere = '';
				break;
			case '1' : // 付费
				$orderwhere = ' and mypay>0 ';
				break;
			case '2' : // 免费
				$orderwhere = " and mypay=0 ";
				break;
		}
		$rownum = $cid == 'all' ? returnarraynum ( $this->db->query ( getwheresql ( 'user', " 1=1 " . $orderwhere, $this->db->dbprefix ) )->row_array () ) : returnarraynum ( $this->db->query ( getwheresql ( 'user', " 1=1 " . $orderwhere . "and uid IN (SELECT uid FROM " . $this->db->dbprefix . "user_category WHERE cid=$cid)", $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "user/activelist/$cid/$status" );
		if ($page == 1) {
			$navtitle = "站点用户活跃度列表";
		} else {
			$navtitle = "站点用户列表" . "_第" . $page . "页";
		}
		$userarticle = $this->topic_model->get_user_articles ( 0, 5 );
		$seo_description = "站点用户列表，根据用户活跃度展示用户排序。";
		$seo_keywords = "站点用户列表";
		include template ( "activelist" );
	}
	function checkemail() {
		
		// if(isset($_COOKIE["useremailcheck"])){
		$uid = intval ( $this->uri->segment ( 3 ) );
		$activecode = strip_tags ( $this->uri->segment ( 4 ) );
		$user = $this->user_model->get_by_uid ( $uid );
		if ($user ['active'] == 1) {
			// $this->user_model->logout ();
			$this->message ( "您的邮箱已激活过，请勿重复激活!", 'index' );
		}
		
		// $this->user_model->logout ();
		
		if ($user ['activecode'] == $activecode) {
			$this->user_model->update_useractive ( $uid );
			if ($this->setting ["ucenter_open"]) {
				$this->load->model ( 'ucenter_model' );
				$this->ucenter_model->uppass ( $user ['username'], '', '', $user ['email'], 1 );
			}
			$this->message ( "邮箱激活成功!", 'index' );
		} else {
			$this->message ( "邮箱激活失败!", 'index' );
		}
		
		// }else{
		// $this->message("邮箱激活已经过期!");
		// }
	}
	
	// 邮箱激活验证
	function vertifyemail() {
		// 验证是否登录
		if ($this->user ['uid'] == 0) {
			$this->message ( "您还没登陆！", 'index' );
		}
		// 验证是否设置过邮箱
		if (trim ( $this->user ['email'] ) == '' || ! isset ( $this->user ['email'] )) {
			$this->message ( "您还没设置过邮箱！", 'user/editemail' );
		}
		
		if ($this->user ['active'] == 1) {
			$this->message ( "您的邮箱已经激活过！", 'index' );
		}
		
		if ($this->user ['activecode'] == '' || $this->user ['activecode'] == 0 || $this->user ['activecode'] == null) {
			$sitename = $this->setting ['site_name'];
			$email = $this->user ['email'];
			$activecode = md5 ( rand ( 10000, 50000 ) );
			$url = SITE_URL . 'index.php?user/checkemail/' . $this->user ['uid'] . '/' . $activecode;
			$message = "这是一封来自".$sitename."邮箱验证，<a target='_blank' href='$url'>请点击此处验证邮箱邮箱账号</a>";
			$v = md5 ( "yanzhengask2email" );
			$v1 = md5 ( "yanzhengask2time" );
			setcookie ( "emailsend" );
			setcookie ( "useremailcheck" );
			$expire1 = time () + 60; // 设置1分钟的有效期
			setcookie ( "emailsend", $v1, $expire1 ); // 设置一个名字为var_name的cookie，并制定了有效期
			$expire = time () + 86400; // 设置24小时的有效期
			setcookie ( "useremailcheck", $v, $expire ); // 设置一个名字为var_name的cookie，并制定了有效期
			$this->user_model->update_emailandactive ( $email, $activecode, $this->user ['uid'] );
			$this->user_model->refresh ( $this->user ['uid'], 1 );
			sendmailto ( $email, "邮箱验证提醒-$sitename", $message, $this->user ['username'] );
		}
		include template ( "vertifyemail" );
	}
	// 修改手机号码
	function editphone() {
		if ($this->user ['uid'] == 0) {
			$this->message ( "您还没登陆！", 'BACK' );
		}
		
		session_start ();
		
		if ($this->input->post ( 'submit' )) {
			
			if (strtolower ( trim ( $this->input->post ( 'code' ) ) ) != $this->user_model->get_code ( "phonecode" )) {
				$this->message ( "验证码错误!", 'BACK' );
			}
			$userphone = trim ( $this->input->post ( 'userphone' ) );
			if (empty ( $userphone )) {
				$this->message ( "抱歉，手机号不能为空！", 'BACK' );
			}
			if ($this->user ['isblack'] == 1) {
				$this->message ( "您是黑名单用户，无法激活手机号码！", 'BACK' );
			}
			$userone = $this->user_model->get_by_phone ( $userphone );
			
			if ($this->user ['phone'] == '') {
				// 手机号为空，新增手机号，如果发现同名手机号，提示手机号存在
				if ($userone) {
					$this->message ( "这个手机号码已经存在！", 'BACK' );
				}
			} else {
				// 如果用户手机号存在且查到手机号和自己的不同
				if ($userone && $userone ['uid'] != $this->user ['uid']) {
					$this->message ( "这个手机号码已经存在！", 'BACK' );
				}
			}
			$this->user_model->updatephone ( $this->user ['uid'], $userphone );
			$this->message ( "手机号码激活成功！" );
		}
		include template ( "editphone" );
	}
	// 邀请我回答
	function invateme() {
		if ($this->user ['uid'] == 0) {
			$this->message ( "您还没登陆！", 'BACK' );
		}
		
		$navtitle = "邀请我回答的问题";
		$seo_description = "";
		$seo_keywords = "";
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$condition = " askuid=" . $this->user ['uid'];
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'question', $condition, $this->db->dbprefix ) )->row_array () );
		
		$questionlist = $this->question_model->list_by_condition ( $condition, $startindex, $pagesize );
		
		$departstr = page ( $rownum, $pagesize, $page, "user/invateme" );
		include template ( 'invatemequestion' );
	}
/**

* 更新邮箱

* @date: 2020年2月21日 上午11:23:12

* @author: 61703

* @param: variable

* @return:

*/
	function editemail() {
		$navtitle = "修改邮箱";
		if ($this->user ['uid'] == 0) {
			$this->message ( "您还没登陆！", 'BACK' );
		}
		
		if ($this->input->post ( 'submit' )) {
			
			if (strtolower ( trim ( $this->input->post ( 'code' ) ) ) != $this->user_model->get_code ()) {
				$this->message ( $this->input->post ( 'state' ) . "验证码错误!", 'BACK' );
			}
			
			$email = trim ( $this->input->post ( 'email' ) );
			if (empty ( $email )) {
				$this->message ( "抱歉，邮箱不能为空！" );
			}
			
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$this->message("邮箱格式错误");
				exit();
			}
			
			$emailaccess = $this->user_model->check_emailaccess ( $email );
			if (FALSE == $emailaccess) {
				$this->message ( "邮箱后缀被系统列入黑名单，禁止注册!" );
			}
			$euser = $this->db->get_where('user',array('email'=>$email))->row_array();
			
			if(!empty($this->user['email'])&&$euser){
				if ($euser) {
					if($email!=$this->user['email']){
						$this->message ( "邮箱已被注册!" );
					}
					
				}
			}
			if($euser&&empty($this->user['email'])){
				$this->message ( "邮箱已被注册!" );
			}
			if($this->user['email']==$email){
				if ($this->user ['active'] == 1) {
					$this->message ( "您的邮箱已经激活过！" );
				}				
			}
			
			
			$sitename = $this->setting ['site_name'];
			
			
			$activecode = md5 ( rand ( 000000000, 888888888 ) );
			$url = SITE_URL . 'index.php?user/checkemail/' . $this->user ['uid'] . '/' . $activecode;
			$message = "这是一封来自".$sitename."邮箱验证，<a target='_blank' href='$url'>请点击此处验证邮箱邮箱账号</a>";
			$v = md5 ( "yanzhengask2email" );
			$v1 = md5 ( "yanzhengask2time" );
			setcookie ( "emailsend" );
			setcookie ( "useremailcheck" );
			$expire1 = time () + 60; // 设置1分钟的有效期
			setcookie ( "emailsend", $v1, $expire1 ); // 设置一个名字为var_name的cookie，并制定了有效期
			$expire = time () + 86400; // 设置24小时的有效期
			setcookie ( "useremailcheck", $v, $expire ); // 设置一个名字为var_name的cookie，并制定了有效期
			$this->user_model->update_emailandactive ( $email, $activecode, $this->user ['uid'] );
			$this->user_model->refresh ( $this->user ['uid'], 1 );
			sendmailto ( $email, "邮箱验证提醒-$sitename", $message, $this->user ['username'] );

			$this->user_model->update_email ( $email, $this->user ['uid'] );
			if ($this->setting ["ucenter_open"]) {
				$this->load->model ( 'ucenter_model' );
				$this->ucenter_model->uppass ( $this->user ['username'], '', '', $this->user ['email'], 1 );
			}
			$this->user_model->refresh ( $this->user ['uid'], 1 );
			$this->message ( "邮箱验证发送成功" );
			
			
		}
		$_SESSION ["formkey"] = getRandChar ( 56 );
		include template ( "editemail" );
	}
	/**
	 *
	 * 通知和私信设置
	 *
	 * @date: 2018年12月21日 下午9:14:50
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function usernotify() {
		$navtitle = "私信和通知";
		if (! $this->user ['uid']) {
			header ( "Location:" . url ( "user/login" ) );
		}
		if ($_POST) {
			$data ['uid'] = intval ( $this->user ['uid'] );
			$data ['inbox_permission'] = $_POST ['inbox_permission'];
			$data ['invite_permission'] = $_POST ['invite_permission'];
			$data ['follow_after_answer'] = $_POST ['follow_after_answer'] ? 1 : 0;
			$data ['article'] = $_POST ['article'] ? 1 : 0;
			$data ['like_object'] = $_POST ['like_object'] ? 1 : 0;
			$data ['bookmark_object'] = $_POST ['bookmark_object'] ? 1 : 0;
			$data ['follow_object'] = $_POST ['follow_object'] ? 1 : 0;
			$data ['answer'] = $_POST ['answer'] ? 1 : 0;
			$data ['comment'] = $_POST ['comment'] ? 1 : 0;
			$data ['content_handled'] = $_POST ['content_handled'] ? 1 : 0;
			$data ['comment_reply'] = $_POST ['comment_reply'] ? 1 : 0;
			$data ['invite'] = $_POST ['invite'] ? 1 : 0;
			$data ['message'] = $_POST ['message'] ? 1 : 0;
			$data ['weekly'] = $_POST ['weekly'] ? 1 : 0;
			$data ['feature_news'] = $_POST ['feature_news'] ? 1 : 0;
			$usernotify = $this->user_model->selectnotifybyuid ( $this->user ['uid'] );
			if ($usernotify) {
				// 更新
				$this->user_model->addnotify ( $data, 'edit' );
			} else {
				
				// 插入
				$this->user_model->addnotify ( $data, 'add' );
				$this->db->last_query ();
			}
			$this->message ( "更新成功！" );
		}
		$usernotify = $this->user_model->get_mynotify ( $this->user ['uid'] );
		include template ( "user_notify" );
	}
	/**
	 *
	 * 用户头像修改
	 *
	 * @date: 2018年12月21日 下午9:14:29
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function editimg() {
	
		$navtitle = "修改个人头像";
		if (isset ( $_FILES ["userimage"] )) {
			$uid = intval ( $this->uri->segment ( 3 ) );
			
			$avatardir = "/data/avatar/";
			$extname = extname ( $_FILES ["userimage"] ["name"] );
			if (! isimage ( $extname ))
				$this->message ( "图片扩展名不正确!", 'user/editimg' );
			$upload_tmp_file = FCPATH . 'data/tmp/user_avatar_' . $uid . '.' . $extname;
			$uid = abs ( $uid );
			$uid = sprintf ( "%09d", $uid );
			$dir1 = $avatardir . substr ( $uid, 0, 3 );
			$dir2 = $dir1 . '/' . substr ( $uid, 3, 2 );
			$dir3 = $dir2 . '/' . substr ( $uid, 5, 2 );
			(! is_dir ( FCPATH . $dir1 )) && forcemkdir ( FCPATH . $dir1 );
			(! is_dir ( FCPATH . $dir2 )) && forcemkdir ( FCPATH . $dir2 );
			(! is_dir ( FCPATH . $dir3 )) && forcemkdir ( FCPATH . $dir3 );
			$smallimg = $dir3 . "/small_" . $uid . '.' . $extname;
			if (move_uploaded_file ( $_FILES ["userimage"] ["tmp_name"], $upload_tmp_file )) {
				$avatar_dir = glob ( FCPATH . $dir3 . "/small_{$uid}.*" );
				foreach ( $avatar_dir as $imgfile ) {
					if (strtolower ( $extname ) != extname ( $imgfile ))
						unlink ( $imgfile );
				}
				image_resize ( $upload_tmp_file, FCPATH . $smallimg, 200, 200, 1 );
				$this->message ( '修改头像成功', 'user/default' );
			}
		} else {
			if ($this->setting ["ucenter_open"]) {
				$this->load->model ( 'ucenter_model' );
				$imgstr = $this->ucenter_model->set_avatar ( $this->user ['uid'] );
			}
		}
		
		include template ( "editimg" );
	}
	function mycategory() {
		$this->load->model ( "category_model" );
		$categoryjs = $this->category_model->get_js ();
		$qqlogin = $this->user_model->get_login_auth ( $this->user ['uid'], 'qq' );
		$sinalogin = $this->user_model->get_login_auth ( $this->user ['uid'], 'sina' );
		$wxlogin = $this->user ['openid'] ? 1 : 0;
		include template ( "mycategory" );
	}
	
	// 解除绑定
	function unchainauth() {
		$typename = trim ( $this->uri->segment ( 3 ) );
		if ($typename == 'wechat') {
			$this->db->set ( 'openid', '' );
			$this->db->where_in ( 'uid', $this->user ['uid'] );
			$this->db->update ( 'user' );
		} else {
			$this->user_model->remove_login_auth ( $this->user ['uid'], $typename );
		}
		
		session_start ();
		$_SESSION ['authinfo'] = null;
		unset ( $_SESSION ['authinfo'] );
		$this->message ( $typename . "绑定解除成功!", 'user/mycategory' );
	}
	function ajaxcategory() {
		$cid = intval ( $this->input->post ( 'cid' ) );
		if ($cid && $this->user ['uid']) {
			foreach ( $this->user ['category'] as $category ) {
				if ($category ['cid'] == $cid) {
					exit ();
				}
			}
			// 如果超过当前最大分类选择数就终止
			if ($this->setting ['cansetcatnum'] == null || trim ( $this->setting ['cansetcatnum'] ) == '')
				$this->setting ['cansetcatnum'] = '1';
			if (count ( $this->user ['category'] ) > $this->setting ['cansetcatnum']) {
				exit ();
			}
			$this->user_model->add_category ( $cid, $this->user ['uid'] );
		}
	}
	function ajaxdeletecategory() {
		$cid = intval ( $this->input->post ( 'cid' ) );
		if ($cid && $this->user ['uid']) {
			$this->user_model->remove_category ( $cid, $this->user ['uid'] );
		}
	}
	function ajaxpoplogin() {
		$forward = isset ( $_SERVER ['HTTP_REFERER'] ) ? $_SERVER ['HTTP_REFERER'] : SITE_URL;
		if (! isset ( $_SESSION )) {
			session_start ();
		}
		$_SESSION ['logintokenid'] = md5 ( time () );
		$_SESSION['forward'] = $forward;
		include template ( "poplogin" );
	}
	/**
	 *
	 * ajax获取用户头部登录信息
	 *
	 * @date: 2019年5月8日 下午3:04:18
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function ajaxgetlogininfo() {
		include template ( "headerlogininfo" );
	}
	/* 用户查看下详细信息 */
	function ajaxuserinfo() {
		$uid = intval ( $this->uri->segment ( 3 ) );
		if ($uid) {
			$userinfo = $this->user_model->get_by_uid ( $uid, 1 );
			$is_followed = $this->user_model->is_followed ( $userinfo ['uid'], $this->user ['uid'] );
			$userinfo_group = $this->usergroup [$userinfo ['groupid']];
			include template ( "usercard" );
		}
	}
	function ajaxloadmessage() {
		$uid = $this->user ['uid'];
		if ($uid == 0) {
			return;
		}
		$user_categorys = $this->user ['category'] && array_per_fields ( $this->user ['category'], 'cid' );
		$message = array ();
		$this->load->model ( 'message_model' );
		$message ['msg_system'] = returnarraynum ( $this->db->query ( getwheresql ( 'message', " new=1 AND touid=$uid AND fromuid<>$uid AND fromuid=0 AND status<>2", $this->db->dbprefix ) )->row_array () );
		$message ['msg_personal'] = returnarraynum ( $this->db->query ( getwheresql ( 'message', " new=1 AND touid=$uid AND fromuid<>$uid AND fromuid<>0 AND status<>2", $this->db->dbprefix ) )->row_array () );
		$message ['message_recommand'] = $this->message_model->rownum_user_recommend ( $uid, $user_categorys, 'notread' );
		if ($message ['msg_personal'] > 0) {
			// 获取最新1条个人私信
			$message ['personmessagelist'] = $this->message_model->group_by_touid ( $uid, 0, 1 );
			$message ['url'] = url ( 'message/personal' );
			$message ['text'] = '';
			$messagemodel = $message ['personmessagelist'] [0];
			$messagemodel ['content'] = strip_tags ( $messagemodel ['content'] );
			switch ($messagemodel ['typename']) {
				case 'questioncomment' :
					$message ['text'] = "<b>[回答评论]</b> " . $messagemodel ['content'];
					break;
				case 'invateanswer' :
					$message ['text'] = "<b>[邀请回答]</b> " . $messagemodel ['content'];
					break;
				case 'attentionquestion' :
					$message ['text'] = "<b>[收藏问题]</b> " . $messagemodel ['content'];
					break;
				case 'attentionarticle' :
					$message ['text'] = "<b>[收藏文章]</b> " . $messagemodel ['content'];
					break;
				case 'attentionuser' :
					$message ['text'] = "<b>[关注用户]</b> " . $messagemodel ['content'];
					break;
				case 'answer' :
					$message ['text'] = "<b>[问题回答]</b> " . $messagemodel ['content'];
					break;
				case 'questiontouser' :
					$message ['text'] = "<b>[对用户提问]</b> " . $messagemodel ['content'];
					break;
				case 'adoptanswer' :
					$message ['text'] = "<b>[采纳回答]</b> " . $messagemodel ['content'];
					break;
				default :
					$message ['text'] = $messagemodel ['content'];
					break;
			}
		}
		
		if ($message ['msg_system'] > 0) {
			// 获取最新1条系统私信
			$message ['systemmessagelist'] = $this->message_model->list_by_touid ( $uid, 0, 1 );
			$message ['systemurl'] = url ( 'message/system' );
			$messagemodel = $message ['systemmessagelist'] [0];
			$messagemodel ['content'] = strip_tags ( $messagemodel ['content'] );
			$message ['systemtext'] = '';
			switch ($messagemodel ['typename']) {
				case 'questioncomment' :
					$message ['systemtext'] = "<b>[回答评论]</b> " . $messagemodel ['content'];
					break;
				case 'invateanswer' :
					$message ['systemtext'] = "<b>[邀请回答]</b> " . $messagemodel ['content'];
					break;
				case 'attentionquestion' :
					$message ['systemtext'] = "<b>[收藏问题]</b> " . $messagemodel ['content'];
					break;
				case 'attentionarticle' :
					$message ['systemtext'] = "<b>[收藏文章]</b> " . $messagemodel ['content'];
					break;
				case 'attentionuser' :
					$message ['systemtext'] = "<b>[关注用户]</b> " . $messagemodel ['content'];
					break;
				case 'answer' :
					$message ['systemtext'] = "<b>[问题回答]</b> " . $messagemodel ['content'];
					break;
				case 'questiontouser' :
					$message ['systemtext'] = "<b>[对用户提问]</b> " . $messagemodel ['content'];
					break;
				case 'adoptanswer' :
					$message ['systemtext'] = "<b>[采纳回答]</b> " . $messagemodel ['content'];
					break;
				default :
					$message ['systemtext'] = $messagemodel ['content'];
					break;
			}
		}
		
		echo tjson_encode ( $message );
		
		exit ();
	}
	function ajaxpayrecharge() {
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		$wx = $this->fromcache ( 'cweixin' );
		$money = doubleval ( $this->uri->segment ( 3 ) );
		if (is_mobile ()) {
			
			if (! strstr ( $useragent, 'MicroMessenger' )) {
				// 非微信浏览器采用H5支付
				require_once FCPATH . "/lib/wxpay/lib/WxPay.Api.php";
				require_once FCPATH . "/lib/wxpay/WxPay.JsApiPay.php";
				
				require_once FCPATH . '/lib/wxpay/log.php';
				
				if ($money > 0) {
					// ①、获取用户openid
					$tools = new JsApiPay ();
					
					$uid = $this->user ['uid'];
					
					$tpmoney = $money * 100;
					
					// ②、统一下单
					$t5 = rand ( 111111111, 999999999 );
					$input = new WxPayUnifiedOrder ();
					if ($this->uri->segment ( 4 ) && $this->uri->segment ( 4 ) == 'ask') {
						$input->SetBody ( "付费咨询付款" );
						$input->SetAttach ( "chongzhi_0_" . $uid . "_" . $tpmoney . "_" . intval ( $this->uri->segment ( 5 ) ) );
					} else {
						$input->SetBody ( "钱包充值" );
						$input->SetAttach ( "chongzhi_0_" . $uid . "_" . $tpmoney );
					}
					
					$input->SetOut_trade_no ( WxPayConfig::MCHID . date ( "YmdHis" ) );
					$input->SetTotal_fee ( $tpmoney );
					$input->SetTime_start ( date ( "YmdHis" ) );
					// $input->SetTime_expire(date("YmdHis", time() + 600));
					$input->SetGoods_tag ( "chongzhi_0_" . $uid . "_" . $tpmoney );
					$input->SetNotify_url ( WxPayConfig::Notify_Url );
					$input->SetTrade_type ( "MWEB" );
					$order = WxPayApi::unifiedOrder ( $input );
					if ($order ['return_code'] == 'SUCCESS' && $order ['result_code'] == 'SUCCESS') {
						$lasturl = $order ['mweb_url'];
						echo $lasturl;
					} else {
						echo 'error|' . $order ['err_code_des'];
						exit ();
					}
				}
			} else {
				if (strstr ( $useragent, 'MicroMessenger' ) && $wx ['appsecret'] != '' && $wx ['appsecret'] != null) {
					if ($this->setting ['openwxpay'] == 1) {
						
						require_once FCPATH . "/lib/wxpay/lib/WxPay.Api.php";
						require_once FCPATH . "/lib/wxpay/WxPay.JsApiPay.php";
						
						require_once FCPATH . '/lib/wxpay/log.php';
						$money = $this->input->post ( 'jine' );
						
						if ($money > 0) {
							
							// ①、获取用户openid
							$tools = new JsApiPay ();
							
							$openId = $this->input->post ( 'openid' );
							
							$uid = $this->user ['uid'];
							
							$tpmoney = $money * 100;
							
							// ②、统一下单
							$t5 = rand ( 111111111, 999999999 );
							$input = new WxPayUnifiedOrder ();
							
							if ($this->uri->segment ( 3 ) && $this->uri->segment ( 3 ) == 'ask') {
								$input->SetBody ( "付费咨询付款" );
								$input->SetAttach ( "chongzhi_0_" . $uid . "_" . $tpmoney . "_" . intval ( $this->input->post ( 'time' ) ) );
							} else {
								$input->SetBody ( "钱包充值" );
								$input->SetAttach ( "chongzhi_0_" . $uid . "_" . $tpmoney );
							}
							
							$input->SetOut_trade_no ( WxPayConfig::MCHID . date ( "YmdHis" ) );
							$input->SetTotal_fee ( $tpmoney );
							$input->SetTime_start ( date ( "YmdHis" ) );
							// $input->SetTime_expire(date("YmdHis", time() + 600));
							$input->SetGoods_tag ( "chongzhi_0_" . $uid . "_" . $tpmoney );
							$input->SetNotify_url ( WxPayConfig::Notify_Url );
							$input->SetTrade_type ( "JSAPI" );
							$input->SetOpenid ( $openId );
							
							$order = WxPayApi::unifiedOrder ( $input );
							
							if ($order ['return_code'] == 'SUCCESS' && $order ['result_code'] == 'SUCCESS') {
								
								$JsApi = $tools->GetJsApiParameters ( $order );
								
								echo $JsApi;
								exit ();
							} else {
								echo 'error|' . $order ['err_code_des'];
								exit ();
							}
							
							// var_dump($bestanswer['JsApi']);exit();
						}
					}
				}
			}
		} else {
			exit ( 'error|' . "请在移动端浏览器里打开" );
		}
		// var_dump($model['JsApi'] );
	}
	function ajaxpaycreditrecharge() {
		if (! $this->setting ['recharge_open']) {
			
			$order ['err_code_des'] = "网站暂不开放财富充值服务";
			echo $order ['err_code_des'];
			exit ();
		}
		
		if (is_mobile ()) {
			
			$useragent = $_SERVER ['HTTP_USER_AGENT'];
			$wx = $this->fromcache ( 'cweixin' );
			$money = doubleval ( $this->uri->segment ( 3 ) );
			
			if (! strstr ( $useragent, 'MicroMessenger' )) {
				if ($this->setting ['openwxpay'] == 1) {
					
					require_once FCPATH . "/lib/wxpay/lib/WxPay.Api.php";
					require_once FCPATH . "/lib/wxpay/WxPay.JsApiPay.php";
					
					require_once FCPATH . '/lib/wxpay/log.php';
					
					if ($money > 0) {
						
						$uid = $this->user ['uid'];
						
						$tpmoney = $money * 100;
						
						// ②、统一下单
						$t5 = rand ( 111111111, 999999999 );
						$input = new WxPayUnifiedOrder ();
						
						$input->SetBody ( "平台财富积分充值" );
						$input->SetAttach ( "creditchongzhi_0_" . $uid . "_" . $tpmoney );
						$input->SetOut_trade_no ( WxPayConfig::MCHID . date ( "YmdHis" ) );
						$input->SetTotal_fee ( $tpmoney );
						$input->SetTime_start ( date ( "YmdHis" ) );
						// $input->SetTime_expire(date("YmdHis", time() + 600));
						$input->SetGoods_tag ( "creditchongzhi_0_" . $uid . "_" . $tpmoney );
						$input->SetNotify_url ( WxPayConfig::Notify_Url );
						$input->SetTrade_type ( "MWEB" );
						
						$order = WxPayApi::unifiedOrder ( $input );
						
						if ($order ['return_code'] == 'SUCCESS' && $order ['result_code'] == 'SUCCESS') {
							
							$lasturl = $order ['mweb_url'];
							echo $lasturl;
							exit ();
						} else {
							echo $order ['err_code_des'];
							exit ();
						}
					}
				}
			} else {
				
				if (strstr ( $useragent, 'MicroMessenger' ) && $wx ['appsecret'] != '' && $wx ['appsecret'] != null) {
					if ($this->setting ['openwxpay'] == 1) {
						
						require_once FCPATH . "/lib/wxpay/lib/WxPay.Api.php";
						require_once FCPATH . "/lib/wxpay/WxPay.JsApiPay.php";
						
						require_once FCPATH . '/lib/wxpay/log.php';
						$money = $this->input->post ( 'jine' );
						if ($money > 0) {
							
							// ①、获取用户openid
							$tools = new JsApiPay ();
							
							$openId = $this->input->post ( 'openid' );
							
							$uid = $this->user ['uid'];
							
							$tpmoney = $money * 100;
							
							// ②、统一下单
							$t5 = rand ( 111111111, 999999999 );
							$input = new WxPayUnifiedOrder ();
							
							$input->SetBody ( "平台财富积分充值" );
							$input->SetAttach ( "creditchongzhi_0_" . $uid . "_" . $tpmoney );
							$input->SetOut_trade_no ( WxPayConfig::MCHID . date ( "YmdHis" ) );
							$input->SetTotal_fee ( $tpmoney );
							$input->SetTime_start ( date ( "YmdHis" ) );
							// $input->SetTime_expire(date("YmdHis", time() + 600));
							$input->SetGoods_tag ( "creditchongzhi_0_" . $uid . "_" . $tpmoney );
							$input->SetNotify_url ( WxPayConfig::Notify_Url );
							$input->SetTrade_type ( "JSAPI" );
							$input->SetOpenid ( $openId );
							
							$order = WxPayApi::unifiedOrder ( $input );
							
							if ($order ['return_code'] == 'SUCCESS' && $order ['result_code'] == 'SUCCESS') {
								
								// $model ['JsApi'] = $tools->GetJsApiParameters ( $order );
								$JsApi = $tools->GetJsApiParameters ( $order );
								
								echo $JsApi;
								exit ();
							} else {
								echo $order ['err_code_des'];
								exit ();
							}
							
							// var_dump($bestanswer['JsApi']);exit();
						}
					}
				}
			}
		} else {
			exit ( "请在移动端浏览器里打开" );
		}
		// var_dump($model['JsApi'] );
	}
	// 现金充值
	function recharge() {
		if (strpos ( $_SERVER ["REQUEST_URI"], "index.php?" ) == false) {
			$baseUrl = SITE_URL . 'index.php?' . urlmap ( $_SERVER ['QUERY_STRING'], 1 );
			header ( "Location:$baseUrl" );
		}
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		$wx = $this->fromcache ( 'cweixin' );
		
		if (strstr ( $useragent, 'MicroMessenger' ) && $wx ['appsecret'] != '' && $wx ['appsecret'] != null && $wx ['winxintype'] != 2) {
			
			$appid = $wx ['appid'];
			$appsecret = $wx ['appsecret'];
			
			require FCPATH . '/lib/php/jssdk.php';
			$jssdk = new JSSDK ( $appid, $appsecret );
			$signPackage = $jssdk->GetSignPackage ();
		}
		if (strstr ( $useragent, 'MicroMessenger' ) && $wx ['appsecret'] != '' && $wx ['appsecret'] != null) {
			
			// if ($bid>0&&strstr($useragent, 'MicroMessenger')&&$wx['appsecret']!=''&&$wx['appsecret']!=null) {
			if ($this->setting ['openwxpay'] == 1) {
				
				require_once FCPATH . "/lib/wxpay/lib/WxPay.Api.php";
				require_once FCPATH . "/lib/wxpay/WxPay.JsApiPay.php";
				
				require_once FCPATH . '/lib/wxpay/log.php';
				
				if (is_mobile ()) {
					
					$tools = new JsApiPay ();
					
					$openId = $tools->GetOpenid ();
					if (! isset ( $openId )) {
						
						$baseUrl = SITE_URL . 'index.php?' . urlmap ( $_SERVER ['QUERY_STRING'], 1 );
						header ( "Location:$baseUrl" );
					}
				}
			}
		}
		include template ( "recharge" );
	}
	// 财富充值
	function creditrecharge() {
		if ($this->user ['uid'] <= 0) {
			$this->message ( "请先登录", 'user/login' );
		}
		if (strpos ( $_SERVER ["REQUEST_URI"], "index.php?" ) == false) {
			$baseUrl = SITE_URL . 'index.php?' . urlmap ( $_SERVER ['QUERY_STRING'], 1 );
			header ( "Location:$baseUrl" );
		}
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		$wx = $this->fromcache ( 'cweixin' );
		
		if (strstr ( $useragent, 'MicroMessenger' ) && $wx ['appsecret'] != '' && $wx ['appsecret'] != null && $wx ['winxintype'] != 2) {
			
			$appid = $wx ['appid'];
			$appsecret = $wx ['appsecret'];
			
			require FCPATH . '/lib/php/jssdk.php';
			$jssdk = new JSSDK ( $appid, $appsecret );
			$signPackage = $jssdk->GetSignPackage ();
		}
		if (strstr ( $useragent, 'MicroMessenger' ) && $wx ['appsecret'] != '' && $wx ['appsecret'] != null) {
			
			// if ($bid>0&&strstr($useragent, 'MicroMessenger')&&$wx['appsecret']!=''&&$wx['appsecret']!=null) {
			if ($this->setting ['openwxpay'] == 1) {
				
				require_once FCPATH . "/lib/wxpay/lib/WxPay.Api.php";
				require_once FCPATH . "/lib/wxpay/WxPay.JsApiPay.php";
				
				require_once FCPATH . '/lib/wxpay/log.php';
				
				if (is_mobile ()) {
					
					$tools = new JsApiPay ();
					
					$openId = $tools->GetOpenid ();
					if (! isset ( $openId )) {
						
						$baseUrl = SITE_URL . 'index.php?' . urlmap ( $_SERVER ['QUERY_STRING'], 1 );
						header ( "Location:$baseUrl" );
					}
				}
			}
		}
		$navtitle = "财富充值";
		include template ( "creditrecharge" );
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
	// 用户提现申请
	function postrequestmoney() {
		if ($this->user ['uid'] <= 0) {
			$this->message ( "请先登录", 'user/login' );
		}
		// $this->load('userbank');
		$user_rmb = $this->user ['jine']; // $_ENV['userbank']->getmysummoneybytouid($this->user['uid']);
		
		$tixianjine = $this->setting ['tixianjine'] ? $this->setting ['tixianjine'] : 1;
		$tixianjine = doubleval ( $tixianjine );
		$posttixianjine = doubleval ( $this->input->post ( 'tixianjine' ) );
		if ($posttixianjine <= 0) {
			$this->message ( "对不起，您的可以提现金额小于" . $tixianjine . "元，无法提现" );
		}
		if (($user_rmb / 100) < $posttixianjine) {
			$this->message ( "申请提现金额超过用户可提现金额了" );
		}
		$rmb = 0;
		if (! isset ( $user_rmb )) {
			$rmb = 0;
		} else {
			$rmb = $posttixianjine; // $user_rmb/100;
		}
		
		if ($rmb < $tixianjine) {
			$this->message ( "对不起，您的可以提现金额小于" . $tixianjine . "元，无法提现" );
		}
		$tixianfeilv = $this->setting ['tixianfeilv'] ? $this->setting ['tixianfeilv'] : 0;
		$tixianfeilv = doubleval ( $tixianfeilv );
		$lastrmb = $rmb - $rmb * $tixianfeilv; // 最终可以提现金额=初始金额-扣除手续费
		if ($lastrmb < 1) {
			$this->message ( "微信规定最小提现金额不能小于1元，当前提现金额为" . ($lastrmb) . "元此次提现失败" );
		}
		$uid = $this->user ['uid'];
		$mod = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user_tixian WHERE state=0 and uid='$uid'" )->row_array ();
		if ($mod != null) {
			$this->message ( "您的提现申请正在审核" );
		}
		$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "user_tixian(uid,jine,state,time,beizu) values ('$uid','$rmb','0',{$this->time},'')" );
		
		// 提现金额大于正常值做资金托管
		if ($rmb > 0) {
			$this->load->model ( 'depositmoney_model' );
			$this->depositmoney_model->add ( $this->user ['uid'], $rmb, 'usertixian', $uid, $uid );
			$tpshangjin = $rmb * 100;
			$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET  `jine`=jine-'$tpshangjin' WHERE `uid`=$uid" );
			
			$time = time ();
			$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "paylog SET type='usertixian',typeid=$uid,money=$rmb,openid='',fromuid=0,touid=$uid,`time`=$time" );
		}
		
		// 提现用户发起通知
		$url = '';
		$text = "您申请提现" . $posttixianjine . "元请求已经收到，请耐心等待审核!</a>";
		$quser = $this->user;
		$wx = $this->fromcache ( 'cweixin' );
		//
		if ($wx ['appsecret'] != '' && $wx ['appsecret'] != null && $wx ['winxintype'] != 2) {
			require FCPATH . '/lib/php/jssdk.php';
			$appid = $wx ['appid'];
			$appsecret = $wx ['appsecret'];
			$jssdk = new JSSDK ( $appid, $appsecret );
			
			if ($quser ['openid'] != '' && $quser ['openid'] != null) {
				$description = "具体点击查看详情";
				if (! $this->setting ['weixin_tpl_tixianshenqing']) {
					$returnmesage = $jssdk->sendtexttouser ( $quser ['openid'], $text );
				} else {
					$returnmesage = $jssdk->sendtixianshengqingtpltouser ( $quser ['openid'], $this->setting ['weixin_tpl_tixianshenqing'], $url, "你好,提现申请已经收到。", $quser ['username'], date ( "Y-m-d H:i" ), $posttixianjine . "元", "微信零钱收款", "感谢你的使用。" );
				}
			}
		}
		$this->message ( "提现申请成功!" );
	}
	// 用户银行
	function userbank() {
		$navtitle = "我的个人钱包";
		if ($this->user ['uid'] <= 0) {
			$this->message ( "请先登录", 'user/login' );
		}
		$this->load->model ( 'userbank_model' );
		
		$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$moenylist = $this->userbank_model->getmymoney ( $this->user ['uid'], $startindex, $pagesize );
		
		$haspaymoney = $this->userbank_model->gethasmysummoneybytouid ( $this->user ['uid'] );
		$haspaymoney = $haspaymoney ['rmb'] / 100;
		// $user_rmb= $this->user['jine'];
		$user_rmb = $this->userbank_model->getmysummoneybytouid ( $this->user ['uid'] );
		$rmb = 0;
		if (! isset ( $user_rmb )) {
			$rmb = 0;
		} else {
			$rmb = $user_rmb ['rmb'] / 100;
		}
		$uid = $this->user ['uid'];
		$mod = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user_tixian WHERE state=0 and uid='$uid'" )->row_array ();
		if ($mod != null) {
			$shenhe = '1';
		}
		$m = $this->db->query ( "select count(*) as num from " . $this->db->dbprefix . "weixin_notify where touid={$this->user['uid']}" )->row_array ();
		$rownum = $m ['num'];
		$departstr = page ( $rownum, $pagesize, $page, "user/userbank" );
		//
		
		include template ( "userbank" );
	}
	// 用户对账流水
	function userzhangdan() {
		$navtitle = "我的对账流水";
		if ($this->user ['uid'] <= 0) {
			$this->message ( "请先登录", 'user/login' );
		}
		$this->load->model ( 'userbank_model' );
		
		$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$moenylist = $this->userbank_model->getzhangdan ( $this->user ['uid'], $startindex, $pagesize );
		
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'paylog', " touid={$this->user['uid']}", $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "user/userzhangdan" );
		//
		
		include template ( "userzhangdan" );
	}
	// 关注用户
	function attentto() {
		$navtitle = "我关注的用户";
		$uid = intval ( $this->input->post ( 'uid' ) );
		if (! $uid) {
			exit ( 'error' );
		}
		
		$is_followed = $this->user_model->is_followed ( $uid, $this->user ['uid'] );
		if ($is_followed) {
			
			$this->user_model->unfollow ( $uid, $this->user ['uid'], 'user' );
			$this->load->model ( "doing_model" );
			$this->doing_model->deletedoing ( $this->user ['uid'], 11, $uid );
			// 删除关注私信
			$this->load->model ( "message_model" );
			$username = addslashes ( $this->user ['username'] );
			$subject = $username . "刚刚关注了您";
			$this->message_model->delmessage ( $uid, $subject, 'attentionuser' );
		} else {
			if ($uid == $this->user ['uid']) {
				exit ( 'self' );
			}
			$this->user_model->follow ( $uid, $this->user ['uid'], $this->user ['username'], 'user' );
			$quser = $this->user_model->get_by_uid ( $uid );
			$this->load->model ( "doing_model" );
			$this->doing_model->add ( $this->user ['uid'], $this->user ['username'], 11, $uid, $quser ['username'] );
			$msgfrom = $this->setting ['site_name'] . '管理员';
			$username = addslashes ( $this->user ['username'] );
			if ($quser ['notify'] ['follow_object']) {
				$this->load->model ( "message_model" );
				$this->message_model->add ( $msgfrom, 0, $uid, $username . "刚刚关注了您", '<a target="_blank" href="' . url ( 'user/space/' . $this->user ['uid'], 1 ) . '">' . $username . '</a> 刚刚关注了您!<br /> <a href="' . url ( 'user/follower', 1 ) . '">点击查看</a>', attentionuser );
			}
		}
		exit ( 'ok' );
	}
	function myjifen() {
		$navtitle = "我的财富值详情";
		if ($this->user ['uid'] <= 0) {
			$this->message ( "请先登录", 'user/login' );
		}
		// 获取我的积分列表
		$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$jifenlist = $this->user_model->credit_detail ( $this->user ['uid'], $startindex, $pagesize );
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'credit', " uid={$this->user['uid']}", $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "user/myjifen" );
		//
		include template ( "myjifen" );
	}
	function invatelist() {
		$navtitle = "我邀请注册的用户列表";
		if ($this->user ['uid'] <= 0) {
			$this->message ( "请先登录", 'user/login' );
		}
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		if (strstr ( $useragent, 'MicroMessenger' )){
			$wx = $this->fromcache ( 'cweixin' );
			if ($wx ['appsecret'] != '' && $wx ['appsecret'] != null && $wx ['winxintype'] != 2) {
				$appid = $wx ['appid'];
				$appsecret = $wx ['appsecret'];
				require FCPATH . 'lib/php/jssdk.php';
				$jssdk = new JSSDK ( $appid, $appsecret );
				$signPackage = $jssdk->GetSignPackage ();
			}
		}
		// 获取我的邀请注册的用户列表
		$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$followerlist = $this->user_model->getinvatelist ( $this->user ['invatecode'], $startindex, $pagesize );
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'user', " frominvatecode='{$this->user ['invatecode']}'", $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "user/invatelist" );
		include template ( "invatelist" );
	}
}

?>