<?php

// MetInfo Enterprise Content Management System
// Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin.class.php');

class recycle extends admin
{
    public function __construct()
    {
        global $_M;
        parent::__construct();
    }

    public function dojson_list()
    {
        global $_M;
        $table = load::sys_class('tabledata', 'new'); //加载表格数据获取类

        $module = $_M['form']['module'];
        $search = $_M['form']['title'];

        $fields = 'id,title,class1,class2,class3,updatetime,recycle';
        $columns = array('product', 'news', 'download', 'img');
        $searchsql = $search ? $searchsql = "AND title LIKE '%$search%'" : $searchsql = '';
        $lang = $_M['lang'];
        $langsql = "AND lang='$lang'"; //查询条件

        $where = "recycle > 0 $langsql $searchsql";
        $order = '';

        if ($module == '0') {
            $query = "SELECT {$fields} FROM {$_M['table']['news']} WHERE $where ";
            $query .= " UNION SELECT {$fields} FROM {$_M['table']['product']} WHERE $where";
            $query .= " UNION SELECT {$fields} FROM {$_M['table']['download']} WHERE $where";
            $query .= " UNION SELECT {$fields} FROM {$_M['table']['img']} WHERE $where";
            $data = $table->getdata($_M['table'][$module], '*', $where, $order, $query); //获取数据
        } else {
            $data = $table->getdata($_M['table'][$module], '*', $where, $order); //获取数据
        }
        $query = "SELECT * FROM {$_M['table']['column']} where lang ='{$_M['lang']}'";
        $c_list = DB::get_all($query);

        foreach ($c_list as $key => $value) {
            $column_list[$value['id']] = $value;
        }

        if (is_array($data)) {
            foreach ($data as $key => $val) {
                $column_name = $column_list[$val['class1']]['name'];
                $mod = $column_list[$val['class1']]['module'];
                if ($val['class2'] != 0) {
                    $column_name = $column_list[$val['class2']]['name'];
                    $mod = $column_list[$val['class1']]['module'];
                }
                if ($val['class3'] != 0) {
                    $column_name = $column_list[$val['class3']]['name'];
                    $mod = $column_list[$val['class1']]['module'];
                }
                $list = array();
                $list['id'] = "{$val['id']}-{$mod}";
                $list['title'] = $val['title'];
                $list['updatetime'] = $val['updatetime'];
                $list['column_name'] = $column_name;
                $list['del_url'] = "{$_M['url']['own_form']}a=dolistsave&allid={$val['id']}-{$mod}&submit_type=del";
                $list['recyclere_url'] = "{$_M['url']['own_form']}a=dolistsave&allid={$val['id']}-{$mod}&submit_type=restore";
                $rarray[] = $list;
            }
            $table->rdata($rarray); //返回数据
            die();
        } else {
            $table->rdata(''); //返回数据;
            die();
        }
    }

    /**
     * 列表操作.
     */
    public function dolistsave()
    {
        global $_M;
        if (isset($_M['form']['allid'])) {
            $item = explode(',', $_M['form']['allid']);
            foreach ($item as $val) {
                $row = explode('-', $val);
                if ($_M['form']['submit_type'] == 'restore') {//恢复
                    $this->dorestore($row[0], $row[1]);
                }
                if ($_M['form']['submit_type'] == 'del') {//删除
                    $para_op = load::mod_class('parameter/parameter_op', 'new');
                    $para_op->del_plist($row[0], $row[1]);
                    $this->dodelete($row[0], $row[1]);
                }
            }
        }
        $redata['status'] = 1;
        $redata['msg'] = $_M['word']['jsok'];
        $this->ajaxReturn($redata);
    }

    /**
     * 从回收站删除.
     *
     * @param string $id
     * @param string $colu
     */
    public function dodelete($id = '', $colu = '')
    {
        global $_M;
        $column = $this->get_colnum_name($colu);
        if ($column) {
            $query = "DELETE  FROM {$_M['table'][$column]} WHERE `id` = '{$id}' and `lang` = '{$_M['lang']}'";
            $data = DB::get_all($query);
        }
    }

    /**
     * 从回收站恢复.
     *
     * @param string $id
     * @param string $colu
     */
    public function dorestore($id = '', $colu = '')
    {
        global $_M;
        $column = $this->get_colnum_name($colu);
        $query = "UPDATE {$_M['table'][$column]} SET `recycle` = 0 WHERE `id` = '{$id}' and `lang` = '{$_M['lang']}'";
        $data = DB::get_all($query);
    }

    /**
     * @param $mod
     *
     * @return string
     */
    public function get_colnum_name($mod = '')
    {
        switch ($mod) {
            case 2:
                $column = 'news';
                break;
            case 3:
                $column = 'product';
                break;
            case 4:
                $column = 'download';
                break;
            case 5:
                $column = 'img';
                break;
        }

        return $column;
    }
}

// This program is an open source system, commercial use, please consciously to purchase commercial license.
// Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
