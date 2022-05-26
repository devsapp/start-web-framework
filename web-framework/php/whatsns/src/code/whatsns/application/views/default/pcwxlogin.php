  <!--{eval global $starttime,$querynum;$mtime = explode(' ', microtime());$runtime=number_format($mtime[1] + $mtime[0] - $starttime,6); $setting=$this->setting;$user=$this->user;$regular=$this->regular;$toolbars="'".str_replace(",", "','", $setting['editor_toolbars'])."'";}-->

<!doctype html>
<html  lang="ch">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>微信扫码登录</title>
  
  <style>
  body{
  background:#333;
  margin-top:100px;
  
  }
  .wxcodeshowtext{
  display: inline-block;
    width: 280px;
    height: 46px;
    line-height: 46px;
    margin: 20px auto 0;
    padding: 0 40px;
    box-shadow: 0 5px 10px -5px #191919 inset, 0 1px 0 0 #444;
    border-radius: 20px;
    color: #fff;
  }
   h1 {
    margin-bottom: 20px;
    font-size: 20px;
    text-shadow: 0 2px 0 #333;
    color: #fff;
    text-align: center;
}
  </style>
      <script type="text/javascript">
          var g_site_url = "{SITE_URL}";
            var g_site_name = "{$setting['site_name']}";
            var g_prefix = "{$setting['seo_prefix']}";
            var g_suffix = "{$setting['seo_suffix']}";
            var g_uid = 0;
            var qid = 0;
            </script>
  </head>
  <body>
  <h1>微信登录</h1>
     <center>  <img id="loginqrcode" src="{SITE_URL}lib/getqrcode.php?data=$qrcode" class="dasahngqrcode" style="width:240px;height:240px;" /></center>
        <center>   <h2 class="chongzhitishi hide loginqecodetext wxcodeshowtext" style="font-size:14px;color:#fff;text-align:center;margin-top:10px;">使用微信扫一扫</h2></center>
 <h2 class="chongzhitishi hide daojishitext" style="font-size:14px;color:#fff;text-align:center;margin-top:10px;"></h2>
 
<script src="{SITE_URL}static/js/jquery-1.11.3.min.js"></script>
 <script src="{SITE_URL}static/css/widescreen/js/common.js?v=2"></script>
  <script type="text/javascript">
getloginresult($time);
</script>
   </body>
   </html>