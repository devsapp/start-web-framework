package com.example.webframework.infrastructure.exceptions;

/**
 * @author luoyu
 * @date 2024/5/7
 **/
public class InternalErrorException extends RuntimeException {
    public InternalErrorException(String message) {
        super(message);
    }
}
