       <div class="input-group inputarticle">
                            <input type="text" class="form-control" placeholder="搜一搜发现答案" id="txtarticle" name="txtarticle">
                            <span class="input-group-btn">
                                <button class="btn btn-default" id="btnsearcharticle" type="button">搜索</button>
                            </span>
                        </div>
                        <script>
$("#btnsearcharticle").click(function(){
	var txtart=$.trim($("#txtarticle").val());
	if(txtart!=''){
      document.location.href="{url question/search}?word="+txtart;
	}else{
		alert("请输入关键词");
	}
});
                        </script>