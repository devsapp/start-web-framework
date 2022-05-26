<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');
defined('IN_ADMIN') or exit('No permission');

load::sys_class('admin');

class index extends admin
{
    public function __construct()
    {
        global $_M;
        parent::__construct();

        $this->weixinapi = load::mod_class('weixin/weixinapi', 'new');
        $this->weixinreply = load::mod_class('weixin/weixinreply', 'new');
    }

    public function doAapiCheck()
    {
        global $_M;
        $res = $this->weixinapi->apiCheck();
        dump($res);
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
