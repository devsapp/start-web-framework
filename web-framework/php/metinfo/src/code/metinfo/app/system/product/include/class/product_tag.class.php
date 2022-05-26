<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

class product_tag extends tag {
    // 必须包含Tag属性 不可修改
    public $config = array(
        'list'     => array( 'block' => 1, 'level' => 4 ),
        'price'    => array( 'block' => 1, 'level' => 4 ),
    );


    public function _list( $attr, $content ) {
        global $_M;
        $cid    = isset( $attr['cid'] ) ? ( $attr['cid'][0] == '$' ? $attr['cid']
            : "'{$attr['cid']}'" ) : 0;
        $order  = isset($attr['order']) ? $attr['order'] : 'no_order';
        $num    = isset($attr['num']) ? $attr['num'] : 8;
        $para    = isset($attr['para']) ? $attr['para'] : 0;

        $php    = <<<str
<?php
    \$cid = $cid;
    if(\$cid == 0){
        \$cid = \$data['classnow'];
    }
    \$num = $num;
    \$para = $para;
    \$order = "$order";
    \$result = load::sys_class('label', 'new')->get('product')->get_list_page(\$cid, \$data['page']);
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

    /**
     * 商城筛选价格数筛选框tag
     * @return string
     */
    public function _price()
    {
        global $_M;
        if (!$_M['config']['shopv2_open']) {
            return '';
        }

        $php = <<<str
<form action="" method="get">
              <input type="hidden" name="class1" value="{\$data.class1}">
              <input type="hidden" name="class2" value="{\$data.class2}">
              <input type="hidden" name="class3" value="{\$data.class3}">
              <input type="hidden" name="lang" value="{\$data.lang}">
              <input type="hidden" name="search" value="search">
              <input type="hidden" name="content" value="{\$_M['form']['content']}">
              <input type="hidden" name="specv" value="{\$_M['form']['specv']}">
              <input type="hidden" name="order" value="{\$_M['form']['order']}">
              <span class="pricetxt">{\$word.app_shop_remind_row4}：</span>
              <input type="text" name="price_low" placeholder="" value="{\$_M['form']['price_low']}" class="form-control inline-block w-100 price_num">
              <span class="pricetxt">-</span>
              <input type="text" name="price_top" placeholder="" value="{\$_M['form']['price_top']}" class="form-control inline-block w-100 price_num">
              <button type="submit" class='btn pricesearch' style="position: relative;top: -3px;">{\$word.confirm}</button>
            </form>
str;
        return $php;

    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
