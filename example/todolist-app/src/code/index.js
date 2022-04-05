const serverless = require('@serverless-devs/fc-http');
const app = require('./server');

exports.handler = serverless(app);
