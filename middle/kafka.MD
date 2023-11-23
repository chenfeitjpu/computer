**kafka**
- [定义](#定义)
- [使用](#使用)
  - [特点](#特点)
  - [架构](#架构)
  - [角色](#角色)
    - [生产者](#生产者)
    - [消费者](#消费者)
    - [broker](#broker)
    - [副本](#副本)
  - [消费保障](#消费保障)
  - [存储](#存储)

# 定义 #
kafka是一种分布式消息系统

# 使用 #
## 特点 ##
```
优势
- 多生产者
- 多消费者
- 基于磁盘存储  无需担心消息丢失
- 伸缩性  可扩展多台broker
- 高性能  轻松处理百万千万级消息流，同时保证亚秒级的消息延迟

高性能的实现
- 页缓存  数据先写入page cache，后写入磁盘
- 磁盘顺序写  
- 零拷贝

消息有序
kafka只保证同一个分区内的消息有序
- 生产者顺序写入
- 同一个分区内的消息只能被一个group里的一个消费者消费
```
## 架构 ##
```
- zookeeper  保存着集群broker、topic、partition等meta数据；负责broker故障发现，partition leader选举，负载均衡等功能
- 生产者(producer)  生产消息
- 消费者(consumer)  消费消息
- 消费者组(consumer group)  每个consumer必须属于一个group
- 服务节点(broker)  消息存储和转发  
- 主题(topic)  消息分类  
- 分区(partition)  一个topic可以包含多个partition，topic消息保存在各个partition上
- 偏移量(offset)  消息在分区的唯一标识
- 副本(replication)  同一partition的数据可以在多Broker上存在多个副本
- leader  消费者消费数据的对象都是leader
- follower  实时从leader中同步数据，leader发生故障时，某个follow会成为新的leader
- 消息(record)  实际写入kafka中并可以被读取的消息记录
```

## 角色 ##
### 生产者 ###
```
生产流程
- 创建生产者
  - bootstrap.servers  连接的kafka集群地址
  - key.serializer&value.serializer  key&value的序列化器
  - client.id  生产者对应的客户端id
  - acks  消息确认类型
  - max.request.size 消息的最大值
  - retries  重试次数
  - retry.backoff.ms  重试时间间隔
  - request.timeout.ms  请求超时时间
- 创建消息
- 发送消息
- 关闭生产者
 
发送过程
- 拦截器
- 序列化器
- 分区器

分区策略
- 轮询(round-robin)  
- 随机(rand)
- 哈希(hash)
- 自定义
分区原则
- 指定分区
- 没有指定分区，key不为空，使用hash算法计算分区
- 没有指定分区，key为空，用轮询的方式选择一个分区

确认应答(acks)
- 0  producer 不会等待任何来自 broker 的响应
- 1  只要集群中partition的Leader节点收到消息，生产者就会收到一个来自服务器的成功响应
- -1 只有当所有参与复制的节点(ISR)全部都收到消息时，生产者才会收到一个来自服务器的成功响应

发送模式
- 同步(sync)  数据同步刷新到磁盘 
- 异步(async)  数据异步刷新到磁盘

发送方式
- 批量发送
  一次发送多条消息
- 压缩发送
  通过gzip或snappy格式对消息进行压缩
```

### 消费者 ###
```
消费流程
- 创建消费者
  - bootstrap.servers  连接的kafka集群地址
  - key.serializer&value.serializer  key&value的序列化器
  - group.id  消费者隶属的消费组名称
- 订阅主题
- 拉取消息
- 提交消息位移
- 关闭消费者

分区策略
- range(默认)
  range分配策略针对的是主题，分区指的某个主题的分区，消费者指的是订阅这个主题的消费者组中的消费者
  - 将分区按数字顺序排行序
  - 消费者按消费者名称的字典序排好序
  - 用分区总数除以消费者总数，如果能够除尽平均分配；若除不尽，则位于排序前面的消费者将多负责一个分区
- round robin
  - 将消费组内所有消费者以及消费者所订阅的所有topic的partition按照字典序排序，然后通过轮询算法逐个将分区以此分配给每个消费者
- sticky
  - 分区的分配尽量的均衡
  - 每一次重分配的结果尽量与上一次分配结果保持一致
- 自定义
```

### broker ###
```
broker leader选举
- 集群中第一个启动的broker会通过在zookeeper中创建临时节点/controller来让自己成为控制器
- 控制器挂掉了，其它broker就会去尝试创建临时节点/controller，如果有一个Broker创建成功，那么其他broker就会收到创建异常通知，也就意味着集群中已经有了控制器
- 集群中有一个broker发生异常退出了，那么控制器就会检查这个broker是否有分区的副本leader，如果有那么这个分区就需要一个新的leader，此时控制器就会去遍历其他副本，决定哪一个成为新的leader，同时更新分区的ISR集合
- 如果有一个broker加入集群中，那么控制器就会通过Broker ID去判断新加入的broker中是否含有现有分区的副本，如果有，就会从分区副本中去同步数据
```

### 副本 ###
```
副本集合
- AR  所有副本(leader+follower)
- ISR  保持同步的副本 
- OSR  滞后过多的副本
- LEO  副本下一条待写入消息的offset
- HW(高水位)  消费者只能拉取到这个offset之前的消息，所有ISR的最小LEO
- LW(低水位)  代表AR集合中最小的logStartOffset 值
- LSO  LastStableOffset  对未完成的事务而言，LSO 的值等于事务中第一条消息的位置(firstUnstableOffset)，对已完成的事务而言，它的值同HW相同

Leader副本选举
每个分区的leader会维护一个ISR集合，ISR列表里面就是follower副本的Borker编号，只有跟得上leader的follower副本才能加入到ISR里面，这个是通过replica.lag.time.max.ms参数配置的。只有ISR里的成员才有被选为leader的可能
所以当leader挂掉了，而且unclean.leader.election.enable=false的情况下，kafka会从ISR列表中选择第一个 follower作为新的leader，因为这个分区拥有最新的已经committed的消息。通过这个可以保证已经committed的消息的数据可靠性
```

## 消费保障 ##
```
消息保障等级 
- 最多一次(at most once)  消息可能会丢失，但不会重复
- 最少一次(at least once)  消息不会丢失，但可能会重复
- 精准一次(exactly once)   消息不会丢失，也不会重复
生产者 
- at least once  未收到确认消息，会进行重试
消费者
- at least once  先消费再commit
- at most once  先commit再消费

幂等性
多次调用所产生的结果和调用一次是一致
开启
`enable.idempotence=true`  开启幂等性
实现
每个生产者实例在初始化的时候都会被分配一个ID(product id)，消息发送到的每一个分区都有对应的序列号(sequence number)，这些序列号从0开始单调递增
broker会在内存中为每对<PID, 分区>维护一个序列号，对于收到的每一条消息，只有它的序列号比broker中维护的序列号大1，broker才会接收它
特点
幂等性只能保证单个生产者单分区的幂等

事务
- 生产者发送多条消息可以封装在一个事务中，形成一个原子操作
- read-process-write模式  将消息消费和生产封装在一个事务中，形成一个原子操作
```

## 存储 ##
```
log结构
一个topic下有多个partition，一个partition下有多个segment文件
segment文件结构
- *.log  数据
- *.index  偏移量索引
- *.timeindex  时间戳索引
消息结构
- record batch
- record
- record header

分段策略
- `log.segment.bytes`  数据大小(默认是1GB)
- `log.segment.ms`  数据时间(默认7天)

过期数据清理
`log.cleaner.enable=true`  启用清理
- 删除  删除过期数据
  `log.cleanup.policy=delete`  启用删除策略
  `log.retention.hours=16`  清理超过指定时间的数据
  `log.retention.bytes=1073741824`  清理超过指定大小的消息 
- 压缩  只保留每个key最后一个版本的数据
  `log.cleanup.policy=compact`  启用压缩策略
```