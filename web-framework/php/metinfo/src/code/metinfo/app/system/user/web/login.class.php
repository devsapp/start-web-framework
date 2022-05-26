<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('user/web/class/userweb');

class login extends userweb
{

    public function __construct()
    {
        global $_M;
        parent::__construct();
        if ($_M['form']['gourl']) {
            $_M['url']['user_home'] = base64_decode($_M['form']['gourl']);
            if (strpos($_M['url']['login'], 'lang=')) {
                $_M['url']['login'] .= "&gourl=" . $_M['form']['gourl'];
            } else {
                $_M['url']['login'] .= "?gourl=" . $_M['form']['gourl'];
            }
        }
    }

    public function check($pid = '')
    {

    }

    public function doindex()
    {
        global $_M;
        $session = load::sys_class('session', 'new');
        // 如果已登录直接跳转到个人中心
        if ($_M['user']['id']) {
            okinfo($_M['url']['user_home']);
        }

        // 如果从其他页面过来
        if (isset($_SERVER['HTTP_REFERER'])) {
            // 是否从本站过来
            $referer = parse_url($_SERVER['HTTP_REFERER']);
            if ($referer['host'] == $_SERVER['HTTP_HOST']) {
                // 来源页面保存到cookie
                setcookie("referer", $_SERVER['HTTP_REFERER']);
            }
        }

        if (isset($_M['form']['gourl']) && $_M['form']['gourl']) {
            setcookie("referer", base64_decode($_M['form']['gourl']));
        }

        if ($session->get("logineorrorlength") > 3) $_M['code'] = 1;

        $this->view('app/login', $this->input);
    }

    public function dologin()
    {
        global $_M;
        $this->login(authcode($_M['form']['username']), authcode($_M['form']['password']));
    }

    public function login($username, $password, $type = 'pass')
    {
        global $_M;
        $session = load::sys_class('session', 'new');
        $paygroup = load::mod_class('user/sys_group', 'new');

        if ($session->get("logineorrorlength") > 3) {
            if (!load::sys_class('pin', 'new')->check_pin($_M['form']['code'], $_M['form']['random'])) {
                okinfo($_M['url']['user_home'], $_M['word']['membercode']);
            }
        }
        $user = $this->userclass->login_by_password($username, $password, $type);
        if ($user) {
            if (!$user['valid']) {
                okinfo($_M['url']['login'], $_M['word']['membererror6']);
            }

            $session->del('logineorrorlength');
            $this->userclass->set_login_record($user);
            // 如果有来源页面,登录之后跳回原来页面 否则跳到个人中心
            if (isset($_COOKIE['referer']) && !strstr($_COOKIE['referer'], 'member/login') && !strstr($_COOKIE['referer'], 'getpassword')) {
                $referer = $_COOKIE['referer'];
                if (strstr($referer, '/member/register_include.php')) {
                    okinfo($_M['url']['user_home']);
                }
                // 删除cookie保存的来源地址

                setcookie("referer");
                okinfo($referer);

            } else {
                okinfo($_M['url']['user_home']);
            }

        } else {
            $length = $session->get("logineorrorlength");
            $length++;
            $session->set("logineorrorlength", $length);
            okinfo($_M['url']['login'], $_M['word']['membererror1']);
        }
    }

    public function dologout()
    {
        global $_M;
        $this->userclass->logout();
        okinfo($_M['url']['login']);
    }

    /**********社会化登陆************/
    public function doother()
    {
        global $_M;
        $other = $this->other($_M['form']['type']);
        $other->set_state();
        $url = $other->get_login_url();
        okinfo($url);
    }

    /**
     * 社会化登陆验证
     */
    public function doother_login()
    {
        global $_M;
        $type = $_M['form']['amp;type'] ? $_M['form']['amp;type'] : $_M['form']['type'];
        $other = $this->other($type);
        $user = $other->get_user($_M['form']['code']);

        if (!$other->state_ok($_M['form']['state'])) {
            okinfo($_M['url']['login'], $_M['word']['membererror2']);
        }
        if ($user) {
            if ($user['register'] == 1) {//跳转用户注册
                okinfo("{$_M['url']['login_other_info']}&other_id={$user['other_id']}&type={$user['other_type']}");
            }
        } else {
            okinfo($_M['url']['login'], $other->errorno);
        }

        if ($user) {
            $this->login($user['username'], md5($user['password']), 'md5');
        } else {
            okinfo($_M['url']['login'], $_M['word']['membererror3']);
        }
    }

    /**
     * 社会化登录用户名设置
     */
    public function dologin_other_info()
    {
        global $_M;
        if (!$_M['form']['type'] && !$_M['form']['other_id']) {
            okinfo($_M['url']['login'], $_M['word']['regfail']);
        }

        $this->input['type'] = $_M['form']['type'];
        $this->input['other_id'] = $_M['form']['other_id'];

        if($_M['form']['type'] == 'weixin'){
            $this->input['submit_url'] = $_M['url']['weixin_register'];
        }else{
            $this->input['submit_url'] = $_M['url']['login_other_register'];
        }

        //系统生成账号
        if ($_M['config']['met_auto_register']) {
            header("location:{$this->input['submit_url']}&type={$this->input['type']}&other_id={$this->input['other_id']}");
        }else{
            $this->view('app/other_info', $this->input);
        }
    }

    /**
     * 社会化账号注册
     */
    public function dologin_other_register()
    {
        global $_M;
        $type = $_M['form']['type'];
        $other_id = $_M['form']['other_id'];

        //系统生成账号
        if($_M['config']['met_auto_register']){
            $username = random(3, 3) . "_" . uniqid() . random(5);
            $password = random(16);
        }else{
            $username = $_M['form']['username'];
            $password = $_M['form']['password'];
        }

        if (!$type && !$other_id && !$username && !$password) {
            okinfo($_M['url']['login'], $_M['word']['regfail']);
        }

        $other = $this->other($type);
        $uid = $other->register($other_id, $username, $password);
        if ($uid) {
            $user = $this->userclass->get_user_by_id($uid);
            $this->login($user['username'], md5($user['password']), 'md5');
        } else {
            if ($other->errorno == 're_username') {
                okinfo($_M['url']['login_other_info'] . "&other_id={$other_id}&type={$type}",$_M['word']['userhave']);
            } else {
                okinfo($_M['url']['login'], $other->errorno);
            }
        }
    }

    public function other($type)
    {
        global $_M;
        if (!$type) {
            okinfo($_M['url']['login'], $_M['word']['membererror4']);
        }
        if ($type == 'qq') {
            $other = load::mod_class('user/web/class/qq', 'new');
        }
        if ($type == 'weibo') {
            $other = load::mod_class('user/web/class/weibo', 'new');
        }
        if ($type == 'weixin') {
            $other = load::mod_class('user/web/class/weixin', 'new');
        }
        return $other;
    }


    /*******微信扫码登陆*******/
    public function doLoginQrcode()
    {
        global $_M;
        $rand = random(32) . uniqid();
        $weixin_party = load::mod_class('user/web/class/weixin_party', 'new');
        $qrcode = $weixin_party->loginQrcode($rand);

        if ($weixin_party->error) {
            $this->error($weixin_party->error[0]);
        } else {
            $redata = array();
            $redata['img'] = $qrcode;
            $redata['code'] = $rand;
            $this->success($redata);
        }
    }

    /*******微信登陆查询*******/
    public function docheckwxlogin()
    {
        global $_M;
        $code = $_M['form']['code'];
        if (!$code) {
            $this->error('data error');
        }

        $weixin_party = load::mod_class('user/web/class/weixin_party', 'new');
        $check_res = $weixin_party->checkWXlogin($code);

        if ($check_res) {
            if ($check_res['register'] != 1) {//已注册用户
                $user = $check_res['sys_user'];
                $session = load::sys_class('session', 'new');
                $res = $this->userclass->login_by_password($user['username'], md5($user['password']), 'md5');
                $session->del('logineorrorlength');
                $this->userclass->set_login_record($res);

                // 如果有来源页面,登录之后跳回原来页面 否则跳到个人中心
                if (isset($_COOKIE['referer']) && !strstr($_COOKIE['referer'], 'member/login') && !strstr($_COOKIE['referer'], 'getpassword')) {
                    $referer = $_COOKIE['referer'];
                    if (strstr($referer, '/member/register_include.php')) {
                        $url = $_M['url']['user_home'];
                    } else {
                        // 删除cookie保存的来源地址
                        setcookie("referer");
                        $url = $referer;
                    }
                } else {
                    $url = $_M['url']['user_home'];
                }

                if ($_M['config']['met_index_type'] != $_M['lang']){
                    $redata = array();
                    $msg = $_M['weixin_login_error'];
                    $redata['url'] = $_M['url']['login'];
                    $this->success($redata, $msg);
                }

                $redata = array();
                $redata['url'] = $url;
                $msg = $_M['word']['login_ok'];
                $this->success($redata,$msg);
            } else {//提示用户注册
                $openid = $check_res['openid'];
                $type = $check_res['other_type'];
                $url = "{$_M['url']['login_other_info']}&other_id={$openid}&type={$type}";

                $redata = array();
                $redata['url'] = $url;
                $this->success($redata);
            }

        }

        $redata = array();
        $this->error($redata);
    }

    /**
     * 微信用户注册
     */
    public function doregistwxuser()
    {
        global $_M;
        $type = $_M['form']['type'];
        $other_id = $_M['form']['other_id'];

        //系统生成账号
        if($_M['config']['met_auto_register']){
            $username = random(3, 3) . "_" . uniqid() . random(5);
            $password = random(16);
        }else{
            $username = $_M['form']['username'];
            $password = $_M['form']['password'];
        }

        $weixin_party = load::mod_class('user/web/class/weixin_party', 'new');
        $uid = $weixin_party->otherUserRegister($other_id , $username, $password);
        if ($uid) {
            $sys_user = $this->userclass->get_user_by_id($uid);
            $this->login($sys_user['username'], md5($sys_user['password']), 'md5');
        } else {
            if ($weixin_party->re_username) {
                $url = "{$_M['url']['login_other_info']}&other_id={$other_id}&type={$type}";
                okinfo($url,$_M['word']['userhave']);
            }else{
                okinfo($_M['url']['login'], $weixin_party->error[0]);
            }
        }
        okinfo($_M['url']['login'], $weixin_party->error[0]);
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
