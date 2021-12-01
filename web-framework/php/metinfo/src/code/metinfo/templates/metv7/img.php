<?php defined('IN_MET') or exit('No permission'); ?>
<include file="head.php" />
<div class="met-img animsition">
    <div class="container">
        <div class="row">
            <if value="$c['met_img_page'] && $data['sub'] && !$_M['form']['search']">
            <tag action='category' cid="$data['classnow']" type="son"></tag>
            <else/>
            <tag action='img.list' num="$c['met_img_list']"></tag>
            </if>
            <if value="$sub">
            <ul class="blocks-100 blocks-md-2 blocks-lg-4 blocks-xxl-4  no-space met-pager-ajax imagesize met-img-list" data-scale='{$c.met_imgs_y}x{$c.met_imgs_x}' m-id='noset'>
                <include file='ajax/img'/>
            </ul>
            <else/>
            <div class='h-100 text-xs-center font-size-20 vertical-align'>{$c.met_data_null}</div>
            </if>
            <div class='m-t-20 text-xs-center hidden-sm-down' m-type="nosysdata">
                <pager type="$c['met_img_page']"/>
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