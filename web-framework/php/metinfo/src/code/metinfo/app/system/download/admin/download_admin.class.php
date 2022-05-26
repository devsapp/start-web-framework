<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('news/admin/news_admin');

class download_admin extends news_admin
{
    public $shop;
    public $module;

    function __construct()
    {
        global $_M;
        parent::__construct();
        $this->module = 4;
        $this->database = load::mod_class('download/download_database', 'new');

    }

    /**
     * 增加
     */
    function doadd()
    {
        global $_M;
        return parent::doadd();
    }

    function doaddsave()
    {
        global $_M;
        return parent::doaddsave();
    }

    public function insert_list($list = array())
    {
        global $_M;
        return parent::insert_list($list);
    }

    public function insert_list_sql($list = array())
    {
        global $_M;
        return parent::insert_list_sql($list);
    }

    /**
     *系统属性
     */
    public function dopara()
    {
        return parent::dopara();
    }

    /*产品编辑*/
    function doeditor()
    {
        global $_M;
        return parent::doeditor();
    }

    function doeditorsave()
    {
        global $_M;
        return parent::doeditorsave();
    }

    public function update_list($list = array(), $id = '')
    {
        global $_M;
        return parent::update_list($list, $id);
    }

    public function update_list_sql($list = array(), $id = '')
    {
        global $_M;
        return parent::update_list_sql($list, $id);
    }

    /**
     * 分页数据
     */
    public function dojson_list()
    {
        global $_M;
        return parent::dojson_list();
    }

    /**
     * @param string $class1
     * @param string $class2
     * @param string $class3
     * @param string $keyword
     * @param string $search_type
     * @param string $orderby_hits
     * @param string $orderby_updatetime
     * @return array
     */
    public function _dojson_list($class1 = '', $class2 = '', $class3 = '', $keyword = '', $search_type = '', $orderby_hits = '', $orderby_updatetime = '')
    {
        global $_M;
        return parent::_dojson_list($class1, $class2, $class3, $keyword, $search_type, $orderby_hits, $orderby_updatetime);
    }

    function dolistsave()
    {
        global $_M;
        return parent::dolistsave();
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
