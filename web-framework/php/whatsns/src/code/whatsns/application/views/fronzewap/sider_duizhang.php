   <!--{eval $duizhanglist=$this->fromcache('duizhang');}-->
    <!--{if $duizhanglist}-->
  

    
     <!--赏金猎人-->
                    <div class="au_side_box">

                        <div class="au_box_title">

                            <div>
                               <i><img src="{SITE_URL}static/css/aozhou/dist/images/sj.png" /></i> 赏金猎人

                            </div>

                        </div>
                        <div class="au_side_box_content" id="duizhanglist">
                            <ul id="duizhangbody">
                                  <!--{loop $duizhanglist $index $shang}-->
                    
              
                       
                                <li >
                                    <div class="_smallimage">
                                        <a href="#"><img src="{$shang['touser']['avatar']}" class="img-circle"></a>
                                    </div>
                                    <div class="_content">
                                        <div class="_rihgtc">
                                          <span class="subname">
                                          {$shang['touser']['username']}{$shang['username']}
                                          {if $shang['author_has_vertify']!=false}<i class="fa fa-vimeo {if $shang['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $shang['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
                                          </span>

                                            <p class="_desc"> {$shang['operation']} <span class="_jinetext"><span class="_jine">{$shang['money']}</span></span></p>
                                        </div>

                                    </div>
                                </li>
         <!--{/loop}-->
                            </ul>
                             <ul  id="duizhangfooter">
     </ul>
                        </div>
                    </div>
                    
    <style>

.lieren-title{
	margin-bottom:5px;
}
#duizhanglist {
    width: 100%;
    height: 180px;
    overflow: hidden;
}
    </style>
    <script>
    oMarqueeEvt();
  //向上无缝滚动Event
	function oMarqueeEvt(){
		function $(element){
			return document.getElementById(element);
		}
		var dome=$("duizhanglist");
		var dome1=$("duizhangbody");
		var dome2=$("duizhangfooter");
		var speed=80; //设置向上滚动速度
		dome2.innerHTML=dome1.innerHTML; //复制demo1为demo2
		function moveTop(){
			if(dome2.offsetTop-dome.scrollTop<=0) //当滚动至demo1与demo2交界时
				dome.scrollTop-=dome1.offsetHeight; //demo跳到最顶端
			else{
				dome.scrollTop++;
			}
		}
		var MyMar=setInterval(moveTop,speed); //设置定时器
		dome.onmouseover=function() {clearInterval(MyMar)}; //鼠标移上时清除定时器达到滚动停止的目的
		dome.onmouseout=function() {MyMar=setInterval(moveTop,speed)}; //鼠标移开时重设定时器，继续滚动
	}
    </script>
            <!--{/if}-->