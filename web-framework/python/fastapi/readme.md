
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-fastapi-v3 帮助文档
<p align="center" class="flex justify-center">
    <a href="https://www.serverless-devs.com" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-fastapi-v3&type=packageType">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-fastapi-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-fastapi-v3&type=packageVersion">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-fastapi-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-fastapi-v3&type=packageDownload">
  </a>
</p>

<description>

本案例是将 fastapi 框架，快速创建部署到阿里云函数计算 FC 。

</description>

<codeUrl>

- [:smiley_cat: 代码](https://github.com/devsapp/start-web-framework/blob/V3/web-framework/python/fastapi/src)

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
   
- :fire: 通过 [Serverless 应用中心](https://fcnext.console.aliyun.com/applications/create?template=start-fastapi-v3) ，
  [![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://fcnext.console.aliyun.com/applications/create?template=start-fastapi-v3) 该应用。
   
</appcenter>
<deploy>
    
- 通过 [Serverless Devs Cli](https://www.serverless-devs.com/serverless-devs/install) 进行部署：
  - [安装 Serverless Devs Cli 开发者工具](https://www.serverless-devs.com/serverless-devs/install) ，并进行[授权信息配置](https://docs.serverless-devs.com/fc/config) ；
  - 初始化项目：`s init start-fastapi-v3 -d start-fastapi-v3`
  - 进入项目，并进行项目部署：`cd start-fastapi-v3 && s deploy -y`
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例是将 fastapi 框架，这一快速且高效的Web框架，快速创建部署到阿里云函数计算 FC 。

FastAPI是一个现代、快速且高效的Web框架，用于构建基于Python的API。它建立在Starlette和Pydantic之上，并利用了Python的异步生态系统，提供了出色的性能和吞吐量。FastAPI的主要特点包括：快速高效、自动文档生成、数据验证和转换、类型注解支持。

FastAPI适用于构建RESTful API、微服务架构、数据处理API以及实时通信等场景。它支持前后端分离的Web应用，快速开发和部署微服务，处理数据并接收和返回JSON数据，以及支持WebSocket实现实时通信。

FastAPI的灵活性使得它能够满足不同项目的需求。例如，对于需要快速迭代和构建高性能API的项目，FastAPI提供了快速编码和减少错误的功能，使得开发者能够更高效地完成开发任务。同时，FastAPI也支持构建微服务和云应用，为开发者提供了更多的选择和可能性。

FastAPI还提供了出色的编辑器支持和自动交互式文档功能，这进一步简化了开发过程并提高了开发效率。开发者可以利用这些功能快速定位问题、调试代码，并生成清晰的API文档，方便与其他团队成员协作和沟通。

通过 Serverless 开发平台，您只需要几步，就可以体验 fastapi 框架，并享受 Serverless 架构带来的降本提效的技术红利。

</appdetail>

## 使用流程

<usedetail id="flushContent">

### 查看部署的案例

部署完成之后，您可以看到系统返回给您的案例地址, 如图:

![图片alt](https://img.alicdn.com/imgextra/i2/O1CN01SjXRdK1dMGeum9IP3_!!6000000003721-0-tps-1100-320.jpg)

此时，打开案例地址，就可以进入基于 fastapi 设置的首页：

![图片alt](https://img.alicdn.com/imgextra/i1/O1CN01KcFj1P1xggdLYuCWH_!!6000000006473-0-tps-1666-1318.jpg)

### 二次开发

您可以通过云端控制台的开发功能进行二次开发。如果您之前是在本地创建的项目案例，也可以在本地项目目录`start-fastapi-v3`文件夹下，对项目进行二次开发。开发完成后，可以通过`s deploy`进行快速部署。

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
