<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin.class.php');
load::sys_class('nav.class.php');
load::sys_class('curl');
/** 网站地图 */
class map extends admin
{

    //获取网站地图设置
    public function doGetSiteMap()
    {
        global $_M;
        $list = array();
        $list['met_sitemap_auto'] = isset($_M['config']['met_sitemap_auto']) ? $_M['config']['met_sitemap_auto'] : 0;
        $list['met_sitemap_not1'] = isset($_M['config']['met_sitemap_not1']) ? $_M['config']['met_sitemap_not1'] : 0;
        $list['met_sitemap_not2'] = isset($_M['config']['met_sitemap_not2']) ? $_M['config']['met_sitemap_not2'] : '';
        $list['met_sitemap_lang'] = isset($_M['config']['met_sitemap_lang']) ? $_M['config']['met_sitemap_lang'] : '';
        $list['met_sitemap_xml'] = isset($_M['config']['met_sitemap_xml']) ? $_M['config']['met_sitemap_xml'] : 0;
        $list['met_sitemap_txt'] = isset($_M['config']['met_sitemap_txt']) ? $_M['config']['met_sitemap_txt'] : 0;

        $this->success($list);
    }

    //保存网站地图设置
    public function doSaveSiteMap()
    {
        global $_M;

        $_M['form']['met_sitemap_not1'] = isset($_M['form']['met_sitemap_not1']) ? $_M['form']['met_sitemap_not1'] : 0;
        $_M['form']['met_sitemap_not2'] = isset($_M['form']['met_sitemap_not2']) ? $_M['form']['met_sitemap_not2'] : 0;
        $_M['form']['met_sitemap_xml'] = isset($_M['form']['met_sitemap_xml']) ? $_M['form']['met_sitemap_xml'] : 0;
        $_M['form']['met_sitemap_txt'] = isset($_M['form']['met_sitemap_txt']) ? $_M['form']['met_sitemap_txt'] : 0;
        $configlist = array();
        $configlist[] = 'met_sitemap_auto';
        $configlist[] = 'met_sitemap_not1';
        $configlist[] = 'met_sitemap_not2';
        $configlist[] = 'met_sitemap_lang';
        $configlist[] = 'met_sitemap_xml';
        $configlist[] = 'met_sitemap_txt';
        configsave($configlist);/*保存系统配置*/

        load::sys_func('file');

        if (!$_M['form']['met_sitemap_xml']) {
            delfile(PATH_WEB . "/sitemap.xml");
        }
        if (!$_M['form']['met_sitemap_txt']) {
            delfile(PATH_WEB . "/sitemap.txt");
        }

        foreach ($configlist as $value) {
            $_M['config'][$value] = $_M['form'][$value];
        }

        load::sys_class('label', 'new')->get('seo')->site_map();
        //写日志
        logs::addAdminLog('htmsitemap', 'submit', 'jsok', 'doSaveSiteMap');
        $this->success('', $_M['word']['jsok']);
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.