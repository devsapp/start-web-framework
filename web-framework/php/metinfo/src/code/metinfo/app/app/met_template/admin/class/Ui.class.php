<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

class Ui
{
    public $error;

    private $metui_dir;

    private $met_ui_type;

    public function __construct()
    {
        global $_M;
        $this->error = array();
        $this->metui_dir = PATH_ALL_APP . 'met_template/style/';
        $this->met_ui_type = array(
            'head_nav',
            'banner',
            'product_list_page',
            'news_list_page',
            'img_list_page',
            'mobile_menu',
        );
    }

    /**
     * 初始化系统UI配置
     */
    public function initializeMetUI($lang = '')
    {
        global $_M;
        if ($lang == '') {
            $lang = $_M['lang'];
        }
        $query = "DELETE FROM {$_M['table']['ui_list']} WHERE skin_name = 'system'";
        DB::query($query);
        $query = "DELETE FROM {$_M['table']['ui_config']} WHERE skin_name = 'system'";
        DB::query($query);
        $block_list = scandir($this->metui_dir);
        if (!is_array($block_list)) {
            return false;
        } else {
            $met_ui_block_list = array();
            foreach ($block_list as $block) {
                if ($block != '.' && $block != '..') {
                    $met_ui_block_list[] = $block;
                }
            }
        }

        foreach ($met_ui_block_list as $key => $block) {
            if (!in_array($block, $this->met_ui_type)) {
                continue;
            }
            $add_conf = self::addMetuiConfig($block,$lang);
            if ($add_conf === false) {
                $this->error[] = "集成UI {$block}  配置插入失败";
                continue;
            }
            $ui_block = "$this->metui_dir/{$block}";
            $ui_list = scandir($ui_block);
            foreach ($ui_list as $k => $ui_name) {
                if ($ui_name != '.' && $ui_name != '..' && is_string($ui_name)) {
                    $install_res = self::installMetui($block, $ui_name, $lang);
                }
            }
        }

        if ($this->error) {
            return false;
        }else{
            return true;
        }
    }

    /**
     * @param string $block
     * @param string $lang
     * @return bool
     */
    public function addMetuiConfig($block = '',$lang = '')
    {
        global $_M;
        if ($block == '' || $lang == '' || !in_array($block, $this->met_ui_type)) {
            return false;
        }

        $config_name = "met_style_{$block}";
        $query = "SELECT * FROM {$_M['table']['config']} WHERE name = '{$config_name}' AND lang = '{$lang}'";
        $config = DB::get_one($query);
        if ($config) {
            $query = "UPDATE {$_M['table']['config']} SET value = 0 WHERE name = '{$config_name}' AND lang = '{$lang}'";
            $res = DB::query($query);
            return true;
        }else{
            $save_data = array(
                'name' => $config_name,
                'value' => 0,
                'lang' => $lang,
            );
            $insta_res = DB::insert($_M['table']['config'],$save_data);
            return $insta_res;
        }

    }

    /**
     * 安装集成UI
     * @param string $block
     * @param string $ui_name
     * @param string $to_lang
     * @return bool
     */
    public function installMetui($block = '', $ui_name = '', $to_lang = '')
    {
        global $_M;
        $redata = array();
        if ($block && $ui_name && $to_lang) {
            $install = $this->metui_dir . "{$block}/{$ui_name}/install.json";
            if (is_file($install)) {
                $install_data = json_decode(file_get_contents($install), true);
                if (is_array($install_data['ui']) && is_array($install_data['config'])) {
                    $installid = self::insertMetui($install_data['ui'], $to_lang);
                    #dump($installid);
                    if (is_numeric($installid)) {
                        $res2 = self::insertMetuiConfig($install_data['config'], $to_lang, $installid);
                    }
                }
            }
            if (!$this->error) {
                return true;
            }else{
                return false;
            }
        } else {
            $this->error[] = "缺少参数";
            return false;
        }
    }

    /**
     * 插入ui信息
     * @param array $metui_info
     * @param string $to_lang
     * @return bool
     */
    private function insertMetui($metui_info = array())
    {
        global $_M;
        $query = "SELECT max(`installid`) as max_id FROM {$_M['table']['ui_list']} WHERE skin_name = 'system'";
        $max_pid = DB::get_one($query);
        $max_pid = $max_pid['max_id'];

        if ($max_pid) {
            $installid = $max_pid + 1;
        } else {
            $installid = 10000;
        }

        $query = "SELECT * FROM {$_M['table']['ui_list']} WHERE skin_name = 'system' AND parent_name ='{$metui_info['parent_name']}' AND ui_name = '{$metui_info['ui_name']}'";
        $met_ui = DB::get_one($query);

        if (!$met_ui) {
            $sava_data = array();
            $sava_data['installid'] = $installid;
            $sava_data['skin_name'] = 'system';
            $sava_data['parent_name'] = $metui_info['parent_name'];
            $sava_data['ui_name'] = $metui_info['ui_name'];
            $sava_data['ui_title'] = $metui_info['ui_title'];
            $sava_data['ui_description'] = $metui_info['ui_description'];
            $sava_data['ui_page'] = $metui_info['ui_page'];
            $sava_data['ui_order'] = $metui_info['ui_order'];
            $sava_data['ui_version'] = $metui_info['ui_version'];
            $sava_data['ui_installtime'] = time();
            $sava_data['ui_edittime'] = time();
            $res = DB::insert($_M['table']['ui_list'], $sava_data);
            if ($res) {
                return $installid;
            } else {
                $this->error[] = DB::error();
                return false;
            }
        } else {
            //ui升级
            if (version_compare($metui_info['ui_version'], $met_ui['ui_version'], '>')) {
                $query = "UPDATE {$_M['table']['ui_list']} SET 
                  ui_title = {$metui_info['ui_title']},
                  ui_description = {$metui_info['ui_description']},
                  ui_order = {$metui_info['ui_order']},
                  ui_version = {$metui_info['ui_version']},
                  ui_edittime = {$metui_info['ui_edittime']},
                  ";
                DB::query($query);
                return $met_ui['installid'];
            }else{
                $this->error[] = "{$metui_info['parent_name']}_{{$metui_info['ui_name']}}  UI 已存在";
                return false;
            }
        }
    }

    /**
     * 插入ui配置
     * @param array $metui_config
     * @param string $to_lang
     * @return bool
     */
    private function insertMetuiConfig($metui_config = array(), $to_lang = '', $installid = '')
    {
        global $_M;
        if (!$installid) {
            $this->error[] = 'no installid';
            return false;
        }

        foreach ($metui_config as $config) {
            $query = "SELECT * FROM {$_M['table']['ui_config']} WHERE skin_name = 'system' AND pid='{$installid}' AND parent_name='{$config['parent_name']}' AND ui_name = '{$config['ui_name']}' AND uip_name='{$config['uip_name']}' AND lang='{$to_lang}'";
            $met_ui_config = DB::get_one($query);
            if ($met_ui_config) {
                $query = "UPDATE {$_M['table']['_config']} SET 
                  uip_style={$config['uip_style']},
                  uip_select={$config['uip_select']},
                  uip_default={$config['uip_default']},
                  uip_title={$config['uip_title']},
                  uip_description={$config['uip_description']},
                  uip_order'={$config['uip_order']}' WHERE 
                  lang='{$to_lang}'
                  ";
                $res = DB::query($query);
            } else {
                $sava_data = array();
                $sava_data['pid'] = $installid;
                $sava_data['skin_name'] = 'system';
                $sava_data['parent_name'] = $config['parent_name'];
                $sava_data['ui_name'] = $config['ui_name'];
                $sava_data['uip_type'] = $config['uip_type'];
                $sava_data['uip_style'] = $config['uip_style'];
                $sava_data['uip_select'] = $config['uip_select'];
                $sava_data['uip_name'] = $config['uip_name'];
                $sava_data['uip_key'] = $config['uip_key'];
                $sava_data['uip_value'] = $config['uip_value'];
                $sava_data['uip_default'] = $config['uip_default'];
                $sava_data['uip_title'] = $config['uip_title'];
                $sava_data['uip_description'] = $config['uip_description'];
                $sava_data['uip_order'] = $config['uip_order'];
                $sava_data['uip_hidden'] = $config['uip_hidden'];
                $sava_data['lang'] = $to_lang;
                $res = DB::insert($_M['table']['ui_config'], $sava_data);
            }

            if (DB::error()) {
                $this->error[] = DB::error();
                continue;
            }
        }
        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    public function getError()
    {
        global $_M;
        return $this->error;
    }

}

