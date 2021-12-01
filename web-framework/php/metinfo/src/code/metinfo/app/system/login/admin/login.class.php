<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin.class.php');
load::sys_class('nav.class.php');
load::sys_func('file');

class login extends admin
{
    public function __construct()
    {
        global $_M;
        parent::__construct();
        // $query = "select * from {$_M['table']['language']} where lang='{$_M['form']['langset']}' and site = 1";
        // $langwordlist = DB::get_all($query);
        // foreach ($langwordlist as $key => $value) {
        //     $_M['word'][$value['name']] = $value['value'];
        // }
    }

    //获取后台基本信息
    private function get_info()
    {
        global $_M;
        $met_langadmin = DB::get_all("select * from {$_M['table']['lang_admin']} where lang !='metinfo' AND useok = 1");

        $met_admin_logo = "{$_M['url']['site']}" . str_replace('../', '', $_M['config']['met_agents_logo_index']);
        $met_agents_logo_login = "{$_M['url']['site']}" . str_replace('../', '', $_M['config']['met_agents_logo_login']);;

        $data = array(
            'met_agents_linkurl' => $_M['config']['met_agents_linkurl'] ? $_M['config']['met_agents_linkurl'] : 'https://www.metinfo.cn',
            'met_agents_logo_login' => $met_agents_logo_login,
            'langset' => $_M['langset'],
            'met_langadmin' => $met_langadmin,
            'met_login_code' => $_M['config']['met_login_code'],
            'url' => $_M['url'],
            'met_admin_type_ok' => $_M['config']['met_admin_type_ok'],
            'met_admin_logo' => $met_admin_logo,
            'lang'=>$_M['lang'],
            'langok'=>$_M['user']['langok']
        );
        $sys_json = parent::sys_json();
        $data = array_merge($data, $sys_json);

        return $data;
    }

    public function doindex()
    {
        global $_M;
        if (get_met_cookie('metinfo_admin_name')) {
            header("Location: {$_M['url']['site_admin']}?lang={$_M['lang']}&n=ui_set");
        }
        $data = $this->get_info();

        $_M['url']['own'] = $_M['url']['site'] . 'app/system/login/admin/';
        $_M['url']['own_tem'] = $_M['url']['own'] . 'templates/';
        $_M['url']['own_name'] = $_M['url']['site_admin'] . '?n=login&';
        $_M['url']['own_form'] = $_M['url']['own_name'] . 'c=login&';
        $_M['url']['get_pass'] = $_M['url']['own_name'] . 'c=getpassword&a=doindex&langset=' . $_M['langset'];

        if (is_mobile()) {
            $this->view('sys/mobile/admin/templates/index', $data);
        } else {
            $this->view('sys/login/admin/templates/index', $data);
        }
    }

    //获取后台基本信息（手机端接口）
    public function doGetInfo()
    {
        global $_M;
        $data = $this->get_info();
        $data['config']=$_M['config'];
        $data['auth']= parent::get_auth();

        $this->success($data);
    }

    public function dologin()
    {
        global $_M;

        if (!load::sys_class('pin', 'new')->check_pin($_M['form']['code'], $_M['form']['random']) && $_M['config']['met_login_code']) {
            $this->error($_M['word']['logincodeerror']);
        }

        //密文传输
        if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == 'xmlhttprequest'){
            $username = isset($_M['form']['login_name']) ? authcode($_M['form']['login_name'], "DECODE") : '';
            $password = isset($_M['form']['login_pass']) ? authcode($_M['form']['login_pass'], "DECODE") : '';
        }else{
            $username = isset($_M['form']['login_name']) ? $_M['form']['login_name'] : '';
            $password = isset($_M['form']['login_pass']) ? $_M['form']['login_pass'] : '';
        }

        if (!$username || !$password) {
            $this->error($_M['word']['loginname']);
        }

        $query = "SELECT * FROM {$_M['table']['admin_table']} WHERE admin_id = '{$username}'";
        $admin = DB::get_one($query);
        if ($admin['admin_pass'] === md5($password)) {
            $cookie = $this->login($admin);
            $this->modify_weburl();
            setcookie('page_iframe_url', '', 0, '/');
            if (!isset($_M['form']['submit_type'])) {
                if (is_mobile()) {
                    header('location:./');
                    die;
                } else {
                    header('location:./?n=ui_set');
                    die;
                }
            }

            //写日志
            logs::addAdminLog('logintitle', 'loginadmin', 'log_successfully', 'dologin', $username);

            $this->success($cookie, $_M['word']['log_successfully']);
        }

        $this->error($_M['word']['loginpass']);
    }

    public function dologinout()
    {
        global $_M;
        setcookie('met_auth', '', 0, '/');
        setcookie('met_auths', '', 0, '/');
        setcookie('met_key', '', 0, '/');
        setcookie('page_iframe_url', '', 0, '/');
        setcookie('admin_lang', '', 0, '/');
        //写日志
        logs::addAdminLog('logintitle', 'indexloginout', 'out_of_success', 'dologinout');
        if (is_mobile()) {
            $this->success('', $_M['word']['out_of_success']);
        } else {
            header('Location: ' . $_M['url']['site_admin']);
        }
    }

    public function login($admin)
    {
        global $_M;
        $met_cookie = array();
        $met_cookie['time'] = time();
        $met_cookie['metinfo_admin_name'] = urlencode($admin['admin_id']);
        $met_cookie['metinfo_admin_pass'] = $admin['admin_pass'];
        $met_cookie['metinfo_admin_id'] = $admin['id'];
        $met_cookie['metinfo_admin_type'] = $admin['usertype'];
        $met_cookie['metinfo_admin_pop'] = $admin['admin_type'];
        $met_cookie['metinfo_admin_time'] = time();
        $met_cookie['metinfo_admin_lang'] = $admin['langok'];
        $met_cookie['languser'] = isset($_M['form']['langset']) ? $_M['form']['langset'] : ($admin['admin_login_lang'] ? $admin['admin_login_lang'] : $_M['config']['met_admin_type']);
        $m_now_date = date('Y-m-d H:i:s');
        $m_user_ip = get_userip();
        $json = jsonencode($met_cookie);
        $query = "UPDATE {$_M['table']['admin_table']} SET cookie='{$json}',admin_modify_date='{$m_now_date}',admin_login=admin_login+1,admin_modify_ip='{$m_user_ip}' WHERE admin_id = '{$admin['admin_id']}'";
        DB::query($query);
        $met_key = random(7);
        $admin['admin_pass'] = md5($admin['admin_pass']);

        $auth = authcode("{$admin['admin_id']}\t{$admin['admin_pass']}", 'ENCODE', $_M['config']['met_webkeys'] . $met_key, 86400);
        setcookie('met_auth', $auth, 0, '/');
        setcookie('met_key', $met_key, 0, '/');

        // 设置账号管理的语言
        $lang_ok = explode('-', $admin['langok']);
        $admin_lang = $admin['langok'] == 'metinfo' ? $_M['lang'] : (in_array($_M['lang'], $lang_ok) ? $_M['lang'] : $lang_ok[0]);

        $cookie = array();
        $cookie['met_auth'] = $auth;
        $cookie['met_key'] = $met_key;
        $cookie['admin_lang'] = $admin_lang;

        $query = "UPDATE {$_M['table']['config']} SET `value`=0 WHERE `name`='met_safe_prompt'";
        DB::query($query);

        return $cookie;
    }

    //修改当前网站url
    public function modify_weburl()
    {
        global $_M;
        if (!strstr($_M['config']['met_weburl'], str_replace('www.', '', HTTP_HOST))) {
            /*网址修改*/
            $met_weburl = 'http://' . HTTP_HOST . '/';
            $query = "UPDATE {$_M['table']['config']} set value='{$met_weburl}' WHERE name='met_weburl'";
            DB::query($query);
            /*语言网址修改*/
            $query = "UPDATE {$_M['table']['lang']} SET met_weburl = '{$met_weburl}'";
            DB::query($query);
            /*重新生成404*/
            load::sys_class('curl');
            $curl = new curl();
            $curl->set('host', $_M['url']['site']);
            $curl->set('file', "include/404.php?lang={$_M['config']['met_index_type']}&metinfonow={$_M['config']['met_member_force']}");
            $curl->curl_post();
        }

        deldir(PATH_WEB . 'cache', 1);
    }

    public function check($pid = '')
    {
    }

    //获取所有语言
    public function doGetAllLanguage()
    {
        global $_M;
        $this->success($_M['word']);
    }
}


# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.