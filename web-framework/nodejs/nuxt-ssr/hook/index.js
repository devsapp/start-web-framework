async function preInit(inputObj) {

}

async function postInit(inputObj) {
    console.log(`\n     _   _            _     _     
    | \\ | |          | |   (_)    
    |  \\| |_   ___  _| |_   _ ___ 
    | . \` | | | \\ \\/ / __| | / __|
    | |\\  | |_| |>  <| |_ _| \\__ \\
    \\_| \\_/\\__,_/_/\\_\\\\__(_) |___/
                          _/ |    
                         |__/     
                                        `);
    console.log(`\n    Welcome to the nuxt SSR application, you can execute the following commands to develop application：`)
    console.log('\x1b[32m%s\x1b[0m', '    npm install');
    console.log('\x1b[32m%s\x1b[0m', '    npm run dev');
    console.log('\x1b[32m%s\x1b[0m', '    s deploy \n');
}

module.exports = {
    postInit,
    preInit
}

