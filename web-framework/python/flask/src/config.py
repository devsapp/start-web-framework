import os


class Config:
    SECRET_KEY = os.environ.get('SECRET_KEY') or 'my-passwd'
    ACCESS_KEY_ID = os.environ.get("ALIBABA_CLOUD_ACCESS_KEY_ID") or 'default-access-key-id'
    ACCESS_KEY_SECRET = os.environ.get("ALIBABA_CLOUD_ACCESS_KEY_SECRET") or 'default-access-key-secret'
    SECURITY_TOKEN = os.environ.get("ALIBABA_CLOUD_SECURITY_TOKEN") or 'default-security-token'
    CURRENT_REGION = os.environ.get("FC_REGION") or 'cn-hangzhou'
    DEBUG = True


config = Config
