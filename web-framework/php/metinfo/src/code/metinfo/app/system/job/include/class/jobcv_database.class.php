<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('base/base_database');

/**
 * 系统标签类
 */

class jobcv_database extends base_database
{
    /**
     * 初始化，继承类需要调用
     */
    public function __construct()
    {
        global $_M;
        $this->construct($_M['table']['cv']);
    }

    public function table_para()
    {
        return 'id|addtime|readok|customerid|jobid|lang|ip';
    }

    public function del_by_id($id = '')
    {
        global $_M;
        $query = "delete from {$_M['table']['plist']} where listid='$id' and lang='{$_M['lang']}' and module='6'";
        DB::query($query);
        $query = "delete  from {$_M['table']['cv']} where id='$id' and lang='{$_M['lang']}'";
        return DB::query($query);
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
