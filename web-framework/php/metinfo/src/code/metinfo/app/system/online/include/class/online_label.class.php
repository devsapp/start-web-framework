<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('news/news_label');

/**
 * news标签类
 */

class online_label extends news_label
{

    public $lang;//语言
    public $databace;

    /**
     * 初始化
     */
    public function __construct()
    {
        global $_M;
        $this->construct('online', '');
    }

    /**
     *
     */
    public function getOnlineList($type = '')
    {
        global $_M;
        $data = $this->database->getList();
        return $this->handle->para_handle($data);
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
