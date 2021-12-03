<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');



class image
{

    /**
     * 图片信息
     * @var [type]
     */
    public $image;

    /**
     * 域名
     * @var [type]
     */
    public $host;

    /**
     * 请求图片宽
     * @var int
     */
    public $x;

    /**
     * 请求图片高
     * @var int
     */
    public $y;

    /**
     * 生成图片宽
     * @var [type]
     */
    public $thumb_x;

    /**
     * 生成图片高
     * @var [type]
     */
    public $thumb_y;

    /**
     * 缩略图存放目录
     * @var [type]
     */
    public $thumb_dir;

    /**
     * 缩略图路径
     * @var [type]
     */

    /**
     * 缩略图url
     * @var [type]
     */
    public $thumb_url;

    public $thumb_path;

    public $default;

    public $thumb_wate;

    /**
     * @param $image_path  图片地址
     * @param string $x 长
     * @param string $y 宽
     * @param int $return 是否调用默认图片
     * @param int $thumb_wate 缩略图水印
     * @return mixed|string
     */
    public function met_thumb($image_path, $x = '', $y = '', $return = 0, $thumb_wate = 1)
    {
        global $_M;
        $this->default = $_M['config']['met_agents_img'];
        if ($return) {
            $this->default = '';
        }
        if (!$image_path) {
            $image_path = $this->default;
        }

        //图片源路径
        $true_path = $image_path;
        $pram = '';
        if (strpos($image_path, '?')) {
            $true_path = substr($image_path, 0, strpos($image_path, '?'));
            $pram = substr($image_path,  strpos($image_path, '?'));
        }
        $this->ext = pathinfo($true_path,PATHINFO_EXTENSION );
        $this->image = end(explode('/', $true_path));

        //检测文件类型
        if (!in_array(strtolower($this->ext),array('jpg','jpeg','png','gif'))) {
            return $image_path;
        }

        $this->thumb_wate = $thumb_wate;
        $this->image_path = str_replace(array($_M['url']['site'], '../', './',$_M['url']['web_site']), '', $true_path);
        // 如果地址为空 缩略默认图片
        if (!$this->image_path) {
            $this->image_path = $this->default;
        }
        // 如果去掉网址还有http就是外部链接图片 不需要缩略处理
        if (substr($this->image_path, 0, 4) == 'http') {
            return $this->image_path;
        }
        $this->x = is_numeric($x) ? intval($x) : false;
        $this->y = is_numeric($y) ? intval($y) : false;

        $this->thumb_dir = PATH_WEB . 'upload/thumb_src/';
        $this->thumb_path = $this->get_thumb_path() . $this->image;

        $image = $this->get_thumb();
        return $image . $pram;
    }

    // 先直接返回缩略图地址
    public function get_thumb_path()
    {
        global $_M;
        $x = $this->x;
        $y = $this->y;

        if ($x && $y) {
            $dirname = "{$x}_{$y}/";
        }

        if ($x && !$y) {
            $dirname = "x_{$x}/";
        }

        if (!$x && $y) {
            $dirname = "y_{$y}/";
        }

        if (!$x && !$y) {
            $dirname = "400_400/";
        }

        $this->thumb_url = $_M['url']['site'] . 'upload/thumb_src/' . $dirname . $this->image;
        $dirname = $this->thumb_dir . $dirname;

        if (stristr(PHP_OS, "WIN")) {
            $dirname = @iconv("utf-8", "GBK", $dirname);
        }
        return $dirname;
    }

    // 生成新的缩略图地址
    public function get_new_path()
    {
        global $_M;
        $x = $this->x;
        $y = $this->y;

        if ($path = explode('?', $this->image_path)) {
            $image_path = $path[0];
        } else {
            $image_path = $this->image_path;
        }

        // 原图不存在
        if (!is_file(PATH_WEB . $image_path)) {
            $image_path = $this->default;
        }
        $s = file_get_contents(PATH_WEB . $image_path);
        $image = imagecreatefromstring($s);

        $width = imagesx($image);//获取原图片的宽
        $height = imagesy($image);//获取原图片的高

        if ($x && $y) {
            $dirname = "{$x}_{$y}/";
            $this->thumb_x = $x;
            $this->thumb_y = $y;
        }

        if ($x && !$y) {
            $dirname = "x_{$x}/";
            $this->thumb_x = $x;
            $this->thumb_y = floor($x / $width * $height);
        }

        if (!$x && $y) {
            $dirname = "y_{$y}/";
            $this->thumb_y = $y;
            $this->thumb_x = floor($y / $height * $width);
        }

        if (!$x && !$y) {
            $dirname = "400_400/";
            $this->thumb_y = 400;
            $this->thumb_x = 400;
        }

        $this->thumb_url = $_M['url']['site'] . 'upload/thumb_src/' . $dirname . $this->image;
        $dirname = $this->thumb_dir . $dirname;

        if (stristr(PHP_OS, "WIN")) {
            $dirname = @iconv("utf-8", "GBK", $dirname);
        }

        return $dirname;
    }

    public function get_thumb()
    {
        if ($path = explode('?', $this->thumb_path)) {
            $thumb_path = $path[0];
        } else {
            $thumb_path = $this->thumb_path;
        }
        return is_file($thumb_path) ? $this->thumb_url : $this->create_thumb();
    }

    public function create_thumb()
    {
        global $_M;
        $suf = '';
        if ($path = explode('?', $this->image_path)) {
            $image_path = $path[0];
            $suf .= '?' . $path[1];
        } else {
            $image_path = $this->image_path;
        }
        $savename = end(explode('/', $image_path));

        if ($_M['config']['met_big_wate'] && strpos($image_path, 'watermark') !== false) {
            $image_path = str_replace('watermark/', '', $image_path);
        }

        if (!is_file(PATH_WEB . $image_path)) {
            $image_path = $this->default;
        }

        $thumb = load::sys_class('thumb', 'new');
        $thumb->set('thumb_save_type', 3);
        $thumb->set('thumb_kind', $_M['config']['met_thumb_kind']);
        $thumb->set('thumb_savepath', $this->get_new_path());
        $thumb->set('thumb_savename', $savename);
        $thumb->set('thumb_width', $this->thumb_x);
        $thumb->set('thumb_height', $this->thumb_y);
        $image = $thumb->createthumb($image_path);
        //缩略图水印
        if ($_M['config']['met_thumb_wate'] && strpos($image_path, 'watermark') === false && $this->thumb_wate) {
            $mark = load::sys_class('watermark', 'new');
            $mark->set('water_savepath', $this->get_thumb_path());
            $mark->set_system_thumb();
            $mark->create($image['path']);
        }

        if ($image['error']) {
            $met_agents_img = str_replace('../', '', $this->default);
            $image_path = $_M['url']['site'] . $met_agents_img. $suf;
            return $image_path;
        }
        return $_M['url']['site'] . $image['path'] . $suf;
    }

}


# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.

