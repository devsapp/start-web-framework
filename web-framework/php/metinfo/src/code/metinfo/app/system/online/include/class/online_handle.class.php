<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('news/news_handle');

/**
 * banner标签类
 */

class online_handle extends news_handle
{
    public function __construct()
    {
        global $_M;
        $this->construct('online');
    }

    /**
     * @param string $content
     */
    public function one_para_handle($content = array())
    {
        global $_M;
        switch ($content['type']) {
            case 0://qq
                $qq_url1 = 'https://wpa.qq.com/msgrd?v=3&uin=';
                $qq_url2 = '&site=qq&menu=yes';
                if (!met_useragent('desktop') && strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false) {
                    $qq_url1 = 'mqq://im/chat?chat_type=wpa&uin=';
                    $qq_url2 = '&version=1&src_type=web';
                }
                $url = "{$qq_url1}{$content['value']}{$qq_url2}";
                $content['url'] = $url;
                break;
            case 1://taobao
                // $url = "http://www.taobao.com/webww/ww.php?ver=3&touid=" . urlencode($content['value']) . "&siteid=cntaobao&status={$_M['config']['met_taobao_type']}&charset=utf-8'";
                $url = "http://www.taobao.com/webww/ww.php?ver=3&touid=" . urlencode($content['value']) . "&siteid=cntaobao&status=1&charset=utf-8";
                $content['url'] = $url;
                break;
            case 2://wangwang
                $url = "https://amos.alicdn.com/msg.aw?v=2&uid={$content['value']}&site=cnalichn&s={$_M['comfig']['met_alibaba_type']}&charset=UTF-8";
                $content['url'] = $url;
                break;
            case 3://tel
                $url = "tel:{$content['value']}";
                $content['url'] = $url;
                break;
            case 4://WX
                $url = str_replace('../', $_M['url']['web_site'], $content['value']);
                $content['url'] = $url;
                break;
            case 5://SKYPE
                $url = "skype:{$content['value']}?chat";
                $content['url'] = $url;
                break;
            case 6://Facebook
                $url = "https://www.facebook.com/{$content['value']}";
                $content['url'] = $url;
                break;
            case 8://企业QQ
                $url = "https://crm2.qq.com/page/portalpage/wpa.php?uin={$content['value']}&aty=0&a=0&curl=&ty=1";
                $content['url'] = $url;
                break;

        }
        return $content;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>