<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

class base_op
{
    public $database;

    /**
     * 初始化
     */
    public function __construct()
    {
        global $_M;
    }

    /**
     * 获取栏目列表内容
     * @param $class1
     * @param $class2
     * @param $class3
     * @return mixed
     */
    public function get_contents_list($class1, $class2, $class3)
    {
        global $_M;
        return $this->database->get_list_by_class123($class1, $class2, $class3);
    }

    /**
     * 删除栏目列表内容
     * @param string $classnow
     * @return bool
     */
    public function del_by_class($classnow = '')
    {
        global $_M;
        $class123 = load::sys_class('label', 'new')->get('column')->get_class123_no_reclass($classnow);
        $this->database->del_list_by_class123($class123['class1']['id'], $class123['class2']['id'], $class123['class3']['id']);
        return true;
    }

    /**
     * 更新内容权限
     * @param string $access
     * @param int $class1
     * @param int $class2
     * @param int $class3
     * @return mixed
     */
    public function access_motify($id = '', $access = 0)
    {
        global $_M;
        if ($id && is_numeric($id)) {
            $data['id'] = $id;
            $data['access'] = $access;

            return $this->database->update_by_id($data);
        }
    }

    /**
     * 移动栏目列表内容
     * @param $nowclass1
     * @param $nowclass2
     * @param $nowclass3
     * @param $toclass1
     * @param $toclass2
     * @param $toclass3
     * @return mixed
     */
    public function list_move($nowclass1 = '', $nowclass2 = '', $nowclass3 = '', $toclass1 ='', $toclass2 ='', $toclass3 = '')
    {
        global $_M;
        return $this->database->move_list_by_class($nowclass1, $nowclass2, $nowclass3, $toclass1, $toclass2, $toclass3);
    }

    /**
     * 复制栏目列表内容
     * @param string $classnow
     * @param string $toclass1
     * @param string $toclass2
     * @param string $toclass3
     * @param string $tolang
     * @param array $paras
     * @return mixed
     */
    public function list_copy($classnow = '', $toclass1 = '', $toclass2 = '', $toclass3 = '', $tolang = '', $paras = array())
    {
        global $_M;
        $contents = $this->database->get_list_by_class_no_next($classnow);

        foreach ($contents as $list) {
            $id = $list['id'];
            $list['id'] = '';
            $list['filename'] = '';
            $list['class1'] = $toclass1;
            $list['class2'] = $toclass2;
            $list['class3'] = $toclass3;
            $list['updatetime'] = date("Y-m-d H:i:s");
            $list['addtime'] = date("Y-m-d H:i:s");
            $list['content'] = str_replace('\'', '\'\'', $list['content']);
            $list['lang'] = $tolang ? $tolang : $list['lang'];

            $id_array[$id] = $this->database->insert($list);
        }

        return $id_array;
    }

    /**
     * 复制栏目列表内容至新语言
     * @param string $id
     * @param string $toclass1
     * @param string $toclass2
     * @param string $toclass3
     * @param string $tolang
     */
    public function copy_one($id = '', $toclass1 = '', $toclass2 = '', $toclass3 = '', $tolang = '')
    {
        global $_M;
        $content = $this->database->get_list_one_by_id($id);
        if ($content) {
            $content['id'] = '';
            $content['filename'] = '';
            $content['class1'] = $toclass1;
            $content['class2'] = $toclass2;
            $content['class3'] = $toclass3;
            $content['updatetime'] = date("Y-m-d H:i:s");
            $content['addtime'] = date("Y-m-d H:i:s");
            $content['content'] = str_replace('\'', '\'\'', $content['content']);
            $content['lang'] = $tolang ? $tolang : $content['lang'];

            $new_id = $this->database->insert($content);
            return $new_id;
        }
        return false;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
