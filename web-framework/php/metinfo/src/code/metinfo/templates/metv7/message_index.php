<?php defined('IN_MET') or exit('No permission'); ?>
<include file="head.php" />
<section class="met-message animsition">
    <div class="container">
        <div class="row">
            <tag action='message.list' num="$c['met_message_list']"></tag>
            <if value='$sub'>
            <div class="col-lg-8 col-md-8 met-message-body panel panel-body m-b-0" boxmh-mh m-id='noset' m-type='message_list'>
                <ul class="list-group list-group-dividered list-group-full met-pager-ajax met-message-list">
                    <include file='ajax/message'/>
                </ul>
                <div class='m-t-20 text-xs-center hidden-sm-down' m-type="nosysdata">
                    <pager/>
                </div>
                <div class="met-pager-ajax-link hidden-md-up" data-plugin="appear" m-type="nosysdata" data-animate="slide-bottom" data-repeat="false">
                    <button type="button" class="btn btn-primary btn-block btn-squared ladda-button" id="met-pager-btn" data-plugin="ladda" data-style="slide-left" data-url="" data-page="1">
                        <i class="icon wb-chevron-down m-r-5" aria-hidden="true"></i>
                        {$lang.page_ajax_next}
                    </button>
                </div>
            </div>
            </if>
            <div class="<if value='$sub'>col-lg-4 col-md-4<else/>col-md-8 col-lg-6 offset-md-2 offset-lg-3 message-list-no</if>">
                <div class="row">
                    <div class="met-message-submit rightsidebar panel panel-body m-b-0" m-id="message_form" m-type='message_form' boxmh-h>
                        <tag action='message.form'></tag>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<include file="foot.php" />