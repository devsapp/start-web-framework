const { NestFactory } = require('@nestjs/core');
const { AppModule } = require('./dist/app.module');

module.exports = async (req, res, context) => {
  const nest = await NestFactory.create(AppModule);
  await nest.listen();
  nest.httpAdapter.instance(req, res, context);
};