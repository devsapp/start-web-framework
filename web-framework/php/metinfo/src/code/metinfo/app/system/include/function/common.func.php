<?php

// MetInfo Enterprise Content Management System
// Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * 输出字符串或数组.
 *
 * @param string/array $vars   输出字符串或数组
 * @param string       $label  提示标题
 * @param string       $return 是否有返回值
 */
function dump($vars, $label = '', $return = false)
{
    if (ini_get('html_errors')) {
        $content = "<pre>\n";
        if ($label != '') {
            $content .= "<strong>{$label} :</strong>\n";
        }
        $content .= htmlspecialchars(print_r($vars, true), ENT_COMPAT, 'ISO-8859-1');
        $content .= "\n</pre>\n";
    } else {
        $content = $label." :\n".print_r($vars, true);
    }
    if ($return) {
        return $content;
    }
    echo $content;

    return null;
}

/**
 * @param $vars
 */
function dd($vars = '')
{
    dump($vars);
    die();
}

function getip()
{
    $IPaddress = '';
    if (isset($_SERVER)) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $IPaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $IPaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $IPaddress = $_SERVER['REMOTE_ADDR'];
        }
    } else {
        if (getenv('HTTP_X_FORWARDED_FOR')) {
            $IPaddress = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_CLIENT_IP')) {
            $IPaddress = getenv('HTTP_CLIENT_IP');
        } else {
            $IPaddress = getenv('REMOTE_ADDR');
        }
    }

    return daddslashes($IPaddress);
}

/**
 * 提取一个数组中部分键值返回.
 *
 * @param array    $roc      提取的数组
 * @param keyarray $keyarray 需要提取的键值数组
 *
 * @return array 返回提取的键值数组
 */
function copykey($roc, $keyarray)
{
    $des = array();
    if (is_array($keyarray)) {
        foreach ($keyarray as $key => $val) {
            $des[$val] = $roc[$val];
        }
    }

    return $des;
}

/**
 * 对字符串进行反斜杠处理，如果服务器开启MAGIC_QUOTES_GPC。则不处理。
 *
 * @param string/array $string 处理的字符串或数组
 * @param bool         $force  是否强制反斜杠处理
 *
 * @return array 返回处理好的字符串或数组
 */
function daddslashes($string, $force = 0)
{
    if ($force) {
        if (is_array($string)) {
            foreach ($string as $key => $val) {
                $string[$key] = daddslashes($val, $force);
            }
        } else {
            if (!defined('IN_ADMIN')) {
                $string = trim(addslashes(sqlinsert($string)));
            } else {
                $string = trim(addslashes($string));
            }
        }
    }

    return $string;
}

/**
 * 对字符串进行SQL注入过滤.
 *
 * @param string/array $string 处理的字符串或数组
 *
 * @return array 返回处理好的字符串或数组
 */
function sqlinsert($string)
{
    if (is_array($string)) {
        foreach ($string as $key => $val) {
            $string[$key] = sqlinsert($val);
        }
    } else {
        $string_old = $string;
        $string = str_ireplace('*', '/', $string);
        $string = str_ireplace('%5C', '/', $string);
        $string = str_ireplace('%22', '/', $string);
        $string = str_ireplace('%27', '/', $string);
        $string = str_ireplace('%2A', '/', $string);
        $string = str_ireplace('~', '/', $string);
        $string = str_ireplace('select', "\sel\ect", $string);
        $string = str_ireplace('insert', "\ins\ert", $string);
        $string = str_ireplace('update', "\up\date", $string);
        $string = str_ireplace('delete', "\de\lete", $string);
        $string = str_ireplace('union', "\un\ion", $string);
        $string = str_ireplace('into', "\in\to", $string);
        $string = str_ireplace('load_file', "\load\_\file", $string);
        $string = str_ireplace('outfile', "\out\file", $string);
        $string = str_ireplace('sleep', "\sle\ep", $string);
        $string = strip_tags($string);
        if ($string_old != $string) {
            $string = '';
        }
        $string = str_ireplace('\\', '/', $string);
        $string = trim($string);
    }

    return $string;
}

/**
 * 使用JS方式页面跳转.
 *
 * @param string $url      跳转地址
 * @param string $langinfo 跳转时alert弹窗内容
 */
function okinfo($url, $langinfo = '')
{
    //用于十合一小程序判断
    if (isset($_POST['device_type']) && $_POST['device_type'] == 'miniprogram') {
        header('Content-Type:application/json; charset=utf-8');
        if ($url == '-1' || $url == 'javascript:history.back();') {
            $return['status'] = 0;
            $msg = '操作失败';
        } else {
            $return['status'] = 1;
            $msg = '操作成功';
        }
        $return['msg'] = $langinfo ? $langinfo : $msg;
        $return_data = json_encode($return);
        exit($return_data);
    }

    if ($langinfo) {
        $langstr = "alert('{$langinfo}');";
    }

    if ($url == '-1') {
        $js = 'window.history.back();';
    } else {
        $js = "location.href='{$url}';";
    }
    echo "<script type='text/javascript'>{$langstr} {$js} </script>";
    die();
}

/**
 * 产生随机字符串.
 *
 * @param string $length 字符串长度
 * @param int    $type   生成字符串类型,0(默认):26字母大小写+数字,1:数字，2:26字母小写，3:26字母大写，4:26字母大小写，5:字母小写+数字，6:字母大写+数字
 *
 * @return string 返回产生随机字符串
 */
function random($length = 1, $type = 0, $patten = '')
{
    if (!$patten) {
        switch ($type) {
            case 1:
                $patten = '0123456789';
                break;
            case 2:
                $patten = 'abcdefghigklmnopqrstuvwxyz';
                break;
            case 3:
                $patten = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 4:
                $patten = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghigklmnopqrstuvwxyz';
                break;
            case 5:
                $patten = 'abcdefghigklmnopqrstuvwxyz0123456789';
                break;
            case 6:
                $patten = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                break;
            default:
                $patten = 'ABCDEFGHIJKMNPQRSTUVWXYZabcdefghigkmnpqrstuvwxyz0123456789';
                break;
        }
    }

    $str = '';
    for ($i = 1; $i > 0; ++$i) {
        if (strlen($str) < $length) {
            $rand = rand(0, strlen($patten));
            $str .= substr($patten, $rand, 1);
        } else {
            break;
        }
    }

    return $str;
}

/**
 * cookie设置.
 *
 * @param string $var    规定 cookie 的名称
 * @param string $value  规定 cookie 的值
 * @param int    $expire 规定 cookie 的有效期
 * @param string $path   规定 cookie 的服务器路径
 * @param string $domain 规定 cookie 的域名
 */
function met_setcookie($var, $value = '', $expire = 0, $path = '/', $domain = '')
{
    $secure = $_SERVER['SERVER_PORT'] == 443 ? 1 : 0;
    setcookie($var, $value, $expire, $path, $domain, $secure, true);
}

/**
 * 获取服务器信息.
 *
 * @return array 返回服务器信息
 */
function server_info()
{
    $serverinfo = array();
    $serverinfo['system'] = php_uname('s'); //获取系统类型
    $serverinfo['sysos'] = $_SERVER['SERVER_SOFTWARE']; //获取php版本及运行环境
    $serverinfo['phpinfo'] = PHP_VERSION; //获取PHP信息
    $serverinfo['mysqlinfo'] = DB::version(); //获取数据库信息
    return $serverinfo;
}

/**
 * 获取ip.
 *
 * @return string 返回当前用户ip
 */
function get_userip()
{
    return $_SERVER['REMOTE_ADDR'];
}

/**
 * 获取浏览器版本.
 *
 * @return string 浏览器
 */
function getbrowser()
{
    $agent = $_SERVER['HTTP_USER_AGENT'];
    $browser = '';
    $browser_ver = '';
    if (preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $agent, $return)) {
        $browser = 'OmniWeb';
        $browser_ver = $return[2];
    }
    if (preg_match('/Netscape([\d]*)\/([^\s]+)/i', $agent, $return)) {
        $browser = 'Netscape';
        $browser_ver = $return[2];
    }
    if (preg_match('/safari\/([^\s]+)/i', $agent, $return)) {
        $browser = 'Safari';
        $browser_ver = $return[1];
    }
    if (preg_match('/Chrome\/([^\s]+)/i', $agent, $return)) {
        $browser = 'Chrome';
        $browser_ver = $return[1];
    }
    if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $return)) {
        $browser = 'Internet Explorer';
        $browser_ver = $return[1];
    }
    if (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $return)) {
        $browser = 'Opera';
        $browser_ver = $return[1];
    }
    if (preg_match('/NetCaptor\s([^\s|;]+)/i', $agent, $return)) {
        $browser = '(Internet Explorer '.$browser_ver.') NetCaptor';
        $browser_ver = $return[1];
    }
    if (preg_match('/Maxthon/i', $agent, $return)) {
        $browser = '(Internet Explorer '.$browser_ver.') Maxthon';
        $browser_ver = '';
    }
    if (preg_match('/360SE/i', $agent, $return)) {
        $browser = '(Internet Explorer '.$browser_ver.') 360SE';
        $browser_ver = '';
    }
    if (preg_match('/SE 2.x/i', $agent, $return)) {
        $browser = '(Internet Explorer '.$browser_ver.') sougou';
        $browser_ver = '';
    }
    if (preg_match('/FireFox\/([^\s]+)/i', $agent, $return)) {
        $browser = 'FireFox';
        $browser_ver = $return[1];
    }
    if (preg_match('/Lynx\/([^\s]+)/i', $agent, $return)) {
        $browser = 'Lynx';
        $browser_ver = $return[1];
    }
    if ($browser != '') {
        return $browser.' '.$browser_ver;
    } else {
        return false;
    }
}

/**
 * url标准化.
 *
 * @return string 返回标准化的url
 */
function url_standard($url)
{
    if (stripos($url, 'http://') === false && stripos($url, 'https://') === false) {
        $url = 'http://'.$url;
    } else {
        if (stripos($url, 'http://') != 0 && stripos($url, 'http://') != 0) {
            $url = str_replace('http://', '', $url);
            $url = 'http://'.$url;
        }
    }
    /*
    $start = strripos($url,'.');
    $start1 = strripos($url,'?');
    if($start !== false && $start1 !== false && $start > $start1){
    return $url;
    die();
    }
    if($start !== false){
    $end = stripos($url,'?');
    if($end !== false){
    $start = $start+1;
    $end = $end-$start;
    $suffix = substr($url, $start, $end);
    }else{
    $start = $start+1;
    $suffix = substr($url, $start);
    }
    $arr = array('php','html','htm');
    if(!in_array($suffix,$arr)){
    $url = substr($url, -1) == '/' ? $url : $url . '/';
    }
    }else{
    $url = substr($url, -1) == '/' ? $url : $url . '/';
    }
     */
    return $url;
}

/**
 * 获取http头信息.
 *
 * @return array 返回标准化的ip
 */
function httphead_info()
{
    $headinfo = array();
    $current = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; //当前页面地址
    $headinfo['current'] = $current;
    $headinfo['referer'] = $_SERVER['HTTP_REFERER']; //前一个页面地址
    $headinfo['domain'] = $_SERVER['SERVER_NAME']; //域名
    $script = !empty($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : (!empty($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : $_SERVER['REQUEST_URI']);
    $headinfo['script'] = $script; //脚本地址
    return $headinfo;
}

/**
 * 把$_M['word'][]字符串转为其所指示的语言变量的值
 *
 * @param string $str $_M['word'][]字符串
 *
 * @return array 返回此语言参数字符串的语言变量的值
 */
function get_word($str)
{
    global $_M;

    $str_old = $str;
    if (substr($str, 0, 5) == 'lang_') {
        $str = str_replace('lang_', '', $str);
    }
    if (substr($str, 0, 3) == '$_M') {
        $str = str_replace(array('$_M', '\'', '[word]', '[', ']'), '', $str);
    }
    if ($_M['word'][$str]) {
        return $_M['word'][$str];
    } else {
        return $str_old;
    }
}

/**
 * @param $image_path  图片地址
 * @param string $x          长
 * @param string $y          宽
 * @param int    $return     是否调用默认图片
 * @param int    $thumb_wate 缩略图水印
 *
 * @return mixed|string
 */
function thumb($image_path, $x = '', $y = '', $return = 0, $thumb_wate = 1)
{
    global $_M;
    $image = load::sys_class('image', 'new');

    return $image->met_thumb($image_path, $x, $y, $return, $thumb_wate);
}

function met_substr($string, $start = 0, $len = 20, $end = '')
{
    preg_match("/<m[\s_a-zA-Z=\d->]+<\/m>/", $string, $match);
    if ($match) {
        $m = $match[0];
    } else {
        $m = '';
    }

    $string = preg_replace("/<m[\s_a-zA-Z=\d->]+<\/m>/", '', $string);
    $con = mb_substr($string, $start, $len, 'utf-8');
    $con = $con.$m;
    if ($con != $string) {
        $con .= $end;
    }

    return $con;
}

//判断用户终端
/**
 * @return bool true:mobile  false:PC
 */
function is_mobile()
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $mobile_agents = array('240x320', 'acer', 'acoon', 'acs-', 'abacho', 'ahong', 'airness', 'alcatel', 'amoi', 'android', 'anywhereyougo.com', 'applewebkit/525', 'applewebkit/532', 'asus', 'audio', 'au-mic', 'avantogo', 'becker', 'benq', 'bilbo', 'bird', 'blackberry', 'blazer', 'bleu', 'cdm-', 'compal', 'coolpad', 'danger', 'dbtel', 'dopod', 'elaine', 'eric', 'etouch', 'fly ', 'fly_', 'fly-', 'go.web', 'goodaccess', 'gradiente', 'grundig', 'haier', 'hedy', 'hitachi', 'htc', 'huawei', 'hutchison', 'inno', /*"ipad",*/'ipaq', 'ipod', 'jbrowser', 'kddi', 'kgt', 'kwc', 'lenovo', 'lg ', 'lg2', 'lg3', 'lg4', 'lg5', 'lg7', 'lg8', 'lg9', 'lg-', 'lge-', 'lge9', 'longcos', 'maemo', 'mercator', 'meridian', 'micromax', 'midp', 'mini', 'mitsu', 'mmm', 'mmp', /*"mobi",*/'mot-', 'moto', 'nec-', 'netfront', 'newgen', 'nexian', 'nf-browser', 'nintendo', 'nitro', 'nokia', 'nook', 'novarra', 'obigo', 'palm', 'panasonic', 'pantech', 'philips', 'phone', 'pg-', 'playstation', 'pocket', 'pt-', 'qc-', 'qtek', 'rover', 'sagem', 'sama', 'samu', 'sanyo', 'samsung', 'sch-', 'scooter', 'sec-', 'sendo', 'sgh-', 'sharp', 'siemens', 'sie-', 'softbank', 'sony', 'spice', 'sprint', 'spv', 'symbian', 'tablet', 'talkabout', 'tcl-', 'teleca', 'telit', 'tianyu', 'tim-', 'toshiba', 'tsm', 'up.browser', 'utec', 'utstar', 'verykool', 'virgin', 'vk-', 'voda', 'voxtel', 'vx', 'wap', 'wellco', 'wig browser', 'wii', 'windows ce', 'wireless', 'xda', 'xde', 'zte');
    $is_mobile = false;
    foreach ($mobile_agents as $device) {
        if (stristr($user_agent, $device)) {
            $is_mobile = true;
            break;
        }
    }

    return $is_mobile;
}

/**
 * 获取模块编号
 * @param  int    $module 模块编号
 * @return string 返回记录后台导航栏目信息的数组
 */
function modname($module = '')
{
    global $_M;
    $metmodname = $module;
    switch ($module) {
        case 0:
            $metmodname = $_M['word']['modout'];
            break;
        case 1:
            $metmodname = $_M['word']['mod1'];
            break;
        case 2:
            $metmodname = $_M['word']['mod2'];
            break;
        case 3:
            $metmodname = $_M['word']['mod3'];
            break;
        case 4:
            $metmodname = $_M['word']['mod4'];
            break;
        case 5:
            $metmodname = $_M['word']['mod5'];
            break;
        case 6:
            $metmodname = $_M['word']['mod6'];
            break;
        case 7:
            $metmodname = $_M['word']['mod7'];
            break;
        case 8:
            $metmodname = $_M['word']['mod8'];
            break;
        case 9:
            $metmodname = $_M['word']['mod9'];
            break;
        case 10:
            $metmodname = $_M['word']['mod10'];
            break;
        case 11:
            $metmodname = $_M['word']['mod11'];
            break;
        case 12:
            $metmodname = $_M['word']['mod12'];
            break;
        case 999:
            $metmodname = $_M['word']['modout'];
            break;
        case 100:
            $metmodname = $_M['word']['mod100'];
            break;
        case 101:
            $metmodname = $_M['word']['mod101'];
            break;
        default:
            $query = "SELECT * FROM {$_M['table']['applist']} WHERE no = '{$module}'";
            $app = DB::get_one($query);
            if ($app) {
                $metmodname = get_word($app['appname']) ?: $app['appname'];
            }
            break;
    }
    return $metmodname;
}

/**
 * useragent 客户端类型判断、客户端验证
 *
 * @param string $isClient 需要验证的客户端类型
 *
 * @return String/Boolean $client 为空时返回当前客户端类型，输入tablet、mobile、desktop则返回当前客户端是否为该类型的判断值
 */
function met_useragent($isClient)
{
    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $iphone = strpos($agent, 'mobile');
    $android = strpos($agent, 'android');
    $windowsPhone = strpos($agent, 'phone');
    $androidTablet = $android && !$iphone ? true : false;
    $ipad = strpos($agent, 'ipad');
    //客户端类型判断
    if ($androidTablet !== false || $ipad !== false) {
        $client = 'tablet';
    } elseif (($iphone !== false && $ipad === false) || ($android !== false && $androidTablet === false) || $windowsPhone !== false) {
        $client = 'mobile';
    } else {
        $client = 'desktop';
    }
    if ($isClient) {
        return $client == $isClient ? true : false; // 客户端验证
    } else {
        return $client;
    }
}

// 内容中图片路径lazyload预处理
function srcToLazyload($str)
{
    $str = preg_replace_callback('/(<img[^>]*)src(=[^>]*>)/', function ($match) {
        return $match['1'].'data-original'.$match['2'];
    }, $str);

    return $str;
}

/**
 * getRelativePath 计算path2 相对于 $path1 的路径,即在path1引用paht2的相对路径.
 *
 * @param string $path1
 * @param string $path2
 *
 * @return string $relapath 相对路径
 */
function getRelativePath($path1, $path2)
{
    global $_M;
    if (defined('PATH_WEB')) {
        $path1 = str_replace(PATH_WEB, '', $path1);
        $path2 = str_replace(PATH_WEB, '', $path2);
    }
    if ($_M['url']['site']) {
        $path1 = str_replace($_M['url']['site'], '', $path1);
        $path2 = str_replace($_M['url']['site'], '', $path2);
    }
    $arr1 = explode('/', $path1);
    $arr2 = explode('/', $path2);
    if (end($arr1) != '' && !strpos(end($arr1), '.')) {
        $arr1[] = '';
    }

    if (end($arr2) != '' && !strpos(end($arr2), '.')) {
        $arr2[] = '';
    }

    $c = array_values(array_diff_assoc($arr1, $arr2));
    $d = array_values(array_diff_assoc($arr2, $arr1));
    array_pop($c);
    foreach ($c as &$v) {
        $v = '..';
    }
    $arr = array_merge($c, $d);
    $relativePath = implode('/', $arr);

    return $relativePath;
}

/**
 * strReplace 多维数组或字符串值字符替换.
 *
 * @param string $find    查找的字符
 * @param string $replace 替换的字符
 * @param string $array   数组或者字符串
 *
 * @return array/String $array 数组或者字符串
 */
function strReplace($find, $replace, $array)
{
    if (is_array($array)) {
        $array = str_replace($find, $replace, $array);
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                $array[$key] = $this->strReplace($find, $replace, $array[$key]);
            }
        }
    } else {
        $array = str_replace($find, $replace, $array);
    }

    return $array;
}

function get_sql($data)
{
    $sql = '';
    foreach ($data as $key => $value) {
        if (strstr($value, "'")) {
            $value = str_replace("'", "\'", $value);
        }
        $sql .= " {$key} = '{$value}',";
    }

    return trim($sql, ',');
}

function getAdminDir()
{
    $web_path = PATH_WEB;
    $res = scandir($web_path);
    foreach ($res as $dir) {
        $admin_lock = $web_path.$dir.'/admin.lock';
        if (file_exists($admin_lock)) {
            $admin_dir = $dir;

            return $admin_dir;
        }
    }
}

/**
 * @param string $url
 * @param string $data
 * @param string $method
 * @param int    $out_time
 * @param int    $showpage
 *
 * @return int|mixed
 */
function curl($url = '', $data = array(), $out_time = 10, $show = 0)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, $out_time);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        curl_close($ch);

        return curl_errno($ch);
    }

    return $result;
}

function api_curl($url, $data = array(), $timeout = 60)
{
    global $_M;
    $ch = curl_init();
    $data['user_key'] = $_M['config']['met_secret_key'];
    $data['domain'] = $_M['url']['web_site'];
    $data['cms_version'] = $_M['config']['metcms_v'];
    
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $result = curl_exec($ch);
    if (!$result) {
        file_put_contents(PATH_WEB.'curl_error.txt', "url:{$url}\nerror:".curl_error($ch)."\n", FILE_APPEND);
    }
    curl_close($ch);

    return $result;
}

function down_curl($url, $data = array(), $path, $timeout = 20)
{
    global $_M;
    $ch = curl_init();
    $data['user_key'] = $_M['config']['met_secret_key'];
    $data['domain'] = $_M['url']['web_site'];
    $data['cms_version'] = $_M['config']['metcms_v'];
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $result = curl_exec($ch);

    if ($result) {
        $res = json_decode($result, true);
        if ($res['status'] != 200 && $res) {
            return $res['msg'];
        } else {
            $fp = fopen($path, 'w+');
            fwrite($fp, $result);
            fclose($fp);
        }
    }
    curl_close($ch);

    return true;
}

function error($msg = '', $status = 0, $data = '', $json_option = 0)
{
    header('Content-Type:application/json; charset=utf-8');
    $error['msg'] = $msg;
    $error['status'] = $status;
    if ($data) {
        $error['data'] = $data;
    }
    $return_data = json_encode($error, $json_option);
    exit($return_data);
}

/** 成功返回
 * @param string $msg         提示信息
 * @param int    $status      状态码
 * @param string $data        返回数据
 * @param int    $json_option json附加
 */
function success($data = '', $msg = '', $status = 1, $json_option = 0)
{
    header('Content-Type:application/json; charset=utf-8');
    $success['msg'] = $msg;
    $success['status'] = $status;
    $success['data'] = $data;

    $return_data = json_encode($success, $json_option);
    exit($return_data);
}

function halt($msg = '')
{
    header('HTTP/1.1 500 Internal Server Error');
    echo "<html><head><title>MetInfo</title><style type='text/css'>P,BODY{FONT-FAMILY:tahoma,arial,sans-serif;FONT-SIZE:10px;}A { TEXT-DECORATION: none;}a:hover{ text-decoration: underline;}TD { BORDER-RIGHT: 1px; BORDER-TOP: 0px; FONT-SIZE: 16pt; COLOR: #000000;}</style><body>\n\n";
    echo "<table style='TABLE-LAYOUT:fixed;WORD-WRAP: break-word'><tr><td>";
    echo "<b>{$msg}<br><br>";
    echo "<b>You Can Get Help In</b>:<br><a href='https://www.metinfo.cn'>https://www.metinfo.cn</a>";
    echo '</td></tr></table>';
    die();
}

function abort()
{
    header('HTTP/1.1 404 Not Found');
    header('Status: 404 Not Found');
    header('location:/404.html');
    die;
}

/**
 * 字段权限控制代码加密后（加密后可用URL传递）.
 *
 * @param string $string    需要加密或解密的字符串
 * @param string $operation ENCODE:加密，DECODE:解密
 * @param string $key       密钥
 * @param int    $expiry    加密有效时间
 *
 * @return string 加密或解密后的字符串
 */
function authcode($string = '', $operation = 'DECODE', $key = '', $expiry = 0)
{
    $result = load::sys_class('auth', 'new')->authcode($string, $operation, $key, $expiry);
    return $result;
}

load::sys_func('compatible');
load::sys_func('power');

// This program is an open source system, commercial use, please consciously to purchase commercial license.
// Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
