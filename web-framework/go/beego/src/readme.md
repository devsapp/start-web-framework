
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、服务名、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-beego 帮助文档
<p align="center" class="flex justify-center">
    <a href="https://www.serverless-devs.com" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-beego&type=packageType">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-beego" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-beego&type=packageVersion">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-beego" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-beego&type=packageDownload">
  </a>
</p>

<description>

beego 是一个使用 Go 语言来开发的高效率的 web 应用开发框架。

</description>

<codeUrl>

- [:smiley_cat: 代码](https://github.com/devsapp/start-web-framework/tree/master/web-framework/go/beego/src)

</codeUrl>
<preview>



</preview>


## 前期准备

使用该项目，您需要有开通以下服务：

<service>



| 服务 |  备注  |
| --- |  --- |
| 函数计算 FC |  基于 Beego 框架的 Web 函数部署在函数计算 |

</service>

推荐您拥有以下的产品权限 / 策略：
<auth>



| 服务/业务 |  权限 |  备注  |
| --- |  --- |   --- |
| 函数计算 | AliyunFCFullAccess |  创建或者更新基于 Beego 框架的 Web 函数 |

</auth>

<remark>



</remark>

<disclaimers>



</disclaimers>

## 部署 & 体验

<appcenter>
   
- :fire: 通过 [Serverless 应用中心](https://fcnext.console.aliyun.com/applications/create?template=start-beego) ，
  [![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://fcnext.console.aliyun.com/applications/create?template=start-beego) 该应用。
   
</appcenter>
<deploy>
    
- 通过 [Serverless Devs Cli](https://www.serverless-devs.com/serverless-devs/install) 进行部署：
  - [安装 Serverless Devs Cli 开发者工具](https://www.serverless-devs.com/serverless-devs/install) ，并进行[授权信息配置](https://docs.serverless-devs.com/fc/config) ；
  - 初始化项目：`s init start-beego -d start-beego `
  - 进入项目，并进行项目部署：`cd start-beego && s deploy - y`
   
</deploy>

## 应用详情

<appdetail id="flushContent">

本项目是将 Beego web 框架部署到阿里云 Serverless 平台（函数计算 FC）。

通过本应用，您可以部署一个 Beego 框架 web 应用，效果如下：

![](http://image.editor.devsapp.cn/alibaba/1vj5d8FAA5hcsjkiFA6A.png)

</appdetail>

## 使用文档

<usedetail id="flushContent">

项目部署完成会出现系统分配的域名地址，该域名地址可作为 API 地址。

例如，在应用中心完成业务功能部署：

![](http://image.editor.devsapp.cn/alibaba/Z3BjurkivswZtbkjyeyC.png)

此时，使用浏览器打开测试域名即可：

![](http://image.editor.devsapp.cn/alibaba/1vj5d8FAA5hcsjkiFA6A.png)

</usedetail>


<devgroup>


## 开发者社区

您如果有关于错误的反馈或者未来的期待，您可以在 [Serverless Devs repo Issues](https://github.com/serverless-devs/serverless-devs/issues) 中进行反馈和交流。如果您想要加入我们的讨论组或者了解 FC 组件的最新动态，您可以通过以下渠道进行：

<p align="center">  

| <img src="https://serverless-article-picture.oss-cn-hangzhou.aliyuncs.com/1635407298906_20211028074819117230.png" width="130px" > | <img src="https://serverless-article-picture.oss-cn-hangzhou.aliyuncs.com/1635407044136_20211028074404326599.png" width="130px" > | <img src="https://serverless-article-picture.oss-cn-hangzhou.aliyuncs.com/1635407252200_20211028074732517533.png" width="130px" > |
| --------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------- |
| <center>微信公众号：`serverless`</center>                                                                                         | <center>微信小助手：`xiaojiangwh`</center>                                                                                        | <center>钉钉交流群：`33947367`</center>                                                                                           |
</p>
</devgroup>
