async function preInit(inputObj) {
    console.log(`\n    ___________.__    .__        __   __________  ___ _____________ 
    \\__    ___/|  |__ |__| ____ |  | _\\______   \\/   |   \\______   \\
      |    |   |  |  \\|  |/    \\|  |/ /|     ___/    ~    \\     ___/
      |    |   |   Y  \\  |   |  \\    < |    |   \\    Y    /    |    
      |____|   |___|  /__|___|  /__|_ \\|____|    \\___|_  /|____|    
                    \\/        \\/     \\/                \\/           
                    `)
}

async function postInit(inputObj) {
    console.log(`\n    Welcome to the start-bottle application
     This application requires to open these services: 
         FC : https://fc.console.aliyun.com/
         
     * Additional instructions:
         1. The Serverless Devs version required by the current project is at least v2.0.103. You can view the current version through [s -v] and upgrade the version through [npm install -g @serverless-devs/s].
     * After the project is initialized, you can directly enter the project directory and use s deploy to deploy the project
     \n`)
}

module.exports = {
    postInit,
    preInit
}
