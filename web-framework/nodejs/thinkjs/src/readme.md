
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-thinkjs-v3 帮助文档
<p align="center" class="flex justify-center">
    <a href="https://www.serverless-devs.com" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-thinkjs-v3&type=packageType">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-thinkjs-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-thinkjs-v3&type=packageVersion">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-thinkjs-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-thinkjs-v3&type=packageDownload">
  </a>
</p>

<description>

ThinkJS 是一款面向未来开发的 Node.js 框架，整合了大量的项目最佳实践，让企业级开发变得更简单、高效。从 3.0 开始，框架底层基于 Koa 2.x 实现，兼容 Koa 的所有功能（部署到Custom运行时）

</description>

<codeUrl>



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
   
- :fire: 通过 [Serverless 应用中心](https://fcnext.console.aliyun.com/applications/create?template=start-thinkjs-v3) ，
  [![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://fcnext.console.aliyun.com/applications/create?template=start-thinkjs-v3) 该应用。
   
</appcenter>
<deploy>
    
- 通过 [Serverless Devs Cli](https://www.serverless-devs.com/serverless-devs/install) 进行部署：
  - [安装 Serverless Devs Cli 开发者工具](https://www.serverless-devs.com/serverless-devs/install) ，并进行[授权信息配置](https://docs.serverless-devs.com/fc/config) ；
  - 初始化项目：`s init start-thinkjs-v3 -d start-thinkjs-v3`
  - 进入项目，并进行项目部署：`cd start-thinkjs-v3 && s deploy -y`
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例将ThinkJS，这一高效的Node.js 框架，快速创建并部署到阿里云函数计算 FC 。

ThinkJS 是一个高效的 Node.js 框架，专为企业级用户和快速开发的现代网络应用程序设计。它采用了全新的 ES6/7 语法，支持 async/await 避免了回调地狱，提供了更优雅的异步代码编写方式。它的 MVC 模式让应用逻辑清晰分层，同时它的自动化工具和组件化支持显著提高了开发效率。

在 GitHub 上，ThinkJS 以其稳定性和前瞻性特性赢得了开发者的青睐，拥有一定数量的 stars。它是由国内开发者团队维护的，因此在国内社区中有着不错的知名度和使用基础。很多中国开发者和公司选择 ThinkJS 作为他们的后端解决方案，特别适用于追求快速开发节奏和期望使用最新JavaScript功能的团队。

ThinkJS 的另一个特点是其插件系统，开发者可以很容易地添加新功能或者在现有功能上进行定制。此外，它还提供了一个强大的 CLI 工具，可以帮助开发者生成项目骨架、创建控制器、模型等，进一步加速开发流程。

将 ThinkJS 应用部署在 Serverless 开发平台上，可以帮助开发团队减少关于服务器配置和维护的烦恼，使他们能够更专注于业务逻辑的实现。Serverless 环境还可以根据应用负载自动调整资源，从而提高应用的伸缩性能和成本效率。

</appdetail>

## 使用流程

<usedetail id="flushContent">

### 查看部署的应用
本项目案例是 thinkjs 部署到阿里云 Serverless 平台（函数计算 FC），部署完成之后，您可以看到系统返回给您的案例地址，例如：

![图片alt](https://img.alicdn.com/imgextra/i4/O1CN01LEAovF1hqH6udRWqY_!!6000000004328-0-tps-1160-330.jpg)

此时，打开案例地址，就可以进入 thinkjs 默认的首页：

![图片alt](https://img.alicdn.com/imgextra/i3/O1CN01Tf3ApY1Unu2JwOrXp_!!6000000002563-0-tps-2990-1510.jpg)

### 二次开发
您可以通过页面上的云端开发功能，在线进行二次开发。如您之前是在本地创建项目，也可以在本地的项目目录`start-thinkjs-v3`下，对项目进行二次开发。在完成开发后，您可以通过`s deploy`命令重新部署该项目并进行查看。

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
