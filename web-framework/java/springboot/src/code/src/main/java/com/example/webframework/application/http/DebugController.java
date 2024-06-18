package com.example.webframework.application.http;

import com.example.webframework.domain.EchoResponse;
import com.example.webframework.infrastructure.exceptions.InternalErrorException;
import com.fasterxml.jackson.databind.ObjectMapper;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import javax.servlet.http.HttpServletRequest;
import java.util.Map;


@RestController
@RequestMapping("/debug")
public class DebugController {


    @Autowired
    private ObjectMapper objectMapper;

    private static final Logger logger = LoggerFactory.getLogger(DebugController.class);


    @RequestMapping(value = {"/displayHttpContext", "/displayHttpContext/"})
    public EchoResponse echo(
            HttpServletRequest request,
            @RequestHeader Map<String, String> headers,
            @RequestParam(required = false) Map<String, String> params,
            @RequestBody(required = false) String body) {

        EchoResponse result = new EchoResponse();
        if (request == null) {
            logger.error("http request is null");
            throw new InternalErrorException("http request is null");
        }
        result.path = request.getRequestURI();
        result.body = body;
        result.method = request.getMethod();
        result.queries = request.getQueryString();
        result.headers = headers;
        result.env = System.getenv();
        logger.info("receive request: {}", result);
        return result;
    }
}
