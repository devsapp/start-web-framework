import Server from './server';
import * as serverless from '@serverless-devs/fc-http';

// Cache
let handler;

exports.handler = async (req, resp, context) => {
  if (!handler) {
    const app = await Server.start();
    handler = serverless(app);
  }
  handler(req, resp, context);
};