<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.


class link_tag extends tag {
    // 必须包含Tag属性 不可修改
    public $config = array(
        'list'     => array( 'block' => 1, 'level' => 4 ),
    );


    public function _list( $attr, $content ) {
        global $_M;

        $php    = <<<str
<?php
    \$result = load::sys_class('label', 'new')->get('link')->get_link_list(\$data['classnow']);
    \$sub = is_array(\$result) ? count(\$result) : 0;
     foreach(\$result as \$index=>\$v):
         if(\$data['module'] == 10001){
             \$v['weburl']   = \str_replace(array('../',\$_M['url']['site']),'',\$v['weburl']);
         }
        \$v['sub']      = \$sub;
        \$v['_index']   = \$index;
        \$v['_first']   = \$index == 0 ? true:false;
        \$v['_last']    = \$index == (count(\$result)-1) ? true : false;
        \$v['nofollow'] = \$v['nofollow'] ? "rel='nofollow'" : '';
?>
str;
        $php .= $content;
        $php .= '<?php endforeach;?>';
        return $php;
    }

    public function _page( $attr, $content)
    {
        global $_M;

    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
