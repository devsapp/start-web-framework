<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('handle');

/**
 * banner标签类
 */

class base_handle extends handle
{
    public $contents_page_name;//模块类型

    /**
     * 初始化，继承类需要调用
     */
    public function construct($contents_page_name)
    {
        global $_M;
        $this->contents_page_name = $contents_page_name;
    }

    /**********数据处理************/
    /**
     * 处理list数组
     * @param  string $list 处理列表数组
     * @return array         处理过后数组
     */
    public function para_handle($list)
    {
        global $_M;
        foreach ($list as $key => $val) {
            $list[$key] = $this->one_para_handle($val);
        }
        return $list;
    }

    /**
     * 处理list数组
     * @param  string $content 内容数组
     * @return array            处理过后数组
     */
    public function one_para_handle($content = array())
    {
        global $_M;
        if ($content) {
            //$content['url'] = $this->url_transform($this->contents_page_name . '/show' . $this->contents_page_name . '.php?lang=' . $content['lang'] . '&id=' . $content['id']);
            $content['url'] = $this->get_content_url($content);
            if ($content['imgurl']) $content['imgurl'] = $this->url_transform($content['imgurl']);
            if ($content['imgurls']) $content['imgurls'] = $this->url_transform($content['imgurls']);
            if ($content['content']) $content['content'] = $this->replace_relative_url($content['content']);
            $content['original_updatetime'] = $content['updatetime'];
            $content['updatetime'] = date($_M['config']['met_listtime'], strtotime($content['updatetime']));
            $content['original_addtime'] = $content['addtime'];
            $content['addtime'] = date($_M['config']['met_listtime'], strtotime($content['addtime']));
            if ($content['new_windows']) {
                $content['target'] = 'target="_blank"';
            } else {
                $content['target'] = '';
            }

            if ($content['other_info'] == '') {
                $content['other_info'] = $content['keywords'];
            }

            if ($content['custom_info'] == '') {
                #$content['custom_info'] = $content['description'];
            }

            if ($_M['form']['id']) {
                $list = 0;
            } else {
                $list = 1;
            }

            if ($_M['form']['ajax']) {
                $src = 'data-src';
                $ajax = '&ajax=1';
            } else {
                $src = 'src';
            }

            if (($_M['config']['met_webhtm'] && $_M['form']['html_filename'] && $_M['form']['metinfonow'] == $_M['config']['met_member_force']) || $_M['config']['met_pseudo'] == 1) {//生成静态页
                $content['hits'] = "<script type='text/javascript' class='met_hits' data-hits='{$content['hits']}' {$src}=\"{$_M['url']['site']}hits/?lang={$_M['lang']}&type={$this->contents_page_name}&vid={$content['id']}&list={$list}{$ajax}\"></script>";
            }
            //发布人 老模板兼容
            $content['issue'] = $content['publisher'];
            //图片列表处理
            $content = self::one_para_img($content);
            //添加样式
            $content = self::addStyle($content);
        }
        return $content;
    }

    /**
     * 图片列表处理
     * @param array $content
     * @return array
     */
    public function one_para_img($content = array())
    {
        global $_M;
        //图片处理
        $displayimg = stringto_array($content['displayimg'], '*', '|');
        list($x, $y) = explode('x', $content['imgsize']);
        $displayimgs[] = array(
            'title' => $content['title'],
            'img' => $content['imgurl'],
            'x' => $x,
            'y' => $y
        );

        foreach ($displayimg as $key => $val) {
            if ($val[1]) {
                list($x, $y) = explode('x', $val['2']);
                $displayimgs[] = array(
                    'title' => $val[0],
                    'img' => $this->url_transform($val[1]),
                    'x' => $x,
                    'y' => $y
                );
            }
        }
        $content['displayimgs'] = $displayimgs;

        return $content;
    }

    /**
     * 添加系统样式
     * @param array $content
     * @return array
     */
    public function addStyle($content = array())
    {
        global $_M;
        //title
        $title = "<span style='";
        if ($content['text_size']) {
            $title .= "font-size:{$content['text_size']}px ;";
        }
        if ($content['text_color']) {
            $title .= "color:{$content['text_color']} ;";
        }
        $title .= "'>" . $content['title'] . "</span>";
        $content['_title'] = $title;

        //description
        /*$desc = "<span style='";
        if ($content['desc_size']) {
            $desc .= "font-size:{$content['desc_size']}px ;";
        }
        if ($content['desc_color']) {
            $desc .= "color:{$content['desc_color']} ;";
        }
        $desc .= "'>" . $content['description'] . "</span>";
        $content['_description'] = $desc;*/

        return $content;
    }

    /**********URL处理************/
    /**
     * 返回分页url
     * @param string $id 栏目id
     * @param string $type url 类型 默认空
     * @return string
     */
    public function get_page_url($id = '', $type = '')
    {
        $c = load::sys_class('label', 'new')->get('column')->get_column_id($id);
        $class = load::sys_class('label', 'new')->get('column')->get_class123_no_reclass($id);
        $url = $this->get_list_page_url($class['class1']['id'], $class['class2']['id'], $class['class3']['id'], $c['foldername'], $this->contents_page_name, $c['filename'], $c['lang'], $type);
        return $url;
    }

    /**
     * 返回内容页url
     * @param array $content 内容详情
     * @param string $type url 类型 默认空
     * @return array|string rul
     */
    public function get_content_url($content = array(), $type = '')
    {
        global $_M;
        if ($content['links']) {
            if ($content['access'] != 0) {
                if ($content['access']) {
                    $url = urlencode(load::sys_class('auth', 'new')->encode($content['links']));
                    $groupid = urlencode(load::sys_class('auth', 'new')->encode($content['access']));
                    $links = "{$_M['url']['entrance']}?m=include&c=access&a=dodown&lang={$_M['lang']}&url={$url}&groupid={$groupid}";
                }
                return $links;
            } else {
                return $content['links'];
            }
        } else {
            $c = load::sys_class('label', 'new')->get('column')->get_column_id($content['class1']);
            $addtime = $content['original_addtime'] ? $content['original_addtime'] : $content['addtime'];
            $url = $this->url_add_contents_filename($c['foldername'], $this->contents_page_name, $content['id'], $content['filename'], $content['lang'], $addtime, $type);
            return $url;
        }
    }

    public function url_add_contents_filename($column_file, $module_name, $id, $filename, $lang, $addtime, $type = '')
    {
        global $_M;

        $type = $this->url_type($type, 0);

        $url = '';
        $url .= $column_file . '/';
        $url .= $this->url_add_content_filename($type, $id, $column_file, $module_name, $addtime, $filename);
        $url .= $this->url_add_id($type, $id, $column_file, $module_name, $filename);
        $url .= $this->url_add_lang($type, $lang);
        $url .= $this->url_add_suffix($type);
        $url = $this->url_transform($url, $lang);
        if ($type == 1) {
            $url = str_replace('.php&', '.php?', $url);
        }
        return $url;
    }

    public function get_list_page_url($column_class1, $column_class2, $column_class3, $column_file, $module_name, $filename, $lang, $type = '')
    {
        global $_M;
        $url = '';

        if ($_M['form']['search'] == 'tag') {
            // 标签搜索的分页
            $data = array('cid' => $column_class1, 'module' => load::sys_class('handle', 'new')->file_to_mod($module_name));
            $tags = load::sys_class('label', 'new')->get('tags');
            $tag = $tags->getTagInfo($_M['form']['content'], $data);
            $url = $tags->getTagUrl($tag, $column_class1);

            if ($_M['config']['met_pseudo']) {
                $type = 2;
            } else {
                $type = 1;
            }

            $url .= $this->url_add_page($type);

        } else {
            $url .= $column_file . '/';
            $type = $this->url_type($type, 2);
            $url .= $this->url_add_list_filename($type, $filename, $column_file, $module_name);
            $url .= $this->url_add_list_class($type, $column_class1, $column_class2, $column_class3, $filename);
            $url .= $this->url_add_page($type);
            $url .= $this->url_add_lang($type, $lang);
            $url .= $this->url_add_suffix($type);
        }

        $url = $this->url_transform($url, $lang);
        if ($type == 1) {
            $url = str_replace('.php&', '.php?', $url);
        }
        return $url;
    }

    public function url_add_page($type)
    {
        global $_M;
        switch ($type) {
            case '1'://动态
                $pname = "&page=#page#";
                break;
            case '2'://伪静态
                $pname = "-#page#";
                break;
            case '3'://静态
                $pname = "_#page#";
                break;
        }
        return $pname;
    }

    public function url_add_lang($type, $lang)
    {
        global $_M;
        $lname = '';
        if (($lang && $lang != $_M['config']['met_index_type'])) {
            switch ($type) {
                case '1'://动态
                    $lname = "&lang={$lang}";
                    break;
                case '2'://伪静态
                    $lname = "-{$lang}";
                    break;
                case '3'://静态
                    $lname = "_{$lang}";
                    break;
            }
        } else {
            if ($type == 2) {
                if ($_M['config']['met_index_type'] != $lang) {
                    $lname = "-{$lang}";
                } else {
                    if ($_M['config']['met_defult_lang']) {
                        $lname = "-{$lang}";
                    }
                }
            } else {
                return '';
            }
        }
        return $lname;
    }

    public function url_add_list_filename($type, $filename, $column_file, $module_name)
    {
        global $_M;
        switch ($type) {
            case '1'://动态
                $fname = 'index.php';
                break;
            case '2'://伪静态
                if ($filename) {
                    $fname = 'list-' . $filename;
                } else {
                    $fname = 'list';
                }
                break;
            case '3'://静态
                if ($filename) {
                    $fname = $filename;
                } else {
                    if ($_M['config']['met_htmlistname']) {
                        $fname = $column_file;
                    } else {
                        $fname = $module_name;
                    }
                }
                break;
        }
        return $fname;
    }

    public function url_add_suffix($type)
    {
        global $_M;
        switch ($type) {
            case '1'://动态
                $sname = '';
                break;
            case '2'://伪静态
                $sname = '.html';
                break;
            case '3'://静态
                $sname = '.' . $_M['config']['met_htmtype'];
                break;
        }
        return $sname;
    }

    public function url_add_list_class($type, $column_class1, $column_class2, $column_class3, $filename)
    {
        global $_M;
        if ($_M['form']['search'] == 'tag') {
            return;
        }
        $idname = '';
        switch ($type) {
            case '1'://动态
                $idname = $column_class1 ? "?class1=$column_class1" : $idname;
                $idname = $column_class2 ? "?class2=$column_class2" : $idname;
                $idname = $column_class3 ? "?class3=$column_class3" : $idname;
                break;
            case '2'://伪静态
                $idname = $column_class1 ? "-$column_class1" : $idname;
                $idname = $column_class2 ? "-$column_class2" : $idname;
                $idname = $column_class3 ? "-$column_class3" : $idname;
                if ($filename) $idname = '';
                break;
            case '3'://静态
                if ($_M['config']['met_listhtmltype']) {
                    $class_now = $column_class3 ? $column_class3 : ($column_class2 ? $column_class2 : $column_class1);
                    $idname = "_{$class_now}";
                } else {
                    $idname .= $column_class1 ? "_{$column_class1}" : '';
                    $idname .= $column_class2 ? "_{$column_class2}" : '';
                    $idname .= $column_class3 ? "_{$column_class3}" : '';
                }
                if ($filename) $idname = '';
                break;
        }
        return $idname;
    }

    public function url_add_content_filename($type, $id, $column_file, $module_name, $addtime, $filename)
    {
        global $_M;
        $cdname = '';
        switch ($type) {
            case '1'://动态
                $cdname = "show" . $module_name . '.php';
                break;
            case '2'://伪静态
                if ($filename) {
                    $cdname = $filename;
                }
                break;
            case '3'://静态
                if ($filename) {
                    $cdname = $filename;
                } else {
                    switch ($_M['config']['met_htmpagename']) {
                        case 0:
                            $cdname = 'show' . $module_name;
                            break;
                        case 1:
                            $cdname = date('Ymd', strtotime($addtime));
                            break;
                        case 2:
                            $cdname = $column_file;
                            break;
                        case 3:
                            $cdname = '';
                            break;
                    }
                }
                break;
        }
        return $cdname;
    }

    public function url_add_id($type, $id, $column_file, $module_name, $filename)
    {
        global $_M;
        $idname = '';
        switch ($type) {
            case '1'://动态
                $idname = "?id=$id";
                break;
            case '2'://伪静态
                if ($filename) {
                    $idname = '';
                } else {
                    $idname = $id;
                }
                break;
            case '3'://静态
                if ($filename) {
                    $idname = '';
                } else {
                    $idname = $id;
                }
                break;
        }
        return $idname;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
