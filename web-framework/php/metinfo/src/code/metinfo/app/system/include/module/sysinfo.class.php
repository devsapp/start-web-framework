<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');
load::sys_class('web');

class sysinfo extends web
{
    public function __construct()
    {
        parent::__construct();
    }

    public function doGetinfo()
    {
        global $_M;
        $redata = array();
        $redata['metcms_v'] = $_M['config']['metcms_v'];
        $redata['time'] = time();
        $redata['microtime'] = microtime();
        $this->success($redata);
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>