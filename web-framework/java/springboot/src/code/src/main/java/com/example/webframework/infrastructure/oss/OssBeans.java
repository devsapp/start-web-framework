package com.example.webframework.infrastructure.oss;

import com.aliyun.oss.OSS;
import com.aliyun.oss.OSSClientBuilder;
import com.aliyun.oss.common.auth.DefaultCredentialProvider;
import com.example.webframework.domain.STSCredentials;
import com.example.webframework.infrastructure.utils.EnvironmentUtils;
import org.springframework.context.annotation.Bean;
import org.springframework.stereotype.Component;

/**
 * @author luoyu
 * @date 2024/5/14
 **/

@Component
public class OssBeans {

    @Bean
    public OSS ossClient() {
        STSCredentials credentials = EnvironmentUtils.getSTSCredentials();
        DefaultCredentialProvider provider = new DefaultCredentialProvider(
                credentials.accessKeyId,
                credentials.accessKeySecret,
                credentials.securityToken
        );
        String regionID = EnvironmentUtils.getCurrentRegion();
        return OSSClientBuilder.create()
                .region(regionID)
                // https://help.aliyun.com/zh/oss/user-guide/regions-and-endpoints
                .endpoint("oss-" + regionID + "-internal.aliyuncs.com")
                .credentialsProvider(provider)
                .build();
    }

}
