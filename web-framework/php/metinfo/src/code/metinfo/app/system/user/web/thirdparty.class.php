<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('user/web/class/userweb');

class thirdparty extends userweb
{

    protected $paraclass;
    protected $paralist;
    protected $no;

    public function __construct()
    {
        global $_M;
        parent::__construct();
    }

    //三方站好绑定
    public function doThirdPartyBind()
    {
        global $_M;
        $type = $_M['form']['type'];
        switch ($type) {
            case 'weixin':
                $rand = random(16).uniqid();



                $weixinapi = load::mod_class('weixin/weixinapi','new');
                $qrcode = $weixinapi->QRcode('bind&'.$rand);
                break;
            default:
                break;
        }

        if ($weixinapi->error) {
            $this->error($weixinapi->error);
        }else{
            $redata = array();
            $redata['img'] = $qrcode;
            $redata['code'] = $rand;
            $this->success($redata);
        }
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>