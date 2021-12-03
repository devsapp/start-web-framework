<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$data['page_title']=$_M['word']['memberIndex9'].$data['page_title'];
$set_user_head=str_replace($_M['url']['site'], '../', $_M['user']['head']);
?>
<include file="sys_web/head"/>
<div class="page bg-pagebg1 met-member member-profile">
	<div class="container">
		<div class="page-content row">
			<include file='app/sidebar'/>
			<div class="col-lg-9">
				<div class="panel panel-default m-b-0">
					<div class='panel-body met-member-index met-member-profile'>
					  	<div class="panel-heading p-y-10 p-x-15">{$_M['word']['memberIndex9']}</div>
					  	<div class="basic">
							<div class="row">
								<div class="col-xs-5 col-sm-3">
									{$_M['word']['memberName']}
								</div>
								<div class="col-xs-7 col-sm-9">
									{$_M['user']['username']}
								</div>
							</div>
							<div class="row"">
								<div class="col-xs-5 col-sm-3">
									{$_M['word']['memberbasicType']}
								</div>
								<div class="col-xs-7 col-sm-9">
									{$_M['user']['group_name']}
								</div>
							</div>
                            <?php if($_M['config']['payment_open']==1 && $data['groupshow']){?>
							<div class="row"">
								<div class="col-xs-5 col-sm-3">
									{$_M['word']['memberbuytitle']}
								</div>
								<div class="col-xs-7 col-sm-9">
									<list data="$data['groupshow']" name="$paygroup">
                                    <a href="{$url.paygroup}&a=dopaygroup&groupid={$paygroup.groupid}" class="btn btn-danger m-r-5">{$paygroup.name}</a>
                                    </list>
								</div>
							</div>
                    <?php } ?>
							<div class="row"">
								<div class="col-xs-5 col-sm-3">
									{$_M['word']['memberbasicLoginNum']}
								</div>
								<div class="col-xs-7 col-sm-9">
									{$_M['user']['login_count']}
								</div>
							</div>
							<div class="row">
								<div class="col-xs-5 col-sm-3">
									{$_M['word']['memberbasicLastIP']}
								</div>
								<div class="col-xs-7 col-sm-9">
									{$_M['user']['login_ip']}
								</div>
							</div>
					  	</div>
					  	<div class="panel-heading m-t-20 p-y-10 p-x-15">{$_M['word']['memberMoreInfo']}</div>
					  	<div>
				  			<form method="post" enctype="multipart/form-data" action="{$_M['url']['info_save']}" class="met-form para">
								<div class="met-upfile">
									<div class="row">
										<div class="col-md-3"></div>
										<div class="col-md-6 form-group">
											<input type="file" name="head" value="{$set_user_head}" data-plugin='fileinput' data-url="{$_M['url']['site']}app/system/entrance.php?lang={$_M['lang']}&c=uploadify&m=include&a=dohead" accept='image/*' hidden/>
										</div>
									</div>
								</div>
								<?php if(count($_M['paralist'])){$_M['paraclass']->parawebtem($_M['user']['id'],10,0,$_M['user']['groupid'],$data['class1']);} ?>
								<div class="form-group m-b-0">
									<div class="row">
										<div class="col-md-3"></div>
										<div class="col-md-9">
											<button class="btn btn-primary btn-squared" type="submit">{$_M['word']['modifyinfo']}</button>
										</div>
									</div>
								</div>
							</form>
					  	</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<include file="sys_web/foot"/>