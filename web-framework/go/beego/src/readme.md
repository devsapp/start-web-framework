
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-beego-v3 帮助文档
<p align="center" class="flex justify-center">
    <a href="https://www.serverless-devs.com" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-beego-v3&type=packageType">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-beego-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-beego-v3&type=packageVersion">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-beego-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-beego-v3&type=packageDownload">
  </a>
</p>

<description>

本案例是将 Beego web 框架，快速搭建部署到阿里云函数计算 FC 。

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
   
- :fire: 通过 [Serverless 应用中心](https://fcnext.console.aliyun.com/applications/create?template=start-beego-v3) ，
  [![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://fcnext.console.aliyun.com/applications/create?template=start-beego-v3) 该应用。
   
</appcenter>
<deploy>
    
- 通过 [Serverless Devs Cli](https://www.serverless-devs.com/serverless-devs/install) 进行部署：
  - [安装 Serverless Devs Cli 开发者工具](https://www.serverless-devs.com/serverless-devs/install) ，并进行[授权信息配置](https://docs.serverless-devs.com/fc/config) ；
  - 初始化项目：`s init start-beego-v3 -d start-beego-v3`
  - 进入项目，并进行项目部署：`cd start-beego-v3 && s deploy -y`
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例是将 Beego ，这一快速开发Go应用的 web 框架，快速搭建部署到阿里云函数计算 FC 。

Beego是一个快速开发Go应用的http框架，它旨在简化Web应用、API以及后端服务的开发过程。这个框架的主要设计灵感来源于tornado、sinatra和flask，同时结合了Go语言本身的一些特性，如interface和struct继承等。

Beego的流行程度在Go语言的Web开发领域中是相当高的。作为一款基于Go语言的高性能Web应用框架，Beego因其简单易用、功能丰富以及性能优越等特点而备受欢迎。它在社区中的活跃度和开发者支持度都很高，这使得Beego成为许多Go语言开发者的首选框架之一。

Beego具有广泛的应用范围。它适用于构建各种类型的Web应用，包括企业级应用、电商网站、博客系统、RESTful API等。Beego的MVC模式使得代码结构清晰，易于维护和扩展，这对于大型项目的开发尤为重要。同时，Beego也支持构建微服务架构的Web应用，通过拆分功能模块为独立的服务，实现高内聚、低耦合的架构设计。

通过 Serverless 开发平台，您只需要几步，就可以体验 Beego 框架，并享受 Serverless 架构带来的降本提效的技术红利。

</appdetail>

## 使用流程

<usedetail id="flushContent">

### 查看部署的案例

通过本案例，您可以部署一个 Beego 框架 web 应用，效果如下：

![](https://img.alicdn.com/imgextra/i3/O1CN012UO6hK1zErpTfg0vY_!!6000000006683-0-tps-2546-1390.jpg)

### 二次开发

您可以通过云端控制台的开发功能进行二次开发。如果您之前是在本地创建的项目案例，也可以在本地项目目录`start-beego-v3`文件夹下，对项目进行二次开发。开发完成后，可以通过`s deploy`进行快速部署。

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
