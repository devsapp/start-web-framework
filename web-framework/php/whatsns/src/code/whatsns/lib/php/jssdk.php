<?php
class JSSDK {
  private $appId;
  private $appSecret;

  public function __construct($appId, $appSecret) {
    $this->appId = $appId;
    $this->appSecret = $appSecret;
  }

  public function getSignPackage() {
    $jsapiTicket = $this->getJsApiTicket();

    // 注意 URL 一定要动态获取，不能 hardcode.
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $timestamp = time();
    $nonceStr = $this->createNonceStr();

    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

    $signature = sha1($string);

    $signPackage = array(
      "appId"     => $this->appId,
      "nonceStr"  => $nonceStr,
      "timestamp" => $timestamp,
      "url"       => $url,
      "signature" => $signature,
      "rawString" => $string
    );
    return $signPackage;
  }

  private function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }

  private function getJsApiTicket() {
    // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode($this->get_php_file("jsapi_ticket.php"));
    if ($data->expire_time < time()) {
      $accessToken = $this->getAccessToken();
      // 如果是企业号用以下 URL 获取 ticket
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
      $res = json_decode($this->httpGet($url));
      $ticket = $res->ticket;
      if ($ticket) {
        $data->expire_time = time() + 7000;
        $data->jsapi_ticket = $ticket;
        $this->set_php_file("jsapi_ticket.php", json_encode($data));
      }
    } else {
      $ticket = $data->jsapi_ticket;
    }

    return $ticket;
  }

  public function getAccessToken() {
    // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode($this->get_php_file("access_token.php"));

    if ($data->expire_time < time()) {

      // 如果是企业号用以下URL获取access_token
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
      $res = json_decode($this->httpGet($url));

      $access_token = $res->access_token;
      if ($access_token) {
        $data->expire_time = time() + 7000;
        $data->access_token = $access_token;

        $this->set_php_file("access_token.php", json_encode($data));
      }
    } else {
      $access_token = $data->access_token;
    }

    return $access_token;
  }
//获取用户基本信息
    public function get_user_info($openid)
    {
    	  $accessToken = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$accessToken."&openid=".$openid."&lang=zh_CN";
        $res = $this->https_request($url);
        return json_decode($res, true);
    }
  //发送模板消息给用户--提现申请
    public function sendtixianshengqingtpltouser($openid,$template_id,$url,$first,$keynote1,$keynote2,$keynote3,$keynote4,$remark){
$data='
 {
            "touser":"'.$openid.'",
           "template_id":"'.$template_id.'",
           "url":"'.$url.'",
           "miniprogram":{
             "appid":"",
             "pagepath":""
           },
           "data":{
                   "first": {
                       "value":"'.$first.'",
                       "color":"#bc723c"
                   },
                   "keyword1":{
                       "value":"'.$keynote1.'"

                   },
                   "keyword2": {
                       "value":"'.$keynote2.'"

                   },
                   "keyword3": {
                       "value":"'.$keynote3.'"

                   },
                     "keyword4": {
                       "value":"'.$keynote4.'"

                   },
                   "remark":{
                       "value":"'.$remark.'",
                       "color":"#173177"
                   }
           }
       }
';
      $accessToken = $this->getAccessToken();
    	$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$accessToken;
$result = $this->https_request($url,$data);
 return json_decode($result, true);
    }
  //发送模板消息给用户--提现审核失败
    public function sendtixianjieguotpltouser($openid,$template_id,$url,$first,$keynote1,$keynote2,$keynote3,$keynote4,$keynote5,$remark){
$data='
 {
            "touser":"'.$openid.'",
           "template_id":"'.$template_id.'",
           "url":"'.$url.'",
           "miniprogram":{
             "appid":"",
             "pagepath":""
           },
           "data":{
                   "first": {
                       "value":"'.$first.'",
                       "color":"#bc723c"
                   },
                   "keyword1":{
                       "value":"'.$keynote1.'"

                   },
                   "keyword2": {
                       "value":"'.$keynote2.'"

                   },
                   "keyword3": {
                       "value":"'.$keynote3.'"

                   },
                     "keyword4": {
                       "value":"'.$keynote4.'"

                   },

                     "keyword5": {
                       "value":"'.$keynote5.'"

                   },
                   "remark":{
                       "value":"'.$remark.'",
                       "color":"#173177"
                   }
           }
       }
';
      $accessToken = $this->getAccessToken();
    	$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$accessToken;
$result = $this->https_request($url,$data);
 return json_decode($result, true);
    }
    //发送模板消息给用户
    public function sendanswertpltouser($openid,$template_id,$url,$first,$keynote1,$keynote2,$keynote3,$remark){
$data='
 {
            "touser":"'.$openid.'",
           "template_id":"'.$template_id.'",
           "url":"'.$url.'",
           "miniprogram":{
             "appid":"",
             "pagepath":""
           },
           "data":{
                   "first": {
                       "value":"'.$first.'",
                       "color":"#bc723c"
                   },
                   "keyword1":{
                       "value":"'.$keynote1.'"

                   },
                   "keyword2": {
                       "value":"'.$keynote2.'"

                   },
                   "keyword3": {
                       "value":"'.$keynote3.'"

                   },
                   "remark":{
                       "value":"'.$remark.'",
                       "color":"#173177"
                   }
           }
       }
';
      $accessToken = $this->getAccessToken();
    	$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$accessToken;
$result = $this->https_request($url,$data);
 return json_decode($result, true);
    }
    //发送消息给用户
   public function sendtexttouser($openid,$msg){
    	$data = '{
 "touser":"'.$openid.'",
 "msgtype":"text",
 "text":
 {
   "content":"'.$msg.'"
 }
}';
    	 $accessToken = $this->getAccessToken();
    	$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$accessToken;
$result = $this->https_request($url,$data);
 return json_decode($result, true);
    }
//https请求
    public function https_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
    //返回用户列表信息
    public function getuserlist($next_openid=""){

    	 $accessToken = $this->getAccessToken();

    $url=$next_openid==""? "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$accessToken":"https://api.weixin.qq.com/cgi-bin/user/get?access_token=$accessToken&next_openid=$next_openid";
     $res = $this->httpGet($url);
        return json_decode($res, true);
    }
    //返回网页授权url
   private function getoauthurl($REDIRECT_URI,$SCOPE){
   	$appId= $this->appId ;


   	return "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appId&redirect_uri=$REDIRECT_URI&response_type=code&scope=$SCOPE&state=STATE#wechat_redirect";
   }
  private function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
    // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);

    curl_close($curl);

    return $res;
  }

  private function get_php_file($filename) {
    return trim(substr(file_get_contents(FCPATH.'lib/php/'.$filename), 15));
  }
  private function set_php_file($filename, $content) {
    $fp = fopen(FCPATH.'lib/php/'.$filename, "w");
    fwrite($fp, "<?php exit();?>" . $content);
    fclose($fp);
  }
}

