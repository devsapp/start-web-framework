# Django case

<toc>

<p align="center"><b> <a href="./readme.md"> 中文 </a> | English </b></p>

- [Quick start](#Quick-start)
    - [Deploy via command line tool](#Deploy-via-command-line-tools)
- [Application details](#Application-details)
- [About Us](#About-Us)

</toc>

# Quick start

- [:octocat: source](https://github.com/devsapp/start-web-framework/tree/master/web-framework/python/django/src)
- [:earth_africa: Effect Preview](http://django.web-framework.1583208943291465.cn-shenzhen.fc.devsapp.net/)

## Deploy via command line tools

> Before starting, you need to install the Serverless Devs developer tools: `npm install @serverless-devs/s -g`, for more installation methods, please refer to [Serverless Devs Installation Documentation](https://www.serverless-devs.com/serverless-devs/install) , you also need to configure key information for Alibaba Cloud. For the method of configuring key information, please refer to [Alibaba Cloud Key Configuration Document](https://www.serverless-devs.com/fc/config)
- Initialize the project: `s init start-django -d start-django`
    > It involves determining the selection of the key, the determination of the service name, the determination of the function name, and the determination of the container image
- Enter the project: `cd start-django`
- Deploy the project: `s deploy -y`
- Invoke： According to the returned `url` information, you can make a request in the browser

# Application details

This project is to deploy the very popular Django framework in Python Web framework to Aliyun Serverless platform (Function Compute FC).

&gt; Django is an open source Web application framework written by Python. The frame mode of MTV is adopted, namely model M, view V and template T. It was originally developed to manage some news content-based websites under the Lawrence Publishing Group, namely CMS (Content Management System) software. It was released under the BSD license in July 2005. This set of frames is named after the Gypsy Jazz guitarist Django Reinhardt of Belgium. Published by Django 3.0 on 2 December 2019

By Serverless Devs developer tools, you only need a few steps to experience the technical bonus of reducing costs and improving efficiency brought by Serverless architecture.

This case application is a very simple Hello World case. After the deployment is completed, you can see the case address returned to you by the system, for example:

![Picture alt](https://serverless-article-picture.oss-cn-hangzhou.aliyuncs.com/1644567419851_20220211081700122623.png)

At this time, open the case address and you can see the application details of the test:

![Picture alt](https://serverless-article-picture.oss-cn-hangzhou.aliyuncs.com/1644567448674_20220211081728869982.png)

Of course, in addition to such a Django Hello World, we also have a [blog case based on Django framework](https://github.com/devsapp/start-web-framework/tree/master/example/django-blog/src) for learning and reference.


# About Us
- Serverless Devs Tools:
    - Repository: [https://www.github.com/serverless-devs/serverless-devs](https://www.github.com/serverless-devs/serverless-devs)
      > Welcome to add a :star2:
    - Official website: [https://www.serverless-devs.com/](https://www.serverless-devs.com/)
- Alibaba Cloud Function Compute components:
    - Repository: [https://github.com/devsapp/fc](https://github.com/devsapp/fc)
    - Help document: [https://www.serverless-devs.com/fc/readme](https://www.serverless-devs.com/fc/readme)
- Dingding communication group: 33947367