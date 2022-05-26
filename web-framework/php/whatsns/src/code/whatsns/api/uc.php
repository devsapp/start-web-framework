<?php
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'production');
define('FC_PATH',  dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR);
define ( 'BASEPATH', FC_PATH.'system' );
define('IN_ASK2', TRUE);
define('UC_CLIENT_VERSION', '1.6.0');//note UCenter 版本标识
define('UC_CLIENT_RELEASE', '20110501');

define('API_DELETEUSER', 1);		//note 用户删除 API 接口开关
define('API_RENAMEUSER', 1);		//note 用户改名 API 接口开关
define('API_GETTAG', 1);		//note 获取标签 API 接口开关
define('API_SYNLOGIN', 1);		//note 同步登录 API 接口开关
define('API_SYNLOGOUT', 1);		//note 同步登出 API 接口开关
define('API_UPDATEPW', 1);		//note 更改用户密码 开关
define('API_UPDATEBADWORDS', 1);	//note 更新关键字列表 开关
define('API_UPDATEHOSTS', 1);		//note 更新域名解析缓存 开关
define('API_UPDATEAPPS', 1);		//note 更新应用列表 开关
define('API_UPDATECLIENT', 1);		//note 更新客户端缓存 开关
define('API_UPDATECREDIT', 1);		//note 更新用户积分 开关
define('API_GETCREDITSETTINGS', 1);	//note 向 UCenter 提供积分设置 开关
define('API_GETCREDIT', 1);		//note 获取用户的某项积分 开关
define('API_UPDATECREDITSETTINGS', 1);	//note 更新应用积分设置 开关

define('API_RETURN_SUCCEED', '1');
define('API_RETURN_FAILED', '-1');
define('API_RETURN_FORBIDDEN', '-2');

define('ASK2_ROOT', substr(dirname(__FILE__), 0, -4));

//note 普通的 http 通知方式
if(!defined('IN_UC')) {

	error_reporting(0);
	require_once ASK2_ROOT.'/application'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'database.php';
	require_once ASK2_ROOT.'/data/ucconfig.inc.php';

	$get = $post = array();

	$code = @$_GET['code'];
	parse_str(_authcode($code, 'DECODE', UC_KEY), $get);


	$timestamp = time();
	if($timestamp - $get['time'] > 3600) {
		exit('Authracation has expiried');
	}
if(empty($get)) {
		exit('Invalid Request');
	}
	$action = $get['action'];

	require_once ASK2_ROOT.'/uc_client/lib/xml.class.php';
	$post = xml_unserialize(file_get_contents('php://input'));

	if(in_array($get['action'], array('test', 'deleteuser', 'renameuser', 'gettag', 'synlogin', 'synlogout', 'updatepw', 'updatebadwords', 'updatehosts', 'updateapps', 'updateclient', 'updatecredit', 'getcreditsettings', 'updatecreditsettings'))) {
		require_once ASK2_ROOT.'/lib/db_mysqli.php';
		 $dbconfig=$db['default'];
		$db = new db ();
		define('DB_TABLEPRE',$dbconfig['dbprefix']);
		$config = array ();
		$config ['hostname'] = $dbconfig['hostname'];
		$config ['username'] =$dbconfig['username'];
		$config ['password'] =$dbconfig['password'];
		$config ['database'] = $dbconfig['database'];
		$config ['charset'] =  $dbconfig['char_set'];
		$config ['autoconnect'] = 1;
		$config ['dbport'] = 3306;
		$config ['debug'] = true;
		$db->open ( $config );
		$GLOBALS['db']=$db;
		$GLOBALS['tablepre'] = DB_TABLEPRE;
		$setting = require (ASK2_ROOT.'/data/cache/setting.php');
		$uc_note = new uc_note();
		$nameaction=$get['action'];
		exit($uc_note->$nameaction($get, $post));

	} else {
		exit(API_RETURN_FAILED);
	}

//note include 通知方式
} else {

	require_once ASK2_ROOT.'/application'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'database.php';
	require_once ASK2_ROOT.'/data/ucconfig.inc.php';
		require_once ASK2_ROOT.'/lib/db_mysqli.php';
		 $dbconfig=$db['default'];
		$db = new db ();
		define('DB_TABLEPRE',$dbconfig['dbprefix']);
		$config = array ();
		$config ['hostname'] = $dbconfig['hostname'];
		$config ['username'] =$dbconfig['username'];
		$config ['password'] =$dbconfig['password'];
		$config ['database'] = $dbconfig['database'];
		$config ['charset'] =  $dbconfig['char_set'];
		$config ['autoconnect'] = 1;
		$config ['dbport'] = 3306;
		$config ['debug'] = true;
		$db->open ( $config );
		$GLOBALS['db']=$db;
		$GLOBALS['tablepre'] = DB_TABLEPRE;
		$setting = require (ASK2_ROOT.'/data/cache/setting.php');

}

class uc_note {

	var $dbconfig = '';
	var $db = '';
	var $tablepre = '';
	var $appdir = '';

	function _serialize($arr, $htmlon = 0) {
		if(!function_exists('xml_serialize')) {
			include_once ASK2_ROOT.'/uc_client/lib/xml.class.php';
		}
		return xml_serialize($arr, $htmlon);
	}

	function __construct() {
		$this->appdir = substr(dirname(__FILE__), 0, -4);
		//$this->dbconfig = $this->appdir.'/config.php';
		$this->dbconfig = $this->appdir.'/application'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'database.php';
		$this->db = $GLOBALS['db'];
		$this->tablepre = $GLOBALS['tablepre'];
	}

	function test($get, $post) {
		return API_RETURN_SUCCEED;
	}

	function deleteuser($get, $post) {
		$uids = $get['ids'];
		!API_DELETEUSER && exit(API_RETURN_FORBIDDEN);

		return API_RETURN_SUCCEED;
	}

	function renameuser($get, $post) {
		$uid = $get['uid'];
		$usernameold = $get['oldusername'];
		$usernamenew = $get['newusername'];
		if(!API_RENAMEUSER) {
			return API_RETURN_FORBIDDEN;
		}

		return API_RETURN_SUCCEED;
	}

	function gettag($get, $post) {
		$name = $get['id'];
		if(!API_GETTAG) {
			return API_RETURN_FORBIDDEN;
		}

		$return = array();
		return $this->_serialize($return, 1);
	}

	function synlogin($get, $post) {
		global $db, $setting;
		$uid = $get['uid'];
		$username = $get['username'];
		if(!API_SYNLOGIN) {
			return API_RETURN_FORBIDDEN;
		}
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		$member = $db->fetch_first("select * from ".DB_TABLEPRE."user  where username='$username'");
		if(is_array($member)){
			$auth = authcode("$uid\t".$member['password'],'ENCODE');
			tcookie('auth', $auth, 31536000);
		}else{
			tcookie('loginuser', $username, $cookietime);
		}
	}

	function synlogout($get, $post) {
		if(!API_SYNLOGOUT) {
			return API_RETURN_FORBIDDEN;
		}
		//note 同步登出 API 接口
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		tcookie('sid','',0);
		tcookie('auth','',0);
	}

	function updatepw($get, $post) {
                global $db;
		if(!API_UPDATEPW) {
			return API_RETURN_FORBIDDEN;
		}
		$username = $get['username'];
		$password = $get['password'];
       $db->query("UPDATE ".DB_TABLEPRE."user SET password='$password' WHERE username='$username");
		return API_RETURN_SUCCEED;
	}

	function updatebadwords($get, $post) {
		if(!API_UPDATEBADWORDS) {
			return API_RETURN_FORBIDDEN;
		}
		$cachefile = $this->appdir.'/uc_client/data/cache/badwords.php';
		$fp = fopen($cachefile, 'w');
		$data = array();
		if(is_array($post)) {
			foreach($post as $k => $v) {
				$data['findpattern'][$k] = $v['findpattern'];
				$data['replace'][$k] = $v['replacement'];
			}
		}
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'badwords\'] = '.var_export($data, TRUE).";\r\n";
		fwrite($fp, $s);
		fclose($fp);
		return API_RETURN_SUCCEED;
	}

	function updatehosts($get, $post) {
		if(!API_UPDATEHOSTS) {
			return API_RETURN_FORBIDDEN;
		}
		$cachefile = $this->appdir.'/uc_client/data/cache/hosts.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'hosts\'] = '.var_export($post, TRUE).";\r\n";
		fwrite($fp, $s);
		fclose($fp);
		return API_RETURN_SUCCEED;
	}

	function updateapps($get, $post) {
		if(!API_UPDATEAPPS) {
			return API_RETURN_FORBIDDEN;
		}
		$UC_API = $post['UC_API'];

		//note 写 app 缓存文件
		$cachefile = $this->appdir.'/uc_client/data/cache/apps.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'apps\'] = '.var_export($post, TRUE).";\r\n";
		fwrite($fp, $s);
		fclose($fp);

		//note 写配置文件
		if(is_writeable($this->appdir.'/config.inc.php')) {
			$configfile = trim(file_get_contents($this->appdir.'/config.inc.php'));
			$configfile = substr($configfile, -2) == '?>' ? substr($configfile, 0, -2) : $configfile;
			$configfile = preg_replace("/define\('UC_API',\s*'.*?'\);/i", "define('UC_API', '$UC_API');", $configfile);
			if($fp = @fopen($this->appdir.'/config.inc.php', 'w')) {
				@fwrite($fp, trim($configfile));
				@fclose($fp);
			}
		}

		return API_RETURN_SUCCEED;
	}

	function updateclient($get, $post) {
		if(!API_UPDATECLIENT) {
			return API_RETURN_FORBIDDEN;
		}
		$cachefile = $this->appdir.'/uc_client/data/cache/settings.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'settings\'] = '.var_export($post, TRUE).";\r\n";
		fwrite($fp, $s);
		fclose($fp);
		return API_RETURN_SUCCEED;
	}

	function updatecredit($get, $post) {
		if(!API_UPDATECREDIT) {
			return API_RETURN_FORBIDDEN;
		}
		$credit = $get['credit'];
		$creditfield = 'credit'.$get['credit'];
		$amount = $get['amount'];
		$uid = $get['uid'];
		if(!$this->db->result_first("SELECT count(*) FROM ".$this->tablepre."user WHERE uid='$uid'")) {
			return 0;
		}
		$this->db->query("UPDATE ".$this->tablepre."user SET $creditfield = $creditfield + $amount WHERE uid='$uid'");
		$credit1=$credit2=0;
		if(1==$credit){
			$credit1=$amount;
		}else{
			$credit2=$amount;
		}
		$this->db->query("INSERT INTO ".$this->tablepre."credit(uid,time,operation,credit1,credit2) VALUES ($uid,$timestamp,'othersystem',$credit1,$credit2) ");
		return API_RETURN_SUCCEED;
	}

	function getcredit($get, $post) {
		if(!API_GETCREDIT) {
			return API_RETURN_FORBIDDEN;
		}
		$uid = intval($get['uid']);
		$credit = intval($get['credit']);
		$creditfield = 'credit'.$get['credit'];
		return $credit >= 1 && $credit <= 2 ? $this->db->result_first("SELECT $creditfield FROM ".$this->tablepre."user WHERE uid='$uid'") : 0;
	}

	function getcreditsettings($get, $post) {
		if(!API_GETCREDITSETTINGS) {
			return API_RETURN_FORBIDDEN;
		}
		$credits=array(
	        '1' => array('经验', '点'),
	        '2' => array('财富', '元'),
		);
		return $this->_serialize($credits);
	}

	function updatecreditsettings($get, $post) {
		global $cache;
		if(!API_UPDATECREDITSETTINGS) {
			return API_RETURN_FORBIDDEN;
		}
		$outextcredits = array();
		foreach($get['credit'] as $appid => $credititems) {
			if($appid == UC_APPID) {
				foreach($credititems as $value) {
					$outextcredits[] = array(
						'appiddesc' => $value['appiddesc'],
						'creditdesc' => $value['creditdesc'],
						'creditsrc' => $value['creditsrc'],
						'title' => $value['title'],
						'unit' => $value['unit'],
						'ratio' => $value['ratio']
					);
				}
			}
		}
                file_put_contents('credit.txt', addslashes(serialize($outextcredits)));
		$this->db->query("REPLACE INTO ".$this->tablepre."setting (k, v) VALUES ('outextcredits', '".addslashes(serialize($outextcredits))."');", 'UNBUFFERED');
		$cache->remove('setting');
		return API_RETURN_SUCCEED;
	}

}



/* 通用php加解密函数 */

function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	global $setting;
	$ckey_length = 4;
	$key = md5 ( $key ? $key : $setting ['auth_key'] );
	$keya = md5 ( substr ( $key, 0, 16 ) );
	$keyb = md5 ( substr ( $key, 16, 16 ) );
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr ( $string, 0, $ckey_length ) : substr ( md5 ( microtime () ), - $ckey_length )) : '';

	$cryptkey = $keya . md5 ( $keya . $keyc );
	$key_length = strlen ( $cryptkey );

	$string = $operation == 'DECODE' ? base64_decode ( substr ( $string, $ckey_length ) ) : sprintf ( '%010d', $expiry ? $expiry + time () : 0 ) . substr ( md5 ( $string . $keyb ), 0, 16 ) . $string;
	$string_length = strlen ( $string );

	$result = '';
	$box = range ( 0, 255 );

	$rndkey = array ();
	for($i = 0; $i <= 255; $i ++) {
		$rndkey [$i] = ord ( $cryptkey [$i % $key_length] );
	}

	for($j = $i = 0; $i < 256; $i ++) {
		$j = ($j + $box [$i] + $rndkey [$i]) % 256;
		$tmp = $box [$i];
		$box [$i] = $box [$j];
		$box [$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i ++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box [$a]) % 256;
		$tmp = $box [$a];
		$box [$a] = $box [$j];
		$box [$j] = $tmp;
		$result .= chr ( ord ( $string [$i] ) ^ ($box [($box [$a] + $box [$j]) % 256]) );
	}

	if ($operation == 'DECODE') {
		if ((substr ( $result, 0, 10 ) == 0 || substr ( $result, 0, 10 ) - time () > 0) && substr ( $result, 10, 16 ) == substr ( md5 ( substr ( $result, 26 ) . $keyb ), 0, 16 )) {
			return substr ( $result, 26 );
		} else {
			return '';
		}
	} else {
		return $keyc . str_replace ( '=', '', base64_encode ( $result ) );
	}
}
function _authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;

	$key = md5($key ? $key : UC_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
				return '';
			}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}

}
/* cookie设置和读取 */

function tcookie($var, $value = 0, $life = 0) {
	global $setting;
	if ($life > 36000) {
		$life = 1800;
	}
	$cookiepre = 'whatsns';
	if (0 === $value) {
		$ret = isset ( $_COOKIE [$cookiepre . $var] ) ? $_COOKIE [$cookiepre . $var] : '';
		
		return $ret;
	} else {
		$domain = $setting ['cookie_domain'] ? $setting ['cookie_domain'] : '';
		
		setcookie ( $cookiepre . $var, $value, $life ? time () + $life : 0, '/', $domain, $_SERVER ['SERVER_PORT'] == 443 ? 1 : 0 );
	}
}
function _stripslashes($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = _stripslashes($val);
		}
	} else {
		$string = stripslashes($string);
	}
	return $string;
}
