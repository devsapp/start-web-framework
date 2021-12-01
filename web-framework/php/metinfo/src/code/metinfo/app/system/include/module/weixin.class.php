<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');
load::sys_class('web');
ini_set('display_errors', 1);
error_reporting(E_ERROR | E_PARSE);

//接口初始化
class weixin extends web {

    public $weixin;

    public function __construct() {
        global $_M;
        parent::__construct();
        $this->weixin = load::mod_class('weixin/weixinapi','new');
        $this->reply = load::mod_class('weixin/weixinreply','new');
    }

    public function doindex() {
        global $_M;
        die("wexin api");
    }

    /**
     * 微信服务器请求入口
     */
    public function doapi() {
        global $_M;
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            //微信服务器接入验证
            $echostr = $this->weixin->checkSignature($_M['form']);
            echo $echostr;
        }else{
            $postStr = file_get_contents("php://input");

            $reply = $this->reply->getContent($postStr);
            echo '';
        }
    }

    /**
     * 登陆二维码
     */
    /*public function doLoginQrcode()
    {
        global $_M;
        $rand = random(16).uniqid();
        $qrcode = $this->weixin->QRcode('login&'.$rand);

        if ($this->weixin->error) {
            $this->error($this->weixin->error);
        }else{
            $redata = array();
            $redata['img'] = $qrcode;
            $redata['code'] = $rand;
            $this->success($redata);
        }
    }*/

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
