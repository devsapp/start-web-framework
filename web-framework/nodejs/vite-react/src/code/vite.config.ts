import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [react()],
  server: {
    port: 9000, // 自定义开发服务器端口
  },
  build: {
    outDir: 'dist', // 自定义构建输出目录
  },
})
