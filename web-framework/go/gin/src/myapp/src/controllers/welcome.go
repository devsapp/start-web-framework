package controllers

import (
	"github.com/gin-gonic/gin"
)

func SetupWelcomeRouters(e *gin.Engine) {
	e.GET("/", RenderWelcomePage)
}

// RenderWelcomePage 渲染首页
func RenderWelcomePage(c *gin.Context) {
	c.HTML(200, "index.html", gin.H{
		"title": "CAP Gin Demo - Powered By CAP",
	})
}
