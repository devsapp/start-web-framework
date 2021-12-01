<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

load::sys_class('para');
 
class sys_para extends para
{
    public $table;

    public function json_para_list($where, $order, $module)
    {
        global $_M;
        $this->table = load::sys_class('tabledata', 'new');
        $where = "lang='{$_M['lang']}' and module = '{$module}' {$where}";
        $data = $this->table->getdata($_M['table']['parameter'], '*', $where, $order);
        foreach ($data as $key => $val) {
            $val['id_html'] = "<input name=\"id\" type=\"checkbox\" value=\"{$val[id]}\">";
            $val['no_order_html'] = "<input type=\"text\" name=\"no_order-{$val[id]}\" data-required=\"1\" class=\"ui-input met-center\" value=\"{$val['no_order']}\">";
            $val['name_html'] = "<input type=\"text\" name=\"name-{$val[id]}\" data-required=\"1\" class=\"ui-input listname\" value=\"{$val['name']}\">";
            $val['paratype_html'] = $this->para_type($val['id'], $val['type']);
            $val['wr_oks_html'] = "<input name=\"wr_oks-{$val[id]}\" type=\"checkbox\" data-checked=\"{$val['wr_oks']}\" value=\"1\">";
            $val['wr_ok_html'] = "<input name=\"wr_ok-{$val[id]}\" type=\"checkbox\" data-checked=\"{$val['wr_ok']}\" value=\"1\">";
            $val['description_html'] = "<input type=\"text\" name=\"description-{$val[id]}\" class=\"ui-input listname\" value=\"{$val[description]}\">";
            $none = $val['type'] == 2 || $val['type'] == 4 || $val['type'] == 6 ? '' : ' none';
            $val['options_html'] = "<button type=\"button\" class=\"btn btn-info{$none} paraoption\" data-id=\"{$val[id]}\">设置选项</button><input name=\"options-{$val[id]}\" type=\"hidden\" value=\"{$val['options']}\">";
            $datas[] = $val;
        }
        return $datas;
    }

    public function json_return($data)
    {
        global $_M;
        $this->table->rdata($data);
    }

    public function table_para($form, $module)
    {
        global $_M;
        $list = explode(",", $form['allid']);
        foreach ($list as $id) {
            if ($id) {
                if ($form['submit_type'] == 'save') {
                    if ($form['class-' . $id]) {
                        $class = explode("-", $form['class-' . $id]);
                        $list['class1'] = $class[0];
                        $list['class2'] = $class[1];
                        $list['class3'] = $class[2];
                    }
                    $list['no_order'] = $form['no_order-' . $id];
                    $list['name'] = $form['name-' . $id];
                    $list['type'] = $form['type-' . $id];
                    $list['wr_oks'] = $form['wr_oks-' . $id];
                    $list['wr_ok'] = $form['wr_ok-' . $id];
                    $list['description'] = $form['description-' . $id];
                    $list['options'] = $list['type'] == 2 || $list['type'] == 4 || $list['type'] == 6 ? $form['options-' . $id] : '';
                    $list['module'] = $module;
                    $list['access'] = $form['access-' . $id];
                    if (is_number($id)) {
                        $this->update_para_list($id, $list, $module);
                    } else {
                        $this->insert_para_list($list, $module);
                    }
                } elseif ($form['submit_type'] == 'del') {
                    if (is_number($id)) {
                        $this->del_para_list($id, $module);
                    }
                }
            }
        }
        return true;
    }

    public function update_para_list($id, $field, $module)
    {
        global $_M;
        if ($field['name']) {
            $query = "UPDATE {$_M['table']['parameter']} SET 
				no_order	= '{$field['no_order']}',
				name 		= '{$field['name']}',
				type 		= '{$field['type']}',
				wr_oks 		= '{$field['wr_oks']}',
				wr_ok 		= '{$field['wr_ok']}',
				description = '{$field['description']}',
				options 	= '{$field['options']}',
				module 		= '{$field['module']}',
				class1 		= '{$field['class1']}',
				class2 		= '{$field['class2']}',
				class3 		= '{$field['class3']}',
				access 		= '{$field['access']}'
				WHERE id 	= '{$id}'
			";
            DB::query($query);
            cache::del("para/paralist_{$module}_{$this->lang}");
        }
    }

    public function insert_para_list($field, $module)
    {
        global $_M;
        if ($field['name']) {
            $query = "INSERT INTO {$_M['table']['parameter']} SET 
				no_order	= '{$field['no_order']}',
				name 		= '{$field['name']}',
				type 		= '{$field['type']}',
				wr_oks 		= '{$field['wr_oks']}',
				wr_ok 		= '{$field['wr_ok']}',
				description = '{$field['description']}',
				options 	= '{$field['options']}',
				module 		= '{$field['module']}',
				class1 		= '{$field['class1']}',
				class2 		= '{$field['class2']}',
				class3 		= '{$field['class3']}',
				access 		= '{$field['access']}',
				lang 		= '{$_M[lang]}'
			";
            DB::query($query);
            cache::del("para/paralist_{$module}_{$this->lang}");
        }
    }

    public function del_para_list($id, $module)
    {
        global $_M;
        if (is_number($id)) {
            $query = "DELETE FROM {$_M['table']['parameter']} WHERE id='{$id}'";
            DB::query($query);
            $query = "DELETE FROM {$this->table($module)} WHERE paraid='{$id}'";
            DB::query($query);
            cache::del("para/paralist_{$module}_{$this->lang}");
        }
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>