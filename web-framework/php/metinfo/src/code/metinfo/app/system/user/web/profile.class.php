<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('user/web/class/userweb');

class profile extends userweb
{

    protected $paraclass;
    protected $paralist;
    protected $no;

    public function __construct()
    {
        global $_M;
        parent::__construct();
        $this->paraclass = load::sys_class('para', 'new');
        $this->paralist = $this->paraclass->get_para_list(10, $this->input['classnow']);
        $this->sys_group = load::mod_class('user/sys_group', 'new');
        $this->paygroup_list = $this->sys_group->get_paygroup_list_buyok();
    }

    /*未激活账户重发邮件验证*/
    public function dovalid_email()
    {
        global $_M;
        $valid = load::mod_class('user/web/class/valid', 'new');
        if ($valid->get_email($_M['user']['username'])) {
            $this->success('', $_M['word']['emailsuc']);
        } else {
            $this->error($_M['word']['emailfail']);
        }
    }

    /*基本信息*/
    public function doindex()
    {
        global $_M;
        $_M['config']['own_order'] = 1;
        if (!$_M['user']['valid']) {
            $valid = $_M['config']['met_member_vecan'] == 1 ? 'valid_email' : 'valid_admin';
            $this->view('app/' . $valid, $this->input);
        } else {
            $_M['paralist'] = $this->paralist;
            $_M['paraclass'] = $this->paraclass;

            $paygroupnow = $this->sys_group->get_paygroup_by_id($_M['user']['groupid']);
            foreach ($this->paygroup_list as $pgroup) {
                if ($pgroup['price'] > $paygroupnow['price']) {
                    $groupshow[] = $pgroup;
                }
            }
            $this->input['groupshow'] = $groupshow;
            $this->view('app/profile_index', $this->input);
        }
    }

    public function doinfosave()
    {
        global $_M;
        $infos = $this->paraclass->form_para($_M['form'], 10, $this->input['classnow']);
        $this->paraclass->update_para($_M['user']['id'], $infos, 10);
        $this->userclass->modify_head($_M['user']['id'], $_M['form']['head']);
        okinfo($_M['url']['profile'], $_M['word']['modifysuc']);
    }

    /*帐号安全*/
    public function dosafety()
    {
        global $_M;
        $_M['config']['own_order'] = 2;
        if ($_M['user']['email']) {
            $_M['profile_safety']['emailtxt'] = $_M['user']['email'];
            $_M['profile_safety']['emailbut'] = $_M['word']['modify'];
            $_M['profile_safety']['emailclass'] = 'emailedit';
        } else {
            $_M['profile_safety']['emailtxt'] = $_M['word']['notbound'];
            $_M['profile_safety']['emailbut'] = $_M['word']['binding'];
            $_M['profile_safety']['emailclass'] = 'emailadd';
        }
        if ($_M['user']['tel']) {
            $_M['profile_safety']['teltxt'] = $_M['user']['tel'];
            $_M['profile_safety']['telbut'] = $_M['word']['modify'];
            $_M['profile_safety']['telclass'] = 'teledit';
        } else {
            $_M['profile_safety']['teltxt'] = $_M['word']['notbound'];
            $_M['profile_safety']['telbut'] = $_M['word']['binding'];
            $_M['profile_safety']['telclass'] = 'teladd';
        }
        if ($_M['user']['idvalid']) {
            $_M['profile_safety']['idvalitxt'] = $_M['word']['authen'];
            $_M['profile_safety']['idvalibut'] = $_M['word']['memberDetail'];
            $_M['profile_safety']['idvaliclass'] = 'idvalview';
            $_M['user']['realidinfo'] = $this->userclass->getRealIdInfo($_M['user']);
        } else {
            $_M['profile_safety']['idvalitxt'] = $_M['word']['notauthen'];
            $_M['profile_safety']['idvalibut'] = $_M['word']['binding'];
            $_M['profile_safety']['idvaliclass'] = 'idvaliadd';
        }
        if ($_M['config']['met_member_vecan'] == 1 && $_M['user']['email'] && $_M['user']['email'] == $_M['user']['username']) {
            $_M['profile_safety']['emailbut'] = $_M['word']['accnotmodify'];
            $_M['profile_safety']['disabled'] = 'disabled';
        }

        if ($_M['config']['met_weixin_open'] == 1) {
            $other_user = load::mod_class('user/web/class/other', 'new')->getOtherUserByUid($_M['user']['id'], 'weixin');
            if ($other_user['openid'] != '' && $other_user['openid'] != '#') {
                //已绑定
                $_M['profile_safety']['weixintxt'] = $_M['word']['bound'];
                $_M['profile_safety']['weixinbut'] = $_M['word']['unbind'];
                $_M['profile_safety']['weixinclass'] = 'weixinunbind';

            }else{
                //未绑定
                $_M['profile_safety']['weixintxt'] = $_M['word']['notbound'];
                $_M['profile_safety']['weixinbut'] = $_M['word']['binding'];
                $_M['profile_safety']['weixinclass'] = 'weixinadd';
            }
        }
        $this->input['user'] = $_M['user'];
        $this->view('app/profile_safety', $this->input);
    }

    /*邮箱绑定与修改*/
    public function doemailedit()
    {
        global $_M;
        if ($_M['form']['p']) {
            $auth = load::sys_class('auth', 'new');
            $email = $auth->decode($_M['form']['p']);
            if ($email && $email == $_M['user']['email']) {
                if ($_M['form']['email']) {
                    $valid = load::mod_class('user/web/class/valid', 'new');
                    if ($valid->get_email($_M['form']['email'], 'emailadd')) {
                        okinfo($_M['url']['profile_safety'], $_M['word']['emailsuclink']);
                    } else {
                        okinfo($_M['url']['profile_safety'], $_M['word']['emailfail']);
                    }
                } else {
                    $this->view('app/profile_emailedit', $this->input);
                }
            } else {
                okinfo($_M['url']['profile_safety'], $_M['word']['emailvildtips2']);
            }
        } else {
            $valid = load::mod_class('user/web/class/valid', 'new');
            if ($valid->get_email($_M['user']['email'], 'emailedit')) {
                $this->success('', $_M['word']['emailsuclink']);

            } else {
                $this->error($_M['word']['emailfail']);
            }
        }
    }

    public function doemailok()
    {
        global $_M;
        $valid = true;
        if ($this->userclass->get_user_by_email($_M['form']['email'])) {
            $valid = false;
        }
        echo json_encode(array(
            'valid' => $valid
        ));
    }

    public function dosafety_emailadd()
    {
        global $_M;
        if ($_M['form']['p']) {
            $auth = load::sys_class('auth', 'new');
            $email = $auth->decode($_M['form']['p']);
            $email = sqlinsert($email);
            if ($email) {
                if ($this->userclass->editor_uesr_email($_M['user']['id'], $email)) {
                    okinfo($_M['url']['profile_safety'], $_M['word']['bindingok']);
                } else {
                    okinfo($_M['url']['profile_safety'], $_M['word']['opfail']);
                }
            } else {
                okinfo($_M['url']['profile_safety'], $_M['word']['emailvildtips2']);
            }
        } else {
            if ($this->userclass->get_user_by_email($_M['form']['email'])) {
                okinfo($_M['url']['profile_safety'], $_M['word']['emailhave']);
            }
            $valid = load::mod_class('user/web/class/valid', 'new');
            if ($valid->get_email($_M['form']['email'], 'emailadd')) {
                okinfo($_M['url']['profile_safety'], $_M['word']['emailsuclink']);
            } else {
                okinfo($_M['url']['profile_safety'], $_M['word']['emailfail']);
            }
        }
    }

    /*密码修改*/
    public function dopasssave()
    {
        global $_M;
        //社会化登陆账号
        if ($_M['user']['source']) {
            if ($this->userclass->editor_uesr_password($_M['user']['id'], $_M['form']['password'])) {
                okinfo($_M['url']['profile_safety'], $_M['word']['modifypasswordsuc']);
            }else {
                okinfo($_M['url']['profile_safety'], $_M['word']['opfail']);
            }
        }

        if (md5($_M['form']['oldpassword']) == $_M['user']['password']) {
            if ($this->userclass->editor_uesr_password($_M['user']['id'], $_M['form']['password'])) {
                okinfo($_M['url']['profile_safety'], $_M['word']['modifypasswordsuc']);
            } else {
                okinfo($_M['url']['profile_safety'], $_M['word']['opfail']);
            }
        } else {
            okinfo($_M['url']['profile_safety'], $_M['word']['lodpasswordfail']);
        }
    }

    /*手机绑定与修改*/
    public function dosafety_teledit()
    {
        global $_M;
        if ($_M['form']['code']) {
            $session = load::sys_class('session', 'new');
            if ($_M['form']['code'] != $session->get("phonecode")) {
                $this->error($_M['word']['membercode']);
                die;
            }
            if (time() > $session->get("phonetime")) {
                $this->error($_M['word']['codetimeout']);
                die;
            }
            $session->del('phonecode');
            $session->del('phonetime');
            $session->del('phonetel');
            $this->success();
        } else {
            $valid = load::mod_class('user/web/class/valid', 'new');
            if ($valid->get_tel($_M['user']['tel'])) {
                $this->success();
            } else {
                $this->error($_M['word']['Sendfrequent']);
            }
        }
    }

    public function dosafety_teladd()
    {
        global $_M;
        $session = load::sys_class('session', 'new');
        if ($_M['form']['phonecode'] != $session->get("phonecode")) {
            okinfo($_M['url']['profile_safety'], $_M['word']['membercode']);
        }
        if (time() > $session->get("phonetime")) {
            okinfo($_M['url']['profile_safety'], $_M['word']['codetimeout']);
        }
        if ($_M['form']['tel'] != $session->get("phonetel")) {
            okinfo($_M['url']['profile_safety'], $_M['word']['telcheckfail']);
        }
        $session->del('phonecode');
        $session->del('phonetime');
        $session->del('phonetel');

        if ($this->userclass->editor_uesr_tel($_M['user']['id'], $_M['form']['tel'])) {
            okinfo($_M['url']['profile_safety'], $_M['word']['bindingok']);
        } else {
            okinfo($_M['url']['profile_safety'], $_M['word']['opfail']);
        }

    }

    public function dosafety_telvalid()
    {
        global $_M;
        if ($this->userclass->get_user_by_username($_M['form']['tel'])) {
            $this->error($_M['word']['telreg']);
        }

         $pinok = load::sys_class('pin', 'new')->check_pin($_M['form']['code'] ,$_M['form']['random']);
        if(!$pinok){
            $this->error($_M['word']['membercode']);
        }

        $valid = load::mod_class('user/web/class/valid', 'new');
        if ($valid->get_tel($_M['form']['tel'])) {
            $this->success();
        } else {
            $this->error($_M['word']['Sendfrequent']);
        }
    }

    public function dosafety_telok()
    {
        global $_M;
        $valid = true;
        if ($this->userclass->get_user_by_tel($_M['form']['tel'])) {
            $valid = false;
        }
        echo json_encode(array(
            'valid' => $valid
        ));
    }

    /**
     * 用户实名认证
     */
    public function dosafety_idvalid()
    {
        global $_M;
        if (!load::sys_class('pin', 'new')->check_pin($_M['form']['code'] ,$_M['form']['random'])) {
            okinfo($_M['url']['profile_safety'], $_M['word']['membercode']);
            die();
        }
        $idvalid = load::mod_class('user/include/class/user_idvalid.class.php', 'new');
        $result = $idvalid->idvalidate();
        if (!$result) {
            okinfo($_M['url']['profile_safety'], $_M['word']['idvalidfailed']);
            die();
        }

        $info = $_M['form']['realname'] . "|" . $_M['form']['idcode'] . "|" . $_M['form']['phone'];
        if ($this->userclass->editor_uesr_idvalid($_M['user']['id'], $info)) {
            okinfo($_M['url']['profile_safety'], $_M['word']['idvalidok']);
            die();
        }
    }

    /**
     * 绑定社会化账号
     */
    public function doOtherBind()
    {
        global $_M;
        $type = $_M['form']['type'];
        switch ($type) {
            case 'weixin':
                $rand = random(16).uniqid();
                $weixin_party = load::mod_class('user/web/class/weixin_party', 'new');
                $qrcode = $weixin_party->WXBind($_M['user'],$rand);
                $error = $weixin_party->error;
                break;
            default:
                break;
        }

        if ($error) {
            $this->error($error);
        }else{
            $redata = array();
            $redata['img'] = $qrcode;
            $redata['code'] = $rand;
            $this->success($redata);
        }
    }

    /**
     * 解绑社会化账号
     */
    public function doUnbind()
    {
        global $_M;
        $type = $_M['form']['type'];
        switch ($type) {
            case 'weixin':
                $weixin_party = load::mod_class('user/web/class/weixin_party', 'new');
                $weixin_party->WXUnbind($_M['user']['id']);
                break;
            default:
                break;
        }

        $redata = array();
        $this->success($redata,$_M['word']['jsok']);
    }

    /**
     * 检测绑定状态
     */
    public function docheckBind()
    {
        global $_M;
        $code = $_M['form']['code'];
        $type = $_M['form']['type'];

        switch ($type) {
            case 'weixin':
                $weixin_party = load::mod_class('user/web/class/weixin_party', 'new');
                $other_user = $weixin_party->checkWXBind($code);
                if ($other_user) {
                    $redata = array();
                    $this->success($redata,'微信账号绑定成功');
                }
                break;
            default:
                break;
        }

        $redata = array();
        $this->error($redata);
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>