<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$data['mod_num']=array(1,2,3,4,5,6,7,8,10,11,12);
if(!$data['handle']) die;
?>
<div class="function-ency-list text-center">
    <p class="text-danger text-left">{$word.function_ency1}</p>
    <div class="row mx-0 mb-3">
        <div class="list-group-item px-2 col-12 text-left bg-light">{$word.websiteSet}</div>
        <if value="$data['handle']['content']">
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/manage" target="_blank" class="d-block">{$word.indexcontent}</a>
        </div>
        </if>
        <if value="$data['handle']['column']">
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/column" target="_blank" class="d-block">{$word.columumanage}</a>
        </div>
        </if>
        <if value="$data['handle']['basic_info']">
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/webset" target="_blank" class="d-block">{$word.basicInfoSet}</a>
        </div>
        </if>
        <if value="$data['handle']['language']">
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/language" target="_blank" class="d-block">{$word.multilingual}</a>
        </div>
        </if>
        <if value="$data['handle']['basic_info']">
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/webset/?head_tab_active=1" target="_blank" class="d-block">{$word.mailSetting}</a>
        </div>
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/webset/?head_tab_active=2" target="_blank" class="d-block">{$word.thirdCode}</a>
        </div>
        </if>
        <if value="$data['handle']['watermark_thumbnail']">
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/imgmanage" target="_blank" class="d-block">{$word.watermarkThumbnail}</a>
        </div>
        </if>
        <if value="$data['handle']['online']">
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/online" target="_blank" class="d-block">{$word.customers}</a>
        </div>
        </if>
        <if value="$data['handle']['banner']">
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/banner" target="_blank" class="d-block">{$word.indexflash}</a>
        </div>
        </if>
        <if value="$data['handle']['content']">
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/recycle" target="_blank" class="d-block">{$word.recycleBin}</a>
        </div>
        </if>
        <if value="$data['handle']['mobile_menu']">
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/menu" target="_blank" class="d-block">{$word.the_menu}</a>
        </div>
        </if>
    </div>
    <div class="row mx-0 mb-3">
        <div class="list-group-item px-2 col-12 text-left bg-light">{$word.securityTools}</div>
        <if value="$data['handle']['checkupdate']">
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/update" target="_blank" class="d-block">{$word.checkupdate}</a>
        </div>
        </if>
        <if value="$data['handle']['safe']">
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/safe" target="_blank" class="d-block">{$word.safety_efficiency}</a>
        </div>
        </if>
        <if value="$data['handle']['databack']">
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/databack/?head_tab_active=0" target="_blank" class="d-block">{$word.data_processing}</a>
        </div>
        </if>
        <if value="$data['handle']['clear_cache']">
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.own_form}n=ui_set&c=index&a=doclear_cache" title="{$word.clearCache}" class="d-block clear-cache">{$word.clearCache}</a>
        </div>
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.own_form}n=ui_set&c=index&a=doClearThumb" title="{$word.clearThumb}" class="d-block clear-cache">{$word.clearThumb}</a>
        </div>
        </if>
        <if value="$data['handle']['environmental_test']">
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="javascript:;" class="d-block" data-toggle="modal" data-target=".system-check-env-modal" data-modal-size="lg" data-modal-url="system/envmt_check/?c=patch&a=docheckEnv" data-modal-fullheight="1" data-modal-title="{$word.environmental_test}" data-modal-oktext="" data-modal-notext="{$word.close}">{$word.environmental_test}</a>
        </div>
        </if>
        <if value="$data['handle']['safe']">
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/safe/?head_tab_active=1" target="_blank" class="d-block">{$word.database_switch}</a>
        </div>
        </if>
        <if value="$data['handle']['safe']">
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/safe/?head_tab_active=2" target="_blank" class="d-block">{$word.operation_log}</a>
        </div>
        </if>
    </div>
    <if value="$data['handle']['seo']">
    <div class="row mx-0 mb-3">
        <div class="list-group-item px-2 col-12 text-left bg-light">{$word.searchEngineOptimization}</div>
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/seo" target="_blank" class="d-block">{$word.seoSetting}</a>
        </div>
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/seo/?head_tab_active=1" target="_blank" class="d-block">{$word.pseudostatic}</a>
        </div>
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/seo/?head_tab_active=2" target="_blank" class="d-block">{$word.indexhtmset}</a>
        </div>
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/seo/?head_tab_active=3" target="_blank" class="d-block">{$word.anchor_text}</a>
        </div>
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/seo/?head_tab_active=4" target="_blank" class="d-block">{$word.htmsitemap}</a>
        </div>
        <if value="$data['handle']['link']">
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/seo/?head_tab_active=5" target="_blank" class="d-block">{$word.indexlink}</a>
        </div>
        </if>
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/seo/?head_tab_active=6" target="_blank" class="d-block">{$word.tag}</a>
        </div>
    </div>
    </if>
    <if value="$data['handle']['user']">
    <div class="row mx-0 mb-3">
        <div class="list-group-item px-2 col-12 text-left bg-light">{$word.indexuser}</div>
        <if value="$data['handle']['web_user']">
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/user" target="_blank" class="d-block">{$word.memberist}</a>
        </div>
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/user/?head_tab_active=1" target="_blank" class="d-block">{$word.membergroup}</a>
        </div>
         <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/user/?head_tab_active=2" target="_blank" class="d-block">{$word.memberattribute}</a>
        </div>
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/user/?head_tab_active=3" target="_blank" class="d-block">{$word.memberfunc}</a>
        </div>
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/user/?head_tab_active=4" target="_blank" class="d-block">{$word.thirdPartyLogin}</a>
        </div>
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/user/?head_tab_active=5" target="_blank" class="d-block">{$word.mailcontentsetting}</a>
        </div>
        </if>
        <if value="$data['handle']['admin_user']">
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/admin/user" target="_blank" class="d-block">{$word.metadmin}</a>
        </div>
        </if>
    </div>
    </if>
    <if value="$data['handle']['column']">
    <div class="row mx-0 mb-3">
        <div class="list-group-item px-2 col-12 text-left bg-light">{$word.systemModule}<span class="text-danger ml-2">{$word.function_ency2}</span></div>
        <list data="$data['mod_num']" name="$v">
        <?php $mod_name=$word['mod'.$v]; ?>
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/column" target="_blank" class="d-block">{$mod_name}</a>
        </div>
        </list>
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/column" target="_blank" class="d-block">{$word.modout}</a>
        </div>
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/column" target="_blank" class="d-block">{$word.tag}</a>
        </div>
    </div>
    </if>
    <div class="row mx-0 mb-3">
        <div class="list-group-item px-2 col-12 text-left bg-light">{$word.appAndPlugin}</div>
        <if value="$data['handle']['myapp']">
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/myapp" target="_blank" class="d-block">{$word.myapp}</a>
        </div>
        </if>
        <if value="$data['handle']['site_template']">
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/app/met_template" target="_blank" class="d-block">{$word.appearance}</a>
        </div>
        </if>
        <if value="$data['handle']['met_agents_sms']">
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/app/met_sms" target="_blank" class="d-block">{$word.sms_function}</a>
        </div>
        </if>
    </div>
    <if value="$data['handle']['partner']">
    <div class="row mx-0">
        <div class="list-group-item px-2 col-12 text-left bg-light">{$word.cooperation_platform}</div>
        <div class="list-group-item px-2 col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{$url.site_admin}#/partner" target="_blank" class="d-block">{$word.cooperation_platform}</a>
        </div>
    </div>
    </if>
</div>