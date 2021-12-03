<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

class notice
{
    public function __construct()
    {

    }

    /**
     * 管理邮件员通知
     */
    public function notice_by_emial($username = '')
    {
        global $_M;
        if (!$_M['config']['met_new_registe_email_notice']) {
            return;
        }
        $data = array(
            'weburl' => $_M['config']['met_weburl'],
            'webname' => $_M['config']['met_webname'],
            'username' => $username,
        );
        #你的网站{web}收到新用户{username}注册注册请求，请登录网站后台查看
        $message = self::repalce_message($_M['word']['new_registe_email_content'], $data);

        $body = "
        <p>{$message}</p>
        <p><a href=\"{$_M['url']['admin_site']}\" target=\"_self\">{$_M['url']['admin_site']}</a></p>";
        $title = $_M['word']['new_regist_notice'];

        //管理员邮件通知
        $mail = load::sys_class('jmail', 'new');
        $met_to_admin_email = explode('|', $_M['config']['met_to_admin_email']);
        foreach ($met_to_admin_email as $email) {
            $mail->send_email($email, $title, $body);
        }
        return;
    }

    /**
     * 管理员短信通知
     * @param string $username
     */
    public function notice_by_sms($username = '')
    {
        global $_M;
        if ($_M['config']['met_new_registe_sms_notice']) {
            $data = array(
                'weburl' => $_M['config']['met_weburl'],
                'webname' => $_M['config']['met_webname'],
                'username' => $username,
            );
            #你的网站{web}收到新用户{username}注册注册请求，请登录网站后台查看
            $message = self::repalce_message($_M['word']['new_registe_email_content'], $data);
            $message .= $_M['config']['met_weburl'];

            $met_to_admin_sms = explode('|', $_M['config']['met_to_admin_sms']);
            foreach ($met_to_admin_sms as $tel) {
                load::sys_class('sms', 'new')->sendsms($tel, $message);
            }
        }
        return;
    }

    /**
     * @param $str
     * @param array $data
     * @return mixed
     */
    public function repalce_message($str, $data = array())
    {
        global $_M;
        foreach ($data as $key => $val) {
            $str = str_replace('{'.$key.'}', $val, $str);
        }
        return $str;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>