<?php defined('IN_MET') or exit('No permission'); ?>
<include file="head.php" />
<div class="met-product-list animsition">
    <div class="container">
        <div class="less-page-content">
            <if value="$c['met_product_page'] && $data['sub'] && !$_M['form']['search']">
            <tag action='category' cid="$data['classnow']" type="son"></tag>
            <else/>
            <tag action='product.list' num="$c['met_product_list']"></tag>
            </if>
            <if value="$sub">
            <ul class="met-product blocks blocks-100 blocks-xlg-5 blocks-md-4 blocks-sm-3 blocks-xs-2 ulstyle met-pager-ajax imagesize" data-scale='{$c.met_productimg_y}x{$c.met_productimg_x}' m-id="noset">
                <include file='ajax/product'/>
            </ul>
            <else/>
            <div class='h-100 text-xs-center font-size-20 vertical-align' m-id="noset">{$c.met_data_null}</div>
            </if>
            <div class='m-t-20 text-xs-center hidden-sm-down' m-type="nosysdata">
                <pager type="$c['met_product_page']" />
            </div>
            <div class="met-pager-ajax-link hidden-md-up" m-type="nosysdata" data-plugin="appear" data-animate="slide-bottom" data-repeat="false">
                <button type="button" class="btn btn-primary btn-block btn-squared ladda-button" id="met-pager-btn" data-plugin="ladda" data-style="slide-left" data-url="" data-page="1">
                    <i class="icon wb-chevron-down m-r-5" aria-hidden="true"></i>
                    {$lang.page_ajax_next}
                </button>
            </div>
        </div>
    </div>
</div>
<include file="foot.php" />