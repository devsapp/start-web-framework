const serverless = require('@serverless-devs/fc-http');
const app = require('./app');

exports.handler = serverless(app);
