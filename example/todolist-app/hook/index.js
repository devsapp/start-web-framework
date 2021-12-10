async function preInit(inputObj) {
    console.log(`\n     _______  _______  ______   _______  ___      ___   _______  _______ 
    |       ||       ||      | |       ||   |    |   | |       ||       |
    |_     _||   _   ||  _    ||   _   ||   |    |   | |  _____||_     _|
      |   |  |  | |  || | |   ||  | |  ||   |    |   | | |_____   |   |  
      |   |  |  |_|  || |_|   ||  |_|  ||   |___ |   | |_____  |  |   |  
      |   |  |       ||       ||       ||       ||   |  _____| |  |   |  
      |___|  |_______||______| |_______||_______||___| |_______|  |___|  `)
}

async function postInit(inputObj) {
    console.log(`\n    Welcome to the todolist-app application
     This application requires to open these services: 
         FC : https://fc.console.aliyun.com/
     This application can help you quickly deploy the todolist-app project.
     
     * 额外说明：s.yaml中声明了actions：
        部署前执行：npm install --production
       如果遇到npm命令找不到等问题，可以适当进行手动项目构建，并根据需要取消actions内容 
     * 项目初始化完成，您可以直接进入项目目录下，并使用 s deploy 进行项目部署\n`)
}

module.exports = {
    postInit,
    preInit
}
