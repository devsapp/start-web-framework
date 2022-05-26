<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');
load::sys_class('admin');
load::sys_func('file');

class index extends admin
{
    /**
     * @var array
     */
    public $error;

    /**
     * @var array 别标记的二级栏目ID (多语言栏目复制)
     */
    protected $copy_class_list;

    public function __construct()
    {
        global $_M;
        parent::__construct();
        $this->database = load::mod_class('column/class/column_database', 'new');
        $this->error = array();
        $this->copy_class_list = array();
    }

    /**
     * 栏目列表
     */
    public function doGetColumnList()
    {
        global $_M;
        $redata = array();
        $sys_column = load::mod_class('column/sys_column', 'new');
        $redata['column_list'] = $sys_column->getColumnList();
        $redata['nav_list'] = $sys_column->nav_list();
        ##$redata['mod_list']    = $sys_column->module_list();

        $this->database->table_return($redata);
    }

    /**
     * 获取可添加的栏目
     * 6,7,10,11,12,13
     */
    public function doGetModlist()
    {
        global $_M;
        $list = $this->database->get_all_column_by_lang($_M['lang']);

        $mod6_num = 0;
        $mod7_num = 0;
        $mod10_num = 0;
        $mod11_num = 0;
        $mod12_num = 0;
        $mod13_num = 0;

        foreach ($list as $column) {
            if ($column['module'] == 6) {
                $disabled_6 = 6;
                $mod6_num++;
            }
            if ($column['module'] == 7) {
                $disabled_7 = 7;
                $mod7_num++;
            }
            if ($column['module'] == 10) {
                $disabled_10 = 10;
                $mod10_num++;
            }
            if ($column['module'] == 11) {
                $disabled_11 = 11;
                $mod11_num++;
            }
            if ($column['module'] == 12) {
                $disabled_12 = 12;
                $mod12_num++;
            }
            if ($column['module'] == 13) {
                $disabled_13 = 13;
                $mod13_num++;
            }
        }

        $array[] = array('name' => $_M['word']['mod1'], 'mod' => 1);//简介
        $array[] = array('name' => $_M['word']['mod2'], 'mod' => 2);//文章
        $array[] = array('name' => $_M['word']['mod3'], 'mod' => 3);//产品
        $array[] = array('name' => $_M['word']['mod4'], 'mod' => 4);//下载
        $array[] = array('name' => $_M['word']['mod5'], 'mod' => 5);//图片
        $array[] = array('name' => $_M['word']['mod6'], 'mod' => 6, 'num' => $mod6_num);//招聘

        if (!$disabled_7) {
            $array[] = array('name' => $_M['word']['mod7'], 'mod' => 7, 'num' => $mod7_num);//留言     message
        }
        $array[] = array('name' => $_M['word']['mod8'], 'mod' => 8);//反馈
        ##$array[] = array('name'=>$_M['word']['mod9'],'mod'=>9);//友情链接
        if (!$disabled_10) {
            $array[] = array('name' => $_M['word']['mod10'], 'mod' => 10, 'num' => $mod10_num);//会员   member
        }
        if (!$disabled_11) {
            $array[] = array('name' => $_M['word']['mod11'], 'mod' => 11, 'num' => $mod11_num);//搜索   search
        }
        if (!$disabled_12) {
            $array[] = array('name' => $_M['word']['mod12'], 'mod' => 12, 'num' => $mod12_num);//网站地图 sitemap
        }
        if (!$disabled_13) {
            $array[] = array('name' => $_M['word']['tag'], 'mod' => 13, 'num' => $mod13_num);//tag标签 tags
        }
        $array[] = array('name' => $_M['word']['modout'], 'mod' => 0);//外部模块

        $ifcolumn = load::mod_class('column/ifcolumn_database', 'new')->get_all();
        foreach ($ifcolumn as $key => $val) {
            $array[] = array('name' => $val['name'], 'mod' => $val['no']);
        }
        $this->ajaxReturn($array);
    }

    /**
     * 添加栏目
     */
    public function doAddColumn()
    {
        global $_M;
        $redata = array();
        $allid = explode(',', $_M['form']['allid']);

        foreach ($allid as $id) {
            $name = $_M['form']['name-new-' . $id];
            $no_order = $_M['form']['no_order-new-' . $id];
            $big_class = $_M['form']['bigclass-new-' . $id];
            $foldername = $_M['form']['foldername-new-' . $id];
            $nav = $_M['form']['nav-new-' . $id];
            $module = $_M['form']['module-new-' . $id];
            $out_url = $_M['form']['out_url-new-' . $id];
            $index_num = $_M['form']['index_num-new-' . $id];
            $filename = $_M['form']['filename-new-' . $id];
            $if_in = $module ? 0 : 1;
            $res = self::_addColumn($name, $no_order, $module, $big_class, $foldername, $nav, $out_url, $index_num, $filename, $if_in);
            if (!$res) {
                continue;
            }
        }

        if (!$this->error) {
            //写日志
            logs::addAdminLog('admin_colunmmanage_v6', 'column_addcolumn_v6', 'jsok', 'doAddColumn');
            buffer::clearColumn();
            $redata['status'] = 1;
            $redata['msg'] = $_M['word']['jsok'];
            $this->ajaxReturn($redata);
        } else {
            //写日志
            logs::addAdminLog('admin_colunmmanage_v6', 'column_addcolumn_v6', $this->error[0], 'doAddColumn');
            $redata['msg'] = $this->error[0];
            $redata['status'] = 0;
            $redata['error'] = $this->error;
            $this->ajaxReturn($redata);
        }


        /*$name = $_M['form']['name'];
        $no_order = $_M['form']['no_order'];
        $big_class = $_M['form']['bigclass'];
        $foldername = $_M['form']['foldername'];
        $nav = $_M['form']['nav'];
        $module = $_M['form']['module'];
        $out_url = $_M['form']['out_url'];
        $index_num = $_M['form']['index_num'];
        $filename = $_M['form']['filename'];
        $if_in = $module ? 0 : 1;

        $res = self::_addColumn($name, $no_order, $module, $big_class, $foldername, $nav, $out_url, $index_num, $filename, $if_in);

        if ($res === true) {
            //写日志
            logs::addAdminLog('admin_colunmmanage_v6', 'column_addcolumn_v6', 'jsok', 'doAddColumn');
            buffer::clearColumn();
            $redata['status'] = 1;
            $redata['msg'] = $_M['word']['jsok'];
            $this->ajaxReturn($redata);
        } else {
            //写日志
            logs::addAdminLog('admin_colunmmanage_v6', 'column_addcolumn_v6', $this->error[0], 'doAddColumn');
            $redata['msg'] = $this->error[0];
            $redata['status'] = 0;
            $redata['error'] = $this->error;
            $this->ajaxReturn($redata);
        }*/
    }

    /**
     * 添加栏目
     * @param string $name
     * @param string $no_order
     * @param string $module
     * @param string $big_class
     * @param string $foldername
     * @param string $nav
     * @param string $out_url
     * @param string $index_num
     * @param string $index_num
     * @param string $filename
     * @param int $if_in
     * @return bool
     */
    private function _addColumn($name = '', $no_order = '', $module = '', $big_class = '', $foldername = '', $nav = '', $out_url = '', $index_num = '', $filename = '', $if_in = 0)
    {
        global $_M;

        $bigclass = $this->database->get_column_by_id($big_class);
        if ($bigclass) {
            $classtype = $bigclass['classtype'] + 1;
            $releclass = $bigclass['module'] == $module ? 0 : $big_class;
            $access = $bigclass['access'];
        } else {
            $classtype = 1;
            $releclass = 0;
            $access = 0;
        }

        if (!trim($name)) {
            //栏目名为空
            $this->error[] = $_M['word']['column_descript1_v6'];
            return false;
        }

        if (preg_match("/[<\x{4e00}-\x{9fa5}>]+/u", $foldername)) {
            //中文目录
            $this->error[] = $_M['word']['column_descript1_v6'];
            return false;
        }

        if (!is_simplestr($foldername, '/^[0-9A-Za-z_-]+$/') && $module != 0) {
            //中文目录
            $this->error[] = $_M['word']['column_descript1_v6'];
            return false;
        }

        $mod = load::sys_class('handle', 'new')->file_to_mod($foldername);
        if ($mod && $mod != $module) {
            $this->error[] = $_M['word']['columndeffflor'];
            return false;
        }

        if ($filename) {
            $filenames = $this->database->get_column_by_filename($filename);
            if ($filenames) {
                $this->error[] = $_M['word']['jsx27'];
                return false;
            }
        }

        if ($bigclass['module'] == $module) {
            $sava_data['foldername'] = $bigclass['foldername'];
        } else {
            //验证模块是否可以用
            if (!$if_in) {
                if (!$this->is_foldername_ok($foldername, $module)) {
                    $this->error[] = $_M['word']['column_descript1_v6'];
                    return false;
                }
            }
            $sava_data['foldername'] = $foldername;
        }

        $sava_data['name'] = $name;
        $sava_data['filename'] = '';
        $sava_data['bigclass'] = $bigclass['id'];
        $sava_data['samefile'] = 0;
        $sava_data['module'] = $module;
        $sava_data['no_order'] = $no_order;
        $sava_data['wap_ok'] = 0;
        $sava_data['wap_nav_ok'] = 0;
        $sava_data['if_in'] = $if_in;
        $sava_data['nav'] = $nav;
        $sava_data['ctitle'] = '';
        $sava_data['keywords'] = '';
        $sava_data['content'] = '';
        $sava_data['description'] = '';
        $sava_data['list_order'] = 1;
        $sava_data['new_windows'] = 0;
        $sava_data['classtype'] = $classtype;   //可以用bigclass计算得出
        $sava_data['out_url'] = $if_in ? $out_url : '';
        $sava_data['index_num'] = $index_num;
        $sava_data['indeximg'] = '';
        $sava_data['columnimg'] = '';
        $sava_data['isshow'] = 1;
        $sava_data['lang'] = $_M['lang'];
        $sava_data['namemark'] = '';
        $sava_data['releclass'] = $releclass;   //可以用bigclass计算得出
        $sava_data['display'] = 0;
        $sava_data['icon'] = '';
        $sava_data['foldername'] = $if_in ? '' : $foldername;
        $sava_data['access'] = $access;
        $sava_data['other_info'] = '';
        $sava_data['custom_info'] = '';
        //数据入库
        $id = $this->database->insert($sava_data);
        if ($id) {
            $this->columnCopyconfig($sava_data['foldername'], $sava_data['module'], $id);
            //更改管理员栏目权限
            load::mod_class("admin/admin_op", 'new')->modify_admin_column_accsess($id, 'c', 'add');

            return true;
        }
        if(!$this->error){
            $this->error[] = 'Data error';
        }
        return false;

    }

    /**
     * 编辑栏目列表
     */
    public function doEditorColumn()
    {
        global $_M;
        $redata = array();
        $data = $_M['form'];
        if ($data['id'] && is_numeric($data['id'])) {
            $save_data['id'] = $data['id'];
            $save_data['name'] = $data['name'];
            $save_data['no_order'] = $data['no_order'];
            $save_data['nav'] = $data['nav'];
            $save_data['index_num'] = $data['index_num'];
            $res = $this->database->update_by_id($save_data);

            buffer::clearColumn();
            $redata['status'] = 1;
            $redata['msg'] = $_M['word']['jsok'];
            $this->ajaxReturn($redata);
        } else {
            $redata['status'] = 0;
            $redata['msg'] = 'Data error';
            $redata['error'] = $this->error;
            $this->ajaxReturn($redata);
        }

    }

    /**
     * 栏目详情
     */
    public function doGetColumn()
    {
        global $_M;
        $id = $_M['form']['id'];

        if ($id && is_numeric($id)) {
            $data = self::getColumn($id);
            if (is_mobile()) {
                $this->success($data);
            } else {
                return $data;
            }
        }
    }

    private function getColumn($class = '')
    {
        if ($class && is_numeric($class)) {
            $data = array();
            $column_list = $this->database->get_list_one_by_id($class);
            $sys_column = load::mod_class('column/sys_column', 'new');
            $column_list['action'] = $sys_column->getColumnAction($column_list);
            $column_list['new_windows'] = $column_list['new_windows'] ? 1 : 0;
            $column_list['list_order'] = $column_list['list_order'] ? $column_list['list_order'] : 1;

            $ext_list = load::mod_class('column_handle.class.php','new')->classExt($column_list);
            $column_list['thumb_list_default'] = $ext_list['thumb_list_default'];
            $column_list['thumb_detail_default'] = $ext_list['thumb_detail_default'];
            $column_list['list_length_default'] = $ext_list['list_length_default'];
            $column_list['tab_num_default'] = $ext_list['tab_num_default'];
            $column_list['tab_name_default'] = $ext_list['tab_name_default'];

            if (!$column_list['bigclass']) {
                $access_val = 0;
            } else {
                $parent_column = $this->database->get_list_one_by_id($column_list['bigclass']);
                if ($parent_column['access'] != 0) {
                    $access_val = $parent_column['access'];
                } else {
                    $access_val = 0;
                }
            }
            $access = $this->access_option($access_val);

            $data['list'] = $column_list;
            $data['access'] = $access;
            $data['nav_list'] = $sys_column->nav_list();
            return $data;
        }
        $this->error[] = "Data error";
        return false;
    }

    /**
     * 栏目样式配置页面配置
     * @return array
     */
    public function doGetClassExtInfo()
    {
        global $_M;
        $redata = array();
        $classnow = $_M['form']['classnow'];

        $column_label = load::mod_class('column/column_label', 'new');
        $c = $column_label->get_column_id($classnow);

        $redata['thumb_list'] = $c['thumb_list'];
        $redata['thumb_detail'] = $c['thumb_detail'];
        $redata['list_length'] = $c['list_length'] ? $c['list_length'] : '';
        $redata['tab_num'] = $c['tab_num'] ? $c['tab_num'] : 0;
        $redata['tab_name'] = $c['tab_name'];

        $ext_list = load::mod_class('column_handle.class.php','new')->classExt($c);
        $redata['thumb_list_default'] = $ext_list['thumb_list_default'];
        $redata['thumb_detail_default'] = $ext_list['thumb_detail_default'];
        $redata['list_length_default'] = $ext_list['list_length_default'];
        $redata['tab_num_default'] = $ext_list['tab_num_default'];
        $redata['tab_name_default'] = $ext_list['tab_name_default'];

        if(is_mobile()){
            $this->ajaxReturn(array('status' => 1, 'data'=>$redata));
        }
        return $redata;
    }

    /**
     * 额外栏目信息
     * @param array $c
     */
    public function classExt_($c = array())
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

            //thumb_list
            if ($c123['class3']['thumb_list'] && $c123['class3']['thumb_list'] != '|') {
                $thumb_list = explode("|", $c123['class3']['thumb_list']);
            } else {
                if ($c123['class2']['thumb_list'] && $c123['class2']['thumb_list'] != '|') {
                    $thumb_list = explode("|", $c123['class2']['thumb_list']);
                } else {
                    if ($c123['class1']['thumb_list'] && $c123['class1']['thumb_list'] != '|') {
                        $thumb_list = explode("|", $c123['class1']['thumb_list']);
                    } else {
                        $thumb_list = $thumb_list_default;
                    }
                }
            }

            //thumb_detail
            if ($c123['class3']['thumb_detail'] && $c123['class3']['thumb_detail'] != '|') {
                $thumb_detail = explode("|", $c123['class3']['thumb_detail']);
            } else {
                if ($c123['class2']['thumb_detail'] && $c123['class2']['thumb_detail'] != '|') {
                    $thumb_detail = explode("|", $c123['class2']['thumb_detail']);
                } else {
                    if ($c123['class1']['thumb_detail'] && $c123['class1']['thumb_detail'] != '|') {
                        $thumb_detail = explode("|", $c123['class1']['thumb_detail']);
                    } else {
                        #$thumb_detail = array(600, 600);
                        $thumb_detail = $thumb_detail_default;
                    }
                }
            }

            //tab_num
            $tab_num = $c123['class3']['tab_num'] ? $c123['class3']['tab_num'] : ($c123['class2']['tab_num'] ? $c123['class2']['tab_num'] : ($c123['class1']['tab_num'] ? $c123['class1']['tab_num'] : 3));
            $tab_num_default = $c123['class2']['tab_num'] ? $c123['class2']['tab_num'] : ($c123['class1']['tab_num'] ? $c123['class1']['tab_num'] : 3);

            //tab_name
            if ($c123['class3']['tab_name'] && $c123['class3']['tab_name'] != '|') {
                $tab_name = explode("|", $c123['class3']['tab_name']);
            } else {
                if ($c123['class2']['tab_name'] && $c123['class2']['tab_name'] != '|') {
                    $tab_name = explode("|", $c123['class2']['tab_name']);
                } else {
                    if ($c123['class1']['tab_name'] && $c123['class1']['tab_name'] != '|') {
                        $tab_name = explode("|", $c123['class1']['tab_name']);
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

            //thumb_list
            if ($c123['class2']['thumb_list'] && $c123['class2']['thumb_list'] != '|') {
                $thumb_list = explode("|", $c123['class2']['thumb_list']);
            } else {
                if ($c123['class1']['thumb_list'] && $c123['class1']['thumb_list'] != '|') {
                    $thumb_list = explode("|", $c123['class1']['thumb_list']);
                } else {
                    $thumb_list = $thumb_list_default;
                }
            }

            //thumb_detail
            if ($c123['class2']['thumb_detail'] && $c123['class2']['thumb_detail'] != '|') {
                $thumb_detail = explode("|", $c123['class2']['thumb_detail']);
            } else {
                if ($c123['class1']['thumb_detail'] && $c123['class1']['thumb_detail'] != '|') {
                    $thumb_detail = explode("|", $c123['class1']['thumb_detail']);
                } else {
                    #$thumb_detail = array(600, 600);
                    $thumb_detail = $thumb_detail_default;
                }
            }

            //tab_num
            $tab_num = $c123['class2']['tab_num'] ? $c123['class2']['tab_num'] : ($c123['class1']['tab_num'] ? $c123['class1']['tab_num'] : 3);

            //tab_name
            if ($c123['class2']['tab_name'] && $c123['class2']['tab_name'] != '|') {
                $tab_name = explode("|", $c123['class2']['tab_name']);
            } else {
                if ($c123['class1']['tab_name'] && $c123['class1']['tab_name'] != '|') {
                    $tab_name = explode("|", $c123['class1']['tab_name']);
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
            //
            $list_length = $c123['class1']['list_length'] ? $c123['class1']['list_length'] : 8;

            //thumb_list
            if ($c123['class1']['thumb_list'] && $c123['class1']['thumb_list'] != '|') {
                $thumb_list = explode("|", $c123['class1']['thumb_list']);
            } else {
                $thumb_list = $thumb_list_default;
            }

            //thumb_detail
            if ($c123['class1']['thumb_detail'] && $c123['class1']['thumb_detail'] != '|') {
                $thumb_detail = explode("|", $c123['class1']['thumb_detail']);
            } else {
                #$thumb_detail = array(600, 600);
                $thumb_detail = $thumb_detail_default;
            }

            //tab_num
            $tab_num = $c123['class1']['tab_num'] ? $c123['class1']['tab_num'] : 3;

            //tab_name
            if ($c123['class1']['tab_name'] && $c123['class1']['tab_name'] != '|') {
                $tab_name = explode("|", $c123['class1']['tab_name']);
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
        $redata['tab_num'] = $tab_num;
        $redata['list_length_default'] = $list_length;
        $redata['thumb_list_default'] = implode("|", $thumb_list);
        $redata['thumb_detail_default'] = implode("|", $thumb_detail);
        $redata['tab_num_default'] = $tab_num;
        $redata['tab_name_default'] = implode("|", $tab_name);
        return $redata;
    }

    /**
     * 编辑栏目详情
     */
    public function doEditorsave()
    {
        global $_M;
        $data = $_M['form'];
        if (!isset($data['id'])) {
            $this->error('error');
        }
        if (isset($data['filename']) && $data['filename']) {
            if (is_numeric($data['filename'])) {
                $this->error($_M['word']['admin_tag_setting10']);
            }
            $filenames = $this->database->get_column_by_filename($data['filename']);
            if ($filenames && $filenames['id'] != $data['id']) {
                $this->error($_M['word']['jsx27']);
            }
        }
        $column = $this->database->get_list_one_by_id($data['id']);

        //栏目说略图尺寸
        $data['thumb_list'] = "{$data['thumb_list_x']}|{$data['thumb_list_y']}";
        $data['thumb_detail'] = "{$data['thumb_detail_x']}|{$data['thumb_detail_y']}";
        //产品栏目选项卡名称
        $data['tab_name'] = "{$data['tab_name_0']}|{$data['tab_name_1']}|{$data['tab_name_2']}|{$data['tab_name_3']}|{$data['tab_name_4']}";
        if (!str_replace('|', '', $data['tab_name'])) {
            $data['tab_name'] = '';
        }
        $this->database->update_by_id($data);
        $this->_update_list_access($data['id'], $data['access'], $column['access']);

        buffer::clearColumn();
        $this->success('', $_M['word']['jsok']);
    }

    /**
     * 更新栏目内容权限
     * @param string $cid 栏目ID
     * @param int $access 栏目会员组id
     */
    public function _update_list_access($cid = '', $access_new = 0, $access_old = '')
    {
        global $_M;
        $column_label = load::sys_class('label', 'new')->get('column');
        $group_column = load::sys_class('group', 'new')->get_group($access_new);
        $group_column_old = load::sys_class('group', 'new')->get_group($access_old);

        if (!$group_column) {
            $group_column = array('access'=>0);
        }
        if (!$group_column_old) {
            $group_column_old = array('access'=>0);
        }

        $column = $this->database->get_list_one_by_id($cid);
        $column_class123 = $column_label->get_class123_no_reclass($cid);
        $class1 = $column_class123['class1']['id'] ? $column_class123['class1']['id'] : 0;
        $class2 = $column_class123['class2']['id'] ? $column_class123['class2']['id'] : 0;
        $class3 = $column_class123['class3']['id'] ? $column_class123['class3']['id'] : 0;

        if ($column) {
            if (in_array($column['module'], array(2, 3, 4, 5))) {
                //更新内容权限
                $module = load::sys_class('handle', 'new')->mod_to_name($column['module']);
                $module_op = load::mod_class("{$module}/{$module}_op", 'new');
                if (method_exists($module_op, 'get_contents_list')) {
                    $content_list = $module_op->get_contents_list($class1, $class2, $class3);
                    foreach ($content_list as $row) {
                        $group_row = load::sys_class('group', 'new')->get_group($row['access']);
                        if ($group_row['access'] < $group_column['access'] || $group_row['access'] == $group_column_old['access']) {
                            $module_op->access_motify($row['id'], $access_new);
                        }
                    }
                }

                //更新栏目属性
//                $query = "SELECT * FROM {$_M['table']['parameter']} WHERE nodule = '{$column['module']}' AND class1 = '{$class1}' AND class2 = '{$class2}' AND class3 = '{$class3}' AND lang = '{$_M['lang']}'";
//                $module_parameter_list = DB::get_all($query);
                $parameter_db = load::mod_class("parameter/parameter_database", 'new');
                $module_parameter_list = $parameter_db->get_parameter($column['module'], $class1, $class2, $class3);

                foreach ($module_parameter_list as $parameter) {
                    if ($parameter['class1'] == 0) {
                        continue;
                    }
                    $group_parameter = load::sys_class('group', 'new')->get_group($parameter['access']);
                    if ($group_parameter['access'] < $group_column['access'] || $group_parameter['access'] == $group_column_old['access']) {
                        $parameter['access'] = $access_new;
                        $parameter_db->update_by_id($parameter);
                    }
                }
            }

            $sub_class = $column_label->get_column_son($column['id']);
            foreach ($sub_class as $sub) {
                $group_sub_class = load::sys_class('group', 'new')->get_group($sub['access']);
                //更新子栏目权限
                if ($group_sub_class['access'] < $group_column['access'] || $group_sub_class['access'] == $group_column_old['access']) {
                    $new_sub = array();
                    $new_sub['id'] = $sub['id'];
                    $new_sub['access'] = $access_new;
                    $this->database->update_by_id($new_sub);
                }
                self::_update_list_access($sub['id'], $access_new, $access_old);
            }
            return;
        }
        return;
    }

    /**
     * 检测静态文件名称是否存在
     */
    public function doCheckFilename()
    {
        global $_M;
        $filename = $_M['form']['filename'];
        $id = $_M['form']['id'] ? $_M['form']['id'] : '';
        $redata['valid'] = true;
        if (is_string($filename)) {
            $patten = '/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u';
            $check_res = is_simplestr($filename, $patten);
            if ($check_res == false) {
                $redata['valid'] = false;
                $redata['message'] = $_M['word']['special_che_deny'];
            }
            $res = $this->database->get_column_by_filename($filename);
            if ($id == '' && $res) {
                $redata['valid'] = false;
                $redata['message'] = $_M['word']['jsx27'];
            }
            if ($id && $res && $res['id'] != $id) {
                $redata['valid'] = false;
                $redata['message'] = $_M['word']['jsx27'];
            }
        }
        $this->ajaxReturn($redata);
    }

    /**
     * 栏目移动
     */
    public function domove()
    {
        global $_M;
        $redata = array();
        $now_id = $_M['form']['nowid'];
        $to_id = $_M['form']['toid'];
        $uplv = $_M['form']['uplv'];
        $foldername = $_M['form']['foldername'];

        if ($now_id) {
            $res = self::_columnMove($now_id, $to_id, $uplv, $foldername);
            if ($res === true) {
                //写日志
                logs::addAdminLog('admin_colunmmanage_v6', 'columnmove1', 'jsok', 'domove');
                $redata['status'] = 1;
                $redata['msg'] = $_M['word']['jsok'];
                $this->ajaxReturn($redata);
            }
        }
        //写日志
        logs::addAdminLog('admin_colunmmanage_v6', 'columnmove1', $this->error[0], 'domove');
        buffer::clearColumn();
        $redata['status'] = 0;
        $redata['msg'] = $this->error[0];
        $redata['error'] = $this->error;
        $this->ajaxReturn($redata);

    }

    /**
     * 移动栏目
     * @param string $now_id
     * @param string $to_id
     * @param string $uplv
     * @param string $foldername
     * @return bool
     */
    private function _columnMove($now_id = '', $to_id = '', $uplv = '', $foldername = '')
    {
        global $_M;
        if ($now_id) {
            $now_column = $this->database->get_list_one_by_id($now_id);
            $now_column_class123 = load::sys_class('label', 'new')->get('column')->get_class123_no_reclass($now_id);
            $to_column = $this->database->get_list_one_by_id($to_id);
            $to_column_class123 = load::sys_class('label', 'new')->get('column')->get_class123_no_reclass($to_id);

            if (!$now_column || !$to_column) {
                if (!$uplv) {
                    $this->error[] = 'Column not found ';
                    return false;
                }
            }

            if ($uplv) {
                //不是外部模块需要验证栏目目录名是否合法
                if ($now_column['module'] != 0) {
                    if (!$foldername) {
                        $this->error[] = $_M['word']['column_descript1_v6'];
                        return false;
                    }

                    if (!is_simplestr($foldername, '/^[0-9A-Za-z_-]+$/')) {
                        //中文目录
                        $this->error[] = $_M['word']['column_descript1_v6'];
                        return false;
                    }
                }

                if (!$now_column['releclass']) {
                    if (in_array($now_column['module'], array(1, 2, 3, 4, 5))) {
                        if (!$this->is_foldername_ok($foldername, $now_column['module'])) {
                            $this->error[] = $_M['word']['column_descript1_v6'];
                            return false;
                        }
                    }
                }

                //升为一级栏目
                //移动内容
                if (in_array($now_column['module'], array(2, 3, 4, 5))) {
                    $module = load::sys_class('handle', 'new')->mod_to_name($now_column['module']);
                    load::mod_class("{$module}/{$module}_op", 'new')->list_move($now_column_class123['class1']['id'], $now_column_class123['class2']['id'], $now_column_class123['class3']['id'], $now_column['id'], 0, 0);
                    if ($now_column['classtype'] == 2) {
                        $son = load::sys_class('label', 'new')->get('column')->get_column_son($now_id);
                        foreach ($son as $key => $val) {
                            if (in_array($val['module'], array(2, 3, 4, 5))) {
                                $module_son = $module = load::sys_class('handle', 'new')->mod_to_name($val['module']);
                                $son123 = load::sys_class('label', 'new')->get('column')->get_class123_reclass($val['id']);
                                load::mod_class("{$module_son}/{$module_son}_op", 'new')->list_move($son123['class1']['id'], $son123['class2']['id'], $son123['class3']['id'], $now_column['id'], $val['id'], 0);
                            }
                        }
                    }
                }

                //移动栏目
                //原2级栏目变为1级栏目
                $list1 = array();
                $list1['id'] = $now_column['id'];
                $list1['bigclass'] = 0;
                $list1['classtype'] = 1;
                $list1['releclass'] = 0;
                $list1['foldername'] = $foldername;
                $this->database->update_by_id($list1);
                //给下级栏目classtype减1
                //原3级栏目变为2级栏目
                $sub_class_list = $this->database->get_column_by_bigclass($now_column['id']);
                foreach ($sub_class_list as $sub_class) {
                    $list2 = array();
                    $list2['id'] = $sub_class['id'];
                    $list2['classtype'] = 2;
                    $list2['bigclass'] = $now_column['id'];
                    if($sub_class['module'] == $now_column['module']){
                        $list2['foldername'] = $foldername;
                    }
                    $this->database->update_by_id($list2);
                }

                //新增栏目入口文件夹
                $this->columnCopyconfig($foldername, $now_column['module'], $now_column['id']);
            } else {
                if (!$to_id) {
                    $this->error[] = 'error no toid';
                    return false;
                }
                if ($now_column['module'] == $to_column['module']) {
                    //同模块移动
                    //移动内容
                    if (in_array($now_column['module'], array(2, 3, 4, 5))) {
                        $module = load::sys_class('handle', 'new')->mod_to_name($now_column['module']);

                        //移动到一级栏目
                        if ($to_column['classtype'] == 1) {
                            if ($now_column['classtype'] == 1) {
                                //被移动的栏目是一级栏目
                                load::mod_class("{$module}/{$module}_op", 'new')->list_move($now_column_class123['class1']['id'], $now_column_class123['class2']['id'], $now_column_class123['class3']['id'], $to_column_class123['class1']['id'], $now_column['id'], 0);
                                $son = load::sys_class('label', 'new')->get('column')->get_column_son($now_id);
                                foreach ($son as $key => $val) {
                                    if (in_array($val['module'], array(2, 3, 4, 5))) {
                                        $module_son = $module = load::sys_class('handle', 'new')->mod_to_name($val['module']);
                                        $son123 = load::sys_class('label', 'new')->get('column')->get_class123_reclass($val['id']);
                                        load::mod_class("{$module_son}/{$module_son}_op", 'new')->list_move($son123['class1']['id'], $son123['class2']['id'], $son123['class3']['id'], $to_column_class123['class1']['id'], $son123['class1']['id'], $son123['class2']['id']);
                                    }
                                }
                            }

                            if ($now_column['classtype'] == 2) {
                                //被移动的栏目是二级栏目
                                load::mod_class("{$module}/{$module}_op", 'new')->list_move($now_column_class123['class1']['id'], $now_column_class123['class2']['id'], $now_column_class123['class3']['id'], $to_column_class123['class1']['id'], $now_column_class123['class2']['id'], $now_column['id']);

                                $son = load::sys_class('label', 'new')->get('column')->get_column_son($now_id);
                                foreach ($son as $key => $val) {
                                    if (in_array($val['module'], array(2, 3, 4, 5))) {
                                        $module_son = $module = load::sys_class('handle', 'new')->mod_to_name($val['module']);
                                        $son123 = load::sys_class('label', 'new')->get('column')->get_class123_reclass($val['id']);
                                        load::mod_class("{$module_son}/{$module_son}_op", 'new')->list_move($son123['class1']['id'], $son123['class2']['id'], $son123['class3']['id'], $to_column_class123['class1']['id'], $son123['class2']['id'], $son123['class3']['id']);
                                    }
                                }
                            }
                        }

                        //移动到二级栏目
                        if ($to_column['classtype'] == 2) {
                            if ($to_column['releclass']) {
                                //被移动的是关联栏目
                                load::mod_class("{$module}/{$module}_op", 'new')->list_move($now_column_class123['class1']['id'], $now_column_class123['class2']['id'], $now_column_class123['class3']['id'], $to_column_class123['class1']['id'], $now_column['id'], 0);
                            } else {
                                //被移动的不是关联栏目
                                load::mod_class("{$module}/{$module}_op", 'new')->list_move($now_column_class123['class1']['id'], $now_column_class123['class2']['id'], $now_column_class123['class3']['id'], $to_column_class123['class1']['id'], $to_column_class123['class2']['id'], $now_column['id']);
                            }
                        }
                    }

                    //移动栏目
                    $list = array();
                    $list['id'] = $now_column['id'];
                    $list['bigclass'] = $to_column['id'];
                    $list['classtype'] = $to_column['classtype'] + 1;
                    $list['foldername'] = $to_column['foldername'];
                    $list['releclass'] = 0;
                    $this->database->update_by_id($list);
                    //删除多余文件夹
                    self::del_column_file($now_column);
                } else {
                    $list = array();
                    $list['id'] = $now_column['id'];
                    $list['bigclass'] = $to_column['id'];
                    $list['classtype'] = $to_column['classtype'] + 1;
                    $list['releclass'] = $to_column['id'];
                    $this->database->update_by_id($list);
                }

                //给下级栏目classtype加1 同模块栏目入口名称变更
                $sub_class_list = $this->database->get_column_by_bigclass($now_column['id']);
                foreach ($sub_class_list as $sub_class) {
                    $list = array();
                    $list['id'] = $sub_class['id'];
                    $list['classtype'] = 3;
                    $list['bigclass'] = $now_column['id'];
                    if($sub_class['module'] == $to_column['module']){
                        $list['foldername'] = $to_column['foldername'];
                    }
                    $this->database->update_by_id($list);
                }
            }
            return true;
        }
        $this->error[] = 'error';
        return false;
    }

    /**
     * 复制栏目到其他语言
     */
    public function doCopyToLang()
    {
        global $_M;
        $cid = $_M['form']['id'];
        $to_lang = $_M['form']['to_lang'];
        $is_contents = $_M['form']['is_contents'];
        $redata = array();

        if ($cid && $to_lang) {
            $allids = array($cid);
            $res = self::_copyToLang($cid, $to_lang, $is_contents, $allids);
            if ($res === true) {
                logs::addAdminLog('admin_colunmmanage_v6', 'columnmove1', 'jsok', 'doCopyToLang');
                buffer::clearColumn($to_lang);
                $redata['status'] = 1;
                $redata['msg'] = $_M['word']['jsok'];
            }
        } else {
            $redata['status'] = 0;
            #$redata['msg']      = 'error';
            $redata['msg'] = $this->error[0];
            $redata['error'] = $this->error;
            $redata['error_info'] = $this->error_info;
        }

        $this->ajaxReturn($redata);
    }

    /**
     * 复制栏目到其他语言
     * @param string $id
     * @param string $to_lang
     * @param int $is_contents
     * @param array $allids
     * @return bool
     */
    private function _copyToLang($id = '', $to_lang = '', $is_contents = 0, $allids = array())
    {
        global $_M;
        if (!$to_lang) {
            $this->error[] = $_M['word']['copyotherlang6'];
            return false;
        }
        if ($to_lang == $_M['lang']) {
            $this->error['error'] = 'Data error tolang same';
            return false;
        }

        //所有要复制的栏目id
        if (!$allids) {
            $this->error['error'] = 'not allids';
            return false;
        }

        if ($id && is_numeric($id) && $to_lang) {
            $c = load::sys_class('label', 'new')->get('column')->get_column_id($id);
            if ($c['classtype'] != 1) {
                //2,3级栏目不能单独复制
                $class123 = load::sys_class('label', 'new')->get('column')->get_class123_reclass($c['id']);
                if (!$this->copy_class_list[$class123['class1']['id']]) {
                    $this->error_info[$id] = $c['name'] . '_' . $_M['word']['copyotherlang5'];
                    $this->error[] = $_M['word']['copyotherlang5'];
                    return false;
                } else {
                    //已复制一级栏目的二级栏目 不再操作
                    return;
                }
            } else {
                $this->copy_class_list[$c['id']] = 1;
            }

            $columninfo = $this->database->get_column_by_foldername($c['foldername'], $to_lang);
            if ($columninfo[0]['id']) {
                //栏目在其他语言中已存在
                $this->error_info[$id] = $c['name'] . '_' . $_M['word']['copyotherlang4'];
                $this->error[] = $_M['word']['copyotherlang4'];
                return false;
            }

            $son_class2 = load::sys_class('label', 'new')->get('column')->get_column_son($id);
            foreach ($son_class2 as $key => $val) {
                if ($val['module'] != $c['module']) {
                    $columninfo = $this->database->get_column_by_foldername($val['foldername'], $to_lang);
                    if ($columninfo[0]['id']) {
                        $this->error_info[$id] = $c['foldername'] . $_M['word']['copyotherlang4'];
                        $this->error[] = $val['foldername'] . $_M['word']['copyotherlang4'];
                        return false;
                    }
                }
            }
            $res = load::mod_class('column/column_op', 'new')->copy_column($id, $_M['lang'], $to_lang, $is_contents, $allids);
            return $res;
        }

        $this->error['error'] = 'Data error';
        return false;
    }

    /**
     * 删除栏目
     */
    public function doDeleteColumn()
    {
        global $_M;
        if (!isset($_M['form']['id'])) {
            $this->error('error');
        }
        $id = $_M['form']['id'] ? $_M['form']['id'] : '';

        if ($id && is_numeric($id)) {
            $res = self::_delolumn($id);
            if ($res === true) {
                //写日志
                logs::addAdminLog('admin_colunmmanage_v6', 'delete', "jsok", 'doDeleteColumn');
                buffer::clearColumn();
                $this->success('', $_M['word']['jsok']);
            }
        }
        //写日志
        logs::addAdminLog('admin_colunmmanage_v6', 'delete', $this->error[0], 'doDeleteColumn');
        $this->error($this->error[0]);
    }

    /**
     * 删除栏目操作
     * @param $id
     */
    private function _delolumn($id)
    {
        global $_M;
        if ($id && is_numeric($id)) {
            $config_database = load::mod_class('config/config_database', 'new');
            $column = $this->database->get_list_one_by_id($id);

            if (!$column) {
                return false;
            }

            //删除下级不同模块文件夹
            $lv = load::mod_class('column/column_op', 'new')->get_sorting_by_lv();
            $module = load::sys_class('handle', 'new')->mod_to_name($column['module']);

            //删除栏目下内容
            self::del_column_content($column['module'], $id, $column['classtype']);
            $classtype = $column['classtype'] + 1;
            foreach ($lv['class' . $classtype][$id] as $key => $val) {
                $this->_delolumn($val['id']);
            }

            /*删除文件*/
            self::del_column_file($column);

            /*删除栏目图片*/
            self::fileUnlink($column['indeximg']);
            self::fileUnlink($column['columnimg']);

            /*删除栏目*/
            $this->database->del_by_id($column['id']);

            /*删除栏目配置*/
            if (intval($id) > 0) {
                $config_database->del_value_by_columnid($id);
                $config_database->del_value_by_flashid($id);
            }

            /*删除栏目banner配置*/
            load::mod_class('banner/banner_database', 'new')->update_flash_by_cid($id, $_M['lang']);

            //更改管理员应用权限
            load::mod_class("admin/admin_op", 'new')->modify_admin_column_accsess($id, 'c', 'del');
            return true;
        }
        $this->error[] = 'Data error';
        return false;
    }

    /***********EXT***********/

    /*删除栏目上传文件*/
    private function fileUnlink($file_name)
    {
        if (stristr(PHP_OS, "WIN")) {
            $file_name = @iconv("utf-8", "gbk", $file_name);
        }
        if (file_exists($file_name)) {
            //@chmod($file_name,0777);
            $area_lord = @unlink($file_name);
        }
        return $area_lord;
    }

    /**
     * 复制栏目配置
     * @param $foldername
     * @param $module
     * @param $id
     * @return bool
     */
    public function columnCopyconfig($foldername = '', $module = '', $id = '')
    {
        global $_M;
        if (!$foldername) return false;
        switch ($module) {
            case 1://简介
                $indexaddress = "../about/index.php";
                $newfile = PATH_WEB . $foldername . "/show.php";
                $address = "../about/show.php";
                $this->Copyfile($address, $newfile);
                break;
            case 2://新闻
                $indexaddress = "../news/index.php";
                $newfile = PATH_WEB . $foldername . "/news.php";
                $address = "../news/news.php";
                $this->Copyfile($address, $newfile);
                $newfile = PATH_WEB . $foldername . "/shownews.php";
                $address = "../news/shownews.php";
                $this->Copyfile($address, $newfile);
                break;
            case 3://产品
                $indexaddress = "../product/index.php";
                $newfile = PATH_WEB . $foldername . "/product.php";
                $address = "../product/product.php";
                $this->Copyfile($address, $newfile);
                $newfile = PATH_WEB . $foldername . "/showproduct.php";
                $address = "../product/showproduct.php";
                $this->Copyfile($address, $newfile);
                break;
            case 4://下载
                $indexaddress = "../download/index.php";
                $newfile = PATH_WEB . $foldername . "/download.php";
                $address = "../download/download.php";
                $this->Copyfile($address, $newfile);
                $newfile = PATH_WEB . $foldername . "/showdownload.php";
                $address = "../download/showdownload.php";
                $this->Copyfile($address, $newfile);
                // $newfile = PATH_WEB . $foldername . "/down.php";
                // $address = "../download/down.php";
                // $this->Copyfile($address, $newfile);
                break;
            case 5://图片
                $indexaddress = "../img/index.php";
                $newfile = PATH_WEB . $foldername . "/img.php";
                $address = "../img/img.php";
                $this->Copyfile($address, $newfile);
                $newfile = PATH_WEB . $foldername . "/showimg.php";
                $address = "../img/showimg.php";
                $this->Copyfile($address, $newfile);
                break;
            case 6://招聘
                $array = array();
                $array[] = array('met_cv_time', '120');
                $array[] = array('met_cv_image', '');
                $array[] = array('met_cv_showcol', '');
                $array[] = array('met_cv_emtype', '1');
                $array[] = array('met_cv_type', '');
                $array[] = array('met_cv_to', '');
                $array[] = array('met_cv_job_tel', '');
                $array[] = array('met_cv_back', '');
                $array[] = array('met_cv_email', '');
                $array[] = array('met_cv_title', '');
                $array[] = array('met_cv_content', '');
                $array[] = array('met_cv_sms_back', '');
                $array[] = array('met_cv_sms_tell', '');
                $array[] = array('met_cv_sms_content', '');
                $this->verbconfig($array, $id);
                break;
            case 7://留言
                $array = array();
                $array[] = array('met_msg_ok', '');
                $array[] = array('met_msg_time', '120');
                $array[] = array('met_msg_name_field', '');
                $array[] = array('met_msg_content_field', '');
                $array[] = array('met_msg_show_type', '1');
                $array[] = array('met_msg_type', '1');
                $array[] = array('met_msg_to', '');
                $array[] = array('met_msg_admin_tel', '');
                $array[] = array('met_msg_back', '');
                $array[] = array('met_msg_email_field', '');
                $array[] = array('met_msg_title', '');
                $array[] = array('met_msg_content', '');
                $array[] = array('met_msg_sms_back', '');
                $array[] = array('met_msg_sms_field', '');
                $array[] = array('met_msg_sms_content', '');
                $this->verbconfig($array, $id);
                break;
            case 8://反馈
                $indexaddress = "../feedback/index.php";
                $newfile = PATH_WEB . $foldername . "/feedback.php";
                $address = "../feedback/feedback.php";
                $column = $this->database->get_list_one_by_id($id);
                $met_fdtable = $column['name'];
                $this->Copyfile($address, $newfile);

                $array = array();
                $array[] = array('met_fd_ok', '');
                $array[] = array('met_fdtable', $met_fdtable);
                ###$array[] = array('met_fd_class', '');
                $array[] = array('met_fd_time', '120');
                $array[] = array('met_fd_related', '');
                $array[] = array('met_fd_showcol', '');
                $array[] = array('met_fd_inquiry', '');
                $array[] = array('met_fd_type', '');
                $array[] = array('met_fd_to', '');
                $array[] = array('met_fd_admin_tel', '');
                $array[] = array('met_fd_back', '');
                $array[] = array('met_fd_email', '');
                $array[] = array('met_fd_title', '');
                $array[] = array('met_fd_content', '');
                $array[] = array('met_fd_sms_back', '');
                $array[] = array('met_fd_sms_tell', '');
                $array[] = array('met_fd_sms_content', '');
                $this->verbconfig($array, $id);
                break;
            default :
                if ($module > 2000) $this->establishAppmodule($foldername, $module);
                break;
        }
        $this->Copyfile($indexaddress, PATH_WEB . $foldername . '/index.php');
    }

    /**
     * 创建栏目入口文件
     * @param $address
     * @param $newfile
     * @return bool|int
     */
    private function Copyfile($address, $newfile)
    {
        $oldcont = "<?php\n";
        $oldcont .= "# MetInfo Enterprise Content Management System \n";
        $oldcont .= "# Copyright (C) MetInfo Co.,Ltd (http://www.mituo.cn). All rights reserved. \n";
        $oldcont .= "require_once '$address';\n";
        $oldcont .= "# This program is an open source system, commercial use, please consciously to purchase commercial license.\n";
        $oldcont .= "# Copyright (C) MetInfo Co., Ltd. (http://www.mituo.cn). All rights reserved.\n";
        $oldcont .= "?>";
        $filename = str_replace(PATH_WEB, '', $newfile);
        $filename = preg_replace("/\/\w+\.php/", '', $filename);
        ##if (!file_exists($newfile) && !$this->unkmodule($filename)) {
        if (!$this->unkmodule($filename)) {
            makefile($newfile);
            return file_put_contents($newfile, $oldcont);
        }
    }

    /*是否是系统模块*/
    private function unkmodule($filename)
    {
        $modfile = array('app', 'admin', 'about', 'news', 'product', 'download', 'img', 'job', 'cache', 'config', 'install', 'feedback', 'include', 'lang', 'link', 'member', 'message', 'public', 'search', 'sitemap', 'templates', 'upload', 'wap', 'online', 'hits', 'shop', 'pay', 'tags', 'tag', '');
        $ok = 0;
        foreach ($modfile as $key => $val) {
            if ($filename == $val) {
                $ok = 1;
            }

        }
        return $ok;
    }

    /*文件夹名称是否可以用*/
    private function is_foldername_ok($foldername, $module)
    {
        global $_M;
        if (!$foldername) {
            return false;
        }

        $other = array('shop', 'pay');
        if (in_array($foldername, $other)) {
            return false;
        }
        $langs = load::mod_class('language/language_op', 'new')->get_lang();
        foreach ($langs as $langkey => $langval) {
            $smodule = load::mod_class('column/column_op', 'new')->get_sorting_by_module(false, $langval['mark']);
            foreach ($smodule as $mkey => $mval) {
                foreach ($mval['class1'] as $c1key => $c1val) {
                    if ($c1val['lang'] == $_M['lang']) {
                        if ($c1val['foldername'] == $foldername) {
                            return false;
                        }
                    } else {
                        if ($c1val['foldername'] == $foldername && $c1val['module'] != $module) {
                            return false;
                        }
                    }
                }
            }
        }
        return true;
    }

    /*应用模块创建时生成相应文件*/
    private function establishAppmodule($foldername = '', $no = '')
    {
        global $_M;
        $where = "where no='$no'";
        $addfile_type = $this->database->getdata($_M['table']['ifcolumn'], $where, '1');
        if ($addfile_type['addfile'] == 1) {
            $path = PATH_WEB . $foldername;
            mkdir($path, 0777);
            $where = "where no='$no'";
            $structure = $this->database->getdata($_M['table']['ifcolumn_addfile'], $where, '0');

            foreach ($structure as $key => $val) {
                $path = PATH_WEB . $foldername . '/' . $val[filename];
                $fp = fopen($path, "w+");
                $str = "<?php";
                $str .= "# MetInfo Enterprise Content Management System";
                $str .= "# Copyright (C) MetInfo Co.,Ltd (http://www.mituo.cn). All rights reserved.\n";
                fputs($fp, $str);
                fclose($fp);
            }
            $where = "where no='$no'";
            $structure1 = $this->database->getdata($_M['table']['ifcolumn_addfile'], $where, '0');

            foreach ($structure1 as $key => $val) {
                $straction[$val['filename']] .= "define('M_NAME', '" . $val['m_name'] . "');\n";
                $straction[$val['filename']] .= "define('M_MODULE', '" . $val['m_module'] . "');\n";
                $straction[$val['filename']] .= "define('M_CLASS', '" . $val['m_class'] . "');\n";

                if (substr($val['m_action'], 0, 1) == '$' || substr($val['m_action'], 0, 1) == '@') {
                    $straction[$val['filename']] .= "define('M_ACTION', " . $val['m_action'] . ");\n";
                } else {
                    $straction[$val['filename']] .= "define('M_ACTION', '" . $val['m_action'] . "');\n";
                }
                $straction[$val['filename']] .= "require_once '../app/app/entrance.php';\n";
            }

            foreach ($structure as $key => $val) {
                $path = PATH_WEB . $foldername . '/' . $val['filename'];
                $fp = fopen($path, "r");
                $read = fread($fp, filesize($path));
                fclose($fp);
                $fp = fopen($path, "w");
                $str = $read . $straction[$val['filename']] . "# This program is an open source system, commercial use, please consciously to purchase commercial license.
  # Copyright (C) MetInfo Co., Ltd. (http://www.mituo.cn). All rights reserved.
  ?>";
                fputs($fp, $str);
                fclose($fp);
            }
        }
    }

    /*生成反馈配置文件*/
    public function verbconfig($array, $id)
    {
        global $_M;
        $lang = $_M['lang'];
        $query = "where columnid='{$id}' and lang='{$lang}'";
        $count = DB::counter($_M['table']['config'], $query, "*");
        if ($count == 0) {
            foreach ($array as $key => $val) {
                $list = array();
                $list['name'] = $val[0];
                $list['value'] = $val[1];
                $list['columnid'] = $id;
                $list['flashid'] = 0;
                $list['lang'] = $_M['lang'];
                load::mod_class('config/config_database', 'new')->insert($list);
            }
        }
    }

    /**
     * 栓除栏目内容
     * @param $module
     * @param $cid
     * @param $classtype
     */
    public function del_column_content($module, $cid, $classtype)
    {
        global $_M;
        if ($module > 1 && $module < 10) {
            $module_name = load::sys_class('handle', 'new')->mod_to_file($module);
            $module_database = load::mod_class("{$module_name}/{$module_name}_database", 'new');

            if ($classtype == 1) {
                $list = $module_database->del_list_by_class123($cid, null, null);
            } elseif ($classtype == 2) {
                $list = $module_database->del_list_by_class123(null, $cid, null);
            } else {
                $list = $module_database->del_list_by_class123(null, null, $cid);
            }

            $para_list = load::mod_class('parameter/parameter_list_database', 'new');
            $para_list->construct($module);
            $para_list->del_parameter_by_class($classtype, $cid);

            foreach ($list as $c) {
                $para_list->del_by_listid($c['id']);
            }
        }
    }

    /**
     * 删除栏目文件
     * @param $column
     */
    private function del_column_file($column)
    {
        $admin_lists = $this->database->get_column_by_foldername($column['foldername']);
        //一级栏目
        if (!$admin_lists['id'] && ($column['classtype'] == 1 || $column['releclass'])) {
            //判断栏目所属模块
            if ($column['foldername'] != '' && ($column['module'] < 6 || $column['module'] == 8) && $column['if_in'] != 1) {
                if (!$this->unkmodule($column['foldername'])) {
                    $foldername = PATH_WEB . $column['foldername'];
                    $this->deldir($foldername);
                }
            }
        }
    }

    /**
     * @param $dir
     * @param int $dk
     * @return bool
     */
    private function deldir($dir, $dk = 1)
    {
        global $_M;
        $dh = opendir($dir);
        while ($file = readdir($dh)) {
            if ($file != "." && $file != "..") {
                $fullpath = $dir . "/" . $file;
                if (!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    deldir($fullpath);
                }
            }
        }
        closedir($dh);
        if ($dk == 0 && $dir != PATH_WEB . 'upload') {
            $dk = 1;
        }

        if ($dk == 1) {
            if (rmdir($dir)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * 编辑栏目列表
     * @param $id
     * @param $list
     */
    public function list_editor($id, $list)
    {
        global $_M;
        if ($id && is_numeric($id)) {
            $alist['id'] = $id;
            $alist['name'] = $list['name-' . $id];
            $alist['no_order'] = $list['no_order-' . $id];
            $alist['nav'] = $list['nav-' . $id];
            $this->database->update_by_id($alist);
            return true;
        }
        $this->error[] = 'error';
        return false;
    }

    /**
     * 栏目列表操作
     */
    public function dolistsave()
    {
        global $_M;
        $redata = array();
        $error_num = 0;
        $list = explode(",", $_M['form']['allid']);
        $allid = $list;
        foreach ($list as $id) {
            if ($id && is_numeric($id)) {
                switch ($_M['form']['submit_type']) {
                    case 'save':
                        $log_name = 'save';
                        $res = $this->list_editor($id, $_M['form']);
                        break;
                    case 'del':
                        $log_name = 'delete';
                        $res = $this->_delolumn($id);
                        break;
                    case 'copy':
                        $log_name = 'Copy';
                        $to_lang = $_M['form']['to_lang'];
                        $is_contents = $_M['form']['is_contents'];
                        $res = self::_copyToLang($id, $to_lang, $is_contents, $allid);
                        break;
                }
                if ($res != true) {
                    $error_num++;
                    continue;
                }
            } else {
                $this->error[] = "Data error";
                break;
            }
        }

        if ($this->error) {
            $redata['status'] = 0;
            #$redata['msg']      = $_M['word']['dataerror'];
            $redata['msg'] = $this->error[0];
            $redata['error'] = $this->error;
            $redata['error_info'] = $this->error_info;
            //写日志
            logs::addAdminLog('admin_colunmmanage_v6', $log_name, 'dataerror', 'dolistsave');
        } else {
            $redata['status'] = 1;
            $redata['msg'] = $_M['word']['jsok'];
            //写日志
            logs::addAdminLog('admin_colunmmanage_v6', $log_name, 'jsok', 'dolistsave');
            buffer::clearColumn();
        }
        $this->ajaxReturn($redata);


    }

    /**********************************/

    public function list_add($id, $list)
    {
        global $_M;
        //$list['id'] = $id;
        $if_in = $_M['form']['module-' . $id] ? 0 : 1;
        $bigclass = $this->database->get_column_by_id($_M['form']['bigclass-' . $id]);
        if ($bigclass) {
            $classtype = $bigclass['classtype'] + 1;
            $releclass = $bigclass['module'] == $_M['form']['module-' . $id] ? 0 : $list['bigclass-' . $id];
        } else {
            $classtype = 1;
            $releclass = 0;
        }
        $alist['name'] = $list['name-' . $id];
        if (!trim($alist['name'])) {
            turnover("{$_M['url']['own_form']}&a=doindex", "{$_M['word']['column_descript1_v6']}", 0);
        }
        if (preg_match("/[<\x{4e00}-\x{9fa5}>]+/u", $_M['form']['foldername-' . $id])) {
            //中文目录
            turnover("{$_M['url']['own_form']}&a=doindex", "{$_M['word']['column_descript1_v6']}", 0);
        }
        $mod = load::sys_class('handle', 'new')->file_to_mod($_M['form']['foldername-' . $id]);

        if ($mod && $mod != $_M['form']['module-' . $id]) {
            turnover("{$_M['url']['own_form']}&a=doindex", "{$_M['word']['columndeffflor']}", 0);
        }
        if ($bigclass['module'] == $_M['form']['module-' . $id]) {
            $alist['foldername'] = $bigclass['foldername'];
        } else {
            //验证模块是否可以用
            if (!$if_in) {
                #die($_M['form']['foldername-' . $id]);
                if (!$this->is_foldername_ok($_M['form']['foldername-' . $id], $_M['form']['module-' . $id])) {
                    turnover("{$_M['url']['own_form']}&a=doindex", "{$_M['word']['column_descript1_v6']}", 0);
                }
            }
            $alist['foldername'] = $list['foldername-' . $id];
        }
        $alist['filename'] = '';
        $alist['bigclass'] = $list['bigclass-' . $id];
        $alist['samefile'] = 0;
        $alist['module'] = $list['module-' . $id];
        $alist['no_order'] = $list['no_order-' . $id];
        $alist['wap_ok'] = 0;
        $alist['wap_nav_ok'] = 0;
        $alist['if_in'] = $if_in;
        $alist['nav'] = $list['nav-' . $id];
        $alist['ctitle'] = '';
        $alist['keywords'] = '';
        $alist['content'] = '';
        $alist['description'] = '';
        $alist['list_order'] = 1;
        $alist['new_windows'] = 0;
        $alist['classtype'] = $classtype;//可以用bigclass计算得出
        $alist['out_url'] = $list['out_url-' . $id];
        $alist['index_num'] = $list['index_num-' . $id];
        $alist['indeximg'] = '';
        $alist['columnimg'] = '';
        $alist['isshow'] = 1;
        $alist['lang'] = $_M['lang'];
        $alist['namemark'] = '';
        $alist['releclass'] = $releclass;//可以用bigclass计算得出
        $alist['display'] = 0;
        $alist['icon'] = '';
        $alist['foldername'] = $list['foldername-' . $id];
        if ($if_in) {
            $alist['foldername'] = '';
        } else {
            $alist['out_url'] = '';
        }
        if ($list['filename']) {
            $filenames = $this->database->get_column_by_filename($list['filename']);
            if ($filenames && $filenames['id'] != $list['id']) {
                turnover("{$_M['url']['own_form']}}&a=doindex", $_M['word']['jsx27'], 0);
            }
        }
        $id = $this->database->insert($alist);
        if ($id) {
            $this->columnCopyconfig($alist['foldername'], $alist['module'], $id);
            //更改管理员栏目权限
            load::mod_class("admin/admin_op", 'new')->modify_admin_column_accsess($id ,'c', 'add');
        }
        return $id;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
