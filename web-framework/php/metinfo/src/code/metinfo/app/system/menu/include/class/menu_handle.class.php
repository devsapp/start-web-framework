<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('handle');


class menu_handle extends handle
{

    /**
     * @param array $list
     * @return mixed
     */

    public function para_handle($list = array())
    {
        global $_M;
        foreach ($list as $key => $val) {
            $list[$key] = $this->one_para_handle($val);
        }
        return $list;
    }

    /**
     * @param array $list
     * @return array
     */
    public function one_para_handle($list = array())
    {
        global $_M;
        $list['icon'] = $list['icon'];
        if (!strstr($list['url'], 'tel:') && !strstr($list['url'], 'mailto:') && !strstr($list['url'], 'sms:')) {
            $list['url'] = $this->url_transform(str_replace('../', '', $list['url']));
        }
        return $list;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
