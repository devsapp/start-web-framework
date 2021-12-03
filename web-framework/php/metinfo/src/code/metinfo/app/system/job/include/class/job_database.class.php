<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('base/base_database');

/**
 * 招聘数据类
 */
class  job_database extends base_database
{

    public function __construct()
    {
        global $_M;
        $this->construct($_M['table']['job']);
    }

    public function table_para()
    {
        return 'id|position|count|place|deal|class1|class2|class3|addtime|updatetime|useful_life|content|access|no_order|wap_ok|top_ok|email|filename|lang|displaytype|text_size|text_color';
    }

    public function get_list_by_class_sql($id = '', $type = '', $order = '')
    {
        global $_M;
        $column = load::sys_class('label', 'new')->get('column');
        $sql = '';

        if ($_M['form']['classnow']) {
            $class = $column->get_class123_reclass($_M['form']['classnow']);
            if ($class['class1']) {
                $sql .= " AND class1 = {$class['class1']['id']} ";
            }

            if ($class['class2']) {
                $sql .= " AND class2 = {$class['class2']['id']} ";
            }

            if ($class['class3']) {
                $sql .= " AND class3 = {$class['class3']['id']} ";
            }
        }

        $sql .= "{$this->langsql} AND displaytype = 1 ";

        if (!$_M['config']['sitemap']) {//网站地图生成全部连接
            //内容权限
            if ($_M['config']['access_type'] == 2) {
                $access_res = self::get_access_sql();
                if ($access_res !=='') {
                    $sql .= " AND access IN ({$access_res}) ";
                }
            }
        }

        //自定义条件
        if (is_array($type)) {
            if ($type['type'] == 'array') {
                $serach = '';
                if ($type['title']['status'] && $type['title']['info']) {
                    if ($type['title']['precision']) {
                        $serach .= " OR position = '{$type['title']['info']}' ";
                    } else {
                        $serach .= " OR position like '%{$type['title']['info']}%' ";
                    }
                }
                if ($type['content']['status'] && $type['content']['info']) {
                    if ($type['content']['precision']) {
                        $serach .= " OR content = '{$type['content']['info']}' ";
                    } else {
                        $serach .= " OR content like '%{$type['content']['info']}%' ";
                    }
                }
                if ($serach) {
                    $sql .= "AND ( 1 != 1 {$serach} ) ";
                    $sql = str_replace('1 != 1  OR', '', $sql);
                }
            }elseif($type['type'] == 'tag'){
                $sql = ' 1 != 1 ';
            }
        }

        $class_sum = $column->get_column_son($id);
        $class_sum_first = $class_sum[0];

        if ($class_sum_first) {
            $class_sum123 = $column->get_class123_no_reclass($class_sum_first['id']);
            if ($class_sum123['class1']['id'] && !$_M['form']['searchword']) {//搜索模块的兼容
                $sql .= "AND class1 = '{$class_sum123['class1']['id']}' ";
            }
            if ($class_sum123['class2']['id']) {
                #$sql .= "AND class2 = '{$class_sum123['class2']['id']}' ";
                $sql .= "AND class2 != 0 ";
            }
            if ($class_sum123['class3']['id']) {
                $sql .= "AND class3 = '{$class_sum123['class3']['id']}' ";
            }

            //排序语句
            if ($class_sum123['class1']['id']) {
                $defult_order = $class_sum123['class1']['list_order'];
            }
            if ($class_sum123['class2']['id']) {
                $defult_order = $class_sum123['class2']['list_order'];
            }
            if ($class_sum123['class3']['id']) {
                $defult_order = $class_sum123['class3']['list_order'];
            }
        } else {
            $class123 = $column->get_class123_no_reclass($id);
            if ($class123['class1']['id'] && !$_M['form']['searchword']) {//搜索模块的兼容
                $sql .= "AND class1 = '{$class123['class1']['id']}' ";
            }
            if ($class123['class2']['id']) {
                $sql .= "AND class2 = '{$class123['class2']['id']}' ";
            }
            if ($class123['class3']['id']) {
                $sql .= "AND class3 = '{$class123['class3']['id']}' ";
            }

            //排序语句
            if ($class123['class1']['id']) {
                $defult_order = $class123['class1']['list_order'];
            }
            if ($class123['class2']['id']) {
                $defult_order = $class123['class2']['list_order'];
            }
            if ($class123['class3']['id']) {
                $defult_order = $class123['class3']['list_order'];
            }
        }

        $order_sql = '';
        if (is_array($order)) {
            //自定义条件
            if ($order['type'] == 'array') {
                $order_sql .= $this->get_custom_order($order['status'], $defult_order);
            }
        } else {
            $order = $order ? $order : $defult_order;
            $order_sql .= $this->get_column_order($order);
        }

        $sql .= $order_sql;
        return $sql;
    }

    /**
     * 获取栏目排序URL
     * @param  string $order 排序类型
     * @return string          排序sql
     */
    public function get_column_order($order)
    {
        $order_sql = '';
        switch ($order) {
            case '1':
                $order_sql .= " ORDER BY top_ok DESC, no_order DESC, updatetime DESC, id DESC ";
                break;
            case '2':
                $order_sql .= " ORDER BY top_ok DESC, no_order DESC, addtime DESC, id DESC ";
                break;
            case '3':
                $order_sql .= " ORDER BY top_ok DESC, no_order DESC, id DESC ";
                break;
            case '4':
                $order_sql .= " ORDER BY top_ok DESC, no_order DESC, id DESC ";
                break;
            case '5':
                $order_sql .= " ORDER BY top_ok DESC, no_order DESC, id ASC ";
                break;
            case '6':
                $order_sql .= " ORDER BY top_ok DESC, no_order DESC, id ASC ";
                break;
            case '-1':
                $order_sql .= "  ";
                break;
            default:
                $order_sql .= " ORDER BY top_ok DESC, no_order DESC, updatetime DESC, id DESC ";
                break;
        }
        return $order_sql;
    }

    /**
     * 获取栏目排序URL
     * @param  string $order 排序类型
     * @return string          排序sql
     */
    public function get_custom_order($order, $defult_order)
    {
        $order_sql = '';
        switch ($order) {
            case '1':
                $order_sql .= " ORDER BY updatetime DESC, id DESC ";    //按更新时间
                break;
            case '2':
                $order_sql .= " ORDER BY addtime DESC, id DESC ";        //按添加时间
                break;
            case '3':
                $order_sql .= " ORDER BY id DESC ";            //按点击数
                break;
            case '4':
                $order_sql .= " ORDER BY id DESC ";                        //按ID倒叙
                break;
            case '5':
                $order_sql .= " ORDER BY id ASC ";                        //按ID顺序
                break;
            case '6':
                $order_sql .= " ORDER BY id DESC ";        //按推荐
                break;
            case '-1':
                $order_sql .= "  ";
                break;
            default:
                $order_sql .= $this->get_column_order($defult_order);
                break;
        }
        return $order_sql;
    }

    /**
     * 获取招聘岗位简历字段
     * @param  string $lang 语言
     * @return array            招聘岗位数组
     */
    public function get_module_para()
    {
        return load::mod_class('parameter/parameter_database', 'new')->get_parameter('6');
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
