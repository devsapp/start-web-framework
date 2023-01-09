FROM node:16.15

WORKDIR /workspace
COPY . .
RUN npm install --registry=https://registry.npmmirror.com
RUN npm run build

EXPOSE 9000
ENTRYPOINT [ "node", "server.js" ]