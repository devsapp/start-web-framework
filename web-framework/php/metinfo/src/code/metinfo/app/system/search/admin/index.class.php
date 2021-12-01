<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');
load::sys_class('admin');
load::sys_func('file');
/** 搜索设置 */
class index extends admin
{
    public function __construct()
    {
        global $_M;
        parent::__construct();
        admin_information();
    }

    //获取设置
    public function doIndex()
    {
        global $_M;
    }

    //获取全站搜索框数据
    public function doGetGlobalSearch()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['language']} WHERE name = 'SearchInfo1' AND lang = '{$_M['lang']}'";
        $lang = DB::get_one($query);
        $data['search_placeholder'] = $lang['value'];
        $data['column'] = load::sys_class('label', 'new')->get('column')->get_parent_columns();
        return $data;
    }

    //保存全部搜索框数据
    public function doSaveGlobalSearch()
    {
        global $_M;
        $data = array(
            'global_search_range',
            'global_search_type',
            'global_search_module',
            'global_search_column',
            'global_search_weight',
        );
        configsave($data, $_M['form']);
        $query = "UPDATE {$_M['table']['language']} SET value = '{$_M['form']['search_placeholder']}' WHERE name = 'SearchInfo1' AND lang = '{$_M['lang']}'";
        DB::query($query);
        buffer::clearConfig();
        $this->success($data, $_M['word']['jsok']);
    }

    //栏目收索
    public function doGetColumnSearch()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['language']} WHERE name = 'columnSearchInfo' AND lang = '{$_M['lang']}'";
        $lang = DB::get_one($query);
        $data['search_placeholder'] = $lang['value'];
        return $data;
    }

    //保存栏目搜索框数据
    public function doSaveColumnSearch()
    {
        global $_M;
        $data = array(
            'column_search_range',
            'column_search_type'
        );
        configsave($data, $_M['form']);
        $query = "UPDATE {$_M['table']['language']} SET value = '{$_M['form']['search_placeholder']}' WHERE name = 'columnSearchInfo' AND lang = '{$_M['lang']}'";
        DB::query($query);
        buffer::clearConfig();

        $this->success($data, $_M['word']['jsok']);
    }

    //高级收索
    public function doGetAdvancedSearch()
    {
        global $_M;
        $data = array();
        $query = "SELECT * FROM {$_M['table']['language']} WHERE name = 'advancedSearchInfo' AND lang = '{$_M['lang']}'";
        $lang = DB::get_one($query);
        $data['search_placeholder'] = $lang['value'];
        $data['column'] = load::sys_class('label', 'new')->get('column')->get_parent_columns();

        return $data;
    }

    //保存栏目搜索框数据
    public function doSaveAdvancedSearch()
    {
        global $_M;
        $data = array(
            'advanced_search_range',    //收索范围
            'advanced_search_type',     //收索类型
            'advanced_search_column',   //收索栏目选择
            'advanced_search_linkage'
        );

        if ($_M['form']['advanced_search_range'] == 'all') {
            $_M['form']['advanced_search_column'] = '';
        }
        configsave($data, $_M['form']);
        $query = "UPDATE {$_M['table']['language']} SET value = '{$_M['form']['search_placeholder']}' WHERE name = 'advancedSearchInfo' AND lang = '{$_M['lang']}'";
        DB::query($query);
        buffer::clearConfig();
        $this->success($data, $_M['word']['jsok']);
    }

    //获取搜索配置 未启用
    public function doGetSearchSet()
    {
        global $_M;
        $data['column'] = load::sys_class('label', 'new')->get('column')->get_parent_columns();
        //全站搜索
        $query = "SELECT * FROM {$_M['table']['language']} WHERE name = 'SearchInfo1' AND lang = '{$_M['lang']}'";
        $lang = DB::get_one($query);
        $data['SearchInfo1'] = $lang['value'];
        //栏目搜索
        $query = "SELECT * FROM {$_M['table']['language']} WHERE name = 'columnSearchInfo' AND lang = '{$_M['lang']}'";
        $lang = DB::get_one($query);
        $data['columnSearchInfo'] = $lang['value'];
        //高级搜索
        $query = "SELECT * FROM {$_M['table']['language']} WHERE name = 'advancedSearchInfo' AND lang = '{$_M['lang']}'";
        $lang = DB::get_one($query);
        $data['advancedSearchInfo'] = $lang['value'];
        return $data;
    }

    //保存搜索配置 未启用
    public function doGetSearchSave()
    {
        global $_M;
        $query = "UPDATE {$_M['table']['language']} SET value = '{$_M['form']['search_placeholder']}' WHERE name = 'SearchInfo1' AND lang = '{$_M['lang']}'";
        DB::query($query);
        $query = "UPDATE {$_M['table']['language']} SET value = '{$_M['form']['columnSearchInfo']}' WHERE name = 'SearchInfo1' AND lang = '{$_M['lang']}'";
        DB::query($query);
        $query = "UPDATE {$_M['table']['language']} SET value = '{$_M['form']['search_placeholder']}' WHERE name = 'SearchInfo1' AND lang = '{$_M['lang']}'";
        DB::query($query);

        $data = array(
            //全站搜索
            'global_search_range',      //收索范围
            'global_search_type',       //收索类型
            'global_search_module',     //搜索模块
            'global_search_column',     //搜索栏目
            //栏目搜索
            'column_search_range',      //收索范围
            'column_search_type',       //收索类型
            //高级搜索
            'advanced_search_range',    //收索范围
            'advanced_search_type',     //收索类型
            'advanced_search_column',   //收索栏目选择
            'advanced_search_linkage'   //是否联动
        );
        configsave($data, $_M['form']);
        buffer::clearConfig();
        $this->success($data, $_M['word']['jsok']);
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
