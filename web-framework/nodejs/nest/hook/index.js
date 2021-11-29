async function preInit(inputObj) {

}

async function postInit(inputObj) {
    console.log(`\n    Welcome to the Nest application, you can execute the following commands to develop application：`)
    console.log('\x1b[32m%s\x1b[0m', '    npm install');
    console.log('\x1b[32m%s\x1b[0m', '    npm start');
    console.log('\x1b[32m%s\x1b[0m', '    s deploy \n');
}

module.exports = {
    postInit,
    preInit
}

