<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('common');
load::sys_class('admin');

class loadtemp extends admin
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取模板内容字符
     * @param $file
     * @param $data
     * @return mixed
     */
    public function doviewHtml()
    {
        global $_M;
        $path = $_M['form']['path'];
        $data = $_M['form']['data'];

        if ($path) {
            $path = str_replace("\\", '/', $path);
            if (strstr($path, '../')) {
                die();
            }

            $path_info = pathinfo($path);
            if (isset($path_info['extension']) && strtolower($path_info['extension']) != 'php') {
                die();
            }

            $paths = explode('/', $path);
            // 权限检测
            $m_type = $paths[0] == 'apps' ? 'app' : 'system';
            $m_class = $data['c'] ? $data['c'] : 'index';
            $m_action = $data['a'] ? $data['a'] : end($paths);
            $metinfo_admin_name = get_met_cookie('metinfo_admin_name');
            $admin_column_url = $paths[1] . ($m_action != 'index' ? '/' . $m_action : '');
            $query = "SELECT * FROM {$_M['table']['admin_table']} WHERE admin_id = '{$metinfo_admin_name}'";
            $admin_info = DB::get_one($query);
            $check_auth = $this->checkAuth($admin_info['admin_op'], $admin_info['admin_type'], $m_type, $paths[1], $m_class, $m_action, $admin_column_url);

            if ($check_auth['status']) {
                // 加载方法，获取数据传到模板文件
                if ($paths[0] == 'apps' && end($paths) == 'index') {
                    !$data['c'] && $data['c'] = 'index';
                    !$data['a'] && $data['a'] = 'doindex';
                }
                if ($data['c'] && $data['a']) {
                    $data['n'] = $data['n'] ? $data['n'] : $paths[1];
                    $dir = is_file(PATH_SYS . $data['n'] . '/admin/' . $data['c'] . '.class.php') ? PATH_SYS : PATH_ALL_APP;
                    $class_path = $dir . $data['n'] . '/admin/' . $data['c'] . '.class.php';
                    if (file_exists($class_path)) {
                        $paths[0] == 'apps' && $_M['m_name'] = $data['n'];
                        $_GET = array_merge($_GET, $data);
                        $_GET['noajax'] = 1;
                        unset($_POST);
                        $data_class = load::module($dir . $data['n'] . '/admin/', $data['c'], 'new');
                        if (method_exists($data_class, $data['a'])) {
                            $data['handle'] = call_user_func(array($data_class, $data['a']));
                        }else{
                            $data['handle'] = array();
                        }
                        $_M['form']['noajax'] = 0;
                        $_M['form']['path'] = $path;
                    }
                }
                // 模板文件所需参数
                if ($paths[0] == 'sys' || $paths[0] == 'apps') {
                    $_M['url']['own'] = $_M['url']['site'] . 'app/' . ($paths[0] == 'app' ? 'app' : 'system') . '/' . $paths[1] . '/admin/';
                    $_M['url']['own_tem'] = $_M['url']['own'] . 'templates/';
                    $_M['url']['own_name'] = $_M['url']['site_admin'] . '?n=' . $paths[1] . '&';
                }
                // 加载模板文件
                $view = load::sys_class('engine', 'new');
                $html = $view->dofetch($path, $data, false);
                // 应用css、js状态
                if ($paths[0] == 'apps') {
                    $own_tem = PATH_WEB . 'app/app/' . $paths[1] . '/admin/templates/';
                    $own_css = file_exists($own_tem . 'css/' . $paths[1] . '.css') ? 1 : 0;
                    $own_js = file_exists($own_tem . 'js/' . $paths[1] . '.js') ? 1 : 0;
                    $html .= "\n" . '<input type="hidden" name="app_file_status" value="' . $own_css . '|' . $own_js . '"/>';
                }
                $redata = array(
                    'status' => 1,
                    'html' => $html
                );
            } else {
                $redata = $check_auth;
            }
        } else {
            $redata = array(
                'status' => 0,
                'msg' => 'error'
            );
        }
        $this->ajaxReturn($redata);
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>