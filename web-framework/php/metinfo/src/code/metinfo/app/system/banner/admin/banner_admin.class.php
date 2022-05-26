<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('base/admin/base_admin');

class banner_admin extends base_admin
{
    public $iniclass;
    public $database;
    public $tabledata;
    public $database_button;

    function __construct()
    {
        global $_M;
        parent::__construct();
        $this->database = load::mod_class('banner/banner_database', 'new');
        $this->database_button = load::mod_class('banner/banner_button_database', 'new');
        $this->tabledata = load::sys_class('tabledata', 'new');
    }

    public function columnlist()
    {
        $array = load::mod_class('column/column_op', 'new')->get_sorting_by_lv();
        $class1 = $array['class1'];
        $class2 = $array['class2'];
        $class3 = $array['class3'];

        $columnlist = array();
        foreach ($class1 as $key => $col1) {
            if ($col1['module'] == 0 || $col1['module'] > 100) {
                continue;
            }
            if ($class2[$col1['id']]) {
                $i = 0;
                foreach ($class2[$col1['id']] as $key2 => $col2) {
                    if ($col2['module'] == 0 || $col1['module'] > 100) {
                        continue;
                    }
                    if ($class3[$col2['id']]) {
                        $j = 0;
                        foreach ($class3[$col2['id']] as $key3 => $col3) {
                            if ($col3['module'] == 0 || $col1['module'] > 100) {
                                continue;
                            }
                            $col2['subcolumn'][$j] = $col3;
                            $j++;
                        }
                    }
                    $col1['subcolumn'][$i] = $col2;
                    $i++;
                }
            }
            $columnlist[] = $col1;
        }
        return $columnlist;
    }

    public function domanage()
    {
        $data['columnlist'] = $this->columnlist();
        return $data;
    }

    /**
     * 分页数据
     */
    public function dojson_list()
    {
        global $_M;
        $lang = $_M['lang'];
        $module = $_M['form']['module'];
        $met_flasharray = load::sys_class('label', 'new')->get('banner')->get_config();
        $where = "lang='$lang' and wap_ok='0'";
        if ($_M['form']['search'] == 'detail_search' && $_M['form']['ftype'] != 'all') {
            $tp = $_M['form']['ftype'] == 1 ? "and img_path!=''" : "and flash_path!=''";
            $where = "lang='$lang' and wap_ok='0' {$tp} ";
        }

        if ($module <> "") {
            $dule = $met_flasharray[$module]['type'] == 2 ? "(flash_path !='' and module = 'metinfo')" : "(img_path !='' and module = 'metinfo')";
            $where = "lang='$lang' and wap_ok='0' and (module like '%,{$module},%' or {$dule}) ";
            $module1[$module] = 'selected';
        }
        $order = " no_order ASC, id DESC ";

        $result = $this->tabledata->getdata($_M['table']['flash'], '*', $where, $order);
        foreach ($result as $key => $list) {
            if (trim($list['module'], ',') == 'metinfo') {
                $list['modulename'] = $_M['word']['allcategory'];
            } else {
                $lmod = explode(',', $list['module']);
                $cname = ',';
                for ($i = 0; $i < count($lmod); $i++) {
                    if ($lmod[$i] != '') {
                        if ($lmod[$i] == 10001) {
                            $cname .= $_M['word']['htmHome'] . ',';
                        } else {
                            $columnids = DB::get_one("select * from {$_M['table']['column']} where id='{$lmod[$i]}' and lang='{$lang}'");
                            $cname .= $columnids['name'] . ',';
                        }
                    }
                }
                $list['modulename'] = $cname;
            }
            $flashrec_list[] = $list;
        }


        foreach ($flashrec_list as $key => $val) {
            $valmdy = explode(',', $val['modulename']);
            if (count($valmdy) == 3) {
                $val['modulename'] = $valmdy[1];
            } elseif (count($valmdy) > 3) {
                $val['modulename'] = '';
                for ($i = 0; $i < count($valmdy); $i++) {
                    if ($valmdy[$i] != '') $val['modulename'] .= $i == (count($valmdy) - 2) ? $valmdy[$i] : $valmdy[$i] . '-';
                }
            }
            $valmname = utf8substr($val['modulename'], 0, 6);
            $list = array();
            $list['id'] = $val['id'];
            $list['no_order'] = $val['no_order'];
            $list['modulename'] = $val['modulename'];
            $list['img_title'] = $val['img_title'];
            $list['height'] = $val['height'];
            $list['height_t'] = $val['height_t'];
            $list['height_m'] = $val['height_m'];
            $list['img_path'] = $val['img_path'];
            $list['class1'] = $val['class1'];
            $list['class2'] = $val['class2'];
            $list['class3'] = $val['class3'];
            $list['valmname'] = $valmname;
            $list['editor_url'] = "a=doeditor&id={$val['id']}&class1={$val['class1']}&class2={$val['class2']}&class3={$val['class3']}";
            $list['del_url'] = "a=dolistsave&submit_type=del&allid={$val['id']}";
            $rarray[] = $list;
        }

        $rarray = $this->tabledata->rdata($rarray);
    }

    public function dolistsave()
    {
        global $_M;
        $list = explode(",", $_M['form']['allid']);
        foreach ($list as $id) {
            if ($id) {
                switch ($_M['form']['submit_type']) {
                    case 'save':
                        $list['no_order'] = $_M['form']['no_order_' . $id];
                        if (!is_numeric($_M['form']['height_' . $id])) {
                            $_M['form']['height_' . $id] = 0;
                        }
                        if (!is_numeric($_M['form']['height_t_' . $id])) {
                            $_M['form']['height_t_' . $id] = 0;
                        }
                        if (!is_numeric($_M['form']['height_m_' . $id])) {
                            $_M['form']['height_m_' . $id] = 0;
                        }
                        $list['height'] = $_M['form']['height_' . $id];
                        $list['height_t'] = $_M['form']['height_t_' . $id];
                        $list['height_m'] = $_M['form']['height_m_' . $id];
                        $this->list_no_order($id, $list['no_order'], $list['height'], $list['height_t'], $list['height_m']);
                        break;
                    case 'del':
                        $this->database->del_by_id($id);
                        break;
                }
            }
        }

        //写日志
        if ($_M['form']['submit_type'] == 'save') {
            logs::addAdminLog("indexflash", 'save', 'success', 'dolistsave');
        } else {
            logs::addAdminLog("indexflash", 'delete', 'success', 'dolistsave');
        }
        $redata['status'] = 1;
        $redata['msg'] = $_M['word']['jsok'];
        $this->ajaxReturn($redata);
    }


    public function list_no_order($id, $no_order, $height, $height_t, $height_m)
    {
        $list['id'] = $id;
        $list['no_order'] = $no_order;
        $list['height'] = $height;
        $list['height_t'] = $height_t;
        $list['height_m'] = $height_m;
        return $this->database->update_by_id($list);
    }

    /**
     * 编辑页面
     */
    public function doeditor()
    {
        global $_M;
        $id = $_M['form']['id'];
        $banner = DB::get_one("SELECT * FROM {$_M['table']['flash']} where id='{$id}'");
        $banner['target'] = $banner['target'] ? $banner['target'] : 0;
        $met_clumid_all = $banner['module'] == 'metinfo' ? 1 : '';

        $redata = array();
        $redata['met_clumid_all'] = $met_clumid_all;
        $redata['banner'] = $banner;
        $redata['columnlist'] = $this->columnlist();
        if (is_mobile()) {
            $this->ajaxReturn($redata);
        }
        return $redata;
    }

    /**
     * 新增内容
     */
    public function doadd()
    {
        global $_M;
        $data['columnlist'] = $this->columnlist();
        return $data;
    }

    /*数据添加保存*/
    public function doeditorsave()
    {
        global $_M;
        $module = $_M['form']['met_clumid_all'] == 1 ? 'metinfo' : $_M['form']['module'];
        if ($_M['form']['met_clumid_all'] != 1) {
            $module = ',' . $module . ',';
        }

        $_M['form']['height'] = is_numeric($_M['form']['height']) ? $_M['form']['height'] : 0;
        $_M['form']['height_t'] = is_numeric($_M['form']['height_t']) ? $_M['form']['height_t'] : 0;
        $_M['form']['height_m'] = is_numeric($_M['form']['height_m']) ? $_M['form']['height_m'] : 0;
        // 添加banner属性img_title_color、img_des、img_des_color、img_text_position（新模板框架v2）
        if ($_M['form']['action'] == 'add') {
            $query = "INSERT INTO {$_M['table']['flash']} (module,img_path,mobile_img_path,img_link,img_title,img_title_color,img_des,img_des_color,img_text_position,img_title_fontsize,img_des_fontsize,flash_path,flash_back,no_order,width,height,height_t,height_m,img_title_mobile,img_title_color_mobile,img_text_position_mobile,img_title_fontsize_mobile,img_des_mobile,img_des_color_mobile,img_des_fontsize_mobile,wap_ok,target,lang) VALUES('$module','{$_M['form']['img_path']}','{$_M['form']['mobile_img_path']}','{$_M['form']['img_link']}','{$_M['form']['img_title']}','{$_M['form']['img_title_color']}','{$_M['form']['img_des']}','{$_M['form']['img_des_color']}','{$_M['form']['img_text_position']}','{$_M['form']['img_title_fontsize']}','{$_M['form']['img_des_fontsize']}','{$_M['form']['flash_path']}','{$_M['form']['flash_back']}','{$_M['form']['no_order']}','{$_M['form']['width']}','{$_M['form']['height']}','{$_M['form']['height_t']}','{$_M['form']['height_m']}','{$_M['form']['img_title_mobile']}','{$_M['form']['img_title_color_mobile']}','{$_M['form']['img_text_position_mobile']}','{$_M['form']['img_title_fontsize_mobile']}','{$_M['form']['img_des_mobile']}','{$_M['form']['img_des_color_mobile']}','{$_M['form']['img_des_fontsize_mobile']}','0','{$_M['form']['target']}','{$_M['lang']}')";
           
            $res = DB::query($query);
            if (!$res) {
                //写日志
                logs::addAdminLog("indexflash", 'add', 'opfailed', 'doeditorsave');
                $redata['status'] = 0;
                $redata['msg'] = $_M['word']['opfailed'];
                $this->ajaxReturn($redata);
            } else {
                //写日志
                logs::addAdminLog("indexflash", 'add', 'success', 'doeditorsave');
                $redata['status'] = 1;
                $redata['msg'] = $_M['word']['jsok'];
                $this->ajaxReturn($redata);
            }
        }


        if ($_M['form']['action'] == 'editor') {
            $query = "UPDATE  {$_M['table']['flash']} SET
            module             = '$module',
            img_path           = '{$_M['form']['img_path']}',
            mobile_img_path    = '{$_M['form']['mobile_img_path']}',
            img_link           = '{$_M['form']['img_link']}',
            img_title          = '{$_M['form']['img_title']}',
            img_title_color    = '{$_M['form']['img_title_color']}',
            img_des            = '{$_M['form']['img_des']}',
            img_des_color      = '{$_M['form']['img_des_color']}',
            img_text_position  = '{$_M['form']['img_text_position']}',
            img_title_fontsize = '{$_M['form']['img_title_fontsize']}',
            img_des_fontsize   = '{$_M['form']['img_des_fontsize']}',
            flash_path         = '{$_M['form']['flash_path']}',
            flash_back         = '{$_M['form']['flash_back']}',
            no_order           = '{$_M['form']['no_order']}',
            width              = '{$_M['form']['width']}',
            height             = '{$_M['form']['height']}',
            height_t           = '{$_M['form']['height_t']}',
            height_m           = '{$_M['form']['height_m']}',
            img_title_mobile   = '{$_M['form']['img_title_mobile']}',
            img_title_color_mobile = '{$_M['form']['img_title_color_mobile']}',
            img_text_position_mobile = '{$_M['form']['img_text_position_mobile']}',
            img_title_fontsize_mobile = '{$_M['form']['img_title_fontsize_mobile']}',
            img_des_mobile     = '{$_M['form']['img_des_mobile']}',
            img_des_color_mobile = '{$_M['form']['img_des_color_mobile']}',
            img_des_fontsize_mobile = '{$_M['form']['img_des_fontsize_mobile']}',
            wap_ok             = '0',
            target             = '{$_M['form']['target']}',
            lang               = '{$_M['lang']}'
            where id='{$_M['form']['id']}'";
            $res = DB::query($query);
            if (!$res) {
                //写日志
                logs::addAdminLog("indexflash", 'save', 'opfailed', 'doeditorsave');
                $redata['status'] = 0;
                $redata['msg'] = $_M['word']['opfailed'];
                $this->ajaxReturn($redata);
            } else {
                //写日志
                logs::addAdminLog("indexflash", 'save', 'success', 'doeditorsave');
                $redata['status'] = 1;
                $redata['msg'] = $_M['word']['jsok'];
                $this->ajaxReturn($redata);
            }
        }

        $redata['status'] = 0;
        $redata['msg'] = $_M['word']['opfailed'];
        $this->ajaxReturn($redata);
    }

    /**
     * 获取banner额外内容
     */
    public function doGetFlashButton()
    {
        global $_M;
        $flash_id = $_M['form']['flash_id'];
        $where = " flash_id = '{$flash_id}' AND lang = '{$_M['lang']}'";
        $order = " no_order ";
        $list = $this->tabledata->getdata($_M['table']['flash_button'], '*', $where, $order);
        $this->tabledata->rdata($list);
    }

    /*  public function doAddFlashButton()
      {
          global $_M;
          $flash_id = $id = $_M['form']['id'];
          $redata['data']['id'] = $flash_id;
          $this->ajaxReturn($redata);
      }*/

    public function doFlashButtonSave()
    {
        global $_M;
        $redata = array();
        $form = $_M['form'];
        $res = $this->flashButtonSave($form);
        if ($res == false) {
            $redata['status'] = 0;
            $redata['msg'] = $this->error[0];
            $redata['error'] = $this->error;
        } else {
            $redata['status'] = 1;
            $redata['msg'] = $_M['word']['jsok'];
        }

        $this->ajaxReturn($redata);
    }

    public function flashButtonSave($form = array())
    {
        global $_M;
        $list = explode(",", $form['allid']);
        foreach ($list as $id) {
            if ($id) {
                if ($form['submit_type'] == 'save') {
                    $info = array();

                    $info['flash_id'] = $form['flash_id'];
                    $info['but_text'] = $form['but_text-' . $id];
                    $info['but_url'] = $form['but_url-' . $id];
                    $info['but_text_size'] = $form['but_text_size-' . $id];
                    $info['but_text_color'] = $form['but_text_color-' . $id];
                    $info['but_text_hover_color'] = $form['but_text_hover_color-' . $id];
                    $info['but_color'] = $form['but_color-' . $id];
                    $info['but_hover_color'] = $form['but_hover_color-' . $id];
                    $info['but_size'] = $form['but_size-' . $id];
                    $info['is_mobile'] = $form['is_mobile-' . $id];
                    $info['no_order'] = $form['no_order-' . $id];
                    $info['target'] = $form['target-' . $id];
                    $info['lang'] = $_M['lang'];

                    if (is_numeric($id)) {
                        $this->updateFlashButton($id, $info);
                    } else {
                        $this->insertFlashButton($info);
                    }
                } elseif ($form['submit_type'] == 'del') {
                    if (is_numeric($id)) {
                        $this->deleteFlashButton($id);
                    }
                }
            }
        }

        //写日志
        if ($form['submit_type'] == 'save') {
            logs::addAdminLog("indexflash", 'save', $this->error ? 'opfailed' : 'success', 'doFlashButtonSave');
        } else {
            logs::addAdminLog("indexflash", 'delete', $this->error ? 'opfailed' : 'success', 'doFlashButtonSave');
        }
        if ($this->error) {
            return false;
        }
        return true;
    }

    private function insertFlashButton($data = array())
    {
        global $_M;
        $insert_id = $this->database_button->insert($data);
        if ($insert_id) {
            return $insert_id;
        } else {
            $this->error[] = DB::error();
            return false;
        }
    }

    private function updateFlashButton($id = '', $data = array())
    {
        global $_M;
        if (is_numeric($id)) {
            $data['id'] = $id;
            $res = $this->database_button->update_by_id($data);
            return $res;
        } else {
            $this->error[] = $_M['word']['dataerror'];
            return false;
        }
    }

    private function deleteFlashButton($id = '')
    {
        global $_M;
        $res = $this->database_button->del_by_id($id);
        return $res;
    }
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.