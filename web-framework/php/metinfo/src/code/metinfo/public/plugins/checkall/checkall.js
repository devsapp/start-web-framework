/**
 * checkAll 全选，反选
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 * @param  {[obj]} checkBtn   [全选obj]
 * @param  {[obj]} sub        [子复选框obj]
 * @param  {[obj]} contraryCheckBtn [取消全选obj]
 */
(function($){
	jQuery.fn.checkAll=function(checkBtn,sub,contraryCheckBtn){
		var $self=$(this),
			match=function(){
		    	//把主复选框和子复选框的状态进行匹配
	            //1、遍历所有的子复选框
	            var isChecked = true;
	            $self.find(sub).each(function () {
	                if(this.checked==false){
	                    isChecked = false;
	                }
	            })
	            //2、改变父复选框的状态
	            $self.find(checkBtn).prop("checked",isChecked);
	        };
	    //功能：点击父复选框时，需要控制子复选框的选中状态
	    //全选的功能（父控制子）
	    $(this).on('change', checkBtn, function(event) {
	    	var checked=$(this).prop("checked");
	    	setTimeout(function(){
	    		$self.find(sub).prop("checked",checked).change();
	    	},0)
	    });
	    //功能:点击子复选框时，需要联动
	    //联动（子控制父：子复选框有改变，那么父复选框也要有对应的改变）
		$(this).on('change', sub, function () {
	        match();
	    });
	    //功能：点击反选按钮时，把子复选框进行反选，同时，还需要把父子复选框进行匹配
	    $(this).on('click', contraryCheckBtn,function () {
	        //复选框反选
	        $self.find(sub).each(function () {
	            this.checked = !this.checked;
	            $(this).change();
	        })
	        // 父子进行匹配
	        match();
	    });
	};
})(jQuery);