<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

class config_app
{

    public $no;//模板编号
    public $lang;//模板语言

    function __construct($no = '', $lang = '')
    {
        global $_M;
        $this->no = $no;
        $this->lang = $_M['lang'];
    }


    /**
     * @param $list  applist
     * @return mixed 外部app多语言处理
     */
    public function standard($list = array())
    {
        global $_M;
        if (!$list['appname']) {
            if ($list['field']) {
                $list['appname'] = get_word($list['name']);
                $list['m_name'] = $list['field'];
                $list['url'] = "{$_M['url']['site_admin']}{$list['url']}&lang={$_M['lang']}";
                $list['ico'] = "{$_M[url]['tem']}myapp/images/{$list[icon]}";
            } else {
                $list['appname'] = get_word($list['name']);
                $list['m_name'] = $list['file'];
                if (file_exists(PATH_WEB . "{$_M['config']['met_adminfile']}/app/{$list['file']}/setapp.php")) {
                    $set_url = "{$_M['url']['site_admin']}app/{$list['file']}/setapp.php";
                } else {
                    $set_url = "{$_M['url']['site_admin']}app/dlapp/setapp.php";
                }
                $list['url'] = "{$set_url}?lang={$_M['lang']}&id={$list['id']}&n={$list['file']}";
                $list['ico'] = $list['depend'] == 'sys' ? "{$_M['url']['site']}app/system/{$list['m_name']}/icon.png" : "{$_M['url']['app']}{$list['m_name']}/icon.png";
                $list['uninstall'] = "{$_M['url']['own_name']}c=myapp&a=dodelapp&no={$list['no']}";
                if ($list['no'] > 10000) $list['update'] = "{$_M['url']['adminurl']}n=appstore&c=appstore&a=doappdetail&type=app&no={$list['no']}";
            }
        } else {
            $list['appname'] = get_word($list['appname']);
            $list['url'] = "{$_M['url']['site_admin']}index.php?lang={$_M['lang']}&n={$list['m_name']}&c={$list['m_class']}&a={$list['m_action']}";
            $list['ico'] = $list['depend'] == 'sys' ? "{$_M['url']['site']}app/system/{$list['m_name']}/icon.png" : "{$_M['url']['app']}{$list['m_name']}/icon.png";
            $list['uninstall'] = "{$_M['url']['own_name']}c=myapp&a=dodelapp&no={$list['no']}";
            if ($list['no'] > 10000) $list['update'] = "{$_M['url']['adminurl']}n=appstore&c=appstore&a=doappdetail&type=app&no={$list['no']}";
            $list['info'] = get_word($list['info']);
        }
        return $list;
    }

}


# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.