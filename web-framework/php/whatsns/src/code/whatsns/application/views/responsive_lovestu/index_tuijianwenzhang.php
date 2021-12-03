
      
         
          {eval $maxtuijian=6;}
          {eval $tuijianlist=$this->getlistbysql("select id,title,state,ispc,viewtime  from ".$this->db->dbprefix."topic where state!=0 and ispc=1 order by viewtime desc limit 0,$maxtuijian");}
 
      	<div class="aside-box">		<h2 class="widget-title">站长推荐</h2>
		<ul>
		 {loop $tuijianlist $tuijian}
											<li>
					<a href="{url topic/getone/$tuijian['id']}"  target="_blank">{$tuijian['title']}</a>
									</li>
						   {/loop}
					</ul>
		</div>  
		