
{if $user['uid']}
<!-- 登录后展示消息，且只有新消息才显示 -->
<div class="ui-tooltips ui-tooltips-guide msg-count hide" onclick="window.location.href='{url message/personal}'">
    <div class="ui-tooltips-cnt ui-tooltips-cnt-link ui-border-b ">
        <i class="ui-icon-talk"></i>您有<span class="m_num"></span>条消息待处理
    </div>
</div>
<style>
.msgspan{
display:none;

    background: #ea6f5a;
    color: #fff;
    padding: 3px;
    border-radius: 50%;
    position: absolute;
    min-width: 20px;
    height: 20px;
    line-height: 20px;
    top: -10px;
}
.tab-head-item ,.tab-head-item a{
position:relative;
}
</style>
{/if}
