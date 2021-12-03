<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * 微信推送相应
 * Class reply
 */
class weixinreply
{
    public $error;

    public function __construct()
    {
        global $_M;
        $this->error = array();
        $weixinapi = load::mod_class('weixin/weixinapi','new');
    }

    /**
     * 微信推送日志
     * @param $data
     * @return mixed
     */
    public function replyLog($data)
    {
        global $_M;
        $log = array();
        $log['FromUserName'] = $data['FromUserName'];
        $log['Content'] = json_encode($data,JSON_UNESCAPED_UNICODE);
        $log['CreateTime'] = $data['CreateTime'];

        $sql = '';
        foreach ($log as $key => $value) {
            $value = str_replace("'", "\'", $value);
            $sql .= " {$key} = '{$value}',";
        }
        $sql = trim($sql, ',');
        $query = "INSERT INTO {$_M['table']['weixin_reply_log']} SET $sql";
        DB::query($query);
    }

    /**
     * 获取回复的内容
     * @param  array $postStr 接收到的内容
     * @return string  回复内容
     */
    public function getContent($postStr)
    {
        global $_M;
        libxml_disable_entity_loader(true);
        $data = json_decode(json_encode(simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

        $this->openid = $data['FromUserName'];

        $this->replyLog($data);
        switch ($data['MsgType']) {
            case 'event':
                switch ($data['Event']) {
                    case 'subscribe'://订阅
                        if ($data['EventKey']) {
                            $data['EventKey'] = strReplace('qrscene_', '', $data['EventKey']);
                            return $this->scna($data);
                        }else{
                            return $this->Reply($data, strtolower($data['Event']));
                        }
                        break;
                    case 'unsubscribe'://取消订阅
                        return $this->replyLog($data);
                        break;
                    case 'SCAN'://用户已关注时的事件推送
                        return $this->scna($data);
                        break;
                    case 'LOCATION'://上报地理位置事件
                        return $this->replyLog($data);
                        break;
                    case 'CLICK'://点击菜单拉取消息时的事件推送
                        return $this->Reply($data, 'click');
                        break;
                    case 'VIEW'://点击菜单跳转链接时的事件推送
                        return $this->replyLog($data);
                        break;
                    default:
                        return $this->Reply($data);
                        break;
                }
                break;
            case 'text':
                return $this->Reply($data, strtolower($data['MsgType']));
                break;
            case 'image':
                return $this->Reply($data, strtolower($data['MsgType']));
                break;
            default:
                return $this->Reply($data);
                break;
        }
    }


    /**
     * 扫码事件
     * @param array $data
     */
    public function scna($data = array())
    {
        $EventKey = explode('&', $data['EventKey']);
        $action = $EventKey[0];
        $code = $EventKey[1];
        switch ($action) {
            case 'login':
                $this->wxLogin($data, $code);
                break;
            case 'bind':
                $this->wxBind($data, $code);
                break;
            default:
                break;
        }
        return;
    }

    /**
     * 微信登录
     * @param array $data
     */
    public function wxLogin($data = array(),$code = '')
    {
        global $_M;
        $weixinapi = load::mod_class('weixin/weixinapi','new');
        $wx_user = $weixinapi->getwxUser($data['FromUserName']);    //获取用户信息
        if (!$wx_user) {
            $this->error[] = '微信用户信息获取失败';
            return false;
        }

        $weixin_party = load::mod_class('user/web/class/weixin_party', 'new');
        $weixin_party->WXlogin($wx_user, $code);
        return;
    }

    /**
     * 用户账号绑定微信
     * @param array $data
     */
    public function wxBind($data = array(),$code = '')
    {
        global $_M;
        $weixinapi = load::mod_class('weixin/weixinapi','new');
        $wx_user = $weixinapi->getwxUser($data['FromUserName']);    //获取用户信息
        if (!$wx_user) {
            $this->error[] = '微信用户信息获取失败';
            return false;
        }

        $weixin_party = load::mod_class('user/web/class/weixin_party', 'new');
        $weixin_party->confirmWxbind($code, $wx_user);
        return;
    }

    /*******************************/
    /**
     * 事件回复
     * @param array $data
     * @param string $type
     */
    public function Reply($data = array(), $type = '')
    {
        $weixin_app = load::app_class('met_weixin/include/class/reply','new');

        $weixin_app->Reply($data, $type);
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
