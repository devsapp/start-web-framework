const { boomify } = require("@hapi/boom");

exports.plugin = {
    name: 'main-default',
    multiple: false,
    register: async function(server, options) {
        server.route([
            {
                method: 'GET',
                path: '/todo/{id}/',
                handler: (request, h) => JSON.stringify(process.env),
                options: {
                    auth: false, cors: true,
                    description: 'Get todo',
                    notes: 'Returns a todo item by the id passed in the path',
                    tags: ['api', 'default'], // ADD THIS TAG
                },
            }, {
                method: 'GET',
                path: '/db/{num}',
                handler: async (request, h) => {
                    try {
                        const { fc_col } = server.plugins['global-static'].collections;
                        const list = await fc_col.find();
                        return h.response(list? list: 'list num is 0')
                    } catch (error) {
                        throw boomify(error)
                    }
                },
                options: {
                    description: 'Get db data',
                    notes: 'Returns a db data item by the id passed in the path',
                    tags: ['api', 'default'], // ADD THIS TAG
                },
            }, {
                method: 'GET',
                path: '/rds/test',
                handler: async (request, h) => {
                    try {
                        const session = server.plugins['global-static'].session;
    
                        const res = await session.get('name')
                        
                        return h.response(res? res: 'none')
                    } catch (error) {
                        throw boomify(error);
                    }
                },
                options: {
                    description: 'Get rds data',
                    notes: 'Returns a rds data item by the id passed in the path',
                    tags: ['api', 'default'], // ADD THIS TAG
                },
            }, 
        ])
    }
}