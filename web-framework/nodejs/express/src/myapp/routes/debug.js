const express = require('express');
const router = express.Router();
const {logger} = require('../logger/config')
/* GET home page. */
router.get('/displayHttpContext', (req, res) => {
    const env = Object.assign({}, process.env)
    env.ALIBABA_CLOUD_ACCESS_KEY_ID = "encrypted"
    env.ALIBABA_CLOUD_ACCESS_KEY_SECRET = "encrypted"
    env.ALIBABA_CLOUD_SECURITY_TOKEN = "encrypted"
    const headers = Object.assign({}, req.headers)
    headers['x-fc-access-key-id'] = "encrypted"
    headers['x-fc-access-key-secret'] = "encrypted"
    headers['x-fc-security-token'] = "encrypted"
    const result = {
        path: req.path,
        body: req.body,
        method: req.method,
        queries: req.query,
        headers: headers,
        env: env,
    };

    // 使用标准日志记录方式替换了console.log
    logger.info(`Receive request: ${JSON.stringify(result)}`);
    res.json(result);
});

module.exports = router;