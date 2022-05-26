/*!
 * 编辑器内容处理功能
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
(function(){
	$(function(){
		// 编辑器响应式表格（需调用tablesaw插件）
		var $meteditor_table=$(".met-editor table");
		if($meteditor_table.length) $meteditor_table.tablexys();
		// 图片尺寸自适应
		$('.met-editor img[width][height],.met-editor img[style*="width:"][style*="height:"]').each(function(){
			if($(this).attr('width')>$(this).parent().width()||parseInt($(this).css('width'))>$(this).parent().width()) $(this).removeAttr('height').height('');
		});
		if(M.device_type=='m'){
			var editorimg_gallery_open=true;
			// 编辑器画廊
			$(".met-editor").each(function(){
				if($("img",this).length && !$(this).hasClass('no-gallery')){
					// 图片画廊参数设置
					var $self=$(this),
						imgsizeset=true;
					$("img",this).one('click',function(){
						var $img=$(this);
						if(imgsizeset){
							$self.find('img').each(function(){
	    						var src=$(this).attr('src'),
	    							size='';
	    						if($(this).data('width')){
	    							size=$(this).data('width')+'x'+$(this).data('height');
	    						}else if($(this).attr('width') && $(this).attr('height')){
	    							size=$(this).attr('width')+'x'+$(this).attr('height');
	    						}
								if(!($(this).parents('a').length && $(this).parents('a').find('img').length==1)) $(this).wrapAll('<a class="photoswipe-a"></a>');
								var $this_photoswipe_a=$(this).parents('.photoswipe-a');
								$this_photoswipe_a.attr({href:src,'data-med':src});
								if(size){
									$this_photoswipe_a.attr({'data-size':size,'data-med-size':size});
								}else{
									if($(this).data('original') && $(this).data('original')==$(this).attr('src')){
										var sizes=$(this)[0].naturalWidth+'x'+$(this)[0].naturalHeight;
										$this_photoswipe_a.attr({'data-size':sizes,'data-med-size':sizes});
									}
									$(this).imageloadFunAlone(function(imgs){
										var sizes=imgs.width+'x'+imgs.height;
										$this_photoswipe_a.attr({'data-size':sizes,'data-med-size':sizes});
									})
								}
			    			});
			    			imgsizeset=false;
						}
	    				if(editorimg_gallery_open){
		    				setTimeout(function(){
				    			$.initPhotoSwipeFromDOM('.met-editor','.photoswipe-a');//（需调用PhotoSwipe插件）
								editorimg_gallery_open=false;
								$img.click();
		    				},300);
		    			}
		    		});
				}
			});
		}
		// 兼容手机端百度地图溢出和坐标位置不居中的问题
		Breakpoints.on('xs',{
            enter:function(){
				$(".met-editor iframe.ueditor_baidumap").each(function(index, el) {
					var src=$(this).attr('src'),
						width=src.match(/width=(\w+)/)[1],
						new_width=$(this).width()-4;
					src=src.replace('&width='+width+'&','&width='+new_width+'&');
					$(this).attr('src',src);
				});
			}
		});
		// 编辑器内容分页
		$(".met-editor .met-editor-tab").each(function(index1, el1) {
			var html='';
			$(this).prev('.met-editor-tabcontent').find('.tab-pane').each(function(index2, el2) {
				var thisid='met-editor-tabcontent'+index1+'-'+index2;
				$(this).attr('id',thisid);
				if(!index2) $(this).addClass('active');
				html+='<li class="page-item '+(index2?'':'active')+'" data-toggle="tab" href="#'+thisid+'"><a href="javascript:;" class="page-link">'+(index2+1)+'</a></li>';
			});
			$('.pagination',this).html(html);
		});
		setTimeout(function(){
			$(".met-editor .met-editor-tab .pagination li").click(function(event) {
				var $obj=$($(this).attr('href'));
				setTimeout(function(){
					if($(window).scrollTop()>$obj.offset().top) $('html,body').stop().animate({scrollTop:$obj.offset().top}, 300);
				},300);
			});
		},0)
	});
})();