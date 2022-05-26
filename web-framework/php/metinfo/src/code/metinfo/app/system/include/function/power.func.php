<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

/**
 * 获取COOKIE值
 * @param  string  $key                             指定键值
 * @return string  $_M['user']['cookie'][$key]	    返回当前管理员或会员的相关COOKIE值
 * 例：get_met_cookie('metinfo_admin_name'):返回当前管理员的账号
	   get_met_cookie('metinfo_member_name'):返回当前会员的账号
	   get_met_cookie('metinfo_admin_pass'):返回当前管理员的密码
	   get_met_cookie('metinfo_member_pass'):返回当前会员的密码
 */
function get_met_cookie($key)
{
    global $_M;
    if (defined('IN_ADMIN')) {
        if ($key == 'metinfo_admin_name' || $key == 'metinfo_member_name') {
            $val = urldecode($_M['user']['cookie'][$key]);
            $val = sqlinsert($val);
            return $val;
        }
        return $_M['user']['cookie'][$key];
    } else {
        $userclass = load::sys_class('user', 'new');
        if (!$userclass->get_login_user_info()) {
            $userclass->login_by_auth($_M['form']['acc_auth'], $_M['form']['acc_key']);
        }
        $m = $userclass->get_login_user_info();
        $m['metinfo_admin_name'] = $_M['user']['cookie']['metinfo_admin_name'];
        $m['metinfo_member_name'] = $m['username'];
        $m['metinfo_member_id'] = $m['id'];
        $m['metinfo_admin_id'] = $m['id'];
        $m['metinfo_admin_pass'] = $m['password'];
        $m['metinfo_member_pass'] = $m['password'];
        $m['metinfo_member_head'] = $m['head'];
        if ($key == 'metinfo_admin_name' || $key == 'metinfo_member_name') {
            $val = urldecode($m[$key]);
            $val = sqlinsert($val);
            return $val;
        }
        return $m[$key];
    }
}

/**
 * 判断COOKIE是否超过一个小时，如果没有超过则更新$_M['user']['cookie']中的信息
 */
function met_cooike_start()
{
    global $_M;
    $_M['user']['cookie'] = array();
    $met_webkeys = $_M['config']['met_webkeys'];
    list($username, $password) = explode("\t", authcode($_M['form']['met_auth'], 'DECODE', $met_webkeys . $_COOKIE['met_key']));
    $username = sqlinsert($username);
    $query = "SELECT * from {$_M['table']['admin_table']} WHERE admin_id = '{$username}'";
    $user = DB::get_one($query);
    $usercooike = json_decode($user['cookie']);
    if (md5($user['admin_pass']) == $password && time() - $usercooike->time < 3600) {
        foreach ($usercooike as $key => $val) {
            $_M['user']['cookie'][$key] = $val;
        }
        if (defined('IN_ADMIN')) {
            $_M['user']['admin_name'] = get_met_cookie('metinfo_admin_name');
            $_M['user']['admin_id'] = $_M['user']['cookie']['metinfo_admin_id'];
            if (function_exists('background_privilege')) {
                $privilege = background_privilege();
                $_M['user']['langok'] = $privilege['langok'];
            }
        }
        $_M['user']['cookie']['time'] = time();
        $json = json_encode($_M['user']['cookie']);
        $query = "update {$_M['table']['admin_table']} set cookie = '{$json}' WHERE admin_id = '{$username}'";
        $user = DB::query($query);
    }
}

/**
 * 清除COOKIE
 * @param  int $userid 用户ID    
 */
function met_cooike_unset($userid = 0)
{
    global $_M;
    $userid = sqlinsert($userid);
    $query = "UPDATE {$_M['table']['admin_table']} set cookie = '' WHERE admin_id='{$userid}' AND usertype = '3'";
    DB::query($query);
    met_setcookie("met_auth", '', time() - 3600);
    met_setcookie("met_auths", '', time() - 3600);
    met_setcookie("met_key", '', time() - 3600);
    met_setcookie("appsynchronous", 0, time() - 3600, '');
    unset($_M['user']['cookie']);
}

/**
 *
 */
function save_met_cookie($metinfo_admin_name = '')
{
    global $_M;
    if (!$metinfo_admin_name) {
        $metinfo_admin_name = get_met_cookie('metinfo_admin_name');
    }
    $query = "select * from {$_M['table']['admin_table']} where admin_id='{$metinfo_admin_name}'";
    $user = DB::get_one($query);
    if ($user) {
        $usercooike = json_decode($user['cookie']);
        foreach ($usercooike as $key => $val) {
            $met_cookie[$key] = $val;
        }
        $met_cookie['time'] = time();
        $json = json_encode($met_cookie);
        $username = $met_cookie['metinfo_admin_id'] ? $met_cookie['metinfo_admin_id'] : $met_cookie['metinfo_member_id'];
        $query = "update {$_M['table']['admin_table']} set cookie='{$json}' where id='{$username}'";
        DB::query($query);
        return true;
    }
    return false;
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>