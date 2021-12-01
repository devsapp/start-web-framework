/*!
 * 产品模块
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
(function(){
	$(function(){
		// 产品列表页
		if($('.met-product-list').length){
			// 图片懒加载
			var $metpro_original=$(".met-product-list [data-original]");
			if($metpro_original.length){
				var $pro_fluid=$(".met-product-list .container-fluid");
				if($pro_fluid.length){
					$pro_fluid.each(function(){
						var $self=$(this);
						$(this).width($(this).width());
						setTimeout(function(){
							$self.width('');
						},2000)
					});
				}
			}
		}
		// 列表瀑布流
		if($('#met-grid').length){
			setTimeout(function(){
				metAnimOnScroll('met-grid');
			},500)
		}
		// 产品详情页
		// 选项卡水平滚动
		var $met_showpro_navtab=$('.met-showproduct-navtabs');
		if($met_showpro_navtab.length) $met_showpro_navtab.navtabSwiper();
		// 产品详情页标准模式
		// if($('.met-showproduct.pagetype1').length){
		// 	// 选项卡点击切换触发事件
		// 	$met_showpro_navtab.find('a[data-toggle="tab"]').on('shown.bs.tab',function(){
		// 		var href=$(this).attr('href');
		// 		$('[data-original]:eq(0)',href).trigger('scroll');
		// 	})
		// }
		// 产品详情页时尚模式
		var $showprotype2=$('.met-showproduct.pagetype2');
		if($showprotype2.length){
			$showprotype2.find('.navbar').wrap('<div></div>');
			var $pro_navbar=$showprotype2.find('.navbar'),
				pro_navbar_t=$pro_navbar.offset().top,
				pro_navbar_fixclass='navbar-fixed-top animation-slide-top',
				$protype2_navtabs_a=$pro_navbar.find('.met-showproduct-navtabs li a'),
				proNavbarStop=0,
				proNavbarScroll=function(){
					var st=$(window).scrollTop();
					// 标题工具栏固定
					if(st>pro_navbar_t){
						if(!$pro_navbar.hasClass(pro_navbar_fixclass)) $pro_navbar.addClass(pro_navbar_fixclass).parent().height($pro_navbar.height());
					}else if($pro_navbar.hasClass(pro_navbar_fixclass)){
						$pro_navbar.removeClass(pro_navbar_fixclass).parent().height('');
					}
					if(!proNavbarStop){
						// 选项卡自动选中
						$protype2_navtabs_a.each(function(){
							var offsettop=proTabTop($(this),$pro_navbar);
							if(st>=(offsettop-50)) proNavActive($(this));// 30为区域上下内边距，根据需要调整
						});
					}
				};
			proNavbarScroll();
			$(window).scroll(function(){
				proNavbarScroll();
			});
			// 选项卡点击滚动事件
			$protype2_navtabs_a.click(function(e){
				e.preventDefault();
				proNavbarStop=1;
				var $self=$(this),
					scrollTopInt=setInterval(function(){
						var st=$(window).scrollTop(),
							scroll_goto=proTabTop($self,$pro_navbar);
						proNavActive($self);
						if(st>=scroll_goto-1 || st+$(window).height()>=$(document).height()-1){
							setTimeout(function(){
								proNavbarStop=0;
							},300);
							clearInterval(scrollTopInt);
						}
						$('html,body').animate({scrollTop:scroll_goto},300,"linear");
					},300)
			})
		}
		if(M.id && $('#met-imgs-slick').length && $('textarea[name="met_product_video"]').val()){
			$.include(M.weburl+'public/web/js/shop_video.js',function(){
				$('#met-imgs-slick').metShopVideo();
			})
		}
	});
	// 选中选项卡
	function proNavActive(dom){
		dom.addClass('active').parent().siblings('li').find('.nav-link').removeClass('active');
	}
	// 获取选项卡内容距离顶部的位置
	function proTabTop(dom,topdom){
		var offsettop=$(dom.attr("href")).offset().top-topdom.height();
		return offsettop;
	}
	// 瀑布流配置（需调用masonry、masonry-extend插件）
	window.metAnimOnScroll=function(obj){
		new AnimOnScroll( document.getElementById(obj),{
			minDuration:0.4,
			maxDuration:0.7,
			viewportFactor:0.2
		});
	}
})();