const serverless = require('@serverless-devs/fc-http');
const getServer = require('./server');

let handler;
module.exports.handler = async (req, res, context) => {
  if (!handler) {
    const app = await getServer();
    handler = serverless(app);
  }
  const response = await handler(req, res, context)
  return response
}