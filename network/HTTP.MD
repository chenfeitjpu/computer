# HTTP #

## 定义 ##
超文本传输协议

## 内容 ##
### 状态码 ###
  - 1xx 提示
  - 2xx 成功
    - 200 OK 正常
    - 204 No Content 没有body数据
    - 206 Partial Content 分段传输
  - 3xx 重定向
    - 301 Move Permanently 永久重定向 
    - 302 Found 临时重定向
    - 304 Not Modified 资源未修改
  - 4xx 客户端错误
    - 400 Bad Request 请求
    - 403 Forbidden
    - 404 Not Found
  - 5xx 服务端错误

## HTTP/0.9 ##
只有一个命令GET
服务器只能回应HTML格式的字符串
## HTTP/1.0 ##
除了GET命令，还引入了POST命令和HEAD命令
任何格式的内容都可以发送
## HTTP/1.1 ##
引入了持久连接，对于同一个域名，大多数浏览器允许同时建立6个持久连接。
引入了管道机制，在同一个TCP连接里面，客户端可以同时发送多个请求。
## SPDY协议 ##
## HTTP/2 ##
  - 二进制协议
  - 多工
  - 数据流
  - 头信息压缩
  - 服务器推送
  
