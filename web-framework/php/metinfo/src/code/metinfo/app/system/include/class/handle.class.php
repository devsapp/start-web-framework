<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 *  数据处理基类.
 */
class handle
{
    /**
     * url 路径进行全站统tt.
     *
     * @param string $url url地址
     *
     * @return array 合法的页面变量
     */
    public function url_transform($url, $lang = '')
    {
        global $_M;
        $lang = $lang ? $lang : $_M['lang'];
        $url = trim($url);
        if (substr($url, 0, 4) == 'http') {
            if (!strstr($url, $_M['url']['web_site'])) {
                return $url;
            }
        }

        $website = $_M['langlist']['web'][$lang]['link'];
        if ($website && !$_M['form']['pageset']) {//非可视化 使用独立域名
            $url = $website . str_replace(array($_M['url']['web_site'], '../'), '', $url);
        } else {
            $site = $_M['url']['site'];
            if (defined('IN_ADMIN')) {
                $site = $_M['url']['web_site'];
            }
            $url = $site . str_replace(array($_M['url']['web_site'], '../'), '', $url);
        }
        if ($_M['form']['pageset']) {
            if (strstr($url, '?')) {
                $url .= '&pageset=1';
            } else {
                if (substr($url, -1) == '/') {
                    $url .= 'index.php?lang=' . $_M['lang'] . '&pageset=1';
                }
            }
        }

        return $url;
    }

    /**
     * 根据模块编号，返回栏目列表遍文件名称.
     *
     * @param string $mod $mod编号
     *
     * @return array 合法的页面变量
     */
    public function mod_to_name($mod)
    {
        global $_M;
        switch ($mod) {
            case '1':
                $name = 'show';
                break;
            case '2':
                $name = 'news';
                break;
            case '3':
                $name = 'product';
                break;
            case '4':
                $name = 'download';
                break;
            case '5':
                $name = 'img';
                break;
            case '6':
                $name = 'job';
                break;
            case '7':
                $name = 'message';
                break;
            case '8':
                $name = 'feedback';
                break;
            case '9':
                $name = 'link';
                break;
            case '10':
                $name = 'member';
                break;
            case '11':
                $name = 'search';
                break;
            case '12':
                $name = 'sitemap';
                break;
            case '13':
                $name = 'tags';
                break;
            default:
                $name = '';
                break;
        }

        return $name;
    }

    /**
     * 根据模块编号，返回栏目列表遍文件名称.
     *
     * @param string $mod $mod编号
     *
     * @return array 合法的页面变量
     */
    public function mod_to_file($mod)
    {
        global $_M;
        switch ($mod) {
            case '1':
                $name = 'about';
                break;
            case '2':
                $name = 'news';
                break;
            case '3':
                $name = 'product';
                break;
            case '4':
                $name = 'download';
                break;
            case '5':
                $name = 'img';
                break;
            case '6':
                $name = 'job';
                break;
            case '7':
                $name = 'message';
                break;
            case '8':
                $name = 'feedback';
                break;
            case '9':
                $name = 'link';
                break;
            case '10':
                $name = 'member';
                break;
            case '11':
                $name = 'search';
                break;
            case '12':
                $name = 'sitemap';
                break;
            case '13':
                $name = 'tags';
                break;
            default:
                $name = '';
                break;
        }

        return $name;
    }

    /**
     * 根据模块编号，返回栏目列表遍文件名称.
     *
     * @param string $mod $mod编号
     *
     * @return array 合法的页面变量
     */
    public function file_to_mod($file)
    {
        global $_M;
        switch ($file) {
            case 'about':
                $mod = '1';
                break;
            case 'news':
                $mod = '2';
                break;
            case 'product':
                $mod = '3';
                break;
            case 'download':
                $mod = '4';
                break;
            case 'img':
                $mod = '5';
                break;
            case 'job':
                $mod = '6';
                break;
            case 'message':
                $mod = '7';
                break;
            case 'feedback':
                $mod = '8';
                break;
            case 'link':
                $mod = '9';
                break;
            case 'member':
                $mod = '10';
                break;
            case 'search':
                $mod = '11';
                break;
            case 'sitemap':
                $mod = '12';
                break;
            case 'tags':
                $mod = '13';
                break;
            default:
                $mod = '';
                break;
        }

        return $mod;
    }

    /**
     * url类型.
     *
     * @param string $type 链接类型（1:动态，2:伪静态，3:静态）
     * @param string $page_type 页面类型（2:分页，1:列表页面，0:内容页面）
     * @param string $pseudo 伪静态  0关闭|1开启
     * @param string $webhtm 静态  0关闭静态|1首页、内容页面静态化|2全站静态
     *
     * @return int|string 链接类型（1:动态，2:伪静态，3:静态）
     */
    public function url_type($type = '', $page_type = '', $pseudo = '', $webhtm = '')
    {
        global $_M;
        if ($_M['form']['pageset']) { //可视化前置动态
            return 1;
        }

        if ($_M['form']['search'] && $page_type == 2) {//搜索状态下，列表页强制动态
            return 1;
        }

        if ($type) {
            return $type;
        }

        //伪静态
        if (!$pseudo) {//伪静态配置
            $pseudo = $_M['config']['met_pseudo'];
        }
        if ($pseudo) {
            return 2;
        }

        if (!$webhtm) {//静态配置
            $webhtm = $_M['config']['met_webhtm'];  //0关闭静态|1首页、内容页面静态化|2全站静态
        }

        //页面类型（2:分页，1:列表页面，0:内容页面）
        if ($page_type) {//列表页
            if ($webhtm == '2') {//2全站静态
                $type = 3;
            } else {
                $type = 1;
            }
        } else {//内容页
            if (!$webhtm) {
                $type = 1;
            } else {
                $type = 3;
            }
        }

        return $type;
    }

    /*
     * url类型
     * @param  string  $module      模块名称或者模块编号
     * @return string               模块名称编号数组
   */
    public function handle_module($module)
    {
        global $_M;
        if (is_numeric($module)) {
            return array(
                'num' => $module,
                'name' => $this->mod_to_file($module),
            );
        } else {
            return array(
                'num' => $this->file_to_mod($module),
                'name' => $module,
            );
        }
    }

    public function replace_list_page_url($url, $page = 1, $class = 0, $type = '')
    {
        global $_M;
        if ($page == 1 && $class && !$_M['form']['search']) {
            $c = load::sys_class('label', 'new')->get('column')->get_column_id($class);

            return load::sys_class('label', 'new')->get('column')->handle->url_full($c, $type);
        } else {
            return str_replace('#page#', $page, $url);
        }
    }

    /**
     * 替换资源相对路径.
     *
     * @param string $content
     *
     * @return mixed
     */
    public function replace_relative_url($content = '')
    {
        global $_M;
        $new_content = str_replace('../', $_M['url']['site'], $content);

        return $new_content;
    }

    public function redirectUrl($data = array())
    {
        global $_M;
        if ($_M['form']['mituo'] == 1) {
            return;
        }

        if ($_M['form']['search'] == 'tag' && strstr(REQUEST_URI, '.php') && $_M['config']['met_pseudo']) {
            if ($data['module'] == 11) {
                // 如果是标签的全站搜索，伪静态时跳转
                header('HTTP/1.1 302 Moved Permanently');
                header("Location: ../tag/{$_M['form']['searchword']}");
                die;
            } else {
                header('HTTP/1.1 302 Moved Permanently');
                header("Location: ./tag/{$_M['form']['content']}");
                die;
            }
        }

        if (strstr(REQUEST_URI, '.php') && !defined('IN_ADMIN') && !$_M['form']['pageset'] && !$_M['form']['search'] && ($_M['config']['met_pseudo'] || $_M['config']['met_webhtm']) && !$_M['form']['metinfonow'] && !isset($_M['form']['para']) && !isset($_M['form']['searchword'])) {
            if ($_M['config']['met_webhtm'] == 1 && $data['list']) {
                return;
            }

            header('HTTP/1.1 302 Moved Permanently');
            header("Location: {$data['url']}");
            die;
        }
    }

    public function checkFunction($site_url = '')
    {
        global $_M;
        if (!$site_url) {
            $site_url = $_M['url']['web_site'];
        }

        $items = array(
            array('mysqli_connect', 'danger', '支持', '函数未开启，网站程序无法使用mysql数据库', '函数'),
            array('zip', 'danger', '支持', '无法在线解压ZIP文件。（无法通过后台上传模板和数据备份文件）<a href="https://www.mituo.cn/qa" target="_blank">帮助</a>', '模块'),
            array('curl', 'danger', '支持', '系统无法远程获取内容，会导致有些操作不起作用或数据不显示<a href="https://www.mituo.cn/qa/2450.html" target="_blank">帮助</a>', '模块'),
            array('file_get_contents', 'danger', '支持', '系统无法远程获取内容，会导致有些操作不起作用或数据不显示<a href="https://www.mituo.cn/qa/2461.html" target="_blank">帮助</a>', '函数'),
            array('file_put_contents', 'danger', '支持', '系统无法写文件<a href="https://www.mituo.cn/qa/2462.html" target="_blank">帮助</a>', '函数'),
            array('file_uploads', 'danger', '支持', '无法上传文件<a href="https://www.mituo.cn/qa/2456.html" target="_blank">帮助</a>', '配置'),
            array('parse_ini_file', 'danger', '支持', '无法连接数据库<a href="https://www.mituo.cn/qa/2463.html" target="_blank">帮助</a>', '函数'),
            array('fopen', 'danger', '支持', '系统无法打开操作文件<a href="https://www.mituo.cn/qa/2460.html" target="_blank">帮助</a>', '函数'),
            array('mb_strlen', 'danger', '支持', '函数未开启，会导致前台显示不完整<a href="https://www.mituo.cn/qa" target="_blank">帮助</a>', '函数'),
            array('bccomp', 'danger', '支持', '函数未开启，会导致支付回调失效<a href="https://www.mituo.cn/qa" target="_blank">帮助</a>', '函数'),
            array('bcmath', 'danger', '支持', '会导致支付回调失效<a href="https://www.mituo.cn/qa" target="_blank">帮助</a>', '模块'),
            array('gd', 'danger', '支持', '图片打水印和缩略生成功能无法使用<a href="https://www.mituo.cn/qa/2453.html" target="_blank">帮助</a>', '模块'),
            array('copy', 'danger', '支持', '无法上传或复制文件<a href="https://www.mituo.cn/qa/2465.html" target="_blank">帮助</a>', '函数'),
            array('smtp', 'warning', '支持', '系统邮件功能无法使用<a href="https://www.mituo.cn/qa/2469.html" target="_blank">帮助</a>', 'smtp'),
            array('rename', 'danger', '支持', '无法重命名文件<a href="https://www.mituo.cn/qa/2464.html" target="_blank">帮助</a>', '函数'),
            array('unlink', 'danger', '支持', '函数未开启，无法清除缓存<a href="https://www.mituo.cn/qa/2467.html" target="_blank">帮助</a>', '函数'),
            array('opendir', 'danger', '支持', '无法列出目录下文件', '函数'),
            array('scandir', 'danger', '支持', '无法列出目录下文件<a href="https://www.mituo.cn/qa/2466.html" target="_blank">[帮助]</a>', '函数'),
            array('curl_exec', 'danger', '支持', '系统无法远程获取内容，会导致有些操作不起作用或数据不显示<a href="https://www.mituo.cn/qa/2468.html" target="_blank">[帮助]</a>', '函数'),
            array('woff2', 'warning', '支持', '不支持该文件类型<a href="https://www.mituo.cn/qa/2446.html" target="_blank">[帮助]</a>', 'woff2'),
            array('PHP', 'danger', PHP_VERSION, 'php版本需要在5.3到8.0之间，否则无法安装使用程序', 'php'),
            array('openssl', 'warning', OPENSSL_VERSION_TEXT, OPENSSL_VERSION_TEXT . '模块未开启，无法发送邮件，且部分应用插件无法使用（如官方商城、一键导入微信文章等）<a href="https://www.mituo.cn/qa/2449.html" target="_blank">[帮助]</a>', 'openssl'),
        );

        if (stristr($_SERVER['SERVER_SOFTWARE'], 'Apache')) {
            $items[] = array('伪静态', 'warning', '支持', '伪静态无法生效', 'apache');
        }
        if (!defined('IN_ADMIN')) {
            $items[] = array('session', 'danger', '支持', '无法登录', 'session');
        } else {
            $items[] = array('SQLite3', 'warning', '支持', '无法使用sqlite数据库，请到php.ini中开启', '类');
        }

        foreach ($items as &$v) {
            $yes = true;
            switch ($v[4]) {
                case '模块':
                    $yes = extension_loaded($v[0]);
                    break;
                case '函数':
                    $yes = function_exists($v[0]);
                    break;
                case 'openssl':
                    $yes = strstr(OPENSSL_VERSION_TEXT, '1.');
                    break;
                case 'php':
                    $yes = version_compare(PHP_VERSION, '5.3.0', '>') && version_compare(PHP_VERSION, '8.1.0', '<');
                    break;
                case 'session':
                    $yes = session_id();
                    break;
                case 'apache':
                    $mod = 'mod_rewrite';
                    if (function_exists('apache_get_modules')) {
                        $yes = in_array($mod, apache_get_modules());
                    } else {
                        if (function_exists('phpinfo')) {
                            ob_start();
                            phpinfo();
                            $phpinfo = ob_get_clean();
                            if (false !== strpos($phpinfo, $mod)) {
                                $yes = true;
                            }
                        }
                    }
                    break;
                case 'smtp':
                    $yes = function_exists('fsockopen') || function_exists('pfsockopen') || function_exists('stream_socket_client');
                    break;
                case 'woff2':
                    $yes = @file_get_contents('../public/fonts/font-awesome/metinfo-icon1.woff2');
                    break;
                case '类':
                    $yes = class_exists($v[0]);
                    break;
                case '配置':
                    $yes = ini_get($v[0]);
                    break;
            }

            if (!$yes) {
                $v[2] = $v[3];
            } else {
                $v[1] = 'success';
            }
        }

        return $items;
    }

    public function checkDirs()
    {
        global $_M;
        $dirs = array(
            '../about/',
            '../download/',
            '../product/',
            '../news/',
            '../img/',
            '../job/',
            '../sitemap/',
            '../upload/',
            '../tags/',
            '../config/',
            '../config/config_db.php',
            '../config/config_safe.php',
            '../cache/',
            '../upload/file/',
            '../message/',
            '../feedback/',
            '../app/',
            '../app/system/',
            /*'../templates/metv7/cache/',
            '../admin/databack/',*/
        );

        if ($_M['config']['met_adminfile']) {
            $dirs[] = "../{$_M['config']['met_adminfile']}/databack/";
        } else {
            $dirs[] = '../admin/databack/';
        }

        if ($_M['config']['met_skin_user']) {
            $dirs[] = "../templates/{$_M['config']['met_skin_user']}/cache/";
        } else {
            $dirs[] = '../templates/metv7/cache/';
        }

        $data = array();
        foreach ($dirs as $key => $row) {
            if (!strstr($row, '.php')) {
                if (!file_exists($row)) {
                    mkdir($row, 0777, true);
                }
            }
            $data[$key]['dir'] = $row;

            if (!file_exists($row)) {
                $data[$key]['msg'] = '文件或文件夹不存在请上传';
                $data[$key]['status'] = 'danger';
            } elseif (!is_writable($row) && version_compare(PHP_VERSION, '5.4') >= 0) {
                $data[$key]['msg'] .= '777属性检测不通过';
                $data[$key]['status'] = 'danger';
            } else {
                $data[$key]['msg'] .= '通 过';
                $data[$key]['status'] = 'success';
            }
        }

        return $data;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
