<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * 解析tag标签模板
 * Class tag_compile
 */
class compile
{
    /**
     * 当前模板根目录
     */
    public $tem_path;

    /**
     * UI管理工具的ui文件夹目录
     */
    public $cache_path;

    /**
     * ui路径
     * @var string
     */
    public $ui_path;

    /**
     * 集成UI目录
     * @var
     */
    public $met_ui_dir;

    /**
     * 需要可视化的字段
     */
    public $fields = array('name', 'value', 'title', 'keywords', 'description', 'content', 'valueinfo', 'defaultvalue', 'imgurl', 'uip_default', 'uip_value', 'img_path', 'columnimg', 'icon', 'imgurls', 'info', 'content1', 'content2', 'content3', 'content4', 'position', 'img_title', 'img_des', 'namemark', 'weblogo', 'ctitle', 'other_info', 'custom_info', 'webname');
    /**
     * 需要可视化的表
     */
    public $tables = array('news', 'column', 'product', 'img', 'job', 'templates', 'ui_config', 'config', 'flash', 'column', 'language', 'download', 'parameter', 'plist', 'link');

    // 返回信息
    public $response = array('status' => 0);

    //模板类型
    public $template_type;

    //集成UI CSS JS 数据
    public $met_ui_data;

    /**
     * sys_compile constructor.
     */
    public function __construct()
    {
        global $_M;
        $this->tem_path = PATH_WEB . 'templates/' . $_M['config']['met_skin_user'] . '/';
        $this->ui_path = PATH_ALL_APP . "met_ui/admin/ui/";
        $this->skin_name = $_M['config']['met_skin_user'];
        $this->cache_path = PATH_WEB . 'cache/templates';
        $this->met_ui_dir = PATH_ALL_APP . "met_template/style/";

        //模板缓存文件目录
        if (!is_dir($this->cache_path)) {
            mkdir($this->cache_path, 0777, true);
        }

        //模板注册文件
        $inc = $this->tem_path . 'metinfo.inc.php';
        if (is_file($inc)) {
            require $inc;
            $this->template_type = isset($template_type) ? $template_type : '';
        } else {
            $this->template_type = 'tag';
        }
    }

    // css压缩
    public function css_compress($str = '')
    {
        $str = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $str);
        $str = str_replace(array("
", "\r\n", "\r", "\n", "\t", '@charset "utf-8";', "@charset 'utf-8';", '@charset "UTF-8";', "@charset 'UTF-8';"), '', $str);
        $str = str_replace(array('  ', '    ', '    '), ' ', $str);
        $str = str_replace(array(': ', ' :'), ':', $str);
        $str = str_replace(array(', ', ' ,'), ',', $str);
        $str = str_replace(array('; ', ' ;'), ';', $str);
        $str = str_replace(array(' }', '} ', ';}'), '}', $str);
        $str = str_replace(array(' {', '{ '), '{', $str);
        $str = '@charset "utf-8";' . $str;// CSS声明

        return $str;
    }

    // js压缩
    // 去除空行、多行注释、单行注释
    public function js_compress($str = '')
    {
        $str = preg_replace(array('!/\*[^*]*\*+([^/][^*]*\*+)*/!'), '', $str);
        $str = str_replace("\r", "\n", $str);
        // $str = str_replace("\t", "", $str);
        $str = explode("\n", $str);
        $str = array_filter($str, function ($var) {
            if (!ctype_space($var)) return $var;
        });
        foreach ($str as $key => $value) {
            $value = trim($value);
            if (substr($value, 0, 2) == '//') {
                unset($str[$key]);
            } else {
                if (strpos($value, '// ') != false) {
                    $value = substr($value, 0, strpos($value, '// '));
                }
                $str[$key] = $value;
            }
        }
        $str = implode("\n", $str);
        return $str;
    }

    /**
     * UI中config.json文件的变量替换
     * @DateTime 2017-12-15
     * @param    string 带变量的路径
     * @return   string 替换后的路径
     */
    public function replace_public($path)
    {

        global $_M;
        if(strstr($path, 'web-icons')
            ||strstr($path, 'font-awesome')
            ||strstr($path, 'filament-tablesaw')
            ||strstr($path, 'formvalidation/language/zh_CN.js')
            ||strstr($path, 'formvalidation/framework/bootstrap4.min.js')
            ||strstr($path, 'jquery-enplaceholder')
        ){
            $path='';
        }else{
            $replace = array(
                '{$metui_url1}vendor/' => PATH_PUBLIC.'plugins/',
                '{$metui_url1}/vendor/' => PATH_PUBLIC.'plugins/',
                '{$metui_url1}' => PATH_PUBLIC,
                '{$metui_url2}vendor/' => PATH_PUBLIC.'plugins/',
                '{$metui_url2}/vendor/' => PATH_PUBLIC.'plugins/',
                '{$metui_url2}js/Plugin/' => PATH_PUBLIC_WEB.'plugins/register/',
                '{$metui_url2}/js/Plugin/' => PATH_PUBLIC_WEB.'plugins/register/',
                '{$metui_url2}' => PATH_PUBLIC,
                '{$metui_url3}plugin/' => PATH_PUBLIC_WEB.'plugins/',
                '{$metui_url3}/plugin/' => PATH_PUBLIC_WEB.'plugins/',
                '{$metui_url3}fonts/' => PATH_PUBLIC.'fonts/',
                '{$metui_url3}/fonts/' => PATH_PUBLIC.'fonts/',
                '{$metui_url3}' => PATH_PUBLIC_WEB,
                '{$metui_url4}' => PATH_WEB . 'app/app/shop/web/templates/met/',
                '{$metui_temp}' => PATH_WEB . "templates/{$_M['config']['met_skin_user']}/"
            );
            if(strstr($path,'$metui_url2') && (strstr($path,'alertify')||strstr($path, 'formvalidation'))){
                $path=str_replace(array('{$metui_url2}/vendor/','{$metui_url2}vendor/'),'{$metui_url3}plugin/',$path);
            }
            if(strstr($path, 'alertify-js')){
                $path=str_replace('alertify-js', 'alertify', $path);
            }
            $init_path=$path;
            $path = str_replace(array_keys($replace), array_values($replace), $path);
            if(!is_file($path) && (strstr($init_path,'{$metui_url3}/plugin/')||strstr($init_path, '{$metui_url3}plugin/'))){
                $path=str_replace(array('{$metui_url3}/plugin/','{$metui_url3}plugin/'),'{$metui_url2}vendor/',$init_path);
                $path=str_replace(array_keys($replace), array_values($replace), $path);
            }
        }
        return $path;
    }

    /**
     * 替换css js路径替换为url
     */
    public function replace_url($path)
    {
        global $_M;
        $http_path = str_replace(PATH_WEB, '', $path);
        $info = pathinfo($http_path);
        $http_dir = $info['dirname'];
        if (!$path) {
            return '';
        }
        $content = file_get_contents($path);
        $content = preg_replace_callback('/url\(["\']*([\.\/]*)([^:]*?)["\']*\)/', function ($match) use ($http_dir) {
            return "url('../../../" . $http_dir . '/' . $match[1] . $match[2] . "')";
        }, $content);
        return $content;
    }

    /**
     * 替换系统url
     * @return array
     */
    public function replace_sys_url()
    {
        global $_M;
        $url = array();
        $web_site = $_M['url']['web_site'];
        foreach ($_M['url'] as $key => $val) {
            if (in_array($key, array('web_site', 'admin_site'))) {
                $url[$key] = $val;
            }else{
                $val = str_replace($web_site, '../', $val);
                $url[$key] = $val;
            }
        }
        return $url;
    }

    /**
     * 替换系统变量
     * @return mixed
     */
    public function replace_sys_config()
    {
        global $_M;
        $config = $_M['config'];

        $config['met_footother'] = str_replace(array('../'), $_M['url']['site'], $config['met_footother']);
        if ($config['met_icp_info']) {
            $config['met_footother'] .= "<p><a href=\"https://beian.miit.gov.cn\" target=\"_blank\" title=\"工信部\" textvalue=\"{$config['met_icp_info']}\">{$config['met_icp_info']}</a></p>";
        }

        $config['met_logo'] = str_replace(array('../', './'), '', $config['met_logo']);
        if (!strstr($config['met_logo'], 'http')) {
            $config['met_logo'] = $_M['url']['site'] . $config['met_logo'];
        }

        $config['met_mobile_logo'] = str_replace(array('../', './'), '', $config['met_mobile_logo']);
        if (!strstr($config['met_mobile_logo'], 'http')) {
            $config['met_mobile_logo'] = $_M['url']['site'] . $config['met_mobile_logo'];
        }

        $config['met_weburl'] = $_M['url']['site'];
        $query = "SELECT id FROM {$_M['table']['config']} WHERE name = 'met_logo' AND lang = '{$_M['lang']}'";
        $logo = DB::get_one($query);

        if ($_M['form']['pageset']) {
            $config['met_logo'] = $config['met_logo'] . "?met-id={$logo['id']}&met-table=config&met-field=value";
        }

        if (!$_M['config']['met_agents_type']) {
            $config['met_agents_copyright_foot'] = '';
        }else{
            switch ($_M['config']['met_copyright_type']) {
                case 0:
                    $config['met_agents_copyright_foot'] = $_M['config']['met_agents_copyright_foot'];
                    break;
                case 1:
                    $config['met_agents_copyright_foot'] = $_M['config']['met_agents_copyright_foot1'];
                    break;
                case 2:
                    $config['met_agents_copyright_foot'] = $_M['config']['met_agents_copyright_foot2'];
                    break;
                default:
                    $config['met_agents_copyright_foot'] = $_M['config']['met_agents_copyright_foot'];
                    break;
            }
        }

        $config['met_agents_copyright_foot'] = str_replace(array('$metcms_v', '$m_now_year'), array($config['metcms_v'], date('Y', time())), $config['met_agents_copyright_foot']);

        if ($config['met_copyright_nofollow']) {
            $config['met_agents_copyright_foot'] = str_replace("<a ", "<a rel=nofollow ", $config['met_agents_copyright_foot']);
        }

        if ($_M['config']['met_pseudo']) {//开启伪静态
            if ($_M['form']['pageset']) {//可视化试
                $config['index_url'] = $config['met_weburl'] . 'index.php?lang=' . $_M['lang'];
            }else{//开启伪静态前提访问
                if ($_M['config']['met_defult_lang']) {//伪静态开启语言标识
                    $config['index_url'] = $config['met_weburl'] . 'index-' . $_M['lang'] . '.html';
                }else{//伪静态未开启语言标识
                    if ($_M['config']['met_index_type'] == $_M['lang']) {
                        $config['index_url'] = $config['met_weburl']; //伪静态默认语言
                    }else{
                        $config['index_url'] = $config['met_weburl'] . 'index-' . $_M['lang'] . '.html';//伪静态非默认语言
                    }
                }
            }
        }else{//动态url
            if ($_M['config']['met_index_type'] == $_M['lang']) {
                $config['index_url'] = $config['met_weburl'];
            }else{
                $config['index_url'] = $config['met_weburl'] . 'index.php?lang=' . $_M['lang'];
            }
        }

//        if ($_M['config']['met_index_type'] == $_M['lang'] && !$_M['config']['met_pseudo']) {
//            $config['index_url'] = $config['met_weburl'];
//        } else {
//            if ($_M['config']['met_pseudo'] && !$_M['form']['pageset']) {
//                if ($_M['config']['met_defult_lang']) {
//                    $config['index_url'] = $config['met_weburl'] . 'index-' . $_M['lang'] . '.html';//伪静态开启语言表示
//                }else{
//                    if ($_M['config']['met_index_type'] == $_M['lang']) {
//                        $config['index_url'] = $config['met_weburl']; //伪静态默认语言
//                    }else{
//                        $config['index_url'] = $config['met_weburl'] . 'index-' . $_M['lang'] . '.html';//伪静态非默认语言
//
//                    }
//                }
//            } else {
//                $config['index_url'] = $config['met_weburl'] . 'index.php?lang=' . $_M['lang'];
//            }
//        }

        if (($_M['form']['pageset'] && !strstr($config['index_url'], '?'))) {
            $config['index_url'] .= 'index.php?lang=' . $_M['lang'];
        }

        //用户头像地址
        if ($_M['user']) {
            $_M['user']['head'] = str_replace(array('../', './'), '', $_M['user']['head']);
            if (!strstr($_M['user']['head'], 'http')) {
                $_M['user']['head'] = $_M['url']['site'] . $_M['user']['head'];
            }
        }

        return $config;
    }

    //剔除数据标签信息
    public function replace_tag($value = '', $default = '', $type = '', $id = 0, $is_css = '')
    {
        global $_M;

        $defaultvalue = $this->replace_m($default);

        $realvalue = $this->replace_m($value);

        if (trim($realvalue) == '') {
            if (is_numeric($defaultvalue) || trim($defaultvalue) == '' || in_array($type, array(4, 6, 9))) {
                $val = $defaultvalue;
            } else {
                $val = $default;
            }
        } else {
            if (in_array($type, array(4, 6, 9)) || is_numeric($realvalue)) {
                $val = $realvalue;
            } else {
                #$val = $value;
                $val = str_replace('../', $_M['url']['site'], $value);
            }
        }

        //上传组件
        if ($type == 7) {
            if ($_M['form']['pageset']) {
                if ($this->template_type == 'ui') {
                    $para = "?met-id={$id}&met-table=ui_config&met-field=uip_value";
                } else {
                    $para = "?met-id={$id}&met-table=templates&met-field=value";
                }
            } else {
                $para = '';
            }
            $realval = $this->replace_m($val);
            if (!$realval) {
                $val = $para;
            } else {
                // 如果是外部图片，不增加网站url
                $val = str_replace('../', '', $realval) . $para;
                if (!strstr($val, 'http')) {
                    if ($is_css) {
                        $val = "../../../" . $val;
                    } else {
                        $val = $_M['url']['site'] . $val;
                    }
                }
            }
        }

        //富文本
        if ($type == 8) {
            $val = str_replace('../', $_M['url']['site'], $value);
            $val = contnets_replace($val);
        }

        return $val;
    }

    /**********可视化数据标签****************/
    //去掉数据中的m标签
    public function replace_m($value)
    {
        global $_M;
        return preg_replace_callback("/<m[\s_a-zA-Z=\d\->]+<\/m>/", function ($match) {
            return ;
        }, $value);
    }

    // 标签里的属性不添加m标签
    public function replace_attr($output)
    {
        global $_M;
        $that = $this;

        $new_output = preg_replace_callback("/(src|alt|value|title|placeholder|poster|data\-name|data\-title|data\-fv\-message|data\-sub\-html)=['\"]?([^\s\>]+)?(<m[\s_a-zA-Z=\d>\-]+<\/m>)['\"]?/isu", function ($match) use ($that) {
            return $that->replace_m(trim($match[0]));
        }, $output);
        if ($new_output) {
            return $new_output;
        } else {
            return $output;
        }
    }

    /*----------------- 前台可视化操作---------------------*/
    public function get_field_text($table = '', $field = '', $id = '')
    {
        global $_M;

        $query = "SELECT * FROM {$_M['table'][$table]} WHERE id = '{$id}'";
        $res = DB::get_one($query);
        if (!$res) {
            return false;
        }
        $this->response['status'] = 1;
        $this->response['text'] = $res[$field];
        if ($table == 'templates') {
            $this->response['type'] = $res['type'];
        }

        return $this->response;
    }

    public function set_field_text($table = '', $field = '', $id = '', $text = '')
    {
        global $_M;

        if ($field == 'defaultvalue') {
            $field = 'value';
        }

        if ($field == 'uip_default') {
            $field = 'uip_value';
        }
        $query = "UPDATE {$_M['table'][$table]} SET $field = '{$text}' WHERE id = '{$id}'";
        $row = DB::query($query);
        if (!$row) {
            $this->response['msg'] = $_M['word']['templateseditfalse'];
            return $this->response;
        }
        $this->response['status'] = 1;
        $this->response['msg'] = $_M['word']['jsok'];
        return $this->response;
    }

    public function save_img_field($table = '', $field = '', $id = '', $path = '')
    {
        global $_M;
        $query = "UPDATE {$_M['table'][$table]} SET {$field} = '{$path}' WHERE id = '{$id}' AND lang = '{$_M['lang']}'";
        return DB::query($query);
    }

    /**************模板緩存操作**************/
    public function set_cache($file, $data)
    {
        global $_M;
        if ($_M['form']['pageset']) {
            if (is_file($file)) {
                @unlink($file);
            }
            return;
        }
        $string = "<?php defined('IN_MET') or exit('No permission'); ?>";
        $string .= json_encode($data);
        $str = file_put_contents($file, $string);
        if (!$str) {
            die($this->cache_path . $_M['word']['templatefilewritno']);
        }
    }

    public function get_cache($file)
    {
        global $_M;
        $string = file_get_contents($file);
        $string = str_replace("<?php defined('IN_MET') or exit('No permission'); ?>", '', $string);
        return json_decode($string, true);
    }

    /******************/
    /**
     * 匹配CSS变量
     * @param $content
     * @return mixed
     */
    public function pregUiVal($content)
    {
        global $_M;
        preg_match_all('/\$(\w+)\$/', $content, $match);
        return $match;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.