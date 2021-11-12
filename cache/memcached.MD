Memcached

# 定义 #
内存对象缓存系统

# 内容 #
## 基本命令 ##
  - add key flags exptime bytes
  - replace key flags exptime bytes 
  - set key flags exptime bytes
  - delete key
  - get key
  - incr key
  - decr key
  - stats
  - flush_all
## 内存管理 ##
slab allocator
## 删除机制 ##
  - 惰性删除
  - LRU
## 分布式 ##
一致性hash算法
## 常见问题 ##
  - 雪崩
  - 无底洞
  - 永久数据被踢 