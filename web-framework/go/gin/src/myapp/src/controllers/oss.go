package controllers

import (
	logger "github.com/sirupsen/logrus"

	"myapp/pkg/services"

	"github.com/gin-gonic/gin"
	"github.com/pkg/errors"
)

func SetupOSSRouters(e *gin.Engine) {
	g := e.Group("/oss")
	f := &OSSFunc{
		ossService: services.NewOSSServiceFromEnv(),
	}
	g.GET("/listBuckets", f.ListBuckets)
}

type OSSFunc struct {
	ossService *services.OssService
}

func (s *OSSFunc) ListBuckets(c *gin.Context) {
	result, err := s.ossService.ListBuckets()
	if err != nil {
		logger.WithContext(c).Errorf("failed to list buckets: %v", err)
		c.JSON(500, gin.H{
			"error": errors.Wrapf(err, "failed to list buckets").Error(),
		})
	}
	c.JSON(200, result)
}
