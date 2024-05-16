from flask import Flask
from flask import request
import arrow

REQUEST_ID_HEADER = 'x-fc-request-id'

app = Flask(__name__)

@app.route('/', defaults={'path': ''})
@app.route('/<path:path>', methods=['GET', 'POST', 'PUT', 'DELETE'])
def hello_world(path):
        rid = request.headers.get(REQUEST_ID_HEADER)
        print("FC Invoke Start RequestId: " + rid)
        data = request.stream.read()
        print("Path: " + path)
        print("Data: " + str(data))
        i=arrow.now()
        body = "Hello, World!" + " at " + i.format('YYYY-MM-DD HH:mm:ss')
        print("FC Invoke End RequestId: " + rid)
        return body

if __name__ == '__main__':
        app.run(host='0.0.0.0',port=9000)
