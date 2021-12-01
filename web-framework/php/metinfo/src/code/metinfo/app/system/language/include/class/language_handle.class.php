<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * 系统标签类
 */

class language_handle
{
    /** 删除相关语言栏目数据
     * @param $column array 栏目数据
     * @return bool
     */
    public function delcolumn($column)
    {
        global $_M;
        if (!$column) {
            return false;
        }
        $adminurl = PATH_WEB . $_M['config']['met_adminfile'] . '\\';
        //判断栏目是否关联
        if ($column['releclass']) {
            $classtype = "class1";
        } else {
            $classtype = "class" . $column['classtype'];
        }
        $column_lang = $column['lang'];
        //判断所属模块 2新闻模块，3产品模块，4下载模块，5图片模块，6招聘模块，7留言系统，8反馈系统，9友情链接，10会员中心
        switch ($column['module']) {
            case 2:
                $query = "SELECT * FROM {$_M['table']['news']} WHERE {$classtype}='{$column['id']}'";
                $del = DB::get_all($query);
                $this->delimg($del);
                $query = "DELETE FROM {$_M['table']['news']} WHERE {$classtype}='{$column['id']}'";
                DB::query($query);
                break;
            case 3:
                $query = "SELECT * FROM {$_M['table']['product']} WHERE {$classtype}='{$column['id']}'";
                $del = DB::get_all($query);
                $this->delimg($del);
                foreach ($del as $key => $val) {
                    $query = "DELETE FROM {$_M['table']['plist']} WHERE listid='{$val['id']}' AND module='{$column['module']}'";
                    DB::query($query);
                }
                $query = "DELETE FROM {$_M['table']['product']} WHERE {$classtype}='{$column['id']}'";
                DB::query($query);
                break;
            case 4:
                $query = "SELECT * FROM {$_M['table']['download']} WHERE {$classtype}='{$column['id']}'";
                $del = DB::get_all($query);
                $this->delimg($del);
                foreach ($del as $key => $val) {
                    $query = "DELETE FROM {$_M['table']['plist']} WHERE listid='{$val['id']}' AND module='{$column['module']}'";
                    DB::query($query);
                }
                $query = "DELETE FROM {$_M['table']['download']} WHERE {$classtype}='{$column['id']}'";
                DB::query($query);
                break;
            case 5:
                $query = "SELECT * FROM {$_M['table']['img']} WHERE {$classtype}='{$column['id']}'";
                $del = DB::get_all($query);
                $this->delimg($del);
                foreach ($del as $key => $val) {
                    $query = "DELETE FROM {$_M['table']['plist']} WHERE listid='{$val['id']}' AND module='{$column['module']}'";
                    DB::query($query);
                }
                $query = "DELETE FROM {$_M['table']['img']} WHERE {$classtype}='{$column['id']}'";
                DB::query($query);
                break;
            case 6:
                $query = "DELETE FROM {$_M['table']['plist']} WHERE lang='{{$classtype}}' AND module='{$column['module']}'";
                DB::query($query);
                $query = "DELETE FROM {$_M['table']['cv']} WHERE lang='{{$classtype}}'";
                DB::query($query);
                $query = "DELETE FROM {$_M['table']['job']} WHERE lang='{{$classtype}}'";
                DB::query($query);
                break;
            case 7:
                $query = "DELETE FROM {$_M['table']['message']} WHERE lang='{{$classtype}}'";
                DB::query($query);
                $query = "DELETE FROM {$_M['table']['config']} WHERE columnid='{$column['id']}' AND lang='{{$classtype}}'";
                DB::query($query);
                $query = "DELETE FROM {$_M['table']['parameter']} WHERE lang='{{$classtype}}' AND module=7";
                DB::query($query);
                $query = "DELETE FROM {$_M['table']['mlist']} WHERE lang='{{$classtype}}' AND module=7";
                DB::query($query);
                break;
            case 8:
                $query = "SELECT id FROM {$_M['table']['feedback']} WHERE class1='{$column['id']}'";
                $del = DB::get_all($query);
                foreach ($del as $key => $val) {
                    $query = "DELETE FROM {$_M['table']['flist']} WHERE listid='{$val['id']}'";
                    DB::query($query);
                }
                $query = "DELETE FROM {$_M['table']['parameter']} WHERE module='{$column['module']}' AND class1='{$column['id']}' AND lang='{{$classtype}}'";
                DB::query($query);
                $query = "DELETE FROM {$_M['table']['feedback']} WHERE class1='{$column['id']}' AND lang='{{$classtype}}'";
                DB::query($query);
                $query = "DELETE FROM {$_M['table']['config']} WHERE columnid='{$column['id']}' AND lang='{{$classtype}}'";
                DB::query($query);
                break;
            case 9:
                $query = "DELETE FROM {$_M['table']['link']} WHERE lang='{{$classtype}}'";
                DB::query($query);
                break;
            case 10:
                $query = "DELETE FROM {$_M['table']['admin_table']} WHERE usertype!=3 AND lang='{$column_lang}'";
                DB::query($query);
                break;
        }

        $query = "DELETE FROM {$_M['table']['column']} WHERE id='{$column['id']}'";
        DB::query($query);

        /*删除文件*/
        $admin_lists = DB::get_one("SELECT id FROM {$_M['table']['column']} WHERE foldername='{$column['foldername']}'");
        if (!$admin_lists['id'] && ($column['classtype'] == 1 || $column['releclass'])) {
            if ($column['foldername'] != '' && ($column['module'] < 6 || $column['module'] == 8) && $column['if_in'] != 1) {
                if (!$this->unkmodule($column['foldername'])) {
                    $foldername = PATH_WEB . $column['foldername'];
                    $this->deldir($foldername);
                }
            }
        }

        /*删除栏目图片*/
        $this->file_unlink($adminurl . $column['indeximg']);
        $this->file_unlink($adminurl . $column['columnimg']);

    }

    /** 删除图片
     * @param $del
     */
    function delimg($del)
    {
        global $_M;
        foreach ($del as $key => $value) {
            if (isset($value['displayimg']) && $value['displayimg']) {
                $img_array = preg_match_all('#\*(../upload/.*?)\*#i', $value['displayimg'], $matches);
                if (isset($img_array[1])) {
                    foreach ($img_array[1] as $val) {
                        $this->file_unlink($val);
                    }
                }

            }

            if (!isset($value['downloadurl']) || !$value['downloadurl']) {
                if (isset($value['imgurl']) && $value['imgurl']) {
                    $this->file_unlink($value['imgurl']);
                }

                if (isset($value['imgurls']) && $value['imgurls']) {
                    $this->file_unlink($value['imgurls']);
                }

                if (isset($value['imgurlbig']) && $value['imgurlbig']) {
                    $value['imgurlbig'] = str_replace('watermark/', '', $value['imgurl']);
                    $this->file_unlink($value['imgurlbig']);
                }
            } else {
                $this->file_unlink($value['downloadurl']);
            }
            $content = array();
            if (isset($value['content'])) {
                $content[] = $value['content'];
            }

            for ($i = 1; $i <= 4; $i++) {
                if (isset($value["content{$i}"])) {
                    $content[] = $value["content{$i}"];
                }
            }

            foreach ($content as $contentkey => $contentval) {
                if ($contentval) {
                    $tmp1 = explode("<", $contentval);
                    foreach ($tmp1 as $key => $val) {
                        $tmp2 = explode(">", $val);
                        if (strcasecmp(substr(trim($tmp2[0]), 0, 3), 'img') == 0) {
                            preg_match('/http:\/\/([^\"]*)/i', $tmp2[0], $out);

                            $vals = explode('/', $out[1]);
                            $this->file_unlink(PATH_WEB . "upload/images/" . $vals[count($vals) - 1]);
                            $this->file_unlink(PATH_WEB . "upload/images/watermark/" . $vals[count($vals) - 1]);
                        }
                    }
                }
            }

        }

    }


    //模块返回表名
    function moduledb($module)
    {
        global $_M;
        switch ($module) {
            case 1:
                $moduledb = $_M['table']['column'];
                break;
            case 2:
                $moduledb = $_M['table']['news'];
                break;
            case 3:
                $moduledb = $_M['table']['product'];
                break;
            case 4:
                $moduledb = $_M['table']['download'];
                break;
            case 5:
                $moduledb = $_M['table']['img'];
                break;
            case 6:
                $moduledb = $_M['table']['job'];
                break;
            case 100:
                $moduledb = $_M['table']['product'];
                break;
            case 101:
                $moduledb = $_M['table']['img'];
                break;
        }
        return $moduledb;
    }


    //是否是系统模块
    function unkmodule($filename)
    {
        $modfile = array('about', 'news', 'product', 'download', 'img', 'job', 'cache', 'config', 'feedback', 'include', 'lang', 'link', 'member', 'message', 'public', 'search', 'sitemap', 'templates', 'upload', 'wap');
        $ok = 0;
        foreach ($modfile as $key => $val) {
            if ($filename == $val) $ok = 1;
        }
        return $ok;
    }

    //删除文件
    function file_unlink($file_name)
    {
        if (stristr(PHP_OS, "WIN")) {
            $file_name = @iconv("utf-8", "gbk", $file_name);
        }
        if (file_exists($file_name)) {
            $area_lord = @unlink($file_name);
        }
        return $area_lord;
    }

    //删除目录和其下所有文件
    function deldir($dir, $dk = 1)
    {
        $dh = opendir($dir);
        while ($file = readdir($dh)) {
            if ($file != "." && $file != "..") {
                $fullpath = $dir . "/" . $file;
                if (!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    deldir($fullpath);
                }
            }
        }
        closedir($dh);
        if ($dk == 0 && $dir != PATH_WEB . 'upload') $dk = 1;
        if ($dk == 1) {
            if (rmdir($dir)) {
                return true;
            } else {
                return false;
            }
        }
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
