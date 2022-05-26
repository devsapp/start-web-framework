
<!--{template header}-->

<section class="ui-container">
<!--{template user_title}-->
     <ul class="tab-head">
                                         
                  
                      <li class="tab-head-item "><a href="{url user/invatelist}" title="邀请的人">邀请的人</a></li>
                                                                               
                  
                      <li class="tab-head-item current"><a href="{url user/invateme}" title="邀请回答">邀请回答</a></li>
                                                                               
                  
                            

   
</ul>
   
    <section class="user-content-list">
    
     <div id="list-container">

   <!--{if $questionlist}-->
   
    
 <div class="qlists">

      <!--{loop $questionlist $index $question}-->
    <!--多图文-->
<div class="qlist">
<div class="title weui-flex">
    <div>
    {if $question['hidden']==1}
        <img src="{SITE_URL}static/css/default/avatar.gif">
        {else}
        <img src="{$question['avatar']}">
        {/if}
    </div>
    <div class="weui-flex__item">
       {if $question['hidden']==1}
         <span class="author">匿名用户 </span> 
       
          {else}
          <span class="author">{$question['author']}   {if $question['author_has_vertify']!=false}
        <i class="fa fa-vimeo {if $question['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $question['author_has_vertify'][0]==0}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
         </span>
       
            {/if}
    </div>

</div>
    <p class="qtitle"><a href="{url question/view/$question['id']}">{$question['title']}</a></p>
   
   {if count($question['images'][1])>0}  
<div class="weui-flex">
 {if count($question['images'][1])>1}
 {loop  $question['images'][1] $index $img}
  {if  $index<=2}
    <div class="weui-flex__item"><div class="imgthumbsmall"> <a href="{url question/view/$question['id']}"><img src="{$img}"></a></div></div>
    {/if}
 {/loop}
 {else}
  {if $question['image']!=null&&count($question['images'][1])<=1}
  {loop  $question['images'][1] $index $img}
   <div class="weui-flex__item"><div class="imgthumbbig"><a href="{url question/view/$question['id']}"><img src="{$img}"></a></div></div>
   {/loop}
  {/if}
 {/if}
</div>
 {/if}
<p class="description">

 <a href="{url question/view/$question['id']}">{eval echo clearhtml($question['description'],100);} </a>
</p>
    <p class="meta">
       <span>
          <i class="icon_huida"></i>{$question['answers']}
       </span>
        <span>
           <i class="icon_liulan"></i> {$question['views']}
       </span>
    </p>
</div>
   
   
  <!--{/loop}-->
</div>
 
      <!--{else}-->
       <div class="text">
            还没有人邀请您回答问题~
          </div>
          <!--{/if}-->

  <div class="pages" >{$departstr}</div>   
      </div>
    </section>
</section>


<!--{template footer}-->