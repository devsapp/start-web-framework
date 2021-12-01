 
      
             <!-- 本周热门讨论问题显示10条-->
        {eval $maxhotre=10;}
         {eval  $hotquestionlist=$this->getlistbysql("select id,title,status,time,answers,views  from ".$this->db->dbprefix."question where status not in(0,9)   order by time desc,answers desc limit 0,$maxhotre");}
 

      	<div class="aside-box">		<h2 class="widget-title">热议问题</h2>
		<ul>
 {loop $hotquestionlist $hotquestion}
											<li>
					<a href="{url question/view/$hotquestion['id']}"  target="_blank">{$hotquestion['title']}</a> <span class="rightanswers"><i class="iconfont icon-pinglun1"></i> {$hotquestion['answers']}</span>
									</li>
						   {/loop}
						        {if !$hotquestionlist}
        <!-- 无数据时 -->
     
        <div class="fly-none">没有相关数据</div>
        {/if}
					</ul>
		</div>  
		