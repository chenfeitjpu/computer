**HTTP**
- [定义](#定义)
- [内容](#内容)

# 定义 #
超文本传输协议(HyperText Transfer Protocol)

# 内容 #
```
数据结构
- 请求
  请求行  请求方法 URL 协议/版本
  请求头  key: value
  空行
  请求体
- 响应
  响应行  协议/版本 状态码 描述 
  响应头  key: value
  空行
  响应体

状态码
- 1xx 提示信息，协议处理的中间状态，还需要后续的操作
  - 101 协议切换
- 2xx 成功，成功处理请求
  - 200 OK 正常
  - 204 No Content 没有body数据
  - 206 Partial Content 分段传输
- 3xx 重定向，资源位置发生变动，需要客户端重新发送请求
  - 301 Move Permanently 永久重定向 浏览器会缓存请求  搜索引擎存储新网址
  - 302 Found 临时重定向  浏览器不会缓存请求  搜索引擎存储的旧网址
  - 304 Not Modified 资源未修改
- 4xx 客户端错误，请求报文有误，服务器无法处理
  - 400 Bad Request 请求报文有误
  - 403 Forbidden 禁止访问
  - 404 Not Found 请求资源不存在
- 5xx 服务端错误，服务器在处理请求时内部发生了错误
  - 500 服务器错误 
  - 502 服务器作为网关或代理，后端服务器发生了错误
  - 503 服务器忙，暂时无法响应
  - 504 服务器作为网关或代理，服务器超时

常见字段
- Host 服务器主机
- Connection 使用持久连接
  超时控制
  - 服务端可以设置keep-alive timeout
  - 设置头信息keep-alive:timeout={time}
- Accept 客户端接受的数据格式
- Accept-Encoding 客户端接受的数据压缩方式
- Content-Length 服务器返回的数据长度
- Content-Type 服务器返回的数据格式
- Content-Encoding 服务器返回数据的压缩方式

请求方法
- GET  从服务器获取资源 安全且幂等
- HEAD  请求头信息，获取资源元信息 安全且幂等
- POST  修改支持 不安全且不幂等
- PUT  修改资源 不安全且幂等
- DELETE  删除资源 不安全且幂等
- TRACE  回显服务器收到的请求，主要用于测试或诊断
- OPTIONS  询问服务器支持的功能选项

缓存技术
- 强制缓存  
  - Cache-Control 是一个相对时间
  - Expires 是一个绝对时间  
  Cache-Control的优先级高于Expires

- 协商缓存  
  - 基于时间  
    - 响应头部中的Last-Modified
      标示资源的最后修改时间
    - 请求头部中的If-Modified-Since 
  - 基于内容
    - 响应头部中Etag  
      唯一标识资源
    - 请求头部中的If-None-Match
    Etag的优先级更高  

HTTP1.1特性
优点  
- 简单 
- 易扩展
- 跨平台
缺点  
- 无状态
- 不安全
  - 明文传输，内容可能会被窃听
  - 不验证通信身份，可能会被冒充
  - 无法验证报文完整性，内容可能会被篡改  
性能  
HTTP协议是基于TCP/IP，并且使用了「请求-应答」的通信模式  
- 长连接 减少了TCP连接的重复建立和断开所造成的额外开销，减轻了服务器端的负载
- HTTP队头阻塞
优化    
- 尽量避免发送HTTP请求(缓存)
- 在需要发送HTTP请求时，考虑如何减少请求次数(减少重定向、合并、延迟)
- 减少服务器的HTTP响应的数据大小(压缩)

HTTPS
特点  
  - 混合加密实现机密性，解决了窃听风险
  - 摘要算法实现完整性，解决了篡改风险
  - 将服务器公钥放入到数字证书，解决了冒充风险  
SSL/TLS通信流程  
  - 客户端向服务器索要并验证公钥
  - 双方协商生成会话秘钥
  - 双方采用会话秘钥进行通信
RSA握手流程  
  - 客户端发送Client Hello(客户端使用的SSL/TLS协议版本&随机数&可用密码套件列表)
  - 服务端发送Server Hello(服务端支持的SSL/TLS协议版本&随机数&选定的密码套件)、Certificate(CA证书)、Server Hello Done请求
  - 客户端发情Client Key Exchange(随机数)、Change Cipher Spec(加密算法改变通知)、Encrypted Handshake Message(摘要信息)
  - 服务端发送Change Cipher Spec(加密算法改变通知)、Encrypted Handshake Message(服务端握手结束通知)
  缺点
  不支持前向保密
ECDHE握手流程 
  - 客户端发送Client Hello(客户端使用的SSL/TLS协议版本&随机数&可用密码套件列表)
  - 服务端发送Server Hello(服务端支持的SSL/TLS协议版本&随机数&密码套件列表)、Certificate(CA证书)、Server Key Exchange(服务端的椭圆曲线公钥)、Server Hello Done请求
  - 客户端发情Client Key Exchange(客户端的椭圆曲线公钥)、Change Cipher Spec(加密算法改变通知)、Encrypted Handshake Message(摘要信息)
  - 服务端发送Change Cipher Spec(加密算法改变通知)、Encrypted Handshake Message(服务端握手结束通知)

HTTP2特性
优化 
  - 头部压缩
    - 静态表编码
    - 动态表编码
    - Huffman编码
  - 二进制格式
    - 帧数据通过HPACK算法进行压缩
  - 并发传输
  - 服务器推送  
缺点
  - TCP队头阻塞

cookie

session
分布式session
- session复制
- session前端存储
- session粘滞
- session后端存储

安全问题
XSS 
  - 过滤
  - 转义
CSRF
  - Referer校验
  - Token校验
```

  
