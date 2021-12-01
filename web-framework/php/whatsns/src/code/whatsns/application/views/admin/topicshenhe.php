<!--{template header}-->
<style>
.contentarticle{
margin-top:10px;
}
</style>
<script type="text/javascript">g_site_url='{SITE_URL}';g_prefix='{$setting['seo_prefix']}';g_suffix='{$setting['seo_suffix']}';</script>

<script src="{SITE_URL}static/js/common.js" type="text/javascript"></script>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;审核文章</div>
</div>
<div class="container" style="background: #fff">
<form method="post"  name="answerlist" >

<p>分类：$catmodel['name']</p>
<p>标签：{$topic['topic_tag']}</p>
<p>
封面图：
<img src="{$topic['image']}">
</p>
<h1>
标题:{$topic['title']}
</h1>

<article class="contentarticle">
<h2>内容：</h2>
{$topic['describtion']}
</article>
<input type="hidden" name="viewtid" value="1">
<input type="hidden" name="tid" value="{$topic['id']}">
<button class="btn" onclick="buttoncontrol(2)">删除</button>
<button class="btn" onclick="buttoncontrol(4)">审核通过</button>
<a target="_blank" class="btn" href="{url admin_topic/edit/$topic['id']}">编辑</a>
</form>
</div>

<script>
function buttoncontrol(num) {

  	   switch (num) {
  
         case 2:
      	   if (confirm('确定删除问题？该操作不可返回！') == false) {
                 return false;
             } else {
             document.answerlist.action = "index.php?admin_topic/remove{$setting['seo_suffix']}";
             document.answerlist.submit();
             }
             break;
         case 4:
      	   if (confirm('确认审核通过吗！') == false) {
                 return false;
             } else {
             document.answerlist.action = "index.php?admin_topic/vertify{$setting['seo_suffix']}";
             document.answerlist.submit();
             }
             break;
  	   }

}
</script>

<!--{template footer}-->