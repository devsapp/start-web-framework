{eval $regular=$this->regular;}
<style>
.current a{
color:#fff !important;
}
</style>
<ul class="sidebar-menu" id="root_menu">
    <li class="header">管理菜单</li>
    <li {if $regular=="admin_main/stat"}class="current"{/if}><a href="{SITE_URL}index.php?admin_main/stat{$setting['seo_suffix']}"><i class="fa fa-dashboard"></i> <span>首页</span> </a></li>
    <li {if $regular=="admin_onlineupdate/index"}class="current"{/if}><a href="{SITE_URL}index.php?admin_onlineupdate/index{$setting['seo_suffix']}" ><i class="fa fa-wrench"></i> <span class="red">在线更新</span> </a></li>
    <li class=""><a href="{url admin_market/clist}" ><i class="fa fa-shopping-cart"></i> <span class="red">应用市场</span> </a></li>
   <li {if $regular=="admin_myplugin/clist"}class="current"{/if}><a href="{SITE_URL}index.php?admin_myplugin/clist{$setting['seo_suffix']}"><i class="fa fa-list"></i> <span>插件管理</span> </a></li>
    {if $user['groupid']==1}
    <li {if $regular=="admin_nav/manager"}class="current"{/if}><a href="{SITE_URL}index.php?admin_nav/manager{$setting['seo_suffix']}"><i class="fa fa-list"></i> <span>后台导航管理</span> </a></li>
        {/if}
    {eval  $adminnavlist=$this->getlistbysql("select * from ".$this->db->dbprefix."admin_nav where status=1 and pid=0  order by ordernum asc  limit 0,100");}
        {if $adminnavlist}
        {loop $adminnavlist $adminnav}
        {if $adminnav['id']!=1}
            <li class="treeview" >
        <a href="#">
            <i class="fa  fa-certificate"></i> <span>{$adminnav['name']}</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu" id="manage_user">
          {eval $pid=$adminnav['id']; $adminnavchlidlist=$this->getlistbysql("select * from ".$this->db->dbprefix."admin_nav where status=1 and pid=$pid  order by ordernum asc  limit 0,100");}
      {loop $adminnavchlidlist $chlidnav}
      {if !strstr($chlidnav['url'],"http://")&&!strstr($chlidnav['url'],"https://")}
      {eval $chlidnav['suburl']=url($chlidnav['url']);}
      {else}
      {eval $chlidnav['suburl']=$chlidnav['url'];}
      {/if}
     
        <li {if $regular==$chlidnav['url']||strstr($chlidnav['url'],$regular)}class="current"{/if}><a href="{$chlidnav['suburl']}" target="main"><i class="fa fa-genderless text-success"></i>{$chlidnav['name']}</a></li>
      {/loop}
        </ul>
    </li>
    {/if}
    {/loop}
    {/if}
        



    <li class="header">常用菜单</li>
    <li><a href="{SITE_URL}" target="_blank"><i class="fa fa-genderless text-success"></i> <span>网站首页</span></a></li>

           <li><a href="{SITE_URL}index.php?admin_setting/cache{$setting['seo_suffix']}" target="main"><i class="fa fa-genderless text-yellow"></i> <span>更新缓存</span></a> </li>
    <li><a href="https://wenda.whatsns.com/" target="_blank"><i class="fa fa-genderless text-yellow"></i> <span>官方求助</span></a></li>
</ul>
<script>
var url='{$regular}';
url=url.replace('/index','/default');
if(url=='admin_category/view'||url=='admin_category/add'||url=='admin_category/edit'){
	 url='admin_category/default';
}
if(url=='admin_user/edit'){
	 url='admin_user/default';
}
if(url=='admin_usergroup/regular'){
	 url='admin_usergroup/default';
}
if(url=='admin_topic/edit'){
	 url='admin_topic/default';
}
if(url=='admin_note/edit'){
	 url='admin_note/default';
}
if(url=='admin_template/editdirfile'){
	 {eval $lastsubfix=substr($this->uri->segment ( 3 ), -3);}
	 {if $lastsubfix=='wap'}
	 url='admin_template/default/wap';
	 {else}
	 url='admin_template/default/pc';
	 {/if}
}
if(url=='admin_template/default'){

	{eval $ddff=$this->uri->segment ( 3);}
	var tmpname="{$ddff}";

	 {if $this->uri->segment ( 3 )=='pc'||$ddff=='default'}
	 url='admin_template/default/pc';
	 {/if}
		 {if $this->uri->segment ( 3 )=='wap'}
		 url='admin_template/default/wap';
		 {/if}
}
		 if(url=='admin_course/add'){

				{eval $ddff=$this->uri->segment ( 3);}
				var tmpname="{$ddff}";

	
					 {if $this->uri->segment ( 3 )=='new'}
					 url='admin_course/add/new';
					 {/if}
			}
					 if(url=='admin_course/myview'){
		
						
								 url='admin_course/default';
							
						}

   // url=url.replace('/default','');
   var tmp_urls=url.split('/');
   var sublink='';
if(url.indexOf('default')>=0){
	if(tmp_urls[0]!='admin_template'){
		//url=tmp_urls[0]+".html";
	}

}
else{
	sublink=tmp_urls[0];
}
url=url+".html";
$(".treeview-menu li").each(function(){
	 var tmp_a=$(this).find("a").attr("href");

	 if(tmp_a.indexOf(url)>=0){

		 $(this).addClass("current");
		 $(this).find("a").css("color","#ffffff");
		 $(this).parent().parent().addClass("active");

	 }




});

if(url.indexOf("admin_emailpush")>=0){
	 $("#manage_emailpush li:first-child").addClass("current");
	 $("#manage_emailpush li:first-child").find("a").css("color","#ffffff");
	 $("#manage_emailpush li:first-child").parent().parent().addClass("active");
}
if(url.indexOf("admin_xiongzhang")>=0){
	 $("#manage_plugin li.xiongzhang").addClass("current");
	 $("#manage_plugin li.xiongzhang").find("a").css("color","#ffffff");
	 $("#manage_plugin li.xiongzhang").parent().parent().addClass("active");
}
if(url.indexOf("admin_course")>=0){

	 $("#manage_course ").addClass("active");
}

$(".current").parent().parent().addClass("active");

</script>
