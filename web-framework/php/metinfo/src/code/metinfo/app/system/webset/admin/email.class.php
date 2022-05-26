<?php
defined('IN_MET') or exit('No permission');

load::sys_class('admin');
load::sys_class('nav');

/** 邮箱服务器设置 */
class email extends admin
{
    public function __construct()
    {
        global $_M;
        parent::__construct();
    }

    //获取邮箱服务器信息
    public function doGetEmail()
    {
        global $_M;
        $data = array();
        $data['met_fd_usename'] = isset($_M['config']['met_fd_usename']) ? $_M['config']['met_fd_usename'] : '';
        $data['met_fd_fromname'] = isset($_M['config']['met_fd_fromname']) ? $_M['config']['met_fd_fromname'] : '';
        $data['met_fd_password'] = isset($_M['config']['met_fd_password']) ? $_M['config']['met_fd_password'] : '';
        $data['met_fd_smtp'] = isset($_M['config']['met_fd_smtp']) ? $_M['config']['met_fd_smtp'] : '';
        $data['met_fd_port'] = isset($_M['config']['met_fd_port']) ? $_M['config']['met_fd_port'] : '';
        $data['met_fd_way'] = isset($_M['config']['met_fd_way']) ? $_M['config']['met_fd_way'] : '';

        $this->success($data);
    }

    //保存邮箱服务器配置
    public function doSaveEmail()
    {
        global $_M;
        //保存系统配置
        $configlist = array();
        $configlist[] = 'met_fd_usename';
        $configlist[] = 'met_fd_fromname';
        if (isset($_M['form']['met_fd_password']) && $_M['form']['met_fd_password'] != 'passwordhidden') {
            $configlist[] = 'met_fd_password';
        }
        $configlist[] = 'met_fd_smtp';
        $configlist[] = 'met_fd_port';
        $configlist[] = 'met_fd_way';
        configsave($configlist);
        //写日志
        logs::addAdminLog('email_Settings', 'save', 'jsok', 'doSaveEmail');
        buffer::clearConfig();
        $this->success('', $_M['word']['jsok']);
    }

    //测试邮箱服务器
    public function doTestEmail()
    {
        global $_M;
        if (!get_extension_funcs('openssl') && stripos($_M['form']['met_fd_smtp'], '.gmail.com') !== false) {
            //写日志
            logs::addAdminLog('email_Settings', 'basictips3', 'setbasicTip14', 'doTestEmail');
            $this->error($_M['word']['setbasicTip14']);
        }

        if (!get_extension_funcs('openssl') && $_M['form']['met_fd_way'] == 'ssl') {
            //写日志
            logs::addAdminLog('email_Settings', 'basictips3', 'setbasicTip15', 'doTestEmail');
            $this->error($_M['word']['setbasicTip15']);
        }

        if (!function_exists('fsockopen') && !function_exists('pfsockopen') && !function_exists('stream_socket_client')) {
            //写日志
            logs::addAdminLog('email_Settings', 'basictips3', 'setbasicTip15', 'doTestEmail');
            $this->error($_M['word']['setbasicTip15']);
        } else {
            $usename = isset($_M['form']['met_fd_usename']) ? $_M['form']['met_fd_usename'] : '';
            $fromname = isset($_M['form']['met_fd_fromname']) ? $_M['form']['met_fd_fromname'] : '';
            $password = isset($_M['form']['met_fd_password']) ? $_M['form']['met_fd_password'] : '';
            $password = $password == 'passwordhidden' ? $_M['config']['met_fd_password'] : $password;
            $smtp = isset($_M['form']['met_fd_smtp']) ? $_M['form']['met_fd_smtp'] : '';
            $port = isset($_M['form']['met_fd_port']) ? $_M['form']['met_fd_port'] : '';
            $way = isset($_M['form']['met_fd_way']) ? $_M['form']['met_fd_way'] : '';

            $jmail = load::sys_class('jmail', 'new');
            $jmail->set_send_mailbox($usename, $fromname, $usename, $password, $smtp, $port, $way);

            $ret = $jmail->send_email($usename, $_M['word']['basictips3'], $_M['word']['basictips4']);

            if (!$ret) {
                //写日志
                logs::addAdminLog('email_Settings', 'basictips3', 'basictips6', 'doTestEmail');
                $this->error($_M['word']['basictips5'] . $_M['word']['basictips6'].$jmail->errorcode);
            }
            //写日志
            logs::addAdminLog('email_Settings', 'basictips3', 'basictips7', 'doTestEmail');
            $this->success('', $_M['word']['basictips7']);
        }
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
