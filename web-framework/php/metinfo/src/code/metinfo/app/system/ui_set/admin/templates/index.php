<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$html_class=$body_class='h-100';
$html_class.=' met-pageset';
$body_class.=' d-flex flex-column';
$pageset_css_filemtime = filemtime(PATH_OWN_FILE.'templates/css/pageset.css');
$pageset_js_filemtime = filemtime(PATH_OWN_FILE.'templates/js/pageset.js');
$met_title=$word['veditor'].'-'.$c['met_webname'];
$headnav_ml=$_M['langset']=='cn'?'ml-xl-3':'en-headnav-padiing';
// $c['met_uiset_guide']=1;
?>
<include file="pub/header"/>
<link rel="stylesheet" href="{$url.public_fonts}metinfo-specail-icon/metinfo-specail-icon.css">
<link rel="stylesheet" href="{$url.own_tem}css/pageset.css?{$pageset_css_filemtime}">
<!-- 顶部导航 -->
<header class='pageset-head bg-dark' style="height: 50px;">
	<div class="container-fluid h-100 position-relative">
		<if value="$c['met_agents_pageset_logo'] eq 1 || !isset($c['met_agents_pageset_logo'])">
		<div class='float-left d-none d-lg-flex align-items-center h-100'>
			<a href="{$c.met_agents_linkurl}" title='{$word.metinfo}' target='_blank' class='text-white pageset-logo'><i class="icon metinfo-specail-icon metinfo-specail-icon-logobd font-size-18"></i> <span>{$word.loginmetinfo}</span></a>
		</div>
		</if>
		<if value="is_mobile()">
		<button class="btn btn-outline-light btn-sm btn-block mt-2 btn-pageset-mobile-menu">{$word.top_menu}</button>
		</if>
		<if value="is_mobile()"><div class="pageset-mobile-menu position-absolute bg-dark py-2"></if>
		<div class="container h-100 pageset-head-nav">
			<div class="row h-100 navbar p-0">
				<div>
	            	<a href class="btn btn-outline-light border-none pageset-view" title='{$word.uisetTips4}' target='_blank'>{$word.preview}</a>
                    <if value="$data['auth']['basic_info'] eq 1">
                    <a href='javascript:;' class="btn btn-outline-light border-none {$headnav_ml} pageset-other-config" data-config-url='{$url.own_form}a=doget_page_config' data-form_action="doset_page_config" title='{$word.uisetTips5}'>{$word.uisetTips6}</a>
                    </if>
                    <if value="$data['auth']['column'] eq 1">
                    <a href='javascript:;' class="btn btn-outline-light border-none {$headnav_ml}" data-toggle="modal" data-target=".pageset-nav-modal" data-url='column' title='{$word.columumanage}'>{$word.banner_column_v6}</a>
                    </if>
                    <if value="$data['auth']['content'] eq 1">
                    <a href='javascript:;' class="btn btn-outline-light border-none {$headnav_ml}" data-toggle="modal" data-target=".pageset-nav-modal" data-url='manage' title='{$word.indexcontent}'>{$word.content}</a>
                    </if>
					<div class="btn-group {$headnav_ml}">
						<button class="btn btn-outline-light border-none dropdown-toggle" type="button" data-toggle="dropdown">{$word.skinstyle}</button>
						<ul class="dropdown-menu mt-2">
                            <if value="$data['auth']['style_settings'] eq 1">
                            <a href="javascript:;" class='dropdown-item px-3 py-2 pageset-other-config' data-config-url='{$url.own_form}a=doget_public_config' data-form_action="doset_public_config">{$word.style_settings}</a>
                            </if>
                            <if value="$data['auth']['site_template'] eq 1">
                            <a href="javascript:;" class='dropdown-item px-3 py-2 nav-tem-choose' data-toggle="modal" data-target=".pageset-nav-modal" data-url='app/met_template'>{$word.appearance}</a>
                            </if>
                            <if value="$data['auth']['watermark_thumbnail'] eq 1">
                            <a href="javascript:;" class='dropdown-item px-3 py-2' data-toggle="modal" data-target=".pageset-nav-modal" data-url='imgmanage'>{$word.watermarkThumbnail}</a>
                            </if>
                            <if value="$data['auth']['banner'] eq 1">
                            <a href="javascript:;" class='dropdown-item px-3 py-2' data-toggle="modal" data-target=".pageset-nav-modal" data-url='banner'>{$word.indexflash}</a>
                            </if>
                            <if value="$data['auth']['mobile_menu'] eq 1">
                            <a href="javascript:;" class='dropdown-item px-3 py-2' data-toggle="modal" data-target=".pageset-nav-modal" data-url='menu'>{$word.the_menu}</a>
                            </if>
						</ul>
					</div>
                    <if value="$data['auth']['seo'] eq 1">
                    <a href='javascript:;' class="btn btn-outline-light border-none {$headnav_ml}" data-toggle="modal" data-target=".pageset-nav-modal" data-url='seo'>SEO</a>
                    </if>
                    <if value="$data['auth']['language'] eq 1">
                    <a href='javascript:;' class="btn btn-outline-light border-none {$headnav_ml}" data-toggle="modal" data-target=".pageset-nav-modal" data-url='language'>{$word.multilingual}</a>
                    </if>
                    <if value="$data['auth']['myapp'] eq 1">
                    <a href="javascript:;" class='btn btn-outline-light border-none {$headnav_ml}' data-toggle="modal" data-target=".pageset-nav-modal" data-url='myapp'>{$word.myapp}</a>
                    </if>
					<div class="btn-group {$headnav_ml}">
						<button class="btn btn-outline-light border-none dropdown-toggle" type="button" data-toggle="dropdown">{$word.indexadmin}</button>
						<ul class="dropdown-menu mt-2">
                            <if value="$data['auth']['databack'] eq 1">
                            <a href="javascript:;" class='dropdown-item px-3 py-2' data-toggle="modal" data-target=".pageset-nav-modal" data-url='databack/?head_tab_active=0'>{$word.data_processing}</a>
							</if>
							<if value="$data['auth']['checkupdate'] eq 1">
							<a href="javascript:;" class='dropdown-item px-3 py-2' data-toggle="modal" data-target=".pageset-nav-modal" data-url='update'>{$word.checkupdate}</a>
							</if>
                            <if value="$data['auth']['online'] eq 1">
                            <a href="javascript:;" class='dropdown-item px-3 py-2' data-toggle="modal" data-target=".pageset-nav-modal" data-url='online'>{$word.customerService}</a>
                            </if>
                            <if value="$data['auth']['user'] eq 1">
                            <a href="javascript:;" class='dropdown-item px-3 py-2' data-toggle="modal" data-target=".pageset-nav-modal" data-url='user'>{$word.memberManage}</a>
                            </if>
                            <if value="$data['auth']['clear_cache'] eq 1">
                            <a href="{$url.own_form}n=ui_set&c=index&a=doclear_cache" class='dropdown-item px-3 py-2 clear-cache'>{$word.clearCache}</a>
	                        <a href="{$url.own_form}n=ui_set&c=index&a=doClearThumb" class='dropdown-item px-3 py-2 clear-cache'>{$word.clearThumb}</a>
                            </if>
	                        <if value="$c['met_agents_app'] && $data['auth']['myapp'] eq 1">
	                    	<list data="$data['applist']" name="$v">
							<a <if value="$v['version']">href="javascript:;" data-toggle="modal" data-target=".pageset-nav-modal" data-url='{$v.url}'<else/>href="{$v.url}" target="_blank"</if> class='dropdown-item px-3 py-2'>{$v.appname}</a>
							</list>
							</if>
						</ul>
					</div>
				</div>
				<div class="float-right">
					<div class="btn-group {$headnav_ml}">
						<button class="btn btn-outline-light border-none dropdown-toggle" type="button" data-toggle="dropdown">{$word.columnmore}</button>
						<ul class="dropdown-menu dropdown-menu-right mt-2">
                            <if value="$data['auth']['basic_info'] eq 1">
                            <a href="javascript:;" class='dropdown-item px-3 py-2' data-toggle="modal" data-target=".pageset-nav-modal" data-url='webset'>{$word.baceinfo}</a>
                            </if>
                            <if value="$data['auth']['safe'] eq 1">
                            <a href="javascript:;" class='dropdown-item px-3 py-2' data-toggle="modal" data-target=".pageset-nav-modal" data-url='safe'>{$word.safety_efficiency}</a>
                            </if>
                            <if value="$data['auth']['basic_info'] eq 1">
                            <a href="javascript:;" class='dropdown-item px-3 py-2' data-toggle="modal" data-target=".pageset-nav-modal" data-url='webset/?head_tab_active=1'>{$word.sysMailboxConfig}</a>
							<a href="javascript:;" class='dropdown-item px-3 py-2' data-toggle="modal" data-target=".pageset-nav-modal" data-url='webset/?head_tab_active=2'>{$word.third_party_code}</a>
                            </if>
                            <if value="$data['auth']['nav_setting'] eq 1 && $data['auth']['myapp'] eq 1">
                            <a href="javascript:;" class='dropdown-item px-3 py-2' data-toggle="modal" data-target=".pageset-nav-modal" data-url='ui_set/pageset_nav/?c=index&a=doapplist'>{$word.navSetting}</a>
                            </if>
                            <if value="$data['auth']['admin_user'] eq 1">
							<a href="javascript:;" class='dropdown-item px-3 py-2' data-toggle="modal" data-target=".pageset-nav-modal" data-url="admin/user">{$word.indexadminname}</a>
                            </if>
							<if value="$data['auth']['function_complete'] eq 1">
							<a href="javascript:;" class='dropdown-item px-3 py-2' data-toggle="modal" data-target="#functionEncy" data-modal-size="lg" data-modal-url="#pub/function_ency/?n=ui_set&c=index&a=get_auth" data-modal-refresh="one" data-modal-fullheight="1" data-modal-title="{$word.funcCollection}" data-modal-oktext="" data-modal-notext="{$word.close}">{$word.funcCollection}</a>
							</if>
                            <if value="$data['auth']['partner'] eq 1">
							<a href="javascript:;" class='dropdown-item px-3 py-2' data-toggle="modal" data-target=".pageset-nav-modal" data-url="partner">{$word.cooperation_platform}</a>
                            </if>
						</ul>
					</div>
					<div class="btn-group {$headnav_ml}">
						<button class="btn btn-outline-light border-none dropdown-toggle" type="button" data-toggle="dropdown">{$word.indexbbs}</button>
						<ul class="dropdown-menu dropdown-menu-right mt-2">
							<if value="$c['met_agents_metmsg']">
							<a href="{$c.help_url}" class='dropdown-item px-3 py-2' target='_blank'>{$word.help_manual}</a>
							<a href="{$c.edu_url}" class='dropdown-item px-3 py-2' target='_blank'>{$word.extension_school}</a>
							<a href="{$c.kf_url}" class='dropdown-item px-3 py-2' target='_blank'>{$word.online_work_order}</a>
							</if>
                            <if value="$data['auth']['environmental_test'] eq 1">
                            <a href="javascript:;" class='dropdown-item px-3 py-2' data-toggle="modal" data-target=".pageset-nav-modal" data-url="system/envmt_check/?c=patch&a=docheckEnv">{$word.environmental_test}</a>
							</if>
							<if value="$c['met_agents_metmsg']">
							<a href="javascript:;" class='dropdown-item px-3 py-2' data-toggle="modal" data-target=".syslicense-modal" data-modal-url="ui_set/license/?c=index&a=get_plugins_license" data-modal-title="许可协议">许可协议</a>
							</if>
							<a href="javascript:;" class='dropdown-item px-3 py-2' data-toggle="modal" data-target=".uiset-guide-modal" data-modal-title="操作引导">操作引导</a>
                        </ul>
					</div>
					</if>
					<a href='{$url.site_admin}' class="btn btn-outline-light border-none {$headnav_ml}" target='_blank'>{$word.oldBackstage}</a>
					<if value="$c['met_agents_metmsg']">
					<a href='javascript:;' class="btn btn-outline-light border-none position-relative {$headnav_ml}" data-toggle="modal" data-target=".pageset-nav-modal" data-url='system/news' title='{$word.sysMessage}'>
						<i class="fa fa-bell-o"></i>
						<span class="sys-news-count position-absolute"></span>
					</a>
					</if>
					<div class="btn-group {$headnav_ml}">
						<button type="button" class="btn btn-outline-light border-none dropdown-toggle pageset-head-user" data-toggle="dropdown"><span class='text-truncate d-inline-block position-relative' style="max-width: 100px;top: 3px;">{$data.power.admin_id}</span></button>
						<ul class="dropdown-menu dropdown-menu-right mt-2">
							<a href='javascript:;' class='dropdown-item px-3 py-2' data-toggle="modal" data-target=".pageset-nav-modal" data-url="admin/user" title='{$word.indexadminname}'>{$word.modify_information}</a>
							<a href="{$url.site_admin}?n=login&c=login&a=dologinout" class='dropdown-item px-3 py-2'>{$word.indexloginout}</a>
						</ul>
					</div>
				</div>
			</div>
			<if value="$c['met_agents_metmsg']">
			<div class='position-absolute d-flex align-items-center h-100' style="right:15px;top:0;">
				<a href="javascript:;" data-toggle="modal" data-target=".pageset-nav-modal" data-url="ui_set/package" title="授权信息"><i class="fa-flag-o mr-1"></i><span>版本信息</span></a>
			</div>
			</if>
		</div>
		<if value="is_mobile()"></div></if>
	</div>
</header>
<!-- 后台文件夹安全提示 -->
<if value="!$data['admin_folder_safe']">
<div class="text-center mb-0 bg-grey alert pageset-tips">
    <button type="button" class="close" aria-label="Close" data-dismiss="alert">
        <span aria-hidden="true">×</span>
    </button>
    <p>{$word.help2}：<span class='text-danger'>{$word.tips8_v6}！</span></p>
    <div>
        <button type='button' class="btn btn-default no-prompt" data-url="{$url.site_admin}?n=index&c=index&a=do_no_prompt" data-dismiss="alert">{$word.nohint}</button>
        <button type='button' data-url="safe" class="btn btn-primary ml-5 btn-adminfolder-change" title="{$word.safety_efficiency}" data-toggle="modal" data-target=".pageset-nav-modal" data-dismiss="alert">{$word.tochange}</button>
    </div>
</div>
</if>
<!-- 可视化窗口 -->
<iframe src="{$data.pageset_iframe_src}" class='page-iframe flex-fill' frameborder="0" width="100%"></iframe>
<button type="button" data-toggle="modal" class="btn-pageset-common-modal" hidden></button>
<button type="button" class="btn-pageset-common-page" hidden></button>
<!-- 可视化窗口中部分情况右键菜单 -->
<menu class="met-menu position-fixed m-0 pl-0 border bg-light shadow rounded">
    <li class="menu-item d-block">
        <button type="button" class="btn btn-light text-left menu-btn obj-remove">
        	<small class="d-block">
	            <i class="icon wb-eye-close mr-1"></i>
	            <span class="menu-text">{$word.uisetTips8}</span>
            </small>
        </button>
    </li>
</menu>
<!-- 引导图 -->
<if value="!is_mobile()">
<div class="modal fade met-scrollbar met-modal uiset-guide-modal p-0 mb-0 border-none rounded-0 bg-white h-100 cover" data-keyboard="false" data-backdrop="false" data-visible="{$c.met_uiset_guide}" data-url="{$url.own_form}a=dono_uisetguide">
	<div class="modal-dialog modal-xl w-100 my-0">
		<div class="modal-content border-none">
			<div class="modal-body p-0">
				<div class="uiset-guide-content position-relative">
					<img data-src="{$url.own_tem}images/guide-bg.jpg" class="img-fluid">
					<div class="uiset-guide-process position-absolute w-100 h-100">
						<div class="item position-absolute" style="left: 50%;top: 50%;transform: translate(-50%,-50%);">
							<div class="uiset-guide-box bg-white p-4">
								<button type="button" class="close" aria-label="Close" data-dismiss="modal">
									<span aria-hidden="true">×</span>
								</button>
								<div class="p-3">
									<div class="text-center">
										<img data-src="{$url.own_tem}images/guide-first.png" style="margin:-130px 0 20px;">
									</div>
									<div class="uiset-guide-body h6 mb-0">
										<p>你好 <span class="text-primary">{$data.power.admin_id}</span>：</p>
										<p>我们邀请你参与新手提示，五步上手米拓企业建站系统</p>
									</div>
									<div class="uiset-guide-footer text-center" style="margin:20px 0 -67px;">
										<button class="btn btn-primary px-5 py-3 btn-next">进入新手提示</button>
									</div>
								</div>
							</div>
						</div>
						<div class="item hide">
							<img data-src="{$url.own_tem}images/guide-logo.png" class="position-absolute" style="left:65px;top:65px;">
							<img data-src="{$url.own_tem}images/guide-arrow2.png" class="position-absolute" style="left:130px;top:100px;">
							<div class="uiset-guide-box bg-white p-4 position-absolute" style="left:300px;top:250px;">
								<button type="button" class="close" aria-label="Close" data-dismiss="modal">
									<span aria-hidden="true">×</span>
								</button>
								<div class="uiset-guide-header">
									<h5 class="d-inline-block mb-0">新手提示</h5>
								</div>
								<hr class="my-2">
								<div class="uiset-guide-body text-secondary text-nowrap">
									鼠标移至图片上，点击“编辑”图标可替换原有图片哦！
								</div>
								<div class="uiset-guide-footer text-right mt-4">
									<button class="btn btn-outline-primary btn-look-demo mr-1" data-toggle="modal" data-target=".uiset-guide-demo-modal">查看演示</button>
									<button class="btn btn-primary btn-prev mr-1">上一步</button>
									<button class="btn btn-primary btn-next">下一步(1/5)</button>
								</div>
							</div>
						</div>
						<div class="item hide">
							<img data-src="{$url.own_tem}images/guide-home.png" class="position-absolute" style="left:350px;top:50px;">
							<img data-src="{$url.own_tem}images/guide-arrow2.png" class="position-absolute" style="left:355px;top:115px;">
							<div class="uiset-guide-box bg-white p-4 position-absolute" style="left:520px;top:280px;">
								<button type="button" class="close" aria-label="Close" data-dismiss="modal">
									<span aria-hidden="true">×</span>
								</button>
								<div class="uiset-guide-header">
									<h5 class="d-inline-block mb-0">新手提示</h5>
								</div>
								<hr class="my-2">
								<div class="uiset-guide-body text-secondary text-nowrap">
								鼠标移至文字上，点击“编辑”图标可修改文字哦！
								</div>
								<div class="uiset-guide-footer text-right mt-4">
									<button class="btn btn-outline-primary btn-look-demo mr-1" data-toggle="modal" data-target=".uiset-guide-demo-modal">查看演示</button>
									<button class="btn btn-primary btn-prev mr-1">上一步</button>
									<button class="btn btn-primary btn-next">下一步(2/5)</button>
								</div>
							</div>
						</div>
						<div class="item hide">
							<img data-src="{$url.own_tem}images/guide-arrow3.png" class="position-absolute" style="left:612px;top:0;">
							<img data-src="{$url.own_tem}images/guide-arrow1.png" class="position-absolute" style="left:717px;top:20px;transform: rotate(272deg);">
							<div class="uiset-guide-box bg-white p-4 position-absolute" style="left:732px;top:130px;">
								<button type="button" class="close" aria-label="Close" data-dismiss="modal">
									<span aria-hidden="true">×</span>
								</button>
								<div class="uiset-guide-header">
									<h5 class="d-inline-block mb-0">新手提示</h5>
								</div>
								<hr class="my-2">
								<div class="uiset-guide-body text-secondary text-nowrap">
								鼠标移至顶部导航栏，点击“风格->风格设置”，可设置网站的颜色哦！
								</div>
								<div class="uiset-guide-footer text-right mt-4">
									<button class="btn btn-outline-primary btn-look-demo mr-1" data-toggle="modal" data-target=".uiset-guide-demo-modal">查看演示</button>
									<button class="btn btn-primary btn-prev mr-1">上一步</button>
									<button class="btn btn-primary btn-next">下一步(3/5)</button>
								</div>
							</div>
						</div>
						<div class="item hide">
							<button class="btn btn-primary position-absolute p-1 font-size-12" style="left:48%;top:130px;">设置</button>
							<img data-src="{$url.own_tem}images/guide-arrow1.png" class="position-absolute" style="left:45%;top:140px;">
							<div class="uiset-guide-box bg-white p-4 position-absolute" style="left:550px;top:265px;">
								<button type="button" class="close" aria-label="Close" data-dismiss="modal">
									<span aria-hidden="true">×</span>
								</button>
								<div class="uiset-guide-header">
									<h5 class="d-inline-block mb-0">新手提示</h5>
								</div>
								<hr class="my-2">
								<div class="uiset-guide-body text-secondary text-nowrap">
								鼠标移至需要修改的区块，点击“设置”按钮，可调用该网站栏目的数据哦！
								</div>
								<div class="uiset-guide-footer text-right mt-4">
									<button class="btn btn-outline-primary btn-look-demo mr-1" data-toggle="modal" data-target=".uiset-guide-demo-modal">查看演示</button>
									<button class="btn btn-primary btn-prev mr-1">上一步</button>
									<button class="btn btn-primary btn-next">下一步(4/5)</button>
								</div>
							</div>
						</div>
						<div class="item hide">
							<button class="btn btn-warning position-absolute p-1 font-size-12" style="left:48%;top:130px;">内容</button>
							<img data-src="{$url.own_tem}images/guide-arrow1.png" class="position-absolute" style="left:45%;top:140px;">
							<div class="uiset-guide-box bg-white p-4 position-absolute" style="left:550px;top:265px;">
								<button type="button" class="close" aria-label="Close" data-dismiss="modal">
									<span aria-hidden="true">×</span>
								</button>
								<div class="uiset-guide-header">
									<h5 class="d-inline-block mb-0">新手提示</h5>
								</div>
								<hr class="my-2">
								<div class="uiset-guide-body text-secondary text-nowrap">
								鼠标移至需要修改的区块，点击“内容”按钮，可发布一篇文章哦！
								</div>
								<div class="uiset-guide-footer text-right mt-4">
									<button class="btn btn-outline-primary btn-look-demo mr-1" data-toggle="modal" data-target=".uiset-guide-demo-modal">查看演示</button>
									<button class="btn btn-primary btn-prev mr-1">上一步</button>
									<button class="btn btn-primary" data-dismiss="modal">完成(5/5)</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</if>
<!-- 手机端提示 -->
<if value="is_mobile() && !$_COOKIE['pageset_mobile_tips_hide']">
<div class="pageset-mobile-tips-wrapper" hidden><span class="pageset-mobile-tips">{$word.visualization1}</span></div>
</if>
<!-- 系统许可协议 -->
<if value="!$data['license']">
<div class="modal fade show met-scrollbar met-modal alert p-0 met-agreement-modal" data-keyboard="false" data-backdrop="false" style="display: block;">
	<div class="modal-dialog modal-dialog-centered modal-xl my-0 mx-auto h-100">
		<div class="modal-content h-100">
			<div class="modal-header justify-content-center">
				<h5 class="modal-title">{$word.read_protocol}</h5>
			</div>
			<div class="modal-body p-0" style="height:calc(100% - 115px);">
				<iframe src="{$data.license_url}" frameborder="0" width="100%" height="100%" style="vertical-align: top;"></iframe>
			</div>
			<div class="modal-footer justify-content-center">
				<a href="{$url.site_admin}?n=login&c=login&a=dologinout" class="btn btn-default mr-5">{$word.disagree}</a>
				<button type="button" class="btn btn-primary" data-dismiss="alert">{$word.agree}</button>
			</div>
		</div>
	</div>
</div>
</if>
<include file="pub/footer"/>
<script src="{$url.own_tem}js/pageset.js?{$pageset_js_filemtime}"></script>