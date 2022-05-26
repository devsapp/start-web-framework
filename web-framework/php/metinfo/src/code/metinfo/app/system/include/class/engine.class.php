<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');


/**
 * 系统标签类
 */
 class engine
 {
     public function __construct()
     {
         global $_M;
         define("TEMP_CACHE_PATH", PATH_WEB . 'cache/templates');

         define("PATH_TEM", PATH_WEB . 'templates/' . $_M['config']['met_skin_user'] . '/');
         load::sys_class('view/met_view');
     }


     public function dodisplay($file, $mod = array())
     {
         global $_M;
         $view = new met_view();

         $view->assign('data', $mod);

         $view->display($file);

         return $view->compileFile;
     }

     public function dofetch($file, $mod = array())
     {
         global $_M;
         $view = new met_view();
         $view->assign('data', $mod);
         $content = $view->fetch($file);
         return $content;
     }
 }

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
