<!--{template header}-->

<style>
.main-wrapper {
    margin-bottom: 40px;
    background: #fff;
}
.tag-list__itembody {
    padding: 20px 0;
    margin-bottom: 0;
}
</style>
<div class="container collection index tagindex" style="padding:15px;">


<h1 class="h3 mt30">标签</h1>
<p>标签不仅能组织和归类你的内容，还能关联相似的内容。正确的使用标签将让你的问题被更多人发现和解决。</p>
<h2 class="h4 mt30">
            常用标签
            <small class="ml5"><a href="{url tags/all}">全部</a></small>
        </h2>
        
        <div class="ui-row tag-list mt20">
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

       {eval  $catlist=$this->getlistbysql("select * from ".$this->db->dbprefix."category where isuseask=1 order by questions desc  limit 0,16");}
        {if $catlist}
   <div style="clear: both"></div>     
<h2 class="h4 mt30">热门话题</h2>
<div class="ui-row tag-index">
      <!--{loop $catlist $index $cat}-->
   <div class="ui-col">
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
  {/if}
</div>
<div style="clear: both"></div>
<!--{template footer}-->