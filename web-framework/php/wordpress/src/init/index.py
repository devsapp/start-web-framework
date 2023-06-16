# coding=utf-8
import os

def handler(event, context):
    if not os.path.exists("/mnt/auto/wordpress"):
        os.system("bash nas_wp_init.sh")
    return "nas init"
