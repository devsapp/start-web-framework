<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$data['page_title']=$_M['word']['memberReg'].$data['page_title'];
?>
<include file="sys_web/head"/>
<include file="app/style"/>
<div class="register-index met-member page p-y-50 bg-pagebg1">
	<div class="container">
		<form class="form-register met-form met-form-validation panel panel-body" method="post" action="{$_M['url']['register_save']}">
			<h1 class='m-t-0 m-b-20 font-size-24 text-xs-center'>{$_M['word']['memberReg']}</h1>
			<?php
			switch ($_M['config']['met_member_vecan']) {
				case 1:
			?>
			<include file="app/register_email"/>
			<?php
					break;
				case 3:
			?>
			<include file="app/register_phone"/>
			<?php
					break;
				default:
			?>
			<include file="app/register_ord"/>
			<?php
					break;
			}
			if(count($_M['paralist'])){
			?>
			<div class="form-group m-y-30 text-muted met-more">
				<hr />
				<span class='text-xs-center bg-white p-x-10'>{$_M['word']['memberMoreInfo']}</span>
			</div>
			<?php
			}
            $_M['paraclass']->parawebtem($_M['user']['id'],10,1,0,$data['class1'],$data['class2'],$data['class3']);
			?>
			<if value="$c['met_member_agreement']">
			<div class="form-group met-form-choice">
				<div class="row">
					<div class="col-md-3"></div>
					<div class="col-md-9">
						<div class="checkbox-custom checkbox-primary m-y-0">
			              	<input type="checkbox" name="met_member_agreement" value="1" id="met_member_agreement" required data-fv-notEmpty-message="{$_M['word']['user_agreement_tips3']}">
			              	<label for="met_member_agreement">{$_M['word']['user_agreement_tips1']}<a href="javascript:;" data-toggle="modal" data-target=".met-user-agreement-modal">《{$_M['word']['user_agreement']}》</a>{$_M['word']['user_agreement_tips2']}</label>
			        	</div>
		        	</div>
	        	</div>
			</div>
			</if>
			<button class="btn btn-lg btn-primary btn-squared btn-block" type="submit" <if value="$c['met_member_agreement']">disabled</if>>{$_M['word']['memberRegister']}</button>
			<div class="login_link m-t-10 text-xs-right"><a href="{$_M['url']['login']}">{$_M['word']['acchave']}</a></div>
		</form>
	</div>
</div>
<if value="$c['met_member_agreement']">
<div class="modal fade modal-primary met-user-agreement-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">{$_M['word']['user_agreement']}</h4>
            </div>
            <div class="modal-body font-size-16">
				{$c.met_member_agreement_content}
            </div>
            <div class="modal-footer">
            	<button type="button" class="btn btn-default" data-dismiss="modal">{$word.close}</button>
            </div>
        </div>
    </div>
</div>
</if>
<include file="sys_web/foot"/>