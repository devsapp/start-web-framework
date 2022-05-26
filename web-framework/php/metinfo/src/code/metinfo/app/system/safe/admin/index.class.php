<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.


defined('IN_MET') or exit('No permission');
load::sys_class('admin');
load::sys_func('file');
/** 安全与效率 */
class index extends admin
{
    public function __construct()
    {
        global $_M;
        parent::__construct();
    }

    //获取设置
    public function doGetSetup()
    {
        global $_M;
        $admin = admin_information();
        $query = "DELETE FROM {$_M['table']['config']} name='met_fd_word' and columnid != 0";
        DB::query($query);

        $feedcfg = DB::get_one("SELECT value FROM {$_M['table']['config']} WHERE lang ='{$_M['lang']}' AND name='met_fd_word' AND columnid = 0");
        $met_fd_word = $feedcfg['value'];

        $list = array();
        $list['met_login_code'] = isset($_M['config']['met_login_code']) ? $_M['config']['met_login_code'] : '';
        $list['met_memberlogin_code'] = isset($_M['config']['met_memberlogin_code']) ? $_M['config']['met_memberlogin_code'] : '';
        $list['met_img_rename'] = isset($_M['config']['met_img_rename']) ? $_M['config']['met_img_rename'] : '';
        $list['met_file_maxsize'] = isset($_M['config']['met_file_maxsize']) ? $_M['config']['met_file_maxsize'] : '';
        $list['met_file_format'] = isset($_M['config']['met_file_format']) ? $_M['config']['met_file_format'] : '';
        $list['met_logs'] = isset($_M['config']['met_logs']) ? $_M['config']['met_logs'] : 0;
        $list['access_type'] = isset($_M['config']['access_type']) ? $_M['config']['access_type'] : 1;
        $list['met_fd_word'] = $met_fd_word;
        $list['disable_cssjs'] = isset($_M['config']['disable_cssjs']) ? $_M['config']['disable_cssjs'] : '';
        $list['met_auto_play_pc'] = isset($_M['config']['met_auto_play_pc']) ? $_M['config']['met_auto_play_pc'] : '0';
        $list['met_auto_play_mobile'] = isset($_M['config']['met_auto_play_mobile']) ? $_M['config']['met_auto_play_mobile'] : '0';
        if ($admin['admin_group'] == 10000) {
            //管理与为创始人才显示后台地址设置
            $list['met_adminfile'] = $_M['config']['met_adminfile'];
        }
        $list['install'] = 0;

        if (is_dir(PATH_WEB . 'install')) {
            $list['install'] = 1;
        }
        $this->success($list);
    }

    //删除安装文件
    public function doDelInstallFile()
    {
        global $_M;
        $dir = PATH_WEB . 'install';
        if (is_dir($dir)) {
            deldir($dir);
            //写日志
            logs::addAdminLog('safety_efficiency', 'setsafeupdate', 'jsok', 'doDelAdmin');
            $this->success($dir, $_M['word']['jsok']);
        }
        //写日志
        logs::addAdminLog('safety_efficiency', 'setsafeupdate', 'opfailed', 'doDelAdmin');
        $this->error();
    }

    //请除模板缓存
    public function clear_cache()
    {
        global $_M;
        if (file_exists(PATH_WEB . 'cache')) {
            deldir(PATH_WEB . 'cache', 1);
        }
        $no = $_M['config']['met_skin_user'];
        $inc_file = PATH_WEB . "templates/{$no}/metinfo.inc.php";
        if (file_exists($inc_file)) {
            require $inc_file;
            if (isset($template_type) && $template_type) {
                deldir(PATH_WEB . 'templates/' . $no . '/cache', 1);
            }
        }
    }

    //保存设置
    public function doSaveSetup()
    {
        global $_M;
        $met_file_format = explode("|", $_M['form']['met_file_format']);
        $new_format = array();
        foreach ($met_file_format as $row) {
            $row = strtolower($row);
            if (strstr($row, 'php')) {
                continue;
            }
            $new_format[] = $row;
        }
        $_M['form']['met_file_format'] = implode('|', $new_format);

        $config_list = array();
        $config_list[] = 'met_img_rename';
        $config_list[] = 'met_login_code';
        $config_list[] = 'met_memberlogin_code';
        $config_list[] = 'met_file_maxsize';
        $config_list[] = 'met_file_format';
        $config_list[] = 'met_fd_word';
        $config_list[] = 'met_logs';
        $config_list[] = 'disable_cssjs';
        $config_list[] = 'access_type';
        $config_list[] = 'met_auto_play_pc';
        $config_list[] = 'met_auto_play_mobile';

        configsave($config_list);

        $current_admin = str_replace($_M['url']['site'], '', trim($_M['url']['site_admin'], '/'));
        $old_admin = $_M['config']['met_adminfile'];
        $new_admin = isset($_M['form']['met_adminfile']) ? $_M['form']['met_adminfile'] : '';
        $new_admin_url = '';
        //创始人才有权限修改后台目录名称
        $admin = admin_information();
        if ($admin['admin_group'] == 10000) {
            if (is_string($new_admin) && $new_admin != '' && $new_admin != $old_admin && $current_admin == $old_admin) {
                $new_admin_url = $_M['url']['web_site'] . $_M['form']['met_adminfile'];
                //中文和特殊字符判断
                if (preg_match("/[\x{4e00}-\x{9fa5}]+/u", $new_admin)) {
                    //写日志
                    logs::addAdminLog('safety_efficiency', 'save', 'js77', 'doSaveSetup');
                    $this->error($_M['word']['js77']);
                } elseif (!preg_match("/^\w+$/u", $new_admin)) {
                    //写日志
                    logs::addAdminLog('safety_efficiency', 'save', 'js77', 'doSaveSetup');
                    $this->error($_M['word']['js77']);
                }

                if (!is_dir(PATH_WEB . $old_admin)) {
                    //写日志
                    logs::addAdminLog('safety_efficiency', 'save', 'setdbNotExist', 'doSaveSetup');
                    $this->error($old_admin . $_M['word']['setdbNotExist']);
                }

                if (is_dir(PATH_WEB . $new_admin)) {
                    //写日志
                    logs::addAdminLog('safety_efficiency', 'save', 'columnerr4', 'doSaveSetup');
                    $this->error($new_admin . $_M['word']['columnerr4']);
                }

                $res = rename(PATH_WEB . $old_admin, PATH_WEB . $new_admin);
                if (!$res) {
                    //写日志
                    movedir(PATH_WEB . $old_admin, PATH_WEB . $new_admin);
                    if (!is_dir(PATH_WEB . $new_admin)) {
                        logs::addAdminLog('safety_efficiency', 'save', 'authTip12', 'doSaveSetup');
                        $this->error($_M['word']['rename_admin_dir']);
                    }
                }
            }
        }

        //写日志
        logs::addAdminLog('safety_efficiency', 'save', 'jsok', 'doSaveSetup');
        $return_data = array();
        if ($new_admin_url) {
            $return_data['url'] = str_replace($old_admin, $new_admin, $_SERVER['HTTP_REFERER']);
        }

        deldir(PATH_WEB . 'cache/templates/', 1);

        $this->success($return_data, $_M['word']['jsok']);
    }

    /**
     * 切换数据库
     */
    public function doSaveDatabase()
    {
        global $_M;
        if (!in_array($_M['form']['db_type'], array('mysql', 'sqlite'))) {
            $this->error('参数错误');
        }

        $config = array();
        if ($_M['form']['db_type'] == $_M['config']['db_type']) {
            $this->success('', $_M['word']['jsok']);
        }

        switch ($_M['form']['db_type']) {
            case 'sqlite':
                if (!class_exists('SQLite3')) {
                    $this->error('Class SQLite3 not found');
                }
                if (!file_exists(PATH_WEB . $_M['config']['db_name'])) {
                    $fp = fopen(PATH_WEB . $_M['config']['db_name'], 'w');
                    if (!$fp) {
                        $this->error(PATH_WEB . $_M['config']['db_name'] . ' File creation failed');
                    }
                    fclose($fp);
                }
                load::mod_class('databack/transfer', 'new')->mysqlExportSqlite();
                break;
            case 'mysql':
                $config['con_db_host'] = $_M['form']['db_host'];
                $config['con_db_port'] = $_M['form']['db_port'] ? $_M['form']['db_port'] : 3306;
                $config['con_db_id'] = $_M['form']['db_username'];
                $config['con_db_pass'] = $_M['form']['db_pass'];
                $config['con_db_name'] = $_M['form']['db_name'];
                $config['tablepre'] = $_M['form']['db_prefix'];

                $db = mysqli_connect($config['con_db_host'], $config['con_db_id'], $config['con_db_pass'], '', $config['con_db_port']);
                if (!$db) {
                    $this->error(mysqli_connect_error());
                }

                if (!@mysqli_select_db($db, $config['con_db_name'])) {
                    $res = mysqli_query($db, "CREATE DATABASE {$config['con_db_name']} ");
                    if (!$res) {
                        $this->error('创建数据库失败: ' . mysqli_error($db));
                    }
                }
                $mysqli = @new mysqli($config['con_db_host'], $config['con_db_id'], $config['con_db_pass'], $config['con_db_name'], $config['con_db_port']);
                if ($mysqli->connect_errno) {
                    $this->error($mysqli->connect_error);
                }

                mysqli_select_db($db, $config['con_db_name']);
                load::mod_class('databack/transfer', 'new')->sqliteExportMysql($config);
                break;
            default:
                $this->error('参数错误');
                die();
                break;
        }

        $config['db_type'] = $_M['form']['db_type'];
        setDbConfig($config);
        $this->success('', $_M['word']['jsok']);
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
