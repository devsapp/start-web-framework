<?php defined('IN_MET') or exit('No permission'); ?>
<style>
.onlinebox_two{background-color: transparent;box-shadow: none;}
.onlinebox_two .met-online-box {width: 54px; height: 54px; position: relative; margin-bottom: 1px;}
.onlinebox_two .online-item  {position: absolute; width: 54px; height: 54px; top: 0; right: 0;transition: all.3s; opacity: .8; filter: Alpha(opacity = 80); color: #fff; font-size: 14px;line-height: 54px;overflow: hidden;}
.onlinebox_two .online-item i{font-size: 20px; width: 54px;}
.onlinebox .onlinebox-open {display: block; cursor: pointer; padding: 0 10px; font-size: 18px; line-height: 40px; color: #fff; }
.onlinebox_two .onlineclose{display: none;}
.met-online-modal .close{position: absolute;right: 5px;top: 0;opacity: 1;}
#onlinebox .met-online-box:hover .online-item{width: 130px;opacity: 1;filter:Alpha(opacity=100);}
#onlinebox .met-online-box:hover .online-item i{width: 30px;}
@media (min-width: 768px){
.onlinebox_two .onlinebox-open{display: none;}
}
@media (max-width: 767px){
.onlinebox_two .onlinebox_two_list{display: none;position: relative;}
.onlinebox_two .onlineclose{font-style: initial;color: #fff;opacity: .8;position: absolute; right: -5px; top: -15px; border-radius: 50%; width: 25px;
    height: 25px;line-height:25px; display: block;font-family: arial;z-index: 10;}
}
</style>
<div id='onlinebox'  class="onlinebox onlinebox_two hide" m-type='online' m-id='online'>
	<div class="onlinebox-open text-xs-center" id="onlinebox-open" style="background:{$c.met_online_color};"> <i class="fa fa-comments-o"></i>
	</div>
	<list data="$data['online_list']"></list>
	<if value="$sub">
		<div class="onlinebox_two_list"> <i class="onlineclose font-size-20 text-xs-center" style="background:{$c.met_online_color};">x</i>
			<list data="$data['online_list']" name="$v">
				<if value="$v['type'] eq 4">
					<div class="met-online-box">
						<a class="online-item text-xs-center met-weixin" style="background-color: {$c.met_online_color};" href="javascript:void(0)" data-toggle="modal" data-target="#met-weixin{$v._index}">
							<i class="{$v.icon}"></i>
							<span>{$v.name}</span>
						</a>
					</div>
					<elseif value="$v['type'] eq 7" />
					<div class="met-online-box">
						<a href="{$v.value}" title="{$v.name}" class="online-item text-xs-center" target="_blank" style="background-color: {$c.met_online_color};">
							<i class="{$v.icon}"></i>
							<span>{$v.name}</span>
						</a>
					</div>
					<else/>
					<div class="met-online-box">
						<a href="{$v.url}" title="{$v.value}" class="online-item text-xs-center" target="_blank" style="background-color: {$c.met_online_color};">
							<i class="{$v.icon}"></i>
							<span>{$v.name}</span>
						</a>
					</div>
				</if>
			</list>
		</div>
	</if>
</div>
<list data="$data['online_list']" name="$weixin">
	<if value="$weixin['type'] eq 4">
		<div class="modal fade met-online-modal" id="met-weixin{$weixin._index}">
			<div class="modal-dialog modal-center modal-sm">
				<div class="modal-content">
					<div class="modal-header text-xs-center">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<img src="{$weixin.url}" alt="{$weixin.name}" style="max-width: 100%;" />
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal -->
		</div>
	</if>
</list>
<script>
$(function(){
 	$("#onlinebox-open").click(function(){
        $("#onlinebox").find(".onlinebox_two_list").show();
        $(this).hide();
    });
    $(".onlineclose").click(function(){
      $("#onlinebox").find(".onlinebox_two_list").hide();
      $("#onlinebox-open").show();
    });
});
</script>