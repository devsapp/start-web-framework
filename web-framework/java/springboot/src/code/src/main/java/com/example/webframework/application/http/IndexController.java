package com.example.webframework.application.http;

import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

/**
 * @author luoyu
 * @date 2024/5/15
 **/
@RestController
@RequestMapping({"/", ""})
public class IndexController {

    @GetMapping({"/", ""})
    public ResponseEntity<String> welcome() {
        // TODO P2 开发功能说明页面，引导用户体验全部功能
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
}
