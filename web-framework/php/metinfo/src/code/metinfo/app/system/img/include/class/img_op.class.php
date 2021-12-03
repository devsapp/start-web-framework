<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('base/base_op');

class img_op extends base_op
{
    public function __construct()
    {
        global $_M;
        $this->database = load::mod_class('img/img_database', 'new');
    }

    /**
     * 复制栏目列表内容至新语言
     * @param string $classnow
     * @param string $toclass1
     * @param string $toclass2
     * @param string $toclass3
     * @param string $tolang
     * @param array $paras
     */
    public function list_copy($classnow = '', $toclass1 = '', $toclass2 = '', $toclass3 = '', $tolang = '', $paras = array())
    {
        global $_M;
        $ids = parent::list_copy($classnow, $toclass1, $toclass2, $toclass3, $tolang, $paras);

        //内容属性
        $class123 = load::sys_class('label', 'new')->get('column')->get_class123_no_reclass($classnow);
        if ($paras) {
            foreach ($ids as $idkey => $idval) {
                foreach ($paras as $pkey => $pval) {
                    load::mod_class('parameter/parameter_op', 'new')->copy_para_list($class123['class1']['module'], $idkey, $pkey, $idval, $pval, $tolang);
                }
            }
        }
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>

