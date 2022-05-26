<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

/**
 * 标签基类
 * Class Tag
 */
abstract class tag
{
    /**
     * 标签左符号
     *
     * @var bool|null
     */
    private $left;
    /**
     * 标签右符号
     *
     * @var bool|null
     */
    private $right;
    /**
     * 比较运算符
     *
     * @var array
     */
    private $condition
        = array(
            'neq' => '<>',
            'eq' => '==',
            'gt' => '>',
            'egt' => '>=',
            'lt' => '<',
            'elt' => '<='
        );

    /**
     * 构造函数
     */
    public function __construct()
    {
        //左侧标签
        $this->left = '<';
        //右侧标签
        $this->right = '>';
        if (method_exists($this, '__init')) {
            $this->__init();
        }
    }

    /**
     * 解析标签
     * 标签解析
     *
     * @param array $tag 标签
     * @param content $ViewContent 模板解析内容
     *
     * @return mixed
     */
    public function parseTag($tag, &$ViewContent, &$met_view)
    {
        global $_M;

        if ($this->config[$tag]['block']) {
            /**
             * 块标签解析
             */
            $preg = '#' . $this->left . '(?:' . $tag . '|' . $tag . '\s+(.*))'
                . $this->right . '(.*)' .
                $this->left[0] . '/' . substr($this->left, 1) . $tag
                . $this->right . '#isU';
        } else {
            /**
             * 行标签处理
             */
            $preg = '#' . $this->left . '(?:' . $tag . '|' . $tag . '\s+(.*))/'
                . $this->right . "#isU"; //独立正则
        }

        /**
         * 找到所有当前标签名的内容区域
         * 变量info说明
         * 0) 全部匹配内容
         * 1) 属性部分
         * 2) 内容部分
         */
        // $ViewContent = $this->parseAttrValue($ViewContent);

        $status = preg_match_all($preg, $ViewContent, $info, PREG_SET_ORDER);

        if ($status) {
            foreach ($info as $k) {
                /**
                 * 属性解析
                 */

                if (empty($k[1])) {
                    $attr = array();
                } else {
                    $attr = $this->parseTagAttr($k[1]);
                }


                /**
                 * 标签内容
                 */
                $k[2] = isset($k[2]) ? $k['2'] : '';
                $content = call_user_func_array(
                    array($this, '_' . $tag), array($attr, $k[2], &$met_view)
                );

                $ViewContent = str_replace($k[0], $content, $ViewContent);
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * 解析标签属性
     *
     * @param string $attrStr 标签字符串
     *
     * @return array 标签名如foreach
     */
    protected function parseTagAttr($attrStr)
    {
        $pregAttr = '#' . '([a-z_]+)=(["\'])(.*)\2#iU'; //属性
        $status = preg_match_all($pregAttr, $attrStr, $info, PREG_SET_ORDER);

        if ($status) {
            $attr = array();
            foreach ($info as $k) {
                /**
                 * 解析属性值
                 */
                $attr[$k[1]] = $this->parseAttrValue($k[3]);
            }

            return $attr;
        } else {
            return array();
        }
    }

    /**
     * 解析属性值
     *
     * @param $attrValue 属性值
     *
     * @return mixed
     */
    protected function parseAttrValue($attrValue)
    {
        /**
         * 替换GT LT等
         */
        foreach ($this->condition as $k => $v) {
            $attrValue = preg_replace("/\s+$k\s+/i", $v, $attrValue);
        }

        /**
         * 替换常量值
         */
        $const = get_defined_constants(true);

        foreach ($const['user'] as $name => $value) {

            /**
             * 替换以__开始的常量
             */
            if (substr($name, 0, 2) == '__') {
                $attrValue = str_ireplace($name, $value, $attrValue);

            }
        }
        /**
         * 解析变量为PHP可识别状态
         */
        $preg = '@\$([\w\.]+)@i';
        $status = preg_match_all($preg, $attrValue, $info, PREG_SET_ORDER);
        if ($status) {
            foreach ($info as $i => $d) {
                $var = '';
                $data = explode('.', $d[1]);
                foreach ($data as $n => $m) {
                    if ($n == 0) {
                        $var .= $m;
                    } else {
                        $var .= '[\'' . $m . '\']';
                    }
                }
                $attrValue = str_replace($d[1], $var, $attrValue);
            }

            return $attrValue;
        } else {
            return $attrValue;
        }
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.