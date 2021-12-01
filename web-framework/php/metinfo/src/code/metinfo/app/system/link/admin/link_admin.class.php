<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');
load::sys_class('admin');

/** 友情链接 */
class link_admin extends admin
{
    public $module;
    public $lang;

    public function __construct()
    {
        global $_M;
        parent::__construct();
        $this->lang = $_M['lang'];
        $this->module = 9;
    }

    public function doGetColumnList()
    {
        global $_M;
        $array = load::mod_class('column/column_op', 'new')->get_sorting_by_lv();
        $class1 = $array['class1'];
        $class2 = $array['class2'];
        $class3 = $array['class3'];

        $columnlist = array();
        //首页
        $index = array(
            'id' => 10001,
            'name' => $_M['word']['homepage']
        );
        $columnlist[] = $index;

        foreach ($class1 as $key => $col1) {
            if ($class2[$col1['id']]) {
                foreach ($class2[$col1['id']] as $key2 => $col2) {
                    if ($class3[$col2['id']]) {
                        foreach ($class3[$col2['id']] as $key3 => $col3) {
                            $col2['subcolumn'][$key3] = $col3;
                        }
                    }
                    $col1['subcolumn'][$key2] = $col2;
                }
            }
            $columnlist[] = $col1;
        }

        $data = array();
        $data['columnlist'] = $columnlist;
        return $data;
    }

    //获取友情链接列表
    public function doGetList()
    {
        global $_M;

        $where = "lang='{$this->lang}'";
        $keyword = isset($_M['form']['keyword']) ? $_M['form']['keyword'] : '';
        $where .= $keyword ? "and webname like '%{$keyword}%'" : '';
        $id = isset($_M['form']['id']) ? $_M['form']['id'] : '';
        if ($id) {
            $where .= " AND id='{$id}' ";
        }

        $search_type = isset($_M['form']['search_type']) ? $_M['form']['search_type'] : '';
        switch ($search_type) {
            case 1:
                $where .= "and show_ok = '0'";
                break;
            case 2:
                $where .= "and com_ok = '1'";
                break;
            case 3:
                $where .= "and link_type ='0'";
                break;
            case 4:
                $where .= "and link_type ='1'";
                break;
        }
        $table = load::sys_class('tabledata', 'new');
        $group_data = $table->getdata($_M['table']['link'], '*', $where, 'orderno DESC');

        foreach ($group_data as $key => $value) {
            $module = trim($value['module'], ',');
            $group_data[$key]['module'] = explode(',', $module);
            $group_data[$key]['file'] = $value['weblogo'];
        }

        $table->rdata($group_data);
    }

    //添加/修改友情链接
    public function doSaveLink()
    {
        global $_M;
        $data = $_M['form'];
        $data['addtime'] = date('Y-m-d H:i:s');
        $data['webname'] = isset($data['webname']) ? $data['webname'] : '';
        $data['weburl'] = isset($data['weburl']) ? $data['weburl'] : '';
        $data['weblogo'] = isset($data['file']) ? $data['file'] : '';
        $data['link_type'] = isset($data['link_type']) ? $data['link_type'] : '';
        $data['info'] = isset($data['info']) ? $data['info'] : '';
        $data['contact'] = isset($data['contact']) ? $data['contact'] : '';
        $data['orderno'] = isset($data['orderno']) ? $data['orderno'] : 0;
        $data['com_ok'] = isset($data['com_ok']) ? $data['com_ok'] : 0;
        $data['show_ok'] = isset($data['show_ok']) ? $data['show_ok'] : 0;
        $data['nofollow'] = isset($data['nofollow']) ? $data['nofollow'] : '';
        $data['module'] = isset($data['module']) ? ',' . $data['module'] . ',' : '';

        if (!$data['webname'] || !$data['weburl'] || !$data['info']) {
            $this->error($_M['word']['jsx10']);
        }

        $data['lang'] = $this->lang;
        if (!$data['id']) {
            $save_data = array();
            $save_data['webname'] = $data['webname'];
            $save_data['weburl'] = $data['weburl'];
            $save_data['weblogo'] = $data['weblogo'];
            $save_data['link_type'] = $data['link_type'];
            $save_data['info'] = $data['info'];
            $save_data['contact'] = $data['contact'];
            $save_data['orderno'] = $data['orderno'];
            $save_data['com_ok'] = $data['com_ok'];
            $save_data['show_ok'] = $data['show_ok'];
            $save_data['addtime'] = $data['addtime'];
            $save_data['nofollow'] = $data['nofollow'];
            $save_data['module'] = $data['module'];
            $save_data['lang'] = $data['lang'];
            $result = DB::insert($_M['table']['link'], $save_data);
            $log_name = 'addinfo';
        } else {
            $query = "UPDATE {$_M['table']['link']} SET 
							webname = '{$data['webname']}',
							weburl = '{$data['weburl']}',
							weblogo = '{$data['weblogo']}',
							link_type = '{$data['link_type']}',
							info = '{$data['info']}',
							contact = '{$data['contact']}',
							orderno = '{$data['orderno']}',
							com_ok = '{$data['com_ok']}',
							show_ok = '{$data['show_ok']}',
							addtime = '{$data['addtime']}',
							nofollow = '{$data['nofollow']}',
							module = '{$data['module']}'
							WHERE id = '{$data['id']}'";
            $result = DB::query($query);
            $log_name = 'submit';
        }

        if (!$result) {
            //写日志
            logs::addAdminLog('indexlink', $log_name, 'dataerror', 'doSaveLink');
            $this->error($_M['word']['dataerror']);
        }

        //写日志
        logs::addAdminLog('indexlink', $log_name, 'jsok', 'doSaveLink');
        $this->success('', $_M['word']['jsok']);
    }

    //删除
    public function doDelLinks()
    {
        global $_M;
        $data = $_M['form']['allid']?explode(',', $_M['form']['allid']):$_M['form']['id'];
        if(!is_array($data)){
            $data=array($data);
        }
        if (!$data) {
            $this->error();
        }

        foreach ($data as $value) {
            $query = "DELETE FROM {$_M['table']['link']} WHERE id='{$value}' AND lang='{$_M['lang']}'";
            DB::query($query);
        }
        //写日志
        logs::addAdminLog('indexlink', 'delete', 'jsok', 'doDelLinks');
        $this->success('', $_M['word']['jsok']);
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
