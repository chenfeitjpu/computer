**php**
- [简介](#简介)
- [数据结构](#数据结构)
- [内存管理](#内存管理)
- [并发控制](#并发控制)

## 简介
```
优势
web开发效率高+网站生态

PHP-FPM的工作模式
- master进程  管理worker
- worker进程  处理请求

一个PHP请求的生命周期
- Nginx接收请求
- 转发给PHP-FPM
- worker解析脚本
- 执行opcode
- 返回结果
- 释放内存

数据类型
- int、float、bool、string
- array、object
- resource、null
```

## 数据结构
```
zval
zval是PHP中变量的底层数据结构
- 结构
  - value  实际数据，固定大小
    - refcount  引用计数
  - type_into  数据类型
  - extra  扩展信息

array
PHP数组底层是一个HashTable（哈希表）
- 哈希索引
- bucket数据
  - key
  - hash
  - value
```

## 内存管理
```
Copy On Write（写时拷贝）
- 多个变量指向同一个zval
- 只有当某个变量被修改时才会复制
- 避免无意义内存拷贝，提高性能

内存分配
- 大对象(3KB)  直接调用操作系统malloc()
- 小对象(<=3KB)  ZMM使用内存池(memory pool)
  - Chunk(2MB)
  - Page(4KB)
  - Block(size class)

垃圾回收
- 引用计数(主机制)
- 循环垃圾回收(辅助机制)
  - root buffer(可能参与循环引用的对象)达到阀值(10000)，会触发垃圾回收，加入后会标为紫色
  - 遍历root buffer，减少引用，把对象置灰
  - 遍历root buffer，引用数为0的对象置白，引用数大于0的置黑
  - 遍历root buffer，删除白色垃圾对象
```

## 并发控制
```
```