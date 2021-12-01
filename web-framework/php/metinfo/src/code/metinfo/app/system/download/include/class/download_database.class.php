<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('base/base_database');

/**
 * 系统标签类
 */
class download_database extends base_database
{
    public function __construct()
    {
        global $_M;
        $this->construct($_M['table']['download']);
    }

    public function table_para()
    {
        return 'id|title|ctitle|keywords|description|content|class1|class2|class3|no_order|wap_ok|img_ok|com_ok|issue|hits|updatetime|addtime|access|top_ok|filename|lang|recycle|displaytype|tag|downloadurl|links|downloadaccess|filesize|text_size|text_color|other_info|custom_info';
    }

    /**
     * 删除
     * @param  string $id id
     * @return bool           删除是否成功
     */
    public function del_by_id($id = '')
    {
        if (parent::del_by_id($id)) {
            load::mod_class('parameter/parameter_database', 'new')->del_list($id, $this->table_to_module($this->table));
            return true;
        } else {
            return false;
        }
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
