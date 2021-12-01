<!--{template meta}-->
<style>
    .ui-notice *{
        font-size: .16rem;;
    }
.ui-notice>i:before {
    font-family: iconfont!important;
    font-size: 32px;
    line-height: 44px;
    font-style: normal;
    -webkit-font-smoothing: antialiased;
    -webkit-text-stroke-width: .2px;
    display: block;
    color: rgba(0,0,0,.5);
    content: "";
    font-size: 100px;
    line-height: 100px;
    color: #31b7ad;
}
</style>
<section class="ui-notice">
    <i style="color:#31b7ae"></i>
    <p>{$message}</p>
 
    
     <!--{if $message=='登陆成功!'||trim($message)=='成功退出!'||trim($message)=='问题已经被删除!'}-->
     
       <script type="text/javascript">
       setTimeout(function(){
    	   window.location.href="{SITE_URL}";
       },2000);
       
     
       </script>
     <!--{/if}-->
    <div class="ui-notice-btn">
     <!--{if $redirect == 'BACK'}-->
      <button onclick="history.go(-1);" class="ui-btn-primary ui-btn-lg" style="background:#31b7ae">返回</button>
        <!--{elseif $redirect!='STOP'}-->
       
      <p style="color:#777;">  页面将在<span id="seconds">3</span>秒后自动跳转到下一页，你也可以直接点 <a href="$redirect" >立即跳转</a>。
          </p>
            <script type="text/javascript">
            var seconds = 3;
            var inter=window.setInterval(function() {
                seconds--;
                if (seconds == 1) {
                    clearInterval(inter);
                   window.location = "$redirect";
                }
                $("#seconds").html(seconds);
            }, 1000);
        </script>
        
           <!--{/if}-->
       
    </div>
</section>
