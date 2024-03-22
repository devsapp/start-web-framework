
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-egg-v3 帮助文档
<p align="center" class="flex justify-center">
    <a href="https://www.serverless-devs.com" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-egg-v3&type=packageType">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-egg-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-egg-v3&type=packageVersion">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-egg-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-egg-v3&type=packageDownload">
  </a>
</p>

<description>

为企业级框架和应用而生（部署到Custom运行时）

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
   
- :fire: 通过 [Serverless 应用中心](https://fcnext.console.aliyun.com/applications/create?template=start-egg-v3) ，
  [![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://fcnext.console.aliyun.com/applications/create?template=start-egg-v3) 该应用。
   
</appcenter>
<deploy>
    
- 通过 [Serverless Devs Cli](https://www.serverless-devs.com/serverless-devs/install) 进行部署：
  - [安装 Serverless Devs Cli 开发者工具](https://www.serverless-devs.com/serverless-devs/install) ，并进行[授权信息配置](https://docs.serverless-devs.com/fc/config) ；
  - 初始化项目：`s init start-egg-v3 -d start-egg-v3`
  - 进入项目，并进行项目部署：`cd start-egg-v3 && s deploy -y`
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例将Egg.js，这一被开发者广泛使用的企业级 Node.js 框架，快速创建并部署到阿里云函数计算 FC 。

Egg.js 的设计哲学强调约定优于配置，以及一致的开发规范，从而使得团队协作变得更加顺畅。它的插件体系和完善的文档允许开发者快速构建 RESTful API、Web 应用服务器、微服务架构，以及处理各种网络协议的后端服务。Egg.js 的高度扩展性还意味着它可以与现代前端技术栈无缝集成，比如 React、Vue、Angular 等。

该框架在业界获得了显著的认可，其 GitHub 仓库拥有 18.8k star，得到了包括阿里巴巴、腾讯等知名企业的青睐和采用。凭借 Egg.js，开发者可以专注于业务逻辑的实现，而将安全性、稳定性和可维护性交由框架来保障。

利用 Egg.js 构建的服务端应用，当部署在 Serverless 开发平台上时，将能够享受到更高效的资源利用率和弹性伸缩的能力。Serverless 架构可以极大地减少运维负担，开发者无需担心底层服务器的配置和管理，能够迅速响应市场需求，推出新功能。Egg.js 与 Serverless 开发平台的结合，为企业带来了敏捷开发的同时，也保证了长期的项目可维护性和稳定性。

</appdetail>

## 使用流程

<usedetail id="flushContent">

### 查看部署的应用
本项目案例是 egg 部署到阿里云 Serverless 平台（函数计算 FC），部署完成之后，您可以看到系统返回给您的案例地址，例如：

![图片alt](https://img.alicdn.com/imgextra/i1/O1CN01T9BLMX22ux5PZbryb_!!6000000007181-0-tps-1220-350.jpg)

此时，打开案例地址，就可以看到测试的应用详情：

![图片alt](https://img.alicdn.com/imgextra/i1/O1CN01D62QIp1pzRxBLab8V_!!6000000005431-0-tps-2526-1502.jpg)

### 二次开发
您可以通过页面上的云端开发功能，在线进行二次开发。如您之前是在本地创建项目，也可以在本地的项目目录`start-egg-v3`下，对项目进行二次开发。在完成开发后，您可以通过`s deploy`命令重新部署该项目并进行查看。

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
