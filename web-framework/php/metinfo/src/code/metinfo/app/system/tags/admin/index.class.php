<?php

// MetInfo Enterprise Content Management System
// Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');
load::sys_class('admin');
load::sys_func('file');
class index extends admin
{
    public $pinyin;

    public function __construct()
    {
        global $_M;
        parent::__construct();
        admin_information();
        $this->pinyin = load::sys_class('pinyin', 'new');
    }

    public function doGetParentColumns()
    {
        global $_M;
        $data = array();
        $screen = $_M['form']['screen'];
        if ($_M['config']['tag_search_type'] == 'column') {
            $columns = load::sys_class('label', 'new')->get('column')->get_parent_columns();
            array_unshift($columns, array('id' => 0, 'name' => $_M['word']['full_site']));
            if ($screen) {
                array_unshift($columns, array('id' => -1, 'name' => $_M['word']['cvall']));
            }
            $data['columns'] = $columns;

            return $data;
        }

        if ($_M['config']['tag_search_type'] == 'module') {
            $modules = array();
            $mod = array(2, 3, 4, 5);
            foreach ($mod as $key => $val) {
                $modules[$key]['id'] = $val;
                $modules[$key]['name'] = modname($val);
            }
            array_unshift($modules, array('id' => 0, 'name' => $_M['word']['full_site']));
            if ($screen) {
                array_unshift($modules, array('id' => -1, 'name' => $_M['word']['cvall']));
            }
            $data['modules'] = $modules;
            return $data;
        }
    }

    public function doGetTags()
    {
        global $_M;
        $id = $_M['form']['id'];
        $query = "SELECT * FROM {$_M['table']['tags']} WHERE id = '{$id}'";
        $data = DB::get_one($query);
        $tag_pinyin = $this->pinyin->getpy($data['tag_name']);

        $columns = $this->doGetParentColumns();

        $columns = isset($columns['columns']) ? $columns['columns'] : $columns['modules'];

        if ($data['list_id']) {
            foreach ($columns as  $val) {
                // 如果是在内容页添加的标签不允许编辑
                if ($_M['config']['tag_search_type'] == 'module') {
                    if ($data['module'] == $val['id']) {
                        $data['modules'][] = $val;
                        continue;
                    }
                } else {
                    if ($data['cid'] == $val['id']) {
                        $data['columns'][] = $val;
                        continue;
                    }
                }
            }
        } else {
            if ($_M['config']['tag_search_type'] == 'column') {
                $data['columns'] = $columns;
            } else {
                $data['modules'] = $columns;
            }
        }

        return $data;
    }

    public function doSaveTags()
    {
        global $_M;
        $id = isset($_M['form']['id']) ? $_M['form']['id'] : 0;
        $tag_name = $_M['form']['tag_name'];

        if (!preg_match('/^[<\x{4e00}-\x{9fa5}>a-z-A-Z_0-9\s]+$/u', $tag_name)) {
            $this->error($_M['word']['admin_tag_setting9']);
        }

        if ($_M['form']['tag_pinyin']) {
            $tag_pinyin = $_M['form']['tag_pinyin'];
            if (!preg_match('/^[a-zA-Z0-9_<\x{4e00}-\x{9fa5}>]+$/u', $tag_pinyin)) {
                $this->error($_M['word']['admin_tag_setting10']);
            }
        } else {
            $tag_pinyin = $this->pinyin->getpy($tag_name);
        }

        $data = array(
            'tag_name' => $tag_name,
            'tag_pinyin' => $tag_pinyin,
            'tag_color' => $_M['form']['tag_color'],
            'tag_size' => $_M['form']['tag_size'],
            'sort' => $_M['form']['sort'],
            'title' => $_M['form']['title'],
            'keywords' => $_M['form']['keywords'],
            'description' => $_M['form']['description'],
            'lang' => $_M['lang'],
        );

        if (isset($_M['form']['cid'])) {
            $data['cid'] = $_M['form']['cid'];
            if (!$data['module'] && !$id) {
                $column = load::sys_class('label', 'new')->get('column')->get_column_id($data['cid']);
                $data['module'] = $column['module'];
            }
        }

        if (isset($_M['form']['module'])) {
            $data['module'] = $_M['form']['module'];
            if (!$data['cid'] && !$id) {
                // 添加的时候按模块设置时自动选一个一级栏目
                $query = "SELECT * FROM {$_M['table']['column']} WHERE module = '{$data['module']}' AND bigclass = 0 AND lang = '{$_M['lang']}'";

                $column = DB::get_one($query);

                $data['cid'] = $column['id'];
            }
        }

        if ($_M['config']['tag_search_type'] == 'column') {
            $where = " AND cid = '{$data['cid']}'";
        }

        if ($_M['config']['tag_search_type'] == 'module') {
            $where = " AND module = '{$data['module']}'";
        }
        $database = load::mod_class('tags/tags_database', 'new');
        $tag_pinyin = $database->getTagPinyin($tag_pinyin, $_M['form']['module'], $id);
        if (!$id) {
            $data['tag_pinyin'] = $tag_pinyin;
            $query = "SELECT * FROM {$_M['table']['tags']} WHERE (tag_name = '{$tag_name}' OR tag_pinyin = '{$tag_pinyin}')  AND lang = '{$_M['lang']}' {$where}";

            $has = DB::get_one($query);
            if ($has) {
                if ($has['tag_name'] == $tag_name) {
                    $this->error("当前聚合范围已经存在标签名称“{$tag_name}”");
                }
                if ($has['tag_pinyin'] == $tag_pinyin) {
                    $this->error("当前聚合范围已经存在静态页面名称“{$tag_pinyin}”");
                }
            }

            $row = DB::insert($_M['table']['tags'], $data);
            if (!$row) {
                $this->error(DB::error());
            }
        } else {
            if ($tag_pinyin != $data['tag_pinyin']) {
                $this->error("当前聚合范围已经存在静态页面名称“{$data['tag_pinyin']}”");
            }
            $query = "SELECT * FROM {$_M['table']['tags']} WHERE id = '{$id}'";
            $tag = DB::get_one($query);

            if ($tag['cid'] && $tag['list_id'] && $tag['tag_name'] != $data['tag_name']) {
                $tags = load::sys_class('label', 'new')->get('tags');
                $tag['new_name'] = $data['tag_name'];
                foreach (explode('|', trim($tag['list_id'], '|')) as $listid) {
                    $tag['listid'] = $listid;
                    $tags->updateNewsTags($tag);
                }
                // 如果这个标签是从内容页面添加的，就需要同步更新内容的tag
            }
            $sql = get_sql($data);
            $query = "UPDATE {$_M['table']['tags']} SET {$sql} WHERE id = '{$id}'";
            $row = DB::query($query);
            if (!$row) {
                $this->error(DB::error());
            }
        }

        if ($_M['config']['met_sitemap_auto']) {//自动更新网站地图
            load::sys_class('label', 'new')->get('seo')->site_map();
        }

        $this->success($data, $_M['word']['jsok']);
    }

    public function doGetTagsList()
    {
        global $_M;

        $where = "lang='{$_M['lang']}'";
        $keyword = isset($_M['form']['keyword']) ? $_M['form']['keyword'] : '';
        $where .= $keyword ? "AND tag_name LIKE '%{$keyword}%'" : '';

        if ($_M['form']['source']) {
            if ($_M['form']['source'] == 1) {
                $where .= " AND list_id != ''";
            } else {
                $where .= " AND (list_id = '' OR list_id IS NULL)";
            }
        }

        if ($_M['form']['cid'] > 0) {
            if ($_M['config']['tag_search_type'] == 'column') {
                $where .= " AND cid = {$_M['form']['cid']}";
            } else {
                $where .= " AND module = {$_M['form']['cid']}";
            }
        }

        if ($_M['form']['cid'] == 0) {
            $where .= ' AND cid = 0';
        }
        $table = load::sys_class('tabledata', 'new');
        $array = $table->getdata($_M['table']['tags'], '*', $where, 'sort DESC,id DESC');
        $columns = $this->doGetParentColumns();
        $modules = isset($columns['columns']) ? $columns['columns'] : $columns['modules'];
        array_unshift($modules, array('id' => -1, 'name' => $_M['word']['cvall']));

        $columns = array();
        foreach ($modules as $key => $val) {
            $columns[$val['id']] = $val['name'];
        }

        $tags = load::sys_class('label', 'new')->get('tags');
        if ($_M['config']['tag_search_type'] == 'column') {
            $field = 'cid';
        } else {
            $field = 'module';
        }
        foreach ($array as &$val) {
            $val['url'] = $tags->getTagUrl($val, $val['cid']);
            $val['cid'] = $val[$field] ? $columns[$val[$field]] : $_M['word']['full_site'];
            $val['module'] = $val[$field] ? $columns[$val[$field]] : $_M['word']['full_site'];
            $val['source'] = $val['list_id'] ? $_M['word']['content'] : $_M['word']['add_manully'];
        }
        unset($val);
        $table->rdata($array);
    }

    public function doDelTags()
    {
        global $_M;
        $tags = load::sys_class('label', 'new')->get('tags');
        $ids = $_M['form']['allid']?explode(',', $_M['form']['allid']):$_M['form']['id'];
        if(!is_array($ids)){
            $ids=array($ids);
        }
        foreach ($ids as $id) {
            $query = "SELECT * FROM {$_M['table']['tags']} WHERE id = '{$id}'";
            $tag = DB::get_one($query);
            if ($tag) {
                foreach (explode('|', trim($tag['list_id'], '|')) as  $listid) {
                    if (!$listid) {
                        continue;
                    }
                    $tag['listid'] = $listid;
                    $tags->deleteNewsTags($tag);
                }
            }
            $query = "DELETE FROM {$_M['table']['tags']} WHERE id = '{$id}'";
            DB::query($query);
        }
        $this->success($id, $_M['word']['jsok']);
    }
}

// This program is an open source system, commercial use, please consciously to purchase commercial license.
// Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
