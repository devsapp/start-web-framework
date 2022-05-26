<?php

// MetInfo Enterprise Content Management System
// Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

class myapp
{
    public $power;

    public function __construct()
    {
        global $_M;
    }

    public function checkAuth()
    {
        $auth = background_privilege();

        return ($auth['application'] == 'metinfo' || is_strinclude('|'.$auth['application'].'|', '|'.$auth.'|')) ? true : false;
    }

    public function login($data)
    {
        global $_M;
        $data['action'] = 'login';
        $result = api_curl($_M['config']['met_api'], $data);
        $res = json_decode($result, true);
        
        if ($res['status'] == 200 || $res['code'] == 0) {
            $user_key = $res['data']['user_key'];
            if ($user_key) {
                $query = "UPDATE {$_M['table']['config']} SET value = '{$user_key}' WHERE name = 'met_secret_key'";
                DB::query($query);
            }

            return $res;
        } else {
            error($res['msg']);
        }
    }

    public function logout()
    {
        global $_M;
        if (!$_M['config']['met_secret_key']) {
            error('用户未登录');
        }
        $data['action'] = 'userInfo';
        $result = api_curl($_M['config']['met_api'], $data);
        $res = json_decode($result, true);
        if ($res['status'] == 200) {
            return $res;
        } else {
            error($res['msg']);
        }
    }

    public function getUserInfo($type = '')
    {
        global $_M;
        if (!$_M['config']['met_secret_key']) {
            error('用户未登录');
        }
        $data['action'] = 'userInfo';
        if ($type == 'logout') {
            $data['logout'] = 1;
        }
        $result = api_curl($_M['config']['met_api'], $data);
        $res = json_decode($result, true);
        if($res['status'] == 200?$type == 'logout':1){
            $query = "UPDATE {$_M['table']['config']} SET value = '' WHERE name = 'met_secret_key'";
            DB::query($query);
        }
        if ($res['status'] == 200) {
            return $res;
        } else {
            error($res['msg']);
        }
    }

    /**
     * 我的应用，如果已经登录应用商店，显示购买的应用.
     */
    public function listApp()
    {
        global $_M;

        $app = array();
        $data = $this->localApp();

        foreach ($data as $key => $val) {
            $app[] = $val['no'];
        }

        if ($_M['config']['met_secret_key'] && $_M['config']['met_agents_metmsg']) {
            $online = $this->onlineApp();
            foreach ($online as $key => $val) {
                $appname[] = $val['m_name'];
                if (in_array($val['no'], $app)) {
                    continue;
                }

                //PHP版本验证
                $php_ver = PHP_VERSION;
                if (!version_compare($val['php_version'], $php_ver, '<=')) {
                    $val['enabled'] = 0;
                    $val['btn_text'] = "应用需要PHP{$val['php_version']}及以上版本，当前网站PHP版本为：{$php_ver},请切换您网站的PHP程序版本";
                }else{
                    $val['enabled'] = 1;
                }
                $data[] = $val;
            }
        }

        return $data;
    }

    private function localApp()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['applist']} WHERE display > 0 ORDER BY id DESC";
        $applist = DB::get_all($query);

        if ($applist && $_M['config']['met_secret_key']) {
            $data = array(
                'action' => 'checkUpdateApp',
                'applist' => base64_encode(json_encode($applist)),
            );
            $res = api_curl($_M['config']['met_api'], $data);
            $result = json_decode($res, true);

            if ($result['status'] == 200) {
                $applist = $result['data'];
            }
        }

        $system = array('0', '10070', '50002');

        $admin_info = admin_information();
        foreach ($applist as $key => $val) {
            if ($val['no']) {
                if (!strstr($admin_info['admin_type'], 'a'.$val['no']) && !strstr($admin_info['admin_type'], 'metinfo')) {
                    unset($applist[$key]);
                    continue;
                }
                if ($val['no'] == 10070 && !$_M['config']['met_agents_sms']) {
                    unset($applist[$key]);
                    continue;
                }
            }

            $module = 'app';
            if ($val['m_name'] == 'pay') {
                $module = 'system';
            }
            $applist[$key]['icon'] = $_M['url']['site']."app/{$module}/{$val['m_name']}/icon.png";
            if (file_exists(PATH_WEB."app/app/{$val['m_name']}/config.json")) {
                $applist[$key]['newapp'] = '1'; //新框架
                $applist[$key]['url'] = $_M['url']['site_admin']."#/app/{$val['m_name']}/?c={$val['m_class']}&a={$val['m_action']}";
            } else {
                $applist[$key]['url'] = $_M['url']['site_admin']."?n={$val['m_name']}&c={$val['m_class']}&a={$val['m_action']}";
            }
            $applist[$key]['system'] = in_array($val['no'], $system);
            $applist[$key]['install'] = 1;
        }

        $applist = array_values($applist);

        return $applist;
    }

    private function onlineApp()
    {
        global $_M;
        $data = array(
            'action' => 'getMyApp',
        );
        $result = api_curl($_M['config']['met_api'], $data);

        if ($result) {
            $data = json_decode($result, true);
            $applist = $data['data'];
            foreach ($applist as $key => $val) {
                $applist[$key]['icon'] = $val['icon'];
                $applist[$key]['install'] = 0;
            }

            return $applist;
        }

        return array();
    }

    public function checkAppUpdate()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['applist']} WHERE display > 0 ORDER BY id DESC";
        $applist = DB::get_all($query);

        if ($applist && $_M['config']['met_secret_key']) {
            $data = array(
                'action' => 'checkUpdateApp',
                'applist' => base64_encode(json_encode($applist)),
            );
            $res = api_curl($_M['config']['met_api'], $data);
            $result = json_decode($res, true);

            if ($result['status'] == 200) {
                $applist = $result['data'];

                $update_list = array();
                foreach ($applist as $app) {
                    if ($app['new_ver']) {
                        $update_list[] = $app;
                    }
                }
            }
            return $update_list;
        }
    }

    public function install($data)
    {
        global $_M;
        $appno = $data['appno'];
        $name = $data['name'];
        $file = PATH_WEB.'app/app/'.$name.'/admin/install.class.php';
        if ($appno == 10080) {
            $file = PATH_WEB.'app/system/'.$name.'/admin/install.class.php';
        }
        // if(file_exists($file)){
        //     $install = load::app_class($name . '/admin/install.class.php', 'new');
        //     $install->dosql();
        //     return true;
        // }
        $data = array(
            'action' => 'installApp',
            'appno' => $appno,
        );

        if (!is_writable(PATH_WEB.'cache')) {
            //写日志
            logs::addAdminLog('myapp', 'appinstall', 'templatefilewritno', 'doAction');
            error(PATH_WEB.'cache'.$_M['word']['templatefilewritno']);
        }

        $appzip = PATH_WEB.'cache/'.$appno.'.zip';
        if (file_exists($appzip)) {
            @unlink($appzip);
        }

        $result = down_curl($_M['config']['met_api'], $data, $appzip);
        if ($result !== true) {
            //写日志
            logs::addAdminLog('myapp', 'appinstall', 'opfailed', 'doAction');
            error($result);
        }

        if (!file_exists($appzip)) {
            //写日志
            logs::addAdminLog('myapp', 'appinstall', 'opfailed', 'doAction');
            error($_M['word']['file_download_failed']);
        }

        $zip = new ZipArchive();
        if ($zip->open($appzip) === true) {
            $zip->extractTo(PATH_WEB); //假设解压缩到在当前路径下images文件夹的子文件夹php
            $zip->close(); //关闭处理的zip文件
        } else {
            //写日志
            logs::addAdminLog('myapp', 'appinstall', 'webupate4', 'doAction');
            error($_M['word']['webupate4']);
        }

        if (!file_exists($file)) {
            //写日志
            logs::addAdminLog('myapp', 'appinstall', 'dltips5', 'doAction');
            error($_M['word']['dltips5']);
        }

        if ($appno == 10080) {
            include $file;
            $install = new install();
        } else {
            $install = load::app_class($name.'/admin/install.class.php', 'new');
        }
        $install->dosql();
        //写日志
        logs::addAdminLog('myapp', 'appinstall', 'jsok', 'doAction');

        //更改管理员应用权限
        load::mod_class("admin/admin_op", 'new')->modify_admin_column_accsess($appno, 'a' ,'add');

        return $result;
    }

    public function uninstall($data)
    {
        global $_M;
        $appno = $data['appno'];
        $query = "SELECT m_name FROM {$_M['table']['applist']} WHERE no = '{$appno}'";
        $app = DB::get_one($query);
        if (!$app) {
            //写日志
            logs::addAdminLog('myapp', 'dlapptips6', 'dltips5', 'doAction');
            error($_M['word']['dltips5']);
        }

        if ($appno == 10080) {
            $file = PATH_WEB.'app/system/'.$app['m_name'].'/admin/uninstall.class.php';
            if (!file_exists($file)) {
                return;
            }
            include $file;
            $uninstall = new uninstall();
            $uninstall->dodel();

            return true;
        }

        $file = PATH_WEB.'app/app/'.$app['m_name'].'/admin/uninstall.class.php';

        if (!file_exists($file)) {
            if ($app['m_name'] == 'met_template') {
                //写日志
                logs::addAdminLog('myapp', 'dlapptips6', 'met_template_nodelet', 'doAction');
                error($_M['word']['met_template_nodelet']);
            }
            // 卸载文件不存在
            $query = "DELETE FROM {$_M['table']['applist']} WHERE no = '{$appno}'";
            DB::query($query);
            $query = "DELETE FROM {$_M['table']['app_config']} WHERE no = '{$appno}'";
            DB::query($query);
            $query = "DELETE FROM {$_M['table']['app_plugin']} WHERE no = '{$appno}'";
            DB::query($query);
            deldir(PATH_WEB.'app/app/'.$app['m_name']);
            //写日志
            logs::addAdminLog('myapp', 'dlapptips6', 'jsok', 'doAction');

            return true;
        }
        //写日志
        logs::addAdminLog('myapp', 'dlapptips6', 'jsok', 'doAction');
        $uninstall = load::app_class($app['m_name'].'/admin/uninstall', 'new');
        $uninstall->dodel();

        //更改管理员应用权限
        load::mod_class("admin/admin_op", 'new')->modify_admin_column_accsess($appno, 'a', 'del');

        return true;
    }

    public function update($appno)
    {
    }

    public function appList($type)
    {
        global $_M;
        $url = 'https://u.mituo.cn/api/site/applications';
        $result = api_curl($url, array('type' => $type));
        $res = json_decode($result, true);

        // 本地已安装的应用
        $app = array();
        $data = $this->localApp();
        foreach ($data as $key => $val) {
            $app[] = $val['no'];
        }

        $list = array();
        foreach ($res['data']['data'] as $key => $val) {
            if (!in_array($val['product_code'], $app)) {
                if ($_M['config']['metinfo_code']) {
                    $val['show_url'] = $val['show_url'].'?metinfo_code='.$_M['config']['metinfo_code'];
                }

                //PHP版本验证
                $php_ver = PHP_VERSION;
                if (!version_compare($val['php_version'], $php_ver, '<=')) {
                    $val['btn_text'] = "应用需要PHP{$val['php_version']}及以上版本，当前网站PHP版本为：{$php_ver},请切换您网站的PHP程序版本";
                    $val['enabled'] = 0;
                }else{
                    $val['enabled'] = 1;
                }
                $list[] = $val;
            }
        }
        return $list;
    }
}

// This program is an open source system, commercial use, please consciously to purchase commercial license.
// Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
