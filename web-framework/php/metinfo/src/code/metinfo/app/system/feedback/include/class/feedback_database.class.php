<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('base/base_database');

/**
 * 反馈数据类
 */

class  feedback_database extends base_database
{
    /**
     * 初始化，继承类需要调用
     */
    public function __construct()
    {
        global $_M;
        $this->construct($_M['table']['feedback']);
    }

    public function table_para()
    {
        return 'id|addtime|class1|fdtitle|fromurl|useinfo|readok|customerid|lang|ip';
    }

    public function get_list_by_class_sql($id = '', $type = '', $order = '')
    {
        $sql = '';
        $sql .= " WHERE class1 = '{$id}' AND readok = 1  ";
        $sql .= "  ORDER BY addtime DESC, id DESC  ";
        return $sql;
    }

    /**
     * 获取反馈字段
     * @param  string $lang 语言
     * @param  string $id 反馈栏目id
     * @return array            反馈字段数组
     */
    public function get_module_para($class1 = '')
    {
        return load::mod_class('parameter/parameter_database', 'new')->get_parameter(8, $class1);
    }

    public function del_flist_by_id($id = '')
    {
        global $_M;
        $query = "delete from {$_M['table']['flist']} where listid='{$id}' and lang ='{$_M['lang']}'";
        return DB::query($query);
    }

    /**
     * 获取开启在线询价的反馈栏目
     * @return array|int
     */
    public function get_inquiry()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['config']} WHERE name = 'met_fd_inquiry' AND value = 1 AND lang = '{$_M['lang']}'";
        $met_fd_inquiry = DB::get_one($query);
        if ($met_fd_inquiry) {
            return $met_fd_inquiry;
        } else {
            return 0;
        }
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
