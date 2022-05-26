<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_func('str');
/**
 * 新建文件夹
 * @param  string  $dir 要新建的文件夹
 * @return boolean 		文件夹存在则返回真，否侧新建文件夹，并返回是否新建文件夹成功
 */
function makedir($dir)
{
    $dir = path_absolute($dir);
    @clearstatcache();
    if (file_exists($dir)) {
        $result = true;
    } else {
        $fileUrl = '';
        $fileArr = explode('/', $dir);
        $result = true;
        foreach ($fileArr as $val) {
            $fileUrl .= $val . '/';
            if (!file_exists($fileUrl)) {
                $result = mkdir($fileUrl, 0777, true);
            }
        }
    }
    @clearstatcache();
    return $result;
}

/**
 * 新建文件
 * @param  string  $file		要新建文件
 * @param  boolean $overWrite	如果新建的文件存在，是否删除原文件（true：删除原文件，false：不删除原文件）默认删除
 * @return boolean				是否新建文件成功
 */
function makefile($file,$overWrite = true)
{
    $file = path_absolute($file);
    @clearstatcache();
    if (file_exists($file) && $overWrite == false) {
        return true;
    } else if (file_exists($file) && $overWrite == true) {
        delfile($file);
    }
    $fileDir = dirname($file);
    if (makedir($fileDir)) {
        @clearstatcache();
        return touch($file);
    } else {
        @clearstatcache();
        return false;
    }
}

/**
 * 复制文件夹
 * @param  string  $oldDir		原文件夹
 * @param  string  $targetDir	复制后的文件夹名
 * @param  boolean $overWrite	是否覆盖原文件夹（true：覆盖原文件夹，false：不覆盖原文件夹）默认覆盖
 * @return boolean				复制成功返回true，否则返回false
 */
function copydir($oldDir, $targetDir, $overWrite = true)
{
    $oldDir = path_absolute($oldDir);
    $targetDir = path_absolute($targetDir);
    @clearstatcache();
    $targetDir = substr($targetDir, -1) == '/' ? $targetDir : $targetDir . '/';
    $oldDir = substr($oldDir, -1) == '/' ? $oldDir : $oldDir . '/';
    if (!is_dir($oldDir)) {
        return false;
    }
    if (!file_exists($targetDir)) {
        makedir($targetDir);
    }
    $resource = opendir($oldDir);
    while (($file = readdir($resource)) !== false) {
        if ($file == '.' || $file == '..') {
            continue;
        }
        if (!is_dir($oldDir . $file)) {
            copyfile($oldDir . $file, $targetDir . $file, $overWrite);
        } else {
            copydir($oldDir . $file, $targetDir . $file, $overWrite);
        }
    }
    @clearstatcache();
    if (is_dir($targetDir)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 复制文件
 * @param  string  $oldFile		原文件
 * @param  string  $targetFile	复制后的文件名
 * @param  boolean $overWrite   是否覆盖原文件（true：覆盖原文件，false：不覆盖原文件）默认覆盖
 * @return boolean				复制成功返回true，否则返回false
 */
function copyfile($oldFile, $targetFile, $overWrite = true)
{
    $oldFile = path_absolute($oldFile);
    $targetFile = path_absolute($targetFile);
    @clearstatcache();
    if (!file_exists($oldFile)) {
        return false;
    }
    @clearstatcache();
    if (file_exists($targetFile) && $overWrite == false) {
        return false;
    } else if (file_exists($targetFile) && $overWrite == true) {
        //delfile($targetFile);
    }
    $fileDir = dirname($targetFile);
    makedir($fileDir);
    if (copy($oldFile, $targetFile)) {
        return true;
    } else {
        return false;
    }
    @clearstatcache();
}

/**
 * 移动文件夹
 * @param  string  $oldDir		原文件夹
 * @param  string  $targetDir	移动后的文件夹名
 * @param  boolean $overWrite	是否覆盖已有文件夹（true：覆盖已有文件夹，false：不覆盖已有文件夹）默认覆盖
 * @return boolean				移动成功返回true，否则返回false
 */
function movedir($oldDir, $targetDir, $overWrite = true)
{
    $oldDir = path_absolute($oldDir);
    $targetDir = path_absolute($targetDir);
    @clearstatcache();
    $targetDir = substr($targetDir, -1) == '/' ? $targetDir : $targetDir . '/';
    $oldDir = substr($oldDir, -1) == '/' ? $oldDir : $oldDir . '/';
    if (!is_dir($oldDir)) {
        return false;
    }
    if (!file_exists($targetDir)) {
        makedir($targetDir);
    }
    $resource = opendir($oldDir);
    if (!$resource) {
        return false;
    }
    while (($file = readdir($resource)) !== false) {
        if ($file == '.' || $file == '..') {
            continue;
        }
        if (!is_dir($oldDir . $file)) {
            movefile($oldDir . $file, $targetDir . $file, $overWrite);
        } else {
            movedir($oldDir . $file, $targetDir . $file, $overWrite);
        }
    }
    closedir($resource);
    @clearstatcache();
    return rmdir($oldDir);
}

/**
 * 移动文件
 * @param  string  $oldFile		原文件
 * @param  string  $targetFile  移动后的文件名
 * @param  boolean $overWrite   是否覆盖已有文件（true：覆盖已有文件，false：不覆盖已有文件）默认覆盖
 * @return boolean				移动成功返回true，否则返回false
 */
function movefile($oldFile, $targetFile, $overWrite = true)
{
    $oldFile = path_absolute($oldFile);
    $targetFile = path_absolute($targetFile);
    @clearstatcache();
    if (!file_exists($oldFile)) {
        return false;
    }
    @clearstatcache();
    if (file_exists($targetFile) && $overWrite == false) {
        //delfile($oldFile);
        return false;
    } else if (file_exists($targetFile) && $overWrite == true) {
        delfile($targetFile);
    }
    $fileDir = dirname($targetFile);
    makedir($fileDir);
    rename($oldFile, $targetFile);
    @clearstatcache();
    return true;
}

/**
 * 删除文件夹
 * @param  string  $fileDir  要删除的文件夹
 * @param  int     $type  	 0：删除本文件夹及文件夹下文件，1：只删除本文件夹下的文件。默认都删除
 * @return boolean 			 删除成功返回true，否则返回false
 */
function deldir($fileDir,$type = 0)
{
    $fileDir = path_absolute($fileDir);
    @clearstatcache();
    $fileDir = substr($fileDir, -1) == '/' ? $fileDir : $fileDir . '/';
    if (!is_dir($fileDir)) {
        return false;
    }
    $resource = opendir($fileDir);
    @clearstatcache();
    while (($file = readdir($resource)) !== false) {
        if ($file == '.' || $file == '..') {
            continue;
        }
        if (!is_dir($fileDir . $file)) {
            delfile($fileDir . $file);
        } else {
            deldir($fileDir . $file);
        }
    }
    closedir($resource);
    @clearstatcache();
    if ($type == 0) rmdir($fileDir);
    return true;
}

/**
 * 删除文件
 * @param  string  $fileDir	要删除的文件
 * @return boolean			删除成功返回true，否则返回false
 */
function delfile($fileUrl)
{
    $fileUrl = path_absolute($fileUrl);
    @clearstatcache();
    if (stristr(PHP_OS, "WIN")) {
        $fileUrl = @iconv("utf-8", "GBK", $fileUrl);
    }
    if (file_exists($fileUrl)) {
        unlink($fileUrl);
        return true;
    } else {
        return false;
    }
    @clearstatcache();
}

/**
 * 相对路径转绝对路径
 * @param  string  $path	要转换的路径
 * @return string			返回转换好的路径
 */
function path_absolute($path)
{
    if (substr($path, 0, strlen(PATH_WEB)) == PATH_WEB) {
        $path = $path;
    } else {
        $path = PATH_WEB . str_replace(array('../', './', PATH_WEB), '', $path);
    }
    if (is_dir($path)) {
        $last = substr($path, -1, 1);
        if ($last != '/' && $last != '\\') {
            $path = $path . '/';
        }
    }
    return $path;
}

/**
 * 绝对路径转相对路径
 * @param  string  $path		要转换的路径
 * @param  string  $relative	相对路径前缀
 * @return string				返回转换好的路径
 */
function path_relative($path, $relative = '../')
{
    return $relative . str_replace(array('../', './', PATH_WEB), '', $path);
}

/**
 * 目录路径最后不是已/，结尾的，则给路径添加上/
 * @param  string  $path		要转换的路径
 * @return string				返回转换好的路径
 */
function path_standard($path)
{
    if (substr($path, -1, 1) != '/') {
        $path = $path . '/';
    }
    return $path;
}

/**
 * 获取文件的大小
 * @param  string  $filename	要获取的文件名
 * @return int					返回文件的大小
 */
function getfilesize($filename)
{
    $filename = path_absolute($filename);
    @clearstatcache();
    if (file_exists($filename)) {
        $filesize = filesize($filename) . 'B';
        if ($filesize > 1000000) {
            $filesize = $filesize / 1000000;
            $filesize = sprintf("%.2f", $filesize);
            $filesize .= 'MB';
        } else {
            if ($filesize > 1000) {
                $filesize = $filesize / 1000;
                $filesize = sprintf("%.2f", $filesize);
                $filesize .= 'KB';
            } else {
                $filesize .= 'B';
            }
        }
    } else {
        return false;
    }
    return $filesize;
}

/**
 * 获取文件的后缀名
 * @param  string  $filename	要获取的文件名
 * @return string				返回文件的后缀名
 */
function getfileable($filename){
	$filename = path_absolute($filename);
	$lastsite = strrpos($filename,'.');
	$fileable = substr($filename,$lastsite+1);
	return $fileable;
}

/**
 * 验证文件夹是否有写权限
 * @param string  $dir        要检测的文件夹
 * @return boolean $flag		有可写权限返回true，否则返回false
 */
function getdirpower($dir)
{
    $dir = path_absolute($dir);
    @clearstatcache();
    $dir = substr($dir, -1) == '/' ? $dir : $dir . '/';
    if (is_dir($dir)) {
        $file_hd = @fopen($dir . '/test.txt', 'w');
        if ($file_hd) {
            $flag = true;
        } else {
            $flag = false;
        }
        @fclose($file_hd);
        @unlink($dir . '/test.txt');
    } else {
        $flag = false;
    }
    return $flag;
}

/**
 * 验证文件是否有写权限
 * @param string  $file		要检测的文件
 * @return boolean $flag	有可写权限返回true，否则返回false
 */
function getfilepower($file)
{
    $file = path_absolute($file);
    @clearstatcache();
    if (file_exists($file) && !is_dir($file)) {
        $power = file_get_contents($file);
        if ($power) {
            if (file_put_contents($file, $power)) {
                return true;
            } else {
                return false;
            }
        } else {
            if (file_put_contents($file, 'test')) {
                unlink($file);
                touch($file);
                return true;
            } else {
                return false;
            }
        }
    } else {
        return false;
    }
}

/**
 * 修改文件夹权限
 * @param  string   $dir	要修改的文件夹
 * @param  int      $power	修改后的文件权限 777/755 读写，544 只读
 * @return boolean  $flag	修改成功返回true，否则返回false
 */
function modifydirpower($dir,$power)
{
    $dir = path_absolute($dir);
    @clearstatcache();
    $dir = substr($dir, -1) == '/' ? $dir : $dir . '/';
    if (is_dir($dir)) {
        $success = @chmod($dir, $power);
        if ($success === false) {
            $flagd = false;
        }
        $resource = opendir($dir);
        @clearstatcache();
        while (($file = readdir($resource)) !== false) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (!is_dir($dir . $file)) {
                modifyfilepower($dir . $file, $power);
            } else {
                modifydirpower($dir . $file, $power);
            }
        }
        closedir($resource);
    }
    if ($flagd === false) {
        return false;
    } else {
        return true;
    }
}

/**
 * 修改文件权限
 * @param  string   $file	要修改的文件
 * @param  int      $power	修改后的文件权限 0777/0755 读写，0544 只读
 * @return boolean  $flag	修改成功返回true，否则返回false
 */
function modifyfilepower($file,$power)
{
    $file = path_absolute($file);
    @clearstatcache();
    if (file_exists($file) && !is_dir($file)) {
        $sucess = chmod($file, $power);
        if ($sucess) {
            $flag = true;
        } else {
            $flag = false;
        }
    } else {
        $flag = false;
    }
    return $flag;
}

/*遍历文件*/
/**
 * 遍历文件夹下所有文件
 * @param  string   $jkdir	遍历文件夹,可以是绝对路径，也可以是相对网站根目录的相对路径
 * @param  string   $suffix	遍历文件的后缀，不填写为全部文件。支持正则。
 * @param  string   $jump	跳过不需要遍历的文件夹。要填写网站根目录路径，不要含有../,实质是"/^({$jump})/"中正则参数。
 * @return string   $filenamearray  返回提取的文件数组。文件路径都是绝对路径。
 */
function traversal($jkdir, $suffix='[A-Za-z]*', $jump=null, &$filenamearray = array())
{
    if ($jkdir == '.' || $jkdir == './') $jkdir = '';
    $jkdir = path_absolute($jkdir);
    $hand = opendir($jkdir);
    while ($file = readdir($hand)) {
        $filename = $jkdir . $file;
        if (@is_dir($filename) && $file != '.' && $file != '..' && $file != './..') {
            if ($jump != null) {
                if (preg_match_all("/^({$jump})/", str_replace(PATH_WEB, '', $filename), $out)) {
                    continue;
                }
            }
            traversal($filename, $suffix, $jump, $filenamearray);
        } else {
            if ($file != '.' && $file != '..' && $file != './..' && preg_match_all("/\.({$suffix})/i", $filename, $out)) {
                if (stristr(PHP_OS, "WIN")) {
                    $filename = iconv("gbk", "utf-8", $filename);
                }
                $filenamearray[] = str_replace(PATH_WEB, '', $filename);
            }
        }
    }
    return $filenamearray;
}

/**
 * 扫描当前文件夹
 * @param string $jkdir
 * @param string $suffix
 * @param null $jump
 */
function scan_dir($jkdir = '', $suffix = '[A-Za-z]*', $jump = null)
{
    if ($jkdir == '.' || $jkdir == './') $jkdir = '';
    $jkdir = path_absolute($jkdir);
    $hand = opendir($jkdir);
    $filenamearray = array();

    while ($file = readdir($hand)) {
        $filename = $jkdir . $file;
        #$filename = str_replace("\\", '/', $filename);
        if (@is_dir($filename) && $file != '.' && $file != '..' && $file != './..') {
            if ($jump != null) {
                if (preg_match_all("/^({$jump})/", str_replace(PATH_WEB, '', $filename), $out)) {
                    continue;
                }
            }
            $filenamearray[] = str_replace(PATH_WEB, '', $filename);
        } else {
            if ($file != '.' && $file != '..' && $file != './..' && preg_match_all("/\.({$suffix})/i", $filename, $out)) {
                if (stristr(PHP_OS, "WIN")) {
                    $filename = iconv("gbk", "utf-8", $filename);
                }
                $filenamearray[] = str_replace(PATH_WEB, '', $filename);
            }
        }
    }
    return $filenamearray;
}

function file_size($file_path = '', $clear = 1)
{
    static $size_total;
    if ($clear) {
        $size_total = 0;
    }
    $file_path = path_absolute($file_path);
    if (is_file($file_path)) {
        $size_total += byte_format(filesize($file_path), 3);
    } elseif (is_dir($file_path)) {
            $handler = opendir($file_path);
        while (($filename = readdir($handler)) !== false) {
            if (!in_array($filename, array(".", "..", 'cache', '.idea','.git', '.gitignore'))) {
                //dump($file_path . "/" . $filename);
                if (is_dir($file_path . "/" . $filename)) {
                    file_size($file_path . "/" . $filename, 0);
                } else {
                    $size_total += byte_format(filesize($file_path . "/" . $filename), 3);
                }
            }
        }
        @closedir($handler);
    }
    return $size_total;
}

/**
 * @param string $dir
 * @param string $skip
 * @param $zip
 */
function file_zip($dir = '', $skip = '', $zip ,$skip_list = array())
{
    global $_M;
    if (!$skip) {
        $skip = PATH_WEB;
    }

    if (strstr(strtoupper(PHP_OS), 'WIN')) {
        $skip = str_replace("\\", '/', $skip);
        $dir = str_replace("\\", '/', $dir);
    }

    $handler = opendir($dir);
    while (($filename = readdir($handler)) !== false) {
        if ($filename != "." && $filename != "..") {
            if (is_dir($dir . "/" . $filename)) {
                //$zip->addEmptyDir($dir . '/' . $filename);
                if ($skip != $dir . '/' . $filename) {
                    $new_dir = str_replace($skip, '', $dir . '/' . $filename);
                    $zip->addEmptyDir($new_dir);
                }
                file_zip($dir . "/" . $filename, $skip, $zip);
            } else {
                //忽略文件列表
                if (!in_array(str_replace($skip, '', $dir . '/' . $filename), $skip_list)) {
                    $zip->addFile($dir . "/" . $filename, str_replace($skip, '', $dir . '/' . $filename));
                }
            }
        }
    }
    @closedir($handler);
}

/**
 * @param string $fzip      //zip文件路径
 * @param string $tagdir    //解压路径
 * @return bool
 */
function fzip_open($fzip = '',$tagdir = '')
{
    if (file_exists($fzip) && is_dir($tagdir)) {
        $zip = new ZipArchive;
        if ($zip->open($fzip) === TRUE) {//中文文件名要使用ANSI编码的文件格式
            $zip->extractTo($tagdir);//提取全部文件
            $zip->close();
            return true;
        }
    }
    return false;
}

/**
 * 文件下载
 * @param string $downurl
 * @return bool
 */
function download($filePath = '')
{
    global $_M;
    $filePath = str_replace(array($_M['url']['web_site'], '../', './'), PATH_WEB, $filePath);

    //检测下载文件是否可读
    if (!is_readable($filePath) || !is_file($filePath)) {
        return false;
    }

    $allowExt = explode('|', $_M['config']['met_file_format']);
    $f_info = pathinfo($filePath);
    //检测文件类型是否允许下载
    if (!in_array($f_info['extension'], $allowExt)) {
        return false;
    }
    $readBuffer = 1024;

    //设置头信息
    //声明浏览器输出的是字节流
    header('Content-Type: application/octet-stream');
    //声明浏览器返回大小是按字节进行计算
    header('Accept-Ranges:bytes');
    //告诉浏览器文件的总大小
    $fileSize = filesize($filePath);
    header('Content-Length:' . $fileSize); //'Content-Length:' 非Accept-Length
    //声明下载文件的名称
    header('Content-Disposition:attachment;filename=' . basename($filePath));//声明作为附件处理和下载后文件的名称
    //获取文件内容
    $handle = fopen($filePath, 'rb');//二进制文件用‘rb’模式读取
    while (!feof($handle)) { //循环到文件末尾 规定每次读取（向浏览器输出为$readBuffer设置的字节数）
        echo fread($handle, $readBuffer);
    }
    fclose($handle);//关闭文件句柄
    exit;
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>