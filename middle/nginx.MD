**Nginx**
- [定义](#定义)
- [使用](#使用)

# 定义 #
HTTP和反向代理服务器

# 使用 #
```
命令
- location
  - 分类
    - 精确匹配
      - = 
    - 普通匹配
      - 前缀匹配
        - ^~
    - 正则匹配
      - ～
        区分大小写
      - ～*
        不区分大小写
  - 优先级
    - 除正则匹配外的最长匹配
      - 精确匹配
        直接返回
      - 前缀匹配
        直接返回
      - 普通匹配
        - 有正则
          返回后面的第一个正则
        - 无正则
          直接返回
- rewrite
  - break  停止匹配
  - last  重新匹配
  - permanent  永久重定向，对应状态码301
  - redirect  临时重定向，对应状态码302

配置
- 负载均衡
  - proxy+upstream
    server {
        location / {
            proxy_pass http://domain;
        }
    }
    upstream domain{  
        server {ip}:{port} weight={weight} max_fails={max_fails} fail_timeout={fail_timeout};
    }  
- 动静分离
- 资源压缩
  http {
    gzip on;
  } 
- 白名单
  - allow
  - deny
```

参考资料  
[官网](https://nginx.org/)  
[Nginx一网打尽：动静分离、压缩、缓存、黑白名单、跨域、高可用、性能优化](https://zhuanlan.zhihu.com/p/656647646)