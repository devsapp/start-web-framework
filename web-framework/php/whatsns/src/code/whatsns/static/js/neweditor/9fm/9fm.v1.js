/*

作者：Firefly95
联系QQ：13783821
项目官网：http://www.9fm.cn/
开发团队：http://9fm.leipi.org/
--------------------------------------------------
2015-08-18
*/
UE.cn9fm = '9fm',UE.api_9fmplayer = "http://9fm.fenliu.cn/api/getplayer.html",UE.api_9fmso = "http://9fm.fenliu.cn/api/so.html";
UE.registerUI('9fm',function(editor,uiName){
    var dialog = new UE.ui.Dialog({
        iframeUrl:this.options.UEDITOR_HOME_URL + UE.cn9fm +'/music.html',
        editor:editor,
        name:uiName,
        title:"ask2问答 发现音乐，分享音乐,可以在( PC、iPhone、Android )播放",
        cssRules:"width:600px;height:300px;",
        buttons:[
            {
                className:'edui-okbutton',
                label:'确定',
                onclick:function () {
                    dialog.close(true);
                }
            }
        ]});

    var btn = new UE.ui.Button({
        name:'dialogbutton' + uiName,
        title:'9FM音乐',
        cssRules :'background-position:-18px -40px;',
        onclick:function () {
            dialog.render();
            dialog.open();
        }
    });

    return btn;
});

