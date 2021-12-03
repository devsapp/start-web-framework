<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

class feedback_tag extends tag {
    // 必须包含Tag属性 不可修改
    public $config = array(
        'form'     => array( 'block' => 1, 'level' => 4 ),
    );


    public function _form( $attr, $content ) {
        global $_M;
        $type = isset( $attr['type'] ) ? $attr['type'] : "";
        $cid = isset( $attr['cid'] ) ? ( $attr['cid'][0] == '$' ? $attr['cid']
            : "'{$attr['cid']}'" ) : 0;

        $php = <<<str
<?php
    \$cid= $cid;
    \$cid= \$cid ? \$cid : \$data['classnow'];
    \$fdtitle=\$data['name'];
    \$result = load::sys_class('label', 'new')->get('feedback')->get_module_form_html(\$cid,\$fdtitle);
    echo \$result;
?>
str;
        return $php;

    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.;
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.