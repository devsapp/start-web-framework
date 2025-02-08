package logging

import (
	"strings"

	"github.com/gin-gonic/gin"
	"github.com/google/uuid"

	"myapp/pkg/constant"
)

func RequestIDMiddleware() gin.HandlerFunc {
	return func(c *gin.Context) {
		requestID := c.GetHeader("X-Fc-Request-Id")
		if requestID == "" {
			// 随机生成request-id，这里使用简单的示例，建议使用更复杂的生成方式
			requestID = strings.ToLower(uuid.New().String())
		}
		// 将request-id设置到Gin的Context中，方便后续的handler获取
		c.Set(constant.RequestID, requestID)
		c.Header("X-Fc-Request-Id", requestID)
		c.Next()
	}
}
