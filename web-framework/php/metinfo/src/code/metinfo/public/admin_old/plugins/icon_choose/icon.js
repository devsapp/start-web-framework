define(function (require, exports, module) {
	var $ = require('jquery');
	var common = require('common');
	require.async(pubjspath+'../fonts/web-icons/web-icons.min.css');
	// 弹出图标选择框
	$(document).on('click', '.icon-add', function(event) {
		if(!$('.icon-iframe').attr('src')) $('.icon-iframe').attr({src:$('.icon-iframe').data('src')});
		$('.icon-iframe').attr({'data-icon-obj':'.icon-add[data-name="'+$(this).attr('data-name')+'"]'});
	});
	$('.icon-iframe').load(function() {
		var $icon_iframe=$(this).contents(),
			icon_iframe_window=$(this).prop('contentWindow'),
			icon_iframe_document=icon_iframe_window.document;
		// 图标设置框-选择图标库
		$icon_iframe.find('.iconchoose .iconchoose-href').click(function(event) {
			$icon_iframe.find('.icon-list').hide();
			$icon_iframe.find('.icon-detail').attr({hidden:''});
			$icon_iframe.find('.icon-detail[data-name='+$(this).data('icon')+']').removeAttr('hidden');
			$('.icon-modal .back-iconlist').removeAttr('hidden');
		});
		// 选择图标
		$icon_iframe.find('.icon-detail .icondemo-wrap').click(function(event) {
			$icon_iframe.find('.icon-detail .icondemo-wrap').removeClass('checked');
			$(this).addClass('checked');
		})
	});
	// 返回图标列表页
	$('.icon-modal .back-iconlist').click(function(event) {
		var $icon_iframe=$('.icon-iframe').contents();
		$(this).attr({hidden:''});
		$icon_iframe.find('.icon-list').show();
		$icon_iframe.find('.icon-detail').attr({hidden:''}).find('.icondemo-wrap').removeClass('checked');
	})
	// 保存图标选择
	$(document).on('click', '.icon-modal button[type=submit]', function(event) {
		var $icon_iframe=$('.icon-iframe').contents(),
			$icon_checked=$icon_iframe.find('.icon-detail .icondemo-wrap.checked'),
			icon=$icon_checked.parents('.icon-detail').data('prev')+$icon_checked.find('.icon-title').html();
		var icon_obj=$('.icon-iframe').attr('data-icon-obj'),
			$icon_obj=$(icon_obj).hasClass('column-icon')?$(icon_obj).parents('form').find('input[name="'+$(icon_obj).data('name')+'"]'):$(icon_obj).parent().find('input[type="hidden"]');
		$icon_obj.val(icon);
		if(!$(icon_obj).hasClass('column-icon')){
			$icon_obj.val(icon).parent().find('.icon-add-view i').attr({class:icon});
			$icon_obj.parent().find('.icon-add-view,.btn-icon-del').removeClass('hide');
		}
		$('.icon-modal').modal('hide');
	})
	// 删除图标选择
	$(document).on('click', 'form .btn-icon-del', function(event) {
		$(this).parent().find('.icon-add-view,.btn-icon-del').addClass('hide');
		$(this).parent().find('input[type="hidden"]').val('');
	})
	// 图标设置框关闭时还原框内显示
	$(document).on('show.bs.modal', '.icon-modal', function(event) {
		var $icon_iframe=$('.icon-iframe').contents();
		$('.icon-modal .back-iconlist').click();
		$icon_iframe.find('.icon-detail .icondemo-wrap').removeClass('checked');
	})
});