<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('handle');

/**
 * 栏目信息处理
 */

class column_handle extends handle
{
    /**
     * 处理栏目数组
     * @param  string $module 模块标识
     * @return string          模块名称
     */
    public function __construct()
    {
        global $_M;
        $this->column = load::mod_class('column/class/column_database', 'new');
    }

    /**
     * 处理栏目数组
     * @param  array $column 栏目数组
     * @return array           处理过后的栏目数组
     */
    public function para_handle($column)
    {
        global $_M;
        $return = array();
        foreach ($column as $key => $val) {
            $this->cache_column[$val['id']] = $val;
        }

        foreach ($column as $key => $val) {
            $val['sub'] = 0;
            $return[$val['id']] = $this->one_para_handle($val);
        }

        //处理栏目是否有下级
        foreach ($return as $key => $val) {
            if ($val['bigclass']) {
                $return[$val['bigclass']]['sub'] = 1;
            }
        }
        return $return;
    }

    /**
     * 处理栏目数组
     * @param  array $content 单个栏目数据
     * @return array            处理过后的栏目数组
     */
    public function one_para_handle($content = array())
    {
        global $_M;
        $content['url'] = $this->get_content_url($content);

        if ($content['indeximg']) $content['indeximg'] = $this->url_transform($content['indeximg']);
        if ($content['columnimg']) {
            $content['columnimg'] = $this->url_transform($content['columnimg']);
        } else {
            $content['columnimg'] = $_M['url']['site'] . str_replace('../', '', $_M['config']['met_agents_img']);
        }
        if ($content['new_windows']) {
            $content['target'] = 'target="_blank"';
        } else {
            $content['target'] = '';
        }
        if ($content['other_info'] == '') {
            $content['other_info'] = $content['keywords'];
        }

        if ($content['custom_info'] == '') {
            $content['custom_info'] = $content['description'];
        }
        $content['content'] = load::sys_class('label', 'new')->get('seo')->anchor_replace($content['content']);
        $content = $this->addStyle($content);
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
        $name = "<span style='";
        if ($content['text_size']) {
            $name .= "font-size:{$content['text_size']}px ;";
        }
        if ($content['text_color']) {
            $name .= "color:{$content['text_color']} ;";
        }
        $name .= "'>" . $content['name'] . "</span>";
        $content['_name'] = $name;

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

    /**
     * 获取额外栏目信息
     * @param array $c
     * @return array
     */
    public function classExt($c = array())
    {
        global $_M;
        $column_lable = load::sys_class('label', 'new')->get('column');
        $c123 = $column_lable->get_class123_no_reclass($c['id']);

        $thumb_list_default = array(800, 500);
        $thumb_detail_default = array(800, 500);
        //新闻
        if ($c['module'] == 2) {
            $thumb_list_default = array($_M['config']['met_newsimg_x'], $_M['config']['met_newsimg_y']);
        }

        //产品
        if ($c['module'] == 3) {
            $thumb_list_default = array($_M['config']['met_productimg_x'], $_M['config']['met_productimg_y']);
            $thumb_detail_default = array($_M['config']['met_productdetail_x'], $_M['config']['met_productdetail_y']);
        }

        //图片
        if ($c['module'] == 5) {
            $thumb_list_default = array($_M['config']['met_imgs_x'], $_M['config']['met_imgs_y']);
            $thumb_detail_default = array($_M['config']['met_imgdetail_x'], $_M['config']['met_imgdetail_y']);
        }

        //栏目配置分页条数及说略图尺寸信息
        $c_lev = $c['classtype'];

        //三级栏目
        if ($c_lev == 3) {
            //list_length
            $list_length = $c123['class3']['list_length'] ? $c123['class3']['list_length'] : ($c123['class2']['list_length'] ? $c123['class2']['list_length'] : ($c123['class1']['list_length'] ? $c123['class1']['list_length'] : 8));
            $list_length_default = $c123['class2']['list_length'] ? $c123['class2']['list_length'] : ($c123['class1']['list_length'] ? $c123['class1']['list_length'] : 8);

            //thumb_list
            if ($c123['class3']['thumb_list'] && $c123['class3']['thumb_list'] != '|') {
                $thumb_list = explode('|', $c123['class3']['thumb_list']);
            } else {
                if ($c123['class2']['thumb_list'] && $c123['class2']['thumb_list'] != '|') {
                    $thumb_list = explode('|', $c123['class2']['thumb_list']);
                } else {
                    if ($c123['class1']['thumb_list'] && $c123['class1']['thumb_list'] != '|') {
                        $thumb_list = explode('|', $c123['class1']['thumb_list']);
                    } else {
                        $thumb_list = $thumb_list_default;
                    }
                }
            }

            //thumb_detail
            if ($c123['class3']['thumb_detail'] && $c123['class3']['thumb_detail'] != '|') {
                $thumb_detail = explode('|', $c123['class3']['thumb_detail']);
            } else {
                if ($c123['class2']['thumb_detail'] && $c123['class2']['thumb_detail'] != '|') {
                    $thumb_detail = explode('|', $c123['class2']['thumb_detail']);
                } else {
                    if ($c123['class1']['thumb_detail'] && $c123['class1']['thumb_detail'] != '|') {
                        $thumb_detail = explode('|', $c123['class1']['thumb_detail']);
                    } else {
                        $thumb_detail = $thumb_detail_default;
                    }
                }
            }

            //tab_num
            $tab_num = $c123['class3']['tab_num'] ? $c123['class3']['tab_num'] : ($c123['class2']['tab_num'] ? $c123['class2']['tab_num'] : ($c123['class1']['tab_num'] ? $c123['class1']['tab_num'] : 3));
            $tab_num_default = $c123['class2']['tab_num'] ? $c123['class2']['tab_num'] : ($c123['class1']['tab_num'] ? $c123['class1']['tab_num'] : 3);

            //tab_name
            if ($c123['class3']['tab_name'] && $c123['class3']['tab_name'] != '|') {
                $tab_name = explode('|', $c123['class3']['tab_name']);
            } else {
                if ($c123['class2']['tab_name'] && $c123['class2']['tab_name'] != '|') {
                    $tab_name = explode('|', $c123['class2']['tab_name']);
                } else {
                    if ($c123['class1']['tab_name'] && $c123['class1']['tab_name'] != '|') {
                        $tab_name = explode('|', $c123['class1']['tab_name']);
                    } else {
                        $tab_name = array(
                            $_M['config']['met_productTabname'],
                            $_M['config']['met_productTabname_1'],
                            $_M['config']['met_productTabname_2'],
                            $_M['config']['met_productTabname_3'],
                            $_M['config']['met_productTabname_4']
                        );
                    }
                }
            }
        }

        //二级栏目将
        if ($c_lev == 2) {
            //list_length
            $list_length = $c123['class2']['list_length'] ? $c123['class2']['list_length'] : ($c123['class1']['list_length'] ? $c123['class1']['list_length'] : 8);
            $list_length_default = $c123['class1']['list_length'] ? $c123['class1']['list_length'] : 8;

            //thumb_list
            if ($c123['class2']['thumb_list'] && $c123['class2']['thumb_list'] != '|') {
                $thumb_list = explode('|', $c123['class2']['thumb_list']);
            } else {
                if ($c123['class1']['thumb_list'] && $c123['class1']['thumb_list'] != '|') {
                    $thumb_list = explode('|', $c123['class1']['thumb_list']);
                } else {
                    $thumb_list = $thumb_list_default;
                }
            }

            //thumb_detail
            if ($c123['class2']['thumb_detail'] && $c123['class2']['thumb_detail'] != '|') {
                $thumb_detail = explode('|', $c123['class2']['thumb_detail']);
            } else {
                if ($c123['class1']['thumb_detail'] && $c123['class1']['thumb_detail'] != '|') {
                    $thumb_detail = explode('|', $c123['class1']['thumb_detail']);
                } else {
                    $thumb_detail = $thumb_detail_default;
                }
            }

            //tab_num
            $tab_num = $c123['class2']['tab_num'] ? $c123['class2']['tab_num'] : ($c123['class1']['tab_num'] ? $c123['class1']['tab_num'] : 3);
            $tab_num_default = $c123['class1']['tab_num'] ? $c123['class1']['tab_num'] : 3;

            //tab_name
            if ($c123['class2']['tab_name'] && $c123['class2']['tab_name'] != '|') {
                $tab_name = explode('|', $c123['class2']['tab_name']);
            } else {
                if ($c123['class1']['tab_name'] && $c123['class1']['tab_name'] != '|') {
                    $tab_name = explode('|', $c123['class1']['tab_name']);
                } else {
                    $tab_name = array(
                        $_M['config']['met_productTabname'],
                        $_M['config']['met_productTabname_1'],
                        $_M['config']['met_productTabname_2'],
                        $_M['config']['met_productTabname_3'],
                        $_M['config']['met_productTabname_4']
                    );
                }
            }
        }

        //一级栏目
        if ($c_lev == 1) {
            $list_length = $c123['class1']['list_length'] ? $c123['class1']['list_length'] : 8;
            $list_length_default = 8;

            //thumb_list
            if ($c123['class1']['thumb_list'] && $c123['class1']['thumb_list'] != '|') {
                $thumb_list = explode('|', $c123['class1']['thumb_list']);
            } else {
                $thumb_list = $thumb_list_default;
            }

            //thumb_detail
            if ($c123['class1']['thumb_detail'] && $c123['class1']['thumb_detail'] != '|') {
                $thumb_detail = explode('|', $c123['class1']['thumb_detail']);
            } else {
                $thumb_detail = $thumb_detail_default;
            }

            //tab_num
            $tab_num = $c123['class1']['tab_num'] ? $c123['class1']['tab_num'] : 3;
            $tab_num_default = 3;

            //tab_name
            if ($c123['class1']['tab_name'] && $c123['class1']['tab_name'] != '|') {
                $tab_name = explode('|', $c123['class1']['tab_name']);
            } else {
                $tab_name = array(
                    $_M['config']['met_productTabname'],
                    $_M['config']['met_productTabname_1'],
                    $_M['config']['met_productTabname_2'],
                    $_M['config']['met_productTabname_3'],
                    $_M['config']['met_productTabname_4']
                );
            }
        }

        $redata = array();
        $redata['list_length'] = $list_length;
        $redata['tab_num'] = $tab_num;
        $redata['tab_name'] = implode("|", $tab_name);
        $redata['thumb_list'] = implode("|", $thumb_list);
        $redata['thumb_detail'] = implode("|", $thumb_detail);

        $redata['list_length_default'] = $list_length_default;
        $redata['tab_num_default'] = $tab_num_default;
        $redata['tab_name_default'] = implode("|", $tab_name);
        $redata['thumb_list_default'] = implode("|", $thumb_list);
        $redata['thumb_detail_default'] = implode("|", $thumb_detail);
        return $redata;
    }

    /**********URL处理************/
    /**
     * 获取url
     * @param  array $content 单个栏目数据
     * @return array            处理过后的栏目数组
     */
    public function get_content_url($content, $type = '')
    {
        global $_M;
        if ($content['out_url']) {
            return $content['out_url'];
        } else {
            if ($_M['config']['met_index_type'] == $content['lang'] && ($content['releclass'] || $content['samefile'])) {
                return $this->url_transform($content['foldername'] . '/', $content['lang']);
            } else {
                return $this->url_full($content, $type);
            }
        }
    }

    /**
     * 处理栏目数组
     * @param  array $content 单个栏目数据
     * @return array            处理过后的栏目数组
     */
    public function url_full($content, $type = '')
    {
        global $_M;
        $page_type = $content['module'] == 1 ? 0: 1;//内容页面
        //$type = $content['isshow'] == 0 ? 1: $type;

        $type = $this->url_type($type, $page_type);
        if ($type == 2) {
            return $this->url_pseudo($content);
        } else if ($type == 3) {
            return $this->url_static($content);
        } else {
            return $this->url_dynamic($content);
        }

    }

    /**
     * 判断真是栏目层级
     * @param $content
     * @return int
     */
    public function get_no_releclass($content)
    {
        if ($content['classtype'] == 1) {
            $classnum = 1;
        }
        if ($content['classtype'] == 2) {
            if ($content['releclass']) {
                $classnum = 1;
            } else {
                $classnum = 2;
            }
        }
        if ($content['classtype'] == 3) {
            $bigclass = $this->cache_column[$content['bigclass']];
            if ($bigclass['releclass']) {
                $classnum = 2;
            } else {
                $classnum = 3;
            }
        }
        return $classnum;
    }

    /**
     * 动态url
     * @param $content
     * @return array|mixed|string
     */
    public function url_dynamic($content)
    {
        global $_M;
        if ($content['module'] >= 2 && $content['module'] <= 6) {
            $classnum = $this->get_no_releclass($content);
            $url = '?class' . $classnum . '=' . $content['id'];
        } else {
            if ($content['module'] == 1 || $content['module'] == 8) {
                $url = '?id=' . $content['id'];
            } else {
                $url = '';
            }
        }
        if ($_M['config']['met_index_type'] != $content['lang']) {
            $url .= '&lang=' . $content['lang'];
        }
        $mod_name = $this->mod_to_name($content['module']) ? $this->mod_to_name($content['module']) : 'index';
        $url = "{$content['foldername']}/{$mod_name}.php{$url}";
        $url = $this->url_transform($url, $content['lang']);
        $url = str_replace('.php&', '.php?', $url);
        return $url;
    }

    /**
     * 静态页url
     * @param $content
     * @return array
     */
    public function url_static($content)
    {
        global $_M;

        $url = '';

        if ($content['filename']) {
            if ($content['module'] == 1) {
                $url .= $content['filename'];
            } else {
                $url .= $content['filename'] . '_1';
            }
        } else {
            $classnum = $this->get_no_releclass($content);
            if ($content['module'] >= 2 && $content['module'] <= 6) {
                if ($classnum != 1 || $_M['config']['met_index_type'] != $content['lang']) {
                    if ($_M['config']['met_htmlistname']) {
                        $url .= $content['foldername'];
                    } else {
                        $url .= $this->mod_to_name($content['module']);

                    }

                    if ($_M['config']['met_listhtmltype']) {
                        $url .= "_{$content['id']}";
                    } else {
                        if ($classnum == 2) {
                            $url .= "_{$content['bigclass']}_{$content['id']}";
                        } else {
                            $url .= "_{$this->cache_column[$content['bigclass']]['bigclass']}_{$content['bigclass']}_{$content['id']}";
                        }
                    }
                    $url .= '_1';
                }
            }

            if ($content['module'] == 1) {
                $classnum = $this->get_no_releclass($content);
                if ($classnum == 1) {
                    if ($content['isshow'] == 1) {
                        $url .= 'index';
                    }else{//显示次级栏目
                        if ($_M['config']['met_index_type'] != $content['lang']) {
                            $url .= '_' . $content['lang'];
                        }
                        $res = $this->url_transform($content['foldername'] . '/' . $url, $content['lang']);
                        return $res;
                    }
                } else {
                    switch ($_M['config']['met_htmpagename']) {
                        case 0:
                            $url .= 'about';
                            break;
                        case 1:
                            $url .= 'about';
                            break;
                        case 2:
                            $url .= $content['foldername'];
                            break;
                        case 3:
                            $url .= '';
                            break;
                    }
                    #$url .= 'about';
                    $url .= "{$content['id']}";
                }
            }
        }
        if (!$url) $url .= 'index';
        if ($_M['config']['met_index_type'] != $content['lang']) {
            $url .= '_' . $content['lang'];
        }

        return $this->url_transform($content['foldername'] . '/' . $url . '.' . $_M['config']['met_htmtype'], $content['lang']);
    }

    /**
     * 伪静态url
     * @param $content
     * @return array
     */
    public function url_pseudo($content)
    {
        global $_M;
        $url = '';
        if ($content['filename']) {
            if (in_array($content['module'],array(2,3,4,5,6))) {
                $url .= 'list-' . $content['filename'];
            }else{
                $url .= $content['filename'];
            }
        } else {
            if (in_array($content['module'],array(2,3,4,5,6))) {
                $url .= 'list-' . $content['id'];
            }
            if ($content['module'] == 1) {
                $classnum = $this->get_no_releclass($content);
                if ($classnum != 1) {
                    $url .= $content['id'];
                }else{
                    $url .= 'index';
                }
            }
        }

        if (!$url && $_M['config']['met_index_type'] != $content['lang']){
            $url .= 'index';
        }

        if ($_M['config']['met_defult_lang']) {
            $url .= '-' . $content['lang'];
            return $this->url_transform($content['foldername'] . '/' . $url . '.html', $content['lang']);
        }else{
            if ($_M['config']['met_index_type'] != $content['lang']) {
                $url .= '-' . $content['lang'];
                return $this->url_transform($content['foldername'] . '/' . $url . '.html', $content['lang']);
            }

            if ($content['filename']) {
                return $this->url_transform($content['foldername'] . '/' . $url . '.html', $content['lang']);
            }

            if ($content['classtype'] == 1) {
                return $this->url_transform($content['foldername'] . '/', $content['lang']);
            }

            return $this->url_transform($content['foldername'] . '/' . $url . '.html', $content['lang']);
        }
    }

    /**
     * 特殊规则 未启用
     * @param $content
     * @return array
     */
    public function url_index_page($content)
    {
        global $_M;

        $url = '';
        if ($content['filename']) {
            if ($content['module'] == 1) {
                $url .= $content['filename'];
            } else {
                $url .= $content['filename'] . '_1';
            }
        } else {
            $classnum = $this->get_no_releclass($content);
            if ($content['module'] >= 2 && $content['module'] <= 6) {
                if ($classnum != 1 || $_M['config']['met_index_type'] != $content['lang']) {
                    if ($_M['config']['met_htmlistname']) {
                        $url .= $content['foldername'];
                    } else {
                        $url .= $this->mod_to_name($content['module']);
                    }
                    if ($_M['config']['met_htmlistname']) {
                        $url .= "_{$content['id']}";
                    } else {
                        if ($classnum == 2) {
                            $url .= "_{$content['bigclass']}_{$content['id']}";
                        } else {
                            $url .= "_{$this->cache_column[$content['bigclass']]['bigclass']}_{$content['bigclass']}_{$content['id']}";
                        }
                    }
                    $url .= '_1';
                }
            }
            if ($content['module'] == 1) {
                $classnum = $this->get_no_releclass($content);
                if ($classnum == 1) {
                    $url .= 'index';
                } else {
                    switch ($_M['config']['met_htmpagename']) {
                        case 0:
                            $url .= 'about';
                            break;
                        case 1:
                            $url .= 'about';
                            break;
                        case 2:
                            $url .= 'foldername';
                        case 3:
                            $url .= '';
                    }
                    #$url .= 'about';
                    $url .= "{$content['id']}";
                }
            }
        }
        if (!$url) $url .= 'index';
        if ($_M['config']['met_index_type'] != $content['lang']) {
            $url .= '_' . $content['lang'];
        }
        return $this->url_transform($content['foldername'] . '/' . $url . '.' . $_M['config']['met_htmtype'], $content['lang']);
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
