<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin.class.php');
load::sys_class('nav.class.php');
load::sys_class('curl');
/** 参数设置 */
class seo extends admin {

	public function __construct() {
		global $_M;
		parent::__construct();
	}

    //获取参数设置
	public function doGetParameter()
    {
        global $_M;
        $list = array();
        $list['met_hometitle'] = isset($_M['config']['met_hometitle']) ? $_M['config']['met_hometitle'] : '';
        $list['met_title_type'] = isset($_M['config']['met_title_type']) ? $_M['config']['met_title_type'] : '';
        $list['met_keywords'] = isset($_M['config']['met_keywords']) ? $_M['config']['met_keywords'] : '';
        $list['met_alt'] = isset($_M['config']['met_alt']) ? $_M['config']['met_alt'] : '';
        $list['met_atitle'] = isset($_M['config']['met_atitle']) ? $_M['config']['met_atitle'] : '';
        $list['met_linkname'] = isset($_M['config']['met_linkname']) ? $_M['config']['met_linkname' ] : '';
        $list['met_foottext'] = isset($_M['config']['met_foottext']) ? htmlspecialchars_decode($_M['config']['met_foottext'],ENT_QUOTES ) : '';
        $list['met_seo'] = isset($_M['config']['met_seo']) ? htmlspecialchars_decode($_M['config']['met_seo'],ENT_QUOTES ) : '';
        $list['met_logo_keyword'] = isset($_M['config']['met_logo_keyword']) ? $_M['config']['met_logo_keyword'] : '';
        $list['met_404content'] = isset($_M['config']['met_404content']) ? htmlspecialchars_decode($_M['config']['met_404content'],ENT_QUOTES ) : '';
        $list['met_data_null'] = isset($_M['config']['met_data_null']) ? $_M['config']['met_data_null'] : '';
        $list['met_tags_title'] = isset($_M['config']['met_tags_title']) ? $_M['config']['met_tags_title'] : '';
        $list['met_301jump']     = isset($_M['config']['met_301jump']) ? $_M['config']['met_301jump'] : '';
        $list['met_copyright_nofollow']     = isset($_M['config']['met_copyright_nofollow']) ? $_M['config']['met_copyright_nofollow'] : '';
        $list['tag_search_type']     = isset($_M['config']['tag_search_type']) ? $_M['config']['tag_search_type'] : '';
        $list['tag_show_range']     = isset($_M['config']['tag_show_range']) ? $_M['config']['tag_show_range'] : '';
        $list['tag_show_number']     = isset($_M['config']['tag_show_number']) ? $_M['config']['tag_show_number'] : '';
        $list['tag_empty_list']     = isset($_M['config']['tag_empty_list']) ? $_M['config']['tag_empty_list'] : '';
        $list['met_https']     = isset($_M['config']['met_https']) ? $_M['config']['met_https'] : '';

        $this->success($list);
    }

	//保存参数设置
	public function doSaveParameter(){
		global $_M;
        if ($_M['form']['met_logo_keyword'] == '') {
            $_M['form']['met_logo_keyword'] = $_M['config']['met_webname'];
        }

        if ($_SERVER['SERVER_PORT'] == 443 || $_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1 || $_SERVER['HTTP_X_CLIENT_SCHEME'] == 'https' || $_SERVER['HTTP_FROM_HTTPS'] == 'on' || $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || $_SERVER['HTTP_SCHEME'] == 'https') {
            $http = 'https://';
        }else{
            $http = 'http://';
        }
        $url = $_M['url']['web_site'];
        //检测301跳转验证是否可访问
        if (($_M['form']['met_https'] == 1 && strpos($url, 'https://') === false) || ($_M['form']['met_301jump'] == 1 && strpos($_M['url']['web_site'], 'www.') === false)){
            $error_hint = '';
            if ($_M['form']['met_301jump'] == 1){
                $url = str_replace($http,$http.'www.',$url);
                $error_hint = $_M['word']['301jump'].$_M['word']['opfailed'];
            }
            if ($_M['form']['met_https'] == 1){
                $url = str_replace('http://','https://',$url);
                $error_hint .= ' https'.$_M['word']['opfailed'];
            }
            $access_result = $this->accessUrl($url);
            if (!$access_result){
                $this->error($error_hint);
            }
        }

		$configlist   = array();
		$configlist[] = 'met_hometitle';
		$configlist[] = 'met_title_type';
		$configlist[] = 'met_keywords';
		$configlist[] = 'met_alt';
		$configlist[] = 'met_atitle';
		$configlist[] = 'met_linkname';
		$configlist[] = 'met_foottext';
		$configlist[] = 'met_seo';
        $configlist[] = 'met_logo_keyword';
        $configlist[] = 'met_404content';
        $configlist[] = 'met_data_null';
        $configlist[] = 'met_tags_title';
        $configlist[] = 'met_301jump';
        $configlist[] = 'met_copyright_nofollow';
        $configlist[] = 'tag_search_type';
        $configlist[] = 'tag_show_range';
        $configlist[] = 'tag_show_number';
        $configlist[] = 'tag_empty_list';
        $configlist[] = 'met_https';

        configsave($configlist);
        buffer::clearConfig();
        load::sys_class('label', 'new')->get('seo')->html404();
        //写日志
        logs::addAdminLog('seoSetting','submit','jsok','doSaveParameter');
        $this->success("",$_M['word']['jsok']);
	}

	private function accessUrl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        $curl_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($curl_code != 200 && $curl_code != 302 && $curl_code != 301) {
            return false;
        }

        return true;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
