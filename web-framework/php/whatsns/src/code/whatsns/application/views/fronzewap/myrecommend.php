<!--{template header}-->
<style>
.note-list{
	padding:10px;
}
.note-list .question_title{
	color:#333;
}
</style>
<section class="ui-container">
<!--{template user_title}-->

   
    <section class="user-content-list">
        
              <!--{if $questionlist}-->
                  <div class="titlemiaosu">
           为我推荐的问题
            </div>
     <ul class="note-list">
 
   
      <!--{loop $questionlist $question}-->
                
    <li id="note-{$question['id']}" data-note-id="{$question['id']}" {if $question['image']!=null}  class="have-img" {else}class="" {/if}>
    {if $question['image']!=null}  
      <a class="wrap-img" {if $question['articleclassid']!=null} href="{url topic/getone/$question['id']}"  {else}  href="{url question/view/$question['id']}" {/if} target="_blank">
            <img src="{$question['image']}">
        </a>
            {/if}
        <div class="content">
            <div class="author">
            
            
               
                
                   
        {if $question['hidden']==1}
  
          <a class="avatar"  href="javascript:void(0)">
                    <img src="{$question['avatar']}" alt="96">
                </a>      <div class="name">
                <a class="blue-link"  href="javascript:void(0)">匿名用户</a>
                
                
        {else}
        <a class="avatar" target="_blank" href="{url user/space/$question['authorid']}">
                    <img src="{$question['avatar']}" alt="96">
                </a>      <div class="name">
                <a class="blue-link" target="_blank" href="{url user/space/$question['authorid']}">{$question['author']}</a>
                
        {/if}
        
                
                <span class="time" data-shared-at="{$question['format_time']}">{$question['format_time']}</span>
            </div>
            </div>
            <a  class="question_title"   href="{url question/view/$question['id']}"  >{$question['title']}</a>
        
            <div class="meta">

                <a target="_blank"  href="{url question/view/$question['id']}" >
                    <i class="fa fa-eye"></i> {$question['views']}
                </a>        <a target="_blank"   href="{url question/view/$question['id']}#comments" >
                <i class="fa fa-comment-o"></i> {$question['answers']}
            </a>      <span><i class=" fa fa-heart-o"></i>  {$question['attentions']}</span>
            </div>
        </div>
    </li>

    <!--{/loop}-->
    </ul>
      <div class="pages" >{$departstr}</div>   
      <!--{else}-->
<section class="ui-notice" style="z-index:-1;">
    <i></i>
    <p>亲，快设置下擅长领域吧，设置后可根据您的兴趣爱好为您推荐合适的问题!</p>
    <div class="ui-notice-btn">
        <button class="ui-btn-primary ui-btn-lg" onclick="window.location.href='{url user/mycategory}'">去设置</button>
    </div>
</section>


          <!--{/if}-->
                    
     
   


   
   

   


   
   


        
    </section>
</section>


<!--{template footer}-->