<?php
ini_set ( 'user_agent', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; Win64; x64; .NET CLR 2.0.50727; SLCC1; Media Center PC 5.0; .NET CLR 3.0.30618; .NET CLR 3.5.30729)' );
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Admin_setting extends ADMIN_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( "tag_model" );
		$this->load->model ( 'user_model' );
		$this->load->model ( 'setting_model' );
		$this->load->model ( "question_model" );
		$this->load->model ( "doing_model" );
		$this->load->model ( "category_model" );
		$this->load->model ( 'answer_model' );
		$this->load->model ( 'answer_comment_model' );
	}
	function index() {
		$this->sitesetting ();
	}
	
	/* 基本设置 */
	function sitesetting() {
		$themetpllist = $this->setting_model->tpl_themelist ();
		$tpllist = $this->setting_model->tpl_list ();
		$waptpllist = $this->setting_model->tpl_waplist ();
		
		if (null !== $this->input->post ( 'submit' )) {
			
			// runlog("11bg.txt", $_POST['banner_color']);
			if (isset ( $_FILES ["file_upload"] )) {
				$imgname = strtolower ( $_FILES ['file_upload'] ['name'] );
				
				$type = substr ( strrchr ( $imgname, '.' ), 1 );
				
				if (isimage ( $type )) {
					
					$upload_tmp_file = FCPATH . '/data/tmp/sitelogo.' . $type;
					
					$filepath = '/data/attach/logo/logo' . '.' . $type;
					forcemkdir ( FCPATH . '/data/attach/logo' );
					if (move_uploaded_file ( $_FILES ['file_upload'] ['tmp_name'], FCPATH . $filepath )) {
						unlink ( $filepath );
						image_resize ( $upload_tmp_file, $filepath, 172, 60 );
						// move_uploaded_file($upload_tmp_file,FCPATH. $filepath);
						try {
							$this->setting ['site_logo'] = SITE_URL . substr ( $filepath, 1 );
						} catch ( Exception $e ) {
							print $e->getMessage ();
						}
					} else {
					}
				}
			}
			
			if (isset ( $_FILES ["bannerfile"] )) {
				$bannerfile = strtolower ( $_FILES ['bannerfile'] ['name'] );
				$bannertype = substr ( strrchr ( $bannerfile, '.' ), 1 );
				
				if (isimage ( $bannertype )) {
					
					$upload_tmp_file = FCPATH . '/data/tmp/sitebanner.' . $bannertype;
					
					$filepath = '/data/attach/banner/sitebanner' . '.' . $bannertype;
					forcemkdir ( FCPATH . '/data/attach/banner' );
					if (move_uploaded_file ( $_FILES ['bannerfile'] ['tmp_name'], $upload_tmp_file )) {
						
						image_resize ( $upload_tmp_file, FCPATH . $filepath, 1180, 400 );
						try {
							$this->setting ['banner_img'] = SITE_URL . substr ( $filepath, 1 );
						} catch ( Exception $e ) {
							print $e->getMessage ();
						}
					}
				}
			}
			
			$this->setting ['banner_color'] = $this->input->post ( 'banner_color' );
			
			$this->setting ['site_name'] = $this->input->post ( 'site_name' );
			$this->setting ['seo_index_title'] = $this->input->post ( 'seo_index_title' );
			$this->setting ['openweixin'] = $this->input->post ( 'openweixin' );
			$this->setting ['register_clause'] = $this->input->post ( 'register_clause' );
			$this->setting ['site_icp'] = $this->input->post ( 'site_icp' );
			$this->setting ['verify_question'] = $this->input->post ( 'verify_question' );
			$this->setting ['allow_outer'] = $this->input->post ( 'allow_outer' );
			$this->setting ['tpl_dir'] = $this->input->post ( 'tpl_dir' );
			$this->setting ['jingyan'] = $this->input->post ( 'jingyan' );
			$this->setting ['hct_logincode'] = $this->input->post ( 'hct_logincode' );
			
			$this->setting ['tpl_themedir'] = $this->input->post ( 'tpl_themedir' );
			$this->setting ['tpl_wapdir'] = $this->input->post ( 'tpl_wapdir' );
			$this->setting ['wap_domain'] = $this->input->post ( 'wap_domain' );
			$this->setting ['question_share'] = stripslashes ( $this->input->post ( 'question_share' ) );
			$this->setting ['site_statcode'] = encode ( $_POST ['site_statcode'], 'tongji' );
			
			$this->setting ['index_life'] = $this->input->post ( 'index_life' );
			$this->setting ['sum_category_time'] = $this->input->post ( 'sum_category_time' );
			$this->setting ['sum_onlineuser_time'] = $this->input->post ( 'sum_onlineuser_time' );
			$this->setting ['list_default'] = $this->input->post ( 'list_default' );
			$this->setting ['rss_ttl'] = $this->input->post ( 'rss_ttl' );
			$this->setting ['code_register'] = intval ( $this->input->post ( 'code_register' ) );
			
			$this->setting ['cancopy'] = intval ( $this->input->post ( 'cancopy' ) );
			$this->setting ['code_login'] = intval ( $this->input->post ( 'code_login' ) );
			$this->setting ['code_ask'] = intval ( $this->input->post ( 'code_ask' ) );
			$this->setting ['code_message'] = intval ( $this->input->post ( 'code_message' ) );
			$this->setting ['notify_mail'] = intval ( $this->input->post ( 'notify_mail' ) );
			$this->setting ['notify_message'] = intval ( $this->input->post ( 'notify_message' ) );
			$this->setting ['allow_expert'] = intval ( $this->input->post ( 'allow_expert' ) );
			$this->setting ['apend_question_num'] = intval ( $this->input->post ( 'apend_question_num' ) );
			$this->setting ['allow_credit3'] = intval ( $this->input->post ( 'allow_credit3' ) );
			$overdue_days = intval ( $this->input->post ( 'overdue_days' ) );
			
			if ($overdue_days && $overdue_days >= 3) {
				$this->setting ['overdue_days'] = $overdue_days;
				$this->setting_model->update ( $this->setting );
				$message = '站点设置更新成功！';
			} else {
				$type = "errormsg";
				$message = '问题过期时间至少为3天！';
			}
		}
		include template ( 'setting_base', 'admin' );
	}
	
	/* 时间设置 */
	function time() {
		$timeoffset = array (
				'-12' => '(标准时-12:00) 日界线西',
				'-11' => '(标准时-11:00) 中途岛、萨摩亚群岛',
				'-10' => '(标准时-10:00) 夏威夷',
				'-9' => '(标准时-9:00) 阿拉斯加',
				'-8' => '(标准时-8:00) 太平洋时间(美国和加拿大)',
				'-7' => '(标准时-7:00) 山地时间(美国和加拿大)',
				'-6' => '(标准时-6:00) 中部时间(美国和加拿大)、墨西哥城',
				'-5' => '(标准时-5:00) 东部时间(美国和加拿大)、波哥大',
				'-4' => '(标准时-4:00) 大西洋时间(加拿大)、加拉加斯',
				'-3.5' => '(标准时-3:30) 纽芬兰',
				'-3' => '(标准时-3:00) 巴西、布宜诺斯艾利斯、乔治敦',
				'-2' => '(标准时-2:00) 中大西洋',
				'-1' => '(标准时-1:00) 亚速尔群岛、佛得角群岛',
				'0' => '(格林尼治标准时) 西欧时间、伦敦、卡萨布兰卡',
				'1' => '(标准时+1:00) 中欧时间、安哥拉、利比亚',
				'2' => '(标准时+2:00) 东欧时间、开罗，雅典',
				'3' => '(标准时+3:00) 巴格达、科威特、莫斯科',
				'3.5' => '(标准时+3:30) 德黑兰',
				'4' => '(标准时+4:00) 阿布扎比、马斯喀特、巴库',
				'4.5' => '(标准时+4:30) 喀布尔',
				'5' => '(标准时+5:00) 叶卡捷琳堡、伊斯兰堡、卡拉奇',
				'5.5' => '(标准时+5:30) 孟买、加尔各答、新德里',
				'6' => '(标准时+6:00) 阿拉木图、 达卡、新亚伯利亚',
				'7' => '(标准时+7:00) 曼谷、河内、雅加达',
				'8' => '(标准时+8:00)北京、重庆、香港、新加坡',
				'9' => '(标准时+9:00) 东京、汉城、大阪、雅库茨克',
				'9.5' => '(标准时+9:30) 阿德莱德、达尔文',
				'10' => '(标准时+10:00) 悉尼、关岛',
				'11' => '(标准时+11:00) 马加丹、索罗门群岛',
				'12' => '(标准时+12:00) 奥克兰、惠灵顿、堪察加半岛' 
		);
		if (null !== $this->input->post ( 'submit' )) {
			$this->setting ['time_offset'] = $this->input->post ( 'time_offset' );
			$this->setting ['time_diff'] = $this->input->post ( 'time_diff' );
			$this->setting ['date_format'] = $this->input->post ( 'date_format' );
			$this->setting ['time_format'] = $this->input->post ( 'time_format' );
			$this->setting ['time_friendly'] = $this->input->post ( 'time_friendly' );
			$this->setting_model->update ( $this->setting );
			$message = '时间设置更新成功！';
		}
		include template ( 'setting_time', 'admin' );
	}
	
	/* 列表显示 */
	function clist() {
		if (null !== $this->input->post ( 'submit' )) {
			foreach ( $_POST as $key => $value ) {
				if ('list' == substr ( $key, 0, 4 )) {
					$this->setting [$key] = $value;
				}
			}
			$this->setting ['title_description'] = $this->input->post ( 'title_description' );
			$this->setting ['hot_on'] = intval ( $this->input->post ( 'hot_on' ) );
			$this->setting ['index_life'] = intval ( $this->input->post ( 'index_life' ) );
			$this->setting ['hot_words'] = $this->setting_model->get_hot_words ( $this->setting ['list_hot_words'] );
			$this->setting_model->update ( $this->setting );
			$message = '列表显示更新成功！';
		}
		include template ( 'setting_list', 'admin' );
	}
	// 关注问题
	function attention_question($qid, $user_uid, $user_username) {
		$uid = $user_uid;
		$username = $user_username;
		$is_followed = $this->question_model->is_followed ( $qid, $uid );
		if ($is_followed) {
			$this->user_model->unfollow ( $qid, $uid );
		} else {
			$this->user_model->follow ( $qid, $uid, $username );
			
			$this->doing_model->add ( $uid, $username, 4, $qid );
		}
	}
	function rand_time($a, $b) {
		$a = strtotime ( $a );
		$b = strtotime ( $b );
		return date ( "Y-m-d H:m:s", mt_rand ( $a, $b ) );
	}
	function getoncaiji() {
		$result = array ();
		require 'simple_html_dom.php';
		$title = strip_tags ( $this->input->post ( "title" ) ); // $_POST["title"];
		$caiji_url = $this->input->post ( "daanurl" );
		$caiji_prefix = $this->input->post ( "guize" );
		$caiji_desc = $this->input->post ( "daandesc" );
		$caiji_best = $this->input->post ( "daanbest" );
		$caiji_hdusertx = $this->input->post ( "caiji_hdusertx" );
		$caiji_hdusername = $this->input->post ( "caiji_hdusername" );
		$bianma = $this->input->post ( "bianma" );
		$ckabox = $this->input->post ( "ckabox" );
		$imgckabox = $this->input->post ( "imgckabox" );
		
		$result ['ckabox'] = $ckabox;
		$result ['imgckabox'] = $imgckabox;
		$html = file_get_html ( $caiji_url );
		
		try {
			$desc = '';
			if ($caiji_desc != '') {
				$wtdesc = $html->find ( $caiji_desc );
				if (isset ( $wtdesc [0] )) {
					$desc = $wtdesc [0]->outertext;
				}
				
				$suffer = substr ( $desc, 0, 4 );
				if ($suffer == '<pre') {
					$desc = $wtdesc [0]->plaintext;
				}
			}
			
			$q = $this->question_model->get_by_title ( htmlspecialchars ( $title ) );
			if ($q != null) {
				$result ['result'] = '1';
			} else {
				$result ['result'] = '0';
			}
			
			// $desc=htmlspecialchars($desc);
			
			$desc = str_replace ( '<img class=">ͼ"', '', $desc );
			$desc = str_replace ( '<img class=">图" class="ikqb_img_alink', '', $desc );
			
			// if($ckabox=='true'||$ckabox=='on'){
			// $desc=filter_outer($desc);
			// }
			// if($imgckabox=='true'||$imgckabox=='on'){
			// $desc=filter_imgouter($desc);
			// }
			
			$result ['miaosu'] = $desc; // 问题描述
			
			$wtbest = $html->find ( $caiji_best );
			$atest = $wtbest [0]->outertext;
			
			if ($ckabox == 'true' || $ckabox == 'on') {
				
				$atest = preg_replace ( "#<a[^>]*>(.*?)</a>#is", "$1", $atest );
			}
			if ($imgckabox == 'true' || $imgckabox == 'on') {
				
				$atest = preg_replace ( '/<img[^>]+>/i', '', $atest );
			}
			$result ['bestanswer'] = $atest; // 最佳答案
			
			if ($imgckabox == 'true' || $imgckabox == 'on') {
				
				$result ['guolvtupuan'] = '过滤图片'; // 过滤图片
			}
			// 其它回答
			$type_fill = $html->find ( $caiji_prefix );
			$result ['otherlist'] = array ();
			$count1 = 0;
			foreach ( $type_fill as $r ) {
				if ($bianma == 'gb2312') {
					$caijilist [$count1] ['title'] = iconv ( 'gb2312', 'utf-8', $r->outertext );
				} else {
					$str = $r->outertext;
					$str = str_replace ( "'", "", $str );
					$str = str_replace ( '<pre style="font-family:微软雅黑;">', "", $str );
					$str = str_replace ( '</pre>', "", $str );
					
					$caijilist [$count1] ['title'] = $str;
					
					// $caijilist[$count1]['title']= $r->outertext ;
				}
				if ($ckabox == 'true' || $ckabox == 'on') {
					// $caijilist[$count1]['title']=filter_outer($caijilist[$count1]['title']);
					$caijilist [$count1] ['title'] = preg_replace ( "#<a[^>]*>(.*?)</a>#is", "$1", $caijilist [$count1] ['title'] );
				}
				if ($imgckabox == 'true' || $imgckabox == 'on') {
					$caijilist [$count1] ['title'] = preg_replace ( '/<img[^>]+>/i', '', $caijilist [$count1] ['title'] );
					
					// $caijilist[$count1]['title']=filter_imgouter($caijilist[$count1]['title']);
				}
				$caijilist [$count1] ['title'] = preg_replace ( '/<p class="tr">.*?<\/p>/is', '', $caijilist [$count1] ['title'] );
				array_push ( $result ['otherlist'], $caijilist [$count1] ['title'] );
				$count1 ++;
			}
		} catch ( Exception $err ) {
		}
		
		$html->clear ();
		
		echo json_encode ( $result );
		exit ();
	}
	function putcaiji() {
		$result = array ();
		$json = json_decode ( $_POST ["jsonstring"], true );
		$title = $json ['m_title'];
		$desc = $json ['m_miaosu'];
		$tiwentime = $json ['m_tiwentime'];
		$huidatime = $json ['m_huidatime'];
		$ckabox = $this->input->post ( "ckabox" );
		$imgckabox = $this->input->post ( "imgckabox" );
		$randclass = $json ["randclass"];
		$cid = $json ["cid"];
		
		$cid1 = $json ["cid1"];
		if (isset ( $json ["cid2"] )) {
			$cid2 = $json ["cid2"];
		} else {
			$cid2 = 0;
		}
		
		if (isset ( $json ["cid3"] )) {
			$cid3 = $json ["cid3"];
		} else {
			$cid3 = 0;
		}
	
	
		
		// $catlist=$_ENV['category']->list_by_pid($catmodel['pid']);
		if (trim ( $randclass ) != '') {
			
			$classarray = explode ( ',', $randclass );
			$cidindex = array_rand ( $classarray, 1 );
			$cid = $classarray [$cidindex];
			$catlist = $this->category_model->get ( $cid );
			if ($catlist ['pid'] == 0) {
				$cid1 = $cid;
			} else {
				$cid1 = $catlist ['pid'];
				$cid2 = $cid;
			}
			
			$cid3 = 3;
		}
		if ($title == "" || $title == null) {
			
			$result ['result'] = "-1";
			echo json_encode ( $result );
			exit ();
		}
		$q = $this->question_model->get_by_title ( htmlspecialchars ( $title ) );
		if ($q != null) {
			$result ['result'] = "0";
			echo json_encode ( $result );
			exit ();
		}
		// 插入标题和描述
		$nowtime = date ( "Y-m-d H:i:s" );
		$tiwentime = $tiwentime * 60;
		$randtime = rand ( 1, $tiwentime );
		
		$t1 = date ( 'Y-m-d H:i:s', strtotime ( "-$randtime minute" ) ); // "2015-1-29 08:43:21";
		
		$mtime = strtotime ( $t1 );
		$userlist = $this->user_model->get_caiji_list ( 0, 500 );
		$mwtuid = array_rand ( $userlist, 1 );
		$uid = $userlist [$mwtuid] ['uid'];
		$username = $userlist [$mwtuid] ['username'];
		
		$desc = str_replace ( "'", '"', $desc );
		
		$qid = $this->question_model->add_seo ( htmlspecialchars ( $title ), $uid, $username, $desc, 0, 0, $cid, $cid1, $cid2, $cid3, 1, rand ( 100, 200 ), $mtime );
	
		$numuser = rand ( 3, 5 );
		for($i = 0; $i <= $numuser; $i ++) {
			$auid = array_rand ( $userlist, 1 );
			$_uid = $userlist [$auid] ['uid'];
			$_username = $userlist [$auid] ['username'];
			$this->attention_question ( $qid, $_uid, $_username );
		}
		
		$taglist = dz_segment ( htmlspecialchars ( $title ) );
		$taglist && $this->tag_model->multi_add ( array_unique ( $taglist ), $qid );
		
		$this->doing_model->add ( $uid, $username, 1, $qid, '' );
		
		$caijilist = array ();
		$count1 = 0;
		$commentarr = array (
				'真给力',
				"谢谢你",
				'非常感谢你',
				'你真是个大好人',
				'你真的帮了我大忙',
				'高手留个联系方式吧',
				'大神......' 
		);
		$comment = $commentarr [array_rand ( $commentarr, 1 )];
		
		$num = 1;
		$aid = 0;
		// 如果最佳答案存在不为空就设置这个最佳答案
		if (! empty ( $json ["m_q_best"] ) && $json ["m_q_best"] != '') {
			
			$randtime = rand ( 1, $huidatime );
			$t2 = date ( 'Y-m-d H:i:s', strtotime ( "+$randtime minute" ) );
			
			$mtime = strtotime ( $t2 );
			$quid = array_rand ( $userlist, 1 );
			$_buid = $userlist [$quid] ['uid'];
			$_busername = $userlist [$quid] ['username'];
			
			$json ["m_q_best"] = str_replace ( "'", '"', $json ["m_q_best"] );
			$json ["m_q_best"] = preg_replace ( '/<p class="tr">.*?<\/p>/is', '', $json ["m_q_best"] );
			$aid = $this->answer_model->add_seo ( $qid, $title, $json ["m_q_best"], $_buid, $_busername, 1, rand ( 20, 80 ), $mtime );
			unset ( $userlist [array_search ( $_busername, $userlist )] );
			
			$answer = $this->answer_model->get ( $aid );
			
			$ret = $this->answer_model->adopt ( $qid, $answer );
			if ($ret) {
				$this->answer_comment_model->add ( $aid, $comment, $uid, $username );
				$this->doing_model->add ( $uid, $username, 8, $qid, $comment, $aid, $_buid, $title );
			}
		}
		
		// 采集其它回答
		foreach ( $json ['m_q_other'] as $k => $v ) {
			$acontent = $v ['content'];
			
			if (empty ( $acontent ) && $acontent == '') {
				continue;
			}
			if (strstr ( $acontent, '<span>热心卡友</span>' )) {
				continue;
			}
			$randtime = rand ( 1, $huidatime );
			$t2 = date ( 'Y-m-d H:i:s', strtotime ( "+$randtime minute" ) );
			
			$mtime = strtotime ( $t2 );
			$quid = array_rand ( $userlist, 1 );
			$_buid = $userlist [$quid] ['uid'];
			$_busername = $userlist [$quid] ['username'];
			
			$acontent = str_replace ( "'", '"', $acontent );
			$acontent = preg_replace ( '/<p class="tr">.*?<\/p>/is', '', $acontent );
			$aid = $this->answer_model->add_seo ( $qid, $title, $acontent, $_buid, $_busername, 1, rand ( 20, 80 ), $mtime );
			unset ( $userlist [array_search ( $_busername, $userlist )] );
		}
		$result ['result'] = "1";
		echo json_encode ( $result );
		exit ();
	}
	
	/* ajax插入数据 */
	function ajaxcaiji() {
		$title = strip_tags ( $this->input->post ( "title" ) ); // $_POST["title"];
		$tiwentime = strip_tags ( $this->input->post ( "tiwentime" ) ); // $_POST["title"];
		$huidatime = strip_tags ( $this->input->post ( "huidatime" ) ); // $_POST["title"];
		$randclass = $this->input->post ( "randclass" );
		$cid = $this->input->post ( "cid" );
		
		$caiji_beginnum = $this->input->post ( "caiji_beginnum" );
		$caiji_endnum = $this->input->post ( "caiji_endnum" );
		
		$cid1 = $this->input->post ( "cid1" );
		$cid2 = $this->input->post ( "cid2" );
		$cid3 = $this->input->post ( "cid3" );
		if ($cid3 == null) {
			$cid3 = 0;
		}
		if ($cid2 == null) {
			$cid2 = 0;
		}
		// $catlist=$_ENV['category']->list_by_pid($catmodel['pid']);
		if (trim ( $randclass ) != ''&&!empty($randclass)) {
			
			$classarray = explode ( ',', $randclass );
			$cidindex = array_rand ( $classarray, 1 );
			$cid = $classarray [$cidindex];
			$catlist = $this->category_model->get ( $cid );
			if ($catlist ['pid'] == 0) {
				$cid1 = $cid;
			} else {
				$cid1 = $catlist ['pid'];
				$cid2 = $cid;
			}
			
			$cid3 = 3;
		}
		
		$uid = $this->input->post ( "uid" );
		$ckbox = $this->input->post ( "ckbox" );
		$username = $this->input->post ( "username" );
		$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 500;
		$startindex = ($page - 1) * $pagesize;
		$userlist = $this->user_model->get_caiji_list ( $startindex, $pagesize );
		$mwtuid = array_rand ( $userlist, 1 );
		$uid = $userlist [$mwtuid] ['uid'];
		$username = $userlist [$mwtuid] ['username'];
		// unset($userlist[array_search($username,$userlist)]);
		$nowtime = date ( "Y-m-d H:i:s" );
		$tiwentime = $tiwentime * 60;
		$randtime = rand ( 1, $tiwentime );
		
		$t1 = date ( 'Y-m-d H:i:s', strtotime ( "-$randtime minute" ) ); // "2015-1-29 08:43:21";
		
		$mtime = strtotime ( $t1 );
		// include 'lib/simple_html_dom.php';
		require 'simple_html_dom.php';
		$caiji_url = $this->input->post ( "daanurl" );
		$caiji_prefix = $this->input->post ( "guize" );
		$caiji_desc = $this->input->post ( "daandesc" );
		$caiji_best = $this->input->post ( "daanbest" );
		$caiji_hdusertx = $this->input->post ( "caiji_hdusertx" );
		$caiji_hdusername = $this->input->post ( "caiji_hdusername" );
		$bianma = $this->input->post ( "bianma" );
		$ckabox = $this->input->post ( "ckabox" );
		$imgckabox = $this->input->post ( "imgckabox" );
		$html = file_get_html ( $caiji_url );
		//
		$res = "";
		try {
			
			$desc = '';
			if ($caiji_desc != '') {
				$wtdesc = $html->find ( $caiji_desc );
				
				$desc = $wtdesc [0]->outertext;
				$suffer = substr ( $desc, 0, 4 );
				if ($suffer == '<pre') {
					$desc = $wtdesc [0]->plaintext;
				}
			}
			
			if ($title == "" || $title == null) {
				echo "标题不能为空";exit();
				return false;
			}
			$q = $this->question_model->get_by_title ( htmlspecialchars ( $title ) );
			if ($q != null){
				echo $title."已经存在";exit();
				return false;
			}
				
			
			// $desc=htmlspecialchars($desc);
			
			if ($ckabox == 'true' || $ckabox == 'on') {
				
				$desc = preg_replace ( "#<a[^>]*>(.*?)</a>#is", "$1", $desc );
			}
			if ($imgckabox == 'true' || $imgckabox == 'on') {
				
				$desc = preg_replace ( '/<img[^>]+>/i', '', $desc );
			}
			$desc = str_replace ( "'", '"', $desc );
			$qid = $this->question_model->add_seo ( htmlspecialchars ( $title ), $uid, $username, $desc, 0, 0, $cid, $cid1, $cid2, $cid3, 1, rand ( 100, 200 ), $mtime );
			
			if ($qid == 0) {
				exit ();
			}
			$numuser = rand ( 3, 5 );
			for($i = 0; $i <= $numuser; $i ++) {
				$auid = array_rand ( $userlist, 1 );
				$_uid = $userlist [$auid] ['uid'];
				$_username = $userlist [$auid] ['username'];
				$this->attention_question ( $qid, $_uid, $_username );
			}
			
			$taglist = dz_segment ( htmlspecialchars ( $title ) );
			$taglist && $this->tag_model->multi_add ( array_unique ( $taglist ), $qid );
			
			$this->doing_model->add ( $uid, $username, 1, $qid, '' );
		} catch ( Exception $err ) {
			$res = 'dddd'; // $err->getMessage();
				               // print $err->getMessage();
		}
		$wtbest = $html->find ( $caiji_best );
		$atest = $wtbest [0]->outertext;
		$type_fill = $html->find ( $caiji_prefix );
		
		if (isset ( $wtbest ) && $wtbest != "" && $wtbest != null)
			$type_fill = array_merge ( $wtbest, $type_fill );
		
		//
		// //print_r($type_fill);
		
		$caijilist = array ();
		$count1 = 0;
		$commentarr = array (
				'真给力',
				"谢谢你",
				'非常感谢你',
				'你真是个大好人',
				'你真的帮了我大忙',
				'高手留个联系方式吧',
				'大神......' 
		);
		$comment = $commentarr [array_rand ( $commentarr, 1 )];
		$countarr = count ( $type_fill );
		$rand = rand ( 1, $countarr );
		$num = 1;
		$aid = 0;
		$answer_adopt_num = rand ( 1, 10 ) % 2;
		foreach ( $type_fill as $r ) {
			
			$randtime = rand ( 1, $huidatime );
			$t2 = date ( 'Y-m-d H:i:s', strtotime ( "+$randtime minute" ) );
			
			$mtime = strtotime ( $t2 );
			$caijilist [$count1] ['num'] = $count1;
			
			if ($bianma == 'gb2312') {
				$caijilist [$count1] ['title'] = iconv ( 'gb2312', 'utf-8', $r->outertext );
			} else {
				$str = $r->outertext;
				$str = str_replace ( "'", "", $str );
				$str = str_replace ( '<pre style="font-family:微软雅黑;">', "", $str );
				$str = str_replace ( '</pre>', "", $str );
				$caijilist [$count1] ['title'] = $str;
				
				// $caijilist[$count1]['title']= $r->outertext ;
			}
			if (strstr ( $caijilist [$count1] ['title'], '<span>热心卡友</span>' )) {
				continue;
			}
			if (count ( $userlist ) > 0) {
				$quid = array_rand ( $userlist, 1 );
				$wdusername = $html->find ( $caiji_hdusername );
				$wendausername = $wdusername [$count1]->plaintext;
				$wduserimage = $html->find ( $caiji_hdusertx );
				
				$wendauserimg = $wduserimage [$count1]->src;
				
				// print_r($wendauserimg) ;
				$user = $this->user_model->get_by_username ( $wendausername );
				
				if (! $user) {
					$pwd=random(11);
					$email=random(10). "@qq.com";
					$hduid = $this->user_model->caijiadd ( $wendausername,$pwd,$email );
					// ucenter注册。
					if ($this->setting ["ucenter_open"]) {
						$this->load->model ( 'ucenter_model' );
						 $this->ucenter_model->ajaxregister ( $wendausername, $pwd, $email, '', 0 );					
					}
					
					$hduid = intval ( $hduid );
					$avatardir = "/data/avatar/";
					$extname = substr ( strrchr ( $wendauserimg, '.' ), 1 );
					$upload_tmp_file = FCPATH . '/data/tmp/user_avatar_' . $hduid . '.' . $extname;
					$hduid = abs ( $hduid );
					$hduid = sprintf ( "%09d", $hduid );
					$dir1 = $avatardir . substr ( $hduid, 0, 3 );
					$dir2 = $dir1 . '/' . substr ( $hduid, 3, 2 );
					$dir3 = $dir2 . '/' . substr ( $hduid, 5, 2 );
					(! is_dir ( FCPATH . $dir1 )) && forcemkdir ( FCPATH . $dir1 );
					(! is_dir ( FCPATH . $dir2 )) && forcemkdir ( FCPATH . $dir2 );
					(! is_dir ( FCPATH . $dir3 )) && forcemkdir ( FCPATH . $dir3 );
					
					$smallimg = $dir3 . "/small_" . $hduid . '.' . $extname;
					$smallimgdir = $dir3 . "/";
					$this->getImage ( $wendauserimg, "small_" . $hduid . '.' . $extname, FCPATH . $smallimgdir, array (
							'jpg',
							'jpeg',
							'png',
							'gif' 
					) );
				} else {
					$hduid = $user ['uid'];
				}
				if ($wendausername == '') {
					$hduid = $userlist [$quid] ['uid'];
					$wendausername = $userlist [$quid] ['username'];
				}
				
				$answer_content = $caijilist [$count1] ['title'];
				
				// $img_arr=getfirstimgs($answer_content);
				// if($img_arr[1]!=null){
				// for($i=0;$i<count($img_arr[1]);$i++){
				// $img_url=getImageFile($img_arr[1][$i],rand(100000, 99999999).".jpg","upload/",1);
				// $answer_content=str_replace($img_arr[1][$i],SITE_URL.$img_url, $answer_content);
				// }
				// }
				
				if ($ckabox == 'true' || $ckabox == 'on') {
					
					$answer_content = preg_replace ( "#<a[^>]*>(.*?)</a>#is", "$1", $answer_content );
				}
				if ($imgckabox == 'true' || $imgckabox == 'on') {
					
					$answer_content = preg_replace ( '/<img[^>]+>/i', '', $answer_content );
				}
				$answer_content = str_replace ( "'", '"', $answer_content );
				$answer_content = preg_replace ( '/<p class="tr">.*?<\/p>/is', '', $answer_content );
				$aid = $this->answer_model->add_seo ( $qid, $title, $answer_content, $hduid, $wendausername, 1, rand ( 20, 80 ), $mtime );
				unset ( $userlist [array_search ( $wendausername, $userlist )] );
				// $_ENV['answer_comment']->add($aid, $comment, $uid, $username);
				// $_ENV['doing']->add($uid, $username, 8, $qid, $comment, $aid, $userlist[$quid]['uid'], $caijilist[$count1]['title']);
				
				if ($answer_adopt_num == 0) {
					$answer = $this->answer_model->get ( $aid );
					
					if ($countarr == 1) {
						
						$ret = $this->answer_model->adopt ( $qid, $answer );
						if ($ret) {
							$this->answer_comment_model->add ( $aid, $comment, $uid, $username );
							$this->doing_model->add ( $uid, $username, 8, $qid, $comment, $aid, $hduid, $caijilist [$count1] ['title'] );
						}
					} else {
						if ($rand == $num) {
							$ret = $this->answer_model->adopt ( $qid, $answer );
							if ($ret) {
								$this->answer_comment_model->add ( $aid, $comment, $uid, $username );
								$this->doing_model->add ( $uid, $username, 8, $qid, $comment, $aid, $hduid, $caijilist [$count1] ['title'] );
							}
						}
					}
				}
			} else {
				
				$answer_content = $caijilist [$count1] ['title'];
				
				// $img_arr=getfirstimgs($answer_content);
				// if($img_arr[1]!=null){
				// for($i=0;$i<count($img_arr[1]);$i++){
				// $img_url=getImageFile($img_arr[1][$i],rand(100000, 99999999).".jpg","upload/",1);
				// $answer_content=str_replace($img_arr[1][$i],SITE_URL.$img_url, $answer_content);
				// }
				// }
				
				if ($ckabox == 'true' || $ckabox == 'on') {
					
					$answer_content = preg_replace ( "#<a[^>]*>(.*?)</a>#is", "$1", $answer_content );
				}
				if ($imgckabox == 'true' || $imgckabox == 'on') {
					
					$answer_content = preg_replace ( '/<img[^>]+>/i', '', $answer_content );
				}
				
				$answer_content = str_replace ( "'", '"', $answer_content );
				$aid = $this->answer_model->add_seo ( $qid, $title, $answer_content, 0, '游客', 1, rand ( 20, 80 ), $mtime );
				if ($answer_adopt_num == 0) {
					$answer = $this->answer_model->get ( $aid );
					if ($countarr == 1) {
						$ret = $this->answer_model->adopt ( $qid, $answer );
						if ($ret) {
							$this->answer_comment_model->add ( $aid, $comment, $uid, $username );
							$this->doing_model->add ( $uid, $username, 8, $qid, $comment, $aid, 0, $caijilist [$count1] ['title'] );
						}
					} else {
						
						if ($rand == $num) {
							$ret = $this->answer_model->adopt ( $qid, $answer );
							if ($ret) {
								$this->answer_comment_model->add ( $aid, $comment, $uid, $username );
								$this->doing_model->add ( $uid, $username, 8, $qid, $comment, $aid, $userlist [$quid] ['uid'], $caijilist [$count1] ['title'] );
							}
						}
					}
				}
			}
			$count1 ++;
			$num ++;
		}
		
		$html->clear ();
		// echo FCPATH.$smallimg;
		// print_r($wduserimage);
		
		echo 'success:' . $title;
		
		// $tt=array_rand($userlist,1);
		// print_r($userlist[$tt]['username']);
		// echo $desc;
		// echo count($type_fill);
		// echo $count1;
	}
	
	/* 采集数据 */
	function caiji() {
		$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 500;
		$startindex = ($page - 1) * $pagesize;
		$userlist = $this->user_model->get_caiji_list ( $startindex, $pagesize );
		$categoryjs = $this->category_model->get_js ();
		
		include FCPATH . '/static/caiji/xml.php';
		$ul_li = '  ';
		if ($urllist) {
			
			foreach ( $urllist as $key => $val ) {
				$ul_li .= '    <li class="nav-parent">';
				$ul_li .= ' <a href="javascript:;">
            <i class="icon-list-ul"></i>' . $key . '<i class="icon-chevron-right nav-parent-fold-icon"></i>

             </a> <ul class="nav" style="display: none;">';
				foreach ( $val as $k => $v ) {
					$ul_li .= '  <li class="liset" path="' . $v . '"><a href="javascript:;">' . $k . '</a></li>';
				}
				$ul_li .= ' </ul>';
				$ul_li .= ' </li>';
			}
		}
		
		include template ( 'setting_caiji', 'admin' );
	}
	function ajaxpostpage() {
		require 'simple_html_dom.php';
		// include 'lib/simple_html_dom.php';
		
		$caiji_url = $this->input->post ( "caiji_url" );
		$caiji_prefix = $this->input->post ( "caiji_prefix" );
		$bianma = $this->input->post ( 'bianma' );
		$ckbox = $this->input->post ( 'ckbox' );
		$html = file_get_html ( $caiji_url );
		
		$type_fill = $html->find ( $caiji_prefix );
		// echo $type_fill[0]->plaintext;
		
		// echo count($type_fill);
		$caijilist = array ();
		$count1 = 0;
		
		foreach ( $type_fill as $r ) {
			// echo $r->plaintext ;
			// break;
			$caijilist [$count1] ['num'] = $count1;
			if ($bianma == 'gb2312') {
				$caijilist [$count1] ['title'] = iconv ( 'gb2312', 'utf-8', $ckbox != 'true' ? $r->plaintext : $r->title );
			} else {
				$caijilist [$count1] ['title'] = $ckbox != 'true' ? $r->plaintext : $r->title;
			}
			$caijilist [$count1] ['href'] = $r->href;
			$count1 ++;
		}
		if (count ( $caijilist ) == 0) {
			$caijilist = null;
		}
		$html->clear ();
		echo json_encode ( $caijilist );
	}
	function getImage($url, $filename = '', $dirName, $fileType, $type = 0) {
		if ($url == '') {
			return false;
		}
		// 获取文件原文件名
		$defaultFileName = basename ( $url );
		// 获取文件类型
		$suffix = substr ( strrchr ( $url, '.' ), 1 );
		if (! in_array ( $suffix, $fileType )) {
			return false;
		}
		// 设置保存后的文件名
		// $filename = $filename == '' ? time().rand(0,9).'.'.$suffix : $defaultFileName;
		
		// 获取远程文件资源
		if ($type) {
			$ch = curl_init ();
			$timeout = 5;
			curl_setopt ( $ch, CURLOPT_URL, $url );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
			$file = curl_exec ( $ch );
			curl_close ( $ch );
		} else {
			ob_start ();
			readfile ( $url );
			$file = ob_get_contents ();
			ob_end_clean ();
		}
		// 设置文件保存路径
		// $dirName = $dirName.'/'.date('Y', time()).'/'.date('m', time()).'/'.date('d',time()).'/';
		if (! file_exists ( $dirName )) {
			mkdir ( $dirName, 0777, true );
		}
		// 保存文件
		$res = fopen ( $dirName . $filename, 'a' );
		fwrite ( $res, $file );
		fclose ( $res );
		return "{'fileName':$filename, 'saveDir':$dirName}";
	}
	/* 注册设置 */
	function register() {
		if (null !== $this->input->post ( 'submit' )) {
			$this->setting ['allow_register'] = $this->input->post ( 'allow_register' );
			
			$this->setting ['register_email_on'] = $this->input->post ( 'register_email_on' ) == "on" ? 1 : 0;
			$this->setting ['register_on'] = $this->input->post ( 'register_on' );
			$this->setting ['max_register_num'] = $this->input->post ( 'max_register_num' );
			$this->setting ['access_email'] = $this->input->post ( 'access_email' );
			$this->setting ['censor_email'] = $this->input->post ( 'censor_email' );
			$this->setting ['censor_username'] = $this->input->post ( 'censor_username' );
			$this->setting_model->update ( $this->setting );
			$message = '注册设置更新成功！';
		}
		include template ( 'setting_register', 'admin' );
	}
	
	/* 邮件设置 */
	function mail() {
		if (null !== $this->input->post ( 'submit' )) {
			foreach ( $_POST as $key => $value ) {
				if ('mail' == substr ( $key, 0, 4 )) {
					$this->setting [$key] = $value;
				}
			}
			$this->setting_model->update ( $this->setting );
			$message = '邮件设置更新成功！';
		}
		include template ( 'setting_mail', 'admin' );
	}
	/* 测试发送邮件 */
	function testmail() {
		if (null !== $this->input->post ( 'submit' )) {
			$toemail = $this->input->post ( 'toemail' );
			
			$subject = $this->input->post ( 'subject' );
			$message = $this->input->post ( 'message' );
			$tousername = $this->input->post ( 'tousername' );
			$state = sendmailto ( $toemail, $subject, $message, $tousername );
			if ($state == "") {
				$message = "对不起，邮件发送失败！请检查邮箱填写是否有误。";
			} else {
				$message = '邮件测试成功！';
			}
		} else {
			$message = '没有提交操作！';
		}
		include template ( 'setting_mail', 'admin' );
	}
	
	/* 积分设置 */
	function settingcredit() {
		if (null !== $this->input->post ( 'submit' )) {
			foreach ( $_POST as $key => $value ) {
				if ('credit' == substr ( $key, 0, 6 )) {
					$this->setting [$key] = $value;
				}
			}
			$this->setting_model->update ( $this->setting );
			$message = '积分设置更新成功！';
		}
		include template ( 'setting_credit', 'admin' );
	}
	
	/* 缓存设置 */
	function cache() {
		$tplchecked = $datachecked = false;
		if (null !== $this->input->post ( 'submit' )) {
			if (null !== $this->input->post ( 'type' )) {
				if (in_array ( 'tpl', $this->input->post ( 'type' ) )) {
					$tplchecked = true;
					cleardir ( FCPATH . '/data/view' );
				}
				if (in_array ( 'data', $this->input->post ( 'type' ) )) {
					$datachecked = true;
					cleardir ( FCPATH . '/data/cache' );
					
				}
				if(is_dir(FCPATH."/course")){
					cleardir ( FCPATH . '/course/data/cache' );
					cleardir ( FCPATH . '/course/data/logs' );
				}
			
				$this->db->query ( "delete from " . $this->db->dbprefix . "session " );
				cleardir ( FCPATH . '/data/logs' );
				$message = '缓存更新成功！';
			} else {
				$tplchecked = $datachecked = false;
				$message = '没有选择缓存类型！';
				$type = 'errormsg';
			}
		}
		include template ( 'setting_cache', 'admin' );
	}
	
	/* UCenter设置 */
	function ucenter() {
		if (null !== $this->input->post ( 'submit' )) {
			
			$this->setting ['ucenter_open'] = intval ( $this->input->post ( 'ucenter_open' ) );
			$this->setting ['ucenter_url'] = strip_tags ( $this->input->post ( 'ucenter_url' ) );
			$this->setting ['ucenter_setuid_byask'] = intval ( $this->input->post ( 'ucenter_setuid_byask' ) );
			$this->setting_model->update ( $this->setting );
			if ($this->input->post ( 'ucenter_config' ) && trim ( $this->input->post ( 'ucenter_config' ) ) != '') {
				$ucconfig = "<?php\n";
				$ucconfig .= tstripslashes ( $this->input->post ( 'ucenter_config' ) );
				writetofile ( FCPATH . '/data/ucconfig.inc.php', $ucconfig );
			}
			// 连接ucenter服务端，生成uc配置文件
			$message = 'UCenter设置完成！';
		}
		include template ( 'setting_ucenter', 'admin' );
	}
	
	/* SEO设置 */
	function seo() {
		if (null !== $this->input->post ( 'submit' )) {
			foreach ( $_POST as $key => $value ) {
				if ('seo' == substr ( $key, 0, 3 )) {
					$this->setting [$key] = $value;
				}
			}
			$this->setting ['baidu_api'] = $this->input->post ( 'baidu_api' );
			$this->setting ['seo_prefix'] = $this->input->post ( 'seo_on' ) == 0 ? '?' : '';
			
			$this->setting_model->update ( $this->setting );
			$message = 'SEO设置更新成功！';
		}
		include template ( 'setting_seo', 'admin' );
	}
	function sms() {
		$url = SITE_URL . "index.php?admin_sms/index";
		header ( "Location:$url" );
	}
	/* 消息模板 */
	function msgtpl() {
		if (null !== $this->input->post ( 'submit' )) {
			$msgtpl = array ();
			for($i = 1; $i <= 4; $i ++) {
				$message ['title'] = $this->input->post ( 'title' . $i );
				$message ['content'] = $this->input->post ( 'content' . $i );
				$msgtpl [] = $message;
			}
			$this->setting ['msgtpl'] = serialize ( $msgtpl );
			$this->setting_model->update ( $this->setting );
			
			$message = '消息模板设置成功!';
		}
		$msgtpl = unserialize ( $this->setting ['msgtpl'] );
		include template ( 'setting_msgtpl', 'admin' );
	}
	
	/* 更新问答统计 */
	function counter() {
		if (null !== $this->input->post ( 'submit' )) {
			foreach ( $_POST as $key => $value ) {
				if ('counter' == substr ( $key, 0, 7 )) {
					$this->setting [$key] = strtolower ( $value );
				}
			}
			$this->setting_model->update_counter ();
			$this->setting_model->update ( $this->setting );
			$message = '问答统计更新成功！';
		}
		include template ( 'setting_counter', 'admin' );
	}
	
	/* * 广告管理* */
	function ad() {
		if (null !== $this->input->post ( 'submit' )) {
			$this->setting ['ads'] = taddslashes ( serialize ( $this->input->post ( 'ad' ) ), 1 );
			$this->setting_model->update ( $this->setting );
			$type = 'correctmsg';
			$message = '广告修改成功!';
			$this->setting = $this->cache->load ( 'setting' );
		}
		$adlist = tstripslashes ( unserialize ( $this->setting ['ads'] ) );
		include template ( 'setting_ad', 'admin' );
	}
	
	/**
	 * 搜索设置
	 */
	function search() {
		if (null !== $this->input->post ( 'submit' )) {
			$this->setting ['search_placeholder'] = $this->input->post ( 'search_placeholder' );
			$this->setting ['search_shownum'] = $this->input->post ( 'search_shownum' );
			$this->setting ['xunsearch_open'] = $this->input->post ( 'xunsearch_open' );
			$this->setting ['xunsearch_sdk_file'] = trim($this->input->post ( 'xunsearch_sdk_file' ));
			if(file_exists(FCPATH.".user.ini")){
				$type = 'errormsg';
				$message="检测到网站根目录下存在 user.ini文件，请确定此文件是否为空，否则会导致配置讯搜后网站500打不开";
			}
			if(strtoupper(substr(PHP_OS,0,3))=="WIN"){
				$type = 'errormsg';
				$message = 'windows 服务器不支持配置xunsearch讯搜全文检索，请选择linux操作系统 centos7+或者ubuntu!';
				$this->setting ['xunsearch_open']=0;
			}else{
				if ($this->setting ['xunsearch_open'] && ! file_exists ( $this->setting ['xunsearch_sdk_file'] )) {
					$type = 'errormsg';
					$message = 'SDK文件不存在，请核实!';
					$this->setting ['xunsearch_open']=0;
				} else {
					$this->setting_model->update ( $this->setting );
					$type = 'correctmsg';
					$message = '搜索设置成功!';
				
				}
			}
		
			
		}
	
		$qrownum = returnarraynum ( $this->db->query ( getwheresql ( 'question', "  status!=0 and  isupdatexunsearch=0 ", $this->db->dbprefix ) )->row_array () );
		$pagesize = 1000;
		$qpages = @ceil ( $qrownum / $pagesize );
		
		$trownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', "  state!=0 and  isupdatexunsearch=0 ", $this->db->dbprefix ) )->row_array () );
		
		$tpages = @ceil ( $trownum / $pagesize );
		include template ( 'setting_search', 'admin' );
	}
	
	/**
	 * 生产全文检索
	 */
	function makewords() {
		$this->question_model->make_words ();
	}
	
	/* qq互联设置 */
	function qqlogin() {
		if (null !== $this->input->post ( 'submit' )) {
			$this->setting ['qqlogin_open'] = $this->input->post ( 'qqlogin_open' );
			$this->setting ['qqlogin_appid'] = trim ( $this->input->post ( 'qqlogin_appid' ) );
			$this->setting ['qqlogin_key'] = trim ( $this->input->post ( 'qqlogin_key' ) );
			$this->setting ['qqlogin_avatar'] = trim ( $this->input->post ( 'qqlogin_avatar' ) );
			$this->setting_model->update ( $this->setting );
			$this->setting = $this->cache->load ( 'setting' );
			$logininc = array ();
			$logininc ['appid'] = $this->setting ['qqlogin_appid'];
			$logininc ['appkey'] = $this->setting ['qqlogin_key'];
			$logininc ['callback'] = SITE_URL . 'plugin/qqlogin/callback.php';
			$logininc ['scope'] = "get_user_info";
			$logininc ['errorReport'] = "true";
			$logininc ['storageType'] = "file";
			$loginincstr = "<?php die('forbidden'); ?>\n" . json_encode ( $logininc );
			$loginincstr = str_replace ( "\\", "", $loginincstr );
			writetofile ( FCPATH . "/plugin/qqlogin/API/comm/inc.php", $loginincstr );
			$message = 'qq互联参数保存成功！';
		}
		include template ( "setting_qqlogin", "admin" );
	}
	/* 微信开放平台网页扫码登录设置 */
	function weixinlogin() {
		if (null !== $this->input->post ( 'submit' )) {
			$this->setting ['wechat_open'] = $this->input->post ( 'wechat_open' );
			$this->setting ['wechat_appid'] = trim ( $this->input->post ( 'wechat_appid' ) );
			$this->setting ['wechat_appSecret'] = trim ( $this->input->post ( 'wechat_appSecret' ) );
			$this->setting_model->update ( $this->setting );
			$message = '微信网页扫码登录参数保存成功！';
		}
		include template ( "setting_weixinlogin", "admin" );
	}
	/* sina互联设置 */
	function sinalogin() {
		if (null !== $this->input->post ( 'submit' )) {
			$this->setting ['sinalogin_open'] = $this->input->post ( 'sinalogin_open' );
			$this->setting ['sinalogin_appid'] = trim ( $this->input->post ( 'sinalogin_appid' ) );
			$this->setting ['sinalogin_key'] = trim ( $this->input->post ( 'sinalogin_key' ) );
			$this->setting ['sinalogin_avatar'] = trim ( $this->input->post ( 'sinalogin_avatar' ) );
			$this->setting_model->update ( $this->setting );
			$this->setting = $this->cache->load ( 'setting' );
			$config = "<?php \r\ndefine('WB_AKEY',  '" . $this->setting ['sinalogin_appid'] . "');\r\n";
			$config .= "define('WB_SKEY',  '" . $this->setting ['sinalogin_key'] . "');\r\n";
			$config .= "define('WB_CALLBACK_URL',  '" . SITE_URL . 'plugin/sinalogin/callback.php' . "');\r\n";
			writetofile ( FCPATH . '/plugin/sinalogin/config.php', $config );
			$message = 'sina互联参数保存成功！';
		}
		include template ( "setting_sinalogin", "admin" );
	}
	
	/* 财富充值设置 */
	function ebank() {
		if (null !== $this->input->post ( 'submit' )) {
			$aliapy_config = array ();
			$this->setting ['recharge_open'] = $this->input->post ( 'recharge_open' );
			$this->setting ['recharge_rate'] = trim ( $this->input->post ( 'recharge_rate' ) );
			$aliapy_config ['seller_email'] = $this->setting ['alipay_seller_email'] = $this->input->post ( 'alipay_seller_email' );
			$aliapy_config ['partner'] = $this->setting ['alipay_partner'] = trim ( $this->input->post ( 'alipay_partner' ) );
			$aliapy_config ['key'] = $this->setting ['alipay_key'] = trim ( $this->input->post ( 'alipay_key' ) );
			$aliapy_config ['sign_type'] = 'MD5';
			$aliapy_config ['input_charset'] = strtolower ( ASK2_CHARSET );
			$aliapy_config ['transport'] = 'http';
			$aliapy_config ['return_url'] = SITE_URL . "index.php?ebank/aliapyback";
			$aliapy_config ['notify_url'] = SITE_URL . "ebank/notifyaliapyback";
			$this->setting_model->update ( $this->setting );
			$strdata = "<?php\nreturn " . var_export ( $aliapy_config, true ) . ";\n?>";
			writetofile ( FCPATH . "/data/alipay.config.php", $strdata );
		}
		include template ( "setting_ebank", "admin" );
	}
	function getfolders() {
		$file_dir = "static/caiji";
		$shili = $file_dir;
		if (! file_exists ( $shili )) {
			echo $shili . "目录不存在!";
		} else {
			$i = 0;
			$file = '';
			if (is_dir ( $shili )) { // 检测是否是合法目录
				if ($shi = opendir ( $shili )) { // 打开目录
					while ( $li = readdir ( $shi ) ) { // 读取目录
						$i ++;
						$temps = explode ( '.', $li );
						$file = $file . $temps [0] . ',';
					}
				}
			} // 输出目录中的内容
			echo trim ( $file, "," );
			closedir ( $shi );
		}
	}
}

?>