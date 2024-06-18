package com.example.webframework.domain;

/**
 * @author luoyu
 * @date 2024/5/14
 **/
public class STSCredentials {
    public String accessKeyId;
    public String accessKeySecret;
    public String securityToken;

    @Override
    public String toString() {
        return "STSCredentials{" +
                "accessKeyId='" + accessKeyId + '\'' +
                ", accessKeySecret='" + accessKeySecret + '\'' +
                ", securityToken='" + securityToken + '\'' +
                '}';
    }
}
