/*!
 * 商品展示视频
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
$.fn.metShopVideo=function(item,dots,dots_events){
	var product_video=$('textarea[name="met_product_video"]').val();
	item=item||'img';
	if(!($(this).length && $(item,this).length && product_video && $(product_video).find('video,iframe,embed').length)) return;
	var $self=$(this);
	if($self.css('position')=='static') $self.css({position:'relative'});
	setTimeout(function() {
		if($self.find('.met-product-showvideo-wrapper').length) return;
		// 显示视频
		var playinfo=$('textarea[name="met_product_video"]').data('playinfo').split('|'),
			autoplay=parseInt(M.device_type=='m'?playinfo[1]:playinfo[0]);
		if(autoplay) product_video=product_video.replace('<video ','<video muted ');
		product_video=product_video.replace('<video ','<video playsinline webkit-playsinline controlsList="nodownload" ');
		$self.append('<div class="met-product-showvideo-wrapper" hidden>'
			+'<div class="met-product-showvideo-btn hide"><a href="javascript:;" class="block d-block pull-xs-left"><i class="fa-play-circle-o"></i></a></div>'
			+'<div class="met-product-showvideo w-full w-100p vertical-align text-xs-center text-center">'
				+'<div class="vertical-align-middle bg-white text-xs-center">'+product_video
			+'<a href="javascript:;" class="video-close text-xs-center text-center">×</a></div></div>'
		+'</div>');
		var $item0=$self.find((item)+':eq(0)'),
			min_width=Math.min(800,$item0.width()),
			min_height=Math.min(500,$item0.height()),
			height=$item0.height()||300,
			$video_wrapper=$self.find('.met-product-showvideo-wrapper'),
			$showvideo=$video_wrapper.find('.met-product-showvideo'),
			$btn_showvideo=$video_wrapper.find('.met-product-showvideo-btn'),
			$video_close=$video_wrapper.find('.video-close'),
			$video=$showvideo.find('video')[0],
			$obj_video=$showvideo.find('video,iframe,embed'),
			scale=$obj_video.attr('height')/$obj_video.attr('width');
		$showvideo.height(height).find('video,iframe,embed').css({'max-height':min_height}).height(height).width('auto');
		$showvideo.find('iframe').width(scale?$obj_video.height()/scale:$obj_video.height());
		setTimeout(function(){
			$video_wrapper.removeAttr('hidden');
			// 播放按钮
			$btn_showvideo.css({
				top: height-(height-$showvideo.find('video,iframe,embed').height())/2-15,left:10+$showvideo.find('.vertical-align-middle').position().left
			}).click(function(event) {
				$(this).addClass('hide');
				$showvideo.show();
				if($video){
					autoplay && $video.currentTime && ($video.muted = false);
					$video.currentTime=0;
					$video.play();
				}
			});
			// 自动播放
			autoplay && $btn_showvideo.click();
			if(M.device_type=='m'){
				if($video && /iPhone/.test(M.useragent)){
					document.addEventListener('touchstart', function(){
						autoplay && !$video.currentTime && $btn_showvideo.click();
					}, false);
				}
				$self.addClass('overflow-visible');
				$video_close.css({top:-30});
			}
			$video && $video.addEventListener('play', function () {
		        $btn_showvideo.addClass('hide');
		    });
			// 关闭视频
			$video_close.click(function(event) {
				$video && $video.pause();
				$showvideo.hide();
				$btn_showvideo.removeClass('hide');
			});
			// 切换展示图片的时候，隐藏视频
			$self.on(dots_events||'click',dots||'.slick-dots li',function(event) {
				$showvideo.is(':visible') && $video_close.click();
			});
		},100)
	}, 900);
};