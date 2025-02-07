package services

import (
	"os"

	"github.com/aliyun/aliyun-oss-go-sdk/oss"

	"myapp/pkg/constant"
)

type OssService struct {
	ossClient *oss.Client
}

func NewOSSServiceFromEnv() *OssService {
	regionID := os.Getenv(constant.FC_REGION)
	accessKeyID := os.Getenv(constant.ALIBABA_CLOUD_ACCESS_KEY_ID)
	accessKeySecret := os.Getenv(constant.ALIBABA_CLOUD_ACCESS_KEY_SECRET)
	securityToken := os.Getenv(constant.ALIBABA_CLOUD_SECURITY_TOKEN)
	endpoint := "oss-" + regionID + "-internal.aliyuncs.com"

	ossClient, err := oss.New(endpoint, accessKeyID, accessKeySecret, func(client *oss.Client) {
		client.Config.SecurityToken = securityToken
	})
	if err != nil {
		panic(err)
	}
	return &OssService{
		ossClient: ossClient,
	}
}

func (s *OssService) ListBuckets() ([]oss.BucketProperties, error) {
	res, err := s.ossClient.ListBuckets()
	if err != nil {
		return nil, err
	}
	return res.Buckets, nil
}
