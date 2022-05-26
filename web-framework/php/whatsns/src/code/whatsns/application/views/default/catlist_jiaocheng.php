<!--{template header}-->
<style>
.container h1{
    font-size: 48px;
    font-weight: 400;
margin-bottom:20px;
}
.card{
padding:15px;
margin-top:10px;
}
.card h2{
    font-size: 24px;
    font-weight: 600;
}
.card  .row {
margin-top:20px;
}
.card .col{
    padding-top: 10px;
     padding-bottom: 10px;
    }
.card a{
text-decoration: none;
    font-weight: 600;

    display: inline-block;
        font-size: 18px;
        color:#ea644a;
    }
    .card a.btn{
    color:#fff;
    font-size:15px;
    }
</style>

<div class="container collection index">
  <div class="row"  style="padding-top:0px;margin:0px">
    <div class="col-xs-24 col-md-24 main">
      <!-- 专题头部模块 -->
         <center><h1> {$catmodel['name']}</h1></center>
       <div class="recommend-collection">
            
        
          <!--{loop $catlist $index $cat}-->
          
                        {eval  $topiclist=$this->getlistbysql("select id,title from ".$this->db->dbprefix."topic where articleclassid=".$cat['id']."  limit 0,100 ");}
       
        {if $topiclist}
          <div class="card">
           <h2>{$cat['name']}</h2>
           <div class="row">
               
       <!--{loop $topiclist $tindex $article}-->
           <div class="col col-md-8">
             <a href="{url topic/getone/$article['id']}">{$article['title']}</a>
           </div>
           {if $tindex==99}
             <div class="col col-md-24">
           <a class="btn  btn-success" href="{url topic/catlist/$cat['id']}">查看更多</a>
              </div>
           {/if}
                      <!--{/loop}-->
           </div>
          </div>
          {/if}
            
                <!--{/loop}--> 
        

                </div>

    </div>
   
  
  </div>
</div>

<!--{template footer }-->