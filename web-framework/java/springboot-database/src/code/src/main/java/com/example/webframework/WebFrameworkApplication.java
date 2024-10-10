package com.example.webframework;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestHeader;
import org.springframework.web.bind.annotation.RestController;

import javax.annotation.PostConstruct;
import java.util.HashMap;
import java.util.Map;

@SpringBootApplication
@RestController
public class WebFrameworkApplication {

    @Autowired
    private JdbcTemplate jdbcTemplate; // 注入JdbcTemplate

    public static void main(String[] args) {
        SpringApplication.run(WebFrameworkApplication.class, args);
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

    @GetMapping("/test-db")
    public ResponseEntity<String> testDatabase() {
        if (testDB()) {
            return new ResponseEntity<>("Database connection successful!", HttpStatus.OK);
        }
        return new ResponseEntity<>("Database connection failed.", HttpStatus.INTERNAL_SERVER_ERROR);
    }

    private boolean testDB() {
        try {
            jdbcTemplate.execute("SELECT 1");
            return true;
        } catch (Exception e) {
            e.printStackTrace();
            return false;
        }
    }

    @PostConstruct
    public void init() {
        String sql = "CREATE TABLE IF NOT EXISTS users (" +
                "id BIGINT AUTO_INCREMENT PRIMARY KEY," +
                "name VARCHAR(255) NOT NULL," +
                "phone VARCHAR(50) NOT NULL," +
                "email VARCHAR(255) NOT NULL" +
                ")";
        jdbcTemplate.execute(sql);
    }

}
