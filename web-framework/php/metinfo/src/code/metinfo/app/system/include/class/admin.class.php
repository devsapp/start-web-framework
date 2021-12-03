<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
#根据《《中华人民共和国著作权法》第四十七条至第五十条的规定表明若用户存在侵犯著作权事实，应当根据情况，承担停止侵害、消除影响、赔礼道歉、赔偿损失等民事责任.......情节严重的，著作权行政管理部门还可以没收主要用于制作侵权复制品的材料、工具、设备等；构成犯罪的，依法追究刑事责任。因而，若用户未经许可，擅自进行修改、删除等侵犯长沙米拓信息技术有限公司著作权的侵权行为，长沙米拓信息技术有限公司有权对该行为通过法律途径追究侵权责任。

defined('IN_MET') or exit('No permission');
defined('IN_ADMIN') or exit('No permission');

load::sys_class('common');
load::sys_class('nav');
load::sys_func('admin');

class admin extends common
{
    public function __construct()
    {
        global $_M;
        parent::__construct();
        met_cooike_start();
        $this->load_language();
        $this->check();
        $this->lang_switch();
        $this->load_help_url();
        load::plugin('doadmin');
    }

    protected function load_url_site()
    {
        global $_M;
        $http = $this->checkHttps();
        $_M['url']['admin_site'] = $http . str_replace(array('/index.php', '/Index.php'), '', HTTP_HOST . PHP_SELF) . '/';
        $_M['url']['web_site'] = preg_replace('/(\/[^\/]*\/$)/', '', $_M['url']['admin_site']) . '/';
        $_M['url']['site_admin'] = str_replace($_M['url']['web_site'], '../', $_M['url']['admin_site']);
        $_M['config']['met_weburl'] = $_M['url']['admin_site'];
    }

    protected function load_url_unique()
    {
        global $_M;
        $_M['url']['adminurl'] = $_M['url']['site_admin'] . "index.php?lang={$_M['lang']}" . '&';
        $_M['url']['own_name'] = $_M['url']['adminurl'] . 'n=' . M_NAME . '&';
        $_M['url']['own_form'] = $_M['url']['own_name'] . 'c=' . M_CLASS . '&';
    }

    protected function load_help_url()
    {
        global $_M;
        $code = @file_get_contents(PATH_WEB . 'config/code.txt');
        $str = '';
        if ($code) {
            $str .= "&metinfo_code=" . trim($code);
        }
        $_M['config']['metinfo_code'] = $code;
        $fields = array('help', 'edu', 'kf', 'qa', 'templates', 'app', 'market', 'copyright');
        foreach ($fields as $val) {
            $_M['config'][$val . '_url'] = "https://u.mituo.cn/api/metinfo?type={$val}" . $str;
        }
        $_M['config']['license_url'] = "../upload/file/license.html" . $str;
    }

    protected function load_language()
    {
        global $_M;
        $admin = admin_information();
        $_M['langset'] = $_M['form']['langset'] ? $_M['form']['langset'] : ($admin['admin_login_lang'] ? $admin['admin_login_lang'] : get_met_cookie('languser'));
        if (!$_M['langset'] || $_M['langset'] == 'metinfo') {
            $_M['langset'] = $_M['config']['met_admin_type'];
        }

        $this->load_word($_M['langset'], 1);
        $this->load_agent_word($_M['langset']);
    }

    protected function load_agent_word($lang)
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['config']} WHERE lang='{$lang}-metinfo'";
        $result = DB::get_all($query);
        foreach ($result as $row) {
            $lang_agents[$row['name']] = $row['value'];
        }
        $_M['word']['indexthanks'] = $lang_agents['met_agents_thanks'];
        $_M['word']['metinfo'] = $lang_agents['met_agents_name'];
        $_M['word']['copyright'] = $lang_agents['met_agents_copyright'];
        $_M['word']['oginmetinfo'] = $lang_agents['met_agents_depict_login'];
    }

    protected function filter_config($value)
    {
        //$value = str_replace('"', '&#34;', str_replace("'", "&#39;", $value));
        $value = parent::filter_config($value);
        return $value;
    }

    protected function lang_switch()
    {
        global $_M;
        if ($_M['form']['switch']) {
            $url = "{$_M['url']['site_admin']}index.php?lang={$_M['lang']}";
            if ($_M['form']['a'] != 'dohome') {
                $url .= "&switchurl=" . urlencode(HTTP_REFERER) . "#metnav_" . $_M['form']['anyid'];
            }
            echo "
			<script>
				window.parent.location.href='{$url}';
			</script>
			";
            die();
        }
    }

    protected function gologin()
    {
        global $_M;
        if (M_NAME == 'index') {
            load::mod_class('login/admin/login', 'new')->doindex();
        } else {
            if (is_mobile()) {
                //http_response_code(401);
                $this->error('', '', 401);
            }

            Header("Location: " . $_M['url']['site_admin']);
        }
    }

    protected function check()
    {
        global $_M;
        $http = isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'http';
        $current_url = $http . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        if (strstr($current_url, $_M['url']['site_admin'] . "index.php")) {
            $admin_index = 1;
        } else {
            $admin_index = '';
        }

        $metinfo_admin_name = get_met_cookie('metinfo_admin_name');
        $metinfo_admin_pass = get_met_cookie('metinfo_admin_pass');
        $query = "SELECT * FROM {$_M['table']['admin_table']} WHERE admin_id = '{$metinfo_admin_name}' AND admin_pass = '{$metinfo_admin_pass}'";
        $admin_info = DB::get_one($query);

        if (!$metinfo_admin_name || !$metinfo_admin_pass) {
            if (!$admin_index) {
                $this->refereCooike();
            }
            met_cooike_unset();
            $this->gologin();
            exit;
        } else {
            if (!$admin_info) {
                if (!$admin_index) {
                    $this->refereCooike();
                }

                met_cooike_unset();
                $this->gologin();
                exit;
            }
        }
        //如果是pc端则跳转链接
        $this->checkAuth($admin_info['admin_op'], $admin_info['admin_type']);
    }

    //检测权限
    protected function checkAuth($admin_op, $admin_type, $m_type = M_TYPE, $m_name = M_NAME, $m_class = M_CLASS, $m_action = M_ACTION, $url = '')
    {
        global $_M;
        if (!strstr($admin_op, "metinfo")) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
                $return_url = "";
            } else {
                $return_url = "javascript:window.history.back();";
            }
            if (stristr($m_action, 'add')) {
                if (!strstr($admin_op, "add")) {
                    return $this->returnData('-1', $_M['word']['loginadd']);
                }
            }
            if (stristr($m_action, 'editor') || stristr($_M['form']['sub_type'], 'editor')) {
                if (!strstr($admin_op, "editor")) {
                    return $this->returnData($return_url, $_M['word']['loginedit']);
                }
            }
            if (stristr($m_action, 'del') || stristr($_M['form']['submit_type'], 'del')) {
                if (!strstr($admin_op, "del")) {
                    return $this->returnData($return_url, $_M['word']['logindelete']);
                }
            }
            if (stristr($m_action, 'all')) {
                if (!strstr($admin_op, "metinfo")) {
                    return $this->returnData($return_url, $_M['word']['loginall']);
                }
            }
            if (stristr($m_action, 'save')) {
                if ($_M['form']['submit_type'] == 'del') {
                    if (!strstr($admin_op, "del")) {
                        return $this->returnData($return_url, $_M['word']['logindelete']);
                    }
                } else {
                    if (isset($_M['form']['id']) && $_M['form']['id']) {
                        if (!strstr($admin_op, "editor")) {
                            return $this->returnData($return_url, $_M['word']['loginadd']);
                        }
                    } else {
                        if (!strstr($admin_op, "add")) {
                            return $this->returnData($return_url, $_M['word']['loginadd']);
                        }
                    }
                }
            }
            if (stristr($m_action, 'table')) {
                if (stristr($_M['form']['submit_type'], 'save')) {
                    if ($_M['form']['allid']) {
                        $power_ids = explode(',', $_M['form']['allid']);
                        $e = 0;
                        $a = 0;
                        foreach ($power_ids as $val) {
                            if ($val) {
                                if (is_numeric($val)) {
                                    $e++;
                                } else {
                                    $a++;
                                }
                            }
                            if ($e > 0) {
                                if (!strstr($admin_op, "editor")) {
                                    return $this->returnData($return_url, $_M['word']['loginedit']);
                                }
                            }
                            if ($a > 0) {
                                if (!strstr($admin_op, "add")) {
                                    return $this->returnData($return_url, $_M['word']['loginadd']);
                                }
                            }
                        }
                    }
                }
                if (stristr($_M['form']['submit_type'], 'del')) {
                    if (!strstr($admin_op, "del")) {
                        return $this->returnData($return_url, $_M['word']['logindelete']);
                    }
                }
            }

            //可视化
            if ($m_action == 'doset_text_content') {
                if (!strstr($admin_op, "editor")) {
                    return $this->returnData($return_url, $_M['word']['loginedit']);
                }
            }
        }
        $n = $m_name;

        //        if ($n == 'index') {
        //            $n = 'manage';
        //        }

        $field = '-';

        if ($n == 'myapp' && $m_class == 'index' && $m_action == 'doAction') {
            if ($_M['form']['handle'] == 'install') {
                $n = 'appinstall';
            } else {
                $n = 'appuninstall';
            }
        }

        if ($m_type == 'app') {
            $query = "SELECT no FROM {$_M['table']['applist']} WHERE m_name = '{$n}'  AND m_class = '{$m_class}'";
            $applist = DB::get_one($query);
            if ($applist) {
                $field = $applist['no'];
            }
        } else {
            if (is_mobile()) {
                $route = "(url='{$n}' OR url='{$n}/')";
            } else {
                if (!$url) {
                    $route = "(url='{$n}' OR url='{$n}/')";
                } else {
                    $route = "(url='{$url}' OR url='{$n}')";
                }
            }
            $query = "SELECT field FROM {$_M['table']['admin_column']} WHERE {$route}";
            $admin_column = DB::get_one($query);

            if ($admin_column) {
                $field = $admin_column['field'];
            }
        }
        $field = strval($field);

        //!!1603 管理員
        if (!stristr($admin_type, $field) && $admin_type != 'metinfo' && $field != 1603) {
            return $this->returnData('-1', $_M['word']['js81']);
        }
        if (stristr($m_name, 'appstore')) {
            if (!stristr($admin_type, '1507') && $admin_type != 'metinfo') {
                return $this->returnData('-1', $_M['word']['appmarket_jurisdiction']);
            }
        }
        if (stristr($m_name, 'theme')) {
            if ($_M['form']['mobile']) {
                if (!stristr($admin_type, '1102') && $admin_type != 'metinfo') {
                    return $this->returnData('-1', $_M['word']['setup_permissions']);
                }
            } else {
                if (!stristr($admin_type, '1101') && $admin_type != 'metinfo') {
                    return $this->returnData('-1', $_M['word']['setup_permissions']);
                }
            }
        }
        if (stristr($m_name, 'column') && stristr($m_action, 'add')) {
            if (!stristr($admin_type, 's9999') && $admin_type != 'metinfo') {
                return $this->returnData('-1', $_M['word']['js81']);
            }
        }
        $redata = array(
            'status' => 1,
        );
        return $redata;
    }

    /**
     * 使用JS方式页面跳转
     * @param  string $url 跳转地址
     * @param  string $langinfo 跳转时alert弹窗内容
     * @param  string $type 1：pc端 2：手机端
     */
    protected function returnData($url, $langinfo)
    {
        if (M_CLASS == 'loadtemp') {
            $redata = array(
                'status' => 0,
                'msg' => $langinfo,
            );
            return $redata;
        } else {
            if (($_SERVER["HTTP_X_REQUESTED_WITH"] && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") || $_SERVER["REQUEST_METHOD"] == 'POST') {
                $this->error($langinfo, '', 403);
            } else {
                if ($langinfo) {
                    $langstr = "alert('{$langinfo}');";
                }

                if ($url == '-1') {
                    $js = "window.history.back();";
                } else {
                    $js = "location.href='{$url}';";
                }
                echo ("<script type='text/javascript'>{$langstr} {$js} </script>");
                die();
            }
        }
    }

    protected function refereCooike()
    {
        global $_M;

        $met_adminfile = $_M['config']['met_adminfile'];
        $http = isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'http';
        $http_referer = $_SERVER['HTTP_REFERER'];
        $referer_url = explode('?', $http_referer);
        $admin_file_len1 = strlen("/{$met_adminfile}/");
        $admin_file_len2 = strlen("/{$met_adminfile}/index.php");
        if (strrev(substr(strrev($referer_url[0]), 0, $admin_file_len1)) == "/{$met_adminfile}/" || strrev(substr(strrev($referer_url[0]), 0, $admin_file_len2)) == "/{$met_adminfile}/index.php" || !$referer_url[0]) {
            $referer_url = "{$http}://{$_SERVER['SERVER_NAME']}{$_SERVER['REQUEST_URI']}";
        }

        if (is_string($referer_url) && !strstr($referer_url, "return.php")) {
            if (!$_COOKIE['re_url']) {
                met_setcookie("re_url", $referer_url, time() + 3600);
            }
        }
    }

    public function access_option($access = 0)
    {
        global $_M;
        $group_list = load::sys_class('group', 'new')->get_group_list();
        if ($access) {
            $access_val = load::sys_class('user', 'new')->get_group_access($access);
            $access_val = $access_val['access'];
            if ($access == '-1') {
                $max_access = load::sys_class('group', 'new')->get_max_access();
                $access_val = $max_access + 1;
            }
        }

        $list = array();
        if ($access) {
            foreach ($group_list as $key => $val) {
                if ($val['access'] >= $access_val) {
                    $arr = array('name' => $val['name'], 'val' => $val['id']);
                    $list[] = $arr;
                }
            }
        } else {
            $list[] = array('name' => $_M['word']['unrestricted'], 'val' => 0);
            foreach ($group_list as $key => $val) {
                $arr = array('name' => $val['name'], 'val' => $val['id']);
                $list[] = $arr;
            }
        }

        //管理员
        ##$admin_id = $val['id'] + 1;
        #$admin_id = '-1';
        #$list[] = array('name' => $_M['word']['metadmin'], 'val' => $admin_id);

        return $list;
    }

    /**
     *
     * @return array
     */
    public function getMetAdmin()
    {
        global $_M;
        $metinfo_admin_name = get_met_cookie('metinfo_admin_name');
        $met_admin = DB::get_one("select * from {$_M['table']['admin_table']} where admin_id='{$metinfo_admin_name}'");
        return $met_admin;
    }

    /**
     * [js系统变量]
     * @return [type] [description]
     */
    public function sys_json()
    {
        global $_M;
        $_M['config']['metinfo_version'] = str_replace('.', '', $_M['config']['metcms_v']);
        $arrlanguage = $_COOKIE['arrlanguage'];
        $arrlanguage = explode('|', $arrlanguage);
        if (in_array('metinfo', $arrlanguage) || in_array('1002', $arrlanguage)) {
            $langprivelage = 1;
        } else {
            $langprivelage = 0;
        }

        $met_para = array(
            'met_editor' => $_M['config']['met_editor'],
            'met_keywords' => $_M['config']['met_keywords'],
            'met_alt' => $_M['config']['met_alt'],
            'met_atitle' => $_M['config']['met_atitle'],
            'metcms_v' => $_M['config']['metcms_v'],
            'patch' => $_M['config']['patch'],
            'tem' => $_M['config']['met_skin_user'],
            'langprivelage' => $langprivelage,
            'url' => array(
                'admin' => $_M['url']['site_admin'],
                'adminurl' => $_M['url']['adminurl'],
                'api' => $_M['url']['api'],
                'own_form' => $_M['url']['own_form'],
                'own_name' => $_M['url']['own_name'],
                'own' => $_M['url']['own'],
                'own_tem' => $_M['url']['own_tem'],
            ),
        );
        $met_para = json_encode($met_para);

        $copyright = str_replace('$metcms_v', $_M['config']['metcms_v'], $_M['config']['met_agents_copyright_foot']);
        $copyright = str_replace('$m_now_year', date('Y', time()), $copyright);
        $copyright = str_replace('&#34;', '', $copyright);
        if (strstr($copyright, 'www.mituo.cn') || strstr($copyright, 'www.metinfo.cn')) {
            $copyright = preg_replace_callback('/\/\/([a-zA-Z0-9-_\.\?&]+)/', function ($match) use ($_M) {
                if ($match && $match[1]) {
                    if (strstr($match[1], '?')) {
                        $type = '&';
                    } else {
                        $type = '?';
                    }

                    if (strstr($match[0], 'www.mituo.cn') || strstr($match[0], 'www.metinfo.cn')) {
                        return $match[0] . $type . 'metinfo_code=' . $_M['config']['metinfo_code'];
                    } else {
                        return $match[0];
                    }
                }
            }, $copyright);
        }

        $sys_json = array(
            'copyright' => $copyright,
            'met_para' => $met_para,
        );
        return $sys_json;
    }

    /**
     * 判断后台目录是否安全
     */
    public function admin_folder_safe()
    {
        global $_M;
        $result = 1;
        if (!$_M['config']['met_safe_prompt']) {
            //判断后来路径是否包含admin和网站关键词
            if (preg_match("/\/admin\/$/", $_M['url']['site_admin'])) {
                $result = 0;
            }

            $site_arr = explode('/', rtrim($_M['url']['site_admin'], '/'));
            $admin_name = array_pop($site_arr);
            if ($admin_name == $_M['config']['met_keywords'] && $_M['config']['met_keywords']) {
                $result = 0;
            }
        }
        return $result;
    }

    // 判断后台各模块入口权限
    public function get_auth($power = array())
    {
        global $_M;
        $power = $power ? $power : admin_information();
        $data = array();
        //判断是否有环境检测的权限
        if (strstr($power['admin_type'], 's1903') || strstr($power['admin_type'], 'metinfo')) {
            $data['environmental_test'] = 1;
        }
        //判断是否有功能大全的权限
        if (strstr($power['admin_type'], 's1902') || strstr($power['admin_type'], 'metinfo')) {
            $data['function_complete'] = 1;
        }
        //判断是否有清空缓存的权限
        if (strstr($power['admin_type'], 's1901') || strstr($power['admin_type'], 'metinfo')) {
            $data['clear_cache'] = 1;
        }
        //判断是否有检测更新的权限
        if (strstr($power['admin_type'], 's1104') || strstr($power['admin_type'], 'metinfo')) {
            $data['checkupdate'] = 1;
            if (!$_M['config']['met_agents_update']) {
                $data['checkupdate'] = 0;
            }
        }

        //判断是否有基本信息设置权限
        if (strstr($power['admin_type'], 's1007') || strstr($power['admin_type'], 'metinfo')) {
            $data['basic_info'] = 1;
        }

        //判断是否有栏目设置权限
        if (strstr($power['admin_type'], 's1201') || strstr($power['admin_type'], 'metinfo')) {
            $data['column'] = 1;
        }

        //判断是否有内容设置权限
        if (strstr($power['admin_type'], 's1301') || strstr($power['admin_type'], 'metinfo')) {
            $data['content'] = 1;
        }

        //判断是否有网站模板权限
        if (strstr($power['admin_type'], 's1405') || strstr($power['admin_type'], 'metinfo')) {
            $data['site_template'] = 1;
            $query = "SELECT * FROM {$_M['table']['admin_column']} WHERE name = 'lang_appearance'";
            $info = DB::get_one($query);
            if (!$info['type'] && !$_M['config']['lang_appearance']) {
                $data['site_template'] = 0;
            }
        }
        //判断是否有水印缩略图权限
        if (strstr($power['admin_type'], 's1003') || strstr($power['admin_type'], 'metinfo')) {
            $data['watermark_thumbnail'] = 1;
        }
        //判断是否有banner管理权限
        if (strstr($power['admin_type'], 's1604') || strstr($power['admin_type'], 'metinfo')) {
            $data['banner'] = 1;
        }
        //判断是否有手机菜单权限
        if (strstr($power['admin_type'], 's1605') || strstr($power['admin_type'], 'metinfo')) {
            $data['mobile_menu'] = 1;
        }
        //判断是否有seo权限
        if (strstr($power['admin_type'], 's1404') || strstr($power['admin_type'], 'metinfo')) {
            $data['seo'] = 1;
        }
        //判断是否有友情链接权限
        if (strstr($power['admin_type'], 's1406') || strstr($power['admin_type'], 'metinfo')) {
            $data['link'] = 1;
        }
        //判断是否有语言权限
        if (strstr($power['admin_type'], 's1002') || strstr($power['admin_type'], 'metinfo')) {
            $data['language'] = 1;
        }
        //判断是否有应用插件权限
        if (strstr($power['admin_type'], 's1505') || strstr($power['admin_type'], 'metinfo')) {
            $data['myapp'] = 1;
            $query = "SELECT * FROM {$_M['table']['admin_column']} WHERE name = 'lang_myapp'";
            $info = DB::get_one($query);
            if (!$_M['config']['lang_myapp'] && !$info['type']) {
                $data['myapp'] = 0;
            }
        }
        if (strstr($power['admin_type'], 'a10070') || strstr($power['admin_type'], 'metinfo')) {
            $data['met_agents_sms'] = 1;
            if (!$_M['config']['met_agents_sms']) {
                $data['met_agents_sms'] = 0;
            }
        }
        //判断是否有备份恢复权限
        if (strstr($power['admin_type'], 's1005') || strstr($power['admin_type'], 'metinfo')) {
            $data['databack'] = 1;
        }
        //判断是否有客服管理权限
        if (strstr($power['admin_type'], 's1106') || strstr($power['admin_type'], 'metinfo')) {
            $data['online'] = 1;
        }
        //判断是否有用户管理权限
        if (strstr($power['admin_type'], 's1506') || strstr($power['admin_type'], 'metinfo')) {
            $data['user'] = 1;
        }
        //判断是否有会员管理权限
        if (strstr($power['admin_type'], 's1601') || strstr($power['admin_type'], 'metinfo')) {
            $data['web_user'] = 1;
        }
        //判断是否有安全与效率权限
        if (strstr($power['admin_type'], 's1004') || strstr($power['admin_type'], 'metinfo')) {
            $data['safe'] = 1;
        }
        //判断是否有管理员设置权限
        if (strstr($power['admin_type'], 's1603') || strstr($power['admin_type'], 'metinfo')) {
            $data['admin_user'] = 1;
        }
        //判断是否有企业超市权限
        if (strstr($power['admin_type'], 's1508') || strstr($power['admin_type'], 'metinfo')) {
            $data['partner'] = 1;
            $query = "SELECT * FROM {$_M['table']['admin_column']} WHERE name = 'cooperation_platform'";
            $info = DB::get_one($query);
            if (!$_M['config']['met_agents_metmsg'] && !$info['type']) {
                $data['partner'] = 0;
            }
        }
        //判断是否有风格设置权限
        if (strstr($power['admin_type'], 's1905') || strstr($power['admin_type'], 'metinfo')) {
            $data['style_settings'] = 1;
        }
        //判断是否有导航菜单设置权限
        if (strstr($power['admin_type'], 's1904') || strstr($power['admin_type'], 'metinfo')) {
            $data['nav_setting'] = 1;
        }
        // 可视化权限
        if (strstr($power['admin_type'], 's1802') || strstr($power['admin_type'], 'metinfo')) {
            $data['ui_set'] = 1;
        }

        return $data;
    }

    // 根据《中华人民共和国著作权法》及《计算机软件保护条例》，此处为权利人的技术保护措施，切勿删除或修改！违反者须承担侵权后果！
    public function getPackageInfo()
    {
        global $_M;
        $data = array('show'=>0,'package'=>'免费版');
        $local = array('localhost','127.0.0','192.168.');
        foreach ($local as $url) {
            $info = explode('/',trim(str_replace(array('https://','http://'),'',$_M['url']['web_site']),'/'));
            if(strstr($info[0],$url)){
                return $data;
            }
        }

        $appno = array();
        $applist = DB::get_all("SELECT no FROM {$_M['table']['applist']}");
        foreach ($applist as $item) {
            $appno[] = $item['no'];
        }

        $hasCopyright = self::checkCopyright();

        $license_file = PATH_WEB . "config/metinfo.txt";

        $url = "https://api.mituo.cn/license";
        $data = array(
            'action' => 'getPackageInfo',
            'copyright'=>$hasCopyright,
            'appno'=>json_encode($appno),
            'skin_name'=>$_M['config']['met_skin_user']
        );
        $res = api_curl($url, $data);
        $res = json_decode($res, true);
        
        if ($res['code'] == 0) {
            $data = $res['data'];
            if(isset($data['license'])){
                file_put_contents($license_file,$data['license']);
            }
        }
        return $data;
    }

    /**
     * @return bool
     */
    public function getImgList()
    {
        $url = 'https://api.mituo.cn/client';
        $data = array(
            'action' => 'getImgList'
        );
        $res = api_curl($url, $data);
        $res = json_decode($res, true);
        if($res['code'] == 0){
            return $res['data'];
        }
        return array();
    }

    /**
     * @return bool
     */
    protected function checkCopyright()
    {
        global $_M;
        //页面验证
        $url = $_M['url']['web_site'];
        $index_ = file_get_contents($url);
        if ($index_) {
            $index_ = str_replace(array("\n"), '', $index_);
            $preg = '/\<div class=[\'\"]powered_by_metinfo[\'\"]\>.*?\<\/div\>/i';  //<div>
            preg_match($preg,  $index_, $mutch);
            if ($mutch) {
                $preg = '/<a[^>]*href[=\"\'\s]+([^\"\']*)[\"\']?[^>]*>/i';    //<a>
                preg_match_all($preg, $mutch[0], $mutch2);
                foreach ($mutch2[1] as $row) {
                    $row = strtolower($row);
                    if (strpos($row, 'metinfo.cn') || strpos($row, 'mituo.cn')) {
                        return true;
                    }
                }
            } else {
                return false;
            }
        }
        return true;
    }

    /**
     * 获取系统插件开源许可协议
     * @param string $dir
     * @param int $level
     * @return array
     */
    public function get_plugins_license()
    {
        global $_M;
        if (!$_M['config']['met_agents_metmsg']) {//显示官方信息
            return;
        }

        $dir = PATH_PUBLIC . 'plugins/';

        $list = array();
        $handle = scan_dir($dir);
        foreach ($handle as $row) {
            $path = PATH_WEB . $row;
            if (is_dir($path)) {
                if(file_exists($path.'/LICENSE')){
                    $license = array();
                    $license['name'] = $row . '/';
                    $license['license_url'] = $row . '/LICENSE';
                    $list[] = $license;
                }else{
                    $handle_2 = scan_dir($path);
                    foreach ($handle_2 as $row2) {
                        if (strstr($row2, 'LICENSE')) {
                            $license = array();
                            $license['name'] = str_replace('.LICENSE', '.js', $row2);
                            $license['license_url'] = $row2;
                            $list[] = $license;
                        }
                    }
                }
            } else{
                if (strstr($row, 'LICENSE')) {
                    $license = array();
                    $license['name'] = str_replace('.LICENSE', '.js', $row);
                    $license['license_url'] = $row;
                    $list[] = $license;
                }
            }
        }

        return $list;
    }

    public function __destruct()
    {
        global $_M;
        // TODO: Implement __destruct() method.
        load::plugin('doadminend');
        #buffer::clearConfig();
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
