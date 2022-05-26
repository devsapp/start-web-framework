<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

class job_tag extends tag
{
    // 必须包含Tag属性 不可修改
    public $config = array(
        'form' => array('block' => 1, 'level' => 4),
        'list' => array('block' => 1, 'level' => 4),
    );


    public function _form($attr, $content)
    {
        global $_M;
        $id = isset($attr['cid']) ? ($attr['cid'][0] == '$' ? $attr['cid']
            : "'{$attr['cid']}'") : 0;
        $php = <<<str
<?php
    \$id = $id;
    \$result = load::sys_class('label', 'new')->get('job')->get_module_form_html(\$id);

    echo \$result;
?>
str;
        $php .= $content;
        return $php;

    }


    public function _list($attr, $content)
    {
        global $_M;
        $cid = isset($attr['cid']) ? ($attr['cid'][0] == '$' ? $attr['cid']
            : "'{$attr['cid']}'") : 0;
        $order = isset($attr['order']) ? $attr['order'] : 'no_order';
        $num = isset($attr['num']) ? $attr['num'] : 8;
        $php = <<<str
<?php
    \$cid = $cid;
    if(\$cid == 0){
        \$cid = \$data['classnow'];
    }
    \$num = $num;
    \$order = "$order";
    \$result = load::sys_class('label', 'new')->get('job')->get_list_page(\$cid, \$data['page']);
    \$sub = is_array(\$result) ? count(\$result) : 0;

     foreach(\$result as \$index=>\$v):
        \$v['sub']      = \$sub;
        \$v['_index']   = \$index;
        \$v['_first']   = \$index == 0 ? true:false;
        \$v['_last']    = \$index == (\$sub-1) ? true : false;
        \$v['count']    = \$v['count'] ? \$v['count'] : \$word['Job1'];
        \$v['classnow'] = \$v['class3'] ? \$v['class3'] : (\$v['class2'] ? \$v['class2'] :\$v['class1']);
?>
str;
        $php .= $content;
        $php .= '<?php endforeach;?>';
        return $php;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.