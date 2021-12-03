<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('base/base_handle');

class product_handle extends base_handle
{

    public function __construct()
    {
        global $_M;
        $this->construct('product');
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

        //商品数据
        if ($_M['config']['shopv2_open'] && $this->contents_page_name == 'product') {
            $goods = load::plugin('doget_goods', 1, $content['id']);
            if ($goods && is_array($goods)) {
                $content = array_merge($content, $goods);
            }
        }

        return $content;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
