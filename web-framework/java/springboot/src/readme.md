# start-springboot 帮助文档

这是函数计算平台的一个springboot+custom runtime开发的脚手架，内置了完整的函数描述文件以及流水线配置，可以在本地以及Devs平台上一键部署，并完成函数的后续开发、构建、部署以及调试功能。

## 前期准备

1. 安装并学会使用Git工具。
2. 拥有阿里云的账号，并开通函数计算产品，并保证有足够的余额使用函数计算产品。

+ 云上开发（推荐）

  推荐在云上开发，可以省去本地环境的搭建过程，只需要赋予Devs平台足够的权限即可完成自动构建发布。

+ 本地开发

  如果需要在本地完成开发、构建，需要以下工作。
    + 完成Docker安装。
    + 完成s工具安装与配置。
    + 完成Java环境的初始化，默认为Java11。

云上开发需要为Devs平台赋予以下权限，本地开发需要为s工具配置的账号或角色赋予以下权限。

| 服务/业务 | 函数计算                |     
|-------|---------------------|   
| 权限/策略 | AliyunFCFullAccess  |  
| 权限/策略 | AliyunOSSFullAccess |

## 部署&体验

1. 云上部署（推荐）

将代码push到远程仓库，通过Devs平台找到相关流水线点击确认后，自动完成部署。

2. 本地构建+部署

在本地根路径执行下列命令或使用Maven工具直接进行构建.

```shell
 cd ./code && bash build.sh && cd ../
```

在本地根路径执行下列命令进行一键部署。

```shell
s deploy --use-local --skip-push --assume-yes
```

# 应用详情

1. web类型，返回静态或动态网页。

查看示例[文件](code/src/main/java/com/example/webframework/application/http/IndexController.java)，学习如何返回静态或动态网页类型。

访问域名根路径，如：http://{分配域名}.fc.devsapp.net/，即可看到返回的网页。

2. 查看http请求详情。

查看示例[文件](code/src/main/java/com/example/webframework/application/http/DebugController.java)
，学习如何查看http请求上下文详情，学习从请求以及环境变量中获取上下文信息。

访问域名相对路径`/debug/displayHttpContext`，如http://{分配域名}.fc.devsapp.net/debug/displayHttpContext，即可看到返回的http请求上下文详情。

3. 学习访问其他云产品。

查看示例[文件](code/src/main/java/com/example/webframework/application/http/OssController.java)，学习如何访问其他云产品。

访问域名相对路径`/oss/listBuckets`，如http://{分配域名}.fc.devsapp.net/loss/listBuckets，即可看到返回的oss桶列表。

## 如何开发

//TODO 回答客户在这个案例基础上开发的问题。

### 切换java版本

开发web类型函数时，推荐使用custom runtime进行开发。custom runtime的说明可以参加文档。TODO
结合公共层技术（链接TODO），可以在函数计算场景切换java版本，方式如下。

#### 修改maven配置文件

在[pom](code/pom.xml)中第11行修改maven构建配置配置。

TODO: 低版本的springboot对高版本的jdk17有兼容性问题，使用jdk17时需要切换springboot到更高版本。

#### 修改云上运行环境配置

修改[文件](s.yaml)
中的path、javaHome、javaLayers配置，详见[文档](https://help.aliyun.com/zh/functioncompute/user-guide/configure-common-layers-for-a-function?#p-dmq-hai-qq7)。

| 语言     | runtime         | path                                                                                                 | javaHome    | javaLayers                                              |      
|--------|-----------------|------------------------------------------------------------------------------------------------------|-------------|---------------------------------------------------------| 
| java8  | custom.debian10 | /opt/java8/bin:/usr/local/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/opt/bin  | /opt/java8  | acs:fc:${vars.region}:official:layers/Java8/versions/1  |
| java11 | custom          | /opt/java11/bin:/usr/local/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/opt/bin | /opt/java11 | acs:fc:${vars.region}:official:layers/Java11/versions/2 |
| java17 | custom          | /opt/java17/bin:/usr/local/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/opt/bin | /opt/java17 | acs:fc:${vars.region}:official:layers/Java17/versions/2 |

### 修改云上构建环境

修改[文件](cd.yaml)中的第50行关于runtime-setup插件的配置。
| 语言 | @serverless-cd/runtime-setup插件 |
|--------|----------------------|
| java8 | java8 |
| java11 | java11 |
| java17 | java17 |


### 依赖添加

在pom文件中直接添加依赖描述即可。

## 本地开发、调试

## 线上流水线运行说明


## 常见问题的FAQ

## 开发者社区

您如果有关于错误的反馈或者未来的期待，您可以在 [Serverless Devs repo Issues](https://github.com/serverless-devs/serverless-devs/issues)
中进行反馈和交流。