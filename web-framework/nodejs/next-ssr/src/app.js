const { parse } = require('url')
const next = require('next')

const dev = process.env.NODE_ENV !== 'production'
const app = next({ dev })
const handle = app.getRequestHandler()
app.prepare();

module.exports = async (req, res, context) => {
  const parsedUrl = parse(req.url, true)
  handle(req, res, parsedUrl)
};
