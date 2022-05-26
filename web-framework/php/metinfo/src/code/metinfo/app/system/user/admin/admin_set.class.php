<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

load::sys_class('admin');
/** 会员功能设置 */
class admin_set extends admin
{
    public function __construct()
    {
        parent::__construct();
        global $_M;
    }

    //获取会员功能设置
    public function doGetUserSetup()
    {
        global $_M;
        $data = array();
        $data['met_member_register'] = isset($_M['config']['met_member_register']) ? $_M['config']['met_member_register'] : '';     //开放注册
        $data['met_member_vecan'] = isset($_M['config']['met_member_vecan']) ? $_M['config']['met_member_vecan'] : '';        //验证方式
        $data['met_member_bgcolor'] = isset($_M['config']['met_member_bgcolor']) ? $_M['config']['met_member_bgcolor'] : '';      //背景颜色
        $data['met_member_bgimage'] = isset($_M['config']['met_member_bgimage']) ? $_M['config']['met_member_bgimage'] : '';      //背景图
        $data['met_member_idvalidate'] = isset($_M['config']['met_member_idvalidate']) ? $_M['config']['met_member_idvalidate'] : '';      //实名认证
        $data['met_member_agreement'] = isset($_M['config']['met_member_agreement']) ? $_M['config']['met_member_agreement'] : 0;      //注册协议开关
        $data['met_member_agreement_content'] = isset($_M['config']['met_member_agreement_content']) ? $_M['config']['met_member_agreement_content'] : '';      //注册协议内容
        $data['met_login_box_position'] = isset($_M['config']['met_login_box_position']) ? $_M['config']['met_login_box_position']: 0;     //登录框位置
        $data['met_member_bg_range'] = isset($_M['config']['met_member_bg_range']) ? $_M['config']['met_member_bg_range']: 0;     //背景生效页面

        $data['met_new_registe_email_notice'] = isset($_M['config']['met_new_registe_email_notice']) ? $_M['config']['met_new_registe_email_notice'] : 0; //邮件通知
        $data['met_to_admin_email'] = isset($_M['config']['met_to_admin_email']) ? $_M['config']['met_to_admin_email'] : ''; //邮件通知

        $data['met_new_registe_sms_notice'] = isset($_M['config']['met_new_registe_sms_notice']) ? $_M['config']['met_new_registe_sms_notice'] : 0; //短信通知
        $data['met_to_admin_sms'] = isset($_M['config']['met_to_admin_sms']) ? $_M['config']['met_to_admin_sms'] : ''; //短信通知

        //查询实名认证可用条数
        $idvalid = load::mod_class('user/include/class/user_idvalid.class.php', 'new');
        $result = $idvalid->checkNumber();
        $data['member'] = 0;
        if ($result['status'] == 200) {
            if (!$result['msg']) {
                $data['member'] = 0;
            } else {
                $data['member'] = $result['msg'];
            }
        }
        $this->success($data);
    }

    //保存设置
    public function doSaveSetup()
    {
        global $_M;
        $configlist = array();
        $configlist[] = 'met_member_register';
        $configlist[] = 'met_member_vecan';
        $configlist[] = 'met_member_bgcolor';
        $configlist[] = 'met_member_bgimage';
        $configlist[] = 'met_member_idvalidate';
        $configlist[] = 'met_member_agreement';
        $configlist[] = 'met_member_agreement_content';
        $configlist[] = 'met_member_bg_range';
        $configlist[] = 'met_new_registe_email_notice';
        $configlist[] = 'met_to_admin_email';
        $configlist[] = 'met_new_registe_sms_notice';
        $configlist[] = 'met_to_admin_sms';
        $configlist[] = 'met_login_box_position';
        configsave($configlist);
        //写日志
        logs::addAdminLog('memberfunc', 'save', 'jsok', 'doSaveSetup');
        $this->success('', $_M['word']['jsok']);
    }

    //获取第三方登录设置
    public function doGetThirdParty()
    {
        global $_M;

        $list = array();
        $list['met_auto_register'] = isset($_M['config']['met_auto_register']) ? $_M['config']['met_auto_register'] : 0;
        //微信
        $list['met_weixin_open'] = isset($_M['config']['met_weixin_open']) ? $_M['config']['met_weixin_open'] : '';
        //开放平台
        #$list['met_weixin_appid'] = isset($_M['config']['met_weixin_appid']) ? $_M['config']['met_weixin_appid'] : '';
        #$list['met_weixin_appsecret'] = isset($_M['config']['met_weixin_appsecret']) ? $_M['config']['met_weixin_appsecret'] : '';
        //公众平台
        $list['met_weixin_gz_appid'] = isset($_M['config']['met_weixin_gz_appid']) ? $_M['config']['met_weixin_gz_appid'] : '';
        $list['met_weixin_gz_appsecret'] = isset($_M['config']['met_weixin_gz_appsecret']) ? $_M['config']['met_weixin_gz_appsecret'] : '';
        $list['met_weixin_gz_token'] = isset($_M['config']['met_weixin_gz_token']) ? $_M['config']['met_weixin_gz_token'] : '';
        $list['met_weixin_gz_url'] = $_M['url']['web_site'] . "app/system/entrance.php?c=weixin&m=include&a=doapi";
        //QQ
        $list['met_qq_open'] = isset($_M['config']['met_qq_open']) ? $_M['config']['met_qq_open'] : '';
        $list['met_qq_appid'] = isset($_M['config']['met_qq_appid']) ? $_M['config']['met_qq_appid'] : '';
        $list['met_qq_appsecret'] = isset($_M['config']['met_qq_appsecret']) ? $_M['config']['met_qq_appsecret'] : '';
        //微博
        $list['met_weibo_open'] = isset($_M['config']['met_weibo_open']) ? $_M['config']['met_weibo_open'] : '';
        $list['met_weibo_appkey'] = isset($_M['config']['met_weibo_appkey']) ? $_M['config']['met_weibo_appkey'] : '';
        $list['met_weibo_appsecret'] = isset($_M['config']['met_weibo_appsecret']) ? $_M['config']['met_weibo_appsecret'] : '';

        $this->success($list);
    }

    //保存第三方登录设置
    public function doSaveThirdParty()
    {
        global $_M;
        if ($_M['config']['met_index_type'] == $_M['lang']){
            $configlist = array();
            $configlist[] = 'met_auto_register';
            $configlist[] = 'met_weixin_appid';
            $configlist[] = 'met_weixin_appsecret';
            $configlist[] = 'met_weixin_gz_appid';
            $configlist[] = 'met_weixin_gz_appsecret';
            $configlist[] = 'met_weixin_gz_token';
            $configlist[] = 'met_weibo_appkey';
            $configlist[] = 'met_weibo_appsecret';
            $configlist[] = 'met_qq_appid';
            $configlist[] = 'met_qq_appsecret';
            $configlist[] = 'met_weixin_open';
            $configlist[] = 'met_weibo_open';
            $configlist[] = 'met_qq_open';
            configsave($configlist);
            //写日志
            logs::addAdminLog('thirdlogin', 'save', 'jsok', 'doSaveThirdParty');
            $this->success($_M['word']['jsok']);
        }
        $this->error($_M['word']['third_party_error']);
    }

    //获取邮箱内容设置
    public function doGetemailSetup()
    {
        global $_M;

        $list = array();
        $list['met_member_email_reg_title'] = isset($_M['config']['met_member_email_reg_title']) ? $_M['config']['met_member_email_reg_title'] : '';
        $list['met_member_email_reg_content'] = isset($_M['config']['met_member_email_reg_content']) ? $_M['config']['met_member_email_reg_content'] : '';

        $list['met_member_email_password_title'] = isset($_M['config']['met_member_email_password_title']) ? $_M['config']['met_member_email_password_title'] : '';
        $list['met_member_email_password_content'] = isset($_M['config']['met_member_email_password_content']) ? $_M['config']['met_member_email_password_content'] : '';

        $list['met_member_email_safety_title'] = isset($_M['config']['met_member_email_safety_title']) ? $_M['config']['met_member_email_safety_title'] : '';
        $list['met_member_email_safety_content'] = isset($_M['config']['met_member_email_safety_content']) ? $_M['config']['met_member_email_safety_content'] : '';

        $this->success($list);
    }

    //保存邮箱设置
    public function doSaveEmailSetup()
    {
        global $_M;
        $configlist = array();
        $configlist[] = 'met_member_email_reg_title';
        $configlist[] = 'met_member_email_reg_content';

        $configlist[] = 'met_member_email_password_title';
        $configlist[] = 'met_member_email_password_content';

        $configlist[] = 'met_member_email_safety_title';
        $configlist[] = 'met_member_email_safety_content';

        configsave($configlist);
        //写日志
        logs::addAdminLog('mailcontentsetting', 'save', 'jsok', 'doSaveEmailSetup');
        $this->success('', $_M['word']['jsok']);
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>