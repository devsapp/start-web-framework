<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
defined('DEVDOMAIN')  OR define('DEVDOMAIN', 'https://www.whatsns.com/');
defined('DEVDOMAINFIX')  OR define('DEVDOMAINFIX', '.html');
$config['getToken'] = DEVDOMAIN."developer/gettoken".DEVDOMAINFIX;//获取token
$config['postquestion'] = DEVDOMAIN."developer/postquestion".DEVDOMAINFIX; //提交问题
$config['getquestionlist'] = DEVDOMAIN."developer/getquestionlist".DEVDOMAINFIX;//获取问题列表
$config['getquestiondetail'] = DEVDOMAIN."developer/getquestiondetail".DEVDOMAINFIX;//获取问题详情记录
$config['postappendquestion'] = DEVDOMAIN."developer/postappendquestion".DEVDOMAINFIX;//追加问题
$config['hasnewmessage'] = DEVDOMAIN."developer/hasnewmessage".DEVDOMAINFIX;//查看是否有新回复信息和官方通知
$config['getupdatelist'] = DEVDOMAIN."developer/getupdatelist".DEVDOMAINFIX; //获取可更新列表
$config['getupdatebyfileid'] = DEVDOMAIN."developer/getupdatebyfileid".DEVDOMAINFIX; //获取当前需要下载的文件id
$config['getapplist'] = DEVDOMAIN."developer/getapplist".DEVDOMAINFIX; //获取应用列表
$config['buyapp'] = DEVDOMAIN."developer/buyapp".DEVDOMAINFIX; //购买应用
$config['mybuyapplist'] = DEVDOMAIN."developer/mybuyapplist".DEVDOMAINFIX; //我的已购买应用
$config['getmybuyappfile'] = DEVDOMAIN."developer/getmybuyappfile".DEVDOMAINFIX; //获取购买得下载应用文件
$config['updatedownappstatus'] = DEVDOMAIN."developer/updatedownappstatus".DEVDOMAINFIX; //获取购买得下载应用文件


