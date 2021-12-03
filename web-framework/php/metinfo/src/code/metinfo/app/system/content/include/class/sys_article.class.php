<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin.class.php');
load::mod_class('content/class/module');

class sys_article extends module
{
    public $errorno;
    public $table;
    public $tablename;
    public $module;

    public function __construct()
    {
        global $_M;
        $this->tablename = $_M['table']['news'];
        $this->module = 2;
    }

    /*复制*/
    public function list_copy($id, $class1, $class2, $class3)
    {
        global $_M;
        $list = $this->get_list($id);
        $list['filename'] = '';
        $list['class1'] = $class1;
        $list['class2'] = $class2;
        $list['class3'] = $class3;
        $list['updatetime'] = date("Y-m-d H:i:s");
        $list['addtime'] = date("Y-m-d H:i:s");
        $list['content'] = str_replace('\'', '\'\'', $list['content']);
        return $this->insert_list_sql($list);
    }

    /*移动产品*/
    public function list_move($id, $class1, $class2, $class3)
    {
        global $_M;
        $query = "UPDATE {$this->tablename} SET
			class1 = '{$class1}',
			class2 = '{$class2}',
			class3 = '{$class3}'
			WHERE id = '{$id}'";
        DB::query($query);
    }

    /*修改排序*/
    public function list_no_order($id, $no_order)
    {
        global $_M;
        $query = "UPDATE {$this->tablename} SET no_order = '{$no_order}' WHERE id = '{$id}'";
        DB::query($query);
    }

    /*上架下架*/
    public function list_display($id, $display)
    {
        global $_M;
        $query = "UPDATE {$this->tablename} SET displaytype = '{$display}' WHERE id = '{$id}'";
        DB::query($query);
    }

    /*置顶*/
    public function list_top($id, $top)
    {
        global $_M;
        $query = "UPDATE {$this->tablename} SET top_ok = '{$top}' WHERE id = '{$id}'";
        DB::query($query);
    }

    /*推荐*/
    public function list_com($id, $com)
    {
        global $_M;
        $query = "UPDATE {$this->tablename} SET com_ok = '{$com}' WHERE id = '{$id}'";
        DB::query($query);
    }

    /*删除*/
    public function del_list($id, $recycle)
    {
        global $_M;
        if ($recycle) {
            $query = "UPDATE {$this->tablename} SET recycle = '2' WHERE id='{$id}'";
            DB::query($query);
        } else {
            $query = "DELETE FROM {$this->tablename} WHERE id='{$id}'";
            DB::query($query);
        }
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
