<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.


defined('IN_MET') or exit('No permission');

class tag_handle
{

    public function __construct()
    {
        global $_M;
    }

    protected function attrdata($params, $ui, $data)
    {
        global $_M;
        $this_data = array();
        $params = json_decode(base64_decode($params), true);
        $this_data['attr'] = array();
        foreach ($params as $key => $val) {
            if ($val[0] == '$') {
                eval("\$this_data['attr'][\$key]=$val;");
            } else {
                $this_data['attr'][$key] = $val;
            }
        }

        $parseFile = PATH_ALL_APP . "met_template/include/class/parse.class.php";
        require_once $parseFile;
        $compile = new parse;
        $this_data['g'] = $compile->list_public_config();
        $this_data['c'] = $compile->replace_sys_config();
        $this_data['word'] = $_M['word'];
        $this_data['url'] = $_M['url'];

        return $this_data;
    }

    protected function get_list($attr)
    {
        $new_result = array();
        if ($attr['cid']) {
            if ($attr['list_type']) {
                $result = load::sys_class('label', 'new')->get('tag')->get_list($attr['cid'], $attr['num'], $attr['type'], $attr['order'], $attr['para']);
            } else {
                $result = load::sys_class('label', 'new')->get('column')->get_column_by_type('son', $attr['cid'], $attr['num']);
            }
            foreach ($result as $key => $item) {
                if (!$attr['list_type']) {
                    if ($item['display'] == 1) {
                        continue;
                    }
                    $list_attr = array(
                        'column' => $item,
                        'page_data' => $attr['page_data'],
                        'hide' => $attr['hide'],
                        'class' => $attr['class']
                    );
                    $item = self::column_handle($list_attr);
                }
                $item = self::list_handle($result, $item, $key);
                $new_result[] = $item;
            }
        }

        return $new_result;
    }

    protected function get_column($cid, $page_data)
    {
        $columnLabel = load::sys_class('label', 'new')->get('column');
        $column = $columnLabel->get_column_id($cid);
        $list_attr = array(
            'column' => $column,
            'page_data' => $page_data
        );
        $column = $this->column_handle($list_attr);

        return $column;
    }

    protected function column_handle($attr)
    {
        global $_M;
        $column = $attr['column'];
        if ($attr['page_data']['module'] == 10001) {
            $column['url'] = str_replace(array('../', $_M['url']['site']), '', $column['url']);
            $column['content'] = str_replace(array('../', $_M['url']['site']), '', $column['content']);
            $column['indeximg'] = str_replace(array('../', $_M['url']['site']), '', $column['indeximg']);
            $column['columnimg'] = str_replace(array('../', $_M['url']['site']), '', $column['columnimg']);
            if (substr(trim($column['icon']), 0, 1) == 'm' || substr(trim($column['icon']), 0, 1) == '') {
                $column['icon'] = 'icon fa-pencil-square-o ' . $column['icon'];
            }
        }
        if ($attr['page_data']['module'] == 404) {
            $column['url'] = str_replace(array('../', $_M['url']['web_site']), '', $column['url']);
            if (!strstr($column['url'], 'http')) {
                $column['url'] = $_M['url']['web_site'] . $column['url'];
            }
            $column['content'] = str_replace(array('../', $_M['url']['web_site']), '', $column['content']);
            $column['indeximg'] = str_replace(array('../', $_M['url']['web_site']), '', $column['indeximg']);
            $column['columnimg'] = str_replace(array('../', $_M['url']['web_site']), '', $column['columnimg']);
        }
        if ($attr['class']) {
            if ($attr['page_data']['classnow'] == $column['id'] || $attr['page_data']['class1'] == $column['id'] || $attr['page_data']['class2'] == $column['id'] || $attr['page_data']['releclass'] == $column['id']) {
                $column['class'] = $attr['class'];
            } else {
                $column['class'] = '';
            }
        }
        if ($attr['hide']) {
            $hides = $attr['hide'];
            $hide = explode("|", $hides);
            if (in_array($column['name'], $hide)) {
                unset($column['id']);
                $column['hide'] = $hide;
                $column['sub'] = 0;
            }
        }

        return $column;
    }

    protected function list_handle($result, $item, $key)
    {
        $count = is_array($result) ? count($result) : 0;
        $item['urlnew'] = $item['new_windows'] ? "target='_blank'" : "target='_self'";
        $item['urlnew'] = $item['nofollow'] ? $item['urlnew'] . " rel='nofollow'" : $item['urlnew'];
        $item['_first'] = $key == 0 ? true : false;
        $item['_last'] = $key == ($count - 1) ? true : false;

        return $item;
    }
}


# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>