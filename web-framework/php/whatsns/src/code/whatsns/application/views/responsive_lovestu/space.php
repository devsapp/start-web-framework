<!--{template header}-->

<!-- 首页导航 --> 
{template index_nav}

{template space_title}

<div class="layui-container">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md8 fly-home-jie">
     <div class="fly-panel">
     {template space_nav}
     </div>
      <div class="fly-panel">
      

        <h3 class="fly-panel-title">$member['username'] 最近的提问</h3>
               {eval $qnums=15;}
          {eval $memberuid=$member['uid']; $questionlist=$this->getlistbysql("select id,title,status,time,views,answers  from ".$this->db->dbprefix."question where status!=0 and authorid=$memberuid order by time desc limit 0,$qnums");}
 
     
        
        <ul class="jie-row">
         {loop $questionlist $question}
          <li>
            {if $question['status']==6}<span class="fly-jing">精</span>{/if}
            <a href="{url question/view/$question['id']}" class="jie-title"> {$question['title']}</a>
            <i>{eval echo tdate($question['time']);}</i>
            <em class="layui-hide-xs">{$question['views']}阅/{$question['answers']}答</em>
          </li>
            {/loop}
          {if  !$questionlist}<div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><i style="font-size:14px;">没有发表任何求解</i></div> 
          {/if}
         
        
        </ul>
      </div>
      <div class="fly-home-da">
              <div class="fly-panel">
        <h3 class="fly-panel-title">$member['username'] 最近的回答</h3>
             {eval $aqnums=4;}
          {eval $memberuid=$member['uid']; $answerlist=$this->getlistbysql("select id,qid,title,status,content,time  from ".$this->db->dbprefix."answer where status!=0 and authorid=$memberuid order by time desc limit 0,$aqnums");}
 
        <ul class="home-jieda">
          {loop $answerlist $answer}
        <li>
          <p>
          <span>{eval echo tdate($answer['time']);}</span>
          在<a href="{url question/view/$answer['qid']}" target="_blank">{$answer['title']}</a>中回答：
          </p>
          <div class="home-dacontent">
            {eval echo clearhtml($answer['content'],100);}
          </div>
        </li>
        {/loop}
        {if  !$answerlist}   <div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><span>没有回答任何问题</span></div>
       {/if}
     
        </ul>
      </div>
      </div>
    
    </div>
    
    <div class="layui-col-md4 ">
             <!-- 推荐文章 -->
     {template index_tuijianwenzhang} 
 <!-- 热门讨论问题 -->
     {template index_hotquestion}
 <!-- 右侧广告位 -->
    {template question_rightadv}
       <!-- 右侧微信二维码 -->
    {template index_qrweixin}
      
    </div>
  </div>
</div>
<!--{template footer}-->