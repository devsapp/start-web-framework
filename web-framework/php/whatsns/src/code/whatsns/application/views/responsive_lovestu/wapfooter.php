<style>
  .ui-footer-btn .ui-tiled .current, .ui-footer-btn .ui-tiled i.current {
        color:#0085ee;
    }
    .ui-footer li i{
        font-size: 20px;
        color: #333333;
    }
    .ui-footer li h6{
        font-size: 13px;
    }

        .ui-footer-btn .ui-tiled .current, .ui-footer-btn .ui-tiled i.current {
        color:#0085ee;
    }

  
 
    #footer{
        margin-bottom: 50px;
        }
        .ui-footer-btn .ui-tiled {
    height: 100%;
}
.ui-flex, .ui-tiled {
    display: -webkit-box;
    width: 100%;
    -webkit-box-sizing: border-box;
}

.ui-footer {
    z-index: 1;
}
.ui-footer-btn {
    background: #fff;
    color: #777;
    position: fixed;
    bottom: 0px;
    left: 0px;
    right: 0px;
}
.ui-footer {
    bottom: 0;
    height: 56px;
}

.ui-tiled li {
    -webkit-box-flex: 1;
    width: 100%;
    text-align: center;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-box-pack: center;
    -webkit-box-align: center;
}
.ui-footer-btn .ui-tiled .current, .ui-footer-btn .ui-tiled i.current {
    color: #0085ee;
}
     .layui-fixbar {
    position: fixed;
    right: 15px;
    bottom: 65px;
    z-index: 999999;
}   
.site-tree-mobile {
  bottom: 65px !important;
}

@media screen and (-webkit-min-device-pixel-ratio: 2)
.ui-border-t, .ui-border-b, .ui-border-tb {
    background-repeat: repeat-x;
    -webkit-background-size: 100% 1px;
}
@media screen and (-webkit-min-device-pixel-ratio: 2)
.ui-border-t {
    background-position: left top;
    background-image: -webkit-gradient(linear,left bottom,left top,color-stop(0.5,transparent),color-stop(0.5,#e0e0e0),to(#e0e0e0));
}
@media screen and (-webkit-min-device-pixel-ratio: 2)
.ui-border-t, .ui-border-b, .ui-border-l, .ui-border-r, .ui-border-tb {
    border: 0;
}



</style>
<footer class="ui-footer ui-footer-btn {if $hidefooter} hide {/if}">
    <ul class="ui-tiled ui-border-t">
        <li class="<!--{if $regular=='index/default' || $regular==''|| $regular=='index'|| $regular=='index/index'}--> current<!--{/if}-->">
            <a href="{SITE_URL}" class="">

                <i class="layui-icon layui-icon-home <!--{if $regular=='index/default' || $regular==''|| $regular=='index'|| $regular=='index/index'}--> current<!--{/if}-->" style="line-height: 34px;"></i>
                <div class="ui-txt-muted <!--{if $regular=='index/default' || $regular==''|| $regular=='index'|| $regular=='index/index'}--> current<!--{/if}-->"><h6>首页</h6></div>
            </a>

        </li>
            <li>
            <a href="{url ask/index}">
                <i class="layui-icon layui-icon-log <!--{if $regular=='ask/index'}--> current<!--{/if}-->" style="line-height: 34px;"></i>
                <div class="ui-txt-muted <!--{if $regular=='ask/index'}--> current<!--{/if}-->"><h6>问答</h6></div>

            </a>
        </li>
        
         <li>
            <a href="{url seo/index}">
                <i class="layui-icon layui-icon-list <!--{if $regular=='seo/index'}--> current<!--{/if}-->" style="line-height: 34px;"></i>
                <div class="ui-txt-muted <!--{if $regular=='seo/index'}--> current<!--{/if}-->"><h6>文章</h6></div>

            </a>
        </li>
        
        <li >
            <a href="{url question/add}">
                <i class="layui-icon layui-icon-edit <!--{if $regular=='question/add'}--> current<!--{/if}-->" style="line-height: 34px;"></i>
                <div  class="myaddquestion ui-txt-muted <!--{if $regular=='question/add'}--> current<!--{/if}-->"><h6>提问</h6></div>

            </a>
        </li>
       
             
        <li>
            <a href="{url expert/index}">
                <i class="layui-icon layui-icon-user <!--{if $regular=='expert/index'}--> current<!--{/if}-->" style="line-height: 34px;"></i>
                <div  class="ui-txt-muted <!--{if $regular=='expert/index'}--> current<!--{/if}-->"><h6>专家</h6></div>

            </a>
        </li>
       
        <li>
         <!--{if $user['uid']!=0}--> 
         
          <a href="{url user/default}">
                <img src="{$user['avatar']}" style="width:30px;height:30px;border-radius:50%;position:relative;top:.03rem;"/>
               
                <div class="ui-txt-muted <!--{if $regular=='user/index'}--> current<!--{/if}-->"><h6 style="position: relative;top:3px;">我的</h6></div>

            </a>
            
  
         <!--{/if}-->
           
            {if $user['uid']==0}
             <a href="{url user/login}" >
               
                <i class="layui-icon layui-icon-friends " style="line-height: 34px;"></i>
                <div class="ui-txt-muted "><h6>我的</h6></div>

            </a>
            {/if}
        </li>

    </ul>

</footer>