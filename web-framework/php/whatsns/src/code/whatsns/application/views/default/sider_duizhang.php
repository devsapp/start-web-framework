   <!--{eval $duizhanglist=$this->fromcache('duizhang');}-->
    <!--{if $duizhanglist}-->

 <style>
        *{margin:0;padding:0}
        #whatsns_notemoney{height:50px;overflow:hidden;}
        #whatsns_notemoney p{height:34px;line-height:34px;overflow:hidden}

    </style>

      <!--站内用户收益公告-->

    <div class="whatsns_notemoney" id="whatsns_notemoney">
     <div id="moneyp">
     <!--{loop $duizhanglist $index $shang}-->
      <p> <i class="fa fa-bell-o"></i> <span class="bell_text">   <a href="{url user/space/$shang['touser']['uid']}" target="_self" class="name">
           {$shang['touser']['username']}{if $shang['author_has_vertify']!=false}<i class="fa fa-vimeo {if $shang['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $shang['author_has_vertify'][0]=='0'}data-original-title="认证用户" {else}data-original-title="认证用户" {/if} ></i>{/if}
        </a> {$shang['operation']} <span class="bell-jine"> {$shang['money']}</span></span></p>
      <!--{/loop}-->
      </div>
        <div id="whatsns_notemoneybk"></div>
    </div>
            <script>
    var speed=80
    var slide=document.getElementById("whatsns_notemoney");
    var slide2=document.getElementById("whatsns_notemoneybk");
    var slide1=document.getElementById("moneyp");
    slide2.innerHTML=slide1.innerHTML
    function Marquee(){
        if(slide2.offsetTop-slide.scrollTop<=0)
            slide.scrollTop-=slide1.offsetHeight
        else{
            slide.scrollTop++
        }
    }
    var MyMar=setInterval(Marquee,speed)
    slide.onmouseover=function(){clearInterval(MyMar)}
    slide.onmouseout=function(){MyMar=setInterval(Marquee,speed)}
</script>
     <!--{/if}-->