<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

//版本号
define('SYS_VER', '7.3.0');
define('SYS_VER_TIME', '20200512');

header("Content-type: text/html;charset=utf-8");
error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR);
PHP_VERSION >= '5.1' && date_default_timezone_set('Asia/Shanghai');
@set_time_limit(0);

define('IN_MET', true);
defined('M_NAME')?: define('M_NAME', '');

//网站根目录
define('PATH_WEB', substr(dirname(__FILE__), 0, -10));
//应用开发包根目录
define('PATH_APP', PATH_WEB . "app/");
//应用文件根目录
define('PATH_ALL_APP', PATH_WEB . "app/app/");
//配置文件根目录
define('PATH_CONFIG', PATH_WEB . "config/");
//缓存文件根目录
define('PATH_CACHE', PATH_WEB . "cache/");
//应用开发框架内核根目录
define('PATH_SYS', PATH_APP . "system/");

//系统类根目录
define('PATH_SYS_CLASS', PATH_WEB . "app/system/include/class/");
//系统方法根目录
define('PATH_SYS_FUNC', PATH_WEB . "app/system/include/function/");
//系统模板公用文件根目录
define('PATH_SYS_TEM', PATH_WEB . "app/system/include/templates/");
define('PATH_PUBLIC', PATH_WEB . "public/");
define('PATH_PUBLIC_ADMINOLD', PATH_PUBLIC . "admin/");
define('PATH_PUBLIC_ADMIN', PATH_PUBLIC . "admin/");
define('PATH_PUBLIC_WEB', PATH_PUBLIC . "web/");
//系统模块根目录
define('PATH_SYS_MODULE', PATH_WEB . "app/system/include/module/");

if (!defined('M_TYPE')) {
    if (file_exists(PATH_APP . 'app/' . M_NAME . '/') && M_NAME) {
        define('M_TYPE', 'app');
    } else {
        define('M_TYPE', 'system');
    }
}

if (!defined('M_MODULE')) {
    $ia = $_GET['a'] ? $_GET['a'] : $_POST['a'];
    $ic = $_GET['c'] ? $_GET['c'] : $_POST['c'];
    define('M_MODULE', 'include');
    define('M_CLASS', $ic);
    define('M_ACTION', $ia);
}
//当前文件夹地址
if (M_TYPE == 'system') {
    if (M_MODULE == 'include') {
        define('PATH_OWN_FILE', PATH_APP . M_TYPE . '/' . M_MODULE . '/module/');
    } else {
        define('PATH_OWN_FILE', PATH_APP . M_TYPE . '/' . M_NAME . '/' . M_MODULE . '/');
    }
} else {
    define('PATH_OWN_FILE', PATH_APP . M_TYPE . '/' . M_NAME . '/' . M_MODULE . '/');
    define('PATH_APP_FILE', PATH_APP . M_TYPE . '/' . M_NAME . '/');
}

define('PATH_MODULE_FILE', PATH_APP . 'system' . '/' . M_MODULE . '/');//兼容v20150511内核，之后请不要使用。

//程序运行开始时间
define('TIME_SYS_START', time());

//当前访问的主机名
define('HTTP_HOST', isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']);

//来源页面
define('REQUEST_URI', $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : htmlentities($_SERVER['PHP_SELF']) . '?' . htmlentities($_SERVER['QUERY_STRING']));

//脚本路径
$phpfile = basename(__FILE__);
$_SERVER['PHP_SELF'] = htmlentities($_SERVER['PHP_SELF']);
define('PHP_SELF', $_SERVER['PHP_SELF'] == "" ? $_SERVER['SCRIPT_NAME'] : $_SERVER['PHP_SELF']);

if (!preg_match('/^[A-Za-z0-9_]+$/', M_TYPE . M_NAME . M_MODULE . M_CLASS . M_ACTION)) {
    echo 'Constants must be numbers or letters or underlined';
    die();
}

require_once PATH_SYS_CLASS . 'load.class.php';

load::module();

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
