**HTTP**
- [简介](#简介)
- [数据结构](#数据结构)
- [参数详解](#参数详解)
- [协议特点](#协议特点)
- [安全问题](#安全问题)
- [RESTFUL API](#restful-api)

## 简介
```
定义
超文本传输协议(HyperText Transfer Protocol)
```

## 数据结构
```
请求
- 请求行  METHOD PATH SCHEME/VERSION
- 请求头  {key: value}
- 空行
- 请求体

响应
- 响应行  SCHEME/VERSION STATUS_CODE STATUS_TEXT 
- 响应头  {key: value}
- 空行
- 响应体
```

## 参数详解
```
请求方法
- 常见
  - GET  从服务器获取资源，安全且幂等
  - HEAD  请求头信息，获取资源元信息，安全且幂等
  - OPTIONS  询问服务器支持的功能选项，安全且幂等
  - TRACE  回显服务器收到的请求，主要用于测试或诊断
  - POST  新增资源，不安全且不幂等
  - PUT  更新完整资源，不安全且幂等
  - PATCH  部分更新，不安全且幂等
  - DELETE  删除资源，不安全且幂等
- GET&POST区别
  - 接口特性
    - GET  获取资源，安全且幂等
    - POST  新增资源，不安全且不幂等
  - 参数位置(语义上的)
    - GET  请求参数放在URL中，只能是字符串，且长度受客户端限制
    - POST  请求参数放在请求体，可以是各种数据格式
  - 缓存
    - GET  默认缓存请求结果
    - POST  默认不会缓存请求结果

状态码
- 1xx 提示信息，协议处理的中间状态，还需要后续的操作
  - 101 协议切换
- 2xx 成功，报文已经收到并被正确处理
  - 200 OK 正常
  - 204 No Content 没有body数据
  - 206 Partial Content 分段传输
- 3xx 资源变动
  - 301 Move Permanently 永久重定向，浏览器会缓存请求，搜索引擎存储新网址
  - 302 Found 临时重定向，浏览器不会缓存请求，搜索引擎存储的旧网址
  - 304 Not Modified 资源未修改
- 4xx 客户端错误，请求报文有误，服务器无法处理
  - 400 Bad Request 请求报文有误
  - 401 Unauthorized  认证错误
  - 403 Forbidden 认证成功，没有授权
  - 404 Not Found 请求资源不存在
- 5xx 服务端错误，服务器在处理请求时内部发生了错误
  - 500 服务器内部错误 
  - 502 服务器作为网关或代理，从上游服务器收到无效的响应，回了，但是出错了
  - 503 服务器忙，暂时无法响应
  - 504 服务器作为网关或代理，未能及时从上游服务器收到响应，一直不回，超时了

长连接
复用TCP连接，在一个TCP连接上，发送多次HTTP请求/响应
- 设置
  - 开启  Connection: keep-alive HTTP/1.1 默认开启
  - 断开  Connection: close
- 断开连接
  - 客户端
    - 空闲超时(几十秒到几分钟)
    - 进程退出
  - 服务端
    - 空闲超时(几十秒到几分钟)，长时间没有请求，服务器会主动关闭连接
    - 请求数到达上限，一个连接内最多处理N个请求，超过后关闭

缓存技术
把响应结果存起来
- 强制缓存  
  - Cache-Control 是一个相对时间，max-age=600，资源600秒内直接用本地缓存
  - Expires 是一个绝对时间  
  Cache-Control的优先级高于Expires
- 协商缓存  
  - 基于内容(ETag / If-None-Match)
    - 响应：ETag: "v1.2.3"
    - 下次请求：If-None-Match: "v1.2.3"
    - 若内容没变 → 返回 304
  - 基于时间(Last-Modified / If-Modified-Since)  
    - 响应：Last-Modified: Tue, 26 Jan 2026 12:00:00 GMT
    - 下次请求：If-Modified-Since: Tue, 26 Jan 2026 12:00:00 GMT
    - 若没变 → 服务器返回 304
    Etag的优先级更高  
```

## 协议特点
```
HTTP1.1
- 特点  
  简单、易扩展、跨平台
- 缺点  
  - 无状态(上下文环境)
    - 目的  高效
    - 保持状态
      - cookie  客户端进行数据存储
      - session  服务端进行会话管理
      - 联系
        Session通过Cookie的SessionID来实现
      - 区别
        - Cookie保存在客户端，Session保存在服务器端  
        - Cookie存储在客户端，比较容易遭到不法获取，Session存储在服务端，安全性相对Cookie要好一些
        - 单个Cookie保存的数据不能超过4K，Session无限制
        - Cookie可设置为长时间保持，Session一般失效时间较短，客户端关闭或者Session超时都会失效
  - 不安全
    - 明文传输，内容可能会被窃听
    - 不验证通信身份，可能会被冒充
    - 无法验证报文完整性，内容可能会被篡改  
- 性能  
  HTTP协议是基于TCP/IP，并且使用了「请求-应答」的通信模式  
  - 长连接 减少了TCP连接的重复建立和断开所造成的额外开销，减轻了服务器端的负载
  - HTTP队头阻塞  上一个请求没有得到相应，其它请求需要阻塞等待
- 优化    
  - 尽量避免发送HTTP请求(缓存)
  - 在需要发送HTTP请求时，考虑如何减少请求次数(减少重定向、合并、延迟)
  - 减少服务器的HTTP响应的数据大小(压缩)

HTTPS
- 特点  
  - 将服务器公钥放入到数字证书，解决了冒充风险  
  - 混合加密实现机密性，解决了窃听风险
  - 摘要算法实现完整性，解决了篡改风险
- SSL/TLS通信流程  
  - 客户端向服务器索要并验证证书
  - 双方协商生成会话秘钥
  - 双方采用会话秘钥进行通信
- RSA握手流程  
  - 客户端发送Client Hello(客户端使用的SSL/TLS协议版本&随机数&可用密码套件列表)
  - 服务端发送Server Hello(服务端支持的SSL/TLS协议版本&随机数&选定的密码套件)、Certificate(CA证书)、Server Hello Done请求
  - 客户端发情Client Key Exchange(随机数、公钥加密)、Change Cipher Spec(加密算法改变通知)、Encrypted Handshake Message(摘要信息)
  - 服务端发送Change Cipher Spec(加密算法改变通知)、Encrypted Handshake Message(服务端握手结束通知)
  缺点
  - 不支持前向保密
- ECDHE握手流程 
  - 客户端发送Client Hello(客户端使用的SSL/TLS协议版本&随机数&可用密码套件列表)
  - 服务端发送Server Hello(服务端支持的SSL/TLS协议版本&随机数&密码套件列表)、Certificate(CA证书)、Server Key Exchange(服务端的椭圆曲线公钥、私钥加密)、Server Hello Done请求
  - 客户端发情Client Key Exchange(客户端的椭圆曲线公钥)、Change Cipher Spec(加密算法改变通知)、Encrypted Handshake Message(摘要信息)
  - 服务端发送Change Cipher Spec(加密算法改变通知)、Encrypted Handshake Message(服务端握手结束通知)

HTTP2
- 特点
  - 二进制帧  HTTP/2不再用纯文本报文，而是把请求/响应拆成很多帧(frame)，用二进制编码
  - 头部压缩  对重复度很高的HTTP头进行压缩，客户端和服务器两端都会建立和维护字典，用长度较小的索引号表示重复的字符串，字典分为静态表编码，动态表编码
  - 并发传输  多个请求在同一条TCP连接上的不同流(stream)并发发送
  - 服务器推送  服务器可以在客户端请求HTML时，主动推送相关资源(CSS/JS)
- 缺点
  - TCP队头阻塞  一旦这条TCP连接上有丢包，底层TCP必须按序重传

HTTP3
- QUIC
```

## 安全问题
```
XSS(跨站脚本攻击)
恶意脚本被注入页面并在浏览器执行
- 转义  对输出到HTML的数据做转义
- 过滤  过滤掉敏感内容
- 开启CSP(Content-Security-Policy) 限制可执行脚本来源

CSRF(跨站请求伪造)
利用用户已登录状态伪造请求
- Token校验 服务端生成随机token，放在页面中，每次提交时带上，服务端校验token是否正确
- Referer校验  检查请求是否来自可信域名
- 设置SameSite Cookie
```

## RESTFUL API
```
一种设计Web接口的风格，以资源为导向，通过统一的URL(一种资源只有一个URL)和HTTP方法(增删改查)来操作这些资源
https://domain/version/resource?filter(key=value)
- 协议  总是使用https协议
- 域名  使用api专用域名
- 版本  放入URL中
- 路径  使用资源表示
- 过滤  
- 操作  GET、POST、PUT、PATCH、DELETE
- 返回结果  Status Code
- 返回内容  使用JSON格式，根据请求资源返回单个或者多个
```
  
