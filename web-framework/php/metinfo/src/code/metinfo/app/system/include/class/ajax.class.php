<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

load::sys_func('common');

/**
 * Class ajax
 */
class ajax extends common
{
    /**
     * ajax constructor.
     */
    public function __construct()
    {
        global $_M;
        $this->load_form();
    }

    public function __destruct()
    {
        global $_M;
        DB::close();
        exit;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>