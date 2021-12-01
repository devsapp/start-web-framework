<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_func('admin');

/**
 * 微信api请求
 * Class weixinapi
 */
class weixinapi
{
    public $error;
    protected $appid;
    protected $secret;

    public function __construct()
    {
        global $_M;
        $this->error = array();
        self::loadWeixinConf();

    }

    protected function loadWeixinConf()
    {
        global $_M;
        $this->secret = $_M['config']['met_weixin_gz_appsecret'];
        $this->appid = $_M['config']['met_weixin_gz_appid'];
        $this->token = $_M['config']['met_weixin_gz_token'];
    }

    /**
     * 接口获取 access_token
     * @return bool|mixed
     */
    protected function getWxToken()
    {
        global $_M;
        $api = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->secret}";
        $res = file_get_contents($api);
        if($res){
            $info = json_decode($res,true);
            if ($info['access_token']) {
                $info['expires_in'] = time() + $info['expires_in'];
                cache::put('access_token',$info);
            }
            return $info;
        }else{
            return false;
        }
    }

    /**
     * 加测token是否失效
     * @param string $access_token
     * @return bool
     */
    protected function checkToken($access_token = '')
    {
        global $_M;
        $res = file_get_contents("https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token={$access_token}");
        if($res){
            //errcode 40001
            $info = json_decode($res,true);
            if ($info['ip_list']) {
                return true;
            }
        }
        return false;
    }

    /**
     * 检测接口是否配置正常
     * @return bool|mixed
     */
    public function apiCheck()
    {
        $info = self::getWxToken();
        return $info;
    }

    /**
     * 获取 access_token
     * @return bool
     */
    public function getToken()
    {
        global $_M;

        if((!$this->appid || !$this->secret) && $_M['form']['a']){
            $this->error[] = '请先配置AppID和AppSecret';
            return false;
        }

        $info = cache::get('access_token');
        if(!$info){
            $info = self::getWxToken();
        }else{
            if($info['expires_in'] < time() || !self::checkToken($info['access_token'])){
                $info = self::getWxToken();
            }
        }

        if(!$info){
            $this->error[] = '获取access_token错误';
            return false;
        }

        if($info['errcode']){
            $e_list = array(
                '-1' => "系统繁忙，此时请开发者稍候再试",
                '40001' => "AppSecret错误或者AppSecret不属于这个公众号，请开发者确认AppSecret的正确性",
                '40002' => "请确保grant_type字段值为client_credential",
                '40164' => "调用接口的IP地址不在白名单中，请在接口IP白名单中进行设置。（小程序及小游戏调用不要求IP地址在白名单内。）",
                '89503' => "此IP调用需要管理员确认,请联系管理员",
                '89501' => "此IP正在等待管理员确认,请联系管理员",
                '89506' => "24小时内该IP被管理员拒绝调用两次，24小时内不可再使用该IP调用",
                '89507' => "1小时内该IP被管理员拒绝调用一次，1小时内不可再使用该IP调用",
                '40125' => "AppSecret 验证失败",
            );
            $error = array(
                'errcode' => $info['errcode'],
                'errmsg' => $info['errmsg'].'--'.$e_list[$info['errcode']]
            );
            $this->error[] = $error;
            file_put_contents(__DIR__ . '/wx_error.txt', var_export($error, true));
            return false;
        }
        return $info['access_token'];
    }

    /**
     * 微信服务器接入验证
     * @return mixed
     */
    public function checkSignature($form = array())
    {
        global $_M;
        $signature = $form["signature"];
        $timestamp = $form["timestamp"];
        $nonce     = $form["nonce"];
        $token     = $this->token;
        $signkey   = array($token, $timestamp, $nonce);
        sort($signkey, SORT_STRING);
        $signString = implode($signkey);
        $signString = sha1($signString);
        if ($signString == $signature) {
            return $form["echostr"];
        } else {
            return false;
        }
        //file_put_contents(__DIR__ . '/data.txt', var_export($_M['form'] , true));
    }

    /**
     * 获取参数二维码
     * @param string $info
     * @return bool|string
     */
    public function QRcode($info = '')
    {
        global $_M;
        $access_token = $this->getToken();
        $api = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token={$access_token}";
        $data = array(
            'expire_seconds' => 604800,
            'action_name' => 'QR_STR_SCENE',
            'action_info' => array(
                'scene'=>array(
                    'scene_str' => $info,
                )
            ),
        );
        $data = json_encode($data);
        $res = self::curl_post($api,$data);
        $res = json_decode($res,true);
        if ($res['ticket']) {
            $ticket = urlencode($res['ticket']);
            $QRcode = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket={$ticket}";
            return $QRcode;
        }else{
            $this->error[] = $res;
            return false;
        }
    }

    /**
     * 获取微信用户信息
     * @param string $openid
     * @return bool|mixed|string
     */
    public function getwxUser($openid = '')
    {
        global $_M;
        $access_token = $this->getToken();
        $api = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN";
        $res = file_get_contents($api);
        $res = json_decode($res , true);
        if (!$res['errcode']) {
            return $res;
        }else{
            $this->error[] = $res;
            return false;
        }
    }

    /**
     * 发送客服通知
     * @param array $msg
     * @return bool|void
     */
    public function customMessage($open_id = '', $msg = '', $type = 'text')
    {
        global $_M;
        if (!$msg ) {
            $this->error[] = '消息不能为空';
            return false;
        }
        if (!$open_id) {
            $this->error[] = 'open_id 不能为空';
            return false;
        }

        $message = array();
        $message['touser'] = $open_id;
        $message['msgtype'] = $type;

        switch ($type) {
            case 'text'://发送文本消息
                $message['text'] = array(
                    'content' => $msg
                );
                break;
            case 'image'://发送图片消息
                $message['image'] = array(
                    'media_id' => $msg
                );
                break;
            case 'image'://发送语音消息
                $message['voice'] = array(
                    'media_id' => $msg
                );
                break;
            case 'video'://发送语音消息
                $message['video'] = array(
                    'media_id' => $msg['media_id'],
                    'thumb_media_id' => $msg['media_id'],
                    'title' => $msg['title'],
                    'description' => $msg['description'],
                );
                break;
            default:
                $message['text'] = array(
                    'content' => $msg
                );
                break;
        }

        if (version_compare(phpversion(), '5.4.0', '>=')) {
            $redata = json_encode($message, JSON_UNESCAPED_UNICODE);
        }else{
            $redata = jsonencode($message);
        }
        $access_token = $this->getToken();
        $api = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
        $res = $this->curl_post($api, $redata);
//        file_put_contents(__DIR__ . '/wx_msg.txt', var_export($redata, true));
//        file_put_contents(__DIR__ . '/wx_msg_res.txt', var_export($res, true));
        return;
    }

    /****工具方法***/
    public function curl_post($url = '', $data = '')
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $r = curl_exec($ch);
        curl_close($ch);
        return $r;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
