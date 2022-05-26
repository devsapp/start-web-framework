
<!--热门问题和最新问题-->
<div class="hot-new-question side-box">
    <ul id="myTab3" class="nav nav-secondary">
        <li class="active">
            <a href="#tab111" data-toggle="tab">热门问题</a>
        </li>
        <li>
            <a href="#tab222" data-toggle="tab">最新问题</a>
        </li>

    </ul>
    <hr>
    <div class="tab-content">
        <div class="tab-pane fade in active" id="tab111">
            <ul class="nav right-ul">
  <!--{eval $attentionlist=$this->fromcache('attentionlist');}-->
                    <!--{loop $attentionlist $index $question_attention}-->
                <li class="b-b-line">
                    <i class="quan"></i> <a title="{$question_attention['title']}" target="_blank"
                                            href="{url question/view/$question_attention['id']}">
                   {$question_attention['title']}<i class="icon icon-question text-success"></i> </a>
                </li>
  <!--{/loop}-->

            </ul>
        </div>
        <div class="tab-pane fade" id="tab222">
            <ul class="nav right-ul">
   <!--{eval $nosolvelist=$this->fromcache('rewardlist');}-->
                <!--{loop $nosolvelist $index $question_reward}-->
                <li class="b-b-line">
                    <i class="quan"></i> <a title="{$question_reward['title']}" target="_blank"
                                            href="{url question/view/$question_reward['id']}">
                   {$question_reward['title']}<i class="icon icon-question text-success"></i> </a>
                </li>

  <!--{/loop}-->
            </ul>
        </div>


    </div>
</div>

<!--热门问题和最新问题标记结束-->


<!--广告插入地方-->

<div class="row">
    <div class="col-sm-12">
       <!--广告位5-->
        <!--{if (isset($adlist['question_view']['right1']) && trim($adlist['question_view']['right1']))}-->
        <div>{$adlist['question_view']['right1']}</div>
        <!--{/if}-->
    </div>
</div>

<!--广告插入结束标记-->