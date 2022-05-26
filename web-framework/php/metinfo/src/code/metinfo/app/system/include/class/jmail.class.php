<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

/**
 * 发送邮件类
 * @param string $fromuser		发件人账号
 * @param string $fromname		发件人姓名
 * @param string $touser		收件人帐号
 * @param string $title			邮件标题
 * @param string $body			内容
 * @param string $usename		smtp用户账号（一般为发件人邮箱账号）
 * @param string $usepassword	smtp用户密码（一般为发件人邮箱密码）
 * @param string $smtp			smtp服务器
 * @param string $port			端口号
 * @param string $way			发送方式
 * @param string $errorcode     出错信息	
 */
class jmail
{
    public $fromuser;
    public $fromname;
    public $touser;
    public $title;
    public $body;
    public $usename;
    public $usepassword;
    public $smtp;
    public $port;
    public $way;
    public $errorcode;

    public function __construct()
    {
        $this->set_sys_mailbox();
    }

    /**
     * 为字段赋值
     * @param  string $name 字段名称
     * @param  mixed $value 要赋给字段的值
     * @return boolean        属性名不正确或值没有返回false
     */
    public function set($name, $value)
    {
        if ($value == null) {
            return false;
        }
        switch ($name) {
            case 'fromuser':
                $this->fromuser = $value;
                break;
            case 'fromname':
                $this->fromname = $value;
                break;
            case 'touser':
                $this->touser = $value;
                break;
            case 'title':
                $this->title = $value;
                break;
            case 'body':
                $this->body = $value;
                break;
            case 'usename':
                $this->usename = $value;
                break;
            case 'usepassword':
                $this->usepassword = $value;
                break;
            case 'smtp':
                $this->smtp = $value;
                break;
            case 'port':
                $this->port = $value;
                break;
            case 'way':
                $this->way = $value;
                break;
            default:
                return false;
                break;
        }
    }

    /**
     * 设置发件邮箱为网站后台设置邮箱
     */
    public function set_sys_mailbox()
    {
        global $_M;
        $this->set_send_mailbox($_M['config']['met_fd_usename'], $_M['config']['met_fd_fromname'], $_M['config']['met_fd_usename'], $_M['config']['met_fd_password'], $_M['config']['met_fd_smtp'], $_M['config']['met_fd_port'], $_M['config']['met_fd_way']);
    }

    /**
     * 设置发件邮箱
     */
    public function set_send_mailbox($fromuser, $fromname, $usename, $usepassword, $smtp, $port = 25, $way = 'tls')
    {
        global $_M;
        $this->set('fromuser', $fromuser);
        $this->set('fromname', $fromname);
        $this->set('usename', $usename);
        $this->set('usepassword', $usepassword);
        $this->set('smtp', $smtp);
        $this->set('port', $port);
        $this->set('way', $way);
    }

    /**
     * 发送邮件
     * @param  string $touser 收件人帐号
     * @param  string $title 邮件标题
     * @param  string $body 邮件内容
     * @param  string $patch 附件地址/绝对路径
     * @return boolean            发送成功返回true，否则返回false
     */
    public function send_email($touser, $title, $body, $patch = '')
    {
        global $_M;
        $this->touser = $touser;
        $this->title = $title;
        $this->body = $body;
        $mail = load::sys_class('phpmailer', 'new');
        $mail->CharSet = "UTF-8";
        $mail->Encoding = "base64";
        $mail->Timeout = 15;
        $mail->ClearAddresses();
        $mail->IsSMTP();

        if (stripos($this->smtp, '.gmail.com') === false) {
            $mail->Port = $this->port;
            $mail->Host = $this->smtp;
            if ($this->way == 'ssl') {
                $mail->SMTPSecure = "ssl";
            } else {
                $mail->SMTPSecure = "";
            }
        } else {
            $mail->Port = 465;
            $mail->Host = $this->smtp;
            $mail->SMTPSecure = "ssl";
        }
        $mail->SMTPAuth = true;
        $mail->Username = $this->usename;
        $mail->Password = $this->usepassword;
        $mail->From = $this->fromuser;
        $mail->FromName = $this->fromname;
        if ($this->repto != "") {
            $name = isset($this->repname) ? $this->repname : $this->repto;
            $mail->AddReplyTo($this->repto, $name);
        }
        $mail->WordWrap = 50; // line
        $mail->Subject = (isset($this->title)) ? $this->title : '';//title
        $body = preg_replace("\\", '', $this->body);
        $mail->MsgHTML($this->body);
        if ($this->touser) {
            $address = explode("|", $this->touser);
            foreach ($address as $key => $val) {
                $mail->AddAddress($val, '');
            }
        }
        $mail->AddAttachment($patch);
        if (!$mail->Send()) {
            $mail->SmtpClose();
            $this->errorcode = $mail->ErrorInfo;
            return false;
        } else {
            $mail->SmtpClose();
            return true;
        }
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>