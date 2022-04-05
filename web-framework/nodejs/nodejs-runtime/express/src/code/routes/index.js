const express = require("express");
const router = express.Router();

/* GET home page. */
router.get("/", function(req, res, next) {
  res.render("index", { title: "快速部署一个 Express 应用" });
});

module.exports = router;