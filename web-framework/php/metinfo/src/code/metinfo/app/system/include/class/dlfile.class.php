<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

/**
 * 远程下载文件
 */
load::sys_class('curl');
load::sys_func('file');
 
class dlfile extends curl
{
    public function __construct()
    {
        global $_M;
        parent::__construct();
        $this->set('file', 'index.php?n=platform&c=dl&a=dodlfile');
    }


    /**
     * 远程下载文件
     * @param  array $urlfrom 下载文件路径
     * @param  string $urlto 保存文件地址
     * @param  string $checksum 下载权限码
     * @param  string $timeout 超时时间
     * @return string            下载成功返回1，失败返回报错信息。
     */
    public function dlfile($urlfrom, $urlto, $checksum = '', $info = '', $timeout = 30)
    {
        global $_M;
        $post_data = array('urlfrom' => $urlfrom, 'checknum' => $checksum, 'cmsver' => $_M['config']['metcms_v'], 'depend' => $info);

        $result = $this->curl_post($post_data, $timeout);
        $link = $this->error_no($result);
        if ($link != 1) {
            return $link;
        }
        if (substr($result, -7) == 'metinfo') {
            $result = substr($result, 0, -7);
            $link = $this->error_no($result);
            if ($link == 1) {
                if ($urlto) {
                    if (!file_exists($urlto)) {
                        makefile($urlto);
                    }
                    $return = file_put_contents($urlto, $result);
                    if (!$return) {
                        return $this->error_no('No filepower');
                    } else {
                        return 1;
                    }
                } else {
                    return $result;
                }
            } else {
                return $link;
            }
        } else {
            return $this->error_no('Timeout');
        }

    }

    public function error_no($str)
    {
        global $_M;
        switch ($str) {
            case 'Timeout' :
                return $_M['word']['dltips7'];
                break;
            case 'nolink' :
                return $_M['word']['dltips6'];
                break;
            case 'NO File' :
                return $_M['word']['dltips5'];
                break;
            case 'Please update' :
                return $_M['word']['dltips4'];
                break;
            case 'No Permissions' :
                return $_M['word']['dltips3'];
                break;
            case 'No filepower' :
                return $_M['word']['dltips2'];
                break;
            case 'nohost' :
                return $_M['word']['dltips1'];
                break;
            Default;
                return 1;
                break;
        }
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>