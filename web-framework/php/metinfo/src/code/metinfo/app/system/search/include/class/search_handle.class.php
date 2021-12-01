<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('handle');

/**
 * 留言处理类
 */

class search_handle extends handle
{

    /**
     * 处理留言列表字段
     * @param  string $search_list 留言列表数组
     * @return array                 处理过后的留言列表
     */
    public function para_handle($search_list)
    {
        global $_M;
        foreach ($search_list as $key => $val) {
            $search_list[$key] = $this->one_para_handle($val);
        }
        return $search_list;
    }

    /**
     * 处理设置字段
     * @param  string $search 设置数组
     * @return array           处理过后的栏目图片数组
     */
    public function one_para_handle($search = array())
    {
        global $_M;

        return $search;
    }

    /*搜索关键词*/
    function get_keyword_str($str, $keyword, $getstrlen, $searchtype, $type = 0)
    {
        $str = str_ireplace('<p>', '&nbsp;', $str);
        $str = str_ireplace('</p>', '&nbsp;', $str);
        $str = str_ireplace('<br />', '&nbsp;', $str);
        $str = str_ireplace('<br>', '&nbsp;', $str);
        if ($type) {
            $searchtype = $searchtype != 2 ? 1 : 0;
        } else {
            $searchtype = $searchtype != 1 ? 1 : 0;
        }
        if (mb_strlen($str, 'utf-8') > $getstrlen) {
            $strlen = mb_strlen($keyword, 'utf-8');
            if (function_exists('mb_stripos')) {
                $strpos = mb_stripos($str, $keyword, 0, 'utf-8');
            } else {
                $strpos = mb_strpos($str, $keyword, 0, 'utf-8');
            }
            $halfStr = intval(($getstrlen - $strlen) / 2);
            if ($strpos != "") {
                if ($strpos >= $halfStr) {
                    $str = mb_substr($str, ($strpos - $halfStr), $halfStr, 'utf-8') . $keyword . mb_substr($str, ($strpos + $strlen), $halfStr, 'utf-8');
                } else {
                    $str = mb_substr($str, 0, $strpos, 'utf-8') . $keyword . mb_substr($str, ($strpos + $strlen), ($halfStr * 2), 'utf-8');
                }
            } else {
                $str = mb_substr($str, 0, $getstrlen, 'utf-8');
            }
            $metinfo = $str . '...';
            if ($searchtype) {
                $metinfo = str_ireplace($keyword, '<em style="font-style:normal;">' . $keyword . '</em>', $str) . '...';
            }
            return $metinfo;
        } else {
            $metinfo = $str;
            if ($searchtype) {
                $metinfo = str_ireplace($keyword, '<em style="font-style:normal;">' . $keyword . '</em>', $str);
            }
            return $metinfo;
        }

    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
