import { Injectable } from '@nestjs/common';

@Injectable()
export class AppService {
  getHello(): string {
    return `<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>快速部署一个 Nest 应用</title>
  <style>
    * {
      padding: 0;
      margin: 0;
      font-family: arial;
    }
    a,
    a:visited {
      color: #0366d6;
      text-decoration: none;
    }
    
    header {
      color: #f0f0f0;
      padding: 16px 16px 40px 16px;
      background-image: linear-gradient(to right, #2938fd, #4190FF);
      font-size: 14px;
    }
    ul, li {
      font-size: 14px;
    }
    header .header {
      display: flex;
      justify-content: space-between;
      text-align: center;
      color: #fff;
    }
    
    header .header a {
      color: #fff;
    }
    header img {
      width: 100px;
    }
    h1 {
      font-size: 36px;
      color: #fff;
      font-weight: normal;
    }
    
    code {
      padding: 2px 4px;
      font-size: 90%;
      color: #c7254e;
      background-color: #f9f2f4;
      border-radius: 4px;
    }
    
    .content {
      width: 1000px;
      margin: auto
    }
    
    .button {
      box-sizing: border-box;
      display: inline-block;
      height: 48px;
      line-height: 48px;
      min-width: 140px;
      font-family: Avenir-Heavy;
      color: #fff;
      text-align: center;
      border-radius: 4px;
      text-decoration: none;
    }
    
    .button-primary {
      background: #4190FF;
    }
    
    .wrap {
      width: 1000px;
      margin: 16px auto auto;
    }
    
    .wrap p {
      margin: 16px 0;
      font-size: 14px;
    }
    
    .wrap a{
      color: #fff;
    }
    
    .content {
      margin-top: 80px;
    }
    
    .list {
      width: 800px;
    }
    
    .list .item {
      position: relative;
      padding-left: 70px;
      margin-top: 50px;
    }
    
    .list .item .step {
      position: absolute;
      width: 36px;
      height: 36px;
      top: -3px;
      left: 0;
      border: 5px solid #4a6495;
      border-radius: 23px;
      text-align: center;
      line-height: 36px;
    }
    
    .list .item h2 {
      font-size: 24px;
      font-weight: normal;
    }
    
    .list .item p {
      line-height: 30px;
      margin-top: 10px;
      color: #777
    }
    
    .list .item .container {
      padding: 20px 0;
      font: 14px;
    }
    
    .list .item .container h3 {
      font-weight: 500;
      margin: 16px 0 8px 0;
    }
    
    .list .item .container pre {
      color: #777;
      background-color: #f0f0f0;
      padding: 8px;
    }
    
    .list .item .container ul {
      list-style: disc;
      padding: 0 20px;
    }
  </style>
</head>

<body>
    <header>
      <div class="header">
        <img src="http://www.serverless-devs.com/img/sdLogo.png" />
        <div>
          <a href="https://github.com/devsapp/nodejs-runtime-framework-application/tree/master/nest-app/src" target="_blank">
            <svg class="w-6 h-6 text-gray-600 hover:text-gray-800" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="32" height="32" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M12 2.247a10 10 0 0 0-3.162 19.487c.5.088.687-.212.687-.475c0-.237-.012-1.025-.012-1.862c-2.513.462-3.163-.613-3.363-1.175a3.636 3.636 0 0 0-1.025-1.413c-.35-.187-.85-.65-.013-.662a2.001 2.001 0 0 1 1.538 1.025a2.137 2.137 0 0 0 2.912.825a2.104 2.104 0 0 1 .638-1.338c-2.225-.25-4.55-1.112-4.55-4.937a3.892 3.892 0 0 1 1.025-2.688a3.594 3.594 0 0 1 .1-2.65s.837-.262 2.75 1.025a9.427 9.427 0 0 1 5 0c1.912-1.3 2.75-1.025 2.75-1.025a3.593 3.593 0 0 1 .1 2.65a3.869 3.869 0 0 1 1.025 2.688c0 3.837-2.338 4.687-4.563 4.937a2.368 2.368 0 0 1 .675 1.85c0 1.338-.012 2.413-.012 2.75c0 .263.187.575.687.475A10.005 10.005 0 0 0 12 2.247z" fill="#fff" /></svg>
            <p>Github</p>
          </a>
        </div>
      </div>
      <div class="wrap">
        <h1>快速部署一个 Nest 应用</h1>
      </div>
      <div class="wrap">
      <p>Serverless Devs 是一个开源开放的 Serverless 开发者平台，致力于为开发者提供强大的工具链体系。通过该平台，开发者可以一键体验多云 Serverless 产品，极速部署 Serverless 项目。</p>
      <a class="button button-primary" href="http://www.serverless-devs.com/zh-cn/index.html" target="_blank">Serverless Devs</a>
      </div>
    </header>
    <div class="content">
      <div class="list">
        <div class="item">
          <div class="step">1</div>
          <h2>介绍</h2>
          <p>这是一个 <code>Nest</code> 应用示例，可以通过 <code>Serverless Devs</code> 工具将项目一键部署到云开发环境</p>
      </div>
      <div class="item">
        <div class="step">2</div>
        <h2>文档</h2>
        <p>NestJS 官方在线文档，参见 <a
             href="https://nestjs.com/" target="_blank">https://nestjs.com/</a>.</p>
      </div>
      <div class="item">
        <div class="step">3</div>
        <h2>快速部署一个 Nest 应用</h2>
        <div class="container">
          <div>
            <h3>步骤一. 准备工作</h3>
            <p>具体步骤请参照 <a href="http://www.serverless-devs.com/zh-cn/docs/installed/cliinstall.html" target="_blank"> Serverless Cli 安装</a></p>
            <h3>步骤二. 初始化应用示例</h3>
            <pre>s init nest-app</pre>
            <h3>步骤三. 一键部署</h3>
            <p>进入到项目目录，在命令行执行</p>
            <pre>s deploy</pre>
            <h3>帮助文档</h3>
            <ul>
              <li>
                <a href="https://github.com/Serverless-Devs/Serverless-Devs"
                   target="_blank">Serverless Devs 开发部署工具</a>
              </li>
              <li>
                <a href="https://github.com/Serverless-Devs/docs/blob/master/zh/install.md"
                   target="_blank">工具安装文档</a>
              </li>
              <li>
                <a href="https://github.com/Serverless-Devs/docs/blob/master/zh/command.md"
                   target="_blank">命令行指令文档</a>
              </li>
              <li>
                <a href="https://github.com/Serverless-Devs/docs/blob/master/zh/yaml.md"
                   target="_blank">Yaml 规范文档</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
</body>

</html>`;
  }
}
