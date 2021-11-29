FROM openjdk:8-jdk-alpine
ARG JAR_FILE=target/*.jar
COPY ${JAR_FILE} webframework.jar
ENTRYPOINT ["java","-jar","/webframework.jar"]