<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.


defined('IN_MET') or exit('No permission');

class user_idvalid
{
    public function __construct()
    {
        global $_M;
    }

    /**
     * 发起实名认证
     */
    public function idvalidate()
    {
        global $_M;
        if (!preg_match("/^((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(18[0,5-9]))\d{8}$/", $_M['form']['phone'])) {
            return false;
        } //手机号码不合法
        if (!preg_match("/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/", $_M['form']['idcode'])) {
            return false;
        } //身份证号码不合法

        $data = array();
        $data['express_key'] = $_M['config']['met_idvalid_key'];
        $data['usersite'] = $_M['url']['site'];
        $data['name'] = $_M['form']['realname'];
        $data['idcode'] = $_M['form']['idcode'];
        $data['phone'] = $_M['form']['phone'];

        $url = $_M['url']['api'].'n=userver&c=idvalidate&a=dovalidate';
        $result = $this->curl($url, $data);
        if ($result['status'] == 200) {
            return true;
        } else {
            return false;
        }
    }

    public function checkBalance()
    {
        global $_M;
        $data = array();
        $data['usersite'] = $_M['url']['site'];
        $data['user_key'] = $_M['config']['met_secret_key'];

        $url = $_M['url']['api'].'n=userver&c=idvalidate&a=dogetbalance';
        $result = $this->curl($url, $data);

        return $result;
    }

    public function getexpresskey()
    {
        global $_M;
        $data = array();
        $data['usersite'] = $_M['url']['site'];
        $data['user_key'] = $_M['config']['met_secret_key'];

        $url = $_M['url']['api'].'n=userver&c=idvalidate&a=dogetexpresskey';
        $result = $this->curl($url, $data);

        return $result;
    }

    public function checkNumber()
    {
        global $_M;
        $data = array();
        $data['usersite'] = $_M['url']['site'];
        $data['user_key'] = $_M['config']['met_secret_key'];
        $data['express_key'] = $_M['config']['met_idvalid_key'];

        $url = $_M['url']['api'].'n=userver&c=idvalidate&a=docheck';
        $result = $this->curl($url, $data);

        return $result;
    }

    public function buy()
    {
        global $_M;
        $data = array();
        $data['user_key'] = $_M['config']['met_secret_key'];
        $data['express_key'] = $_M['config']['met_idvalid_key'];
        $data['usersite'] = $_M['url']['site'];
        $data['price'] = $_M['form']['type'];

        $url = $_M['url']['api'].'n=userver&c=idvalidate&a=dobuy';
        $result = $this->curl($url, $data);

        return $result;
    }

    public function getpackage()
    {
        global $_M;
        $data = array();
        $data['usersite'] = $_M['url']['site'];
        $data['user_key'] = $_M['config']['met_secret_key'];

        $url = $_M['url']['api'].'n=userver&c=idvalidate&a=dogetpackage';
        $result = $this->curl($url, $data);

        return $result;
    }

    public function curl($url, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 8);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        //echo $result;
        curl_close($ch);
        if ($result) {
            return json_decode($result, true);
        } else {
            return false;
        }
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.