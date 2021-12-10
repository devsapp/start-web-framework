async function preInit(inputObj) {
    console.log(`\n    .____                                    .__   
    |    |   _____ ____________ ___  __ ____ |  |  
    |    |   \\__  \\\\_  __ \\__  \\\\  \\/ // __ \\|  |  
    |    |___ / __ \\|  | \\// __ \\\\   /\\  ___/|  |__
    |_______ (____  /__|  (____  /\\_/  \\___  >____/
            \\/    \\/           \\/          \\/      `)
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
