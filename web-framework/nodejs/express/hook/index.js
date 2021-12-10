async function preInit(inputObj) {
    console.log(`\n     _____                             
    |  ___|                            
    | |____  ___ __  _ __ ___  ___ ___ 
    |  __\\ \\/ / '_ \\| '__/ _ \\/ __/ __|
    | |___>  <| |_) | | |  __/\\__ \\__ \\
    \\____/_/\\_\\ .__/|_|  \\___||___/___/
              | |                      
              |_|                      
                                        `)
}

async function postInit(inputObj) {

    console.log(`\n    Welcome to the start-express application
     This application requires to open these services: 
         FC : https://fc.console.aliyun.com/
     Express development docs: https://www.expressjs.com.cn/4x/api.html

     * 额外说明：s.yaml中声明了actions：
        部署前执行：npm install --production
       如果遇到npm命令找不到等问题，可以适当进行手动项目构建，并根据需要取消actions内容 
     * 项目初始化完成，您可以直接使用 s deploy 进行项目部署\n`)
}

module.exports = {
    postInit,
    preInit
}
