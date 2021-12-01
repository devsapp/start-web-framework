    {eval $lastpinglunmaxtuijian=6;}
          {eval $lastpingluntuijianlist=$this->getlistbysql("select id,tid,title,state,content,time  from ".$this->db->dbprefix."articlecomment where state!=0 order by time desc limit 0,$lastpinglunmaxtuijian");}
 
<div class="aside-box"><h2 class="widget-title">最新评论</h2>
          
	 {loop $lastpingluntuijianlist $pinglun}
                        <li>
                <div class="widger-comment-plane">
                    <div class="widger-comment-info">
                        <div class="widger-comment-user">
                            <div class="widger-avatar">
                                <img alt="wdm3212" src="{eval echo get_avatar_dir($pinglun['authorid']);}"  class="avatar avatar-30 photo" height="30" width="30">                            </div>
                            <div class="widger-comment-name">
                               {$pinglun['author']}                          </div>
                        </div>
                        <div class="widger-comment-time">
                            <span>{eval echo date('m月d日',$pinglun['time']);}</span>
                        </div>
                    </div>
                    <div class="widger-comment-excerpt">
                        <p>{eval echo clearhtml($pinglun['content'],20);}</p>
                    </div>
                    <p class="widger-comment-postlink">
                        评论于 <a href="{url topic/getone/$pinglun['tid']}" target="_blank">{$pinglun['title']}</a>
                    </p>
                </div>

            </li>
   {/loop}
            </div>	
               
          
  