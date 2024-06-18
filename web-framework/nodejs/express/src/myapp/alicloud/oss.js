const OSS = require('ali-oss');
const {logger} = require('../logger/config')

const getOssClient = () => {
    const region = 'oss-'+process.env.FC_REGION || 'oss-cn-hangzhou';
    const accessKeyId = process.env.ALIBABA_CLOUD_ACCESS_KEY_ID || 'dummy-access-key-id';
    const accessKeySecret = process.env.ALIBABA_CLOUD_ACCESS_KEY_SECRET || 'dummy-access-key-secret';
    const securityToken = process.env.ALIBABA_CLOUD_SECURITY_TOKEN || 'dummy-security-token';
    return new OSS({
        region,
        accessKeyId,
        accessKeySecret,
        stsToken: securityToken,
        internal: true,
    });
};

const client = getOssClient();

module.exports = {
    getOssClient,
    client
}