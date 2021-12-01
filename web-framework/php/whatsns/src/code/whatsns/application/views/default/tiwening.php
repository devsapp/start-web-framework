<!--正在提问-->

<div class="tiwening mar-t-05">

    <div class="right_box_title clearfix">
        <strong>正在提问</strong>


        <a class="pull-right mar-ly-05"  href="{url category/view/all/1}">
            更多
        </a>
    </div>

    <hr>

    <div class="askusers">


        <ul class="right_box_list_lun clear">
          <!--{eval $nosolvelist=$this->fromcache('nosolvelist');}-->
                <!--{loop $nosolvelist $index $question_left}-->
            <li class="clear " style="height: 144.076px; opacity: 0.923561; overflow: hidden;">
                <div class="left">
                    <span>{$question_left['format_time']}</span>
                    <b></b>
                </div>
                <div class="right">
                    <div class="right_top clear">
                        <img width="50" height="50" class="img-rounded"  alt="{$question_left['author']}"
                             src="{$question_left['avatar']}"
                             onmouseover="pop_user_on(this, '1273554', 'img');" onmouseout="pop_user_out();">

                        <div>
                            <span>{$question_left['author']}</span>
                        </div>
                    </div>
                    <div class="right_bottom">
                        <strong class="otw clear"><i>Q:</i><a title="{$question_left['title']}" target="_blank"
                                                              href="{url question/view/$question_left['id']}">{$question_left['title']}</a></strong>

                        <div class="clear">
                           

                            <p>{$question_left['description']}</p>
                        </div>
                    </div>
                </div>
            </li>
              <!--{/loop}-->
          

        </ul>

    </div>

</div>

<!--正在提问结束标记-->