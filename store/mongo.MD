MongoDb

# 定义 #
文档数据库

# 内容 #
## 库 ##
### 操作 ###
  - show dbs
  - db
  - use DATABASE_NAME
  - db.dropDatabase()

## 集合 ##
### 操作 ###
  - show collections
  - db.createCollection(name, option)
  - db.COLLECTION_NAME.drop()

## 文档 ##
### 操作 ###
  - db.COLLECTION_NAME.insert()
  - db.COLLECTION_NAME.update()
  - db.COLLECTION_NAME.remove()
  - db.COLLECTION_NAME.find()

## 查询 ##
### 操作 ###
#### 比较运算符 ####
  - $gt
  - $gte
  - $lt
  - $lte
  - $ne
#### 逻辑运算符 ####
  - $and
  - $or
  - $not
  - $nor
#### 类型操作符 ####
  - $type
#### 正则 ####
  - //
  - $regex
  