from flask import Flask, request, jsonify
import arrow

app = Flask(__name__)


@app.route("/", defaults={"path": ""}, methods=["GET", "POST", "PUT", "DELETE"])
@app.route("/<path:path>", methods=["GET", "POST", "PUT", "DELETE"])
def hello_world(path):
    requestId = request.headers.get("x-fc-request-id")
    print("FC Invoke Start RequestId: " + requestId)

    response = jsonify(
        {
            "msg": "Hello, World!" + " at " + arrow.now().format("YYYY-MM-DD HH:mm:ss"),
            "request": {
                "query": str(request.query_string, "utf-8"),
                "path": path,
                "data": str(request.stream.read(), "utf-8"),
                "clientIp": request.headers.get("x-forwarded-for"),
            },
        }
    )

    print("FC Invoke End RequestId: " + requestId)
    return response


if __name__ == "__main__":
    app.run(host="0.0.0.0", port=9000)
