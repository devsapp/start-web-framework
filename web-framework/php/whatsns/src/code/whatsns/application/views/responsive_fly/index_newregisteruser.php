 <div class="fly-panel fly-rank fly-rank-reply" id="LAY_replyRank">
        <h3 class="fly-panel-title">最新注册</h3>
       <!-- 最多显示最新注册的16人-->
        {eval $maxregusernums=16;}
        <dl>
         {eval $newreguserlist=$this->getlistbysql("select uid,username,regtime,isblack  from ".$this->db->dbprefix."user where isblack=0 order by regtime desc limit 0,$maxregusernums");}
          {loop $newreguserlist $reguser}
          <dd>
            <a href="{url user/space/$reguser['uid']}">
              <img src="{eval echo get_avatar_dir($reguser['uid']);}"><cite title="{$reguser['username']}">{$reguser['username']}</cite><i title="{eval echo tdate($reguser['regtime']);}">{eval echo tdate($reguser['regtime']);}</i>
            </a>
          </dd>
          {/loop}
        </dl>
      </div>