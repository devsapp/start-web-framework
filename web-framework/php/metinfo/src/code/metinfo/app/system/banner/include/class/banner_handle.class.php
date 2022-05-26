<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('handle');

/**
 * banner标签类
 */

class banner_handle extends handle
{
    /**
     * 处理图片字段
     * @param  string $banner 设置数组
     * @return array           处理过后的栏目配置数组
     */
    public function config_para_handle($banner_config = array())
    {
        global $_M;
        return $banner_config;
    }

    /**
     * 处理设置字段
     * @param  string $banner 设置数组
     * @return array           处理过后的栏目图片数组
     */
    public function img_para_handle($banner_img = array())
    {
        global $_M;
        foreach ($banner_img as $key => $val) {
            $banner_img[$key]['img_path'] = $val['img_path'] ? $this->url_transform($val['img_path']) : '';
            $banner_img[$key]['mobile_img_path'] = $val['mobile_img_path'] ? $this->url_transform($val['mobile_img_path']) : '';
            if ($banner_img[$key]['mobile_img_path'] == '' && $banner_img[$key]['img_path']) {
                $banner_img[$key]['mobile_img_path'] = $banner_img[$key]['img_path'];
            }
            if (is_mobile() && $val['mobile_img_path']) {//老模板兼容
                $banner_img[$key]['img_path'] = $this->url_transform($val['mobile_img_path']);
            }

            //字体大小
            $banner_img[$key]['img_title_fontsize'] = $banner_img[$key]['img_title_fontsize'] ? $banner_img[$key]['img_title_fontsize'] : '';
            $banner_img[$key]['img_des_fontsize'] = $banner_img[$key]['img_des_fontsize'] ? $banner_img[$key]['img_des_fontsize'] : '';

            $banner_img[$key]['img_title_mobile'] = $banner_img[$key]['img_title_mobile'] ? $banner_img[$key]['img_title_mobile'] : $banner_img[$key]['img_title'];
            $banner_img[$key]['img_title_color_mobile'] = $banner_img[$key]['img_title_color_mobile'] ? $banner_img[$key]['img_title_color_mobile'] : $banner_img[$key]['img_title_color'];
            $banner_img[$key]['img_text_position_mobile'] = $banner_img[$key]['img_text_position_mobile'] != '' ? $banner_img[$key]['img_text_position_mobile'] : $banner_img[$key]['img_text_position'];
            $banner_img[$key]['img_des_mobile'] = $banner_img[$key]['img_des_mobile'] ? $banner_img[$key]['img_des_mobile'] : $banner_img[$key]['img_des'];
            $banner_img[$key]['img_des_color_mobile'] = $banner_img[$key]['img_des_color_mobile'] ? $banner_img[$key]['img_des_color_mobile'] : $banner_img[$key]['img_des_color'];
            $banner_img[$key]['img_title_fontsize_mobile'] = $banner_img[$key]['img_title_fontsize_mobile'] ? $banner_img[$key]['img_title_fontsize_mobile'] : $banner_img[$key]['img_title_fontsize'];
            $banner_img[$key]['img_des_fontsize_mobile'] = $banner_img[$key]['img_des_fontsize_mobile'] ? $banner_img[$key]['img_des_fontsize_mobile'] : $banner_img[$key]['img_des_fontsize'];
            $banner_img[$key]['img_link'] = str_replace('../', $_M['url']['site'], $banner_img[$key]['img_link']);

            $banner_img[$key]['button'] = $this->button_para_handle($val['id']);
        }
        return $banner_img;
    }

    public function button_para_handle($flash_id = '')
    {
        global $_M;
        $button_database = load::mod_class('banner/banner_button_database', 'new');
        $data = $button_database->getOneButtonByFlashId($flash_id);
        $but_list = array();
        foreach ($data as $key => $but) {
            $but_list[$key] = $this->one_but_handle($but);
        }
        return $but_list;
    }

    public function one_but_handle($button = array())
    {
        global $_M;
        $but_size = explode('x', $button['but_size']);
        $button['but_x'] = $but_size[0] ? $but_size[0] : '';
        $button['but_y'] = $but_size[1] ? $but_size[1] : '';
        $button['but_text_size'] = $button['but_text_size'] ? $button['but_text_size'] : '';
        $button['but_url'] = str_replace('../', $_M['url']['site'], $button['but_url']);

        return $button;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
