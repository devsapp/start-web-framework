package com.example.webframework.application.service;


import com.aliyun.oss.OSS;
import com.aliyun.oss.model.Bucket;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

import java.io.InputStream;
import java.util.List;




/**
 * @author luoyu
 * @date 2024/5/14
 **/
@Component
public class OssService {

    @Autowired
    private OSS ossClient;

    public List<Bucket> listBuckets() {
        return ossClient.listBuckets();
    }

}
