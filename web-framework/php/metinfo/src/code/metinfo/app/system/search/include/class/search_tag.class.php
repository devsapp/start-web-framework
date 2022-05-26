<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.


class search_tag extends tag {
    // 必须包含Tag属性 不可修改
    public $config = array(
        'list'     => array( 'block' => 1, 'level' => 4 ),
        'form'     => array( 'block' => 1, 'level' => 4 ),
        'global'     => array( 'block' => 1, 'level' => 4 ),
        'column'     => array( 'block' => 1, 'level' => 4 ),
        'advanced'     => array( 'block' => 1, 'level' => 4 ),
        'option'     => array( 'block' => 1, 'level' => 4 ),
    );

    public function _form( $attr, $content = '' ) {
        global $_M;
        $type = isset( $attr['type'] ) ? $attr['type'] : "''";
        $cid = isset( $attr['cid'] ) ? ( $attr['cid'][0] == '$' ? $attr['cid']
            : "'{$attr['cid']}'" ) : 0;

        $php = <<<str
        <?php
            \$cid=$cid;
            \$result = load::sys_class('label', 'new')->get('search')->get_search_form_html(\$cid);
            echo \$result;
        ?>
str;
        return $php;
    }

    public function _global( $attr, $content = '' ) {
        global $_M;
        $type = isset( $attr['type'] ) ? $attr['type'] : "''";
        $php = <<<str
        <?php
            \$result = load::sys_class('label', 'new')->get('search')->get_search_global(\$data);
            echo \$result;
        ?>
str;
        return $php;
    }

    public function _column( $attr, $content = '' ) {
        global $_M;
        $type = isset( $attr['type'] ) ? $attr['type'] : "''";
        $php = <<<str
        <?php
            \$result = load::sys_class('label', 'new')->get('search')->get_search_column(\$data);
            echo \$result;
        ?>
str;
        return $php;
    }

    public function _advanced( $attr, $content = '' ) {
        global $_M;
        $type = isset( $attr['type'] ) ? $attr['type'] : "''";
        $php = <<<str
        <?php
            \$result = load::sys_class('label', 'new')->get('search')->get_search_advanced(\$data);
            echo \$result;
        ?>
str;
        return $php;
    }

    public function _list( $attr, $content = '' ) {
        global $_M;
        $word    = isset($attr['word']) ? $attr['word'] : "''";
        $php    = <<<str
<?php
    \$result = load::sys_class('label', 'new')->get('search')->get_search_list(\$data['searchword']);
    \$sub = is_array(\$result) ? count(\$result) : 0;
     foreach(\$result as \$index=>\$v):
        \$v['sub']      = \$sub;
        \$v['_index']   = \$index;
        \$v['_first']   = \$index == 0 ? true:false;
        \$v['_last']    = \$index == (count(\$result)-1) ? true : false;
?>
str;
        $php .= $content;
        $php .= '<?php endforeach;?>';
        return $php;
    }

    //搜索数据数组type=page
    public function _option( $attr, $content = '' ) {
        global $_M;
        $type   = isset($attr['type']) ? $attr['type'] : 'page';
        $php    = <<<str
<?php
    \$search = load::sys_class('label', 'new')->get('search')->get_search_opotion('$type', \$data['classnow'], \$data['page']);
?>
str;
        return $php;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.