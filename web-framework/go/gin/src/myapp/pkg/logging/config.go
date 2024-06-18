package logging

import (
	"fmt"
	"os"
	"time"

	"github.com/sirupsen/logrus"

	"myapp/pkg/constant"
)

type customFormatter struct{}

func (f *customFormatter) Format(entry *logrus.Entry) ([]byte, error) {
	timestamp := entry.Time.Format(time.RFC3339)
	message := entry.Message
	level := entry.Level.String()
	requestID, ok := entry.Data[constant.RequestID]
	if !ok {
		requestID, ok = entry.Context.Value(constant.RequestID).(string)
		if !ok {
			requestID = ""
		}
	}

	// 注意：获取调用者的代码路径需开启logrus的ReportCaller，这会有性能开销
	caller := "unknown"
	if entry.HasCaller() {
		caller = fmt.Sprintf("%s:%d", entry.Caller.File, entry.Caller.Line)
	}

	log := fmt.Sprintf("%s - %s - %s - %s: %s\n", timestamp, requestID, level, caller, message)
	return []byte(log), nil
}

func init() {
	formatter := &customFormatter{}
	logrus.SetFormatter(formatter)
	logrus.SetReportCaller(true)
	logrus.SetLevel(logrus.InfoLevel)
	logrus.SetOutput(os.Stdout)
}
