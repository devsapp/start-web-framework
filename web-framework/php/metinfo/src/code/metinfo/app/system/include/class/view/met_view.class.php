<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

load::sys_class('view/view_compile');
/**
 * 模板标签处理
 */
final class met_view
{

    /**
     * 模板变量
     *
     * @var array
     */
    public $vars = array();

    public $const = array();
    /**
     * 模版文件
     *
     * @var null
     */
    public $tplFile = null;
    /**
     * 编译文件
     *
     * @var null
     */
    public $compileFile = null;
    public $id;

    /**
     * 模板显示
     *
     * @param string $tplFile 模板文件
     * @param string $cachePath 缓存目录
     * @param int $cacheTime 缓存时间
     * @param string $contentType 文件类型
     * @param bool $show 是否显示
     *
     * @return bool|string
     */
    public function display($tplFile = null, $cacheTime = -1, $cachePath = null, $contentType = "text/html", $show = true)
    {
        global $_M;
        $cachePath = $cachePath ? $cachePath : TEMP_CACHE_PATH;

        $content = null;
        if (!$content) {
            /**
             * 全局变量定义
             * 模板使用{$c.xx}方式调用
             */
            $sys_compile = load::sys_class('view/compile', 'new');
            if ($sys_compile->template_type == 'tag' || (defined("IN_ADMIN") && ($sys_compile->template_type == 'ui'))) {
                $this->compile = load::sys_class('view/sys_compile', 'new');
                // 模板使用$lang.xxx调用模板标签配置
                $this->vars['lang'] = $this->compile->list_templates_config();
            } else {
                $parseFile = PATH_ALL_APP . "met_template/include/class/parse.class.php";
                if (!file_exists($parseFile)) {
                    die('error templates file is not found');
                }
                require_once $parseFile;
                $this->compile = new parse;
            }

            $this->vars['g'] = $this->compile->list_public_config(); //模板全局配置
            $this->vars['c'] = $this->compile->replace_sys_config(); //系统全局配置

            /**
             * 模板使用$lang.xxx调用模板标签配置
             */
            ##$this->vars['lang'] = $sys_compile->list_templates_config();
            ##$this->vars['lang'] = $this->vars['g'];

            if (defined('IN_ADMIN')) {
                $this->vars['url'] = $this->compile->replace_sys_url();
            }else{
                $this->vars['url'] = $_M['url'];
            }
            $this->vars['word'] = $_M['word'];//语言
            $this->vars['user'] = load::sys_class('user', 'new')->get_login_user_info();

            /**
             * 获得模板文件
             */
            $this->tplFile = $this->getTemplateFile($tplFile);

            if (!$this->tplFile) {
                return;
            }

            //编译文件
            $this->compileFile = $cachePath . '/_' . substr(md5($this->tplFile . $_M['lang'] . intval($_M['form']['pageset'])), 0, 8) . '.php';
            // var_dump($this->compileFile);
            // 编译文件不存在或DEBUG时都会重新编译
            if ($this->compileInvalid($tplFile)) {

                //执行编译
                $this->compile();
            }

            //加载全局变量
            if (!empty($this->vars)) {
                extract($this->vars);
            }

            ob_start();
            include $this->compileFile;
            $content = ob_get_clean();

        }

        if ($show) {
            $charset = "UTF-8";
            if (!headers_sent()) {
                header("Content-type:" . $contentType . ';charset=' . $charset);
            }
            echo $content;
            die;
        } else {
            return $content;
        }
    }

    /**
     * 获得视图内容
     *
     * @param null $tplFile 模板文件
     * @param null $cacheTime 缓存时间
     * @param null $cachePath 缓存路径
     * @param string $contentType 文档类型
     *
     * @return bool|string
     */
    public function fetch($tplFile = null, $cacheTime = null, $cachePath = null, $contentType = "text/html")
    {
        return $this->display(
            $tplFile, $cacheTime, $cachePath, $contentType, false
        );
    }

    /**
     * 获得模版文件
     *
     * @param $file 模板文件
     *
     * @return bool|string
     */
    private function getTemplateFile($file)
    {
        global $_M;
        $filename = $file;
        if (!is_file($file)) {
            $file_info = explode('/', $file, 2);
            if (count($file_info) > 1) {
                $m_module = M_MODULE;
                if (M_CLASS == 'loadtemp' && M_ACTION == 'doviewhtml') {
                    $m_module = 'admin';
                    $app_path = PATH_OWN_FILE;
                    if ($file_info[0] == 'app') {
                        $path = $_M['form']['path'];
                        $app_path = explode('templates/', $this->getTemplateFile($path));
                        $app_path = $app_path[0];
                    }
                } else if ($file_info[0] == 'app') {
                    $app_path = PATH_OWN_FILE;
                }
                switch ($file_info[0]) {
                    case 'ui_ajax':
                        $file = PATH_WEB . str_replace('ui_ajax/', 'public/web/templates/ajax/', $file);
                        break;
                    case 'ui_v2':
                        $file = PATH_WEB . str_replace('ui_v2/', 'public/web/', $file);
                        if (strpos($file_info[1], 'module/shop/shop_option_ui') !== false) {
                            $file = $this->getTemplateFile('app/module/shop_option');
                        }

                        break;
                    case 'app':
                        if (file_exists(PATH_TEM . M_NAME . '/' . end($file_info).'.php')) {
                            $file = PATH_TEM . M_NAME . '/' . end($file_info);
                            break;
                        }
                        if (M_MODULE == 'web' && (M_NAME == 'shop' || M_NAME == 'product' || M_NAME == 'pay')) {
                            if (M_NAME == 'product' && $_M['config']['shopv2_open']) {
                                $app_path = PATH_APP . 'app/shop/' . $m_module . '/';
                            }
                            $file = $app_path . str_replace('app/', "templates/met/", $file);
                        } else {
                            $file = $app_path . str_replace('app/', "templates/", $file);
                        }
                        break;
                    case 'sys':
                        $file = PATH_WEB . str_replace('sys/', 'app/system/', $file);
                        break;
                    case 'sys_admin':
                        $file = PATH_WEB . str_replace('sys_admin/', 'app/system/include/templates/admin_old/', $file);
                        break;
                    case 'sys_web':
                        $folder = $_M['config']['metinfover'] == 'v2' ? 'app/system/include/templates/web/' : 'public/web/';
                        $file = PATH_WEB . str_replace('sys_web/', $folder, $file);
                        break;
                    case 'pub':
                        $file = PATH_WEB . str_replace('pub/', 'app/system/include/templates/' . $m_module . '/', $file);
                        break;
                    case 'apps':
                        $file = PATH_WEB . str_replace('apps/', 'app/app/', $file);
                        break;
                    case 'site':
                        $file = PATH_WEB . str_replace('site/', '', $file);
                        break;
                    default:
                        $onlyfile = true;
                        break;
                }
            } else {
                $onlyfile = true;
            }

            if ($onlyfile) {
                if ($file == 'user_sidebar') {
                    $file = PATH_WEB . 'app/system/user/web/templates/sidebar';
                } else {
                    $file = PATH_TEM . $file;
                }
            }

            /**
             * 添加后缀
             */
            if (!preg_match('/\.[a-z]+$/i', $file)) {
                $file .= '.php';
            }
        }

        /**
         * 模板文件检测
         */
        if (is_file($file)) {
            if (!strtolower(substr($file, -4)) == ".php") {
                return false;
            }
            return $file;
        } else {
            if (strstr($filename, '/')) {
                return false;
            }
            $default = PATH_PUBLIC_WEB .'templates/'. $filename . '.php';
            if (file_exists($default)) {
                return $default;
            }
            return false;
        }
    }

    /**
     * 编译是否失效
     *
     * @return bool true 失效
     */
    private function compileInvalid()
    {
        global $_M;
        $tplFile = $this->tplFile;
        $compileFile = $this->compileFile;
        return !is_file($compileFile) || $_M['config']['debug']
            || (filemtime($tplFile) > filemtime($compileFile));
    }

    /**
     * 编译模板
     */
    public function compile()
    {
        /**
         * 编译是否失效
         */
        if (!$this->compileInvalid()) {
            return;
        }
        $compileObj = new view_compile();
        $compileObj->id = $this->id;
        $compileObj->run($this);
    }

    /**
     * 向模板中传入变量
     *
     * @param string|array $var 变量名
     * @param mixed $value 变量值
     *
     * @return bool
     */
    public function assign($var, $value)
    {
        if (is_array($var)) {
            foreach ($var as $k => $v) {
                if (is_string($k)) {
                    $this->vars[$k] = $v;
                }
            }
        } else {
            $this->vars[$var] = $value;
        }
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
