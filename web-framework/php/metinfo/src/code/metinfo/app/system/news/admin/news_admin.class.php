<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('base/admin/base_admin');

class news_admin extends base_admin
{
    public $module;
    public $database;
    public $para_op;
    public $para_list;
    public $plist_database;


    /**
     * news_admin constructor.
     */
    public function __construct()
    {
        global $_M;
        parent::__construct();
        $this->module = 2;
        $this->database = load::mod_class('news/news_database', 'new');
        $this->para_op = load::mod_class('parameter/parameter_op', 'new');
    }

    /**
     * 新增内容
     */
    public function doadd()
    {
        global $_M;
        $redata = array();
        $list = $this->add();
        $list['class1'] = $_M['form']['class1'];
        $list['class2'] = $_M['form']['class2'];
        $list['class3'] = $_M['form']['class3'];
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

    /**
     * 条件内容基础数据 多模块共用
     * @return mixed
     */
    public function add()
    {
        global $_M;
        $list['class1'] = $_M['form']['class1'] ? $_M['form']['class1'] : '';
        $list['class2'] = $_M['form']['class2'] ? $_M['form']['class2'] : '';
        $list['class3'] = $_M['form']['class3'] ? $_M['form']['class3'] : '';
        $class_now = $list['class3'] ? $list['class3'] : ($list['class2'] ? $list['class2'] : $list['class1']);
        $column = load::sys_class('label', 'new')->get('column')->get_column_id($class_now);
        $list['access'] = $column['access'];
        $list['displaytype'] = 1;
        $list['addtype'] = 1;
        $list['updatetime'] = date("Y-m-d H:i:s");
        $list['publisher'] = $this->met_admin['admin_name'] ? $this->met_admin['admin_name'] : $this->met_admin['admin_id'];

        return $list;
    }

    /**
     * 添加数据保存
     */
    public function doaddsave()
    {
        global $_M;
        $redata = array();
        $_M['form']['addtime'] = $_M['form']['addtype'] == 2 ? $_M['form']['addtime'] : $_M['form']['updatetime'];
        $_M['form']['issue'] = $this->met_admin['admin_id'];
        $_M['form']['hits'] = intval($_M['form']['hits']);
        $id = $this->insert_list($_M['form']);
        if ($id && is_numeric($id)) {
            $url = "{$_M['url']['own_form']}a=doindex{$_M['form']['turnurl']}";
            $html_res = load::mod_class('html/html_op', 'new')->html_generate($url, $_M['form']['class1'], $id);
            //写日志
            logs::addAdminLog('administration', 'addinfo', 'jsok', 'doaddsave');
            $redata['status'] = 1;
            $redata['msg'] = $_M['word']['jsok'];
            $redata['html_res'] = $html_res;
            $redata['back_url'] = $url;
            $this->ajaxReturn($redata);
        } else {
            //写日志
            logs::addAdminLog('administration', 'addinfo', 'dataerror', 'doaddsave');
            $redata['status'] = 0;
            $redata['msg'] = $_M['word']['dataerror'];
            $redata['error'] = $this->error;
            $this->ajaxReturn($redata);
        }
    }

    /**
     * 新增内容插入数据处理
     * @param  前台提交的表单数组 $list
     * @return $pid  新增的ID 失败返回FALSE
     */
    public function insert_list($list = array())
    {
        global $_M;
        //自动发布更新时间设置
        if ($list['addtype'] == 2 && strtotime($list['updatetime']) < strtotime($list['addtime'])) {
            $list['updatetime'] = $list['addtime'];
        }
        //发布人信息
        $list['issue'] = $this->met_admin['admin_id'];

        if ($list['imgurl'] == '') {
            if (preg_match('/\.\.\/upload([\w\/\_<\x{4e00}-\x{9fa5}>\-\(\)]*)\.(jpg|png|gif)/iu', $list['content'], $out)) {
                if ($out[0]) {
                    $list['imgurl'] = $out[0];
                } else {
                    $list['imgurl'] = '';
                }
            }
        }
        //图片处理 缩略图 水印图
        $list = $this->form_imglist($list, $this->module);

        $pid = $this->insert_list_sql($list);

        // 更新TAG标签
        load::sys_class('label', 'new')->get('tags')->updateTags($list['tag'], $this->module, $list['class1'], $pid, 1);

        if ($pid) {
            if ($this->module == 3 || $this->module == 4 || $this->module == 5) {
                //更新系统属性产品 下载 图片
                $this->para_op->insert($pid, $this->module, $list);
            }
            return $pid;
        } else {
            $this->error[] = "Data error";
            return false;
        }
    }

    /**
     * 插入sql
     * @param  array $list 插入的数组
     * @return number     插入后的数据ID
     */
    public function insert_list_sql($list = array())
    {
        global $_M;
        if (!$list['title']) {
            return false;
        }
        if (!$this->check_filename($list['filename'], '', $this->module)) {
            return false;
        }
        if ($list['links']) {
            $list['links'] = url_standard($list['links']);
        }
        if (!$list['description']) {
            $list['description'] = $this->description($list['content']);
        };

        $list['displayimg'] = $list['displayimg'] ? : '';
        $list['displaytype'] = $list['displaytype'] ? 1: 0;
        $list['no_order'] = $list['no_order'] ? 1 : 0;
        $list['com_ok'] = $list['com_ok'] ? 1 : 0;
        $list['wap_ok'] = $list['wap_ok'] ? 1 : 0;
        $list['top_ok'] = $list['top_ok'] ? 1 : 0;
        $list['new_ok'] = $list['new_ok'] ? 1 : 0;

        $list['text_size'] = is_numeric($list['text_size']) ? $list['text_size'] : 0;
        // $list['updatetime'] = date("Y-m-d H:i:s");
        // $list['addtime']    = $list['addtime']?$list['addtime']:$list['updatetime'];
        $list['lang'] = $list['lang'] ? $list['lang'] : $this->lang;
        //发布信息需要审核才能正常显示
        $admin_info = admin_information();
        if ($admin_info['admin_check'] == 1 && !strstr($admin_info['admin_type'], 'metinfo')) {
            $list['displaytype'] = 0;
        }
        return $this->database->insert($list);
    }

    /**
     * ajax检测静态文件是否重名//base
     */
    public function docheck_filename()
    {
        global $_M;
        $redata = array();
        if (is_numeric($_M['form']['filename'])) {
            $errorno = $this->errorno == 'error_filename_cha' ? $_M['word']['js74'] : $_M['word']['admin_tag_setting10'];
            #$errorno = $this->errorno == 'error_filename_cha' ? $_M['word']['js74'] : $_M['word']['js73'];
            $redata['valid'] = false;
            $redata['message'] = $errorno;
            $this->ajaxReturn($redata);
        }

        if (!$this->check_filename($_M['form']['filename'], $_M['form']['id'], $this->module)) {
            $errorno = $this->errorno == 'error_filename_cha' ? $_M['word']['js74'] : $_M['word']['js73'];
            $redata['valid'] = false;
            $redata['message'] = $errorno;
            $this->ajaxReturn($redata);
        } else {
            $redata['valid'] = true;
            $redata['message'] = $_M['word']['js75'];
            $this->ajaxReturn($redata);
        }
    }

    /**
     * 系统属性
     */
    public function dopara()
    {
        global $_M;
        $redata = array();
        $class1 = is_numeric($_M['form']['class1']) ? $_M['form']['class1'] : 0;
        $class2 = is_numeric($_M['form']['class2']) ? $_M['form']['class2'] : 0;
        $class3 = is_numeric($_M['form']['class3']) ? $_M['form']['class3'] : 0;
        $listid = is_numeric($_M['form']['id']) ? $_M['form']['id'] : 0;
        $paralist = $this->para_op->paratem($listid, $this->module, $class1, $class2, $class3);
        $redata['status'] = 1;
        $redata['data'] = $paralist;
        $this->ajaxReturn($redata);
    }

    /**
     * 编辑文章页面
     */
    public function doeditor()
    {
        global $_M;
        $redata = array();
        $id = $_M['form']['id'];

        if ($id && is_numeric($id)) {
            $list = $this->database->get_list_one_by_id($_M['form']['id']);
            $list = $this->listAnalysis($list);

            $column_own = load::sys_class('label', 'new')->get('column')->get_column_id($list['class_now']);
            $access_option = $this->access_option($column_own['access']);
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

        if (is_mobile()) {
            $this->error();
        } else {
            return false;
        }
    }

    /**
     * 修改保存页面
     * @param  array $list 插入的数组
     * @return number 插入后的数据ID
     */
    public function doeditorsave()
    {
        global $_M;
        $redata = array();
        $id = $_M['form']['id'];
        $list = $_M['form'];

        if (!is_numeric($id)) {
            $redata['status'] = 0;
            $redata['msg'] = $_M['word']['dataerror'];
            $redata['error'] = "No id";
            $this->ajaxReturn($redata);
        }
        //发布信息需要审核才能正常显示
        $admin_info = admin_information();
        if ($admin_info['admin_check'] == 1 && !strstr($admin_info['admin_type'], 'metinfo')) {
            $list['displaytype'] = 0;
        }
        if ($this->update_list($list, $id)) {
            $url = "{$_M['url']['own_form']}a=doindex&class1={$_M['form']['class1']}&class2={$_M['form']['class2']}&class3={$_M['form']['class3']}";
            $html_res = load::mod_class('html/html_op', 'new')->html_generate($url, $_M['form']['class1'], $_M['form']['id']);

            $redata['status'] = 1;
            $redata['msg'] = $_M['word']['jsok'];
            $redata['html_res'] = $html_res;
            $redata['back_url'] = $url;
            $this->ajaxReturn($redata);

        } else {
            $redata['status'] = 0;
            $redata['msg'] = $_M['word']['dataerror'];
            $this->ajaxReturn($redata);
        }
    }

    /**
     * 保存修改
     * @param  array $list 修改的数组
     * @return bool                     修改是否成功
     */
    public function update_list($list = array(), $id = '')
    {
        global $_M;
        //水印图
        /*if ($list['imgurl'] == '') {
            if (preg_match('/<img.*?src=\\\\"(.*?)\\\\".*?>/i', $list['content'], $out)) {
                $imgurl = explode("upload/", $out[1]);
                $list['imgurl'] = '../upload/' . str_replace('watermark/', '', $imgurl[1]);
            }
        }*/
        if ($list['imgurl'] == '') {
            if (preg_match('/\.\.\/upload([\w\/\_<\x{4e00}-\x{9fa5}>\-\(\)]*)\.(jpg|png|gif)/iu', $list['content'], $out)) {
                if ($out[0]) {
                    $list['imgurl'] = str_replace('watermark/', '', $out[0]);
                }
            }
        }

        //图片处理 缩略图 水印图
        $list = $this->form_imglist($list, $this->module);
        load::sys_class('label', 'new')->get('tags')->updateTags($list['tag'], $this->module, $list['class1'], $id);

        if ($this->update_list_sql($list, $id)) {

            if ($this->module == 3 || $this->module == 4 || $this->module == 5) {
                $this->para_op->update($id, $this->module, $list);
            }
            return true;
        } else {
            $this->error[] = 'Data error';
            return false;
        }
    }

    /**
     * 保存修改sql
     * @param array $list
     * @param string $id
     * @return bool
     */
    public function update_list_sql($list = array(), $id = '')
    {
        $list['displaytype'] = $list['displaytype'] ? 1: 0;
        $list['no_order'] = $list['no_order'] ? 1: 0;
        $list['com_ok'] = $list['com_ok'] ? 1 : 0;
        $list['wap_ok'] = $list['wap_ok'] ? 1 : 0;
        $list['top_ok'] = $list['top_ok'] ? 1 : 0;
        $list['new_ok'] = $list['new_ok'] ? 1 : 0;

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
        $list['description'] = addslashes($list['description']);
        $list['addtime'] = $list['addtype'] == 2 ? $list['addtime'] : $list['updatetime'];
        $list['id'] = $id;
        return $this->database->update_by_id($list);
    }

    /**
     * 栏目json
     */
    public function docolumnjson()
    {
        global $_M;
        $list = self::_columnjson();
        if ($_M['form']['noajax']) {
            return $list;
        }
        $list_new = array();
        $list_new['citylist'] = $list['columnlist'];
        $this->ajaxReturn($list_new);
    }

    public function _columnjson()
    {
        $list = parent::column_json($this->module/*, $_M['form']['type']*/);
        $list = array(
            'columnlist' => $list['citylist'],
            'columnlist_json' => jsonencode($list['citylist'])

        );
        return $list;
    }

    /**
     * 分页数据
     */
    public function dojson_list()
    {
        global $_M;
        $class1 = is_numeric($_M['form']['class1']) ? $_M['form']['class1'] : '';
        $class2 = is_numeric($_M['form']['class2']) ? $_M['form']['class2'] : '';
        $class3 = is_numeric($_M['form']['class3']) ? $_M['form']['class3'] : '';
        $keyword = $_M['form']['keyword'];
        $search_type = $_M['form']['search_type'];
        foreach ($_M['form']['order'] as $key => $value) {
            $order[$value['name']] = $value['value'];
        }

        $list = $this->_dojson_list($class1, $class2, $class3, $keyword, $search_type, $order['hits'], $order['updatetime']);

        $this->json_return($list);
    }

    /**
     * @param string $class1
     * @param string $class2
     * @param string $class3
     * @param string $keyword
     * @param string $search_type
     * @param string $orderby_hits
     * @param string $orderby_updatetime
     * @return array
     */
    public function _dojson_list($class1 = '', $class2 = '', $class3 = '', $keyword = '', $search_type = '', $orderby_hits = '', $orderby_updatetime = '')
    {
        global $_M;
        if ($class3) {
            $classnow = $class3;
        } elseif ($class2) {
            $classnow = $class2;
        } else {
            $classnow = $class1;
        }

        $get_allow_column = $this->get_allow_column();
        $get_allow_column = implode(',', $get_allow_column);
        $where = $class1 ? " and class1 = '{$class1}'" : " AND class1 IN ({$get_allow_column}) ";
        #$where = $class1 ? " and class1 = '{$class1}'" : ' and class1 = 0 ';
        $where .= $class2 ? " and class2 = '{$class2}'" : '';
        $where .= $class3 ? " and class3 = '{$class3}'" : '';
        $where .= $keyword ? " and title like '%{$keyword}%'" : '';
        switch ($search_type) {
            case 0:
                break;
            case 1:
                $where .= " and displaytype = '0'";
                break;
            case 2:
                $where .= " and com_ok = '1'";
                break;
            case 3:
                $where .= " and top_ok = '1'";
                break;
        }

        $admininfo = admin_information();
        if ($admininfo['admin_issueok'] == 1) {
            $where .= "and issue = '{$admininfo['admin_id']}'";
        }
        $met_class = $this->column(2, $this->module);

        //sql排序
        $order = $this->list_order($met_class[$classnow]['list_order']);
        if ($orderby_hits) $order = "hits {$orderby_hits}";
        if ($orderby_updatetime) $order = "updatetime {$orderby_updatetime}";
        $userlist = $this->json_list($where, $order);

        foreach ($userlist as $key => $val) {
            $list['id'] = $val['id'];
            $list['title'] = $val['title'];
            $list['no_order'] = $val['no_order'];
            $list['url'] = $this->url($val, $this->module);
            $list['hits'] = $val['hits'];
            $list['com_ok'] = $val['com_ok'];
            $list['top_ok'] = $val['top_ok'];
            $list['addtype'] = strtotime($val['addtime']) > time() ? 1 : 0;
            $list['imgurl'] = $val['imgurl'];
            $list['updatetime'] = $val['updatetime'];
            $list['addtime'] = $val['addtime'];
            $list['displaytype'] = $val['displaytype'];
            $list['editor_url'] = "{$_M['url']['own_form']}a=doeditor&id={$val['id']}&class1={$class1}&class2={$class2}&class3={$class3}";
            $list['del_url'] = "{$_M['url']['own_form']}a=dolistsave&submit_type=del&allid={$val['id']}";

            if ($this->module == 4) {
                $list['downloadurl'] = $val['downloadurl'];
            }

            $rarray[] = $list;
        }

        return $rarray;
    }

    /**
     * 列表操作保存
     */
    function dolistsave()
    {
        global $_M;
        $redata = array();
        $list = explode(",", $_M['form']['allid']);

        foreach ($list as $id) {
            if ($id) {
                switch ($_M['form']['submit_type']) {
                    case 'save':
                        $log_name = 'submit';
                        $list['no_order'] = $_M['form']['no_order-' . $id];
                        $res = $this->list_no_order($id, $list['no_order']);
                        break;
                    case 'del':
                        $log_name = 'jslang1';
                        $res = $this->del_list($id, $_M['form']['recycle']);
                        break;
                    case 'recycle':
                        $log_name = 'jslang0';
                        $res = $this->del_list($id, 1);
                        break;
                    case 'comok':
                        $log_name = 'recom';
                        $res = $this->list_com($id, 1);
                        break;
                    case 'comno':
                        $log_name = 'unrecom';
                        $res = $this->list_com($id, 0);
                        break;
                    case 'topok':
                        $log_name = 'top';
                        $res = $this->list_top($id, 1);
                        break;
                    case 'topno':
                        $log_name = 'untop';
                        $res = $this->list_top($id, 0);
                        break;
                    case 'displayok':
                        $log_name = 'frontshow';
                        $res = $this->list_display($id, 1);
                        break;
                    case 'displayno':
                        $log_name = 'fronthidden';
                        $res = $this->list_display($id, 0);
                        break;
                    case 'move':
                        if (!isset($_M['form']['columnid'])) {
                            break;
                        }
                        $log_name = 'columnmove1';
                        $class = explode("-", $_M['form']['columnid']);
                        $class1 = $class[0];
                        $class2 = $class[1];
                        $class3 = $class[2];
                        $res = $this->list_move($id, $class1, $class2, $class3);
                        break;
                    case 'copy':
                        if (!isset($_M['form']['columnid'])) {
                            break;
                        }
                        $log_name = 'copycontnet';
                        $class = explode("-", $_M['form']['columnid']);
                        $class1 = $class[0];
                        $class2 = $class[1];
                        $class3 = $class[2];
                        $newid = $this->list_copy($id, $class1, $class2, $class3);
                        break;
                    case 'copy_tolang':
                        if (!isset($_M['form']['columnid'])) {
                            break;
                        }
                        $log_name = 'copyotherlang';
                        $new_class = explode("-", $_M['form']['columnid']);
                        $tolang = $_M['form']['tolang'];
                        $module = $_M['form']['module'];
                        $res = $this->copy_tolang($id, $module, $tolang, $new_class);
                        break;
                }
            }
        }

        if (!$this->error) {
            $url = "{$_M['url']['own_form']}a=doindex&class1={$_M['form']['class1']}&class2={$_M['form']['class2']}&class3={$_M['form']['class3']}";
            $html_res = load::mod_class('html/html_op', 'new')->html_generate($url, $_M['form']['class1'], $_M['form']['id']);
            $redata['status'] = 1;
            $redata['msg'] = $_M['word']['jsok'];
            $redata['html_res'] = $html_res;
            $redata['back_url'] = $url;
            logs::addAdminLog('administration', $log_name, 'jsok', 'dolistsave');
        } else {
            $redata['status'] = 0;
            $redata['msg'] = $this->error[0];
            $redata['error'] = $this->error;
            logs::addAdminLog('administration', $log_name, $this->error[0], 'dolistsave');
        }
        $this->ajaxReturn($redata);
    }

    /*复制*/
    public function list_copy($id = '', $class1 = '', $class2 = '', $class3 = '')
    {
        if ($id && is_numeric($id)) {
            $content = $this->database->get_list_one_by_id($id);
            $content['filename'] = '';
            $content['class1'] = $class1;
            $content['class2'] = $class2;
            $content['class3'] = $class3;
            $content['classother'] = '';
            $content['updatetime'] = date("Y-m-d H:i:s");
            $content['addtime'] = date("Y-m-d H:i:s");
            $content['title'] = str_replace("'", "\'", $content['title']);
            $content['description'] = str_replace("'", "\'", $content['description']);
            $content['keywords'] = str_replace("'", "\'", $content['keywords']);
            $content['filename'] = str_replace("'", "\'", $content['filename']);
            $content['custom_info'] = str_replace("'", "\'", $content['custom_info']);
            $content['other_info'] = str_replace("'", "\'", $content['other_info']);
            $content['content'] = str_replace('\'', '\'\'', $content['content']);
            $content['content1'] = str_replace('\'', '\'\'', $content['content1']);
            $content['content2'] = str_replace('\'', '\'\'', $content['content2']);
            $content['content3'] = str_replace('\'', '\'\'', $content['content3']);
            $content['content4'] = str_replace('\'', '\'\'', $content['content4']);
            $copyid = $this->insert_list_sql($content);

            //复制产品参数
            if ($this->module == 3 || $this->module == 4 || $this->module == 5) {
                $this->para_copy($id, $copyid);
            }
            return $copyid;
        }
        $this->error[] = 'error no id';
        return false;
    }

    /**
     * 复制系统属性
     * @param $id
     * @param $copyid
     */
    public function para_copy($id, $copyid)
    {
        global $_M;
        $this->plist_database = load::mod_class('parameter/parameter_list_database', 'new');
        $this->plist_database->construct($this->module);

        ##$paralist = $this->para_list->get_list($id, $this->module);//
        $paralist = $this->plist_database->get_by_listid($id);
        foreach ($paralist as $key => $paravalue) {
            $listid = $copyid;
            $paraid = $paravalue['paraid'];
            $info = $paravalue['info'];
            $imgname = $paravalue['imgname'];
            $lang = $paravalue['lang'];
            $module = $paravalue['module'];
            ##$this->para_list->insert_plist($listid, $paraid, $info, $imgname, $lang, $module);
            $this->plist_database->update_by_listid_paraid($listid, $paraid, $info, $imgname);
        }
    }

    /**
     * 多语言内容复制
     */
    public function copy_tolang($id = '', $module = '', $tolang = '', $new_class = array())
    {
        global $_M;
        if ($id && $module && $tolang && $new_class) {
            $content = $this->database->get_list_one_by_id($id);
            if ($content) {
                $content['id'] = '';
                $content['filename'] = '';
                $content['class1'] = $new_class[0];
                $content['class2'] = $new_class[1];
                $content['class3'] = $new_class[2];
                $content['classother'] = '';
                $content['updatetime'] = date("Y-m-d H:i:s");
                $content['addtime'] = date("Y-m-d H:i:s");
                $content['title'] = str_replace("'", "\'", $content['title']);
                $content['description'] = str_replace("'", "\'", $content['description']);
                $content['keywords'] = str_replace("'", "\'", $content['keywords']);
                $content['filename'] = str_replace("'", "\'", $content['filename']);
                $content['custom_info'] = str_replace("'", "\'", $content['custom_info']);
                $content['other_info'] = str_replace("'", "\'", $content['other_info']);
                $content['content'] = str_replace('\'', '\'\'', $content['content']);
                $content['content1'] = str_replace('\'', '\'\'', $content['content1']);
                $content['content2'] = str_replace('\'', '\'\'', $content['content2']);
                $content['content3'] = str_replace('\'', '\'\'', $content['content3']);
                $content['content4'] = str_replace('\'', '\'\'', $content['content4']);
                $content['lang'] = $tolang ? $tolang : $content['lang'];
                $new_id = $this->insert_list_sql($content);
                if ($new_id) {
                    return $new_id;
                }
            }
            $this->error[] = "Content replication failed";
            return false;
        }
    }

    /*移动产品*/
    public function list_move($id = '', $class1 = '', $class2 = '', $class3 = '')
    {
        if ($id && is_numeric($id)) {
            $list['id'] = $id;
            $list['class1'] = $class1;
            $list['class2'] = $class2;
            $list['class3'] = $class3;
            return $this->database->update_by_id($list);
        }
        $this->error[] = 'error no id';
        return false;
    }

    /*修改排序*/
    public function list_no_order($id = '', $no_order = '')
    {
        if ($id && is_numeric($id)) {
            $list['id'] = $id;
            $list['no_order'] = $no_order;
            return $this->database->update_by_id($list);
        }
        $this->error[] = 'error no id';
        return false;
    }

    /*上架下架*/
    public function list_display($id = '', $display = '')
    {
        if ($id && is_numeric($id)) {
            $list['id'] = $id;
            $list['displaytype'] = $display;
            return $this->database->update_by_id($list);
        }
        $this->error[] = 'error no id';
        return false;
    }

    /*置顶*/
    public function list_top($id = '', $top = '')
    {
        if ($id && is_numeric($id)) {
            $list['id'] = $id;
            $list['top_ok'] = $top;
            return $this->database->update_by_id($list);
        }
        $this->error[] = 'error no id';
        return false;
    }

    /*推荐*/
    public function list_com($id = '', $com = '')
    {
        if ($id && is_numeric($id)) {
            $list['id'] = $id;
            $list['com_ok'] = $com;
            return $this->database->update_by_id($list);
        }
        $this->error[] = 'error no id';
        return false;
    }

    /*删除*/
    public function del_list($id = '', $recycle = 1)
    {
        if ($id && is_numeric($id)) {
            if ($recycle == 1) {
                //放入回收站
                $list['id'] = $id;
                $list['recycle'] = $recycle;
                $list['updatetime'] = date('Y-m-d H:i:s', time());
                return $this->database->update_by_id($list);
            } else {
                //删除数据
                $this->para_op->del_plist($id, $this->module); //删除属性值
                return $this->database->del_by_id($id);
            }
        }
        $this->error[] = 'error no id';
        return false;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
