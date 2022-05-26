<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin');
load::sys_func('admin');

class index extends admin
{
    /**
     * 后台框架页
     */
    public function doindex()
    {
        global $_M;
        $data = array();
        if (!$_M['form']['noside']) {
            $sub_column = load::mod_class('base/admin/base_admin', 'new')->column(1);
            $adminnav = get_adminnav();
            $data['adminnav'] = array();
            foreach ($adminnav as $key => $val) {
                if ($val['display'] == 1) {
                    if ($val['type'] == 1) {
                        $data['adminnav']['top'][] = $val;
                    } else {
                        if ($val['bigclass'] == 3 && strstr($val['url'], 'feed_')) {
                            $module_info = explode('_', $val['url']);

                            //子菜单
                            if (is_array($sub_column[$module_info[2]])) {
                                $sub_num = count($sub_column[$module_info[2]]);
                            }else{
                                $sub_num = 0;
                            }

                            foreach ($sub_column[$module_info[2]] as $keys => $value) {
                                if (!($module_info[2] == 6 && $keys == 'class1' && $sub_num > 1)) {
                                    foreach ($value as $keys1 => $value1) {
                                        $url = "manage/?module={$module_info[1]}";
                                        if ($keys == 'class1') {
                                            $url .= "&class1={$value1['id']}";
                                        } else {
                                            $url .= "&class1={$value1['bigclass']}&class2={$value1['id']}";
                                        }
                                        if ($module_info[2] == 7 || ($module_info[2] == 6 && $sub_num == 1)) {
                                            $val['url'] = $url;
                                        } else {
                                            $data['adminnav']['sub'][$val['id']][] = array(
                                                'name' => $value1['name'],
                                                'url' => $url
                                            );
                                        }
                                    }
                                }
                            }
                            if (($module_info[2] != 7 || !$sub_column[$module_info[2]]) && !($module_info[2] == 6 && $sub_num == 1)) $val['url'] = '';
                        }
                        $data['adminnav']['sub'][$val['bigclass']][] = $val;
                    }
                } else if ($val['type'] == 1) {
                    foreach ($adminnav as $key1 => $val1) {
                        if ($val1['type'] == 2 && $val1['bigclass'] == $val['id'] && $val1['display'] == 1) {
                            $data['adminnav']['top'][] = $val1;
                        }
                    }
                }
            }

            if(!$_M['form']['sidebar_reload']){
                #$data['met_admin_logo'] = "{$_M['url']['public_images']}logo.png";
                $data['met_admin_logo'] = "{$_M['url']['site']}" . str_replace('../', '', $_M['config']['met_agents_logo_index']);
                $sys_auth = load::mod_class('system/class/sys_auth', 'new');
                $data['otherinfoauth'] = $sys_auth->have_auth();

                $data['msecount'] = DB::counter($_M['table']['infoprompt'], "WHERE (lang='" . $_M['lang'] . "' or lang='metinfo') and see_ok='0'", "*");
                $data['privilege'] = background_privilege();
                setcookie("arrlanguage", $data['privilege']['navigation'], 0, '/');
                $arrlanguage = explode('|', $data['privilege']['navigation']);
                if (in_array('metinfo', $arrlanguage) || in_array('1002', $arrlanguage)) {
                    $data['langprivelage'] = 1;
                } else {
                    $data['langprivelage'] = 0;
                }
                $data['admin_group'] = admin_information();
                //判断是否有环境检测的权限
                if (strstr($data['admin_group']['admin_type'], 's1903') || strstr($data['admin_group']['admin_type'], 'metinfo')) {
                    $data['environmental_test'] = 1;
                }
                //判断是否有功能大全的权限
                if (strstr($data['admin_group']['admin_type'], 's1902') || strstr($data['admin_group']['admin_type'], 'metinfo')) {
                    $data['function_complete'] = 1;
                }
                //判断是否有清空缓存的权限
                if (strstr($data['admin_group']['admin_type'], 's1901') || strstr($data['admin_group']['admin_type'], 'metinfo')) {
                    $data['clear_cache'] = 1;
                }
                //判断是否有检测更新的权限
                if (strstr($data['admin_group']['admin_type'], '1104') || strstr($data['admin_group']['admin_type'], 'metinfo')) {
                    $data['checkupdate'] = 1;
                    if (!$_M['config']['met_agents_update']) {
                        $data['checkupdate'] = 0;
                    }
                }
                $data['admin_group'] = $data['admin_group']['admin_group'];
            }
        }
        if(!$_M['form']['sidebar_reload']){
            $sys_json = parent::sys_json();
            $data = array_merge($data, $sys_json);
        }
        $this->view(is_mobile() ? 'sys/mobile/admin/templates/index' : 'app/index', $data);
    }

    /**
     * 后台首页
     */
    public function dohome()
    {
        global $_M;
        $privilege = background_privilege();
        $admin_folder_safe = $this->admin_folder_safe();
        $home_app_ok = $_M['config']['met_agents_metmsg'];
        $home_news_ok = $_M['config']['met_agents_metmsg'];

        $query = "SELECT count(1) as total FROM {$_M['table']['feedback']} WHERE readok=0 AND lang = '{$_M['lang']}'";
        $feedback = DB::get_one($query);
        $feedback['name'] = $_M['word']['feedfback'];
        if (!$feedback) {
            $feedback['total'] = 0;
        }

        $query = "SELECT count(1) as total FROM {$_M['table']['message']} WHERE readok=0 AND lang = '{$_M['lang']}'";
        $message = DB::get_one($query);
        $message['name'] = $_M['word']['message'];
        if (!$message) {
            $message['total'] = 0;
        }

        $query = "SELECT count(1) as total FROM {$_M['table']['cv']} WHERE readok=0 AND lang = '{$_M['lang']}'";
        $cv = DB::get_one($query);
        if (!$cv) {
            $cv['total'] = 0;
        }
        $cv['name'] = $_M['word']['job'];

        $query = "SELECT COUNT(1) AS total FROM {$_M['table']['news']} WHERE  lang = '{$_M['lang']}'";
        $news = DB::get_one($query);
        if (!$news) {
            $news['total'] = 0;
        }
        $news['name'] = $_M['word']['upfiletips37'];

        $query = "SELECT COUNT(1) AS total FROM {$_M['table']['product']} WHERE  lang = '{$_M['lang']}'";
        $product = DB::get_one($query);
        if (!$product) {
            $product['total'] = 0;
        }

        $product['name'] = $_M['word']['product'];;
        $data = array(
            'admin_folder_safe' => $admin_folder_safe,
            'home_app_ok' => $home_app_ok,
            'home_news_ok' => $home_news_ok,
            'summarize' => array(
                'news' => $news,
                'product' => $product,
                'feedback' => $feedback,
                'message' => $message,
                'job' => $cv
            )
        );

        if (is_mobile()) {
            $this->success($data);
        } else {
            return $data;
        }
    }

    /**
     * 系统检测
     * @return array
     */
    public function doSysCheck()
    {
        global $_M;
        if ($_M['config']['met_secret_key']) {
            $myapp = load::mod_class('myapp/class/myapp', 'new');
            $new_app = $myapp->checkAppUpdate();

            $data = array(
                'action' => 'checkSystemUpdate',
                'version' => $_M['config']['metcms_v'],
            );
            $result = api_curl($_M['config']['met_api'], $data);
            $res = json_decode($result, true);
            if ($res['status'] == 200) {
                $sys_new_ver = $res['data'];
            }
        }


        $redata = array(
            'new_app' => $new_app,
            'sys_new_ver' => $sys_new_ver,
        );
        return $redata;
    }

    /**
     * 检测授权文件
     */
    public function doGetPackageInfo()
    {
        $package_info = $this->getPackageInfo();
        $this->success($package_info);
    }

    /**
     * @return bool
     */
    public function doGetImgList()
    {
        $img_list = $this->getImgList();
        $this->success($img_list);
    }

    /**
     * 取消系统安全提示
     */
    public function do_no_prompt()
    {
        $configlist = array();
        $configlist[] = 'met_safe_prompt';
        configsave($configlist, array('met_safe_prompt' => 1));
        $this->success();
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
