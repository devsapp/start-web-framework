<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.


defined('IN_MET') or exit('No permission');

load::mod_class('base/base_database');

/**
 * 系统标签类.
 */
class news_database extends base_database
{
    public $multi_column = 0; //是否支持多栏目

    public function __construct()
    {
        global $_M;
        $this->construct($_M['table']['news']);
    }

    //字段注册
    public function table_para()
    {
        return 'id|title|ctitle|keywords|description|content|class1|class2|class3|no_order|wap_ok|img_ok|imgurl|imgurls|com_ok|issue|hits|updatetime|addtime|access|top_ok|filename|lang|recycle|displaytype|tag|links|text_size|text_color|other_info|custom_info|publisher';
    }

}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.