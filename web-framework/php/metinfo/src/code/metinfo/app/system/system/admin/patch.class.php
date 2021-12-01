<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

load::sys_class('admin');
load::sys_func('file');
load::sys_func('array');

class patch extends admin
{
    public function dopatch()
    {
        global $_M;
        $curl = load::sys_class('curl', 'new');
        $curl->set('file', '?n=platform&c=system&a=dopatch');
        $post_data = array('cmsver' => $_M['config']['metcms_v'], 'patch' => $_M['config']['met_patch']);
        $difilelist = $curl->curl_post($post_data, 10);
        $difilelists = stringto_array($difilelist, '|', '*', ':');
        if ($difilelists[0][0][0] == 'suc') {
            foreach ($difilelists[1] as $keylist => $vallist) {
                $met_patch = $vallist[0];
                unset($vallist[0]);
                foreach ($vallist as $key => $val) {
                    $dlfile = load::sys_class('dlfile', 'new');
                    $copydir = str_replace(':/admin/', ':/' . $_M['config']['met_adminfile'] . '/', ':/' . $val);
                    $copydir = str_replace(':/', '', $copydir);
                    $re = $dlfile->dlfile('file/v' . $_M['config']['metcms_v'] . '/file/' . $val, PATH_WEB . $copydir, 'metcms');
                    if ($re != 1) {
                        break;
                    }
                }
                $update_file = PATH_WEB . "{$_M['config'][met_adminfile]}/update/patch/v{$_M['config']['metcms_v']}_{$met_patch}.class.php";
                if (file_exists($update_file)) {
                    require_once $update_file;
                }
                @unlink($update_file);
                $query = "update {$_M['table']['config']} set value='{$met_patch}' where name='met_patch'";
                DB::query($query);
            }
            echo 1;
        } else {
            echo 2;
        }
        die();
    }

    public function docheckEnv()
    {
        global $_M;
        $handle = load::sys_class('handle', 'new');
        $data = array(
            'data' => $handle->checkFunction(),
            'dirs' => $handle->checkDirs()
        );
        return $data;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>