<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin');

class index extends admin
{
    public $error;
    public $moduleObj;

    public function __construct()
    {
        global $_M;
        parent::__construct();
        $this->error = array();
        $this->moduleObj = load::own_class('admin/class/Tem', 'new');
        $this->uiObj = load::own_class('admin/class/Ui', 'new');
    }

    public function doindex()
    {
    }

    public function dolist()
    {
        global $_M;
        $type = $_M['form']['type'];
        if($type == 'tag'){
            $res = $this->moduleObj->listTagTemplates();
            $this->success($res);
        }else{
            $res = $this->moduleObj->listTemplates();
            
            // if(!$_M['config']['met_secret_key']){
            //     $this->error();
            // }else{
                $this->success($res);
            // }
        }
    }

    public function doimport()
    {
        global $_M;
        sleep(3);
        $skin_name = $_M['form']['skin_name'];
        $res = $this->moduleObj->import($skin_name);
        //写日志
        logs::addAdminLog('appearance','setdbImportData','jsok','doimport');

        $this->success($res, '操作成功');

    }

    public function doinstall()
    {
        global $_M;
        $skin_name = $_M['form']['skin_name'];
        $res = $this->moduleObj->install($skin_name);
        $this->success($res);

    }

    public function dodownloadUI()
    {
        global $_M;
        $skin_name = $_M['form']['skin_name'];
        $ui_name = $_M['form']['ui_name'];
        $res = $this->moduleObj->downloadUI($skin_name, $ui_name);
        $this->success($res);
    }

    public function doenable()
    {
        global $_M;
        $skin_name = $_M['form']['skin_name'];
        $res = $this->moduleObj->enable($skin_name);
        $res2 = $this->uiObj->initializeMetUI();  //初始化集成UI数据
        //写日志
        logs::addAdminLog('appearance','skinusenow','jsok','doenable');
        $this->success($res, '切换成功');
    }
    public function dodelete()
    {
        global $_M;
        $skin_name = $_M['form']['skin_name'];
        $res = $this->moduleObj->delete($skin_name);

        //写日志
        logs::addAdminLog('appearance','delete','jsok','dodelete');

        $this->success($res, '设置成功');

    }
    public function docheck()
    {
        global $_M;
        $skin_name = $_M['form']['skin_name'];
        $res = $this->moduleObj->check($skin_name);
        if ($res) {
            $this->success($res);
        } else {
            $this->error($res);
        }

    }
    public function doupdate()
    {
        global $_M;
        $skin_name = $_M['form']['skin_name'];
        $res = $this->moduleObj->update($skin_name);
        if ($res) {
            //写日志
            logs::addAdminLog('appearance','appupgrade','met_template_updateok','doupdate');
            $this->success($res, '更新成功');
        }
        //写日志
        logs::addAdminLog('appearance','appupgrade','opfailed','doupdate');
    }

    public function dodownloadData()
    {
        global $_M;
        $skin_name = $_M['form']['skin_name'];
        $piece = $_M['form']['piece'] ? $_M['form']['piece'] : 0;
        $res = $this->moduleObj->downloadData($skin_name,$piece);
        if ($res) {
            $this->success($res, '下载成功');
        }
    }

    public function doimportData()
    {
        global $_M;
        $skin_name = $_M['form']['skin_name'];
        $piece = $_M['form']['piece'] ? $_M['form']['piece'] : 0;
        $res = $this->moduleObj->importData($skin_name,$piece);
        if ($res) {
            //写日志
            logs::addAdminLog('appearance','met_template_installdemo','jsok','doimportData');
            $this->success($res);
        }
        //写日志
        logs::addAdminLog('appearance','met_template_installdemo','opfailed','doimportData');
    }

    /**
     * 导入集成UI数据
     * @return bool
     */
    public function doimportDataMetUi()
    {
        global $_M;
        $block = $_M['form']['block'];
        $ui_name = $_M['form']['ui_name'];
        $lang = $_M['form']['tolang'] ? $_M['form']['tolang'] : $_M['lang'];

        if ($block == '' || $ui_name == '') {
            $this->error[] = "no block or no ui_name";
            dump($this->error);
            return false;
        }

        $res = $this->uiObj->addMetuiConfig($block,$lang);
        if ($res != true) {
            $error = $this->uiObj->geterror();
            $redata['status'] = 0;
            $redata['msg'] = '集成UI初始化失败';
            $redata['error'] = $this->error;
            $this->ajaxReturn($redata);
        }else{
            $this->success('',$_M['word']['jsok']);
            return true;
        }
    }

    /**
     * 初始化集成UI
     * @return bool
     */
    public function doIniSysUI()
    {
        global $_M;
        $redata = array();
        $res = $this->uiObj->initializeMetUI();
        if ($res != true) {
            $error = $this->uiObj->geterror();
            $redata['status'] = 0;
            $redata['msg'] = '集成UI初始化失败';
            $redata['error'] = $this->error;
            $this->ajaxReturn($redata);
        }else{
            $this->success('','集成UI初始化成功');
            return true;
        }
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
