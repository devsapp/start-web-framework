<!--{template header}-->
 <!-- 首页导航 --> 
{template index_nav}

<link rel="stylesheet" media="all" href="{SITE_URL}static/css/common/commtag.css" />

<div class="layui-container collection index tagindex" style="margin-bottom: 20px;" >
<div class="layui-card">
  <div class="layui-card-header">标签</div>
  <div class="layui-card-body">
 <p>标签不仅能组织和归类你的内容，还能关联相似的内容。正确的使用标签将让你的问题被更多人发现和解决。</p>
 <div class="tagsearchbox">

              <div class="form-group">
    
       
           
          <div class=" dongtai ">
          <div class="tags">
      
          </div>
            <input type="text" autocomplete="off"  data-toggle="tooltip" data-placement="bottom" title="" placeholder="可输入拼音或者中文搜索" data-original-title="支持拼音+中文检索" name="topic_tagset" value=""  class="txt_taginput" >
            <i class="layui-icon layui-icon-search"></i>
           <div class="tagsearch">
        
          
           </div>
            
          </div>
        
        </div>
</div>
  </div>
</div>
    
    <div class="layui-card">
  <div class="layui-card-header">  常用标签
            <small class="ml5"><a href="{url tags/all}">全部</a></small></div>
  <div class="layui-card-body">
    <div class="layui-row tag-list mt20">
                            {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='A' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">A</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='B' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">B</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                    
                    
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='C' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">C</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                    
                    <!-- D -->
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='D' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">D</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                    <!-- E -->
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='E' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">E</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                    
                    <!-- F -->
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='F' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">F</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                    
                       <!-- G -->
                       
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='G' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">G</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                    
                      <!-- H -->
                       
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='H' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">H</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                   <!-- I -->
                       
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='I' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">I</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}   
                    
                      <!-- J -->
                       
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='J' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">J</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                      <!-- K -->
                       
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='K' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">K</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                    
                       <!-- L -->
                       
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='L' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">L</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                    
                       <!-- M -->
                       
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='M' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">M</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                    
                       <!-- N -->
                       
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='N' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">N</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                    
                        
                       <!-- O -->
                       
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='O' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">O</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                        
                       <!-- P-->
                       
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='P' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">P</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                    
                        
                       <!-- Q -->
                       
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='Q' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">Q</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                    
                    
                        
                       <!-- R -->
                       
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='R' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">R</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                    
                        
                       <!-- S -->
                       
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='S' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">S</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                    
                    
                        
                       <!-- T -->
                       
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='T' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">T</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                    
                    
                        
                       <!-- U -->
                       
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='U' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">U</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                    
                        
                       <!-- V -->
                       
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='V' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">V</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                    
                        
                       <!-- W -->
                       
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='W' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">W</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                    
                        
                       <!-- X -->
                       
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='X' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">X</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                    
                        
                       <!-- Y -->
                       
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='Y' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">Y</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                    
                        
                       <!-- Z -->
                       
                         {eval  $taglist=$this->getlistbysql("select * from ".$this->db->dbprefix."tag where tagfisrtchar='Z' order by tagquestions desc,tagarticles desc  limit 0,10");}
        {if $taglist}
        <div class="tag-list__itemWraper">
                    <div class="tag-list__itemInnerBox">
                        <h3 class="h5 tag-list__itemheader">Z</h3>
                        <ul class="tag-list__itembody taglist--inline multi">
                                   
                
    
       <!--{loop $taglist $index $tag}-->
                                                                 
                                                                                                <li class="tagPopup">
                                        <a href="{url tag/$tag['tagalias']}" class="tag" >
                                        {if $tag['tagimage']}
                                                                                            <img src="{$tag['tagimage']}">
                                                                                            {/if}
{$tag['tagname']}
                                        </a>
                                    </li>
                                      <!--{/loop}-->
                                                                                    </ul>
                    </div>
                </div>
                    {/if}
                    
                    
        </div>
  </div>
</div>
     {eval  $catlist=$this->getlistbysql("select * from ".$this->db->dbprefix."category where isuseask=1 and iscourse=0 order by questions desc  limit 0,16");}
        {if $catlist}
<div class="layui-card">
  <div class="layui-card-header">热门话题</div>
  <div class="layui-card-body">
<div class="layui-row tag-index layui-col-space10">
      <!--{loop $catlist $index $cat}-->
   <div class="layui-col-md4">
                    <div class="media border">
                        <a class="pull-left" href="{url category/view/$cat['id']}">
                            <img class="media-object" width="40" height="40" src="{eval echo get_cid_dir ( $cat['id'], 'big' );}" alt="{$cat['name']}">
                        </a>

                        <div class="media-body">
                            <h3 class="h5 media-heading"><a href="{url category/view/$cat['id']}">{$cat['name']}</a></h3>

                            <p class="text-muted mb0" >{eval echo clearhtml($cat['miaosu'],20)}</p>
                        </div>
                    </div>
                </div>
                    <!--{/loop}-->
</div>

  </div>
</div>
      {/if}


   
</div>
<script type="text/javascript">
layui.use(['jquery', 'layer'], function(){
	  var $ = layui.$ //重点处
	  ,layer = layui.layer;
	  $(".txt_taginput").on(" input propertychange",function(){
			 var _txtval=$(this).val();
			 if(_txtval.length>1){
			
				 //检索标签信息
				 var _data={tagname:_txtval};
				 var _url="{url tags/ajaxsearch}";
			
				 $.ajax({
				        //提交数据的类型 POST GET
				        type:"POST",
				        //提交的网址
				        url:_url ,
				        //提交的数据
				        data:_data,
				        //返回数据的格式
				        datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
				        beforeSend: function () {

				        	loading=layer.load(0, {
				                shade: false,
				                time: 2*1000
				            });
				         },
				        //成功返回之后调用的函数
				        success:function(result){
				        	var result=eval("("+result+")");
				   		 console.log(result)
						 if(result.code==200){
							 console.log(_txtval)
							  $(".tagsearch").html("");
							for(var i=0;i<result.taglist.length;i++){
						
								 var _msg=result.taglist[i].tagname
								 
						           $(".tagsearch").append('<div class="tagitem" tagid="'+result.taglist[i].id+'"><a target="_blank" href="'+result.taglist[i].url+'">'+_msg+'</a></div>');
							}
						if(result.taglist.length>0){
							
							$(".tagsearch").show();
						}else{
							$(".tagsearch").hide();
						}
						 }else{
							
							 $(".tagsearch").hide();
						 }
				        }   ,
				        complete: function () {
				        	layer.close(loading);
				         },
				        //调用出错执行的函数
				        error: function(){
				      	 layer.msg("请求异常", {
				 			  time: 1500 
						});
				            //请求出错处理
				        }
				    });
				    
		
			 }else{
					$(".tagsearch").html("");
					$(".tagsearch").hide();
			 }
		})

});




</script>
<!--{template footer}-->