<?php

// MetInfo Enterprise Content Management System
// Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('database');

/**
 * 搜索标签类.
 */
class tags_database extends database
{
    public function __construct()
    {
        global $_M;
        $this->construct($_M['table']['tags']);
    }

    public function getTagsInfo($tag, $tag_pinyin, $class1, $id)
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['tags']} WHERE tag_name='{$tag}' AND tag_pinyin='{$tag_pinyin}' AND list_id='{$id}' AND `cid`='{$class1}' AND lang='{$_M['lang']}'";
        $data = db::get_one($query);

        return $data;
    }

    public function getTagPinyin($tag_pinyin, $module, $id = 0)
    {
        global $_M;

        $query = "SELECT * FROM {$_M['table']['tags']} WHERE tag_pinyin = '{$tag_pinyin}' AND lang = '{$_M['lang']}' AND module = '{$module}'";
        if ($id) {
            $query .= " AND id != {$id}";
        }
        $res = DB::get_one($query);

        if ($res) {
            $num = substr($tag_pinyin, -1, 1);
            if (strstr(substr($tag_pinyin, -2, 1), '_') && is_numeric($num)) {
                $suffix = substr($tag_pinyin, -2, 2);
                ++$num;
                $tag_pinyin = str_replace($suffix, '_'.$num, $tag_pinyin);
            } else {
                $tag_pinyin = $tag_pinyin.'_1';
            }

            return $this->getTagPinyin($tag_pinyin, $module);
        } else {
            return $tag_pinyin;
        }
    }

    public function getAlltags()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['tags']} WHERE lang = '{$_M['lang']}' GROUP BY tag_name";
        $tags = DB::get_all($query);

        return $tags;
    }
}

// This program is an open source system, commercial use, please consciously to purchase commercial license.
// Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
