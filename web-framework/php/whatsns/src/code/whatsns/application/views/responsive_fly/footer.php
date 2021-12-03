
<div class="fly-footer">
  <p><a href="{SITE_URL}" target="_blank">{$setting['site_name']}</a> {eval echo date('Y');} &copy; <a href="{SITE_URL}" target="_blank">www.whatsns.com 出品</a></p>
  <p>
    <a href="{url rss/list}" target="_blank">站点地图</a>
    <a href="{url tags/default}" target="_blank">站点标签</a>
    <a href="{url ask/index}" target="_blank">站点题库</a>
  </p>
</div>
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