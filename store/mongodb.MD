MongoDb
- [定义](#定义)
- [使用](#使用)
  - [简介](#简介)
  - [数据操作](#数据操作)
  - [数据存储](#数据存储)
  - [事务](#事务)
  - [集群](#集群)

# 定义 #
基于分布式文件存储的开源NoSQL数据库系统，提供了面向文档的存储方式

# 使用 #
## 简介 ##
```
特点
- 灵活性  数据模型是动态的
- 横向扩展  通过分片实现数据的扩展

组成
- database
- collection
- document
```

## 数据操作 ##
```
- 基本命令
  - 数据库
    - `show dbs`  查看所有数据库
    - `db`  查看当前使用数据库
    - `use DATABASE_NAME`  数据库不存在，则创建数据库，否则切换到指定数据库
    - `db.dropDatabase()`  删除数据库
  - 集合
    - `show collections`  查看集合
    - `db.createCollection(name, options)`  创建集合
    - `db.COLLECTION_NAME.drop()`  删除集合
  - 文档
    - `db.COLLECTION_NAME.insertOne(document)`  添加单个文档
    - `db.COLLECTION_NAME.insertMany([document, document])`  添加多个文档
    - `db.COLLECTION_NAME.updateOne(query, update)`  更新单个文档
    - `db.COLLECTION_NAME.updateMany(query, update)`  更新多个文档
    - `db.COLLECTION_NAME.replaceOne(query, document)`  替换单个文档
    - `db.COLLECTION_NAME.deleteOne(query)`  删除单个文档
    - `db.COLLECTION_NAME.deleteMany(query)`  删除多个文档
    - `db.COLLECTION_NAME.find(query)`  查询文档
    - `db.COLLECGION_NAME.bulkWrite()`  批量操作
  - 运算符
    - 比较运算符  
      $gt、$gte、$lt、$lte、$ne
    - 逻辑运算符
      $and、$or、$not、$nor
    - 类型操作符
      $type
    - 正则
      //、$regex
  - 结果集
    - sort(keys)
    - skip(number)
    - limit(number)

索引
- 操作
  - `db.COLLECTION_NAME.getIndexes()`  查询索引
  - `db.COLLECTION_NAME.createIndex(keys, options)`  添加索引
  - `db.COLLECTION_NAME.dropIndexes()`  删除所有索引
  - `db.COLLECTION_NAME.dropIndex(name)`  删除索引
- 实现
  - key string
    将BSON比较流程转换为memcmp二进制比较流程
  
聚合
- 单一命令
  - db.COLLECTION_NAME.countDocuments(query, options)
  - db.COLLECTION_NAME.distinct(field, query, options)    
- 管道
  - db.COLLECTION_NAME.aggregate   
```

## 数据存储 ##
```
bson
- 好处
  - 丰富的数据类型
  - 不做数据类型转换
    - 访问速度更快
    - 存储空间更低
  - 二进制格式，解析性能高
  - 字段长度前置，随机访问快
```

## 事务 ##
```
```

## 集群 ##
```
主从

分片

```


学习资料  
[官方文档](https://www.mongodb.com/docs/manual/)  
[中文文档](https://www.mongodb.com/zh-cn/docs/manual/)  
[MongoDB常见面试题总结](https://javaguide.cn/database/mongodb/mongodb-questions-01.html)
[MongoDB内核技术解密](https://github.com/pengzhenyi2015/MongoDB-Kernel-Study)