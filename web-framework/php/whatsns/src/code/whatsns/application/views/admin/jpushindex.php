<!--{template header}-->
<script type="text/javascript" src="{SITE_URL}static/js/jquery-ui/jquery-ui.js"></script>
<script src="{SITE_URL}static/js/admin.js" type="text/javascript"></script>

<style>
em{
	color:red;
}
</style>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;推送管理</div>
</div>
<!--{if isset($message)}-->

<div class="alert alert-warning">{$message}</div>
<!--{/if}-->

<div class="alert alert-success" style="margin:20px auto">这里只做简单的给推送全部用户，复杂的移步到极光网站自己应用推送配置里。</div>

<form action="{SITE_URL}index.php?admin_jpush/sendmessage{$setting['seo_suffix']}" method="post">
<div class="row container">
<div class="col-md-24">
<textarea rows="4" cols="3" name="sendmsg" class="form-control" style="max-width:400px;"></textarea>
</div>
<br>
<button class="btn btn-success">推送</button>
</div>
</form>
<!--{template footer}-->
<script>

{if $srchcategory}
$(document).ready(function(){
    $("#srchcategory option").each(function(){
        if($(this).val()==$srchcategory){
            $(this).prop("selected","true");
        }
    });
});
{/if}
</script>