<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

/**
 * Class cache
 */
class cache
{

    public static function get($file, $type = 'php')
    {

        $dir = PATH_CACHE . $file . '.' . $type;
        if (file_exists($dir)) {
            include $dir;
            if ($cache) {
                return $cache;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public static function put($file, $data, $type = 'php')
    {
        global $_M;

        load::sys_func('file');
        $save = PATH_CACHE . $file . '.' . $type;
        makefile($save);
        #$data = str_replace(array("\"", "\\"), array("\\\"", "\\\\"), $data);
        if (!is_array($data)) {
            file_put_contents($save, "<?php\ndefined('IN_MET') or exit('No permission');\n\$cache=\"{$data}\";\n?>");
        } else {
            $info = var_export($data, true);
            $info = "<?php\ndefined('IN_MET') or exit('No permission');\n\$cache = {$info};\n?>";
            file_put_contents($save, $info);
        }
    }

    public static function del($file, $type = 'php')
    {
        load::sys_func('file');
        if ($type == 'file') {
            @deldir(PATH_CACHE . $file);
        } else {
            @unlink(PATH_CACHE . $file . '.' . $type);
        }
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>