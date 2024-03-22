
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-nest-v3 帮助文档
<p align="center" class="flex justify-center">
    <a href="https://www.serverless-devs.com" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-nest-v3&type=packageType">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-nest-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-nest-v3&type=packageVersion">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-nest-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-nest-v3&type=packageDownload">
  </a>
</p>

<description>

Nest (NestJS) 是一个用于构建高效、可扩展的 Node.js 服务器端应用程序的开发框架。

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
   
- :fire: 通过 [Serverless 应用中心](https://fcnext.console.aliyun.com/applications/create?template=start-nest-v3) ，
  [![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://fcnext.console.aliyun.com/applications/create?template=start-nest-v3) 该应用。
   
</appcenter>
<deploy>
    
- 通过 [Serverless Devs Cli](https://www.serverless-devs.com/serverless-devs/install) 进行部署：
  - [安装 Serverless Devs Cli 开发者工具](https://www.serverless-devs.com/serverless-devs/install) ，并进行[授权信息配置](https://docs.serverless-devs.com/fc/config) ；
  - 初始化项目：`s init start-nest-v3 -d start-nest-v3`
  - 进入项目，并进行项目部署：`cd start-nest-v3 && s deploy -y`
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例 Nest.js ，这一灵活的 Node.js 框架，快速创建并部署到阿里云函数计算 FC 。

NestJS 旨在为开发者提供构建高效、可维护和可扩展Web应用程序的工具。使用 TypeScript 作为主要语言，NestJS 提供了严格的类型检查，极大地提高了代码的质量和可维护性。它的架构灵感来源于 Angular，采用了模块化和面向切面编程的概念，从而使得代码组织结构清晰，且易于测试。

在GitHub上，NestJS 凭借其一致性、可扩展性和集成了现代技术的特点，赢得了大量的 stars (63.5k) 和一个活跃的开发社区。世界各地的开发者和许多公司都在采用 NestJS 来构建他们的后端服务，特别是当需要一个结构化、维护性强的解决方案时。

NestJS 的一个突出特点是它的模块化系统，允许将应用程序划分为多个模块，每个模块都专注于特定的任务或功能区域。这有助于保持代码的整洁和组织，同时也方便在团队中协作。框架同时支持依赖注入，这使得每个部分都能够轻松地测试和模拟。

结合 Serverless 开发平台，NestJS 可以在无服务器环境中运行，这让开发者能够专注于编写业务逻辑，而无需处理服务器的配置和管理。Serverless 开发平台的自动扩展功能意味着应用程序可以根据需求动态调整资源，这为处理不可预见的流量提供了灵活性，并且可能会降低运营成本。

</appdetail>

## 使用流程

<usedetail id="flushContent">

### 查看部署的应用
本项目案例是 nest 部署到阿里云 Serverless 平台（函数计算 FC），部署完成之后，您可以看到系统返回给您的案例地址，例如：

![图片alt](https://img.alicdn.com/imgextra/i2/O1CN01B5lXdl1cdqHT3P8ps_!!6000000003624-0-tps-1272-342.jpg)

此时，打开案例地址，就可以进入 nest 默认的首页：

![图片alt](https://img.alicdn.com/imgextra/i1/O1CN01wCeC0D238EYKSZW3J_!!6000000007210-0-tps-2518-1454.jpg)

### 二次开发
您可以通过页面上的云端开发功能，在线进行二次开发。如您之前是在本地创建项目，也可以在本地的项目目录`start-nest-v3`下，对项目进行二次开发。在完成开发后，您可以通过`s deploy`命令重新部署该项目并进行查看。

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
