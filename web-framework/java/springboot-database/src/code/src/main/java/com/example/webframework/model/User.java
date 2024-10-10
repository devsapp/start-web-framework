package com.example.webframework.model;

import lombok.Data;

@Data
public class User {
    private Long id;
    private String name;
    private String phone;
    private String email;

    public User(Long id, String name, String phone, String email) {
        this.id = id;
        this.name = name;
        this.phone = phone;
        this.email = email;
    }

    public User() {
    }
}
