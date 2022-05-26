<?php defined('IN_MET') or exit('No permission'); ?>
<include file="head.php" page="tags"/>
<section class="met-tags-body p-y-30" m-id="noset">
    <div class="container">
        <div class="bg-white p-20 met-tags-wrapper">
            <ul class="list-unstyled m-b-0 met-tags-list">
                <include file='ui_ajax/tags'/>
            </ul>
        </div>
    </div>
</section>
<include file="foot.php" />