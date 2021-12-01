    
          
              {eval $user=$this->user;}
     
                {if $user['uid']==0}
                     <a href="{url user/login}" class="header-item">
                    登录      
                </a>
                <a href="{url user/register}" class="header-item active-color">
                    免费注册      
                </a>
                {else}
                  <a href="{url user/default}" class="header-item active-color">
                  欢迎,$user['username'] 
                </a>
                 <a href="{url message/system}" style="position:relative;" class="text-danger"><i class="fa fa-envelope-o fa-fw"></i><span class="msg-count" style="position:relative;top:0px;left:0px;"></span>私信</a>
               
                {if $user['groupid']<4&&$user['groupid']>0}
                     <a href="{SITE_URL}index.php?admin_main/stat" class="header-item active-color">
                    后台管理
                </a>
                  {/if}
                     <a href="{url user/logout}" class="header-item active-color">
                  退出
                </a>
                {/if}