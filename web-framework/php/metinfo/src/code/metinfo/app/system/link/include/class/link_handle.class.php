<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('handle');

/**
 * 友情链接处理类
 */

class link_handle extends handle
{

    /**
     * 处理友情链接列表字段
     * @param  string $link_list 友情链接列表数组
     * @return array                 处理过后的友情链接列表
     */
    public function para_handle($link_list)
    {
        global $_M;
        foreach ($link_list as $key => $val) {
            $link_list[$key] = $this->one_para_handle($val);
        }
        return $link_list;
    }

    /**
     * 处理设置字段
     * @param  string $link 设置数组
     * @return array   处理过后的友情链接数组
     */
    public function one_para_handle($link = array())
    {
        global $_M;
        $link['weblogo'] = $this->url_transform(str_replace('../', '', $link['weblogo']));
        $link['nofollow'] = $link['nofollow'] ? "rel=\"nofollow\"" : '';
        return $link;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
