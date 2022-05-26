<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * @return mixed
 */
function member_information(){
	global $_M;
	$metinfo_member_name = get_met_cookie('metinfo_member_name');
	$user = load::sys_class('user', 'new')->get_user_by_username($metinfo_member_name);
	$user['usertype'] = $user['groupid'];
	$user['admin_id'] = $user['username'];
	$user['admin_pass'] = $user['password'];
	$query = "SELECT id,name FROM {$_M['table']['column']} WHERE access <= '{$user['groupid']}' AND lang = '{$_M['lang']}'";
	$column = DB::get_all($query);
	$user['column'] = $column;
	return $user;
}

/**
 * @return bool
 */
function is_weixin_client(){
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')){
		return true;
	}else{
		return false;
	}
}

/**
 * @return bool
 */
function is_mobile_client(){
	$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
	$uachar = "/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile|wap|Android|ucweb)/i";
	if(($ua != '' && preg_match($uachar, $ua))){
		return true;
	}else{
		return false;
	}

}


# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>