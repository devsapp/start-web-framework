<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * 字符串验证：URL
 * @param  string  $url		要验证的URL
 * @return boolean $flag	合法的URL返回true，否则返回false
 */
function is_url($url){
	$flag = true;
	$patten = '/http:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is';
	if(preg_match($patten, $url) == 0){
		$flag = false;
	}
	return $flag;
}

/**
 * 字符串验证：email
 * @param  string  $email  	要验证的URL
 * @return boolean $flag	合法的email返回true，否则返回false
 */
function is_email($email){
	$flag = true;
	$patten = '/[\w-]+@[\w-]+\.[a-zA-Z\.]*[a-zA-Z]$/';
	if(preg_match($patten, $email) == 0){
		$flag = false;
	}
	return $flag;
}

/**
 * 字符串验证：数字
 * @param  string(int)  $number  	    要验证的数字或字符串
 * @return boolean 		$flag		是数字（数字字符串）返回true，否则返回false
 */
function is_number($number){
	$flag = true;
	if(!is_numeric($number)){
		$flag = false;
	}
	return $flag;
}

/**
 * 字符串验证：合法文件名
 * @param  string  $filename  	要验证的文件名
 * @return boolean				合法的文件名返回true，否则返回false
 */
function is_filename($filename){
	$error = array('/','\\',':','<','>','"','|','?','*');
	foreach($error as $val){
		if(is_strinclude($filename,$val)){
			return false;
		}
	}
	return true;
}

/**
 * 字符串验证：手机
 * @param  string(int)  $phone	要验证的手机号
 * @return boolean		$flag	合法的手机号返回true，否则返回false
 */
function is_phone($phone){
	if(strlen($phone) == 11){
		$flag = true;
		$patten = '/^1[346578]{1}\d{8}\d$/';
		if(preg_match($patten, $phone) == 0){
			$flag = false;
		}
	}else{
		$flag = false;
	}
	return $flag;
}

/**
 * 字符串验证：是否为空
 * @param  string  $str		要验证的字符串
 * @return boolean $flag	字符串为空返回false，否则返回true
 */
function is_strempty($str){
	$flag = true;
	if(empty($str)){
		$flag = false;
	}
	return $flag;
}

/**
 * 字符串验证：长度
 * @param  string  $str	    要验证的字符串
 * @param  int     $cnlen	中文字符计算方式,1:中文按1个字符计算,2:中文按2个字符计算
 * @return int			    返回字符串的长度
 */
function str_length($str, $cnlen = 2){
	$code = mb_detect_encoding($str, "ASCII, UTF-8, GB2312, GBK", true);
	if($cnlen == 1){
		return mb_strlen($str, $code);
	}else{
		return (strlen($str) + mb_strlen($str, $code)) / 2;
	}
}

/**
 * 字符串查找
 * @param  string	$str  	在该字符串中查找
 * @param  string	$needle	指定验证的字符串
 * @param  int 		$type	0：不区分大小写，1：区分大小写。默认不区分大小写
 * @return boolean	$flag	包含有指定的字符串返回true  否则返回false
 */
function is_strinclude($str, $needle, $type = 0){
	if(!$needle) return false;
    if (!is_string($needle)) {
        $needle = strval($needle);
    }
	$flag = true;
	if(function_exists('stripos')){
		if($type == 0){
			if(stripos($str, $needle) === false){
				$flag = false;
			}
		}else if($type == 1){
			if(strpos($str, $needle) === false){
				$flag = false;
			}
		}
	}else{
		if($type == 0){
			if(stristr($str, $needle) === false){
				$flag = false;
			}
		}else if($type == 1){
			if(strstr($str, $needle) === false){
				$flag = false;
			}
		}
	}
	return $flag;
}

/**
 * 普通字符串查找
 * @param string $str
 * @param string $patten
 * @return bool
 */
function is_simplestr($str = '' , $patten = '/^[0-9A-Za-z_]+$/')
{
    $flag = false;
    if(preg_match($patten, $str)){
        $flag = true;
    }
    return $flag;
}

/**
 * 字符串截取（考虑中英文混排）
 * @param  string	$str  		在该字符串中截取
 * @param  int 		$start  	开始截取的位置，如果为负数则从字符串末尾截取出长度为(/$start/）的字符串。默认为0
 * @param  int 		$length     要截取的字符串长度（可选）只能为非负数
 * @return string	$newstr		返回截取后的字符串，失败时返回false
 */
function strcut($str, $start = 0, $length = ''){
	$code = mb_detect_encoding($str, "ASCII,UTF-8,GB2312,GBK", true);
	$len = mb_strlen($str, $code);
	if($start > $len){
		return false;
	}
	if(-$start > $len){
		return $str;
	}
	if(empty($length) && $length !==0){
		if($start < 0){
			$length = -$start;
			$start = $len + $start;
		}else{
			$length = $len - $start;
		}
	}
	if($length < 0){
		return false;
	}
	$newstr = mb_substr($str, $start, $length, $code);
	return $newstr;
}

/**
 * 字符串编码转换
 * @param  string  $str  		要转换的字符串
 * @param  string  $newcode  	输出的字符集
 * @param  string  $oldcode		输入的字符集
 * @param  int     $type	    0：字符转换不出时将被丢弃 1：字符转换不出时，它可以通过一个或多个形似的字符来近似表达。默认为0
 * @return string  $str			返回转换后的字符串
 */
function change_code($str, $newcode, $oldcode = '', $type = 0){
	$oldcode = $oldcode ? $oldcode : mb_detect_encoding($str, "ASCII,UTF-8,GB2312,GBK", true);
	$parameter = $type ==0 ? '//IGNORE' : '//TRANSLIT';
	$str = iconv($oldcode, $newcode.$parameter, $str);
	return $str;
}

/**
 * 显示某一个时间相当于当前时间在多少秒前，多少分钟前，多少小时前，多少天前
 * timeInt: 时间戳
 * format: 时间显示格式
 */
function timeFormat($timeInt,$format='Y-m-d H:i:s'){
	global $_M;
	if(empty($timeInt)||!is_numeric($timeInt)||!$timeInt){
		return '';
	}
	$d=time()-$timeInt;
	if($d<0){
		return '';
	}else{
		if($d<60){
			return $d.$_M['word']['times1'];
		}else{
			if($d<3600){
				return floor($d/60).$_M['word']['times2'];
			}else{
				if($d<86400){
					return floor($d/3600).$_M['word']['times3'];
				}else{
					if($d<259200){//3天内
						return floor($d/86400).$_M['word']['times4'];
					}else{
						return date($format,$timeInt);
					}
				}
			}
		}
	}
}

/**
 * 字节格式化 把字节数格式为B K M G T P E Z Y 描述的大小
 * @param int $size 大小
 * @param int $dec 显示类型
 * @return int
 */
function byte_format($size = 0, $dec = '2', $unit = "MB")
{
    $arr = array("B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
    foreach ($arr as $key => $val) {
        if (strtoupper($unit) == $val) {
            $pos = $key;
        }
    }

    if (intval($pos)) {
        $size = $size / pow(1024, $pos);
    }
    return round($size, $dec);
}

/**
 * 转UTF-8码
 * @param $str
 * @param $from
 * @param $len
 * @return mixed|string
 */
function utf8Substr($str, $from, $len) {
    $len = preg_match("/[\x7f-\xff]/", $str)?$len:$len*2;
    if(mb_strlen($str,'utf-8')>intval($len)){
        return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
                '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
                '$1',$str)."..";
    }else{
        return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
            '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
            '$1',$str);
    }
}

/**
 * 汉字转unicode
 */
function unicode_encode($name = '')
{
    $name = iconv('UTF-8', 'UCS-2', $name);
    $len = strlen($name);
    $str = '';
    for ($i = 0; $i < $len - 1; $i = $i + 2) {
        $c = $name[$i];
        $c2 = $name[$i + 1];
        if (ord($c) > 0) {    // 两个字节的文字
            $str .= '\u'.base_convert(ord($c), 10, 16).base_convert(ord($c2), 10, 16);
        } else {
            $str .= $c2;
        }
    }
    return $str;
}

/**
 * 富文本分页
 * @param string $content
 * @return string
 */
function contnets_replace($content = '')
{
    if (strstr($content, '_ueditor_page_break_tag_')) {
        $content = "<div class='tab-content met-editor-tabcontent'>\n<div class='tab-pane clearfix animation-fade'>\n" . str_replace('_ueditor_page_break_tag_', "\n</div>\n<div class='tab-pane clearfix animation-fade fade'>\n", $content) . "\n</div>\n</div>";
        $content .= "\n<div class='met-editor-tab m-t-15 text-xs-center'>\n<ul class='pagination pagination-sm m-y-0'>\n</ul>\n</div>";
    }
    return $content;
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>