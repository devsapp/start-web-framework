<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('database');

/**
 * 系统标签类
 */

class ifcolumn_database extends database
{

    /**
     * 初始化，继承类需要调用
     */
    public function __construct()
    {
        global $_M;
        $this->construct($_M['table']['ifcolumn']);
        $this->get_lang('#all');
    }

    public function getLeftColumn()
    {
        global $_M;
        // 会员侧栏添加的数据
        $query = "SELECT * FROM {$_M['table']['ifmember_left']} WHERE lang='{$_M['lang']}' AND  effect = 1 ORDER BY `no`,`own_order`";
        $navigation = DB::get_all($query);
        $data = array();
        foreach ($navigation as $key => $val) {
            if ($val['columnid']) {
                $query = "SELECT * FROM {$_M['table']['column']} WHERE id = '{$val['columnid']}' and lang='{$_M['lang']}'";
                $column = DB::get_one($query);
                $val['foldername'] = $val['foldername'] ? $val['foldername'] : $column['foldername'];
                $val['filename'] = $val['filename'] ? $val['filename'] : 'index.php';
                $list['url'] = "{$_M['url']['site']}{$val['foldername']}/{$val['filename']}";
                $list['title'] = $column['name'];
            } else {
                $list['url'] = "{$_M['url']['site']}{$val['foldername']}/{$val['filename']}";
                $list['title'] = $_M['word'][$val['title']] ? $_M['word'][$val['title']] : $val['title'];
            }
            $list['url'] .= (strpos($list['url'], '?') !== false ? '&' : '?') . "lang={$_M['lang']}";
            $list['no'] = $val['no'];
            $list['target'] = $val['target'];
            $list['own_order'] = $val['own_order'];
            $data[] = $list;
        }
        return $data;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
