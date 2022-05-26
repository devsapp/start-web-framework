<?php
defined('IN_MET') or exit('No permission');

load::sys_class('admin');
load::sys_class('nav');

/** 第三方代码设置 */
class thirdparty extends admin {

	public function __construct() {
		global $_M;
		parent::__construct();
	}

    //获取第三方代码内容
    public function doGetThirdparty(){
        global $_M;
        $data = array();
        $data['met_headstat'] = isset($_M['config']['met_headstat']) ? htmlspecialchars_decode($_M['config']['met_headstat'],ENT_QUOTES ) : '';
        $data['met_footstat'] = isset($_M['config']['met_footstat']) ? htmlspecialchars_decode($_M['config']['met_footstat'],ENT_QUOTES) : '';
        $data['met_headstat_mobile'] = isset($_M['config']['met_headstat_mobile']) ? htmlspecialchars_decode($_M['config']['met_headstat_mobile'],ENT_QUOTES) : '';
        $data['met_footstat_mobile'] = isset($_M['config']['met_footstat_mobile']) ? htmlspecialchars_decode($_M['config']['met_footstat_mobile'],ENT_QUOTES) : '';
        $this->success($data);
    }

    //保存第三方代码
    public function doSaveThirdparty()
    {
        global $_M;

        $configlist = array();
        $configlist[] = 'met_headstat';
        $configlist[] = 'met_footstat';
        $configlist[] = 'met_headstat_mobile';
        $configlist[] = 'met_footstat_mobile';
        //保存系统配置
        configsave($configlist);
        //写日志
        logs::addAdminLog('third_party_code','save','jsok','doSaveThirdparty');
        buffer::clearConfig();
        $this->success('', $_M['word']['jsok']);
    }


}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>