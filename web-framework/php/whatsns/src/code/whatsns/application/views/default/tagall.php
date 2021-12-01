<!--{template header}-->

<style>
.main-wrapper {
    margin-bottom: 40px;
    background: #fff;
}
.tag-list__itembody {
    padding: 20px 0;
    margin-bottom: 0;
}
.text-muted {
margin-right:10px;
}
.pages {
    padding: 10px 0px 10px 0px;
    font-family: Tahoma;
    font-weight: bold;
    text-align: center;
}
.mt20{
margin-top:20px;
}
.tag-list__item{
margin-left:0px;
    padding-left: 0px;
}
</style>
<div class="container collection index tagindex" style="padding-top:10px;">


<h1 class="h3 mt20">标签<br><small>标签是最有效的内容组织形式，正确的使用标签能更快的发现和解决你的问题</small></h1>

      
<div class="row tag-list mt20">
{loop $taglist $tag}
<section class="tag-list__item col-md-6">
                <div class="widget-tag">
                    <h2 class="h4">
                        <a href="{url tags/view/$tag['tagalias']}" class="">{$tag['tagname']}</a>
                    </h2>
                                        <p>{if $tag['description']}$tag['description']{else}暂无相关描述{/if}</p>
                                        <div class="widget-tag__action">

                        <button class="btn btn-default btn-xs mr5 tagfollow hide" >加关注</button>

                        <strong class="follows">{$tag['tagquestions']}</strong> <span class="text-muted">问题</span><strong class="follows">{$tag['tagarticles']}</strong> <span class="text-muted">文章</span>
                    </div>
                </div>
            </section>
            {/loop}
            
</div>
<div class="pages">
{$departstr}
</div>
</div>
<!--{template footer}-->