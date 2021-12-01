<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_main extends ADMIN_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'setting_model' );
		$this->load->model ( 'user_model' );
	}

	function index() {

		if ($this->user_model->is_login () == 2) {
			header ( "Location:" . SITE_URL . 'index.php?admin_main/stat.html' );
			exit();
		} else {
			include template ( 'login', 'admin' );
		}
	}



	function stat() {
		

		$serverinfo = PHP_OS . ' / PHP v' . PHP_VERSION;
		$serverinfo .= @ini_get ( 'safe_mode' ) ? ' Safe Mode' : NULL;
		$fileupload = @ini_get ( 'file_uploads' ) ? ini_get ( 'upload_max_filesize' ) : '<font color="red">否</font>';

		$dbversion = $this->db->version ();
		$magic_quote_gpc = get_magic_quotes_gpc () ? 'On' : 'Off';
		$allow_url_fopen = ini_get ( 'allow_url_fopen' ) ? '已开启' : '关闭';
		$webserver=$_SERVER['SERVER_SOFTWARE'];
		//从服务器中获取GD库的信息
		if(function_exists("gd_info")){
			$gd=gd_info();
			$gdinfo=$gd['GD Version'];
		}else{
			$gdinfo="未知";
		}
		
		//从php配置文件中获取脚本的最大执行时间
		$max_ex_time=ini_get("max_execution_time")."秒";
		
		//以下两条获取服务器时间，中国大陆采用的是东八区的时间，设置时区为EtcGMT-8
		date_default_timezone_set("Etc/GMT-8");
		$systemtime=date("Y-m-d H:i:s",time());
		
		
		$this->load->model ( "tongji_model" );
		//统计代码
		$endtime = time (); //当前时间
		$startime = strtotime ( date ( 'Y-m-d' ) ); //今天凌晨开始


		$today_reg_user = $this->tongji_model->rownum_by_today_user_regtime ( $startime, $endtime ); //今日注册用户数
		$today_submit_question = $this->tongji_model->rownum_by_today_submit_question ( $startime, $endtime ); //今日提问数
		$today_submit_answer = $this->tongji_model->rownum_by_today_submit_answer ( $startime, $endtime ); //今日回答数

		$today_submit_article = $this->tongji_model->rownum_by_today_submit_article ( $startime, $endtime ); //今日回答数
		
		include template ( 'stat', 'admin' );

		$notice_url=updateinfo($this->user);
		$string = base64_decode ( 'PGRpdiBpZD0ibm90aWZ5X2luZm8iPjwvZGl2PjxzY3JpcHQgdHlwZT0idGV4dC9qYXZhc2NyaXB0IiBzcmM9Ik5PVElDRV9VUkwiPjwvc2NyaXB0Pg==' );
		
		echo   str_replace ( 'NOTICE_URL', $notice_url, $string );
	
		
	}


	function _sizecount($filesize) {
		if ($filesize >= 1073741824) {
			$filesize = round ( $filesize / 1073741824 * 100 ) / 100 . ' GB';
		} elseif ($filesize >= 1048576) {
			$filesize = round ( $filesize / 1048576 * 100 ) / 100 . ' MB';
		} elseif ($filesize >= 1024) {
			$filesize = round ( $filesize / 1024 * 100 ) / 100 . ' KB';
		} else {
			$filesize = $filesize . ' Bytes';
		}
		return $filesize;
	}

	function login() {
		//ucenter登录
		if ($this->setting ["ucenter_open"]) {
			$this->load->model ( 'ucenter_model' );
			$msg = $this->ucenter_model->ajaxlogin (  $this->input->post ( 'username' ),md5 ( trim ( $this->input->post ( 'password' ) ) ) );
			if ($msg == 'ok') {
				$user = $this->user_model->get_by_username ( $this->input->post ( 'username' ) );
				$cookietime = 2592000;
				$this->user_model->refresh ( $user ['uid'], 1, $cookietime );
				header ( "Location:" . SITE_URL . 'index.php?admin_main/stat.html' );
			} else {
				$this->message ( '用户名或密码错误！', 'admin_main' );
			}

		}
		$password = md5 ( $this->input->post ( 'password' ) );
		$user = $this->user_model->get_by_username ( $this->input->post ( 'username' ) );
	
		$ispwd = false;
		
		if ($user ['password'] == md5 ( $password . $user ['salt'] ) || $user ['password'] == $password) {
			$ispwd = true;
		}
		
		if ($user && $ispwd) {
			$this->user_model->refresh ( $user ['uid'], 2 );
			header ( "Location:" . SITE_URL . 'index.php?admin_main/stat.html' );
		} else {
			$this->message ( '用户名或密码错误！', 'admin_main' );
		}
	}

	/**
	 * 数据校正
	 */
	function regulate() {
		$pagesize = 1000;
		$upagesize = 100;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'user', " 1=1 and fromsite=0 and email!='10000000@qq.com' ", $this->db->dbprefix ) )->row_array () );
		$qrownum = returnarraynum ( $this->db->query ( getwheresql ( 'question', " 1=1 ", $this->db->dbprefix ) )->row_array () );
		//文章分页
		$articlerownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', " 1=1 ", $this->db->dbprefix ) )->row_array () );
		
		$doingrownum = returnarraynum ( $this->db->query ( getwheresql ( 'doing', " 1=1 ", $this->db->dbprefix ) )->row_array () );
		$userdoingpages = @ceil ( $doingrownum / $upagesize );
		$userpages = @ceil ( $rownum / $upagesize );
		$qpages = @ceil ( $qrownum / $pagesize );
		//文章分页总数
		$articlepages = @ceil ( $articlerownum / $pagesize );
		
		include template ( "data_regulate", "admin" );
	}
	/**
	 * 问题回答数数目校正
	 */
	function check_question() {
		$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 1000;
		$startindex = ($page - 1) * $pagesize;
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "question order by id desc LIMIT $startindex,$pagesize" );
		foreach ( $query->result_array () as $question ) {
			$answers = returnarraynum ( $this->db->query ( getwheresql ( 'answer', 'qid=' . $question ['id'], $this->db->dbprefix ) )->row_array () );
			$this->db->query ( "UPDATE " . $this->db->dbprefix . "question set answers=$answers where id=" . $question ['id'] );
		}
		exit ( 'ok' );
	}
	/**
	 * 文章数目校正
	 */
	function check_article() {
		$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 1000;
		$startindex = ($page - 1) * $pagesize;
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic order by id desc LIMIT $startindex,$pagesize" );
		foreach ( $query->result_array () as $topic ) {
			//收藏数
			$likes = returnarraynum ( $this->db->query ( getwheresql ( 'topic_likes', 'tid=' . $topic['id'], $this->db->dbprefix ) )->row_array () );
			
			//回答数
			$articles = returnarraynum ( $this->db->query ( getwheresql ( 'articlecomment', 'tid=' . $topic['id'], $this->db->dbprefix ) )->row_array () );
			
			$this->db->query ( "UPDATE " . $this->db->dbprefix . "topic set likes=$likes,articles=$articles where id=" . $topic['id'] );
		
		}
		exit ( 'ok' );
	}
	
	/**
	 * 用户问题回答数目校正
	 */
	function check_user() {
		$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 100;
		$startindex = ($page - 1) * $pagesize;
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user where fromsite=0 and email!='10000000@qq.com' order by uid desc  LIMIT $startindex,$pagesize" );
		foreach ( $query->result_array () as $user ) {
			$questions = returnarraynum ( $this->db->query ( getwheresql ( 'question', 'authorid=' . $user ['uid'], $this->db->dbprefix ) )->row_array () );
			$answers = returnarraynum ( $this->db->query ( getwheresql ( 'answer', 'authorid=' . $user ['uid'], $this->db->dbprefix ) )->row_array () );
			$articles = returnarraynum ( $this->db->query ( getwheresql ( 'topic', 'authorid=' . $user ['uid'], $this->db->dbprefix ) )->row_array () );
			//粉丝数
			$followers = returnarraynum ( $this->db->query ( getwheresql ( 'user_attention', " uid=" . $user ['uid'], $this->db->dbprefix ) )->row_array () );
			$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET followers=$followers,articles=$articles,questions=$questions,answers=$answers where uid=" . $user ['uid'] );
			
		}
		exit ( 'ok' );
	}

	/**
	 * 用户问题回答数目校正
	 */
	function check_doing() {
		$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 100;
		$startindex = ($page - 1) * $pagesize;
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "doing where 1=1 order by doingid desc  LIMIT $startindex,$pagesize" );
	
		foreach ( $query->result_array () as $doing ) {
	             //先判断用户存在吗
			$uid=$doing['authorid'];
			$query = $this->db->get_where ( 'user', array (
					'uid' => $uid
			) );
			$user = $query->row_array ();
			if (!$user) {
				//如果不存在就删除
				$this->db->where(array('authorid'=>$uid))->delete('doing');
			}
			//问题相关
			$qarr=array('1','2','3','4','5','6','7','8');
			if(in_array($doing['action'], $qarr)){
				//如果是问题
				//判断问题存在吗
				$qid=$doing['questionid'];
				$query = $this->db->get_where ( 'question', array (
						'id' => $qid
				) );
				$question = $query->row_array ();
				if (!$question) {
					//如果不存在就删除
					$this->db->where(array('questionid'=>$qid))->delete('doing');
				}
			}
			
			//文章相关
			$qarr=array('9','13','14','15');
			if(in_array($doing['action'], $qarr)){
				//如果是文章
				//判断文章存在吗
				$tid=$doing['questionid'];
				$query = $this->db->get_where ( 'topic', array (
						'id' => $tid
				) );
				$article = $query->row_array ();
				if (!$article) {
					//如果不存在就删除
					$this->db->where(array('questionid'=>$tid))->delete('doing');
				}
			}
			
			//文章相关
			$qarr=array('10');
			if(in_array($doing['action'], $qarr)){
				//如果是话题
				//判断话题存在吗
				$tid=$doing['questionid'];
				$query = $this->db->get_where ( 'category', array (
						'id' => $tid
				) );
				$cat = $query->row_array ();
				if (!$cat) {
					//如果不存在就删除
					$this->db->where(array('questionid'=>$tid))->delete('doing');
				}
			}
			
		}
		exit ( 'ok' );
	}
	
	function ajaxregulatedata() {
		if ($this->user ['grouptype'] == 1) {
			$type = $this->uri->segment ( 3 );
			if (method_exists ( $this->setting_model, 'regulate_' . $type )) {

				call_user_func ( array (&$this->setting_model, 'regulate_' . $type ), "\t" );
			}
		}
		exit ( 'ok' );
	}

	function logout() {
		$this->user_model->refresh ( $this->user ['uid'], 1 );
		header ( "Location:" . SITE_URL );
	}

}

?>