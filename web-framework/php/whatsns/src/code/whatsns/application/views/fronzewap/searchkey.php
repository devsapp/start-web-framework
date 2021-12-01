<!--{template meta}-->

<!--{template searchinput}-->
   
       <div class="ui-col side " style="float: none;padding:7px;">
     <div class="widget-box pt0 " style="border:none;">
                        <h2 class="h4 widget-box__title" style="margin-bottom: 5px">热门标签</h2>
                        <ul class="taglist--inline multi">
                                <!--{eval $hosttaglist = $this->fromcache("hosttaglist");}-->
                                 <!--{loop $hosttaglist $index $rtag}-->
                                
                                                            <li class="tagPopup">
                                    <a class="tag" href="{url tags/view/$rtag['tagalias']}" >
                                                                          {if $rtag['tagimage']}  <img src="$rtag['tagimage']">{/if}
                                                                        {$rtag['tagname']}</a>
                                </li>
                                                <!--{/loop}-->          
                                                    </ul>
                    </div>
  </div>
  
  <div class="au_side_box" style="padding:0px;margin:0px;">

    <div class="au_box_title ws_mynewquestion" style="    padding: 7px;">

        <div>
            <i class="fa fa-file-text-o lv"></i>一周热点

        </div>

    </div>
    
     
      <div class="stream-list question-stream xm-tag tag-nosolve">
       <!--{eval $attentionlist = $this->fromcache("attentionlist");}-->
                                          <!--{loop $attentionlist $index $question}-->
      <section class="stream-list__item">
       {if $question['status']==2}
                <div class="qa-rank"><div class="answers answered solved ml10 mr10">
                {$question['answers']}<small>解决</small></div></div>     
                {else}
                {if $question['answers']>0}
                <div class="qa-rank"><div class="answers answered ml10 mr10">
                $question['answers']<small>回答</small></div>
                </div>
                   {else}
                   <div class="qa-rank"><div class="answers ml10 mr10">
                0<small>回答</small></div></div>
                {/if}
                
                
                {/if}
                   <div class="summary">
            <ul class="author list-inline">
                                           
                                                <li class="authorinfo">
                                          {if $question['hidden']==1}
                                            匿名用户
                      
                       {else} 
                              <a href="{url user/space/$question['authorid']}">
                          {$question['author']}{if $question['author_has_vertify']!=false}<i class="fa fa-vimeo {if $question['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " ></i>{/if}
                          </a>
                      
                         {/if} 
                       
                        <span class="split"></span>
                        <a href="{url question/view/$question['id']}">{$question['format_time']}</a>
                                    </li>
            </ul>
            <h2 class="title"><a href="{url question/view/$question['id']}">{$question['title']}</a></h2>
 <!--{if $question['tags']}-->
           <ul class="taglist--inline ib">
<!--{loop $question['tags'] $tag}-->
<li class="tagPopup authorinfo">
                        <a class="tag" href="{url tags/view/$tag['tagalias']}" >
                                                       {$tag['tagname']}
                        </a>
                    </li>
                    

                           
                <!--{/loop}-->
                 </ul>
                <!--{else}--><!--{/if}-->
                
              
                                   
                           
                                            </div>
    </section>
    <!--{/loop}-->
  
      
      </div>
 
    </div>
    
<script>
$('.ui-searchbar-wrap').addClass('focus');
$('.ui-searchbar-input input').focus();
</script>
<!--{template footer}-->