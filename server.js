var http = require("http");

function handleRequest(req, res) {
  res.writeHead(200, { "Content-Type": "text/plain" });
  res.end("Hello Node");
}

var server = http.createServer(handleRequest);

server.listen(3000, function () {
  console.log("Server running at http://localhost:3000");
});