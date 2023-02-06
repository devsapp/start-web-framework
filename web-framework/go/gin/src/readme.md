
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、服务名、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-gin 帮助文档
<p align="center" class="flex justify-center">
    <a href="https://www.serverless-devs.com" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-gin&type=packageType">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-gin" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-gin&type=packageVersion">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-gin" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-gin&type=packageDownload">
  </a>
</p>

<description>

Gin 是使用 Go/golang 语言实现的 HTTP Web 框架。接口简洁，性能极高。

</description>

<codeUrl>

- [:smiley_cat: 代码](https://github.com/devsapp/start-web-framework/tree/master/web-framework/go/gin)

</codeUrl>
<preview>



</preview>


## 前期准备

使用该项目，您需要有开通以下服务：

<service>



| 服务 |  备注  |
| --- |  --- |
| 函数计算 FC |  基于Gin框架的Web函数部署在函数计算 |

</service>

推荐您拥有以下的产品权限 / 策略：
<auth>



| 服务/业务 |  权限 |  备注  |
| --- |  --- |   --- |
| 函数计算 | AliyunFCFullAccess |  创建或者更新基于Gin框架的Web函数 |

</auth>

<remark>



</remark>

<disclaimers>



</disclaimers>

## 部署 & 体验

<appcenter>
   
- :fire: 通过 [Serverless 应用中心](https://fcnext.console.aliyun.com/applications/create?template=start-gin) ，
  [![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://fcnext.console.aliyun.com/applications/create?template=start-gin) 该应用。
   
</appcenter>
<deploy>
    
- 通过 [Serverless Devs Cli](https://www.serverless-devs.com/serverless-devs/install) 进行部署：
  - [安装 Serverless Devs Cli 开发者工具](https://www.serverless-devs.com/serverless-devs/install) ，并进行[授权信息配置](https://docs.serverless-devs.com/fc/config) ；
  - 初始化项目：`s init start-gin -d start-gin `
  - 进入项目，并进行项目部署：`cd start-gin && s deploy - y`
   
</deploy>

## 应用详情

<appdetail id="flushContent">

本项目是将 Gin  web 框架部署到阿里云 Serverless 平台（函数计算 FC）。

通过本应用，您可以部署一个 Gin 框架web应用，效果如下：

![](http://image.editor.devsapp.cn/alibaba/xkv59yxZqA6s1Gw8vvEs.png)

</appdetail>

## 使用文档

<usedetail id="flushContent">

项目部署完成会出现系统分配的域名地址，该域名地址可作为 API 地址。

例如，在应用中心完成业务功能部署：

![](http://image.editor.devsapp.cn/alibaba/Z6xiav5SZgEG5i22khhg.png)


此时，使用浏览器或者 curl 工具， 就可以对测试域名进行请求：

![](http://image.editor.devsapp.cn/alibaba/xkv59yxZqA6s1Gw8vvEs.png)

![](http://image.editor.devsapp.cn/alibaba/vdZkiv1xyrxkjGv1blr9.png)

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
