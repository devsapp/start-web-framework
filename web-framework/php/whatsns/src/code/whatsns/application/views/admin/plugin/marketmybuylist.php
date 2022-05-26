<!--{template header,admin}-->

<div style="width:100%; color:#000;">
    <div >
    <ol class="breadcrumb" style="margin-bottom:0px;">
  <li><a href="{url admin_main/stat}">后台首页</a></li>
   <li><a href="{url admin_market/clist}">应用市场</a></li>
  <li class="active">{$navtitle}</li>
</ol>
</div>
<div style="padding:8px;">

<div class="row" id="appshowlist" style="margin-top:16px;">
{template market_buyapplist}
</div>
</div>
<script type="text/javascript">

</script>
<!--{template footer,admin}-->
</div>