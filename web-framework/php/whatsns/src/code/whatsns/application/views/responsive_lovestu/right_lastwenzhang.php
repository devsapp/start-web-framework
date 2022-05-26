   
              {eval $lastmaxtuijian=6;}
          {eval $lasttuijianlist=$this->getlistbysql("select id,title,state,ispc,viewtime  from ".$this->db->dbprefix."topic where state!=0 order by viewtime desc limit 0,$lastmaxtuijian");}
 
      	<div class="aside-box">		<h2 class="widget-title">近期文章</h2>
		<ul>
		 {loop $lasttuijianlist $tuijian}
											<li>
					<a href="{url topic/getone/$tuijian['id']}"  target="_blank">{$tuijian['title']}</a>
									</li>
						   {/loop}
					</ul>
		</div>  
		