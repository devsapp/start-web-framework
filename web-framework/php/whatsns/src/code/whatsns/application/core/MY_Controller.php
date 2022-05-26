<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
header ( "Access-Control-Allow-Origin: *" ); // 合法请求域名--可改成实际允许的接口域名地址
header ( "Access-Control-Allow-Headers: Content-Type" );
header ( 'Access-Control-Allow-Methods: GET, POST, PUT,DELETE' );
defined ( 'APP_SECRET' ) or define ( 'APP_SECRET', '21b4b3307249dd9782850f55a5fbee0d' ); // accesstoken加密秘钥
defined ( 'ACCESSTOKEN_EXPIRETIME' ) or define ( 'ACCESSTOKEN_EXPIRETIME', 72 ); // accesstoken过期时间 ，单位小时
defined ( 'SESSTION_EXPIRETIME' ) or define ( 'SESSTION_EXPIRETIME', 10 ); // 会话过期时间 ，单位分钟，多久时间不操作自动过期
defined ( 'CODE_EXPIRETIME' ) or define ( 'CODE_EXPIRETIME', 1 ); // 验证码过期时间 ，单位分钟，多久时间不操作自动过期
class MY_Controller extends CI_Controller {
	var $whitelist;
	function __construct() {
		parent::__construct ();
	}
}
class ADMIN_Controller extends MY_Controller {
	var $whitelist;
	function __construct() {
		parent::__construct ();
		if ($this->user ['groupid'] != 1 && $this->user ['groupid'] != 2 && $this->user ['groupid'] != 3) {
			$this->message ( "您无权限访问后台" );
			exit ();
		}
		// 增加后台登录日志
		$this->addloginlog ();
	}
	/**
	 *
	 * 增加登录日志
	 *
	 * @date: 2020年10月20日 下午4:17:34
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function addloginlog() {
		$hasloginlogtable = $this->db->query ( "SELECT table_name FROM information_schema.TABLES WHERE table_name ='" . $this->db->dbprefix . "loginlog';" )->row_array ();
		if (! $hasloginlogtable) {
			// 如果不存在就创建
			// 增加 登录日志表
			$sql = "CREATE TABLE `" . $this->db->dbprefix . "loginlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL DEFAULT '' COMMENT '用户名',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户uid',
  `firstlogintime` int(11) NOT NULL DEFAULT '0' COMMENT '开始登录时间戳',
  `lastlogintime` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `loginip` varchar(255) NOT NULL DEFAULT '' COMMENT '登录ip',
  `logindate` varchar(50) NOT NULL DEFAULT '' COMMENT '登录日期',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) COMMENT 'uid',
  KEY `logindate` (`logindate`) COMMENT 'logindate',
  KEY `uidandlogindate` (`uid`,`logindate`) COMMENT 'uidandlogindate',
  KEY `loginipanduidandlogindate` (`uid`,`loginip`(191),`logindate`) COMMENT 'loginipanduidandlogindate'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='登录日志';
";
			$this->db->query ( $sql );
		}
		// 根据后台登录人uid,登录ip，logindate登录日期确定是否是新增还是更新最后登录时间
		$data = array (
				'uid' => $this->user ['uid'],
				'logindate' => date ( 'Y-m-d' ),
				'loginip' => getip () 
		);
		$userlogin = $this->db->get_where ( 'loginlog', $data )->row_array ();
		if ($userlogin) {
			// 如果存在就更新
			$this->db->where ( $data )->update ( 'loginlog', array (
					'lastlogintime' => time () 
			) );
		} else {
			
			$insertdata = array (
					'firstlogintime' => time (),
					'lastlogintime' => time (),
					'username' => $this->user ['username'],
					'uid' => $this->user ['uid'],
					'logindate' => date ( 'Y-m-d' ),
					'loginip' => getip () 
			);
			// 如果不存在就插入
			$this->db->insert ( 'loginlog', $insertdata );
			$openid = $this->user ['openid'];
			
			if ($openid) {
				if (file_exists ( FCPATH . 'lib' . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . "access_token.php" )) {
					unlink ( FCPATH . 'lib' . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . "access_token.php" );
				}				
				$this->load->model ( 'weixin_setting_model' );
				
				$wx = $this->weixin_setting_model->get ();
				
				// 发送微信登录通知
				$setting = $this->setting;
				require FCPATH . 'lib' . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'jssdk.php';
				$appid = $wx ['appid'];
				$appsecret = $wx ['appsecret'];
				
				$weixin = new JSSDK ( $appid, $appsecret );
				
				$first = $this->user ['username'] . ",您已成功登录-" . $setting ['site_name'] . "！";
				$keynote1 = date ( 'Y-m-d H:i:s', time () );
				$keynote2 = getip ();
				$remark = "提示：如果本次登录不是您本人所为，说明您的帐号已经被盗！";
				$templateid = $setting ['weixin_tpl_loginid'];
				
				// 发送登录信息
				$data = '
 {
            "touser":"' . $openid . '",
           "template_id":"' . $templateid . '",
           "miniprogram":{
             "appid":"",
             "pagepath":""
           },
           "data":{
                   "first": {
                       "value":"' . $first . '",
                       "color":"#bc723c"
                   },
                   "keyword1":{
                       "value":"' . $keynote1 . '"
                       		
                   },
                   "keyword2": {
                       "value":"' . $keynote2 . '"
                       		
                   },
                       		
                   "remark":{
                       "value":"' . $remark . '",
                       "color":"#173177"
                   }
           }
       }
';
				
				$accessToken = $weixin->getAccessToken ();
				
				$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $accessToken;
				$result = $weixin->https_request ( $url, $data );
			}
		}
	}
}
class APP_Controller extends MY_Controller {
	var $whitelist;
	var $showquestion = 1;
	var $showanswer = 1;
	var $showpostanswer = 1;
	var $showarticle = 1;
	var $showarticlecomment = 1;
	function __construct() {
		parent::__construct ();
	}
	/**
	 *
	 * //校验token
	 * //检查accesstoken是否过期
	 *
	 * @date: 2018年8月22日 下午3:59:36
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	public function check_token($accesstoken) {
		if ($accesstoken) {
			
			try {
				$accesstoken = decode ( $accesstoken, APP_SECRET ); // 解码accesstoken
				$user = unserialize ( $accesstoken );
			} catch ( Exception $e ) {
				$message ['code'] = 2088;
				$message ['message'] = '会话过期，重新登录';
				echo json_encode ( $message );
				exit ();
			}
			
			// 获取用户的uid
			$uid = trim ( $user ['uid'] );
			$username = $user ['username'];
			// $item = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user WHERE username='$username'" )->row_array ();
			// $uid = trim($item ['uid']);
			// 先判断是否存在用户登录文件
			$userfile = FCPATH . '/data/userlogin/' . $uid . '.php';
			if (! file_exists ( $userfile )) {
				$message ['code'] = 2088;
				$message ['message'] = '会话过期，重新登录';
				echo json_encode ( $message );
				exit ();
			}
			$user = $this->returnuser ( $userfile );
			$user ['uid'] = $uid;
			if (($user ['expire'] - time ()) <= 0) {
				unlink ( $userfile );
				$message ['code'] = 2088;
				$message ['message'] = '会话过期，' . '重新登录';
				echo json_encode ( $message );
				exit ();
			}
			// 判断两次操作时间间隔
			// if ((time () - $user ['operationtime']) > SESSTION_EXPIRETIME * 60) {
			//
			// echo 'error|太久没操作了，重新登录';
			// unlink($userfile);
			// exit ();
			// }
			/*
			 * $user ['operationtime'] = time (); //当前操作时间
			 * $accesstoken = encode ( serialize ( $user ), APP_SECRET );
			 * $strdata = "<?php\nreturn " . var_export ( $user, true ) . ";\n?>";
			 * $filesave = FCPATH . 'data/userlogin/' . $user ['uid'] . '.php';
			 * if (file_exists ( $filesave )) {
			 * unlink ( $filesave );
			 * }
			 * writetofile ( $filesave, $strdata );
			 */
			return $user;
		} else {
			$message ['code'] = "201";
			$message ['message'] = '权限验证失败';
			echo json_encode ( $message );
			exit ();
		}
	}
	public function returnuser($file) {
		return @include $file;
	}
	// 检查特殊字符函数
	public function checkstring($str) {
		if (preg_match ( "/[\'<>{}]|\]|\[|\/|\\\|\"|\|/", $str )) {
			$message ['code'] = "201";
			$message ['message'] = '用户名或者密码不能包含特殊字符';
			echo json_encode ( $message );
			exit ();
		}
	}
	// 检查特殊字符函数
	function checkdeepstring($str) {
		if (preg_match ( "/[\',:;*?~`!#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/", $str )) {
			$message ['code'] = "201";
			$message ['message'] = '用户名或者密码不能包含特殊字符';
			echo json_encode ( $message );
			exit ();
		}
	}
}