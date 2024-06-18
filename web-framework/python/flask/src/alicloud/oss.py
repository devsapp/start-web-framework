import oss2

from config import config

stsAuth = oss2.StsAuth(config.ACCESS_KEY_ID, config.ACCESS_KEY_SECRET, config.SECURITY_TOKEN)
# https://help.aliyun.com/zh/oss/user-guide/regions-and-endpoints
endpoint = "oss-%s-internal.aliyuncs.com" % config.CURRENT_REGION
oss_client = oss2.Service(stsAuth, endpoint)
