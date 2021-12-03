<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

/**
 * 模板引擎编译处理类
 *
 * @package     View
 */
class view_compile
{
    private $view;
    /**
     * 模板编译内容
     *
     * @var
     */
    private $content;


    /**
     * 别名函数
     *
     * @var array
     */
    private $aliasFunction
        = array(
            'default' => '_default'
        );


    /**
     * 不解析内容
     * a) 先将不解析内容放入数组中
     * b) 然后将从内容替换
     *
     * @var array
     */
    private $literal = array();

    /**
     * @var 同_load_class
     */
    private $compile;

    /**
     * 构造函数
     */
    function __construct()
    {
        global $_M;
    }

    //运行编译
    public function run(&$view = null)
    {
        $this->view = $view;

        /**
         * 模板内容
         */
        $this->content = file_get_contents($this->view->tplFile);

        /**
         * 获得不解析内容
         */
        $this->getNoParseContent();

        /**
         * 加载标签类
         * 标签由系统标签与应用标签构成
         */
        $this->parseTag();

        /**
         * 解析变量
         */
        $this->parseVar();
        /**
         * 将所有常量替换
         */
        $this->parseUrlConst();

        /**
         * 将不解析内容还原
         */
        $this->replaceNoParseContent();

        /**
         * 创建编译目录
         */

        $dirname = str_ireplace("\\", "/", dirname($this->view->compileFile));
        $dirPath = substr($dirname, "-1") == "/" ? $dirname : $dirname . "/";
        if (!is_dir($dirPath)) {
            $dirs = explode('/', $dirPath);
            $dir = '';
            foreach ($dirs as $v) {
                $dir .= $v . '/';
                if (is_dir($dir))
                    continue;
                mkdir($dir, 0777, true);
            }
        }
        /**
         * 储存编译文件
         */
        file_put_contents($this->view->compileFile, $this->content);
    }

    /**
     * 获得不解析内容
     */
    private function getNoParseContent()
    {
        $status = preg_match_all(
            '@<literal>(.*?)<\/literal>@isU', $this->content, $info,
            PREG_SET_ORDER
        );

        if ($status) {
            foreach ($info as $n => $content) {
                if (!empty($content)) {
                    $this->literal[$n] = $content[1];
                    $this->content = str_replace(
                        $content[0], '###' . $n . '###', $this->content
                    );
                }
            }
        }
    }

    /**
     * 将记录的不解析内容替换回来
     */
    private function replaceNoParseContent()
    {

        foreach ($this->literal as $n => $content) {
            $this->content = str_replace(
                '###' . $n . '###', $content, $this->content
            );
        }
    }

    /**
     * 加载标签库与解析标签
     */
    private function parseTag()
    {
        /**
         * 所有标签库类
         */
        $tagClass = array();

        $tags = array(
            __DIR__ . '/met_tag.class.php',
            __DIR__ . '/sys_tag.class.php',
            #__DIR__.'/ui_tag.class.php',
            PATH_ALL_APP . "met_template/include/class/ui_tag.class.php"
        );

        if (!empty($tags) && is_array($tags)) {

            foreach ($tags as $file) {

                if (is_file($file)) {
                    require_once $file;
                }
                $class = basename($file);
                $res = explode('.', $class);
                $class = $res[0];
                /**
                 * 合法标签类必须包含config属性
                 */
                if (class_exists($class, false)
                    && property_exists($class, 'config')
                    && get_parent_class($class) == 'tag'
                ) {
                    $tagClass[] = $class;
                }
            }
        }

        /**
         * 解析标签类
         */
        foreach ($tagClass as $class) {
            /**
             * 标签类对象
             */
            $obj = new $class();

            /**
             * 标签库中的标签方法
             */
            foreach ($obj->config as $tag => $option) {
                /**
                 * 合法标签满足以下条件
                 * b) 定义了block与level值
                 */


                if (!isset($option['block'])
                    || !isset($option['level'])
                ) {
                    continue;
                }

                /**
                 * 解析标签
                 */
                for ($i = 0; $i <= $option['level']; $i++) {

                    if (!$obj->parseTag($tag, $this->content, $this->view)
                    ) {
                        break;
                    }
                }
            }
        }
    }

    /**
     * 解析变量
     *
     * @return mixed
     */
    private function parseVar()
    {
        $preg = '#\{(\$[\w\.\[\]\'"]+)?(?:\|(.*))?\}#isU';
        $status = preg_match_all(
            $preg, $this->content, $info,
            PREG_SET_ORDER
        );
        if ($status) {
            foreach ($info as $d) {
                /**
                 * 变量
                 */
                $var = '';
                if (!empty($d[1])) {
                    $data = explode('.', $d[1]);
                    foreach ($data as $n => $m) {
                        if ($n == 0) {
                            $var .= $m;
                        } else {
                            $var .= '[\'' . $m . '\']';
                        }
                    }
                }
                /**
                 * 函数
                 */
                if (!empty($d[2])) {
                    $functions = explode('|', $d[2]);
                    foreach ($functions as $func) {
                        /**
                         * 函数解析
                         * 如:substr:0,2
                         */
                        $tmp = explode(':', $func, 2);
                        /**
                         * 函数名
                         * 别名函数中存在时，使用别名函数
                         */
                        if (isset($this->aliasFunction[$tmp[0]])) {
                            $name = $this->aliasFunction[$tmp[0]];
                        } else {
                            $name = $tmp[0];
                        }
                        //参数
                        $arg = empty($tmp[1]) ? '' : $tmp[1];
                        /**
                         * 变量加入到参数中
                         * 参数中有@@时将变量替换@@
                         */
                        if (strstr($arg, '@@')) {
                            $var = str_replace('@@', $var, $arg);
                        } else {
                            $var = $var . ',' . $arg;
                        }
                        /**
                         * 删除参数连接后的尾部逗号
                         */
                        $var = trim($var, ',');
                        $var = $name . '(' . $var . ')';
                    }
                }
                if (!empty($var)) {
                    $replace = '<?php echo ' . $var . ';?>';
                    $this->content = str_replace($d[0], $replace, $this->content);
                }

            }
        }
    }

    /**
     * 替换URL地址常量
     *
     */
    private function parseUrlConst()
    {
        $const = get_defined_constants(true);
        foreach ($const['user'] as $k => $v) {
            if (strstr($k, '__')) {
                $this->content = str_replace($k, $v, $this->content);
            }
        }
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.