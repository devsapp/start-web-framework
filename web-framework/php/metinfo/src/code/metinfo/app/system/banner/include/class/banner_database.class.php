<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * 系统标签类
 */

class  banner_database
{

    public $banner_config_array;//banner配置数组

    /**
     * 对banner/config数组进行处理
     * @param  string $id 语言
     * @return array        配置数组
     */
    public function banner_config_handle($config)
    {
        $falshval = array();
        if ($config['flashid']) {
            $config['value'] = explode('|', $config['value']);
            $falshval['type'] = $config['value'][0];
            $falshval['x'] = $config['value'][1];
            $falshval['y'] = $config['value'][2];
            $falshval['imgtype'] = $config['value'][3];
            $config['mobile_value'] = explode('|', $config['mobile_value']);
            $falshval['wap_type'] = $config['mobile_value'][0];
            $falshval['wap_y'] = $config['mobile_value'][1];
        }
        return $falshval;
    }

    /**
     * 获取banner栏目配置数据
     * @param  string $lang 语言
     * @return array          配置数组
     */
    public function get_banner_config_by_lang($lang)
    {
        global $_M;
        if (!$this->banner_config_array[$lang]) {
            $query = "SELECT * FROM {$_M['table']['config']} WHERE lang='{$lang}'";
            $c = DB::get_all($query);
            foreach ($c as $key => $val) {
                if ($val['flashid']) {
                    $this->banner_config_array[$lang][$val['flashid']] = $this->banner_config_handle($val);
                }
            }
        }
        return $this->banner_config_array[$lang];
    }

    /**
     * 获取banner图片栏目设置数据
     * @param  string $lang 语言
     * @return array          图片配置数组
     */
    public function get_banner_img_by_lang($lang)
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['flash']} WHERE lang = '{$lang}'";
        return DB::get_all($query);
    }

    /**
     * 获取指定栏目banner配置数据
     * @param  string $id 语言
     * @return array        配置数组
     */
    public function get_banner_config_by_column($id)
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['config']} WHERE flashid =' {$id}'";
        return $this->banner_config_handle(DB::get_one($query));
    }

    /**
     * 获取指定栏目banner图片数据
     * @param  string $id 语言
     * @return array        配置数组
     */
    public function get_banner_img_by_column($id, $lang)
    {
        global $_M;
        if ($_M['config']['inwap']) {
            $sql = "AND wap_ok = 1";
        } else {
            $sql = "AND wap_ok = 0";
        }
        $query = "SELECT * FROM {$_M['table']['flash']} WHERE (module LIKE '%,{$id},%' OR module = 'metinfo' ) AND lang = '{$lang}' {$sql} ORDER BY no_order ASC, id DESC";
        return DB::get_all($query);
    }

    public function update_by_id($list)
    {
        global $_M;
        $sql = '';
        foreach ($list as $key => $value) {
            if ($key != 'id') {
                $sql .= "{$key}={$value},";
            }
        }
        $sql = trim($sql, ',');
        $query = "UPDATE {$_M['table']['flash']} SET {$sql} WHERE id='{$list['id']}'";
        return DB::query($query);
    }

    public function del_by_id($id)
    {
        global $_M;
        $query = "DELETE FROM {$_M['table']['flash']} WHERE id = '{$id}'";
        return DB::query($query);
    }

    public function update_flash_by_cid($cid, $lang)
    {
        global $_M;
        $query = "SELECT id,module FROM {$_M['table']['flash']} WHERE module like '%,{$cid},%' AND lang = '{$lang}'";
        $flash = DB::get_all($query);
        foreach ($flash as $f) {
            $new_module = str_replace(",{$cid},", ',', $f['module']);
            $query = "UPDATE {$_M['table']['flash']} SET module = '{$new_module}' WHERE id = {$f['id']}";
            DB::query($query);
        }
    }

    public function table_para()
    {
        return 'id|module|img_title|img_path|img_link|flash_path|flash_back|no_order|width|height|wap_ok|img_title_color|img_des|img_des_color|img_text_position|img_title_fontsize|img_des_fontsize|height_m|height_t|mobile_img_path|img_title_mobile|img_title_color_mobile|img_text_position_mobile|img_title_fontsize_mobile|img_des_mobile|img_des_color_mobile|img_des_fontsize_mobile|lang|target';
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
