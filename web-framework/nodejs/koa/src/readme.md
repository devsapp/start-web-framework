
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-koa-v3 帮助文档
<p align="center" class="flex justify-center">
    <a href="https://www.serverless-devs.com" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-koa-v3&type=packageType">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-koa-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-koa-v3&type=packageVersion">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-koa-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-koa-v3&type=packageDownload">
  </a>
</p>

<description>

Koa 是一个新的 web 框架，由 Express 幕后的原班人马打造， 致力于成为 web 应用和 API 开发领域中的一个更小、更富有表现力、更健壮的基石（部署到Custom运行时）

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
   
- :fire: 通过 [Serverless 应用中心](https://fcnext.console.aliyun.com/applications/create?template=start-koa-v3) ，
  [![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://fcnext.console.aliyun.com/applications/create?template=start-koa-v3) 该应用。
   
</appcenter>
<deploy>
    
- 通过 [Serverless Devs Cli](https://www.serverless-devs.com/serverless-devs/install) 进行部署：
  - [安装 Serverless Devs Cli 开发者工具](https://www.serverless-devs.com/serverless-devs/install) ，并进行[授权信息配置](https://docs.serverless-devs.com/fc/config) ；
  - 初始化项目：`s init start-koa-v3 -d start-koa-v3`
  - 进入项目，并进行项目部署：`cd start-koa-v3 && s deploy -y`
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例将 Koa.js ，这一现代化的Node.js web框架，快速创建并部署到阿里云函数计算 FC 。

Koa.js 是一个现代化的Node.js web框架，通过利用 async 函数，它提供了一种更有效的方式来处理和响应HTTP请求。与传统的Node.js中间件模式不同，Koa 试图最小化中间件栈中的冗余和不必要的控制流，这为开发者提供了编写高效和可维护代码的更大灵活性。

其核心设计理念是通过一个精简的中间件层直接与Node.js的HTTP对象交互，从而避免在Node.js原生对象上进行封装或者扩展，这种设计使得Koa 不仅轻量，而且性能优越。它的中间件堆栈流式执行模式可以更加优雅地编写后端逻辑，让错误处理和数据传递变得简单清晰。

在GitHub上，Koa 由于其优雅的设计和高效的处理方式，得到了开发社区的高度评价和广泛的关注，拥有34.8k stars。许多初创公司和企业选择 Koa 作为他们构建 RESTful API 和服务端应用的基础，因为它允许他们以非常直观的方式构建功能和处理请求。

当开发者将 Koa 应用部署到 Serverless 开发平台时，他们可以充分利用云平台的扩展性和按需计费的优势，而无需担心底层基础设施的维护工作。这种架构让开发者能够专注于编码和业务逻辑，而将运维复杂性交给云服务提供商。Koa.js 的轻量化设计特别适合Serverless架构，使其成为现代Web开发中高效开发的理想选择。

</appdetail>

## 使用流程

<usedetail id="flushContent">

### 查看部署的应用
本项目案例是 koa 部署到阿里云 Serverless 平台（函数计算 FC），部署完成之后，您可以看到系统返回给您的案例地址，例如：

![图片alt](https://img.alicdn.com/imgextra/i1/O1CN01PiiXG01xMzdovGWIm_!!6000000006430-0-tps-1182-330.jpg)

此时，打开案例地址，就可以进入 koa 默认的首页：

![图片alt](https://img.alicdn.com/imgextra/i2/O1CN010YYmHs1GKg8sK5WqU_!!6000000000604-0-tps-2298-1314.jpg)

### 二次开发
您可以通过页面上的云端开发功能，在线进行二次开发。如您之前是在本地创建项目，也可以在本地的项目目录`start-koa-v3`下，对项目进行二次开发。在完成开发后，您可以通过`s deploy`命令重新部署该项目并进行查看。

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
