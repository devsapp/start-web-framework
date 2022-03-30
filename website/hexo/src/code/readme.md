## 🚀 一键部署
您可以点击 点击`一键部署`按钮,进行快速体验

[![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://fcnext.console.aliyun.com/applications/create?template=website-hexo)

# Website 静态网站

> 快速部署和体验Serverless架构下的前端静态网站

- [体验前准备](#体验前准备)
- [代码与预览](#代码与预览)
- [快速部署和体验](#快速部署和体验)
    - [在线快速体验](#在线快速体验)
    - [在本地部署体验](#在本地部署体验)
- [项目使用注意事项](#项目使用注意事项)
- [应用详情](#应用详情)

## 体验前准备

该应用案例，需要您开通[阿里云OSS](https://oss.console.aliyun.com/)以及 [阿里云CDN](https://cdn.console.aliyun.com/) 产品。

## 代码与预览

- [:octocat: 源代码](https://github.com/devsapp/start-website/tree/master/website-hexo/src)
- [:earth_africa: 效果预览](http://django.web-framework.1583208943291465.cn-shenzhen.fc.devsapp.net/)

## 快速部署和体验
### 在线快速体验

- 通过阿里云 **Serverless 应用中心**： 可以点击 [【🚀 部署】](https://fcnext.console.aliyun.com/applications/create?template=website-hexo) ，按照引导填入参数，快速进行部署和体验。

### 在本地部署体验

1. 下载安装 Serverless Devs：`npm install @serverless-devs/s`
   > 详细文档可以参考 [Serverless Devs 安装文档](https://github.com/Serverless-Devs/Serverless-Devs/blob/master/docs/zh/install.md)
2. 配置密钥信息：`s config add`
   > 详细文档可以参考 [阿里云密钥配置文档](https://github.com/devsapp/fc/blob/main/docs/zh/config.md)
3. 初始化项目：`s init website-hexo -d website-hexo`
4. 进入项目并部署：`cd website-hexo && s deploy`

## 项目使用注意事项
项目Yaml中，声明了`actions`，其对应的命令分别为`npm install`以及`npm run build`。如果已经安装依赖或者无需`build`，再部署的时候通过`--skip-actions`跳过：`s deploy --skip-actions`。
或者注释掉`actions`的声明。加速`deploy`的部署流程

## 应用详情
通过 Serverless Devs 开发者工具，您只需要几步，就可以体验 Serverless 架构，带来的降本提效的技术红利。

本案例应用是一个非常简单的静态网站案例，部署完成之后，您可以看到系统返回给您的案例地址，例如：

![图片alt](https://img.alicdn.com/imgextra/i3/O1CN01fxYSoO1fHLTljwiTM_!!6000000003981-2-tps-1798-420.png)

此时，打开案例地址，就可以看到测试的应用详情：

![图片alt](https://img.alicdn.com/imgextra/i4/O1CN01crbYOg1MXOeyDUzQ0_!!6000000001444-2-tps-2532-1328.png)

-----

> - Serverless Devs 项目：https://www.github.com/serverless-devs/serverless-devs
> - Serverless Devs 文档：https://www.github.com/serverless-devs/docs
> - Serverless Devs 钉钉交流群：33947367    
