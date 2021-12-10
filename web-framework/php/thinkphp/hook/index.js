async function preInit(inputObj) {
    console.log(`\n    ___________.__    .__        __   __________  ___ _____________ 
    \\__    ___/|  |__ |__| ____ |  | _\\______   \\/   |   \\______   \\
      |    |   |  |  \\|  |/    \\|  |/ /|     ___/    ~    \\     ___/
      |    |   |   Y  \\  |   |  \\    < |    |   \\    Y    /    |    
      |____|   |___|  /__|___|  /__|_ \\|____|    \\___|_  /|____|    
                    \\/        \\/     \\/                \\/           `)
}

async function postInit(inputObj) {
    console.log(`\n    Welcome to the start-bottle application
     This application requires to open these services: 
         FC : https://fc.console.aliyun.com/
     
     * 项目初始化完成，您可以直接进入项目目录下，并使用 s deploy 进行项目部署\n`)
}

module.exports = {
    postInit,
    preInit
}
