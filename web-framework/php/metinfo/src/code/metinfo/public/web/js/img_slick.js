/*!
 * 详情页展示图片（需调用slick插件）
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
(function() {
	$(function() {
		// 产品详情页、图片模块详情页轮播图，共用插件
		var $met_img_slick = $('#met-imgs-slick'),
			$met_img_slick_slide = $met_img_slick.find('.slick-slide');
		if ($met_img_slick_slide.length > 1) {
			// 缩略图水平滑动
			$met_img_slick.on('init', function(event, slick) {
					$met_img_slick.find('ul.slick-dots').navtabSwiper();
				})
				// 开始轮播
			var slick_swipe = true,
				slick_fade = slick_arrows = false;
			if (M.device_type == 'd' && $met_img_slick.hasClass('fngallery')) {
				slick_swipe = false;
				slick_fade = true;
			}
			if (!slick_swipe) $met_img_slick.addClass('slick-fade'); // 如果切换效果为淡入淡出，则加上标记class，其slick-slide鼠标样式为缩放镜
			if (M.device_type != 'm') slick_arrows = true;
			$met_img_slick.slick({
				arrows: slick_arrows,
				dots: true,
				speed: 300,
				fade: slick_fade,
				swipe: slick_swipe,
				customPaging: function(a, b) { // 缩略图html
					var $selfimg = $met_img_slick_slide.eq(b),
						src = $selfimg.find('.lg-item-box').data('exthumbimage'),
						alt = $selfimg.find('img').attr('alt'),
						img_html = '<img src="' + src + '" alt="' + alt + '" />';
					return img_html;
				},
				prevArrow: met_prevarrow,
				nextArrow: met_nextarrow,
				adaptiveHeight: true,
				lazyloadPrevNext: 1
			});
			// 切换图片之前，判断所有图片是否被替换，如被替换，则还原
			$met_img_slick.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
				$met_img_slick_slide.each(function(index, el) {
					var thisimg = $('img', this),
						thisimg_datasrc = thisimg.attr('data-src');
					if (!thisimg.attr('data-lazy') && thisimg.attr('src') != thisimg_datasrc) thisimg.attr({
						src: thisimg_datasrc
					});
				});
			});
		}
		// 画廊加载
		var $fngallery = $('.fngallery');
		if ($fngallery.length) {
			var $fngalleryimg = $fngallery.find('.slick-slide img');
			if ($fngalleryimg.length) {
				var fngallery_open = true;
				$fngalleryimg.each(function() {
					$(this).one('click', function() {
						if (fngallery_open) {
							if (M.device_type == 'm') {
								$fngalleryimg.each(function(index, el) {
									var size='400x400';
									$(this).parents('[data-med][data-size="x"]').attr({'data-size':size,'data-med-size':size});
								});
								$.initPhotoSwipeFromDOM('.fngallery', '.slick-slide:not(.slick-cloned) [data-med]'); //（需调用PhotoSwipe插件）
							} else {
								$fngallery.galleryLoad(); //（需调用lightGallery插件）
							}
							fngallery_open = false;
						}
					});
				})
			}
		}
		if(M.id && $met_img_slick.length && $('textarea[name="met_product_video"]').val()){
			$.include(M.weburl+'public/web/js/shop_video.js',function(){
				$met_img_slick.metShopVideo();
			})
		}
	});
})();