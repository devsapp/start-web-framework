const Main = require('./main')

exports.plugin = {
    name: 'api-default',
    multiple: true,
    register: async function(server, options) {
        const prefix = options.prefix ? options.prefix : ''
    
        await server.register([
            { plugin: Main, routes: { prefix: `${prefix}/base` } }
        ])
    }
}
