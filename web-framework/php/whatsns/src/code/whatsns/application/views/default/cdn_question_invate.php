{if $user['uid']>0&&$question['status']!=9&&$question['status']!=0}
						
						<script type="text/javascript">
						  g_uid=$user['uid'];
 loadinneruserbyanswerincid("{$qid}");
 function loadinneruserbyanswerincid(_qid){
	  	var _url=g_site_url+"index.php?question/loadinavterbyanswerincid.html";
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

								<div class="box_m_invatelist"></div>
								<p class="invateload-more" onclick="invateuseranswer($qid)">加载更多答主</p>
							</div>
						</div>
						{/if}