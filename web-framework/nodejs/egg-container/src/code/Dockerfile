FROM node:16.15

WORKDIR /workspace
COPY . .
RUN npm install --production --registry=https://registry.npmmirror.com

EXPOSE 9000
ENTRYPOINT [ "node", "server.js" ]