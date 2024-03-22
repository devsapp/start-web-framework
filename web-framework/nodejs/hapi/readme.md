
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-hapi-v3 帮助文档
<p align="center" class="flex justify-center">
    <a href="https://www.serverless-devs.com" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-hapi-v3&type=packageType">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-hapi-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-hapi-v3&type=packageVersion">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-hapi-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-hapi-v3&type=packageDownload">
  </a>
</p>

<description>

HapiJS是一个开源的、基于Node.js的应用框架，它适用于构建应用程序和服务，其设计目标是让开发者把精力集中于开发可重用的应用程序的业务逻辑，向开发者提供构建应用程序业务逻辑所需的基础设施。

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
   
- :fire: 通过 [Serverless 应用中心](https://fcnext.console.aliyun.com/applications/create?template=start-hapi-v3) ，
  [![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://fcnext.console.aliyun.com/applications/create?template=start-hapi-v3) 该应用。
   
</appcenter>
<deploy>
    
- 通过 [Serverless Devs Cli](https://www.serverless-devs.com/serverless-devs/install) 进行部署：
  - [安装 Serverless Devs Cli 开发者工具](https://www.serverless-devs.com/serverless-devs/install) ，并进行[授权信息配置](https://docs.serverless-devs.com/fc/config) ；
  - 初始化项目：`s init start-hapi-v3 -d start-hapi-v3`
  - 进入项目，并进行项目部署：`cd start-hapi-v3 && s deploy -y`
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例将 hapi.js ，这一功能齐全的 Node.js 框架，快速创建并部署到阿里云函数计算 FC 。

hapi.js 为开发者提供了一套工具来构建可扩展和健壮的服务器端应用程序和服务。hapi的核心特点包括内置的输入验证、缓存、身份验证、错误处理和更多。它以插件系统为基础，允许开发者通过模块化的方式扩展应用功能，同时保持代码的组织性和可测试性。

这个框架的设计原则之一是"配置即代码"，这意味着大部分功能通过配置对象而非编写大量代码来实现。这种方法简化了复杂功能的集成，并促进了代码的清晰和易管理。hapi在GitHub上有着良好的用户基础和活跃的社区，被多家知名企业和组织采纳，这证明了其作为构建企业级应用的可靠性和有效性。

通过使用hapi.js，开发人员可以构建从简单的API到复杂的单页应用程序的服务器端逻辑。它的插件生态系统和可组合的架构使得添加新功能变得简单，并且在需要时可以轻松地进行升级或替换组件。

结合Serverless 开发平台，hapi.js可以实现更有效的资源利用和自动扩缩能力，无需管理底层服务器。借助Serverless 开发平台，hapi应用可以自动扩展以适应流量变化，同时减少未使用资源的浪费。这意味着开发者可以更专注于业务逻辑的创造，而将运维的复杂性和规模化问题交给云平台管理。

</appdetail>

## 使用流程

<usedetail id="flushContent">

本项目案例是将 hapi 部署到阿里云 Serverless 平台 (函数计算 FC) 。部署完成之后，您可以看到系统返回给您的案例地址, 如图:

![图片alt](https://img.alicdn.com/imgextra/i4/O1CN01wLm5Gn25WAV8q7Qw0_!!6000000007533-0-tps-1176-338.jpg)

此时，打开案例地址，就可以进入 hapi 默认的首页：

![图片alt](https://img.alicdn.com/imgextra/i1/O1CN019eIc1K1w9sfJirPVk_!!6000000006266-0-tps-2738-1418.jpg)

### 二次开发
您可以通过页面上的云端开发功能，在线进行二次开发。如您之前是在本地创建项目，也可以在本地的项目目录`start-hapi-v3`下，对项目进行二次开发。在完成开发后，您可以通过`s deploy`命令重新部署该项目并进行查看。

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
