<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('CODETABLEDIR', STATICPATH.'/encoding/');

function utf8_to_gbk($utfstr) {
    global $UC2GBTABLE;
    $okstr = '';
    if(empty($UC2GBTABLE)) {
        $filename = CODETABLEDIR.'gb-unicode.table';
        $fp = fopen($filename, 'rb');
        while($l = fgets($fp,15)) {
            $UC2GBTABLE[hexdec(substr($l, 7, 6))] = hexdec(substr($l, 0, 6));
        }
        fclose($fp);
    }
    $okstr = '';
    $ulen = strlen($utfstr);
    for($i=0; $i<$ulen; $i++) {
        $c = $utfstr[$i];
        $cb = decbin(ord($utfstr[$i]));
        if(strlen($cb)==8) {
            $csize = strpos(decbin(ord($cb)),'0');
            for($j = 0; $j < $csize; $j++) {
                $i++;
                $c .= $utfstr[$i];
            }
            $c = utf8_to_unicode($c);
            if(isset($UC2GBTABLE[$c])) {
                $c = dechex($UC2GBTABLE[$c]+0x8080);
                $okstr .= chr(hexdec($c[0].$c[1])).chr(hexdec($c[2].$c[3]));
            }
            else {
                $okstr .= '&#'.$c.';';
            }
        }
        else {
            $okstr .= $c;
        }
    }
    $okstr = trim($okstr);
    return $okstr;
}

function gbk_to_utf8($gbstr) {
    global $CODETABLE;
    if(empty($CODETABLE)) {
        $filename = CODETABLEDIR.'gb-unicode.table';
        $fp = fopen($filename, 'rb');
        while($l = fgets($fp,15)) {
            $CODETABLE[hexdec(substr($l, 0, 6))] = substr($l, 7, 6);
        }
        fclose($fp);
    }
    $ret = '';
    $utf8 = '';
    while($gbstr) {
        if(ord(substr($gbstr, 0, 1)) > 0x80) {
            $thisW = substr($gbstr, 0, 2);
            $gbstr = substr($gbstr, 2, strlen($gbstr));
            $utf8 = '';
            @$utf8 = unicode_to_utf8(hexdec($CODETABLE[hexdec(bin2hex($thisW)) - 0x8080]));
            if($utf8 != '') {
                for($i = 0; $i < strlen($utf8); $i += 3) $ret .= chr(substr($utf8, $i, 3));
            }
        }
        else {
            $ret .= substr($gbstr, 0, 1);
            $gbstr = substr($gbstr, 1, strlen($gbstr));
        }
    }
    return $ret;
}

function big5_to_gbk($Text) {
    global $BIG5_DATA;
    if(empty($BIG5_DATA)) {
        $filename = CODETABLEDIR.'big5-gb.table';
        $fp = fopen($filename, 'rb');
        $BIG5_DATA = fread($fp, filesize($filename));
        fclose($fp);
    }
    $max = strlen($Text)-1;
    for($i = 0; $i < $max; $i++) {
        $h = ord($Text[$i]);
        if($h >= 0x80) {
            $l = ord($Text[$i+1]);
            if($h==161 && $l==64) {
                $gbstr = '　';
            }
            else {
                $p = ($h-160)*510+($l-1)*2;
                $gbstr = $BIG5_DATA[$p].$BIG5_DATA[$p+1];
            }
            $Text[$i] = $gbstr[0];
            $Text[$i+1] = $gbstr[1];
            $i++;
        }
    }
    return $Text;
}

function gbk_to_big5($Text) {
    global $GB_DATA;
    if(empty($GB_DATA)) {
        $filename = CODETABLEDIR.'gb-big5.table';
        $fp = fopen($filename, 'rb');
        $gb = fread($fp, filesize($filename));
        fclose($fp);
    }
    $max = strlen($Text)-1;
    for($i = 0; $i < $max; $i++) {
        $h = ord($Text[$i]);
        if($h >= 0x80) {
            $l = ord($Text[$i+1]);
            if($h==161 && $l==64) {
                $big = '　';
            }
            else {
                $p = ($h-160)*510+($l-1)*2;
                $big = $GB_DATA[$p].$GB_DATA[$p+1];
            }
            $Text[$i] = $big[0];
            $Text[$i+1] = $big[1];
            $i++;
        }
    }
    return $Text;
}

function unicode_to_utf8($c) {
    $str = '';
    if($c < 0x80) {
        $str .= $c;
    }
    elseif($c < 0x800) {
        $str .= (0xC0 | $c >> 6);
        $str .= (0x80 | $c & 0x3F);
    }
    elseif($c < 0x10000) {
        $str .= (0xE0 | $c >> 12);
        $str .= (0x80 | $c >> 6 & 0x3F);
        $str .= (0x80 | $c & 0x3F);
    }
    elseif($c < 0x200000) {
        $str .= (0xF0 | $c >> 18);
        $str .= (0x80 | $c >> 12 & 0x3F);
        $str .= (0x80 | $c >> 6 & 0x3F);
        $str .= (0x80 | $c & 0x3F);
    }
    return $str;
}

function utf8_to_unicode($c) {
    switch(strlen($c)) {
        case 1:
            return ord($c);
        case 2:
            $n = (ord($c[0]) & 0x3f) << 6;
            $n += ord($c[1]) & 0x3f;
            return $n;
        case 3:
            $n = (ord($c[0]) & 0x1f) << 12;
            $n += (ord($c[1]) & 0x3f) << 6;
            $n += ord($c[2]) & 0x3f;
            return $n;
        case 4:
            $n = (ord($c[0]) & 0x0f) << 18;
            $n += (ord($c[1]) & 0x3f) << 12;
            $n += (ord($c[2]) & 0x3f) << 6;
            $n += ord($c[3]) & 0x3f;
            return $n;
    }
}


function asc_to_pinyin($asc,&$pyarr) {
    if($asc < 128)return chr($asc);
    elseif(isset($pyarr[$asc]))return $pyarr[$asc];
    else {
        foreach($pyarr as $id => $p) {
            if($id >= $asc)return $p;
        }
    }
}

function gbk_to_pinyin($str,$ishead=0,$isclose=1) {
    global $pinyins;
    $restr = '';
    $str = trim($str);
    $slen = strlen($str);
    if($slen<2)	return $str;
    if(count($pinyins)==0) {
        $fp = fopen( CODETABLEDIR.'pinyin.dat','r');
        while(!feof($fp)) {
            $line = trim(fgets($fp));
            $pinyins[$line[0].$line[1]] = substr($line,3,strlen($line)-3);
        }
        fclose($fp);
    }
    for($i=0;$i<$slen;$i++) {
        if(ord($str[$i])>0x80) {
            @ $c = $str[$i].$str[$i+1];
            $i++;
            if(isset($pinyins[$c])) {
                if($ishead==0) {
                    $restr .= $pinyins[$c];
                }else {
                    $restr .= $pinyins[$c][0];
                }
            }else {
                $restr .= "_";
            }
        }else if( preg_match("/[a-z0-9]/i",$str[$i]) ) {
            $restr .= $str[$i];
        }else {
            $restr .= "_";
        }
    }
    if($isclose==0) {
        unset($pinyins);
    }
    return $restr;
}


?>