<!DOCTYPE html>
<html lang="cn">
  <!--{eval global $starttime,$querynum;$mtime = explode(' ', microtime());$runtime=number_format($mtime[1] + $mtime[0] - $starttime,6); $setting=$this->setting;$user=$this->user;$regular=$this->regular;$toolbars="'".str_replace(",", "','", $setting['editor_toolbars'])."'";}-->


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--{if isset($seo_title)}-->
        <title>{$seo_title}</title>
        <!--{else}-->
        <title><!--{if $navtitle}-->{$navtitle} - <!--{/if}-->{$setting['site_name']}</title>
        <!--{/if}-->
        <!--{if isset($seo_description)}-->
        <meta name="description" content="{$seo_description}" />
        <!--{else}-->
        <meta name="description" content="{$setting['site_name']}" />
        <!--{/if}-->

        <meta name="keywords" content="{$seo_keywords}" />
        <meta name="author" content="whatsns Team" />
        <meta name="copyright" content="2019 www.whatsns.com" />
      <meta name="applicable-device" content="pc"/>
      <meta name="version" content="whatsns问答系统 {ASK2_VERSION}-up{ASK2_RELEASE}"/>
      {if trim(config_item('mobile_domain')) }
      <script type="text/javascript">
      function IsPC() {
    	  var userAgentInfo = navigator.userAgent;
    	  var Agents = ["Android", "iPhone",
    	        "SymbianOS", "Windows Phone",
    	        "iPad", "iPod"];
    	  var flag = true;
    	  for (var v = 0; v < Agents.length; v++) {
    	    if (userAgentInfo.indexOf(Agents[v]) > 0) {
    	      flag = false;
    	      break;
    	    }
    	  }
    	  return flag;
    	}
  	
        var _currenturl=window.location.href;
       var _baseurl="{eval echo trim(config_item('base_url'));}";
       var _mobilebaseurl="{eval echo trim(config_item('mobile_domain'));}";
       var _mobileurl=_currenturl.replace(_baseurl,_mobilebaseurl);
     if(!IsPC()){
    	 window.location.href=_mobileurl;
     }
      
      
      </script>
      {/if}
      <link href="{SITE_URL}static/css/widescreen/css/zui.min.css" rel="stylesheet">
    <link rel="stylesheet" media="all" href="{SITE_URL}static/css/common/animate.min.css" />
    <link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/greenzhongchou.css?v1.2" />
    <link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/greencommon.css?v1.2" />

    <link rel="stylesheet" href="{SITE_URL}static/css/widescreen/css/whatsns.css?v1.2" media="screen" type="text/css">
    <link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/greencustom.css" />
    <link href="{SITE_URL}static/css/static/css/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="{SITE_URL}static/css/widescreen/css/green_main.css?v1.2">
    <link rel="stylesheet" href="{SITE_URL}static/css/widescreen/css/slider.css">
    <link rel="stylesheet" href="{SITE_URL}static/css/widescreen/css/basepage.css">
    <link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/flat/index.css" />
       <link href="{SITE_URL}static/css/widescreen/css/kc.css" rel="stylesheet">
           <link rel="stylesheet" href="{SITE_URL}static/css/widescreen/css/index/css/reset.css">
    <link rel="stylesheet" href="{SITE_URL}static/css/widescreen/css/index/css/index.css">
<script src="{SITE_URL}static/js/jquery-1.11.3.min.js"></script>
<script src="{SITE_URL}static/js/ie.js" type="text/javascript"></script>
<!-- ZUI Javascript组件 -->
<script src="{SITE_URL}static/css/dist/js/zui.min.js"></script>
 <script src="{SITE_URL}static/css/widescreen/js/common.js"></script>
  <script src="{SITE_URL}static/css/widescreen/js/cdn.js?v=1.0"></script>
   <script type="text/javascript" src="{SITE_URL}static/js/jquery.qrcode.min.js"></script>
    <!--[if lt IE 9]>
    <script src="{SITE_URL}static/css/dist/lib/ieonly/html5shiv.js"></script>
    <script src="{SITE_URL}static/css/dist/lib/ieonly/respond.js"></script>
    <![endif]-->
    <script type="text/javascript">
          var g_site_url = "{SITE_URL}";
            var g_site_name = "{$setting['site_name']}";
            var g_prefix = "{$setting['seo_prefix']}";
            var g_suffix = "{$setting['seo_suffix']}";
            var g_uid = {$user['uid']};
            var qid = 0;
            </script>
            {if $topicid&&$topicone['xzsrc']&&$setting['xiongzhang_appid'] }
<script type="application/ld+json">
    {
        "@context": "https://ziyuan.baidu.com/contexts/cambrian.jsonld",
        "@id": "{SITE_URL}{eval echo substr($_SERVER['REQUEST_URI'],1);}",
        "appid": "{eval echo trim($setting['xiongzhang_appid']);}",  //替换成自己的appid值
        "title": "{$navtitle}",
        "images": [
        "{$topicone['xzsrc']}"
        ],
        "pubDate": "{eval echo date('Y-m-d',$topicone['timespan']);}T{eval echo date('H:i:s',$topicone['timespan']);}" 
    }

</script>
{/if}
</head>
<body>