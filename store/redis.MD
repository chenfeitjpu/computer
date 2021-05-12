# Redis #

## 定义 ##
键值对数据库

## 内容 ##
### 键 ###
#### 操作 ####
  - KEYS pattern
  - SCAN CURSOR MATCH pattern COUNT count
  - EXISTS key
  - TYPE key
  - RANDOMKEY
  - DEL key
  - UNLINK key
  - RENAME key newkey
  - RENAMENX key newkey
  - MOVE key db
  - DUMP key
  - EXPIRE key second
  - PEXPIRE key millisecond
  - EXPIREAT key timestamp
  - PEXPIREAT key millitimestamp
  - PERSIST key
  - DBSIZE
### 库 ###
#### 操作 ####
  - SELECT db
  - FLUSHDB
  - FLUSHALL

### 数据结构 ###
#### string ####
##### 操作 #####
  - SET key value [EX second | PX millisecond] [nx | xx]
  - SETEX key second value
  - PSETEX <key> <millisecond> <value>
  - SETNX key value
  - MSET key value [key value]
  - MSETNX key value [key value]
  - GETSET key value
  - APPEND key value
  - SETRANGE key offset value
  - INCR key
  - INCRBY key increment
  - INCRBYFLOAT key increment
  - DECR key
  - DECRBY key decrement
  - GET key
  - MGET key [key]
  - GETRANGE key start end
  - STRLEN key
##### 内部编码 #####
  - int
  - embstr
  - raw

#### list ####
##### 操作 #####
  - LPUSH key value [value]
  - LPUSHX key value [value]
  - RPUSH key value [value]
  - RPUSHX key value [value]
  - LINSERT key BEFORE|AFTER pivot value
  - LPOP key
  - BLPOP key [key] timeout 
  - RPOP key
  - BRPOP key [key] timeout
  - RPOPLPUSH source destination
  - BRPOPLPUSH source destination timeout
