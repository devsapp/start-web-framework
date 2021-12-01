<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('web');
load::sys_class('upfile');
load::sys_func('array');

/**
 * 一个强大的上传类，可上传文件或图片，上传的图片根据所传的值控制是否生成大图水印，缩略图，缩略图水印，以及控制其下的大部分属性。
 * @param object $upfile		实例化upfile类
 * @param object $watermark 	实例化watermark类
 * @param object $thumb			实例化thumb类
 */
class uploadify extends web
{
    public $upfile;

    function __construct()
    {
        parent::__construct();
        global $_M;
        $this->upfile = new upfile();
        $this->max_img_px_size = 2600;
    }

    /**
     * 设置上传属性
     */
    public function set_upload($info)
    {
        global $_M;
        $this->upfile->set('savepath', $info['savepath']);
        $this->upfile->set('format', $info['format']);
        $this->upfile->set('maxsize', $info['maxsize']);
        $this->upfile->set('is_rename', $info['is_rename']);
        $this->upfile->set('is_overwrite', $info['is_overwrite']);
    }

    /**
     * 上传函数
     * @return json                            返回成功或失败信息，成功有路径，失败有错误信息，不过要通过json解析
     */
    public function upload($formname)
    {
        global $_M;
        $res = $this->upfile->upload($formname);
        return $res;
    }

    /**
     * 上传图片执行函数
     * @param array $file 设置属性
     */
    public function upimg($file)
    {
        global $_M;
        $this->upfile->set_upimg();
        $this->set_upload($file);
        $back = $this->upload($file['formname']);
        if ($back['error']) {
            return $back;
        } else {
            $res = self::checkimg($back);
            if ($res == true) {
                //self::imgCompress($back);
                $back['original'] = $back['path'];
                $back['size'] = $back['size'];
                return $back;
            } else {
                $redata = array();
                $redata['error'] = "图片尺寸超出系统限制(图片宽高不超过{$this->max_img_px_size}px)";
                return $redata;
            }
        }
    }

    /**
     * 上传文件
     * @return json  返回成功或失败信息，成功有路径，失败有错误信息，不过要通过json解析
     */
    public function doupfile()
    {
        global $_M;
        $this->upfile->set_upfile();
        $info['is_overwrite'] = $_M['form']['is_overwrite'];
        $this->set_upload($info);
        $back = $this->upload($_M['form']['formname']);
        $back['order'] = $_M['form']['file_id'] ? $_M['form']['file_id'] : 0;
        if ($_M['form']['type'] == 1) {
            if ($back['error']) {
                $this->ajaxReturn($back);
            } else {
                $back['original'] = $back['path'];
                $back['append'] = 'false';
                $back['filesize'] = $back['size'];
                $back['filesize'] = round($back['size'] / 1024, 2);
                $this->ajaxReturn($back);
            }
        }
    }

    /**
     * 上传图片
     * @return json 返回成功或失败信息，成功有路径，失败有错误信息，不过要通过json解析
     */
    public function doupimg()
    {
        global $_M;
        $infoarray = array('formname', 'savepath', 'format', 'maxsize', 'is_rename', 'is_overwrite');
        $info = copykey($_M['form'], $infoarray);
        $back = $this->upimg($info);
        $imgpath = explode('../', $back['path']);
        $img_info = getimagesize(PATH_WEB . $imgpath[1]);
        $img_name = pathinfo(PATH_WEB . $imgpath[1]);
        $back['order'] = $_M['form']['file_id'] ? $_M['form']['file_id'] : 0;
        if ($back['error']) {
            $this->ajaxReturn($back);
        } else {
            $back['name'] = $img_name['basename'];
            $back['path'] = $imgpath[1];
            $back['x'] = $img_info[0];
            $back['y'] = $img_info[1];
            #$back['filesize'] =  round(filesize($back['original'])/1024,2);
            #$back['filesize'] =  $back['size'];
            $back['filesize'] = round($back['size'] / 1024, 2);
            $this->ajaxReturn($back);
        }
    }

    /**
     * 上传头像
     * @return json  返回成功或失败信息，成功有路径，失败有错误信息，不过要通过json解析
     */
    public function dohead()
    {
        global $_M;

        $info['formname'] = $_M['form']['formname'];
        $info['savepath'] = '/head';
        $info['format'] = 'jpg|jpeg|png|gif';
        $info['maxsize'] = '5';
        $info['is_rename'] = 1;

        if (!get_met_cookie('id')) {
            // 未登录用户中心无权限上传
            $this->ajaxReturn($_M['word']['uploadfilenop']);
        }
        $back = $this->upimg($info);
        if ($back['error']) {
            $this->ajaxReturn($back);
        } else {
            $file_old = PATH_WEB . str_replace('../', '', $back['path']);
            $basename = basename($file_old);
            $file_new = PATH_WEB . 'upload/head/' . get_met_cookie('id') . '_' . $basename;
            rename($file_old, $file_new);
            $thumb = load::sys_class('thumb', 'new');//加载缩略图类
            $thumb->set('thumb_width', '200');//保存在原图路径的子目录下
            $thumb->set('thumb_height', '200');//保存在原图路径的子目录下
            $thumb->set('thumb_save_type', 2);//保存在原图路径的子目录下
            $thumb->set('thumb_kind', 3);//设置生成缩略图方式为裁剪
            $filePath = $file_new;//设置原图路径
            $ret = $thumb->createthumb($filePath);//生成缩略图

            $redata['path'] = str_replace(PATH_WEB, '../', $file_new);
            $redata['append'] = 'false';
            $redata['type'] = 'head';
            $this->ajaxReturn($redata);
        }
    }

    /**
     * 上传图标
     */
    public function doupico()
    {
        global $_M;
        $info['formname'] = $_M['form']['formname'];
        $info['savepath'] = '/file';
        $info['format'] = 'jpeg|jpg|png|ico';
        $info['maxsize'] = '5';
        $info['is_rename'] = 1;

        $back = $this->upimg($info);
        if ($back['error']) {
            $this->ajaxReturn($back);
        }
        $imgpath = explode('../', $back['path']);
        $img_info = getimagesize(PATH_WEB . $imgpath[1]);
        $img_name = pathinfo(PATH_WEB . $imgpath[1]);
        $back['name'] = $img_name['basename'];
        $back['path'] = $imgpath[1];
        $back['x'] = $img_info[0];
        $back['y'] = $img_info[1];
        $back['path'] = str_replace("//", "/", $back['path']);
        $back['original'] = str_replace("//", "/", $back['original']);
        $this->ajaxReturn($back);

        /*else{
            $back['error'] = 1;
            $back['msg'] = $_M['word']['uploadfilenop'];
            $this->ajaxReturn($back);
        }*/
    }

    /**
     * 检测图片尺寸
     * @param array $data
     * @return bool
     */
    private function checkimg($data = array())
    {
        global $_M;
        $path = $data['path'];
        $size = $data['size'];

        $img_paht = str_replace('../', PATH_WEB, $path);
        $imgattr = @getimagesize($img_paht);
        $pathinfo = pathinfo($img_paht);
        if (in_array($pathinfo['extension'],array('svg'))) {
            return true;
        }

        if ($imgattr) {
            if ($imgattr[0] > $this->max_img_px_size  || $imgattr[1] > $this->max_img_px_size ) {
                return false;
            } else {
                return true;
            }

        } else {
            return false;
        }
    }

    /**
     * 自动压缩上传图片
     * @param string
     */
    private function imgCompress($data = array())
    {
        global $_M;
        return;
        if ($_M['config']['met_img_compress'] == 1) {
            $path = $data['path'];
            $size = $data['size'];

            $img_paht = str_replace('../', PATH_WEB, $path);
            if (file_exists($img_paht)) {
                $check = @exif_imagetype($img_paht);
                $allowedExts = array(IMAGETYPE_JPEG, IMAGETYPE_PNG);
                if (in_array($check, $allowedExts)) {
                    $imgattr = @getimagesize($img_paht);
                    if ($imgattr) {
                        $max_img_size = 5000;       //3000px  处理超高分辨率图片内存出错
                        if ($imgattr[0] > $max_img_size || $imgattr[1] > $max_img_size) {
                            return false;
                        }

                        $file_size = 500 * 1024;        //500kb
                        $img_size = 1000;               //1000px
                        if ($size > $file_size || $imgattr[0] > $img_size || $imgattr[1] > $img_size) {
                            $img_compress = load::sys_class('imgCompress', 'new');
                            $save_name = $img_paht;
                            ##$save_name = PATH_WEB.'upload/201907/new.jpg';
                            $img_compress->compressImg($img_paht, $save_name);
                            return true;
                        }
                    }
                }
            }
        }
        return;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>