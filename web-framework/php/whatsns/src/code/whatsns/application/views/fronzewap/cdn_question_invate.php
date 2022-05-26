 {if $user['uid']>0&&$question['status']!=9&&$question['status']!=0}
      	{if $cananswerthisquestion==true}
      <script type="text/javascript">
      $(function(){
    
    	  loadinneruserbyanswerincid("{$qid}");
      });

 function loadinneruserbyanswerincid(_qid){
	  	var _url="{url question/loadinavterbyanswerincid}";
	  	data={qid:_qid}
	  	function success(result){
		 

		  
	  		$(".box_m_invatelist").html("");
	  		if(result.code==20000){
	  			 $("#dialog_invate .m_invateinfo span.m_i_view").attr("data-content",result.invateuserlist);
	  		
	  			   $(".m_i_persionnum").html(result.invatenum);
	                 $(".box_m_invatelist").html(result.message);
	                
	                 $(".m_invate_user").click(function(){
	              	   var _backnum=$(this).attr("data-back");
	              	   if(_backnum&&_backnum==1){
	              		   cancelinvateuser($(this),$(this).attr("data-qid"),$(this).attr("data-uid"),false);
	              	   }else{
	              		   invateuseranswerhome($(this),$(this).attr("data-qid"),$(this).attr("data-cid"),$(this).attr("data-uid"))
	              	   }
	              	 
	                 })
	  		}else{
	  		  
		  		$(".noanswers").hide();
	  			
	  		}
	  		  
	  		
	  	}
	  	ajaxpost(_url,data,success);
	  }
 </script>
    <div class="noanswers bb hanswer">
    <div class="maters">
        <p class="tit">您可以邀请下面用户，快速获得回答</p>
            <div  class="ui-searchbar-wrap ui-border-b">

   
        <div class="ui-form-item ui-form-item-pure ui-border-b">
            <input type="text"  data-qid="{$question['id']}" type="text" id="m_i_searchusertxt" placeholder="搜索你想邀请的人">
          
        </div>
   
</div>
        <div class="box_m_invatelist"></div>
        
            </div>
    </div>
    {/if}
      {/if}