MongoDb
- [定义](#定义)
- [内容](#内容)
  - [基本命令](#基本命令)
  - [查询](#查询)

# 定义 #
文档数据库

# 内容 #
## 基本命令 ##
```
数据库
- `show dbs`  查看所有数据库
- `db`  查看当前数据库
- `use DATABASE_NAME`  数据库不存在，则创建数据库，否则切换到指定数据库
- `db.dropDatabase()`  删除数据库

集合
- `show collections`  查看集合
- `db.createCollection(name, option)`  显示创建集合
- `db.COLLECTION_NAME.drop()`  删除集合

文档
- `db.COLLECTION_NAME.insert()`  添加文档
- `db.COLLECTION_NAME.update()`  修改文档
- `db.COLLECTION_NAME.remove()`  删除文档
- `db.COLLECTION_NAME.find()`  查询文档

索引
- `db.COLLECTION_NAME.getIndexes`  查询索引
- `db.COLLECTION_NAME.createIndex`  添加索引
- `db.COLLECTION_NAME.dropIndex`  删除索引
- `db.COLLECTION_NAME.dropIndexes`  删除所有索引
```

## 查询 ##
```
比较运算符
- $gt
- $gte
- $lt
- $lte
- $ne

逻辑运算符
- $and
- $or
- $not
- $nor

类型操作符
- $type

正则
- //
- $regex

结果集
- sort
- limit
- skip

聚合
单一命令
- count
- distinct
分解
- mapReduce 
管道
- aggregate
```
  