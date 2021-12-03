<!--{template header}-->
<script type="text/javascript">
    function selectCell(obj) {
        var trid=obj.value;
        $("#"+trid+" input[name='regular_code[]']").each(function(){
            this.checked = obj.checked;
        });
    }
</script>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;设置组权限</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->
<form action="index.php?admin_usergroup/regular/$group['groupid']{$setting['seo_suffix']}" method="post">
    <input type="hidden" name="groupid" value="$group['groupid']">
    <table class="table">
        <tbody>
            <tr class="header" >
                <td>
                    <input type="button" style="cursor:pointer" onclick="document.location.href='index.php?admin_usergroup{$setting['seo_suffix']}'" value="会员用户组" />&nbsp;&nbsp;&nbsp;
                    <input type="button" style="cursor:pointer" onclick="document.location.href='index.php?admin_usergroup/system{$setting['seo_suffix']}'" value="系统用户组" />&nbsp;&nbsp;&nbsp;
			设置组权限
                </td>
            </tr>
    </table>
    <table width="100%" cellspacing="1" cellpadding="4" align="center" class="tableborder">
        <tr class="header">
            <td colspan="2">系统操作权限设置</td>
        </tr>
        <tr id="regular_view">
            <td class="altbg1" width="18%">
                <input name="chkGroup" value="regular_view"  class="checkbox" type="checkbox" onclick="selectCell(this);">页面浏览（前台）
            </td>
            <td class="altbg2">
                 <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/getpass"  {if false!==strpos($group['regulars'],'user/getpass')}checked{/if}  class="checkbox" type="checkbox">找回密码
                </div>
           <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="api_user/bindregisterapi,api_user/registerapi,user/register"  {if false!==strpos($group['regulars'],'api_user/bindregisterapi,api_user/registerapi,user/register')}checked{/if}  class="checkbox" type="checkbox">注册用户
                </div>
                 <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="tags/index,tags/view,tags/question,tags/article,tags/all,tags/ajaxsearch"  {if false!==strpos($group['regulars'],'tags/index,tags/view,tags/question,tags/article,tags/all,tags/ajaxsearch')}checked{/if}  class="checkbox" type="checkbox">前端标签浏览
                </div>
                
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="index/index,index/default"  {if false!==strpos($group['regulars'],'index/index,index/default')}checked{/if}  class="checkbox" type="checkbox">首页浏览
                </div>
                   <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="new/default,newpage/index,newpage/catname,newpage/maketag"  {if false!==strpos($group['regulars'],'new/default,newpage/index,newpage/catname,newpage/maketag')}checked{/if}  class="checkbox" type="checkbox">问题库浏览
                </div>
                
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="category/view"  {if false!==strpos($group['regulars'],'category/view')}checked{/if}  class="checkbox" type="checkbox">分类浏览
                </div>
                     <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="topic/weeklist,topic/default,topic/catlist,topic/hotlist"  {if false!==strpos($group['regulars'],'topic/weeklist,topic/default,topic/catlist,topic/hotlist')}checked{/if}  class="checkbox" type="checkbox">文章列表浏览
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="category/list"  {if false!==strpos($group['regulars'],'category/list')}checked{/if}  class="checkbox" type="checkbox">问题列表浏览
                </div>
                    <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="topic/getone"  {if false!==strpos($group['regulars'],'topic/getone')}checked{/if}  class="checkbox" type="checkbox">浏览文章
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/view"  {if false!==strpos($group['regulars'],'question/view')}checked{/if}  class="checkbox" type="checkbox">浏览问题
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/follow"  {if false!==strpos($group['regulars'],'question/follow')}checked{/if}  class="checkbox" type="checkbox">查看问题关注者
                </div>
            
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="note/list"  {if false!==strpos($group['regulars'],'note/list')}checked{/if}  class="checkbox" type="checkbox">公告列表
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="note/view"  {if false!==strpos($group['regulars'],'note/view')}checked{/if}  class="checkbox" type="checkbox">公告浏览
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="rss/category"  {if false!==strpos($group['regulars'],'rss/category')}checked{/if}  class="checkbox" type="checkbox">分类RSS
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="rss/list"  {if false!==strpos($group['regulars'],'rss/list')}checked{/if}  class="checkbox" type="checkbox">列表RSS
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="rss/question"  {if false!==strpos($group['regulars'],'rss/question')}checked{/if}  class="checkbox" type="checkbox">问题RSS
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/scorelist"  {if false!==strpos($group['regulars'],'user/scorelist')}checked{/if}  class="checkbox" type="checkbox">用户排行榜
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/activelist"  {if false!==strpos($group['regulars'],'user/activelist')}checked{/if}  class="checkbox" type="checkbox">活跃用户
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="expert/default"  {if false!==strpos($group['regulars'],'expert/default')}checked{/if}  class="checkbox" type="checkbox">专家列表
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/qqlogin"  {if false!==strpos($group['regulars'],'user/qqlogin')}checked{/if}  class="checkbox" type="checkbox">QQ登录
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="gift/default,gift/search,gift/add"  {if false!==strpos($group['regulars'],'gift/default,gift/search,gift/add')}checked{/if}  class="checkbox" type="checkbox">礼品商店
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/search"  {if false!==strpos($group['regulars'],'question/search')}checked{/if}  class="checkbox" type="checkbox">问题搜索
                </div>

                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/add"  {if false!==strpos($group['regulars'],'question/add')}checked{/if}  class="checkbox" type="checkbox">提问题
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/answer"  {if false!==strpos($group['regulars'],'question/answer,')}checked{/if}  class="checkbox" type="checkbox">回答问题
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="doing/default"  {if false!==strpos($group['regulars'],'doing/default')}checked{/if}  class="checkbox" type="checkbox">动态
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="topic/userxinzhi,user/space_attention,user/space_ask,user/space_answer,user/space"  {if false!==strpos($group['regulars'],'topic/userxinzhi,user/space_attention,user/space_ask,user/space_answer,user/space')}checked{/if}  class="checkbox" type="checkbox">用户空间
                </div>
                <!--{if 3!=$group['grouptype']}-->
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="answer/append"  {if false!==strpos($group['regulars'],'answer/append')}checked{/if}  class="checkbox" type="checkbox">追问
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="answer/addcomment"  {if false!==strpos($group['regulars'],'answer/addcomment')}checked{/if}  class="checkbox" type="checkbox">回答评论
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/edittag"  {if false!==strpos($group['regulars'],'question/edittag')}checked{/if}  class="checkbox" type="checkbox">编辑问题标签
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="favorite/add"  {if false!==strpos($group['regulars'],'favorite/add')}checked{/if}  class="checkbox" type="checkbox">收藏问题
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="inform/add"  {if false!==strpos($group['regulars'],'inform/add')}checked{/if}  class="checkbox" type="checkbox">举报回答
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/answercomment"  {if false!==strpos($group['regulars'],'question/answercomment')}checked{/if}  class="checkbox" type="checkbox">问题评论
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="note/addcomment"  {if false!==strpos($group['regulars'],'note/addcomment')}checked{/if}  class="checkbox" type="checkbox" />公告评论
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/attentto"  {if false!==strpos($group['regulars'],'question/attentto')}checked{/if}  class="checkbox" type="checkbox" />关注问题
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/attentto"  {if false!==strpos($group['regulars'],'user/attentto')}checked{/if}  class="checkbox" type="checkbox" />关注用户
                </div>
                <!--{/if}-->
                
                    <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="attach/upload,attach/checkattackfile,attach/upimg,attach/uploadimage,attach/uploadimage,attach/watermark"  {if false!==strpos($group['regulars'],'attach/upload,attach/checkattackfile,attach/upimg,attach/uploadimage,attach/uploadimage,attach/watermark')}checked{/if}  class="checkbox" type="checkbox">上传附件
                </div>
            </td>
        </tr>

        <!--{if 3!=$group['grouptype']}-->
        <tr id="regular_user">
            <td class="altbg1" width="18%">
                <input name="chkGroup" value="regular_user"  class="checkbox" type="checkbox" onclick="selectCell(this);">用户相关（前台）
            </td>
              
        
           
            <td class="altbg2">
                         <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/addxinzhi"  {if false!==strpos($group['regulars'],'user/addxinzhi')}checked{/if}  class="checkbox" type="checkbox">添加文章
                </div>
        
                     <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/editxinzhi"  {if false!==strpos($group['regulars'],'user/editxinzhi')}checked{/if}  class="checkbox" type="checkbox">编辑文章
                </div>
                
                     <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/deletexinzhi"  {if false!==strpos($group['regulars'],'user/deletexinzhi')}checked{/if}  class="checkbox" type="checkbox">删除文章
                </div>
                     <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/editimg"  {if false!==strpos($group['regulars'],'user/editimg')}checked{/if}  class="checkbox" type="checkbox">修改头像
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/recommend"  {if false!==strpos($group['regulars'],'user/recommend')}checked{/if}  class="checkbox" type="checkbox">为我推荐
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/default,user/score"  {if false!==strpos($group['regulars'],'user/default,user/score')}checked{/if}  class="checkbox" type="checkbox">个人中心首页
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/userbank"  {if false!==strpos($group['regulars'],'user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/userbank')}checked{/if}  class="checkbox" type="checkbox">财富充值
                </div>

                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/ask"  {if false!==strpos($group['regulars'],'user/ask')}checked{/if}  class="checkbox" type="checkbox">我的提问
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/answer"  {if false!==strpos($group['regulars'],'user/answer')}checked{/if}  class="checkbox" type="checkbox">我的回答
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/follower,user/attention"  {if false!==strpos($group['regulars'],'user/follower,user/attention')}checked{/if}  class="checkbox" type="checkbox">我的关注
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="favorite/default,favorite/delete,question/addfavorite"  {if false!==strpos($group['regulars'],'favorite/default,favorite/delete,question/addfavorite')}checked{/if}  class="checkbox" type="checkbox">我的收藏
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/profile"  {if false!==strpos($group['regulars'],'user/profile')}checked{/if}  class="checkbox" type="checkbox">个人资料
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/uppass"  {if false!==strpos($group['regulars'],'user/uppass')}checked{/if}  class="checkbox" type="checkbox">修改密码
                </div>

                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/editimg,user/saveimg"  {if false!==strpos($group['regulars'],'user/editimg,user/saveimg')}checked{/if}  class="checkbox" type="checkbox">编辑头像
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/mycategory,user/unchainauth"  {if false!==strpos($group['regulars'],'user/mycategory,user/unchainauth')}checked{/if}  class="checkbox" type="checkbox">我的设置
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="user/level"  {if false!==strpos($group['regulars'],'user/level')}checked{/if}  class="checkbox" type="checkbox">我的等级
                </div>
            </td>
        </tr>
        <tr id="regular_question">
            <td class="altbg1" width="18%">
                <input name="chkGroup" value="regular_question"  class="checkbox" type="checkbox" onclick="selectCell(this);">问题相关（前台）
            </td>
            <td class="altbg2">
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="attach/uploadimage"  {if false!==strpos($group['regulars'],'attach/uploadimage')}checked{/if}  class="checkbox" type="checkbox">上传图片
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/adopt"  {if false!==strpos($group['regulars'],'question/adopt')}checked{/if}  class="checkbox" type="checkbox">采纳答案
                </div>
                 <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/edit"  {if false!==strpos($group['regulars'],'question/edit,')}checked{/if}  class="checkbox" type="checkbox">编辑问题
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/close"  {if false!==strpos($group['regulars'],'question/close')}checked{/if}  class="checkbox" type="checkbox">关闭问题
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/supply"  {if false!==strpos($group['regulars'],'question/supply')}checked{/if}  class="checkbox" type="checkbox">补充问题
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/addscore"  {if false!==strpos($group['regulars'],'question/addscore')}checked{/if}  class="checkbox" type="checkbox">提高悬赏
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/editanswer"  {if false!==strpos($group['regulars'],'question/editanswer')}checked{/if}  class="checkbox" type="checkbox">修改答案
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="question/search"  {if false!==strpos($group['regulars'],'question/search')}checked{/if}  class="checkbox" type="checkbox">问题搜索
                </div>
            </td>
        </tr>

        <tr id="regular_message">
            <td class="altbg1" width="18%">
                <input name="chkGroup" value="regular_message"  class="checkbox" type="checkbox" onclick="selectCell(this);">站内消息（前台）
            </td>
            <td class="altbg2">
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="message/send"  {if false!==strpos($group['regulars'],'message/send')}checked{/if}  class="checkbox" type="checkbox">发消息
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="message/new"  {if false!==strpos($group['regulars'],'message/new')}checked{/if}  class="checkbox" type="checkbox">收件箱
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="message/personal"  {if false!==strpos($group['regulars'],'message/personal')}checked{/if}  class="checkbox" type="checkbox">私人消息
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="message/system"  {if false!==strpos($group['regulars'],'message/system')}checked{/if}  class="checkbox" type="checkbox">系统消息
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="message/outbox"  {if false!==strpos($group['regulars'],'message/outbox')}checked{/if}  class="checkbox" type="checkbox">发件箱
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="message/view"  {if false!==strpos($group['regulars'],'message/view')}checked{/if}  class="checkbox" type="checkbox">浏览消息
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="message/remove,message/removedialog"  {if false!==strpos($group['regulars'],'message/remove,message/removedialog')}checked{/if}  class="checkbox" type="checkbox">删除消息
                </div>
            </td>
        </tr>
        <!--{if 1==$group['grouptype']}-->
        <tr id="regular_setting">
            <td class="altbg1" width="18%">
                <input name="chkGroup" value="regular_setting"  class="checkbox" type="checkbox" onclick="selectCell(this);">网站设置（后台）
            </td>
            <td class="altbg2">
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_main/default,admin_main/index,admin_main/header,admin_main/menu,admin_main/stat,admin_main/login,admin_main/logout"  {if false!==strpos($group['regulars'],'admin_main/default,admin_main/index,admin_main/header,admin_main/menu,admin_main/stat,admin_main/login,admin_main/logout')}checked{/if}  class="checkbox" type="checkbox">后台登录
                </div>
                 
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/base,admin_setting/default"  {if false!==strpos($group['regulars'],'admin_setting/base,admin_setting/default')}checked{/if}  class="checkbox" type="checkbox">基本设置
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/list"  {if false!==strpos($group['regulars'],'admin_setting/list')}checked{/if}  class="checkbox" type="checkbox">列表显示
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/register"  {if false!==strpos($group['regulars'],'admin_setting/register')}checked{/if}  class="checkbox" type="checkbox">注册设置
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/mail,admin_setting/testmail"  {if false!==strpos($group['regulars'],'admin_setting/mail,admin_setting/testmail')}checked{/if}  class="checkbox" type="checkbox">邮件设置
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/credit"  {if false!==strpos($group['regulars'],'admin_setting/credit')}checked{/if}  class="checkbox" type="checkbox">积分设置
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/seo"  {if false!==strpos($group['regulars'],'admin_setting/seo')}checked{/if}  class="checkbox" type="checkbox">seo设置
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/static"  {if false!==strpos($group['regulars'],'admin_setting/static')}checked{/if}  class="checkbox" type="checkbox">html纯静态
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/word"  {if false!==strpos($group['regulars'],'admin_setting/word')}checked{/if}  class="checkbox" type="checkbox">词语过滤
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/cache"  {if false!==strpos($group['regulars'],'admin_setting/cache')}checked{/if}  class="checkbox" type="checkbox">更新缓存
                </div>
             
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/ucenter"  {if false!==strpos($group['regulars'],'admin_setting/ucenter')}checked{/if}  class="checkbox" type="checkbox">UCenter
                </div>
                 <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_tixian/index,admin_tixian/default,admin_tixian/ganxie,admin_tixian/queren,admin_tixian/deletetixian"  {if false!==strpos($group['regulars'],'admin_tixian/index,admin_tixian/default,admin_tixian/ganxie,admin_tixian/queren,admin_tixian/deletetixian')}checked{/if}  class="checkbox" type="checkbox">提现审核
                </div>
             <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_duizhang/index,admin_duizhang/default,admin_duizhang/select"  {if false!==strpos($group['regulars'],'admin_duizhang/index,admin_duizhang/default,admin_duizhang/select')}checked{/if}  class="checkbox" type="checkbox">查看对账流水
                </div>
                   <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_dashang/default,admin_dashang/index,admin_dashang/select"  {if false!==strpos($group['regulars'],'admin_dashang/default,admin_dashang/index,admin_dashang/select')}checked{/if}  class="checkbox" type="checkbox">打赏记录查询
                </div>
                  <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_sitelog/default,admin_sitelog/index,admin_sitelog/delete"  {if false!==strpos($group['regulars'],'admin_sitelog/default,admin_sitelog/index,admin_sitelog/delete')}checked{/if}  class="checkbox" type="checkbox">站点日志查询
                </div>
                   <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_totalset/default,admin_totalset/index"  {if false!==strpos($group['regulars'],'admin_totalset/default,admin_totalset/index')}checked{/if}  class="checkbox" type="checkbox">全局设置
                </div>
                   <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_chajian/autoasnwer,admin_chajian/postanswer,admin_chajian/attention_question"  {if false!==strpos($group['regulars'],'admin_chajian/autoasnwer,admin_chajian/postanswer,admin_chajian/attention_question')}checked{/if}  class="checkbox" type="checkbox">插件管理-自问自答
                </div>
                   <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_chajian/addarticle"  {if false!==strpos($group['regulars'],'admin_chajian/addarticle')}checked{/if}  class="checkbox" type="checkbox">插件管理-马甲发布文章
                </div>
                   <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_xiongzhang/apiset,admin_xiongzhang/historytui,admin_xiongzhang/newtui,admin_xiongzhang/topichistorytui,admin_xiongzhang/topicnewtui,admin_xiongzhang/taghistorytui,admin_xiongzhang/tagnewtui,admin_xiongzhang/index,admin_xiongzhang/topiclist,admin_xiongzhang/default,admin_xiongzhang/taglist"  {if false!==strpos($group['regulars'],'admin_xiongzhang/apiset,admin_xiongzhang/historytui,admin_xiongzhang/newtui,admin_xiongzhang/topichistorytui,admin_xiongzhang/topicnewtui,admin_xiongzhang/taghistorytui,admin_xiongzhang/tagnewtui,admin_xiongzhang/index,admin_xiongzhang/topiclist,admin_xiongzhang/default,admin_xiongzhang/taglist')}checked{/if}  class="checkbox" type="checkbox">插件管理-熊掌号配置
                </div>
                  <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/testsms,admin_setting/sms"  {if false!==strpos($group['regulars'],'admin_setting/testsms,admin_setting/sms')}checked{/if}  class="checkbox" type="checkbox">短信设置
                </div>
                  <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_editor/setting"  {if false!==strpos($group['regulars'],'admin_editor/setting')}checked{/if}  class="checkbox" type="checkbox">编辑器设置
                </div>
                    <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/weixinlogin"  {if false!==strpos($group['regulars'],'admin_setting/weixinlogin')}checked{/if}  class="checkbox" type="checkbox">微信扫码登录设置
                </div>
                 <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/qqlogin"  {if false!==strpos($group['regulars'],'admin_setting/qqlogin')}checked{/if}  class="checkbox" type="checkbox">QQ互联登录设置
                </div>
                   <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_setting/sinalogin"  {if false!==strpos($group['regulars'],'admin_setting/sinalogin')}checked{/if}  class="checkbox" type="checkbox">新浪微博登录设置
                </div>
            </td>
        </tr>

        <tr id="regular_manage">
            <td class="altbg1" width="18%">
                <input name="chkGroup" value="regular_manage"  class="checkbox" type="checkbox" onclick="selectCell(this);">网站管理（后台）
            </td>
            <td class="altbg2">
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_category/updatecatbyorder,admin_category/updatecatbywenzhang,admin_category/updatecatbywenda,admin_category/updatecatbyindex,admin_category/default,admin_category/add,admin_category/edit,admin_category/myview,admin_category/view,admin_category/remove,admin_category/reorder,admin_category/postadd,admin_category/editalias,admin_category/editmiaosu,admin_category/getmiaosu"  {if false!==strpos($group['regulars'],'admin_category/updatecatbyorder,admin_category/updatecatbywenzhang,admin_category/updatecatbywenda,admin_category/updatecatbyindex,admin_category/default,admin_category/add,admin_category/edit,admin_category/myview,admin_category/view,admin_category/remove,admin_category/reorder,admin_category/postadd,admin_category/editalias,admin_category/editmiaosu,admin_category/getmiaosu')}checked{/if}  class="checkbox" type="checkbox">分类管理
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_question/baidutui,admin_question/default,admin_question/searchquestion,admin_question/searchanswer,admin_question/removequestion,admin_question/removeanswer,admin_question/edit,admin_question/examine,admin_question/examineanswer,admin_question/verify,admin_question/delete"  {if false!==strpos($group['regulars'],'admin_question/baidutui,admin_question/default,admin_question/searchquestion,admin_question/searchanswer,admin_question/removequestion,admin_question/removeanswer,admin_question/edit,admin_question/examine,admin_question/examineanswer,admin_question/verify,admin_question/delete')}checked{/if}  class="checkbox" type="checkbox">问题管理
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_user/default,admin_user/search,admin_user/add,admin_user/remove,admin_user/edit"  {if false!==strpos($group['regulars'],'admin_user/default,admin_user/search,admin_user/add,admin_user/remove,admin_user/edit')}checked{/if}  class="checkbox" type="checkbox">用户管理
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_usergroup/default,admin_usergroup/add,admin_usergroup/remove,admin_usergroup/edit"  {if false!==strpos($group['regulars'],'admin_usergroup/default,admin_usergroup/add,admin_usergroup/remove,admin_usergroup/edit')}checked{/if}  class="checkbox" type="checkbox">用户组管理
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_note/default,admin_note/add,admin_note/edit,admin_note/remove"  {if false!==strpos($group['regulars'],'admin_note/default,admin_note/add,admin_note/edit,admin_note/remove')}checked{/if}  class="checkbox" type="checkbox">公告管理
                </div>
                 <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_link/default,admin_link/add,admin_link/edit,admin_link/remove,admin_link/reorder"  {if false!==strpos($group['regulars'],'admin_link/default,admin_link/add,admin_link/edit,admin_link/remove,admin_link/reorder')}checked{/if}  class="checkbox" type="checkbox">友链管理
                </div>
                    <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_vertifyuser/default,admin_vertifyuser/index,admin_vertifyuser/bohui,admin_vertifyuser/vertifysave"  {if false!==strpos($group['regulars'],'admin_vertifyuser/default,admin_vertifyuser/index,admin_vertifyuser/bohui,admin_vertifyuser/vertifysave')}checked{/if}  class="checkbox" type="checkbox">认证管理
                </div>
                 <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_tag/delete,admin_tag/changepinyin,admin_tag/add,admin_tag/muttadd,admin_tag/postmutttag,admin_tag/checktagbyalias,admin_tag/checktagbyname,admin_tag/tongbutag,admin_tag/tongbudatatag,admin_tag/default,admin_tag/index,admin_tag/edit,admin_tag/updatedata"  {if false!==strpos($group['regulars'],'admin_tag/delete,admin_tag/changepinyin,admin_tag/add,admin_tag/muttadd,admin_tag/postmutttag,admin_tag/checktagbyalias,admin_tag/checktagbyname,admin_tag/tongbutag,admin_tag/tongbudatatag,admin_tag/default,admin_tag/index,admin_tag/edit,admin_tag/updatedata')}checked{/if}  class="checkbox" type="checkbox">标签管理
                </div>
                  <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_keywords/default,admin_keywords/index,admin_keywords/add,admin_keywords/editindexkeyword,admin_keywords/muladd"  {if false!==strpos($group['regulars'],'admin_keywords/default,admin_keywords/index,admin_keywords/add,admin_keywords/editindexkeyword,admin_keywords/muladd')}checked{/if}  class="checkbox" type="checkbox">关键词库管理
                </div>
                   <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_word/default,admin_word/index,admin_word/add,admin_word/muladd"  {if false!==strpos($group['regulars'],'admin_word/default,admin_word/index,admin_word/add,admin_word/muladd')}checked{/if}  class="checkbox" type="checkbox">词语过滤管理
                </div>
                <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_inform/default,admin_inform/index,admin_inform/remove"  {if false!==strpos($group['regulars'],'admin_inform/default,admin_inform/index,admin_inform/remove')}checked{/if}  class="checkbox" type="checkbox">举报管理
                </div>
                   <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_topic/default,admin_topic/index,admin_topic/shenhe,admin_topic/vertifycomments,admin_topic/add,admin_topic/baidutui,admin_topic/edit,admin_topic/view,admin_topic/vertify,admin_topic/remove,admin_topic/verifycomment,admin_topic/deletecomment,admin_topic/reorder,admin_topic/ajaxgetselect,admin_topic/makeindex"  {if false!==strpos($group['regulars'],'admin_topic/default,admin_topic/index,admin_topic/shenhe,admin_topic/vertifycomments,admin_topic/add,admin_topic/baidutui,admin_topic/edit,admin_topic/view,admin_topic/vertify,admin_topic/remove,admin_topic/verifycomment,admin_topic/deletecomment,admin_topic/reorder,admin_topic/ajaxgetselect,admin_topic/makeindex')}checked{/if}  class="checkbox" type="checkbox">文章管理
                </div>
                   <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_template/default,admin_template/index,admin_template/editdirfile,admin_template/getpcdir,admin_template/getwapdir,admin_template/getpcdirfile"  {if false!==strpos($group['regulars'],'admin_template/default,admin_template/index,admin_template/editdirfile,admin_template/getpcdir,admin_template/getwapdir,admin_template/getpcdirfile')}checked{/if}  class="checkbox" type="checkbox">模板管理
                </div>
                 <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="admin_weixin/tplset,admin_weixin/setting,admin_weixin/ticheng,admin_weixin/tplset,admin_weixin/del,admin_weixin/deltuwen,admin_weixin/getuserinfo,admin_weixin/addwelcome,admin_weixin/getfollowers,admin_weixin/addtext,admin_weixin/addtuwen,admin_weixin/addnav,admin_weixin/savetoken,admin_weixin/delmenu,admin_weixin/makemenu,admin_weixin/getmenus"  {if false!==strpos($group['regulars'],'admin_weixin/tplset,admin_weixin/setting,admin_weixin/ticheng,admin_weixin/tplset,admin_weixin/del,admin_weixin/deltuwen,admin_weixin/getuserinfo,admin_weixin/addwelcome,admin_weixin/getfollowers,admin_weixin/addtext,admin_weixin/addtuwen,admin_weixin/addnav,admin_weixin/savetoken,admin_weixin/delmenu,admin_weixin/makemenu,admin_weixin/getmenus')}checked{/if}  class="checkbox" type="checkbox">微信管理
                </div>
            
                   <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="topicdata/pushindex,admin_topic/topicdatalist,admin_topic/reordertopdata,admin_topic/canceltopdata"  {if false!==strpos($group['regulars'],'topicdata/pushindex,admin_topic/topicdatalist,admin_topic/reordertopdata,admin_topic/canceltopdata')}checked{/if}  class="checkbox" type="checkbox">顶置内容管理
                </div>
           
                   <div style="width: 200px; float: left;">
                    <input name="regular_code[]" value="topic/pushhot,admin_topic/topichotlist,admin_topic/cancelhottopic"  {if false!==strpos($group['regulars'],'topic/pushhot,admin_topic/topichotlist,admin_topic/cancelhottopic')}checked{/if}  class="checkbox" type="checkbox">站内推荐内容管理
                </div>
            </td>
        </tr>
        <!--{/if}-->
        <!--{/if}-->
        </tbody>
    </table>
    <!--{if 6!=$group['groupid'] && $group['grouptype']!=1}-->
    <table class="table">
        <tr class="header">
            <td colspan="2">其他权限设置</td>
        </tr>
 <tr>
					<td class="altbg1" width="45%"><b>是否允许免费查看付费答案(新增):</b><br><span class="smalltxt">勾选后此角色可以免费偷看需付费支付的答案内容</span></td>
					<td class="altbg2">
						<input class="radio"  type="radio"  {if $group['canfreereadansser']==1}checked{/if}  value="1" name="canfreereadansser"><label for="majia">是</label>&nbsp;&nbsp;&nbsp;
						<input class="radio"    type="radio"   {if $group['canfreereadansser']==0}checked{/if}  value="0" name="canfreereadansser"><label for="majia">否</label>
					</td>
				</tr>

        <tr>
					<td class="altbg1" width="45%"><b>是否允许发布文章:</b><br><span class="smalltxt">选择是这个用户组可以发布文章，默认可以</span></td>
					<td class="altbg2">
						<input class="radio"  type="radio"  {if $group['doarticle']==1}checked{/if}  value="1" name="doarticle"><label for="majia">是</label>&nbsp;&nbsp;&nbsp;
						<input class="radio"    type="radio"   {if $group['doarticle']==0}checked{/if}  value="0" name="doarticle"><label for="majia">否</label>
					</td>
				</tr>
         <tr>
            <td class="altbg1" width="45%"><b>每小时文章数限制:</b><br><span class="smalltxt">设置允许会员每小时最多的提问数量，0 为不限制，此功能会轻微加重服务器负担。</span></td>
            <td class="altbg2"><input name="articlelimits" value="{$group['articlelimits']}" class="txt"></td>
        </tr>
            <tr>
            <td class="altbg1" width="45%"><b>每小时提问数限制:</b><br><span class="smalltxt">设置允许会员每小时最多的提问数量，0 为不限制，此功能会轻微加重服务器负担。</span></td>
            <td class="altbg2"><input name="questionlimits" value="{$group['questionlimits']}" class="txt"></td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>每小时回答数限制:</b><br><span class="smalltxt">设置允许会员每小时最多的回答数量，0 为不限制，此功能会轻微加重服务器负担。</span></td>
            <td class="altbg2"><input name="answerlimits" value="{$group['answerlimits']}" class="txt"></td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>每天最大评分值:</b><br><span class="smalltxt">设置允许会员每天最大的评分数值，0 为不限制，此功能会轻微加重服务器负担。</span></td>
            <td class="altbg2"><input name="credit3limits" value="{$group['credit3limits']}" class="txt"></td>
        </tr>
    </table>
    <!--{/if}-->
    <input type="submit" class="btn btn-success" name="submit" value="提交" />
</form>
<br>
<!--{template footer}-->

