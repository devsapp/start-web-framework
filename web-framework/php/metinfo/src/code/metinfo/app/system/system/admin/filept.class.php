<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin');
load::sys_func('file');
load::sys_func('array');

class filept extends admin
{
    /**
     * 获取上传文件夹列表
     * @return [type] [description]
     */
    public function dogetfile()
    {
        global $_M;
        $filearray = traversal(PATH_WEB . '/upload/', 'jpg|png|gif|jpeg|bmp', '((\/upload\/[0-9]{6}\/thumb)|(\/upload\/[0-9]{6}\/thumb_dis)|(\/upload\/[0-9]{6}\/watermark)|(\/upload\/thumb_src)|(\/upload\/files)|(\/upload\/images)|(\/upload\/_thumb)|(\/upload\/\.quarantine)|(\/upload\/\.tmb))');//_thumbs
        foreach ($filearray as $val) {
            // $img_info = getimagesize(PATH_WEB.$val);
            $img_name = pathinfo(PATH_WEB . $val);
            $info['name'] = $img_name['basename'];
            $info['filename'] = $img_name['filename'];
            $info['path'] = $val;
            $info['value'] = '..' . $val;
            // $info['x'] = $img_info[0];
            // $info['y'] = $img_info[1];
            // $info['time'] = filemtime(PATH_WEB.$val);
            $array[] = $info;
        }
        $arrays = arr_sort($array, 'filename', SORT_DESC);
        $this->ajaxReturn($arrays);
    }

    /**
     * 获取文件列表
     * @return [type] [description]
     */
    public function doGetFileList()
    {
        global $_M;
        $dir = $_M['form']['dir'] ? str_replace('../', '', $_M['form']['dir']) : '/upload/';
        $dir = PATH_WEB . $dir;
        $filearray = scan_dir($dir, 'jpg|png|gif|jpeg|bmp|svg', '((\/upload\/[0-9]{6}\/thumb)|(\/upload\/[0-9]{6}\/thumb_dis)|(\/upload\/[0-9]{6}\/watermark)|(\/upload\/thumb_src)|(\/upload\/files)|(\/upload\/images)|(\/upload\/_thumb)|(\/upload\/sql)|(\/upload\/\.quarantine)|(\/upload\/\.tmb))');//_thumbs
        $i=0;
        foreach ($filearray as $val) {
            // $img_info = getimagesize(PATH_WEB.$val);
            $img_name = pathinfo(PATH_WEB . $val);
            $file_type = is_dir(PATH_WEB . $val) ? 'dir' : 'file';
            $info['name'] = $img_name['basename'];
            $info['filename'] = $img_name['filename'];
            $info['path'] = $val;
            $info['value'] = '..' . $val;
            $info['type'] = $file_type;
            // $info['x'] = $img_info[0];
            // $info['y'] = $img_info[1];
            $i++;
            if(strstr($_M['form']['sort'],'time_')){
                if($i>100){
                    $info['time']=$info['filename'];
                }else{
                    $info['time'] = filemtime(PATH_WEB.$val);
                }
            }
            $array[] = $info;
        }
        if (is_array($array)) {
            switch ($_M['form']['sort']){
                case 'name_desc':
                    $arrays = arr_sort($array, 'filename', SORT_DESC);
                    break;
                case 'time_asc':
                    $arrays = arr_sort($array, 'time', SORT_ASC);
                    break;
                case 'time_desc':
                    $arrays = arr_sort($array, 'time', SORT_DESC);
                    break;
                default:
                    $arrays = arr_sort($array, 'filename', SORT_ASC);
                    break;
            }
        } else {
            $arrays = array();
            /*$arrays['name'] = '';
            $arrays['path'] = '';
            $arrays['value'] = '';
            $arrays['type'] = '';*/
        }
        $this->ajaxReturn($arrays);
    }

    /**
     * 获取文件信息
     * @return [type] [description]
     */
    public function doGetFileInfo($path, $type, $size_unit)
    {
        global $_M;
        $_M['form']['path'] && $path = $_M['form']['path'];
        $_M['form']['type'] && $type = $_M['form']['type'];
        $_M['form']['size_unit'] && $size_unit = $_M['form']['size_unit'];
        $paths = is_array($path) ? $path : array($path);
        foreach ($paths as $value) {
            if (strstr($value, '../upload/')) {
                $value = str_replace('../upload/', PATH_WEB . 'upload/', $value);
            }
            if (strstr($value, $_M['url']['site'])) {
                $value = str_replace($_M['url']['site'], PATH_WEB, $value);
            }
            switch ($type) {
                case 'size':
                    if ($size_unit == 'kb') {
                        $info['data'][] = intval(filesize($value) / 1024);
                    } else {
                        $info['data'][] = getfilesize($value);
                    }
                    break;
                default:
                    if ($size_unit == 'kb') {
                        $info['data'][] = intval(filesize($value) / 1024);
                    } else {
                        $info['data'][] = getfilesize($value);
                    }
            }
        }
        if (!is_array($path)) {
            $info['data'] = $info['data'][0];
        }
        $info['status'] = 1;
        $this->ajaxReturn($info);
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>