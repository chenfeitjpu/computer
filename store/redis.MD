Redis

# 定义 #
键值对数据库

# 内容 #
## 键 ##
### 操作 ###
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
## 库 ##
### 操作 ###
  - SELECT db
  - FLUSHDB
  - FLUSHALL

## 数据结构 ##
### 字符串(string) ###
#### 操作 ####
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
#### 内部编码 ####
  - int(整数)
  - embstr(短字符串)
  - raw(长字符串)

### 哈希(hash) ###
#### 操作 ####
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

#### 内部编码 ####
  - ziplist(压缩列表)
  - hashtable(哈希表)
  - 

### 列表(list) ###
#### 操作 ####
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
#### 内部编码 ####
  - ziplist(压缩列表)
  - linkedlist(链表)
  - quicklist(快速列表)

### 集合(set) ###
#### 操作 ####
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
#### 内部编码 ####
  - intset(整数集合)
  - hashtable(哈希表)

### 有序集合(sorted set) ###
#### 操作 ####
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
#### 内部编码 ####
   - ziplist(压缩列表)
   - skiplist(跳表)

### 基数统计(HyperLogLog) ###
#### 操作 ####
  - PFADD key element [element] 
  - PFCOUNT key [key]
  - PFMERGE destkey sourcekey sourcekey

### 位图(bitmap) ###
#### 操作 ####
  - SETBIT key offset value
  - GETBIT key offset
  - BITPOS key bit [start] [end]
  - BITCOUNT key [start] [end]
  - BITOP operation destkey key key
  - BITFIELD key [GET type offset] [SET TYPE offset value] [INCRBY type offset increment] [OVERFLOW WRAP|SAT|FAIL]


