
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-flask-v3 帮助文档
<p align="center" class="flex justify-center">
    <a href="https://www.serverless-devs.com" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-flask-v3&type=packageType">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-flask-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-flask-v3&type=packageVersion">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-flask-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-flask-v3&type=packageDownload">
  </a>
</p>

<description>

本案例将Flask框架，这一非常受欢迎的Python Web框架，快捷创建并部署到阿里云函数计算 FC。

</description>

<codeUrl>

- [:smiley_cat: 代码](https://github.com/devsapp/start-web-framework/tree/V3/web-framework/python/flask/src)

</codeUrl>
<preview>



</preview>


## 前期准备

使用该项目，您需要有开通以下服务并拥有对应权限：

<service>



| 服务/业务 |  权限  | 相关文档 |
| --- |  --- | --- |
| 函数计算 |  AliyunFCFullAccess | [帮助文档](https://help.aliyun.com/product/2508973.html) [计费文档](https://help.aliyun.com/document_detail/2512928.html) |

</service>

<remark>



</remark>

<disclaimers>



</disclaimers>

## 部署 & 体验

<appcenter>
   
- :fire: 通过 [Serverless 应用中心](https://fcnext.console.aliyun.com/applications/create?template=start-flask-v3) ，
  [![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://fcnext.console.aliyun.com/applications/create?template=start-flask-v3) 该应用。
   
</appcenter>
<deploy>
    
- 通过 [Serverless Devs Cli](https://www.serverless-devs.com/serverless-devs/install) 进行部署：
  - [安装 Serverless Devs Cli 开发者工具](https://www.serverless-devs.com/serverless-devs/install) ，并进行[授权信息配置](https://docs.serverless-devs.com/fc/config) ；
  - 初始化项目：`s init start-flask-v3 -d start-flask-v3`
  - 进入项目，并进行项目部署：`cd start-flask-v3 && s deploy -y`
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例将Flask框架，这一非常受欢迎的Python Web框架，快捷创建并部署到阿里云函数计算 FC。

Flask是一个使用 Python 编写的轻量级 Web 应用框架。其 WSGI 工具箱采用 Werkzeug ，模板引擎则使用 Jinja2 。Flask使用 BSD 授权。

该框架全网下载量超过四千万次，在github上获得了超过6w star，是最为主流的Python Web应用框架之一。

该框架特别适用于小型、简单的Web应用或API开发。对于这类项目，Flask的简洁性和易用性使得开发过程更加高效和快速。开发者可以利用Flask的核心组件快速搭建起项目的基本框架，并通过扩展库来增加额外的功能。

通过 Serverless 开发平台，您只需要几步，就可以体验 Flask 框架，并享受Serverless 架构带来的降本提效的技术红利。

</appdetail>

## 使用流程

<usedetail id="flushContent">

### 查看部署的案例
本案例应用是一个非常简单的 Hello World 案例，部署完成之后，您可以看到系统返回给您的案例地址，例如：

![图片alt](https://img.alicdn.com/imgextra/i1/O1CN01TRmXgG1DmD5FlW8Lv_!!6000000000258-0-tps-1072-326.jpg)

此时，打开案例地址，就可以看到测试的应用详情：

![图片alt](https://img.alicdn.com/imgextra/i1/O1CN01WUPmli1j20tgwId81_!!6000000004489-0-tps-1232-514.jpg)

### 二次开发
您可以通过页面上的云端开发功能，在线进行二次开发。如您之前是在本地创建项目，也可以在本地的项目目录`start-flask-v3`下，对项目进行二次开发。在完成开发后，您可以通过`s deploy`命令重新部署该项目并进行查看。

</usedetail>

## 注意事项

<matters id="flushContent">
</matters>


<devgroup>


## 开发者社区

您如果有关于错误的反馈或者未来的期待，您可以在 [Serverless Devs repo Issues](https://github.com/serverless-devs/serverless-devs/issues) 中进行反馈和交流。如果您想要加入我们的讨论组或者了解 FC 组件的最新动态，您可以通过以下渠道进行：

<p align="center">  

| <img src="https://serverless-article-picture.oss-cn-hangzhou.aliyuncs.com/1635407298906_20211028074819117230.png" width="130px" > | <img src="https://serverless-article-picture.oss-cn-hangzhou.aliyuncs.com/1635407044136_20211028074404326599.png" width="130px" > | <img src="https://serverless-article-picture.oss-cn-hangzhou.aliyuncs.com/1635407252200_20211028074732517533.png" width="130px" > |
| --------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------- |
| <center>微信公众号：`serverless`</center>                                                                                         | <center>微信小助手：`xiaojiangwh`</center>                                                                                        | <center>钉钉交流群：`33947367`</center>                                                                                           |
</p>
</devgroup>
