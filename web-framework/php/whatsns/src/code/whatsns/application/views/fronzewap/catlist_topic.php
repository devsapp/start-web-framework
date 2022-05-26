<!--{template header}-->
<style>
.zthead {
    position: relative;
    min-height: 60px;
    padding: 10px 10px 0px 70px;
    border-bottom: 1px solid #e6e6e6;
    background-color: #fff;
}
.zthead .img, .zthead .img {
    position: absolute;
    left: 10px;
    top: 10px;
}
.img img {
    border-radius: 4px;
}
.zthead .title
{
    display: table;
    content: " ";
	margin:0px;

}
.zthead h1, .zthead h1 {
    margin: 3px 0 5px 0;
    font-size: 17px;
    color: #333;
}
.zthead p, .zthead p {
    margin: 0;
  font-size:12px;
}
.c-hui {
    color: #999999;
}
.fl {
    float: left!important;
}
</style>
<div class="zthead ui-clear">
			<a class="img"><img width="50" src="$catmodel['bigimage']" alt="{$catmodel['name']}"></a>
			<div class="title ui-clear">
				<h1 class="fl"> {$catmodel['name']}</h1>
							</div>
							 <p class="c-hui"> 
			        收录了{$rownum}篇文章 ·{$catmodel['questions']}个问题 · {$catmodel['followers']}人关注
		</p>
		</div>
<section class="sec-result">
 <div class="ui-tab" id="tab1">
    <ul class="ui-tab-nav ui-border-b" style="font-size:13px;">
         <li class="current">
        <a href="{url topic/catlist/$cid}">全部文章</a>
        </li>
       
        
           <li>
       <a href="{url category/view/$catmodel['id']}">相关讨论</a>
        </li>
      
    </ul>
  <div id="list-container">
        <!-- 文章列表模块 -->
 <div class="qlists">
      <!--{loop $topiclist $index $topic}-->   
    <!--多图文-->
<div class="qlist">
<div class="title weui-flex">
    <div>
   
        <img src="{$topic['avatar']}">
        
    </div>
    <div class="weui-flex__item">

          <span class="author">{$topic['author']}   {if $topic['author_has_vertify']!=false}
        <i class="fa fa-vimeo {if $topic['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title=""  ></i>{/if}
         </span>
       
          
    </div>

</div>
    <p class="qtitle"><a href="{url topic/getone/$topic['id']}">{$topic['title']}</a></p>
   
   {if count($topic['images'][1])>0}  
<div class="weui-flex">
 {if count($topic['images'][1])>1}
 {loop  $topic['images'][1] $index $img}
 {if  $index<=2}
    <div class="weui-flex__item"><div class="imgthumbsmall"> <a href="{url topic/getone/$topic['id']}"><img src="{$img}"></a></div></div>
    {/if}
 {/loop}
 {else}
  {if $topic['image']!=null&&count($topic['images'][1])<=1}
  {loop  $topic['images'][1] $index $img}
   <div class="weui-flex__item"><div class="imgthumbbig"><a href="{url topic/getone/$topic['id']}"><img src="{$img}"></a></div></div>
   {/loop}
  {/if}
 {/if}
</div>
 {/if}
<p class="description">
 <a href="{url topic/getone/$topic['id']}" style="color:#333"> 
      {if $topic['price']!=0}
                                              <div class="box_toukan ">
  {eval echo clearhtml($topic['freeconent'],50);}
  {if $topic['readmode']==2}
  
											<a  class="thiefbox font-12" ><i class="icon icon-lock font-12"></i> &nbsp;更多阅读需支付&nbsp;$topic['price']&nbsp;&nbsp;积分……</a>

   {/if}
        {if $topic['readmode']==3}		                      
											<a  class="thiefbox font-12" ><i class="icon icon-lock font-12"></i> &nbsp;更多阅读需支付&nbsp;$topic['price']&nbsp;&nbsp;元……</a>

		                    {/if}
										</div>
                   {else}
                   {eval echo clearhtml($topic['describtion'],50);}

                    {/if}
                    </a>
</p>
    <p class="meta">
       <span>
          <i class="icon_huida"></i>{$topic['articles']}
       </span>
        <span>
           <i class="icon_liulan"></i> {$topic['views']}
       </span>
    </p>
</div>
   
   
  <!--{/loop}-->
</div>

      </div>
</div>
   <div class="pages">{$departstr}</div>
</section>






<!--{template footer }-->