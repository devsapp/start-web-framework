<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('web');

class open extends web
{ //一键登录功能

    public function __construct()
    {
        parent::__construct();
    }

    public function doctun()
    {
        global $_M;
        $columns = load::mod_class('column/column_database', 'new')->get_all_column_by_lang($_M['lang']);
        foreach ($columns as $key => $val) {
            if ($val['display'] == 1){//前台隐藏栏目
                continue;
            }
            if (in_array($val['module'], array(2, 3, 4, 5))) {
                if ($val['classtype'] == 1) {
                    $sorting['class1'][$key] = $columns[$key];
                }
                if (in_array($val['module'], array(2, 3, 4, 5))) {
                    if ($val['classtype'] == 2) {
                        $sorting['class2'][$val['bigclass']][$key] = $columns[$key];
                    }
                    if ($val['classtype'] == 3) {
                        $sorting['class3'][$val['bigclass']][$key] = $columns[$key];
                    }
                }

            }
        }
        ksort($sorting);
        $array = $sorting;
        $metinfo = array();

        $cid = explode('#@met@#', $_M['config']['advanced_search_column']);
        $i = 0;
        if ($_M['config']['advanced_search_range'] == 'all' || ($_M['config']['advanced_search_range'] == 'parent' && !$_M['config']['advanced_search_column'])) {
            $metinfo['citylist'][$i]['p'] = $_M['word']['columnall'] ? $_M['word']['columnall'] : '全部栏目';
            $metinfo['citylist'][$i]['value'] = '';
        } else {
            $i = -1;
        }
        $_M['url']['site'] = $_M['form']['module'] == 10001 ? '' : '../';
        foreach ($array['class1'] as $key => $val) { //一级级栏目
            if ($_M['config']['advanced_search_range'] == 'parent') {
                if (!in_array($val['id'], $cid)) {
                    continue;
                }
            }
            $i++;
            $metinfo['citylist'][$i]['p'] = $val['name'];
            $metinfo['citylist'][$i]['value'] = $val['id'];
            $metinfo['citylist'][$i]['url'] = $_M['url']['site'] . "{$val['foldername']}/index.php?lang=" . $_M['lang'];
            //if (count($array['class2'][$val['id']]) && $_M['config']['advanced_search_linkage']) { //二级栏目
            if ($array['class2'][$val['id']] && $_M['config']['advanced_search_linkage']) { //二级栏目
                $k = 0;
                $metinfo['citylist'][$i]['c'][$k]['n'] = $_M['word']['columnall'] ? $_M['word']['columnall'] : '全部栏目';
                $metinfo['citylist'][$i]['c'][$k]['value'] = '';

                $first_son = reset($array['class2'][$val['id']]);
                if ($val['module'] == 1) {//简介模块下的下级列表栏目
                    $metinfo['citylist'][$i]['url'] = $_M['url']['site'] . "{$first_son['foldername']}/index.php?lang=" . $_M['lang'];
                }

                foreach ($array['class2'][$val['id']] as $k1 => $val2) {
                    $k++;
                    $metinfo['citylist'][$i]['c'][$k]['n'] = $val2['name'];
                    $metinfo['citylist'][$i]['c'][$k]['value'] = $val2['id'];
                    //if (count($array['class3'][$val2['id']])) { //三级栏目
                    if ($array['class3'][$val2['id']]) { //三级栏目
                        $j = 0;
                        $metinfo['citylist'][$i]['c'][$k]['a'][$j]['s'] = $_M['word']['columnall'] ? $_M['word']['columnall'] : '全部栏目';
                        $metinfo['citylist'][$i]['c'][$k]['a'][$j]['value'] = '';
                        foreach ($array['class3'][$val2['id']] as $k2 => $val3) {
                            $j++;
                            $metinfo['citylist'][$i]['c'][$k]['a'][$j]['s'] = $val3['name'];
                            $metinfo['citylist'][$i]['c'][$k]['a'][$j]['value'] = $val3['id'];
                        }
                    }
                }
            } else {
                if ($val['module'] == 1) {
                    unset($metinfo['citylist'][$i]);
                    $i--;
                }
            }
        }

        echo json_encode($metinfo);
    }

    public function doAgents()
    {
        global $_M;
        if (!$_M['config']['met_agents_type']) {
            $met_agents = '';
        }else{
            switch ($_M['config']['met_copyright_type']) {
                case 0:
                    $met_agents = $_M['config']['met_agents_copyright_foot'];
                    break;
                case 1:
                    $met_agents = $_M['config']['met_agents_copyright_foot1'];
                    break;
                case 2:
                    $met_agents = $_M['config']['met_agents_copyright_foot2'];
                    break;
                default:
                    $met_agents = $_M['config']['met_agents_copyright_foot'];
                    break;
            }
        }

        $met_agents = str_replace(array('$metcms_v', '$m_now_year'), array($_M['config']['metcms_v'], date('Y', time())), $met_agents);

        if ($_M['config']['met_copyright_nofollow']) {
            $met_agents = str_replace("<a ", "<a rel=nofollow ", $met_agents);
        }
        $this->success($met_agents);
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
