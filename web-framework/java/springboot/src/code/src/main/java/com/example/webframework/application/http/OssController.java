package com.example.webframework.application.http;

import com.aliyun.oss.model.Bucket;
import com.example.webframework.application.service.OssService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import java.util.List;

/**
 * @author luoyu
 * @date 2024/5/8
 **/
@RestController
@RequestMapping("/oss")
public class OssController {

    @Autowired
    private OssService ossService;
    @GetMapping("/listBuckets")
    public List<Bucket> listBuckets() {
        return ossService.listBuckets();
    }

}
