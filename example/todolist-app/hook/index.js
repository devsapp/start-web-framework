async function preInit(inputObj) {

}

async function postInit(inputObj) {
    console.log(`\n     _______  _______  ______   _______  ___      ___   _______  _______ 
    |       ||       ||      | |       ||   |    |   | |       ||       |
    |_     _||   _   ||  _    ||   _   ||   |    |   | |  _____||_     _|
      |   |  |  | |  || | |   ||  | |  ||   |    |   | | |_____   |   |  
      |   |  |  |_|  || |_|   ||  |_|  ||   |___ |   | |_____  |  |   |  
      |   |  |       ||       ||       ||       ||   |  _____| |  |   |  
      |___|  |_______||______| |_______||_______||___| |_______|  |___|  
                                        `)
    console.log(`\n    Welcome to the todolist-app application
     This application requires to open these services: 
         FC : https://fc.console.aliyun.com/
     This application can help you quickly deploy the todolist-app project.
     The application uses FC component：https://github.com/devsapp/fc
     The application homepage: https://github.com/devsapp/todolist\n`)
}

module.exports = {
    postInit,
    preInit
}
