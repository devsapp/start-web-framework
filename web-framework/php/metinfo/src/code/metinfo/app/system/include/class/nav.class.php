<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

/**
 *顶部导航选项卡
 * @param array $navlist  导航选项卡数组
 * @param int   $nav_show 是否显示导航选项卡
 */
class nav
{

    public static $navlist;
    public static $nav_show = 1;

    /**
     * 设置导航选项卡
     * @param int $num 导航选项卡编号
     * @param string $title 导航选项卡名称
     * @param string $url 导航选项卡地址
     */
    public static function set_nav($num, $title, $url, $target = '_self')
    {
        self::$navlist[$num]['title'] = $title;
        self::$navlist[$num]['url'] = $url;
        self::$navlist[$num]['classnow'] = "";
        self::$navlist[$num]['target'] = $target;
    }

    /**
     * 设置当前页面的导航栏
     * @param int $num 选定导航选项卡的编号
     * @param string $title 在顶部导航后追加的导航，一般是这个选定导航选项卡的内部页面，此时导航选项卡会影藏。
     */
    public static function select_nav($num, $title = '')
    {
        global $_M;
        foreach (self::$navlist as $key => $val) {
            self::$navlist[$key]['classnow'] = '';
            self::$navlist[$key]['nav'] = '';
        }
        self::$navlist[$num]['classnow'] = "class='now'";
        if ($title) {
            self::$navlist[$num]['nav'] = ' > <a href="' . self::$navlist[$num]['url'] . '">' . self::$navlist[$num]['title'] . '</a> > ' . $title . "<div class='return'><a href='javascript:history.go(-1);'><i class='fa fa-chevron-left'></i>{$_M['word']['js55']}</a></div>";
            self::$nav_show = 0;
        } else {
            self::$navlist[$num]['nav'] = ' > ' . self::$navlist[$num]['title'];
            self::$nav_show = 1;
        }
    }

    /**
     * 获取导航选项卡数组
     * @return string 导航选项卡数组
     */
    public static function get_nav()
    {
        if (self::$nav_show == 1) {
            return self::$navlist;
        } else {
            return false;
        }
    }

    /**
     * 获取顶部导航html代码
     * @return string 顶部导航html代码
     */
    public static function get_select_navhtml()
    {
        foreach (self::$navlist as $key => $val) {
            if ($val['nav']) {
                return $val['nav'];
            }
        }
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>