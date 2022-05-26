<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');
load::sys_class('admin');

/** 菜单设置 */
class menu_admin extends admin
{
    public $module;
    public $lang;
    public $tabledata;

    public function __construct()
    {
        global $_M;
        parent::__construct();
        $this->lang = $_M['lang'];
        $this->tabledata = load::sys_class('tabledata', 'new');
        $this->database = load::mod_class('menu/menu_database', 'new');
    }

    public function doindex()
    {
        global $_M;
        return;
    }

    //获取列表
    public function doGetList()
    {
        global $_M;
        $where = " lang = '{$_M['lang']}'";
        $order = " no_order ";
        $list = $this->tabledata->getdata($_M['table']['menu'], '*', $where, $order);
        $this->tabledata->rdata($list);
    }

    //新增/修改
    public function doSaveMenu()
    {
        global $_M;
        $form = $_M['form'];
        $list = explode(",", $form['allid']);
        foreach ($list as $id) {
            if ($id) {
                if ($form['submit_type'] == 'save') {
                    $info = array();
                    $info['name'] = $form['name-' . $id];
                    $info['url'] = $form['url-' . $id];
                    $info['icon'] = $form['icon-' . $id];
                    $info['text_color'] = $form['text_color-' . $id];
                    $info['but_color'] = $form['but_color-' . $id];
                    $info['enabled'] = $form['enabled-' . $id];
                    $info['no_order'] = $form['no_order-' . $id];
                    $info['lang'] = $_M['lang'];

                    if (is_numeric($id)) {
                        $this->updateMenu($id, $info);
                    } else {
                        $this->insertMenu($info);
                    }
                } elseif ($form['submit_type'] == 'del') {
                    if (is_numeric($id)) {
                        $this->deleteMenu($id);
                    }
                }
            }
        }
        if ($this->error) {
            $redata['status'] = 0;
            $redata['msg'] = $this->error[0];
            $redata['error'] = $this->error;
        } else {
            $redata['status'] = 1;
            $redata['msg'] = $_M['word']['jsok'];
        }
        $this->ajaxReturn($redata);
    }

    private function insertMenu($data = array())
    {
        global $_M;
        /*$data['type'] = $data['type'] ? $data['type'] : 1;
        $data['is_mobile'] = $data['is_mobile'] ? $data['is_mobile'] : 1;*/
        $insert_id = $this->database->insert($data);
        return $insert_id;
    }

    private function updateMenu($id, $data)
    {
        global $_M;
        $data['id'] = $id;
        $res = $this->database->update_by_id($data);
        return $res;
    }

    private function deleteMenu($id)
    {
        global $_M;
        $res = $this->database->del_by_id($id);
        return $res;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
