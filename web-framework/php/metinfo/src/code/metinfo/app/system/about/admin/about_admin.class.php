<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('news/admin/news_admin');
load::mod_class('message/admin/message_admin');


class about_admin extends news_admin
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
        $this->module = 1;
        $this->database = load::mod_class('about/about_database', 'new');
        $this->tabledata = load::sys_class('tabledata', 'new');
    }

    /**
     * 新增内容
     */
    public function doadd()
    {
        return;
    }

    /**
     * 添加数据保存
     */
    public function doaddsave()
    {
        return;
    }

    /**
     * 新增内容插入数据处理
     * @param  前台提交的表单数组 $list
     * @return $pid  新增的ID 失败返回FALSE
     */
    public function insert_list($list = array())
    {
        return parent::insert_list();
    }

    /**
     * 插入sql
     * @param  array $list 插入的数组
     * @return number  插入后的数据ID
     */
    public function insert_list_sql($list = array())
    {
        return parent::insert_list_sql($list);
    }

    /**
     * 编辑文章页面
     */

    public function doeditor()
    {
        global $_M;
        $id = $_M['form']['id'];
        $about = $this->database->get_list_one_by_id($id);
        $redata['list'] = $about;
        return $redata;
    }

    /**
     * 修改保存页面
     * @param  array $list 插入的数组
     * @return number  插入后的数据ID
     */
    public function doeditorsave()
    {
        global $_M;
        if ($this->update_list($_M['form'], $_M['form']['id'])) {
            buffer::clearColumn($_M['lang']);
            $redata['status'] = 1;
            $redata['msg'] = $_M['word']['jsok'];
            $this->ajaxReturn($redata);
        } else {
            $redata['status'] = 0;
            $redata['msg'] = $_M['word']['dataerror'];
            $this->ajaxReturn($redata);
        }
    }

    /**
     * 保存修改
     * @param  array $list 修改的数组
     * @return bool                     修改是否成功
     */
    public function update_list($list = array(), $id = '')
    {
        return self::update_list_sql($list, $id);
    }

    /**
     * 保存修改sql
     * @param  array $list 修改的数组
     * @return bool    修改是否成功
     */
    public function update_list_sql($list = array(), $id = '')
    {
        global $_M;
        $list['id'] = $id;
        //图片处理 缩略图 水印图
        $list = $this->form_imglist($list, $this->module);
        if ($list['description']) {
            $listown = $this->database->get_list_one_by_id($id);
            $description = $this->description($listown['content']);
            if ($list['description'] == $description) {
                $list['description'] = $this->description($list['content']);
            }
        } else {
            $list['description'] = $this->description($list['content']);
        }
        return $this->database->update_by_id($list);    //更新内容
    }

    /**
     * 栏目json
     */
   public function docolumnjson()
    {
        global $_M;
        $redata = array();
        $column_database = load::mod_class('column/column_database', 'new');
        $list = $column_database->get_column_by_module(1);
        $new_list = array();

        foreach ($list as $column) {
            $arr = array();
            if ($column['isshow'] == 1) {
                $class123 = load::sys_class('label', 'new')->get('column')->get_class123_no_reclass($column['id']);
                if ($class123) {
                    $para_class123 = '';
                    $para_class123 .= $class123['class1']['id'] ? "&class1={$class123['class1']['id']}" : '';
                    $para_class123 .= $class123['class2']['id'] ? "&class2={$class123['class2']['id']}" : '';
                    $para_class123 .= $class123['class3']['id'] ? "&class3={$class123['class3']['id']}" : '';
                }
                $mod_name = load::sys_class('handle', 'new')->mod_to_file($column['module']);
                $url = "lang={$this->lang}&n={$mod_name}&c={$mod_name}_admin&a=doeditor". $para_class123;

                $arr['id'] 			= $column['id'];
                $arr['name'] 		= $column['name'];
                $new_list[] = $arr;
            }
        }
        $redata['list']=$new_list;
        return $redata;
    }

    /**
     * 检测静态文件名称是否存在
     */
    public function doCheckFilename()
    {
        global $_M;
        $filename = $_M['form']['filename'];
        $id = $_M['form']['id'] ? $_M['form']['id'] : '';
        $redata['valid'] = true;
        if (is_string($filename)) {
            $patten = '/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u';
            $check_res = is_simplestr($filename,$patten);
            if ($check_res == false) {
                $redata['valid'] = false;
                $redata['message'] = $_M['word']['special_che_deny'];
            }
            $res = $this->database->get_column_by_filename($filename);
            if ($id == '' && $res) {
                $redata['valid'] = false;
                $redata['message'] = $_M['word']['jsx27'];
            }
            if ($id && $res && $res['id'] != $id) {
                $redata['valid'] = false;
                $redata['message'] = $_M['word']['jsx27'];
            }
        }
        $this->ajaxReturn($redata);
    }

    /**
     * 分页数据
     */
    public function dojson_list()
    {
        return;
    }

    /**
     * @param string $class1
     * @param string $class2
     * @param string $class3
     * @param string $keyword
     * @return array|bool
     */
    public function _dojson_list($class1 = '', $class2 = '', $class3 = '', $keyword = '', $search_type = '', $orderby_hits = '', $orderby_updatetime = '')
    {
        return;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
