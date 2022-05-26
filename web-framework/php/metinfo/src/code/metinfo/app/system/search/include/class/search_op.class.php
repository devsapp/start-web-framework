<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * 搜索模块标签类
 */

class search_op
{

    /**
     * 初始化
     */
    public function __construct()
    {
        global $_M;
        $this->lang = $_M['lang'];
    }

    //更新或者写入搜索信息
    public function insert_search_info($module, $listid)
    {
        global $_M;
        list($mid, $mname) = load::sys_mod('handle', 'new')->handle_module($module);
        if ($mid == 1) {
            $list = load::sys_class('label', 'new')->get('column')->get_column_id($listid);
            $search['title'] = $list['name'];
            $search['contents'] = strip_tags($list['content']);
            //$search['paras'] = '';
            $search['module'] = $mid;
            $search['class1'] = 0;
            $search['class2'] = 0;
            $search['class3'] = 0;
            $search['urlinfo'] = array(
                1 => load::sys_class('label', 'new')->get('column')->handle->get_content_url($list, 1),
                2 => load::sys_class('label', 'new')->get('column')->handle->get_content_url($list, 2),
                3 => load::sys_class('label', 'new')->get('column')->handle->get_content_url($list, 3),
            );
            $search['top_ok'] = '';
            $search['com_ok'] = '';
            $search['update_time'] = '';
        } else {
            $list = load::sys_class('label', 'new')->get($mname)->get_one_list_contents($listid, 0, 0);
            $search['title'] = $list['title'];
            $search['contents'] = strip_tags($list['content'] . $list['conten1'] . $list['content2'] . $list['content3'] . $list['content4'] . $list['content5']);
            //$search['paras'] = $this->search_para_handle($list['para']);
            $search['module'] = $mid;
            $search['class1'] = $list['class1'];
            $search['class2'] = $list['class2'];
            $search['class3'] = $list['class3'];
            $search['urlinfo'] = array(
                1 => load::sys_class('label', 'new')->get($mname)->handle->get_content_url($list, 1),
                2 => load::sys_class('label', 'new')->get($mname)->handle->get_content_url($list, 2),
                3 => load::sys_class('label', 'new')->get($mname)->handle->get_content_url($list, 3),
            );
        }
        $s = load::mod_class('search/search_database', 'new')->get_search_list_by_module_listid($mid, $listid);
        if ($s) {
            $search['id'] = $s['id'];
            $this->update_by_id($search);
        } else {
            $this->insert($search);
        }
        return true;
    }

    //对保存的字段进行处理
    public function search_para_handle($para)
    {
        $str = '';
        $str .= "[#S#]";
        foreach ($para as $key => $val) {
            $str .= "{$val['id']}[#M#]{$val['value']}[#S#]";
        }
        return $str;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
