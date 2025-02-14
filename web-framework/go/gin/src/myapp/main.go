package main

import (
	"github.com/gin-gonic/gin"

	"myapp/pkg/logging"
	"myapp/src/routes"
)

func main() {
	router := gin.Default()
	router.Use(logging.RequestIDMiddleware())

	// 设置静态文件路径
	router.Static("/assets", "./assets")

	// 加载视图文件
	router.LoadHTMLGlob("views/*")

	// 初始化路由
	routes.InitRoutes(router)

	// 运行服务器
	router.Run(":8080") // 监听并在 0.0.0.0:8080 上启动服务
}
