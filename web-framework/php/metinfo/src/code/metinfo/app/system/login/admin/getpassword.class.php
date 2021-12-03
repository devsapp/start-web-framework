<?php
defined('IN_MET') or exit('No permission');
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

load::sys_class('admin.class.php');
load::sys_class('nav.class.php');
load::sys_func('file');

class getpassword extends admin
{
    public function __construct()
    {
        global $_M;
        parent::__construct();

        //初始化语言
        if (!is_simplestr($_M['langset']) || !is_simplestr($_M['form']['langset'])) {
            die();
        }

        //页面公共数据
        $met_langadmin = DB::get_all("select * from {$_M['table']['lang_admin']} where lang !='metinfo'");
        $data = array(
            'langset' => $_M['langset'],
            'met_langadmin' => $met_langadmin,
            'met_agents_logo_login' => $_M['config']['met_agents_logo_login'],
            'met_agents_linkurl' => $_M['config']['met_agents_linkurl'] ? $_M['config']['met_agents_linkurl'] : 'https://www.metinfo.cn',
        );
        $sys_json = parent::sys_json();
        $data = array_merge($data, $sys_json);
        $this->data = $data;
    }

    public function doindex()
    {
        //http://localhost/Met7.0/admin/?n=login&c=getpassword&a=doindex
        global $_M;
        if (get_met_cookie('metinfo_admin_name')) {
            Header("Location: {$_M['url']['site_admin']}?lang={$_M['lang']}&n=ui_set");
        }

        $abt_type = array();
        $abt_type['sms'] = 1;
        $abt_type['email'] = 1;

        $this->data['url'] = "{$_M['url']['own_form']}a=doInfoSubmit";
        $this->data['description'] = $_M['word']['password1'];
        $this->data['abt_type'] = $abt_type;
        logs::addAdminLog('admin_getpassword', 'doindex', 'OK', 'doindex');
        $this->view('app/getpassword', $this->data);
    }

    /**
     * 提交基本信息
     */
    public function doInfoSubmit()
    {
        global $_M;
        $abt_type = $_M['form']['abt_type'];
        if ($abt_type == 1) {
            $this->data['description'] = $_M['word']['password2'];
            $this->data['title'] = $_M['word']['password3'];
        } elseif ($abt_type == 2) {
            $this->data['description'] = $_M['word']['password4'];
            $this->data['title'] = $_M['word']['password5'];
        }

        $this->data['url'] = "{$_M['url']['own_form']}&a=doSendMsg";
        $this->data['abt_type'] = $abt_type;
        $this->view('app/getpassword', $this->data);
    }


    /*******************/
    /**
     * 找回密码发送邮件或短信
     */
    public function doSendMsg()
    {
        global $_M;
        $form = $_M['form'];

        if ($form['abt_type'] == 1) {
            //短信
            self::getPasswordByMobile($form);
        } elseif ($form['abt_type'] == 2) {
            //邮箱
            self::getPasswordByEmail($form);
        } else {
            die($_M['word']['dataerror']);
        }
    }

    /**
     * 邮箱找回
     * @param array $form
     */
    protected function getPasswordByEmail($form = array())
    {
        global $_M;
        $admin_id = $form['admin_id'];
        $langset = $form['langset'];
        $redata = array();

        if (!is_email($admin_id)) {//邮箱格式错误
            $redata['status'] = 0;
            $redata['msg'] = $_M['word']['password7'];
            $this->ajaxReturn($redata);
        }

        #$query = "SELECT * FROM {$_M['table']['admin_table']} WHERE admin_id='{$admin_id}' and usertype='3'";
        $query = "SELECT * FROM {$_M['table']['admin_table']} WHERE admin_id='{$admin_id}'";
        $admin_list = DB::get_one($query);
        if (!$admin_list) {
            #$query = "SELECT * FROM {$_M['table']['admin_table']} WHERE admin_email='$admin_id' and usertype='3'";
            $query = "SELECT * FROM {$_M['table']['admin_table']} WHERE admin_email='$admin_id'";
            $admin_list = DB::get_one($query);
            if (!$admin_list) {//没有找到对应的管理员
                $redata['status'] = 0;
                $redata['msg'] = $_M['word']['password14'];
                $this->ajaxReturn($redata);
                return;
            }
        }

        if ($admin_list && $admin_list['admin_email'] == '') {
            $redata['status'] = 0;
            $redata['msg'] = $_M['word']['password14'];
            $this->ajaxReturn($redata);
            return;
        }

        if ($admin_list) {
            //拼装加密数据
            $x = md5($admin_list['admin_id'] . '+' . $admin_list['admin_pass']); //验证信息加密
            $outime = 3600 * 24 * 3;
            $string = authcode($admin_list['admin_id'] . "." . $x, 'ENCODE', $_M['config']['met_webkeys'], $outime);
            $string = urlencode($string);
            $mailurl = "{$_M['url']['admin_site']}index.php?n=login&c=getpassword&a=doresetpass&langset={$langset}&abt_type=2&p={$string}";


            //拼装邮件内容
            $admin_name = $admin_list['admin_id'];
            $to = $admin_list['admin_email'];
            $title = $_M['config']['met_webname'] . $_M['word']['getNotice'];

            $body = "<style type='text/css'>\n";
            $body .= "#metinfo{ padding:10px; color:#555; font-size:12px; line-height:1.8;}\n";
            $body .= "#metinfo .logo{ border-bottom:1px dotted #333; padding-bottom:5px;}\n";
            $body .= "#metinfo .logo img{ border:none;}\n";
            $body .= "#metinfo .logo a{ display:block;}\n";
            $body .= "#metinfo .text{ border-bottom:1px dotted #333; padding:5px 0px;}\n";
            $body .= "#metinfo .text p{ margin-bottom:5px;}\n";
            $body .= "#metinfo .text a{ color:#70940E;}\n";
            $body .= "#metinfo .copy{ color:#BBB; padding:5px 0px;}\n";
            $body .= "#metinfo .copy a{ color:#BBB; text-decoration:none; }\n";
            $body .= "#metinfo .copy a:hover{ text-decoration:underline; }\n";
            $body .= "#metinfo .copy b{ font-weight:normal; }\n";
            $body .= "</style>\n";
            $body .= "<div id='metinfo'>\n";
            $logo_url = str_replace('../', $_M['url']['web_site'], $_M['config']['met_logo']);
            $body .= "<div class='logo'><a href='{$_M['config']['met_weburl']}' title='{$_M['config']['met_webname']}'><img src='{$logo_url}' /></a></div>";
            $body .= "<div class='text'><p>{$_M['word']['hello']}{$admin_name}</p><p>{$_M['word']['getTip1']}</p>";
            $body .= "<p><a href='{$mailurl}'>{$mailurl}</a></p>\n";

            //用户邮件
            if ($_M['config']['met_agents_type']) {
                $body .= "</div><div class='copy'>{$this->data['foot']}</a></div>";
            }

            $checkFindByEmail = $this->checkFindByEmail();
            //发送邮件
            $this->jmail = load::sys_class('jmail', 'new');
            $sendMail = $this->jmail->send_email($to, $title, $body);

            if ($sendMail) {
                //成功！！
                $redata['status'] = 0;
                $redata['msg'] = $_M['word']['getTip3'] . $_M['word']['memberEmail'] . '：' . $admin_list['admin_email'];
                logs::addAdminLog('admin_getpassword', 'send_email', 'ok', 'getPasswordByEmail');
            } else {
                $redata['status'] = 0;
                $redata['msg'] = $_M['word']['password30'];
                logs::addAdminLog('admin_getpassword', 'send_email', 'false', 'getPasswordByEmail');
            }

            $this->ajaxReturn($redata);
        }
    }

    /**
     * 检测邮箱服务是否可用
     */
    protected function checkFindByEmail()
    {
        global $_M;
        if (!get_extension_funcs('openssl') && stripos($_M['form']['met_fd_smtp'], '.gmail.com') !== false) {
            $this->error[] = $_M['word']['setbasicTip14'];
            return false;
        }

        if (!get_extension_funcs('openssl') && $_M['form']['met_fd_way'] == 'ssl') {
            $this->error[] = $_M['word']['setbasicTip15'];
            return false;
        }

        if (!function_exists('fsockopen') && !function_exists('pfsockopen') && !function_exists('stream_socket_client')) {
            $this->error[] = $_M['word']['setbasicTip15'];
            return false;
        }
    }

    /**
     * 短信找回
     * @param array $form
     */
    protected function getPasswordByMobile($form = array())
    {
        global $_M;
        $redata = array();
        $admin_id = $form['admin_id'];
        ##$admin_list = DB::get_one("SELECT * FROM {$_M['table']['admin_table']} WHERE admin_id='{$admin_id}' and usertype='3'");
        $admin_list = DB::get_one("SELECT * FROM {$_M['table']['admin_table']} WHERE admin_id='{$admin_id}'");
        if ($admin_list && $admin_list['admin_mobile'] == '') {
            $redata['status'] = 0;
            $redata['msg'] = $_M['word']['password6'];
            $this->ajaxReturn($redata);
        }
        if (!$admin_list) {
            if (!is_phone($admin_id)) {
                $redata['status'] = 0;
                $redata['msg'] = $_M['word']['password7'];
                $this->ajaxReturn($redata);
            }
            #$admin_list = DB::get_one("SELECT * FROM {$_M['table']['admin_table']} WHERE admin_mobile='{$admin_id}' and usertype='3'");
            $admin_list = DB::get_one("SELECT * FROM {$_M['table']['admin_table']} WHERE admin_mobile='{$admin_id}'");
            if (!$admin_list) {
                $redata['status'] = 0;
                $redata['msg'] = $_M['word']['password8'];
                $this->ajaxReturn($redata);
            }
        }

        $code = random(6, 1);    //验证码
        $nber = random(4, 5);    //信息编号
        $cnde = $code . '-' . $nber . '-' . $admin_list['admin_id'];

        //检测短信是否可用
        $checkBySMS = self::checkFindBySMS();
        if (!$checkBySMS) {
            logs::addAdminLog('admin_getpassword', 'sendsms', 'false', 'getPasswordByMobile');
            $redata['status'] = 0;
            $redata['msg'] = $_M['word']['password13'];
            $this->ajaxReturn($redata);
        }

        //发送短信
        ##$message = "{$_M['word']['password9']} {$code} {$_M['word']['password10']} {$nber} [{$_M['url']['web_site']}]";
        $message = "{$_M['word']['password9']} {$code} [{$_M['url']['web_site']}]";
        $sms_obj = load::sys_class('sms', 'new');
        $smsok = $sms_obj->sendsms($admin_list['admin_mobile'], $message);

        if ($smsok['status'] == 200) {
            //拼装加密数据
            $x = md5($admin_list['admin_id'] . '+' . $admin_list['admin_pass']); //验证信息加密
            $outime = 3600 * 24 * 3;
            $string = authcode($admin_list['admin_id'] . "." . $x . '.' . $nber, 'ENCODE', $_M['config']['met_webkeys'], $outime);
            $string = urlencode($string);

            //写入数据库
            $query = "delete from {$_M['table']['otherinfo']} WHERE lang = 'met_cnde'";
            DB::query($query);
            $query = "INSERT INTO {$_M['table']['otherinfo']} SET
    						authpass = '{$cnde}',
    						lang     = 'met_cnde'";
            $res = DB::query($query);

            if ($res) {
                $mobile = substr($admin_list['admin_mobile'], 0, 3) . '****' . substr($admin_list['admin_mobile'], 7, 10);
                $description = $_M['word']['password11'] . '<br/><span class="color999">' . $_M['word']['password12'] . '</span>';

                logs::addAdminLog('admin_getpassword', 'sendsms', 'ok', 'getPasswordByMobile');
                $redata['url'] = $_M['url']['own_form'] . "a=doCodeCheck&abt_type=1&p={$string}";
                $redata['description'] = $description;
                $redata['mobile'] = $mobile;
                $redata['msg'] = $_M['word']['password31'];
                $redata['abt_type'] = 1;
                $redata['status'] = 1;
                $this->ajaxReturn($redata);
            } else {
                logs::addAdminLog('admin_getpassword', 'sendsms', 'false', 'getPasswordByMobile');
                $redata['status'] = 0;
                $redata['msg'] = $_M['word']['password13'];
                $redata['error'] = "data insert failure";
                $this->ajaxReturn($redata);
            }
        } else {
            logs::addAdminLog('admin_getpassword', 'sendsms', 'false', 'getPasswordByMobile');
            $redata['status'] = 0;
            $redata['msg'] = $_M['word']['password13'];
            $redata['error'] = '短信发送失败';
            $this->ajaxReturn($redata);
        }
    }

    /**
     * 短信找回是否可用
     * @return bool
     */
    protected function checkFindBySMS()
    {
        global $_M;
        $sms = load::app_class('met_sms/include/class/met_sms', 'new');
        $res = $sms->get_sms();
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 手机验证码
     */
    public function doCodeCheck()
    {
        global $_M;
        $form = $_M['form'];

        $string = urlencode($form['p']);
        $this->data['url'] = $_M['url']['own_form'] . "a=doCodeCheckSave&abt_type=1&p={$string}";
        $this->data['p'] = $form['p'];
        $this->data['description'] = $_M['word']['password11'];
        $this->view('app/getpassword', $this->data);
    }

    /**
     * 检测验证码跳转
     */
    public function doCodeCheckSave()
    {
        global $_M;
        $form = $_M['form'];
        if ($form['p'] && $form['code']) {
            //解密
            $array = explode('.', authcode($form['p'], 'DECODE', $_M['config']['met_webkeys']));
            $array[0] = daddslashes($array[0]);
            $admin_id = $array[0];
            $x = $array[1];
            $nber = $array[2];
            $string = urlencode($form['p']);

            $sql = "SELECT * FROM {$_M['table']['admin_table']} WHERE admin_id='{$admin_id}'";
            $met_admin = DB::get_one($sql);

            $checkcode = md5($admin_id . '+' . $met_admin['admin_pass']);//验证信息解密
            if ($x != $checkcode) {
                logs::addAdminLog('admin_getpassword', 'CodeCheck', 'false', 'doCodeCheckSave');
                $redata['status'] = 0;
                $redata['msg'] = $_M['word']['dataerror'];
                $this->ajaxReturn($redata);
            }

            //短信验证码核实
            $cnde = $form['code'] . '-' . $nber . '-' . $admin_id;
            $codeok = DB::get_one("SELECT * FROM {$_M['table']['otherinfo']} WHERE authpass='{$cnde}' and lang='met_cnde'");

            if ($codeok) {
                logs::addAdminLog('admin_getpassword', 'CodeCheck', 'ok', 'doCodeCheckSave');
                $redata['url'] = "{$_M['url']['own_form']}&a=doResetpass&abt_type=1&p={$string}&admin_name={$admin_id}&code={$form['code']}";
                $redata['admin_name'] = $admin_id;
                $redata['abt_type'] = 1;
                $redata['status'] = 1;
                $redata['p'] = $string;
                $this->ajaxReturn($redata);
            }
        }

        logs::addAdminLog('admin_getpassword', 'CodeCheck', 'false', 'doCodeCheckSave');
        $redata['status'] = 0;
        $redata['msg'] = $_M['word']['dataerror'];
        $this->ajaxReturn($redata);
        #okinfo($_M['url']['web_site']);

    }


    /******************/
    /**
     * 重置密码
     */
    public function doResetpass()
    {
        global $_M;
        $form = $_M['form'];

        $array = explode('.', authcode($form['p'], 'DECODE', $_M['config']['met_webkeys']));
        $array[0] = daddslashes($array[0]);
        $admin_id = $array[0];
        $x = $array[1];

        $sql = "SELECT * FROM {$_M['table']['admin_table']} WHERE admin_id='{$admin_id}'";
        $met_admin = DB::get_one($sql);

        $passwords = $met_admin['admin_pass'];
        $checkcode = md5($admin_id . '+' . $passwords);//验证信息解密
        if ($x != $checkcode) {//加密信息验证失败
            okinfo($_M['url']['web_site']);
        }

        if ($form['abt_type'] == 1) {
            self::resetPassbyMobile($form);
        } elseif ($form['abt_type'] == 2) {
            self::resetPassbyEmail($form);
        }

        okinfo($_M['url']['web_site']);
    }

    //邮箱找回
    protected function resetPassbyEmail($form)
    {
        global $_M;
        if ($form['p']) {
            $referer = $_M['url']['own_form'] . 'a=dogetpassword&langset=' . $form['langset'];
            $array = explode('.', authcode($form['p'], 'DECODE', $_M['config']['met_webkeys']));
            $array[0] = daddslashes($array[0]);
            $admin_id = $array[0];
            $x = $array[1];
            $string = urlencode($form['p']);

            //
            $sql = "SELECT * FROM {$_M['table']['admin_table']} WHERE admin_id='{$admin_id}'";
            $met_admin = DB::get_one($sql);

            //
            $passwords = $met_admin['admin_pass'];
            $checkcode = md5($admin_id . '+' . $passwords);//验证信息解密
            if ($x != $checkcode) {//加密信息验证失败
                okinfo($referer, $_M['word']['dataerror']);
            }
            $this->data['url'] = "{$_M['url']['own_form']}&a=doResetPassSave&abt_type=2&p={$string}&admin_name={$admin_id}";
            $this->data['admin_name'] = $admin_id;
            $this->data['abt_type'] = 2;
            $this->data['p'] = $string;
            $this->data['description'] = $_M['word']['password16'];

            logs::addAdminLog('admin_getpassword', 'resetPass', 'ok', 'resetPassbyEmail');
            $this->view($this->view('app/getpassword', $this->data));
        }
        logs::addAdminLog('admin_getpassword', 'resetPass', 'false', 'resetPassbyEmail');
        okinfo($_M['url']['web_site'], $_M['word']['dataerror']);
        return false;

    }

    //短信找回
    protected function resetPassbyMobile($form)
    {
        global $_M;
        if ($form['p'] && $form['code']) {
            //解密
            $array = explode('.', authcode($form['p'], 'DECODE', $_M['config']['met_webkeys']));
            $array[0] = daddslashes($array[0]);
            $admin_id = $array[0];
            $x = $array[1];
            $nber = $array[2];
            $string = urlencode($form['p']);

            $sql = "SELECT * FROM {$_M['table']['admin_table']} WHERE admin_id='{$admin_id}'";
            $met_admin = DB::get_one($sql);

            $checkcode = md5($admin_id . '+' . $met_admin['admin_pass']);//验证信息解密
            if ($x != $checkcode) {
                logs::addAdminLog('admin_getpassword', 'resetPass', 'false', 'resetPassbyMobile');
                okinfo($_M['url']['web_site'], $_M['word']['dataerror']);
            }

            //短信验证码核实
            $cnde = $form['code'] . '-' . $nber . '-' . $admin_id;
            $codeok = DB::get_one("SELECT * FROM {$_M['table']['otherinfo']} WHERE authpass='{$cnde}' and lang='met_cnde'");

            if ($codeok) {
                $nbers = explode('-', $codeok['authpass']);
                $code = $nbers[0];
                $nber = $nbers[1];
                $admin_id_other = $nbers[2];

                $this->data['url'] = "{$_M['url']['own_form']}&a=doResetPassSave&abt_type=1&p={$string}&admin_name={$admin_id}&code={$code}";
                $this->data['admin_name'] = $admin_id;
                $this->data['abt_type'] = 1;
                $this->data['status'] = 1;
                $this->data['p'] = $string;
                $this->data['description'] = $_M['word']['password16'];
                logs::addAdminLog('admin_getpassword', 'resetPass', 'ok', 'resetPassbyMobile');
                $this->view($this->view('app/getpassword', $this->data));
            }
        }
        logs::addAdminLog('admin_getpassword', 'resetPass', 'false', 'resetPassbyMobile');
        okinfo($_M['url']['web_site'], $_M['word']['dataerror']);

    }

    /*******************/
    /**
     * 保存新密码
     */
    public function doResetPassSave()
    {
        global $_M;
        $form = $_M['form'];
        $redata = array();

        if ($form['password'] == '' || $form['passwordsr'] == '') {
            $redata['status'] = 0;
            $redata['msg'] = $_M['word']['dataerror'];
            $this->ajaxReturn($redata);
        }
        if ($form['passwordsr'] != $form['password']) {
            $redata['status'] = 0;
            $redata['msg'] = $_M['word']['js6'];
            $this->ajaxReturn($redata);
        }
        /*if ($password == '') okinfo('javascript:history.back();', $_M['word']['dataerror']);
        if ($passwordsr != $password) okinfo('javascript:history.back();', $_M['word']['js6']);*/

        if ($form['abt_type'] == 1) {//短信找回
            self::ResetSaveByMobile($form);
        } elseif ($form['abt_type'] == 2) {
            self::ResetSaveByEmail($form);
        } else {
            $redata['status'] = 0;
            $redata['msg'] = $_M['word']['dataerror'];
            $this->ajaxReturn($redata);
        }
    }

    /**
     * @param array $form
     */
    protected function ResetSaveByMobile($form = array())
    {
        global $_M;

        if ($form['p'] && $form['code']) {
            //解密
            $array = explode('.', authcode($form['p'], 'DECODE', $_M['config']['met_webkeys']));
            $array[0] = daddslashes($array[0]);
            $admin_id = $array[0];
            $x = $array[1];
            $nber = $array[2];

            $sql = "SELECT * FROM {$_M['table']['admin_table']} WHERE admin_id='{$admin_id}'";
            $met_admin = DB::get_one($sql);

            $checkcode = md5($admin_id . '+' . $met_admin['admin_pass']);//验证信息解密
            if ($x != $checkcode) {
                logs::addAdminLog('admin_getpassword', 'resetPassSave', 'false', 'ResetSaveByMobile');
                $redata['status'] = 0;
                $redata['msg'] = $_M['word']['dataerror'];
                $this->ajaxReturn($redata);
            }

            //短信验证码核实
            $cnde = $form['code'] . '-' . $nber . '-' . $admin_id;
            $codeok = DB::get_one("SELECT * FROM {$_M['table']['otherinfo']} WHERE authpass='{$cnde}' and lang='met_cnde'");

            if ($codeok) {
                //删除临时信息
                $query = "delete from {$_M['table']['otherinfo']} where authpass='{$cnde}' and lang='met_cnde'";
                DB::query($query);

                //修改密码
                $password_new = md5($form['password']);
                $query = "update {$_M['table']['admin_table']} set
        			   admin_pass='{$password_new}'
        			   where admin_id='{$admin_id}'";
                DB::query($query);

                //验证新密码
                $query = "SELECT * FROM {$_M['table']['admin_table']} WHERE 
                `admin_id`='{$admin_id}' AND
                 `admin_pass`='{$password_new}'";
                $res = DB::get_one($query);

                if ($res) {
                    logs::addAdminLog('admin_getpassword', 'resetPassSave', 'ok', 'ResetSaveByMobile');
                    $redata['status'] = 1;
                    $redata['url'] = $_M['url']['admin_site'];
                    $redata['msg'] = $_M['word']['jsok'];
                    $this->ajaxReturn($redata);
                } else {
                    logs::addAdminLog('admin_getpassword', 'resetPassSave', 'false', 'ResetSaveByMobile');
                    $redata['status'] = 0;
                    $redata['msg'] = $_M['word']['dataerror'];
                    $this->ajaxReturn($redata);
                }
            }
        }

        $redata['status'] = 0;
        $redata['msg'] = $_M['word']['dataerror'];
        $this->ajaxReturn($redata);
    }

    /**
     * @param $form
     */
    protected function ResetSaveByEmail($form = array())
    {
        global $_M;
        $redata = array();

        if (!$form['p']) {
            logs::addAdminLog('admin_getpassword', 'resetPassSave', 'false', 'ResetSaveByEmail');
            $redata['status'] = 0;
            $redata['msg'] = $_M['word']['dataerror'];
            $this->ajaxReturn($redata);
        }

        $array = explode('.', authcode($form['p'], 'DECODE', $_M['config']['met_webkeys']));
        $array[0] = daddslashes($array[0]);
        $admin_id = $array[0];
        $x = $array[1];

        //
        $sql = "SELECT * FROM {$_M['table']['admin_table']} WHERE admin_id='{$admin_id}'";
        $met_admin = DB::get_one($sql);

        //
        $password = $met_admin['admin_pass'];
        $checkcode = md5($admin_id . '+' . $password);//验证信息解密
        if ($x != $checkcode) {//加密信息验证失败
            logs::addAdminLog('admin_getpassword', 'resetPassSave', 'false', 'ResetSaveByEmail');
            $redata['status'] = 0;
            $redata['msg'] = $_M['word']['dataerror'];
            $this->ajaxReturn($redata);
        }

        //更新管理员密码
        $password_new = md5($form['password']);
        $query = "update {$_M['table']['admin_table']} set
        			   admin_pass='{$password_new}'
        			   where admin_id='{$admin_id}'";
        DB::query($query);

        //验证新密码
        $query = "SELECT * FROM {$_M['table']['admin_table']} WHERE 
                `admin_id`='{$admin_id}' AND
                 `admin_pass`='{$password_new}'";
        $res = DB::get_one($query);

        if ($res) {
            logs::addAdminLog('admin_getpassword', 'resetPassSave', 'ok', 'ResetSaveByEmail');
            $redata['status'] = 1;
            $redata['url'] = $_M['url']['admin_site'];
            $redata['msg'] = $_M['word']['jsok'];
            $this->ajaxReturn($redata);
        } else {
            logs::addAdminLog('admin_getpassword', 'resetPassSave', 'false', 'ResetSaveByEmail');
            $redata['status'] = 0;
            $redata['msg'] = $_M['word']['dataerror'];
            $this->ajaxReturn($redata);
        }
    }

    /****/
    public function check($pid = '')
    {
        return;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>