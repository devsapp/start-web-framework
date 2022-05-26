<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('message/admin/message_admin');
load::mod_class('news/admin/news_admin');


class job_admin extends news_admin
{
    public $moduleclass;
    public $module;
    public $database;

    /**
     * 初始化
     */

    function __construct()
    {
        global $_M;
        parent::__construct();
        $class1 = is_numeric($_M['form']['class1']) ? $_M['form']['class1'] : '';
        $this->module = 6;
        $this->database = load::mod_class('job/job_database', 'new');
        $this->tabledata = load::sys_class('tabledata', 'new');
    }

    /**
     * 新增内容
     */
    public function doadd()
    {
        global $_M;

        $redata = array();
        $list = $this->add();
        $list['class1'] = $_M['form']['class1'];
        $list['class2'] = $_M['form']['class2'];
        $list['class3'] = $_M['form']['class3'];
        $list['addtime'] = date('Y-m-d', time());
        $list['updatetime'] = date('Y-m-d', time());
        $access_option = $this->access_option();
        $classnow = $list['class3'] ? $list['class3'] : ($list['class2'] ? $list['class2'] : $list['class1']);
        $column_list = $this->_columnjson();

        $config_op = load::mod_class('config/config_op', 'new');
        $conlum_configs = $config_op->getColumnConfArry($classnow);

        $redata['list'] = $list;
        $redata['now_time'] = $list['addtime'];
        $redata['met_cv_emtype'] = $conlum_configs['met_cv_emtype'];
        $redata['access_option'] = $access_option;
        $redata = array_merge($redata, $column_list);
        if (is_mobile()) {
            $this->success($redata);
        } else {
            return $redata;
        }
    }

    /**
     * 添加数据保存
     */
    public function doaddsave()
    {
        global $_M;
        parent::doaddsave();
    }

    public function insert_list($list = array()){
        global $_M;
        return $this->insert_list_sql($list);
    }

    /**
     * 插入sql
     * @param  array $list 插入的数组
     * @return number 插入后的数据ID
     */
    public function insert_list_sql($list = array())
    {
        global $_M;
        if (!$this->check_filename($list['filename'], '', $this->module)) {
            return false;
        }
        $list['class1'] = $list['class1'] ? $list['class1'] : 0;
        $list['class2'] = $list['class2'] ? $list['class2'] : 0;
        $list['class3'] = $list['class3'] ? $list['class3'] : 0;
        $list['lang'] = $this->lang;
        $list['count'] = is_numeric($list['count']) ? $list['count'] : 0;
        $list['useful_life'] = is_numeric($list['useful_life']) ? $list['useful_life'] : 0;
        return $this->database->insert($list);
    }

    /**
     * 编辑文章页面
     */
    function doeditor()
    {
        global $_M;
        $id = $_M['form']['id'];
        $class1 = is_numeric($_M['form']['class1']) ? $_M['form']['class1'] : '';
        $class2 = is_numeric($_M['form']['class2']) ? $_M['form']['class2'] : '';
        $class3 = is_numeric($_M['form']['class3']) ? $_M['form']['class3'] : '';
        $classnow = $class3 ? $class3 : ($class2 ? $class2 : $class1);

        $config_op = load::mod_class('config/config_op', 'new');
        $conlum_configs = $config_op->getColumnConfArry($classnow);

        $list = $this->database->get_list_one_by_id($id);
        $access_option = $this->access_option();
        $column_list = $this->_columnjson();

        $redata['list'] = $list;
        $redata['met_cv_emtype'] = $conlum_configs['met_cv_emtype'];
        $redata['now_time'] = date('Y-m-d', time());
        $redata['access_option'] = $access_option;
        $redata = array_merge($redata, $column_list);
        if (is_mobile()) {
            $this->success($redata);
        } else {
            return $redata;
        }
    }

    /**
     * 修改保存页面
     * @param  array $list 插入的数组
     * @return number                 插入后的数据ID
     */
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

    /**
     * 保存修改sql
     * @param  array $list 修改的数组
     * @return bool                     修改是否成功
     */
    public function update_list_sql($list = array(), $id = '')
    {
        global $_M;
        $list['id'] = $id;
        return $this->database->update_by_id($list);
    }

    /**
     * 获取列表数据
     */
    function dojson_list()
    {
        global $_M;
        parent::dojson_list();
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
        $where = '';
        $where .= $class1 ? " AND class1 = '{$class1}'" : " AND class1 = 0";
        $where .= $class2 ? " AND class2 = '{$class2}'" : " AND class2 = 0";
        $where .= $class3 ? " AND class3 = '{$class3}'" : " AND class3 = 0";
        $where .= $keyword ? " AND position like '%{$keyword}%'" : '';
        switch ($search_type) {
            case 0:
                break;
            case 1:
                $where .= " and displaytype = '0'";
                break;
            case 2:
                $where .= " and top_ok = '1'";
                break;
        }
        $admininfo = admin_information();
        if ($admininfo['admin_issueok'] == 1) $where .= " and issue = '{$admininfo['admin_id']}'";
        $met_class = $this->column(2, $this->module);
        if ($class3) {
            $classnow = $class3;
        } elseif ($class2) {
            $classnow = $class2;
        } else {
            $classnow = $class1;
        }

        $order = $this->list_order($met_class[$classnow]['list_order']);
        $data = $this->json_list($where, $order);

        foreach ($data as $key => $val) {
            $list = array();
            $list['id'] = $val['id'];
            $list['position'] = $val['position'];
            $list['count'] = $val['count'];
            $list['place'] = $val['place'];
            $list['deal'] = $val['deal'];
            $list['useful_life'] = $val['useful_life'];
            $list['top_ok'] = $val['top_ok'];
            $list['displaytype'] = $val['displaytype'];
            $list['no_order'] = $val['no_order'];
            $list['addtime'] = $val['addtime'];
            $list['updatetime'] = $val['updatetime'];
            if ($_M['config']['met_member_use']) {
                switch ($val['access']) {
                    case '1':
                        $list['access'] = array('name' => $_M['word']['access1'], 'val' => $list['access']);
                        break;
                    case '2':
                        $list['access'] = array('name' => $_M['word']['access2'], 'val' => $list['access']);
                        break;
                    case '3':
                        $list['access'] = array('name' => $_M['word']['access3'], 'val' => $list['access']);
                        break;
                    default:
                        $list['access'] = array('name' => $_M['word']['access0'], 'val' => 0);
                        break;
                }
            }
            $list['doeditor'] = "{$_M['url']['own_form']}a=doeditor&id={$val['id']}&class1={$class1}&class2={$class2}&class3={$class3}";
            $list['delete'] = "{$_M['url']['own_form']}a=dolistsave&submit_type=del&allid={$val['id']}";

            $rarray[] = $list;
        }

        return $rarray;
    }

    /**
     * 保存列表
     */
    function dolistsave()
    {
        global $_M;
        return parent::dolistsave();
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
