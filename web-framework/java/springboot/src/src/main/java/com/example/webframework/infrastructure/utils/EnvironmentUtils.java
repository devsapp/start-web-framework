package com.example.webframework.infrastructure.utils;

import com.example.webframework.domain.STSCredentials;

/**
 * @author luoyu
 * @date 2024/5/10
 **/
public class EnvironmentUtils {
    public static STSCredentials getSTSCredentials() {
        STSCredentials result = new STSCredentials();
        result.accessKeyId = System.getenv("ALIBABA_CLOUD_ACCESS_KEY_ID");
        result.accessKeySecret = System.getenv("ALIBABA_CLOUD_ACCESS_KEY_SECRET");
        result.securityToken = System.getenv("ALIBABA_CLOUD_SECURITY_TOKEN");
        return result;
    }

    public static String getCurrentRegion() {
        return System.getenv("FC_REGION");
    }
}
