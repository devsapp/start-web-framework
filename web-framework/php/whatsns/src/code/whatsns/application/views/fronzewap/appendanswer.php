<!--{template header}-->


<div class="container  mar-t-1 mar-b-1">
<div class="row">
  <div class="col-sm-24">

    <form  class="form-horizontal mar-t-05"  name="answerform"  action="{url answer/append}" method="post" onsubmit="return check_form();" >
            <div class="askbox">
               
                
                 <div class="form-group">
         
          <p class="col-md-24 form-title">
           <!--{if $answer['authorid'] == $user['uid']}-->继续回答
  <!--{else}-->继续追问
  <!--{/if}-->
          </p>
          <div class="col-md-16">
            <div id="introContent">
                        <!--{template editor}-->
                    </div>
          </div>
        </div>
            
                  <!--{if $user['grouptype']!=1&&$setting['code_ask']&&$user['credit1']<$setting['jingyan']}-->
        
                      
     <!--{template code}-->
       
          <!--{/if}-->
          
         <div class="form-group">
         <div class="ui-btn-wrap">
           <input type="hidden" value="{$qid}" name="qid"/>
                    <input type="hidden" value="{$aid}" name="aid"/>
             <button type="submit" id="submit" name="submit" class="ui-btn ui-btn-primary" data-loading="稍候...">保存</button>
          <a class="ui-btn" onclick="window.history.go(-1)">返回</a>
          </div>
        </div>
            </div>	
        </form>
  </div>
  
   <div class="col-sm-4">
   <!--广告位5-->
        <!--{if (isset($adlist['question_view']['right1']) && trim($adlist['question_view']['right1']))}-->
        <div>{$adlist['question_view']['right1']}</div>
        <!--{/if}-->
  </div>
</div>
</div>

<script type="text/javascript">
    function check_form() {
   	 var eidtor_content='';
 	if(isueditor==1){
 		  eidtor_content = editor.getContent();
 	}else{
 		eidtor_content = editor.wang_txt.html();
 	}
 	
        if (bytes(eidtor_content) <= 5) {
            alert('内容不能少于5个字！');
            return false;
        }
        return true;
    }
</script>
<!--{template footer}-->