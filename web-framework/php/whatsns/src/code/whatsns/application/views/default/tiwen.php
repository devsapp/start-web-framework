
<!--正在提问-->

<div class="tiwening mar-t-05">

    <div class="right_box_title clearfix">
        <strong>正在提问</strong>


        <a class="pull-right mar-ly-05"  href="{url category/view/all/1}">
            更多
        </a>
    </div>

    <hr>

    <div class="askusers">


        <ul class="right_box_list_lun clear">
          <!--{eval $nosolvelist=$this->fromcache('nosolvelist');}-->
                <!--{loop $nosolvelist $index $question_left}-->
            <li class="clear " >
                <div class="left">
                    <span>{$question_left['format_time']}</span>
                    <b></b>
                </div>
                <div class="right">
                    <div class="right_top clear">
                        <img width="50" height="50" alt="{$question_left['author']}"
                             src="{$question_left['avatar']}"
                             onmouseover="pop_user_on(this, '1273554', 'img');" onmouseout="pop_user_out();">

                        <div>
                            <span>{$question_left['author']}</span>
                        </div>
                    </div>
                    <div class="right_bottom">
                        <strong class="otw clear"><i>Q:</i><a title="{$question_left['title']}" target="_blank"
                                                              href="{url question/view/$question_left['id']}">{$question_left['title']}</a></strong>

                        <div class="clear">
                           

                            <p>{$question_left['description']}</p>
                        </div>
                    </div>
                </div>
            </li>
              <!--{/loop}-->
          

        </ul>

    </div>

</div>
<script>

//JavaScript Document
(function($){
	$.fn.myScroll = function(options){
	//默认配置
	var defaults = {
		speed:40,  //滚动速度,值越大速度越慢
		rowHeight:24 //每行的高度
	};
	
	var opts = $.extend({}, defaults, options),intId = [];

	function marquee(obj, step){

		obj.find("ul").animate({
			marginTop: '-=1'
		},0,function(){
				var s = Math.abs(parseInt($(this).css("margin-top")));
				console.log(s);
				if(s >= step){
					$(this).find("li").slice(0, 1).appendTo($(this));
					$(this).css("margin-top", -10);
				}
			});
		}
		
		this.each(function(i){
			var sh = opts["rowHeight"],speed = opts["speed"],_this = $(this);
			intId[i] = setInterval(function(){
				if(_this.find("ul").height()<=_this.height()){
					clearInterval(intId[i]);
				}else{
					marquee(_this, sh);
				}
			}, speed);

			_this.hover(function(){
				clearInterval(intId[i]);
			},function(){
				intId[i] = setInterval(function(){
					if(_this.find("ul").height()<=_this.height()){
                        console.log(_this.find("ul").height());
                        console.log(_this.height());
						clearInterval(intId[i]);
					}else{
                       
						marquee(_this, sh);
					}
				}, speed);
			});
		
		});

	}

})(jQuery);
</script>
<script>
$(function(){
	$("div.askusers").myScroll({
		speed:40, //数值越大，速度越慢
		rowHeight:150 //li的高度
	});
});
</script>
</script>
<!--正在提问结束标记-->