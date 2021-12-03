<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

load::sys_func('file.func.php');

/** 
 * 水印类
 * @param string $water_savepath		添加水印后，图片保存路径
 * @param string $water_mark_type	    添加的水印类型，text:文字，img:图片
 * @param string $water_save_type		添加水印后，图片保存路径类型，1:保存在原图路径的字目录下，2:覆盖原图片，3:自定义路径
 * @param string $is_watermark	        是否添加对图片添加水印
 * @param string $water_image_name		水印的图像文件的名称(必须包含的路径名)
 * @param string $water_pos				水印图像的位置
 * @param string $water_text			水印文本(支持换行符)
 * @param string $water_text_size		水印文本大小
 * @param string $water_text_angle		文字水印倾角
 * @param string $water_text_font		水印文本字体(字体文件要放在后台管理目录/include/fonts/),路径可以为绝对，或者相对网站根目录路径
 * @param string $water_text_color		水印文本颜色
 * @param string $jpeg_quality			jpeg图像质量
 * @param string $met_image_transition	水印图像和原始图像的融合度(1 = 100)
 * 以上路径变量都必须是绝对路径，如果不使用类的set方法
 */
class watermark
{
    public $water_savepath = "watermark/";
    public $water_mark_type = "text";
    public $water_save_type = 1;
    public $is_watermark = 1;
    public $water_image_name = "";
    public $water_pos = 3;
    public $water_text = "";
    public $water_text_size = 40;
    public $water_text_angle = 20;
    public $water_text_font = "";
    public $water_text_color = "#cccccc";
    public $jpeg_quality = 90;
    public $met_image_transition = 80;

    /**
     * 初始化，默认设置添加后台大图水印
     */
    public function __construct()
    {
        global $_M;
        $this->set('water_image_name', $_M['config']['met_wate_bigimg']);
        $this->set('water_pos', $_M['config']['met_watermark']);
        $this->set('water_text', $_M['config']['met_text_wate']);
        $this->set('water_text_size', $_M['config']['met_text_bigsize']);
        $this->set('water_text_angle', $_M['config']['met_text_angle']);
        $this->set('water_text_font', $_M['config']['met_text_fonts']);
        $this->set('water_text_color', $_M['config']['met_text_color']);
    }

    /**
     * 设置文字水印
     */
    public function set_textmark()
    {
        global $_M;
        $this->set('water_mark_type', 'text');
    }

    /**
     * 设置图片水印
     */
    public function set_imgmark()
    {
        global $_M;
        $this->set('water_mark_type', 'img');
    }

    /**
     * 按照网站设置设置水印类型
     */
    public function set_system_watermark()
    {
        global $_M;
        if ($_M['config']['met_wate_class'] == 1) {
            $this->set_textmark();
        }
        if ($_M['config']['met_wate_class'] == 2) {
            $this->set_imgmark();
        }
    }

    /**
     * 按照网站设置大图水印方式添加水印
     */
    public function set_bigimg()
    {
        global $_M;
        $this->set('water_image_name', $_M['config']['met_wate_bigimg']);
        $this->set('water_pos', $_M['config']['met_watermark']);
        $this->set('water_text', $_M['config']['met_text_wate']);
        $this->set('water_text_size', $_M['config']['met_text_bigsize']);
        $this->set('water_text_angle', $_M['config']['met_text_angle']);
        $this->set('water_text_font', $_M['config']['met_text_fonts']);
        $this->set('water_text_color', $_M['config']['met_text_color']);
        $this->set('water_save_type', 1);
        $this->set('is_watermark', 1);
        $this->set_system_watermark();
    }

    /**
     * 按照网站设置缩略图水印方式添加水印
     */
    public function set_thumb()
    {
        global $_M;
        $this->set('water_image_name', $_M['config']['met_wate_img']);
        $this->set('water_pos', $_M['config']['met_watermark']);
        $this->set('water_text', $_M['config']['met_text_wate']);
        $this->set('water_text_size', $_M['config']['met_text_size']);
        $this->set('water_text_angle', $_M['config']['met_text_angle']);
        $this->set('water_text_font', $_M['config']['met_text_fonts']);
        $this->set('water_text_color', $_M['config']['met_text_color']);
        $this->set('water_save_type', 2);
        $this->set('is_watermark', 1);
        $this->set_system_watermark();
    }

    /**
     * 按照网站设置大图水印方式添加水印，如果网站设置没有开启水印，则不会对原图添加水印
     */
    public function set_system_thumb()
    {
        global $_M;
        $this->set_thumb();
        $this->set('is_watermark', $_M['config']['met_thumb_wate']);
    }

    /**
     * 按照网站设置缩略图水印方式添加水印，如果网站设置没有开启水印，则不会对原图添加水印
     */
    public function set_system_bigimg()
    {
        global $_M;
        $this->set_system_watermark();
        $this->set_bigimg();
        $this->set('is_watermark', $_M['config']['met_big_wate']);
    }

    /**
     * 设置字段
     * @param string $name 需要设置的字段名，为public字段都可以设置
     * @param string $value 需要设置的字段名的值
     * water_image_name设置可以是绝对路径，也可以是相对网站根目录的相对路径
     * water_text_font置可以是绝对路径，也是相对网站后台根目录的相对路径
     */
    public function set($name, $value)
    {
        global $_M;
        if ($value === NULL) {
            return false;
        }
        switch ($name) {
            case 'water_savepath':
                if ($this->water_save_type == 3) {
                    $this->water_savepath = path_absolute($value);
                } else {
                    $this->water_savepath = $value;
                }
                $this->water_savepath = path_standard($this->water_savepath);
                break;
            case 'water_save_type':
                $this->water_save_type = $value;
                break;
            case 'water_mark_type':
                $this->water_mark_type = $value;
                break;
            case 'is_watermark':
                $this->is_watermark = $value;
                break;
            case 'water_image_name':
                $this->water_image_name = path_absolute($value);
                break;
            case 'water_pos':
                $this->water_pos = $value;
                break;
            case 'water_text':
                $this->water_text = $value;
                break;
            case 'water_text_size':
                $this->water_text_size = $value;
                break;
            case 'water_text_color':
                $this->water_text_color = $value;
                break;
            case 'water_text_angle':
                $this->water_text_angle = $value;
                break;
            case 'water_text_font':
                $water_text_font = PATH_WEB . str_replace('../', '', $value);
                if (file_exists($water_text_font)) {
                    $this->water_text_font = $water_text_font;
                }else{
                    $this->water_text_font = PATH_PUBLIC . 'fonts/Cantarell-Regular.ttf';
                }
                break;
            case 'met_image_transition':
                $this->met_image_transition = $value;
                break;
            case 'jpeg_quality':
                $this->jpeg_quality = $value;
                break;
        }
    }

    /**
     * 打水印的方法
     * @param  string $water_scr_image 原图路径
     * @return array                    返回成功信息
     * 返回值为数组各字段含义，error:是否出错，1出错，0正常，errorcode:报错代码，path:水印图片路径
     */
    public function create($water_scr_image)
    {
        global $_M;
        $water_scr_image = path_absolute($water_scr_image);
        if (!file_exists($water_scr_image) || is_dir($water_scr_image)) {
            return $this->error($_M['word']['batchtips30']);
        }

        if ($this->is_watermark != 1) {
            return $this->sucess(path_relative($water_scr_image));
        }

        if ($this->water_save_type == 1) {
            $save_path_water = dirname($water_scr_image) . '/' . $this->water_savepath;
        }
        if ($this->water_save_type == 2) {
            $save_path_water = dirname($water_scr_image) . '/';
        }
        if ($this->water_save_type == 3) {
            $save_path_water = $this->water_savepath;
        }
        if (stristr(PHP_OS, "WIN")) {
            $water_scr_image = @iconv("utf-8", "GBK", $water_scr_image);
            $this->water_image_name = @iconv("utf-8", "GBK", $this->water_image_name);
        }
        if (!file_exists($water_scr_image) || is_dir($water_scr_image)) {
            return $this->error($_M['word']['batchtips30']);
        }

        $src_image_type = $this->get_type($water_scr_image);

        $src_image = $this->createImage($src_image_type, $water_scr_image);
        if (!$src_image) return;
        $src_image_w = ImageSX($src_image);
        $src_image_h = ImageSY($src_image);
        if ($this->water_mark_type == 'img') {
            #$this->water_image_name = strtolower(trim($this->water_image_name));
            $this->water_image_name = trim($this->water_image_name);
            $met_image_type = $this->get_type($this->water_image_name);
            $met_image = $this->createImage($met_image_type, $this->water_image_name);
            $met_image_w = ImageSX($met_image);
            $met_image_h = ImageSY($met_image);
            $temp_met_image = $this->getPos($src_image_w, $src_image_h, $this->water_pos, $met_image);
            $met_image_x = $temp_met_image["dest_x"];
            $met_image_y = $temp_met_image["dest_y"];
            if ($this->get_type($this->water_image_name) == 'png') {
                imagecopy($src_image, $met_image, $met_image_x, $met_image_y, 0, 0, $met_image_w, $met_image_h);
            } else {
                imagecopymerge($src_image, $met_image, $met_image_x, $met_image_y, 0, 0, $met_image_w, $met_image_h, $this->met_image_transition);
            }
        }
        if ($this->water_mark_type == 'text') {
            $temp_water_text = $this->getPos($src_image_w, $src_image_h, $this->water_pos);
            $water_text_x = $temp_water_text["dest_x"];
            $water_text_y = $temp_water_text["dest_y"];
            if (preg_match("/([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])/i", $this->water_text_color, $color)) {
                $red = hexdec($color[1]);
                $green = hexdec($color[2]);
                $blue = hexdec($color[3]);
                $water_text_color = imagecolorallocate($src_image, $red, $green, $blue);
            } else {
                $water_text_color = imagecolorallocate($src_image, 255, 255, 255);
            }
            imagettftext($src_image, $this->water_text_size, $this->water_text_angle, $water_text_x, $water_text_y, $water_text_color, $this->water_text_font, $this->water_text);
        }
        makedir($save_path_water);
        $save_file = $save_path_water . basename($water_scr_image);
        if ($save_path_water) {
            $src_image_type = $this->get_type($save_file);
            if ($src_image_type == "jpg") $src_image_type = "jpeg";
            switch ($src_image_type) {
                case 'gif':
                    $src_img = ImagePNG($src_image, $save_file);
                    break;
                case 'jpeg':
                    $src_img = ImageJPEG($src_image, $save_file, $this->jpeg_quality);
                    break;
                case 'png':
                    $src_img = ImagePNG($src_image, $save_file);
                    break;
                default:
                    $src_img = ImageJPEG($src_image, $save_file, $this->jpeg_quality);
                    break;
            }
        } else {
            if ($src_image_type == "jpg") $src_image_type = "jpeg";
            header("Content-type: image/{$src_image_type}");
            switch ($src_image_type) {
                case 'gif':
                    $src_img = ImagePNG($src_image);
                    break;
                case 'jpg':
                    $src_img = ImageJPEG($src_image, "", $this->jpeg_quality);
                    break;
                case 'png':
                    $src_img = ImagePNG($src_image);
                    break;
                default:
                    $src_img = ImageJPEG($src_image, "", $this->jpeg_quality);
                    break;
            }
        }
        imagedestroy($src_image);
        if (stristr(PHP_OS, "WIN")) {
            $water_scr_image = @iconv("GBK", "utf-8", $water_scr_image);
            $this->water_image_name = @iconv("GBK", "utf-8", $this->water_image_name);
            $save_file = @iconv("GBK", "utf-8", $save_file);
        }
        return $this->sucess(path_relative($save_file));
    }

    /**
     * 创建图片资源
     * @param string $type :        图片类型
     * @param string $img_name :    创建图片的路径
     * @return 返回创建的图片资源
     */
    protected function createImage($type, $img_name)
    {
        if (!$type) {
            $type = $this->get_type($img_name);
        }
        switch ($type) {
            case 'gif':
                if (function_exists('imagecreatefromgif')) $tmp_img = @imagecreatefromgif($img_name);
                break;
            case 'jpg':
                $tmp_img = imagecreatefromjpeg($img_name);
                break;
            case 'png':
                $tmp_img = imagecreatefrompng($img_name);
                break;
            case 'jpeg':
                $tmp_img = imagecreatefromjpeg($img_name);
                break;
            default:
                $tmp_img = imagecreatefromstring($img_name);
                break;
        }
        imagesavealpha($tmp_img, true);

        return $tmp_img;
    }

    /**
     * 根据设置返回水印位置
     * @param string $sourcefile_width :        原图宽度
     * @param string $sourcefile_height :    原图高度
     * @param string $water_pos 水印位置
     * 0 = middle            正中
     * 1 = top left            左上
     * 2 = top right        右上
     * 3 = bottom right        右下
     * 4 = bottom left        左下
     * 5 = top middle        顶部中间
     * 6 = middle right        右中
     * 7 = bottom middle    底部中间
     * 8 = middle left        左中
     * @param string $met_image :            createImage创建的图片资源
     * @return array                        返回水印位置
     */
    protected function getPos($sourcefile_width, $sourcefile_height, $pos, $met_image = "")
    {
        if ($met_image) {
            $insertfile_width = ImageSx($met_image);
            $insertfile_height = ImageSy($met_image);
        } else {
            $lineCount = explode("\r\n", $this->water_text);
            $fontSize = imagettfbbox($this->water_text_size, $this->water_text_angle, $this->water_text_font, $this->water_text);
            $insertfile_width = $fontSize[2] - $fontSize[0];
            $insertfile_height = count($lineCount) * ($fontSize[1] - $fontSize[5]);
            $fontSizeone = imagettfbbox($this->water_text_size, $this->water_text_angle, $this->water_text_font, 'e');
            $fontSizeone = ($fontSizeone[2] - $fontSizeone[0]) / 2;
        }
        switch ($pos) {
            case 0:
                $dest_x = ($sourcefile_width / 2) - ($insertfile_width / 2);
                $dest_y = ($sourcefile_height / 2) + ($insertfile_height / 2);
                break;
            case 1:
                $dest_x = 0;
                $dest_y = $insertfile_height;
                break;
            case 2:
                $dest_x = $sourcefile_width - $insertfile_width - $fontSizeone;
                $dest_y = $insertfile_height;
                break;
            case 3:
                $dest_x = $sourcefile_width - $insertfile_width - $fontSizeone;
                $dest_y = $sourcefile_height - ($insertfile_height / 4);
                break;
            case 4:
                $dest_x = 0;
                $dest_y = $sourcefile_height - ($insertfile_height / 4);
                break;
            case 5:
                $dest_x = (($sourcefile_width - $insertfile_width) / 2);
                $dest_y = $insertfile_height;
                break;
            case 6:
                $dest_x = $sourcefile_width - $insertfile_width - $fontSizeone;
                $dest_y = ($sourcefile_height / 2) + ($insertfile_height / 2);
                break;
            case 7:
                $dest_x = (($sourcefile_width - $insertfile_width) / 2);
                $dest_y = $sourcefile_height - ($insertfile_height / 4);
                break;
            case 8:
                $dest_x = 0;
                $dest_y = ($sourcefile_height / 2) + ($insertfile_height / 2);
                break;
            default:
                $dest_x = $sourcefile_width - $insertfile_width;
                $dest_y = $sourcefile_height - $insertfile_height;
                break;
        }
        if ($met_image) {
            $dest_y = $dest_y - $insertfile_height;
        }
        return array("dest_x" => $dest_x, "dest_y" => $dest_y);
    }

    /**
     * 获得的图片格式，包括 jpg, png, gif
     * @param string $img_name : 包含了路径的文件名
     * @return array $type        返回文件类型
     */
    protected function get_type($img_name)
    {
        $name_array = explode(".", $img_name);
        if (preg_match("/\.(jpg|jpeg|gif|png)$/i", $img_name, $matches)) {
            $type = strtolower($matches[1]);
        } else {
            $type = "string";
        }
        return $type;
    }

    /**
     * 水印错误调用方法
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
     * 水印成功调用方法
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