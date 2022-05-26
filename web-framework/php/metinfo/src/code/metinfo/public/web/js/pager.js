/*!
 * 列表页翻页功能
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
(function(){
	$(function(){
		// 翻页ajax加载
		if($(".met-pager-ajax,.met-page-ajax").length && $('#metPageT').length){
			var $met_pager=$('.met_pager'),
				$metpagerajax_link=$(".met-pager-ajax-link");
			if($met_pager.length){
				if($metpagerajax_link.hasClass("hidden-md-up")){
					Breakpoints.on('xs',{
		            	enter:function(){
							metpagerajax();
						}
					});
				}else{
					metpagerajax();
				}
		        setTimeout(function(){
					$metpagerajax_link.scrollFun(function(val){
			            val.appearDiy();
					});
				},0)
			}
		}else $('.met_pager').remove();
	});
	// 分页脚本
	function metpagerajax(){
		var $metpagerbtn=$("#met-pager-btn"),
			$metpaget=$('#metPageT'),
			$metpagerajax=$(".met-pager-ajax,.met-page-ajax"),
			$Ahover=$('.met_pager .Ahover'),
			pageurl_str=$Ahover.next().attr('href'),
			pagemax=$metpaget.data('pageurl')?parseInt($metpaget.data('pageurl').split('|')[2]):1,
			page=parseInt($metpaget.val()),
			metpagerbtnText=function(){
				$metpagerbtn.removeClass('disabled').find('.fa-refresh').remove();
				$metpagerbtn.find('.wb-chevron-down').show();
				if(pagemax){
					if(pagemax==page) $metpagerbtn.attr({hidden:''})/*addClass('disabled').text('已经是最后一页了')*/;
				}else{
					$metpagerbtn.attr({hidden:''});
				}
			};
		metpagerbtnText();
		!pageurl_str && (pageurl_str=$Ahover.prev().attr('href'));
		!pageurl_str && (pageurl_str=$Ahover.attr('href'));
		pageurl_str.indexOf('.php')>0 && (pageurl_str+=(pageurl_str.indexOf('.php?')>0?'&':'?')+'page=');
		$metpagerbtn.click(function(){
			if(!$metpagerbtn.hasClass('disabled')){
				$(this).addClass('disabled').prepend('<i class="icon fa-refresh fa-spin"></i>').find('.wb-chevron-down').hide();
				page++;
				if(pageurl_str.indexOf('.php')>0){
					var pageurl=pageurl_str+page;
				}else{
					var fielename=pageurl_str.split('/').slice(-1)[0],
						fielename_name=fielename.split('.')[0],
						delimiter=fielename_name.indexOf('-')>0?'-':'_',
						fielename_names=fielename_name.split(delimiter),
						last=fielename_names.slice(-1)[0],
						last_is_nan=isNaN(last),
						new_last=last_is_nan?delimiter+last:'';
					fielename_name=fielename_names.slice(last_is_nan?-2:-1)[0];
					var new_fielename=fielename.replace(fielename_name+new_last+'.',page+new_last+'.'),
						pageurl=pageurl_str.replace(fielename,new_fielename);
				}
				$.ajax({
					url:pageurl,
					type:'GET',
					success:function(data){
						var $data=$(data).find('.met-pager-ajax,.met-page-ajax');
						if(!$data.length){
							data='<div class="met-pager-ajax">'+data+'</div>';
							$data=$(data);
						}
						$data.find('>').addClass('page'+page).removeClass('shown');
						// 静态化状态下获取翻页列表数据的浏览次数的js语句预处理
						$data.find('.met_hits').each(function(index, el) {
							$(this).attr({'data-src':$(this).attr('src')}).removeAttr('src');
						});
						data=$data.html();
						$metpagerajax.append(data);
						metpagerajaxFun(page);
						metpagerbtnText();
					}
				});
			}
		});
	}
	// 无刷新分页获取到数据追加到页面后，可以在此方法继续处理
	function metpagerajaxFun(page){
		var $metpagerajax=$('.met-pager-ajax,.met-page-ajax'),
			metpager_original='.page'+page+' [data-original]'
			$data_appear=$metpagerajax.find('.page'+page+' [data-plugin="appear"]');
		if($metpagerajax.find(metpager_original).length){
			// 图片高度预设
			// setTimeout(function(){
				$metpagerajax.imageSize(metpager_original);
			// },0)
			// 图片延迟加载
		    if($metpagerajax.find(metpager_original).length) $metpagerajax.find(metpager_original).lazyload();
			setTimeout(function(){
				$('html,body').stop().animate({scrollTop:$(window).scrollTop()+2},0);
		    },300)
		}
	    if($data_appear.length) $data_appear.trigger('appear');
		if($('#met-grid').length){
			setTimeout(function(){
				if(typeof metAnimOnScroll != 'undefined') metAnimOnScroll('met-grid');// 产品模块瀑布流
			},100)
		}
		// 获取翻页列表数据的浏览次数
		if($metpagerajax.find('.page'+page+' .met_hits').length){
			$metpagerajax.find('.page'+page+' .met_hits').each(function(index, el) {
				var $self=$(this);
				if($(this).data('src')){
					$.ajax({
						url:$(this).data('src'),
						type:'POST',
						data:{ajax:1},
						success:function(result){
							if(result!='') $self.after(parseInt(result));
						}
					});
				}
			});
		}
	}
})();