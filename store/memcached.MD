**memcached**
- [定义](#定义)
- [内容](#内容)
  - [基本语法](#基本语法)
  - [内存管理](#内存管理)
  - [删除机制](#删除机制)

# 定义 #
内存缓存系统

# 内容 #
## 基本语法 ##
```
常用命令
- `add key flags exptime bytes` 添加
- `replace key flags exptime bytes` 修改
- `set key flags exptime bytes` 设置
- `delete key` 删除
- `get key` 获取
- `incr key` 自增
- `decr key` 自减
- `stats` 查看状态
- `flush_all` 刷新所有数据

注意事项
- key最多250个字节
- value最大1M
- 过期时间最长30天
```
 
## 内存管理 ##
```
内存分配
slab allocator

  - **惰性删除**
  - **LRU**
```

## 删除机制 ##
```
