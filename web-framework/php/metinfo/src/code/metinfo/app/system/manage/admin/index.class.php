<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.


defined('IN_MET') or exit('No permission');
load::mod_class('base/admin/base_admin');


class index extends base_admin
{
    public function __construct()
    {
        global $_M;
        parent::__construct();
    }

    /**
     * 内容管理
     */
    public function doGetContentList()
    {
        global $_M;
        $redata = array();
        $class = $_M['form']['class'];
        $content_type = $_M['form']['content_type'];

        $list = self::_getColnumList($class, $content_type);
        $redata['status'] = 1;
        $redata['data']['list'] = $list;

        $this->ajaxReturn($redata);
    }

    private function _getColnumList($class_id = '', $content_type = 0)
    {
        global $_M;
        $admin = admin_information();
        $metinfo_admin_name = $admin['admin_id'];
        $met_content_type = $admin['content_type'];
        if ($met_content_type == 0) {
            $query = "select content_type from {$_M['table']['admin_table']} where admin_id='{$metinfo_admin_name}'";
            $met_content_type1 = DB::get_one($query);
            $met_content_type = $met_content_type1['content_type'];
        }
        $query = "update {$_M['table']['admin_table']} set content_type='1' where admin_id='{$metinfo_admin_name}'";
        DB::query($query);

        if (!$content_type) {
            $content_type = $met_content_type;
        }

        if ($content_type == 2) {
            //自定义管理员不可查看
            if ($admin['admin_group'] == 0) {
                return;
            }
            //内容管理员-按模块获取能容列表
            $contents = self::getContentBymodule();
            return $contents;
        } else {
            //按栏目获取能容列表
            $contents = self::getContentByColumn();
            return $contents;
        }
    }

    /**
     * 按模块获取能容列表
     * @param string $class_id
     * @return array
     */
    private function getContentBymodule()
    {
        global $_M;
        $content_list = array();
        $columns = load::mod_class('column/column_database', 'new')->get_all_column_by_lang($_M['lang']);

        foreach ($columns as $column) {
            if (($column['classtype'] == 1 or ($column['releclass'] > 0 and (in_array($column['module'], array(1, 2, 3, 4, 5, 6, 7, 8))))) or $column['module']==6 and $column['if_in'] == 0) {
                $met_classindex[$column['module']][] = $column;
            }
        }

        foreach ($met_classindex as $mod => $column) {
            if ($mod > 0 && $mod <= 8) {
                $content_list[$mod]['name'] = modname($mod);
                $content_list[$mod]['classtype'] = 1;
                $content_list[$mod]['url'] = self::getModContentLink($column[0], 'mod');
                if(in_array($mod, array(6,7))) {
                    $content_list[$mod]['url'].='&class1='.$column[0]['id'];
                }
                if ($mod == 6) {
                    $content_list[$mod]['url'] = '';
                    foreach ($column as $row) {
                        $class123 = load::sys_class('label', 'new')->get('column')->get_class123_no_reclass($row['id']);
                        $job_column = array();
                        $job_column['name'] = $row['name'];
                        $job_column['classtype']=2;
                        $job_column['url'].="?n=job&class1={$class123['class1']['id']}&class2={$class123['class2']['id']}&class3={$class123['class3']['id']}";
                        $content_list[$mod]['subcolumn'][] = $job_column;
                    }
                }

                if ($mod == 8) {
                    $content_list[$mod]['url'] = '';
                    foreach ($column as $row) {
                        $class123 = load::sys_class('label', 'new')->get('column')->get_class123_no_reclass($row['id']);
                        $feed_column = array();
                        $feed_column['name'] = $row['name'];
                        $feed_column['classtype']=2;
                        $feed_column['url'].='?n=feedback&class1='.$row['id'];
                        $feed_column['url'] .= "?n=feedback&class1={$class123['class1']['id']}&class2={$class123['class2']['id']}&class3={$class123['class3']['id']}";
                        $content_list[$mod]['subcolumn'][] = $feed_column;
                    }
                }
            }
        }
        return $content_list;
    }

    /**
     * 按栏目获取内容列表
     * @param string $class_id
     * @return mixed
     */
    private function getContentByColumn($class_id = '')
    {
        global $_M;
        $array = column_sorting(2);
        $column_list = array();
        $sys_column = load::mod_class('column/sys_column', 'new');

        foreach ($array['class1'] as $key1 => $col_v1) {
            if($col_v1['module']==0 || $col_v1['module']>8){continue;}
            $col_v1['module_name'] = $sys_column->module($col_v1['module']);
            $col_v1['url'] = self::getModContentLink($col_v1);
            if ($class2 = $array['class2'][$col_v1['id']]) {
                $col_v1['url'] = $col_v1['module'] == 6 ? '' : $col_v1['url'];  //招聘模块有二级栏目直接进入二级栏目管理
                foreach ($class2 as $key2 => $col_v2) {
                    $col_v2['url'] = self::getModContentLink($col_v2);
                    if ($class3 = $array['class3'][$col_v2['id']]) {
                        foreach ($class3 as $key3 => $col_v3) {
                            $col_v3['url'] = self::getModContentLink($col_v3);
                            $col_v2['subcolumn'][] = $col_v3;
                        }
                    }
                    $col_v1['subcolumn'][] = $col_v2;
                }
            }
            $column_list[] = $col_v1;
        }

        return $column_list;
    }


    /**
     * 内容列表连接
     * @param string $mod
     * @param $class_id
     * @return string
     */
    private function getModContentLink($column = array(), $c_type = 'column')
    {
        global $_M;
        //收索
        if ($column['module'] == 11) {
            /*$url = "#/seo/?head_tab_active=6";
            return $url;*/
        }

        //网站地图
        if ($column['module'] == 12){
            $url = "#/seo/?head_tab_active=4";
            return $url;
        }

        //集合标签
        if ($column['module'] == 13) {
            $url = "#/seo/?head_tab_active=6";
            return $url;
        }

        $class123 = load::sys_class('label', 'new')->get('column')->get_class123_no_reclass($column['id']);
        if ($class123) {
            $para_class123 = '';
            $para_class123 .= $class123['class1']['id'] ? "&class1={$class123['class1']['id']}" : '';
            $para_class123 .= $class123['class2']['id'] ? "&class2={$class123['class2']['id']}" : '';
            $para_class123 .= $class123['class3']['id'] ? "&class3={$class123['class3']['id']}" : '';
        }
        $mod_name = load::sys_class('handle', 'new')->mod_to_file($column['module']);

        if ($c_type == 'mod') {
            $url = "lang={$this->lang}&n={$mod_name}&c={$mod_name}_admin&a=dojson_list";
            return $url;
        } else {
            #$url = "lang={$this->lang}&n={$mod_name}&c={$mod_name}_admin&a=doindex" . $para_class123;
            $url = "lang={$this->lang}&n={$mod_name}&c={$mod_name}_admin&a=dojson_list&" . $para_class123;
            if ($column['isshow'] == 0 && ($column['module'] == 1)) {
                return '';
            }
            return $url;
        }
    }

    /*
     * 栏目列表连接
     */
    private function getColumnList($mod)
    {
        $mod_name = load::sys_class('handle', 'new')->mod_to_file($mod);
        $url = "lang={$this->lang}&n={$mod_name}&c={$mod_name}_admin&a=docolumnjson";
        return $url;
    }

    /**
     * 收索栏目
     */
    public function dosearch()
    {
        global $_M;
        $redata = array();
        $search_contnet = $_M['form']['search_contnet'];
        if ($search_contnet) {
            $content = self::_search($search_contnet);
            $redata['status'] = 1;
            $redata['data']['list'] = $content;
            $this->ajaxReturn($redata);
        }
        $this->doGetContentList();
    }

    /**
     * 收索
     * @param string $search_contnet
     * @return array
     */
    private function _search($search_contnet = '')
    {
        global $_M;
        $query = "select * from {$_M['table']['column']} where name like '%{$search_contnet}%' and lang='{$this->lang}' and module <= 8";
        $column_list = DB::get_all($query);

        $list = array();
        foreach ($column_list as $key1 => $class1) {
            $class1['url'] = self::getModContentLink($class1);
            $class1_son = load::sys_class('label', 'new')->get('column')->get_column_son($class1['id']);
            if ($class1_son) {
                foreach ($class1_son as $key2 => $class2) {
                    $class2['url'] = self::getModContentLink($class2);
                    $class2_son = load::sys_class('label', 'new')->get('column')->get_column_son($class2['id']);
                    if ($class2_son) {
                        foreach ($class2_son as $key3 => $class3) {
                            $class3['url'] = self::getModContentLink($class3);
                        }
                        $class2['subcolumn'][] = $class3;
                    }
                    $class1['subcolumn'][] = $class2;
                }
            }
            $list[$key1] = $class1;
        }
        return $list;

    }

    /**
     * 添加内容的选择栏目json
     */
    public function docolumnjson()
    {
        global $_M;
        $list['citylist']=array();
        $columnlist=column_sorting();
        foreach ($columnlist['class1'] as $key => $value) {
            if($value['module']>=2 && $value['module']<=6){
                $column_json = parent::column_json($value['module'],1,$value['id']);
                $list['citylist']=array_merge($list['citylist'],$column_json['citylist']);
            }
        }
        if($_M['form']['noajax']){
            $list=array(
                'columnlist'=>$list['citylist'],
                'columnlist_json'=>jsonencode($list['citylist'])

            );
            return $list;
        }
        $this->ajaxReturn($list);
    }


    /**
     * 获取特定语言下的栏目列表
     */
    public function doGetLangColumn()
    {
        global $_M;
        $tolang = $_M['form']['tolang'];
        $module = $_M['form']['module'];
        $mod = load::sys_class('handle', 'new')->file_to_mod($module);

        $column_list = self::getColumnjson($mod , $tolang);
        #dump($column_list);
        $this->ajaxReturn($column_list);
    }

    /**
     * 栏目列表处理
     * @param string $module
     * @param string $tolang
     * @return array
     */
    private function getColumnjson($module = '', $tolang = '')
    {
        global $_M;
        $array = self::_getColumnjson($module, $tolang);

        $metinfo = array();
        $i = 0;
        $metinfo['citylist'][$i]['p']['name'] = "{$_M['word']['columnselect1']}";
        $metinfo['citylist'][$i]['p']['value'] = '';

        foreach ($array['class1'] as $key => $val) { //一级级栏目

            if ($val['module'] == $module) {
                $i++;
                $metinfo['citylist'][$i]['p']['name'] = $val['name'];
                $metinfo['citylist'][$i]['p']['value'] .= $val['id'];

                if (count($array['class2'][$val['id']])) { //二级栏目
                    $k = 0;
                    $metinfo['citylist'][$i]['c'][$k]['n']['name'] = "{$_M['word']['modClass2']}";
                    $metinfo['citylist'][$i]['c'][$k]['n']['value'] = '';
                    $k++;

                    foreach ($array['class2'][$val['id']] as $key => $val2) {
                        $metinfo['citylist'][$i]['c'][$k]['n']['name'] = $val2['name'];
                        $metinfo['citylist'][$i]['c'][$k]['n']['value'] = $val2['id'];

                        if (count($array['class3'][$val2['id']])) { //三级栏目
                            $j = 0;
                            $metinfo['citylist'][$i]['c'][$k]['a'][0]['s']['name'] = "{$_M['word']['modClass3']}";
                            $metinfo['citylist'][$i]['c'][$k]['a'][0]['s']['value'] = '';
                            $j++;

                            foreach ($array['class3'][$val2['id']] as $key => $val3) {
                                $metinfo['citylist'][$i]['c'][$k]['a'][$j]['s']['name'] = $val3['name'];
                                $metinfo['citylist'][$i]['c'][$k]['a'][$j]['s']['value'] = $val3['id'];
                                $j++;
                            }
                        }
                        $k++;
                    }
                }
            }
        }

        return $metinfo;
        ##$this->ajaxReturn($array);
    }

    /**
     * 获取栏目
     * @param  string $type
     * @param  string $module 模块
     * @return array  栏目数组
     */
    private function _getColumnjson($module = '', $tolang = '')
    {
        //理顺被关联的栏目
        $array = column_sorting(2,$tolang);

        $newarray = array();
        foreach ($array['class1'] as $key => $val) {
            if ($val['module'] == $module) {
                $newarray['class1'][] = $val;
            }
        }

        foreach ($array['class2'] as $key => $val) {
            foreach ($val as $val2) {
                if ($val2['module'] == $module) {
                    if ($val2['releclass']) {
                        $newarray['class1'][] = $val2;
                        if (count($array['class3'][$val2['id']])) {
                            $newarray['class2'][$val2['id']] = $array['class3'][$val2['id']];
                        }
                    } else {
                        $newarray['class2'][$val2['bigclass']][] = $val2;
                    }
                }
            }
        }
        foreach ($array['class3'] as $key => $val) {
            foreach ($val as $key1 => $val3) {
                # code...
                if (!$val3['releclass']) {
                    $newarray['class3'][$key][$key1] = $val3;
                }
            }
        }

        return $newarray;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.