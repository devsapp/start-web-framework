const express = require('express');
const router = express.Router();
const {client} = require('../alicloud/oss')
const {logger} = require('../logger/config')
/* GET home page. */
router.get('/listBuckets', async (req, res) => {
    try {
        const result = await client.listBuckets()
        return res.json(result)
    } catch (e) {
        logger.error(`failed to list buckets: ${JSON.stringify(e)}`)
        return res.json({
            code: 500,
            msg: e.message
        })
    }
});

module.exports = router;