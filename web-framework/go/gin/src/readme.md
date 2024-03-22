
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-gin-v3 帮助文档
<p align="center" class="flex justify-center">
    <a href="https://www.serverless-devs.com" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-gin-v3&type=packageType">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-gin-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-gin-v3&type=packageVersion">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-gin-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-gin-v3&type=packageDownload">
  </a>
</p>

<description>

本案例是将 Gin ，这一非常受欢迎的 web 框架，快速创建并部署到阿里云函数计算 FC 。

</description>

<codeUrl>

- [:smiley_cat: 代码](https://github.com/devsapp/start-web-framework/tree/V3/web-framework/go/gin/src)

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
   
- :fire: 通过 [Serverless 应用中心](https://fcnext.console.aliyun.com/applications/create?template=start-gin-v3) ，
  [![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://fcnext.console.aliyun.com/applications/create?template=start-gin-v3) 该应用。
   
</appcenter>
<deploy>
    
- 通过 [Serverless Devs Cli](https://www.serverless-devs.com/serverless-devs/install) 进行部署：
  - [安装 Serverless Devs Cli 开发者工具](https://www.serverless-devs.com/serverless-devs/install) ，并进行[授权信息配置](https://docs.serverless-devs.com/fc/config) ；
  - 初始化项目：`s init start-gin-v3 -d start-gin-v3`
  - 进入项目，并进行项目部署：`cd start-gin-v3 && s deploy -y`
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例是将 Gin ，这一非常受欢迎的 web 框架，快速创建并部署到阿里云函数计算 FC 。

Gin在Go语言的Web开发社区中非常受欢迎，并且拥有大量的用户和贡献者。它的简洁性、性能和灵活性使得它成为许多Go语言开发者的首选框架。Gin在GitHub等代码托管平台上的star数和fork数都很高，这表明了它的广泛使用和影响力。

Gin框架的应用场景非常广泛，如：RESTful API开发、Web服务开发、微服务架构、实时通信等。它的高性能、简洁易用和灵活扩展等特点使得它成为Go语言开发者的优选之一。

通过 Serverless 开发平台，您只需要几步，就可以体验 Gin 框架，并享受 Serverless 架构带来的降本提效的技术红利。

</appdetail>

## 使用流程

<usedetail id="flushContent">

### 查看部署的案例

通过本案例，您可以部署一个 Gin 框架web应用，效果如下：

![](http://image.editor.devsapp.cn/alibaba/xkv59yxZqA6s1Gw8vvEs.png)


项目部署完成会出现系统分配的域名地址，该域名地址可作为 API 地址。

例如，在控制台完成业务功能部署：

![](http://image.editor.devsapp.cn/alibaba/Z6xiav5SZgEG5i22khhg.png)


此时，使用浏览器或者 curl 工具， 就可以对测试域名进行请求：

![](http://image.editor.devsapp.cn/alibaba/xkv59yxZqA6s1Gw8vvEs.png)

![](http://image.editor.devsapp.cn/alibaba/vdZkiv1xyrxkjGv1blr9.png)

### 二次开发

您可以通过云端控制台的开发功能进行二次开发。如果您之前是在本地创建的项目案例，也可以在本地项目目录`start-gin-v3`文件夹下，对项目进行二次开发。开发完成后，可以通过`s deploy`进行快速部署。

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
