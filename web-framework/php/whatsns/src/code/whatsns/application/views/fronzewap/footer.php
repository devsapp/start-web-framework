<div id="footer" style="margin-bottom: 50px;">
	<div class="container">
		<div class="text-center">
			<a href="{SITE_URL}">{$setting['site_name']}</a><span
				class="span-line">|</span> <a href="https://beian.miit.gov.cn/"
				target="_blank">{$setting['site_icp']}</a><!--{if $setting['site_statcode']}-->
	<span class="span-line">&nbsp;&nbsp;</span>{eval echo decode($setting['site_statcode'],'tongji');}
	<!--{/if}-->
		</div>
		
	</div>
</div>

</section>

<div class="tnvk_footer">
	<div
		class="tnvk_f_item <!--{if $regular=='index/default' || $regular==''|| $regular=='index'|| $regular=='index/index'}--> active<!--{/if}-->">
		<a href="{SITE_URL}"> {if $regular=='index/default' || $regular==''||
			$regular=='index'|| $regular=='index/index'} <img class="tnvk_icon"
			src="{SITE_URL}static/css/fronze/css/svg/home_active.svg" /> {else} <img
			class="tnvk_icon" src="{SITE_URL}static/css/fronze/css/svg/home.svg" />
			{/if} <span>首页</span>
		</a>
	</div>
	<div
		class="tnvk_f_item {if $regular=='user/attention'} active{/if}">
		<a href="{url attention/question}"> {if
			$regular=='user/attention'} <img class="tnvk_icon"
			src="{SITE_URL}static/css/fronze/css/svg/guanzhu_active.svg" />
			{else} <img class="tnvk_icon"
			src="{SITE_URL}static/css/fronze/css/svg/guanzhu.svg" /> {/if} <span>关注</span>
		</a>
	</div>
	<div class="tnvk_f_item">
		<a href="{url question/add}">
			<div class="addplus">
				<img class="tnvk_icon"
					src="{SITE_URL}static/css/fronze/css/svg/plus.svg" />
			</div>

		</a>
	</div>
	<div
		class="tnvk_f_item {if $regular=='message/system'||$regular=='message/personal'} active{/if}">
		<a href="{url message/personal}"> {if
			$regular=='message/system'||$regular=='message/personal'} <img
			class="tnvk_icon"
			src="{SITE_URL}static/css/fronze/css/svg/msg_active.svg" /> {else} <img
			class="tnvk_icon" src="{SITE_URL}static/css/fronze/css/svg/msg.svg" />
			{/if} <span>消息<span class="msg-count"><span class="m_num"></span></span></span>
		</a>
	</div>
	<div class="tnvk_f_item {if $regular=='user/score'} active{/if}">
		<a href="{url user/score}"> {if $regular=='user/score'} <img
			class="tnvk_icon"
			src="{SITE_URL}static/css/fronze/css/svg/my_active.svg" /> {else} <img
			class="tnvk_icon" src="{SITE_URL}static/css/fronze/css/svg/my.svg" />
			{/if} <span>我的</span>
		</a>
	</div>
</div>
<div id="to_top"></div>

<script src="{SITE_URL}static/js/jquery-1.11.3.min.js"></script>
<script src="{SITE_URL}static/css/fronze/js/main.js?v1.1"></script>
<script>$.noConflict();</script>
<script src="{SITE_URL}static/js/jquery.lazyload.min.js"></script>
<script type="text/javascript">
jQuery(".qlist img").addClass("lazy");


 jQuery("img.lazy").lazyload({effect: "fadeIn" });
</script>
<script>
$(document).ready(function(){  
	  $(".edui-upload-video").attr("preload","");
    var p=0,t=0;  
    var oTop = document.getElementById("to_top");
    var screenw = document.documentElement.clientWidth || document.body.clientWidth;
    var screenh = document.documentElement.clientHeight || document.body.clientHeight;
    $(window).scroll(function(e){  
            p = $(this).scrollTop();  
            var scrolltop = document.documentElement.scrollTop || document.body.scrollTop;
            if(scrolltop<=screenh){
            	oTop.style.display="none";
            }else{
            	oTop.style.display="block";
            }
            if(t<=p){//下滚  
            	if(scrolltop>50){
            		 $(".nav_top").hide();
            	}
        
            }  
              
            else{//上滚  
            	$(".nav_top").show();
            	
            }  
            setTimeout(function(){t = p;},0);         
    });  
    oTop.onclick = function(){
        document.documentElement.scrollTop = document.body.scrollTop =0;
      }
});  
  

</script>

</body>
</html>