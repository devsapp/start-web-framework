# Todolist 案例

> 快速部署和体验Serverless架构下的 TodoList 项目

- [体验前准备](#体验前准备)
- [代码与预览](#代码与预览)
- [快速部署和体验](#快速部署和体验)
    - [在线快速体验](#在线快速体验)
    - [在本地部署体验](#在本地部署体验)
- [项目使用注意事项](#项目使用注意事项)
- [操作介绍](#操作介绍)

## 体验前准备

该应用案例，需要您开通[阿里云函数计算](https://fcnext.console.aliyun.com/) 产品；并建议您当前的账号有一下权限存在`FCDefaultRole`。

## 代码与预览

- [:octocat: 源代码](https://github.com/devsapp/start-web-framework/tree/master/example/todolist-app/src)

## 快速部署和体验
### 在线快速体验

- 通过阿里云 **Serverless 应用中心**： 可以点击 [【🚀 部署】](https://fcnext.console.aliyun.com/applications/create?template=todolist-app) ，按照引导填入参数，快速进行部署和体验。

### 在本地部署体验

1. 下载安装 Serverless Devs：`npm install @serverless-devs/s` 
    > 详细文档可以参考 [Serverless Devs 安装文档](https://github.com/Serverless-Devs/Serverless-Devs/blob/master/docs/zh/install.md)
2. 配置密钥信息：`s config add`
    > 详细文档可以参考 [阿里云密钥配置文档](https://github.com/devsapp/fc/blob/main/docs/zh/config.md)
3. 初始化项目：`s init todolist-app -d todolist-app`
4. 进入项目并部署：`cd todolist-app && s deploy`

> 在本地使用该项目时，不仅可以部署，还可以进行更多的操作，例如查看日志，查看指标，进行多种模式的调试等，这些操作详情可以参考[函数计算组件命令文档](https://github.com/devsapp/fc#%E6%96%87%E6%A1%A3%E7%9B%B8%E5%85%B3) ;

## 项目使用注意事项

1. 项目Yaml中，声明了`actions`，其对应的命令为`npm install --production`，如果在使用项目时，遇到类似找不到`npm`命令的情况，请根据自身电脑关于`nodejs`与`nmp`的配置对此出进行修改，或者手动进行依赖安装，并注释掉这`actions`部分代码；
2. 目前函数计算支持的项目代码包大小为100M，如果一个完整的项目依赖包过大，可以按照以下方法进行优化和处理：
    - 将部分静态资源等，放在对象存储中，以降低代码包的体积；
    - 将 `nasConfig` 配置为 `auto`，然后基于 nas 指令将大文件（可能是训练集/依赖包）传输到 NAS 指定位置，然后配置相应的环境变量到 `s.yml` 中的函数配置中；
    - 将非 custom-container 的函数转换成 custom-container，这需要对代码进行一定的改造，并新增 dockerfile，然后创建这个函数（此方式冷启动时间相对其他 runtime 会有一点点的延长）；

## 操作介绍

更多使用内容：
 - [本地构建](#本地构建)
 - [调试](#调试)
   - [端云联调](#端云联调)
   - [本地调试](#本地调试)
 - [部署](#部署)
 - [查看日志](#查看日志)
 - [对服务进行访问](#对服务进行访问)
 - [可观测性](#可观测性)
 - [发布](#发布)
 - [CICD](#CICD)
 - [删除](#删除)
 
> 权限与Yaml配置可以参考 [FC Yaml 规范文档](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/yaml.md)
 
### 本地构建

本案例为 nodejs runtime，因此构建过程实际上是进行了安装依赖的操作，可以使用如下三种方式进行构建：

```bash
# 方式一，基于 npm 原生指令进行构建
$ npm install

# 方式二，基于 Serverless Devs fc 组件，依赖于本机的 nodejs 环境进行构建，构建产物保存在 .s 目录下
$ s build

# 方式三，基于 Serverless Devs fc 组件，需要安装 docker，依赖函数计算官方镜像的 nodejs 环境进行构建，构建产物保存在 .s 目录下
$ s build --use-docker
```

### 调试

调试目前只支持本地，有两种类型：

1. 本地调试： 本地启动函数容器，调用请求由本地发起，无法访问 vpc 内网以及一些云服务的内网地址。
2. 端云联调： 本地启动函数容器，调用请求来自线上，可以访问 vpc 内网以及一些云服务的内网地址。

#### 端云联调

端云联调需要如下几种前置条件:

1. 开通[阿里云镜像服务](https://cr.console.aliyun.com/)
2. 开通[阿里云日志服务](https://sls.console.aliyun.com/)
3. 安装 docker

可以通过 proxied 系列指令，快速进行端云联调操作:

```bash
# 设置环境变量 DISABLE_BIND_MOUNT_TMP_DIR，用于关闭本地函数容器挂载本机目录到 /tmp 的能力

# For Windows
$ set DISABLE_BIND_MOUNT_TMP_DIR=true
# For Macos
$ export DISABLE_BIND_MOUNT_TMP_DIR=true

# 启动准备环境和辅助资源
$ s proxied setup --config vscode --debug-port 3000
```

`setup` 执行完后会阻塞住，此时需要重新打开一个终端执行调用请求：

```bash
$ s proxied invoke
```

此时本地函数就会被调用，而调用的返回结果只是一段 html 内容，此时不会执行 html 中发出的请求。这是因为端云联调的调用请求得到的 html 内容只能以文本形式返回，并不会执行 html 中请求静态页面的内容。

在 `setup` 时我们已经增加了 `--config vscode --debug-port 3000` 参数，这两个参数用于 vscode 断点调试，因此我们可以通过如下步骤进行断点调试。

1. 给源代码打上断点
2. 启动调试器
   ![img](https://img.alicdn.com/imgextra/i1/O1CN01sE914X1IBdKZMlqgN_!!6000000000855-2-tps-3572-2238.png)
3. 在终端执行 `s proxied invoke` 指令

在端云联调完成后，需要执行 `s proxied clean` 指令来清理本地环境以及辅助资源。

#### 本地调试

本示例是 http 函数，因此使用 `local start` 指令来进行本地调试，若是 event 函数，需要使用 `local invoke`
 指令来进行调试，详情请参考[这里](https://github.com/devsapp/fc/blob/main/docs/Usage/local.md)。

```bash
# 设置环境变量 DISABLE_BIND_MOUNT_TMP_DIR，用于关闭本地函数容器挂载本机目录到 /tmp 的能力

# For Windows
$ set DISABLE_BIND_MOUNT_TMP_DIR=true
# For Macos
$ export DISABLE_BIND_MOUNT_TMP_DIR=true

# 启动本地调试
$ s local start
[2021-07-23T11:25:43.197] [INFO ] [S-CLI] - Start ...
[2021-07-23T11:25:45.473] [INFO ] [FC-LOCAL-INVOKE] - Using trigger for start: name: http-trigger
type: http
config:
  authType: anonymous
  methods:
    - GET
    - POST

[2021-07-23T11:25:45.477] [INFO ] [FC-LOCAL-INVOKE] - HttpTrigger http-trigger of todo-list-service/todo-list was registered
        url: http://localhost:7901/2016-08-15/proxy/todo-list-service/todo-list/
        methods: GET,POST
        authType: anonymous

Tips：you can also use these commands to run/debug custom domain resources:

Start with customDomain: 
* s local start auto

Debug with customDomain: 
* s local start -d 3000 auto


Tips for next step
======================
* Deploy Resources: s deploy
TodoList:
  status: succeed

function compute app listening on port 7901!
```

此时访问上述 `url: http://localhost:7901/2016-08-15/proxy/todo-list-service/todo-list/` 字段即可访问本地启动的函数服务。

若要进行断点调试，需要给 `local start` 指令增加如下参数：

```bash
$ s local start --config vscode --debug-port 3000
```

断点调试模式下，可以通过如下步骤进行断点调试。

1. 给源代码打上断点
2. 启动调试器
   ![img](https://img.alicdn.com/imgextra/i1/O1CN01sE914X1IBdKZMlqgN_!!6000000000855-2-tps-3572-2238.png)
3. 访问上述 `url: http://localhost:7901/2016-08-15/proxy/todo-list-service/todo-list/`

### 部署

接下来我们可以进行部署操作。

```bash
$ s deploy
```

若发现配置有问题，可以修改对应的配置，然后利用 `deploy` 指令只部署修改后的配置，例如我们这里可以修改 s.yml 中函数的 `description` ，然后只部署函数配置:

```bash
$ s deploy function --type config
```

部署完成后，我们需要保存返回的 `url` 字段，供后续调用使用。

此外，我们可以通过 `info` 指令来获取部署后的资源信息。

```bash
# 查看部署后的资源信息
$ s info
```

### 查看日志

利用 `logs` 指令能实时查看函数生成的日志，但是得在 s.yml 中的 `service` 下配置 `logConfig` 字段。本示例中已经配置了 `logConfig: auto`，这会在账号下自动生成一个 logproject 和 logstore，因此需要有对应的权限。

```bash
# 实时查看日志
$ s logs -t

# 查看某一时间段内的日志
$ s logs -s 2021-07-22T12:00:00+08:00 -e 2021-07-23T10:00:00+08:00
```

### 对服务进行访问

服务部署完成后，可以直接通过 `s invoke` 对线上服务发起调用，查看服务是否运行正常。也可以对线上服务进行压力测试：

```bash
# 调用函数
$ s invoke

# 压力测试
$ s cli fc stress start --num-user 6 --spawn-rate 10 --run-time 30 --function-type http --url xxx --region cn-hangzhou
```

压力测试后会返回简单的压测结果信息，若要查看详细的汇报信息，请打开生成的 html 文件:

```bash
Html report flie: /Users/zqf/.s/cache/fc-stress/html/url#2021-07-23T09-59-41.html
Execute 'open /Users/zqf/.s/cache/fc-stress/html/url#2021-07-23T09-59-41.html' on macos for html report with browser.
Average: 17
Fails: 0
Failures/s: 0
Max: 10111
Method: GET
Min: 7
Name: /
RPS: 333
Requests: 9989
p50: 13
p60: 14
p70: 16
p90: 21
p95: 25
p99: 43
```

### 可观测性

通过 `metrics` 指令来查看函数的运行指标:

```bash
$ s metrics
[2021-07-23T10:21:29.023] [INFO ] [S-CLI] - Start ...
[2021-07-23T10:21:30.444] [INFO ] [FC-METRICS] - Creating serivce: Metrics start...
End of method: metrics
[2021-07-23T10:21:30.625] [INFO ] [FC-METRICS] - Getting domain: http://localhost:3000, 请用浏览器访问Uri地址进行查看
```

`s metrics` 指令会返回上述 url，访问该 url 就可以查看函数的指标信息。

### 发布

上述测试完成后，可以进行发布操作：

```bash
# 发布版本
$ s version publish --description 'this is a version 1'

# 发布别名
$ s alias publish --alias-name testAlias --version 1
```

发布完成后，可以查看已经发布的版本/别名。

```bash
# 查看已经发布的版本信息
$ s version list --table
s
# 查看已经发布的别名
$ s alias list --table
```

### CICD

若要想要将上述流程在自动化，可以选择 cicd 组件来生成 cicd 模版，目前支持生成 Github Action 模版和 Gitee Go 模版。以 Github Action 为例。

```bash
# 初始化 Github Action 模版
$ s cli cicd github
```

上述指令会在当前项目下生成 .github/workflows/serverless-devs.yml 文件，文件内容：

```yaml
name: Serverless Devs Project CI/CD

on:
  push:
    branches: [ main ]

jobs:
  serverless-devs-cd:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - uses: actions/setup-node@v2
        with:
          node-version: 12
          registry-url: https://registry.npmjs.org/
      - run: npm install
      - run: npm install -g @serverless-devs/s
      # 默认密钥配置指令是阿里云密钥配置指令，更多可以参考：
      # 如何通过Github Action使用Serverless Devs做CI/CD：http://short.devsapp.cn/cicd/github/action/usage
      # Serverless Devs的官网是通过Serverless Devs部署的: http://short.devsapp.cn/cicd/github/action/practice
      - run: s config add --AccountID ${{secrets.AccountID}} --AccessKeyID ${{secrets.AccessKeyID}} --AccessKeySecret ${{secrets.AccessKeySecret}} -a default
      - run: s deploy
```

此时 push 到 main 分支的操作会触法上述流程，目前流程主要只会执行 `s deploy` 操作，若需要进行其他操作，需要手工添加 `- run: ${command}` 即可。

注：需要将阿里云密钥信息设置在对应 repo 中的 `Secrets` 中，包括： AccountID、AccessKeyID 和 AccessKeySecret 三个变量。

### 删除

最后，我们可以通过 `s remove service` 指令来删除上述部署的资源。


-------

> - Serverless Devs 项目：https://www.github.com/serverless-devs/serverless-devs   
> - Serverless Devs 文档：https://www.github.com/serverless-devs/docs   
> - Serverless Devs 钉钉交流群：33947367    
