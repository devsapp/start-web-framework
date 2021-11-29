async function preInit(inputObj) {

}

async function postInit(inputObj) {
    console.log(`\n     _____            
    |  ___|           
    | |__  __ _  __ _ 
    |  __|/ _\` |/ _\` |
    | |__| (_| | (_| |
    \\____/\\__, |\\__, |
           __/ | __/ |
          |___/ |___/ 
                                        `)
    console.log(`\n    Welcome to the Egg application, you can execute the following commands to develop application：`)
    console.log('\x1b[32m%s\x1b[0m', '    npm install');
    console.log('\x1b[32m%s\x1b[0m', '    npm run dev');
    console.log('\x1b[32m%s\x1b[0m', '    s deploy \n');
}

module.exports = {
    postInit,
    preInit
}
postInit()
