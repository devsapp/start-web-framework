<?php
//error_reporting ( 0 );
function is_https()
{
	if ( ! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off')
	{
		return TRUE;
	}
	elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
	{
		return TRUE;
	}
	elseif ( ! empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off')
	{
		return TRUE;
	}
	
	return FALSE;
}
/**
 * qq登录模块实现
 */
define ( 'ASK2_ROOT', dirname ( dirname ( dirname ( __FILE__ ) ) ) . DIRECTORY_SEPARATOR );
define ( 'BASEPATH', ASK2_ROOT . 'system' );
if(is_https()){
	define ( 'SITE_URL', 'https://' . $_SERVER ['HTTP_HOST'] . '/' );
}else{
	define ( 'SITE_URL', 'http://' . $_SERVER ['HTTP_HOST'] . '/' );
}

require_once ("../../lib/db_mysqli.php");
require_once ("./API/qqConnectAPI.php");
include ASK2_ROOT . 'application' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'database.php';
$dbconfig = $db ['default'];
$db = new db ();
define ( 'DB_TABLEPRE', $dbconfig ['dbprefix'] );
$config = array ();
$config ['hostname'] = $dbconfig ['hostname'];
$config ['username'] = $dbconfig ['username'];
$config ['password'] = $dbconfig ['password'];
$config ['database'] = $dbconfig ['database'];
$config ['charset'] = $dbconfig ['char_set'];
$config ['autoconnect'] = 1;
$db->open ( $config );
$setting = require (ASK2_ROOT . 'data/cache/setting.php');

$qc = new QC ();
$token = $qc->qq_callback ();
$openid = $qc->get_openid ();
$qc = new QC ( $token, $openid );

if(isset($_SESSION)){
	
	if($_SESSION['loginuid']){
		
		$uid=$_SESSION['loginuid'];
		add_auth ( $token, $openid, $uid );
		
		header ( "Location:" . url('user/mycategory') );
		exit ();
	}
	
}
$user = get_by_openid ( $openid, $token );
$uid = $user ['uid'];
if ($user) {
	
	add_auth ( $token, $openid, $uid );
	refresh ( $user );
	if (! isset ( $_SESSION )) {
		session_start ();
	}
	if(isset($_SESSION ['forward'])){
		$forward=$_SESSION ['forward'];
		if(strstr($forward,'graph.qq.com')||strstr($forward,'user/getphonepass')||strstr($forward,'user/getpass')||strstr($forward,'user/logout')||strstr($forward,'user/checkemail')){
			$forward=SITE_URL;
		}
		header("Location:".$forward);
	}else{
		$forward = isset ( $_SERVER ['HTTP_REFERER'] ) ? $_SERVER ['HTTP_REFERER'] : SITE_URL;
		if(strstr($forward,'graph.qq.com')||strstr($forward,'user/getphonepass')||strstr($forward,'user/getpass')||strstr($forward,'user/logout')||strstr($forward,'user/checkemail')){
			$forward=SITE_URL;
		}
		header ( "Location:" . $forward );
	}
	
	exit ();
} else {
	
	if (! $setting ['allow_register']) {
		header ( "Content-Type: text/html;charset=utf-8" );
		exit ( "系统注册功能暂时处于关闭状态!" );
	}
	$userinfo = $qc->get_user_info ();
	
	if($setting['weixinregset']){
		$nickname = preg_replace_callback('/./u',function(array $match){
			return strlen($match[0]) >= 4 ? '' : $match[0];
		},$userinfo['nickname']);
			
			$nickname=trim($nickname);
			if(!empty($nickname)){
				$_username=addslashes($nickname);
				$tempusernickname=$db->fetch_first ( "SELECT * FROM " . DB_TABLEPRE . "user WHERE username='$_username'" );
				
			}
			
			$gender=0;
			if($userinfo ['gender']=='女'){
				$gender=1;
			}
			
			$hduid=add_user(addslashes($nickname),md5(strtolower(rand(10000000,12000000))),$gender,addslashes($token),addslashes($openid));
			if(empty($nickname)){
				$nickname="用户".$hduid;
				$db->query ( "UPDATE " . DB_TABLEPRE . "user SET `username`='$nickname'  WHERE `uid`=$hduid" );
				
			}
			if($tempusernickname){
				$nickname=$nickname.$hduid;
				$db->query ( "UPDATE " . DB_TABLEPRE . "user SET `username`='$nickname'  WHERE `uid`=$hduid" );
				
			}
			$user = get_by_openid ( $openid, $token );
			$uid = $user ['uid'];
			if ($user) {
				add_auth ( $token, $openid, $uid );
				refresh ( $user );
				//生成头像
				//figureurl_qq_2
				$hduid = intval ( $hduid );
				
				$avatardir = "/data/avatar/";
				$extname = 'jpg';
				$upload_tmp_file = ASK2_ROOT . '/data/tmp/user_avatar_' . $hduid . '.' . $extname;
				$hduid = abs ( $hduid );
				$hduid = sprintf ( "%09d", $hduid );
				$dir1 = $avatardir . substr ( $hduid, 0, 3 );
				$dir2 = $dir1 . '/' . substr ( $hduid, 3, 2 );
				$dir3 = $dir2 . '/' . substr ( $hduid, 5, 2 );
				(! is_dir ( ASK2_ROOT . $dir1 )) && forcemkdir ( ASK2_ROOT . $dir1 );
				(! is_dir ( ASK2_ROOT . $dir2 )) && forcemkdir ( ASK2_ROOT . $dir2 );
				(! is_dir ( ASK2_ROOT . $dir3 )) && forcemkdir ( ASK2_ROOT . $dir3 );
				
				$smallimg = $dir3 . "/small_" . $hduid . '.' . $extname;
				$smallimgdir = $dir3 . "/";
				getImage($userinfo['figureurl_qq_2'],"small_" . $hduid . '.' . $extname, ASK2_ROOT . $smallimgdir, array('jpg','jpeg','png', 'gif'));
				if (! isset ( $_SESSION )) {
					session_start ();
				}
				if(isset($_SESSION ['forward'])){
					$forward=$_SESSION ['forward'];
					if(strstr($forward,'graph.qq.com')||strstr($forward,'user/getphonepass')||strstr($forward,'user/getpass')||strstr($forward,'user/logout')||strstr($forward,'user/checkemail')){
						$forward=SITE_URL;
					}
					header("Location:".$forward);
				}else{
					$forward = isset ( $_SERVER ['HTTP_REFERER'] ) ? $_SERVER ['HTTP_REFERER'] : SITE_URL;
					if(strstr($forward,'graph.qq.com')||strstr($forward,'user/getphonepass')||strstr($forward,'user/getpass')||strstr($forward,'user/logout')||strstr($forward,'user/checkemail')){
						$forward=SITE_URL;
					}
					header ( "Location:" . $forward );
				}
				
				exit ();
			}else{
				exit("账号授权失败");
			}
			
	}else{
		
		$token_arr ['access_token'] = $token;
		$token_arr ['uid'] = $openid;
		$token_arr ['username'] = $userinfo ['nickname'];
		$token_arr ['gender'] = $userinfo ['gender'];
		$token_arr ['type'] = 'qq';
		$token_arr ['profile_image_url'] = $userinfo ['figureurl_qq_2'];
		$token_arr ['qqlogin_avatar'] = $userinfo ['qqlogin_avatar'];
		unset($_SESSION ['authinfo']);
		$_SESSION ['authinfo'] = $token_arr;
		
		header ( "Location:" . url ( 'user/login' ) . "?oauth_provider=QQProvider&code=" . time() );
		exit ();
	}
	
}
function url($var, $url = '') {
	global $setting;
	// exit($var);
	$location = '?' . $var . $setting ['seo_suffix'];
	if ((false === strpos ( $var, 'admin_' )) && $setting ['seo_on']) {
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		
		if (! strstr ( $useragent, 'MicroMessenger' )) {
			$location = $var . $setting ['seo_suffix'];
		}
		
	}
	return SITE_URL . $location; //程序动态获取的，给question的model使用
	
	
}
function get_remote_image($url, $savepath) {
	ob_start ();
	readfile ( $url );
	$img = ob_get_contents ();
	ob_end_clean ();
	$size = strlen ( $img );
	$fp2 = @fopen ( $savepath, "a" );
	fwrite ( $fp2, $img );
	fclose ( $fp2 );
	return $savepath;
}
function taddslashes($string, $force = 0) {
	if ($force) {
		if (is_array ( $string )) {
			foreach ( $string as $key => $val ) {
				$string [$key] = taddslashes ( $val, $force );
			}
		} else {
			$string = addslashes ( $string );
		}
	}
	return $string;
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
/* cookie设置和读取 */

function tcookie($var, $value = 0, $life = 0) {
	global $setting;
	if ($life > 36000) {
		$life = 1800;
	}
	$cookiepre = 'whatsns';
	if (0 === $value) {
		$ret = isset ( $_COOKIE [$cookiepre . $var] ) ? $_COOKIE [$cookiepre . $var] : '';
		checkattack ( $var, 'cookie' );
		return $ret;
	} else {
		$domain = $setting ['cookie_domain'] ? $setting ['cookie_domain'] : '';
		checkattack ( $var, 'cookie' );
		setcookie ( $cookiepre . $var, $value, $life ? time () + $life : 0, '/', $domain, $_SERVER ['SERVER_PORT'] == 443 ? 1 : 0 );
	}
}
function getImage($url, $filename = '', $dirName, $fileType, $type = 0) {
	if ($url == '') {
		return false;
	}
	//获取文件原文件名
	$defaultFileName = basename ( $url );
	
	
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	$file = curl_exec($ch);
	curl_close($ch);
	
	if (! file_exists ( $dirName )) {
		mkdir ( $dirName, 0777, true );
	}
	
	
	$resource = fopen($dirName . $filename, 'a');
	fwrite($resource, $file);
	fclose($resource);
	
}
/* XSS 检测 */

function checkattack($reqarr, $reqtype = 'post') {
	$filtertable = array ('get' => 'sleep\s*?\(.*\)|\'|(and|or)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)', 'post' => 'sleep\s*?\(.*\)|\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)', 'cookie' => 'sleep\s*?\(.*\)|\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)' );
	if (is_array ( $reqarr ) && ! empty ( $reqarr )) {
		foreach ( $reqarr as $reqkey => $reqvalue ) {
			
			if (is_array ( $reqvalue )) {
				
				checkattack ( $reqvalue, $reqtype );
			}
			
			if (preg_match ( "/" . $filtertable [$reqtype] . "/is", $reqvalue ) == 1 && ! in_array ( $reqkey, array ('content' ) )) {
				print ('Illegal operation!') ;
				exit ( - 1 );
			}
			
		}
	}
	
}
/**
 * getip
 * @return string
 */
function getip() {
	$ip = $_SERVER ['REMOTE_ADDR'];
	if (isset ( $_SERVER ['HTTP_CLIENT_IP'] ) && preg_match ( '/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER ['HTTP_CLIENT_IP'] )) {
		$ip = $_SERVER ['HTTP_CLIENT_IP'];
	} elseif (isset ( $_SERVER ['HTTP_X_FORWARDED_FOR'] ) and preg_match_all ( '#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER ['HTTP_X_FORWARDED_FOR'], $matches )) {
		foreach ( $matches [0] as $xip ) {
			if (! preg_match ( '#^(10|172\.16|192\.168)\.#', $xip )) {
				$ip = $xip;
				break;
			}
		}
	}
	return $ip;
}
function get_user($uid) {
	global $db;
	return $db->fetch_first ( "SELECT * FROM " . DB_TABLEPRE . "user WHERE uid='$uid'" );
}

function get_by_openid($openid, $token = 0) {
	global $db;
	return $db->fetch_first ( "SELECT * FROM " . DB_TABLEPRE . "user AS u," . DB_TABLEPRE . "login_auth as la WHERE u.uid=la.uid AND la.openid='$openid' " );
}

function get_by_username($username) {
	global $db;
	return $db->fetch_first ( "SELECT * FROM " . DB_TABLEPRE . "user WHERE username='$username'" );
}

function get_last_username($username) {
	global $db;
	return $db->fetch_first ( "SELECT * FROM " . DB_TABLEPRE . "user WHERE username LIKE '$username%' ORDER BY uid DESC" );
}

function add_user($username, $password, $gender, $token, $openid) {
	global $db, $setting;
	$password = md5 ( $password );
	$time = time ();
	$db->query ( "INSERT INTO " . DB_TABLEPRE . "user(username,password,email,gender,regip,regtime,`lastlogin`) values ('$username','$password','null',$gender,'" . getip () . "',$time,$time)" );
	$uid = $db->insert_id ();
	$db->query ( "INSERT INTO " . DB_TABLEPRE . "login_auth(uid,type,token,openid,time) values ($uid,'qq','$token','$openid',$time)" );
	$credit1 = $setting ['credit1_register'];
	$credit2 = $setting ['credit2_register'];
	$db->query ( "INSERT INTO " . DB_TABLEPRE . "credit(uid,time,operation,credit1,credit2) VALUES ($uid,$time,'plugin/qqlogin',$credit1,$credit2) " );
	$db->query ( "UPDATE " . DB_TABLEPRE . "user SET credit2=credit2+$credit2,credit1=credit1+$credit1 WHERE uid=$uid " );
	$reginfo="欢迎您注册了".$setting ['site_name'];
	
	$db->query ( "INSERT INTO " . DB_TABLEPRE . "doing(authorid,author,action,questionid,content,createtime) VALUES ($uid,'$username',12,$uid,'$reginfo',$time) " );
	
	return $uid;
}

function add_auth($token, $openid, $uid) {
	global $db;
	$time = time ();
	$db->query ( "REPLACE INTO " . DB_TABLEPRE . "login_auth(uid,type,token,openid,time) values ($uid,'qq','$token','$openid',$time)" );
}

function remove_auth($openid) {
	global $db;
	$db->query ( "DELETE FROM " . DB_TABLEPRE . "login_auth WHERE openid='$openid'" );
}

function refresh($user) {
	global $db, $setting;
	$uid = $user ['uid'];
	$password = $user ['password'];
	$time = time ();
	
	$db->query ( "UPDATE " . DB_TABLEPRE . "user SET `lastlogin`=$time  WHERE `uid`=$uid" ); //更新最后登录时间
	if(!$_SESSION){
		session_start();
	}
	$_SESSION['loginuid']=$uid;
	$_SESSION['loginpassword']=$password;
	
}

?>
