package controllers

import (
	"os"
	"strings"

	"github.com/gin-gonic/gin"
	logger "github.com/sirupsen/logrus"

	"myapp/pkg/constant"
)

func SetupDebugRouters(e *gin.Engine) {
	g := e.Group("/debug")
	g.Any("/displayHttpContext", DebugAPI)
}

func DebugAPI(c *gin.Context) {
	env := getEnvAsMap()
	if env[constant.ALIBABA_CLOUD_ACCESS_KEY_ID] != "" {
		env[constant.ALIBABA_CLOUD_ACCESS_KEY_ID] = "encrypted"
	}
	if env[constant.ALIBABA_CLOUD_ACCESS_KEY_SECRET] != "" {
		env[constant.ALIBABA_CLOUD_ACCESS_KEY_SECRET] = "encrypted"
	}
	if env[constant.ALIBABA_CLOUD_SECURITY_TOKEN] != "" {
		env[constant.ALIBABA_CLOUD_SECURITY_TOKEN] = "encrypted"
	}
	result := gin.H{
		"path":    c.Request.URL.Path,
		"body":    "", // Gin中读取请求体要用c.Request.Body，且只能读取一次
		"method":  c.Request.Method,
		"queries": c.Request.URL.Query(),
		"headers": c.Request.Header,
		"env":     env, // Go的环境变量是通过os包获取的
	}

	logger.WithContext(c).Infof("receive request: %#v", result) // 使用Go的内置日志库，但可以选择更强大的库如logrus
	c.JSON(200, result)
}

func getEnvAsMap() map[string]string {
	envs := os.Environ()
	envMap := make(map[string]string, len(envs))

	for _, env := range envs {
		pair := strings.SplitN(env, "=", 2) // 仅分割第一个"="，以确保值中的"="不会被分割
		if len(pair) == 2 {
			envMap[pair[0]] = pair[1]
		}
	}
	return envMap
}
