<?php
defined('IN_MET') or exit('No permission');

load::sys_class('admin');
load::sys_class('nav');

/** 基本信息设置 */
class info extends admin
{
    public function __construct()
    {
        global $_M;
        parent::__construct();
    }

    //获取基本信息列表
    public function doGetInfo()
    {
        global $_M;
        buffer::clearConfig();
        $data = array();

        //网站基本信息
        $info = array();
        $info['met_webname']    = isset($_M['config']['met_webname']) ? $_M['config']['met_webname'] : '';
        $info['met_logo']       = isset($_M['config']['met_logo']) ? $_M['config']['met_logo'] : '';
        $info['met_mobile_logo'] = isset($_M['config']['met_mobile_logo']) ? $_M['config']['met_mobile_logo'] : '';
        $info['met_weburl']     = self::get_weburl();;
        $info['met_keywords']   = isset($_M['config']['met_keywords']) ? $_M['config']['met_keywords'] : '';
        $info['met_description'] = isset($_M['config']['met_description']) ? $_M['config']['met_description'] : '';
        $info['data_key']       = isset($_M['config']['met_webkeys']) ? md5(md5(substr($_M['config']['met_webkeys'], 0, 8))) : '';
        //版权
        $info['met_copyright_type']       = isset($_M['config']['met_copyright_type']) ? $_M['config']['met_copyright_type'] : 0;
        $agents = array();
        $agents[] = str_replace(array('$metcms_v', '$m_now_year'), array($_M['config']['metcms_v'], date('Y', time())), $_M['config']['met_agents_copyright_foot']);
        $agents[] = str_replace(array('$metcms_v', '$m_now_year'), array($_M['config']['metcms_v'], date('Y', time())), $_M['config']['met_agents_copyright_foot1']);
        $agents[] = str_replace(array('$metcms_v', '$m_now_year'), array($_M['config']['metcms_v'], date('Y', time())), $_M['config']['met_agents_copyright_foot2']);
        $info['agents'] = $agents;

        //底部信息
        $info['met_footright']   = isset($_M['config']['met_footright']) ? $_M['config']['met_footright'] : '';
        $info['met_footaddress'] = isset($_M['config']['met_footaddress']) ? $_M['config']['met_footaddress'] : '';
        $info['met_foottel']     = isset($_M['config']['met_foottel']) ? $_M['config']['met_foottel'] : '';
        $info['met_footother']   = isset($_M['config']['met_footother']) ? $_M['config']['met_footother'] : '';
        $info['met_icp_info']   = isset($_M['config']['met_icp_info']) ? $_M['config']['met_icp_info'] : '';

        $data['info'] = $info;

        $adrry = admin_information();
        $email = $adrry['admin_email'];
        $tel = $adrry['admin_mobile'];

        $data['weburltext'] = $_M['word']['upfiletips10'].$_M['url']['web_site'];
        if ($_M['langlist']['web'][$_M['lang']]['link']) {
            $data['met_weburl'] = $_M['langlist']['web'][$_M['lang']]['link'];
            $data['disabled'] = 'disabled';
            $data['weburltext'] = "{$_M['word']['unitytxt_8']}";
        }

        $data['data_key'] = md5(md5(substr($_M['config']['met_webkeys'], 0, 8)));
        $this->success($info);
    }

    //保存网站基本信息
    public function doSaveInfo()
    {
        global $_M;
        if (!$_M['form']) {
            $this->error();
        }

        if (isset($_M['form']['met_ico']) && $_M['form']['met_ico'] != '../favicon.ico') {
            copy($_M['form']['met_ico'], '../favicon.ico');
        }

        if ($_M['form']['met_ico'] == '') {
            delfile('../favicon.ico');
        }

        //保存配置信息
        $configlist = array();
        $configlist[] = 'met_webname';
        $configlist[] = 'met_logo';
        $configlist[] = 'met_mobile_logo';
        $configlist[] = 'met_keywords';
        $configlist[] = 'met_description';
        $configlist[] = 'met_footright';
        $configlist[] = 'met_footaddress';
        $configlist[] = 'met_foottel';
        $configlist[] = 'met_footother';
        $configlist[] = 'met_copyright_type';
        $configlist[] = 'met_icp_info';
        configsave($configlist);

        //写日志
        logs::addAdminLog('website_information', 'save', 'jsok', 'doSaveInfo');

        buffer::clearConfig();
        $this->success('', $_M['word']['jsok']);
    }



    /** 获取站点网址
     * @param  string $lang 语言
     * @return string
     */
    private function get_weburl()
    {
        global $_M;
        if ($_M['langlist']['web'][$_M['lang']]['link']) {
            return $_M['langlist']['web'][$_M['lang']]['link'];
        }

        $query = "SELECT met_weburl FROM {$_M['table']['lang']} WHERE lang = '{$_M['lang']}'";
        $get_lang = DB::get_one($query);
        $web_url = isset($get_lang['met_weburl']) ? $get_lang['met_weburl'] : '';
        if (!$web_url) {
            $web_url = isset($_M['config']['met_weburl']) ? $_M['config']['met_weburl'] : $_M['url']['web_site'];
        }
        return $web_url;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
