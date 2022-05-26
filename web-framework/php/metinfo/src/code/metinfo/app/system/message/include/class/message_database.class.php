<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('base/base_database');


/**
 * 留言数据类
 */
class  message_database extends base_database
{
    /**
     * 初始化，继承类需要调用
     */
    public function __construct()
    {
        global $_M;
        $this->construct($_M['table']['message']);
    }

    public function table_para()
    {
        return 'id|addtime|useinfo|access|customerid|lang|ip|imgname|checkok|readok';
    }

    public function get_list_by_class_sql($id = '', $type = '', $order = '')
    {
        $confival = $this->get_config_val('met_msg_show_type', $id);//留言审核开关
        $sql = '';
        if ($confival) {
            $sql .= " {$this->langsql} and checkok = 1";
        } else {
            $sql .= " {$this->langsql}";
        }
        $sql .= " ORDER BY addtime DESC, id DESC ";
        return $sql;
    }

    /**
     * 获取留言字段
     * @param  string $id 留言栏目id
     * @return array            留言字段数组
     */
    public function get_module_para()
    {
        return load::mod_class('parameter/parameter_database', 'new')->get_parameter($this->mod);
    }

    public function get_config_val($name = '', $columnid = '')
    {
        global $_M;
        $query = "select * from {$_M['table']['config']} where name = '$name' and columnid ='{$columnid}' and lang='{$_M['lang']}'";
        $config = DB::get_one($query);
        return $config['value'];
    }

    function get_message_columnid()
    {
        global $_M;
        $message = DB::get_one("select * from {$_M['table']['column']} where module = 7 and lang ='{$_M['lang']}'");
        return $message['id'];
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
