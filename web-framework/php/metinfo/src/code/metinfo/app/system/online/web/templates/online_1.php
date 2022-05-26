<?php defined('IN_MET') or exit('No permission'); ?>
<style type="text/css">
.onlinebox_one{background-color: transparent;box-shadow: none;}
.onlinebox_one .online-item{width: 68px;height: 60px;margin-bottom: 2px; padding-top: 12px; position: relative;display: block;color: #ffffff;}
.onlinebox_one .online-item:nth-child(2){border-radius: 5px 5px 0px 0px;}
.onlinebox_one .online-item:last-child{border-radius: 0px 0px 5px 5px;}
.onlinebox_one .online-item i{font-size: 18px;}
.onlinebox_one .onlinebox-open{border-radius: 5px;font-size: 22px;}
.onlinebox_one .close{font-style: initial;color: #fff;opacity: 1;position: absolute; right: -5px; top: -15px;z-index:1; border-radius: 50%; width: 25px;
    height: 25px;line-height:25px; display: none;font-size: 20px !important; font-family: arial; }
.onlinebox .onlinebox-open {display: block; cursor: pointer; padding: 0 10px; font-size: 18px; line-height: 40px; color: #fff; }
@media (min-width: 768px){
.onlinebox_one .onlinebox-open{display: none;}
}
@media (max-width: 767px){
.onlinebox_one .online-item:first-child{border-radius: 5px 5px 0px 0px;}
.onlinebox_one .onlinebox_one_list{display: none;}
.onlinebox_one .close{display:block;}
.onlinebox_one .online-item{width: 54px;height: 50px;font-size: 12px;padding-top: 6px;}
.onlinebox_one .online-item i{font-size: 14px;}
}
</style>
<?php $hash_erweima=0; ?>
<div id='onlinebox'  class="onlinebox onlinebox_one hide" m-type='online' m-id='online'>
    <div class="onlinebox-open text-xs-center" id="onlinebox-open" style="background:{$c.met_online_color};"> <i class="fa fa-comments-o"></i>
    </div>
    <list data="$data['online_list']"></list>
    <if value="$sub">
    <div class="onlinebox_one_list">
        <a href="javascript:void(0)" class="text-xs-center">
            <i class="close" style="background:{$c.met_online_color};">x</i>
        </a>
        <list data="$data['online_list']" name="$v">
            <if value="$v['type'] eq 4">
            <?php $hash_erweima=1; ?>
            <a class="online-item text-xs-center met-online-weixin" style="background-color: {$c.met_online_color};" href="javascript:void(0)" data-index="{$v._index}" data-plugin="webuiPopover" data-trigger="hover" data-animation="pop" <if value="$c['met_online_type'] eq 1 || $c['met_online_type'] eq 3">
            data-placement='right'
            <else/>
            data-placement='left'
            </if>
            data-content="<img src='{$v.url}' alt='{$c.met_webname}' width='100' height='100'>">
                <i class="{$v.icon}"></i>
                <p class="m-b-0">{$v.name}</p>
            </a>
            <elseif value="$v['type'] eq 7" />
            <a href="{$v.value}" title="{$v.name}" class="online-item text-xs-center" target="_blank" style="background-color: {$c.met_online_color};">
                <i class="{$v.icon}"></i>
                <p class="m-b-0">{$v.name}</p>
            </a>
            <else/>
            <a href="{$v.url}" title="{$v.value}" class="online-item text-xs-center" target="_blank" style="background-color: {$c.met_online_color};">
                <i class="{$v.icon}"></i>
                <p class="m-b-0">{$v.name}</p>
            </a>
        </if>
        </list>
    </div>
    </if>
</div>
<script>
$(function(){
    <if value="$hash_erweima">
    metFileLoadFun([
      '{$url.public_plugins}webui-popover/webui-popover.min.css',
      '{$url.public_plugins}webui-popover/jquery.webui-popover.min.js',
      '{$url.public_web}plugins/register/webui-popover.min.js'
    ],function(){
      return typeof $.fn.webuiPopover=='function';
    },function(){
      $('.met-online-weixin').webuiPopover();
    });
    </if>
    $("#onlinebox-open").click(function(){
        $("#onlinebox").find(".onlinebox_one_list").show();
        $(this).hide();
    });
    $(".close").click(function(){
      $("#onlinebox").find(".onlinebox_one_list").hide();
      $("#onlinebox-open").show();
    });
});
</script>