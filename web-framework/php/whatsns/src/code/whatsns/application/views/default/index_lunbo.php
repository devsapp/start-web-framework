<div id="slide01" class="tab" onmouseover="this.className='tab tab-active';" onmouseout="this.className='tab';">
<div class="control" id="slide01_control">
<a href="javascript:void(0)" class="current"></a>
<a href="javascript:void(0)" class=""></a>
<a href="javascript:void(0)" class=""></a>
</div>
<a href="javascript:;" class="btnlunbo btnL" onclick="slide01.prev();return false;" onmouseover="slide01.stop();" onmouseout="slide01.play();"></a>
<a href="javascript:;" class="btnlunbo btnR" onclick="slide01.next();return false;" onmouseover="slide01.stop();" onmouseout="slide01.play();"></a>
<div class="tabContent">

{eval $lunbolist=array(array('title'=>'喝果汁≠吃水果，宝宝1岁内能不能喝果汁？','image'=>'https://inews.gtimg.com/newsapp_bt/0/12231284174/641','href'=>"https://www.baidu.com"),array('title'=>'喝果汁≠吃水果，宝宝1岁内能不能喝果汁？','image'=>'https://img0.pcbaby.com.cn/pcbaby/vedio/000031346/2004/20204/1/15857347814840870.jpg','href'=>"https://xw.qq.com/cmsid/20191022V06G8T00"),array('title'=>'喝果汁≠吃水果，宝宝1岁内能不能喝果汁？','image'=>'https://img0.pcbaby.com.cn/pcbaby/special/2009/20209/29/16013779906401250.jpg','href'=>"https://www.sohu.com/a/411363978_120334127?_f=index_pagefocus_3"));}

<div class="slideContent">
{loop $lunbolist $lunbo}
<div class="c" style="display: block;">
<div class="pic">
<a target="_blank" href="{$lunbo['href']}" title="{$lunbo['title']}"><img src="{$lunbo['image']}" alt="{$lunbo['title']}" width="660" height="340"><span class="picTit"><em>{$lunbo['title']}</em></span></a>
</div>
</div>
{/loop}
</div>
</div>
</div>