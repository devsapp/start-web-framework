package com.example.webframework.infrastructure.filters;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.slf4j.MDC;
import org.springframework.stereotype.Component;
import org.springframework.web.filter.OncePerRequestFilter;

import javax.servlet.FilterChain;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.util.UUID;

/**
 * @author luoyu
 * @date 2024/5/10
 **/
@Component
public class RequestIDInterceptor extends OncePerRequestFilter {

    private static final String KEY_REQUEST_ID = "x-fc-request-id";

    @Override
    protected void doFilterInternal(HttpServletRequest request, HttpServletResponse response, FilterChain filterChain)
            throws ServletException, IOException {
        try {
            String requestId = request.getHeader(KEY_REQUEST_ID);
            if (requestId == null) {
                requestId = UUID.randomUUID().toString();
            }
            MDC.put("RequestId", requestId);
            response.addHeader(KEY_REQUEST_ID, requestId);
            filterChain.doFilter(request, response);
        } finally {
            MDC.remove("RequestId");
        }
    }
}
