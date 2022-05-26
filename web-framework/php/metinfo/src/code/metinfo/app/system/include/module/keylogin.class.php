<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

load::sys_class('web');
load::sys_func('array');
load::sys_func('file');

class keylogin extends web
{//一键登录功能

    function __construct()
    {
        parent::__construct();
    }

    public function dologin()
    {
        global $_M;
        //$_M['form']['metmd5'] = '';//自动登录发起串，由服务器传入
        if ($admin = $this->sendmetmd5($_M['form']['metmd5'])) {//用curl模块远程访问服务器http://account.metinfo.cn/keylogin/md5check
            //$_M['form']['loginpass']服务器返回用于登录的用户后台的账号密码MD5，如md5(md5(admin123456))
            //验证账号，密码进行登录
            $this->login($admin);
            $this->modify_weburl();
            header("location:../{$_M['config']['met_adminfile']}/index.php?lang=" . $_M['config']['met_index_type']);
        } else {
            if ($this->sendmetmd5_error == -2) {
                echo $_M['word']['linkmetinfoerror'];
            }
            if ($this->sendmetmd5_error == -1) {
                echo $_M['word']['appusererror'];
            }
        }
    }

    public function dotestlogin()
    {
        global $_M;
        //$_M['form']['metmd5'] = '';//自动登录发起串，由服务器传入
        if ($this->sendmetmd5($_M['form']['metmd5'])) {//用curl模块远程访问服务器http://account.metinfo.cn/keylogin/md5check
            //$_M['form']['loginpass']服务器返回用于登录的用户后台的账号密码MD5，如md5(md5(admin123456))
            //验证账号密码。正确返回绑定成功,成功输出1，失败输出0
            echo "metinfosuc|1";
        } else {
            echo "metinfosuc|{$this->sendmetmd5_error}";
        }
    }


    public function sendmetmd5($metmd5)
    {
        global $_M;
        load::sys_class('curl');
        $curl = new curl();
        $curl->set('host', 'http://app.metinfo.cn');
        $curl->set('file', "/index.php?n=platform&c=server_keylogin&a=domd5check");
        $post['metmd5'] = $metmd5;
        $return = $curl->curl_post($post, 180);
        list($state, $loginpass) = explode('|', $return);
        if ($state != 'suc') {
            $this->sendmetmd5_error = '-2';
            return false;
        }
        $query = "SELECT * FROM {$_M['table']['admin_table']}";
        $admins = DB::get_all($query);
        foreach ($admins as $key => $val) {
            if (md5(md5($val['admin_id'] . $val['admin_pass'])) == $loginpass) {
                $this->sendmetmd5_error = '0';
                return $val;
            }
        }
        $this->sendmetmd5_error = '-1';
        return false;
    }

    function login($admin)
    {
        global $_M;
        $met_cookie = array();
        $met_cookie['time'] = time();
        $met_cookie['metinfo_admin_name'] = $admin['admin_id'];
        $met_cookie['metinfo_admin_pass'] = $admin['admin_pass'];
        $met_cookie['metinfo_admin_id'] = $admin['id'];
        $met_cookie['metinfo_admin_type'] = $admin['usertype'];
        $met_cookie['metinfo_admin_pop'] = $admin['admin_type'];
        $met_cookie['metinfo_admin_time'] = time();
        $met_cookie['metinfo_admin_lang'] = $admin['langok'];
        $m_now_date = date('Y-m-d H:i:s');
        $m_user_ip = get_userip();
        $json = json_encode($met_cookie);
        $query = "update {$_M['table']['admin_table']} set cookie='{$json}',admin_modify_date='{$m_now_date}',admin_login=admin_login+1,admin_modify_ip='{$m_user_ip}' WHERE admin_id = '{$admin['admin_id']}'";
        DB::query($query);
        $met_key = random(7);
        $admin[admin_pass] = md5($admin[admin_pass]);

        $auth = authcode("{$admin[admin_id]}\t{$admin[admin_pass]}", 'ENCODE', $_M['config']['met_webkeys'] . $met_key, 86400);
        setcookie("met_auth", $auth, 0, '/');
        setcookie("met_key", $met_key, 0, '/');
    }

    function modify_weburl()
    {
        global $_M;
        if (!strstr($_M['config']['met_weburl'], str_replace('www.', '', HTTP_HOST))) {
            /*网址修改*/
            $met_weburl = "http://" . HTTP_HOST . '/';
            $query = "UPDATE {$_M['table']['config']} set value='{$met_weburl}' WHERE name='met_weburl'";
            DB::query($query);
            /*语言网址修改*/
            $query = "UPDATE {$_M['table']['lang']} SET met_weburl = '{$met_weburl}'";
            DB::query($query);
            /*重新生成404*/
            $gent = "{$_M['url']['site']}include/404.php?lang={$_M['config']['met_index_type']}&metinfonow={$_M['config']['met_member_force']}";
            load::sys_class('curl');
            $curl = new curl();
            $curl->set('host', $_M['url']['site']);
            $curl->set('file', "include/404.php?lang={$_M['config']['met_index_type']}&metinfonow={$_M['config']['met_member_force']}");
            $curl->curl_post();
        }
        deldir(PATH_WEB . 'cache', 1);
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>