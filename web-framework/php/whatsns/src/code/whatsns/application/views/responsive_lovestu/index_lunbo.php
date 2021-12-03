<style>
{if is_mobile()}
div[carousel-item]>* {
    text-align: center;
    line-height: 100px;
    color: #409eff;
}
{else}
div[carousel-item]>* {
    text-align: center;
    line-height: 280px;
    color: #409eff;
}
{/if}


</style>

<div class="layui-carousel" id="test1" lay-filter="test1">
  <div carousel-item="">

    <div class=""><a href="https://wenda.whatsns.com/" target="_blank">  <img {if is_mobile()}style="height: 140px;" {else}style="height: 280px;" {/if}  src="{SITE_URL}static/responsive_lovestu/1.jpg"></a></div>
    <div class=""><a href="https://wenda.whatsns.com/" target="_blank"><img {if is_mobile()}style="height: 140px;" {else}style="height: 280px;" {/if}  src="{SITE_URL}static/responsive_lovestu/2.jpg"></a></div>


  </div>
</div> 
<script>
layui.use(['carousel', 'form'], function(){
  var carousel = layui.carousel
  ,form = layui.form;
  
  //常规轮播
  carousel.render({
    elem: '#test1'
    ,arrow: 'always',
    width: '100%'
    {if is_mobile()}
        ,height: '140px'
        {else}
        ,height: '280px'
        {/if}
  });
  

  
  var $ = layui.$, active = {
    set: function(othis){
      var THIS = 'layui-bg-normal'
      ,key = othis.data('key')
      ,options = {};
      
      othis.css('background-color', '#5FB878').siblings().removeAttr('style'); 
      options[key] = othis.data('value');
      ins3.reload(options);
    }
  };
  

});
</script>
