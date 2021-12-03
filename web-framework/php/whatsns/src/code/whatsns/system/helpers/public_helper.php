<?php
require_once FCPATH . 'lib/aliyunsmssdk/vendor/autoload.php';
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
/**
 * 请求接口返回内容
 *
 * @param string $url
 *        	[请求的URL地址]
 * @param string $params
 *        	[请求的参数]
 * @param int $ipost
 *        	[是否采用POST形式]
 * @return string
 */
function juhecurl($url, $params = false, $ispost = 0) {
	$httpInfo = array ();
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );
	curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
	curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 30 );
	curl_setopt ( $ch, CURLOPT_TIMEOUT, 30 );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
	if ($ispost) {
		curl_setopt ( $ch, CURLOPT_POST, true );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $params );
		curl_setopt ( $ch, CURLOPT_URL, $url );
	} else {
		if ($params) {
			curl_setopt ( $ch, CURLOPT_URL, $url . '?' . $params );
		} else {
			curl_setopt ( $ch, CURLOPT_URL, $url );
		}
	}
	$response = curl_exec ( $ch );
	if ($response === FALSE) { // echo "cURL Error: " . curl_error($ch);
		return false;
	}
	$httpCode = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
	$httpInfo = array_merge ( $httpInfo, curl_getinfo ( $ch ) );
	curl_close ( $ch );
	return $response;
}
function aliyunsms($phonenum, $tmpcode, $code) {
	global $setting;
	AlibabaCloud::accessKeyClient ( $setting ['aliyunsmskey'], $setting ['aliyunsmsaccessSecret'] )->regionId ( 'cn-hangzhou' )->asDefaultClient ();
	
	try {
		$result = AlibabaCloud::rpc ()->product ( 'Dysmsapi' )->
		// ->scheme('https') // https | http
		version ( '2017-05-25' )->action ( 'SendSms' )->method ( 'POST' )->host ( 'dysmsapi.aliyuncs.com' )->options ( [ 
				'query' => [ 
						'RegionId' => "cn-hangzhou",
						'PhoneNumbers' => $phonenum,
						'SignName' => $setting ['aliyunsmssign'],
						'TemplateCode' => $tmpcode,
						'TemplateParam' => "{\"code\":\"$code\"}" 
				] 
		] )->request ();
		$smsresult = $result->toArray ();
		return $smsresult;
	} catch ( ClientException $e ) {
		echo $e->getErrorMessage () . PHP_EOL;
	} catch ( ServerException $e ) {
		echo $e->getErrorMessage () . PHP_EOL;
	}
}
function aliyunregsms($phonenum, $tmpcode, $sitename, $username, $password) {
	global $setting;
	AlibabaCloud::accessKeyClient ( $setting ['aliyunsmskey'], $setting ['aliyunsmsaccessSecret'] )->regionId ( 'cn-hangzhou' )->asDefaultClient ();
	
	try {
		$result = AlibabaCloud::rpc ()->product ( 'Dysmsapi' )->
		// ->scheme('https') // https | http
		version ( '2017-05-25' )->action ( 'SendSms' )->method ( 'POST' )->host ( 'dysmsapi.aliyuncs.com' )->options ( [ 
				'query' => [ 
						'RegionId' => "cn-hangzhou",
						'PhoneNumbers' => $phonenum,
						'SignName' => $setting ['aliyunsmssign'],
						'TemplateCode' => $tmpcode,
						'TemplateParam' => "{\"sitename\":\"$sitename\",\"username\":\"$username\",\"password\":\"$password\"}" 
				] 
		] )->request ();
		$smsresult = $result->toArray ();
		return $smsresult;
	} catch ( ClientException $e ) {
		echo $e->getErrorMessage () . PHP_EOL;
	} catch ( ServerException $e ) {
		echo $e->getErrorMessage () . PHP_EOL;
	}
}
function sendsms($key, $mobile, $tpl_id, $tpl_value) {
	$sendUrl = 'http://v.juhe.cn/sms/send'; // 短信接口的URL
	$message [] = array ();
	$smsConf = array (
			'key' => $key, // 您申请的APPKEY
			'mobile' => $mobile, // 接受短信的用户手机号码
			'tpl_id' => $tpl_id, // 您申请的短信模板ID，根据实际情况修改
			'tpl_value' => $tpl_value 
	); // 您设置的模板变量，根据实际情况修改
	
	$content = juhecurl ( $sendUrl, $smsConf, 1 ); // 请求发送短信
	
	if ($content) {
		$result = json_decode ( $content, true );
		$error_code = $result ['error_code'];
		if ($error_code == 0) {
			$message ['errorcode'] = 0;
			// 状态为0，说明短信发送成功
			// echo "短信发送成功,短信ID：".$result['result']['sid'];
			
			$message ['msg'] = $result ['result'] ['sid'];
		} else {
			// 状态非0，说明失败
			$message ['errorcode'] = 1;
			$msg = $result ['reason'];
			$message ['msg'] = $msg;
			
			// echo "短信发送失败(".$error_code.")：".$msg;
		}
	} else {
		// 返回内容异常，以下可根据业务逻辑自行修改
		// echo "请求发送短信失败";
		$message ['errorcode'] = 1;
		
		$message ['msg'] = '请求发送短信失败';
	}
	return $message;
}
/**
 * 百度分词---
 *
 * @param $title string
 *        	进行分词的标题
 * @param $content string
 *        	进行分词的内容
 * @param $encode string
 *        	API返回的数据编码
 * @return array 得到的关键词数组
 */
function dz_segment($title = '', $content = '', $encode = 'utf-8') {
	global $setting;
	if ($setting ['baidufenci'] != 1) { // 如果不启用百度分词直接跳过
		return false;
	}
	if ($title == '') {
		return false;
	}
	error_reporting ( 0 );
	$_title = strip_tags ( $title . $content );
	try {
		
		$url = 'http://zhannei.baidu.com/api/customsearch/keywords?title=' . urlencode ( $_title );
		$xml_array = file_get_contents ( $url );
		$decodedJsonArr = json_decode ( $xml_array, true );
		$wordrank = $decodedJsonArr ['result'] ['res'] ['wordrank'];
		$data = array ();
		foreach ( $wordrank as $key => $value ) {
			
			list ( $_k, $_v, $z ) = preg_split ( '/:/', $value );
			if ($z > 0.12) {
				if (strlen ( $_k ) >= 2) {
					if (! in_array ( $_k, $data )) {
						if (count ( $data ) <= 4) {
							array_push ( $data, $_k );
						}
					}
				}
			}
		}
		
		if (count ( $data ) > 0) {
			return $data;
		} else {
			
			foreach ( $wordrank as $key => $value ) {
				
				list ( $_k, $_v, $z ) = preg_split ( '/:/', $value );
				if ($z > 0.1) {
					if (strlen ( $_k ) >= 2) {
						if (! in_array ( $_k, $data )) {
							if (count ( $data ) <= 4) {
								array_push ( $data, $_k );
							}
						}
					}
				}
			}
			if (count ( $data ) > 0) {
				return $data;
			} else {
				return false;
			}
		}
	} catch ( Exception $e ) {
		
		return false;
	}
}
/**
 *
 * 生成指定个数得随机字符
 *
 * @date: 2019年10月15日 上午9:14:33
 *
 * @author : 61703
 *        
 * @param : $GLOBALS        	
 *
 * @return :
 *
 *
 */
function getRandChar($length) {
	$str = null;
	$strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
	$max = strlen ( $strPol ) - 1;
	
	for($i = 0; $i < $length; $i ++) {
		$str .= $strPol [rand ( 0, $max )]; // rand($min,$max)生成介于min和max两个数之间的一个随机整数
	}
	
	return $str;
}

/* 根据用户UID获得用户头像地址 */
function get_avatar_dir($uid) {
	global $setting,$user;
	if ($setting ['ucenter_open']) {
		return $setting ['ucenter_url'] . '/avatar.php?uid=' . $uid . '&size=middle';
	} else {
		$uid = sprintf ( "%09d", $uid );
		$dir1 = substr ( $uid, 0, 3 );
		$dir2 = substr ( $uid, 3, 2 );
		$dir3 = substr ( $uid, 5, 2 );
		if($user['uid']==$uid){
			$rand ="?code=" . rand ( 10, 99999999 );
		}else{
			$rand='';
		}
		
		$avatar_dir = "data/avatar/" . $dir1 . '/' . $dir2 . '/' . $dir3 . "/small_" . $uid;
		if (file_exists ( $avatar_dir . ".jpg" ))
			return base_url () . $avatar_dir . ".jpg" . $rand;
		if (file_exists ( $avatar_dir . ".jpeg" ))
			return base_url () . $avatar_dir . ".jpeg" . $rand;
		if (file_exists ( $avatar_dir . ".gif" ))
			return base_url () . $avatar_dir . ".gif" . $rand;
		if (file_exists ( $avatar_dir . ".png" ))
			return base_url () . $avatar_dir . ".png" . $rand;
	}
	// 显示系统默认头像
	return base_url () . '/static/css/default/avatar.gif';
}
/* 判断用户是否认证 */
function get_vertify_info($uid) {
	$vertify_file = "data/attach/vertify/$uid.txt";
	if (file_exists ( $vertify_file )) {
		$txt = file_get_contents ( $vertify_file );
		$result = explode ( '|', $txt );
		return $result;
	} else {
		return false;
	}
}
/* 根据分类cid获得封面图地址 */
function get_cid_dir($cid, $type = 'big') {
	$cid = sprintf ( "%09d", $cid );
	$dir1 = substr ( $cid, 0, 3 );
	$dir2 = substr ( $cid, 3, 2 );
	$dir3 = substr ( $cid, 5, 2 );
	$avatar_dir = "data/category/" . $dir1 . '/' . $dir2 . '/' . $dir3 . "/" . $type . "_" . $cid;
	
	if (file_exists ( $avatar_dir . ".jpg" ))
		return base_url () . $avatar_dir . ".jpg";
	if (file_exists ( $avatar_dir . ".jpeg" ))
		return base_url () . $avatar_dir . ".jpeg";
	if (file_exists ( $avatar_dir . ".gif" ))
		return base_url () . $avatar_dir . ".gif";
	if (file_exists ( $avatar_dir . ".png" ))
		return base_url () . $avatar_dir . ".png";
	
	// 显示系统默认分类图片地址
	return base_url () . '/static/images/defaulticon.jpg';
}
/**
 *
 * 获取栏目地址
 *
 * @date: 2019年9月24日 上午9:19:08
 *
 * @author : 61703
 *        
 * @param : $userdir
 *        	如果设置位true，表示优先使用目录做url不使用分类id
 *        	
 * @return :
 *
 *
 */
function getcaturl($catid, $url, $userdir = true) {
	if (file_exists ( FCPATH . "data/cache/category.php" )) {
		$category = include FCPATH . "data/cache/category.php";
	}
	
	// $catid=intval($catid);
	
	$cat = $category [$catid];
	
	if ($cat) {
		if (! empty ( $cat ['dir'] ) && $userdir) {
			// 如果分类栏目不能为空，则使用栏目拼音代替分类id
			$url = str_replace ( '#id#', $cat ['dir'], $url );
		} else {
			$url = str_replace ( '#id#', $cat ['id'], $url );
		}
	} else {
		$url = str_replace ( '#id#', $catid, $url );
	}
	return url ( $url );
}
/* 伪静态和html纯静态可以同时存在 */
function url($var, $url = '') {
	global $setting;
	$_fix = '';
	//文章id转加密
// 	if (strstr ( $var, 'topic/getone' )) {
// 		$_urlparms=explode('/', $var);
// 		if(is_array($_urlparms)){
// 			$_aid=intval($_urlparms[2]);
// 			if($_aid){
// 				$var="topic/getone/".endecodeID($_urlparms[2]);
// 			}
			
// 			//runlog('url', $var."--".$_urlparms[2]."--".endecodeID($_urlparms[2])."--".endecodeID("52AA7C63A15026736486F2",'decode'));
// 		}
		
// 	}
	
	if (strstr ( $var, 'seo/index' ) || strstr ( $var, 'ask/index' ) || strstr ( $var, 'category/view' ) || strstr ( $var, 'topic/catlist' )) { // 去掉文章栏目和问题栏目的url尾巴
	} else {
		$_fix = $setting ['seo_suffix'];
	}
	$location = 'index.php?' . $var . $_fix;
	if ((false === strpos ( $var, 'admin_' )) && $setting ['seo_on']) {
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		
		if (! strstr ( $useragent, 'MicroMessenger' )) {
			$location = $var . $_fix;
		} else {
			$location = 'index.php?' . $var . $_fix;
		}
	}
	
	$location = urlmap ( $location, 2 );
	if (strstr ( trim ( config_item ( 'mobile_domain' ) ),$_SERVER ['HTTP_HOST'] )) {
		
		if (config_item ( 'mobile_domain' )) {
			return config_item ( 'mobile_domain' ) . $location;
		} else {
			return config_item ( 'base_url' ) . $location;
		}
	} else {
		return config_item ( 'base_url' ) . $location;
	}
}

if (! function_exists ( 'updateinfo' )) {
	/**
	 * update siteinfo
	 *
	 * @param
	 *        	string
	 * @return string
	 */
	function updateinfo($user) {
		global $setting;
		defined('P_VERSION')  OR define('P_VERSION', 'null');
		$CI = & get_instance ();
		$sitename = $setting ['site_name'];
		$siturl = $_SERVER ['HTTP_HOST'];
		$pars = array (
				'sitename' => $sitename,
				'siteurl' => $siturl,
				'email' => $user ['email'],
				'version' => P_VERSION.ASK2_VERSION,
				'release' => ASK2_RELEASE,
				'phpos' => PHP_OS,
				'phpversion' => phpversion (),
				'mysqlversion' => $CI->db->version (),
				'browser' => urlencode ( $_SERVER ['HTTP_USER_AGENT'] ),
				'username' => urlencode ( $user ['username'] ),
				'phone' => urlencode ( $user ['phone'] ) 
		);
		$data = http_build_query ( $pars );
		return 'https://wenda.whatsns.com/updatesite.php?' . $data;
	}
}
/*
 * url转换器，1为请求转换，就是把类似q-替换为question/view
 * 2为反向转换，就是把类似/question/view/替换为q-
 */
if (! function_exists ( 'urlmap' )) {
	function urlmap($var, $direction = 2) {
		if (file_exists ( APPPATH . 'config/routes.php' )) {
			include (APPPATH . 'config/routes.php');
		}
		unset ( $route ['404_override'], $route ['default_controller'], $route ['translate_uri_dashes'] );
		$url_routes = $route;
		(2 == $direction) && $url_routes = array_flip ( $url_routes );
		foreach ( $url_routes as $mapkey => $route ) {
			$mapkey = str_replace ( '/$1', '/', strtolower ( $mapkey ) );
			$mapkey = str_replace ( '//$2', '/', $mapkey );
			$mapkey = str_replace ( '/$3', '', $mapkey );
			$mapkey = str_replace ( '/$4', '', $mapkey );
			$route = str_replace ( '-(:num)/(:num)', '-', strtolower ( $route ) );
			$route = str_replace ( '-(:any)/(:num)', '-', $route );
			$route = str_replace ( '/(:num)/(:num)', '/', $route );
			$route = str_replace ( '/(:any)/(:num)', '/', $route );
			$route = str_replace ( '-(:any)', '-', $route );
			$route = str_replace ( '-(:num)', '-', $route );
			$route = str_replace ( '-/(:num)', '-', $route );
			$route = str_replace ( '-/(:any)', '-', $route );
			$route = str_replace ( '-/(:num)', '-', $route );
			$route = str_replace ( '/(:num)', '/', $route );
			$route = str_replace ( '/(:any)', '/', $route );
			$route = str_replace ( '//', '/', $route );
			if (false !== strpos ( $var, $mapkey )) {
				$url = str_replace ( $mapkey, $route, $var );
				
				return $url;
			}
		}
		return $var;
	}
}
/**
 * random
 *
 * @param int $length        	
 * @return string $hash
 */
function random($length = 6, $type = 0) {
	$hash = '';
	$chararr = array (
			'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz',
			'0123456789',
			'23456789ABCDEFGHJKLMNPQRSTUVWXYZ' 
	);
	$chars = $chararr [$type];
	$max = strlen ( $chars ) - 1;
	PHP_VERSION < '4.2.0' && mt_srand ( ( double ) microtime () * 1000000 );
	for($i = 0; $i < $length; $i ++) {
		$hash .= $chars [mt_rand ( 0, $max )];
	}
	return $hash;
}
function cutstr($string, $length, $dot = '...') {
	if (strlen ( $string ) <= $length) {
		return $string;
	}
	$string = str_replace ( array (
			'&amp;',
			'&quot;',
			'&lt;',
			'&gt;' 
	), array (
			'&',
			'"',
			'<',
			'>' 
	), $string );
	$strcut = '';
	
	$n = $tn = $noc = 0;
	while ( $n < strlen ( $string ) ) {
		$t = ord ( $string [$n] );
		if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
			$tn = 1;
			$n ++;
			$noc ++;
		} elseif (194 <= $t && $t <= 223) {
			$tn = 2;
			$n += 2;
			$noc += 2;
		} elseif (224 <= $t && $t <= 239) {
			$tn = 3;
			$n += 3;
			$noc += 2;
		} elseif (240 <= $t && $t <= 247) {
			$tn = 4;
			$n += 4;
			$noc += 2;
		} elseif (248 <= $t && $t <= 251) {
			$tn = 5;
			$n += 5;
			$noc += 2;
		} elseif ($t == 252 || $t == 253) {
			$tn = 6;
			$n += 6;
			$noc += 2;
		} else {
			$n ++;
		}
		if ($noc >= $length) {
			break;
		}
	}
	if ($noc > $length) {
		$n -= $tn;
	}
	$strcut = substr ( $string, 0, $n );
	
	$strcut = str_replace ( array (
			'&',
			'"',
			'<',
			'>' 
	), array (
			'&amp;',
			'&quot;',
			'&lt;',
			'&gt;' 
	), $strcut );
	return $strcut . $dot;
}
function clearhtml($miaosu, $len = '200') {
	$miaosu = strip_tags ( $miaosu );
	$miaosu = strip_tags ( str_replace ( '&amp;nbsp;', '', $miaosu ) );
	$miaosu = str_replace ( '&nbsp;', '', $miaosu );
	// $miaosu = str_replace ( ' ', '', $miaosu );
	$miaosu = str_replace ( '"', '', $miaosu );
	$miaosu = str_replace ( '“', '', $miaosu );
	$miaosu = str_replace ( '”', '', trim ( $miaosu ) );
	$dot = mb_strlen ( $miaosu ) < $len ? "" : "...";
	return mb_substr ( trim ( $miaosu ), 0, $len, "utf-8" ) . $dot;
}
function generate_key() {
	$random = random ( 20 );
	$info = md5 ( $_SERVER ['SERVER_SOFTWARE'] . $_SERVER ['HTTP_HOST'] . $_SERVER ['SERVER_ADDR'] . $_SERVER ['SERVER_PORT'] . $_SERVER ['HTTP_USER_AGENT'] . time () );
	$return = '';
	for($i = 0; $i < 64; $i ++) {
		$p = intval ( $i / 2 );
		$return [$i] = $i % 2 ? $random [$p] : $info [$p];
	}
	return implode ( '', $return );
}

/**
 * getip
 *
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
function get_client_ip() {
	$clientip = '';
	if (getenv ( 'HTTP_CLIENT_IP' ) && strcasecmp ( getenv ( 'HTTP_CLIENT_IP' ), 'unknown' )) {
		$clientip = getenv ( 'HTTP_CLIENT_IP' );
	} elseif (getenv ( 'HTTP_X_FORWARDED_FOR' ) && strcasecmp ( getenv ( 'HTTP_X_FORWARDED_FOR' ), 'unknown' )) {
		$clientip = getenv ( 'HTTP_X_FORWARDED_FOR' );
	} elseif (getenv ( 'REMOTE_ADDR' ) && strcasecmp ( getenv ( 'REMOTE_ADDR' ), 'unknown' )) {
		$clientip = getenv ( 'REMOTE_ADDR' );
	} elseif (isset ( $_SERVER ['REMOTE_ADDR'] ) && $_SERVER ['REMOTE_ADDR'] && strcasecmp ( $_SERVER ['REMOTE_ADDR'], 'unknown' )) {
		$clientip = $_SERVER ['REMOTE_ADDR'];
	}
	
	preg_match ( "/[\d\.]{7,15}/", $clientip, $clientipmatches );
	$clientip = $clientipmatches [0] ? $clientipmatches [0] : 'unknown';
	return $clientip;
}
function real_ip() {
	static $realip = NULL;
	
	if ($realip !== NULL) {
		return $realip;
	}
	
	if (isset ( $_SERVER )) {
		if (isset ( $_SERVER ['HTTP_X_FORWARDED_FOR'] )) {
			$arr = explode ( ',', $_SERVER ['HTTP_X_FORWARDED_FOR'] );
			
			/* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
			foreach ( $arr as $ip ) {
				$ip = trim ( $ip );
				
				if ($ip != 'unknown') {
					$realip = $ip;
					
					break;
				}
			}
		} elseif (isset ( $_SERVER ['HTTP_CLIENT_IP'] )) {
			$realip = $_SERVER ['HTTP_CLIENT_IP'];
		} else {
			if (isset ( $_SERVER ['REMOTE_ADDR'] )) {
				$realip = $_SERVER ['REMOTE_ADDR'];
			} else {
				$realip = '0.0.0.0';
			}
		}
	} else {
		if (getenv ( 'HTTP_X_FORWARDED_FOR' )) {
			$realip = getenv ( 'HTTP_X_FORWARDED_FOR' );
		} elseif (getenv ( 'HTTP_CLIENT_IP' )) {
			$realip = getenv ( 'HTTP_CLIENT_IP' );
		} else {
			$realip = getenv ( 'REMOTE_ADDR' );
		}
	}
	
	preg_match ( "/[\d\.]{7,15}/", $realip, $onlineip );
	$realip = ! empty ( $onlineip [0] ) ? $onlineip [0] : '0.0.0.0';
	
	return $realip;
}
// 百度推送
function baidusend($api, $array_urls) {
	if ($api == '') {
		return "";
	}
	$ch = curl_init ();
	$options = array (
			CURLOPT_URL => $api,
			CURLOPT_POST => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS => implode ( "\n", $array_urls ),
			CURLOPT_HTTPHEADER => array (
					'Content-Type: text/plain' 
			) 
	);
	curl_setopt_array ( $ch, $options );
	$result = curl_exec ( $ch );
	return $result;
}
// 格式化前端IP显示
function formatip($ip, $type = 1) {
	if (strtolower ( $ip ) == 'unknown') {
		return false;
	}
	if ($type == 1) {
		$ipaddr = substr ( $ip, 0, strrpos ( $ip, "." ) ) . ".*";
	}
	return $ipaddr;
}
function forcemkdir($path) {
	if (! file_exists ( $path )) {
		forcemkdir ( dirname ( $path ) );
		$oldumask = umask ( 0 );
		mkdir ( $path, 0777 );
		umask ( $oldumask );
	}
}
function cleardir($dir, $forceclear = false) {
	if (! is_dir ( $dir )) {
		return;
	}
	$directory = dir ( $dir );
	while ( $entry = $directory->read () ) {
		$filename = $dir . '/' . $entry;
		if (is_file ( $filename )) {
			@unlink ( $filename );
		} elseif (is_dir ( $filename ) && $forceclear && $entry != '.' && $entry != '..') {
			chmod ( $filename, 0777 );
			cleardir ( $filename, $forceclear );
			rmdir ( $filename );
		}
	}
	$directory->close ();
}
function iswriteable($file) {
	$writeable = 0;
	if (is_dir ( $file )) {
		$dir = $file;
		if ($fp = @fopen ( "$dir/test.txt", 'w' )) {
			@fclose ( $fp );
			@unlink ( "$dir/test.txt" );
			$writeable = 1;
		}
	} else {
		if ($fp = @fopen ( $file, 'a+' )) {
			@fclose ( $fp );
			$writeable = 1;
		}
	}
	return $writeable;
}
// 检查特殊字符函数
function has_special_char($str) {
	if (strlen ( $str ) < 3) {
		return false;
	}
	if (preg_match ( "/[\',.@-_:。【】;*?~`!#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/", $str )) {
		return true;
	} else {
		return false;
	}
}
function readfromfile($filename) {
	if ($fp = @fopen ( $filename, 'rb' )) {
		if (PHP_VERSION >= '4.3.0' && function_exists ( 'file_get_contents' )) {
			return file_get_contents ( $filename );
		} else {
			flock ( $fp, LOCK_EX );
			$data = fread ( $fp, filesize ( $filename ) );
			flock ( $fp, LOCK_UN );
			fclose ( $fp );
			return $data;
		}
	} else {
		return '';
	}
}
function writetofile($filename, &$data) {
	if ($fp = @fopen ( $filename, 'wb' )) {
		if (PHP_VERSION >= '4.3.0' && function_exists ( 'file_put_contents' )) {
			return @file_put_contents ( $filename, $data );
		} else {
			flock ( $fp, LOCK_EX );
			$bytes = fwrite ( $fp, $data );
			flock ( $fp, LOCK_UN );
			fclose ( $fp );
			return $bytes;
		}
	} else {
		return 0;
	}
}
function extname($filename) {
	$pathinfo = pathinfo ( $filename );
	return strtolower ( $pathinfo ['extension'] );
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
function getrealsplitstring($ids) {
}
/* XSS 检测 */
function checkattack($reqarr, $reqtype = 'post') {
	$filtertable = array (
			'get' => 'sleep\s*?\(.*\)|\'|(and|or)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)',
			'post' => 'sleep\s*?\(.*\)|\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)',
			'cookie' => 'sleep\s*?\(.*\)|\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)' 
	);
	if (is_array ( $reqarr ) && ! empty ( $reqarr )) {
		foreach ( $reqarr as $reqkey => $reqvalue ) {
			
			if (is_array ( $reqvalue )) {
				
				checkattack ( $reqvalue, $reqtype );
			}
			
			if (preg_match ( "/" . $filtertable [$reqtype] . "/is", $reqvalue ) == 1 && ! in_array ( $reqkey, array (
					'content' 
			) )) {
				print ('Illegal operation!') ;
				exit ( - 1 );
			}
		}
	}
}
function tstripslashes($string) {
	if (is_array ( $string )) {
		foreach ( $string as $key => $val ) {
			$string [$key] = tstripslashes ( $val );
		}
	} else {
		$string = stripslashes ( $string );
	}
	return $string;
}
if (! function_exists ( 'template' )) {
	function template($file, $tpldir = '') {
		global $setting;
		$tmp_dir = $tpldir;
		
		if (is_mobile ()) {
			if ($setting ['app_useragnet']) {
				
				// 判断是否来自app端代理请求
				$useragent = $_SERVER ['HTTP_USER_AGENT'];
				if (strstr ( $useragent, $setting ['app_useragnet'] )) {
					$tpldir = $setting ['app_template'];
				} else {
					if ($tpldir == '') {
						$tpldir = $setting ['tpl_wapdir'];
					}
				}
			} else {
				if ($tpldir == '') {
					$tpldir = $setting ['tpl_wapdir'];
				}
			}
		} else {
			if ($tpldir == '')
				$tpl_dir = $setting ['tpl_dir'];
		}
		// if (! empty ( config_item ( 'mobile_domain' ) ) && $_SERVER ['HTTP_HOST']) {
		if (strstr ( trim ( config_item ( 'mobile_domain' ) ),$_SERVER ['HTTP_HOST'] )) {
			$tpldir = $setting ['tpl_wapdir'];
		}
		// }
		
		$isadmin = ('admin' == substr ( strtolower ( $tpldir), 0, 5 ));
		
		if (strstr ( $setting ['tpl_dir'], 'responsive_' )&&!$isadmin) {
			$tpldir = $setting ['tpl_dir'];
		}
		if ($_SESSION ['themename'] && ! is_mobile ()) {
			
			$tpldir = $_SESSION ['themename'];
		}
		
		$querystring = isset ( $_SERVER ['REQUEST_URI'] ) ? $_SERVER ['REQUEST_URI'] : '';
		$querystring = str_replace ( '.html', '', $querystring );
		$querystring = str_replace ( '/?', '', $querystring );
		$querystring = str_replace ( '/index.php?', '', $querystring );
		$querystring = trim ( $querystring, '/' );
		$querystring_arr = explode ( '/', $querystring );
		if (is_array ( $querystring_arr )) {
			
			if (strpos ( $querystring_arr [0], 'admin_' ) !== FALSE) {
				$tpldir = 'admin';
			}
		}
		$tpldir = ('' == $tpldir) ? $tpl_dir : $tpldir;
		if (strpos ( $file, '/' ) != FALSE) {
			$filetmp = explode ( '/', $file );
			$dirfile = $file;
			$file = $filetmp [count ( $filetmp ) - 1];
			$tplfile = APPPATH . '/views/' . $tpldir . '/' . $dirfile . TMP_PREX;
		} else {
			$tplfile = APPPATH . '/views/' . $tpldir . '/' . $file . TMP_PREX;
		}
		
		$objfile = FCPATH . '/data/view/' . $tpldir . '_' . $file . '.tpl' . TMP_PREX;
		if ('default' != $tpldir && ! is_file ( $tplfile )) {
			if (strpos ( $file, '/' ) != FALSE) {
				$filetmp = explode ( '/', $file );
				$dirfile = $file;
				$file = $filetmp [count ( $filetmp ) - 1];
				$tplfile = APPPATH . '/views/default/' . $dirfile . TMP_PREX;
			} else {
				$tplfile = APPPATH . '/views/default/' . $file . TMP_PREX;
			}
			
			$objfile = FCPATH . '/data/view/default_' . $file . '.tpl' . TMP_PREX;
		}
		if(!is_dir(dirname($objfile))){
			mkdir(dirname($objfile));
		}
		if (! file_exists ( $objfile ) || (@filemtime ( $tplfile ) > @filemtime ( $objfile ))) {
			
			require_once (BASEPATH . 'helpers/template_helper.php');
			parse_template ( $tplfile, $objfile );
		}
		return $objfile;
	}
}
function timeLength($time) {
	$length = '';
	if ($day = floor ( $time / (24 * 3600) )) {
		$length .= $day . '天';
	}
	if ($hour = floor ( $time % (24 * 3600) / 3600 )) {
		$length .= $hour . '小时';
	}
	if ($day == 0 && $hour == 0) {
		$length = floor ( $time / 60 ) . '分';
	}
	return $length;
}
/* 验证码生成 */
function makecode($code, $width = 80, $height = 28, $quality = 3) {
	$fontcfg = array (
			'spacing' => 2 
	);
	$fontfile = STATICPATH . 'css/default/ninab.ttf';
	$fontcolors = array (
			array (
					27,
					78,
					181 
			),
			array (
					22,
					163,
					35 
			),
			array (
					214,
					36,
					7 
			),
			array (
					88,
					127,
					30 
			),
			array (
					66,
					133,
					244 
			),
			array (
					241,
					147,
					0 
			),
			array (
					232,
					0,
					0 
			),
			array (
					196,
					146,
					1 
			) 
	);
	$im = imagecreatetruecolor ( $width * $quality, $height * $quality );
	$imbgcolor = imagecolorallocate ( $im, 255, 255, 255 );
	imagefilledrectangle ( $im, 0, 0, $width * $quality, $height * $quality, $imbgcolor );
	
	$lettersMissing = 4 - strlen ( $code );
	$fontSizefactor = 0.9 + ($lettersMissing * 0.09);
	$x = 4 * $quality;
	$y = round ( ($height * 27 / 32) * $quality );
	$length = strlen ( $code );
	$degree = rand ( 8 * - 1, 8 );
	$fontsize = 22 * $quality * $fontSizefactor;
	
	// 雪花
	for($i = 0; $i < 10; $i ++) {
		$color = imagecolorallocate ( $im, mt_rand ( 200, 255 ), mt_rand ( 200, 255 ), mt_rand ( 200, 255 ) );
		// imagestring($im,mt_rand(1,5),mt_rand(0,$lwidth),mt_rand(0,$lwidth),'a',$color);
		imagettftext ( $im, $fontsize, $degree, $i * 30, $y - $i * 2, $color, $fontfile, mt_rand ( 1, 9 ) );
	}
	for($i = 0; $i < $length; $i ++) {
		
		$color = $fontcolors [mt_rand ( 0, sizeof ( $fontcolors ) - 1 )];
		$imbgcolor = imagecolorallocate ( $im, $color [0], $color [1], $color [2] );
		
		$letter = substr ( $code, $i, 1 );
		$coords = imagettftext ( $im, $fontsize, $degree, $x, $y, $imbgcolor, $fontfile, $letter );
		$x += ($coords [2] - $x) + ($fontcfg ['spacing'] * $quality);
	}
	$x1 = $width * $quality * .15;
	$x2 = $x;
	$y1 = rand ( $height * $quality * .40, $height * $quality * .65 );
	$y2 = rand ( $height * $quality * .40, $height * $quality * .65 );
	$lwidth = 0.5 * $quality;
	for($i = $lwidth * - 1; $i <= $lwidth; $i ++) {
		// imageline($im, $x1, $y1 + $i, $x2, $y2 + $i, $imbgcolor);
		// imageline($im, $x1+3, $y1 + $i, $x2+5, $y2 + $i, $imbgcolor);
		imageline ( $im, $x1 + 9, $y1 + $i, $x2 + 10, $y2 + $i, $imbgcolor );
	}
	
	$imResampled = imagecreatetruecolor ( $width, $height );
	imagecopyresampled ( $imResampled, $im, 0, 0, 0, 0, $width, $height, $width * $quality, $height * $quality );
	imagedestroy ( $im );
	$im = $imResampled;
	header ( "Content-type: image/jpeg" );
	imagejpeg ( $im, null, 80 );
	imagedestroy ( $im );
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

/**
 * 加密解密id,
 * @param unknown $string
 * @param string $action  encode|decode
 * @return string
 */
function endecodeID($string, $action = 'encode') {
	$startLen = 13;
	$endLen = 8;
	
	$coderes = '';
	#TOD 暂设定uid字符长度最大到9
	if ($action=='encode') {
		$uidlen = strlen($string);
		$salt = 'whatsns';
		$codestr = $string.$salt;
		$encodestr = hash('md4', $codestr);
		$coderes = $uidlen.substr($encodestr, 5,$startLen-$uidlen).$string.substr($encodestr, -12,$endLen);
		
	}elseif($action=='decode'){
		$string=strtoupper($string);
		$strlen = strlen($string);
		$uidlen = $string[0];
		$coderes = substr($string, $startLen-$uidlen+1,$uidlen);
	}
	return  $coderes;
}
function encode($string = '', $skey = 'mishen') {
	$strArr = str_split ( base64_encode ( $string ) );
	$strCount = count ( $strArr );
	foreach ( str_split ( $skey ) as $key => $value )
		$key < $strCount && $strArr [$key] .= $value;
	return str_replace ( array (
			'=',
			'+',
			'/' 
	), array (
			'O0O0O',
			'o000o',
			'oo00o' 
	), join ( '', $strArr ) );
}
function decode($string = '', $skey = 'mishen') {
	$strArr = str_split ( str_replace ( array (
			'O0O0O',
			'o000o',
			'oo00o' 
	), array (
			'=',
			'+',
			'/' 
	), $string ), 2 );
	$strCount = count ( $strArr );
	foreach ( str_split ( $skey ) as $key => $value )
		$key <= $strCount && isset ( $strArr [$key] ) && $strArr [$key] [1] === $value && $strArr [$key] = $strArr [$key] [0];
	return base64_decode ( join ( '', $strArr ) );
}

/* 日期格式显示 */
function tdate($time, $type = 3, $friendly = 1) {
	global $setting;
	($setting ['time_friendly'] != 1) && $friendly = 0;
	$format [] = $type & 2 ? (! empty ( $setting ['date_format'] ) ? $setting ['date_format'] : 'Y-n-j') : '';
	$format [] = $type & 1 ? (! empty ( $setting ['time_format'] ) ? $setting ['time_format'] : 'H:i') : '';
	$timeoffset = $setting ['time_offset'] * 3600 + $setting ['time_diff'] * 60;
	$time = intval ( $time );
	$timestring = gmdate ( implode ( ' ', $format ), $time + $timeoffset );
	if ($friendly) {
		$time = time () - $time;
		if ($time <= 24 * 3600) {
			if ($time > 3600) {
				$timestring = intval ( $time / 3600 ) . '小时前';
			} elseif ($time > 60) {
				$timestring = intval ( $time / 60 ) . '分钟前';
			} elseif ($time > 0) {
				$timestring = $time . '秒前';
			} else {
				$timestring = '现在前';
			}
		} else if ($time <= 72 * 3600) {
			
			$timestring = intval ( $time / (24 * 3600) ) . '天前';
		}
	}
	return str_replace ( '/', '-', $timestring );
}

/* cookie设置和读取 */
function tcookie($var, $value = 0, $life = 0) {
	global $setting;
	if ($life > 36000) {
		$life = 36000;
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

/* 日志记录 */
function runlog($file, $message, $halt = 0) {
	$nowurl = $_SERVER ['REQUEST_URI'] ? $_SERVER ['REQUEST_URI'] : ($_SERVER ['PHP_SELF'] ? $_SERVER ['PHP_SELF'] : $_SERVER ['SCRIPT_NAME']);
	$log = date ( $_SERVER ['REQUEST_TIME'], 'Y-m-d H:i:s' ) . "\t" . $_SERVER ['REMOTE_ADDR'] . "\t{$nowurl}\t" . str_replace ( array (
			"\r",
			"\n" 
	), array (
			' ',
			' ' 
	), trim ( $message ) ) . "\n";
	
	$yearmonth = gmdate ( 'Ym', $_SERVER ['REQUEST_TIME'] );
	$logdir = FCPATH . '/data/logs/';
	if (! is_dir ( $logdir ))
		mkdir ( $logdir, 0777 );
	$logfile = $logdir . $yearmonth . '_' . $file . '.php';
	if (@filesize ( $logfile ) > 2048000) {
		$dir = opendir ( $logdir );
		$length = strlen ( $file );
		$maxid = $id = 0;
		while ( $entry = readdir ( $dir ) ) {
			if (strstr ( $entry, $yearmonth . '_' . $file )) {
				$id = intval ( substr ( $entry, $length + 8, - 4 ) );
				$id > $maxid && $maxid = $id;
			}
		}
		closedir ( $dir );
		$logfilebak = $logdir . $yearmonth . '_' . $file . '_' . ($maxid + 1) . '.php';
		@rename ( $logfile, $logfilebak );
	}
	if ($fp = @fopen ( $logfile, 'a' )) {
		@flock ( $fp, 2 );
		fwrite ( $fp, "<?PHP exit;?>\t" . str_replace ( array (
				'<?',
				'?>',
				"\r",
				"\n" 
		), '', $log ) . "\n" );
		fclose ( $fp );
	}
	
	if ($halt)
		exit ();
}

/* 翻页函数 */
function cpage($num, $perpage, $curpage, $url) {
	global $setting;
	$multipage = '';
	
	if ($num > $perpage) {
		$page = 8;
		$offset = 2;
		$pages = @ceil ( $num / $perpage );
		if ($page > $pages) {
			$from = 1;
			$to = $pages;
		} else {
			$from = $curpage - $offset;
			$to = $from + $page - 1;
			if ($from < 1) {
				$to = $curpage + 1 - $from;
				$from = 1;
				if ($to - $from < $page) {
					$to = $page;
				}
			} elseif ($to > $pages) {
				$from = $pages - $page + 1;
				$to = $pages;
			}
		}
		
		$multipage = ($curpage - $offset > 1 && $pages > $page ? '<a  class="n" href="' . $url . '&pageindex=1' . '" >首页</a>' . "\n" : '');
		
		if ($curpage > 1) {
			if ($curpage - 1 == 1) {
				
				$multipage = $multipage . '<a href="' . $url . '&pageindex=1' . '"  class="n">上一页</a>' . "\n";
			} else {
				$multipage = $multipage . '<a href="' . $url . '&pageindex=' . ($curpage - 1) . '"  class="n">上一页</a>' . "\n";
			}
		} else {
		}
		
		for($i = $from; $i <= $to; $i ++) {
			if ($i == 1) {
				
				$multipage .= $i == $curpage ? "<strong>$i</strong>\n" : '<a href="' . $url . '&pageindex=1' . '">' . $i . '</a>' . "\n";
			} else {
				$multipage .= $i == $curpage ? "<strong>$i</strong>\n" : '<a href="' . $url . '&pageindex=' . $i . '">' . $i . '</a>' . "\n";
			}
		}
		$multipage .= ($curpage < $pages ? '<a class="n" href="' . $url . '&pageindex=' . ($curpage + 1) . '">下一页</a>' . "\n" : '') . ($to < $pages ? '<a class="n" href="' . $url . '&pageindex=' . $pages . '" >最后一页</a>' . "\n" : '');
	}
	
	return $multipage;
}

/* 翻页函数 */
function page($num, $perpage, $curpage, $operation, $ajax = 0) {
	global $setting;
	$multipage = '';
	$operation = urlmap ( $operation, 2 );
	$mpurl = "";
	
	// $setting ['seo_prefix']='?';
	if (strpos ( $operation, 'new-' ) !== false || strpos ( $operation, 'tags-' ) !== false) {
		$mpurl = base_url () . $setting ['seo_prefix'] . $operation;
	} else {
		
		$mpurl = base_url () . $setting ['seo_prefix'] . $operation . '/';
	}
	
	('admin' == substr ( $operation, 0, 5 )) && ($mpurl = 'index.php?' . $operation . '/');
	
	if ($num > $perpage) {
		$page = 8;
		$offset = 2;
		$pages = @ceil ( $num / $perpage );
		if ($page > $pages) {
			$from = 1;
			$to = $pages;
		} else {
			$from = $curpage - $offset;
			$to = $from + $page - 1;
			if ($from < 1) {
				$to = $curpage + 1 - $from;
				$from = 1;
				if ($to - $from < $page) {
					$to = $page;
				}
			} elseif ($to > $pages) {
				$from = $pages - $page + 1;
				$to = $pages;
			}
		}
		if (! $ajax) {
			$multipage = ($curpage - $offset > 1 && $pages > $page ? '<a  class="n" href="' . $mpurl . '1' . $setting ['seo_suffix'] . '" >首页</a>' . "\n" : '');
			
			if ($curpage > 1) {
				if ($curpage - 1 == 1) {
					$tmpurl = substr ( $mpurl, 0, strlen ( $mpurl ) - 1 );
					$multipage = $multipage . '<a href="' . $tmpurl . $setting ['seo_suffix'] . '"  class="n">上一页</a>' . "\n";
				} else {
					$multipage = $multipage . '<a href="' . $mpurl . ($curpage - 1) . $setting ['seo_suffix'] . '"  class="n">上一页</a>' . "\n";
				}
			} else {
			}
			
			for($i = $from; $i <= $to; $i ++) {
				if ($i == 1) {
					
					$tmpurl = substr ( $mpurl, 0, strlen ( $mpurl ) - 1 );
					
					$multipage .= $i == $curpage ? "<strong>$i</strong>\n" : '<a href="' . $tmpurl . $setting ['seo_suffix'] . '">' . $i . '</a>' . "\n";
				} else {
					$multipage .= $i == $curpage ? "<strong>$i</strong>\n" : '<a href="' . $mpurl . $i . $setting ['seo_suffix'] . '">' . $i . '</a>' . "\n";
				}
			}
			$multipage .= ($curpage < $pages ? '<a class="n" href="' . $mpurl . ($curpage + 1) . $setting ['seo_suffix'] . '">下一页</a>' . "\n" : '') . ($to < $pages ? '<a class="n" href="' . $mpurl . $pages . $setting ['seo_suffix'] . '" >最后一页</a>' . "\n" : '');
		} else {
			$multipage = '';
			if ($curpage < $pages) {
				$multipage = '<a href="' . $mpurl . ($curpage + 1) . $setting ['seo_suffix'] . '">查看更多</a>';
			}
		}
	}
	
	return $multipage;
}
// sql 组合
function getwheresql($table, $where, $tbprex) {
	return "select count(*) as num from " . $tbprex . $table . " where $where ";
}
// 返回数组中的值
function returnarraynum($arr) {
	if (isset ( $arr )) {
		return $arr ['num'];
	} else {
		return 0;
	}
}
/* 二维数组去重 */
function assoc_unique($arr, $key) {
	$tmp_arr = array ();
	foreach ( $arr as $k => $v ) {
		if (in_array ( $v [$key], $tmp_arr )) { // 搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
			unset ( $arr [$k] );
		} else {
			$tmp_arr [] = $v [$key];
		}
	}
	sort ( $arr ); // sort函数对数组进行排序
	return $arr;
}
/**
 *
 * 代码高亮
 *
 * @date: 2019年4月20日 下午6:35:43
 *
 * @author : 61703
 *        
 * @param : $GLOBALS        	
 *
 * @return :
 *
 *
 */
function codehightline($str) {
	$newct = str_replace ( '<pre class="brush:php;toolbar:false">', '<pre ><code >', $str );
	$newct = str_replace ( '<pre class="brush:java;toolbar:false">', '<pre ><code >', $newct );
	$newct = str_replace ( '<pre class="brush:html;toolbar:false">', '<pre ><code >', $newct );
	$newct = str_replace ( '<pre class="brush:js;toolbar:false">', '<pre ><code >', $newct );
	
	$newct = str_replace ( '</pre">', '</code></pre>', $newct );
	return $newct;
}
// 熊掌号推送
function xiongzhangtuisong($urls) {
	return false;
	global $setting;
	$urls = array ();
	
	if (trim ( $setting ['xiongzhang_settinghistoryapi'] ) != '' && $setting ['xiongzhang_settinghistoryapi'] != null) {
		
		$api = $setting ['xiongzhang_settinghistoryapi'];
		
		$ch = curl_init ();
		$options = array (
				CURLOPT_URL => $api,
				CURLOPT_POST => true,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POSTFIELDS => implode ( "\n", $urls ),
				CURLOPT_HTTPHEADER => array (
						'Content-Type: text/plain' 
				) 
		);
		curl_setopt_array ( $ch, $options );
		$result = json_decode ( curl_exec ( $ch ), true );
	}
}
/* 替换关键词 */
function replacewords($content) {
	global $setting, $keyword;
	
	$articlecontent = $content;
	if ($keyword != null) {
		$maxindex_keywords = $setting ['maxindex_keywords'];
		$pagemaxindex_keywords = $setting ['pagemaxindex_keywords'];
		//
		//
		
		$canreplace = true;
		$kindex = 0;
		$urlarray = array ();
		//
		foreach ( $keyword as $key => $val ) {
			if ($canreplace == false) {
				break;
			}
			$word = $keyword [$key] ['find'];
			
			$wordurl = "<a style='color:#2f2f2f;cursor:pointer;' href='" . $keyword [$key] ['replacement'] . "'>" . $keyword [$key] ['find'] . "</a>";
			$repstrlen = strlen ( $word );
			$rand = random ( 5 );
			
			//
			if ($maxindex_keywords != 0) {
				for($i = 0; $i < $maxindex_keywords; $i ++) {
					if ($pagemaxindex_keywords != 0) {
						// // //如果超过设置的最大值就终止替换
						
						if ($kindex >= $pagemaxindex_keywords) {
							$canreplace = false;
							break;
						}
					}
					
					$s_start = strpos ( $articlecontent, $word );
					//
					if ($s_start > 0) {
						//
						
						array_push ( $urlarray, array (
								'word' => $rand,
								'url' => $wordurl 
						) );
						$keys = 'word';
						//
						
						assoc_unique ( $urlarray, $keys );
						//
						$keyword [$key] ['num'] = intval ( $keyword [$key] ['find'] ) + 1;
						$firstcontent = substr ( $articlecontent, 0, $s_start );
						//
						$sec = substr ( $articlecontent, $s_start + $repstrlen );
						//
						if (trim ( $firstcontent ) != '') {
							//
							$articlecontent = $firstcontent . "{#replace_keyword$rand#}" . $sec;
						} else {
							$articlecontent = "{#replace_keyword$rand#}" . $sec;
						}
						//
						//
						
						$kindex ++;
					}
					
					//
					//
					//
				}
			} else {
				$articlecontent = str_replace ( $word, $wordurl, $articlecontent );
				
				//
			}
			
			//
		}
		if ($maxindex_keywords != 0) {
			//
			
			if (count ( $urlarray ) > 0) {
				
				for($i = 0; $i < count ( $urlarray ); $i ++) {
					$word = $urlarray [$i] ['word'];
					
					$url = $urlarray [$i] ['url'];
					$articlecontent = str_replace ( "{#replace_keyword$word#}", $url, $articlecontent );
					
					// //
				}
			}
		}
		
		//
	}
	return $articlecontent;
}
/* 过滤关键词 */
function checkwords($content) {
	global $setting, $badword;
	$status = 0;
	$text = $content;
	if (! empty ( $badword )) {
		foreach ( $badword as $word => $wordarray ) {
			$replace = $wordarray ['replacement'];
			$content = str_replace ( $word, $replace, $content, $matches );
			
			if ($matches > 0) {
				
				if ('{MOD}' == $replace) {
					$status = 1;
				}
				if ('{BANNED}' == $replace) {
					$status = 2;
				}
				
				if ($status > 0) {
					$content = $text;
					break;
				}
			}
		}
	}
	// $content = str_replace(array("\r\n", "\r", "\n"), '<br />', htmlentities($content));
	return array (
			$status,
			$content 
	);
}
/* 过滤关键词---字符串 */
function checkwordsglobal($content) {
	global $setting, $badword;
	$status = 0;
	$text = $content;
	if (! empty ( $badword )) {
		foreach ( $badword as $word => $wordarray ) {
			$replace = $wordarray ['replacement'];
			$content = str_replace ( $word, $replace, $content, $matches );
			if ($matches > 0) {
				'{MOD}' == $replace && $status = 1;
				'{BANNED}' == $replace && $status = 2;
				if ($status > 0) {
					$content = $text;
					break;
				}
			}
		}
	}
	// $content = str_replace(array("\r\n", "\r", "\n"), '<br />', htmlentities($content));
	return $content;
}
/* http请求 */
function topen($url, $timeout = 15, $post = '', $cookie = '', $limit = 0, $ip = '', $block = TRUE) {
	$return = '';
	
	$matches = parse_url ( $url );
	$host = $matches ['host'];
	$path = $matches ['path'] ? $matches ['path'] . ($matches ['query'] ? '?' . $matches ['query'] : '') : '/';
	$port = ! empty ( $matches ['port'] ) ? $matches ['port'] : 80;
	if ($post) {
		$out = "POST $path HTTP/1.0\r\n";
		$out .= "Accept: */*\r\n";
		// $out .= "Referer: $boardurl\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n";
		$out .= 'Content-Length: ' . strlen ( $post ) . "\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cache-Control: no-cache\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
		$out .= $post;
	} else {
		$out = "GET $path HTTP/1.0\r\n";
		$out .= "Accept: */*\r\n";
		// $out .= "Referer: $boardurl\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
	}
	$fp = @fsockopen ( ($ip ? $ip : $host), $port, $errno, $errstr, $timeout );
	if (! $fp) {
		return '';
	} else {
		stream_set_blocking ( $fp, $block );
		stream_set_timeout ( $fp, $timeout );
		@fwrite ( $fp, $out );
		$status = stream_get_meta_data ( $fp );
		if (! $status ['timed_out']) {
			while ( ! feof ( $fp ) ) {
				if (($header = @fgets ( $fp )) && ($header == "\r\n" || $header == "\n")) {
					break;
				}
			}
			$stop = false;
			while ( ! feof ( $fp ) && ! $stop ) {
				$data = fread ( $fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit) );
				$return .= $data;
				if ($limit) {
					$limit -= strlen ( $data );
					$stop = $limit <= 0;
				}
			}
		}
		@fclose ( $fp );
		return $return;
	}
}

/* 发送邮件 */
function sendmail($touser, $subject, $message, $from = '') {
	$toemail = $touser ['email'];
	if (! $toemail || $toemail == 'null')
		return false;
	
	$url = url ( 'asynsendemail/msend' );
	$post_data = array (
			"tousername" => $toemail,
			'mailtitle' => $subject,
			'mailcontent' => $message 
	);
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_URL, $url );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $ch, CURLOPT_TIMEOUT, 1 );
	curl_setopt ( $ch, CURLOPT_POST, 1 );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
	$output = curl_exec ( $ch );
	curl_close ( $ch );
	return $output;
}
/**
 *
 * 发送大批量邮件
 *
 * @date: 2018年12月22日 下午10:37:05
 *
 * @author : 61703
 *        
 * @param : $GLOBALS        	
 *
 * @return :
 *
 *
 */
function sendmutiemail($emails, $subject, $message) {
	if (! $emails || $emails == 'null')
		return false;
	
	$url = url ( 'asynsendemail/msend' );
	$post_data = array (
			"tousername" => implode ( ',', $emails ),
			'mailtitle' => $subject,
			'mailcontent' => $message 
	);
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_URL, $url );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $ch, CURLOPT_TIMEOUT, 1 );
	curl_setopt ( $ch, CURLOPT_POST, 1 );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
	$output = curl_exec ( $ch );
	curl_close ( $ch );
	return $output;
}
/* 发送测试邮件 */
function sendmailto($toemail, $subject, $message, $tousername = '', $from = '') {
	global $setting;
	
	if (! $toemail || $toemail == 'null')
		return false;
	
	if (! $tousername || $tousername == 'null') {
		$tousername = $toemail;
	}
	$message = <<<EOT
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>$subject</title>
		</head>
		<body>
		hi, $tousername<br>
            $subject<br>
            $message<br>
		这封邮件由系统自动发送，请不要回复。
		</body>
		</html>
EOT;
	require 'email.class.php';
	// ******************** 配置信息 ********************************
	$smtpserver = $setting ['mailserver']; // "smtp.163.com";//SMTP服务器
	$smtpserverport = $setting ['mailport']; // SMTP服务器端口
	$smtpusermail = $setting ['mailfrom']; // SMTP服务器的用户邮箱
	$smtpemailto = $toemail; // 发送给谁
	$smtpuser = $setting ['mailauth_username']; // SMTP服务器的用户帐号
	$smtppass = $setting ['mailauth_password']; // SMTP服务器的用户密码
	$mailtitle = $subject; // 邮件主题
	$mailcontent = $message; // 邮件内容
	$mailtype = "HTML"; // 邮件格式（HTML/TXT）,TXT为文本邮件
	                    // ************************ 配置信息 ****************************
	$smtp = new smtp ( $smtpserver, $smtpserverport, true, $smtpuser, $smtppass ); // 这里面的一个true是表示使用身份验证,否则不使用身份验证.
	$smtp->debug = false; // 是否显示发送的调试信息
	$state = $smtp->sendmail ( $smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype );
	return $state;
}
function sendemailtouser($toemail, $subject, $message) {
	if (empty ( $toemail )) {
		return false;
	}
	global $setting;
	
	$message = <<<EOT
<!DOCTYPE html>
<html lang="ch">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>$subject</title>
</head>
		<body>
		hi, $toemail<br>
            $subject<br>
            $message
		</body>
		</html>
EOT;
	require 'email.class.php';
	// ******************** 配置信息 ********************************
	$smtpserver = $setting ['mailserver']; // "smtp.163.com";//SMTP服务器
	$smtpserverport = $setting ['mailport']; // SMTP服务器端口
	$smtpusermail = $setting ['mailfrom']; // SMTP服务器的用户邮箱
	$smtpemailto = $toemail; // 发送给谁
	$smtpuser = $setting ['mailauth_username']; // SMTP服务器的用户帐号
	$smtppass = $setting ['mailauth_password']; // SMTP服务器的用户密码
	$mailtitle = $subject; // 邮件主题
	$mailcontent = $message; // 邮件内容
	$mailtype = "HTML"; // 邮件格式（HTML/TXT）,TXT为文本邮件
	                    // ************************ 配置信息 ****************************
	$smtp = new smtp ( $smtpserver, $smtpserverport, true, $smtpuser, $smtppass ); // 这里面的一个true是表示使用身份验证,否则不使用身份验证.
	$smtp->debug = false; // 是否显示发送的调试信息
	$state = $smtp->sendmail ( $smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype );
}
/* 取得一个字符串的拼音表示形式 */
function getpinyin($str, $ishead = 0, $isclose = 1) {
	if (! function_exists ( 'gbk_to_pinyin' )) {
		require_once (BASEPATH . 'helpers/iconv_helper.php');
	}
	if (strtolower ( config_item ( 'charset' ) ) == 'utf-8') {
		$str = utf8_to_gbk ( $str );
	}
	return gbk_to_pinyin ( $str, $ishead, $isclose );
}

/* 得到一个分类的getcategorypath，一直到根分类 */
function getcategorypath($cid) {
	global $category;
	$item = $category [$cid];
	$dirpath = $item ['dir'];
	while ( true ) {
		if (0 == $item ['pid']) {
			break;
		} else {
			$item = $category [$item ['pid']];
		}
		$dirpath = $item ['dir'] . '/' . $dirpath;
	}
	return $dirpath;
}

/* 得到链接来源 */
function get_url_source($forward = "") {
	global $setting;
	$refer = $forward ? $forward : $_SERVER ['HTTP_REFERER'];
	$start = $setting ['seo_on'] ? strlen ( base_url () ) : strlen ( base_url () ) + 1;
	$refer = substr ( $refer, $start );
	return substr ( $refer, 0, strrpos ( $refer, "." ) );
}

/* 数组类型，是否是向量类型 */
function isVector(&$array) {
	$next = 0;
	foreach ( $array as $k => $v ) {
		if ($k !== $next)
			return false;
		$next ++;
	}
	return true;
}

/* 自己定义tjson_encode */
function tjson_encode($value) {
	switch (gettype ( $value )) {
		case 'double' :
		case 'integer' :
			return $value > 0 ? $value : '"' . $value . '"';
		case 'boolean' :
			return $value ? 'true' : 'false';
		case 'string' :
			return '"' . str_replace ( array (
					"\n",
					"\b",
					"\t",
					"\f",
					"\r" 
			), array (
					'\n',
					'\b',
					'\t',
					'\f',
					'\r' 
			), addslashes ( $value ) ) . '"';
		case 'NULL' :
			return 'null';
		case 'object' :
			return '"Object ' . get_class ( $value ) . '"';
		case 'array' :
			if (isVector ( $value )) {
				if (! $value) {
					return $value;
				}
				foreach ( $value as $v ) {
					$result [] = tjson_encode ( $v );
				}
				return '[' . implode ( ',', $result ) . ']';
			} else {
				$result = '{';
				foreach ( $value as $k => $v ) {
					if ($result != '{')
						$result .= ',';
					$result .= tjson_encode ( $k ) . ':' . tjson_encode ( $v );
				}
				return $result . '}';
			}
		default :
			return '"' . addslashes ( $value ) . '"';
	}
}

/* 是否是外部url */
function is_outer($url) {
	$findstr = $domain = $_SERVER ["HTTP_HOST"];
	$words = explode ( '.', $domain );
	if (count ( $words ) > 2) {
		array_shift ( $words );
		$findstr = implode ( '.', $words );
	}
	return false === strpos ( $url, $findstr );
}
/* 是否是外部imgurl */
function is_imgouter($url) {
	$findstr = $domain = $_SERVER ["HTTP_HOST"];
	$words = explode ( '.', $domain );
	if (count ( $words ) > 2) {
		array_shift ( $words );
		$findstr = implode ( '.', $words );
	}
	return false === strpos ( $url, $findstr );
}
/* 处理外部url */
function change_outer($url) {
	return base_url () . '?redirect/change/' . urlencode ( $url );
}

/* html中的是否包含外部url */
function has_outer($content) {
	$contain = false;
	if (! function_exists ( 'file_get_html' )) {
		require_once (BASEPATH . 'helpers/simple_html_dom_helper.php');
	}
	$html = str_get_html ( $content );
	$ret = $html->find ( 'a' );
	foreach ( $ret as $a ) {
		if (is_outer ( $a->href )) {
			$contain = true;
			break;
		}
	}
	$html->clear ();
	return $contain;
}
function get_rand_ip() {
	$arr_1 = array (
			"218",
			"218",
			"66",
			"66",
			"218",
			"218",
			"60",
			"60",
			"202",
			"204",
			"66",
			"66",
			"66",
			"59",
			"61",
			"60",
			"222",
			"221",
			"66",
			"59",
			"60",
			"60",
			"66",
			"218",
			"218",
			"62",
			"63",
			"64",
			"66",
			"66",
			"122",
			"211" 
	);
	$randarr = mt_rand ( 0, count ( $arr_1 ) );
	$ip1id = $arr_1 [$randarr];
	$ip2id = round ( rand ( 600000, 2550000 ) / 10000 );
	$ip3id = round ( rand ( 600000, 2550000 ) / 10000 );
	$ip4id = round ( rand ( 600000, 2550000 ) / 10000 );
	return $ip1id . "." . $ip2id . "." . $ip3id . "." . $ip4id;
}
// 替换外部图片
function replace_imgouter($content) {
	if (! function_exists ( 'file_get_html' )) {
		require_once (BASEPATH . 'helpers/simple_html_dom_helper.php');
	}
	$html = str_get_html ( $content );
	$ret = $html->find ( 'img' );
	foreach ( $ret as $a ) {
		
		$attrs = $a->getAllAttributes ();
		foreach ( $attrs as $attr_key => $attr_value ) {
			if ($attr_key == "data-src") {
				if (is_imgouter ( $attr_value )) {
					$filename = random ( 10 ) . ".jpg";
					if (is_dir ( FCPATH . 'data/imgouter' )) {
						forcemkdir ( FCPATH . 'data/imgouter' );
					}
					$imgname = "./data/imgouter/" . $filename;
					if (! list ( $w, $h ) = getimagesize ( $attr_value )) {
						return;
					} else {
						$src = imagecropper ( $attr_value, $imgname, $w, $h );
					}
					
					$imgname = SITE_URL . "data/imgouter/" . $filename;
					// 阿里云存储
					try {
						require_once STATICPATH . 'js/neweditor/php/Config.php';
						if (Config::OPEN_OSS) {
							$targetfile = "data/imgouter/" . $filename;
							require_once STATICPATH . 'js/neweditor/php/up.php';
							if (Common::getOpenoss () == '1') {
								$diross = $targetfile;
								$tmpfile = $targetfile;
								
								if (substr ( $targetfile, 0, 1 ) == '/') {
									$diross = substr ( $targetfile, 1 );
								}
								$imgnamefile = uploadFile ( Common::getOssClient (), Common::getBucketName (), $diross, FCPATH . $targetfile );
								if ($imgnamefile != 'error') {
									$imgname = $imgnamefile;
								}
							}
						}
					} catch ( Exception $e ) {
						print $e->getMessage ();
					}
					
					if (file_exists ( FCPATH . "data/imgouter/" . $filename )) {
						$a->outertext = '<img src="' . $imgname . '" />';
					}
				}
				break;
			}
			if ($attr_key == "src") {
				if (is_imgouter ( $a->src )) {
					$filename = random ( 10 ) . ".jpg";
					if (is_dir ( FCPATH . 'data/imgouter' )) {
						forcemkdir ( FCPATH . 'data/imgouter' );
					}
					$imgname = "./data/imgouter/" . $filename;
					if (! list ( $w, $h ) = getimagesize ( $a->src )) {
						return;
					} else {
						$src = imagecropper ( $a->src, $imgname, $w, $h );
					}
					
					$imgname = SITE_URL . "data/imgouter/" . $filename;
					// 阿里云存储
					try {
						require_once STATICPATH . 'js/neweditor/php/Config.php';
						if (Config::OPEN_OSS) {
							$targetfile = "data/imgouter/" . $filename;
							require_once STATICPATH . 'js/neweditor/php/up.php';
							if (Common::getOpenoss () == '1') {
								$diross = $targetfile;
								$tmpfile = $targetfile;
								
								if (substr ( $targetfile, 0, 1 ) == '/') {
									$diross = substr ( $targetfile, 1 );
								}
								$imgnamefile = uploadFile ( Common::getOssClient (), Common::getBucketName (), $diross, FCPATH . $targetfile );
								if ($imgnamefile != 'error') {
									$imgname = $imgnamefile;
								}
							}
						}
					} catch ( Exception $e ) {
						print $e->getMessage ();
					}
					if (file_exists ( FCPATH . "data/imgouter/" . $filename )) {
						$a->outertext = '<img src="' . $imgname . '" />';
					}
				}
				break;
			}
		}
	}
	$content = $html->save ();
	$html->clear ();
	return $content;
}
// 过滤图片其它url
function filter_otherimgouter($content) {
	if (! function_exists ( 'file_get_html' )) {
		require_once (BASEPATH . 'helpers/simple_html_dom_helper.php');
	}
	$html = str_get_html ( $content );
	$ret = $html->find ( 'img' );
	foreach ( $ret as $a ) {
		if (is_imgouter ( $a->_fcksavedurl )) {
			$a->_fcksavedurl = "";
		}
	}
	$content = $html->save ();
	$html->clear ();
	return $content;
}
/* 过滤外部url */
function filter_outer($content) {
	if (! function_exists ( 'file_get_html' )) {
		require_once (BASEPATH . 'helpers/simple_html_dom_helper.php');
	}
	$html = str_get_html ( $content );
	$ret = $html->find ( 'a' );
	foreach ( $ret as $a ) {
		if (is_outer ( $a->href )) {
			$a->outertext = $a->innertext;
		}
	}
	$content = $html->save ();
	$html->clear ();
	return $content;
}
function filter_link($content) {
	if (! function_exists ( 'file_get_html' )) {
		require_once (BASEPATH . 'helpers/simple_html_dom_helper.php');
	}
	$html = str_get_html ( $content );
	$ret = $html->find ( 'a' );
	foreach ( $ret as $a ) {
		
		$a->outertext = $a->innertext;
	}
	$content = $html->save ();
	$html->clear ();
	return $content;
}
/* 过滤外部图片url */
function filter_imgouter($content) {
	if (! function_exists ( 'file_get_html' )) {
		require_once (BASEPATH . 'helpers/simple_html_dom_helper.php');
	}
	$html = str_get_html ( $content );
	$ret = $html->find ( 'img' );
	foreach ( $ret as $a ) {
		if (is_imgouter ( $a->src )) {
			$a->outertext = '';
		}
	}
	$content = $html->save ();
	$html->clear ();
	return $content;
}

/* 内存是否够用 */
function is_mem_available($mem) {
	$limit = trim ( ini_get ( 'memory_limit' ) );
	if (empty ( $limit ))
		return true;
	$unit = strtolower ( substr ( $limit, - 1 ) );
	switch ($unit) {
		case 'g' :
			$limit = substr ( $limit, 0, - 1 );
			$limit *= 1024 * 1024 * 1024;
			break;
		case 'm' :
			$limit = substr ( $limit, 0, - 1 );
			$limit *= 1024 * 1024;
			break;
		case 'k' :
			$limit = substr ( $limit, 0, - 1 );
			$limit *= 1024;
			break;
	}
	if (function_exists ( 'memory_get_usage' )) {
		$used = memory_get_usage ();
	}
	if ($used + $mem > $limit) {
		return false;
	}
	return true;
}

// 图片处理函数
/* 根据扩展名判断是否图片 */
function isimage($extname) {
	return in_array ( $extname, array (
			'jpg',
			'jpeg',
			'png',
			'gif',
			'bmp' 
	) );
}
/**
 * 图像裁剪
 *
 * @param $title string
 *        	原图路径
 * @param $content string
 *        	需要裁剪的宽
 * @param $encode string
 *        	需要裁剪的高
 */
function imagecropper($source_path, $dst, $target_width, $target_height) {
	$httpxieyi = strtolower ( substr ( $source_path, 0, 7 ) );
	$httpsxieyi = strtolower ( substr ( $source_path, 0, 8 ) );
	$controlleradmin = strtolower ( substr ( ROUTE_A, 0, 5 ) );
	$controllerkecheng = strtolower ( substr ( ROUTE_A, 0, 7 ) );
	
	if (! file_exists ( $source_path )) {
		
		// 非站内图片，看看外部图片格式
		if ($httpxieyi != 'http://' && $httpsxieyi != 'https://' && $controlleradmin != 'admin' && $controllerkecheng != 'kecheng') {
			exit ( "非正常图片地址" );
		} else {
			$source_info = getimagesize ( $source_path );
		}
	} else {
		$source_info = getimagesize ( $source_path );
	}
	
	$source_width = $source_info [0];
	$source_height = $source_info [1];
	$source_mime = $source_info ['mime'];
	$source_ratio = $source_height / $source_width;
	$target_ratio = $target_height / $target_width;
	
	// 源图过高
	if ($source_ratio > $target_ratio) {
		$cropped_width = $source_width;
		$cropped_height = $source_width * $target_ratio;
		$source_x = 0;
		$source_y = ($source_height - $cropped_height) / 2;
	} // 源图过宽
elseif ($source_ratio < $target_ratio) {
		$cropped_width = $source_height / $target_ratio;
		$cropped_height = $source_height;
		$source_x = ($source_width - $cropped_width) / 2;
		$source_y = 0;
	} // 源图适中
else {
		$cropped_width = $source_width;
		$cropped_height = $source_height;
		$source_x = 0;
		$source_y = 0;
	}
	ini_set ( 'memory_limit', '500M' );
	switch ($source_mime) {
		case 'image/gif' :
			$source_image = imagecreatefromgif ( $source_path );
			break;
		
		case 'image/jpeg' :
			
			$source_image = imagecreatefromjpeg ( $source_path );
			break;
		
		case 'image/png' :
			$source_image = imagecreatefrompng ( $source_path );
			break;
		
		default :
			return false;
			break;
	}
	unlink ( $source_path );
	$target_image = imagecreatetruecolor ( $target_width, $target_height );
	$cropped_image = imagecreatetruecolor ( $cropped_width, $cropped_height );
	
	// 裁剪
	imagecopy ( $cropped_image, $source_image, 0, 0, $source_x, $source_y, $cropped_width, $cropped_height );
	// 缩放
	imagecopyresampled ( $target_image, $cropped_image, 0, 0, 0, 0, $target_width, $target_height, $cropped_width, $cropped_height );
	
	// 保存图片到本地(两者选一)
	
	imagepng ( $target_image, $dst );
	imagedestroy ( $target_image );
	return $dst;
	
	// 直接在浏览器输出图片(两者选一)
	// header('Content-Type: image/jpeg');
	// imagepng($target_image);
	// imagedestroy($target_image);
	// imagejpeg($target_image);
	// imagedestroy($source_image);
	// imagedestroy($target_image);
	// imagedestroy($cropped_image);
}
function image_resize($src, $dst, $width, $height, $crop = 0) {
	return imagecropper ( $src, $dst, $width, $height );
	
	if (! list ( $w, $h ) = getimagesize ( $src ))
		return "Unsupported picture type!";
	
	$type = strtolower ( substr ( strrchr ( $src, "." ), 1 ) );
	if ($type == 'jpeg')
		$type = 'jpg';
	switch ($type) {
		case 'bmp' :
			$img = imagecreatefromwbmp ( $src );
			break;
		case 'gif' :
			$img = imagecreatefromgif ( $src );
			break;
		case 'jpg' :
			$img = imagecreatefromjpeg ( $src );
			break;
		case 'png' :
			$img = imagecreatefrompng ( $src );
			break;
		default :
			return false;
	}
	// resize
	if ($crop) {
		// if ($w < $width or $h < $height) {
		// rename($src, $dst);
		// return true;
		// }
		$ratio = max ( $width / $w, $height / $h );
		$h = $height / $ratio;
		$x = ($w - $width / $ratio) / 2;
		$w = $width / $ratio;
	} else {
		if ($w < $width and $h < $height) {
			rename ( $src, $dst );
			return true;
		}
		$ratio = min ( $width / $w, $height / $h );
		$width = $w * $ratio;
		$height = $h * $ratio;
		$x = 0;
	}
	$new = imagecreatetruecolor ( $width, $height );
	// preserve transparency
	if ($type == "gif" or $type == "png") {
		imagecolortransparent ( $new, imagecolorallocatealpha ( $new, 0, 0, 0, 127 ) );
		imagealphablending ( $new, false );
		imagesavealpha ( $new, true );
	}
	
	imagecopyresampled ( $new, $img, 0, 0, $x, 0, $width, $height, $w, $h );
	
	switch ($type) {
		case 'bmp' :
			imagewbmp ( $new, $dst );
			break;
		case 'gif' :
			imagegif ( $new, $dst );
			break;
		case 'jpg' :
			imagejpeg ( $new, $dst );
			break;
		case 'png' :
			imagepng ( $new, $dst );
			break;
	}
	return true;
}
function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale) {
	list ( $imagewidth, $imageheight, $imageType ) = getimagesize ( $image );
	$thumb_image_name = APPPATH . $thumb_image_name;
	$imageType = image_type_to_mime_type ( $imageType );
	$newImageWidth = ceil ( $width * $scale );
	$newImageHeight = ceil ( $height * $scale );
	$newImage = imagecreatetruecolor ( $newImageWidth, $newImageHeight );
	switch ($imageType) {
		case "image/gif" :
			$source = imagecreatefromgif ( $image );
			break;
		case "image/pjpeg" :
		case "image/jpeg" :
		case "image/jpg" :
			$source = imagecreatefromjpeg ( $image );
			break;
		case "image/png" :
		case "image/x-png" :
			$source = imagecreatefrompng ( $image );
			break;
	}
	imagecopyresampled ( $newImage, $source, 0, 0, $start_width, $start_height, $newImageWidth, $newImageHeight, $width, $height );
	switch ($imageType) {
		case "image/gif" :
			imagegif ( $newImage, $thumb_image_name );
			break;
		case "image/pjpeg" :
		case "image/jpeg" :
		case "image/jpg" :
			imagejpeg ( $newImage, $thumb_image_name );
			break;
		case "image/png" :
		case "image/x-png" :
			imagepng ( $newImage, $thumb_image_name );
			break;
	}
	chmod ( $thumb_image_name, 0777 );
	return $thumb_image_name;
}

/**
 * 获取内容中的第一张图
 *
 * @param unknown_type $string        	
 * @return unknown|string
 */
function getfirstimg(&$string) {
	preg_match ( "/<img.+?src=[\\\\]?\"(.+?)[\\\\]?\"/i", $string, $imgs );
	if (isset ( $imgs [1] )) {
		return $imgs [1];
	} else {
		return null;
	}
}
// 获取图片数组
function getfirstimgs(&$string) {
	preg_match_all ( "/<img.+?src=[\\\\]?\"(.+?)[\\\\]?\"/i", $string, $imgs );
	if (isset ( $imgs [1] )) {
		return $imgs;
	} else {
		return "";
	}
}
function getImageFile($url, $filename = '', $dirName, $type = 0) {
	if ($url == '') {
		return false;
	}
	// 获取文件原文件名
	$defaultFileName = basename ( $url );
	// 获取文件类型
	$suffix = substr ( strrchr ( $url, '.' ), 1 );
	// if(!in_array($suffix, $fileType)){
	// return false;
	// }
	// 设置保存后的文件名
	// $filename = $filename == '' ? time().rand(0,9).'.'.$suffix : $defaultFileName;
	
	// 获取远程文件资源
	if ($type) {
		// $ch = curl_init();
		// $timeout = 5;
		// curl_setopt($ch, CURLOPT_URL, $url);
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt ( $ch, CURLOPT_REFERER, 'http://www.baidu.com/');
		// curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		// $file = curl_exec($ch);
		// curl_close($ch);
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 30 );
		curl_setopt ( $ch, CURLOPT_REFERER, 'http://www.baidu.com' );
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
	return $dirName . $filename;
}
function array_per_fields($array, $field) {
	$values = array ();
	if (is_array ( $array )) {
		foreach ( $array as $val ) {
			$values [] = $val [$field];
		}
	}
	return $values;
}
function highlight($content, $words, $highlightcolor = 'red') {
	$wordlist = explode ( " ", $words );
	foreach ( $wordlist as $hightlightword ) {
		if (strlen ( $content ) < 1 || strlen ( $hightlightword ) < 1) {
			return $content;
		}
		$content = str_replace ( $hightlightword, "<font color=red>$hightlightword</font>", $content );
		
		// $content = preg_replace ( "/$hightlightword/is", "<font color=red>\\0</font>", $content );
	}
	return $content;
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
function is_mobile() {
	$is_mobile = false;
	if (empty ( $_SERVER ['HTTP_USER_AGENT'] )) {
		$is_mobile = false;
	} elseif (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'Mobile' ) !== false || strpos ( $_SERVER ['HTTP_USER_AGENT'], 'Android' ) !== false || strpos ( $_SERVER ['HTTP_USER_AGENT'], 'Silk/' ) !== false || strpos ( $_SERVER ['HTTP_USER_AGENT'], 'Kindle' ) !== false || strpos ( $_SERVER ['HTTP_USER_AGENT'], 'BlackBerry' ) !== false || strpos ( $_SERVER ['HTTP_USER_AGENT'], 'Opera Mini' ) !== false || strpos ( $_SERVER ['HTTP_USER_AGENT'], 'Opera Mobi' ) !== false) {
		$is_mobile = true;
	} else {
		$is_mobile = false;
	}
	
	return $is_mobile;
}
/**

* 获取开发者accesstoken

* @date: 2020年11月10日 下午1:37:21

* @author: 61703

* @param: $GLOBALS

* @return:

*/
function getAccessToken(){
	global $setting;
	// 获取token
	if (! isset ( $_SESSION )) {
		session_start ();
	}
	if (! isset ( $_SESSION ['dev_accesstion'] )) {
		
		// 判断是否设置了appid和appsecret
		if ($setting['dev_appid'] == '' || ! isset ( $setting['dev_appid'] ) || $setting['dev_appsecret'] == '' || ! isset ( $setting['dev_appsecret'] )) {
			$message ['code'] = 201;
			$message ['msg'] = "appid或者appsecret不能为空";
			return $message;
		}
		$result = curl_post ( config_item ( "getToken" ), array (
				'appid' => $setting['dev_appid'],
				'appsecret' => $setting['dev_appsecret']
		) );
	
		$accesstoken = '';
		if (is_array ( $result )) {
			if($result['code']!=200){
				return $result;
			}else{
				$accesstoken = $result ['data'] ['accesstoken'];
				$_SESSION['dev_accesstion']=$accesstoken;
			}
		
		}
		
	}
	return $_SESSION['dev_accesstion'];
}
/**
 *
 * post接口
 *
 * @date: 2020年11月10日 上午9:26:10
 *
 * @author : 61703
 *
 * @param
 *        	: variable
 *
 * @return :
 *
 */
function curl_post($url, $data = array(),$returntype="json") {
	try {
		
		$ch = curl_init ();
		
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ($ch, CURLOPT_REFERER, SITE_URL);  
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
		// POST数据
		
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		
		// 把post的变量加上
		
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		
		$output = curl_exec ( $ch );
		
		curl_close ( $ch );
		$result = json_decode ( $output, true );
		if(is_array($result)){
			return $result;
		}else{
			$message ['code'] = 202;
			$message ['msg'] = "未获取任何结果信息";
			$message ['data'] = $output;
			if($returntype=="json"){
			
				return json_encode ( $message );
				
			}else{
				return $message;
			}
			
		}

	} catch ( Exception $e ) {
		$message ['code'] = 201;
		$message ['msg'] = "请求失败";
		if($returntype=="json"){
		
			return json_encode ( $message );
			
		}else{
			return $message;
		}
	
	}
}
// 原生消息推送
function jpushmsg($message, $alisname, $msgname, $tourl) {
	if (! file_exists ( FCPATH . '/lib/jpush/config.php' )) {
		return false;
	}
	require FCPATH . '/lib/jpush/config.php';
	$message = trim ( $message );
	if ($message == "") {
		return false;
	}
	try {
		$response = $client->push ()->setPlatform ( array (
				'ios',
				'android' 
		) )->
		// 一般情况下，关于 audience 的设置只需要调用 addAlias、addTag、addTagAnd 或 addRegistrationId
		
		addAlias ( $alisname )->
		// ->addTag(array($alisname))
		// ->addRegistrationId("1a0018970af69b8899e")
		setNotificationAlert ( $message )->iosNotification ( $message, array (
				'sound' => 'sound.caf',
				// 'badge' => '+1',
				// 'content-available' => true,
				// 'mutable-content' => true,
				'category' => 'jiguang',
				'extras' => array (
						'key' => $tourl 
				
				) 
		) )->androidNotification ( $message, array (
				'title' => $msgname,
				// 'builder_id' => 2,
				'extras' => array (
						'key' => $tourl 
				
				) 
		) )->message ( 'message content', array (
				'title' => $msgname,
				// 'content_type' => 'text',
				'extras' => array (
						'key' => $tourl 
				
				) 
		) )->options ( array (
				// sendno: 表示推送序号，纯粹用来作为 API 调用标识，
				// API 返回时被原样返回，以方便 API 调用方匹配请求与返回
				// 这里设置为 100 仅作为示例
				
				// 'sendno' => 100,
				
				// time_to_live: 表示离线消息保留时长(秒)，
				// 推送当前用户不在线时，为该用户保留多长时间的离线消息，以便其上线时再次推送。
				// 默认 86400 （1 天），最长 10 天。设置为 0 表示不保留离线消息，只有推送当前在线的用户可以收到
				// 这里设置为 1 仅作为示例
				
				// 'time_to_live' => 1,
				
				// apns_production: 表示APNs是否生产环境，
				// True 表示推送生产环境，False 表示要推送开发环境；如果不指定则默认为推送生产环境
				
				'apns_production' => ture 
			
			// big_push_duration: 表示定速推送时长(分钟)，又名缓慢推送，把原本尽可能快的推送速度，降低下来，
			// 给定的 n 分钟内，均匀地向这次推送的目标用户推送。最大值为1400.未设置则不是定速推送
			// 这里设置为 1 仅作为示例
			
		// 'big_push_duration' => 1
		) )->send ();
	} catch ( \JPush\Exceptions\APIConnectionException $e ) {
		// try something here
		// print $e;
	} catch ( \JPush\Exceptions\APIRequestException $e ) {
		// try something here
		// print $e;
	}
}
?>