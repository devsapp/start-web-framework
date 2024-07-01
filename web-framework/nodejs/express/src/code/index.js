const express = require("express");
const bodyParser = require("body-parser");

const app = express();

app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());
app.use(bodyParser.text());
app.use(bodyParser.raw());

app.all("/*", (req, res) => {
  const requestId = req.headers["x-fc-request-id"];
  console.log("FC Invoke Start RequestId: " + requestId);

  res.send(
    JSON.stringify({
      msg: "Hello, World! ",
      request: {
        query: req.query,
        path: req.originalUrl,
        data: req.body,
        clientIp: req.headers["x-forwarded-for"],
      },
    })
  );

  console.log("FC Invoke End RequestId: " + requestId);
});

app.listen(9000, () => {
  console.log("Express started on port 9000");
});
