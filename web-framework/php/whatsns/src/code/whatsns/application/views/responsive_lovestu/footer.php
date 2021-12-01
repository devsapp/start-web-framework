
  <footer>

<div class="footer-plane">
    <div class="footer-container">
        <div>
            <div class="footer-aside-box">			<div class="textwidget"><p>{$setting['seo_index_description']}</p>
</div>
		</div>        </div>
        <div>
            <nav class="menu-footer-plane"><ul id="menu-%e5%ba%95%e9%83%a8%e8%8f%9c%e5%8d%95" class="menu-footer-list"><li id="menu-item-305" class="menu-item menu-item-305"><a href="{url rss/list}" target="_blank">站点地图</a></li>
<li id="menu-item-306" class="menu-item menu-item-306"><a href="{url tags/default}" target="_blank">站点标签</a></li>
<li id="menu-item-307" class="menu-item menu-item-307"> <a href="{url ask/index}" target="_blank">站点题库</a></li>
</ul></nav>            <div class="footer-info">
               Copyright © {eval echo date('Y');} WHATSNS · <a href="{SITE_URL}">{$setting['site_name']}</a> · {$setting['site_icp']}           </div>
        </div>
        <div class="footer-details">
            <div>                    <img src="{$setting['weixin_logo']}" alt="">
                                    <p></p>
            </div>
           
        </div>
    </div>
</div>

    </footer>
</div>
 {if $regular!='user/login'&&$regular!='user/register'&&$regular!='user/getpass'&&$regular!='user/getphonepass'}
<div class="layui-hide-md">

{template wapfooter}

</div>
{else}
<style>
.footer-plane {
    margin-bottom: 0px;
}
</style>
{/if}
 <script>
layui.use(['jquery', 'layer'], function(){ 
  var $ = layui.$ //重点处
  ,layer = layui.layer;
  var tips;
  $(".link-tips").hover(function () { 
      tips = layer.tips($(this).attr("title"), $(this),{
         tips: [1, '#555555']
         // 上右下左四个方向，通过1-4进行方向设定
     });
     
 },function(){
 	layer.close(tips);
 });
<!--{if $setting['opensinglewindow']==1}-->
 $("a").attr("target","_self");

                <!--{/if}-->
 $(".lazy").each(function(){
	 $(this).attr("src",$(this).attr("data-original"))
 })
});
 

</script>


<script>

layui.cache.page = 'user';
layui.cache.user = {
  username: '{if $user['username']}$user['username']{else}游客{/if}'
  ,uid: {if $user['uid']}$user['uid']{else}-1{/if}
  ,avatar: '{$user['avatar']}'
  ,experience: 83
  ,sex: '{if $user['sex']==1}女{else}男{/if}'
};
layui.config({
  version: "3.0.0"
  ,base: '{SITE_URL}static/responsive_fly/res/mods/' 
}).extend({
  fly: 'index'
}).use('fly');
</script>

</body>
</html>