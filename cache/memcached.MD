**Memcached**
- [定义](#定义)
- [内容](#内容)
  - [基本命令](#基本命令)
  - [内存管理](#内存管理)
  - [删除机制](#删除机制)
  - [分布式](#分布式)
  - [常见问题](#常见问题)

# 定义 #
内存对象缓存系统

# 内容 #
## 基本命令 ##
  - `add key flags exptime bytes` 添加
  - `replace key flags exptime bytes` 修改
  - `set key flags exptime bytes` 设置
  - `delete key` 删除
  - `get key` 获取
  - `incr key` 自增
  - `decr key` 自减
  - `stats` 查看状态
  - `flush_all` 刷新所有数据
 
## 内存管理 ##
slab allocator

## 删除机制 ##
  - **惰性删除**
  - **LRU**

## 分布式 ##
一致性hash算法

## 常见问题 ##
  - **雪崩**
  - **无底洞**
  - **久数据被踢**