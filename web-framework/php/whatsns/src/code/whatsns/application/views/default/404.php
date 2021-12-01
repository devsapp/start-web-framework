                                                        <!DOCTYPE html>
<html>
 <!--{eval global $starttime,$querynum;$mtime = explode(' ', microtime());$runtime=number_format($mtime[1] + $mtime[0] - $starttime,6); $setting=$this->setting;$user=$this->user;$headernavlist=$this->nav;$regular=$this->regular;$toolbars="'".str_replace(",", "','", $setting['editor_toolbars'])."'";}-->
<head lang="en">
    <meta charset="UTF-8">
   <!--{if isset($seo_title)}-->
        <title>{$seo_title}</title>
        <!--{else}-->
        <title><!--{if $navtitle}-->{$navtitle} - <!--{/if}-->{$setting['site_name']}</title>
        <!--{/if}-->
        <!--{if isset($seo_description)}-->
        <meta name="description" content="{eval echo cutstr($seo_description,160,'')}" />
        <!--{else}-->
        <meta name="description" content="{$setting['site_name']}" />
        <!--{/if}-->
        <meta name="keywords" content="{$seo_keywords}" />
<style type="text/css">

a,fieldset,img{border:0;}

a:hover{color:#3366cc;text-decoration:underline;}
body{font-size:24px;color:#B7AEB4;}
body a.link,body h1,body p{-webkit-transition:opacity 0.5s ease-in-out;-moz-transition:opacity 0.5s ease-in-out;transition:opacity 0.5s ease-in-out;}
#wrapper{text-align:center;margin:100px auto;width:594px;}
a.link{text-shadow:0px 1px 2px white;font-weight:600;color:#3366cc;opacity:1;}
h1{text-shadow:0px 1px 2px white;font-size:24px;opacity:1;}
img{-webkit-transition:opacity 1s ease-in-out;-moz-transition:opacity 1s ease-in-out;transition:opacity 1s ease-in-out;height:202px;width:199px;opacity:1;}
p{text-shadow:0px 1px 2px white;font-weight:normal;font-weight:200;opacity:1;}
.fade{opacity:1;}
@media only screen and (min-device-width:320px) and (max-device-width:480px){
 #wrapper{margin:40px auto;text-align:center;width:280px;}
}
</style>
  [removed][removed]
<!--[if IE 6]>[removed]document.execCommand("BackgroundImageCache", false, true);[removed]<![endif]-->

</head>
<body>

    <div id="wrapper">
    <a href="{SITE_URL}"><img src="http://www.ask2.cn/data/upload/404_icon.png"></a>
        <div>
            <h1>唉呀!</h1>
            <p>你正在寻找的页面无法找到。<a href="{SITE_URL}">可能在这里！</a></p>
            <a class="link" href="/">返回?</a>
        </div>
    </div>
[removed]
$(document).ready(function(){


 
  $("img").addClass('fade').delay(800).queue(function(next){
   $("h1, p").addClass("fade");
   $("a.link").css("opacity", 1);
   
   next();
  });
 
});
[removed]
</body></html>
                        
                        