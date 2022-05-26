<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

class auth
{

    public $auth_key;

    public function __construct()
    {
        global $_M;
        $this->auth_key = $_M['config']['met_webkeys'];
    }

    public function decode($str, $key = '')
    {
        return $this->authcode($str, 'DECODE', $this->auth_key . $key);
    }

    public function encode($str, $key = '', $time = 0)
    {
        return $this->authcode($str, 'ENCODE', $this->auth_key . $key, $time);
    }

    public function creatkey($length = '10')
    {
        $str = "A2B3C4zD5yE6xF7wG8vH9uitJsKrLnMmNlPkQjRiShTgUfVeWdXcYbZa";
        $result = "";
        for ($i = 0; $i < $length; $i++) {
            $num[$i] = rand(0, 25);
            $result .= $str[$num[$i]];
        }
        return $result;
    }

    /**
     * 字段权限控制代码加密后（加密后可用URL传递）.
     *
     * @param string $string    需要加密或解密的字符串
     * @param string $operation ENCODE:加密，DECODE:解密
     * @param string $key       密钥
     * @param int    $expiry    加密有效时间
     *
     * @return string 加密或解密后的字符串
     */
    public function authcode($string = '', $operation = 'DECODE', $key = '', $expiry = 0)
    {
        $ckey_length = 4;
        $key = md5($key ? $key : '');
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';
        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);

        if ($operation == 'ENCODE') {
            $string = $operation == 'DECODE' ? urlencode($string) : $string;
            $string = sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        } elseif ($operation == 'DECODE') {
            $string = base64_decode(substr($string, $ckey_length));
        }

        //$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
        $string_length = strlen($string);
        $result = '';
        $box = range(0, 255);
        $rndkey = array();
        for ($i = 0; $i <= 255; ++$i) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }
        for ($j = $i = 0; $i < 256; ++$i) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        for ($a = $j = $i = 0; $i < $string_length; ++$i) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if ($operation == 'DECODE') {
            if (!$result) {
                return '';
            }

            $exp_time = substr($result, 0, 10);
            if(!is_numeric($exp_time)){
                return '';
            }

            if (($exp_time == 0 || $exp_time - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                return urldecode(substr($result, 26));
                //return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc . str_replace('=', '', base64_encode($result));
        }
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>