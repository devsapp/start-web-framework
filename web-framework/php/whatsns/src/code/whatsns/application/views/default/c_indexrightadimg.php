         <a href="{url expert/default}" class="banner-download blk">
                        <img src="{SITE_URL}static/css/widescreen/css/index/img/zjrz.png" alt="">
                    </a>
                    <div class="banner-buys">
                        <p class="tit1 fff text-center">{$setting['site_name']}</p>
                        <p class="tit2 fff medium text-center mar-t-10">提供最权威的解答</p>
                        <div class="total-tit tc color-666">总咨询问题</div>
                        <div class="total-money tc">{eval echo  returnarraynum ( $this->db->query ( getwheresql ( 'question',"status!=0", $this->db->dbprefix ) )->row_array () ) ;}个</div>
                        <a href="{url question/add}" class="blk send-btn tc active-bg fff">我要立即发布问题</a>
                        <a href="{url user/addxinzhi}" class="blk publish-article tc bg-fff active-color">我要发布文章</a>
                        <ul class="banner-r-list small tc">
                            <li class="fl">极速回答</li>
                            <li class="fl">行家认证</li>
                            <li class="fl">专业解答</li>
                            <li class="fl">官方保证</li>
                        </ul>  
                    </div>