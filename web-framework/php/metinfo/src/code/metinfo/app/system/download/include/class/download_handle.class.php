<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('base/base_handle');


class download_handle extends base_handle
{
    public function __construct()
    {
        global $_M;
        $this->construct('download');
    }

    /**
     * 处理list数组
     * @param  string $content 内容数组
     * @return array            处理过后数组
     */
    public function one_para_handle($content = array())
    {
        global $_M;
        $content = parent::one_para_handle($content);
        $content['downloadurl'] = str_replace('../', $_M['url']['web_site'], $content['downloadurl']);
        if ($content['downloadaccess']) {
            $url = urlencode(load::sys_class('auth', 'new')->encode($content['downloadurl']));
            $groupid = urlencode(load::sys_class('auth', 'new')->encode($content['downloadaccess']));
            $content['downloadurl'] = "{$_M['url']['entrance']}?m=include&c=access&a=dodown&url={$url}&groupid={$groupid}&lang={$_M['lang']}";
        }
        return $content;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
