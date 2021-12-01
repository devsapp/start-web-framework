<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

/**
 * 前台标签库
 * Class met_tag.
 */
load::sys_class('view/tag');
class met_tag extends tag
{
    public $config = array(
        'tag' => array('block' => 1, 'level' => 4),
        'mituo' => array('block' => 1, 'level' => 4),
        'lang' => array('block' => 1, 'level' => 4),
        'foreach' => array('block' => 1, 'level' => 5),
        'list' => array('block' => 1, 'level' => 5),
        'if' => array('block' => 1, 'level' => 10),
        'elseif' => array('block' => 0, 'level' => 0),
        'else' => array('block' => 0, 'level' => 0),
        'include' => array('block' => 0, 'level' => 0),
        'location' => array('block' => 1, 'level' => 4),
        'pager' => array('block' => 0, 'level' => 0),
        'pagination' => array('block' => 0, 'level' => 0),
    );

    public function _mituo($attr, $content)
    {
        global $_M;
        $action = $attr['ui'];
        if ($action == '404') {
            $action = 'met404';
        }
        $tag_file = PATH_WEB . "app/system/tag/templates/{$action}.class.php";
        $download = 0;
        // 如果不存在自动下载
        // if (!file_exists($tag_file)) {
        //     $download = 1;
        // } else {
        //     $mtime = filemtime($tag_file);
        //     if (time() > $mtime + 86400) {
        //         $class = load::mod_class("tag/templates/{$action}.class.php", 'new');
        //         if ($class->version < 10000) {
        //             $download = 1;
        //         }
        //         unset($class);
        //     }
        // }

        // if ($download) {
        //     $data = array(
        //         'action' => 'downloadUiTag',
        //         'skin_name' => $_M['config']['met_skin_user'],
        //         'ui_name' => $action,
        //     );
        //     $result = api_curl($_M['config']['met_api'], $data);
        //     $res = json_decode($result, true);
        //     if (!file_exists(PATH_WEB.'app/system/tag/templates/')) {
        //         mkdir(PATH_WEB.'app/system/tag/templates/', 0777, true);
        //     }
        //     if ($res['status'] == 200 && $res['data']) {
        //         file_put_contents($tag_file, base64_decode($res['data']));
        //         unset($res['data']);
        //     } else {
        //         die($res['msg']);
        //     }
        // }
        $params = base64_encode(json_encode($attr));
        $php
            = <<<php
        <?php 
        echo load::mod_class('tag/templates/{$action}.class.php','new')->parse('$params',\$ui,\$data);
        ?>
php;

        return $php;
    }

    public function _tag($attr, $content)
    {
        static $instance = array();
        $info = explode('.', $attr['action']);
        $count = is_array($info) ? count($info) : 0;

        if ($count > 1) {
            $action = '_' . $info[1];
            $module = $info[0];
        } else {
            $action = '_' . $info[0];
            $module = 'column';
        }

        $module_tag = $module . '/include/class/' . $module . '_tag.class.php';
        $app_tag = $module . '/include/class/' . $module . '_tag.class.php';

        if (is_file(PATH_SYS . $module_tag)) {
            load::mod_class($module_tag);
            $class = $module . '_tag';
        } elseif (is_file(PATH_ALL_APP . $app_tag)) {
            load::app_class($app_tag);
            $class = $module . '_tag';
        } else {
            die($attr['action'] . 'is not find ');
            //load::sys_class('ui');
            //$class = 'ui_tag';
        }
        if (!isset($instance[$class])) {
            $instance[$class] = new $class();
        }

        return $instance[$class]->$action($attr, $content);
    }

    //list标签
    public function _list($attr, $content, &$met)
    {
        //变量
        $from = $attr['data'];
        $name = isset($attr['name']) ? $attr['name'] : '$val';
        $name = substr($name, 1);
        $num = isset($attr['num']) ? $attr['num'] : 50;

        $php =
<<<php
        <?php
            \$sub = is_array($from) ? count($from) : 0;
            \$num = $num;
            
            if(!is_array($from) && $from){
                $from = explode('|',$from);
            }

            foreach ($from as \$index => \$val) {
                if(is_numeric(\$index) && \$index >= \$num){
                    break;
                }

                if(is_array(\$val)){
                    \$val['_index'] = \$index;
                    \$val['_first'] = \$index == 0 ? true : false;
                    \$val['_last']  = \$index == (\$sub-1) ? true : false;
                    \$val['sub']    = \$sub;
                }

                \$$name = \$val;
            ?>
php;
        $php .= $content;
        $php .= '<?php }?>';

        return $php;
    }

    //标签处理
    public function _foreach($attr, $content)
    {
        $php
            = "<?php foreach ({$attr['from']} as {$attr['key']}=>{$attr['value']}){?>";
        $php .= $content;
        $php .= '<?php }?>';

        return $php;
    }

    //加载模板文件
    public function _include($attr, $content, &$met)
    {
        //替换常量
        $const = get_defined_constants(true);

        foreach ($const['user'] as $k => $v) {
            $attr['file'] = str_replace($k, $v, $attr['file']);
        }

        //删除域名
        $file = str_replace(PATH_WEB . '/', '', trim($attr['file']));

        $view = new met_view();
        $page = $attr['page'];
        $view->fetch($file);

        if (!$view->compileFile) {
            return '';
        }
        $cache = file_get_contents($view->compileFile);
        // 每个页面头部加页面标识
        if ($page) {
            $this->compile = load::sys_class('view/sys_compile', 'new');
            if ($this->compile->template_type != 'tag') {
                require_once PATH_ALL_APP . 'met_template/include/class/parse.class.php';
                $this->compile = new parse();
            }

            $this->compile->parse_page($page);
            $cache = '<?php $met_page = "' . $page . '";?>' . $cache;
        }

        return $cache;
    }

    //if标签
    public function _if($attr, $content, &$met)
    {
        $php =
<<<php
    <?php if({$attr['value']}){ ?>$content<?php } ?>
php;

        return $php;
    }

    //elseif标签
    public function _elseif($attr, $content, &$met)
    {
        $php = "<?php }else if({$attr['value']}){ ?>";
        $php .= $content;

        return $php;
    }

    //else标签
    public function _else($attr, $content, &$met)
    {
        $php = '<?php }else{ ?>';
        $php .= $content;

        return $php;
    }

    public function _location($attr, $content)
    {
        $cid = isset($attr['cid']) ? $attr['cid'] : 0;
        $php =
<<<str
        <?php
            \$cid = $cid;
            if(!\$cid){
                \$cid = \$data['classnow'];
            }
            \$location = load::sys_class('label', 'new')->get('column')->get_class123_reclass(\$cid);
            \$location_data = array();
            \$location_data[0] = \$location['class1'];
            \$location_data[1] = \$location['class2'];
            \$location_data[2] = \$location['class3'];
            unset(\$location);
            foreach(\$location_data as \$index=> \$v):
        ?>
str;
        $php .= $content;
        $php .= '<?php endforeach;?>';

        return $php;
    }

    public function _pager($attr, $content)
    {
        $page_type = $attr['type'] ? $attr['type'] : 0;
        $php =
<<<str
     <?php
     \$page_type = $page_type;
     if(!\$data['classnow']){
        \$data['classnow'] = 2;
     }

     if(!\$data['page']){
        \$data['page'] = 1;
     }
      \$result = load::sys_class('label', 'new')->get('tag')->get_page_html(\$data['classnow'],\$data['page'],\$page_type);

       echo \$result;

     ?>
str;

        return $php;
    }

    public function _pagination($attr, $content)
    {
        global $_M;
        $php =
<<<str
        <div class='met-page p-y-30 border-top1'>
            <div class="container p-t-30 ">
                <ul class="pagination block blocks-2 text-xs-center text-sm-left">
                    <li class='page-item m-b-0 {\$data['preinfo']['disable']}'>
                        <a href='<?php if(\$data['preinfo']['url']){?>{\$data['preinfo']['url']}<?php }else{?>javascript:;<?php }?>' title="{\$data['preinfo']['title']}" class='page-link text-truncate'>
                            {\$word['Previous_news']}
                            <span aria-hidden="true" class='<?php if(\$data['preinfo']['url']){?>hidden-xs-down<?php }?>'>: <?php if(\$data['preinfo']['title']){?>{\$data['preinfo']['title']}<?php }else{?>{\$word['Noinfo']}<?php }?></span>
                        </a>
                    </li>
                    <li class='page-item m-b-0 {\$data['nextinfo']['disable']}'>
                        <a href='<?php if(\$data['nextinfo']['url']){?>{\$data['nextinfo']['url']}<?php }else{?>javascript:;<?php }?>' title="{\$data['nextinfo']['title']}" class='page-link pull-xs-right text-truncate'>
                            {\$word['Next_news']}
                            <span aria-hidden="true" class='<?php if(\$data['nextinfo']['url']){?>hidden-xs-down<?php }?>'>: <?php if(\$data['nextinfo']['title']){?>{\$data['nextinfo']['title']}<?php }else{?>{\$word['Noinfo']}<?php }?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
str;

        return $php;
    }

    public function _lang($attr, $content)
    {
        global $_M;
        $php =
<<<str
        <?php
            \$language = load::sys_class('label', 'new')->get('language')->get_lang();
           
            \$sub = is_array(\$language) ? count(\$language) : 0;
            \$i = 0;
            foreach(\$language as \$index=>\$v):
                \$v['_index']   = \$index;
                \$v['_first']   = \$i == 0 ? true:false;
                \$v['_last']    = \$index == (count(\$language)-1) ? true : false;
                \$v['sub'] = \$sub;
                \$i++;
        ?>
str;
        $php .= $content;
        $php .= '<?php endforeach;?>';

        return $php;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.