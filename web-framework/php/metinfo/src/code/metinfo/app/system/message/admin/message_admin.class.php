<?php

// MetInfo Enterprise Content Management System
// Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('base/admin/base_admin');

class message_admin extends base_admin
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
     * @var 当acinton为空的时候，回传ture
     */
    public $plist_database;

    /**
     * 初始化.
     */
    public function __construct()
    {
        global $_M;
        parent::__construct();
        $this->module = 7;
        $this->database = load::mod_class('message/message_database', 'new');
        $this->tabledata = load::sys_class('tabledata', 'new');
        $this->para_op = load::mod_class('parameter/parameter_op', 'new');
        $this->plist_database = load::mod_class('parameter/parameter_list_database', 'new');
        $this->plist_database->construct($this->module);
    }

    /**
     * 列表数据.
     */
    public function dojson_list()
    {
        global $_M;
        $redata = array();
        $class1 = is_numeric($_M['form']['class1']) ? $_M['form']['class1'] : '';
        $class2 = is_numeric($_M['form']['class2']) ? $_M['form']['class2'] : '';
        $class3 = is_numeric($_M['form']['class3']) ? $_M['form']['class3'] : '';

        $keyword = $_M['form']['keyword'];
        $search_type = $_M['form']['search_type'];
        $checkok = $_M['form']['checkok'];
        $orderby_hits = $_M['form']['orderby_hits'];
        $orderby_updatetime = $_M['form']['orderby_updatetime'];

        $list = $this->_dojson_list($class1, $class2, $class3, $keyword, $search_type, $checkok, $orderby_hits, $orderby_updatetime);
        $redata['data'] = $list;
        $this->ajaxReturn($redata);
    }

    /**
     * 分页数据.
     */
    public function _dojson_list($class1 = '', $class2 = '', $class3 = '', $keyword = '', $search_type = '', $checkok = '', $orderby_hits = '', $orderby_updatetime = '')
    {
        global $_M;
        $class = array();
        $class['class1'] = $class1;
        $class['class2'] = $class2;
        $class['class3'] = $class3;
        if ($class3) {
            $classnow = $class3;
        } elseif ($class2) {
            $classnow = $class2;
        } else {
            $classnow = $class1;
        }

        $msg_config = load::mod_class('config/config_op', 'new')->getColumnConfArry($classnow);

        $where = " lang='{$this->lang}' ";
        $order = '';
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
            $search_sql .= " SELECT count(msg.id) AS main_id,msg.id,ml.listid,ml.paraid,ml.imgname,ml.info FROM {$_M['table']['message']} AS msg JOIN {$_M['table']['mlist']} AS ml ON  msg.id = ml.listid WHERE ml.lang='{$this->lang}' ";

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
            $search_sql .= $para_search_sql . "GROUP BY id ";

            if ($keyword) {
                $para_num = $para_num + 1;
            }
            $search_sql .= ") AS t1 WHERE main_id = {$para_num} ";
        }

        if (!$para_fields && $keyword) {
            $search_sql = " SELECT listid FROM {$_M['table']['mlist']}  WHERE info LIKE '%{$keyword}%'";
        }

        if ($search_sql) {
            $where .= " AND  id IN ( {$search_sql}) ";
        }
        //end参数筛选

        $order .= ' addtime desc ';
        $msg_list = $this->tabledata->getdata($_M['table']['message'], '*', $where, $order);

        //留言列表处理
        $rarray = array();
        foreach ($msg_list as $key => $list) {
            $list['customerid'] = $list['customerid'] ? $list['customerid'] : $_M['word']['feedbackAccess0'];
            /*if ($list['readok']) {
                $list['readok'] = array('name' => $_M['word']['yes'], 'val' => $list['readok']);
            } else {
                $list['readok'] = array('name' => $_M['word']['no'], 'val' => $list['readok']);
            }*/

            $name = $this->plist_database->select_by_listid_paraid($list['id'], $msg_config['met_msg_name_field']);
            $list['name'] = $name['info'];
            $tel = $this->plist_database->select_by_listid_paraid($list['id'], $msg_config['met_msg_sms_field']);
            $list['tel'] = $tel['info'];
            $email = $this->plist_database->select_by_listid_paraid($list['id'], $msg_config['met_msg_email_field']);
            $list['email'] = $email['info'];
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
                        $list['access'] = array('name' => $_M['word']['access0'], 'val' => 0);
                        break;
                }
            }
            $list['view_url'] = "{$_M['url']['own_form']}a=doview&id={$list['id']}&class1_select={$class1}";
            $list['del_url'] = "{$_M['url']['own_form']}a=dolistsave&submit_type=del&allid={$list['id']}&class1_select={$class1}";
            $rarray[] = $list;
        }

        return $this->tabledata->rdata($rarray);
        #$this->json_return($rarray);
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
        for ($start; $start < $end; ++$start) {
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
     * 查看留言
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
        //$met_message_fd_class   = $_M['config']['met_message_fd_class'];
        //$met_message_fd_sms     = $_M['config']['met_message_fd_sms'];
        //$met_message_fd_email   = $_M['config']['met_message_fd_email'];
        $met_message_fd_content = $_M['config']['met_message_fd_content'];

        //查看状态
        $update_data = array('id' => $id, 'readok' => 1);
        $this->database->update_by_id($update_data);
        $msg_list = $this->database->get_list_one_by_id($id);
        if ($msg_list) {
            $para_list = $this->para_op->get_para_list($this->module, $class1, $class2, $class3);

            foreach ($para_list as $key => $para) {
                //属性值
                $this->plist_database = load::mod_class('parameter/parameter_list_database', 'new');
                $this->plist_database->construct($this->module);
                $plist = $this->plist_database->select_by_listid_paraid($id, $para['id']);
                $plist['info'] = htmlspecialchars($plist['info']);
                $para_row = array(
                    'name' => $para['name'],
                    'val' => $plist['info'],
                    'type' => $para['type'],
                    'id' => $plist['id'],
                    'paraid' => $para['id'],
                    'listid' => $id,
                );
                //留言能容字段的是属性id
                if ($para['id'] == $met_message_fd_content) {
                    $para_row['message_fd_content'] = 1;
                }
                $msg_list['plist'][] = $para_row;
                $msg_list['customerid'] = $msg_list['customerid'] ? $msg_list['customerid'] : $_M['word']['feedbackAccess0'];
            }
        }
        $access_option = $this->access_option();

        $redata['list'] = $msg_list;
        $redata['access_option'] = $access_option;
        $redata['met_message_fd_content'] = $met_message_fd_content;    //留言能容字段的是属性id
        if (is_mobile()) {
            $this->success($redata);
        } else {
            return $redata;
        }
    }

    /**
     * 修改保存页面.
     *
     * @param array $list 插入的数组
     *
     * @return number 插入后的数据ID
     */
    public function doeditorsave()
    {
        global $_M;
        $redata = array();
        $id = $_M['form']['id'];
        $list = $_M['form'];
        if ($this->update_list($list, $id)) {
            $redata['status'] = 1;
            $redata['msg'] = $_M['word']['jsok'];
            $this->ajaxReturn($redata);
        }
    }

    /**
     * 保存修改.
     *
     * @param array $list 修改的数组
     *
     * @return bool 修改是否成功
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
     * 保存修改sql.
     *
     * @param array $list 修改的数组
     *
     * @return bool 修改是否成功
     */
    public function update_list_sql($list = array(), $id = '')
    {
        global $_M;
        $list['id'] = $id;
        $this->plist_database = load::mod_class('parameter/parameter_list_database', 'new');
        $this->plist_database->construct($this->module);
        $paraid = $_M['config']['met_message_fd_content'];
        $para = $this->plist_database->select_by_listid_paraid($id, $paraid);
        $imgname = $para['name'];
        $this->plist_database->update_by_listid_paraid($id, $paraid, $list['fd_content'], $imgname);    //更新屬性值
        return $this->database->update_by_id($list);    //更新内容
    }

    /**
     * 列表操作保存.
     */
    public function dolistsave()
    {
        global $_M;
        $redata = array();
        $list = explode(',', $_M['form']['allid']);
        foreach ($list as $id) {
            if ($id) {
                switch ($_M['form']['submit_type']) {
                    case 'del':
                        $this->del_list($id);
                        break;
                }
            }
        }
        $url = "{$_M['url']['own_form']}a=doindex&class1={$_M['form']['class1']}";
        $html_res = load::mod_class('html/html_op', 'new')->html_generate($url, $_M['form']['class1'], $_M['form']['id']);
        $redata['status'] = 1;
        $redata['msg'] = $_M['word']['jsok'];
        $redata['html_res'] = $html_res;
        $this->ajaxReturn($redata);

        /*if ($_M['config']['met_webhtm'] == 2 && $_M['config']['met_htmlurl'] == 0) {
            turnover("./content/article/save.php?lang={$_M['lang']}&action=html");
        } else {
            turnover("{$_M[url][own_form]}a=doindex&class1=" . $_M[form][class1]);
        }*/
    }

    /*删除*/
    public function del_list($id)
    {
        global $_M;

        $this->plist_database->del_by_listid($id);
        $this->database->del_by_id($id);

        return;
    }

    /**
     * 系统参数设置.
     */
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

        $config_op = load::mod_class('config/config_op', 'new');
        $conlum_configs = $config_op->getColumnConfArry($class1);
        //dump($conlum_configs);

        $redata['list'] = $conlum_configs;
        $redata['list']['met_msg_name_field'] = self::get_config_field(1, $conlum_configs['met_msg_name_field']);
        $redata['list']['met_msg_content_field'] = self::get_config_field(3, $conlum_configs['met_msg_content_field']);
        $redata['list']['met_msg_email_field'] = self::get_config_field(9, $conlum_configs['met_msg_email_field']);
        $redata['list']['met_msg_sms_field'] = self::get_config_field(8, $conlum_configs['met_msg_sms_field']);

        //通用配置
        $redata['list']['class1'] = $class1;
        $redata['list']['class2'] = $class2;
        $redata['list']['class3'] = $class3;
        $redata['list']['classnow'] = $classnow;

        if (is_mobile()) {
            $this->success($redata);
        } else {
            //dump($redata);
            //die();
            return $redata;
        }
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
            $redata['error'] = 'Data error no class1';
            $this->ajaxReturn($redata);
        }

        $config_op = load::mod_class('config/config_op', 'new');
        $conlum_configs = $config_op->getColumnConfArry($classnow);

        foreach ($conlum_configs as $name => $val) {
            if ($conlum_configs[$name] != $list[$name] && isset($list[$name])) {
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
     *
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
}

// This program is an open source system, commercial use, please consciously to purchase commercial license.
// Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
