define(function(require, exports, module) {
	
	var $ = jQuery = require('jquery');
	
	exports.malert = function(tips){
		if(!$('#alertModal').length){
			var txt = '<div class="modal fade bs-example-modal-sm" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">';
				txt += '<div class="modal-dialog modal-sm">';
				txt += '<div class="modal-content">';
				txt += '<div class="modal-header">';
				txt += '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
				txt += '<h4 class="modal-title" id="myModalLabel">提示信息</h4>';
				txt += '</div>';
				txt += '<div class="modal-body">';
				txt += '</div>';
				txt += '</div>';
				txt += '</div>';
				txt += '</div>';
			$("body").append(txt);
		}
		$("#alertModal .modal-body").html(tips);
		$('#alertModal').modal('show');
	}
	
});