<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('user/web/class/userweb');

class getpassword extends userweb
{

    public function __construct()
    {
        global $_M;
        parent::__construct();
    }

    public function check($pid = '')
    {

    }

    public function doindex()
    {
        global $_M;
        require_once $this->view('app/getpassword', $this->input);
    }

    public function doemail()
    {
        global $_M;
        if (!load::sys_class('pin', 'new')->check_pin($_M['form']['code'],$_M['form']['random']) && $_M['config']['met_memberlogin_code']) {
            okinfo($_M['url']['getpassword'], $_M['word']['membercode']);
        }
        load::sys_func('str');
        if (is_email($_M['form']['username'])) {
            $user = $this->userclass->get_user_by_email($_M['form']['username']);
            if (!$user) {
                okinfo($_M['url']['getpassword'], $_M['word']['NoidJS']);
            }
            $valid = load::mod_class('user/web/class/valid', 'new');
            if ($valid->get_email($_M['form']['username'], 'getpassword')) {
                okinfo($_M['url']['login'], $_M['word']['emailsucpass']);
            } else {
                okinfo($_M['url']['login'], $_M['word']['emailfail']);
            }
        } elseif (is_phone($_M['form']['username'])) {
            $user = $this->userclass->get_user_by_tel($_M['form']['username']);
            if (!$user) {
                okinfo($_M['url']['getpassword'], $_M['word']['NoidJS']);
            }
            require_once $this->view('app/getpassword_telset', $this->input);
        } else {
            okinfo($_M['url']['getpassword'], $_M['word']['emailvildtips3']);
        }

    }

    public function dophonecode()
    {
        global $_M;
        $user = $this->userclass->get_user_by_tel($_M['form']['phone']);
        if (!$user) {
            okinfo($_M['url']['getpassword'], $_M['word']['NoidJS']);
        }

        $valid = load::mod_class('user/web/class/valid', 'new');
        if ($valid->get_tel($_M['form']['phone'])) {
            $this->success();
        } else {
            $this->error($_M['word']['membererror5']);
        }

    }

    public function dotelvalid()
    {
        global $_M;
        $session = load::sys_class('session', 'new');
        if ($_M['form']['phonecode'] != $session->get("phonecode")) {
            okinfo($_M['url']['getpassword'], $_M['word']['membercode']);
        }
        if (time() > $session->get("phonetime")) {
            okinfo($_M['url']['getpassword'], $_M['word']['codetimeout']);
        }
        $session->del('phonecode');
        $session->del('phonetime');
        $user = $this->userclass->get_user_by_tel($_M['form']['username']);
        if ($user) {
            if ($this->userclass->editor_uesr_password($user['id'], $_M['form']['password'])) {
                okinfo($_M['url']['login'], $_M['word']['modifypasswordsuc']);
            } else {
                okinfo($_M['url']['login'], $_M['word']['opfail']);
            }
        } else {
            okinfo($_M['url']['login'], $_M['word']['NoidJS']);
        }
    }

    public function dovalid()
    {
        global $_M;
        $auth = load::sys_class('auth', 'new');
        $email = $auth->decode($_M['form']['p']);
        if (!is_email($email)) $email = '';
        if ($email) {
            if ($_M['form']['password']) {
                $user = $this->userclass->get_user_by_email($email);
                if ($user) {
                    if ($this->userclass->editor_uesr_password($user['id'], $_M['form']['password'])) {
                        okinfo($_M['url']['login'], $_M['word']['modifypasswordsuc']);
                    } else {
                        okinfo($_M['url']['login'], $_M['word']['opfail']);
                    }
                } else {
                    okinfo($_M['url']['login'], $_M['word']['NoidJS']);
                }
            }
            require_once $this->view('app/getpassword_mailset', $this->input);
        } else {
            okinfo($_M['url']['register'], $_M['word']['emailvildtips2']);
        }
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>