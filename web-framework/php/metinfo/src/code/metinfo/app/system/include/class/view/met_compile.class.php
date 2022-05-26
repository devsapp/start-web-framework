<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('view/compile');

/**
 * 集成UI解析
 * Class met_compile
 */
class met_compile extends compile
{
    //启用模板路径
    public $tem_path;

    //系统ui目录
    public $met_ui_dir;

    //集成UI CSS JS数据
    public $met_ui_data;

    //缓存目录
    public $cache_path;

    /**
     * constructor.
     */
    public function __construct()
    {
        global $_M;
        parent::__construct();
        $this->met_ui_dir = PATH_WEB . 'app/style/';
        $this->tem_path = PATH_WEB . 'templates/' . $_M['config']['met_skin_user'] . '/';
    }

    /**
     * 解析页面
     * @DateTime 2017-12-20
     * @param    string $page 当前页面
     * @return   null
     */
    public function parse_met_ui($temp_type = 'tag', $temp_global_data = array())
    {
        global $_M;
        //处理标签模板全局变量
        if ($temp_type == 'tag') {
            $temp_global_data['firstcolor'] = $temp_global_data['first_color'];
            $temp_global_data['secondcolor'] = '';
            $temp_global_data['thirdcolor'] = '';
        }

        $query = "SELECT * FROM {$_M['table']['style_list']} WHERE effect = 1 ORDER BY ui_order";
        $style_list = DB::get_all($query);

        foreach ($style_list as $key => $ui) {
            $temp_page = $this->met_ui_dir . $ui['block_name'] . '/' . $ui['pid'] . '/index.php';

            if (!is_file($temp_page)) {
                continue;
                #return false;
            }

            $tem_ui_path = $this->met_ui_dir . $ui['block_name'] . '/' . $ui['pid'];
            $config_path = $tem_ui_path . '/config.json';

            if (is_file($config_path)) {
                $config = json_decode(file_get_contents($config_path), true);
                if (!$config) {
                    echo "{$config_path}'配置文件有问题'<br>";
                }

                foreach ($config['css'] as $k => $val) {

                    if (strpos($val, 'ui/css') !== false) {
                        $ui_info[$key]['css'][] = $tem_ui_path . '/' . str_replace('ui/css/', '', $val);
                        $ui_info[$key]['block_name'] = $ui['block_name'];
                        $ui_info[$key]['pid'] = $ui['pid'];
                    } else {
                        if ($temp_type == 'tag') {
                            $css[] = $val;
                        } else {
                            $css[] = $this->replace_public($val);
                        }
                    }
                }

                foreach ($config['js'] as $k => $val) {

                    if (strpos($val, 'ui/js') !== false) {

                        $ui_info[$key]['js'][] = $tem_ui_path . '/' . str_replace('ui/js/', '', $val);
                        $ui_info[$key]['block_name'] = $ui['block_name'];
                        $ui_info[$key]['pid'] = $ui['pid'];
                    } else {
                        if ($temp_type == 'tag') {
                            $js[] = $val;
                        } else {
                            $js[] = $this->replace_public($val);
                        }

                    }
                }
            }
        }

        $unique_css = array_unique($css);
        $unique_js = array_unique($js);


        $js_content = "";
        $css_content = "";

        /*foreach ($unique_css as $key => $c) {
            if(strpos($c, '/fonts/web-icons/web-icons.min.css')===false && strpos($c, '/fonts/font-awesome/font-awesome.min.css')===false){
                $css_content .= $this->replace_url($c);
            }

        }*/

        /* foreach ($unique_js as $key => $c) {
             $js_content.= "\n".file_get_contents($c);
         }*/

        foreach ($ui_info as $k => $v) {
            $_css = $this->replace_css($v, $temp_global_data);
            $css_content .= $_css;

            $_js = $this->replace_js($v, $temp_global_data);
            $js_content .= $_js;
        }

        $redata = array();
        $redata['css'] = $unique_css;
        $redata['js'] = $unique_js;
        $redata['js_content'] = $js_content;
        $redata['css_content'] = $css_content;

        $this->met_ui_data = $redata;
        return $redata;
    }

    /**
     * 替换UI带的css中的Url
     */
    public function replace_css($data = array(), $global_data = array())
    {
        global $_M;

        $css_content = "";
        foreach ($data['css'] as $c) {

            // 替换配置
            $css = file_get_contents($c);

            // 模板公共色调参数
            foreach ($global_data as $name => $value) {
                // 替换公共参数
                $css = str_replace("\${$name}\$", $value, $css);
            }

            $this->list_block_config($data['block_name'], $data['pid']);

            $css = str_replace('$met_uicss', '.' . $data['block_name'] . '_' . $data['pid'], $css);
            $img_url = 'style/' . $data['block_name'] . '/' . $data['pid'] . '/img';

            if (is_dir(PATH_WEB . $img_url)) {
                $img_url = $_M['url']['site'] . $img_url;
            }/*else{
                $img_url = $_M['url']['app'].'met_ui/admin/ui/'.$data['parent_name'].'/'.$data['ui_name'].'/img';
            }*/
            $css = str_replace('$ui_url', $img_url, $css);
            preg_match_all('/\$(\w+)\$/', $css, $match);
            $variable = array_unique($match[1]);
            foreach ($variable as $v) {
                $config = $this->get_config_by_pid($data['pid'], $v);
                $css = str_replace("\${$v}\$", $config, $css);
            }

            $css_content .= "\n" . $css;
        }

        return $css_content . "\n";
    }

    /**
     * UI带的js中的变量替换
     */
    public function replace_js($data = array(), $global_data = array())
    {
        global $_M;

        #$global = $this->list_global_config($this->skin_name);
        $js_content = "";
        foreach ($data['js'] as $j) {
            $js = file_get_contents($j);
            $js = str_replace('$met_uicss', $data['block_name'] . '_' . $data['pid'], $js);
            $js_content .= "\n" . $js;
        }

        return $js_content . "\n";
    }

    /**
     * 获取区块置参数
     * @param string $block_name
     * @param string $pid
     * @return array|mixed
     */
    public function list_block_config($block_name = '', $pid = '')
    {
        global $_M;

        if (!$block_name || !$pid) {
            return;
        }

        $cache = $this->cache_path . '/' . "{$block_name}_{$pid}_{$_M['lang']}.php";

        if (is_file($cache) && !$_M['form']['pageset']) {
            return self::get_cache($cache);
        }
        $query = "SELECT * FROM {$_M['table']['style_config']} WHERE pid = '{$pid}' AND block_name = '{$block_name}' AND lang = '{$_M['lang']}'";
        $config = DB::get_all($query);

        $met_ui = array();
        $met_ui['mid'] = $pid;
        $met_ui['mname'] = $block_name;
        foreach ($config as $key => $value) {
            $val = $this->replace_tag($value['uip_value'], $value['uip_default'], $value['uip_type'], $value['id']);
            $met_ui[$value['uip_name']] = $val;
        }

        self::set_cache($cache, $met_ui);

        return $met_ui;
    }

    /**
     * @param string $pid
     * @param string $uip_name
     * @return int|string
     */
    public function get_config_by_pid($pid = '', $uip_name = '')
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['style_config']} WHERE pid = '{$pid}' AND uip_name = '{$uip_name}' AND lang = '{$_M['lang']}'";

        $config = DB::get_one($query);

        $value = $this->replace_tag($config['uip_value'], $config['uip_default'], $config['uip_type']);
        return $value;
    }

    public function get_config_by_name($block_name = '', $pid = '', $uip_name = '')
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['style_config']} WHERE block_name = '{$block_name}' AND pid = '{$pid}' AND uip_name = '{$uip_name}' AND uip_name = '{$uip_name}' AND lang = '{$_M['lang']}'";
        $config = DB::get_one($query);
        return $this->replace_tag($config['uip_value'], $config['uip_default'], $config['uip_type']);
    }

    //获取区块启用UI信息
    public function get_effect_ui($block_name = '')
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['style_list']} WHERE block_name = '{$block_name}' AND effect = 1 AND lang = '{$_M['lang']}'";
        $ui = DB::get_one($query);
        if (!$ui) {
            $query = "SELECT * FROM {$_M['table']['style_list']} WHERE block_name = '{$block_name}' AND lang = '{$_M['lang']}' AND pid = 1 ";
            $ui = DB::get_one($query);
        }
        return $ui;
    }


    /******************************/
    /**
     * 模板并列栏目配置
     * @param $page
     * @return array
     */
    public function list_page_config($page)
    {
        global $_M;
        $config = json_decode(file_get_contents($this->tem_path . 'ui.json'), true);
        $data = array();
        foreach ($config['page'][$page] as $key => $val) {
            $ui_config = $this->list_local_config($val['installid']);
            $data[$val['parent_name']] = $ui_config['ui_show'];
        }
        return $data;
    }

    /**
     * 获取指定模板UI配置信息
     * @param string $pid
     * @param string $skin_name
     * @return bool
     */
    public function list_local_config($pid = '', $skin_name = '')
    {
        global $_M;
        if ($skin_name == '') {
            $skin_name = $this->skin_name;
        }

        $ui = buffer::getUiConfig("config/{$skin_name}_ui_{$pid}_{$_M['lang']}");
        if (!$ui) {
            $query = "SELECT * FROM {$_M['table']['ui_config']} WHERE pid = '{$pid}' AND skin_name = '{$skin_name}' AND lang = '{$_M['lang']}'";
            $config = DB::get_all($query);

            $ui['mid'] = $pid;
            foreach ($config as $key => $value) {
                $val = $this->replace_tag($value['uip_value'], $value['uip_default'], $value['uip_type'], $value['id']);
                $ui[$value['uip_name']] = $val;
            }
            buffer::setUiConfig("config/{$skin_name}_ui_{$pid}_{$_M['lang']}", $ui);
        }
        return $ui;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.