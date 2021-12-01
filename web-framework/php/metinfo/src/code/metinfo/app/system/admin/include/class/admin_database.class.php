<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('database');

/**
 * 系统标签类
 */

class admin_database extends database
{

    public function __construct()
    {
        global $_M;
        $this->construct($_M['table']['admin_table']);
    }

    public function table_para()
    {
        return 'id|admin_type|admin_id|admin_pass|admin_name|admin_sex|admin_tel|admin_mobile|admin_email|admin_qq|admin_msn|admin_taobao|admin_introduction|admin_login|admin_modify_ip|admin_modify_date|admin_register_date|admin_approval_date|admin_ok|admin_op|admin_issueok|admin_group|companyname|companyaddress|companyfax|usertype|checkid|companycode|companywebsite|cookie|admin_shortcut|lang|content_type|langok|admin_login_lang|admin_check';
    }

    public function get_one_by_admin_id($username)
    {
        $query = "SELECT * FROM {$this->table} WHERE admin_id = '$username'";
        return DB::get_one($query);
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
