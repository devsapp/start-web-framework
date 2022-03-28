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