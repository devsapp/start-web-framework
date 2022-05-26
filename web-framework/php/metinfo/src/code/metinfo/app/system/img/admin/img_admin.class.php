<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('news/admin/news_admin');

class img_admin extends news_admin
{
    public $shop;
    public $module;

    function __construct()
    {
        global $_M;
        parent::__construct();
        $this->module = 5;
        $this->database = load::mod_class('img/img_database', 'new');

    }

    /**
     * 增加
     */
    function doadd()
    {
        global $_M;
        return parent::doadd();
    }

    function doaddsave()
    {
        global $_M;
        return parent::doaddsave();
    }

    public function insert_list($list = array())
    {
        global $_M;;
        return parent::insert_list($list);
    }

    public function insert_list_sql($list = array())
    {
        global $_M;
        $list['content1'] = $list['content1'] ?  : '';
        $list['content2'] = $list['content2'] ?  : '';
        $list['content3'] = $list['content3'] ?  : '';
        $list['content4'] = $list['content4'] ?  : '';
        $list['contentinfo'] = $list['contentinfo'] ?  : '';
        $list['contentinfo1'] = $list['contentinfo1'] ?  : '';
        $list['contentinfo2'] = $list['contentinfo2'] ?  : '';
        $list['contentinfo3'] = $list['contentinfo3'] ?  : '';
        $list['contentinfo4'] = $list['contentinfo4'] ?  : '';
        return parent::insert_list_sql($list);
    }

    /**
     *系统属性
     */
    public function dopara()
    {
        return parent::dopara();
    }

    /*产品编辑*/
    function doeditor()
    {
        global $_M;
        $list = $this->database->get_list_one_by_id($_M['form']['id']);
        $list = $this->listAnalysis($list);
        $list['imgurl_all'] = $list['imgurl'];
        $displayimg = explode("|", $list['displayimg']);
        foreach ($displayimg as $val) {
            $img = explode("*", $val);
            $list['imgurl_all'] .= '|' . $img[1];
        }
        $list['imgurl_all'] = trim($list['imgurl_all'], '|');
        $access_option = $this->access_option($list['access']);
        $column_list = $this->_columnjson();

        $redata['list'] = $list;
        $redata['access_option'] = $access_option;
        $redata = array_merge($redata, $column_list);
        if (is_mobile()) {
            $this->success($redata);
        } else {
            return $redata;
        }
    }

    function doeditorsave()
    {
        global $_M;
        return parent::doeditorsave();
    }

    public function update_list($list = array(), $id = '')
    {
        global $_M;
        return parent::update_list($list, $id);
    }

    public function update_list_sql($list = array(), $id = '')
    {
        if (!$list['title']) {
            $this->error[] = 'no title';
            return false;
        }
        if (!$this->check_filename($list['filename'], $id, $this->module)) {
            return false;
        }
        if ($list['links']) {
            $list['links'] = url_standard($list['links']);
        }
        if ($list['description']) {
            $listown = $this->database->get_list_one_by_id($id);
            $description = $this->description($listown['content']);
            if ($list['description'] == $description) {
                $list['description'] = $this->description($list['content']);
            }
        } else {
            $list['description'] = $this->description($list['content']);
        }
        $list['displayimg'] = $this->displayimg_check($list['displayimg']);
        $list['id'] = $id;
        return $this->database->update_by_id($list);
    }

    /**
     * 去除多余的displayimg里面的图片数据
     * @param $img
     * @return string
     */
    public function displayimg_check($img = '')
    {
        $imgs = stringto_array($img, '*', '|');
        $str = '';
        foreach ($imgs as $val) {
            if ($val[1]) {
                $str .= "{$val[0]}*{$val[1]}*{$val[2]}|";//增加展示图片尺寸值{$val[2]}（新模板框架v2）
            }
        }
        $str = trim($str, '|');
        return $str;
    }

    /**
     *列表数据
     */
    function dojson_list()
    {
        global $_M;
        parent::dojson_list();
    }


    function dolistsave()
    {
        global $_M;
        return parent::dolistsave();
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
