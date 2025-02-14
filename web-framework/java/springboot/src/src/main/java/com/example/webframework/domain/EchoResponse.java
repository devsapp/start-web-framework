package com.example.webframework.domain;

import java.util.Map;

/**
 * @author luoyu
 * @date 2024/5/7
 **/
public class EchoResponse {
    public String path;
    public String body;
    public String method;
    public String queries;
    public Map<String, String> headers;
    public Map<String, String> env;

    @Override
    public String toString() {
        return "EchoResponse{" +
                "path='" + path + '\'' +
                ", body='" + body + '\'' +
                ", method='" + method + '\'' +
                ", queries='" + queries + '\'' +
                ", headers=" + headers +
                ", env=" + env +
                '}';
    }
}
