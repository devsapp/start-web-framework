<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('message/admin/message_admin');

class feedback_admin extends message_admin
{
    /**
     * @var
     */
    public $moduleclass;

    /**
     * @var int
     */
    public $module;

    /**
     * @var 当acinton为空的时候，回传ture
     */
    public $database;

    /**
     * @var
     */
    public $feed_column;

    /**
     * @var
     */
    public $tabledata;

    /**
     * 初始化
     */
    function __construct()
    {
        global $_M;
        parent::__construct();
        $class1 = $_M['form']['data']['class1'];
        $column_info = load::mod_class('column/column_label', 'new')->get_column_id($class1);

        $this->feed_column = $column_info;
        $this->module = 8;
        $this->database = load::mod_class('feedback/feedback_database', 'new');
        $this->tabledata = load::sys_class('tabledata', 'new');
        $this->para_op = load::mod_class('parameter/parameter_op', 'new');
        $this->plist_database = load::mod_class('parameter/parameter_list_database', 'new');
        $this->plist_database->construct($this->module);
        //$this->database->construct('new');
    }

    /**
     * 反馈列表信息
     * @return array
     */
    public function dofeedback_info()
    {
        global $_M;
        $redata = array();
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
        $met_fd_class = $conlum_configs['met_fd_class'];      //信息分类字段（现已弃用 所有下拉单选均可）
        $met_fd_related = $conlum_configs['met_fd_related'];    //产品关联字段
        $met_fd_showcol = $conlum_configs['met_fd_showcol'];    //列表显示字段
        $met_fd_showcol = explode('|', $met_fd_showcol);

        $para_list = $this->database->get_module_para($classnow, $this->module);

        $parameter_handle = load::mod_class('parameter/parameter_handle', 'new');
        $parameter_database = load::mod_class('parameter/parameter_database', 'new');
        $showcol = array();
        foreach ($met_fd_showcol as $paraid) {
            foreach ($para_list as $val) {
                if ($paraid == $val['id']) {
                    //表单分类字段下拉列表
                    if ($val['type'] == 2 || $val['type'] == 6) {
                        if ($met_fd_related == $val['id']) {
                            // 如果有产品关联，筛选就用产品
                            $options = $parameter_handle->related_product($val['related']);
                        } else {
                            $options = $parameter_database->get_para_values($val['module'], $val['id']);
                        }

                        $op_data = array();
                        #$op_data['val'] = '';
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

    /**
     * 模块栏目
     */
    public function docolumnjson()
    {
        global $_M;
        $redata = array();
        $column_database = load::mod_class('column/column_database', 'new');
        $list = $column_database->get_column_by_module(8);
        $new_list = array();

        foreach ($list as $column) {
            $arr = array();
            $arr['id'] = $column['id'];
            $arr['name'] = $column['name'];
            $new_list[] = $arr;

        }
        $redata['list'] = $new_list;
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
        $checkok = $_M['form']['checkok'];
        $search_type = $_M['form']['search_type'];
        $orderby_hits = $_M['form']['orderby_hits'];
        $orderby_updatetime = $_M['form']['orderby_updatetime'];

        $list = $this->_dojson_list($class1, $class2, $class3, $keyword, $search_type, $checkok ,$orderby_hits, $orderby_updatetime);
        $redata['data'] = $list;
        $this->ajaxReturn($redata);
    }

    /**
     * 反馈分页数据
     */
    public function _dojson_list($class1 = '', $class2 = '', $class3 = '', $keyword = '', $search_type = '', $checkok = '', $orderby_hits = '', $orderby_updatetime = '')
    {
        global $_M;
        if ($class3) {
            $classnow = $class3;
        } elseif ($class2) {
            $classnow = $class2;
        } else {
            $classnow = $class1;
        }

        $config_op = load::mod_class('config/config_op', 'new');
        $met_fd_showcol = $config_op->getColumnConf($classnow, 'met_fd_showcol');
        if ($met_fd_showcol) {
            $met_fd_showcol = explode('|', $met_fd_showcol);
        } else {
            $met_fd_showcol = '';
        }

        if (is_mobile()) {//手机端只显示第一栏属性
            if ($met_fd_showcol) {
                $first_col = $met_fd_showcol[0];
            } else {
                $parameters = $this->para_op->get_para_list($this->module, $class1, $class2, $class3);
                $first_col = $parameters[0]['id'];
            }
            $met_fd_showcol = $first_col ? array($first_col) : null;
        }

        $where = " AND class1 = {$classnow} ";
        switch ($search_type) {
            case 0:
                break;
            case 1:
                $where .= "and readok = '0'";
                break;
            case 2:
                $where .= "and readok = '1'";
                break;
        }

        if ($checkok) {
            $where .= " AND checkok = '1' ";
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
            $search_sql .= " SELECT count(fd.id) AS main_id,fd.id,fl.listid,fl.paraid,fl.imgname,fl.info FROM {$_M['table']['feedback']} AS fd JOIN {$_M['table']['flist']} AS fl ON  fd.id = fl.listid WHERE fd.lang='{$this->lang}' ";

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
            $search_sql = " SELECT listid FROM {$_M['table']['flist']}  WHERE info LIKE '%{$keyword}%'";
        }

        if ($search_sql) {
            $where .= " AND  id IN ( {$search_sql}) ";
        }
        //end参数筛选

        $order = '  addtime desc';
        $feedbacklist = $this->json_list($where, $order);
        ##dump($this->tabledata->getsql());

        //反馈列表处理
        $rarray = array();
        foreach ($feedbacklist as $key => $val) {
            $val['customerid'] = $val['customerid'] ? $val['customerid'] : $_M['word']['feedbackAccess0'];
            $val['url'] = $this->url($val, $this->module);
            $list = array();
            $list['id'] = $val['id'];
            $list['state'] = $val['state'];
            $list['readok'] = $val['readok'];

            foreach ($met_fd_showcol as $paraid) {
                //$info_list = DB::get_one("select * from {$_M['table']['flist']} where listid='{$val['id']}' and paraid='{$paraid}' and lang='{$this->lang}'");
                $info_list = $this->plist_database->select_by_listid_paraid($val['id'], $paraid);
                $list['para_list']['para_' . $paraid] = htmlspecialchars($info_list['info']);
            }

            $list['addtime'] = $val['addtime'];
            $list['view_url'] = "{$_M['url']['own_form']}a=doeditor&id={$val['id']}&class1={$val['class1']}";
            $list['delet_url'] = "{$_M['url']['own_form']}a=dolistsave&submit_type=del&allid={$val['id']}";
            if ($_M['config']['met_member_use']) {
                switch ($list['access']) {
                    case '1':
                        $list['access'] = array('name' => $_M['word']['access1'], 'val' => $list['access']);
                        break;
                    case '2':
                        $list['access'] = array('name' => $_M['word']['access2'], 'val' => $list['access']);
                        break;
                    case '3':
                        $list['access'] = array('name' => $_M['word']['access3'], 'val' => $list['access']);
                        break;
                    default:
                        $list['access'] = array('name' => $_M['word']['access0'], 'val' => $list['access']);
                        break;
                }
            }

            $rarray[] = $list;
        }

        $this->tabledata->rdata($rarray);
        #$this->json_return($rarray);
    }

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
     * 查看反馈
     */
    public function doview()
    {
        global $_M;
        $redata = array();
        $lang = $_M['lang'];
        $id = $_M['form']['id'];
        $class1 = is_numeric($_M['form']['class1']) ? $_M['form']['class1'] : '';
        $class2 = is_numeric($_M['form']['class2']) ? $_M['form']['class2'] : '';
        $class3 = is_numeric($_M['form']['class3']) ? $_M['form']['class3'] : '';


        $update_data = array('id' => $id, 'readok' => 1);
        $this->database->update_by_id($update_data);
        $feedback = $this->database->get_list_one_by_id($id);
        if ($feedback) {
            //栏目属性列表
            $para_list = $this->para_op->get_para_list($this->module, $class1, $class2, $class3);
            foreach ($para_list as $key => $para) {
                //属性值
                $this->plist_database = load::mod_class('parameter/parameter_list_database', 'new');
                $this->plist_database->construct($this->module);
                $plist = $this->plist_database->select_by_listid_paraid($id, $para['id']);
                $plist['info'] = htmlspecialchars($plist['info']);
                if ($para['type'] == 5) {
                    $tag_a = str_replace('../', $_M['url']['web_site'], $plist['info']);
                    $plist['info'] = "<a href='$tag_a'  target='_blank'>$tag_a</a>";
                }
                $feedback['plist'][] = array(
                    'name' => $para['name'],
                    'val' => $plist['info'],
                    'type' => $para['type'],
                    'id' => $plist['id'],
                    'paraid' => $para['id'],
                    'listid' => $id
                );
            }
            $feedback['customerid'] = $feedback['customerid'] ? $feedback['customerid'] : $_M['word']['feedbackAccess0'];
        }

        $redata['list'] = $feedback;
        if (is_mobile()) {
            $this->success($redata);
        } else {
            return $redata;
        }

    }

    /**
     * 修改保存页面
     * @param  array $list 插入的数组
     * @return number                 插入后的数据ID
     */
    public function doeditorsave()
    {
        global $_M;
        parent::doeditorsave();
    }

    /**
     * 保存修改
     * @param  array $list 修改的数组
     * @return bool                     修改是否成功
     */
    public function update_list($list = array(), $id = '')
    {
        global $_M;
        if ($this->update_list_sql($list, $id)) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * 保存修改sql
     * @param  array $list 修改的数组
     * @return bool    修改是否成功
     */
    public function update_list_sql($list = array(), $id = '')
    {
        global $_M;
        $save_data = array();
        $save_data['id'] = $id;
        $save_data['useinfo'] = $list['useinfo'];
        return $this->database->update_by_id($save_data);    //更新内容

    }


    /*系统参数设置*/

    public function dosyset()
    {
        global $_M;
        $redata = array();
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

        $inquiry_abled = $this->checkConfInquiry($classnow);
        $config_op = load::mod_class('config/config_op', 'new');
        $conlum_configs = $config_op->getColumnConfArry($classnow);
        $met_fd_class = self::get_config_field(array(2, 6), $conlum_configs['met_fd_class'],$classnow);
        $met_fd_related = self::get_config_field(array(2, 4, 6), $conlum_configs['met_fd_related'],$classnow);
        $met_fd_related['options'] = array_merge(array(array('name' => $_M['word']['listproductreok'], 'val' => 0)), $met_fd_related['options']);
        $met_fd_email = self::get_config_field(9, $conlum_configs['met_fd_email'],$classnow);
        $met_fd_sms_tell = self::get_config_field(8, $conlum_configs['met_fd_sms_tell'],$classnow);

        $met_fd_showcol_id = explode('|', $conlum_configs['met_fd_showcol']);
        $met_fd_showcol = array();
        $parameters = $this->para_op->get_para_list($this->module, $classnow);
        foreach ($parameters as $para) {
            $row = array();
            $row['id'] = $para['id'];
            $row['name'] = $para['name'];
            if (in_array($para['id'], $met_fd_showcol_id)) {
                $met_fd_showcol['val'] .= $para['id'] . '|';
            }
            $met_fd_showcol['options'][] = $row;
        }

        $redata['list'] = $conlum_configs;
        $redata['list']['met_fd_class'] = $met_fd_class;
        $redata['list']['met_fd_related'] = $met_fd_related;
        $redata['list']['met_fd_email'] = $met_fd_email;
        $redata['list']['met_fd_sms_tell'] = $met_fd_sms_tell;
        $redata['list']['met_fd_showcol'] = $met_fd_showcol;
        $redata['list']['inquiry_abled'] = $inquiry_abled;
        $redata['list']['inquiry_tips'] = $inquiry_abled ? $_M['word']['feedbackinquiryinfo1'] : $_M['word']['feedbackinquiryinfo'];

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
    }

    //检测询价是否开启
    private function checkConfInquiry($classnow = '')
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['config']} WHERE name = 'met_fd_inquiry' AND lang = '{$_M['lang']}'";
        $config_inquiry = DB::get_all($query);

        $flag = 1;
        foreach ($config_inquiry as $row) {
            if ($row['columnid'] != $classnow && $row['value'] == 1) {
                $flag = 0;
            }
        }
        return $flag;
    }

    /**
     * 关闭所有在线询价
     */
    private function confInquiryOff()
    {
        global $_M;
        $query = "UPDATE {$_M['table']['config']} SET value = 0 WHERE name = 'met_fd_inquiry' AND lang = '{$_M['lang']}'";
        DB::query($query);
    }

    /*保存配置*/
    public function dosaveinc()
    {
        global $_M;
        $redata = array();
        $list = $_M['form'];
        $classnow = $_M['form']['classnow'];

        if (!is_numeric($classnow)) {
            $redata['status'] = 0;
            $redata['msg'] = $_M['word']['dataerror'];
            $redata['error'] = "Data error no class1";
            $this->ajaxReturn($redata);
        }

        //关闭所有在线询价
        $this->confInquiryOff();

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
     * @param string $type 属性类型
     * @param string $value 值
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

    /********************导出EXCEL表******************/
    function doexport()
    {
        global $_M;
        $class1 = is_numeric($_M['form']['class1']) ? $_M['form']['class1'] : '';
        $class2 = is_numeric($_M['form']['class2']) ? $_M['form']['class2'] : '';
        $class3 = is_numeric($_M['form']['class3']) ? $_M['form']['class3'] : '';
        $allid = $_M['form']['allid'];
        $search_type = $_M['form']['search_type'];
        $keyword = $_M['form']['keyword'];

        if ($class3) {
            $classnow = $class3;
        } elseif ($class2) {
            $classnow = $class2;
        } else {
            $classnow = $class1;
        }

        $this->xls = load::mod_class('feedback/PHP_XLS', 'new');
        $fd_column = load::mod_class('column/column_database', 'new')->get_column_by_id($classnow);
        $met_fd_showcol = array();
        $parameters = $this->para_op->get_para_list($this->module, $classnow);
        foreach ($parameters as $para) {
            $met_fd_showcol[] = $para['id'];
        }

        $where = "lang='{$this->lang}' AND class1 = {$classnow} ";
        switch ($search_type) {
            case 0:
                break;
            case 1:
                $where .= " AND readok = '0' ";
                break;
            case 2:
                $where .= " AND readok = '1' ";
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
            $search_sql .= " SELECT count(fd.id) AS main_id,fd.id,fl.listid,fl.paraid,fl.imgname,fl.info FROM {$_M['table']['feedback']} AS fd JOIN {$_M['table']['flist']} AS fl ON  fd.id = fl.listid WHERE fd.lang='{$this->lang}' ";

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
            $search_sql = " SELECT listid FROM {$_M['table']['flist']}  WHERE info LIKE '%{$keyword}%'";
        }

        if ($search_sql) {
            $where .= " AND  id IN ( {$search_sql}) ";
        }
        //end参数筛选

        $order = ' ORDER BY addtime desc';
        $query = "SELECT * FROM {$_M['table']['feedback']} WHERE {$where} {$order}";
        $feedbacklist = DB::get_all($query);

        //反馈列表处理
        $f_list = array();
        foreach ($feedbacklist as $key => $val) {
            $val['customerid'] = $val['customerid'] ? $val['customerid'] : $_M['word']['feedbackAccess0'];
            $val['url'] = $this->url($val, $this->module);

            $list = array();
            $list['id'] = $val['id'];
            $list['fdtitle'] = $val['fdtitle'];
            #$list['fromurl'] = $val['fromurl'];
            $list['fromurl'] = str_replace('&', urlencode('&'), $val['fromurl']);
            $list['customerid'] = $list['customerid'] ? $list['customerid'] : $_M['word']['feedbackAccess0'];
            $list['useinfo'] = $val['useinfo'];
            $list['addtime'] = $val['addtime'];

            $query = "SELECT * FROM {$_M['table']['flist']} WHERE listid = '{$val['id']}'";
            $flist = DB::get_all($query);
            foreach ($flist as $row) {
                if (in_array($row['paraid'],$met_fd_showcol)) {
                    $list['para_' . $row['paraid']] = $row['info'];
                }
            }

            /*foreach ($met_fd_showcol as $paraid) {
                $info_list = $this->plist_database->select_by_listid_paraid($val['id'], $paraid);
                $list['para_' . $paraid] = $info_list['info'];
            }*/

            $f_list[] = $list;
        }

        //拼装表头
        $column = array();
        $param = array();
        $column[] = '';
        $column[] = $_M['word']['fdeditorInterest'];
        $param[] = 'fdtitle';
        foreach ($parameters as $key => $val) {
            $column[] = $val['name'];
            $param[] = "para_" . $val['id'];
        }
        $column[] = $_M['word']['fdeditorTime'];
        $column[] = $_M['word']['fdeditorFrom'];
        $column[] = $_M['word']['feedbackID'];
        $column[] = $_M['word']['fdeditorRecord'];
        $param[] = 'addtime';
        $param[] = 'fromurl';
        $param[] = 'customerid';
        $param[] = 'useinfo';

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

        for ($i = 0; $i < count($f_list); $i++) {

            for ($j = 0; $j < count($column) - 1; $j++) {
                $this->xls->SetActiveStyle('center');
                $this->xls->Textc($i + 2, $j + 1, $f_list[$i][$param[$j]]);
            }
        }
        $excelname = $fd_column['name'] ? $fd_column['name'] : 'table';

        $this->xls->Output($excelname . ".xls");
    }

}
# This program is an open source system, commercial use, please consciously to purchase commercial license.;
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
