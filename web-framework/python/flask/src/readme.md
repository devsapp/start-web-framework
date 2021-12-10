# 阿里云 Flask 框架案例

- [快速体验](#快速体验)
- [相关命令](#相关命令)
- [依赖过大部署方案](#依赖过大部署方案)
- [最佳实践案例](#最佳实践案例)
    - [通过Container进行部署](#通过Container进行部署)

## 快速体验

- 初始化项目：`s init start-flask`
- 进入项目后部署：`s deploy`
- 部署过程中可能需要阿里云密钥的支持，部署完成之后会获得到临时域名可供测试

> 权限与Yaml配置可以参考 [FC Yaml 规范文档](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/yaml.md)

> * 额外说明：s.yaml中声明了actions：    
>    部署前执行：pip3 install -r requirements.txt -t .   
>   如果遇到pip3命令找不到等问题，可以适当进行手动项目构建，并根据需要取消actions内容     
> * 项目初始化完成，您可以直接进入项目目录下，并使用 s deploy 进行项目部署

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

## 依赖过大部署方案

函数计算的接口本身默认只支持 50M 的代码包，如果想要部署超过 50M 的代码包，可以考虑：

1. (50M, 100M] 范围内的代码包，可以：
    - 指定 `s.yml` 中的 `ossBucket` 字段(需要是已存在的 Bucket 并且需要和服务同地域)，此时通过工具进行部署时，工具会把代码压缩上传到这个指定的 Bucket，然后通过OSS的配置方式部署函数；
    - 手动将代码压缩上传到对象存储，然后在 `s.yaml` 中指定 `ossBucket` 和 `ossKey` 字段，此时部署函数时，工具会直接通过OSS的配置方式部署函数；
2. 大于 100M 的代码包，可以：
    - 将 `nasConfig` 配置为 `auto`，然后基于 nas 指令将大文件（可能是训练集/依赖包）传输到 NAS 指定位置，然后配置相应的环境变量到 `s.yml` 中的函数配置中；
    - 将非 custom-container 的函数转换成 custom-container，这需要对代码进行一定的改造，并新增 dockerfile，然后创建这个函数（此方式冷启动时间相对其他 runtime 会有一点点的延长）；
    
### 最佳实践案例

#### 通过Container进行部署

1. 在项目下，创建Dockerfile文件，例如：
    ```dockerfile
    FROM python:3.6.3-slim
    
    WORKDIR /home/code
    COPY . .
    ```
2. 编写资源描述文件（`s.yaml`）：
    ```yaml
    # Yaml参考文档：https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/yaml.md
    edition: 1.0.0          #  命令行YAML规范版本，遵循语义化版本（Semantic Versioning）规范
    name: framework         #  项目名称
    access: "{{ access }}"       #  秘钥别名
    
    services:
      framework: # 业务名称/模块名称
        component: fc  # 组件名称
        actions:
          pre-deploy: # 在deploy之前运行
            - run: pip3 install -r requirements.txt -t .  # 要运行的命令行
              path: ./code # 命令行运行的路径
            - run: s build --use-docker
              path: ./code
        props: # 组件的属性值
          region: cn-beijing
          service:
            name: web-framework
            description: 'Serverless Devs Web Framework Service'
          function:
            name: flask
            description: 'Serverless Devs Web Framework Flask Function'
            codeUri: './code'
            runtime: custom-container
            timeout: 60
            caPort: 9000
            customContainerConfig:
              image: 'registry.cn-beijing.aliyuncs.com/custom-container/web-framework:0.0.1'    # 需要替换为自己的镜像地址，或者自己目标的镜像地址，需要开通阿里云容器镜像服务等
              command: '["./bootstrap"]'
          triggers:
            - name: httpTrigger
              type: http
              config:
                authType: anonymous
                methods:
                  - GET
          customDomains:
            - domainName: auto
              protocol: HTTP
              routeConfigs:
                - path: '/*'
    ```
3. 进行项目的一键部署：`s deploy --use-local -y`，此时系统就可以自动安装依赖、构建镜像，并将业务以Container形式部署到线上

-----

> - Serverless Devs 项目：https://www.github.com/serverless-devs/serverless-devs   
> - Serverless Devs 文档：https://www.github.com/serverless-devs/docs   
> - Serverless Devs 钉钉交流群：33947367    