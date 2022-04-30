readme = '''# {packageName} 帮助文档

<p align="center" class="flex justify-center">
    <a href="https://www.serverless-devs.com" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package={packageName}&type=packageType">
  </a>
  <a href="http://www.devsapp.cn/details.html?name={packageName}" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package={packageName}&type=packageVersion">
  </a>
  <a href="http://www.devsapp.cn/details.html?name={packageName}" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package={packageName}&type=packageDownload">
  </a>
</p>

<description>

{description}

</description>

<table>

{serviceTable}

</table>

<codepre id="codepre">

# 代码 & 预览

{codepre}

</codepre>

<deploy>

## 部署 & 体验

<appcenter>

- 🔥 通过 [Serverless 应用中心](https://fcnext.console.aliyun.com/applications/create?template={packageName}) ，
[![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://fcnext.console.aliyun.com/applications/create?template={packageName})  该应用。 

</appcenter>

- 通过 [Serverless Devs Cli](https://www.serverless-devs.com/serverless-devs/install) 进行部署：
    - [安装 Serverless Devs Cli 开发者工具](https://www.serverless-devs.com/serverless-devs/install) ，并进行[授权信息配置](https://www.serverless-devs.com/fc/config) ；
    - 初始化项目：\`s init {packageName} -d {packageName}\`   
    - 进入项目，并进行项目部署：\`cd {packageName} && s deploy -y\`

</deploy>

<appdetail id="flushContent">

# 应用详情

{appdetail}

</appdetail>

<devgroup>

## 开发者社区

您如果有关于错误的反馈或者未来的期待，您可以在 [Serverless Devs repo Issues](https://github.com/serverless-devs/serverless-devs/issues) 中进行反馈和交流。如果您想要加入我们的讨论组或者了解 FC 组件的最新动态，您可以通过以下渠道进行：

<p align="center">

| <img src="https://serverless-article-picture.oss-cn-hangzhou.aliyuncs.com/1635407298906_20211028074819117230.png" width="130px" > | <img src="https://serverless-article-picture.oss-cn-hangzhou.aliyuncs.com/1635407044136_20211028074404326599.png" width="130px" > | <img src="https://serverless-article-picture.oss-cn-hangzhou.aliyuncs.com/1635407252200_20211028074732517533.png" width="130px" > |
|--- | --- | --- |
| <center>微信公众号：\`serverless\`</center> | <center>微信小助手：\`xiaojiangwh\`</center> | <center>钉钉交流群：\`33947367\`</center> | 

</p>

</devgroup>'''

import os
import yaml

applicationPaths = [
    'example/django-blog/',
    'example/todolist-app/',
    'web-framework/java/springboot',
    'web-framework/nodejs/custom-runtime/egg',
    'web-framework/nodejs/custom-runtime/express',
    'web-framework/nodejs/custom-runtime/hapi',
    'web-framework/nodejs/custom-runtime/koa',
    'web-framework/nodejs/custom-runtime/midway-koa',
    'web-framework/nodejs/custom-runtime/next',
    'web-framework/nodejs/custom-runtime/nuxt-ssr',
    'web-framework/nodejs/nodejs-runtime/egg',
    'web-framework/nodejs/nodejs-runtime/connect',
    'web-framework/nodejs/nodejs-runtime/express',
    'web-framework/nodejs/nodejs-runtime/hapi',
    'web-framework/nodejs/nodejs-runtime/koa',
    'web-framework/nodejs/nodejs-runtime/nest',
    'web-framework/nodejs/nodejs-runtime/nuxt',
    'web-framework/nodejs/nodejs-runtime/thinkjs',
    'web-framework/php/discuz',
    'web-framework/php/ecshop',
    'web-framework/php/laravel',
    'web-framework/php/metinfo',
    'web-framework/php/thinkphp',
    'web-framework/php/typecho',
    'web-framework/php/whatsns',
    'web-framework/php/wordpress',
    'web-framework/php/zblog',
    'web-framework/python/bottle',
    'web-framework/python/django',
    'web-framework/python/fastapi',
    'web-framework/python/flask',
    'web-framework/python/pyramid',
    'web-framework/python/tornado',
    'web-framework/python/webpy'
]

for eveApplication in applicationPaths:
    with open(os.path.join(eveApplication, 'publish.yaml')) as f:
        yamlContent = f.read()
    publishyaml = yaml.safe_load(yamlContent)

    applicationName = publishyaml['Name']
    applicationDescription = publishyaml['Description']
    applicationVersion = publishyaml['Version']

    readme = readme.replace('{packageName}', applicationName)
    readme = readme.replace('{description}', applicationDescription)

    with open(os.path.join(eveApplication, 'readme.md')) as f:
        tempReadmemd = f.read()

    tempApplicationDetail = tempReadmemd.split('# 应用详情')[1].split("# 关于我们")[0]

    readme = readme.replace('{appdetail}', tempApplicationDetail)

    serviceTableHeader = '| 服务/业务 | '
    serviceTableCenter = '| --- | '
    serviceTableContent = '| 权限/策略 | '
    for eveService in publishyaml['Service']:
        serviceTableHeader = serviceTableHeader + eveService + " |  "
        serviceTableCenter = serviceTableCenter + " --- |  "
        serviceTableContent = serviceTableContent + '<br/>'.join(
            publishyaml['Service'][eveService]['Authorities']) + " |  "
    finalTable = '''## 前期准备
使用该项目，推荐您拥有以下的产品权限 / 策略：

%s   
%s 
%s''' % (serviceTableHeader, serviceTableCenter, serviceTableContent)

    readme = readme.replace('{serviceTable}', finalTable)

    source = '- [😼 源代码](%s)' % ('https://github.com/devsapp/start-fc/blob/main/' + eveApplication)

    readme = readme.replace('{codepre}', source)

    with open(os.path.join(eveApplication, 'readme.md'), 'w') as f:
        f.write(readme)

    with open(os.path.join(eveApplication, 'src/readme.md'), 'w') as f:
        f.write(readme)

    try:
        os.remove(os.path.join(eveApplication, 'readme_en.md'))
        os.remove(os.path.join(eveApplication, 'cloudshell.md'))
        os.remove(os.path.join(eveApplication, 'src/readme_en.md'))
    except Exception as e:
        print(e)

    versions = applicationVersion.split('.')
    versions[-1] = str(int(versions[-1]) + 1)

    yamlContent = yamlContent.replace(applicationVersion, '.'.join(versions))
    with open(os.path.join(eveApplication, 'publish.yaml'), 'w') as f:
        f.write(yamlContent)

with open('./update.list', 'w') as f:
    f.write('\n'.join(applicationPaths))
