
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、服务名、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-django-test 帮助文档
<p align="center" class="flex justify-center">
    <a href="https://www.serverless-devs.com" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-django-test&type=packageType">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-django-test" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-django-test&type=packageVersion">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-django-test" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-django-test&type=packageDownload">
  </a>
</p>

<description>

Django是一个开放源代码的Web应用框架，由Python写成。采用了MTV的框架模式，即模型M，视图V和模版T

</description>

<codeUrl>

- [:smiley_cat: 代码](https://github.com/devsapp/start-web-framework/tree/master/web-framework/python/django)

</codeUrl>
<preview>

- [:eyes: 预览](http://django.web-framework-2bxw.1431999136518149.cn-hangzhou.fc.devsapp.net/)

</preview>


## 前期准备

使用该项目，您需要有开通以下服务：

<service>



| 服务 |  备注  |
| --- |  --- |
| 函数计算 FC |  需要创建函数处理核心业务逻辑 |

</service>

推荐您拥有以下的产品权限 / 策略：
<auth>



| 服务/业务 |  权限 |  备注  |
| --- |  --- |   --- |
| 函数计算 | AliyunFCFullAccess |  需要创建函数处理核心业务逻辑 |

</auth>

<remark>

您还需要注意：   
如果部署的项目的代码包很大， 超过了函数计算最大的 500M 限制，可以参考[函数计算大代码包部署的实践](https://github.com/awesome-fc/fc-faq/blob/main/docs/%E5%A4%A7%E4%BB%A3%E7%A0%81%E5%8C%85%E9%83%A8%E7%BD%B2%E7%9A%84%E5%AE%9E%E8%B7%B5%E6%A1%88%E4%BE%8B.md)

</remark>

<disclaimers>

免责声明：   
Django 是一个高级 Python Web 框架，它鼓励快速开发和干净、实用的设计。由经验丰富的开发人员构建，它解决了 Web 开发的大部分麻烦，因此您可以专注于编写您的应用程序，而无需重新发明轮子。它是免费和开源的。具体的使用所需遵循的协议，请参考 https://www.djangoproject.com/

</disclaimers>

## 部署 & 体验

<appcenter>
   
- :fire: 通过 [Serverless 应用中心](https://fcnext.console.aliyun.com/applications/create?template=start-django-test) ，
  [![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://fcnext.console.aliyun.com/applications/create?template=start-django-test) 该应用。
   
</appcenter>
<deploy>
    
- 通过 [Serverless Devs Cli](https://www.serverless-devs.com/serverless-devs/install) 进行部署：
  - [安装 Serverless Devs Cli 开发者工具](https://www.serverless-devs.com/serverless-devs/install) ，并进行[授权信息配置](https://docs.serverless-devs.com/fc/config) ；
  - 初始化项目：`s init start-django-test -d start-django-test `
  - 进入项目，并进行项目部署：`cd start-django-test && s deploy - y`
   
</deploy>

## 应用详情

<appdetail id="flushContent">

本项目是将 Python Web 框架中，非常受欢迎的 Django 框架，部署到阿里云 Serverless 平台（函数计算 FC）。

> Django是一个开放源代码的Web应用框架，由Python写成。采用了MTV的框架模式，即模型M，视图V和模版T。它最初是被开发来用于管理劳伦斯出版集团旗下的一些以新闻内容为主的网站的，即是CMS（内容管理系统）软件。并于2005年7月在BSD许可证下发布。这套框架是以比利时的吉普赛爵士吉他手Django Reinhardt来命名的。2019年12月2日，Django 3. 0发布

通过 Serverless Devs 开发者工具，您只需要几步，就可以体验 Serverless 架构，带来的降本提效的技术红利。

</appdetail>

## 使用文档

<usedetail id="flushContent">

# 返回的地址进行测试

本案例应用是一个非常简单的 Hello World 案例，部署完成之后，您可以看到系统返回给您的案例地址，例如：

![图片alt](https://serverless-article-picture.oss-cn-hangzhou.aliyuncs.com/1644567419851_20220211081700122623.png)

此时，打开案例地址，就可以看到测试的应用详情：

![图片alt](https://serverless-article-picture.oss-cn-hangzhou.aliyuncs.com/1644567448674_20220211081728869982.png)

当然，除了这样一个 Django 的 Hello World 之外，我们还有一个[基于 Django 框架的博客案例](https://github.com/devsapp/start-web-framework/tree/master/example/django-blog/src) ，可供学习和参考。

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
