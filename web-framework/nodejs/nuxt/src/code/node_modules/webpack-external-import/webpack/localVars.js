"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.addLocalVars = addLocalVars;

// eslint-disable-next-line import/prefer-default-export
function addLocalVars(source, chunk, compilationHash) {
  return [source, "", "// object to store interleaved JavaScript chunks", "var interleaveMap = {};", "// object to store interleaved CSS chunks", "var interleavedCssChunks = {}", "var compilationHash = '".concat(compilationHash, "'")].join("\n");
}