 <div class="form-group">
    <div class="col-sm-12">
      <div class="radio">
        <label>
          <input type="radio" {if !$topic} checked {/if} value="1"  name="answerauthor"> 当前登录人
        </label>
      </div>
      <div class="radio" style="margin-left:10px;"> 
        <label>
          <input type="radio" value="2" name="answerauthor"> 专家回答
        </label>
      </div>
      <div class="radio" style="margin-left:10px;">
        <label>
          <input type="radio" value="3" name="answerauthor">马甲回答
        </label>
      </div>
        <div class="radio" style="margin-left:10px;">
        <label>
          <input type="radio" value="4" name="answerauthor">其它用户回答
        </label>
      </div>
      
    </div>
  </div>
  <!-- 如果是专家回答 -->
  <div class="answerbyexpert" style="display:none;">
   <h5>选择专家:</h5><hr>
     <div class="form-group">

    <div class="col-sm-3">
      <select class="form-control" id="expertusername">
      	{eval $expertlist=$this->getlistbysql("select uid,username,expert from ".$this->db->dbprefix."user where expert=1 limit 0,100");}
					 					
					{loop $expertlist $expert}
				   <option value="{$expert['uid']}">{$expert['username']}</option>
				    {/loop}
				   
      </select>
    </div>

  </div>
  </div>
    <!-- 如果是马甲回答 -->
  <div class="answerbymajia" style="display:none;">
   <h5>选择马甲:</h5><hr>
     <div class="form-group">

    <div class="col-sm-3">
      <select class="form-control" id="majiausername">
       	{eval $majialist=$this->getlistbysql("select uid,username,expert from ".$this->db->dbprefix."user where fromsite=1 limit 0,100");}
					 					
					{loop $majialist $majia}
					{if !empty($majia['username'])}
				   <option value="{$majia['uid']}">{$majia['username']}</option>
				   {/if}
				    {/loop}
      </select>
    </div>

  </div>
  </div>
    <div class="form-group" id="otherauthor" style="display:none;">
    <label for="exampleInputAccount4" class="col-sm-1" style="width:11%">用户名</label>
    <div class="col-md-6 col-sm-10">
      <input type="text" class="form-control" id="answerusername" placeholder="填写社区用户账号名">
    </div>
  </div> 
  <script>
  var slid=1;
  {if $topic}
  var currentansweruid="{$topic['author']}";
  {else}
  var currentansweruid="{$user['username']}";
  {/if}
  $("input:radio[name=answerauthor]").change( function (){
		slid=$(this).val();
		switch(slid){
		case "1":
			currentansweruid={$user['username']};
			$(".answerbyexpert").hide();
			$(".answerbymajia").hide();
			$("#otherauthor").hide();
			break;
			
		case "2":
			currentansweruid=$("#expertusername").text();
			$(".answerbyexpert").show();
			$(".answerbymajia").hide();
			$("#otherauthor").hide();
			break;
		case "3":
			currentansweruid=$("#majiausername").text();
			$(".answerbymajia").show();
			$("#otherauthor").hide();
			$(".answerbyexpert").hide();
			break;
		case "4":
			currentansweruid=$.trim($("#answerusername").val());
			$(".answerbymajia").hide();
			$(".answerbyexpert").hide();
			$("#otherauthor").show();
			break;
		}
		})
  </script>