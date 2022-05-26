<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin');

/** 管理员设置 */
class index extends admin
{
    public $database;

    public function __construct()
    {
        global $_M;
        parent::__construct();
        $this->database = load::mod_class('admin/admin_database', 'new');
    }

    //获取管理员列表
    public function doGetList()
    {
        global $_M;
        $where = '';
        if (isset($_M['form']['keyword']) && $_M['form']['keyword']) {
            $where .= " admin_id like '%{$_M['form']['keyword']}%' ";
        }

        $now_admin = admin_information();

        if ($now_admin['admin_group'] != 10000) {
            if ($where) {
                #$where .= " AND admin_group!=10000 AND admin_id!='{$now_admin['admin_id']}'";
                $where .= " AND admin_group!=10000 ";
            } else {
                $where .= " admin_group!=10000 ";
            }
        }
        $table = load::sys_class('tabledata', 'new');
        ##$user_list = $table->getdata($_M['table']['admin_table'], '*', $where);
        $user_list = $table->getdataAll($_M['table']['admin_table'], '*', $where);

        $redata = array();
        foreach ($user_list as $key => $val) {
            $val['admin_group_name'] = $this->get_admin_group_name($val['admin_group']);
            if ($now_admin['admin_id'] == $val['admin_id']) {
                $val['action_name'] = $_M['word']['adminpassTitle'];
                $val['editor_url'] = $_M['url']['own_form'] . "a=doGetInfo&id={$val['id']}";
            } else {
                if ($this->have_power_eidtor($now_admin['admin_group'], $val['admin_group'])) {
                    $val['action_name'] = $_M['word']['editor'];
                    $val['editor_url'] = $_M['url']['own_form'] . "a=doGetAdminSetup&id={$val['id']}";
                } else {
                    continue;
                }
            }
            $val['now_admin'] = $val['id'] == $now_admin['id'] ? '1' : '0';
            $redata[$key] = $val;
        }

        $total = count($redata);
        $table->rarray['recordsTotal'] = $total;
        $table->rarray['recordsFiltered'] = $total;
        $table->rdata($redata);
    }

    public function json_return($data = array())
    {
        global $_M;
        $table = load::sys_class('tabledata', 'new');
        $length = $table->length;
        $start = $table->start;
        $end = $start + $length;

        $redata = array();
        for ($start; $start < $end; $start++) {
            if ($data[$start]) {
                $redata[] = $data[$start];
            }
        }
        $table->rdata($redata);
    }

    //获取权限管理栏目
    public function doGetColumn()
    {
        global $_M;
        $metinfo_column = array();
        $query = "SELECT * FROM {$_M['table']['admin_column']} ORDER BY type ASC, list_order ASC";
        $sidebar_column = DB::get_all($query);
        foreach ($sidebar_column as $key => $val) {
            //去除的数组
            if ((($val['name'] == 'lang_indexcode') || ($val['name'] == 'lang_indexebook') || ($val['name'] == 'lang_indexbbs') || ($val['name'] == 'lang_indexskinset')) && !$_M['config']['met_agents_metmsg']) {
                continue;
            }
            if ((($val['name'] == 'lang_webnanny') || ($val['name'] == 'lang_smsfuc')) && $_M['config']['met_agents_sms'] == 0) {
                continue;
            }
            if (($val['name'] == 'lang_dlapptips2') && $_M['config']['met_agents_app'] == 0) {
                continue;
            }
            //信息处理
            $val['name'] = get_word($val['name']);
            if (strstr($val['info'], "lang_")) {
                $val['info'] = $$val['info'];
            }
            $val['field'] = 's' . $val['field'];
            $val['url'] = $val['url'] ?: $_M['url']['admin_site'] . $val['url'];
            switch ($val['type']) {
                case 1:
                    $metinfo_column[$val['id']]['info'] = $val;
                    break;
                case 2:
                    if ($metinfo_column[$val['bigclass']]['info']['type']) {
                        $metinfo_column[$val['bigclass']]['next'][$val['field']] = $val;
                    }
                    break;
            }
        }
        foreach ($metinfo_column as $key => $val) {
            if ($val['info']['id'] == '1') {//管理，添加内容管理
                $langs = load::mod_class('language/language_op', 'new')->get_lang();
                foreach ($langs as $langkey => $langval) {
                    $module = load::mod_class('column/column_op', 'new')->get_sorting_by_module(false, $langval['mark']);
                    $mlist = array();
                    $mlist['info']['name'] = $langval['name'];
                    $mlist['info']['field'] = $langval['mark'];
                    foreach ($module as $modulekey => $moduleval) {
                        if (in_array($modulekey, array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 11, 12, 13))) {
                            foreach ($moduleval['class1'] as $class1val) {
                                $list = array();
                                $list['name'] = $class1val['name'];
                                $list['field'] = 'c' . $class1val['id'];
                                $list['column_lang'] = "column-lang column-lang-{$langval['mark']}";
                                $list['data_lang'] = "data-lang-column=\"{$langval['mark']}\"";
                                $mlist['column'][$list['field']] = $list;
                            }
                        }
                    }

                    $metinfo_column[$key]['next'][$val['info']['field']] = $val['info'];
                    $metinfo_column[$key]['next2'][$langval['mark']] = $mlist;

                }

            }

            if ($val['info']['id'] == 2) {
                $list = array();
                $list['name'] = $_M['word']['admintips4'];
                $list['field'] = 's9999';
                $metinfo_column[$key]['next']['s9999'] = $list;
            }
            if ($val['info']['id'] == '6') {//应用，添加应用

                $app = load::mod_class('myapp/class/getapp', 'new')->get_app();
                $mlist = array();

                foreach ($app as $v) {
                    if ($v['no'] == 0) {
                        continue;
                    }
                    $list = array();
                    $list['name'] = $v['appname'];
                    $list['field'] = 'a' . $v['no'];
                    $mlist['column'][$list['field']] = $list;
                }
                $metinfo_column[$key]['next2'] = $mlist;
            }
        }

        foreach ($metinfo_column as $key => $value) {
            //根栏目权限
            if ($value['next']) {
                if ($value['info']['id'] == 37) {
                    continue;
                }
                $info = array();
                $info[$value['info']['field']] = $value['info'];
                $next = array_merge($info, $value['next']);
                $metinfo_column[$key]['next'] = $next;
            } else {
                $metinfo_column[$key]['next'][$value['info']['field']] = $value['info'];
            }
        }
        $list['metinfocolumn'] = $metinfo_column;
        $this->success($list);
    }

    //获取管理员设置
    public function doGetAdminSetup()
    {
        global $_M;
        $sys_admin = admin_information();
        if (!isset($_M['form']['id'])) {
            $this->error();
        }

        $list = $this->database->get_list_one_by_id($_M['form']['id']);
        unset($list['admin_pass']);

        if (!$this->have_power_eidtor($sys_admin['admin_group'], $list['admin_group'])) {
            $this->error($_M['word']['js81']);
        }

        //语言勾选
        $list['lang'] = load::mod_class('language/language_op', 'new')->get_lang();
        foreach ($list['lang'] as $key => $val) {
            $list['lang_check'] .= $val['mark'] . '|';
        }
        if ($list['langok'] == 'metinfo') {
            $list['lang_check'] .= '#metinfo#|';
        } else {
            $langoks = explode('-', trim($list['langok'], '-'));
            $list['lang_check'] = implode('|', $langoks);
        }
        $list['lang_check'] = trim($list['lang_check'], '|');

        //控制勾选
        $admin_ops = explode('-', trim($list['admin_op'], '-'));
        $list['op_check'] = trim(implode('|', $admin_ops), '|');

        //权限控制
        if ($list['admin_type'] == 'metinfo') {
            //js处理的全部选中
            $list['pop_check'] = 'all';
        } else {
            $admin_types = explode('-', trim($list['admin_type'], '-'));

            $list['pop_check'] = trim(implode('|', $admin_types), '|');
        }

        $this->success($list);
    }

    //保存管理员设置
    public function doSaveSetup()
    {
        global $_M;
        $data = array();
        $data['id'] = isset($_M['form']['id']) ? $_M['form']['id'] : '';
        $data['admin_email'] = isset($_M['form']['admin_email']) ? $_M['form']['admin_email'] : '';
        $data['admin_pass'] = isset($_M['form']['admin_pass']) ? $_M['form']['admin_pass'] : '';
        $data['admin_name'] = isset($_M['form']['admin_name']) ? $_M['form']['admin_name'] : '';
        $data['admin_id'] = isset($_M['form']['admin_id']) ? $_M['form']['admin_id'] : '';
        $data['admin_op'] = isset($_M['form']['admin_op']) ? $_M['form']['admin_op'] : '';
        $data['admin_issueok'] = isset($_M['form']['admin_issueok']) ? $_M['form']['admin_issueok'] : '';
        $data['langok'] = isset($_M['form']['langok']) ? $_M['form']['langok'] : '';
        $data['admin_type'] = isset($_M['form']['admin_pop']) ? $_M['form']['admin_pop'] : '';
        $data['admin_login_lang'] = isset($_M['form']['admin_login_lang']) ? $_M['form']['admin_login_lang'] : '';
        $data['admin_check'] = isset($_M['form']['admin_check']) ? $_M['form']['admin_check'] : 0;
        $data['admin_group'] = isset($_M['form']['admin_group']) ? $_M['form']['admin_group'] : '';
        $data['admin_mobile'] = isset($_M['form']['admin_mobile']) ? $_M['form']['admin_mobile'] : '';
        if (!$data['admin_id']) {
            $this->error();
        }
        $log_name = $data['id'] ? 'save' : 'added';

        //编辑权限检测
        $now_admin = admin_information();

        if ($data['id']) {
            $query = "SELECT * FROM {$_M['table']['admin_table']} WHERE admin_id='{$data['admin_id']}' AND id='{$data['id']}'";
            $editor_admin = DB::get_one($query);
            if (!$this->have_power_eidtor($now_admin['admin_group'],  $editor_admin['admin_group'])) {
                logs::addAdminLog('metadmin', $log_name, 'jsok', 'doSaveSetup');
                $this->error($_M['word']['js81']);
            }
        }

        if (!$this->have_power_eidtor($now_admin['admin_group'],   $admin_group = $data['admin_group'])) {
            logs::addAdminLog('metadmin', $log_name, 'jsok', 'doSaveSetup');
            $this->error($_M['word']['js81']);
        }

        //管理ID称唯一
        $query = "SELECT admin_id FROM {$_M['table']['admin_table']} WHERE admin_id='{$data['admin_id']}' AND id!='{$data['id']}'";
        $check_username = DB::get_one($query);
        if ($data['admin_id'] == $check_username['admin_id']) {
            logs::addAdminLog('metadmin', $log_name, 'jsok', 'doSaveSetup');
            $this->error($_M['word']['js78']);
        }

        //管理邮箱称唯一
        if ($data['admin_email']) {
            $query = "SELECT admin_id FROM {$_M['table']['admin_table']} WHERE admin_email ='{$data['admin_email']}' AND id!='{$data['id']}'";
            $check_email = DB::get_one($query);
            if ($check_email) {
                $this->error($_M['word']['admin_email_error']);
            }
        }

        //管理员名称唯一
        if ($data['admin_name']) {
            $query = "SELECT admin_id FROM {$_M['table']['admin_table']} WHERE admin_name='{$data['admin_name']}' AND id!='{$data['id']}'";
            $check_name = DB::get_one($query);
            if ($check_name) {
                $this->error($_M['word']['admin_name_repeat']);
            }
        }

        //管理邮箱称唯一
        if ($data['admin_email']) {
            $query = "SELECT admin_id FROM {$_M['table']['admin_table']} WHERE admin_email ='{$data['admin_email']}' AND id!='{$data['id']}'";
            $check_email = DB::get_one($query);
            if ($check_email) {
                $this->error($_M['word']['admin_email_error']);
            }
        }

        $list = $this->public_handle($data);

        if (!$data['id']) {//新增管理员
            if (!$data['admin_pass']) {
                $this->error($_M['word']['please_password']);
            }
            $result = $this->database->insert($list);
        } else {//更新管理员
            if (isset($_M['form']['admin_pass']) && $_M['form']['admin_pass']) {
                if ($_M['form']['admin_pass'] != $_M['form']['admin_pass_replay']) {
                    $this->error($_M['word']['formerror5']);
                }
                $data['admin_pass'] = $_M['form']['admin_pass'];
            }
            $list['id'] = $data['id'];
            $result = $this->database->update_by_id($list);
        }

        if (!$result) {
            //写日志
            logs::addAdminLog('metadmin', $log_name, 'dataerror', 'doSaveSetup');
            $this->error($_M['word']['dataerror']);
        }
        //写日志
        logs::addAdminLog('metadmin', $log_name, 'jsok', 'doSaveSetup');
        $this->success('', $_M['word']['jsok']);
    }


    //获取系统管理员个人信息
    public function doGetInfo()
    {
        global $_M;
        $sys_admin = admin_information();
        if (isset($_M['form']['id']) && $_M['form']['id']) {
            $list = $this->database->get_list_one_by_id($_M['form']['id']);
        } else {
            $list = $this->database->get_list_one_by_id($sys_admin['id']);
        }

        if ($sys_admin['id'] != $list['id']) {
            $this->error('nopower');
        }

        $this->success($list);
    }

    //保存系统管理员设置信息
    public function doSaveInfo()
    {
        global $_M;
        $data['id'] = $_M['form']['id'];
        $data['admin_name'] = $_M['form']['admin_name'];
        if (isset($_M['form']['admin_email']) && $_M['form']['admin_email']) {
            $data['admin_email'] = $_M['form']['admin_email'];
        }
        if (isset($_M['form']['admin_mobile']) && $_M['form']['admin_mobile']) {
            $data['admin_mobile'] = $_M['form']['admin_mobile'];
        }

        if (!$data['id']) {
            $this->error($_M['word']['loginedit']);
        }

        if (isset($_M['form']['admin_pass']) && $_M['form']['admin_pass']) {
            if ($_M['form']['admin_pass'] != $_M['form']['admin_pass_replay']) {
                $this->error($_M['word']['formerror5']);
            }
            $data['admin_pass'] = $_M['form']['admin_pass'];
        }

        $admin_info = admin_information();
        //检测编辑权限
        if ($admin_info['id'] != $data['id']) {
            $this->error($_M['word']['loginedit']);
        }

        //检测管理员姓名
        if ($data['admin_name']) {
            $query = "SELECT admin_id FROM {$_M['table']['admin_table']} WHERE admin_name='{$data['admin_name']}' AND id!='{$data['id']}'";
            $check_name = DB::get_one($query);
            if ($check_name) {
                $this->error($_M['word']['admin_name_repeat']);
            }
        }

        $admin = $this->database->get_list_one_by_id($data['id']);
        if (!$admin) {
            $this->error($_M['word']['opfailed']);
        }

        if ($data['admin_pass'] && $data['admin_pass'] != $admin['admin_pass']) {
            $data['admin_pass'] = md5($data['admin_pass']);
        }

        $update_result = $this->database->update_by_id($data);
        if (!$update_result) {
            //写日志
            logs::addAdminLog('metadmin', 'adminpassTitle', 'dataerror', 'doSaveInfo');
            $this->error($_M['word']['dataerror']);
        }
        //写日志
        logs::addAdminLog('metadmin', 'adminpassTitle', 'jsok', 'doSaveInfo');
        $this->success('', $_M['word']['jsok']);
    }

    //删除管理员
    public function doDelAdmin()
    {
        global $_M;
        $id_list = isset($_M['form']['id']) ? $_M['form']['id'] : '';
        if (!$id_list) {
            $this->error('error');
        }

        $admin_info = admin_information();

        foreach ($id_list as $id) {
            //操作权限验证
            $one = $this->database->get_list_one_by_id($id);
            if (!$this->have_power_eidtor($admin_info['admin_group'], $one['admin_group'])) {
                $this->error($_M['word']['js81']);
            }

            $check_admin = DB::get_one("SELECT id,admin_group FROM {$_M['table']['admin_table']} WHERE id='{$id}'");
            if ($check_admin['admin_group'] == 10000 || $check_admin['id'] == 1) {
                //写日志
                logs::addAdminLog('metadmin', 'delete', 'admin_del_error', 'doDelAdmin');
                $this->error($_M['word']['admin_del_error']);
            }

            $this->database->del_by_id($id);
        }
        //写日志
        logs::addAdminLog('metadmin', 'delete', 'jsok', 'doDelAdmin');
        $this->success('', $_M['word']['jsok']);
    }


    /**
     * 管理员信息验证处理
     * @param $list
     * @return mixed
     */
    public function public_handle($list = array())
    {
        global $_M;

        $admin = $this->database->get_list_one_by_id($list['id']);

        //管理员邮箱
        $alist['admin_email'] = $list['admin_email'];
        //密码
        if (empty($list['admin_pass']) || $admin['admin_pass'] == md5($list['admin_pass'])) {
            $alist['admin_pass'] = $admin['admin_pass'];
        } else {
            $alist['admin_pass'] = md5($list['admin_pass']);    //新密码
        }
        //名字
        $alist['admin_name'] = $list['admin_name'];
        //管理员邮箱
        $alist['admin_email'] = $list['admin_email'];
        //控制
        $alist['admin_op'] = $list['admin_op'];
        //管理其他管理员权限
        $alist['admin_issueok'] = $list['admin_issueok'] ? 1 : 0;
        //分组
        $alist['admin_group'] = $list['admin_group'];
        $alist['admin_id'] = $list['admin_id'];
        $alist['admin_mobile'] = $list['admin_mobile'];
        //语言
        if (strstr($list['langok'], 'metinfo')) {
            $alist['langok'] = 'metinfo';
        } else {
            $alist['langok'] = $list['langok'];
        }
        //管理员登录语言
        $alist['admin_login_lang'] = $list['admin_login_lang'];
        //发布信息需要审核才能正常显示
        $alist['admin_check'] = $list['admin_check'];
        //权限
        if ($list['admin_group'] == 3 && strstr($list['admin_pop_str'], 's1801') && strstr($list['admin_pop_str'], 's1802')) {
            $alist['admin_type'] = 'metinfo';
        } else {
            $alist['admin_type'] = '-' . str_replace('metinfo-', '', $list['admin_type']) . '-';
        }
        return $alist;
    }


    /**
     * @param $my
     * @param $you
     * @return bool
     */
    public function have_power_eidtor($my = '', $you = '')
    {
        if ($my == '0' || $my == '1' || $my == '2') {
            return false;
        } else {
            if ($my <= $you) {
                return false;
            } else {
                return true;
            }
        }
    }

    /**
     * 管理员类型
     * @param $aid
     * @return string
     */
    function get_admin_group_name($aid)
    {
        global $_M;
        $str = '';
        switch ($aid) {
            case 0:
                //自定义管理员
                $str = $_M['word']['managertyp5'] . $_M['word']['metadmin'];
                break;
            case 1:
                //内容管理员
                $str = $_M['word']['managertyp4'];
                break;
            case 2:
                //优化推广专员
                $str = $_M['word']['managertyp3'];
                break;
            case 3:
                //管理员
                $str = $_M['word']['metadmin'];
                break;
            case 10000:
                //创始人
                $str = $_M['word']['managertyp1'];
                break;
        }
        return $str;
    }

    //获取管理员基本信息
    public function doGetAdminInfo()
    {
        global $_M;
        $info = admin_information();
        $info['lang'] = $_M['lang'];
        $this->success($info);
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
