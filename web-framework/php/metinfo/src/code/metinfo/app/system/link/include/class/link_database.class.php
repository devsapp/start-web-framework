<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('base/base_database');

/**
 * 友情链接数据类
 */

class link_database extends base_database
{

    /**
     * 获取友情链接列表数组
     * @param  string $id 友情链接栏目id
     * @param  string $com_ok 推荐
     * @param  string $start limit开始条数
     * @param  string $rows limit取的条数
     * @return array           友情链接列表数组
     */
    public function __construct()
    {
        global $_M;
        $this->construct($_M['table']['link']);
    }

    public function get_link_list_by_lang($lang, $com_ok = 0, $start = 0, $rows = '', $classnow = '')
    {
        global $_M;
        $where = "WHERE lang = '{$lang}' AND show_ok = 1 ";
        $where .= $com_ok ? " AND com_ok = 1 " : '';
        if ($classnow) {
            $where .= "AND (module LIKE '%,{$classnow},%' OR module='')";
        }
        $limit = $rows ? " LIMIT {$start} , {$rows} " : '';
        $order = " ORDER BY com_ok DESC , orderno DESC, id DESC ";
        $query = "SELECT * FROM {$_M['table']['link']} {$where} {$order} {$limit}";
        return DB::get_all($query);
    }

    public function table_para()
    {
        return 'id|webname|weburl|weblogo|link_type|info|contact|orderno|com_ok|show_ok|addtime|lang|nofollow';
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
