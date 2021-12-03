<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

class banner_tag extends tag
{
    // 必须包含Tag属性 不可修改
    public $config = array(
        '_list' => array('block' => 1, 'level' => 4),
    );

    public function _list($attr, $content)
    {
        $php = <<<str
<?php 
    \$banner = load::sys_class('label', 'new')->get('banner')->get_column_banner(\$data['classnow']);
    \$sub = is_array(\$banner['img']) ? count(\$banner['img']) : 0;
    foreach(\$banner['img'] as \$index=>\$v):
        \$v['_index']   = \$index;
        \$v['_first']   = \$index == 0 ? true:false;
        \$v['_last']    = \$index == (\$sub-1) ? true : false;
        \$v['type'] = \$banner['config']['type'];
        \$v['y'] = \$banner['config']['y'];
        \$v['sub'] = \$sub;
?>
str;
        $php .= $content;
        $php .= '<?php endforeach;?>';
        return $php;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.