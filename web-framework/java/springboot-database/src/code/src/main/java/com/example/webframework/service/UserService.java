package com.example.webframework.service;

import com.example.webframework.model.User;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class UserService {
    @Autowired
    private JdbcTemplate jdbcTemplate;

    public List<User> getAllUsers() {
        String sql = "SELECT * FROM users"; // Ensure that the users table exists in your database
        return jdbcTemplate.query(sql, (resultSet, rowNum) -> {
            User user = new User();
            user.setId(resultSet.getLong("id"));
            user.setName(resultSet.getString("name"));
            user.setPhone(resultSet.getString("phone"));
            user.setEmail(resultSet.getString("email"));
            return user;
        });
    }

    public User createUser(User user) {
        String sql = "INSERT INTO users (name, phone, email) VALUES (?, ?, ?)";
        jdbcTemplate.update(sql, user.getName(), user.getPhone(), user.getEmail());
        return user; // Ideally, get the created user's ID back and set it in the user object
    }

    public User updateUser(Long id, User user) {
        String sql = "UPDATE users SET name = ?, phone = ?, email = ? WHERE id = ?";
        jdbcTemplate.update(sql, user.getName(), user.getPhone(), user.getEmail(), id);
        user.setId(id);
        return user;
    }

    public void deleteUser(Long id) {
        String sql = "DELETE FROM users WHERE id = ?";
        jdbcTemplate.update(sql, id);
    }
}
