<?php defined('IN_MET') or exit('No permission');?>
<style type="text/css">
.onlinebox_three{border:2px solid;}
.onlinebox_three .onlinebox_three_list{width: 160px;padding: 10px 0px;}
.onlinebox_three .online-item{margin-bottom: 5px; padding: 0px 17px; position: relative;display: block;color: #666;}
.onlinebox_three .online-item:last-child{margin-bottom: 0px;}
.onlinebox_three .online-item:hover{background: #f8f8f8;}
.onlinebox_three .online-item i{font-size: 16px;}
.onlinebox_three .onlinebox-open{font-size: 22px;display:none;cursor: pointer;padding: 0 10px; font-size: 18px; line-height: 40px;}
.onlinebox.min .onlinebox-open{display:block;padding:0 10px;background:#444;font-size:18px;line-height:40px;color:#fff}
.onlinebox .onlinebox-min{position: relative;top:-4px;}
@media (max-width: 767px){
.onlinebox_three .online-item{font-size: 12px;padding-top: 6px;}
.onlinebox_three .online-item i{font-size: 14px;}
}
</style>
<div id='onlinebox'  class="onlinebox onlinebox_three hide" m-type='online' m-id='online' style="border-color:{$c.met_online_color};">
    <div class="onlinebox-open" style="background:{$c.met_online_color};"><i class="fa fa-comments-o"></i></div>
    <div class="onlinebox-box">
        <div class="onlinebox-top" style="background:{$c.met_online_color};">
            <div class="onlinebox-top-btn font-size-26">
                <a href="javascript:;" class="onlinebox-close" title="">&times;</a>
                <a href="javascript:;" class="onlinebox-min">-</a>
            </div>
            <h4>{$word.Online}</h4>
        </div>
        <list data="$data['online_list']"></list>
        <if value="$sub">
            <div class="onlinebox_three_list">
                <list data="$data['online_list']" name="$v">
                    <if value="$v['type'] eq 4">
                        <a class="online-item text-xs-center met-weixin" href="javascript:void(0)">
                            <img src='{$v.url}' alt='{$c.met_webname}' width='120' height='120'/>
                            <p class="m-b-0">{$v.name}</p>
                        </a>
                        <elseif value="$v['type'] eq 7" />
                        <a href="{$v.value}" title="{$v.name}" class="online-item" target="_blank"> <i class="{$v.icon}" style="color:{$c.met_online_color};"></i>
                            <span>{$v.name}</span>
                        </a>
                        <else/>
                        <a href="{$v.url}" title="{$v.value}" class="online-item" target="_blank">
                            <i class="{$v.icon}" style="color:{$c.met_online_color};"></i>
                            <span>{$v.name}</span>
                        </a>
                    </if>
                </list>
            </div>
        </if>
        <div class="met-editor onlinebox-bottom p-x-10 p-y-5">{$c.met_onlinetel}</div>
    </div>
</div>