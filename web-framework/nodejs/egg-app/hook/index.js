async function preInit(inputObj) {
    console.log(`\n     _____            
    |  ___|           
    | |__  __ _  __ _ 
    |  __|/ _\` |/ _\` |
    | |__| (_| | (_| |
    \\____/\\__, |\\__, |
           __/ | __/ |
          |___/ |___/ 
                                        `)
}

async function postInit(inputObj) {
    console.log(`\n    Welcome to the start-egg application
     This application requires to open these services: 
         FC : https://fc.console.aliyun.com/
     Egg.js development docs: https://eggjs.org/zh-cn/tutorials/index.html
     
     * 额外说明：s.yaml中声明了actions：
        部署前执行：npm install --production
       如果遇到npm命令找不到等问题，可以适当进行手动项目构建，并根据需要取消actions内容 
     * 项目初始化完成，您可以直接进入项目目录下，并使用 s deploy 进行项目部署\n`)
}


module.exports = {
    postInit,
    preInit
}
postInit()
