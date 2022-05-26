<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin.class.php');
load::sys_class('nav.class.php');
load::sys_class('curl');

/** 图片水印 */
class imgmanager extends admin {
    public function __construct()
    {
        global $_M;
        parent::__construct();
    }

    //获取缩略图设置
    public function doGetThumbs(){
        global $_M;
        $data = array();
        $data['met_autothumb_ok'] = isset($_M['config']['met_autothumb_ok']) ? $_M['config']['met_autothumb_ok'] : '';
        $data['met_thumb_kind'] = isset($_M['config']['met_thumb_kind']) ? $_M['config']['met_thumb_kind'] : '';
        $data['met_productimg_x'] = isset($_M['config']['met_productimg_x']) ? $_M['config']['met_productimg_x'] : '';
        $data['met_productimg_y'] = isset($_M['config']['met_productimg_y']) ? $_M['config']['met_productimg_y'] : '';
        $data['met_imgs_x'] = isset($_M['config']['met_imgs_x']) ? $_M['config']['met_imgs_x'] : '';
        $data['met_imgs_y'] = isset($_M['config']['met_imgs_y']) ? $_M['config']['met_imgs_y'] : '';
        $data['met_newsimg_x'] = isset($_M['config']['met_newsimg_x']) ? $_M['config']['met_newsimg_x'] : '';
        $data['met_newsimg_y'] = isset($_M['config']['met_newsimg_y']) ? $_M['config']['met_newsimg_y'] : '';
        $data['met_productdetail_x'] = isset($_M['config']['met_productdetail_x']) ? $_M['config']['met_productdetail_x'] : '';
        $data['met_productdetail_y'] = isset($_M['config']['met_productdetail_y']) ? $_M['config']['met_productdetail_y'] : '';
        $data['met_imgdetail_x'] = isset($_M['config']['met_imgdetail_x']) ? $_M['config']['met_imgdetail_x'] : '';
        $data['met_imgdetail_y'] = isset($_M['config']['met_imgdetail_y']) ? $_M['config']['met_imgdetail_y'] : '';

        $this->success($data);
    }

    //保存缩略图设置
    public function doSaveThumbs()
    {
        global $_M;
        if (isset($_M['form']['met_autothumb_ok'])){
            $_M['form']['met_autothumb_ok'] = $_M['form']['met_autothumb_ok'] ? 1 : 0;
        }
        $configlist = array();
        $configlist[] = 'met_autothumb_ok';
        $configlist[] = 'met_thumb_kind';
        $configlist[] = 'met_productimg_x';
        $configlist[] = 'met_productimg_y';
        $configlist[] = 'met_imgs_x';
        $configlist[] = 'met_imgs_y';
        $configlist[] = 'met_newsimg_x';
        $configlist[] = 'met_newsimg_y';
        $configlist[] = 'met_productdetail_x';
        $configlist[] = 'met_productdetail_y';
        $configlist[] = 'met_imgdetail_x';
        $configlist[] = 'met_imgdetail_y';
        //保存系统配置
        configsave($configlist);

        //写日志
        buffer::clearConfig();
        logs::addAdminLog('modimgurls','save','jsok','doSaveThumbs');
        $this->success('',$_M['word']['jsok']);
    }

    //获取水印设置
    public function doGetWaterMark(){
        global $_M;
        $data = array();
        $data['met_wate_class'] = isset($_M['config']['met_wate_class']) ? $_M['config']['met_wate_class'] : '';
        $data['met_big_wate'] = isset($_M['config']['met_big_wate']) ? $_M['config']['met_big_wate'] : '';
        $data['met_thumb_wate'] = isset($_M['config']['met_thumb_wate']) ? $_M['config']['met_thumb_wate'] : '';
        $data['met_watermark'] = isset($_M['config']['met_watermark']) ? $_M['config']['met_watermark'] : '';
        $data['met_text_wate'] = isset($_M['config']['met_text_wate']) ? $_M['config']['met_text_wate'] : '';
        $data['met_text_color'] = isset($_M['config']['met_text_color']) ? $_M['config']['met_text_color'] : '';
        $data['met_text_size'] = isset($_M['config']['met_text_size']) ? $_M['config']['met_text_size'] : '';
        $data['met_text_bigsize'] = isset($_M['config']['met_text_bigsize']) ? $_M['config']['met_text_bigsize'] : '';
        $data['met_text_fonts'] = isset($_M['config']['met_text_fonts']) ? $_M['config']['met_text_fonts'] : '';
        $data['met_wate_img'] = isset($_M['config']['met_wate_img']) ? $_M['config']['met_wate_img'] : '';
        $data['met_wate_bigimg'] = isset($_M['config']['met_wate_bigimg']) ? $_M['config']['met_wate_bigimg'] : '';
        $data['met_text_angle'] = isset($_M['config']['met_text_angle']) ? $_M['config']['met_text_angle'] : '';

        $this->success($data);
    }


    //保存水印设置
    public function doSaveWaterMark()
    {
        global $_M;
        if(isset($_M['from']['met_big_wate'])){
            $_M['form']['met_big_wate'] = $_M['from']['met_big_wate'] ? 1 : 0;
        }
        if(isset($_M['from']['met_thumb_wate'])) {
            $_M['form']['met_thumb_wate'] = $_M['from']['met_thumb_wate'] ? 1 : 0;
        }

        $configlist = array();
        $configlist[] = 'met_wate_class';
        $configlist[] = 'met_big_wate';
        $configlist[] = 'met_thumb_wate';
        $configlist[] = 'met_watermark';
        $configlist[] = 'met_text_wate';
        $configlist[] = 'met_text_size';
        $configlist[] = 'met_text_bigsize';
        $configlist[] = 'met_text_fonts';
        $configlist[] = 'met_text_angle';
        $configlist[] = 'met_text_color';
        $configlist[] = 'met_wate_img';
        $configlist[] = 'met_wate_bigimg';
        configsave($configlist);

        //写日志
        buffer::clearConfig();
        logs::addAdminLog('indexpic','save','jsok','doSaveWaterMark');
        $this->success('',$_M['word']['jsok']);
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.