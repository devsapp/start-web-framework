<?php
ini_set ( 'date.timezone', 'Asia/Shanghai' );
define ( 'IN_ASK2', TRUE );
$http_type = ((isset ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] == 'on') || (isset ( $_SERVER ['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER ['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'https://';
if (is_https ()) {
	define ( 'SITE_URL', 'https://' . $_SERVER ['HTTP_HOST'] . '/' );
} else {
	define ( 'SITE_URL', 'http://' . $_SERVER ['HTTP_HOST'] . '/' );
}

define ( 'ENVIRONMENT', isset ( $_SERVER ['CI_ENV'] ) ? $_SERVER ['CI_ENV'] : 'production' );
define ( 'FC_PATH', dirname ( dirname ( dirname ( __FILE__ ) ) ) . DIRECTORY_SEPARATOR );
define ( 'BASEPATH', FC_PATH . 'system' );
$setting = require (FC_PATH . 'data/cache/setting.php');
require FC_PATH . 'lib/db_mysqli.php';
$wechatObj = new wechatCallbackapiTest ();

if (! isset ( $_GET ['echostr'] )) {
	$wechatObj->responseMsg ();
} else {
	$wechatObj->valid ();
}
function url($var, $url = '') {
	global $setting;
	// exit($var);
	$location = '?' . $var . $setting ['seo_suffix'];
	if ((false === strpos ( $var, 'admin_' )) && $setting ['seo_on']) {
	
		
	
			$location = $var . $setting ['seo_suffix'];
		
		
	}
	$location = urlmap ( $location, 2 );
	return SITE_URL . $location; //程序动态获取的，给question的model使用
	
	
}
function urlmap($var, $direction = 2) {
	if (file_exists ( FC_PATH . 'application/config/routes.php' )) {
		include (FC_PATH . 'application/config/routes.php');
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

//判断是否是https
function is_https() {
	if (! empty ( $_SERVER ['HTTPS'] ) && strtolower ( $_SERVER ['HTTPS'] ) !== 'off') {
		return TRUE;
	} elseif (isset ( $_SERVER ['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER ['HTTP_X_FORWARDED_PROTO'] === 'https') {
		return TRUE;
	} elseif (! empty ( $_SERVER ['HTTP_FRONT_END_HTTPS'] ) && strtolower ( $_SERVER ['HTTP_FRONT_END_HTTPS'] ) !== 'off') {
		return TRUE;
	}

	return FALSE;
}
class wechatCallbackapiTest {
	var $db;
	var $token;
	function wechatCallbackapiTest() {

		$this->init_db ();

		$this->token = $this->getoken ();
	}
	function init_db() {
		require FC_PATH . 'application' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'database.php';
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
		$config ['dbport'] = 3306;
		$config ['debug'] = true;
		$db->open ( $config );
		$this->db = $db;
	}
	function getoken() {
		$wxtoken = $this->db->fetch_first ( "SELECT * FROM " . DB_TABLEPRE . "setting where k='wxtoken' limit 0,1" );
		return trim ( $wxtoken ['v'] );
	}
	//验证签名
	public function valid() {

		$echoStr = $_GET ["echostr"];
		$signature = $_GET ["signature"];
		$timestamp = $_GET ["timestamp"];
		$nonce = $_GET ["nonce"];
		$token = $this->token;
		$tmpArr = array ($token, $timestamp, $nonce );
		sort ( $tmpArr, SORT_STRING );
		$tmpStr = implode ( $tmpArr );
		$tmpStr = sha1 ( $tmpStr );
		if ($tmpStr == $signature) {
			echo $echoStr;
			exit ();
		}
	}

	//响应消息
	public function responseMsg() {
		$postStr = isset($GLOBALS ["HTTP_RAW_POST_DATA"])? $GLOBALS ["HTTP_RAW_POST_DATA"]:file_get_contents('php://input');
		if (! empty ( $postStr )) {
			$this->logger ( "R \r\n" . $postStr );
			$postObj = simplexml_load_string ( $postStr, 'SimpleXMLElement', LIBXML_NOCDATA );
			$RX_TYPE = trim ( $postObj->MsgType );

			if (($postObj->MsgType == "event") && ($postObj->Event == "subscribe" || $postObj->Event == "unsubscribe")) {
				//过滤关注和取消关注事件
			} else {

			}

			//消息类型分离
			switch ($RX_TYPE) {
				case "event" :
					$result = $this->receiveEvent ( $postObj );
					break;
				case "text" :

					$result = $this->receiveText ( $postObj );

					break;
				case "image" :
					$result = $this->receiveImage ( $postObj );
					break;
				case "location" :
					$result = $this->receiveLocation ( $postObj );
					break;
				case "voice" :
					$result = $this->receiveVoice ( $postObj );
					break;
				case "video" :
					$result = $this->receiveVideo ( $postObj );
					break;
				case "link" :
					$result = $this->receiveLink ( $postObj );
					break;
				default :
					$result = "unknown msg type: " . $RX_TYPE;
					break;
			}
			$this->logger ( "T \r\n" . $result );
			echo $result;
		} else {
			echo "";
			exit ();
		}
	}

	//接收事件消息
	private function receiveEvent($object) {
		$content = "";
		switch ($object->Event) {
			case "subscribe" :
				$site = $this->db->fetch_first ( "SELECT * FROM " . DB_TABLEPRE . "weixin_info limit 0,1" );
				$content = $site ['msg'];
				$content .= (! empty ( $object->EventKey )) ? ("\n来自二维码场景 " . str_replace ( "qrscene_", "", $object->EventKey )) : "";
				break;
			case "unsubscribe" :
				$content = "取消关注";
				break;
			case "CLICK" :
				$content = $this->getcontent ( $object->EventKey );
				break;
			case "VIEW" :
				$content = "跳转链接 " . $object->EventKey;
				break;
			case "SCAN" :
				$content = "扫描场景 " . $object->EventKey;
				break;
			case "LOCATION" :
				// $content = "上传位置：纬度 ".$object->Latitude.";经度 ".$object->Longitude;
				break;
			case "scancode_waitmsg" :
				if ($object->ScanCodeInfo->ScanType == "qrcode") {
					$content = "扫码带提示：类型 二维码 结果：" . $object->ScanCodeInfo->ScanResult;
				} else if ($object->ScanCodeInfo->ScanType == "barcode") {
					$codeinfo = explode ( ",", strval ( $object->ScanCodeInfo->ScanResult ) );
					$codeValue = $codeinfo [1];
					$content = "扫码带提示：类型 条形码 结果：" . $codeValue;
				} else {
					$content = "扫码带提示：类型 " . $object->ScanCodeInfo->ScanType . " 结果：" . $object->ScanCodeInfo->ScanResult;
				}
				break;
			case "scancode_push" :
				$content = "扫码推事件";
				break;
			case "pic_sysphoto" :
				$content = "系统拍照";
				break;
			case "pic_weixin" :
				$content = "相册发图：数量 " . $object->SendPicsInfo->Count;
				break;
			case "pic_photo_or_album" :
				$content = "拍照或者相册：数量 " . $object->SendPicsInfo->Count;
				break;
			case "location_select" :
				$content = "发送位置：标签 " . $object->SendLocationInfo->Label;
				break;
			default :
				// $content = "receive a new event: ".$object->Event;
				break;
		}

		if (is_array ( $content )) {
			if (isset ( $content [0] ['PicUrl'] )) {
				$result = $this->transmitNews ( $object, $content );
			} else if (isset ( $content ['MusicUrl'] )) {
				$result = $this->transmitMusic ( $object, $content );
			}
		} else {
			if ($content == "") {
				$site = $this->db->fetch_first ( "SELECT * FROM " . DB_TABLEPRE . "weixin_info limit 0,1" );
				$content = $site ['unword'];
			}

			$result = $this->transmitText ( $object, $content );
		}
		return $result;
	}

	private function getcontent($keyword, $object = null) {
		// runlog ( 'test', $keyword );
		$keys = array ();
		$kcontent = array ();
		$content = '';
		$query = $this->db->query ( "SELECT * FROM " . DB_TABLEPRE . "weixin_keywords order by id desc LIMIT 0,1000" );
		while ( $key = $this->db->fetch_array ( $query ) ) {
			//精准匹配
			if ($key ['showtype'] == 1) {
				if ($keyword == $key ['txtname']) {
					//系统关键词
					if ($key ['txttype'] == 1) {
						switch (trim ( $key ['txtcontent'] )) {
							case '#最新问题#' :
								$content = $this->newquestion ();
								if (count ( $content ) <= 0) {
									$content = "没有最新问题推荐哟";
								}
								break;
							case '#热门问题#' :
								$content = $this->hotquestion ();
								if (count ( $content ) <= 0) {
									$content = "没有热门问题推荐哟";
								}
								break;
							case '#最新文章#' :
								$content = $this->newblog ();
								if (count ( $content ) <= 0) {
									$content = "没有最新文章推荐哟";
								}
								break;
							case '#站长推荐#' :
								$content = $this->hotblog ();
								if (count ( $content ) <= 0) {
									$content = "没有站长推荐的文章哟";
								}
								break;
							case '#附近的人#' :
								break;
							case '#附近的问题#' :
								break;

						}
					} else {
						if (! empty ( $key ['title'] ) && $key ['title'] != '') {

							$sql = $this->db->query ( "SELECT * FROM " . DB_TABLEPRE . "weixin_keywords where txtname='$keyword' order by id desc LIMIT 0,1" );

							while ( $topic = $this->db->fetch_array ( $sql ) ) {

								if (strstr ( $topic ['wburl'], 'http:' )||strstr ( $topic ['wburl'], 'https:' )) {
									$kcontent [] = array ("Title" => $topic ['title'], "Description" => $topic ['txtcontent'], "PicUrl" =>  $topic ['fmtu'], "Url" => $topic ['wburl'] );

								} else {
									$kcontent [] = array ("Title" => $topic ['title'], "Description" => $topic ['txtcontent'], "PicUrl" => SITE_URL . $topic ['fmtu'], "Url" => url('topic/getone/' . $topic['wzid']) );

								}

							}

						} else {
							$content = $key ['txtcontent'];
						}

					}
					if (count ( $kcontent ) > 0) {
						$content = $kcontent;
					}
					break;
				}
			} else {
				//模糊匹配
				if (strstr ( $keyword, $key ['txtname'] )) {
					if ($key ['txttype'] == 1) {
						switch (trim ( $key ['txtcontent'] )) {
							case '#最新问题#' :
								$content = $this->newquestion ();
								if (count ( $content ) <= 0) {
									$content = "没有最新问题推荐哟";
								}
								break;
							case '#热门问题#' :
								$content = $this->hotquestion ();
								if (count ( $content ) <= 0) {
									$content = "没有最新问题推荐哟";
								}
								break;
							case '#最新文章#' :
								$content = $this->newblog ();
								if (count ( $content ) <= 0) {
									$content = "没有最新文章推荐哟";
								}
								break;
							case '#站长推荐#' :
								$content = $this->hotblog ();
								if (count ( $content ) <= 0) {
									$content = "没有站长推荐的文章哟";
								}
								break;
							case '#附近的人#' :
								break;
							case '#附近的问题#' :
								break;
						}
					} else {
						if (! empty ( $key ['title'] ) && $key ['title'] != '') {

							$sql = $this->db->query ( "SELECT * FROM " . DB_TABLEPRE . "weixin_keywords where txtname='$keyword' order by id desc LIMIT 0,1" );

							while ( $topic = $this->db->fetch_array ( $sql ) ) {
								if (strstr ( $topic ['wburl'], 'http:' )) {
									$kcontent [] = array ("Title" => $topic ['title'], "Description" => $topic ['txtcontent'], "PicUrl" => SITE_URL . $topic ['fmtu'], "Url" => $topic ['wburl'] );

								} else {
									$kcontent [] = array ("Title" => $topic ['title'], "Description" => $topic ['txtcontent'], "PicUrl" => SITE_URL . $topic ['fmtu'], "Url" => url('topic/getone/' . $topic['wzid'] ) );

								}
							}

						} else {

							$content = $key ['txtcontent'];
						}
					}
					if (count ( $kcontent ) > 0) {
						$content = $kcontent;
					}
					break;
				}
			}
		}
		if ($keyword == "签到" || $keyword == "打卡") {
			$content = "签到记录已经收到";
		}
		if ($keyword == "账号绑定" || $content == "账号绑定") {
			$openid = $object->FromUserName;
			$getone = $this->db->fetch_first ( "SELECT * FROM " . DB_TABLEPRE . "user where openid='$openid' limit 0,1" );
			if ($getone == null) {
				$url = SITE_URL . "index.php?account/bind/$openid";
				$content = "<a href='$url'>" . $getone ['username'] . "点击进入账号绑定</a>";
			} else {

				$content = $getone ['username'] . "您已经绑定账号了!";
			}

		}
		if ($keyword == 'openid') {
			$content = "您的openid:" . $object->FromUserName;
		}
		return $content;
	}
	//接收文本消息
	private function receiveText($object) {
		$keyword = trim ( $object->Content );

		$content = "";
		$content = $this->getcontent ( $keyword, $object );
		$type = '';
		$firststr = substr ( $keyword, 0, 1 );
		$laststr = substr ( $keyword, strlen ( $keyword ) - 1, 1 );
		if ($laststr == "#" && $firststr == "#") {
			$type = 'topic'; //表示文章检索
		}
		if ($laststr == "$" && $firststr == "$") {
			$type = 'question'; //表示文章检索
		}
		//        //检索内容
		switch ($type) {
			case 'topic' :
				$topickeyword = trim ( $keyword, "#" );
				$content = array ();
				$query = $this->db->query ( "SELECT * FROM " . DB_TABLEPRE . "topic where title like '%$topickeyword%' order by id desc LIMIT 0,1" );
				while ( $topic = $this->db->fetch_array ( $query ) ) {

					//$topic['viewtime'] = tdate($topic['viewtime']);
					$index = strpos ( $topic ['image'], 'http' );
					if ($index == 0) {
						$content [] = array ("Title" => $topic ['title'], "Description" => "", "PicUrl" => $topic ['image'], "Url" =>url('topic/getone/' . $topic['id'] ));
					} else {
						$content [] = array ("Title" => $topic ['title'], "Description" => "", "PicUrl" => SITE_URL . $topic ['image'], "Url" => url('topic/getone/' . $topic['id'] ));
					}

				}
				break;
			case 'question' :
				$topickeyword = trim ( $keyword, "$" );
				$content = array ();
				$query = $this->db->query ( "SELECT * FROM " . DB_TABLEPRE . "question where title like '%$topickeyword%' order by id desc LIMIT 0,1" );
				while ( $question = $this->db->fetch_array ( $query ) ) {

					//$topic['viewtime'] = tdate($topic['viewtime']);
					$imgsrc = $question ['description'];
					if ($imgsrc == null || $imgsrc == '') {
						$imgsrc = SITE_URL . "static/css/default/avatar.gif"; //get_avatar_dir($question['authorid']);
					}
					$question ['image'] = $imgsrc;

					$content [] = array ("Title" => $question ['title'], "Description" => "", "PicUrl" => $question ['image'], "Url" => SITE_URL . 'index.php?q-' . $question ['id'] . '.html' );

				}
				break;
		}

		if ($content == "") {
			$content = array ();
			//查标签
			$query = $this->db->query ( "SELECT * FROM " . DB_TABLEPRE . "tag where  tagname='$keyword' order by tagquestions desc LIMIT 0,1" );
			while ( $tagitem = $this->db->fetch_array ( $query ) ) {
				
				//$topic['viewtime'] = tdate($topic['viewtime']);
				$imgsrc = $tagitem['tagimage'];
				if ($imgsrc == null || $imgsrc == '') {
					$imgsrc = SITE_URL . "static/images/defaulticon.jpg";
				}
				if (!strstr ( $imgsrc, 'http' )) {
					$imgsrc=SITE_URL.$imgsrc;
				}
				$content [] = array ("Title" => $tagitem['tagname'], "Description" => $tagitem['description'], "PicUrl" =>$imgsrc , "Url" => url('tags/view/' . $tagitem ['tagalias']) );
				
			}
			if(!$content){
			//查问题
			$query = $this->db->query ( "SELECT * FROM " . DB_TABLEPRE . "question where title like '%$keyword%' order by id desc LIMIT 0,1" );
			while ( $question = $this->db->fetch_array ( $query ) ) {
				
				//$topic['viewtime'] = tdate($topic['viewtime']);
				$imgsrc = $question ['description'];
				if ($imgsrc == null || $imgsrc == '') {
					$imgsrc = SITE_URL . "static/css/default/avatar.gif"; //get_avatar_dir($question['authorid']);
				}
				$question ['image'] = $imgsrc;
				
				$content [] = array ("Title" => $question ['title'], "Description" => "", "PicUrl" =>'' , "Url" => url('question/view/' . $question ['id']) );
				
			}
			}
			if(!$content){
				//查文章
				$query = $this->db->query ( "SELECT * FROM " . DB_TABLEPRE . "topic where title like '%$keyword%' order by id desc LIMIT 0,1" );
				while ( $topic = $this->db->fetch_array ( $query ) ) {
					
					//$topic['viewtime'] = tdate($topic['viewtime']);
					
					if (strstr ( $topic ['image'], 'http' )) {
						$content [] = array ("Title" => $topic ['title'], "Description" => "", "PicUrl" => $topic ['image'], "Url" => url('topic/getone/' . $topic ['id'] ));
					} else {
						$content [] = array ("Title" => $topic ['title'], "Description" => "", "PicUrl" => SITE_URL . $topic ['image'], "Url" => url('topic/getone/' . $topic ['id'] ) );
					}
					
				}
			}
		
			
	
		

			if (count ( $content ) == 0) {
				$unword = $this->db->fetch_first ( "SELECT * FROM " . DB_TABLEPRE . "setting where k='unword' limit 0,1" );
				$_content = trim ( $unword ['v'] );

				$content = empty ( $_content ) ? "小编不知道你在说啥" : $_content;
			}

		}
// 		                 if($content=='圣诞快乐'){
// 		                 	@require   '../../lib/wxpay/hongbao/pay.php';
// 		$packet = new Packet();
// 		//
// 		////调取支付方法
// 			$result=$packet->_route('wxpacket',array('openid'=>$object->FromUserName));
// 		//
// 			switch ($result){
// 				case 'SUCCESS':
// 					$content="端午节快乐，送了你一个红包，赶快领取吧！";
// 					break;
// 					default:
// 						$content="红包领取失败，再接再励!".$result;
// 						break;
// 			}
// 		//
// 		                 }


		if (is_array ( $content )) {
			if (isset ( $content [0] )) {
				$result = $this->transmitNews ( $object, $content );
			} else if (isset ( $content ['MusicUrl'] )) {
				$result = $this->transmitMusic ( $object, $content );
			}
		} else {
			$result = $this->transmitText ( $object, $content );
		}
		return $result;
	}

	//接收图片消息
	private function receiveImage($object) {
		$content = array ("MediaId" => $object->MediaId );
		$result = $this->transmitImage ( $object, $content );
		return $result;
	}

	//接收位置消息
	private function receiveLocation($object) {
		$content = "你发送的是位置，经度为：" . $object->Location_Y . "；纬度为：" . $object->Location_X . "；缩放级别为：" . $object->Scale . "；位置为：" . $object->Label;
		$result = $this->transmitText ( $object, $content );
		return $result;
	}

	//接收语音消息
	private function receiveVoice($object) {
		if (isset ( $object->Recognition ) && ! empty ( $object->Recognition )) {
			$content = "你刚才说的是：" . $object->Recognition;
			// $object->content=$object->Recognition;
			//$this->receiveText($object);
			$result = $this->transmitText ( $object, $content );
		} else {
			$content = array ("MediaId" => $object->MediaId );
			$result = $this->transmitVoice ( $object, $content );
		}
		return $result;
	}

	//接收视频消息
	private function receiveVideo($object) {
		$content = array ("MediaId" => $object->MediaId, "ThumbMediaId" => $object->ThumbMediaId, "Title" => "", "Description" => "" );
		$result = $this->transmitVideo ( $object, $content );
		return $result;
	}

	//接收链接消息
	private function receiveLink($object) {
		$content = "你发送的是链接，标题为：" . $object->Title . "；内容为：" . $object->Description . "；链接地址为：" . $object->Url;
		$result = $this->transmitText ( $object, $content );
		return $result;
	}

	//回复文本消息
	private function transmitText($object, $content) {
		if (! isset ( $content ) || empty ( $content )) {
			return "";
		}

		$xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[text]]></MsgType>
    <Content><![CDATA[%s]]></Content>
</xml>";
		$result = sprintf ( $xmlTpl, $object->FromUserName, $object->ToUserName, time (), $content );

		return $result;
	}

	//回复图文消息
	private function transmitNews($object, $newsArray) {
		if (! is_array ( $newsArray )) {
			return "";
		}
		$itemTpl = "        <item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
        </item>
";
		$item_str = "";
		foreach ( $newsArray as $item ) {
			$item_str .= sprintf ( $itemTpl, $item ['Title'], $item ['Description'], $item ['PicUrl'], $item ['Url'] );
		}
		$xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[news]]></MsgType>
    <ArticleCount>%s</ArticleCount>
    <Articles>
$item_str    </Articles>
</xml>";

		$result = sprintf ( $xmlTpl, $object->FromUserName, $object->ToUserName, time (), count ( $newsArray ) );
		return $result;
	}

	//回复音乐消息
	private function transmitMusic($object, $musicArray) {
		if (! is_array ( $musicArray )) {
			return "";
		}
		$itemTpl = "<Music>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <MusicUrl><![CDATA[%s]]></MusicUrl>
        <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
    </Music>";

		$item_str = sprintf ( $itemTpl, $musicArray ['Title'], $musicArray ['Description'], $musicArray ['MusicUrl'], $musicArray ['HQMusicUrl'] );

		$xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[music]]></MsgType>
    $item_str
</xml>";

		$result = sprintf ( $xmlTpl, $object->FromUserName, $object->ToUserName, time () );
		return $result;
	}

	//回复图片消息
	private function transmitImage($object, $imageArray) {
		$itemTpl = "<Image>
        <MediaId><![CDATA[%s]]></MediaId>
    </Image>";

		$item_str = sprintf ( $itemTpl, $imageArray ['MediaId'] );

		$xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[image]]></MsgType>
    $item_str
</xml>";

		$result = sprintf ( $xmlTpl, $object->FromUserName, $object->ToUserName, time () );
		return $result;
	}

	//回复语音消息
	private function transmitVoice($object, $voiceArray) {
		$itemTpl = "<Voice>
        <MediaId><![CDATA[%s]]></MediaId>
    </Voice>";

		$item_str = sprintf ( $itemTpl, $voiceArray ['MediaId'] );
		$xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[voice]]></MsgType>
    $item_str
</xml>";

		$result = sprintf ( $xmlTpl, $object->FromUserName, $object->ToUserName, time () );
		return $result;
	}

	//回复视频消息
	private function transmitVideo($object, $videoArray) {
		$itemTpl = "<Video>
        <MediaId><![CDATA[%s]]></MediaId>
        <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
    </Video>";

		$item_str = sprintf ( $itemTpl, $videoArray ['MediaId'], $videoArray ['ThumbMediaId'], $videoArray ['Title'], $videoArray ['Description'] );

		$xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[video]]></MsgType>
    $item_str
</xml>";

		$result = sprintf ( $xmlTpl, $object->FromUserName, $object->ToUserName, time () );
		return $result;
	}

	//回复多客服消息
	private function transmitService($object) {
		$xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[transfer_customer_service]]></MsgType>
</xml>";
		$result = sprintf ( $xmlTpl, $object->FromUserName, $object->ToUserName, time () );
		return $result;
	}

	//回复第三方接口消息
	private function relayPart3($url, $rawData) {
		$headers = array ("Content-Type: text/xml; charset=utf-8" );
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $rawData );
		$output = curl_exec ( $ch );
		curl_close ( $ch );
		return $output;
	}

	//字节转Emoji表情
	function bytes_to_emoji($cp) {
		if ($cp > 0x10000) { # 4 bytes
			return chr ( 0xF0 | (($cp & 0x1C0000) >> 18) ) . chr ( 0x80 | (($cp & 0x3F000) >> 12) ) . chr ( 0x80 | (($cp & 0xFC0) >> 6) ) . chr ( 0x80 | ($cp & 0x3F) );
		} else if ($cp > 0x800) { # 3 bytes
			return chr ( 0xE0 | (($cp & 0xF000) >> 12) ) . chr ( 0x80 | (($cp & 0xFC0) >> 6) ) . chr ( 0x80 | ($cp & 0x3F) );
		} else if ($cp > 0x80) { # 2 bytes
			return chr ( 0xC0 | (($cp & 0x7C0) >> 6) ) . chr ( 0x80 | ($cp & 0x3F) );
		} else { # 1 byte
			return chr ( $cp );
		}
	}

	//日志记录
	private function logger($log_content) {
		if (isset ( $_SERVER ['HTTP_APPNAME'] )) { //SAE
			sae_set_display_errors ( false );
			sae_debug ( $log_content );
			sae_set_display_errors ( true );
		} else if ($_SERVER ['REMOTE_ADDR'] != "127.0.0.1") { //LOCAL
			$max_size = 1000000;
			$log_filename = "log.xml";
			if (file_exists ( $log_filename ) and (abs ( filesize ( $log_filename ) ) > $max_size)) {
				unlink ( $log_filename );
			}
			file_put_contents ( $log_filename, date ( 'Y-m-d H:i:s' ) . " " . $log_content . "\r\n", FILE_APPEND );
		}
	}
	//最新博客
	function newblog() {
		$content = array ();

		$newtopic = file_get_contents ( SITE_URL . 'index.php?api_article/clist' );

		$de_json = json_decode ( $newtopic, TRUE );

		$count_json = count ( $de_json );
		for($i = 0; $i < 1; $i ++) {

			$content [] = array ("Title" => $de_json [$i] ['Title'], "Description" => $de_json [$i] ['Description'], "PicUrl" => $de_json [$i] ['PicUrl'], "Url" => $de_json [$i] ['Url'] );

		}

		return $content;
	}

	//最热博客
	function hotblog() {
		$content = array ();

		$newtopic = file_get_contents ( SITE_URL . 'index.php?api_article/hotalist' );

		$de_json = json_decode ( $newtopic, TRUE );

		$count_json = count ( $de_json );
		for($i = 0; $i < 1; $i ++) {

			$content [] = array ("Title" => $de_json [$i] ['Title'], "Description" => $de_json [$i] ['Description'], "PicUrl" => $de_json [$i] ['PicUrl'], "Url" => $de_json [$i] ['Url'] );

		}

		return $content;
	}
	//最新问题
	function newquestion() {
		$content = array ();

		$newquestion = file_get_contents ( SITE_URL . 'index.php?api_article/newqlist' );

		$de_json = json_decode ( $newquestion, TRUE );

		$count_json = count ( $de_json );
		for($i = 0; $i < 1; $i ++) {

			$content [] = array ("Title" => $de_json [$i] ['title'], "Description" => '', "PicUrl" => $de_json [$i] ['avatar'], "Url" => $de_json [$i] ['url'] );
		}

		return $content;
	}
	//热门问题
	function hotquestion() {
		$content = array ();
		if (is_https ()) {
			! define ( 'SITE_URL' ) && define ( 'SITE_URL', 'https://' . $_SERVER ['HTTP_HOST'] . '/' );
		} else {
			! define ( 'SITE_URL' ) && define ( 'SITE_URL', 'http://' . $_SERVER ['HTTP_HOST'] . '/' );
		}

		$hotquestion = file_get_contents ( SITE_URL . 'index.php?api_article/hotqlist' );
		$de_json = json_decode ( $hotquestion, TRUE );

		$count_json = count ( $de_json );
		for($i = 0; $i < 1; $i ++) {

			$content [] = array ("Title" => $de_json [$i] ['title'], "Description" => '', "PicUrl" => $de_json [$i] ['avatar'], "Url" => $de_json [$i] ['url'] );
		}

		return $content;
	}
	/* 根据用户UID获得用户头像地址 */
	function get_avatar_dir($uid) {

			$uid = sprintf ( "%09d", $uid );
			$dir1 = substr ( $uid, 0, 3 );
			$dir2 = substr ( $uid, 3, 2 );
			$dir3 = substr ( $uid, 5, 2 );
			$rand = ''; // "?code=" . rand ( 10, 99999999 );
			$avatar_dir = "data/avatar/" . $dir1 . '/' . $dir2 . '/' . $dir3 . "/small_" . $uid;
			if (file_exists ( $avatar_dir . ".jpg" ))
				return SITE_URL . $avatar_dir . ".jpg" . $rand;
				if (file_exists ( $avatar_dir . ".jepg" ))
					return SITE_URL . $avatar_dir . ".jepg" . $rand;
					if (file_exists ( $avatar_dir . ".gif" ))
						return SITE_URL . $avatar_dir . ".gif" . $rand;
						if (file_exists ( $avatar_dir . ".png" ))
							return SITE_URL. $avatar_dir . ".png" . $rand;
		
		// 显示系统默认头像
		return SITE_URL. '/static/css/default/avatar.gif';
	}
}
?>