 <link rel="stylesheet" type="text/css" href="{SITE_URL}static/js/neweditor/code/styles/tomorrow-night-eighties.css">
    <script type="text/javascript" src="{SITE_URL}static/js/neweditor/code/highlight.pack.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
   <!--{if $setting['cancopy']==1}-->
              <script src="{SITE_URL}static/js/nocopy.js"></script>
                <!--{/if}-->

<script src="{SITE_URL}static/js/jquery.lazyload.min.js"></script>
<script>

 <!--{if $setting['opensinglewindow']==1}-->
 $("a").attr("target","_self");

                <!--{/if}-->
  

                    $("img.lazy").lazyload({effect: "fadeIn" });

</script>

  <div class="side-tool" id="to_top"><ul><li data-placement="left" data-toggle="tooltip" data-container="body" data-original-title="回到顶部" >
    <a href="#" class="function-button"><i class="fa fa-angle-up"></i></a>
    </li>



      </ul></div>
      
       
  
      <script>
window.onload = function(){
	  $(".edui-upload-video").attr("preload","");
  var oTop = document.getElementById("to_top");

  var screenw = document.documentElement.clientWidth || document.body.clientWidth;
  var screenh = document.documentElement.clientHeight || document.body.clientHeight;
  window.onscroll = function(){
    var scrolltop = document.documentElement.scrollTop || document.body.scrollTop;
 
    if(scrolltop<=screenh){
    	oTop.style.display="none";
    }else{
    	oTop.style.display="block";
    }
    if(scrolltop>30){
	     
    	$(".scrollshow").show();
    }else{
    	$(".scrollshow").hide();
    }
  }
  oTop.onclick = function(){
    document.documentElement.scrollTop = document.body.scrollTop =0;
  }
}

</script>

  <footer id="footer">
     {if $regular=='index/index'}
           <!--{eval $links=$this->fromcache('link');}-->

         <!--{if $links }-->
      <div class="link-wrap">
            <div class="content">
                <div class="footer-title">
                    <span class="ilblk title medium fff tc">友情链接</span> 
                </div>
                <div class="links clearfix small">
                <!--{loop $links $link}-->    
                  <a href="{$link['url']}" target="_blank" class="footer-link fl" title="{$link['description']}"> {$link['name']}</a>
                <!--{/loop}-->
                  
         
                </div>
            </div>
        </div>

   <!--{/if}-->
  
        {/if}
        <div class="copyrigth-wrap small">
            <div class="content copyrigth">
                    Copyright © {eval echo date('Y');} {$setting['site_name']} {$setting['site_icp']}
                      <a > <!--{if $setting['site_statcode']}--> {eval echo decode($setting['site_statcode'],'tongji');}<!--{/if}--></a>
            </div>
        </div>
    </footer>
</body>
</html>