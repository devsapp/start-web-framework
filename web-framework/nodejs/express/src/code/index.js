var express = require('express');

var app = express();

app.get('*', (req, res) => {
    res.header('Content-Type', 'text/html;charset=utf-8')
    console.log('test');

    res.send(`<!DOCTYPE html>
    <html>
    
    <head>
      <meta charset="UTF-8">
      <title>快速部署一个 Express 应用</title>
      <link rel="stylesheet" href="https://serverless-devs-app-pkg.oss-cn-beijing.aliyuncs.com/web-framework-demo.css" />
    </head>
    
    <body>
    <header>
    <div class="header">
      <img class="logo" src="https://img.alicdn.com/imgextra/i4/O1CN01Qg3e7H1WlGp5th8J6_!!6000000002828-2-tps-400-400.png" />
      <div>
        <a href="https://github.com/devsapp/start-web-framework/tree/master/web-framework/nodejs/express/src" target="_blank">
          <svg class="w-6 h-6 text-gray-600 hover:text-gray-800" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="32" height="32" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M12 2.247a10 10 0 0 0-3.162 19.487c.5.088.687-.212.687-.475c0-.237-.012-1.025-.012-1.862c-2.513.462-3.163-.613-3.363-1.175a3.636 3.636 0 0 0-1.025-1.413c-.35-.187-.85-.65-.013-.662a2.001 2.001 0 0 1 1.538 1.025a2.137 2.137 0 0 0 2.912.825a2.104 2.104 0 0 1 .638-1.338c-2.225-.25-4.55-1.112-4.55-4.937a3.892 3.892 0 0 1 1.025-2.688a3.594 3.594 0 0 1 .1-2.65s.837-.262 2.75 1.025a9.427 9.427 0 0 1 5 0c1.912-1.3 2.75-1.025 2.75-1.025a3.593 3.593 0 0 1 .1 2.65a3.869 3.869 0 0 1 1.025 2.688c0 3.837-2.338 4.687-4.563 4.937a2.368 2.368 0 0 1 .675 1.85c0 1.338-.012 2.413-.012 2.75c0 .263.187.575.687.475A10.005 10.005 0 0 0 12 2.247z" fill="#fff" /></svg>
          <p>Github</p>
        </a>
      </div>
    </div>
    <div class="wrap">
      <h1>快速部署一个 Express 应用</h1>
    </div>
    <div class="wrap">
    <p>Serverless Devs 是一个开源开放的 Serverless 开发者平台，致力于为开发者提供强大的工具链体系。通过该平台，开发者可以一键体验多云 Serverless 产品，快速部署 Serverless 项目。</p>
    <a class="button button-primary" href="http://www.serverless-devs.com" target="_blank">Serverless Devs</a>
    </div>
  </header>
      <div class="content">
        <div class="list">
          <div class="item">
            <div class="step">1</div>
            <h2>介绍</h2>
            <p>这是一个 <code>Express</code> 应用示例，可以通过 Serverless Devs 工具将项目一键部署到云开发环境</p>
          </div>
          <div class="item">
            <div class="step">2</div>
            <h2>文档</h2>
            <p>Express 官方在线文档，参见 <a href="https://expressjs.com/zh-cn/" target="_blank">https://expressjs.com/zh-cn/</a></p>
          </div>
          <div class="item">
            <div class="step">3</div>
            <h2>快速部署一个 Express 应用</h2>
            <div class="container">
              <div>
                <h3>步骤一. 准备工作</h3>
                <p>具体步骤请参照 <a href="https://github.com/Serverless-Devs/Serverless-Devs/blob/master/docs/zh/install.md" target="_blank"> Serverless Cli 安装</a></p>
                <h3>步骤二. 初始化应用示例</h3>
                <pre>s init start-express</pre>
                <h3>步骤三. 一键部署</h3>
                <p>进入到项目目录，在命令行执行</p>
                <pre>s deploy</pre>
                <h3>帮助文档</h3>
                <ul>
                  <li>
                    Serverless Devs 钉钉交流群：33947367
                  </li>
                  <li>
                    <a href="https://github.com/Serverless-Devs/Serverless-Devs"
                       target="_blank">Serverless Devs 工具</a>
                  </li>
                  <li>
                    <a href="https://www.serverless-devs.com/serverless-devs/install"
                       target="_blank">工具安装文档</a>
                  </li>
                  <li>
                    <a href="https://www.serverless-devs.com/serverless-devs/command/readme"
                       target="_blank">命令行指令文档</a>
                  </li>
                  <li>
                    <a href="https://www.serverless-devs.com/fc/yaml/readme"
                       target="_blank">Yaml 规范文档</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        <div class="item">
          <div class="step">4</div>
          <h2>Github</h2>
          <p>您对此应用有任何问题或者建议，欢迎给我们 <a href="https://github.com/devsapp/start-web-framework/issues/" target="_blank">提issue</a></p>
        </div>
      </div>
    </body>
    
</html>
`)
})

app.listen(9000, () => {
    console.log('start success.');
}).on('error', (e) => {
    console.error(e.code, e.message)
})