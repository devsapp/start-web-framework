<?php

defined('IN_MET') or exit('No permission');

class met_sms
{
    public function __construct()
    {
        global $_M;
        $_M['config']['met_sms_url'] = 'https://u.mituo.cn/api/sms';
    }

    public function get_sms()
    {
        global $_M;
        $data = array(
            'user_key' => $_M['config']['met_secret_key'],
            'sms_token' => $_M['config']['met_sms_token'],
            'url' => $_M['config']['met_weburl'],
            'type' => 'sms',
        );
        $res = $this->curl($_M['config']['met_sms_url'], $data);

        if ($res['status'] == 200) {
            return $res['data'];
        } else {
            return '';
        }
    }

    /**
     * 短信发送记录.
     *
     * @DateTime 2017-07-26
     *
     * @param [type] $start  offset
     * @param [type] $length limit
     */
    public function get_logs($start, $length)
    {
        global $_M;
        $data = array(
            'user_key' => $_M['config']['met_secret_key'],
            'sms_token' => $_M['config']['met_sms_token'],
            'url' => $_M['config']['met_weburl'],
            'type' => 'logs',
            'start' => $start,
            'length' => $length,
        );

        return $this->curl($_M['config']['met_sms_url'], $data);
    }

    /**
     * 营销类短信
     *
     * @DateTime 2017-07-26
     *
     * @param [type] $phone
     * @param [type] $content
     */
    public function custom_send($phone, $content)
    {
        global $_M;
        $data = array(
            'user_key' => $_M['config']['met_secret_key'],
            'sms_token' => $_M['config']['met_sms_token'],
            'url' => $_M['url']['web_site'],
            'type' => 'custom_send',
            'phone' => $phone,
            'content' => $content,
        );

        return $this->curl($_M['config']['met_sms_url'], $data);
    }

    /**
     * 通知类短信
     *
     * @DateTime 2017-07-26
     *
     * @param [type] $phone
     * @param [type] $content
     */
    public function auto_send($phone, $content)
    {
        global $_M;
        if ($phone == '') {
            return false;
        }
        $data = array(
            'user_key' => $_M['config']['met_secret_key'],
            'sms_token' => $_M['config']['met_sms_token'],
            'url' => $_M['url']['web_site'],
            'type' => 'auto_send',
            'phone' => $phone,
            'content' => $content,
        );

        return $this->curl($_M['config']['met_sms_url'], $data);
    }

    public function curl($url, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 8);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        #curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        curl_close($ch);
        if ($result) {
            return json_decode($result, true);
        } else {
            return false;
        }
    }
}
