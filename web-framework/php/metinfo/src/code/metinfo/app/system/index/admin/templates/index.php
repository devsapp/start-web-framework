<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<if value="!$_M['form']['sidebar_reload']">
<?php
$html_class=$body_class='h-100';
$html_class.=' met-admin';
?>
<include file="pub/header"/>
<if value="!$_M['form']['noside']">
<div class="h-100 cover d-flex">
	<div class="metadmin-sidebar h-100 transition500">
		<button type="button" class="btn btn-default p-0 rounded-circle text-center position-absolute btn-adminsidebar-control"><i class="fa-angle-left h4 mb-0 position-relative" style="top:-1px;"></i></button>
		<div class="metadmin-logo d-flex align-items-center py-2 px-4" style="height: 62px;">
			<a href="#/home" title="{$word.metinfo}" class="d-block">
				<img src="{$data.met_admin_logo}" alt="{$word.metinfo}" class="img-fluid" style="max-height: 50px;">
				<img src="{$url.site}favicon.ico?{$favicon_filemtime}" alt="{$word.metinfo}" class="img-fluid" style="max-height: 50px;">
			</a>
		</div>
		<!-- <hr class="my-0"> -->
		<ul class="list-unstyled mb-0 mt-3 metadmin-sidebar-nav">
			<li class="py-3 px-4 transition500">
				<a href="#/home">{$word.backstage}</a>
				<span class="mx-1">|</span>
				<a href="{$url.site}index.php?lang={$_M['lang']}" target="_blank">{$word.homepage}</a>
				<if value="$data['privilege']['navigation'] eq 'metinfo' || strstr($data['privilege']['navigation'], '1802')">
				<span class="mx-1">|</span>
				<a href="{$url.site_admin}?lang={$_M['lang']}&n=ui_set" target="_blank">{$word.visualization}</a>
				</if>
			</li>
			<li class="transition500 position-relative">
				<a href="javascript:;" class="d-flex justify-content-between align-items-center px-4">
					<div><i class="fa-home mr-3"></i></div>
				</a>
				<ul class="sub list-unstyled text-nowrap py-2">
					<li class="transition500">
						<a href="#/home" title="{$msub.name}" class="d-block px-4"><span>{$word.backstage}</span></a>
						<a href="{$url.site}index.php?lang={$_M['lang']}" target="_blank" class="d-block px-4"><span>{$word.homepage}</span></a>
						<a href="{$url.site_admin}?lang={$_M['lang']}&n=ui_set" class="d-block px-4"><span>{$word.visualization}</span></a>
					</li>
				</ul>
			</li>
			<!-- <hr class="my-0"> -->
</if>
</if>
<if value="!$_M['form']['noside']">
			<list data="$data['adminnav']['top']" name="$m">
			<li class="transition500 position-relative">
				<a <if value="$m['url']">href="#/{$m.url}"<else/>href="javascript:;"</if> title="{$m.name}" class="d-flex justify-content-between align-items-center px-4">
					<div><i class="metinfo-admin-icon metinfo-admin-icon-{$m.icon} mr-3"></i><span>{$m.name}</span></div>
					<if value="$data['adminnav']['sub'][$m['id']]"><span class="fa fa-caret-right h6 mb-0 position-relative"></span></if>
				</a>
				<if value="$data['adminnav']['sub'][$m['id']]">
				<ul class="sub list-unstyled text-nowrap py-2">
					<list data="$data['adminnav']['sub'][$m['id']]" name="$msub">
					<if value="$msub['url']||$data['adminnav']['sub'][$msub['id']]">
					<li class="transition500 position-relative">
						<a <if value="$msub['url']">href="#/{$msub.url}"<else/>href="javascript:;"</if> title="{$msub.name}" class="d-block px-4"><i class="metinfo-admin-icon metinfo-admin-icon-{$msub.icon} mr-3"></i><span>{$msub.name}</span></a>
						<if value="$data['adminnav']['sub'][$msub['id']]">
						<ul class="sub list-unstyled text-nowrap py-2">
							<list data="$data['adminnav']['sub'][$msub['id']]" name="$msub1">
							<li class="transition500 position-relative">
								<a <if value="$msub1['url']">href="#/{$msub1.url}"<else/>href="javascript:;"</if> title="{$msub1.name}" class="d-block px-4"><if value="$msub1['icon']"><i class="metinfo-admin-icon metinfo-admin-icon-{$msub1.icon} mr-3"></i></if><span>{$msub1.name}</span></a>
							</li>
							</list>
						</ul>
						</if>
					</li>
					</if>
					</list>
				</ul>
				<else/>
				<ul class="sub nosub hide list-unstyled text-nowrap py-2">
					<li class="transition500 position-relative">
						<a href="#/{$m.url}" title="{$m.name}" class="d-block px-4"><span>{$m.name}</span></a>
					</li>
				</ul>
				</if>
			</li>
			</list>
</if>
<if value="!$_M['form']['sidebar_reload']">
<if value="!$_M['form']['noside']">
		</ul>
	</div>
</if>
	<div class="metadmin-rightcontent h-100 met-scrollbar position-relative media-body" style="background: #F0F5F7;;overflow-x: hidden;">
		<if value="!$_M['form']['noside']">
		<?php
        $lang_name = $_M['langlist']['web'][$_M['lang']]['name'];
		?>
		<header class="metadmin-head navbar bg-white px-0 py-3">
			<div class="container-fluid px-4">
				<div>
			        <div class="breadcrumb mb-0 p-0 d-none d-md-flex bg-none float-left mt-1 metadmin-breadcrumb">
			            <li class='breadcrumb-item'>{$lang_name}</li>
			        </div>
		        </div>
		        <div class="metadmin-head-right d-flex align-items-center">
					<if value="$c['met_agents_metmsg']">
					<a href="javascript:;" class="text-content mr-4" data-toggle="modal" data-target=".syspackage-modal" data-modal-url="ui_set/package" data-modal-title="授权信息" data-modal-type="centered" data-modal-footerok="0">
	                    <i class="fa-flag-o"></i>
	                    <span class="d-none d-md-inline-block">版本信息</span>
	                </a>
					</if>
                    <if value="$data['clear_cache'] eq 1">
		        	<div class="btn-group mr-4">
		                <button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown">
		                    <i class="metinfo-admin-icon metinfo-admin-icon-clear-chache"></i>
		                    <span class="d-none d-md-inline-block">{$word.clearCache}</span>
		                </button>
		                <ul class="dropdown-menu dropdown-menu-right metadmin-head-langlist">
		                	<a href="{$url.own_form}n=ui_set&c=index&a=doclear_cache" title="{$word.clearCache}" class='dropdown-item px-3 clear-cache'>{$word.system_cache}</a>
		                	<a href="{$url.own_form}n=ui_set&c=index&a=doClearThumb" title="{$word.clearThumb}" class='dropdown-item px-3 clear-cache'>{$word.modimgurls}</a>
		                </ul>
		            </div>
					</if>
                    <if value="$data['checkupdate'] eq 1">
                    <a href="javascript:;" class="text-content mr-4" data-toggle="modal" data-target=".update-modal" data-modal-size="lg" data-modal-url="update" data-modal-fullheight="1" data-modal-title="{$word.checkupdate}" data-modal-oktext="" data-modal-notext="{$word.close}">
	                    <i class="metinfo-admin-icon metinfo-admin-icon-update"></i>
	                    <span class="d-none d-md-inline-block">{$word.checkupdate}</span>
	                </a>
                    </if>
		            <if value="$data['function_complete'] eq 1">
	                <a href="javascript:;" class="text-content mr-4" data-toggle="modal" data-target=".function-ency-modal" data-modal-size="lg" data-modal-url="#pub/function_ency/?n=ui_set&c=index&a=get_auth" data-modal-refresh="one" data-modal-fullheight="1" data-modal-title="{$word.funcCollection}" data-modal-oktext="" data-modal-notext="{$word.close}">
	                    <i class="metinfo-admin-icon metinfo-admin-icon-function"></i>
	                    <span class="d-none d-md-inline-block">{$word.funcCollection}</span>
	                </a>
		            </if>
		            <if value="$c['met_agents_metmsg']">
		            <div class="btn-group mr-4">
		            	<button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown">
		                    <i class="metinfo-admin-icon metinfo-admin-icon-manual"></i>
		                    <span class="d-none d-md-inline-block">{$word.update_log}</span>
		                </button>
		                <ul class="dropdown-menu dropdown-menu-right">
		                	<a href="{$c.help_url}" target="_blank" class='dropdown-item px-3'>{$word.help_manual}</a>
		                	<a href="{$c.edu_url}" target="_blank" class='dropdown-item px-3'>{$word.extension_school}</a>
		                	<a href="{$c.kf_url}" target="_blank" class='dropdown-item px-3'>{$word.online_work_order}</a>
                            <if value="$data['environmental_test'] eq 1">
							<a href="javascript:;" class='dropdown-item px-3' data-toggle="modal" data-target=".system-check-env-modal" data-modal-size="lg" data-modal-url="system/envmt_check/?c=patch&a=docheckEnv" data-modal-fullheight="1" data-modal-title="{$word.environmental_test}" data-modal-oktext="" data-modal-notext="{$word.close}">{$word.environmental_test}</a>
							<if value="$c['met_agents_metmsg']">
							<a href="javascript:;" class='dropdown-item px-3' data-toggle="modal" data-target=".syslicense-modal" data-modal-url="ui_set/license/?c=index&a=get_plugins_license" data-modal-title="许可协议">许可协议</a>
							</if>
							</if>
		                </ul>
		            </div>
		            </if>
		            <div class="btn-group mr-4">
		                <button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown">
		                    <i class="metinfo-admin-icon metinfo-admin-icon-multilingualism"></i>
		                    <span class="d-none d-md-inline-block">{$lang_name}</span>
		                </button>
		                <ul class="dropdown-menu dropdown-menu-right metadmin-head-langlist">
		                	<list data="$_M['user']['langok']" name="$v">
		                        <a href="javascript:;" data-val='{$v.mark}' class='dropdown-item px-3'>{$v.name}</a>
		                    </list>
	                        <li class="px-3 py-1"><a href="#/language" class="btn btn-primary btn-add-lang"><i class="fa fa-plus"></i> {$word.added}{$word.langweb}</a></li>
		                </ul>
		            </div>
		            <div class="btn-group">
		                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
		                	<i class="metinfo-admin-icon metinfo-admin-icon-administrator"></i>
		                	<span>{$_M['user']['admin_name']}</span>
		                </button>
		                <ul class="dropdown-menu dropdown-menu-right">
		                    <a href="#/admin/user" class="dropdown-item px-3">{$word.modify_information}</a>
		                    <a href="{$url.adminurl}n=login&c=login&a=dologinout" class="dropdown-item px-3">{$word.indexloginout}</a>
		                </ul>
		            </div>
			    </div>
		    </div>
		</header>
		</if>
		<div class="metadmin-main px-4 mt-4 mb-3">
		</div>
		<div class="metadmin-loader"><div class="text-center d-flex align-items-center h-100"><div class="loader loader-round-circle"></div></div></div>
		<footer class="metadmin-foot px-4 my-3 text-grey">{$data.copyright}</footer>
		<button type="button" class="btn btn-primary px-2 met-scroll-top position-fixed" hidden><i class="icon wb-chevron-up" aria-hidden="true"></i></button>
	</div>
<if value="!$_M['form']['noside']">
</div>
<button type="button" data-toggle="modal" class="btn-admin-common-modal" hidden></button>
</if>
<include file="pub/footer"/>
</if>