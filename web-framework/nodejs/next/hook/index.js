async function preInit(inputObj) {
    console.log(`\n     _   _           _     _     
    | \\ | |         | |   (_)    
    |  \\| | _____  _| |_   _ ___ 
    | . \` |/ _ \\ \\/ / __| | / __|
    | |\\  |  __/>  <| |_ _| \\__ \\
    \\_| \\_/\\___/_/\\_\\\\__(_) |___/
                         _/ |    
                        |__/     
                                        `)
}

async function postInit(inputObj) {

    console.log(`\n    Welcome to the start-next application
     This application requires to open these services: 
         FC : https://fc.console.aliyun.com/
     Next development docs  : https://www.nextjs.cn/docs/getting-started
     
     * 额外说明：s.yaml中声明了actions：
        部署前执行：npm install --production
       如果遇到npm命令找不到等问题，可以适当进行手动项目构建，并根据需要取消actions内容 
     * 项目初始化完成，您可以直接进入项目目录下，并使用 s deploy 进行项目部署\n\n`)
}

module.exports = {
    postInit,
    preInit
}