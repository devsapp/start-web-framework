package com.example.webframework;

import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.boot.test.context.SpringBootTest;
import org.springframework.http.HttpStatus;
import org.springframework.test.context.junit4.SpringRunner;

import static org.junit.Assert.assertEquals;

@RunWith(SpringRunner.class)
@SpringBootTest
public class WebFrameworkApplicationTests {

	@Test
	public void testWelcome() {
		assertEquals(HttpStatus.OK, new WebFrameworkApplication().welcome().getStatusCode());
	}

}
