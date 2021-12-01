<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');
load::sys_func('file');
/**
 * 栏目标签类
 */

class column_op
{

    /**
     * 初始化
     */
    public function __construct()
    {
        global $_M;
        $this->lang = $_M['lang'];
    }

    /**
     * 对当前管理员有权限操作的栏目信息进行整理；
     * @param  int $type 1；按模块生成;2：按栏目生成
     * @return array  $column  返回把记录当前管理员有权限操作的栏目信息的数组按模块归类或栏目归类整理后的数组
     */
    public function get_sorting_by_lv($power = 1, $lang = '')
    {
        global $_M;
        $information = load::mod_class('column/column_database', 'new')->get_all_column_by_lang($lang);
        //$power_admin = background_privilege();
        foreach ($information as $key => $val) {
            if ($power) {
                $class123 = load::sys_class('label', 'new')->get('column')->get_class123_no_reclass($val['id']);
                if (!is_have_power('c' . $class123['class1']['id'])) {
                    continue;
                }
            }
            if ($val['classtype'] == 1) {
                $sorting['class1'][$key] = $information[$key];
            }
            if ($val['classtype'] == 2) {
                $sorting['class2'][$val['bigclass']][$key] = $information[$key];
            }
            if ($val['classtype'] == 3) {
                $sorting['class3'][$val['bigclass']][$key] = $information[$key];
            }
        }
        return $sorting;
    }

    public function get_lv_array($power = 1, $lang = '')
    {
        global $_M;
        $information = load::mod_class('column/column_database', 'new')->get_all_column_by_lang($lang);
        //$power_admin = background_privilege();
        foreach ($information as $key => $val) {
            if ($power) {
                $class123 = load::sys_class('label', 'new')->get('column')->get_class123_no_reclass($val['id']);
                if (!is_have_power('c' . $class123['class1']['id'])) {
                    continue;
                }
            }
            if ($val['classtype'] == 1) {
                $sorting[0] = $information[$key];
            }
            if ($val['classtype'] == 2) {
                $sorting[$val['bigclass']][$key] = $information[$key];
            }
            if ($val['classtype'] == 3) {
                $sorting[$val['bigclass']][$key] = $information[$key];
            }
        }
        return $sorting;
    }

    /**
     * 对当前管理员有权限操作的栏目信息进行整理；
     * @param  int $type 1；按模块生成;2：按栏目生成
     * @return array  $column  返回把记录当前管理员有权限操作的栏目信息的数组按模块归类或栏目归类整理后的数组
     */
    public function get_sorting_by_module($power = true, $lang = '')
    {
        global $_M;
        $information = load::mod_class('column/column_database', 'new')->get_all_column_by_lang($lang);
        //$power_admin = background_privilege();
        foreach ($information as $key => $val) {
            if ($power) {
                $class123 = load::sys_class('label', 'new')->get('column')->get_class123_no_reclass($val['id']);
                if (!is_have_power('c' . $class123['class1']['id'])) {
                    continue;
                }
            }
            if ($val['releclass'] != 0) {
                $sorting[$val['module']]['class1'][$key] = $information[$key];
                $column_classtype[] = $val['id'];
            } else {
                if ($val['classtype'] == 1) {
                    $sorting[$val['module']]['class1'][$key] = $information[$key];
                }
                if ($val['classtype'] == 2) {
                    $sorting[$val['module']]['class2'][$key] = $information[$key];
                }
            }
        }
        foreach ($information as $key => $val) {
            $i = 0;
            if ($val['classtype'] == 3) {
                foreach ($column_classtype as $key1 => $val1) {
                    if ($val['bigclass'] == $val1) {
                        $i = 1;
                    }
                }
                if ($i == 1) {
                    $sorting[$val['module']]['class2'][$key] = $information[$key];
                } else {
                    $sorting[$val['module']]['class3'][$key] = $information[$key];
                }
            }
        }
        return $sorting;
    }

    /**
     * 栏目复制
     * @param string $id 要复制的栏目ID
     * @param string $to_lang 复制到的目标语言
     * @param int $is_contents 是否复制内容
     * @param array $allids 所有需要复制的栏目ID（判断子栏目复制与否）
     * @return bool
     */
    public function copy_column($id = '', $local_lang ='', $to_lang = '', $is_contents = 0, $allids = array())
    {
        global $_M;
        if (!$id || !$allids) {
            return false;
        }

        $c = load::sys_class('label', 'new')->get('column')->get_column_id($id);
        if (!$to_lang) {
            $to_lang = $c['lang'];
        }
        if ($c['classtype'] != 1) return false;
        $class1 = $this->in_column($c['id'], 0, $local_lang, $to_lang, $is_contents);

        $module = load::sys_class('handle', 'new')->mod_to_file($c['module']);
        if ($class1) {

            if ($is_contents == 1) {
                //复制全局栏目属性
                $para_class0 = load::mod_class('parameter/parameter_op', 'new')->copy_parameter($id, 0, 0, 0, $to_lang);
            }
            $para_class1 = $this->copy_para($id, $c['module'], $c['module'], $class1, 0, 0, $to_lang, $is_contents);
            $this->copy_content($id, $c['module'], $c['module'], $class1, 0, 0, $to_lang, $is_contents, (array)$para_class0 + (array)$para_class1);

            $son_class2 = load::sys_class('label', 'new')->get('column')->get_column_son($c['id']);
            foreach ($son_class2 as $val2) {
                if (in_array($val2['id'], $allids)) {
                    $val_class2 = $this->in_column($val2['id'], $class1, $local_lang, $to_lang, $is_contents);
                    $para_class2 = $this->copy_para($val2['id'], $c['module'], $val2['module'], $class1, $val_class2, 0, $to_lang, $is_contents);
                    $this->copy_content($val2['id'], $c['module'], $val2['module'], $class1, $val_class2, 0, $to_lang, $is_contents, (array)$para_class0 + (array)$para_class1 + (array)$para_class2);

                    $val_son_class3 = load::sys_class('label', 'new')->get('column')->get_column_son($val2['id']);
                    foreach ($val_son_class3 as $val3) {
                        if (in_array($val3['id'], $allids)) {
                            $val_class3 = $this->in_column($val3['id'], $val_class2, $local_lang, $to_lang, $is_contents);
                            $para_class3 = $this->copy_para($val3['id'], $c['module'], $val3['module'], $class1, $val_class2, $val_class3, $to_lang, $is_contents);
                            $this->copy_content($val3['id'], $c['module'], $val3['module'], $class1, $val_class2, $val_class3, $to_lang, $is_contents, (array)$para_class0 + (array)$para_class1 + (array)$para_class2 + (array)$para_class3);
                        }
                    }
                }
            }
        }
        return true;
    }

    /**
     * 复制栏目下内容；
     */
    public function copy_content($column_id, $class1_module, $classnow_module, $toclass1, $toclass2, $toclass3, $to_lang, $is_contents = 0, $paras = array())
    {
        if ($classnow_module >= 2 && $classnow_module <= 6 && $is_contents == 1) {
            if ($class1_module != $classnow_module) {
                $toclass1 = $toclass2;
                $toclass2 = $toclass3;
                $toclass3 = 0;
            }
            $name = load::sys_class('handle', 'new')->mod_to_file($classnow_module);
            $mod_op = load::mod_class("{$name}/{$name}_op", 'new');
            if (method_exists($mod_op, 'list_copy')) {
                $mod_op->list_copy($column_id, $toclass1, $toclass2, $toclass3, $to_lang, $paras);
            }
        }
        return true;
    }

    /**
     * 插入栏目；
     */
    public function in_column($id = '', $bigclass = '', $local_lang = '', $tolang = '', $is_contents = '')
    {
        $infos = load::mod_class('column/column_database', 'new')->get_column_by_id($id, $local_lang);
        if (!$bigclass) $bigclass = 0;
        if ($infos['id']) {
            $classnow = $infos['id'];
            unset($infos['id']);
            $infos['bigclass'] = $bigclass;
            if ($infos['releclass']) {
                $infos['bigclass'] = $bigclass;
            }
            $infos['filename'] = '';
            $infos['lang'] = $tolang;
            $toclass = load::mod_class('column/column_database', 'new')->insert($infos);
            if ($infos['module'] == 6 || $infos['module'] == 7 || $infos['module'] == 8) {
                load::mod_class('config/config_op', 'new')->copy_column_config($classnow, $toclass, $tolang);
            }
            return $toclass;
        } else {
            return false;
        }
    }

    /**
     * 复制栏目下内容；
     */
    public function copy_para($column_id, $class1_module, $classnow_module, $toclass1, $toclass2, $toclass3, $to_lang, $is_contents = 0)
    {
        if ($is_contents == 0) {
            return;
        }
        if ($class1_module != $classnow_module) {
            $toclass1 = $toclass2;
            $toclass2 = $toclass3;
            $toclass3 = 0;
        }
        if ($classnow_module >= 2 && $classnow_module <= 5) {
            //新闻 产品 图片 下载
            $paras = load::mod_class('parameter/parameter_op', 'new')->copy_parameter($column_id, $toclass1, $toclass2, $toclass3, $to_lang);
        } else if ($classnow_module == 6) {
            //招聘
            $paras = load::mod_class('parameter/parameter_op', 'new')->copy_parameter($column_id, $toclass1, $toclass2, $toclass3, $to_lang);
        } else if ($classnow_module == 7 || $classnow_module == 8) {
            //留言 反馈
            $paras = load::mod_class('parameter/parameter_op', 'new')->copy_parameter($column_id, $toclass1, $toclass2, $toclass3, $to_lang);
        }
        return $paras;
    }

    /**
     * 恢复栏目文件
     * @param $foldername
     * @param $module
     * @param $id\
     */
    public function do_recover_column_files($type = 0)
    {
        global $_M;
        $default_module = Array('app', 'admin', 'about', 'news', 'product', 'download', 'img', 'job', 'cache', 'config', 'install', 'feedback', 'include', 'lang', 'link', 'member', 'message', 'public', 'search', 'sitemap', 'templates', 'upload', 'wap', 'online', 'hits', 'shop', 'pay', '');
        $modulenum = Array(1, 2, 3, 4, 5, 8, 0);

        $query = "SELECT `foldername`,`module`,`id` FROM {$_M['table']['column']}";
        $columnarr = DB::get_all($query);

        foreach ($columnarr as $row) {
            if (!in_array($row['foldername'], $default_module) && in_array($row['module'], $modulenum)) {

                if (!file_exists(PATH_WEB . "{$row['foldername']}/index.php") || $type) {

                    $this->columnCopyconfig($row['foldername'], $row['module'], $row['id'], $type);

                }
            }
        }

        /*if(!in_array($foldername,$default_module) && in_array($module,$modulenum)){
            if(is_dir(PATH_WEB."$foldername") && !file_exists(PATH_WEB."$foldername/index.php")){
                $this->columnCopyconfig($foldername, $module, $id);
            }
        }*/
    }

    public function Copyfile($address, $newfile, $type = 0)
    {
        $oldcont = "<?php\n# MetInfo Enterprise Content Management System \n# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. \nrequire_once '$address';\n# This program is an open source system, commercial use, please consciously to purchase commercial license.\n# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.\n?>";
        $filename = str_replace(PATH_WEB, '', $newfile);
        $filename = preg_replace("/\/\w+\.php/", '', $filename);
        if ((!file_exists($newfile) && !$this->unkmodule($filename)) || $type) {
            makefile($newfile);
            return file_put_contents($newfile, $oldcont);
        }
    }


    /*是否是系统模块*/
    public function unkmodule($filename)
    {
        $modfile = array('app', 'admin', 'about', 'news', 'product', 'download', 'img', 'job', 'cache', 'config', 'feedback', 'include', 'lang', 'link', 'member', 'message', 'public', 'search', 'sitemap', 'templates', 'upload', 'wap', 'online');
        $ok = 0;
        foreach ($modfile as $key => $val) {
            if ($filename == $val) {
                $ok = 1;
            }
        }
        return $ok;
    }

    public function columnCopyconfig($foldername, $module, $id, $type = 0)
    {
        global $_M;

        if (!$foldername) return false;

        switch ($module) {
            case 1:
                $indexaddress = "../about/index.php";
                $newfile = PATH_WEB . $foldername . "/show.php";
                $address = "../about/show.php";
                $this->Copyfile($address, $newfile, $type);
                break;
            case 2:
                $indexaddress = "../news/index.php";
                $newfile = PATH_WEB . $foldername . "/news.php";
                $address = "../news/news.php";

                $this->Copyfile($address, $newfile, $type);
                $newfile = PATH_WEB . $foldername . "/shownews.php";
                $address = "../news/shownews.php";
                $this->Copyfile($address, $newfile, $type);
                break;
            case 3:
                $indexaddress = "../product/index.php";
                $newfile = PATH_WEB . $foldername . "/product.php";
                $address = "../product/product.php";
                $this->Copyfile($address, $newfile, $type);
                $newfile = PATH_WEB . $foldername . "/showproduct.php";
                $address = "../product/showproduct.php";
                $this->Copyfile($address, $newfile, $type);
                break;
            case 4:
                $indexaddress = "../download/index.php";
                $newfile = PATH_WEB . $foldername . "/download.php";
                $address = "../download/download.php";
                $this->Copyfile($address, $newfile, $type);
                $newfile = PATH_WEB . $foldername . "/showdownload.php";
                $address = "../download/showdownload.php";
                $this->Copyfile($address, $newfile, $type);
                // $newfile = PATH_WEB . $foldername . "/down.php";
                // $address = "../download/down.php";
                // $this->Copyfile($address, $newfile,$type);
                break;
            case 5:
                $indexaddress = "../img/index.php";
                $newfile = PATH_WEB . $foldername . "/img.php";
                $address = "../img/img.php";
                $this->Copyfile($address, $newfile, $type);
                $newfile = PATH_WEB . $foldername . "/showimg.php";
                $address = "../img/showimg.php";
                $this->Copyfile($address, $newfile, $type);
                break;
            case 8:
                $indexaddress = "../feedback/index.php";
                $newfile = PATH_WEB . $foldername . "/feedback.php";
                $address = "../feedback/feedback.php";
                $this->Copyfile($address, $newfile, $type);
                break;
        }
        $this->Copyfile($indexaddress, PATH_WEB . $foldername . '/index.php', $type);
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.;
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
