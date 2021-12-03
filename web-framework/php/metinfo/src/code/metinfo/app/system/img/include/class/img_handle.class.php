<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('base/base_handle');

class img_handle extends base_handle
{
    public function __construct()
    {
        global $_M;
        $this->construct('img');
    }

    public function one_para_handle($content = array())
    {
        return parent::one_para_handle($content);
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
