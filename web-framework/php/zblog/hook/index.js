async function preInit(inputObj) {
    console.log(`\n    _____________.   .__                 
    \\____    /\\_ |__ |  |   ____   ____  
      /     /  | __ \\|  |  /  _ \\ / ___\\ 
     /     /_  | \\_\\ \\  |_(  <_> ) /_/  >
    /_______ \\ |___  /____/\\____/\\___  / 
            \\/     \\/           /_____/  
                                        `)
}

async function postInit(inputObj) {
    console.log(`\n    Welcome to the start-bottle application
     This application requires to open these services: 
         FC : https://fc.console.aliyun.com/
         NAS: https://nas.console.aliyun.com/
     
     * Additional instructions: In order to ensure that the project can install plug-ins and templates normally, and to ensure the project 0 transformation, the current case implementation logic:
         1. Function Compute is only executed as an environment
         2. The business code is placed in the NAS
         > So in Yaml, there is a post-deploy section to upload the business code to the NAS. At this time, you need to pay extra attention:
         > - version/alias, etc., may not take effect for business code
         > - Under the premise of using the same NAS, please pay attention to whether the folder will be overwritten when deploying other functions, so as not to affect each other
         3. The Serverless Devs version required by the current project is at least v2.0.103. You can view the current version through [s -v] and upgrade the version through [npm install -g @serverless-devs/s].
     * After the project is initialized, you can directly enter the project directory and use s deploy to deploy the project
     \n`)
}

module.exports = {
    postInit,
    preInit
}
