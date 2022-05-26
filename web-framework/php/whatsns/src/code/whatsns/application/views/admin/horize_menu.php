                  <style>

.main-header .nav {
    padding-left: 0;
    margin-bottom: 0;
    list-style: none;
    margin-top:5px;
    display: inline-block;
}
.main-header .nav-secondary>li>a {
    border-bottom: none;
}
.main-header .nav-secondary>li.active>a, .main-header .nav-secondary>li.active>a:focus,.main-header  .nav-secondary>li.active>a:hover {
    color: #000000;
    border-bottom:none;
}
        </style>

            <ul class="nav nav-secondary">

    <!--{template chajian}-->

    <li>
      <a class="dropdown-toggle" data-toggle="dropdown" href="###">系统设置 <span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="{SITE_URL}index.php?admin_setting/sitesetting{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>站点设置</a></li>
             <li><a href="{SITE_URL}index.php?admin_sitelog{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>站点日志查看</a></li>
                                 <li><a href="{SITE_URL}index.php?admin_tixian{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>用户提现审核</a></li>
                 <li><a href="{SITE_URL}index.php?admin_dashang{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>打赏记录管理</a></li>
                  <li><a href="{SITE_URL}index.php?admin_duizhang{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>对账流水管理</a></li>
                <li><a href="{SITE_URL}index.php?admin_setting/time{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>时间设置</a> </li>
                <li><a href="{SITE_URL}index.php?admin_setting/clist{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>首页设置</a> </li>
                <li><a href="{SITE_URL}index.php?admin_setting/search{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>搜索管理</a></li>
                <li><a href="{SITE_URL}index.php?admin_setting/register{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>注册设置</a></li>
                <li><a href="{SITE_URL}index.php?admin_nav{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>导航管理</a> </li>
                <li><a href="{SITE_URL}index.php?admin_link{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>友情链接</a> </li>

      </ul>
    </li>


        <li >
      <a class="dropdown-toggle" data-toggle="dropdown" href="###">高级管理 <span class="caret"></span></a>
      <ul class="dropdown-menu">
         <li><a href="{SITE_URL}index.php?admin_setting/caiji{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>数据采集设置</a> </li>
                              <li><a href="{SITE_URL}index.php?admin_setting/sms{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>短信设置</a> </li>
                <li><a href="{SITE_URL}index.php?admin_setting/mail{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>邮件设置</a> </li>
                <li><a href="{SITE_URL}index.php?admin_setting/msgtpl{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>消息模板</a> </li>
                <li><a href="{SITE_URL}index.php?admin_setting/settingcredit{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>积分设置</a> </li>
                <li><a href="{SITE_URL}index.php?admin_setting/ebank{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>财富充值</a> </li>
                <li><a href="{SITE_URL}index.php?admin_setting/seo{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>seo设置</a> </li>
                <li><a href="{SITE_URL}index.php?admin_editor/setting{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>编辑器设置</a> </li>
                <li><a href="{SITE_URL}index.php?admin_setting/qqlogin{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>qq互联设置</a> </li>
                <li><a href="{SITE_URL}index.php?admin_setting/sinalogin{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>sina互联设置</a> </li>
      </ul>
    </li>



        <li >
      <a class="dropdown-toggle" data-toggle="dropdown" href="###">内容管理 <span class="caret"></span></a>
      <ul class="dropdown-menu">
         <li><a href="{SITE_URL}index.php?admin_question/examine{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>问答审核</a></li>
                <li><a href="{SITE_URL}index.php?admin_question{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>问题管理</a></li>
                <li><a href="{SITE_URL}index.php?admin_question/searchanswer{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>回答管理</a></li>
                <li><a href="{SITE_URL}index.php?admin_category{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>分类管理</a></li>
                <li><a href="{SITE_URL}index.php?admin_topic{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>博客管理</a></li>
                <li><a href="{SITE_URL}index.php?admin_tag{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>标签管理</a></li>
                <li><a href="{SITE_URL}index.php?admin_keywords{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>关键词库</a></li>
                <li><a href="{SITE_URL}index.php?admin_word{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>词语过滤</a></li>
                <li><a href="{SITE_URL}index.php?admin_inform{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>举报管理</a></li>
                <li><a href="{SITE_URL}index.php?admin_note{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>公告管理</a></li>
                <li><a href="{SITE_URL}index.php?admin_ad{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>广告管理</a></li>
      </ul>
    </li>




        <li >
      <a class="dropdown-toggle" data-toggle="dropdown" href="###">用户管理<span class="caret"></span></a>
      <ul class="dropdown-menu">
         <li><a href="{SITE_URL}index.php?admin_user/add{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>添加用户</a> </li>
                <li><a href="{SITE_URL}index.php?admin_user{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>用户管理</a> </li>
                <li><a href="{SITE_URL}index.php?admin_banned/add{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>禁止IP</a> </li>
                <li><a href="{SITE_URL}index.php?admin_expert{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>专家管理</a> </li>
                <li><a href="{SITE_URL}index.php?admin_usergroup{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>用户组</a></li>
                <li><a href="{SITE_URL}index.php?admin_usergroup/system{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>系统用户组</a></li>
      </ul>
    </li>




        <li >
      <a class="dropdown-toggle" data-toggle="dropdown" href="###">模板管理 <span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="{SITE_URL}index.php?admin_template/default/pc{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>PC模板</a> </li>
                <li><a href="{SITE_URL}index.php?admin_template/default/wap{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>手机Wap模板</a> </li>
      </ul>
    </li>




        <li >
      <a class="dropdown-toggle" data-toggle="dropdown" href="###">微信管理 <span class="caret"></span></a>
      <ul class="dropdown-menu">
               <li><a href="{SITE_URL}index.php?admin_weixin/ticheng{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>分成配置(新)</a> </li>
         <li><a href="{SITE_URL}index.php?admin_weixin/setting{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>配置微信信息</a> </li>
                <li><a href="{SITE_URL}index.php?admin_weixin/addwelcome{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>关注回复</a> </li>
                <li><a href="{SITE_URL}index.php?admin_weixin/addnav{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>底部导航菜单配置</a> </li>
                <li><a href="{SITE_URL}index.php?admin_weixin/addtext{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>关键词文本回复</a> </li>

                <li><a href="{SITE_URL}index.php?admin_weixin/addtuwen{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>关键词图文回复</a> </li>
                <li><a href="{SITE_URL}index.php?admin_weixin/getfollowers{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>粉丝管理</a> </li>
      </ul>
    </li>
          <li >
      <a class="dropdown-toggle" data-toggle="dropdown" href="###">系统工具 <span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="{SITE_URL}index.php?admin_setting/cache{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>更新缓存</a> </li>
                <li><a href="{SITE_URL}index.php?admin_datacall/default{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>js数据调用</a> </li>
                <li><a href="{SITE_URL}index.php?admin_main/regulate{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>数据校正</a> </li>
                <li><a href="{SITE_URL}index.php?admin_db/backup{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>数据库备份</a> </li>
                <li><a href="{SITE_URL}index.php?admin_db/tablelist{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>数据库优化</a> </li>
                 <li><a href="{SITE_URL}index.php?admin_setting/ucenter{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>UCenter</a> </li>
                  <li><a href="{SITE_URL}index.php?admin_cms/setting{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-success"></i>CMS系统</a> </li>
      </ul>
    </li>

         <li >
      <a class="dropdown-toggle" data-toggle="dropdown" href="###">常用菜单 <span class="caret"></span></a>
      <ul class="dropdown-menu">
          <li><a href="{SITE_URL}" target="_blank"><i class="fa fa-genderless text-success"></i> <span>网站首页</span></a></li>
                <li><a href="{SITE_URL}?update" target="main"><i class="fa fa-genderless text-yellow"></i> <span>更新数据表</span></a> </li>
           <li><a href="{SITE_URL}index.php?admin_setting/cache{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-yellow"></i> <span>更新缓存</span></a> </li>
    <li><a href="http://www.ask2.cn" target="_blank"><i class="fa fa-genderless text-yellow"></i> <span>官方求助</span></a></li>
      </ul>
    </li>

          <li >
      <a class="dropdown-toggle" data-toggle="dropdown" href="###">名站统计 <span class="caret"></span></a>
      <ul class="dropdown-menu">

      </ul>
    </li>


  </ul>