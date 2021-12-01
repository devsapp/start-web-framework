<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

class other
{
    public $errorno;
    public $appid;
    public $appkey;
    public $table;
    public $type;

    public function __construct()
    {
        global $_M;
        $this->table = $_M['table']['user_other'];
    }

    /**
     * 通过回调信息获取用户
     * @param $info
     * @return bool
     */
    public function get_user($code)
    {
        if (!$code) {
            return false;
        }
        $infos = $this->get_access_token($code);
        if (!$infos) {
            return false;
        }

        $user = $this->get_user_by_openid($infos['openid']);
        if (!$user) {
            //返回用户信息 提示注册
            $user['register'] = 1;
            $user['other_id'] = $infos['openid'];
            $user['other_type'] = $this->type;
        } else {
            $user['register'] = 0;
        }
        return $user;
    }

    /**
     * 注册用户
     * @param $openid
     * @param string $username
     * @return bool
     */
    public function register($other_id = '', $username = '', $password = ''){
        $userclass = load::sys_class('user', 'new');
        if($username == ''){
            $uerinfo  = $this->get_info_by_curl($other_id);
            if(!$uerinfo){
                return false;
            }
            $username = $uerinfo['username'];
        }
        //注册系统用户
        $result = $userclass->register($username, $password, '', '', '', 1, '', $this->type);
        if(!$result){//系统用户注册失败
            if(strstr($userclass->errorno, 'username')){
                $this->errorno = "re_username";
            }else{
                $this->errorno = $userclass->errorno;
            }
            return false;
        }else{//系统用户注册成功
            $user = $userclass->get_user_by_username($username);
            $this->update_other_user($user['id'], $other_id,  '#', '#');
            return $user['id'];
        }
    }

    /**
     * @param $info
     * @return array|bool|void
     */
    public function get_access_token($code)
    {
        //本地数据库擦寻
        $data = $this->get_other_user($code);
        if (!$data) {
            $data = $this->get_access_token_by_curl($code);
            if (!$data) {
                return false;
            }
            if ($this->get_other_user($data['openid'])) {
                $this->update_other_user('#', $data['openid'], $data['access_token'], $data['expires_in']);
            } else {
                $this->insert_other_user('0', $data['openid'], $data['access_token'], $data['expires_in']);
            }
        }
        return $data;
    }

    /**
     * 获取系统用户信息
     * @param $code
     * @return mixed
     */
    public function get_user_by_openid($openid = '')
    {
        $other_user = $this->get_other_user($openid);
        if ($other_user['met_uid']) {
            $user = load::sys_class('user', 'new')->get_user_by_id($other_user['met_uid']);
        }
        return $user;
    }

    /**
     * 获取用戶信息
     * @param $openid
     * @return array
     */
    public function get_other_user($openid = '')
    {
        $query = "SELECT * FROM {$this->table} WHERE openid = '{$openid}' AND type='{$this->type}'";
        return DB::get_one($query);
    }

    /**
     * @param string $uid
     * @param string $type
     * @return array
     */
    public function getOtherUserByUid($uid = '', $type = '')
    {
        global $_M;
        $sql = "SELECT * FROM {$_M['table']['user_other']} WHERE type = '{$type}' AND met_uid = '{$uid}'";
        $user = DB::get_one($sql);
        return $user;
    }

    /**
     * 新增用戶信息
     * @param $met_uid
     * @param $openid
     * @param $unionid
     * @param $access_token
     * @param $expires_in
     * @return mixed
     */
    public function insert_other_user($met_uid, $openid, $access_token, $expires_in)
    {
        $query = "INSERT INTO {$this->table} SET met_uid='{$met_uid}', openid = '{$openid}',unionid='{$openid}',access_token='{$access_token}', expires_in='{$expires_in}', type='{$this->type}'";
        return DB::query($query);
    }

    /**
     * 更新用戶信息
     * @param $unionid
     * @param string $openid
     * @param string $met_uid
     * @param string $access_token
     * @param string $expires_in
     * @return mixed
     */
    public function update_other_user($met_uid = '#', $openid = '#', $access_token = '#', $expires_in = '#')
    {
        $sql = '';
        if ($met_uid != '#') {
            $sql .= "met_uid='{$met_uid}',";
        }
        if ($access_token != '#') {
            $sql .= "access_token='{$access_token}', expires_in='{$expires_in}',";
        }
        if ($openid != '#') {
            $sql .= "openid='{$openid}', unionid = '{$openid}'";
        }
        $sql = trim($sql, ',');
        $query = "UPDATE {$this->table} SET {$sql} WHERE openid = '{$openid}'";
        return DB::query($query);
    }

    public function set_state()
    {
        load::sys_class('session', 'new')->set('other_state', random(10));
    }

    public function get_state()
    {
        return load::sys_class('session', 'new')->get('other_state');
    }

    public function state_ok($state)
    {
        if ($state == load::sys_class('session', 'new')->get('other_state')) {
            return true;
        } else {
            return false;
        }
    }

    public function get_access_token_by_curl($code)
    {
        //必须返回access_token,expires_in,openid
    }

    public function get_info_by_curl($openid)
    {
        //必须返回username
    }

    public function get_login_url()
    {
        //必须返回第三方登录地址
    }

    public function error_curl($data)
    {
        if ($data['error']) {
            $this->errorno = $data['error_description'] ? $data['error_description'] : $data['error'];
            return true;
        } else {
            return false;
        }
    }
}


# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>