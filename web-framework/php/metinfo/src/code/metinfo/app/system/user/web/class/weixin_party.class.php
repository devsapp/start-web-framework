<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * 微信登陆
 * Class weixinlogin
 */
class weixin_party
{
    public $error;
    public $type;

    public function __construct()
    {
        global $_M;
        $this->error = array();
        $this->type = 'weixin';
        $this->weixinapi = load::mod_class('weixin/weixinapi', 'new');
        $this->user_other = array('id', 'met_uid', 'openid', 'unionid', 'access_token', 'expires_in', 'type');
    }

    public function loginQrcode($rand = '')
    {
        $qrcode = $this->weixinapi->QRcode('login&' . $rand);
        if (!$this->weixinapi->error) {
            return $qrcode;
        }
        $this->error[] = $this->weixinapi->error;
        return false;
    }
    /**
     * @param array $other_user
     */
    public function wxLogin($other_user = array(), $code = '')
    {
        global $_M;
        if (!$other_user) {
            $this->error[] = '无法获取用户';
            return false;
        }
        if (!$code) {
            $this->error[] = 'code不存在';
            return false;
        }

        $user_exists = self::getOtherUser($other_user['openid']);
        if (!$user_exists) {//新增other_user
            $save_data = array();
            $save_data['met_uid'] = '#';
            $save_data['openid'] = $other_user['openid'];
            $save_data['unionid'] = '';
            $save_data['access_token'] = $code;
            $save_data['expires_in'] = time() + 300;
            $save_data['type'] = $this->type;
            $this->insert_other_user($save_data);
        } else {
            if ($user_exists['met_uid']) {
                $sys_user = load::sys_class('user', 'new')->get_user_by_id($user_exists['met_uid']);
            } else {
                $save_data = array();
                $save_data['openid'] = $other_user['openid'];
                $save_data['access_token'] = $code;
                $save_data['expires_in'] = time() + 300;

                $where = array();
                $where['openid'] = $other_user['openid'];
                $where['type'] = $this->type;
                $this->update_other_user($save_data, $where);
            }
        }

        if ($sys_user) {
            if ($sys_user['lang'] != $_M['lang']) {
                $this->error[] = '当前网站用户无法登陆';

                $msg = "当前网站用户无法登陆 ";
                $this->weixinapi->customMessage($other_user['openid'], $msg);  //登陆成功提示
                return false;
            }

            $save_data = array();
            $save_data['access_token'] = $code;
            $save_data['expires_in'] = time() + 300;

            $where['openid'] = $other_user['openid'];

            $this->update_other_user($save_data, $where);

            $date = date("Y-m-d H:i:s");
            $msg = "你的账号{$sys_user['username']}已登录
登录时间：$date ";

            $this->weixinapi->customMessage($other_user['openid'], $msg);  //登陆成功提示
            return true;
        } else {
            $this->error[] = '用户不存在';
            return false;
        }
    }

    /**
     * @param array $other_user
     * @return bool
     */
    public function otherUserRegister($other_id = '', $username = '', $password = '')
    {
        global $_M;
        if (!$other_id || !$username || !$password) {
            $this->error[] = '参数丢失';
            return false;
        }

        $other_user = $this->getOtherUser($other_id);
        if (!$other_user || !$other_user['met_uid'] == 0) {
            $this->error[] = '用户不存在';
            return false;
        }
        if ($other_user['met_uid'] != 0) {
            $this->error[] = '用户已存在';
            return false;
        }

        //注册系统用户
        $userclass = load::sys_class('user', 'new');
        $result = $userclass->register($username, $password, '', '', '', 1, '', $this->type);
        if (!$result) {//系统用户注册失败
            if (strstr($userclass->errorno, 'username')) {
                $this->errorno = "re_username";
            } else {
                $this->error[] = $userclass->errorno;
            }
            $this->error[] = '用户注册失败';
            return false;
        } else {//系统用户注册成功
            $sys_user = $userclass->get_user_by_username($username);
            $save_data = array();
            $save_data['met_uid'] = $sys_user['id'];
            $save_data['openid'] = $other_id;

            $where = array();
            $where['openid'] = $other_id;
            $where['type'] = $this->type;
            $this->update_other_user($save_data, $where);

            $date = date("Y-m-d H:i:s");
            $msg = "你的账号{$username}注册成功
注册时间：$date ";
            $this->weixinapi->customMessage($other_id, $msg);  //注册成功提示
            return $sys_user['id'];
        }
    }

    /**
     * 检测微信登陆状态
     */
    public function checkWXlogin($code = '')
    {
        global $_M;
        $redata = array();
        $redata['other_type'] = $this->type;

        $other_user = self::getUserByAcreateToken($code);
        if ($other_user) {
            $sys_user = load::sys_class('user', 'new')->get_user_by_id($other_user['met_uid']);
            if ($sys_user) {//已注册用户
                $redata['register'] = 0;
                $redata['openid'] = $other_user['openid'];
                $redata['sys_user'] = $sys_user;
            } else {//提示注册
                $redata['register'] = 1;
                $redata['openid'] = $other_user['openid'];
            }
            return $redata;
        } else {
            $this->error[] = '注册失败';
            return false;
        }
    }

    /**
     * 新增绑定
     */
    public function wxBind($user = array(), $rand = '')
    {
        global $_M;
        if (!$user || !$rand) {
            $this->error[] = '参数错误';
            return false;
        }
        $other_user = $this->getOtherUserByUid($user['id']);

        if (!$other_user) {
            $save_data = array();
            $save_data['met_uid'] = $user['id'];
            $save_data['openid'] = '#';
            $save_data['unionid'] = '#';
            $save_data['access_token'] = $rand;
            $save_data['expires_in'] = time() + 300;
            $save_data['type'] = $this->type;
            $this->insert_other_user($save_data);

            $qrcode = $this->weixinapi->QRcode('bind&' . $rand);
            if (!$this->weixinapi->error) {
                return $qrcode;
            }
            $this->error[] = $this->weixinapi->error;
            return false;
        } elseif ($other_user['openid'] == '#') {
            $save_data = array();
            $save_data['openid'] = '#';
            $save_data['unionid'] = '#';
            $save_data['access_token'] = $rand;
            $save_data['expires_in'] = time() + 300;

            $where = array();
            $where['met_uid'] = $user['id'];
            $where['type'] = $this->type;
            $this->update_other_user($save_data, $where);

            $qrcode = $this->weixinapi->QRcode('bind&' . $rand);
            if (!$this->weixinapi->error) {
                return $qrcode;
            }
            $this->error[] = $this->weixinapi->error;
            return false;
        } else {
            $this->error[] = '该用户已绑定微信';
            return false;
        }
    }

    /**
     * 绑定微信账号 绑定状态
     */
    public function checkWXBind($code = '')
    {
        if (!$code) {
            $this->error[] = 'code不存在';
            return false;
        }

        $other_user = self::getUserByAcreateToken($code);
        if ($other_user && $other_user['openid'] != '#') {
            $wx_user = $this->weixinapi->getwxUser($other_user['openid']);    //获取用户信息
            return $wx_user;
        }
        return false;
    }


    /**
     * 绑定微信 确认绑定信息
     * @return array|bool
     */
    public function confirmWxbind($code = '', $wx_user = array())
    {
        if (!$code) {
            $this->error[] = 'code不存在';
            return false;
        }

        $other_user = self::getUserByAcreateToken($code);
        if ($other_user) {
            if ($other_user['openid'] == '#') {//绑定用户
                $save_data = array();
                $save_data['openid'] = $wx_user['openid'];
                $save_data['unionid'] = $wx_user['openid'];

                $where['access_token'] = $code;
                $where['type'] = $this->type;

                $this->update_other_user($save_data, $where);

                $sys_user = load::sys_class('user', 'new')->get_user_by_id($other_user['met_uid']);
                $date = date("Y-m-d H:i:s");
                $msg = "你的账号{$sys_user['username']}已成功绑定微信
绑定时间：$date ";

                $this->weixinapi->customMessage($wx_user['openid'], $msg);  //登陆成功提示
                return true;
            }
            $this->error[] = '该用户已绑定微信';
            return false;
        }
        $this->error[] = '用户不存在';
        return false;
    }

    public function WXUnbind($uid = '')
    {
        global $_M;
        $this->delOtherUserByuid($uid);
        return;
    }

    /**
     * @param string $uid
     * @param string $type
     * @return array
     */
    public function getOtherUserByUid($uid = '')
    {
        global $_M;
        $sql = "SELECT * FROM {$_M['table']['user_other']} WHERE met_uid = '{$uid}' AND type = '{$this->type}' ";
        $other_user = DB::get_one($sql);
        return $other_user;
    }

    /**
     * @param string $uid
     * @return array
     */
    public function delOtherUserByuid($uid = '')
    {
        global $_M;
        $query = "DELETE FROM {$_M['table']['user_other']} WHERE met_uid = '{$uid}' AND type='{$this->type}'";
        return DB::get_one($query);
    }

    /**
     * @return array
     */
    public function getOtherUser($other_id = '')
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['user_other']} WHERE openid = '{$other_id}' AND type='{$this->type}'";
        return DB::get_one($query);
    }

    /**
     * @param string $uid
     * @return array
     */
    public function delOtherUser($other_id = '')
    {
        global $_M;
        $query = "DELETE FROM {$_M['table']['user_other']} WHERE openid = '{$other_id}' AND type='{$this->type}'";
        return DB::get_one($query);
    }

    /**
     * @return array
     */
    public function getUserByAcreateToken($code = '')
    {
        global $_M;
        if (!$code) {
            $this->error[] = 'code 不存在';
            return false;
        }

        $query = "SELECT * FROM {$_M['table']['user_other']} WHERE access_token = '{$code}' AND type = '{$this->type}'";
        $user = DB::get_one($query);

        if (!$user) {
            $this->error[] = '用户不存在';
            return false;
        }

        if ($user['expires_in'] < time()) {
            $this->error[] = '请求超时';
            return false;
        }

        return $user;
    }

    /**
     * @param array $save_data
     * @return mixed
     */
    protected function insert_other_user($save_data = array())
    {
        global $_M;
        if (!$save_data) {
            return false;
        }
        $sql = self::getSql($this->user_other, $save_data);
        $query = "INSERT INTO {$_M['table']['user_other']} SET {$sql}";
        $res = DB::query($query);
        if (DB::error()) {
            $this->error['error_sql'] = $query;
            $this->error['error'] = DB::error();
            return false;
        }
        return $res;
    }

    /**
     * @param array $save_data
     * @return mixed
     */
    protected function update_other_user($save_data = array(), $where = array())
    {
        global $_M;
        $sql = self::getSql($this->user_other, $save_data);
        $condition = self::getCondi($this->user_other, $where);

        $query = "UPDATE {$_M['table']['user_other']} SET {$sql} WHERE 
                type='{$this->type}' AND 
                {$condition}";
        $res = DB::query($query);
        if (DB::error()) {
            $this->error['error_sql'] = $query;
            $this->error['error'] = DB::error();
            return false;
        }
        return $res;
    }

    /**
     * 拼装sql
     * @param array $fields
     * @param array $save_data
     * @return string
     */
    protected function getSql($fields = array(), $save_data = array())
    {
        $sql = '';
        foreach ($fields as $field) {
            if ($field == 'id') {
                continue;
            }
            if (isset($save_data[$field])) {
                $sql .= " {$field} = '{$save_data[$field]}',";
            }
        }

        return trim($sql, ',');
    }

    /**
     * @param array $fields
     * @param array $save_data
     * @return string
     */
    protected function getCondi($fields = array(), $save_data = array())
    {
        $sql = '';
        foreach ($fields as $field) {
            if (isset($save_data[$field])) {
                $sql .= " {$field} = '{$save_data[$field]}' AND ";
            }
        }
        $sql .= "1 = 1";
        return $sql;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
