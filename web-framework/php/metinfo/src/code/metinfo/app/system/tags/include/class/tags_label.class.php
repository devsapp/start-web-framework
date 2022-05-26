<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('base/base_label');

/**
 * 搜索模块标签类.
 */
class tags_label extends base_label
{
    public $lang; //语言
    public $search_page; //语言

    /**
     * 初始化.
     */
    public function __construct()
    {
        global $_M;
        $this->lang = $_M['lang'];
        $this->construct('search', $_M['config']['met_search_list']);
    }

    /**
     * 内容添加或更新时如果存在tag就处理.
     */
    public function updateTags($tagStr, $module, $class1, $id, $add = 0)
    {
        global $_M;

        $pinyin = load::sys_class('pinyin', 'new');
        $table = $this->getTableName($class1);
        $query = "SELECT tag FROM {$_M['table'][$table]} WHERE id = '{$id}'";
        $content = DB::get_one($query);

        $new = explode('|', $tagStr);
        $old = explode('|', $content['tag']);

        if ($add || $tagStr == $content['tag']) {
            // 如果文章或产品内容是新增的
            $old = array();
        }


        if (trim($content['tag'])) {
            $delete = array_diff($old, $new);
            if ($delete) {
                foreach ($delete as $key => $val) {
                    $query = "SELECT * FROM {$_M['table']['tags']} WHERE module = '{$module}' AND cid = '{$class1}' AND list_id like '%|{$id}|%' AND tag_name = '{$val}' AND lang = '{$_M['lang']}'";

                    $tags = DB::get_all($query);

                    foreach ($tags as $tag) {
                        if ($tag['list_id'] == "|{$id}|") {
                            // 如果tag表只存了id，直接删除
                            $query = "DELETE FROM {$_M['table']['tags']} WHERE id = '{$tag['id']}'";

                            DB::query($query);
                        } else {
                            $newId = str_replace("|{$id}|", '|', $tag['list_id']);
                            $query = "UPDATE {$_M['table']['tags']} SET list_id = '{$newId}' WHERE id = '{$tag['id']}'";

                            DB::query($query);
                        }
                    }
                }
            }
        }

        $create = array_diff($new, $old);
        if ($create) {
            foreach ($create as $val) {
                if (!trim($val)) {
                    continue;
                }
                if ($_M['config']['tag_search_type'] == 'module') {
                    $query = "SELECT * FROM {$_M['table']['tags']} WHERE module = '{$module}' AND tag_name = '{$val}' AND lang = '{$_M['lang']}'";
                } else {
                    $query = "SELECT * FROM {$_M['table']['tags']} WHERE module = '{$module}' AND cid = '{$class1}' AND tag_name = '{$val}' AND lang = '{$_M['lang']}'";
                }

                $tags = DB::get_one($query);
                $tag_pinyin = $pinyin->getpy($val);
                if ($tags) {
                    if ($tags['list_id']) {
                        if (!strstr($tags['list_id'], "|{$id}|")) {
                            $newId = $tags['list_id'] . "{$id}|";
                            $query = "UPDATE {$_M['table']['tags']} SET list_id = '{$newId}',tag_name='{$val}',tag_pinyin='{$tag_pinyin}' WHERE id = '{$tags['id']}'";
                            DB::query($query);
                        }    
                    } else {
                        $data = array(
                            'tag_name' => $val,
                            'tag_pinyin' => $tag_pinyin,
                            'module' => $module,
                            'cid' => $class1,
                            'list_id' => "|{$id}|",
                            'lang' => $_M['lang'],
                        );
                        DB::insert($_M['table']['tags'], $data);
                    }
                } else {
                    $data = array(
                        'tag_name' => $val,
                        'tag_pinyin' => $tag_pinyin,
                        'module' => $module,
                        'cid' => $class1,
                        'list_id' => "|{$id}|",
                        'lang' => $_M['lang'],
                    );

                    DB::insert($_M['table']['tags'], $data);
                }
            }
        }
    }

    // 内容删除时删除对应的TAG
    public function deleteNewsTags($tag)
    {
        global $_M;
        if (!$tag['cid'] || !$tag['listid']) {
            return;
        }
        $table = $this->getTableName($tag['cid']);

        $query = "SELECT * FROM {$_M['table'][$table]} WHERE id = '{$tag['listid']}'";
        $content = DB::get_one($query); //详情内容
        $tags = explode('|', $content['tag']);
        $new = array();
        foreach ($tags as $val) {
            if ($val == $tag['tag_name']) {
                continue;
            }
            $new[] = $val;
        }
        if ($new) {
            $newStr = implode('|', $new);
        } else {
            $newStr = '';
        }
        $query = "UPDATE {$_M['table'][$table]} SET tag = '{$newStr}' WHERE id = '{$tag['listid']}'";
        $row = DB::query($query);
        if (!$row) {
            file_put_contents(PATH_CACHE . 'tags_error.log', $query . "\n" . DB::error() . "\n", FILE_APPEND);
        }
    }

    // 更新TAG标签时处理新闻产品内容中的TAG标签
    public function updateNewsTags($tag)
    {
        global $_M;

        if (!$tag['cid'] || !$tag['listid']) {
            return;
        }
        $table = $this->getTableName($tag['cid']);

        $query = "SELECT tag FROM {$_M['table'][$table]} WHERE id = '{$tag['listid']}'";
        $content = DB::get_one($query);
        if (!$content['tag']) {
            return;
        }

        $new = array();
        foreach (explode('|', $content['tag']) as $val) {
            if ($val == $tag['tag_name']) {
                continue;
            }

            $new[] = $val;
        }

        $new[] = $tag['new_name'];

        $new = array_unique($new);
        $newStr = implode('|', $new);
        $query = "UPDATE {$_M['table'][$table]} SET tag = '{$newStr}' WHERE id = '{$tag['listid']}'";
        $row = DB::query($query);
        if (!$row) {
            file_put_contents(PATH_CACHE . 'tags_error.log', $query . "\n" . DB::error() . "\n", FILE_APPEND);
        }
    }

    // 聚合页面
    public function get_tags_list($data = array(), $lang = '')
    {
        global $_M;
        $lang = $lang ? $lang : $_M['lang'];
        $query = "SELECT * FROM {$_M['table']['tags']} WHERE lang = '{$lang}' ORDER BY sort DESC,id DESC";
        $tags = DB::get_all($query);
        foreach ($tags as &$val) {
            $val['url'] = $this->getTagUrl($val, $val['cid'], $lang);
            $style = '';
            if ($val['tag_size']) {
                $style .= "font-size:{$val['tag_size']}px;";
            }
            if ($val['tag_color']) {
                $style .= "color:{$val['tag_color']};";
            }

            if ($style) {
                $val['_tag_name'] = "<span style=\"{$style}\">{$val['tag_name']}</span>";
            } else {
                $val['_tag_name'] = $val['tag_name'];
            }
        }

        return $tags;
    }

    public function getRelationList($content, $tag_name)
    {
        // 获取TAG标签相关内容
        global $_M;
        $list_id = $content['id'];
        $cid = $content['class1'];
        $column = load::sys_class('label', 'new')->get('column')->get_column_id($cid);
        $module = $column['module'];
        $limit = $_M['config']['tag_show_number'];

        $tags = array();

        if ($_M['config']['tag_show_range']) {
            // 如果是精确关联设置了TAG的内容
            foreach (explode('|', $tag_name) as $val) {
                $query = "SELECT * FROM {$_M['table']['tags']} WHERE list_id like '%|{$list_id}|%' AND tag_name = '{$val}' AND lang = '{$_M['lang']}' order by rand()";
                $tag = DB::get_all($query);
                $tags = array_merge($tags, $tag);
            }
            $data = array();
            $table = $this->getTableName($cid);
            $news = load::sys_class('label', 'new')->get($table);

            $list_id = array();
            foreach ($tags as $val) {
                $list = explode('|', trim($val['list_id'], '|'));
                $list_id = array_merge((array)$list_id, (array)$list);
            }

            $list_id = array_unique($list_id);
            foreach ($list_id as $id) {
                $data[] = $news->handle->one_para_handle(
                    $news->database->get_list_one_by_id($id)
                );
            }

            return $data;
        } else {
            $modules = array(2 => 'news', 3 => 'product', 4 => 'download', 5 => 'img');
            if (!$_M['form']['search']) {
                $_M['form']['search'] = 'search';   //强行开启搜索 拼装搜索sql语句
            }

            $unique_data = array();
            $redata = array();
            $search_name_list = explode('|', $tag_name);
            foreach ($search_name_list as $search_name) {
                $type = load::mod_class('search/search_label.class.php', 'new')->get_search_type(0, $search_name);
                if ($_M['config']['tag_search_type'] == 'module') {
                    $data = load::sys_class('label', 'new')->get($modules[$module])->get_module_list(0, $limit, $type, array('type' => 'array', 'status' => 7));
                } else {
                    $data = load::sys_class('label', 'new')->get($modules[$module])->get_module_list($cid, $limit, $type, array('type' => 'array', 'status' => 7));
                }

                foreach ($data as $one) {
                    if (!isset($unique_data[$one['id']])) {
                        $redata[] = $one;
                    }
                    $unique_data[$one['id']] = $one['id'];
                }
            }
            $_M['form']['search'] = ''; //注销搜索防止动态链接条静态链接失效

            return $redata;
        }
    }

    public function getSqlByTag($tag_name, $class)
    {
        global $_M;
        $tag_name = $this->getTagName($tag_name);
        if ($_M['config']['tag_search_type'] == 'module') {
            $query = "SELECT list_id FROM {$_M['table']['tags']} WHERE module = '{$class['class1']['module']}' AND tag_name ='{$tag_name}'  AND lang = '{$_M['lang']}'";
        } else {
            $query = "SELECT list_id FROM {$_M['table']['tags']} WHERE cid = '{$class['class1']['id']}' AND tag_name ='{$tag_name}'  AND lang = '{$_M['lang']}'";
        }
        $tag = DB::get_all($query);

        $listid = array();
        foreach ($tag as $val) {
            if ($val['list_id']) {
                foreach (explode('|', trim($val['list_id'], '|')) as $id) {
                    if (trim($id)) {
                        $listid[] = $id;
                    }
                }
            }
        }

        $listid = array_unique($listid);
        if (!$listid) {
            if ($_M['config']['tag_show_range']) {
                return ' AND 1!=1';
            }

            return '';
        }

        $listStr = implode(',', $listid);
        $sql = " OR id IN ({$listStr})";

        return $sql;
    }

    public function getTagUrl($tag, $cid = 0, $lang = '')
    {
        global $_M;
        $lang = $lang ? $lang : $_M['lang'];
        $cid = $tag['cid'];
        $lang_site = $_M['langlist']['web'][$lang]['link'];
        if ($lang_site) {
            $site = $_M['langlist']['web'][$lang]['link'];
        } else {
            $site = $_M['url']['web_site'];
        }
        $module = $tag['module'] ? $tag['module'] : 0;
        // 如果是伪静态
        if ($_M['config']['met_pseudo']) {
            $url = 'tag/' . $tag['tag_pinyin'];
            /*if($_M['config']['tag_search_type'] == 'module'){
                $url .= '-' . $module;
            }*/
            if ($lang != $_M['config']['met_index_type']) {
                $url .= '-' . $lang;
            }
        } else {
            if ($_M['config']['tag_search_type'] == 'module') {
                if (!$module) {
                    ##$url = "index.php?stype=0&search=tag&searchword={$tag['tag_pinyin']}&module={$module}&lang={$lang}";
                    $url = "index.php?stype=0&search=tag&searchword={$tag['tag_pinyin']}&lang={$lang}";
                } else {
                    $url = "index.php?stype=0&search=tag&content={$tag['tag_pinyin']}&lang={$lang}";
                }
            } else {
                $url = "index.php?stype=0&search=tag&content={$tag['tag_pinyin']}&lang={$lang}";
            }
        }

        // 如果按栏目搜索
        if ($_M['config']['tag_search_type'] == 'module') {
            if (!$module) {
                return $site . 'search/' . $url;
            } else {
                $modules = array(2 => 'news', 3 => 'product', 4 => 'download', 5 => 'img');
                $folder = $modules[$module];
                return $site . $folder . '/' . $url;
            }
        } else {
            if (!$cid) {
                return $site . 'search/' . $url;
            }

            //语言栏目
            load::sys_class('label', 'new')->get('column')->get_column($lang);
            $column = load::sys_class('label', 'new')->get('column')->get_column_id($cid);
            $folder = $column['foldername'];
            return $site . $folder . '/' . $url;
        }
    }

    // 新闻详情页面获取当前内容的所有TAG标签
    public function getTagsByNews($tagStr, $id)
    {
        global $_M;
        $data = array();
        foreach (explode('|', $tagStr) as $key => $val) {
            $query = "SELECT * FROM {$_M['table']['tags']} WHERE tag_name = '{$val}' AND list_id like '%|{$id}|%' AND lang = '{$_M['lang']}'";
            $tag = DB::get_one($query);
            $data[$key]['url'] = $this->getTagUrl($tag, $tag['cid']);
            $data[$key]['name'] = $val;
        }

        return $data;
    }

    // 不管是名称还是拼音都查一下
    public function getTagName($name)
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['tags']} WHERE (tag_name = '{$name}' OR tag_pinyin = '{$name}') AND lang = '{$_M['lang']}'";
        $tag = DB::get_one($query);
        if (!$tag) {
            return $name;
        }

        return $tag['tag_name'];
    }

    public function getTagPinyin($name)
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['tags']} WHERE (tag_name = '{$name}' OR tag_pinyin = '{$name}') AND lang = '{$_M['lang']}'";
        $tag = DB::get_one($query);
        if (!$tag) {
            return $name;
        }

        return $tag['tag_pinyin'];
    }

    public function getTagInfo($tag_name, $data)
    {
        global $_M;
        $where = '';
        $cid = $data['cid'] ? $data['cid'] : $data['class1'];

        if ($_M['form']['content']) {
            if ($_M['config']['tag_search_type'] == 'column') {
                $where .= "AND cid = '{$cid}'";
            } else {
                $where .= " AND module = '{$data['module']}'";
            }
        }
        if ($data['module'] == 11) {
            // 如果是tag搜索全部
            $where .= ' AND module = 0 AND cid = 0';
        }

        if (!$cid) {
            $where = '';
        }

        $query = "SELECT * FROM {$_M['table']['tags']} WHERE (tag_name = '{$tag_name}' OR tag_pinyin = '{$tag_name}') AND lang = '{$_M['lang']}' {$where}";
        $tag = DB::get_one($query);

        return $tag;
    }

    public function getTableName($cid)
    {
        global $_M;
        ##$column = load::sys_class('label', 'new')->get('column');
        ##$category = $column->get_column_id($cid); //得到当前栏目
        $column_db = load::mod_class('column/column_database', 'new');
        $category = $column_db->get_column_by_id($cid); //得到当前栏目
        $modules = array(2 => 'news', 3 => 'product', 4 => 'img', 5 => 'download');

        return $modules[$category['module']]; //得到表名
    }

    public function get_module_list($id = '', $rows = '', $type = '', $order = '', $para = 0)
    {
        return;
    }
}


# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
