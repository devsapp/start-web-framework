const server = require('./server');
const serverless = require('@serverless-devs/fc-http');


exports.handler = serverless(server);
