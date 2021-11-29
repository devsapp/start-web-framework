async function preInit(inputObj) {

}

async function postInit(inputObj) {
    console.log(`\n    ______ _                         
    |  _  (_)                        
    | | | |_  __ _ _ __   __ _  ___  
    | | | | |/ _\` | '_ \\ / _\` |/ _ \\ 
    | |/ /| | (_| | | | | (_| | (_) |
    |___/ | |\\__,_|_| |_|\\__, |\\___/ 
         _/ |             __/ |      
        |__/             |___/       
                                        `)
    console.log(`\n    Welcome to the start-django application
     This application requires to open these services: 
         FC : https://fc.console.aliyun.com/
     This application can help you quickly deploy the Django project:
         Full yaml configuration : https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/yaml.md
         Django development docs: https://docs.djangoproject.com/en/3.2/
     This application homepage: https://github.com/devsapp/start-web-framework\n`)
}

module.exports = {
    postInit,
    preInit
}
