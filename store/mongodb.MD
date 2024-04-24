MongoDb
- [定义](#定义)
- [使用](#使用)
  - [操作](#操作)
  - [查询](#查询)
  - [存储引擎](#存储引擎)
  - [集群](#集群)

# 定义 #
文档数据库

# 使用 #
## 操作 ##
```
数据库
- `show dbs`  查看所有数据库
- `db`  查看当前使用数据库
- `use DATABASE_NAME`  数据库不存在，则创建数据库，否则切换到指定数据库
- `db.dropDatabase()`  删除数据库

集合
- `show collections`  查看集合
- `db.createCollection(name, options)`  创建集合
- `db.COLLECTION_NAME.drop()`  删除集合

文档
- `db.COLLECTION_NAME.insertOne(document)`  添加单个文档
- `db.COLLECTION_NAME.insertMany([document, document])`  添加多个文档
- `db.COLLECTION_NAME.updateOne(query, update)`  更新单个文档
- `db.COLLECTION_NAME.updateMany(query, update)`  更新多个文档
- `db.COLLECTION_NAME.replaceOne(query, document)`  替换单个文档
- `db.COLLECTION_NAME.removeOne(query)`  删除单个文档
- `db.COLLECTION_NAME.removeMany(query)`  删除多个文档
- `db.COLLECTION_NAME.find(query)`  查询文档

索引
- `db.COLLECTION_NAME.getIndexes()`  查询索引
- `db.COLLECTION_NAME.createIndex(keys, options)`  添加索引
- `db.COLLECTION_NAME.dropIndexes()`  删除所有索引
- `db.COLLECTION_NAME.dropIndex(name)`  删除索引
```

## 查询 ##
```
运算符
- 比较运算符
  - $gt
  - $gte
  - $lt
  - $lte
  - $ne
- 逻辑运算符
  - $and
  - $or
  - $not
  - $nor
- 类型操作符
  - $type
- 正则
  - //
  - $regex

结果集
- sort(keys)
- skip(number)
- limit(number)

聚合
- 单一命令
  - db.COLLECTION_NAME.countDocuments(query, options)
  - db.COLLECTION_NAME.distinct(field, query, options)    
- 管道
  - db.COLLECTION_NAME.aggregate   
```

## 存储引擎 ##

## 集群 ##