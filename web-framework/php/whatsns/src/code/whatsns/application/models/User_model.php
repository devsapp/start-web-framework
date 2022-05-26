<?php
class User_model extends CI_Model {
	var $search;
	var $index;
	function __construct() {
		parent::__construct ();
		
		$this->load->database ();
		global $setting;
		if ($setting ['xunsearch_open']) {
			require_once $setting ['xunsearch_sdk_file'];
			
			$xs = new XS ( XUNSEARCH_QUESTIONFILE );
			
			$this->search = $xs->search;
			
			$this->index = $xs->index;
		}
		
	}
	function get_by_uid($uid, $loginstatus = 1) {
		$uid=intval($uid);
		global $usergroup;
		$query = $this->db->get_where ( 'user', array (
				'uid' => $uid 
		) );
		$user = $query->row_array ();
		if ($user) {
			$user ['avatar'] = get_avatar_dir ( $uid );
			$user ['register_time'] = isset ( $user ['regtime'] ) && tdate ( $user ['regtime'] );
			$user ['vertify'] = $this->getvertifyinfo_by_uid ( $uid );
			$user ['lastlogin'] = isset ( $user ['lastlogin'] ) && tdate ( $user ['lastlogin'] );
			$user ['author_has_vertify'] = get_vertify_info ( $user ['uid'] ); // 用户是否认证			
			$user ['grouptitle'] = $usergroup [$user ['groupid']] ['grouptitle'];
			$user ['category'] = $this->get_category ( $user ['uid'] );
			$user ['notify'] = $this->get_mynotify ( $user ['uid'] );
			($loginstatus == 1) && $user ['islogin'] = $this->is_login ( $uid );
			($loginstatus == 2) && $user ['refresh_time'] = tdate ( $this->get_refresh_time ( $uid ) );
		}
		
		return $user;
	}
	function getvertifyinfo_by_uid($uid) {
		$uid=intval($uid);
		$vertify = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "vertify where uid=$uid" )->row_array ();
		if ($vertify != null) {
			$vertify ['avatar'] = get_avatar_dir ( $uid );
			$vertify ['time'] = tdate ( $vertify ['time'] );
			if ($vertify ['status'] == null) {
				$vertify ['status'] = - 1;
			}
			switch ($vertify ['status']) {
				case 0 :
					$vertify ['msg'] = "等待审核";
					break;
				case 1 :
					$vertify ['msg'] = "审核通过";
					break;
				case 2 :
					$vertify ['msg'] = "审核被退回";
					break;
				default :
					$vertify ['msg'] = "未认证";
					break;
			}
		} else {
			$vertify = null;
		}
		
		return $vertify;
	}
	// 获取用户总金额
	function getallusermoney() {
		$query = $this->db->select_sum ( 'jine', 'sum' )->where ( array (
				'jine>' => 0 
		) )->get ( 'user' );
		
		$usermoney = $query->row_array ();
		return $usermoney ['sum'];
	}
	// 获取微信绑定账号总人数
	function getsumuserbyopenid() {
		$this->db->select ( array (
				'openid',
				'uid' 
		) )->where ( array (
				'openid!=' => '' 
		) )->from ( 'user' );
		
		return $this->db->count_all_results ();
	}
	// 获取邮箱验证总人数
	function getsumuserbyueamactive() {
		$this->db->where ( array (
				'active' => 1 
		) )->from ( 'user' );
		
		return $this->db->count_all_results ();
	}
	function get_by_username($username) {
		$username=addslashes($username);
		$query = $this->db->where ( array (
				'username' => $username 
		) )->or_where ( array (
				'email' => $username 
		) )->or_where ( array (
				'phone' => $username 
		) )->from ( 'user' )->get ();
		
		$user = $query->row_array ();
		if ($user) {
			$user ['notify'] = $this->get_mynotify ( $user ['uid'] );
		}
		
		return $user;
	}
	function get_by_invatecode($invatecode) {
		$invatecode=addslashes($invatecode);
		$query = $this->db->get_where ( 'user', array (
				'invatecode' => $invatecode
		) );
		$user = $query->row_array ();
		if ($user) {
			$user ['notify'] = $this->get_mynotify ( $user ['uid'] );
		}
		return $user;
	}
	function get_by_wechatopenid($openid) {
		$openid=addslashes($openid);
		$query = $this->db->get_where ( 'user', array (
				'wechatopenid' => $openid 
		) );
		$user = $query->row_array ();
		if ($user) {
			$user ['notify'] = $this->get_mynotify ( $user ['uid'] );
		}
		return $user;
	}
	function get_by_openid($openid) {
		$openid=addslashes($openid);
		$query = $this->db->get_where ( 'user', array (
				'openid' => $openid 
		) );
		$user = $query->row_array ();
		if ($user) {
			$user ['notify'] = $this->get_mynotify ( $user ['uid'] );
		}
		return $user;
	}
	function get_by_email($email) {
		$email=addslashes($email);
		$query = $this->db->get_where ( 'user', array (
				'email' => $email 
		) );
		$user = $query->row_array ();
		if ($user) {
			$user ['notify'] = $this->get_mynotify ( $user ['uid'] );
		}
		return $user;
	}
	function get_by_phone($phone) {
		$phone=addslashes($phone);
		$query = $this->db->get_where ( 'user', array (
				'phone' => $phone 
		) );
		$user = $query->row_array ();
		if ($user) {
			$user ['notify'] = $this->get_mynotify ( $user ['uid'] );
		}
		return $user;
	}
	function get_by_name_email($name, $email) {
		$name=addslashes($name);
		$email=addslashes($email);
		$query = $this->db->get_where ( 'user',array('email'=>$email,'username'=>$name) );
		$user = $query->row_array ();
		if ($user) {
			$user ['notify'] = $this->get_mynotify ( $user ['uid'] );
		}
		return $user;
	}
	
	/* 采纳率 */
	function adoptpercent($user) {
		$adoptpercent = 0;
		if (0 != $user ['answers']) {
			if($user ['adopts']>$user ['answers']){
				$adoptpercent=100;
			}else{
				$adoptpercent = round ( ($user ['adopts'] / $user ['answers']), 3 ) * 100;
			}
			
		}
		return $adoptpercent;
	}
	function get_list($start = 0, $limit = 10) {
		$userlist = array ();
		
		$query = $this->db->select ( '*' )->from ( 'user' )->order_by ( 'uid DESC' )->limit ( $limit, $start )->get ();
		
		foreach ( $query->result_array () as $user ) {
			$user ['lastlogintime'] = tdate ( $user ['lastlogin'] );
			$user ['regtime'] = tdate ( $user ['regtime'] );
			$user ['author_has_vertify'] = get_vertify_info ( $user ['uid'] ); // 用户是否认证
			$userlist [] = $user;
		}
		return $userlist;
	}
	function get_active_list($start = 0, $limit = 10, $cid = 'all', $status = 'all') {
		if($cid!='all'){
			$cid=intval($cid);
		}
		if($status!='all'){
			$status=intval($status);
		}
		global $user;
		$userlist = array ();
		$orderwhere = array (
				'1' => 1 
		);
		switch ($status) {
			case 'all' : // 全部
				$orderwhere = array (
						'1' => 1 
				);
				break;
			case '1' : // 付费
				$orderwhere = array (
						'mypay>' => 0 
				);
				break;
			case '2' : // 免费
				$orderwhere = array (
						'mypay' => 0 
				);
				break;
		}
		if ($cid == 'all') {
			$query = $this->db->from ( 'user' )->where ( $orderwhere )->order_by ( 'hasvertify desc, answers DESC' )->limit ( $limit, $start )->get ();
		} else {
			$query = $this->db->select ( '*' )->from ( 'user' )->where ( $orderwhere )->order_by ( 'hasvertify desc, answers DESC' )->join ( 'user_category', "user_category.uid = user.uid and user_category.cid=$cid" )->limit ( $limit, $start )->get ();
		}
		
		foreach ( $query->result_array () as $usermodel ) {
			$usermodel ['avatar'] = get_avatar_dir ( $usermodel ['uid'] );
			$usermodel ['author_has_vertify'] = get_vertify_info ( $usermodel ['uid'] ); // 用户是否认证
			$usermodel ['signature'] = $usermodel ['signature'] == null ? '用户很懒，什么都没留下' : $usermodel ['signature'];
			$usermodel ['signature'] = cutstr ( checkwordsglobal ( strip_tags ( $usermodel ['signature'] ) ), 40, '...' );
			$is_followed = $this->is_followed ( $usermodel ['uid'], $user ['uid'] );
			$usermodel ['hasfollower'] = $is_followed == 0 ? "0" : "1";
			$usermodel ['category'] = $this->get_category ( $usermodel ['uid'] );
			$userlist [] = $usermodel;
		}
		return $userlist;
	}
	// 获取采集用户列表
	function get_caiji_list($start = 0, $limit = 10) {
		$userlist = array ();
		
		//$query = $this->db->select ( '*' )->from ( 'user' )->where ( array (
			//	'fromsite' => 1 
		//) )->order_by ( 'lastlogin desc' )->limit ( $limit, $start )->get ();
		$query=$this->db->query("select * from  " . $this->db->dbprefix . "user where fromsite=1 order by rand() limit $start,$limit");
		foreach ( $query->result_array () as $user ) {
			$user ['avatar'] = get_avatar_dir ( $user ['uid'] );
			$userlist [] = $user;
		}
		return $userlist;
	}
	function get_active_list_bynosign($start = 0, $limit = 10) {
		$userlist = array ();
		$query = $this->db->select ( '*' )->from ( 'user' )->where ( array (
				'signature' => '这个人很懒，什么都没留下' 
		) )->or_where ( array (
				'signature' => null 
		) )->order_by ( 'lastlogin desc,credit2 DESC' )->limit ( $limit, $start )->get ();
		
		foreach ( $query->result_array () as $user ) {
			$user ['avatar'] = get_avatar_dir ( $user ['uid'] );
			$user ['author_has_vertify'] = get_vertify_info ( $user ['uid'] ); // 用户是否认证
			$userlist [] = $user;
		}
		return $userlist;
	}
	function get_lastest_register($start = 0, $limit = 5) {
		$userlist = array ();
		
		$query = $this->db->select ( '*' )->from ( 'user' )->order_by ( 'regtime desc' )->limit ( $limit, $start )->get ();
		
		foreach ( $query->result_array () as $user ) {
			$user ['avatar'] = get_avatar_dir ( $user ['uid'] );
			$user ['author_has_vertify'] = get_vertify_info ( $user ['uid'] ); // 用户是否认证
			$userlist [] = $user;
		}
		return $userlist;
	}
	function get_answer_top($start = 0, $limit = 8) {
		$userlist = array ();
		
		$query = $this->db->select ( '*' )->from ( 'user' )->order_by ( 'answers DESC,lastlogin DESC' )->limit ( $limit, $start )->get ();
		
		foreach ( $query->result_array () as $user ) {
			$user ['avatar'] = get_avatar_dir ( $user ['uid'] );
			$userlist [] = $user;
		}
		return $userlist;
	}
	function list_by_search_condition($condition, $start = 0, $limit = 10) {
		
		global $user;
		$userlist = array ();
		$query = $this->db->query ( 'SELECT * FROM ' . $this->db->dbprefix . "user WHERE $condition ORDER BY `uid` DESC LIMIT $start , $limit" );
		foreach ( $query->result_array () as $usermodel ) {
			$usermodel ['regtime'] = tdate ( $usermodel ['regtime'] );
			$usermodel ['avatar'] = get_avatar_dir ( $usermodel ['uid'] );
			$usermodel ['author_has_vertify'] = get_vertify_info ( $usermodel ['uid'] ); // 用户是否认证
			$usermodel ['lastlogintime'] = tdate ( $usermodel ['lastlogin'] );
			$is_followed = $this->is_followed ( $usermodel ['uid'], $user ['uid'] );
			$usermodel ['hasfollower'] = $is_followed == 0 ? "0" : "1";
			$usermodel ['category'] = $this->get_category ( $usermodel ['uid'] );
			$userlist [] = $usermodel;
		}
		return $userlist;
	}
	
	/* 根据用户的一段时间的财富值排序，只取前100名。 */
	function list_by_credit($type = 0, $limit = 100) {
		$type=intval($type);
		$limit=intval($limit);
		global $usergroup;
		$userlist = array ();
		$starttime = 0;
		if (1 == $type) {
			$starttime = time () - 7 * 24 * 3600;
		}
		if (2 == $type) {
			$starttime = time () - 30 * 24 * 3600;
		}
		$sqlarray = array (
				'SELECT u.uid,u.groupid, u.username,u.gender,u.lastlogin,u.credit2,u.questions,u.answers,u.adopts FROM ' . $this->db->dbprefix . "user  u ORDER BY `credit2` DESC,u.answers DESC  LIMIT 0,$limit",
				"SELECT u.uid,u.groupid, u.username,u.gender,u.lastlogin,sum( c.credit2 ) credit2,u.questions,u.answers,u.adopts FROM " . $this->db->dbprefix . "user u," . $this->db->dbprefix . "credit c   WHERE u.uid=c.uid AND c.time>$starttime   GROUP BY u.uid ORDER BY credit2  DESC,u.answers DESC LIMIT 0,$limit",
				"SELECT u.uid,u.groupid, u.username,u.gender,u.lastlogin,sum( c.credit2 ) credit2,u.questions,u.answers,u.adopts  FROM " . $this->db->dbprefix . "user u," . $this->db->dbprefix . "credit c   WHERE u.uid=c.uid AND c.time>$starttime   GROUP BY u.uid ORDER BY credit2  DESC,u.answers DESC LIMIT 0,$limit" 
		);
		$query = $this->db->query ( $sqlarray [$type] );
		foreach ( $query->result_array () as $user ) {
			$user ['gender'] = (1 == $user ['gender']) ? '男' : '女';
			$user ['lastlogin'] = tdate ( $user ['lastlogin'] );
			$user ['grouptitle'] = $usergroup [$user ['groupid']] ['grouptitle'];
			$user ['avatar'] = get_avatar_dir ( $user ['uid'] );
			$user ['author_has_vertify'] = get_vertify_info ( $user ['uid'] ); // 用户是否认证
			$userlist [] = $user;
		}
		return $userlist;
	}
	function refresh($uid, $islogin = 1, $cookietime = 0) {
		$uid=intval($uid);
	
		global $user;
		
		$query = $this->db->select ( '*' )->from ( 'user' )->join ( 'usergroup', 'usergroup.groupid=user.groupid' )->where ( array (
				'user.uid' => $uid
		) )->get ();
		$user = $query->row_array ();
		
		$this->db->set ( 'lastlogin', time () )->where ( array (
				'uid' => $uid
		) )->update ( 'user' );
		$this->db->where ( array (
				'uid' => $uid,
				'time<' => time ()
		) )->delete ( 'session' );

		$password = $user ['password'];
        if(!$_SESSION){
        	session_start();
        }
        $_SESSION['loginuid']=$uid;
        $_SESSION['loginpassword']=$password;
				$user ['newmsg'] = 0;
	}
// 	function refresh($uid, $islogin = 1, $cookietime = 0) {
// 		$uid=intval($uid);
// 		@$sid = tcookie ( 'sid' );
// 		global $user;
		
// 		$query = $this->db->select ( '*' )->from ( 'user' )->join ( 'usergroup', 'usergroup.groupid=user.groupid' )->where ( array (
// 				'user.uid' => $uid 
// 		) )->get ();
// 		$user = $query->row_array ();
		
// 		$this->db->set ( 'lastlogin', time () )->where ( array (
// 				'uid' => $uid 
// 		) )->update ( 'user' );
// 		$this->db->where ( array (
// 				'uid' => $uid,
// 				'time<' => time () 
// 		) )->delete ( 'session' );
// 		$data = array (
// 				'sid' => $sid,
// 				'uid' => $uid,
// 				'islogin' => $islogin,
// 				'ip' => getip (),
// 				'time' => time () 
// 		);
// 		$this->db->replace ( 'session', $data );
// 		$password = $user ['password'];
// 		$auth = authcode ( "$uid\t$password", 'ENCODE' );
// 		if ($cookietime)
// 			tcookie ( 'auth', $auth, $cookietime );
// 		else
// 			tcookie ( 'auth', $auth );
		
// 		tcookie ( 'loginuser', '' );
// 		$user ['newmsg'] = 0;
// 	}
	function refresh_session_time($sid, $uid) {

		
	}
	
	/* 添加用户，本函数需要返回uid */
	function add($username, $password, $email = '', $uid = 0) {
		$password = md5 ( $password );
		if ($uid) {
			$data = array (
					'uid' => $uid,
					'username' => $username,
					'password' => $password,
					'email' => $email,
					'regip' => getip (),
					'regtime' => time (),
					'lastlogin' => time () 
			);
			$this->db->replace ( 'user', $data );
		} else {
			$data = array (
					'uid' => $uid,
					'username' => $username,
					'password' => $password,
					'email' => $email,
					'regip' => getip (),
					'regtime' => time (),
					'lastlogin' => time () 
			);
			$this->db->insert ( 'user', $data );
			$uid = $this->db->insert_id ();
		}
		return $uid;
	}
	function caijiadd($username, $password, $email = '', $fromsite = 1) {
		$password = md5 ( $password );
		$data = array (
				'username' => $username,
				'password' => $password,
				'fromsite' => $fromsite,
				'email' => $email,
				'regip' => get_rand_ip (),
				'regtime' => time (),
				'lastlogin' => time () 
		);
		$this->db->insert ( 'user', $data );
		$uid = $this->db->insert_id ();
		
		return $uid;
	}
	/* 微信授权注册 */
	function weixinadd($username, $password, $openid = '') {
		$password = md5 ( $password );
		$data = array (
				'username' => $username,
				'password' => $password,
				'openid' => $openid,
				'regip' => getip (),
				'regtime' => time (),
				'lastlogin' => time () 
		);
		$this->db->insert ( 'user', $data );
		
		$uid = $this->db->insert_id ();
		
		return $uid;
	}
	function adduserapi($username, $password, $email = '', $groupid = 7, $uid = 0, $phone = 0) {
		$password = md5 ( $password );
	
		if ($uid) {
			$data = array (
					'uid' => $uid,
					'username' => $username,
					'password' => $password,
					'email' => $email,
					'regip' => getip (),
					'regtime' => time (),
					'lastlogin' => time (),
					'groupid' => $groupid 
			);
			$this->db->replace ( 'user', $data );
		} else {
			if ($phone == 0) {
				$phone = '';
				$data = array (
						'username' => $username,
						'password' => $password,
						'email' => $email,
						'regip' => getip (),
						'regtime' => time (),
						'lastlogin' => time (),
						'groupid' => $groupid,
						'phone' => $phone 
				);
				$this->db->insert ( 'user', $data );
			} else {
				$data = array (
						'username' => $username,
						'password' => $password,
						'email' => $email,
						'regip' => getip (),
						'regtime' => time (),
						'lastlogin' => time (),
						'groupid' => $groupid,
						'phone' => $phone,
						'phoneactive' => 1 
				);
				$this->db->insert ( 'user', $data );
			}
			
			$uid = $this->db->insert_id ();
		}
		if(FROMUC){
			//更新用户密码
			$salt=random(6);//加盐
			$newpwd=md5($password.$salt);
			$this->db->query("update ".$this->db->dbprefix."user set salt='$salt' , password='$newpwd' where uid=$uid ");
		}
		return $uid;
	}
	// 更新注册邀请码
	function updateinvatecode($uid, $frominvatecode) {
		$uid=intval($uid);
		$frominvatecode=addslashes($frominvatecode);
		// 检查有没有这个人，如果有就更新
		$user = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user WHERE invatecode='$frominvatecode'" )->row_array ();
		if ($user) {
			// 更新用户信息
			$this->db->update ( 'user', array (
					'frominvatecode' => $frominvatecode 
			), array (
					'uid' => $uid 
			) );
			$invateusers = intval ( $user ['invateusers'] ) + 1; // 邀请人数+1
			$this->db->update ( 'user', array (
					'invateusers' => $invateusers 
			), array (
					'uid' => $user ['uid'] 
			) );
			// 将邀请人自动关注到被邀请人
			$touser = $this->get_by_uid ( $uid );
			$this->follow ( $user ['uid'], $touser ['uid'], $touser ['username'], 'user' );
			// 邀请注册，添加财富值
			$CI = & get_instance ();
			$CI->credit ( $user ['uid'], $this->setting ['credit1_invate'], $this->setting ['credit2_invate'], 0, 'invateuser' );
		}
	}
	// 分配邀请码
	function sendinvatecodetouid($uid) {
		$uid=intval($uid);
		// 随机产生一个邀请码
		$invatecode =random(8);
		// 检查有没有这个人，如果有就分配
		$user = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user WHERE invatecode='$invatecode'" )->row_array ();
		if (! $user) {
			// 更新用户信息
			$this->db->update ( 'user', array (
					'invatecode' => $invatecode 
			), array (
					'uid' => $uid 
			) );
			$this->refresh ( $uid );
		}
	}
	
	// ip地址限制
	function is_allowed_register() {
		global $setting;
		$starttime = strtotime ( "-1 day" );
		$endtime = strtotime ( "+1 day" );
		$this->db->from ( 'user' )->where ( array (
				'regip' => getip (),
				'regtime>' => $starttime,
				'regtime<' => $endtime 
		) );
		$usernum = $this->db->count_all_results ();
		if ($usernum >= $setting ['max_register_num']) {
			return false;
		}
		return true;
	}
	
	/* 修改用户密码 */
	function uppass($uid, $password) {
		$uid=intval($uid);
		$password = md5 ( $password );
		$this->db->set ( 'password', $password )->where ( array (
				'uid' => $uid 
		) )->update ( 'user' );
	}
	
	/* 更新用户信息 */
	function update($uid, $gender, $bday, $phone, $qq, $msn, $introduction, $signature, $isnotify = 1) {
		$data = array (
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
				'uid' => $uid 
		) )->update ( 'user' );
	}
	function update_email($email, $uid) {
		$this->db->set ( 'email', $email )->where ( array (
				'uid' => $uid 
		) )->update ( 'user' );
	}
	/* 修改邮箱并修改激活为0 */
	function update_emailandactive($email, $activecode, $uid) {
		$data = array (
				'activecode' => $activecode,
				'active' => 0,
				'email' => $email 
		);
		$this->db->set ( $data )->where ( array (
				'uid' => $uid 
		) )->update ( 'user' );
	}
	/* 修改激活为1,邮箱激活 */
	function update_useractive($uid) {
		$this->db->set ( 'active', 1 )->where ( array (
				'uid' => $uid 
		) )->update ( 'user' );
	}
	/* 激活用户手机号码 */
	function updatephone($uid, $userphone) {
		$data = array (
				'phone' => $userphone,
				'phoneactive' => 1 
		);
		$this->db->set ( $data )->where ( array (
				'uid' => $uid 
		) )->update ( 'user' );
	}
	/* 礼品兑换用户信息 */
	function update_gift($uid, $realname, $email, $phone, $qq) {
		$data = array (
				'realname' => $realname,
				'email' => $email,
				'phone' => $phone,
				'qq' => $qq 
		);
		$this->db->set ( $data )->where ( array (
				'uid' => $uid 
		) )->update ( 'user' );
	}
	
	/* 后台更新用户信息 */
	function update_user($uid, $username, $passwd, $email, $groupid, $credits, $credit1, $credit2, $gender, $bday, $phone, $qq, $msn, $introduction, $signature, $isblack = 0) {
		$data = array (
				'username' => $username,
				'password' => $passwd,
				'isblack' => $isblack,
				'email' => $email,
				'groupid' => $groupid,
				'credits' => $credits,
				'credit1' => $credit1,
				'credit2' => $credit2,
				'gender' => $gender,
				'bday' => $bday,
				'phone' => $phone,
				'qq' => $qq,
				'msn' => $msn,
				'introduction' => $introduction,
				'signature' => $signature 
		);
		
		$this->db->where ( array (
				'uid' => $uid 
		) )->update ( 'user', $data );
	}
	
	/* 更新authstr */
	function update_authstr($uid, $authstr) {
		$data = array (
				'authstr' => $authstr 
		);
		$this->db->set ( "authstr", $authstr )->where ( array (
				'uid' => $uid 
		) )->update ( 'user' );
	}
	
	/* 更新username */
	function update_username($uid, $username, $useremail) {
		$data = array (
				'username' => $username,
				'email' => $useremail 
		);
		$this->db->set ( $data )->where ( array (
				'uid' => $uid 
		) )->update ( 'user' );
	}
	
	/* 删除用户 */
	function remove($uids, $all = 0) {
		$this->db->where_in ( 'uid', explode ( ',', $uids ) )->delete ( 'user' );
		$this->db->where_in ( 'uid', explode ( ',', $uids ) )->delete ( 'famous' );
		/* 删除问题和回答,文章 */
		if ($all) {
			$tables = array (
					'question',
					'topic',
					'articlecomment',
					'answer' 
			);
			$this->db->where_in ( 'authorid', explode ( ',', $uids ) );
			$this->db->delete ( $tables );
			$this->db->set ( 'answers', 'answers-1', FALSE )->where_in ( 'authorid', explode ( ',', $uids ) )->update ( 'question' );
		}
		if(strstr($uids,',')){
			$uids = explode ( ',', $uids );
		}

		$this->db->where_in('uid',$uids)->delete('tag_item');
		$this->db->where_in('authorid',$uids)->delete('doing');
	
	}
	function logout() {
		global $user;
		tcookie ( 'sid', '', 0 );
		tcookie ( 'auth', '', 0 );
		tcookie ( 'cauth', '', 0 );
		tcookie ( 'loginuser', '', 0 );
		$query = $this->db->select_max ( 'time' )->where ( array (
				'uid' => $user ['uid'] 
		) )->get ( 'session' );
		$lasttime = $query->row_array ();
		$this->db->where ( array (
				'uid' => $user ['uid'],
				'time<' => $lasttime ['time'] 
		) )->delete ( 'session' );
		if(!$_SESSION){
			//开启 Session
			session_start();
		}
		
		// 删除所有 Session 变量
		$_SESSION = array();
		//判断 cookie 中是否保存 Session ID
		if(isset($_COOKIE[session_name()])){
			setcookie(session_name(),'',time()-3600, '/');
		}
		//彻底销毁 Session
		session_destroy();
	}
	function save_code($code,$codename="code") {
		if (! isset ( $_SESSION )) {
			session_start ();
		}
		$_SESSION [$codename] = $code;
	}
	function get_code($codename="code") {
		if (! isset ( $_SESSION )) {
			session_start ();
		}
		return $_SESSION [$codename];
	}
	function is_login($uid = 0) {
		global $user, $setting;
		(! $uid) && $uid = $user ['uid'];
		$onlinetime = time () - intval ( $setting ['sum_onlineuser_time'] ) * 60;
		$query = $this->db->select ( array (
				'islogin' 
		) )->get_where ( 'session', array (
				'uid' => $uid,
				'time>' => $onlinetime 
		) );
		$islogin = $query->row_array ();
		if ($islogin && $uid > 0) {
			return $islogin;
		}
		return false;
	}
	function get_refresh_time($uid) {
		$query = $this->db->from ( 'session' )->where ( array (
				'uid' => $uid 
		) )->order_by ( 'time DESC' )->get ();
		return $query->row_array ();
	}
	
	/* 用户财富值明细 */
	function credit_detail($uid, $start = 0, $limit = 10) {
		$details = array ();
		$query = $this->db->where ( array (
				'uid' => $uid 
		) )->order_by ( 'time desc' )->limit ( $limit, $start )->get ( 'credit' );
		foreach ( $query->result_array () as $credit ) {
			$credit ['time'] = tdate ( $credit ['time'] );
			
			switch ($credit ['operation']) {
				case 'api_user/loginapi' : // 普通登录
					$credit ['content'] = '登录网站';
					break;
				case 'question/ajaxanswer' : // 回答问题
					$credit ['content'] = '回答问题';
					break;
				case 'delanswer' : // 删除问题回答
					$credit ['content'] = '删除问题回答';
					break;
				case 'app_question/answerquestion' : // 回答问题
					$credit ['content'] = '回答问题';
					break;
				case 'plugin/sinalogin' :
					$credit ['content'] = '新浪微博登录网站';
					break;
				case 'offer' :
					$credit ['content'] = '悬赏财富值';
					break;
				case 'question/postmedia' :
					$credit ['content'] = '语音回答了问题';
					break;
				case 'question/postmedia' :
					$credit ['content'] = '语音回答了问题';
					break;
				case 'question/ajaxadd' :
					$credit ['content'] = '提了一个问题';
					break;
				case 'question/ajaxquickadd' :
					$credit ['content'] = '提出了一个问题';
					break;
				
				case 'adopt' :
					$credit ['content'] = '回答被采纳';
					break;
				case 'addarticle' :
					$credit ['content'] = '发布文章';
					break;
				case 'delarticle' :
					$credit ['content'] = '删除文章';
					break;
				case 'invateuser' :
					$credit ['content'] = '邀请用户注册';
					break;
				case 'api_user/registerapi' :
					$credit ['content'] = '注册了网站';
					break;
				case 'back' :
					$credit ['content'] = '财富值悬赏问题被删除';
					break;
				case 'hiddenback' :
					$credit ['content'] = '匿名问题被删除';
					break;
				case 'delquestion' :
					$credit ['content'] = '问题被删除';
					break;
				case 'back' :
					$credit ['content'] = '财富值悬赏问题被删除';
					break;
				case 'api_user/bindregisterapi' :
					$credit ['content'] = '注册并绑定微信账号';
					break;
				case 'user/addxinzhi' :
					$credit ['content'] = '发布文章';
					break;
				case 'api_user/bindloginapi' :
					$credit ['content'] = '登录并绑定微信';
					break;
					
				case 'app_auth/wxlogin' :
					$credit ['content'] = '微信授权登录网站';
					break;
				case 'app_auth/login' :
					$credit ['content'] = '微信授权登录网站';
					break;
				case 'appstore/postlogin' :
					$credit ['content'] = '登录应用商店';
					break;
				case 'question/answer' :
					$credit ['content'] = '回答问题';
					break;
				case 'user/register' :
					$credit ['content'] = '注册网站';
					break;
				case 'app_user/postlogin' :
					$credit ['content'] = '登录网站';
					break;
				case '支付宝充值' :
					$credit ['content'] = '支付宝财富值充值';
					break;
				case '积分充值' :
					$credit ['content'] = '微信财富值充值';
					break;
				case 'message/send' :
					$credit ['content'] = '发送私信';
					break;
				case 'app_user/sendmessage' :
					$credit ['content'] = '发送私信';
					break;
				default :
					$credit ['content'] = '其它操作';
					break;
			}
			$details [] = $credit;
		}
		return $details;
	}
	
	/* 检测用户名合法性 */
	function check_usernamecensor($username) {
		global $setting;
		$censorusername = $setting ['censor_username'];
		$censorexp = '/^(' . str_replace ( array (
				'\\*',
				"\r\n",
				' ' 
		), array (
				'.*',
				'|',
				'' 
		), preg_quote ( ($censorusername = trim ( $censorusername )), '/' ) ) . ')$/i';
		if ($censorusername && preg_match ( $censorexp, $username )) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	/* 检测邮件地址合法性 */
	function check_emailaccess($email) {
		global $setting;
		$accessemail = $setting ['access_email'];
		$censoremail = $setting ['censor_email'];
		$accessexp = '/(' . str_replace ( "\r\n", '|', preg_quote ( trim ( $accessemail ), '/' ) ) . ')$/i';
		$censorexp = '/(' . str_replace ( "\r\n", '|', preg_quote ( trim ( $censoremail ), '/' ) ) . ')$/i';
		if ($accessemail || $censoremail) {
			if (($accessemail && ! preg_match ( $accessexp, $email )) || ($censoremail && preg_match ( $censorexp, $email ))) {
				return FALSE;
			} else {
				return TRUE;
			}
		} else {
			return TRUE;
		}
	}
	function get_mynotify($uid) {
		$usernotify = $this->db->where ( array (
				"uid" => $uid 
		) )->limit ( 1 )->get ( "user_notify" )->row_array ();
		if ($usernotify) {
			return $usernotify;
		} else {
			// 插入
			$data ['uid'] = $uid;
			$data ['inbox_permission'] = 0;
			$data ['invite_permission'] = 0;
			$data ['follow_after_answer'] = 1;
			$data ['article'] = 1;
			$data ['like_object'] = 1;
			$data ['bookmark_object'] = 1;
			$data ['follow_object'] = 1;
			$data ['answer'] = 1;
			$data ['comment'] = 1;
			$data ['content_handled'] = 1;
			$data ['comment_reply'] = 1;
			$data ['invite'] = 1;
			$data ['message'] = 1;
			$data ['weekly'] = 1;
			$data ['feature_news'] = 1;
			$this->addnotify ( $data, 'add' );
		}
	}
	/**
	 *
	 * 查询通知是否存在
	 *
	 * @date: 2018年12月22日 上午10:37:51
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function selectnotifybyuid($uid) {
		$usernotify = $this->db->where ( array (
				"uid" => $uid 
		) )->limit ( 1 )->get ( "user_notify" )->row_array ();
		return $usernotify;
	}
	/**
	 *
	 * 插入用户通知
	 *
	 * @date: 2018年12月22日 上午10:31:59
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function addnotify($data, $type) {
		if ($type == 'add') {
			$this->db->insert ( 'user_notify', $data );
		}
		if ($type == 'edit') {
			$this->db->where ( array (
					"uid" => $data ['uid'] 
			) )->update ( 'user_notify', $data );
		}
	}
	/**
	 *
	 * 用户分类关注
	 *
	 * @date: 2018年12月22日 上午10:31:24
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function add_category($cid, $uid) {
		$data = array (
				'cid' => $cid,
				'uid' => $uid 
		);
		$this->db->insert ( 'user_category', $data );
	}
	function get_category($uid) {
		$query = $this->db->select ( '*' )->from ( 'user_category' )->where ( array (
				'uid' => $uid 
		) )->get ();
		
		$categorylist = array ();
		foreach ( $query->result_array () as $categorymodel ) {
			if (isset ( $this->category [$categorymodel ['cid']] )) {
				$categorymodel ['categoryname'] = $this->category [$categorymodel ['cid']] ['name'];
			} else {
				$categorymodel ['categoryname'] = '';
			}
			
			$categorylist [] = $categorymodel;
		}
		return $categorylist;
	}
	function remove_category($cid, $uid) {
		$this->db->where ( array (
				'cid' => $cid,
				'uid' => $uid 
		) )->delete ( 'user_category' );
	}
	function update_elect($uid, $elect) {
		$elect && $elect = time ();
		$this->db->set ( 'elect', $elect );
		$this->db->where ( 'uid', uid );
		$this->db->update ( 'user' );
	}
	function update_expert($uids, $type) {
		$this->db->set ( 'expert', $type );
		$this->db->where_in ( 'uid', $uids );
		$this->db->update ( 'user' );
	}
	function update_caijiuser($uids, $type) {
		$this->db->set ( 'fromsite', $type );
		$this->db->where_in ( 'uid', $uids );
		$this->db->update ( 'user' );
	}
	function get_login_auth($uid, $type = 'qq') {
		$query = $this->db->get_where ( 'login_auth', array (
				'type' => $type,
				'uid' => $uid 
		) );
		return $query->row_array ();
	}
	function remove_login_auth($uid, $type = 'qq') {
		$this->db->where ( array (
				'type' => $type,
				'uid' => $uid 
		) )->delete ( 'login_auth' );
	}
	
	/* 获取所有注册用户数目 */
	function rownum_alluser() {
		return array (
				$this->db->count_all ( 'user' ) 
		);
	}
	
	/* 获取所有在线用户数目 */
	function rownum_onlineuser() {
		$end = time () - intval ( $this->setting ['sum_onlineuser_time'] ) * 60;
		$this->db->where ( array (
				'time>' => $end 
		) )->from ( 'session' );
		$this->db->group_by ( "ip" );
		return $this->db->count_all_results ();
	}
	function list_online_user($start = 0, $limit = 50) {
		$onlinelist = array ();
		$end = time () - intval ( $this->setting ['sum_onlineuser_time'] ) * 60;
		$this->db->select ( array (
				'session.uid',
				'session.ip',
				'user.username',
				'session.time' 
		) );
		$this->db->from ( 'session' );
		$this->db->join ( 'user', "session.uid = user.uid " );
		$this->db->where ( array (
				'session.time>' => $end 
		) );
		$this->db->group_by ( "session.ip" );
		$this->db->order_by ( 'session.time DESC' )->limit ( $limit, $start );
		$query = $this->db->get ();
		
		foreach ( $query->result_array () as $online ) {
			$online ['online_time'] = tdate ( $online ['time'] );
			$onlinelist [] = $online;
		}
		return $onlinelist;
	}
	/* 邀请注册用户列表 */
	function getinvatelist($invatecode, $start = 0, $limit = 20) {
		$followerlist = array ();
		
		$query = $this->db->select ( '*' )->from ( 'user' )->where ( array (
				'frominvatecode' => $invatecode 
		) )->order_by ( 'uid DESC' )->limit ( $limit, $start )->get ();
		
		foreach ( $query->result_array () as $invater ) {
			$invater ['avatar'] = get_avatar_dir ( $invater ['uid'] );
			
			$is_followed = $this->is_followed ( $invater ['uid'], $this->user ['uid'] );
			
			$invater ['hasfollower'] = $is_followed == 0 ? "0" : "1";
			
			$userfollower = $this->get_by_uid ( $invater ['uid'] );
			
			$invater ['info'] = $userfollower;
			$followerlist [] = $invater;
		}
		
		return $followerlist;
	}
	/* 关注者列表 */
	function get_follower($uid, $start = 0, $limit = 20) {
		$followerlist = array ();
		
		$query = $this->db->select ( '*' )->from ( 'user_attention' )->where ( array (
				'uid' => $uid 
		) )->order_by ( 'time DESC' )->limit ( $limit, $start )->get ();
		
		foreach ( $query->result_array () as $follower ) {
			$follower ['avatar'] = get_avatar_dir ( $follower ['followerid'] );
			$is_followed = $this->is_followed ( $follower ['followerid'], $this->user ['uid'] );
			$follower ['hasfollower'] = $is_followed == 0 ? "0" : "1";
			$userfollower = $this->get_by_uid ( $follower ['followerid'] );
			$follower ['info'] = $userfollower;
			$followerlist [] = $follower;
		}
		return $followerlist;
	}
	
	/* 已关注列表 */
	function get_attention($followerid, $start = 0, $limit = 20) {
		$attentionlist = array ();
		$this->db->select ( array (
				'user.uid',
				'user.username',
				'user.gender' 
		) );
		$this->db->from ( 'user_attention' );
		$this->db->join ( 'user', "user_attention.uid = user.uid and user_attention.followerid=$followerid" );
		$this->db->order_by ( 'user_attention.time DESC' )->limit ( $limit, $start );
		$query = $this->db->get ();
		
		foreach ( $query->result_array () as $attention ) {
			$attention ['avatar'] = get_avatar_dir ( $attention ['uid'] );
			$is_followed = $this->is_followed ( $attention ['uid'], $this->user ['uid'] );
			$attention ['hasfollower'] = $is_followed == 0 ? "0" : "1";
			$userattention = $this->get_by_uid ( $attention ['uid'] );
			$attention ['info'] = $userattention;
			$attentionlist [] = $attention;
		}
		return $attentionlist;
	}
	
	/* 已关注列表 */
	function get_attention_question($followerid, $start = 0, $limit = 20) {
		$questionlist = array ();
		$this->db->select ( 'question.*' );
		$this->db->from ( 'question' );
		$this->db->join ( 'question_attention', "question.cid!=0 and question_attention.qid = question.id and question_attention.followerid=$followerid" );
		$this->db->order_by ( 'question_attention.time DESC' )->limit ( $limit, $start );
		$query = $this->db->get ();
		
		foreach ( $query->result_array () as $question ) {
			if ($question ['cid'] != 0) {
				$question ['avatar'] = get_avatar_dir ( $question ['authorid'] );
				$question ['image'] = getfirstimg ( $question ['description'] );
				$question ['images'] = getfirstimgs ( $question ['description'] );
				$question ['description'] = cutstr ( checkwordsglobal ( strip_tags ( $question ['description'] ) ), 240, '...' );
				$question ['attention_time'] = tdate ( $question ['time'] );
				
				$question ['category_name'] = $this->category [$question ['cid']] ['name'];
				$questionlist [] = $question;
			}
		}
		return $questionlist;
	}
	function rownum_attention_question($followerid) {
		$this->db->select ( '*' );
		$this->db->from ( 'question' );
		$this->db->join ( 'question_attention', "question.cid!=0 and question_attention.qid = question.id and question_attention.followerid=$followerid" );
		return $this->db->count_all_results ();
	}
	/* 已关注分类话题列表 */
	function get_attention_category($followerid, $start = 0, $limit = 20) {
		$modellist = array ();
		
		$query = $this->db->select ( '*' )->from ( 'categotry_follower' )->where ( array (
				'uid' => $followerid 
		) )->order_by ( 'time DESC' )->limit ( $limit, $start )->get ();
		
		foreach ( $query->result_array () as $model ) {
			$c_time = tdate ( $model ['time'] );
			$c_uid = $model ['uid'];
			$c_cid = $model ['cid'];
			$model = $this->get_cat_bycid ( $model ['cid'] );
			$model ['uid'] = $c_uid;
			$model ['cid'] = $c_cid;
			$model ['avatar'] = get_avatar_dir ( $c_uid );
			$model ['doing_time'] = $c_time;
			$model ['url'] = urlmap ( 'category/view/' . $model ['cid'], 2 );
			$model ['url'] = url ( $model ['url'] );
			$modellist [] = $model;
		}
		return $modellist;
	}
	function rownum_attention_category($followerid) {
		$this->db->from ( 'categotry_follower' )->where ( array (
				'uid' => $followerid 
		) );
		return $this->db->count_all_results ();
	}
	function get_cat_bycid($id) {
		$query = $this->db->get_where ( 'category', array (
				'id' => $id 
		) );
		$category = $query->row_array ();
		
		$category ['image'] = get_cid_dir ( $category ['id'], 'small' );
		$category ['follow'] = $this->is_followedcid ( $category ['id'], $this->user ['uid'] );
		$category ['miaosu'] = cutstr ( checkwordsglobal ( strip_tags ( $category ['miaosu'] ) ), 140, '...' );
		$category ['bigimage'] = get_cid_dir ( $category ['id'], 'big' );
		return $category;
	}
	/* 是否关注分类 */
	function is_followedcid($cid, $uid) {
		$this->db->from ( 'categotry_follower' )->where ( array (
				'uid' => $uid,
				'cid' => $cid 
		) );
		return $this->db->count_all_results ();
	}
	
	/* 是否关注用户 */
	function is_followed($uid, $followerid) {
		$this->db->from ( 'user_attention' )->where ( array (
				'uid' => $uid,
				'followerid' => $followerid 
		) );
		return $this->db->count_all_results ();
	}
	
	/* 关注 */
	function follow($sourceid, $followerid, $follower, $type = 'question') {
		$usertmp = $this->get_by_uid ( $followerid );
		$sourcefield = 'qid';
		($type != 'question') && $sourcefield = 'uid';
		
		if ($usertmp ['fromsite'] == 1) {
			$tiwentime = $tiwentime * 120;
			$randtime = rand ( 1, $tiwentime );
			
			$time = strtotime ( "-$randtime minute" ); // 如果是采集用户，那么关注时间随机
		} else {
			$time = time ();
		}
		$data = array (
				"$sourcefield" => $sourceid,
				'followerid' => $followerid,
				'follower' => $follower,
				'time' => $time 
		);
		
		$this->db->insert ( $type . "_attention", $data );
		if ($type == 'question') {
			$data = array (
					'qid' => $sourceid,
					'uid' => $followerid,
					'time' => time () 
			);
			
			$this->db->replace ( 'favorite', $data );
			$this->db->set ( 'attentions', 'attentions+1', FALSE );
			
			$this->db->where ( 'id', $sourceid );
			$this->db->update ( 'question' );
			
			if ($this->setting ['xunsearch_open']) {
				$_question = $this->getquestionbyqid ( $sourceid );
				$question = array ();
				$question ['id'] = $sourceid;
				$question ['attentions'] = $_question ['attentions'];
				$question ['price'] = $_question ['price'];
				$doc = new XSDocument ();
				$doc->setFields ( $question );
				$this->index->update ( $doc );
			}
		} else if ($type == 'user') {
			
			$this->db->set ( 'followers', 'followers+1', FALSE );
			$this->db->where ( 'uid', $sourceid );
			$this->db->update ( 'user' );
			
			$this->db->set ( 'attentions', 'attentions+1', FALSE );			
			$this->db->where ( 'uid', $followerid );
			$this->db->update ( 'user' );
			
	
			
		}
	}
	
	/* 取消关注 */
	function unfollow($sourceid, $followerid, $type = 'question') {
		$sourcefield = 'qid';
		($type != 'question') && $sourcefield = 'uid';
		$this->db->delete ( $type . "_attention", array (
				"$sourcefield" => $sourceid,
				'followerid' => $followerid 
		) );
		
		if ($type == 'question') {
			$this->db->set ( 'attentions', 'attentions-1', FALSE );
			$this->db->where ( 'id', $sourceid );
			$this->db->update ( 'question' );
			
			if ($this->setting ['xunsearch_open']) {
				$_question = $this->getquestionbyqid ( $sourceid );
				$question = array ();
				$question ['id'] = $sourceid;
				$question ['attentions'] = $_question ['attentions'];
				$question ['shangjin'] = $_question ['shangjin'];
				$question ['price'] = $_question ['price'];
				$doc = new XSDocument ();
				$doc->setFields ( $question );
				$this->index->update ( $doc );
			}
		} else if ($type == 'user') {
			$this->db->set ( 'followers', 'followers-1', FALSE );
			$this->db->where ( 'uid', $sourceid );
			$this->db->update ( 'user' );
			$this->db->set ( 'attentions', 'attentions-1', FALSE );
			$this->db->where ( 'uid', $followerid );
			$this->db->update ( 'user' );
		}
	}
	function getquestionbyqid($id) {
		$query = $this->db->get_where ( 'question', array (
				'id' => $id 
		) );
		$question = $query->row_array ();
		
		return $question;
	}
}

?>