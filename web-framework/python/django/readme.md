
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-django-v3 帮助文档
<p align="center" class="flex justify-center">
    <a href="https://www.serverless-devs.com" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-django-v3&type=packageType">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-django-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-django-v3&type=packageVersion">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-django-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-django-v3&type=packageDownload">
  </a>
</p>

<description>

本案例是将 Python Web 框架中，非常受欢迎的 Django 框架，快速创建并部署到阿里云函数计算 FC。

</description>

<codeUrl>

- [:smiley_cat: 代码](https://github.com/devsapp/start-web-framework/tree/V3/web-framework/python/django/src)

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
   
- :fire: 通过 [Serverless 应用中心](https://fcnext.console.aliyun.com/applications/create?template=start-django-v3) ，
  [![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://fcnext.console.aliyun.com/applications/create?template=start-django-v3) 该应用。
   
</appcenter>
<deploy>
    
- 通过 [Serverless Devs Cli](https://www.serverless-devs.com/serverless-devs/install) 进行部署：
  - [安装 Serverless Devs Cli 开发者工具](https://www.serverless-devs.com/serverless-devs/install) ，并进行[授权信息配置](https://docs.serverless-devs.com/fc/config) ；
  - 初始化项目：`s init start-django-v3 -d start-django-v3`
  - 进入项目，并进行项目部署：`cd start-django-v3 && s deploy -y`
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例是将 Python Web 框架中，非常受欢迎的 Django 框架，快速创建并部署到阿里云函数计算 FC。

Django是一个开放源代码的Web应用框架，由Python写成。采用了MTV的框架模式，即模型M，视图V和模版T。它最初是被开发来用于管理劳伦斯出版集团旗下的一些以新闻内容为主的网站的，即是CMS（内容管理系统）软件。并于2005年7月在BSD许可证下发布。这套框架是以比利时的吉普赛爵士吉他手Django Reinhardt来命名的。

Django凭借其强大的功能和易用性，赢得了全球大量开发者的青睐。其优势包括开发效率高、生态完善，并且有官方社区长期支持。Django不仅适合大型公司使用，也适合个人开发者进行项目开发，因此它在各种规模和类型的项目中都有广泛的应用。主要适用于Web应用开发、API服务、数据分析平台、以及后台管理系统等。

Django还具有高度的安全性，包括防止常见的Web攻击、CSRF保护、XSS预防等，有助于开发相对安全的Web应用。同时，其可扩展性也支持模块化开发和可插拔的应用，使得系统易于扩展和维护。

通过 Serverless 开发平台，您只需要几步，就可以体验 Django 框架，并享受Serverless 架构带来的降本提效的技术红利。

</appdetail>

## 使用流程

<usedetail id="flushContent">

### 查看部署的案例
部署完成之后，您可以看到系统返回给您的案例地址, 如图:

![图片alt](https://img.alicdn.com/imgextra/i4/O1CN019DHro51NlQYyyFzn7_!!6000000001610-0-tps-1104-322.jpg)

此时，打开案例地址，就可以进入 django 默认的首页：

![图片alt](https://img.alicdn.com/imgextra/i4/O1CN01dS1RL71CEUJCVIj2I_!!6000000000049-0-tps-1814-1278.jpg)

### 二次开发

您可以通过云端控制台的开发功能进行二次开发。如果您之前是在本地创建的项目案例，也可以在本地项目目录`start-django-v3`文件夹下，对项目进行二次开发。开发完成后，可以通过`s deploy`进行快速部署。

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
