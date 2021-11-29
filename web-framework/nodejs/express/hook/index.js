async function preInit(inputObj) {

}

async function postInit(inputObj) {
    console.log(`\n     _____                             
    |  ___|                            
    | |____  ___ __  _ __ ___  ___ ___ 
    |  __\\ \\/ / '_ \\| '__/ _ \\/ __/ __|
    | |___>  <| |_) | | |  __/\\__ \\__ \\
    \\____/_/\\_\\ .__/|_|  \\___||___/___/
              | |                      
              |_|                      
                                        `)
    console.log(`\n    Welcome to the start-express application
     This application requires to open these services: 
         FC : https://fc.console.aliyun.com/
     This application can help you quickly deploy the Express project:
         Full yaml configuration : https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/yaml.md
         Express development docs: https://www.expressjs.com.cn/4x/api.html
     This application homepage: https://github.com/devsapp/start-web-framework\n`)
}

module.exports = {
    postInit,
    preInit
}
