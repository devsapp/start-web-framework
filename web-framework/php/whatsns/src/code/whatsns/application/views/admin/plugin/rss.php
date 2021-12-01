<!--{template header,admin}-->
<div style="width:100%; color:#000;margin:0px 0px 10px;">
    <div >
    <ol class="breadcrumb">
  <li><a href="{url admin_main/stat}">后台首页</a></li>
  <li><a href="{url admin_myplugin/clist}">插件列表</a></li>
  <li class="active">{$navtitle}</li>
</ol>

</div>
<div class="alert alert-warning"><p><strong>提示:</strong><a target="_blank" href="https://www.whatsns.com/doc/6.html"><b>宝塔面板中设置计划任务自动推送方法</b></a></div>
    <table class="table">
        <tr class="header">
            <td colspan="2">全站SiteMap站点地图---记得提交搜索引擎，收录杠杠的【自动更新，站内同步】</td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>站内问题地图地址:</b><br><span class="">请把站内地图提交到百度站长和360站长平台</span></td>
            <td class=""><input type="text" value="{eval echo str_replace('.html','.xml',url('rss/clist'));}" name="seo_suffix" style="width:400px;"/></td>
        </tr>
   <tr>
            <td class="altbg1" width="45%"><b>站内文章地图地址:</b><br><span class="">请把站内地图提交到百度站长和360站长平台</span></td>
            <td class=""><input type="text" value="{eval echo str_replace('.html','.xml',url('rss/articlelist'));}" name="seo_suffix" style="width:400px;"/></td>
        </tr>
    <tr>
            <td class="altbg1" width="45%"><b>站内标签地图地址:</b><br><span class="">请把站内地图提交到百度站长和360站长平台</span></td>
            <td class=""><input type="text" value="{eval echo str_replace('.html','.xml',url('rss/tag'));}" name="seo_suffix" style="width:400px;"/></td>
        </tr>
            <tr>
            <td class="altbg1" width="45%"><b>站内用户地图地址:</b><br><span class="">请把站内地图提交到百度站长和360站长平台</span></td>
            <td class=""><input type="text" value="{eval echo str_replace('.html','.xml',url('rss/userspace'));}" name="seo_suffix" style="width:400px;" /></td>
        </tr>
    </table>
    <div style="margin-top: 16px;padding:8px;">
<p><b>打开站点目录下rss生成文件【路径:application\controllers\Rss.php】，修改默认显示数量，xml数量最大不超过50000。</b></p>
<img src="https://www.whatsns.com/data/ueditor/php/upload/image/20201104/1604457078344381.png"/>
</div>
<div style="margin-top: 16px;padding:8px;">
<p style="color:#03A9F4"><b>静态xml地址,需要访问上面动态地址后生成（推荐)</b></p>
<p>问题xml：<b>{SITE_URL}question.xml</b><span style="margin-left: 8px;">访问一次{eval echo str_replace('.html','.xml',url('rss/clist'));}后此静态地址刷新一次内容</span></p>
<p>问题xml：<b>{SITE_URL}article.xml</b><span style="margin-left: 8px;">访问一次{eval echo str_replace('.html','.xml',url('rss/articlelist'));}后此静态地址刷新一次内容</span></p>
<p>问题xml：<b>{SITE_URL}tag.xml</b><span style="margin-left: 8px;">访问一次{eval echo str_replace('.html','.xml',url('rss/tag'));}后此静态地址刷新一次内容</span></p>
<p>问题xml：<b>{SITE_URL}user.xml</b><span style="margin-left: 8px;">访问一次{eval echo str_replace('.html','.xml',url('rss/userspace'));}后此静态地址刷新一次内容</span></p>
</div>
<div style="margin-top: 16px;padding:8px;">
<p><b>ps:您可以在宝塔面板计划任务中定时设置设置访问上面动态地址，将静态地址提交给百度站长后台或者360站长后台</b></p>
<p>提交入口看图（百度站长平台）https://ziyuan.baidu.com/</p>
<img style="margin-bottom:8px;" src="https://www.whatsns.com/data/ueditor/php/upload/image/20201104/1604456654697316.png"/>
<img src="https://www.whatsns.com/data/ueditor/php/upload/image/20201104/1604456546873072.png" />
</div>
<!--{template footer,admin}-->
</div>
