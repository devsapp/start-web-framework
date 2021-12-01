   <div class="fly-panel">
        <h3 class="fly-panel-title">站长推荐</h3>
        <!-- 站长推荐文章6条-->
        {eval $maxtuijian=6;}
          {eval $tuijianlist=$this->getlistbysql("select id,title,state,ispc,viewtime  from ".$this->db->dbprefix."topic where state!=0 order by viewtime desc limit 0,$maxtuijian");}
 
        <ul class="fly-panel-main fly-list-static">
                 {loop $tuijianlist $tuijian}
          <li>
            <a href="{url topic/getone/$tuijian['id']}" target="_blank">{$tuijian['title']}</a>
          </li>
       {/loop}
        </ul>
      </div>