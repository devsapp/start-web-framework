  <!-- 公共头部--> 
{template header}
<div class="layui-container fly-marginTop">
	<div class="fly-panel">
	  <div class="fly-none">
	    <h2><i class="layui-icon layui-icon-tips font200"></i></h2>
      <p>{$message}</p>
          <div class="text-center ">
        <!--{if $redirect == 'BACK'}-->
        <a  href="javascript:history.go(-1);">返回原处</a>&nbsp;&nbsp;
        <a  href="{url user/ask}">我的提问</a>&nbsp;&nbsp;
        <a  href="{SITE_URL}">回到首页</a>
        <!--{elseif $redirect!='STOP'}-->
       页面将在<span id="seconds">3</span>秒后自动跳转到下一页，你也可以直接点 <a href="$redirect" >立即跳转</a>。
        <script type="text/javascript">
            var seconds = 3;
            var inter=window.setInterval(function() {
                --seconds;
                if (seconds == 1) {
                    clearInterval(inter);
                   window.location = "$redirect";
                }
                document.getElementById("seconds").innerHTML=seconds
               
            }, 1000);
        </script>
        <!--{/if}-->
    </div>
	  </div>
	</div>
</div>
 <!-- 公共底部 --> 
{template footer}