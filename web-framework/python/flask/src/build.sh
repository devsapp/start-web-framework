#!/bin/bash
set -e

# make sure .env exist
if [ ! -d .env ]; then
    python3 -m venv .env
fi

source .venv/bin/activate
# build for local
.venv/bin/pip3 install -r requirements.txt
mkdir -p python
rm -rf python
# build for remote, docker is required for this action
s build