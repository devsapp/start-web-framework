<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin');

/**
 * 会员管理
 * Class admin_user
 */
class admin_user extends admin
{
    public $module;
    public $userclass;
    public $group;

    public function __construct()
    {
        parent::__construct();
        global $_M;
        $this->module = 10;
        $this->userclass = load::sys_class('user', 'new');
        $this->group = load::sys_class('group', 'new');
    }

    /**
     * 获取会员列表
     */
    public function doGetUserList()
    {
        global $_M;
        $groupid = isset($_M['form']['groupid']) ? $_M['form']['groupid'] : '';
        $keyword = isset($_M['form']['keyword']) ? $_M['form']['keyword'] : '';
        $idvalid = isset($_M['form']['idvalid']) ? $_M['form']['idvalid'] : '';

        //获取用户组
        $user_group = array();
        $group = DB::get_all("SELECT id,name FROM {$_M['table']['user_group']} WHERE lang = '{$_M['lang']}'");
        foreach ($group as $key => $val) {
            $user_group[$val['id']] = $val['name'];
        }

        $search = $groupid ? " and groupid = '{$groupid}'" : '';
        //是否实名认证
        $search .= $idvalid ? ($idvalid == 1 ? " and idvalid = '1'" : " and (idvalid is null or idvalid = 0)") : '';
        $search .= $keyword ? " and (username like '%{$keyword}%' || email like '%{$keyword}%' || tel like '%{$keyword}%')" : '';

        $table = load::sys_class('tabledata', 'new');
        $order = "login_time DESC,register_time DESC";
        $where = "lang='{$_M['lang']}' {$search}";
        $userlist = $table->getdata($_M['table']['user'], '*', $where, $order);

        foreach ($userlist as $key => $value) {
            switch ($value['source']) {
                case 'weixin':
                    $value['source'] = $_M['word']['weixinlogin'];
                    break;
                case 'weibo':
                    $value['source'] = $_M['word']['sinalogin'];
                    break;
                case 'qq':
                    $value['source'] = $_M['word']['qqlogin'];
                    break;
                default:
                    $value['source'] = $_M['word']['registration'];
                    break;
            }
            $value['idvalid'] = $value['idvalid'] ? $value['idvalid'] : 0;
            $value['register_time'] = timeFormat($value['register_time']);
            $value['login_time'] = timeFormat($value['login_time']);
            $value['groupid'] = $user_group[$value['groupid']];
            if (!$value['login_time']) {
                $value['login_time'] = $value['register_time'];
            }
            $user_data[$key] = $value;
        }

        $table->rdata($user_data);
    }

    /**
     * 添加会员
     */
    public function doAddUser()
    {
        global $_M;
        $username = isset($_M['form']['username']) ? $_M['form']['username'] : '';
        $password = isset($_M['form']['password']) ? $_M['form']['password'] : '';
        $valid = isset($_M['form']['valid']) ? $_M['form']['valid'] : '';
        $groupid = isset($_M['form']['groupid']) ? $_M['form']['groupid'] : '';
        if ($this->userclass->register($username, $password, '', '', '', $valid, $groupid)) {
            //写日志
            logs::addAdminLog('memberist', 'memberAdd', 'jsok', 'doAddUser');
            $this->success('', $_M['word']['jsok']);
        }
        //写日志
        logs::addAdminLog('memberist', 'memberAdd', 'jsx10', 'doAddUser');
        $this->error($_M['word']['jsx10']);
    }

    /**
     * 获取会员信息
     */
    public function doGetUserInfo()
    {
        global $_M;

        $id = intval($_M['form']['id']);
        if (!$id) {
            $this->error();
        }
        $user = $this->userclass->get_user_by_id($id);
        unset($user['password']);
        $para_list = load::sys_class('para', 'new')->get_para_list(10);
        foreach ($para_list as $key => $para) {
            $query = "SELECT info FROM {$_M['table']['user_list']} WHERE listid = '{$id}' AND paraid='{$para['id']}' AND lang = '{$_M['lang']}'";
            $user_info = DB::get_one($query);
            $para_list[$key]['value'] = htmlspecialchars($user_info['info']);
        }
        $user['user_para'] = $para_list;

        $contactInfo = self::getUserContactInfo($user, $para_list);

        $user['email_list'] = $contactInfo['email_list'];
        $user['sms_list'] = $contactInfo['sms_list'];

        $this->success($user);
    }

    /**
     * @param array $user
     * @return array
     */
    public function getUserContactInfo($user = array())
    {
        $email_list = array();
        $sms_list = array();

        if ($user['tel']) {
            $sms_list[] = $user['tel'];
        }

        if ($user['email']) {
            $email_list[] = $user['email'];
        }

        foreach ($user['user_para'] as $item) {
            //8 电话
            if ($item['type'] == 8) {
                $sms_list[] = $user['tel'];

            }

            //9邮箱
            if ($item['type'] == 9) {
                $email_list[] = $user['email'];
            }
        }

        return array('email_list' => $email_list, 'sms_list' => $sms_list);
    }

    /**
     * 保存会员信息
     */
    public function doSaveUser()
    {
        global $_M;
        $id = isset($_M['form']['id']) ? $_M['form']['id'] : '';
        $password = isset($_M['form']['password']) ? $_M['form']['password'] : '';
        $email = isset($_M['form']['email']) ? $_M['form']['email'] : '';
        $tel = isset($_M['form']['tel']) ? $_M['form']['tel'] : '';
        $valid = isset($_M['form']['valid']) ? $_M['form']['valid'] : '';
        $groupid = isset($_M['form']['groupid']) ? $_M['form']['groupid'] : '';

        if ($password) {
            if (!$this->userclass->editor_uesr_password($id, $password)) {
                if ($this->userclass->errorno == 'error_password_cha') {
                    $this->error($_M['word']['user_tips4_v6']);
                }
            }
        }
        $res = $this->userclass->editor_uesr($id, $email, $tel, $valid, $groupid);
        if ($res) {
            $paraclass = load::sys_class('para', 'new');
            $para_list = $paraclass->get_para_list(10);
            $info = array();
            foreach ($para_list as $val) {
                if (isset($_M['form']['info_' . $val['id']])) {
                    $info[$val['id']] = $_M['form']['info_' . $val['id']];
                }
            }
            $paraclass->update_para($id, $info, 10);
            $this->success('', $_M['word']['jsok']);
        }else{
            $this->error($this->userclass->error);
        }
    }

    /**
     * 删除会员
     */
    public function doDelUser()
    {
        global $_M;
        if (!isset($_M['form']['id']) || !$_M['form']['id'] || !is_array($_M['form']['id'])) {
            $this->error();
        }
        $id_list = $_M['form']['id'];

        foreach ($id_list as $value) {
            $query = "DELETE FROM {$_M['table']['user']} WHERE id='{$value}'";
            DB::query($query);
            $query = "DELETE FROM {$_M['table']['user_other']} WHERE met_uid='{$value}'";
            DB::query($query);
            $query = "DELETE FROM {$_M['table']['user_list']} WHERE listid='{$value}'";
            DB::query($query);
        }
        $this->userclass->user_del($id_list);
        //写日志
        logs::addAdminLog('memberist', 'delete', 'jsx10', 'doDelUser');
        $this->success('', $_M['word']['jsok']);
    }

    /**
     * 检查用户名是否可用
     */
    public function doCheckUsername()
    {
        global $_M;
        $username = isset($_M['form']['username']) ? $_M['form']['username'] : '';
        if (!$username) {
            $res['message'] = $_M['word']['loginid'];
            $res['valid'] = false;
            $this->ajaxReturn($res);
        }

        if (!$this->userclass->check_str($username)) {
            $res['message'] = $_M['word']['user_tips2_v6'];
            $res['valid'] = false;
            $this->ajaxReturn($res);
        }

        if (
            $this->userclass->get_user_by_username_sql($username) ||
            $this->userclass->get_admin_by_username_sql($username) ||
            $this->userclass->get_user_by_email($username) ||
            $this->userclass->get_admin_by_email_sql($username) ||
            $this->userclass->get_admin_by_mobile_sql($username) ||
            $this->userclass->get_user_by_tel($username)
        ) {
            $res['message'] = $_M['word']['user_tips3_v6'];
            $res['valid'] = false;
            $this->ajaxReturn($res);
        }

        $res['message'] = $_M['word']['user_tips1_v6'];
        $res['valid'] = true;
        $this->ajaxReturn($res);
    }

    /**
     * 检查邮箱是否可用
     */
    public function doCheckEmail()
    {
        global $_M;
        $user = $this->userclass->get_user_by_email($_M['form']['email']);
        if ($user && $user['id'] != $_M['form']['id']) {
            $this->error();
        }

        $this->success();
    }

    /**
     * 检查电话号码是否可用
     */
    public function doCheckTel()
    {
        global $_M;
        $user = $this->userclass->get_user_by_tel($_M['form']['tel']);
        if ($user && $user['id'] != $_M['form']['id']) {
            $this->error();
        }
        $this->success();
    }

    /**
     * 发送用户邮件通知
     */
    public function doUserEmail()
    {
        global $_M;
        $id = intval($_M['form']['id']);
        $to_email = intval($_M['form']['to_email']);
        $email_title = intval($_M['form']['email_title']);
        $email_content = intval($_M['form']['email_content']);

        if (!$id || !$to_email || !$email_title || !$email_content) {
            $this->error();
        }

        $user = $this->userclass->get_user_by_id($id);
        if (!$user) {
            $this->error();
        }

        $data = array(
            'weburl' => $_M['config']['met_weburl'],
            'webname' => $_M['config']['met_webname'],
            'username' => $user['username'],
        );
        #你的网站{web}收到新用户{username}注册注册请求，请登录网站后台查看
        $email_title = self::repalce_message($_M['word']['email_title'], $data);
        $body = self::repalce_message($_M['word']['email_content'], $data);

        //邮件通知
        $mail = load::sys_class('jmail', 'new');
        $res = $mail->send_email($to_email, $email_title, $body);
        $this->success('',$_M['word']['jsok']);
    }

    /**
     * 发送用户短信通知
     */
    public function doUserSms()
    {
        global $_M;
        $id = intval($_M['form']['id']);
        $to_sms = intval($_M['form']['to_sms']);
        $sms_content = intval($_M['form']['sms_content']);

        if (!$id || !$to_sms || !$sms_content ) {
            $this->error();
        }

        $user = $this->userclass->get_user_by_id($id);
        if (!$user) {
            $this->error();
        }

        $data = array(
            'weburl' => $_M['config']['met_weburl'],
            'webname' => $_M['config']['met_webname'],
            'username' => $user['username'],
        );
        #你的网站{web}收到新用户{username}注册注册请求，请登录网站后台查看
        $message = self::repalce_message($_M['word']['sms_content'], $data);

        load::sys_class('sms', 'new')->sendsms($to_sms, $message);

        $this->success('',$_M['word']['jsok']);

    }

    /**
     * @param $str
     * @param array $data
     * @return mixed
     */
    public function repalce_message($str, $data = array())
    {
        global $_M;
        foreach ($data as $key => $val) {
            $str = str_replace('{'.$key.'}', $val, $str);
        }
        return $str;
    }

    //导出会员列表
    public function doExportUser()
    {
        global $_M;
        $groupid = isset($_M['form']['groupid']) ? $_M['form']['groupid'] : '';
        $keyword = isset($_M['form']['keyword']) ? $_M['form']['keyword'] : '';
        $search = $groupid ? "and groupid = '{$groupid}'" : '';
        $search .= $keyword ? "and (username like '%{$keyword}%' || email like '%{$keyword}%' || tel like '%{$keyword}%')" : '';
        /*查询表用户*/
        $query = "SELECT * FROM {$_M['table']['user']} WHERE lang='{$_M['lang']}' {$search} ORDER BY login_time DESC,register_time DESC";  //mysql语句
        $user_data = DB::get_all($query);
        //会员组信息
        $user_group = $this->group->get_group_list();

        $parameter_database = load::mod_class('parameter/parameter_database', 'new');
        $parameter_list = load::mod_class('parameter/parameter_op', 'new')->get_para_list($this->module);

        //表头
        $head = array(
            $_M['word']['loginusename'],
            $_M['word']['membergroup'],
            $_M['word']['membertips1'],
            $_M['word']['lastactive'],
            $_M['word']['adminLoginNum'],
            $_M['word']['memberCheck'],
            $_M['word']['source'],
            $_M['word']['bindingmail'],
            $_M['word']['bindingmobile']
        );

        if ($parameter_list) {
            $para_list = array();
            foreach ($parameter_list as $key => $para) {
                $head[] = $para['name'];   //表头
                if (in_array($para['type'],array(2, 4, 6))) {
                    $para['options'] = $parameter_database->get_para_values($para['module'], $para['id']);
                    $para_list[$para['id']] = $para;
                }
                $para_list[$para['id']] = $para;
            }
        }

        $rarray = array();

        foreach ($user_data as $key => $user) {
            switch ($user['source']) {
                case 'weixin':
                    $user['source'] = $_M['word']['weixinlogin'];
                    break;
                case 'weibo':
                    $user['source'] = $_M['word']['sinalogin'];
                    break;
                case 'qq':
                    $user['source'] = $_M['word']['qqlogin'];
                    break;
                default:
                    $user['source'] = $_M['word']['register'];
                    break;
            }
            if (!$user['login_time']) {
                $user['login_time'] = $user['register_time'];
            }

            foreach ($user_group as $group) {
                if ($user['groupid'] == $group['id']) {
                    $group_name = $group['name'];
                }
            }
            
            $list = array();
            $list[] = $user['username'];
            $list[] = $group_name;
            $list[] = date('Y-m-d H:i:s', $user['register_time']);
            $list[] = date('Y-m-d H:i:s', $user['login_time']);
            $list[] = $user['login_count'];
            $list[] = $user['valid'] ? $_M['word']['memberChecked'] : $_M['word']['memberUnChecked'];
            $list[] = $user['source'];
            $list[] = $user['email'];
            $list[] = $user['tel'];

            $query = "SELECT * FROM {$_M['table']['user_list']} WHERE listid='{$user['id']}'";
            $user_para = DB::get_all($query);

            $para_info = array();
            foreach ($user_para as $para_row) {
                $parameter = $para_list[$para_row['paraid']];
                if (in_array($parameter['type'], array(2, 4, 6))) {
                    $select = explode('#@met@#', $para_row['info']);
                    $option_str = '';
                    foreach ($parameter['options'] as $option) {
                        if (in_array($option['id'], $select)) {
                            $option_str .= $option['value'] . ',';
                        }
                    }
                    $para_info[$para_row['paraid']] = trim($option_str, ',');
                }else{
                    $para_info[$para_row['paraid']] = $para_row['info'];
                }
            }

            foreach ($para_list as $para) {
                $list[] = $para_info[$para['id']];
            }

            //导出表单数据
            $rarray[] = $list;
        }

        $filename = "USER_" . date('Y-m-d', time()) . "_ACCLOG";
        $csv = load::sys_class('csv', 'new');
        $csv->get_csv($filename, $rarray, $head);
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>