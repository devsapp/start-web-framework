<!DOCTYPE html>
<html lang="cn">
<!--{eval global $starttime,$querynum;$mtime = explode(' ', microtime());$runtime=number_format($mtime[1] + $mtime[0] - $starttime,6); $setting=$this->setting;$user=$this->user;$regular=$this->regular;$toolbars="'".str_replace(",", "','", $setting['editor_toolbars'])."'";}-->
{eval $caifuzhiname="财富值"}
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--{if isset($seo_title)}-->
<title>{$seo_title}</title>
<!--{else}-->
<title><!--{if $navtitle}-->{$navtitle} - <!--{/if}-->{$setting['site_name']}
</title>
<!--{/if}-->
<!--{if isset($seo_description)}-->
<meta name="description" content="{$seo_description}" />
<!--{else}-->
<meta name="description" content="{$setting['site_name']}" />
<!--{/if}-->
<meta name="keywords" content="{$seo_keywords}" />
<link rel="stylesheet"	href="{SITE_URL}static/responsive_fly/res/layui/css/layui.css">
<link rel="stylesheet"	href="{SITE_URL}static/responsive_fly/res/css/global.css">
<link rel="stylesheet"	href="{SITE_URL}static/responsive_fly/res/css/main.css">
<script src="{SITE_URL}static/js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="{SITE_URL}static/responsive_fly/res/layui/layui.js"></script>

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