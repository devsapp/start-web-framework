<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('web');

/**
 * 前台基类
 */
class userweb extends web {
	public $userclass;
	/**
	  * 初始化
	  */
	public function __construct() {
		global $_M;
		parent::__construct();
        $this->check();
		$this->userclass = load::sys_class('user', 'new');
		// 页面基本信息
		$query = "SELECT * FROM {$_M['table']['column']} WHERE module='10' AND lang='{$_M['lang']}'";
		$member = DB::get_one($query);
		$_M['config']['app_no']=0;
		 $this->add_input('page_title','-'.$member['name'].$this->input['page_title']);
		 $this->add_input('name',$member['name']);
		 $this->add_input('classnow',$this->input_class());
	}

	public function check($pid = '') {
		global $_M;
		$user = $this->get_login_user_info();
		if(!$user){
            $lang = $_M['form']['lang'] ? $_M['form']['lang'] : $_M['lang'];
            $gourl = $_M['form']['gourl'] ? $_M['form']['gourl'] : '';
            $url = "{$_M['url']['web_site']}member/login.php?";
            $url .= $lang ? "lang={$lang}" : '';
            $url .= $gourl ? "&gourl={$gourl}" : '';
            header("Location: {$url}");
			#okinfo($url,$_M['word']['please_login']);
		}
	}

	/**
	  * 重写web类的load_url_unique方法，获取前台特有URL
	  */
	protected function load_url_unique() {
		global $_M;
		parent::load_url_unique();
		// load::mod_class('user/user_url', 'new')->insert_m();
	}
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
