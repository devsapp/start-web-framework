# 阿里云函数计算：django-blog

通过该应用，您可以简单快速的创建一个Django Blog到阿里云函数计算服务。

- 下载命令行工具：`npm install -g @serverless-devs/s`
- 初始化一个模版项目：`s init django-blog`
- 【如果要配置Mysql，否则自动使用Sqlite】对数据库等进行配置，在`./ServerlessBlog/settings.py`文件中，70行的位置，对数据库等进行配置：
    ```python
    DATABASES = {
        'default': {
            'ENGINE': 'django.db.backends.mysql',
            'NAME': '',
            'USER': '',
            'PASSWORD': '',
            'HOST': '',
            'PORT': 3306,
        }
    }
    ```
- 进入项目后部署项目：`s deploy`

关于初始化管理员等操作，可以参考Django框架的开发指南： https://docs.djangoproject.com/en/3.2/

> 运行出错：ImportError: cannot import name 'metadata' from 'importlib'的解决方法：https://stackoverflow.com/questions/59216175/importerror-cannot-import-name-metadata-from-importlib

## 相关命令

由于该框架直接部署在阿里云函数计算平台，所以可以参考函数计算组件相关的命令：

| 构建&部署 | 可观测性 | 调用&调试 |  发布&配置  |  其他功能 |
| --- | --- | --- |--- | --- |
| [**部署 deploy**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/deploy.md)   | [指标查询 metrics](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/metrics.md) | [**本地调用 local**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/local.md)      | [**版本 version**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/version.md)      | [**硬盘挂载 nas**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/nas.md) | 
| [**构建 build**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/build.md)     | [日志查询 logs](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/logs.md)       | [远程调用 invoke](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/invoke.md)    | [**别名 alias**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/alias.md)         | [计划变更 plan](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/plan.md)  | 
| [移除 remove](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/remove.md)   |                                              | [**端云联调 proxied**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/proxied.md) | [预留 provision](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/provision.md)   | [查看函数 info](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/info.md)  | 
|                                          |                                              | [远程调试 remote](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/remote.md)    | [按量资源 ondemand](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/ondemand.md) |[**资源同步 sync**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/sync.md)  | 
|                                          |                                              | [内存&并发度探测 eval](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/eval.md)  | [层 layer](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/layer.md) |      [压测 stress](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/stress.md)               | 
|                                          |                                              |   |  | [API调用 api](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/api.md)                     | 
|                                          |                                              |   |  |  [Fun项目迁移 fun2s](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/fun2s.md)                   | 

-----

> - Serverless Devs 项目：https://www.github.com/serverless-devs/serverless-devs   
> - Serverless Devs 文档：https://www.github.com/serverless-devs/docs   
> - Serverless Devs 钉钉交流群：33947367    
