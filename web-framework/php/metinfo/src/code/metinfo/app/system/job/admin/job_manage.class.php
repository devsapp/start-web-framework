<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

#load::mod_class('news/admin/news_admin');
load::mod_class('message/admin/message_admin');

class job_manage extends message_admin
{
    public $moduleclass;

    public $module;

    public $database;

    public $tabledata;

    public $plist_database;

    /**
     * 初始化
     */
    function __construct()
    {
        global $_M;
        parent::__construct();
        $this->module = 6;
        $this->database = load::mod_class('job/job_database', 'new');
        $this->tabledata = load::sys_class('tabledata', 'new');
        $this->para_op = load::mod_class('parameter/parameter_op', 'new');
        $this->plist_database = load::mod_class('parameter/parameter_list_database', 'new');
        $this->plist_database->construct($this->module);
    }

    /**
     * 获取职位列表
     */
    public function doget_position_list()
    {
        global $_M;
        $class1 = is_numeric($_M['form']['class1']) ? $_M['form']['class1'] : '';
        $class2 = is_numeric($_M['form']['class2']) ? $_M['form']['class2'] : '';
        $class3 = is_numeric($_M['form']['class3']) ? $_M['form']['class3'] : '';

        $where = '';
        $where .= $class1 ? " AND class1 = '{$class1}'" : " AND class1 = 0";
        $where .= $class2 ? " AND class2 = '{$class2}'" : " AND class2 = 0";
        $where .= $class3 ? " AND class3 = '{$class3}'" : " AND class3 = 0";
        $position_list = $this->database->get_all($where);
        $list = array(array('jobid' => '', 'position' => $_M['word']['please_choose']));
        foreach ($position_list as $position) {
            $arr = array();
            $arr['jobid'] = $position['id'];
            $arr['position'] = $position['position'];
            $list[] = $arr;
        }
        $this->ajaxReturn($list);
    }

    /*信息管理*/
    public function dojob_info()
    {
        global $_M;
        $class1 = is_numeric($_M['form']['class1']) ? $_M['form']['class1'] : '';
        $class2 = is_numeric($_M['form']['class2']) ? $_M['form']['class2'] : '';
        $class3 = is_numeric($_M['form']['class3']) ? $_M['form']['class3'] : '';
        if ($class3) {
            $classnow = $class3;
        } elseif ($class2) {
            $classnow = $class2;
        } else {
            $classnow = $class1;
        }

        $config_op = load::mod_class('config/config_op', 'new');
        $conlum_configs = $config_op->getColumnConfArry($classnow);
        $met_cv_showcol = explode('|', $conlum_configs['met_cv_showcol']);

        $para_list = $this->database->get_module_para($classnow, $this->module);
        $parameter_database = load::mod_class('parameter/parameter_database', 'new');
        $showcol = array();

        foreach ($met_cv_showcol as $paraid) {
            foreach ($para_list as $val) {
                if ($paraid == $val['id']) {
                    //表单分类字段下拉列表
                    if ($val['type'] == 2 || $val['type'] == 6) {
                        $options = $parameter_database->get_para_values($val['module'], $val['id']);

                        $op_data = array();
                        $op_data['list'][] = array(
                            'name' => $_M['word']['cvall'],
                            'val' => '',
                        );

                        foreach ($options as $option) {
                            $op_data['list'][] = array(
                                'name' => $option['value'],
                                'val' => $option['value'],
                                #'val'   =>  $option['id'],
                            );
                        }

                        $val['options'] = $op_data;
                        $showcol[] = $val;
                    } else {
                        $showcol[] = $val;
                    }
                }
            }

        }
        $redata['showcol'] = $showcol;
        return $redata;
    }

    public function dojson_list()
    {
        global $_M;
        $redata = array();
        $class1 = is_numeric($_M['form']['class1']) ? $_M['form']['class1'] : '';
        $class2 = is_numeric($_M['form']['class2']) ? $_M['form']['class2'] : '';
        $class3 = is_numeric($_M['form']['class3']) ? $_M['form']['class3'] : '';

        $keyword = $_M['form']['keyword'];
        $search_type = $_M['form']['search_type'];
        $orderby_hits = $_M['form']['orderby_hits'];
        $orderby_updatetime = $_M['form']['orderby_updatetime'];
        $jobid = $_M['form']['jobid'];

        $list = $this->_dojson_list($class1, $class2, $class3, $keyword, $search_type, $orderby_hits, $orderby_updatetime, $jobid);
        $redata['data'] = $list;
        $this->ajaxReturn($redata);
    }


    public function _dojson_list($class1 = '', $class2 = '', $class3 = '', $keyword = '', $search_type = '', $orderby_hits = '', $orderby_updatetime = '', $jobid = '')
    {
        global $_M;
        $class = array();
        $class['class1'] = $class1 ? $class1 : 0;
        $class['class2'] = $class2 ? $class2 : 0;
        $class['class3'] = $class3 ? $class3 : 0;
        if ($class3) {
            $classnow = $class3;
        } elseif ($class2) {
            $classnow = $class2;
        } else {
            $classnow = $class1;
        }

        $lang = $this->lang;

        $config_op = load::mod_class('config/config_op', 'new');
        $met_cv_showcol = $config_op->getColumnConf($classnow, 'met_cv_showcol');
        if ($met_cv_showcol) {
            $met_cv_showcol = explode('|', $met_cv_showcol);
        } else {
            $met_cv_showcol = null;
        }

        if (is_mobile()) {//手机端只显示第一栏属性
            if ($met_cv_showcol) {
                $first_col = $met_cv_showcol[0];
            } else {
                $parameters = $this->para_op->get_para_list($this->module, $class1, $class2, $class3);
                $first_col = $parameters[0]['id'];
            }
            $met_cv_showcol = $first_col ? array($first_col) : null;
        }

        $where = " lang='{$lang}' ";
        if (isset($_M['form']['jobid']) && $_M['form']['jobid']) {
            $where .= " AND jobid='{$_M['form']['jobid']}' ";
        }

        switch ($search_type) {
            case 0:
                break;
            case 1:
                $where .= "AND readok = '0'";
                break;
            case 2:
                $where .= "AND readok = '1'";
                break;
        }

        //参数筛选
        $para_fields = array();
        foreach ($_M['form'] as $key => $row) {
            if (strstr($key, 'para_') && $row) {
                $para_id = str_replace('para_', '', $key);
                $para_fields[$para_id] = $row;
            }
        }

        if ($para_fields && is_array($para_fields)) {
            $search_sql = " SELECT t1.id FROM (";
            $search_sql .= " SELECT count(cv.id) AS main_id,cv.id,pl.listid,pl.paraid,pl.imgname,pl.info FROM {$_M['table']['cv']} AS cv JOIN {$_M['table']['plist']} AS pl ON  cv.id = pl.listid WHERE  pl.module = 6 AND cv.lang='{$this->lang}' ";

            $para_num = count($para_fields);
            $para_search_sql = ' AND (';
            foreach ($para_fields as $id => $pval) {
                $para_search_sql .= " (paraid = '{$id}' AND info = '{$pval}') OR";
            }
            $para_search_sql = trim($para_search_sql, 'OR');

            if ($keyword) {
                $para_search_sql .= " OR info LIKE '%{$keyword}%' ";
            }
            $para_search_sql .= ') ';
            $search_sql .= $para_search_sql."GROUP BY id ";

            if ($keyword) {
                $para_num = $para_num + 1;
            }
            $search_sql .= ") AS t1 WHERE main_id = {$para_num} ";
        }

        if (!$para_fields && $keyword) {
            $search_sql = " SELECT listid FROM {$_M['table']['plist']}  WHERE info LIKE '%{$keyword}%' AND module = 6 ";
        }

        if ($search_sql) {
            $where .= " AND  id IN ( {$search_sql}) ";
        }
        //end参数筛选

        $order = ' addtime desc ';

        #$cv_list = $this->json_list($where, $order);
        $cv_list = $this->tabledata->getdata($_M['table']['cv'], '*', $where, $order);

        $rarray = array();
        foreach ($cv_list as $key => $row) {
            if ($jobid && $row['jobid'] != $jobid) {
                continue;
            }

            $job_info = $this->database->get_list_one_by_id($row['jobid']);
            if ($job_info['class1'] != $class['class1'] || $job_info['class2'] != $class['class2'] || $job_info['class3'] != $class['class3']) {
                continue;
            }
            $list = $row;
            if ($_M['config']['met_member_use']) {
                switch ($row['access']) {
                    case '1':
                        $list['access'] = array('name' => $_M['word']['access1'], 'val' => $row['access']);
                        break;
                    case '2':
                        $list['access'] = array('name' => $_M['word']['access2'], 'val' => $row['access']);
                        break;
                    case '3':
                        $list['access'] = array('name' => $_M['word']['access3'], 'val' => $row['access']);
                        break;
                    default:
                        $list['access'] = array('name' => $_M['word']['access0'], 'val' => $row['access']);
                        break;
                }
            }

            $list['customerid'] = $row['customerid'] == '0' ? $_M['word']['feedbackAccess0'] : $row['customerid'];
            $list['position'] = $job_info['position'];
            $list['readok'] = $row['readok'];
            //属性
            /*foreach ($met_cv_showcol as $paraid) {
                $info_list = $this->plist_database->select_by_listid_paraid($row['id'], $paraid);
                $list['para_list']['para_' . $paraid] = $info_list['info'];
            }*/
            $query = "SELECT * FROM {$_M['table']['plist']} WHERE listid = '{$row['id']}' AND module = '{$this->module}'";
            $plist = DB::get_all($query);
            foreach ($plist as $val) {
                if (in_array($val['paraid'],$met_cv_showcol)) {
                    $list['para_list']['para_' . $val['paraid']] = htmlspecialchars($val['info']);
                }
            }

            $list['view_url'] = $_M['url']['own_form'] . "a=doview&lang={$lang}&id={$row['id']}&class1_select={$class1}&class2_select={$class2}&class3_select={$class3}";
            $list['del_url'] = $_M['url']['own_form'] . "a=dolistsave&lang={$lang}&allid={$row['id']}&submit_type=del&class1_select={$class1}";
            $list['export_url'] = $_M['url']['own_form'] . "a=doexport&lang={$lang}&id={$row['id']}&class1={$class1}&class2={$class2}&class3={$class3}";

            $rarray[] = $list;
        }
        return  $this->tabledata->rdata($rarray);
        #return $this->json_return($rarray);
    }

    /**
     * @param array $data
     */
    public function json_return($data = array())
    {
        global $_M;
        $length = $this->tabledata->length;
        $start = $this->tabledata->start;
        $end = $start + $length;

        $redata = array();
        for ($start; $start < $end; $start++) {
            if ($data[$start]) {
                $redata[] = $data[$start];
            }
        }

        $total = count($data);
        $this->tabledata->rarray['recordsTotal'] = $total;
        $this->tabledata->rarray['recordsFiltered'] = $total;
        $this->tabledata->rdata($redata);
    }

    /**
     * 查看简历
     */
    public function doview()
    {
        global $_M;
        $redata = array();
        $id = $_M['form']['id'];
        $lang = $_M['lang'];
        $class1 = is_numeric($_M['form']['class1']) ? $_M['form']['class1'] : '';
        $class2 = is_numeric($_M['form']['class2']) ? $_M['form']['class2'] : '';
        $class3 = is_numeric($_M['form']['class3']) ? $_M['form']['class3'] : '';

        $query = "UPDATE {$_M['table']['cv']} SET readok  = '1' WHERE id='{$id}' AND lang='{$lang}'";
        DB::query($query);
        $query = "SELECT * FROM {$_M['table']['cv']} WHERE id='{$id}'";
        $cv_info = DB::get_one($query);
        if ($cv_info) {
            //栏目属性列表
            $para_list = $this->para_op->get_para_list($this->module, $class1, $class2, $class3);
            foreach ($para_list as $key => $para) {
                //属性值
                $plist = $this->plist_database->select_by_listid_paraid($id, $para['id']);
                $plist['info'] = htmlspecialchars($plist['info']);
                $cv_info['plist'][] = array(
                    'name' => $para['name'],
                    'val' => $plist['info'],
                    'type' => $para['type'],
                    'id' => $plist['id'],
                    'paraid' => $para['id'],
                    'listid' => $id
                );
            }
        }
        $redata['list'] = $cv_info;
        if (is_mobile()) {
            $this->success($redata);
        } else {
            return $redata;
        }
    }

    /**
     * 列表操作保存
     */
    public function dolistsave()
    {
        global $_M;
        parent::dolistsave();
    }

    /*删除简历*/
    public function del_list($id)
    {
        global $_M;
        $this->plist_database->del_by_listid($id);
        $query = "DELETE FROM {$_M['table']['cv']} WHERE id = '{$id}'";
        DB::query($query);
        return;
    }

    /**
     * 招聘模块参数设置
     */
    public function dosyset()
    {
        global $_M;
        $redata = array();
        $class1 = is_numeric($_M['form']['class1']) ? $_M['form']['class1'] : '';
        $class2 = is_numeric($_M['form']['class2']) ? $_M['form']['class2'] : '';
        $class3 = is_numeric($_M['form']['class3']) ? $_M['form']['class3'] : '';
        $classnow = $class3 ? $class3 : ($class2 ? $class2 : $class1);

        #$para_list = $this->para_op->get_para_list($this->module, $class1, $class2, $class3);

        $config_op = load::mod_class('config/config_op', 'new');
        $conlum_configs = $config_op->getColumnConfArry($classnow);
        //栏目配置
        $met_cv_showcol_id = explode('|', $conlum_configs['met_cv_showcol']);
        $met_cv_showcol = array();
        $parameters = $this->para_op->get_para_list($this->module, $class1, $class2, $class3);
        foreach ($parameters as $para) {
            $row = array();
            $row['id'] = $para['id'];
            $row['name'] = $para['name'];
            if (in_array($para['id'], $met_cv_showcol_id)) {
                $met_cv_showcol['val'] .= $para['id'] . '|';
            }
            $met_cv_showcol['options'][] = $row;
        }
        $redata['list']['met_cv_showcol'] = $met_cv_showcol;//列表显示属性
        $redata['list']['met_cv_image'] = $this->get_config_field(5, $conlum_configs['met_cv_image'], $classnow);//邮箱附件字段
        $redata['list']['met_cv_email'] = $this->get_config_field(9, $conlum_configs['met_cv_email'], $classnow);////Email字段名
        $redata['list']['met_cv_type'] = $conlum_configs['met_cv_type'] ? $conlum_configs['met_cv_type'] : '0';//简历接收方式
        $redata['list']['met_cv_emtype'] = $conlum_configs['met_cv_emtype'] ? $conlum_configs['met_cv_emtype'] : '0';//邮件接收方式
        $redata['list']['met_cv_back'] = $conlum_configs['met_cv_back'];     //用户邮件自动回复
        $redata['list']['met_cv_to'] = $conlum_configs['met_cv_to'];       //用户简历接收邮箱
        $redata['list']['met_cv_title'] = $conlum_configs['met_cv_title'];    //用户回复邮件标题
        $redata['list']['met_cv_content'] = $conlum_configs['met_cv_content'];  //用户回复邮件内容
        $redata['list']['met_cv_sms_back'] = $conlum_configs['met_cv_sms_back'];  //用户短信自动回复开关
        $redata['list']['met_cv_sms_tell'] = $this->get_config_field(8, $conlum_configs['met_cv_sms_tell'], $classnow);  //用户短信自动回复号码
        $redata['list']['met_cv_sms_content'] = $conlum_configs['met_cv_sms_content'];  //用户短信自动回复内容
        $redata['list']['met_cv_time'] = $conlum_configs['met_cv_time'];     //防刷新时间
        $redata['list']['met_cv_job_tel'] = $conlum_configs['met_cv_job_tel'];  //短信通知号码

        //通用配置
        $redata['list']['class1'] = $class1;
        $redata['list']['class2'] = $class2;
        $redata['list']['class3'] = $class3;
        $redata['list']['classnow'] = $classnow;
        if (is_mobile()) {
            $this->success($redata);
        } else {
            return $redata;
        }

        #$this->ajaxReturn($redata);
    }

    /**
     * 保存配置
     */
    public function dosaveinc()
    {
        global $_M;
        $redata = array();
        $list = $_M['form'];
        $classnow = $_M['form']['classnow'];

        if (!is_numeric($classnow)) {
            $redata['status'] = 0;
            $redata['msg'] = $_M['word']['dataerror'];
            $redata['error'] = "Data error no classnow";
            $this->ajaxReturn($redata);
        }

        $config_op = load::mod_class('config/config_op', 'new');
        $conlum_configs = $config_op->getColumnConfArry($classnow);

        foreach ($conlum_configs as $name => $val) {
            if (isset($list[$name]) && $list[$name] != $conlum_configs[$name]) {
                $config_op->saveColumnConf($classnow, $name, $list[$name]);
            }
        }

        buffer::clearConfig();
        $redata['status'] = 1;
        $redata['msg'] = $_M['word']['jsok'];
        $this->ajaxReturn($redata);
    }

    /**
     * @param string $type
     * @param string $value
     * @return mixed
     */
    public function get_config_field($type = '', $value = '', $classnow = '')
    {
        global $_M;
        $class123 = $class123 = load::sys_class('label', 'new')->get('column')->get_class123_no_reclass($classnow);
        $paralist = load::mod_class('parameter/parameter_database', 'new')->get_parameter($this->module, $class123['class1']['id'], $class123['class2']['id'], $class123['class3']['id']);
        $list = array();
        $unll = $_M['word']['please_choose'] ? $_M['word']['please_choose'] : '--';
        $list[] = array('name' => $unll, 'val' => '');
        foreach ($paralist as $key => $val) {
            if (is_array($type)) {
                foreach ($type as $t) {
                    if ($val['type'] == $t) {
                        $list[] = array('name' => $val['name'], 'val' => $val['id']);
                    }
                }
            }else{
                if ($val['type'] == $type) {
                    $list[] = array('name' => $val['name'], 'val' => $val['id']);
                }
            }
        }
        $redata['val'] = $value;
        $redata['options'] = $list;
        return $redata;
    }

    /**
     * 导出简历
     */
    public function doexport()
    {
        global $_M;
        $id = $_M['form']['id'];
        $lang = $_M['lang'];
        $class1 = is_numeric($_M['form']['class1']) ? $_M['form']['class1'] : '';
        $class2 = is_numeric($_M['form']['class2']) ? $_M['form']['class2'] : '';
        $class3 = is_numeric($_M['form']['class3']) ? $_M['form']['class3'] : '';

        if ($class3) {
            $classnow = $class3;
        } elseif ($class2) {
            $classnow = $class2;
        } else {
            $classnow = $class1;
        }

        $config_op = load::mod_class('config/config_op', 'new');
        $conlum_configs = $config_op->getColumnConfArry($classnow);

        $query = "UPDATE {$_M['table']['cv']} SET readok  = '1' WHERE id='{$id}' AND lang='{$lang}'";
        DB::query($query);
        $query = "SELECT * FROM {$_M['table']['cv']} WHERE id='{$id}'";
        $cv_info = DB::get_one($query);

        $job_info = $this->database->get_list_one_by_id($cv_info['jobid']);
        $position = $job_info['position'];

        if ($cv_info) {
            //栏目属性列表
            $para_list = $this->para_op->get_para_list($this->module, $class1, $class2, $class3);

            foreach ($para_list as $key => $para) {
                //属性值
                $plist = $this->plist_database->select_by_listid_paraid($id, $para['id']);
                $cv_info['plist'][] = array(
                    'name' => $para['name'],
                    'val' => $plist['info'],
                    'type' => $para['type'],
                    'id' => $plist['id'],
                    'paraid' => $para['id'],
                    'listid' => $id
                );
            }
        }

        $body = '<style type="text/css">' . "\n";
        $body .= 'table.metinfo_cv{ width:500px; border:1px solid #999; margin:10px auto; color:#555; font-size:12px; line-height:1.8;}' . "\n";
        $body .= 'table.metinfo_cv td.title{ background:#999; font-size:14px; text-align:center; padding:2px 5px; font-weight:bold; color:#fff;}' . "\n";
        $body .= 'table.metinfo_cv td.l{white-space:nowrap; background:#f4f4f4; text-align:right; padding:2px 5px; font-weight:bold;}' . "\n";
        $body .= 'table.metinfo_cv td.r{ background:#fff; text-align:left; padding:2px 5px; }' . "\n";
        $body .= 'table.metinfo_cv td.pc{ text-align:right; width:25%; padding:0px;}' . "\n";
        $body .= 'table.metinfo_cv td.pc img{ border:1px solid #999; padding:1px; margin:3px;}' . "\n";
        $body .= 'table.metinfo_cv td.footer{ text-align:center; padding:0px; font-size:11px; color:#666; background:#f4f4f4; border-top:1px dotted #999;}' . "\n";
        $body .= 'table.metinfo_cv td.footer a{  color:#666; }' . "\n";
        $body .= '</style>' . "\n";
        $body .= '<table cellspacing="1" cellpadding="2" class="metinfo_cv">' . "\n";
        $body .= '<tr><td class="title" colspan="3">' . $title = "{$_M['word']['member_cv']} {$position}" . '</td></tr>' . "\n";

        foreach ($cv_info['plist'] as $val) {
            if ($conlum_configs['met_cv_image'] == $val['paraid']) {
                $imgurl = str_replace("../", $_M['url']['web_site'], $val['val']);
                $bt = $val['val'] != '' ? '<td class="pc" rowspan="5">' . '<img src="' . $imgurl . '" width="140" height="160" /></td>' : '';

            }
        }

        foreach ($cv_info['plist'] as $key => $val) {
            $bt = $key > 0 ? '' : $bt;
            if ($val['type'] != 5) {
                $body = $body . '<tr><td class="l">' . $val['name'] . '</td><td class="r">' . $val['val'] . '</td>' . $bt . '</tr>' . "\n";
            } else {
                $para_url = str_replace("../", $_M['url']['web_site'], $val['val']);
                if ($conlum_configs['met_cv_image'] != $val['paraid']) {
                    $para = explode('../', $para);
                    $para = $para[1] != "" ? "<a href=" . $_M['config']['met_weburl'] . $para[1] . " trage='_blank' style='color:#f00;' >" . $_M['word']['Download'] . "</a>" : $_M['word']['Emptyno'];
                    $body = $body . '<tr><td class="l">' . $val['name'] . '</td><td class="r">' . $para_url . '</td>' . $bt . '</tr>' . "\n";
                } else {
                    $body = $body . '<tr><td class="l">' . $val['name'] . '</td><td class="r">' . $para_url . '</td>' . $bt . '</tr>' . "\n";
                }
            }
        }
        $body .= '</table>';

        echo $body;
        die();
    }

    /********************导出EXCEL表******************/
    function doexportList()
    {
        global $_M;
        $class1 = is_numeric($_M['form']['class1']) ? $_M['form']['class1'] : '';
        $class2 = is_numeric($_M['form']['class2']) ? $_M['form']['class2'] : '';
        $class3 = is_numeric($_M['form']['class3']) ? $_M['form']['class3'] : '';
        $allid = $_M['form']['allid'];
        $lang = $this->lang;
        $keyword = $_M['form']['keyword'];
        $search_type = $_M['form']['search_type'];

        if ($class3) {
            $classnow = $class3;
        } elseif ($class2) {
            $classnow = $class2;
        } else {
            $classnow = $class1;
        }

        $class = load::mod_class('column/column_database', 'new')->get_column_by_id($class1, $lang);
        $table_name = $class['name'];

        $this->xls = load::mod_class('feedback/PHP_XLS', 'new');
        $parameters = $this->para_op->get_para_list($this->module, $classnow);
        foreach ($parameters as $para) {
            $met_cv_showcol[] = $para['id'];
        }

        $where = " lang='{$lang}' ";
        if (isset($_M['form']['jobid']) && $_M['form']['jobid']) {
            $where .= " AND jobid='{$_M['form']['jobid']}' ";
        }

        switch ($search_type) {
            case 0:
                break;
            case 1:
                $where .= "AND readok = '0' ";
                break;
            case 2:
                $where .= "AND readok = '1' ";
                break;
        }

        if ($allid) {
            $allid = explode(',', $allid);
            foreach ($allid as $_id) {
                if (is_numeric($_id)) {
                    $id_list[] = $_id;
                }
            }
            if ($id_list) {
                $id_list = implode(',', $id_list);
                $where .= " AND `id` IN ({$id_list}) ";
            }
        }

        //参数筛选
        $para_fields = array();
        foreach ($_M['form'] as $key => $row) {
            if (strstr($key, 'para_') && $row) {
                $para_id = str_replace('para_', '', $key);
                $para_fields[$para_id] = $row;
            }
        }

        if ($para_fields && is_array($para_fields)) {
            $search_sql = " SELECT t1.id FROM (";
            $search_sql .= " SELECT count(cv.id) AS main_id,cv.id,pl.listid,pl.paraid,pl.imgname,pl.info FROM {$_M['table']['cv']} AS cv JOIN {$_M['table']['plist']} AS pl ON  cv.id = pl.listid WHERE  pl.module = 6 AND cv.lang='{$this->lang}' ";

            $para_num = count($para_fields);
            $para_search_sql = ' AND (';
            foreach ($para_fields as $id => $pval) {
                $para_search_sql .= " (paraid = '{$id}' AND info = '{$pval}') OR";
            }
            $para_search_sql = trim($para_search_sql, 'OR');

            if ($keyword) {
                $para_search_sql .= " OR info LIKE '%{$keyword}%' ";
            }
            $para_search_sql .= ') ';
            $search_sql .= $para_search_sql."GROUP BY id ";

            if ($keyword) {
                $para_num = $para_num + 1;
            }
            $search_sql .= ") AS t1 WHERE main_id = {$para_num} ";
        }

        if (!$para_fields && $keyword) {
            $search_sql = " SELECT listid FROM {$_M['table']['plist']}  WHERE info LIKE '%{$keyword}%' AND module = 6 ";
        }

        if ($search_sql) {
            $where .= " AND  id IN ( {$search_sql}) ";
        }
        //end参数筛选

        $order = ' ORDER BY addtime desc ';

        $query = "SELECT * FROM {$_M['table']['cv']} WHERE {$where} {$order}";
        $cv_list = DB::get_all($query);

        //招聘列表处理
        $rearray = array();
        foreach ($cv_list as $key => $row) {
            /*if ($jobid && $row['jobid'] != $jobid) {
                continue;
            }*/

            $job_info = $this->database->get_list_one_by_id($row['jobid']);
            $list = $row;
            $list['customerid'] = $row['customerid'] == '0' ? $_M['word']['feedbackAccess0'] : $row['customerid'];
            $list['position'] = $job_info['position'];
            $list['readok'] = $row['readok'];
            $list['para_list']['position'] = $job_info['position'];
            //属性
            $query = "SELECT * FROM {$_M['table']['plist']} WHERE listid = '{$row['id']}' AND module = '{$this->module}'";
            $plist = DB::get_all($query);
            foreach ($plist as $val) {
                if (in_array($val['paraid'],$met_cv_showcol)) {
                    if (strstr($val['info'], '../')) {
                        $val['info'] = str_replace('../', $_M['url']['web_site'], $val['info']);
                    }
                    $list['para_list']['para_' . $val['paraid']] = $val['info'];

                }
            }

            /*if ($met_cv_showcol) {
                foreach ($met_cv_showcol as $paraid) {
                    $info_list = $this->plist_database->select_by_listid_paraid($row['id'], $paraid);
                    if (strstr($info_list['info'], '../')) {
                        $info_list['info'] = str_replace('../', $_M['url']['web_site'], $info_list['info']);
                    }
                    $list['para_list']['para_' . $paraid] = $info_list['info'];
                }
            }*/

            $rearray[] = $list;
        }

        //拼装表头
        $column = array();
        $param = array();
        $column[] = '';
        $column[] = $_M['word']['jobposition'];
        $param[] = 'position';

        foreach ($parameters as $key => $val) {
            $column[] = $val['name'];
            $param[] = "para_" . $val['id'];
        }

        #$column[] = $_M['word']['fdeditorTime'];
        #$column[] = $_M['word']['fdeditorFrom'];
        #$column[] = $_M['word']['feedbackID'];
        #$column[] = $_M['word']['fdeditorRecord'];

        #$param[] = 'addtime';
        #$param[] = 'fromurl';
        #$param[] = 'customerid';
        #$param[] = 'useinfo';

        //拼装表格
        //$xls=new PHP_XLS();
        $this->xls->AddSheet($_M['word']['editor']);
        $this->xls->NewStyle('hd_t');

        $this->xls->StyleSetFont(0, 10, 0, 1, 0, 0);

        $this->xls->StyleSetAlignment(0, 0);
        $this->xls->StyleAddBorder("Top", '#000000', 2);
        $this->xls->StyleAddBorder("Right", '#000000', 1);

        $this->xls->CopyStyle('hd_t', 'hd_l');
        $this->xls->StyleAddBorder("Left", '#000000', 2);

        $this->xls->CopyStyle('hd_t', 'hd_r');
        $this->xls->StyleAddBorder("Right", '#000000', 2);

        $this->xls->SetRowHeight(1, 30);

        for ($i = 1; $i < count($column); $i++) {
            $this->xls->SetColWidth($i, 80);
        }

        $this->xls->SetActiveStyle('hd_l');
        $this->xls->SetActiveStyle('hd_t');
        $this->xls->SetActiveStyle('hd_r');
        for ($i = 1; $i < count($column); $i++) {
            $this->xls->Textc(1, $i, $column[$i]);
        }


        $this->xls->NewStyle('center');
        $this->xls->StyleSetAlignment(0, 0);
        $this->xls->StyleAddBorder("Top", '#000000', 1);
        $this->xls->StyleAddBorder("Right", '#000000', 1);

        $this->xls->CopyStyle('center', 'center_l');
        $this->xls->StyleAddBorder("Left", '#000000', 2);

        $this->xls->CopyStyle('center', 'center_r');
        $this->xls->StyleAddBorder("Right", '#000000', 2);

        /*get feedback infomation *export xls */

        for ($i = 0; $i < count($rearray); $i++) {

            for ($j = 0; $j < count($column) - 1; $j++) {
                $this->xls->SetActiveStyle('center');
                $this->xls->Textc($i + 2, $j + 1, $rearray[$i]['para_list'][$param[$j]]);
            }
        }
        $excelname = $table_name;

        $this->xls->Output($excelname . ".xls");
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
