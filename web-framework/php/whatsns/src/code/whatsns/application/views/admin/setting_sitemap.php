<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;SiteMap设置</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->


    <table class="table">
        <tr class="header">
            <td colspan="2">全站SiteMap站点地图---记得提交搜索引擎，收录杠杠的【自动更新，站内同步】</td>
        </tr>

        <tr>
            <td class="altbg1" width="45%"><b>站内问题地图地址:</b><br><span class="">请把站内地图提交到百度站长和360站长平台</span></td>
            <td class=""><input type="text" value="{url rss/list}" name="seo_suffix" style="width:400px;"/></td>
        </tr>
   <tr>
            <td class="altbg1" width="45%"><b>站内文章地图地址:</b><br><span class="">请把站内地图提交到百度站长和360站长平台</span></td>
            <td class=""><input type="text" value="{url rss/articlelist}" name="seo_suffix" style="width:400px;"/></td>
        </tr>
    <tr>
            <td class="altbg1" width="45%"><b>站内标签地图地址:</b><br><span class="">请把站内地图提交到百度站长和360站长平台</span></td>
            <td class=""><input type="text" value="{url rss/tag}" name="seo_suffix" style="width:400px;"/></td>
        </tr>


            <tr>
            <td class="altbg1" width="45%"><b>站内用户地图地址:</b><br><span class="">请把站内地图提交到百度站长和360站长平台</span></td>
            <td class=""><input type="text" value="{url rss/userspace}" name="seo_suffix" style="width:400px;" /></td>
        </tr>
    </table>


<br>
<!--{template footer}-->