/**
 *  ueditor完整配置项
 *  可以在这里配置整个编辑器的特性
 */
/**************************提示********************************
 * 所有被注释的配置项均为UEditor默认值。
 * 修改默认配置请首先确保已经完全明确该参数的真实用途。
 * 主要有两种修改方案，一种是取消此处注释，然后修改成对应参数；另一种是在实例化编辑器时传入对应参数。
 * 当升级编辑器时，可直接使用旧版配置文件替换新版配置文件,不用担心旧版配置文件中因缺少新功能所需的参数而导致脚本报错。
 **************************提示********************************/


(function () {
    /**
     * 编辑器资源文件根路径。它所表示的含义是：以编辑器实例化页面为当前路径，指向编辑器资源文件（即dialog等文件夹）的路径。
     * 鉴于很多同学在使用编辑器的时候出现的种种路径问题，此处强烈建议大家使用"相对于网站根目录的相对路径"进行配置。
     * "相对于网站根目录的相对路径"也就是以斜杠开头的形如"/myProject/ueditor/"这样的路径。
     * 如果站点中有多个不在同一层级的页面需要实例化编辑器，且引用了同一UEditor的时候，此处的URL可能不适用于每个页面的编辑器。
     * 因此，UEditor提供了针对不同页面的编辑器可单独配置的根路径，具体来说，在需要实例化编辑器的页面最顶部写上如下代码即可。当然，需要令此处的URL等于对应的配置。
     * window.UEDITOR_HOME_URL = "/xxxx/xxxx/";
     */
    var URL = window.UEDITOR_HOME_URL || getUEBasePath();
    /**
     * 配置项主体。注意，此处所有涉及到路径的配置别遗漏URL变量。
     */
    window.UEDITOR_CONFIG = {

        //为编辑器实例添加一个路径，这个不能被注释
        UEDITOR_HOME_URL : URL

        //图片上传配置区
        ,imageUrl:g_site_url+"index.php?attach/uploadimage"             //图片上传提交地址
        ,imagePath:g_site_url                     //图片修正地址，引用了fixedImagePath,如有特殊需求，可自行配置
        //,imageFieldName:"upfile"                  //图片数据的key,若此处修改，需要在后台对应文件修改对应参数
        //,compressSide:0                           //等比压缩的基准，确定maxImageSideLength参数的参照对象。0为按照最长边，1为按照宽度，2为按照高度
        //,maxImageSideLength:900                   //上传图片最大允许的边长，超过会自动等比缩放,不缩放就设置一个比较大的值，更多设置在image.html中
        ,savePath: [ 'upload1', 'upload2', 'upload3' ]    //图片保存在服务器端的目录， 默认为空， 此时在上传图片时会向服务器请求保存图片的目录列表，
                                                            // 如果用户不希望发送请求， 则可以在这里设置与服务器端能够对应上的目录名称列表
                                                            //比如： savePath: [ 'upload1', 'upload2' ]

        //涂鸦图片配置区
        ,scrawlUrl:URL+"php/scrawlUp.php"           //涂鸦上传地址
        ,scrawlPath:URL+"php/"                            //图片修正地址，同imagePath

        //附件上传配置区
        ,fileUrl:g_site_url+"index.php?attach/upload"               //附件上传提交地址
        ,filePath:g_site_url                  //附件修正地址，同imagePath
        //,fileFieldName:"upfile"                    //附件提交的表单名，若此处修改，需要在后台对应文件修改对应参数

        //远程抓取配置区
        //,catchRemoteImageEnable:true               //是否开启远程图片抓取,默认开启
        ,catcherUrl:URL +"php/getRemoteImage.php"   //处理远程图片抓取的地址
        ,catcherPath:URL + "php/"                  //图片修正地址，同imagePath
        //,catchFieldName:"upfile"                   //提交到后台远程图片uri合集，若此处修改，需要在后台对应文件修改对应参数
        //,separater:'ue_separate_ue'               //提交至后台的远程图片地址字符串分隔符
        //,localDomain:[]                            //本地顶级域名，当开启远程图片抓取时，除此之外的所有其它域名下的图片都将被抓取到本地,默认不抓取127.0.0.1和localhost

        //图片在线管理配置区
        ,imageManagerUrl:URL + "php/imageManager.php"       //图片在线管理的处理地址
        ,imageManagerPath:URL + "php/"                                    //图片修正地址，同imagePath

        //屏幕截图配置区
        ,snapscreenHost: location.hostname                                 //屏幕截图的server端文件所在的网站地址或者ip，请不要加http://
        ,snapscreenServerUrl: URL +"php/imageUp.php" //屏幕截图的server端保存程序，UEditor的范例代码为“URL +"server/upload/php/snapImgUp.php"”
        ,snapscreenPath: URL + "php/"
        ,snapscreenServerPort: location.port                                   //屏幕截图的server端端口
        //,snapscreenImgAlign: ''                                //截图的图片默认的排版方式

        //word转存配置区
        ,wordImageUrl:URL + "php/imageUp.php"             //word转存提交地址
        ,wordImagePath:URL + "php/"                       //
        //,wordImageFieldName:"upfile"                     //word转存表单名若此处修改，需要在后台对应文件修改对应参数

        //视频上传配置区
        ,getMovieUrl:URL+"php/getMovie.php"                   //视频数据获取地址
        ,videoUrl:URL+"php/fileUp.php"               //附件上传提交地址
        ,videoPath:URL + "php/"                   //附件修正地址，同imagePath
        //,videoFieldName:"upfile"                    //附件提交的表单名，若此处修改，需要在后台对应文件修改对应参数

        //工具栏上的所有的功能按钮和下拉框，可以在new编辑器的实例时选择自己需要的从新定义

, toolbars: [[ 'preview','removeformat','music','formatmatch','cleardoc','bold','forecolor','backcolor','insertimage','autotypeset','attachment','link','unlink',
               'fontfamily','fontsize','insertvideo','map','fullscreen'
               ]]

        //常用配置项目
        //,isShow : true    //默认显示编辑器

        //,initialContent:'欢迎使用ueditor!'    //初始化编辑器的内容,也可以通过textarea/script给值，看官网例子

        //,initialFrameWidth:1000  //初始化编辑器宽度,默认1000
        //,initialFrameHeight:320  //初始化编辑器高度,默认320
        //,zIndex : 900     //编辑器层级的基数,默认是900

        //如果自定义，最好给p标签如下的行高，要不输入中文时，会有跳动感
        //,initialStyle:'p{line-height:1em}'//编辑器层级的基数,可以用来改变字体等
        ,wordCount:false          //是否开启字数统计
        ,elementPathEnabled : false
    };

    function getUEBasePath ( docUrl, confUrl ) {

        return getBasePath( docUrl || self.document.URL || self.location.href, confUrl || getConfigFilePath() );

    }

    function getConfigFilePath () {

        var configPath = document.getElementsByTagName('script');

        return configPath[ configPath.length -1 ].src;

    }

    function getBasePath ( docUrl, confUrl ) {

        var basePath = confUrl;


        if(/^(\/|\\\\)/.test(confUrl)){

            basePath = /^.+?\w(\/|\\\\)/.exec(docUrl)[0] + confUrl.replace(/^(\/|\\\\)/,'');

        }else if ( !/^[a-z]+:/i.test( confUrl ) ) {

            docUrl = docUrl.split( "#" )[0].split( "?" )[0].replace( /[^\\\/]+$/, '' );

            basePath = docUrl + "" + confUrl;

        }

        return optimizationPath( basePath );

    }

    function optimizationPath ( path ) {

        var protocol = /^[a-z]+:\/\//.exec( path )[ 0 ],
            tmp = null,
            res = [];

        path = path.replace( protocol, "" ).split( "?" )[0].split( "#" )[0];

        path = path.replace( /\\/g, '/').split( /\// );

        path[ path.length - 1 ] = "";

        while ( path.length ) {

            if ( ( tmp = path.shift() ) === ".." ) {
                res.pop();
            } else if ( tmp !== "." ) {
                res.push( tmp );
            }

        }

        return protocol + res.join( "/" );

    }

    window.UE = {
        getUEBasePath: getUEBasePath
    };

})();
