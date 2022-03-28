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

     * Additional note: 
      1. [actions] are declared in s.yaml, execute before deployment
         If you don't need to build the project every time, or you don't need to build before deployment, or you have built it manually, you can comment out this part
      2. The Serverless Devs version required by the current project is at least v2.0.103. You can view the current version through [s -v] and upgrade the version through [npm install -g @serverless-devs/s].
     * After the project is initialized, you can directly enter the project directory and use s deploy to deploy the project
    \n`)
}

module.exports = {
    postInit,
    preInit
}
