<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

class csv
{
    public $encode;
    public $origin_code;
    public $target_code;

    public function __construct()
    {
        $this->encode = 1;
        $this->origin_code = "utf-8";
        $this->target_code = "GBK//IGNORE";
    }

    /**
     * @param $filename
     * @param $array
     * @param $head
     * @param array $foot
     */
    public function get_csv($filename, $array, $head, $foot = array())
    {
        //CLI模式通过php://output向终端输出内容
        $fp = fopen('php://output', 'a') or die("Can't open php://output");

        // 表头
        foreach ($head as $i => $v) {
            $head [$i] = self::char_GBK($v);
        }
        fputcsv($fp, $head);

        $cnt = 0;
        // 内容
        $limit = 8000;
        foreach ($array as $row) {
            $cnt++;
            if ($limit == $cnt) {
                ob_flush();
                flush();
                $cnt = 0;
            }
            $content = array();
            foreach ($head as $i => $v) {
                $content [] = self::char_GBK($row[$i]);
            }
            fputcsv($fp, $content);
        }

        if ($foot) {
            foreach ($foot as $i => $v) {
                $foot[$i] = self::char_GBK($v);
            }
            fputcsv($fp, $foot);
        }

        // 输出Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
        header('Cache-Control: max-age=0');
    }

    public function char_GBK($str = '')
    {
        if (!$str) {
            return '';
        }

        if ($this->encode) {
            //return iconv("UTF-8", "gb2312//TRANSLIT", $str);
            //return iconv("UTF-8", "GBK//IGNORE", $str);
            return iconv($this->origin_code, $this->target_code, $str);
        }else{
            return $str;
        }

    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>