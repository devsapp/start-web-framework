define(function(require, exports, module) {

	var $ = jQuery = require('jquery');
	//上传组件
	function imgupload(){
		require.async('epl/upload/webuploader.min',function(){
			var uploader = WebUploader.create({
				auto: true,
				swf: siteurl + 'public/admin_old/plugins/upload/Uploader.swf',
				server: basepath + 'index.php?c=uploadify&m=include&a=doupimg&lang='+lang,
				pick: '#filePicker',
				compress:{
					width: 2600,
					height: 2000,
					noCompressIfLarger: true
				},
				accept: {
					title: 'Images',
					extensions: 'gif,jpg,jpeg,bmp,png,svg',//增加文件格式（新模板框架v2）
					mimeTypes: 'image/*'
				}
			}),
			folder_name='';
			// 文件上传中
			uploader.on( 'startUpload', function() {
				$("#filePicker span.filePicker-txt").html(METLANG.upload_progress_v6+"...");
			});
			//文件上传成功时
			uploader.on( 'uploadSuccess', function( file, response ) {
				if(response.error){
					alert(response.errorcode);
				}else{
					// 重新加载图片库列表，并跳转到上传的文件夹
					var folder_name=response.path.substring(7,response.path.lastIndexOf('/'));
					imglistload(folder_name);
				}
			});
			// 文件全部上传完成时
			uploader.on( 'uploadFinished', function( file ) {
				$("#filePicker span.filePicker-txt").html(METLANG.upload_local_v6);
			});
		});
	}
	// 图片列表分页
	function imglistPage(folder_id){
		if($("#UploadModal .holder").html()!='') $("#UploadModal .holder").jPages("destroy");
		$("#UploadModal .holder").jPages({
			containerID : folder_id,
			perPage :20,
			previous:METLANG.back,
			next:METLANG.next_page,
			delay:0,
			fallback:0,
			callback:function(pages, items){
				$('#upimglist .folder-warrper li').removeClass('checked');
				items.showing.each(function(index, el) {
					if(!$(this).hasClass('folder') && $(this).css('background-image')=='none') $(this).css({'background-image':'url("'+$(this).data('original')+'")'});
				});
			}
		});
	}
	// 图片加载完成处理
	function imglistloadFun(img_paths,name){
		var name=name||'',
			index=name?imgku_folder.indexOf(name.toString()):'all',
			location='upload/'+(name?name+'/':''),
			folder_id='folder-'+index,
			folder_obj='#'+folder_id,
			$folder=$(folder_obj);
		$("#upimglist .folder-warrper").hide().find('li').removeClass('checked');
		if($folder.length){// 展示需要打开的文件夹
			$folder.show();
		}else{// 加载需要打开的文件夹
			var html='',
				folder_html='';
				weburl=siteurl.substring(0,siteurl.length-1);
			for (var i in img_paths) {
				if(i!='unique' && (index=='all'?i.indexOf('/')<0:1)){
					if(img_paths[i]['name']){
						var path = weburl + img_paths[i].path;
						html += '<li title="'+img_paths[i].name+'" data-original="'+path+'">'
								+'<a href="'+path+'" title="'+METLANG.View+METLANG.image+'" target="_blank" class="view"><i class="fa-search-plus"></i></a>'
								+'<div class="check" data-value="'+img_paths[i].value+'" data-path="'+path+'"><i class="fa fa-check"></i></div>'
								+'</li>';
					}else{
						folder_html += '<li class="folder" title="'+METLANG.enter_folder+'">'
								+'<i class="fa-folder-open-o"></i>'
								+'<div class="widget-image-meta" data-name="'+((name?(name+'/'):'')+i)+'">请双击'+METLANG.physicalfunction4+'<br>'+i+'</div>'
								+'</li>';
					}
				}
			}
			html='<ul class="folder-warrper clearfix" id="'+folder_id+'">'+folder_html+html+'</ul>';
			$("#upimglist").append(html);
		}
		// 图片列表分页
		var $folder=$(folder_obj);
		require('epl/upload/jPages.css');
		require.async('epl/upload/jPages.min',function(){
			if($("#UploadModal").is(':visible')){
				imglistPage(folder_id);
			}else{
				var inteval=setInterval(function(){
						if($("#UploadModal").is(':visible')){
							imglistPage(folder_id);
							clearInterval(inteval);
						}
					},10);
			}
		});
		// 更新显示图片文件夹路径
		$('#UploadModal .upimglist-location').html(location);
		// 显示返回上一页按钮
		if(name){
			$('#UploadModal .imglist-back').removeClass('hide');
		}else{
			$('#UploadModal .imglist-back').addClass('hide');
		}
	}
	// 加载图片列表
	function imglistload(folder_name){
		$("#upimglist").html('<div class="loader text-center">'+METLANG.fliptext2+'</div>');
		$.ajax({
		   type: "GET",
		   dataType: "json",
		   url: adminurl+'n=system&c=filept&a=dogetfile',
		   success: function(result){
				window.imgku_path={};
				window.imgku_folder=[];
				$.each(result, function (index, value) {
					var dir=value.path.substring(8,value.path.lastIndexOf('/'));
					if(dir){
						if(dir.indexOf('/')>0){
							var folder_list=dir.split('/'),
								last_dir_list=imgku_path;
							for (var i = 0; i < folder_list.length; i++) {
								if(!last_dir_list[folder_list[i]]) last_dir_list[folder_list[i]]=[];
								last_dir_list=last_dir_list[folder_list[i]];
								if(i>0){
									var last_dir='';
									for (var s = 0; s < i; s++) {
										last_dir+=(last_dir?'/':'')+folder_list[s];
									}
									if(!imgku_path[last_dir]) imgku_path[last_dir]=[];
									if(!imgku_path[last_dir][folder_list[i]]) imgku_path[last_dir][folder_list[i]]=[];
								}
							}
						}
						if(!imgku_path[dir]) imgku_path[dir]=[];
						imgku_path[dir].push(value);
					}else{
						imgku_path.push(value);
					}
				});
				for (var i in imgku_path) {
					if(i!='unique') imgku_folder.push(i);
				}
				imglistloadFun(folder_name?imgku_path[folder_name]:imgku_path,folder_name);
				$("#upimglist .loader").remove();
		   	}
		});
	}
	//图片库
	function imgku(){
		//生成模态框
		var txt = '<div class="modal fade" id="UploadModal" aria-hidden="true">'
				+'<div class="modal-dialog">'
					+'<div class="modal-content">'
						+'<div class="modal-header clearfix" role="tabpanel">'
							+'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
							+'<h4>'+METLANG.upload_selectimg_v6+'</h4>'
							+'<button class="btn btn-success" id="filePicker"><span class="filePicker-txt">'+METLANG.upload_local_v6+'</span></button>'
							+'<span class="red tips" style="display: inline-block;margin-top: 5px;margin-left: 10px;">'+METLANG.enter_folder+'</span>'
						+'</div>'
						+'<div class="modal-body text-right">'
							+'<div class="clearfix">'
								+'<div class="upimglist-location pull-left"></div>'
								+'<button class="btn btn-warning imglist-back hide"><i class="icon wb-reply" aria-hidden="true"></i>'+METLANG.js55+'</span></button>'
								+'<button type="button" class="btn btn-default" data-dismiss="modal" style="margin-left:10px;">'+METLANG.jslang2+'</button>'
								+'<button type="submit" class="btn btn-primary" style="margin-left:10px;">'+METLANG.confirm+'</button>'
							+'</div>'
							+'<div id="upimglist" class="clearfix"><div class="loader text-center">'+METLANG.fliptext2+'</div></div>'
							+'<div class="holder"></div>'
						+'</div>'
					+'</div>'
				+'</div>'
			+'</div>';
		$("body").append(txt);
	}
	// 插入图片
	function imgadd(dom,src,value){
		// 函数重写（新模板框架v2）
		var $appimagelist=dom.next().find(".app-image-list"),
			sort_l=$appimagelist.find('.sort').length;
		$li = ' <li class="sort">' +
				'<a href="'+src+'" target="_blank">' +
					'<img src="'+src+'">' +
				'</a>' +
				'<span class="close hide">&times;</span>' +
			'</li>';
		dom.next().find(".app-image-list li.upnow").before($li);
		// 商品图尺寸设置
		var imgtemp = new Image();
        imgtemp.src = src;
        imgtemp.index=sort_l;
        imgtemp.onload = function(){
			dom.next().find(".app-image-list li.sort:eq("+this.index+") img").attr({'data-size':this.width+'x'+this.height});
		}
	}
	// 重新赋值
	function imgvalue(dom){
		var list = dom.next().find('li.sort'),value = '',l = list.length;
		list.each(function(i){
			var vl = $(this).find("img").attr('src').replace(siteurl,'../');
			value += i>0 ? '|' + vl: vl;
		});
		dom.attr('value',value);
		if($('.product_shop .stock').length) require.async(own+'admin/templates/js/product_shop.js',function(func){
			func.standard_option();
		})
	}

	exports.func = function(e){
		var ik = false,tf = false;
		//构建版面
		var es = e.find('.ftype_upload .fbox input');
		es.each(function(){
			if($(this).data("upload-type")=='doupimg' || $(this).data("upload-type")=='doupico'){
				ik = true;
				var dom = $(this),name = dom.attr('name');
				var doaction = $(this).data("upload-type");
				var data_key = $(this).data("upload-key");
				dom.hide();
				var html = '<div class="picture-list ui-sortable">';
					html+= '<ul class="js-picture-list app-image-list clearfix">';
					html+= '<li class="upnow">' +
							'<div data-name="'+name+'" id="filePicker_'+name+'" class="btn btn-default" style="border-radius:0px"><span class="uptxt">'+METLANG.jsx15+'</span></div>' +
							'</li>';
					if($(this).data("upload-type")=='doupimg')html+= '<li class="imgku">';
					if($(this).data("upload-type")=='doupimg')html+= '<button type="button" data-name="'+name+'" class="btn btn-default" data-toggle="modal" data-target="#UploadModal">'+METLANG.upload_libraryimg_v6+'</button>';
					if($(this).data("upload-type")=='doupimg')html+= '</li>';
					html+= '<li class="add-outside"><button type="button" class="btn btn-default add-outside-btn" data-toggle="popover" data-original-title="" title="">'+METLANG.upload_extraimglink_v6+'</button>'
							+'</li>';
					html+= '</ul>';
					html+= '</div>';
				dom.after(html);
				dom.parent().find('.picture-list .add-outside-btn').popover({
					content:function(){
						return '<div class="ftype_input outside-box">'
									+'<div class="fbox" style="margin-right:0;"><input type="text" name="outside_img" placeholder="'+METLANG.upload_extraimglink_v6+'" style="width: 100% !important;margin-bottom: 5px;"/><br /><button type="button" class="btn btn-primary btn-sm outside-ok" style="margin-right:5px;">'+METLANG.confirm+'</button><button type="button" class="btn btn-default btn-sm  outside-cancel">'+METLANG.jslang2+'</a></div>'
								+'</div>';
					},
					html:true,
					placement:'left'
				});
				var src = dom.val();
				if(src){
					src += '|';
					var srcs = src.split('|'),isrc='';
					for(var i=0;i<srcs.length;i++){
						if(srcs[i]!=''){
							if(srcs[i].indexOf('../')>=0){
								isrc = srcs[i].split('../');
								isrc = siteurl + isrc[1];
							}else{
								isrc=srcs[i];
							}
							imgadd(dom,isrc,srcs[i]);
							isrc = '';
						}
					}
				}
				require.async('epl/upload/webuploader.min',function(){
					var uploaders = WebUploader.create({
						auto: true,
						swf: siteurl + 'public/admin_old/plugins/upload/Uploader.swf',
						server: basepath + 'index.php?c=uploadify&m=include&a='+doaction+'&lang='+lang + '&data_key=' +data_key,
						pick: {
						id:'#filePicker_'+name,
						multiple :dom.data('upload-many')?true:false,
						},
						compress:{
							width: 2600,
							height: 2000,
							noCompressIfLarger: true
						},
						accept: {
							title: 'Images',
							extensions: 'gif,jpg,jpeg,bmp,png,ico,svg',//增加文件格式（新模板框架v2）
							mimeTypes: 'image/*'
						}
					});
					//文件上传成功时
					uploaders.on( 'uploadSuccess', function( file, response ) {
						if(response.error){
							alert(response.errorcode);
						}else{
							if(!dom.data('upload-many')){
								if(dom.next().find('li.sort').length)dom.next().find('li.sort').remove();
							}
							var path = siteurl + response.path;
							imgadd(dom,path,response.original);
							imgvalue(dom);
							$("#UploadModal").data('reload', 1);
						}
					});
					uploaders.on( 'startUpload', function() {
						$('#filePicker_'+name+' span.uptxt').html(METLANG.upload_progress_v6+"...");
					});
					//文件全部上传完成时
					uploaders.on( 'uploadFinished', function( file ) {
						$('#filePicker_'+name+' span.uptxt').html(METLANG.jsx15);
					});
				});
			}
			if($(this).data("upload-type")=='doupfile'){
				tf = true;
			}
		});
		if(tf){
			require.async('epl/uploadify/upload',function(a){
				a.func(e);
			});
		}
		if(ik){
			/*拖曳排序*/
			require.async('plugins/dragsort/jquery.dragsort',function(){
				$('.ftype_upload ul.app-image-list').dragsort({
					dragSelector: "li.sort a",
					dragBetween: false ,
					dragEnd: function() {
						var dom = $(this).parents('.picture-list').parent().find('input[data-upload-type="doupimg"]');
						imgvalue(dom);
					}
				}).find('.sort a').click(function(e) {// 火狐浏览器拖拽会跳转的兼容
					if(navigator.userAgent.indexOf("Firefox") > -1) e.preventDefault();
				});
			});
			if(!$('#UploadModal').length) imgku();//图片库
		}
	}
	//选中图片事件
	$(document).on('click','#upimglist li:not(.folder)',function(){
		if(!$("form .ftype_upload input[name='"+$("#UploadModal").data("inputname")+"']").data('upload-many')) $("#upimglist li").removeClass('checked');
		$(this).toggleClass('checked');
	});
	//确定选中图片事件
	$(document).on('click','#UploadModal button[type="submit"]',function(){
		var x = $("#upimglist li div.check:visible"),l = x.length;
		if(l){
			var dom = $("form .ftype_upload input[name='"+$("#UploadModal").data("inputname")+"']");
			if(!dom.data('upload-many')){
				if(dom.next().find('li.sort').length)dom.next().find('li.sort').remove();
			}
			x.each(function(i){
				imgadd(dom,$(this).data('path'),$(this).data('value'));
			});
			imgvalue(dom);
			$('#UploadModal').modal('hide');
		}else{
			alert(METLANG.upload_pselectimg_v6);
		}
	});
	// 打开图片文件夹
	$(document).on('dblclick','#upimglist li.folder',function(){
		var name=$('.widget-image-meta',this).data('name');
		imglistloadFun(imgku_path[name],name);
	});
	// 返回图片根目录
	$(document).on('click','#UploadModal .imglist-back',function(){
		var back_folder=$('#UploadModal .upimglist-location').html();
		back_folder=back_folder.substring(7,back_folder.lastIndexOf('/'));
		back_folder=back_folder.substring(0,back_folder.lastIndexOf('/'));
		imglistloadFun(back_folder?imgku_path[back_folder]:imgku_path,back_folder);
	})
	//点击图片库按钮
	$(document).on('click','.ftype_upload .app-image-list li.imgku button',function(){
		if($("#UploadModal").data("ini")){
			if($("#UploadModal").data("reload")){
				imglistload();
				$("#UploadModal").data("reload",0);
			}else{
				$("#UploadModal").data("inputname",$(this).data('name'));
				$("#upimglist li").removeClass('checked');
			}
		}else{
			imglistload();//获取图片列表、分页
			imgupload();//上传组件加载
			$("#UploadModal").data("ini",'1').data("inputname",$(this).data('name'));
		}
	});
	//删除按钮
	$(document).on('click','.ftype_upload .app-image-list li.sort .close',function(){
		var dom = $(this).parents('.picture-list').parent().find('input[data-upload-type="doupimg"]');
		$(this).parents('li.sort').remove();
		imgvalue(dom);
	});
	// 添加外部图片链接
	$(document).on('shown.bs.popover', '.ftype_upload .add-outside-btn', function(event) {
		var $outside_img=$(this).parents('.ftype_upload').find('.outside-box input[name=outside_img]');
		$outside_img.val($(this).attr('data-outside_img'));
	})
	$(document).on('click', '.ftype_upload .outside-box .outside-ok', function(event) {
		var $input_upload=$(this).parents('.ftype_upload').find('input[data-upload-type]'),
			$outside_img=$(this).parents('.outside-box').find('input[name=outside_img]'),
			$sort_img=$(this).parents('.ftype_upload').find('.js-picture-list .sort:eq(0) img');
		if(typeof ($input_upload.attr('data-oldimg'))=="undefined") $input_upload.attr({'data-oldimg':$input_upload.val()});// 暂存原图路径
		if($outside_img.val()){
			if(!$input_upload.attr('data-upload-many')) $(this).parents('.ftype_upload').find('.js-picture-list .sort').remove();
			imgadd($input_upload,$outside_img.val());
			imgvalue($input_upload);
		}
		$(this).parents('.ftype_upload').find('.add-outside-btn').attr({'data-outside_img':$outside_img.val()});// 暂存外部图片路径
	});
	$(document).on('click', '.ftype_upload .outside-box .btn', function(event) {
		$(this).parents('.ftype_upload').find('.add-outside-btn').popover('hide');
	});
});
