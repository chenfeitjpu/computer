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
  - int(整数)
  - embstr(短字符串)
  - raw(长字符串)

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
  - LREM key count value
  - LTRIM key start stop
  - LSET key index value
  - LINDEX key index
  - LRANGE key start stop
  - LLEN key
##### 内部编码 #####
  - ziplist(压缩列表)
  - linkedlist(链表)
  - quicklist(快速列表)

#### set ####
##### 操作 #####
  - SADD key member [member]
  - SREM key member member
  - SPOP key
  - SMOVE source destination member
  - SISMEMBER key member
  - SRANDOMMEMBER key count
  - SMEMBERS key
  - SINNER key key
  - SINNERSTORE destination key key
  - SUNION key key
  - SUNIONSTORE destination key key
  - SDIFF key key
  - SDIFFSTORE destination key key
  - SCARD key
##### 内部编码 #####
  - intset(整数集合)
  - hashtable(哈希表)

#### sorted set ####
##### 操作 #####
  - 
  - 
  - 
  - 
##### 内部编码 #####