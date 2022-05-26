 <dl class="fly-panel fly-list-one">
        <dt class="fly-panel-title">热议问题</dt>
            <!-- 本周热门讨论问题显示10条-->
        {eval $maxhotre=10;}
         {eval  $hotquestionlist=$this->getlistbysql("select id,title,status,time,answers,views  from ".$this->db->dbprefix."question where status not in(0,9) and answers>0  order by time desc,answers desc limit 0,$maxhotre");}
 
 {loop $hotquestionlist $hotquestion}
        <dd>
          <a href="{url question/view/$hotquestion['id']}">{$hotquestion['title']}</a>
          <span><i class="iconfont icon-pinglun1"></i> {$hotquestion['answers']}</span>
        </dd>
       {/loop}
        {if !$hotquestionlist}
        <!-- 无数据时 -->
     
        <div class="fly-none">没有相关数据</div>
        {/if}
      </dl>