**Redis**
- [定义](#定义)
- [使用](#使用)
  - [基础命令](#基础命令)
  - [数据类型](#数据类型)
    - [字符串(string)](#字符串string)
    - [列表(list)](#列表list)
    - [哈希(hash)](#哈希hash)
    - [集合(set)](#集合set)
    - [有序集合(sorted set)](#有序集合sorted-set)
    - [位图(bitmap)](#位图bitmap)
    - [基础统计(hyperloglog)](#基础统计hyperloglog)
    - [位置(geo)](#位置geo)
    - [流(stream)](#流stream)
  - [数据结构](#数据结构)
    - [Redis存储模型](#redis存储模型)
    - [Redis对象](#redis对象)
    - [SDS](#sds)
  - [事务](#事务)
  - [订阅](#订阅)
  
# 定义 #
键值数据库

# 使用 #
## 基础命令 ##
```
键  
- `KEYS pattern`  查找所有符合给定模式的键
- `SCAN cursor [MATCH pattern] [COUNT count]`  迭代数据库中的键
- `EXISTS key`  检查给定键是否存在
- `TYPE key`  返回键所储存的值的类型
- `RANDOMKEY`  随机返回一个键
- `DEL key`  删除键
- `UNLINK key`  异步删除键
- `RENAME key newkey`  修改键的名称
- `RENAMENX key newkey`  修改键的名称, 新键不存在
- `MOVE key db`  将当前数据库的键移动到给定的数据库db中
- `DUMP key`  序列化键
- `EXPIRE key second`  设置键过期时间，以秒计
- `PEXPIRE key millisecond`  设置键过期时间，以毫秒计
- `EXPIREAT key second`  设置键过期时间的时间戳，以秒计
- `PEXPIREAT key millisecond`  设置键过期时间的时间戳，以毫秒计
- `PERSIST KEY`  设置键永久有效
- `TTL key`  以秒为单位返回键的剩余过期时间
- `PTTL key`  以毫秒为单位返回键的剩余过期时间

库  
- `SELECT db`  切换数据库
- `FLUSHDB`  清空当前数据库中的所有键
- `FLUSHALL`  清空所有数据库的所有键
- `DBSIZE`  当前数据库的key数量

string 
- `SET key value [EX second | PX millisecond] [EXAT timestamp | PXAT timestamp] [nx | xx] [GET] [KEEPTTL]` 设置键值对
- `SETNX key value` 设置键值对，key不存在
- `SETEX key second value` 设置过期时间，以秒为单位
- `PSETEX key millisecond value` 设置过期时间，以毫秒为单位
- `GET key` 获取key
- `GETSET key value` 设置新值，返回旧值
- `APPEND key value` 追加值
- `INCR key` 自增1
- `INCRBY key increment` 指定自增量，整数
- `INCRBYFLOAT key increment` 指定自增量，浮点数
- `DECR key` 自减1
- `DECRBY key decrement` 指定自减量，整数
- `MSET key value [key value]` 批量设置
- `MSETNX key value [key value]` 批量设置，key不存在
- `MGET key [key]` 批量获取key
- `SETRANGE key offset value` 从指定位置覆盖值 
- `GETRANGE key start end` 获取指定位置字符串
- `STRLEN key` 获取字符串长度

list 
- `LPUSH key value [value]` 左边添加列表元素
- `LPUSHX key value [value]` 左边添加列表元素，key已存在
- `RPUSH key value [value]` 右边添加列表元素
- `RPUSHX key value [value]` 右边添加列表元素，key已存在
- `LINSERT key BEFORE|AFTER pivot value` 在指定位置添加列表元素
- `LPOP key` 左边移除列表元素
- `BLPOP key [key] timeout` 左边移除列表元素，等待指定时间
- `RPOP key` 右边边移除列表元素
- `BRPOP key [key] timeout` 右边移除列表元素，等待指定时间
- `RPOPLPUSH source destination` 右边移除列表元素，左边追加列表元素
- `BRPOPLPUSH source destination timeout` 右边移除列表元素，左边追加列表元素，等待指定时间
- `LREM key count value` 移除列表元素
- `LTRIM key start stop` 保留列表指定区间的元素
- `LSET key index value` 通过索引设置列表的值
- `LINDEX key index` 通过索引获取列表的值
- `LRANGE key start stop` 获取指定范围的值
- `LLEN key` 获取列表长度

hash
- `HSET key field value`  设置哈希表字段
- `HSETNX key field value`  设置哈希表字段，属性不存在
- `HMSET key field value field value`  批量设置哈希表字段
- `HGET key field`  获取哈希表字段
- `HMGET key field field`  批量获取哈希表字段
- `HDEL key field [field]`  删除哈希表字段
- `HINCR key field increment`  自增，按整型值
- `HINCRBYFLOAT key field increment`  自增，按浮点值
- `HEXISTS key field`  判断哈希表字段是否存在
- `HKEYS key`  获取哈希表所有字段
- `HVALS key` 获取哈希表所有值
- `HGETALL key`  获取哈希表所有字段和值
- `HLEN key`  获取哈希表长度

set
- `SADD key member [member]`  向集合中添加元素
- `SPOP key`  从集合中移除元素
- `SREM key member [member]`  从集合中移除指定元素
- `SMOVE source destination member` 移动集合元素
- `SISMEMBER key member`  判断元素是否在集合中
- `SRANDOMMEMBER key count`  随机返回集合中的元素
- `SMEMBERS key`  返回集合中所有元素
- `SINNER key key`  求集合交集
- `SINNERSTORE destination key key`  存储集合交集
- `SUNION key key`  求集合并集
- `SUNIONSTORE destination key key`  存储集合并集
- `SDIFF key key`  求集合差集
- `SDIFFSTORE destination key key`  存储集合差集
- `SCARD key`  获取集合长度

sorted set
- `ZADD key score member [score member]`  添加元素
- `ZREM key member [member]`  移除元素
- `ZREMRANGEBYRANK key start stop`  按索引排名移除元素
- `ZREMRANGEBYSCORE key min max`  按分数区间移除元素
- `ZREMRANGEBYLEX key min max`  按字典区间移除元素
- `ZRANK key member`  获取元素排名
- `ZREVRANK key member`  获取元素反向排名
- `ZSCORE key member`  获取元素分数
- `ZRANGE key start stop [WITHSCORES]`  获取指定排名区间的成员
- `ZREVRANGE key start stop [WITHSCORES]`  获取指定排名区间的成员
- `ZRANGEBYSCORE key min max [WITHSCORES] [LIMIT offset count]`  获取指定分数区间的成员
- `ZREVRANGEBYSCORE key min max [WITHSCORES]`  获取指定分数区间的成员
- `ZRANGEBYLEX key min max [LIMIT offset count]`  获取指定字典区间的成员
- `ZINTERSTORE destination numkeys key key`  存储交集
- `ZUNIONSTORE destination numkeys key key`  存储并集
- `ZINCRBY key increment member`  自增
- `ZCARD key`  获取成员数量
- `ZCOUNT key min max`  获取分数区间的成员数量
- `ZLEXCOUNT key min max`  获取字典区间的成员数量

bit
- `SETBIT key offset value`  设置bit位
- `GETBIT key offset`  获取bit位
- `BITPOS key bit [start] [end] [BYTE|BIT]` 在指定字节区间查找bit出现的位置
- `BITCOUNT key [start] [end]`  在指定位区间统计1出现的次数
- `BITOP operation destkey key key`  对key进行位运算


hyperloglog
- `PFADD key element [element]`  添加元素
- `PFCOUNT key [key]`   获取统计数量
- `PFMERGE destkey sourcekey sourcekey`  合并多个集合

geo
- `GEOADD key longitude latitude member [longitude latitude member]`  添加坐标
- `GEOPOS key member [member]`  获取坐标
- `GEODIST key member member [m|km|ft|mi]`  获取两个位置的距离
- `GEORADIUS key longitude latitude radius [m|km|ft|mi] [WITHCOORD] [WITHDIST] [WITHHASH] [COUNT count] [AES|DESC] [STORE key]`  以给定的经纬度为中心， 返回指定范围内的元素
- `GEORADIUSBYMEMBER key member m|km|ft|mi [WITHCOORD] [WITHDIST] [WITHHASH] [COUNT count] [AES|DESC] [STORE key]`  以给定的位置为中心， 返回指定范围内的元素
- `GEOHASH key member [member]`  获取坐标的hash位置

stream
- `XADD key id field value [field value]`  添加消息
- `XDEL key id [id]`  删除消息
- `XTRIM key [MAXLEN|MINIID] [~] [count]`  裁剪为指定数量的项目
- `XRANGE key start end [COUNT count]`  获取消息列表
- `XREVRANGE key end start [COUNT count]` 反向获取消息列表
- `XREAD [COUNT count] [BLOCK milliseconds] STREAMS key [key] id [id]` 获取消息
- `XLEN key`  获取消息长度
```

## 数据类型 ##
### 字符串(string) ###
**内部实现**  
- int(整数)
- embstr(sds)
- raw(sds)

**应用**  
- 缓存对象
- 计数
- 分布式锁

### 列表(list) ###
```
内部实现
- quicklist

应用
- 消息队列
```
  
### 哈希(hash) ###
```
内部实现
- listpack

应用  
- 缓存对象
```

### 集合(set) ###
```
内部实现  
- 整数集合(元素都是整数且元素个数小于512个)
- 哈希表
  
应用  
- 点赞
- 关注
- 抽奖  
```

### 有序集合(sorted set) ###
```
内部实现
- listpack

应用 
- 排行榜
- 排序
```


### 位图(bitmap) ###
```
内部实现
- string
  
应用  
- 签到
- 登陆
```

  
### 基础统计(hyperloglog) ###
```
应用  
- UV计数
```


### 位置(geo) ###
```
内部实现
- sorted set

应用  
- 打车

```

### 流(stream) ###
```
应用
- 消息队列
```

## 数据结构 ##
### Redis存储模型 ###  
![avatar](./images/redis/redis-struct.png)  
```
- redisDb结构  Redis数据库的结构 结构体里存放了指向了dict结构的指针   
- dict结构  结构体里存放了2个哈希表，正常情况下都是用「哈希表1」，「哈希表2」只有在 rehash 的时候才用  
- ditctht结构 结构里存放了哈希表数组，数组中的每个元素都是指向一个哈希表节点结构（dictEntry）的指针  
- dictEntry结构  结构里存放了void *key和void *value指针，*key 指向的是String对象，而*value则可以指向String对象，也可以指向集合类型的对象，比如List对象、Hash对象、Set对象和Zset对象  
```

### Redis对象 ###  
![avatar](./images/redis/redis-object-struct.png) 
``` 
- type  标识该对象是什么类型的对象（String对象、List对象、Hash对象、Set对象和Zset对象） 
- encoding  标识该对象使用了哪种底层的数据结构  
- ptr  指向底层数据结构的指针  
```

### SDS ###
简单动态字符串（simple dynamic string）
![avatar](./images/redis/redis-sds-struct.png)  
```
结构
- len  记录了字符串长度    
- alloc  分配给字符数组的空间长度  
- flags  不同类型的SDS，sdshdr5、sdshdr8、sdshdr16、sdshdr32和sdshdr64  
- buf[]  字符数组，用来保存实际数据  

优点  
- 高效  
  直接获取长度 
  柔性数组  
- 二进制安全  
  不以\0结束
- 节省空间  
  不同的flags
  不字节拉齐
```

## 事务 ##
**常用命令**    
```
- MULTI
- EXEC
- DISCARD
- WATCH key [key]
- UNWATCH
```

## 订阅 ##
**常用命令**  
```
- SUBSCRIBE channel [channel]
- PSUBSCRIBE pattern [pattern]
- UNSUBSCRIBE channel [channel]
- PUNSUBSCRIBE pattern [pattern]
- PUBLISH channel message
- PUBSUB subcommand [argument]
```



