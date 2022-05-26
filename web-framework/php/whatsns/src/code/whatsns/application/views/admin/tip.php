<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>操作提示</title>

    <!-- zui -->
    <link href="{SITE_URL}static/css/dist/css/zui.min.css" rel="stylesheet">
  <!-- Font Awesome Icons -->
    <link href="{SITE_URL}static/css/static/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />


        <link href="{SITE_URL}static/css/admin/mishen.css" rel="stylesheet" type="text/css" />
    <!--[if lt IE 9]>
    <script src="{SITE_URL}static/css/dist/lib/ieonly/html5shiv.js"></script>
    <script src="{SITE_URL}static/css/dist/lib/ieonly/respond.js"></script>
    <![endif]-->

</head>
<body  >
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<div class="container">
<table class="table">
	<tr class="header"><td>消息提示</td></tr>
	<tr class="altbg2"><td><font color="#FFA406">{$message}</font>
	<!--{if 'BACK'!=$redirect}-->
		<br /><span class="smalltxt">页面将在3秒后自动跳转到下一页，你也可以直接点 <a href="$redirect" >立即跳转</a>。</span>
		<script type="text/javascript">
			function redirect(url, time) {
				setTimeout("window.location='" + url + "'", time * 1000);
			}
			redirect('$redirect', 3);
		</script>
	 <!--{/if}-->
  </td></tr>
</table>
</div>
<!--{/if}-->
<!--{template footer}-->