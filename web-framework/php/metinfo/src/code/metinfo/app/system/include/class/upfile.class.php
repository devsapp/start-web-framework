<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_func('file.func.php');
load::sys_class('common');

/**
 * 上传文件类
 * @param string $savepath		路径,为上传文件夹（upload）下的路径
 * @param string $format		允许上传文件后缀,如zip|jpg|txt,用竖线隔开,设置的格式不能超过网站设置中的格式
 * @param string $maxsize		限制上传文件大小,单位是M,设置的大小不能超过网站设置中的大小
 * @param string $is_rename		是否重命名,1：重命名，0：不重命名
 * @param string $ext			后缀
 * 以上路径变量都必须是绝对路径，如果不使用类的set方法
 */
class upfile extends common
{
    public $savepath;
    public $format;
    public $maxsize;
    public $is_rename;

    protected $ext;

    public function __construct()
    {
        parent::__construct();
        global $_M;
        $query = "SELECT * FROM {$_M['table']['language']} WHERE lang='{$_M['lang']}' AND site=1 ";
        $result = DB::get_all($query);
        foreach ($result as $val) {
            $_M['word'][$val['name']] = trim($val['value']);
        }

        $this->maxsize = 1073741824;
        $this->set_upfile();
    }

    /**
     * 设置字段
     */
    public function set($name, $value)
    {
        global $_M;
        if ($value === NULL) {
            return false;
        }
        switch ($name) {
            case 'savepath':
                $this->savepath = path_standard(PATH_WEB . 'upload/' . $value);

                break;
            case 'format':
                $this->format = $value;
                break;
            case 'maxsize':
                if (is_numeric($value)) {
                    $maxsize = min($value * 1048576, $this->maxsize);
                    $this->maxsize = min($_M['config']['met_file_maxsize'] * 1048576, $maxsize);
                } else {
                    $this->maxsize = min($_M['config']['met_file_maxsize'] * 1048576, $this->maxsize);
                }
                break;
            case 'is_rename':
                $this->is_rename = $value;
                break;
        }
    }

    /**
     * 设置上传文件模式
     */
    public function set_upfile()
    {
        global $_M;
        $this->set('savepath', 'file');
        $this->set('format', $_M['config']['met_file_format']);
        $this->set('maxsize', $_M['config']['met_file_maxsize'] * 1048576);
        $this->set('is_rename', $_M['config']['met_img_rename']);
    }

    /**
     * 设置上传图片模式
     */
    public function set_upimg()
    {
        global $_M;
        $this->set('savepath', date('Ym'));
        $this->set('format', $_M['config']['met_file_format']);
        $this->set('maxsize', $_M['config']['met_file_maxsize'] * 1048576);
        $this->set('is_rename', $_M['config']['met_img_rename']);
    }

    /**
     * 设置上传备份文件模式
     */
    public function set_upsql()
    {
        global $_M;
        $this->set('savepath', 'sql');
        $this->set('format', "sql|zip");
        $this->set('maxsize', 5 * 1048576);
        $this->set('is_rename', 0);
        $this->set('is_overwrite', 1);
    }

    /**
     * 上传方法
     * @param array $form 上传空间名，也就是input，file上传控件的name字段值
     */
    public function upload($form = '')
    {
        global $_M;
        foreach ($_FILES as $key => $val) {
            if (isset($form) ? $form == $key : 1) {
                $filear = $_FILES[$key];
            }
        }

        //是否能正常上传
        if (!is_array($filear)) $filear['error'] = 4;
        if ($filear['error'] != 0) {
            $errors = array(
                0 => $_M['word']['upfileOver4'],
                1 => $_M['word']['upfileOver'],
                2 => $_M['word']['upfileOver1'],
                3 => $_M['word']['upfileOver2'],
                4 => $_M['word']['upfileOver3'],
                6 => $_M['word']['upfileOver5'],
                7 => $_M['word']['upfileOver5']
            );
            $error_info[] = $errors[$filear['error']] ? $errors[$filear['error']] : $errors[0];
            return self::_error($errors[$filear['error']]);
        }

        //空间超容 有些虚拟主机不支持此函数
        if (function_exists('disk_free_space')) {
            if (disk_free_space(__DIR__) != FALSE && disk_free_space(__DIR__) != 'NULL') {
                if (disk_free_space(__DIR__) < $filear["size"]) {
                    return self::_error("out of disk space");
                }
            }
        }

        //目录不可写
        if (!is_writable(PATH_WEB . "upload")) {
            return self::_error("directory ['" . PATH_WEB . "upload'] can not write");
        }
        //文件大小是否正确{}
        if ($filear["size"] > $this->maxsize) {
            return self::_error("{$_M['word']['upfileFile']}" . $filear["name"] . " {$_M['word']['upfileMax']} {$_M['word']['upfileTip1']}");
        }
        //文件后缀是否为合法后缀
        $this->getext($filear["name"]); //获取允许的后缀

        if (!getimagesize($filear['tmp_name']) && in_array($this->ext, array('png', 'jpg', 'gif', 'bmp', 'jpeg'))) {
            // 假图片不允许上传
            return self::_error("{$_M['word']['upfileTip3']}");
        }

        if (strtolower($this->ext) == 'php' || strtolower($this->ext) == 'aspx' || strtolower($this->ext) == 'asp' || strtolower($this->ext) == 'jsp' || strtolower($this->ext) == 'js' || strtolower($this->ext) == 'asa') {
            return self::_error($this->ext . " {$_M['word']['upfileTip3']}");
        }
        if ($_M['config']['met_file_format']) {
            if ($_M['config']['met_file_format'] != "" && !in_array(strtolower($this->ext), explode('|', strtolower($_M['config']['met_file_format']))) && $filear) {
                return self::_error($this->ext . " {$_M['word']['upfileTip3']}");
            }
        } else {
            return self::_error($this->ext . " {$_M['word']['upfileTip3']}");
        }
        if ($this->format) {
            if ($this->format != "" && !in_array(strtolower($this->ext), explode('|', strtolower($this->format))) && $filear) {
                return self::_error($this->ext . " {$_M['word']['upfileTip3']}");
            }
        }
        //文件名重命名
        $this->set_savename($filear["name"], $this->is_rename);
        //新建保存文件
        if (stripos($this->savepath, PATH_WEB . 'upload/') !== 0) {
            return self::_error($_M['word']['upfileFail2']);
        }

        if (strstr($this->savepath, './')) {
            return self::_error($_M['word']['upfileTip3']);
        }
        if (!makedir($this->savepath)) {
            return self::_error($_M['word']['upfileFail2']);
        }
        //复制文件
        $upfileok = 0;
        $file_tmp = $filear["tmp_name"];
        $file_name = $this->savepath . $this->savename;
        if (stristr(PHP_OS, "WIN")) {
            $file_name = @iconv("utf-8", "GBK", $file_name);
        }
        if (function_exists("move_uploaded_file")) {
            if (move_uploaded_file($file_tmp, $file_name)) {
                $upfileok = 1;
            } else if (copy($file_tmp, $file_name)) {
                $upfileok = 1;
            }
        } elseif (copy($file_tmp, $file_name)) {
            $upfileok = 1;
        }
        if (!$upfileok) {
            if (is_writable($this->savepath)) {
                $_M['word']['upfileOver4'] = $_M['word']['upfileOver5'];
            }
            $errors = array(0 => $_M['word']['upfileOver4'], 1 => $_M['word']['upfileOver'], 2 => $_M['word']['upfileOver1'], 3 => $_M['word']['upfileOver2'], 4 => $_M['word']['upfileOver3'], 6 => $_M['word']['upfileOver5'], 7 => $_M['word']['upfileOver5']);
            $filear['error'] = $filear['error'] ? $filear['error'] : 0;
            return self::_error($errors[$filear['error']]);
        } else {
            if (stripos($filear['tmp_name'], PATH_WEB) === false) {
                @unlink($filear['tmp_name']); //Delete temporary files
            }
        }
        load::plugin('doqiniu_upload', 0, array('savename' => str_replace(PATH_WEB, '', $this->savepath) . $this->savename, 'localfile' => $file_name));
        $back = '../' . str_replace(PATH_WEB, '', $this->savepath) . $this->savename;
        return self::_success($back, $filear["size"]);
    }

    //批量上传文件
    public function uploadarr($form = '')
    {
        if ($form) {
            foreach ($_FILES as $key => $val) {
                if ($form == $key) {
                    $filear = $_FILES[$key];
                }
            }
        }
        if (!$filear) {
            foreach ($_FILES as $key => $val) {
                $filear = $_FILES[$key];
                break;
            }
        }

        $length = count($filear['name']);
        for ($i = 0; $i < $length; $i++) {
            $file['name'] = $filear['name'][$i];
            $file['type'] = $filear['type'][$i];
            $file['tmp_name'] = $filear['tmp_name'][$i];
            $file['error'] = $filear['error'][$i];
            $file['size'] = $filear['size'][$i];
            $res[$i] = $this->uploadcustom($file);
        }
        return $res;
    }

    public function uploadcustom($filear = '')
    {
        global $_M;

        //是否能正常上传
        if (!is_array($filear)) $filear['error'] = 4;
        if ($filear['error'] != 0) {
            $errors = array(
                0 => $_M['word']['upfileOver4'],
                1 => $_M['word']['upfileOver'],
                2 => $_M['word']['upfileOver1'],
                3 => $_M['word']['upfileOver2'],
                4 => $_M['word']['upfileOver3'],
                6 => $_M['word']['upfileOver5'],
                7 => $_M['word']['upfileOver5']
            );
            $error_info[] = $errors[$filear['error']] ? $errors[$filear['error']] : $errors[0];
            return self::_error($errors[$filear['error']]);
        }
        //空间超容 有些虚拟主机不支持此函数
        if (function_exists('disk_free_space')) {
            if (disk_free_space(__DIR__) != FALSE && disk_free_space(__DIR__) != 'NULL') {
                if (disk_free_space(__DIR__) < $filear["size"]) {
                    return self::_error("out of disk space");
                }
            }

        }
        //目录不可写
        if (!is_writable(PATH_WEB . "upload")) {
            return self::_error("directory ['" . PATH_WEB . "upload'] can not write");
        }
        //文件大小是否正确{}
        if ($filear["size"] > $this->maxsize) {
            return self::_error("{$_M['word']['upfileFile']}" . $filear["name"] . " {$_M['word']['upfileMax']} {$_M['word']['upfileTip1']}");
        }
        //文件后缀是否为合法后缀
        $this->getext($filear["name"]); //获取允许的后缀
        if (strtolower($this->ext) == 'php' || strtolower($this->ext) == 'aspx' || strtolower($this->ext) == 'asp' || strtolower($this->ext) == 'jsp' || strtolower($this->ext) == 'js' || strtolower($this->ext) == 'asa') {
            return self::_error($this->ext . " {$_M['word']['upfileTip3']}");
        }
        if ($_M['config']['met_file_format']) {
            if ($_M['config']['met_file_format'] != "" && !in_array(strtolower($this->ext), explode('|', strtolower($_M['config']['met_file_format']))) && $filear) {
                return self::_error($this->ext . " {$_M['word']['upfileTip3']}");
            }
        } else {
            return self::_error($this->ext . " {$_M['word']['upfileTip3']}");
        }
        if ($this->format) {
            if ($this->format != "" && !in_array(strtolower($this->ext), explode('|', strtolower($this->format))) && $filear) {
                return self::_error($this->ext . " {$_M['word']['upfileTip3']}");
            }
        }
        //文件名重命名
        $this->set_savename($filear["name"], $this->is_rename);
        //新建保存文件
        if (stripos($this->savepath, PATH_WEB . 'upload/') !== 0) {
            return self::_error($_M['word']['upfileFail2']);
        }

        if (strstr($this->savepath, './')) {
            return self::_error($_M['word']['upfileTip3']);
        }
        if (!makedir($this->savepath)) {
            return self::_error($_M['word']['upfileFail2']);
        }
        //复制文件
        $upfileok = 0;
        $file_tmp = $filear["tmp_name"];
        $file_name = $this->savepath . $this->savename;
        if (stristr(PHP_OS, "WIN")) {
            $file_name = @iconv("utf-8", "GBK", $file_name);
        }
        if (function_exists("move_uploaded_file")) {
            if (move_uploaded_file($file_tmp, $file_name)) {
                $upfileok = 1;
            } else if (copy($file_tmp, $file_name)) {
                $upfileok = 1;
            }
        } elseif (copy($file_tmp, $file_name)) {
            $upfileok = 1;
        }
        if (!$upfileok) {
            $errors = array(0 => $_M['word']['upfileOver4'], 1 => $_M['word']['upfileOver'], 2 => $_M['word']['upfileOver1'], 3 => $_M['word']['upfileOver2'], 4 => $_M['word']['upfileOver3'], 6 => $_M['word']['upfileOver5'], 7 => $_M['word']['upfileOver5']);
            $filear['error'] = $filear['error'] ? $filear['error'] : 0;
            return self::_error($errors[$filear['error']]);
        } else {
            if (stripos($filear['tmp_name'], PATH_WEB) === false) {
                @unlink($filear['tmp_name']); //Delete temporary files
            }
        }
        load::plugin('doqiniu_upload', 0, array('savename' => str_replace(PATH_WEB, '', $this->savepath) . $this->savename, 'localfile' => $file_name));
        $back = '../' . str_replace(PATH_WEB, '', $this->savepath) . $this->savename;
        return self::_success($back, $filear['size']);

    }


    /**
     * 获取后缀
     * @param  string $filename 文件名
     * @return string            文件后缀名
     */
    protected function getext($filename)
    {
        if ($filename == "") {
            return;
        }
        $ext = explode(".", $filename);
        $ext = $ext[count($ext) - 1];
        if (preg_match("/^[0-9a-zA-Z]+$/u", $ext)) {
            return $this->ext = $ext;
        }
        return $this->ext = '';
    }

    /**
     * 是否重命名
     * @param  string $filename 文件名
     * @param  string $is_rename 是否重命名，0或1
     * @return string                处理后的文件名
     */
    protected function set_savename($filename, $is_rename)
    {
        if ($is_rename) {
            srand((double)microtime() * 1000000);
            $rnd = rand(100, 999);
            $filename = date('U') + $rnd;
            $filename = $filename . "." . $this->ext;
        } else {
            $name_verification = explode('.', $filename);
            $verification_mun = count($name_verification);
            if ($verification_mun > 2) {
                $verification_mun1 = $verification_mun - 1;
                $name_verification1 = $name_verification[0];
                for ($i = 0; $i < $verification_mun1; $i++) {
                    $name_verification1 .= '_' . $name_verification[$i];
                }
                $name_verification1 .= '.' . $name_verification[$verification_mun1];
                $filename = $name_verification1;
            }
            $filename = str_replace(array(":", "*", "?", "|", "/", "\\", "\"", "<", ">", "——", " "), '_', $filename);
            if (stristr(PHP_OS, "WIN")) {
                if (!preg_match('/^[<0-9a-zA-Z\x{4e00}-\x{9fa5}-_<>().\s]+$/u', $filename) && version_compare(phpversion(),'5.4','<')) {
                    $this->set_savename($filename, 1);
                }
                $filename_temp = @iconv("utf-8", "GBK", $filename);
            } else {
                $filename_temp = $filename;
            }
            $i = 0;
            $savename_temp = str_replace('.' . $this->ext, '', $filename_temp);
            while (file_exists($this->savepath . $filename_temp)) {
                $i++;
                $filename_temp = $savename_temp . '(' . $i . ')' . '.' . $this->ext;
            }
            if ($i != 0) {
                $filename = str_replace('.' . $this->ext, '', $filename) . '(' . $i . ')' . '.' . $this->ext;
            }
        }
        return $this->savename = $filename;
    }

    /**
     * 上传错误调用方法
     * @param string $error 错误信息
     * @return array 返回错误信息
     */
    protected function _error($error)
    {
        $redata = array();
        $redata['error'] = $error;
        $redata['msg'] = $error;
        return $redata;
    }

    /**
     * @param string $path
     * @param string $size
     * @return mixed
     */
    protected function _success($path = '', $size = '')
    {
        $redata = array();
        $redata['size'] = $size;
        $redata['path'] = $path;
        return $redata;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>