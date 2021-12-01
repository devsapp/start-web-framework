<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('database');

/**
 * 系统标签类
 */

class admin_op
{
    /**
     * @param string $column_id 栏目ID或者app编号
     * @param string $accsess_type  权限类型 s后台栏目 | c栏目 | a应用
     * @param string $type  add增加 | del去除
     */
    public function modify_admin_column_accsess($column_id = '', $accsess_type = 'c', $type = 'add')
    {
        global $_M;
        if (is_numeric($column_id)) {
            $admin_id = $_M['user']['admin_id'];
            $query = "SELECT * FROM {$_M['table']['admin_table']} WHERE id = '{$admin_id}'";
            $admin = DB::get_one($query);
            if ($admin) {
                if ($admin['admin_type'] != 'metinfo' && $admin['admin_group'] != 10000) {
                    $admin_type = explode('-', trim($admin['admin_type'], '-'));
                    $column_sty = $accsess_type . $column_id;
                    if ($type == 'add') {
                        $admin_type[] = $column_sty;
                        $admin_type = array_unique($admin_type);
                    }else{
                        $admin_type = array_unique($admin_type);
                        $key = array_search($column_sty, $admin_type);
                        unset($admin_type[$key]);
                    }
                    $admin_type = implode('-', $admin_type);
                    $admin_type = "-$admin_type-";

                    $query = "UPDATE {$_M['table']['admin_table']} SET `admin_type` = '{$admin_type}' WHERE id = $admin_id";
                    DB::query($query);
                } elseif ($admin['admin_type'] == 'metinfo' && $admin['admin_group'] == 10000) {
                    $query = "SELECT * FROM {$_M['table']['admin_table']} WHERE id != '{$admin_id}'";
                    $admin_list = DB::get_all($query);
                    foreach ($admin_list as $row) {
                        $admin_type = explode('-', trim($row['admin_type'], '-'));
                        $column_sty = $accsess_type . $column_id;
                        if ($type == 'add') {
                            $admin_type[] = $column_sty;
                            $admin_type = array_unique($admin_type);
                        }else{
                            $admin_type = array_unique($admin_type);
                            $key = array_search($column_sty, $admin_type);
                            unset($admin_type[$key]);
                        }
                        $admin_type = implode('-', $admin_type);
                        $admin_type = "-$admin_type-";
                        $query = "UPDATE {$_M['table']['admin_table']} SET `admin_type` = '{$admin_type}' WHERE id = '{$row['id']}'";
                        DB::query($query);
                    }
                }
            }
        }
    }
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
