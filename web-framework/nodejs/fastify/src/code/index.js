const fastify = require("fastify")();

fastify.addContentTypeParser("*", function (request, payload, done) {
  var data = "";
  payload.on("data", (chunk) => {
    data += chunk;
  });
  payload.on("end", () => {
    done(null, data);
  });
});

fastify.all("/*", {}, async function (request, reply) {
  const requestId = request.headers["x-fc-request-id"];
  console.log("FC Invoke Start RequestId: " + requestId);
  reply
    .code(200)
    .header("my-custom-header", "hello")
    .send({
      msg: "Hello, World! ",
      request: {
        query: request.query,
        path: request.url,
        data: request.body,
        clientIp: request.headers["x-forwarded-for"],
      },
    });
  console.log("FC Invoke End RequestId: " + requestId);
});

fastify.listen({ port: 9000, host: "0.0.0.0" }, (err) => {
  if (err) throw err;
  console.log(`server listening on ${fastify.server.address().port}`);
});
