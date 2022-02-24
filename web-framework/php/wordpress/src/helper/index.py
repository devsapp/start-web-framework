# coding=utf-8

import requests
import os


def handler(event, context):
    url = os.environ['WP_URL']
    res = requests.head(url)
    print(res.status_code)
