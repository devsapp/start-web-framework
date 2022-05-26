<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

load::sys_func('file.func.php');

/**
 * 缩略图类
 * @param string $thumb_width 	缩略图宽
 * @param string $thumb_height 	缩略图高
 * @param string $thumb_savepath	缩略图保存地址
 * @param string $thumb_save_type	保存方式，1:保存在原图路径的子目录下，2:覆盖原图片，3:自定义路径
 * @param string $thumb_bgcolor		缩略图背景颜色，已#开头
 * @param string $thumb_kind		生成缩略图方式，1拉升，2留白，3裁剪
 * 以上路径变量都必须是绝对路径，如果不使用类的set方法
 */
class thumb
{
    public $thumb_src_image = "";
    public $thumb_width = 400;
    public $thumb_height = 400;
    public $thumb_savepath = "";
    public $thumb_savename = "";
    public $thumb_save_type = 1;
    public $thumb_bgcolor = '#FFFFFF';
    public $thumb_kind = 1;

    function __construct()
    {
        global $_M;
    }

    /**
     * 设置字段
     * @param string $name 需要设置的字段名，为public字段都可以设置
     * @param string $value 需要设置的字段名的值
     * thumb_savepath当thumb_save_type为3时置可以是绝对路径，也是相对网站后台根目录的相对路径
     * thumb_savepath当thumb_save_type为2，设置无效
     * thumb_savepath当thumb_save_type为1，thumb_savepath为相对原图的路径
     */
    public function set($name, $value)
    {
        global $_M;
        if ($value === NULL) {
            return false;
        }
        switch ($name) {
            case 'thumb_width';
                $this->thumb_width = $value;
                break;
            case 'thumb_height';
                $this->thumb_height = $value;
                break;
            case 'thumb_savepath';
                if ($this->thumb_save_type == 3) {
                    $this->thumb_savepath = path_absolute($value);
                } else {
                    $this->thumb_savepath = $value;
                }
                $this->thumb_savepath = path_standard($this->thumb_savepath);
                break;
            case 'thumb_save_type';
                $this->thumb_save_type = $value;
                break;
            case 'thumb_bgcolor';
                $this->thumb_bgcolor = $value;
                break;
            case 'thumb_kind';
                $this->thumb_kind = $value;
                break;
            case '$thumb_savename';
                $this->thumb_savename = $value;
                break;
        }
    }

    /**
     * 按网站列表页缩略图方式缩略图片（2 = 新闻模块, 3 = 产品模块, 5 = 图片模块）
     * @param string $module 2/news:新闻模块，3/product:产品模块，5/img:图片模块）
     */
    public function list_module($module = '')
    {
        if ($module == 'news') $module = 2;
        if ($module == 'product') $module = 3;
        if ($module == 'img') $module = 5;
        switch ($module) {
            case 2:
                $this->list_news();
                break;
            case 3:
                $this->list_product();
                break;
            case 5:
                $this->list_img();
                break;
            default:
                $this->list_news();
        }
    }

    /**
     * 按网站内容页缩略图方式缩略图片（3 = 产品模块, 5 = 图片模块）
     * @param string $module 3/product:产品模块，5/img:图片模块）
     */
    public function content_module($module = '')
    {
        if ($module == 'product') $module = 3;
        if ($module == 'img') $module = 5;
        switch ($module) {
            case 3;
                $this->contents_product();
                break;
            case 5;
                $this->contents_img();
                break;
        }
    }

    /**
     * 按网站新闻列表页缩略图方式缩略图片
     */
    public function list_news()
    {
        global $_M;
        $this->set('thumb_width', $_M['config']['met_newsimg_x']);
        $this->set('thumb_height', $_M['config']['met_newsimg_y']);
        $this->set('thumb_save_type', 1);
        $this->set('thumb_savepath', 'thumb/');
        $this->set('thumb_kind', $_M['config']['met_thumb_kind']);
        $this->set('thumb_bgcolor', '#FFFFFF');
    }

    /**
     * 按网站产品列表页缩略图方式缩略图片
     */
    public function list_product()
    {
        global $_M;
        $this->set('thumb_width', $_M['config']['met_productimg_x']);
        $this->set('thumb_height', $_M['config']['met_productimg_y']);
        $this->set('thumb_save_type', 1);
        $this->set('thumb_savepath', 'thumb/');
        $this->set('thumb_kind', $_M['config']['met_thumb_kind']);
        $this->set('thumb_bgcolor', '#FFFFFF');
    }

    /**
     * 按网站图片列表页缩略图方式缩略图片
     */
    public function list_img()
    {
        global $_M;
        $this->set('thumb_width', $_M['config']['met_imgs_x']);
        $this->set('thumb_height', $_M['config']['met_imgs_y']);
        $this->set('thumb_save_type', 1);
        $this->set('thumb_savepath', 'thumb/');
        $this->set('thumb_kind', $_M['config']['met_thumb_kind']);
        $this->set('thumb_bgcolor', '#FFFFFF');
    }

    /**
     * 按网站图片内容页缩略图方式缩略图片
     */
    public function contents_img()
    {
        global $_M;
        $this->set('thumb_width', $_M['config']['met_imgdetail_x']);
        $this->set('thumb_height', $_M['config']['met_imgdetail_y']);
        $this->set('thumb_save_type', 1);
        $this->set('thumb_savepath', 'thumb_dis/');
        $this->set('thumb_kind', $_M['config']['met_thumb_kind']);
        $this->set('thumb_bgcolor', '#FFFFFF');
    }

    /**
     * 按网站产品内容页缩略图方式缩略图片
     */
    public function contents_product()
    {
        global $_M;
        $this->set('thumb_width', $_M['config']['met_productdetail_x']);
        $this->set('thumb_height', $_M['config']['met_productdetail_y']);
        $this->set('thumb_kind', $_M['config']['met_thumb_kind']);
        $this->set('thumb_save_type', 1);
        $this->set('thumb_savepath', 'thumb_dis/');
        $this->set('thumb_bgcolor', '#FFFFFF');
    }

    /**
     * 生成缩略图的方法
     * @param  strint    原图地址
     * @return array    返回成功或错误信息
     * 返回值为数组各字段含义，error:是否出错，1出错，0正常，errorcode:报错代码，path:缩略图片路径
     */
    public function createthumb($thumb_src_image)
    {
        global $_M;
        $this->thumb_width = $this->thumb_width ? $this->thumb_width : 100;
        $this->thumb_height = $this->thumb_height ? $this->thumb_height : 100;
        $gd = $this->gd_version();

        $thumb_src_image = path_absolute($thumb_src_image);
        if ($this->thumb_save_type == 1) {
            $thumb_savepath = dirname($thumb_src_image) . '/' . $this->thumb_savepath;
            ##$thumb_savepath = PATH_WEB."upload/thumb_src/{$this->thumb_width}_{$this->thumb_height}/";
        }
        if ($this->thumb_save_type == 2) {
            $thumb_savepath = dirname($thumb_src_image) . '/';
        }
        if ($this->thumb_save_type == 3) {
            $thumb_savepath = $this->thumb_savepath;
        }
        if (stristr(PHP_OS, "WIN")) {
            $thumb_src_image = @iconv("utf-8", "GBK", $thumb_src_image);
        }
        if (!file_exists($thumb_src_image) || is_dir($thumb_src_image)) {
            return $this->error($_M['word']['batchtips30']);
        }

        //检查原始是否文件存在并且得到原图信息
        $org_info = @getimagesize($thumb_src_image);//返回图片大小
        if ($org_info['mime'] == 'image/bmp') {//bmp图无法压缩
            return $this->error($_M['word']['upfileFail5']);
        }
        if (!$this->check_img_function($org_info[2])) {
            return $this->error($_M['word']['upfileFail6']);
        }

        $img_org = $this->img_resource($thumb_src_image, $org_info[2]);

        //原始图像和缩略图尺寸对比
        $scale_org = $org_info[0] / $org_info[1];
        $scale_tumnb = $this->thumb_width / $this->thumb_height;

        //处理缩略图宽度和高度为0的情况，背景和缩略图一样大
        if ($this->thumb_width == 0) {
            $this->thumb_width = $this->thumb_height * $scale_org;
        }
        if ($this->thumb_height == 0) {
            $this->thumb_height = $this->thumb_width / $scale_org;
        }

        //创建缩略图
        if ($gd == 2) {//创建一张缩略图（黑色）
            $img_thumb = imagecreatetruecolor($this->thumb_width, $this->thumb_height);
        } else {
            $img_thumb = imagecreate($this->thumb_width, $this->thumb_height);
        }
        imagealphablending($img_thumb, false);
        imagesavealpha($img_thumb, true);//透明图片不改变背景
        //缩略图背景颜色
        if (empty($this->thumb_bgcolor)) $this->thumb_bgcolor = "#FFFFFF";
        $this->thumb_bgcolor = trim($this->thumb_bgcolor, "#");
        sscanf($this->thumb_bgcolor, "%2x%2x%2x", $red, $green, $blue);
        $clr = imagecolorallocate($img_thumb, $red, $green, $blue);
        imagefilledrectangle($img_thumb, 0, 0, $this->thumb_width, $this->thumb_height, $clr);//创建背景色，默认为白色
        switch ($this->thumb_kind) {
            case 1:
                $dst_x = 0;
                $dst_y = 0;
                $lessen_width = $this->thumb_width;
                $lessen_height = $this->thumb_height;
                $scr_x = 0;
                $scr_y = 0;
                $scr_w = $org_info[0];
                $scr_h = $org_info[1];
                break;
            case 2:
                if ($org_info[0] / $this->thumb_width > $org_info[1] / $this->thumb_height) {//上下留白
                    $lessen_width = $this->thumb_width;
                    $lessen_height = $this->thumb_width / $scale_org;
                } else {//左右留白
                    $lessen_width = $this->thumb_height * $scale_org;
                    $lessen_height = $this->thumb_height;
                }
                $dst_x = ($this->thumb_width - $lessen_width) / 2;
                $dst_y = ($this->thumb_height - $lessen_height) / 2;
                $scr_x = 0;
                $scr_y = 0;
                $scr_w = $org_info[0];
                $scr_h = $org_info[1];
                break;
            case 3:
                $dst_x = 0;
                $dst_y = 0;
                $lessen_width = $this->thumb_width;
                $lessen_height = $this->thumb_height;
                if ($org_info[0] / $this->thumb_width > $org_info[1] / $this->thumb_height) {//上下留白,截左右
                    $scr_w = $org_info[1] * $scale_tumnb;
                    $scr_h = $org_info[1];
                } else {//左右留白,截上下
                    $scr_w = $org_info[0];
                    $scr_h = $org_info[0] / $scale_tumnb;
                }
                $scr_x = ($org_info[0] - $scr_w) / 2;
                $scr_y = ($org_info[1] - $scr_h) / 2;
                break;
        }
        //放大原始图片
        if ($gd == 2) {
            imagecopyresampled($img_thumb, $img_org, $dst_x, $dst_y, $scr_x, $scr_y, $lessen_width, $lessen_height, $scr_w, $scr_h);
        } else {
            imagecopyresized($img_thumb, $img_org, $dst_x, $dst_y, $scr_x, $scr_y, $lessen_width, $lessen_height, $scr_w, $scr_h);
        }
        if (!makedir($thumb_savepath)) {
            return $this->error($_M['word']['upfileFail4']);
        }

        $thumb_savename = $this->thumb_savename ? $this->thumb_savename : end(explode('/', $thumb_src_image));
        $thumbname = $thumb_savepath . $thumb_savename;
        //Create
        switch ($org_info['mime']) {
            case 'image/gif':
                if (function_exists('imagegif')) {
                    $re = imagegif($img_thumb, $thumbname);
                } else {
                    return $this->error($_M['word']['upfileFail9']);
                }
                break;
            case 'image/pjpeg':
            case 'image/jpeg':
                if (function_exists('imagejpeg')) {
                    $re = imagejpeg($img_thumb, $thumbname, 100);
                } else {
                    return $this->error($_M['word']['upfileFail10']);
                }
                break;
            case 'image/x-png':
            case 'image/png':
                if (function_exists('imagejpeg')) {
                    $re = imagepng($img_thumb, $thumbname);
                } else {
                    return $this->error($_M['word']['upfileFail11']);
                }
                break;
            default:
                return $this->error($_M['word']['upfileFail7']);
        }
        if (!$re) {
            return $this->error($_M['word']['upfileFail8']);
        }
        if (stristr(PHP_OS, "WIN")) {
            $thumbname = @iconv("GBK", "utf-8", $thumbname);
        }
        $thumbname = str_replace(PATH_WEB, '', $thumbname);
        imagedestroy($img_thumb);
        imagedestroy($img_org);
        return $this->sucess($thumbname);
    }

    /**
     * 创建图片资源
     * @param string $img :         创建图片的路径
     * @param string $mime_type : 图片类型
     * @return                   返回创建的图片资源
     */
    protected function img_resource($img, $mime_type)
    {
        switch ($mime_type) {
            case 1:
            case 'image/gif':
                $res = imagecreatefromgif($img);
                break;

            case 2:
            case 'image/pjpeg':
            case 'image/jpeg':
                $res = imagecreatefromjpeg($img);
                break;

            case 3:
            case 'image/x-png':
            case 'image/png':
                $res = imagecreatefrompng($img);
                break;

            default:
                return false;
        }
        return $res;
    }

    /**
     * 得到的Gd服务器版本
     * @return int 返回Gd服务器版本
     */
    protected function gd_version()
    {
        static $version = -1;
        if ($version >= 0) {
            return $version;
        }
        if (!extension_loaded('gd')) {
            $version = 0;
        } else {
            // 使用 gd_info() 函数取得当前安装的 GD 库的信息
            if (function_exists('gd_info')) {
                $ver_info = gd_info();
                preg_match('/\d/', $ver_info['GD Version'], $match);
                $version = $match[0];
            } else {
                if (function_exists('imagecreatetruecolor')) {
                    $version = 2;
                } else if (function_exists('imagecreate')) {
                    $version = 1;
                }
            }
        }
        return $version;
    }

    /**
     * 检测PHP版本以及处理函数是否可用
     * @return buttton 返回可用或不可用信息
     */
    protected function check_img_function($img)
    {
        switch ($img) {
            case 'image/gif':
            case 1:
                return function_exists('imagecreatefromgif');
                break;

            case 'image/pjpeg':
            case 'image/jpeg':
            case 2:
                return function_exists('imagecreatefromjpeg');
                break;

            case 'image/x-png':
            case 'image/png':
            case 3:
                return function_exists('imagecreatefrompng');
                break;
            default:
                return false;
                break;
        }
    }

    /**
     * 缩略图错误调用方法
     * @param string $error 错误信息
     * @return array 返回错误信息
     */
    protected function error($error)
    {
        $back['error'] = 1;
        $back['errorcode'] = $error;
        return $back;
    }

    /**
     * 缩略图成功调用方法
     * @param string $path 路径
     * @return array 返回成功路径(相对于当前路径)
     */
    protected function sucess($path)
    {
        $back['error'] = 0;
        $back['path'] = $path;
        return $back;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>