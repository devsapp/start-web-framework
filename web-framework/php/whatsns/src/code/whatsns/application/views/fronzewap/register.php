<!--{template meta}-->
    <style>
        body{
            background: #f1f5f8;
        }
        .regpop .content,.regyinsipop .content{
        display:block;
        max-height:200px;
        overflow:scroll;
        }
        .hide{
        display:none;
        }
    </style>
    <div class="ws_header">
    <i onclick="window.history.go(-1)" class="fa fa-angle-left"></i>
    <div class="ws_h_title">用户注册</div>
<span class="ws_ab_reg" onclick="window.location.href='{url user/login}'"><i class="fa fa-user-o"></i>登录</span>
</div>
  <div class="au_login_panelform sign">
        <form class="new_user" method="post">
         <input type="hidden" id="tokenkey" name="tokenkey" value='{$_SESSION["registrtokenid"]}'/>
               {if $setting['needinvatereg']==1}
               
            <div class="input-prepend ">
                <input placeholder="填写推荐人邀请码" type="text" {if $invatecode}readonly{/if} value="{if $invatecode}$invatecode{/if}" id="frominvatecode"  name="frominvatecode" >
                <i class="fa fa-envelope"></i>
            </div>
             {/if}
            <div class="input-prepend ">
                <input placeholder="你的昵称" type="text" value="" id="username" name="user_name" onblur="check_username();">
                <i class="fa fa-user"></i>
            </div>
                   {if !$setting['register_email_on']}
            <div class="input-prepend ">
                <input placeholder="你的邮箱" type="text" value="" id="email" name="email" onblur="check_email();">
                <i class="fa fa-envelope"></i>
            </div>
               {/if}
              {if $setting['smscanuse']==1}
            <div class="input-prepend  no-radius js-normal ">

                <input placeholder="手机号" type="tel"  onblur="check_phone();" maxlength="11" id="userphone" name="userphone">
                <i class="fa fa-phone"></i>
            </div>

            <div class="input-prepend  no-radius security-up-code js-security-number ">
                <input type="text" id="seccode_verify" name="seccode_verify" placeholder="手机验证码" onblur="check_phone();">
                <i class="fa fa-get-pocket"></i>
                <a id="testbtn" onclick="gosms()" class="btn-up-resend js-send-code-button" href="javascript:;">发送验证码</a>

            </div>
             {else}
  {if !$setting['needinvatereg']}
            <div class="input-prepend  no-radius js-normal ">
                    <img src="{url user/code}" onclick="javascript:updatecode();" id="verifycode" class="hide">

                    <input autocomplete="OFF" type="text" class="form-control" id="seccode_verify" name="seccode_verify" placeholder="验证码">
              <i class="fa fa fa-get-pocket"></i>
                  </div>
                       {/if} 
                {/if}
            <div class="input-prepend ">
                <input placeholder="设置密码" type="password" id="password" name="password" autocomplete="OFF" onblur="check_passwd();" maxlength="20">
                <i class="fa fa-lock"></i>
            </div>
             {if !$setting['needinvatereg']}
            <div class="input-prepend">
                <input placeholder="确认密码" type="password" id="repassword" name="repassword" autocomplete="OFF"  onblur="check_repasswd();" maxlength="20">
                <i class="fa fa-lock"></i>
            </div>
    
            <div class="input-prepend ">
                <input placeholder="邀请码，非必填" type="text" {if $invatecode}readonly{/if} value="{if $invatecode}$invatecode{/if}" id="frominvatecode"  name="frominvatecode" >
                <i class="fa fa-envelope"></i>
            </div>
             {/if}
            <button type="button" id="regsubmit" onclick="cheklogin()" class="sign-up-button">注册</button>
            <p class="sign-up-msg">点击 “注册” 即表示您同意并愿意遵守协议<br> 
            <a  href="javascript:regshow()">用户协议</a> 和 <a href="javascript:regyinsishow()">隐私政策</a> 。</p>
        
        </form>
            <!--{if $setting['sinalogin_open']||$wxbrower||$setting['qqlogin_open']}-->
        <!-- 更多登录方式 -->
        <div class="more-sign">

            <h6>第三方登录</h6>
            <ul>
                <!--{if $setting['sinalogin_open']}-->
                <li><a class="weibo" href="{SITE_URL}plugin/sinalogin/index.php"><i class="fa fa-weibo"></i></a></li>
                <!--{/if}-->
             
                <!--{if $setting['qqlogin_open']}-->
                <li><a class="qq" href="{SITE_URL}plugin/qqlogin/index.php"><i class="fa fa-qq"></i></a></li>
                <!--{/if}-->



            </ul>

        </div>
         <!--{/if}-->
    </div>

<div class=" regpop ui-dialog " id="regpop">
    <div class="ui-dialog-cnt">
        <div class="ui-dialog-bd content">
            <h3>注册协议</h3>
            <p >当您申请用户时，表示您已经同意遵守本规章。&nbsp;</p><p>欢迎您加入本站点参加交流和讨论，本站点为公共问答，为维护网上公共秩序和社会稳定，请您自觉遵守以下条款：&nbsp;</p><p><br></p><p>一、不得利用本站危害国家安全、泄露国家秘密，不得侵犯国家社会集体的和公民的合法权益，不得利用本站制作、复制和传播下列信息：</p><p>　 （一）煽动抗拒、破坏宪法和法律、行政法规实施的；</p><p>　（二）煽动颠覆国家政权，推翻社会主义制度的；</p><p>　（三）煽动分裂国家、破坏国家统一的；</p><p>　（四）煽动民族仇恨、民族歧视，破坏民族团结的；</p><p>　（五）捏造或者歪曲事实，散布谣言，扰乱社会秩序的；</p><p>　（六）宣扬封建迷信、淫秽、色情、赌博、暴力、凶杀、恐怖、教唆犯罪的；</p><p>　（七）公然侮辱他人或者捏造事实诽谤他人的，或者进行其他恶意攻击的；</p><p>　（八）损害国家机关信誉的；</p><p>　（九）其他违反宪法和法律行政法规的；</p><p>　（十）进行商业广告行为的。</p><p><br></p><p>二、互相尊重，对自己的言论和行为负责。</p><p>三、禁止在申请用户时使用相关本站的词汇，或是带有侮辱、毁谤、造谣类的或是有其含义的各种语言进行注册用户，否则我们会将其删除。</p><p>四、禁止以任何方式对本站进行各种破坏行为。</p><p>五、如果您有违反国家相关法律法规的行为，本站概不负责，您的登录问答信息均被记录无疑，必要时，我们会向相关的国家管理部门提供此类信息。</p>
        </div>
        <div class="ui-dialog-ft">
            <button type="button" onclick="reghide()" data-role="button">知道了</button>
            
        </div>
    </div>
</div>

<div class=" regyinsipop ui-dialog " id="regyinsipop">
    <div class="ui-dialog-cnt">
        <div class="ui-dialog-bd content">
            <h3>隐私协议</h3>
           <div class="show-content hide hidequestioncontent" style="display: block;">
                  <p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;{$setting['site_name']}及相关网站（{SITE_URL}）所提供的各项服务的所有权和运作权均归本站所有。{$setting['site_name']}及相关网站用户使用协议（以下简称“本协议”）系由{$setting['site_name']}及相关网站用户与互文就{$setting['site_name']}及相关网站的各项服务所订立的相关权利义务规范。用户使用本程序及相关网站，即表示接受并同意本协议的所有条件和条款。互文作为{$setting['site_name']}及相关网站的运营者依据本协议为用户提供服务。不愿接受本协议条款的，不得访问或使用本程序及相关网站。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;互文有权对本协议条款进行修改，修改后的协议一旦公布即有效代替原来的协议。用户可随时查阅最新协议。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;《知识产权声明》为本协议不可分割的组成部分。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;用户参与{$setting['site_name']}及相关网站使用时，须遵守使用规则，不得恶意破坏泄露程序及相关网站数据。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; white-space: normal; font-size: 19.2px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;一、服务内容</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1、{$setting['site_name']}及相关网站运用自己的系统，通过互联网络等方式为用户提供自制三维模型、编辑造型等功能。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2、用户必须自行准备如下设备和承担如下开支：（1）上网设备，包括并不限于电脑或者其他上网终端、调制解调器及其他上网装置；（2）上网开支，包括并不限于网络接入费、上网设备租用费、手机流量费等。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3、用户提供的注册资料，用户同意：（1）提供合法、真实、准确、详尽的个人资料； （2）如有变动，及时更新用户资料。如果用户提供的注册资料不合法、不真实、不准确、不详尽的，用户需承担因此引起的相应责任及后果，并且互文保留终止用户使用{$setting['site_name']}及相关网站各项服务的权利。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; white-space: normal; font-size: 19.2px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;二、服务的提供、修改及终止</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1、用户在接受{$setting['site_name']}及相关网站各项服务的同时，同意接受{$setting['site_name']}及相关网站提供的各类信息服务。用户在此授权互文可以向其电子邮件、手机、通信地址等发送商业信息。</p><p><span style="font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px;">用户有权选择不接受{$setting['site_name']}及相关网站提供的各类信息服务，并进入{$setting['site_name']}及相关网站相关页面进行更改。</span></p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;"><br></p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2、{$setting['site_name']}及相关网站保留随时修改或中断服务而不需通知用户的权利。{$setting['site_name']}及相关网站有权行使修改或中断服务的权利，不需对用户或任何无直接关系的第三方负责。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3、用户对本协议的修改有异议，或对{$setting['site_name']}及相关网站的服务不满，可以行使如下权利：</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（1）停止使用的网络服务；</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（2）通过客服等渠道告知{$setting['site_name']}及相关网站停止对其服务。 结束服务后，用户使用{$setting['site_name']}及相关网站络服务的权利立即终止。在此情况下，{$setting['site_name']}及相关网站没有义务传送任何未处理的信息或未完成的服务给用户或任何无直接关系的第三方。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; white-space: normal; font-size: 19.2px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;三、用户信息的保密</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1、本协议所称之{$setting['site_name']}及相关网站用户信息是指符合法律、法规及相关规定，并符合下述范围的信息：</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（1）用户注册{$setting['site_name']}及相关网站或申请{$setting['site_name']}及相关网站会员VIP时，向{$setting['site_name']}及相关网站提供的个人信息；</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（2）用户在使用{$setting['site_name']}及相关网站服务、参加网站活动或访问网站网页时，{$setting['site_name']}及相关网站自动接收并记录的用户浏览器端或手机客户端数据，包括但不限于IP地址、网站Cookie中的资料及用户要求取用的网页记录；</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（3）{$setting['site_name']}及相关网站从商业伙伴处合法获取的用户个人信息；</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（4）其它{$setting['site_name']}及相关网站通过合法途径获取的用户个人信息。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2、{$setting['site_name']}及相关网站承诺：</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;非经法定原因或用户事先许可，{$setting['site_name']}及相关网站不会向任何第三方透露用户的密码、姓名、手机号码等非公开信息</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3、在下述法定情况下，用户的个人信息将会被部分或全部披露：</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（1）经用户同意向用户本人或其他第三方披露；</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（2）根据法律、法规等相关规定，或行政机构要求，向行政、司法机构或其他法律规定的第三方披露；</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（3）其它{$setting['site_name']}及相关网站根据法律、法规等相关规定进行的披露。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; white-space: normal; font-size: 19.2px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;四、用户权利</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1、用户的用户名、密码和安全性</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（1）用户有权选择是否成为{$setting['site_name']}及相关网站会员，用户选择成为{$setting['site_name']}及相关网站注册用户的，可自行创建、修改昵称。用户名和昵称的命名及使用应遵守相关法律法规并符合网络道德。用户名和昵称中不能含有任何侮辱、威胁、淫秽、谩骂等侵害他人合法权益的文字。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（2）用户一旦注册成功，成为{$setting['site_name']}及相关网站的会员，将得到起风号和密码，并对以此组起风号和密码登入系统后所发生的所有活动和事件负责，自行承担一切使用该起风号的言语、行为等而直接或者间接导致的法律责任。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（3）用户有义务妥善保管{$setting['site_name']}及相关网站账号、起风号和密码，用户将对起风号和密码安全负全部责任。因用户原因导致用户名或密码泄露而造成的任何法律后果由用户本人负责。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（4）用户密码遗失的，可以通过注册电子邮箱发送的链接重置密码，以手机号码注册的用户可以凭借手机号码找回原密码。用户若发现任何非法使用用户名或存在其他安全漏洞的情况，应立即告知{$setting['site_name']}及相关网站。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2、用户有权修改其个人账户中各项可修改信息，自行选择昵称和录入介绍性文字，自行决定是否提供非必填项的内容；</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3、用户有权根据网站相关规定，获得{$setting['site_name']}及相关网站给与的奖励；</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4、用户有权参加{$setting['site_name']}及相关网站组织提供的各项线上、线下活动；</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5、用户在取得{$setting['site_name']}及相关网站发放的会员卡后，有权至所在城市会员卡商户进行消费、获得折扣或积分、并根据网站相关规定进行积分兑换等。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; white-space: normal; font-size: 19.2px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;五、用户义务</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1、不得利用本站危害国家安全、泄露国家秘密，不得侵犯国家社会集体的和公民的合法权益，不得利用本站制作、复制和传播下列信息：</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（1）煽动抗拒、破坏宪法和法律、行政法规实施的；</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（2）煽动颠覆国家政权，推翻社会主义制度的；</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（3）煽动分裂国家、破坏国家统一的；</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（4）煽动民族仇恨、民族歧视，破坏民族团结的；</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（5）捏造或者歪曲事实，散布谣言，扰乱社会秩序的；</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（6）宣扬封建迷信、淫秽、色情、赌博、暴力、凶杀、恐怖、教唆犯罪的；</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（7）公然侮辱他人或者捏造事实诽谤他人的，或者进行其他恶意攻击的；</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（8）损害国家机关信誉的；</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（9）其他违反宪法和法律行政法规的；</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（10）进行商业广告行为的。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2、用户不得通过任何手段恶意注册{$setting['site_name']}及相关网站站帐号，包括但不限于以牟利、炒作、套现、获奖等为目的多个账号注册。用户亦不得盗用其他用户帐号。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;如用户违反上述规定，则{$setting['site_name']}及相关网站有权直接采取一切必要的措施，包括但不限于删除用户发布的内容、取消用户在网站获得的星级、荣誉以及虚拟财富，暂停或查封用户帐号，取消因违规所获利益，乃至通过诉讼形式追究用户法律责任等。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3、用户需维护点评的客观性，不得利用{$setting['site_name']}及相关网站用户身份进行违反诚信的任何行为，包括但不限于：炒作商户，并向商户收取费用或获取利益；为获得利益或好处，参与或组织撰写及发布虚假点评；以差评威胁，要求商户提供额外的利益或好处；进行其他其它影响点评客观、干扰扰乱网站正常秩序的违规行为等。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;如用户违反上述规定，则{$setting['site_name']}及相关网站有权采取一切必要的措施，包括但不限于：删除用户发布的内容、取消用户在网站获得的星级、荣誉以及虚拟财富，暂停或查封用户帐号，取消因违规所获利益，乃至通过诉讼形式追究用户法律责任等。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4、禁止用户将{$setting['site_name']}及相关网站以任何形式作为从事各种非法活动的场所、平台或媒介。未经{$setting['site_name']}及相关网站的授权或许可，用户不得借用本站的名义从事任何商业活动，也不得以任何形式将{$setting['site_name']}及相关网站作为从事商业活动的场所、平台或媒介。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;如用户违反上述规定，则{$setting['site_name']}及相关网站有权直接采取一切必要的措施，包括但不限于删除用户发布的内容、取消用户在网站获得的星级、荣誉以及虚拟财富，暂停或查封用户帐号，取消因违规所获利益，乃至通过诉讼形式追究用户法律责任等。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5、用户在{$setting['site_name']}及相关网站以各种形式发布的一切信息，均应符合国家法律法规等相关规定及网站相关规定，符合社会公序良俗，并不侵犯任何第三方主体的合法权益，否则用户自行承担因此产生的一切法律后果，且互文因此受到的损失，有权向用户追偿。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; white-space: normal; font-size: 19.2px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;六、知识产权及其它权利</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1、用户已经明确阅读，并明确了解本网站的《知识产权声明》。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2、任何用户接受本协议，即表明该用户主动将其在任何时间段在本程序及相关网站发表的任何形式的著作的使用权无偿授予{$setting['site_name']}及相关网站运营商。 本协议已经构成《著作权法》第二十五条所规定的书面协议，其效力及于用户在{$setting['site_name']}及相关网站发布的任何受著作权法保护的作品内容，无论该内容形成于本协议签订前还是本协议签订后。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3、互文是{$setting['site_name']}及相关网站的制作者,拥有此网站内容及资源的版权,受国家知识产权保护,享有对本网站各种协议、声明的修改权；未经互文的明确书面许可，任何第三方不得为任何非私人或商业目的获取或使用本网站的任何部分或通过本网站可直接或间接获得的任何内容、服务或资料。任何第三方违反本协议的规定以任何方式，和/或以任何文字对本网站的任何部分进行发表、复制、转载、更改、引用、链接、下载或以其他方式进行使用，或向任何其他第三方提供获取本网站任何内容的渠道，则对本网站的使用权将立即终止，且任何第三方必须按照本公司的要求，归还或销毁使用本网站任何部分的内容所创建的资料的任何副本。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4、起风啦未向任何第三方转让本网站或其中的任何内容所相关的任何权益或所有权，且一切未明确向任何第三方授予的权利均归互文所有。未经本协议明确允许而擅自使用本网站任何内容、服务或资料的，构成对本协议的违约行为，且可能触犯著作权、商标、专利和/或其他方面的法律法规，互文保留对任何违反本协议规定的第三方（包括单位或个人等）提起法律诉讼的权利。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5、本公司可按自身判断随时对本协议进行修改及更新。本协议有所改动的公告一经在程序及相关网站官网上发布即产生法律效力，并适用于改动发布后对本程序及相关网站的一切访问和使用行为。如用户在修改后的本协议发布后继续使用本程序及相关网站的，即代表用户接受并同意了这些改动。用户应定期查看官网通知或本协议，了解对用户具有约束力的本协议的任何改动。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; white-space: normal; font-size: 19.2px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;七、拒绝担保与免责</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1、{$setting['site_name']}及相关网站作为“网络服务提供者”的第三方平台，不担保网站平台上的信息及服务能充分满足用户的需求。对于用户在接受{$setting['site_name']}及相关网站的服务过程中可能遇到的错误、侮辱、诽谤、不作为、淫秽、色情或亵渎事件，{$setting['site_name']}及相关网站不承担法律责任。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2、基于互联网的特殊性，{$setting['site_name']}及相关网站也不担保服务不会受中断，对服务的及时性、安全性都不作担保，不承担非因{$setting['site_name']}及相关网站导致的责任。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$setting['site_name']}及相关网站力图使用户能对本网站进行安全访问和使用，但{$setting['site_name']}及相关网站不声明也不保证本网站或其服务器是不含病毒或其它潜在有害因素的；因此用户应使用业界公认的软件查杀任何自{$setting['site_name']}及相关网站下载文件中的病毒。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3、{$setting['site_name']}及相关网站不对用户所发布信息的保存、修改、删除或储存失败负责。对网站上的非因{$setting['site_name']}及相关网站故意所导致的排字错误、疏忽等不承担责任。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$setting['site_name']}及相关网站有权但无义务，改善或更正本网站任何部分之疏漏、错误。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4、除非{$setting['site_name']}及相关网站以书面形式明确约定，{$setting['site_name']}及相关网站对于用户以任何方式（包括但不限于包含、经由、连接或下载）从本网站所获得的任何内容信息，包括但不限于广告、商户信息、点评内容等，不保证其准确性、完整性、可靠性；对于用户因本网站上的内容信息而购买、获取的任何产品、服务、信息或资料，{$setting['site_name']}及相关网站不承担责任。用户自行承担使用本网站信息内容所导致的风险。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5、{$setting['site_name']}及相关网站内所有用户所发表的用户点评，仅代表用户个人观点，并不表示本网站赞同其观点或证实其描述，本网站不承担用户点评引发的任何法律责任。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;6、互文有权删除{$setting['site_name']}及相关网站内各类不符合法律或协议规定的点评，而保留不通知用户的权利。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;7、所有发给用户的通告，{$setting['site_name']}及相关网站都将通过正式的页面公告、站内信、电子邮件、客服电话、手机短信或常规的信件送达。任何非经{$setting['site_name']}及相关网站正规渠道获得的中奖、优惠等活动或信息，{$setting['site_name']}及相关网站不承担法律责任。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; white-space: normal; font-size: 19.2px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;八、侵权投诉</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1、据《中华人民共和国侵权责任法》第三十六条，任何第三方认为，用户利用{$setting['site_name']}及相关网站平台侵害本人民事权益或实施侵权行为的，包括但不限于侮辱、诽谤等，被侵权人有权书面通知{$setting['site_name']}及相关网站采取删除、屏蔽、断开链接等必要措施。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2、据《信息网络传播权保护条例》，任何第三方认为，{$setting['site_name']}及相关网站所涉及的作品、表演、录音录像制品，侵犯自己的信息网络传播权或者被删除、改变了自己的权利管理电子信息的，可以向{$setting['site_name']}及相关网站提交书面通知，要求{$setting['site_name']}及相关网站删除该侵权作品，或者断开链接。通知书应当包含下列内容：</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（一）权利人的姓名（名称）、联系方式和地址；</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（二）要求删除或者断开链接的侵权作品、表演、录音录像制品的名称和网络地址；</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; （三）构成侵权的初步证明材料。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;权利人应当对通知书的真实性负责。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;此外，为使{$setting['site_name']}及相关网站能及时、准确作出判断，还请侵权投诉人一并提供以下材料：</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3、任何第三方（包括但不限于企业、公司、单位或个人等）认为{$setting['site_name']}及相关网站用户发布的任何信息侵犯其合法权益的，包括但不限于以上两点，在有充分法律法规及证据足以证明的情况下，均可以通过下列联系方式通知{$setting['site_name']}及相关网站：</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;邮寄地址：黑龙江省哈尔滨市道里区群力景江东路165号</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;邮政编码：154100</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;收件人：{$setting['site_name']}及相关网站客服部</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4、侵权投诉必须包含下述信息：</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（1）被侵权人的证明材料，或被侵权作品的原始链接及其它证明材料。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（2）侵权信息或作品在{$setting['site_name']}及相关网站上的具体链接。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（3）侵权投诉人的联络方式，以便{$setting['site_name']}及相关网站相关部门能及时回复您的投诉，最好包括电子邮件地址、电话号码或手机等。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（4）投诉内容须纳入以下声明：“本人本着诚信原则，有证据认为该对象侵害本人或他人的合法权益。本人承诺投诉全部信息真实、准确，否则自愿承担一切后果。”</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（5）本人亲笔签字并注明日期，如代理他人投诉的，必须出具授权人签字的授权书。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5、{$setting['site_name']}及相关网站建议用户在提起投诉之前咨询法律顾问或律师。我们提请用户注意：如果对侵权投诉不实，则用户可能承担法律责任。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; white-space: normal; font-size: 19.2px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;九、适用法律和裁判地点</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1、因用户使用{$setting['site_name']}及相关网站站而引起或与之相关的一切争议、权利主张或其它事项，均受中华人民共和国法律的管辖。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2、用户和{$setting['site_name']}及相关网站发生争议的，应首先本着诚信原则通过协商加以解决。如果协商不成，则应向互文所在地人民法院提起诉讼。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; white-space: normal; font-size: 19.2px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;十、可分性</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;如果本协议的任何条款被视为不合法、无效或因任何原因而无法执行，则此等规定应视为可分割，不影响任何其它条款的法律效力。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; white-space: normal; font-size: 19.2px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;十一、冲突选择</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;本协议是{$setting['site_name']}及相关网站与用户注册成为{$setting['site_name']}及相关网站用户，使用{$setting['site_name']}及相关网站服务之间的重要法律文件，{$setting['site_name']}及相关网站或者用户的任何其他书面或者口头意思表示与本协议不一致的，均应当以本协议为准。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; white-space: normal; font-size: 19.2px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;十二、针对搜索引擎</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$setting['site_name']}及相关网站官网要求各搜索引擎遵循行业规范，即“拒绝 Robots 访问标准”(Robots Exclusion Standard)，否则将视你的抓取行为是对我网站财产权利和知识产权的侵犯，有权通过法律诉讼维护网站利益。{$setting['site_name']}及相关网站官网制定了详细的Robots规则，点击查阅。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; white-space: normal; font-size: 19.2px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;十三、特别提醒</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鉴于：《中华人民共和国合同法》第39条规定：采用格式条款订立合同的，提供格式条款的一方应当遵循公平原则确定当事人之间的权利和义务，并采取合理的方式提请对方注意免除或者限制其责任的条款，按照对方的要求，对该条款予以说明。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$setting['site_name']}及相关网站在此依法做出特别声明如下：{$setting['site_name']}及相关网站采取合理的方式提请用户注意的义务将通过如下方式实现：在本合同中{$setting['site_name']}及相关网站以明确的足以引起用户注意的加重字体、斜体、下划线、颜色标记等合理方式提醒用户注意相关条款（需要强调的是，还包括用户应特别注意任何未明确标记的含有“不承担”、“免责”“不得”等形式用语的条款），该等条款的确认将导致用户在特定情况下的被动、不便、损失，包括但不限于本合同第六条、第七条、第九条等，请用户在确认同意本协议之前再次阅读上述条款。双方确认上述条款非属于《中华人民共和国合同法》第40条规定的“免除其责任、加重对方责任、排除对方主要权利的”的条款，{$setting['site_name']}及相关网站尊重用户的权利尤其是诉讼的权利，但作为全球运营的公司，{$setting['site_name']}及相关网站在尊重用户诉讼权利的同时建议诉讼管辖地法院为互文所在地人民法院，而用户选择同意注册或使用{$setting['site_name']}及相关网站各项服务即视为双方对此约定达成了一致意见。</p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;, &quot;??????&quot;, arial, simsun, &quot;????&quot;; font-size: 19.2px; white-space: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鉴于{$setting['site_name']}及相关网站已依法明确了上述条款、履行了格式条款制订方的义务，用户点击立即注册或使用{$setting['site_name']}及相关网站各项服务，将被视为且应当被视为用户已经完全注意并同意了本合同所有条款尤其是提醒用户注意的条款的合法性及有效性，用户不应当以{$setting['site_name']}及相关网站未对格式条款以合理方式提醒用户注意或未根据用户要求尽到说明义务为理由而声称或要求法院或其它任何第三方确认相关条款非法或无效。</p><p><br></p>            </div>
        </div>
        <div class="ui-dialog-ft">
            <button type="button" onclick="regyinsihide()" data-role="button">知道了</button>
            
        </div>
    </div>
</div>

    <section id="scripts">






      <script type="text/javascript">
      function regshow(){

     	  var classVal = document.getElementById("regpop").getAttribute("class");
      	//添加的话
      	  classVal = classVal.concat(" show");
      	
      	  document.getElementById("regpop").setAttribute("class",classVal );

      	  
      }
      function reghide(){

    	  var classVal = document.getElementById("regpop").getAttribute("class");

    	//删除的话
    	classVal = classVal.replace("show","");
    	document.getElementById("regpop").setAttribute("class",classVal );
    	        }

      function regyinsishow(){

     	  var classVal = document.getElementById("regyinsipop").getAttribute("class");
      	//添加的话
      	  classVal = classVal.concat(" show");
      	
      	  document.getElementById("regyinsipop").setAttribute("class",classVal );

      	  
      }
      function regyinsihide(){

    	  var classVal = document.getElementById("regyinsipop").getAttribute("class");

    	//删除的话
    	classVal = classVal.replace("show","");
    	document.getElementById("regyinsipop").setAttribute("class",classVal );
    	        }
      
      setTimeout(function(){updatecode();$("#verifycode").removeClass("hide");},500);
    var usernameok = 1;
    var password = 1;
    var repasswdok = 1;
    var emailok = 1;
    var codeok = 1;
    function check_username() {
        var username = $.trim($('#username').val());
        var length = bytes(username);

        if (length < 3 || length > 15) {

        	el2=$.tips({
                content:'用户名请使用3到15个字符',
                stayTime:1000,
                type:"info"
            });


            usernameok = false;
        } else {
            $.post("{url user/ajaxusername}", {username: username}, function(flag) {
                if (-1 == flag) {


                	 el2=$.tips({
                         content:'此用户名已经存在',
                         stayTime:2000,
                         type:"info"
                     });

                    usernameok = false;
                } else if (-2 == flag) {


                	 el2=$.tips({
                         content:'用户名含有禁用字符',
                         stayTime:2000,
                         type:"info"
                     });
                    usernameok = false;
                } else {

                	 el2=$.tips({
                         content:'用户名可以使用',
                         stayTime:1000,
                         type:"success"
                     });

                    usernameok = true;
                }
            });
        }
    }

    function check_passwd() {
        var passwd = $('#password').val();
        if (bytes(passwd) < 6 || bytes(passwd) > 16) {




        	 el2=$.tips({
                 content:'密码最少6个字符，最长不得超过16个字符',
                 stayTime:2000,
                 type:"info"
             });
            password = false;
        } else {


            password = 1;
        }
    }

    function check_repasswd() {
        repasswdok = 1;
        var repassword = $('#repassword').val();
        if (bytes(repassword) < 6 || bytes(repassword) > 16) {
        	 el2=$.tips({
                 content:'密码最少6个字符，最长不得超过16个字符',
                 stayTime:2000,
                 type:"info"
             });

            repasswdok = false;
        } else {
            if ($('#password').val() == $('#repassword').val()) {


                repasswdok = true;
            } else {
            	 el2=$.tips({
                     content:'两次密码输入不一致',
                     stayTime:2000,
                     type:"info"
                 });

                repasswdok = false;
            }
        }
    }

    function check_email() {
        var email = $.trim($('#email').val());
        if (!email.match(/^[\w\.\-]+@([\w\-]+\.)+[a-z]{2,4}$/ig)) {



        	 el2=$.tips({
                 content:'邮件格式不正确',
                 stayTime:1000,
                 type:"info"
             });

            usernameok = false;
        } else {
            $.post("{url user/ajaxemail}", {email: email}, function(flag) {
                if (-1 == flag) {
                	 el2=$.tips({
                         content:'此邮件地址已经注册',
                         stayTime:1000,
                         type:"info"
                     });

                    emailok = false;
                } else if (-2 == flag) {
                	 el2=$.tips({
                         content:'邮件地址被禁止注册',
                         stayTime:1000,
                         type:"info"
                     });

                    emailok = false;
                } else {
                    emailok = true;

                	 el2=$.tips({
                         content:'邮箱名可以注册',
                         stayTime:1500,
                         type:"success"
                     });
                }
            });
        }
    }




    function cheklogin(){


        var _uname=$("#username").val();
        var _upwd=$("#password").val();
        var _rupwd=$("#repassword").val();
        var _code=$("#seccode_verify").val();
        var _email=$("#email").val();
        var _frominvatecode=$("#frominvatecode").val();
        {if $setting['needinvatereg']==1}
        if(_frominvatecode==''){
      	  $("#frominvatecode").val("")
      	  alert("邀请码不能为空");
     		 return false;
        }
      {/if}
        var _apikey=$("#tokenkey").val();
        var el='';
        {if $setting['smscanuse']==1}
        var _phone=$("#userphone").val();

      	  var _rs=check_phone(_phone);
      	if(!_rs){
      		 alert("手机号码有误");
      		 return false;
      	}
        var _data={phone:_phone,uname:_uname,upwd:_upwd,rupwd:_rupwd,email:_email,frominvatecode:_frominvatecode,apikey:_apikey,seccode_verify:_code};
        {else}
        var _data={uname:_uname,upwd:_upwd,rupwd:_rupwd,email:_email,frominvatecode:_frominvatecode,apikey:_apikey,seccode_verify:_code};
        {/if}
        $.ajax({
            //提交数据的类型 POST GET
            type:"POST",
            //提交的网址
            url:"{url api_user/registerapi}",
            //提交的数据
            data:_data,
            //返回数据的格式
            datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".
            //在请求之前调用的函数
            beforeSend:function(){
         	    el=$.loading({
         	        content:'加载中...',
         	    })
            },
            //成功返回之后调用的函数
            success:function(data){
            	 el.loading("hide");

                if(data=='reguser_ok'){





                  window.location.href="{SITE_URL}?user/default";



                }else if(data=='reguser_ok1'){
                	 el2=$.tips({
                         content:'注册成功，系统已发送注册邮件，24小时之内请进行邮箱验证，在您没激活邮件之前你不能发布问题和文章等操作！',
                         stayTime:1500,
                         type:"success"
                     });

                	   window.location.href="{SITE_URL}?user/default";
                }else{
                	switch(data){


                	case 'reguser_cant_null':

                		 el2=$.tips({
                             content:'用户名或者密码不能为空',
                             stayTime:1000,
                             type:"info"
                         });

                		break;
                	case 'regemail_Illegal':
                		 el2=$.tips({
                             content:'注册邮箱不合法',
                             stayTime:1000,
                             type:"info"
                         });

                		break;
                	case 'regemail_has_exits':
                		 el2=$.tips({
                             content:'邮箱已注册',
                             stayTime:1000,
                             type:"info"
                         });

                		break;
                	case 'regemail_cant_use':
                		 el2=$.tips({
                             content:'此邮箱不能注册使用',
                             stayTime:1000,
                             type:"info"
                         });

                		break;
                	case 'reguser_has_exits':
                		 el2=$.tips({
                             content:'注册用户名已经存在',
                             stayTime:1000,
                             type:"info"
                         });

                		break;
                	case 'Illegal':
                		 el2=$.tips({
                             content:'用户名或者密码包含特殊字符',
                             stayTime:1000,
                             type:"info"
                         });

                		break;
                	default:

                		 el2=$.tips({
                             content:data,
                             stayTime:1000,
                             type:"info"
                         });
                		break;
                	}
                }
            }   ,
            //调用执行后调用的函数
            complete: function(XMLHttpRequest, textStatus){
         	    el.loading("hide");
            },
            //调用出错执行的函数
            error: function(){
                //请求出错处理
            }
        });
        return false;
    }



      //验证码
        function updatecode() {
            var img = g_site_url + "index.php" + query + "user/code/" + Math.random();
            $('#verifycode').attr("src", img);
        }

</script>
    </section>

<script src="{SITE_URL}static/css/fronze/js/main.js"></script>
