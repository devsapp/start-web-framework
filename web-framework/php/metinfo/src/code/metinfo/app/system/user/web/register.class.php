<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('user/web/class/userweb');

class register extends userweb
{

    public $paralist;
    public $paraclass;

    public function __construct()
    {
        global $_M;
        parent::__construct();
        isset($_SESSION) ? "" : load::sys_class('session', 'new');
        if (!$_M['config']['met_member_register']) {
            okinfo($_M['url']['login'], $_M['word']['regclose']);
        }
        $this->paraclass = load::sys_class('para', 'new');
        $paralist = $this->paraclass->get_para_list(10);
        foreach ($paralist as $val) {
            if ($val['wr_oks']) $paralists[] = $val;
        }
        $this->paralist = $paralists;
        $_M['paralist'] = $this->paralist;
        $_M['paraclass'] = $this->paraclass;
    }

    public function check($pid = '')
    {

    }

    public function doindex()
    {
        global $_M;
        if ($_M['user']['id']) {
            okinfo($_M['url']['user_home']);
        }

        $this->view('app/register', $this->input);
    }

    public function dosave()
    {
        global $_M;
        $info = $this->paraclass->form_para($_M['form'], 10);
        switch ($_M['config']['met_member_vecan']) {
            case 1://邮箱注册
                $pinok = load::sys_class('pin', 'new')->check_pin($_M['form']['code'] ,$_M['form']['random']);
                if (!$pinok && $_M['config']['met_memberlogin_code']) {
                    okinfo(-1, $_M['word']['membercode']);
                }
                $res = $this->userclass->get_user_by_username($_M['form']['username']);
                if ($res) {
                    okinfo(-1, $_M['word']['emailhave']);
                }
                $register_result = $this->userclass->register($_M['form']['username'], $_M['form']['password'], $_M['form']['username'], '', $info, 0);
                if ($register_result) {
                    $valid = load::mod_class('user/web/class/valid', 'new');
                    $user = array();
                    $user['id'] = $register_result;
                    $this->userclass->set_login_record($user);
                    if ($valid->get_email($_M['form']['username'])) {
                        //管理员通知
                        self::adminNotice($_M['form']['username']);

                        $this->userclass->login_by_password($_M['form']['username'], $_M['form']['password']);
                        okinfo($_M['url']['profile'], $_M['word']['emailchecktips1']);
                    } else {
                        okinfo($_M['url']['login'], $_M['word']['emailfail']);
                    }
                } else {
                    okinfo(-1, $_M['word']['regfail']);
                }
                break;
            case 3://手机注册
                $session = load::sys_class('session', 'new');
                if ($_M['form']['phonecode'] != $session->get("phonecode")) {
                    okinfo(-1, $_M['word']['phonecodeerror']);
                }
                if (time() > $session->get("phonetime")) {
                    okinfo(-1, $_M['word']['codetimeout']);
                }

                $_M['form']['username'] = $_M['form']['phone'];
                if ($_M['form']['username'] != $session->get("phonetel")) {
                    okinfo(-1, $_M['word']['telcheckfail']);
                }
                $session->del('phonecode');
                $session->del('phonetime');
                $session->del('phonetel');
                $register_result = $this->userclass->register($_M['form']['phone'], $_M['form']['password'], '', $_M['form']['username'], $info, 1);
                if ($register_result) {
                    //管理员通知
                    self::adminNotice($_M['form']['username']);

                    $user = array();
                    $user['id'] = $register_result;
                    $this->userclass->set_login_record($user);
                    $this->userclass->login_by_password($_M['form']['username'], $_M['form']['password']);
                    okinfo($_M['url']['profile'], $_M['word']['regsuc']);
                } else {
                    okinfo(-1, $_M['word']['regfail']);
                }
                break;
            default ://默认注册
                //验证码
                if (!load::sys_class('pin', 'new')->check_pin($_M['form']['code'] ,$_M['form']['random']) && $_M['config']['met_memberlogin_code']) {
                    okinfo(-1, $_M['word']['membercode']);
                }

                //字段检测
                self::check_field();

                $valid = $_M['config']['met_member_vecan'] == 2 ? 0 : 1;
                $turnovertext = $_M['config']['met_member_vecan'] == 2 ? $_M['word']['js25'] : $_M['word']['regsuc'];
                $register_result = $this->userclass->register($_M['form']['username'], $_M['form']['password'], '', '', $info, $valid);
                if ($register_result) {
                    //管理员通知
                    self::adminNotice($_M['form']['username']);

                    $user = array();
                    $user['id'] = $register_result;
                    $this->userclass->set_login_record($user);
                    $this->userclass->login_by_password($_M['form']['username'], $_M['form']['password']);
                    okinfo($_M['url']['profile'], $turnovertext);
                } else {
                    okinfo(-1, $_M['word']['regfail']);
                }
                break;
        }
    }

    /**
     * 管理员通知
     */
    public function adminNotice($usernaem = '')
    {
        global $_M;
        //管理员通知
        $this->notice = $other = load::mod_class('user/web/class/notice', 'new');;
        $this->notice->notice_by_emial($usernaem);
        $this->notice->notice_by_sms($usernaem);
    }

    /**
     * 字段检测
     */
    protected function check_field()
    {
        global $_M;
        $paralist = load::mod_class('parameter/parameter_database', 'new')->get_parameter('10');
        foreach ($paralist as $key => $val) {
            $para[$val['id']] = $val;
        }

        $paraarr = array();
        $form = $_M['form'];
        foreach (array_keys($form) as $vale) {
            if (strstr($vale, 'info_')) {
                $arr = explode('_', $vale);
                $paraarr[] = str_replace('info_', '', $arr[1]);
            }
        }

        //必填属性验证
        foreach (array_keys($para) as $val) {
            if ($para[$val]['wr_ok'] == 1 /*&& in_array($val, $paraarr)*/) {
                if ($_M['form']['info_' . $val] == '') {
                    $info = "【{$para[$val]['name']}】" . $_M['word']['noempty'];
                    okinfo('javascript:history.back();', $info);
                }
            }
        }
    }


    public function doemailvild()
    {
        global $_M;
        $auth = load::sys_class('auth', 'new');
        $username = $auth->decode($_M['form']['p']);
        $username = sqlinsert($username);
        if ($username) {
            if ($this->userclass->get_user_valid($username)) {
                okinfo($_M['url']['login'], $_M['word']['activesuc']);
            } else {
                okinfo($_M['url']['register'], $_M['word']['emailvildtips1']);
            }
        } else {
            okinfo($_M['url']['register'], $_M['word']['emailvildtips2']);
        }
    }

    public function douserok()
    {
        global $_M;
        $valid = true;
        if ($this->userclass->get_user_by_username_sql($_M['form']['username']) || $this->userclass->get_admin_by_username_sql($_M['form']['username'])) {
            $valid = false;
        }
        echo json_encode(array(
            'valid' => $valid
        ));
    }

    public function dophonecode()
    {
        global $_M;
        $pinok = load::sys_class('pin', 'new')->check_pin($_M['form']['code'] ,$_M['form']['random']);
        if(!$pinok){
            $this->error($_M['word']['membercode']);
        }
		if($this->userclass->get_user_by_username($_M['form']['phone'])){
			$this->error($_M['word']['telreg']);
		}

        $valid = load::mod_class('user/web/class/valid', 'new');
        $res = $valid->get_tel($_M['form']['phone']);
        if ($res['status'] == 200) {
            $this->success('', $_M['word']['getOK']);
        } else {
            if ($res['msg']) {
                $this->error($res['msg']);
            }
            $this->error($_M['word']['getFail']);
        }
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>