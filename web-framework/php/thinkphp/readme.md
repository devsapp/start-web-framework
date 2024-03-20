
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-thinkphp-v3 帮助文档
<p align="center" class="flex justify-center">
    <a href="https://www.serverless-devs.com" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-thinkphp-v3&type=packageType">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-thinkphp-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-thinkphp-v3&type=packageVersion">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-thinkphp-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-thinkphp-v3&type=packageDownload">
  </a>
</p>

<description>

本案例将 ThinkPHP 框架，这一款非常流行的web应用开发框架，快速创建部署到阿里云函数计算 FC 。

</description>

<codeUrl>

- [:smiley_cat: 代码](https://github.com/devsapp/start-web-framework/blob/V3/web-framework/php/thinkphp/src)

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
   
- :fire: 通过 [Serverless 应用中心](https://fcnext.console.aliyun.com/applications/create?template=start-thinkphp-v3) ，
  [![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://fcnext.console.aliyun.com/applications/create?template=start-thinkphp-v3) 该应用。
   
</appcenter>
<deploy>
    
- 通过 [Serverless Devs Cli](https://www.serverless-devs.com/serverless-devs/install) 进行部署：
  - [安装 Serverless Devs Cli 开发者工具](https://www.serverless-devs.com/serverless-devs/install) ，并进行[授权信息配置](https://docs.serverless-devs.com/fc/config) ；
  - 初始化项目：`s init start-thinkphp-v3 -d start-thinkphp-v3`
  - 进入项目，并进行项目部署：`cd start-thinkphp-v3 && s deploy -y`
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例将 ThinkPHP 框架，这一款非常流行的web应用开发框架，快速创建部署到阿里云函数计算 FC 。

ThinkPHP是一个使用纯PHP开发，面向对象和面向过程的优秀安全敏捷的web应用框架，旨在简化企业级应用开发和敏捷web应用开发。它遵循MVC分层开发模式和单一入口等简洁规范的思想，并且内置了大量的开发模块和常用功能，以便开发者能够快速构建web应用程序。

ThinkPHP是一个非常流行的PHP开发框架，在web开发领域有着广泛的应用。其流行程度主要得益于其出色的性能、易用性、功能丰富性以及强大的社区支持。

ThinkPHP适用于各种规模的项目开发，特别是中大型项目。由于其具有丰富的功能和易用的操作方法，ThinkPHP特别适合构建需要复杂业务逻辑和数据库操作的应用程序。无论是企业级应用、网站开发还是API接口开发，ThinkPHP都能提供高效、稳定的解决方案。ThinkPHP还具有良好的跨平台性，支持多种服务器环境和数据库，这使得开发者可以根据项目需求灵活选择技术栈。

通过 Serverless 开发平台，您只需要几步，就可以体验 ThinkPHP 框架，并享受 Serverless 架构带来的降本提效的技术红利。

</appdetail>

## 使用流程

<usedetail id="flushContent">

### 查看部署的案例

部署完成之后，您可以看到系统返回给您的案例地址，例如：

![图片alt](https://img.alicdn.com/imgextra/i2/O1CN01VThkci1PfakWJv1X8_!!6000000001868-0-tps-1110-320.jpg)

此时，打开案例地址，就可以进入 ThinkPHP 首页：

![图片alt](https://img.alicdn.com/imgextra/i4/O1CN01sJoYbl1gMDSbmIVzC_!!6000000004127-0-tps-1548-934.jpg)

### 二次开发

您可以通过云端控制台的开发功能进行二次开发。如果您之前是在本地创建的项目案例，也可以在本地项目目录`start-thinkphp-v3`文件夹下，对项目进行二次开发。开发完成后，可以通过`s deploy`进行快速部署

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
