package com.example.webframework;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestHeader;
import org.springframework.web.bind.annotation.RestController;

import java.util.HashMap;
import java.util.Map;

@SpringBootApplication
@RestController
public class WebFrameworkApplication {

    public static void main(String[] args) {
        SpringApplication.run(WebFrameworkApplication.class, args);
    }

    @GetMapping("/")
    public ResponseEntity<String> welcome() {
        String welcome = "<html xmlns=\"http://www.w3.org/1999/xhtml\"" +
                "<head>" +
                "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>" +
                "<title>Serverless Devs - Powered By Serverless Devs</title>" +
                "<link href=\"https://example-static.oss-cn-beijing.aliyuncs.com/web-framework/style.css\" rel=\"stylesheet\" type=\"text/css\"/>" +
                "</head>" +
                "<body>" +
                "<div class=\"website\">" +
                "<div class=\"ri-t\">" +
                "<h1>Devsapp</h1>" +
                "<h2>这是一个 Spring Boot 项目</h2>" +
                "<span>自豪的通过Serverless Devs进行部署</span>" +
                "<br/><p>您也可以快速体验： <br/>" +
                "• 下载Serverless Devs工具：npm install @serverless-devs/s<br/>" +
                "• 初始化项目：s init start-springboot<br/>" +
                "• 项目部署：s deploy<br/><br/>" +
                "Serverless Devs 钉钉交流群：33947367 </p>" +
                "</div></div></body></html>";
        return new ResponseEntity<>(welcome, HttpStatus.OK);
    }

    @GetMapping("/fcheaders")
    public ResponseEntity<Map<String, String>> listHeaders(
            @RequestHeader Map<String, String> headers) {
        Map<String, String> fcHeaders = new HashMap<>();
        headers.forEach((key, value) -> {
            if (key.startsWith("x-fc")) {
                fcHeaders.put(key, value);
            }

        });

        return new ResponseEntity<>(fcHeaders, HttpStatus.OK);
    }
}
