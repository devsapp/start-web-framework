<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('web');

class hits extends web
{

    public function __construct()
    {
        global $_M;
        parent::__construct();
    }

    public function dohits()
    {
        global $_M;

        if (!is_numeric($_M['form']['vid'])) {
            return '';
        }

        switch ($_M['form']['type']) {
            case 'product':
                $met_hits = 'product';
                break;
            case 'news':
                $met_hits = 'news';
                break;
            case 'download':
                $met_hits = 'download';
                break;
            case 'img':
                $met_hits = 'img';
                break;
            default :
                $met_hits = '';
                break;
        }

        $query = "select id,hits from {$_M['table'][$met_hits]} where id='{$_M['form']['vid']}'";
        $hits_list = DB::get_one($query);
        if (!$_M['form']['list']) {
            $hits_list['hits']++;

            $query = "update {$_M['table'][$met_hits]} SET hits='$hits_list[hits]' where id='{$_M['form']['vid']}'";
            DB::query($query);
        }
        if ($_M['form']['ajax']) {
            echo $hits_list['hits'];
            die;
        } else {
            echo "document.write('" . $hits_list['hits'] . "')";
            die;
        }

    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
