<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('curl');

class sys_auth
{

    protected $code;
    protected $key;
    protected $member_code;
    protected $curl;

    public function __construct()
    {
        global $_M;
    }

    public function have_auth()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['otherinfo']} WHERE id='1'";
        $key_info = DB::get_one($query);
        if ($key_info['authpass'] && $key_info['authcode']) {
            list($domain, $tempdomain) = explode('|', $key_info['info3']);
            if (is_strinclude($_M['url']['site'], $domain) || is_strinclude($_M['url']['site'], $tempdomain) || is_strinclude($_M['url']['site'], 'localhost') || is_strinclude($_M['url']['site'], '127.0.0.1')) {
                return $key_info;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function dl_auth($key, $code)
    {
        global $_M;
        $curl = load::sys_class('curl', 'new');

        $curl->set('file', "index.php?n=platform&c=authcheck&m=web&a=doauthinfo&key={$key}&code={$code}&domain={$_M['url']['site']}");
        $post = array('post' => '');
        $info = $curl->curl_post($post);
        if ($info == 'fail') {
            $query = "update {$_M['table']['otherinfo']} set info1='',info2='',authcode='',authpass='' where id=1";
            DB::query($query);
            return false;
        } else {
            $usertemp = explode('[!]', $info);
            if ($usertemp['0'] == 1) {
                $info1 = "{$_M['word']['sys_parameter342']}";
            }
            if ($usertemp['0'] == 2) {
                $info1 = "{$_M['word']['usertype3']}";
            }
            if ($usertemp['0'] == 3) {
                $info1 = "{$_M['word']['usertype4']}";
            }
            $query = "update {$_M['table']['otherinfo']} set info1='{$info1}',info2='{$usertemp['1']}',info3='{$usertemp['4']}',authpass='{$usertemp['2']}',authcode='{$usertemp['3']}' where id=1";
            DB::query($query);
            return true;
        }
    }

    public function authinfo()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['otherinfo']} WHERE id='1'";
        $key_info = DB::get_one($query);
        $curl = load::sys_class('curl', 'new');
        $curl->set('file', "index.php?n=platform&c=authcheck&m=web&a=doauth_json&key={$key_info['authpass']}&code={$key_info['authcode']}&domain={$_M['url']['site']}&datatype=data&weblang=cn");
        $post = array('post' => '');
        $info = $curl->curl_post($post);
        $re = jsondecode($info);
        $query = "update {$_M['table']['otherinfo']} set info1='{$re['webtype_h']}' where id=1";
        DB::query($query);
        return $re;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>