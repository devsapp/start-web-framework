<?php defined('IN_MET') or exit('No permission'); ?>
<include file="head.php" />
<section class="met-search animsition">
    <div class="container">
        <div class="row">
            <div class="met-search-body">
                <tag action="search.advanced"></tag>
                <ul class="list-group list-group-full list-group-dividered met-pager-ajax">
                    <include file='ajax/search'/>
                </ul>
            </div>
            <div class='m-t-20 text-xs-center hidden-sm-down' m-type="nosysdata">
                <pager />
            </div>
            <div class="met-pager-ajax-link hidden-md-up" m-type="nosysdata" data-plugin="appear" data-animate="slide-bottom" data-repeat="false">
                <button type="button" class="btn btn-primary btn-block btn-squared ladda-button" id="met-pager-btn" data-plugin="ladda" data-style="slide-left" data-url="" data-page="1">
                    <i class="icon wb-chevron-down m-r-5" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</section>
<include file="foot.php" />