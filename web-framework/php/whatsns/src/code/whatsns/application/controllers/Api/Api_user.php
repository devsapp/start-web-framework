<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Api_user extends CI_Controller {
	var $apikey = '';
	var $whitelist;
	// 构造函数
	function __construct() {
		$this->whitelist = "bindloginapi";
		parent::__construct ();
		$this->load->model ( 'user_model' );
	}
	// -----------------------------------用户注册录接口函数
	function bindregisterapi() {
		$sitename = $this->setting ['site_name'];
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		if (! strstr ( $useragent, 'MicroMessenger' )) {
			exit ( "只能微信里绑定哟，您就别费劲想耍花招了" );
		}
		if (! $this->setting ['allow_register']) {
			exit ( "系统注册功能暂时处于关闭状态!" );
		}
		$openid = trim ( $this->input->post ( 'openid' ) ); // openid
		$username = strip_tags ( trim ( $this->input->post ( 'uname' ) ) ); // 用户注册名字，strip_tags第一层过滤
		$password = trim ( $this->input->post ( 'upwd' ) ); // 用户注册密码
		$phone = trim ( $this->input->post ( 'phone' ) ); // 用户注册手机号
		$repassword = trim ( $this->input->post ( 'rupwd' ) ); // 用户注册密码
		
		$frominvatecode = strip_tags ( trim ( $this->input->post ( 'frominvatecode' ) ) ); // 用户邀请码
		$this->checkdeepstring ( $username );
		$usernamecensor = $this->user_model->check_usernamecensor ( $username );
		if (FALSE == $usernamecensor)
			exit ( '用户包含敏感词' );
		$this->checkstring ( $password );
		$this->checkstring ( $repassword );
		
		if (! $this->setting ['needinvatereg']) {
			if (trim ( $this->input->post ( 'seccode_verify' ) ) == '') {
				exit ( '验证码不能为空' );
			}
		}
		
		// 判断邀请码是否为真
		if ($frominvatecode) {
			$tempinvateuser = $this->user_model->get_by_invatecode ( $frominvatecode );
			if (! $tempinvateuser) {
				exit ( '邀请码不存在' );
			}
		} else {
			$frominvatecode = '';
		}
		if ($this->setting ['needinvatereg'] == 1) {
			if (empty ( $frominvatecode )) {
				exit ( '邀请码不正确' );
			}
		}
		
		$email = ''; // 用户邮箱
		if (! $this->setting ['register_email_on']) {
			$email = $this->input->post ( 'email' ); // 用户邮箱
			$emailaccess = $this->user_model->check_emailaccess ( $email );
			if (FALSE == $emailaccess) {
				exit ( "邮件地址被禁止注册" );
			}
			
			if (! preg_match ( "/^[a-z'0-9]+([._-][a-z'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$/", strtolower ( $email ) )) {
				exit ( "regemail_Illegal" ); // 注册邮箱不合法
			} else if ($this->db->from ( 'user' )->where ( array (
					'email' => $email 
			) )->count_all_results ()) {
				exit ( "regemail_has_exits" ); // 注册邮箱已经存在
			} else if (! $this->user_model->check_usernamecensor ( $username )) {
				exit ( "regemail_cant_use" ); // 注册邮箱不能使用
			}
		}
		
		$groupid = 7; // 角色ID
		if ($repassword != $password) {
			exit ( "两次输入密码不一样" ); // 用户密码不能为空
		}
		if ('' == $username || '' == $password) {
			exit ( "reguser_cant_null" ); // 用户密码不能为空
		}
		
		$user = $this->user_model->get_by_username ( $username );
		$user && exit ( "reguser_has_exits" ); // 注册用户已经存在
		                                       
		// ucenter注册。
		if ($this->setting ["ucenter_open"]) {
			// 判断手机号是否启用注册
			if (isset ( $this->setting ['smscanuse'] ) && $this->setting ['smscanuse'] == 1) {
				$userone = $this->user_model->get_by_phone ( $phone );
				if ($userone != null) {
					exit ( "手机号已存在!" );
				}
			}
			$this->load->model ( 'ucenter_model' );
			$msg = $this->ucenter_model->ajaxregister ( $username, $password, $email );
			if ($msg == 'ok') {
				// $uid = $_ENV['user']->adduserapi($username, $password, $email,$groupid);//插入model/user.class.php里adduserapi函数里
				$user = $this->user_model->get_by_username ( $username );
				$uid = $user ['uid'];
				if (isset ( $this->setting ['smscanuse'] ) && $this->setting ['smscanuse'] == 1) {
					// 如果启用手机号注册就更新此用户手机号并处于激活状态
					$this->db->where ( array (
							'uid' => $uid 
					) )->update ( 'user', array (
							'phone' => $phone,
							'phoneactive' => 1 
					) );
				}
				
				$this->user_model->refresh ( $uid );
				$this->setAvatar ( $uid );
				$_opentmp_user = $this->user_model->get_by_openid ( $openid );
				
				if (! $_opentmp_user) {
					$datatmp = array (
							'openid' => $openid 
					);
					$this->db->where ( array (
							'uid' => intval ( $uid ) 
					) )->update ( 'user', $datatmp );
				}
				
				$this->credit ( $uid, $this->setting ['credit1_register'], $this->setting ['credit2_register'] ); // 注册增加积分
				if ($frominvatecode) {
					$this->user_model->updateinvatecode ( $uid, $frominvatecode );
				}
				if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1') {
					
					$activecode = md5 ( rand ( 10000, 50000 ) );
					$url = SITE_URL . 'index.php?user/checkemail/' . $uid . '/' . $activecode;
					$message = "这是一封来自【" . $sitename . "】邮箱验证，<a target='_blank' href='$url'>请点击此处验证邮箱邮箱账号</a>";
					$v = md5 ( "yanzhengask2email" );
					$v1 = md5 ( "yanzhengask2time" );
					setcookie ( "emailsend" );
					setcookie ( "useremailcheck" );
					$expire1 = time () + 60; // 设置1分钟的有效期
					setcookie ( "emailsend", $v1, $expire1 ); // 设置一个名字为var_name的cookie，并制定了有效期
					$expire = time () + 86400; // 设置24小时的有效期
					setcookie ( "useremailcheck", $v, $expire ); // 设置一个名字为var_name的cookie，并制定了有效期
					$this->user_model->update_emailandactive ( $email, $activecode, $uid );
					$this->user_model->refresh ( $this->user ['uid'], 1 );
					sendmailto ( $email, "邮箱验证提醒-$sitename", $message, $this->user ['username'] );
				}
				// $this->credit($this->user['uid'], $this->setting['credit1_register'], $this->setting['credit2_register']); //注册增加积分
				
				if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1') {
					exit ( "reguser_ok1" );
					
					// exit("注册成功，系统已发送注册邮件，24小时之内请进行邮箱验证，在您没激活邮件之前你不能发布问题和文章等操作！");//注册成功
				} else {
					exit ( "reguser_ok" );
				}
			} else {
				exit ( $msg );
			}
		}
		$uid = 0;
		if (isset ( $this->setting ['smscanuse'] ) && $this->setting ['smscanuse'] == 1) {
			$userone = $this->user_model->get_by_phone ( $phone );
			if ($userone != null) {
				exit ( "手机号已存在!" );
			}
		}
		
		if (isset ( $this->setting ['smscanuse'] ) && $this->setting ['smscanuse'] == 1) {
			$uid = $this->user_model->adduserapi ( $username, $password, $email, $groupid, 0, $phone ); // 插入model/user.class.php里adduserapi函数里
		} else {
			
			$uid = $this->user_model->adduserapi ( $username, $password, $email, $groupid );
		}
		
		$newuser = $this->user_model->get_by_username ( $username );
		$uid = $newuser ['uid'];
		// 如果是来自dz导入的用户信息
		if (FROMUC) {
			// 更新用户密码
			$salt = random ( 6 ); // 加盐
			$newpwd = md5 ( md5 ( $password ) . $salt );
			$this->db->query ( "update " . $this->db->dbprefix . "user set salt='$salt' , password='$newpwd' where uid=$uid " );
		}
		$this->user_model->refresh ( $uid );
		
		$_opentmp_user = $this->user_model->get_by_openid ( $openid );
		
		if (! $_opentmp_user) {
			$datatmp = array (
					'openid' => $openid 
			);
			$this->db->where ( array (
					'uid' => intval ( $uid ) 
			) )->update ( 'user', $datatmp );
		}
		
		$sitename = $this->setting ['site_name'];
		
		$this->credit ( $uid, $this->setting ['credit1_register'], $this->setting ['credit2_register'] ); // 注册增加积分
		if ($frominvatecode) {
			$this->user_model->updateinvatecode ( $uid, $frominvatecode );
		}
		
		if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1') {
			
			$activecode = md5 ( rand ( 10000, 50000 ) );
			$url = SITE_URL . 'index.php?user/checkemail/' . $uid . '/' . $activecode;
			$message = "这是一封来自【" . $sitename . "】邮箱验证，<a target='_blank' href='$url'>请点击此处验证邮箱邮箱账号</a>";
			$v = md5 ( "yanzhengask2email" );
			$v1 = md5 ( "yanzhengask2time" );
			setcookie ( "emailsend" );
			setcookie ( "useremailcheck" );
			$expire1 = time () + 60; // 设置1分钟的有效期
			setcookie ( "emailsend", $v1, $expire1 ); // 设置一个名字为var_name的cookie，并制定了有效期
			$expire = time () + 86400; // 设置24小时的有效期
			setcookie ( "useremailcheck", $v, $expire ); // 设置一个名字为var_name的cookie，并制定了有效期
			$this->user_model->update_emailandactive ( $email, $activecode, $uid );
			$this->user_model->refresh ( $this->user ['uid'], 1 );
			sendmailto ( $email, "邮箱验证提醒-$sitename", $message, $this->user ['username'] );
		}
		// $this->credit($this->user['uid'], $this->setting['credit1_register'], $this->setting['credit2_register']); //注册增加积分
		$this->setAvatar ( $uid );
		if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1') {
			exit ( "reguser_ok1" );
			
			// exit("注册成功，系统已发送注册邮件，24小时之内请进行邮箱验证，在您没激活邮件之前你不能发布问题和文章等操作！");//注册成功
		} else {
			exit ( "reguser_ok" );
		}
	}
	// -----------------------------------用户注册录接口函数
	function registerapi() {
		$sitename = $this->setting ['site_name'];
		
		$username = strip_tags ( trim ( $this->input->post ( 'uname' ) ) ); // 用户注册名字，strip_tags第一层过滤
		$password = trim ( $this->input->post ( 'upwd' ) ); // 用户注册密码
		$phone = trim ( $this->input->post ( 'phone' ) ); // 用户注册手机号
		$repassword = trim ( $this->input->post ( 'rupwd' ) ); // 用户注册密码
		
		$frominvatecode = strip_tags ( trim ( $this->input->post ( 'frominvatecode' ) ) ); // 用户邀请码
		
		$this->checkdeepstring ( $username );
		if (! $this->setting ['allow_register']) {
			exit ( "系统注册功能暂时处于关闭状态!" );
		}
		if (isset ( $this->setting ['max_register_num'] ) && $this->setting ['max_register_num'] && ! $this->user_model->is_allowed_register ()) {
			exit ( "您的当前的IP已经超过当日最大注册数目，如有疑问请联系管理员!" );
		}
		if (! $this->setting ['needinvatereg']) {
			if (trim ( $this->input->post ( 'seccode_verify' ) ) == '') {
				exit ( '验证码不能为空' );
			}
		}
		
		// 判断邀请码是否为真
		if ($frominvatecode) {
			$tempinvateuser = $this->user_model->get_by_invatecode ( $frominvatecode );
			if (! $tempinvateuser) {
				exit ( '邀请码不存在' );
			}
		} else {
			$frominvatecode = '';
		}
		if ($this->setting ['needinvatereg'] == 1) {
			if (empty ( $frominvatecode )) {
				exit ( '邀请码不正确' );
			}
		}
		
		$usernamecensor = $this->user_model->check_usernamecensor ( $username );
		
		if (isset ( $this->setting ['smscanuse'] ) && $this->setting ['smscanuse'] == 1) {
			
			if (! preg_match ( "/^1[23456789]{1}\d{9}$/", $phone )) {
				
				exit ( "手机号码不正确" );
			}
			if (trim ( $this->input->post ( 'seccode_verify' ) ) == '') {
				exit ( '验证码不能为空' );
			}
			if (strtolower ( trim ( $this->input->post ( 'seccode_verify' ) ) ) != $this->user_model->get_code ( "phonecode" )) {
				exit ( '验证码错误' );
			}
		}
		
		if (FALSE == $usernamecensor)
			exit ( '用户包含敏感词' );
		$this->checkstring ( $password );
		$this->checkstring ( $repassword );
		$email = ''; // 用户邮箱
		if (! $this->setting ['register_email_on']) {
			$email = $this->input->post ( 'email' ); // 用户邮箱
			$emailaccess = $this->user_model->check_emailaccess ( $email );
			if (FALSE == $emailaccess) {
				exit ( "邮件地址被禁止注册" );
			}
			
			if (! preg_match ( "/^[a-z'0-9]+([._-][a-z'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$/", strtolower ( $email ) )) {
				exit ( "regemail_Illegal" ); // 注册邮箱不合法
			} else if ($this->db->from ( 'user' )->where ( array (
					'email' => $email 
			) )->count_all_results ()) {
				exit ( "regemail_has_exits" ); // 注册邮箱已经存在
			} else if (! $this->user_model->check_usernamecensor ( $username )) {
				exit ( "regemail_cant_use" ); // 注册邮箱不能使用
			}
		}
		
		$groupid = 7; // 角色ID
		if (! $this->setting ['needinvatereg']) {
			if ($repassword != $password) {
				exit ( "两次输入密码不一样" ); // 用户密码不能为空
			}
		}
		
		if ('' == $username || '' == $password) {
			exit ( "reguser_cant_null" ); // 用户密码不能为空
		}
		$user = $this->user_model->get_by_username ( $username );
		$user && exit ( "reguser_has_exits" ); // 注册用户已经存在
		                                       
		// ucenter注册。
		if ($this->setting ["ucenter_open"]) {
			// 判断手机号是否启用注册
			if (isset ( $this->setting ['smscanuse'] ) && $this->setting ['smscanuse'] == 1) {
				$userone = $this->user_model->get_by_phone ( $phone );
				if ($userone != null) {
					exit ( "手机号已存在!" );
				}
			}
			$this->load->model ( 'ucenter_model' );
			$msg = $this->ucenter_model->ajaxregister ( $username, $password, $email );
			if ($msg == 'ok') {
				// $uid = $_ENV['user']->adduserapi($username, $password, $email,$groupid);//插入model/user.class.php里adduserapi函数里
				$user = $this->user_model->get_by_username ( $username );
				$uid = $user ['uid'];
				if (isset ( $this->setting ['smscanuse'] ) && $this->setting ['smscanuse'] == 1) {
					// 如果启用手机号注册就更新此用户手机号并处于激活状态
					$this->db->where ( array (
							'uid' => $uid 
					) )->update ( 'user', array (
							'phone' => $phone,
							'phoneactive' => 1 
					) );
				}
				// 判断是否有第三方登录
				if ($_SESSION ['authinfo'] != null) {
					$this->bindthird ( $uid, $_SESSION ['authinfo'] );
				}
				$this->user_model->refresh ( $uid );
				$sitename = $this->setting ['site_name'];
				$this->load->model ( "doing_model" );
				$this->doing_model->add ( $uid, $username, 12, $uid, "欢迎您注册了$sitename" );
				$this->credit ( $uid, $this->setting ['credit1_register'], $this->setting ['credit2_register'] ); // 注册增加积分
				$this->setAvatar ( $uid );
				if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1' && $email != '') {
					
					$activecode = md5 ( rand ( 10000, 50000 ) );
					$url = SITE_URL . 'index.php?user/checkemail/' . $uid . '/' . $activecode;
					$message = "这是一封来自【" . $sitename . "】邮箱验证，<a target='_blank' href='$url'>请点击此处验证邮箱邮箱账号</a>";
					$v = md5 ( "yanzhengask2email" );
					$v1 = md5 ( "yanzhengask2time" );
					setcookie ( "emailsend" );
					setcookie ( "useremailcheck" );
					$expire1 = time () + 60; // 设置1分钟的有效期
					setcookie ( "emailsend", $v1, $expire1 ); // 设置一个名字为var_name的cookie，并制定了有效期
					$expire = time () + 86400; // 设置24小时的有效期
					setcookie ( "useremailcheck", $v, $expire ); // 设置一个名字为var_name的cookie，并制定了有效期
					$this->user_model->update_emailandactive ( $email, $activecode, $uid );
					$this->user_model->refresh ( $uid, 1 );
					sendmailto ( $email, "邮箱验证提醒-$sitename", $message, $this->user ['username'] );
				}
				// $this->credit($this->user['uid'], $this->setting['credit1_register'], $this->setting['credit2_register']); //注册增加积分
				
				if ($frominvatecode) {
					$this->user_model->updateinvatecode ( $uid, $frominvatecode );
				}
				
				if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1') {
					
					exit ( "reguser_ok1" );
					
					// exit("注册成功，系统已发送注册邮件，24小时之内请进行邮箱验证，在您没激活邮件之前你不能发布问题和文章等操作！");//注册成功
				} else {
					exit ( "reguser_ok" );
				}
			} else {
				exit ( $msg );
			}
		}
		$uid = 0;
		if (isset ( $this->setting ['smscanuse'] ) && $this->setting ['smscanuse'] == 1) {
			$userone = $this->user_model->get_by_phone ( $phone );
			if ($userone != null) {
				exit ( "手机号已存在!" );
			}
		}
		
		if (isset ( $this->setting ['smscanuse'] ) && $this->setting ['smscanuse'] == 1) {
			$uid = $this->user_model->adduserapi ( $username, $password, $email, $groupid, 0, $phone ); // 插入model/user.class.php里adduserapi函数里
		} else {
			
			$uid = $this->user_model->adduserapi ( $username, $password, $email, $groupid );
		}
		// 如果是来自dz导入的用户信息
		if (FROMUC) {
			// 更新用户密码
			$salt = random ( 6 ); // 加盐
			$newpwd = md5 ( md5 ( $password ) . $salt );
			$this->db->query ( "update " . $this->db->dbprefix . "user set salt='$salt' , password='$newpwd' where uid=$uid " );
		}
		if ($frominvatecode) {
			$this->user_model->updateinvatecode ( $uid, $frominvatecode );
		}
		
		// 判断是否有第三方登录
		if ($_SESSION ['authinfo'] != null) {
			$this->bindthird ( $uid, $_SESSION ['authinfo'] );
		}
		$this->user_model->refresh ( $uid );
		$sitename = $this->setting ['site_name'];
		
		$this->load->model ( "doing_model" );
		$this->doing_model->add ( $uid, $username, 12, $uid, "欢迎您注册了$sitename" );
		$this->credit ( $uid, $this->setting ['credit1_register'], $this->setting ['credit2_register'] ); // 注册增加积分
		
		if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1' && $email != '') {
			
			$activecode = md5 ( rand ( 10000, 50000 ) );
			$url = SITE_URL . 'index.php?user/checkemail/' . $uid . '/' . $activecode;
			$message = "这是一封来自【" . $sitename . "】邮箱验证，<a target='_blank' href='$url'>请点击此处验证邮箱邮箱账号</a>";
			$v = md5 ( "yanzhengask2email" );
			$v1 = md5 ( "yanzhengask2time" );
			setcookie ( "emailsend" );
			setcookie ( "useremailcheck" );
			$expire1 = time () + 60; // 设置1分钟的有效期
			setcookie ( "emailsend", $v1, $expire1 ); // 设置一个名字为var_name的cookie，并制定了有效期
			$expire = time () + 86400; // 设置24小时的有效期
			setcookie ( "useremailcheck", $v, $expire ); // 设置一个名字为var_name的cookie，并制定了有效期
			$this->user_model->update_emailandactive ( $email, $activecode, $uid );
			$this->user_model->refresh ( $this->user ['uid'], 1 );
			sendmailto ( $email, "邮箱验证提醒-$sitename", $message, $this->user ['username'] );
		}
		$this->setAvatar ( $uid );
		if (isset ( $this->setting ['register_on'] ) && $this->setting ['register_on'] == '1') {
			exit ( "reguser_ok1" );
			
			// exit("注册成功，系统已发送注册邮件，24小时之内请进行邮箱验证，在您没激活邮件之前你不能发布问题和文章等操作！");//注册成功
		} else {
			exit ( "reguser_ok" );
		}
	}
	// 检查http请求的主机和请求的来路域名是否相同，不相同拒绝请求
	function check_loginapikey() {
		if (! isset ( $_SESSION )) {
			session_start ();
		}
		if ($_SESSION ["logintokenid"] == null || $this->input->post ( 'apikey' ) == null) {
			echo '非法操作.';
			exit ();
		}
		if ($_SESSION ["logintokenid"] != $this->input->post ( 'apikey' )) {
			echo '页面过期，请保存数据刷新页面在操作!';
			exit ();
		}
	}
	// 检查http请求的主机和请求的来路域名是否相同，不相同拒绝请求
	function check_registerapikey() {
		if (! isset ( $_SESSION )) {
			session_start ();
		}
		if ($_SESSION ["registrtokenid"] == null || $this->input->post ( 'apikey' ) == null) {
			echo '非法操作.';
			exit ();
		}
		if ($_SESSION ["registrtokenid"] != $this->input->post ( 'apikey' )) {
			echo '页面过期，请保存数据刷新页面在操作!';
			exit ();
		}
	}
	function setAvatar($uid) {
		$uid = intval ( $uid );
		
		$avatardir = "/data/avatar/";
		$extname = "jpg";
		$upload_tmp_file = FCPATH . 'static/css/default/avatar.gif';
		$uid = abs ( $uid );
		$uid = sprintf ( "%09d", $uid );
		$dir1 = $avatardir . substr ( $uid, 0, 3 );
		$dir2 = $dir1 . '/' . substr ( $uid, 3, 2 );
		$dir3 = $dir2 . '/' . substr ( $uid, 5, 2 );
		(! is_dir ( FCPATH . $dir1 )) && forcemkdir ( FCPATH . $dir1 );
		(! is_dir ( FCPATH . $dir2 )) && forcemkdir ( FCPATH . $dir2 );
		(! is_dir ( FCPATH . $dir3 )) && forcemkdir ( FCPATH . $dir3 );
		$smallimg = $dir3 . "/small_" . $uid . '.' . $extname;
		
		$avatar_dir = glob ( FCPATH . $dir3 . "/small_{$uid}.*" );
		foreach ( $avatar_dir as $imgfile ) {
			if (strtolower ( $extname ) != extname ( $imgfile ))
				unlink ( $imgfile );
		}
		copy ( $upload_tmp_file, FCPATH . $smallimg );
		// image_resize ( $upload_tmp_file, FCPATH . $smallimg, 200, 200, 1 );
	}
	
	// ---------------------------用户登录接口函数
	/*
	 *
	 *
	 * uname:用户名
	 *
	 * upwd:用户密码
	 */
	function loginapi() {
		$username = trim ( $this->input->post ( 'uname' ) ); // 用户名
		
		$password = md5 ( trim ( $this->input->post ( 'upwd' ) ) ); // 用户密码
		
		$this->checkdeepstring ( $username );
		
		$this->checkstring ( $password );
		if ('' == $username || '' == $password) {
			exit ( 'login_null' ); // 登录参数为空
		}
		
		// ucenter登陆。
		if ($this->setting ["ucenter_open"]) {
			$this->load->model ( 'ucenter_model' );
			$msg = $this->ucenter_model->ajaxlogin ( $username, $this->input->post ( 'upwd' ) );
			if ($msg == 'ok') {
				
				$cookietime = 2592000;
				$user = $this->user_model->get_by_username ( $username );
				if (! $user) {
					$uid = $this->user_model->add ( $username, $this->input->post ( 'upwd' ) );
					$user = $this->user_model->get_by_username ( $username );
				} else {
					if ($user ['isblack'] == 1) {
						exit ( '用户被列入网站黑名单!' ); // 登录参数为空
					}
					$uid = $user ['uid'];
				}
				$this->user_model->refresh ( $uid, 1, $cookietime );
				
				// 判断是否有第三方登录
				if ($_SESSION ['authinfo'] != null) {
					$this->bindthird ( $user ['uid'], $_SESSION ['authinfo'] );
				}
				
				$this->credit ( $user ['uid'], $this->setting ['credit1_login'], $this->setting ['credit2_login'] ); // 登录增加积分
				
				exit ( 'login_ok' ); // 登录成功
			} else {
				exit ( $msg );
			}
		}
		
		$user = $this->user_model->get_by_username ( $username );
		if (! $user) {
			
			exit ( '输出账号不存在' ); // 输出账号不存在
		}
		if (isset ( $this->setting ['openfrontlogin'] )) {
			if (intval ( $this->setting ['openfrontlogin'] )) {
				
				// 判断登录账号是否还可以继续尝试密码登录，此处代码不管密码对不对，只要达到限制登录次数就回阻止后续代码运行
				if (isset ( $this->setting ['pwd_error_locktime'] )) {
					$min = intval ( $this->setting ['pwd_error_locktime'] );
				} else {
					$min = 30;
				}
				// 检查用户最近30分钟密码错误次数
				$res = $this->checkPassWrongTime ( $user ['uid'] );
				// 错误次数超过限制次数
				if ($res === false) {
					exit ( '你刚刚输错很多次密码，为了保证账户安全，系统已经将您账号锁定' . $min . '分钟' );
				}
			}
		}
		$ispwd = false;
		
		if ($user ['password'] == md5 ( $password . $user ['salt'] ) || $user ['password'] == $password) {
			$ispwd = true;
		}
		$cookietime = 7200;
		
		if (is_array ( $user ) && $ispwd) {
			if ($user ['isblack'] == 1) {
				exit ( '用户被列入网站黑名单!' ); // 登录参数为空
			}
			$openid = $_SESSION ['authinfo'] ['uid'];
			// if($user['wechatopenid']!=''&&$user['wechatopenid']!=$openid){
			// exit ( '该账号已绑定其它微信，请先解绑!' );
			// }
			
			// 判断是否有第三方登录
			if ($_SESSION ['authinfo'] != null) {
				$this->bindthird ( $user ['uid'], $_SESSION ['authinfo'] );
			}
			
			$this->user_model->refresh ( $user ['uid'], 1, $cookietime );
			$this->credit ( $user ['uid'], $this->setting ['credit1_login'], $this->setting ['credit2_login'] ); // 登录增加积分
			                                                                                                     // $questions = returnarraynum ( $this->db->query ( getwheresql ( 'question', 'authorid=' . $user ['uid'], $this->db->dbprefix ) )->row_array () );
			                                                                                                     // $answers = returnarraynum ( $this->db->query ( getwheresql ( 'answer', 'authorid=' . $user ['uid'], $this->db->dbprefix ) )->row_array () );
			                                                                                                     // $articles = returnarraynum ( $this->db->query ( getwheresql ( 'topic', 'authorid=' . $user ['uid'], $this->db->dbprefix ) )->row_array () );
			                                                                                                     // $attentions = $this->user_model->rownum_attention_question ( $user ['uid'] );
			                                                                                                     // $this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET articles=$articles,questions=$questions,answers=$answers,attentions=$attentions where uid=" . $user ['uid'] );
			
			exit ( 'login_ok' ); // 登录成功
		} else {
			if (isset ( $this->setting ['openfrontlogin'] )) {
				if (intval ( $this->setting ['openfrontlogin'] )) {
					if (isset ( $this->setting ['pwd_error_locktime'] )) {
						$min = intval ( $this->setting ['pwd_error_locktime'] );
					} else {
						$min = 30;
					}
					// 检查用户最近30分钟密码错误次数
					$res = $this->checkPassWrongTime ( $user ['uid'] );
					// 错误次数超过限制次数
					if ($res === false) {
						exit ( '你刚刚输错很多次密码，为了保证账户安全，系统已经将您账号锁定' . $min . '分钟' );
					}
					$this->recordPassWrongTime ( $user ['uid'], $user ['username'] );
					// 检查用户最近30分钟密码错误次数
					$res = $this->checkPassWrongTime ( $user ['uid'] );
					if (isset ( $this->setting ['pwd_error_num'] )) {
						$error_num = intval ( $this->setting ['pwd_error_num'] );
					} else {
						$error_num = 3;
					}
					
					// 错误次数超过限制次数
					if ($res === false) {
						exit ( '你刚刚输错很多次密码，为了保证账户安全，系统已经将您账号锁定' . $min . '分钟' );
					}
					
					exit ( "密码在错误" . ($error_num - $res) . "次后将被锁定" . $min . "分钟" ); // 用户名或者密码错误
				} else {
					exit ( "密码不正确，请重试" );
				}
			} else {
				exit ( "密码不正确，请重试" );
			}
		}
	}
	// 添加第三方绑定,新浪微博，qq
	function bindthird($uid, $auth) {
		$time = time ();
		$openid = $auth ['uid'];
		$token = $auth ['access_token'];
		$type = $auth ['type'];
		if ($type != 'weixin') {
			$datainsert = array (
					'uid' => $uid,
					'type' => $type,
					'token' => $token,
					'openid' => $openid,
					'time' => $time 
			);
			$this->db->insert ( 'login_auth', $datainsert );
		} else {
			$_opentmp_user = $this->user_model->get_by_wechatopenid ( $openid );
			
			if ($_opentmp_user) {
				exit ( '此微信已授权其它账号！' ); // 用户名或者密码错误
			}
			
			$datatmp = array (
					'wechatopenid' => $openid 
			);
			$this->db->where ( array (
					'uid' => intval ( $uid ) 
			) )->update ( 'user', $datatmp );
		}
		
		session_start ();
		$_SESSION ['authinfo'] = null;
		unset ( $_SESSION ['authinfo'] );
	}
	// ---------------------------绑定微信登录接口函数
	/*
	 *
	 *
	 * uname:用户名
	 *
	 * upwd:用户密码
	 */
	function bindloginapi() {
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		if (! strstr ( $useragent, 'MicroMessenger' )) {
			exit ( "只能微信里绑定哟，您就别费劲想耍花招了" );
		}
		$openid = trim ( $this->input->post ( 'openid' ) ); // openid
		$username = trim ( $this->input->post ( 'uname' ) ); // 用户名
		$registrationid = trim ( $this->input->post ( 'registrationid' ) ); // registrationid
		                                                                    // 判断是否包含特殊字符
		
		$password = md5 ( trim ( $this->input->post ( 'upwd' ) ) ); // 用户密码
		
		$this->checkdeepstring ( $username );
		
		$this->checkstring ( $password );
		if ('' == $username || '' == $password) {
			exit ( 'login_null' ); // 登录参数为空
		}
		
		// ucenter登录
		if ($this->setting ["ucenter_open"]) {
			$this->load->model ( 'ucenter_model' );
			$msg = $this->ucenter_model->ajaxlogin ( $username, $password );
			if ($msg == 'ok') {
				$user = $this->user_model->get_by_username ( $username );
				$cookietime = 2592000;
				
				$this->user_model->refresh ( $user ['uid'], 1, $cookietime );
				$this->credit ( $user ['uid'], $this->setting ['credit1_login'], $this->setting ['credit2_login'] ); // 登录增加积分
				$uid = $user ['uid'];
				
				$_opentmp_user = $this->user_model->get_by_openid ( $openid );
				
				if (! $_opentmp_user) {
					
					$datatmp = array (
							'openid' => $openid 
					);
					$this->db->where ( array (
							'uid' => $uid 
					) )->update ( 'user', $datatmp );
				}
				
				// 如果$registrationid不为空就绑定
				if ($registrationid) {
					
					$uid = $user ['uid'];
					$datatmp = array (
							'registrationid' => $registrationid 
					);
					$this->db->where ( array (
							'uid' => $uid 
					) )->update ( 'user', $datatmp );
				}
				exit ( 'login_ok' ); // 登录成功
			}
		}
		
		$user = $this->user_model->get_by_username ( $username );
		if (! $user) {
			exit ( "登录账号不存在" );
		}
		if (isset ( $this->setting ['openfrontlogin'] )) {
			if (intval ( $this->setting ['openfrontlogin'] )) {
				if (isset ( $this->setting ['pwd_error_locktime'] )) {
					$min = intval ( $this->setting ['pwd_error_locktime'] );
				} else {
					$min = 30;
				}
				// 检查用户最近30分钟密码错误次数
				$res = $this->checkPassWrongTime ( $user ['uid'] );
				// 错误次数超过限制次数
				if ($res === false) {
					exit ( '你刚刚输错很多次密码，为了保证账户安全，系统已经将您账号锁定' . $min . '分钟' );
				}
			}
		}
		$cookietime = 2592000;
		// 如果是来自dz导入的用户信息
		if (FROMUC) {
			$newpwd = md5 ( $password . $user ['salt'] );
		} else {
			$newpwd = $password;
		}
		if (is_array ( $user ) && ($newpwd == $user ['password'])) {
			if ($user ['isblack'] == 1) {
				exit ( '用户被列入网站黑名单!' ); // 登录参数为空
			}
			$uid = $user ['uid'];
			
			$this->user_model->refresh ( $uid, 1, $cookietime );
			$this->credit ( $user ['uid'], $this->setting ['credit1_login'], $this->setting ['credit2_login'] ); // 登录增加积分
			
			$_opentmp_user = $this->user_model->get_by_openid ( $openid );
			
			if (! $_opentmp_user) {
				$datatmp = array (
						'openid' => $openid 
				);
				$this->db->where ( array (
						'uid' => $uid 
				) )->update ( 'user', $datatmp );
			}
			
			// 如果$registrationid不为空就绑定
			if ($registrationid) {
				$uid = $user ['uid'];
				$datatmp = array (
						'registrationid' => $registrationid 
				);
				$this->db->where ( array (
						'uid' => $uid 
				) )->update ( 'user', $datatmp );
			}
			exit ( 'login_ok' ); // 登录成功
		} else {
			if (isset ( $this->setting ['openfrontlogin'] )) {
				if (intval ( $this->setting ['openfrontlogin'] )) {
					if (isset ( $this->setting ['pwd_error_locktime'] )) {
						$min = intval ( $this->setting ['pwd_error_locktime'] );
					} else {
						$min = 30;
					}
					// 检查用户最近30分钟密码错误次数
					$res = $this->checkPassWrongTime ( $user ['uid'] );
					// 错误次数超过限制次数
					if ($res === false) {
						exit ( '你刚刚输错很多次密码，为了保证账户安全，系统已经将您账号锁定' . $min . '分钟' );
					}
					$this->recordPassWrongTime ( $user ['uid'], $user ['username'] );
					// 检查用户最近30分钟密码错误次数
					$res = $this->checkPassWrongTime ( $user ['uid'] );
					if (isset ( $this->setting ['pwd_error_num'] )) {
						$error_num = intval ( $this->setting ['pwd_error_num'] );
					} else {
						$error_num = 3;
					}
					
					// 错误次数超过限制次数
					if ($res === false) {
						exit ( '你刚刚输错很多次密码，为了保证账户安全，系统已经将您账号锁定' . $min . '分钟' );
					}
					
					exit ( "密码在错误" . ($error_num - $res) . "次后将被锁定" . $min . "分钟" ); // 用户名或者密码错误
				} else {
					exit ( "密码不正确，请重试" );
				}
			} else {
				exit ( "密码不正确，请重试" );
			}
		}
	}
	// ---------------------------------登录退出接口函数
	function loginoutapi() {
		if (! isset ( $_SESSION )) {
			session_start ();
		}
		
		session_destroy (); // 清空以创建的所有SESSION
		$this->user_model->logout ();
		exit ( 'loginout_ok' ); // 退出成功
	}
	// --------------------------修改密码接口
	function editpwdapi() {
		global $user;
		$this->check_registerapikey (); // 判断是否为正确的http请求
		$uid = $user ['uid']; // 用户名
		                      // 判断是否包含特殊字符
		
		if ($uid == 0) {
			exit ( "请先登录" );
		}
		$newpwd = trim ( $this->input->post ( 'newpwd' ) ); // 用户密码
		$this->user_model->uppass ( $uid, trim ( $newpwd ) );
		exit ( 'editpwd_ok' );
	}
	/**
	 * 检查用户最近$min分钟密码错误次数
	 * $uid 用户ID
	 * $min 锁定时间
	 * $wTIme 错误次数
	 *
	 * @return 错误次数超过返回false,其他返回错误次数，提示用户
	 */
	function checkPassWrongTime($uid) {
		try {
			if (empty ( $uid )) {
				
				exit ( "找不到登录用户uid" );
			}
			if (isset ( $this->setting ['pwd_error_num'] )) {
				$wTime = intval ( $this->setting ['pwd_error_num'] );
			} else {
				$wTime = 3;
			}
			if (isset ( $this->setting ['pwd_error_locktime'] )) {
				$min = intval ( $this->setting ['pwd_error_locktime'] );
			} else {
				$min = 30;
			}
			$time = time ();
			$prevTime = time () - $min * 60;
			
			// 用户所在登录ip
			$ip = getip ();
			
			// pass_wrong_time_status代表用户输出了密码
			$sql = "select * from " . $this->db->dbprefix . "login_info where uid=$uid and pass_wrong_time_status=2 and logintime between $prevTime and $time and ip='$ip' ";
			$loginlist = $this->db->query ( $sql )->result_array ();
			
			// 统计错误次数
			$wrongTime = count ( $loginlist );
			
			// 判断错误次数是否超过限制次数
			if ($wrongTime >= $wTime) {
				return false;
			}
			
			return $wrongTime;
		} catch ( Exception $e ) {
		}
	}
	/**
	 *
	 * 记录密码输出信息
	 *
	 * @date: 2020年10月23日 下午4:15:22
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function recordPassWrongTime($uid, $username) {
		try {
			$ip = getip ();
			$useragent = $_SERVER ['HTTP_USER_AGENT'];
			$time = time ();
			$inserdata = array (
					'uid' => $uid,
					'username' => $username,
					'ip' => $ip,
					'useragent' => $useragent,
					'logintime' => $time,
					'pass_wrong_time_status' => 2 
			
			);
			$this->db->insert ( 'login_info', $inserdata );
		} catch ( Exception $e ) {
		}
	}
	
	// 检查特殊字符函数
	function checkstring($str) {
		if (preg_match ( "/[\'<>{}]|\]|\[|\/|\\\|\"|\|/", $str )) {
			exit ( '用户名或者密码不能包含特殊字符' ); // 参数不合法
		}
	}
	// 检查特殊字符函数
	function checkdeepstring($str) {
		if (preg_match ( "/[\',:;*?~`!#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/", $str )) {
			exit ( '用户名或者密码不能包含特殊字符' ); // 参数不合法
		}
	}
}

?>