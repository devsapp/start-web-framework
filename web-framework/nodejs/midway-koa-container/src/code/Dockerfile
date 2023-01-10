FROM node:16.15

WORKDIR /workspace
COPY . .
RUN npm install --registry=https://registry.npmmirror.com
RUN npm run bundle

EXPOSE 9000
ENTRYPOINT [ "node", "build/index.js" ]