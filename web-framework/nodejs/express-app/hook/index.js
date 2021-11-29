async function preInit(inputObj) {

}

async function postInit(inputObj) {
    console.log(`\n     _____                             
    |  ___|                            
    | |____  ___ __  _ __ ___  ___ ___ 
    |  __\\ \\/ / '_ \\| '__/ _ \\/ __/ __|
    | |___>  <| |_) | | |  __/\\__ \\__ \\
    \\____/_/\\_\\ .__/|_|  \\___||___/___/
              | |                      
              |_|                      
                                        `)
    console.log(`\n    Welcome to the Express application, you can execute the following commands to develop application：`)
    console.log('\x1b[32m%s\x1b[0m', '    npm install');
    console.log('\x1b[32m%s\x1b[0m', '    npm run dev');
    console.log('\x1b[32m%s\x1b[0m', '    s deploy \n');
}

module.exports = {
    postInit,
    preInit
}

