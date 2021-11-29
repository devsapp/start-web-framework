const serverless = require('@serverless-devs/fc-http');

const app = require('./app');

module.exports.handler = serverless(app);