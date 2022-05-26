<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('base/base_handle');

/**
 * 留言处理类
 */

class message_handle extends base_handle
{

    public function __construct()
    {
        global $_M;
        $this->construct('message');
    }

    /**
     * 处理留言列表字段
     * @param  string $message_list 留言列表数组
     * @return array                 处理过后的留言列表
     */
    public function para_handle($message_list)
    {
        global $_M;
        foreach ($message_list as $key => $val) {
            $message_lists[$key] = $this->one_para_handle($val);
            $power = load::sys_class('user', 'new')->check_power($val['access']);
            if ($power < 0) {
                $message_lists[$key]['useinfo'] = "{$_M['word']['Reply']}<br>【<a href='../member/login.php?lang={$_M['lang']}'>{$_M['word']['login']}</a>】【<a href='../member/register_include.php?lang={$_M['lang']}'>{$_M['word']['register']}</a>】";
            }
        }
        return $message_lists;
    }

    /**
     * 处理设置字段
     * @param  string $message 设置数组
     * @return array           处理过后的栏目图片数组
     */
    public function one_para_handle($message = array())
    {
        global $_M;
        $message['addtime'] = date($_M['config']['met_listtime'], strtotime($message['addtime']));
        return $message;
    }

    /**
     * 处理设置字段
     * @param  string $id 反馈栏目id
     * @return array 提交表单地址
     */
    public function module_form_url($id)
    {
        global $_M;
        #$c = load::sys_class('label', 'new')->get('column')->get_column_id($id);
        return $this->url_transform('message/index.php?action=add&lang=' . $_M['lang']);
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
