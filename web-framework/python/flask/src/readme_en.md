# Flask case

<toc>

<p align="center"><b> <a href="./readme.md"> 中文 </a> | English </b></p>

- [Quick start](#Quick-start)
    - [Deploy via command line tool](#Deploy-via-command-line-tools)
- [Application details](#Application-details)
- [About Us](#About-Us)

</toc>

# Quick start

- [:octocat: source](https://github.com/devsapp/start-web-framework/tree/master/web-framework/python/flask/src)
- [:earth_africa: Effect Preview](http://flask.web-framework.1583208943291465.cn-shenzhen.fc.devsapp.net/)

## Deploy via command line tools

> Before starting, you need to install the Serverless Devs developer tools: `npm install @serverless-devs/s -g`, for more installation methods, please refer to [Serverless Devs Installation Documentation](https://www.serverless-devs.com/serverless-devs/install) , you also need to configure key information for Alibaba Cloud. For the method of configuring key information, please refer to [Alibaba Cloud Key Configuration Document](https://www.serverless-devs.com/fc/config)
- Initialize the project: `s init start-flask -d start-flask`
    > It involves determining the selection of the key, the determination of the service name, the determination of the function name, and the determination of the container image
- Enter the project: `cd start-flask`
- Deploy the project: `s deploy -y`
- Invoke： According to the returned `url` information, you can make a request in the browser

# Application details
This project is to deploy the very popular Flask framework in Python Web framework to Aliyun Serverless platform (Function Compute FC).

&gt; Flask is a lightweight Web application framework written in Python. Its WSGI toolbox uses Werkzeug, and the template engine uses Jinja2. Flask uses BSD authorization.

By Serverless Devs developer tools, you only need a few steps to experience the technical bonus of reducing costs and improving efficiency brought by Serverless architecture.

This case application is a very simple Hello World case. After the deployment is completed, you can see the case address returned to you by the system, for example:

![Picture alt](https://serverless-article-picture.oss-cn-hangzhou.aliyuncs.com/1644567788251_20220211082308412077.png)

At this time, open the case address and you can see the application details of the test:

![Picture alt](https://serverless-article-picture.oss-cn-hangzhou.aliyuncs.com/1644567807662_20220211082327817140.png)


# About Us
- Serverless Devs Tools:
    - Repository: [https://www.github.com/serverless-devs/serverless-devs](https://www.github.com/serverless-devs/serverless-devs)
      > Welcome to add a :star2:
    - Official website: [https://www.serverless-devs.com/](https://www.serverless-devs.com/)
- Alibaba Cloud Function Compute components:
    - Repository: [https://github.com/devsapp/fc](https://github.com/devsapp/fc)
    - Help document: [https://www.serverless-devs.com/fc/readme](https://www.serverless-devs.com/fc/readme)
- Dingding communication group: 33947367