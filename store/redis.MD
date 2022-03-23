Redis
- [定义](#定义)
- [内容](#内容)
  - [键](#键)
    - [常用命令](#常用命令)
  - [库](#库)
    - [常用命令](#常用命令-1)
  - [数据类型](#数据类型)
    - [string](#string)
      - [常用命令](#常用命令-2)
      - [数据类型](#数据类型-1)
    - [list](#list)
      - [常用命令](#常用命令-3)
      - [数据结构](#数据结构)
    - [hash](#hash)
      - [常用命令](#常用命令-4)
      - [数据结构](#数据结构-1)
    - [set](#set)
      - [常用命令](#常用命令-5)
      - [数据结构](#数据结构-2)
    - [sorted set](#sorted-set)
      - [常用命令](#常用命令-6)
      - [数据结构](#数据结构-3)
    - [基数统计(HyperLogLog)](#基数统计hyperloglog)
      - [常用命令](#常用命令-7)
    - [位图(bitmap)](#位图bitmap)
      - [常用命令](#常用命令-8)
    - [地理位置(GEO)](#地理位置geo)
      - [常用命令](#常用命令-9)
    - [流(stream)](#流stream)
      - [常用命令](#常用命令-10)
  - [事务](#事务)
    - [常用命令](#常用命令-11)
  - [订阅](#订阅)
    - [常用命令](#常用命令-12)
  
# 定义 #
键值数据库

# 内容 #
## 键 ##
### 常用命令 ###
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
- TTL key
- PTTL key
- DBSIZE
  
## 库 ##
### 常用命令 ###
- SELECT db
- FLUSHDB
- FLUSHALL

## 数据类型 ##
### string ###
#### 常用命令 ####
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
  
#### 数据类型 ####
- int(整数)
- embstr(短字符串)
- raw(长字符串)

### list ###
#### 常用命令 ####
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
  
#### 数据结构 ####
- ziplist(压缩列表)
- linkedlist(链表)
- quicklist(快速列表)
  
### hash ###
#### 常用命令 ####
- HSET key field value
- HSETNX key field value
- HMSET key field value field value
- HDEL key field [field]
- HINCR key field increment
- HINCRBYFLOAT key field increment
- HEXISTS key field
- HGET key field
- HMGET key field field
- HKEYS key
- HVALUES key
- HGETALL key
- HLEN key

#### 数据结构 ####
- ziplist(压缩列表)
- hashtable(哈希表) 

### set ###
#### 常用命令 ####
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

#### 数据结构 ####
- intset(整数集合)
- hashtable(哈希表)

### sorted set ###
#### 常用命令 ####
- ZADD key score member [score member]
- ZREM key member [member]
- ZREMRANGEBYRANK key start stop
- ZREMRANGEBYSCORE key min max
- ZREMRANGEBYLEX key min max
- ZINCRBY key increment member
- ZRANK key member
- ZREVRANK key member
- ZSCORE key member
- ZRANGE key start stop [WITHSCORES]
- ZREVRANGE key start stop [WITHSCORES] 
- ZRANGEBYSCORE key min max [WITHSCORES] [LIMIT offset count]
- ZREVRANGEBYSCORE key min max [WITHSCORES]
- ZRANGEBYLEX key min max [LIMIT offset count]
- ZINTERSTORE destination numkeys key key
- ZUNIONSTORE destination numkeys key key
- ZCARD key
- ZCOUNT key min max
- ZLEXCOUNT key min max

#### 数据结构 ####
 - ziplist(压缩列表)
 - skiplist(跳表)

### 基数统计(HyperLogLog) ###
#### 常用命令 ####
- PFADD key element [element] 
- PFCOUNT key [key]
- PFMERGE destkey sourcekey sourcekey

### 位图(bitmap) ###
#### 常用命令 ####
- SETBIT key offset value
- GETBIT key offset
- BITPOS key bit [start] [end]
- BITCOUNT key [start] [end]
- BITOP operation destkey key key
- BITFIELD key [GET type offset] [SET TYPE offset value] [INCRBY type offset increment] [OVERFLOW WRAP|SAT|FAIL]

### 地理位置(GEO) ###
#### 常用命令 ####
- GEOADD key longitude latitude member [longitude latitude member]
- GEOPOS key member [member]
- GEODIST key member member [m|km|ft|mi]
- GEORADIUS key longitude latitude m|km|ft|mi [WITHCOORD] [WITHDIST] [WITHHASH] [COUNT count] [AES|DESC] [STORE key]
- GEORADIUSBYMEMBER key member m|km|ft|mi [WITHCOORD] [WITHDIST] [WITHHASH] [COUNT count] [AES|DESC] [STORE key]
- GEOHASH key member [member]

### 流(stream) ###
#### 常用命令 ####
- XADD key ID field value [field value]
- XDEL key ID [ID]
- XTRIM key [MAXLEN|MINIID] threshold [LIMIT count]
- XRANGE key start end [COUNT count]
- XREVRANGE key end start [COUNT count]
- XREAD [COUNT count] [BLOCK milliseconds] STREAMS key [key] id [id]
- XLEN key

## 事务 ##
### 常用命令 ###
- MULTI
- EXEC
- DISCARD
- WATCH key [key]
- UNWATCH

## 订阅 ##
### 常用命令 ###
- SUBSCRIBE channel [channel]
- PSUBSCRIBE pattern [pattern]
- UNSUBSCRIBE channel [channel]
- PUNSUBSCRIBE pattern [pattern]
- PUBLISH channel message
- PUBSUB subcommand [argument]


