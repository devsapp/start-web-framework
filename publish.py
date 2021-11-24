import os
import json
import zipfile
import requests


def getContent(fileList):
    for eveFile in fileList:
        try:
            with open(eveFile) as f:
                return f.read()
        except:
            pass
    return None

with open('publish.cache') as f:
    publish_list = [eve_app.strip() for eve_app in f.readlines()]

for eve_app in publish_list:
    os.system('cd %s && wget https://serverless-registry.oss-cn-hangzhou.aliyuncs.com/publish-file/python3/hub-publish.py && python hub-publish.py' % eve_app)