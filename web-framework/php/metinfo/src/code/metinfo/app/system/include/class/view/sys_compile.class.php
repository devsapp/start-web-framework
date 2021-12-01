<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * 解析tag标签模板
 * Class tag_compile
 */
load::sys_class('view/compile');
class sys_compile extends compile
{

    /**
     * sys_compile constructor.
     */
    public function __construct()
    {
        global $_M;
        parent::__construct();
        /*
        $this->template_type    = 'tag';
        $this->tem_path         = PATH_WEB.'templates/'.$_M['config']['met_skin_user'].'/';
        $this->ui_path          = PATH_ALL_APP."met_ui/admin/ui/";
        $this->skin_name        = $_M['config']['met_skin_user'];
        $this->cache_path       = PATH_WEB.'cache/templates';

        //模板缓存文件目录
        if(!is_dir($this->cache_path)){
            mkdir($this->cache_path,0777,true);
        }

        //模板注册文件
        $inc = $this->tem_path.'metinfo.inc.php';
        if(is_file($inc)){
            require $inc;
            $this->template_type = $template_type;
            // 标签模式解析css
            if ($this->template_type == 'tag') {
                $this->parse_tag_static('css');
                $this->parse_tag_static('js');
            }
        }*/

        $this->parse_tag_static('css');
        $this->parse_tag_static('js');
    }

    /**
     * 解析页面
     * @DateTime 2017-12-20
     * @param    string $page 当前页面
     * @return   null
     */
    public function parse_page($page = '')
    {
        global $_M;
        if ($page == '') {
            return false;
        }

        if (!$_M['form']['pageset'] && is_file($this->tem_path . 'cache/' . $page . '.css')) {
            return false;
        }
        $temp_page = $this->tem_path . $page . '.php';
        $ignore = array('404', 'metinfo.inc');

        if (in_array($page, $ignore)) {
            return false;
        }

        if (!is_file($temp_page)) {
            return false;
        }

        // 得到模板文件内容
        #$content = file_get_contents($temp_page);

    }

    /**
     * 标签模式下替换metinfocss中的变量
     */
    public function parse_tag_static($type = 'css')
    {
        global $_M;

        $res = $this->tem_path . 'static/metinfo.' . $type;
        $new = $this->tem_path . 'cache/metinfo.' . $type;
        if (!is_dir(dirname($new)) && $_M['config']['met_skin_user']) {
            mkdir(dirname($new), 0777, true);
        }

        $has = is_file($new);
        if (($_M['form']['pageset'] && !defined('IN_ADMIN')) || !$has) {
            if (is_file($res)) {
                $tem_config = $this->list_templates_config(1);
                $content = file_get_contents($res);
                foreach ($tem_config as $name => $value) {
                    $content = str_replace("\${$name}\$", $value, $content);
                }
                //集成UI 静态内容
                /*$met_compile = load::sys_class('view/met_compile','new');
                $this->met_ui_data = $met_compile->parse_met_ui($this->template_type, $tem_config);*/

                $add_content = $this->parse_tag_path($type);
                $content = $add_content . "\n" . $content;
                if ($type == 'css') {
                    #$content = $content . "\n" . $this->met_ui_data['css_content'];
                    $content = $this->css_compress($content);
                } else {
                    #$content = $content . "\n" . $this->met_ui_data['js_content'];
                    $content = $this->js_compress($content);
                }
                file_put_contents($new, $content);
            }
        }
    }

    /**
     * 标签模式替换路径
     * @param string $type
     * @return string
     */
    public function parse_tag_path($type = 'css')
    {
        global $_M;
        $config = json_decode(file_get_contents($this->tem_path . 'config.json'), true);
        $new_content = "";

        //追加集成Ui数据
        /*if (is_array($this->met_ui_data[$type])) {
            $config_data = array_merge($config[$type], $this->met_ui_data[$type]);
        }else {
            $config_data = $config[$type];
        }*/

        $config_data = $config[$type];
        $config_data = array_unique($config_data);

        foreach ($config_data as $res) {
            $path = $this->replace_public($res);
            if(!$path){
                continue;
            }
            $content = file_get_contents($path);

            $file_path = str_replace(PATH_WEB, '', $path);
            if ($type == 'css') {
                $dir = str_replace(PATH_WEB, '', dirname($path)) . '/';
                $new_content .= $this->replace_url($path);
            } else {
                $new_content .= $content;
            }
        }

        return $new_content;
    }

    /**
     * 获取模板全局配置
     * @return array|mixed
     */
    public function list_public_config()
    {
        global $_M;
        //区分ui模板和tag模板进入不同解析方法
        $public_config = $this->list_templates_config();
        return $public_config;
    }

    /**
     * @param string $is_css
     * @return bool|mixed
     */
    public function list_templates_config($is_css = '')
    {
        global $_M;

        $tem_config = buffer::getTagConfig();
        if (!$tem_config) {
            $query = "SELECT * FROM {$_M['table']['templates']} WHERE lang = '{$_M['lang']}' AND no = '{$_M['config']['met_skin_user']}' AND type != 1";
            $templates = DB::get_all($query);
            foreach ($templates as $val) {
                $tem_config[$val['name']] = $this->replace_tag($val['value'], $val['defaultvalue'], $val['type'], $val['id']);
            }
            buffer::setTagConfig($tem_config);

            if ($_M['form']['pageset']) {
                $query = "SELECT * FROM {$_M['table']['templates']} WHERE lang = '{$_M['lang']}' AND no = '{$_M['config']['met_skin_user']}' AND name like 'tagshow_%'";
                $tagshow = DB::get_all($query);
                foreach ($tagshow as $t) {
                    $tem_config[$t['name']] = 1;
                }
            }
        }

        if (!$is_css) {
            $tem_config = str_replace('../', $_M['url']['site'], $tem_config);
        } else {
            $tem_config = str_replace('../', '../../../', $tem_config);
        }
        return $tem_config;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.