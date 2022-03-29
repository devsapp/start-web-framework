## 🚀 一键部署
您可以点击 点击`一键部署`按钮,进行快速体验
[![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://fcnext.console.aliyun.com/applications/create?template=start-laravel)

# Laravel 案例

<toc>

<p align="center"><b> 中文 | <a href="./readme_en.md"> English </a>  </b></p>

- [快速开始](#快速开始)
    - [通过应用中心部署](#通过应用中心部署)
    - [通过命令行工具部署](#通过命令行工具部署)
    - [通过阿里云CloudShell部署](#通过阿里云CloudShell部署)
- [应用详情](#应用详情)
- [关于我们](#关于我们)

</toc>

# 快速开始

- [:octocat: 源代码](https://github.com/devsapp/start-web-framework/tree/master/web-framework/php/laravel/src)
- [:earth_africa: 效果预览](http://laravel.web-framework.1583208943291465.cn-shenzhen.fc.devsapp.net/)

## 通过应用中心部署

<appcenter>

您可以在阿里云 [:earth_asia: Serverless 应用中心](https://fcnext.console.aliyun.com/applications/create?template=start-laravel) ，快速体验该应用：   
[![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://fcnext.console.aliyun.com/applications/create?template=start-laravel) 

</appcenter>

## 通过命令行工具部署
> 在开始之前，需要先安装 Serverless Devs 开发者工具：`npm install @serverless-devs/s -g`，更多安装方法，可以参考[Serverless Devs 安装文档](https://www.serverless-devs.com/serverless-devs/install) ，针对阿里云还需要配置密钥信息，配置密钥信息的方法可以参考[阿里云密钥配置文档](https://www.serverless-devs.com/fc/config)
- 初始化项目：`s init start-laravel -d start-laravel`    
    > 涉及到确定密钥的选择、服务名称的确定、函数名称的确定以及容器镜像的确定    
- 进入项目：`cd start-laravel`
- 部署项目：`s deploy -y`
- 调用函数： 根据返回的`url`信息，在浏览器中进行请求即可

## 通过阿里云CloudShell部署
如果您不想在应用中心中快速体验，也不想下载命令行工具体验，您也可以在[ :rocket:  阿里云 CloudShell](https://api.aliyun.com/new#/tutorial?action=git_open&git_repo=https://github.com/devsapp/start-web-framework.git&tutorial=web-framework/php/laravel/cloudshell.md) 中快速体验。
# 应用详情
本项目是将非常流行的开发框架 Laravel 部署到阿里云 Serverless 平台（函数计算 FC）。

通过 Serverless Devs 开发者工具，您只需要几步，就可以体验 Serverless 架构，带来的降本提效的技术红利。

部署完成之后，您可以看到系统返回给您的案例地址，例如：

![图片alt](https://img.alicdn.com/imgextra/i3/O1CN01YW4bY922rk74VKEpB_!!6000000007174-2-tps-2474-920.png)

此时，打开案例地址，就可以进入 Laravel 首页：

![图片alt](https://img.alicdn.com/imgextra/i3/O1CN01QGFRxH1dOYTnMSnnX_!!6000000003726-2-tps-2816-1466.png)

# 关于我们
- Serverless Devs 工具：
    - 仓库：[https://www.github.com/serverless-devs/serverless-devs](https://www.github.com/serverless-devs/serverless-devs)    
      > 欢迎帮我们增加一个 :star2: 
    - 官网：[https://www.serverless-devs.com/](https://www.serverless-devs.com/)
- 阿里云函数计算组件：
    - 仓库：[https://github.com/devsapp/fc](https://github.com/devsapp/fc)
    - 帮助文档：[https://www.serverless-devs.com/fc/readme](https://www.serverless-devs.com/fc/readme)
- 钉钉交流群：33947367    