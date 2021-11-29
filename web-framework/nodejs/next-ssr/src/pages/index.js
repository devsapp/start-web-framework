import Head from "next/head";
import styles from "../styles/Home.module.css";

export default function Home() {
  return (
    <div>
      <Head>
        <title>快速部署一个 Next SSR 应用</title>
        <link rel="icon" href="/favicon.ico" />
      </Head>
      <header>
        <div className="header">
          <img src="http://www.serverless-devs.com/img/sdLogo.png" />
          <div>
            <a href="https://github.com/devsapp/nodejs-runtime-framework-application/tree/master/next-ssr-app/src" target="_blank">
              <svg class="w-6 h-6 text-gray-600 hover:text-gray-800" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="32" height="32" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M12 2.247a10 10 0 0 0-3.162 19.487c.5.088.687-.212.687-.475c0-.237-.012-1.025-.012-1.862c-2.513.462-3.163-.613-3.363-1.175a3.636 3.636 0 0 0-1.025-1.413c-.35-.187-.85-.65-.013-.662a2.001 2.001 0 0 1 1.538 1.025a2.137 2.137 0 0 0 2.912.825a2.104 2.104 0 0 1 .638-1.338c-2.225-.25-4.55-1.112-4.55-4.937a3.892 3.892 0 0 1 1.025-2.688a3.594 3.594 0 0 1 .1-2.65s.837-.262 2.75 1.025a9.427 9.427 0 0 1 5 0c1.912-1.3 2.75-1.025 2.75-1.025a3.593 3.593 0 0 1 .1 2.65a3.869 3.869 0 0 1 1.025 2.688c0 3.837-2.338 4.687-4.563 4.937a2.368 2.368 0 0 1 .675 1.85c0 1.338-.012 2.413-.012 2.75c0 .263.187.575.687.475A10.005 10.005 0 0 0 12 2.247z" fill="#fff" /></svg>
              <p>Github</p>
            </a>
          </div>
        </div>
        <div className={styles.wrap}>
          <h1>快速部署一个 Next SSR 应用</h1>
        </div>
        <div className={styles.wrap}>
          <p>Serverless Devs 是一个开源开放的 Serverless 开发者平台，致力于为开发者提供强大的工具链体系。通过该平台，开发者可以一键体验多云 Serverless 产品，极速部署 Serverless 项目。</p>
          <a className={styles['button-primary']} href="http://www.serverless-devs.com/zh-cn/index.html" target="_blank">Serverless Devs</a>
        </div>
      </header>
      <div className={styles.content}>
        <div className={styles.list}>
          <div className={styles.item}>
            <div className={styles.step}>1</div>
            <h2>介绍</h2>
            <p>这是一个 <code>Next SSR</code> 应用示例，可以通过 <code>Serverless Devs</code> 工具将项目一键部署到云开发环境</p>
          </div>
          <div className={styles.item}>
            <div className={styles.step}>2</div>
            <h2>文档</h2>
            <p>NextJS 官方在线文档，参见 <a
              href="https://www.nextjs.cn/" target="_blank">https://www.nextjs.cn/</a>.</p>
          </div>
          <div className={styles.item}>
            <div className={styles.step}>3</div>
            <h2>快速部署一个 Next 应用</h2>
            <div className={styles.container}>
              <div>
                <h3>步骤一. 准备工作</h3>
                <p>具体步骤请参照 <a
                  href="http://www.serverless-devs.com/zh-cn/docs/installed/cliinstall.html" target="_blank"> Serverless Cli 安装</a></p>
                <h3>步骤二. 初始化应用示例</h3>
                <pre>s init next-ssr-app</pre>
                <h3>步骤三. 一键部署</h3>
                <p>进入到项目目录，在命令行执行</p>
                <pre>s deploy</pre>
                <h3>帮助文档</h3>
                <ul >
                  <li>
                    <a
                      href="https://github.com/Serverless-Devs/Serverless-Devs"
                      target="_blank">Serverless Devs 开发部署工具</a>
                  </li>
                  <li>
                    <a
                      href="https://github.com/Serverless-Devs/docs/blob/master/zh/install.md"
                      target="_blank">工具安装文档</a>
                  </li>
                  <li>
                    <a
                      href="https://github.com/Serverless-Devs/docs/blob/master/zh/command.md"
                      target="_blank">命令行指令文档</a>
                  </li>
                  <li>
                    <a
                      href="https://github.com/Serverless-Devs/docs/blob/master/zh/yaml.md"
                      target="_blank">Yaml 规范文档</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div >
  );
}
