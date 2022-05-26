<!--{template header}-->

  <!--{eval $adlist = $this->fromcache("adlist");}-->
    <!--{if 0!=$user['uid']}-->
<script type="text/javascript" src="{SITE_URL}js/neweditor/ueditor.config.js"></script> 
<script type="text/javascript" src="{SITE_URL}js/neweditor/ueditor.all.js"></script> 

    <!--{/if}-->
      <link href="{SITE_URL}css/dist/css/question.css" rel="stylesheet">
<div class="ask_wp container">
<div class="ask_sub_nav">
<a href="/">穷游旅行问答</a>
 <span>&gt;</span> <a href="/question/2892089.html" data-bn-ipg="" class="title_ellipsis">
      {$question['title']} </a>
 </div>

<div class="row ask_item mt20">
<!-- 右侧导航 -->
<div class="ask_item_main ask_item_detail_bg  col-md-8 col-xs-12">
<div class="ask_detail_item clearfix"> 
                                                                  
                <div class="ask_detail_content">
                    

                                        <div class="ui_headPort" alt="1429837">
                        <a class="avatar" href="http://www.qyer.com/u/1429837" data-bn-ipg="7-1">
                            <img src="http://static.qyer.com/images/user2/avatar/big5.png" width="80" height="80" alt="tcrla" title="春节冰岛机票价格 - 穷游旅行问答">
                            
                        </a>
                    </div>
                    
                    <div class="ask_detail_content_tag">
                                        <!--{if $taglist}-->       
                                       <!--{loop $taglist $tag}-->

                  <a href="{url tag-$tag}" class="ask_tag_add" data-bn-ipg="7-2"><strong class="ask_tag_strong">{$tag}</strong></a>
                                       
                <!--{/loop}--><!--{else}--><!--{/if}-->
                                        </div>
                    
                    <h2 class="ask_detail_content_title qyer_spam_text_filter">{$question['title']}</h2>
                    <div class="question-info clearfix mt10">
                        
                        {$question['format_time']}
                                                    <span class="from-bbs cGray">
                                来自 <a title="挪威/瑞典/芬兰/丹麦/冰岛" href="http://bbs.qyer.com/forum-25-5-1.html" data-bn-ipg="7-4">挪威/瑞典/芬兰/丹麦/冰岛</a> 版问题
                            </span>
                                                
                    </div>                   
                    <div class="ask_detail_content_text qyer_spam_text_filter">
                  {eval    echo replacewords($question['description']);    }     
                    </div>
                   
                    
                    <div class="clearfix mt10 ">

                        <div class="fl mt10">
                                                        <span class="fl"><span class="iconfont"></span> {$question['views']}人浏览 </span>
                                                        <span class="line">|</span>
                                                        <span class="fl"><span class="iconfont" style="font-size:1.1em"></span> {$question['answers']} 个回答</span>
                                                        <span class="line">|</span>

                            <span class="fl"><span class="iconfont"></span> {$question['attentions']}人关注 </span>

                            
                        </div>
                                                <span class="fr">
                           
                           
                                                         
  <!--{if $is_followed}-->
                                          
   <a href="javascript:;" id="attenttoquestion" value="2892089" class="button_followed ui_btn_big jsaddquestionatten" onclick="attentto_question({$question['id']})" id="attenttoquestion" data-bn-ipg="ask-answer-follow">取消关注</a>
    
                    <!--{else}-->
                    
                                        
   <a href="javascript:;"  value="2892089" class="button_attention ui_btn_big jsaddquestionatten" onclick="attentto_question({$question['id']})" id="attenttoquestion" data-bn-ipg="ask-answer-follow">关注问题</a>
    
                    <!--{/if}-->
                                                                                   
                                                                                     
                                                                                     
                                                        <input type="button" value="回答问题" class="ui_btn_big jsjumptoanswer" data-bn-ipg="ask-answer-answer">
                        </span>
                                            </div>
                </div>
            </div>
            
            
            <!-- 回答列表和回答编辑器 -->
            <div class="ask_detail_comment mt20">
                

                                
                                 
                 
                 

                 

                     
    <!--{loop $answerlist $index $answer}-->                  
<div class="mod_discuss clearfix jsanswerbox">
      
    
            <a href="javascript:;" data-bn-ipg="8-1-1-8" class=" jsaskansweruseful useful_left  " value="3284423">
        <span class="upvote-count">{$answer['supports']}</span>
        </a>
           
        
    

    
    <div class="mod_discuss_cnt">
        <!-- <div class="mod_discuss_cnt_triangle"></div> -->
        <div class="mod_discuss_box">
            <div class="jsanswercontent">
                <div class="mod_discuss_box_name">
                    <div class="mod_discuss_face">
                                                                            
                        <div class="ui_headPort" alt="2145180">
                            <a class="avatar ava40" data-bn-ipg="8-1-1-1" href="{url user/space/$answer['authorid']}">
                                <img src="{$answer['author_avartar']}" width="80" height="80" class="ui_headPort_img" alt="{$answer['author']}">
                                
                            </a>
                        </div>
                    </div>
                    <a data-bn-ipg="8-1-1-2" href="{url user/space/$answer['authorid']}">{$answer['author']}</a>
                                        回答了问题 <span class="ico_point">.</span> <a href="" class="normal_text">{$answer['time']}</a>                </div>
                <div class="mod_discuss_box_text qyer_spam_text_filter">{eval    echo replacewords($answer['content']);    }</div>

                <div class="mod_discuss_box_tool clearfix">
                    <div class="mt5">

                        <span class=" fl">
                        <i class="icon icon-window-alt mar-y-05"></i>
                                                <a data-bn-ipg="8-1-1-4" href="javascript:;" class="icon_discuss jsslideshowcomment" alt="3284423" value="0" rel="bestow07" isself="0"><span>
                               添加讨论</span>
                        </a>
                                                </span>
                        
                       

                                     
                     

                    </div>

                </div>
            </div>

            <div class="stamp"></div>

            
        </div>
        <!-- 讨论开始 -->
   
        <!-- 讨论结束 -->
    </div>
</div> 
                                                
      <!--{/loop}-->           
                

                                                <a name="questionanswer" id="questionanswer" style="margin-top: -150px; position: absolute;">&nbsp;</a>                
                                <div class="mod_discuss clearfix mt10">
                    <div class="mod_discuss_face ui_headPort" alt="8572777">
                           <a href="{url user/space/$user['uid']}" class="fl" data-bn-ipg="9-1"><img src="{$user['avatar']}" width="80" height="80" alt="{$user['username']}"></a>                    </div>
                    <div class="mod_discuss_cnt mod_noborder">
                    <!--{if 0!=$user['uid']}-->
   <!--{if !$already && $user['uid']!= $question['authorid']}-->
       <form name="answerForm" action="{url question/answer}" method="post">
<div class="row comment-form">

  
    <div class="col-sm-12 ">
       <div class="your-answer">
                    <script type="text/plain" id="anscontent" name="content" style="height: 122px;"></script>
                   
                </div>
    </div>
    <div class="col-sm-12 mar-t-05">
  
        <div class="row">
            <div class="col-sm-10">
              <!--{if $setting['code_ask']}-->
                <div class="row">
                    <div class="col-sm-4">
                        <span class="">验证码</span>
                        <input onblur="check_code()" name="code" id="code" type="text" class="input-code">
                    </div>

                    <div class="col-sm-6">
                        <span class="verifycode"><img class="hand" id="verifycode" onclick="javascript:updatecode();" src="{url user/code}"></span>
                        <a href="javascript:updatecode();" class="changecode">&nbsp;换一个</a>
                        <span id="codetip" class="input_error alert alert-warning hide"></span>
                    </div>
                </div>
                   <!--{/if}-->
            </div>
            <div class="col-sm-2">
             <input type="hidden" value="{$question['id']}" name="qid">
                <input type="hidden" value="{$question['title']}" name="title">
                <button type="submit" name="submit" class="btn btn-success pull-right">

                    提交
                </button>
            </div>
        </div>
      
    </div>
</div>

  </form>
  

  <!--{/if}-->    
  
   <!--{else}-->
   
     <!--{/if}-->    
                    </div>
                </div>
                                          

            </div>
</div>


<!-- 左侧导航 -->
<div class="silderight col-md-4 col-xs-12">
<div class="ask_detail_do mt20">
                <h4 class="f14 fb cGray">相关问题</h4>
                <ul class="mt5 clearfix">
                
  <!--{loop $solvelist $solve}-->
   <li>
   <strong>#</strong>
   <span>
   <a title=" {$solve['title']}" href="{url question/view/$solve['id']}" data-bn-ipg="ask-answer-relatedquestion">
   {$solve['title']}
   </a>
   </span>
   </li>
 


  <!--{/loop}-->
                                                                                                               
                </ul>
            </div>
            
            
            <div class="ask_detail_do mt20">
                <h4 class="f14 fb cGray">相关文章</h4>
                <ul class="mt5 clearfix">
                
  <!--{loop $topiclist $index $article}-->
   <li>
   <strong>#</strong>
   <span>
   <a title=" {$article['title']}" href="{url topic/getone/$article['id']}" data-bn-ipg="ask-answer-relatedquestion">
{$article['title']}
   </a>
   </span>
   </li>
 


  <!--{/loop}-->
                                                                                                               
                </ul>
            </div>
            
            
</div>
</div>


</div>
<script type="text/javascript">  
            var editor = UE.getEditor('anscontent',{  
                //这里可以选择自己需要的工具按钮名称,此处仅选择如下五个  
                toolbars:[['FullScreen',  'Undo', 'Redo','bold','simpleupload', 'insertimage', 'scrawl', 'insertvideo', 'attachment']],  
                //focus时自动清空初始化时的内容  
                autoClearinitialContent:true,  
                //关闭字数统计  
                wordCount:false,  
                //关闭elementPath  
                elementPathEnabled:false
               
                //更多其他参数，请参考ueditor.config.js中的配置项  
            });  
        </script>  
<!--{template footer}-->