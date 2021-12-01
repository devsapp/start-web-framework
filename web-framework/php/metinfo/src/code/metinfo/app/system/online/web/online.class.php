<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.


/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/27
 * Time: 15:31
 */
defined('IN_MET') or exit('No permission');

load::sys_class('web');

class online extends web
{
    public function __construct()
    {
        global $_M;
        parent::__construct();
    }

    public function do_online()
    {
        global $_M, $metinfover;
        if ($_M['config']['met_online_type'] != 0) {
            $met_url = $_M['url']['public'];
            $cache_online = Cache::get("config/online_{$_M['lang']}");
            if (!$cache_online || 1) {
                $cache_online = $this->cache_online();
            }

            $online_style = $_M['config']['met_online_skin'] ? $_M['config']['met_online_skin'] : 1;
            $data['online_list'] = $cache_online;
            $data['url'] = $_M['url'];

            if ($_M['form']['module'] == 10001) {
                $_M['config']['met_onlinetel'] = str_replace('../', '', $_M['config']['met_onlinetel']);
            }

            $file_path = PATH_WEB . "app/system/online/web/templates/online_{$online_style}.php";
            $engine = load::sys_class('engine', 'new');
            $html = $engine->dofetch($file_path, $data);

            $redata = array();
            $redata['status'] = 1;
            $redata['html'] = $html;
            $redata['t'] = $_M['config']['met_online_type'];
            $redata['x'] = $_M['config']['met_online_x'] ? $_M['config']['met_online_x'] : "10";
            $redata['y'] = $_M['config']['met_online_y'] ? $_M['config']['met_online_y'] : "100";
        } else {
            $redata['status'] = 0;
        }
        $this->ajaxReturn($redata);
    }

    /**
     * 缓存兼容函数
     */
    public function cache_online(){
        global $_M;
        $list = load::mod_class('online/online_label', 'new')->getOnlineList();
        $unm = count($list);
        foreach ($list as $key => $value) {
            $list[$key]['_index'] = $key;
            if($key==0){
                $list[$key]['_first'] = 1;
            }
            if($key==$unm-1){
                $list[$key]['_last'] = 1;
            }
        }

        Cache::put("config/online_{$_M['lang']}", $list);
        return $list;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.