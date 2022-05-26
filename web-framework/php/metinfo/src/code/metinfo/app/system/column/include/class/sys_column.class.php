<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');
load::sys_func('file');
/**
 * 栏目标签类
 */

class sys_column
{
    /**
     * @var array
     */
    private $met_class1 = array();

    /**
     * @var array
     */
    private $met_class2 = array();

    /**
     * @var array
     */
    private $met_class3 = array();


    /**
     * 初始化
     */
    public function __construct()
    {
        global $_M;
        $this->lang = $_M['lang'];
        self::getMetColum();
    }

    /**
     * 1 2 3 级栏目列表
     */
    private function getMetColum()
    {
        $array = load::mod_class('column/column_op', 'new')->get_sorting_by_lv();
        $this->met_class1 = $array['class1'];
        $this->met_class2 = $array['class2'];
        $this->met_class3 = $array['class3'];
    }

    /**
     * 栏目列表
     * @return array
     */
    public function getColumnList()
    {
        global $_M;
        $met_class1 = $this->met_class1;
        $met_class2 = $this->met_class2;
        $met_class3 = $this->met_class3;

        $met_class1 = self::class_arr($met_class1, 1);
        $met_class2 = self::class_arr($met_class2, 2);
        $met_class3 = self::class_arr($met_class3, 3);


        foreach ($met_class1 as $key => $col1) {
            $col1 = $this->handle_show_column($col1);
            $col1['action'] = self::getColumnAction($col1);

            if ($met_class2[$col1['id']]) {
                foreach ($met_class2[$col1['id']] as $key2 => $col2) {
                    $col2 = $this->handle_show_column($col2);
                    $col2['action'] = self::getColumnAction($col2);

                    if ($met_class3[$col2['id']]) {
                        foreach ($met_class3[$col2['id']] as $key3 => $col3) {
                            $col3 = $this->handle_show_column($col3);
                            $col3['action'] = self::getColumnAction($col3);
                            $col2['subcolumn'][$key3] = $col3;
                        }

                    }
                    $col1['subcolumn'][$key2] = $col2;
                }
            }
            $columnlist[] = $col1;
        }

        return $columnlist;
    }

    public function class_arr($class_list = array(), $class_type = 1)
    {
        global $_M;
        if ($class_type == 1) {
            $new_list = array();
            foreach ($class_list as $key => $class) {
                $new_list[$key] = self::para_column($class);
            }
            return $new_list;
        }

        if ($class_type == 2) {
            $new_list = array();
            foreach ($class_list as $key1 => $class1) {
                foreach ($class1 as $key2 => $class2) {
                    $new_list[$key1][$key2] = self::para_column($class2);
                }
            }
            return $new_list;
        }

        if ($class_type == 3) {
            $new_list = array();
            foreach ($class_list as $key2 => $class2) {
                foreach ($class2 as $key3 => $class3) {
                    $new_list[$key2][$key3] = self::para_column($class3);
                }
            }
            return $new_list;
        }
    }

    /**
     * 处理栏目数据
     * @param array $class
     * @return array
     */
    public function para_column($class = array())
    {
        $new_data = array();
        $new_data['id'] = $class['id'];
        $new_data['name'] = $class['name'];
        $new_data['module'] = $class['module'];
        $new_data['foldername'] = $class['foldername'];
        $new_data['no_order'] = $class['no_order'];
        $new_data['nav'] = $class['nav'];
        $new_data['bigclass'] = $class['bigclass'];
        $new_data['classtype'] = $class['classtype'];
        $new_data['releclass'] = $class['releclass'];
        $new_data['if_in'] = $class['if_in'];
        $new_data['out_url'] = $class['out_url'];

        return $new_data;
    }


    /**
     * 栏目操作
     * @param array $column
     * @return array
     */
    public function getColumnAction($column = array())
    {
        global $_M;
        $col_lev = self::getColumnLev();    //获取栏目层级深度
        $column_lv_1 = $col_lev[1];         //一级栏目层级
        $column_lv_2 = $col_lev[2];         //二级栏目层级
        $met_class1 = $this->met_class1;
        $met_class2 = $this->met_class2;
        $met_class3 = $this->met_class3;
        $action = array();

        if ($column['classtype'] != 3 && in_array($column['module'], array(1, 2, 3, 4, 5))) {
            //可以添加下级栏目
            $action['add_subcolumn'] = 1;
        }

        if ($column['module'] == 6 && ($column['classtype'] == 1 || ($column['classtype'] == 2 && $column['releclass']))) {
            //招聘模块允许添加下级栏目
            $action['add_subcolumn'] = 1;
        }

        if (!($column_lv_1[$column['id']] == 3 && $column['classtype'])) {
            //可移动栏目
            $action['columnmove'] = 1;
            $action['move_columns'] = array();

            if ($column['classtype'] != 1) {
                //可以升级顶级栏目
                if ($column['releclass']) {
                    //可直接升级
                    $action['top_column'] = 1;
                } else {
                    //招聘模块的的二级栏目不能升为一级栏目
                    if ($column['module'] != 6) {
                        //提示输入栏目目录名称
                        $action['top_column'] = 2;
                    }
                }
            }
            if ($column['classtype'] == 1) {
                //一级栏目移动
                foreach ($met_class1 as $ckey => $cval) {
                    if (in_array($cval['module'], array(1, 2, 3, 4, 5)) && $cval['id'] != $column['id']) {
                        //判断一级栏目子栏目是是否包含不同模块栏目
                        $diff_sub = 0;
                        foreach ($met_class2[$column['id']] as $sub2) {
                            if ($sub2['module'] != $column['module'] && $sub2['module'] != 0 && in_array($sub2['module'], array(1, 2, 3, 4, 5, 6))) {
                                $diff_sub = 1;
                            }
                        }

                        if ($diff_sub) {
                            //子栏目包含不同模块只能移动到同栏目模块
                            $action['columnmove'] = ''; //不可移动
                        } else {
                            //子栏目不包含不同模块
                            $action['move_columns'][] = array(
                                'id' => $cval['id'],
                                'name' => $cval['name'],
                                'module' => $cval['module'],
                            );
                        }
                    }

                    if (!$diff_sub) {
                        //一级栏目没有子栏目时可移动到同模块的二级栏目
                        if (in_array($cval['module'], array(1, 2, 3, 4, 5)) && ($cval['module'] == $column['module'] || $column['module'] == 0) && !$met_class2[$column['id']]) {
                            foreach ($met_class2[$cval['id']] as $c2key => $c2val) {
                                if ($c2val['module'] == $column['module']) {
                                    $action['move_columns'][] = array(
                                        'id' => $c2val['id'],
                                        'name' => " - - " . $c2val['name'],
                                        'module' => $c2val['module'],
                                    );
                                }
                            }
                        }
                    }
                }
            } elseif ($column['classtype'] == 2) {
                //二级栏目同栏目移动
                if ($column['module'] == 6 && !$column['releclass']) {
                    $action['columnmove'] = ''; //非关联栏目的二级招聘栏目不可移动
                }
                foreach ($met_class1 as $ckey => $cval) {
                    if (in_array($cval['module'], array(1, 2, 3, 4, 5)) && $cval['id'] != $column['bigclass']) {
                        if (in_array($column['module'], array(2, 3, 4, 5))) {//带列表的二级栏目只能同模块移动
                            if (($cval['module'] == $column['module'] || $column['module'] == 0)) {
                                $action['move_columns'][] = array(
                                    'id' => $cval['id'],
                                    'name' => $cval['name'],
                                    'module' => $cval['module'],
                                );
                            }
                        } else {
                            $action['move_columns'][] = array(
                                'id' => $cval['id'],
                                'name' => $cval['name'],
                                'module' => $cval['module'],
                            );
                        }
                    }

                    foreach ($met_class2[$cval['id']] as $c2key => $c2val) {
                        if (in_array($c2val['module'], array(1, 2, 3, 4, 5)) && $c2val['id'] != $column['id'] && ($c2val['module'] == $column['module'] || $column['module'] == 0) && !$met_class3[$column['id']]) {
                            $action['move_columns'][] = array(
                                'id' => $c2val['id'],
                                'name' => " - - " . $c2val['name'],
                                'module' => $c2val['module']
                            );
                        }
                    }
                }
            } else {
                if ($column['module'] == 6) {
                    $action['columnmove'] = ''; //不可移动
                }
                //三级栏目同栏目移动
                foreach ($met_class1 as $ckey => $cval) {
                    if (in_array($cval['module'], array(1, 2, 3, 4, 5))) {
                        if (in_array($column['module'], array(2, 3, 4, 5))) {
                            if ($cval['module'] == $column['module'] || $column['module'] == 0) {
                                $action['move_columns'][] = array(
                                    'id' => $cval['id'],
                                    'name' => $cval['name'],
                                    'module' => $cval['module'],
                                );
                            }
                        } else {
                            $action['move_columns'][] = array(
                                'id' => $cval['id'],
                                'name' => $cval['name'],
                                'module' => $cval['module'],
                            );
                        }
                    }
                    foreach ($met_class2[$cval['id']] as $c2key => $c2val) {
                        if (in_array($c2val['module'], array(1, 2, 3, 4, 5)) && $c2val['id'] != $column['bigclass'] && ($c2val['module'] == $column['module'] || $column['module'] == 0)) {
                            $action['move_columns'][] = array(
                                'id' => $c2val['id'],
                                'name' => " - - " . $c2val['name'],
                                'module' => $c2val['module']
                            );
                        }
                    }
                }
            }
        }

        return $action;
    }

    /**
     * 栏目深度
     * @return array
     */
    private function getColumnLev()
    {
        $met_class1 = $this->met_class1;
        $met_class2 = $this->met_class2;
        $met_class3 = $this->met_class3;

        foreach ($met_class1 as $key => $val) {
            $column_lv[$val['id']] = 1;
            /*二级栏目处理*/
            foreach ($met_class2[$val['id']] as $key2 => $val2) {
                if (!$val2['releclass'] && $column_lv[$val['id']] && $column_lv[$val['id']] < 2) {
                    //一级栏目深度
                    $column_lv[$val['id']] = 2;
                }
                /*三级栏目处理*/
                foreach ($met_class3[$val2['id']] as $key3 => $val3) {
                    if (/*!$val2['releclass'] && */
                        $column_lv[$val['id']] && $column_lv[$val['id']] < 3) {
                        //一级栏目深度
                        $column_lv[$val['id']] = 3;
                    }
                    $column_lv_2[$val2['id']] = 1;//二级栏目有下级栏目
                }
            }
        }

        $col_lev = array();
        $col_lev[1] = $column_lv;
        $col_lev[2] = $column_lv_2;
        return $col_lev;
    }


    /**
     * @param array $c
     * @return array
     */
    private function handle_show_column($c = array())
    {
        global $_M;
        if ($c['if_in'] && $c['module'] < 1000) {
            $c['foldername'] = $c['out_url'];
        }
        /*$c['nav_option'] = array(
            array('name' => $_M['word']['columnnav1'], 'val' => 0),
            array('name' => $_M['word']['columnnav2'], 'val' => 1),
            array('name' => $_M['word']['columnnav3'], 'val' => 2),
            array('name' => $_M['word']['columnnav4'], 'val' => 3),
        );*/
        $c['name'] = str_replace('"', '&#34;', str_replace("'", '&#39;', $c['name']));
        $c['content'] = addslashes($c['content']);
        $c['module_name'] = self::module($c['module']);
        return $c;
    }

    /**
     * 栏目编号
     * @param $module
     * @return string
     */
    public function module($module)
    {
        global $_M;
        if ($module > 1000) {//应用模块
            $getapp = load::mod_class('myapp/getapp', 'new');
            $app = $getapp->get_oneapp($module);
            if ($app) {
                return $module = $app['appname'];
            }
        }

        switch ($module) {
            case '0':
                $module = $_M['word']['modout'];
                break;
            case '1':
                $module = $_M['word']['mod1'];
                break;
            case '2':
                $module = $_M['word']['mod2'];
                break;
            case '3':
                $module = $_M['word']['mod3'];
                break;
            case '4':
                $module = $_M['word']['mod4'];
                break;
            case '5';
                $module = $_M['word']['mod5'];
                break;
            case '6':
                $module = $_M['word']['mod6'];
                break;
            case '7':
                $module = $_M['word']['mod7'];
                break;
            case '8':
                $module = $_M['word']['mod8'];
                break;
            case '9':
                $module = $_M['word']['mod9'];
                break;
            case '10':
                $module = $_M['word']['mod10'];
                break;
            case '11':
                $module = $_M['word']['mod11'];
                break;
            case '12':
                $module = $_M['word']['mod12'];
                break;
            case '13':
                $module = $_M['word']['tag'];
                break;
            case '100':
                $module = $_M['word']['mod100'];
                break;
            case '101':
                $module = $_M['word']['mod101'];
                break;
        }
        return $module;
    }

    public function module_list()
    {
        global $_M;
        $array[] = array('name' => $_M['word']['modout'], 'mod' => 0);//外部模块
        $array[] = array('name' => $_M['word']['mod1'], 'mod' => 1);//简介
        $array[] = array('name' => $_M['word']['mod2'], 'mod' => 2);//文章
        $array[] = array('name' => $_M['word']['mod3'], 'mod' => 3);//产品
        $array[] = array('name' => $_M['word']['mod4'], 'mod' => 4);//下载
        $array[] = array('name' => $_M['word']['mod5'], 'mod' => 5);//图片
        $array[] = array('name' => $_M['word']['mod6'], 'mod' => 6);//招聘
        $array[] = array('name' => $_M['word']['mod7'], 'mod' => 7);//留言     message
        $array[] = array('name' => $_M['word']['mod8'], 'mod' => 8);//反馈
        ##$array[] = array('name'=>$_M['word']['mod9'],'mod'=>9);//友情链接
        $array[] = array('name' => $_M['word']['mod10'], 'mod' => 10);//会员   member
        $array[] = array('name' => $_M['word']['mod11'], 'mod' => 11);//搜索   search
        $array[] = array('name' => $_M['word']['mod12'], 'mod' => 12);//网站地图 sitemap
        $array[] = array('name' => $_M['word']['tag'], 'mod' => 13);//tag标签 tags
        $ifcolumn = load::mod_class('column/ifcolumn_database', 'new')->get_all();
        foreach ($ifcolumn as $key => $val) {
            $array[] = array('name' => $val['name'], 'mod' => $val['no']);
        }
        return $array;
    }

    public function nav_list()
    {
        global $_M;
        $nav_list = array(
            '0' => $_M['word']['columnnav1'],
            '1' => $_M['word']['columnnav2'],
            '2' => $_M['word']['columnnav3'],
            '3' => $_M['word']['columnnav4'],
        );
        return $nav_list;
    }

}
# This program is an open source system, commercial use, please consciously to purchase commercial license.;
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
