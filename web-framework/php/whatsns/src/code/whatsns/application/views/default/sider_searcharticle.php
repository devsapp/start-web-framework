       <div class="input-group inputarticle">
                            <input type="text" class="form-control" placeholder="搜索该专栏的文章" id="txtarticle" name="txtarticle">
                            <span class="input-group-btn">
                                <button class="btn btn-default" id="btnsearcharticle" type="button">搜索</button>
                            </span>
                        </div>
                        <script>
$("#btnsearcharticle").click(function(){
	var txtart=$.trim($("#txtarticle").val());
	if(txtart!=''){
      document.location.href="{url topic/search}?word="+txtart;
	}else{
		alert("请输入关键词");
	}
});
                        </script>