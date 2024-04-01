**kafka**
- [定义](#定义)
- [使用](#使用)
  - [架构](#架构)
  - [读写](#读写)
  - [存储](#存储)

# 定义 #
kafka是一种分布式消息系统

# 使用 #
## 架构 ##
```
概念
- 术语
  - 消息(record)  
    kafka中的数据单元
  - 批次(batch)
    为了提高效率，消息会分批次写入kafka，批次就代指的是一组消息
  - 主题(topic)  
    消息分类  
  - 分区(partition) 
    一个topic可以包含多个partition，topic消息保存在各个partition上  
    单一主题中的分区有序，但是无法保证主题中所有的分区有序  
  - 生产者(producer)
    向主题发送消息
  - 消费者(consumer)
    处理生产者产生的消息
  - 消费者组(consumer group)  
    每个consumer必须属于一个group
  - 偏移量(offset)  
    消息在分区的唯一标识  
  - 服务节点(broker)  
    一个独立的kafka服务器就被称为broker，broker接收来自生产者的消息，为消息设置偏移量，并提交消息到磁盘保存
  - broker集群
    broker是集群的组成部分，broker集群由一个或多个Broker组成，每个集群都有一个broker同时充当了集群控制器的角色
  - zookeeper  
    保存着集群broker、topic、partition等meta数据；负责broker故障发现，partition leader选举，负载均衡等功能
  - 副本(replication)  
    同一partition的数据可以在多broker上存在多个副本
  - leader  
    消费者消费数据的对象都是Leader
  - follower  
    实时从leader中同步数据，leader发生故障时，某个follow会成为新的leader
  - 重平衡(rebalance)
    消费者组内某个消费者实例挂掉后，其他消费者实例自动重新分配订阅主题分区的过程

特点
- 优势
  - 多生产者
  - 多消费者
  - 基于磁盘存储  
    无需担心消息丢失
  - 伸缩性  
    每个主题(topic)包含多个分区(partition)，主题中的分区可以分布在不同的主机(broker)中
  - 高可用
    某个节点宕机，kafka集群能够正常工作

- 高性能的实现
  - 分批发送
  - 消息压缩
  - 顺序读写
  - 页缓存  
    数据先写入page cache，后写入磁盘
  - 零拷贝

- 消息有序
  kafka只保证同一个分区内的消息有序
  - 生产者顺序写入
  - 同一个分区内的消息只能被一个group里的一个消费者消费
```

## 读写 ##
```
生产
- 写入消息流程
  - producer先从zookeeper找到该partition的leader
  - producer将消息发送给该leader
  - leader将消息写入本地log
  - followers从leader中pull消息，写入本地log后向leader发送ack
  - leader收到所有ISR中的replication的ack后，增加HW并向producer发送ACK
- 分区
  - 目的
    - 方便扩展
      一个topic可以有多个partition，可以适应任意大小的数据
    - 提高并发  
      可以以partition为单位读写
  - 原则
    - 指明partition的情况下，直接将指明的值作为partition值
    - 没有指明partition值但有key的情况下，将key的hash值与topic的partition数进行取余得到partition值  
    - 既没有partition值又没有key值的情况下，第一次调用时随机生成一个整数(后面每次调用在这个整数上自增)，将这个值与topic可用的partition总数取余得到partition值，也就是常说的RoundRobin算法  
      - 策略
        - 轮询(RoundRobin)  
        - 随机(Rand)
        - 哈希(Hash)
- 副本
  - 目的
    实现故障自动转移
  - ISR
    和leader保持同步进度的follower
- 应答机制
  - 0  
    producer不等待broker的ack
    broker一接收到还没有写入磁盘就已经返回，当broker故障时有可能丢失数据
  - 1  
    producer等待broker的ack，partition的leader落盘成功后返回ack  
    如果在follower同步成功之前leader故障，那么将会丢失数据
  - -1 
    producer等待broker的ack，partition的leader和follower全部落盘成功后才返回ack
    如果在follower同步完成后，broker发送Ack之前，leader发生故障，那么就会造成数据重复
- 语义
  - 至多一次  
  - 至少一次  
  - 精确一次  
    - 幂等性发送者
      - 单一会话单一分区
    - 事务性发送者
      - 跨会话跨分区
- 故障处理
  - 概念
    - LEO
      每个副本最后一个offset
    - HW
      消费者能见到的最大的offset，ISR队列中最小的LEO
  - 规则
    - follower故障
      follower发生故障后会被临时踢出ISR，待该follower恢复后，follower会读取本地磁盘记录的上次的HW，并将log文件高于HW的部分截取掉，从HW开始向leader进行同步。等该follower的LEO大于等于该Partition的HW，即follower追上leader之后，就可以重新加入ISR了  
    - leader故障
      leader发生故障之后，会从ISR中选出一个新的leader，之后为保证多个副本之间的数据一致性，其余的follower会先将各自的log文件高于HW的部分截掉，然后从新的leader同步数据  
- 刷盘机制
  - 配置
    - log.flush.interval.messages  
      //多少条消息，刷盘1次 默认值 LONG.MAX_VALUE
    - log.flush.interval.ms  
      //多长时间，刷盘1次 LONG.MAX_VALUE
    - log.flush.scheduler.interval.ms   
      //周期性的刷盘，缺省3000，即3s
  - 操作系统刷新page cache

消费
- 模式
  - kafka消费者采用pull拉模式从broker中消费数据  
  - pull模式则可以根据consumer的消费能力以适当的速率消费消息
  - 消费者可能会陷入循环中，一直返回空数据。为了避免这种情况，我们在我们的拉请求中有参数，允许消费者请求在等待数据到达的长轮询中进行阻塞
- 消费者组
  - 消费者是以consumer group消费者组的方式工作，由一个或者多个消费者组成一个组，共同消费一个topic  
  - 每个分区在同一时间只能由group中的一个消费者读取，但是多个group可以同时消费这个partition
  - 消费者组实现广播与单播的功能
- 分区分配策略
  - 轮询(RoundRobin)
    把多个主题当成一个整体
    消费者组里的消费者之间消费的消息个数最多相差1个
    - 实现
      对主题和分区进行排序，根据消费者进行轮询
    - 适用场景
      适用于消费者组中消费者订阅的主题相同的情况
  - 范围方法(Range)
    不会把多个主题当成一个整体
    消费者组内的消费者消费的消息数量相差可能较大
    - 实现
      计算每个consumer可以消费的分区个数，然后按照顺序将指定个数范围的分区分配给各个consumer
  - Sticky
- 提交消费偏移量
  - 自动
  - 手动
    - 同步
    - 异步
- 再平衡
  - 发生条件
    - 组成员数发生变更
    - 订阅主题发生变更
    - 订阅主题的分区数发生变更
```

## 存储 ##
```
log结构
- 划分
  一个topic下有多个partition，一个partition下有多个segment文件
- segment
  - 文件结构
    - *.log  
      数据
    - *.index  
      偏移量索引
    - *.timeindex
      时间戳索引
  - 分段策略
    - 数据大小(默认是1GB)
      `log.segment.bytes`  
    - 数据时间(默认7天)
      `log.segment.ms`  
- 消息结构
  - record
  - record batch
  - record header

过期数据清理
- 启用清理
  `log.cleaner.enable=true`  
- 策略
  - 删除  
    - 启用删除策略
      `log.cleanup.policy=delete`
    - 清理超过指定时间的数据  
      `log.retention.hours=16`  
    - 清理超过指定大小的消息
      `log.retention.bytes=1073741824`  
  - 压缩  
    只保留每个key最后一个版本的数据
    - 启用压缩策略
    `log.cleanup.policy=compact` 
```

学习资料  
[官网](https://kafka.apache.org/)  
[真的，Kafka入门一篇文章就够了](https://juejin.cn/post/6844903495670169607)  
[kafka是怎么实现顺序写磁盘的](https://www.zhihu.com/question/63408317/answer/3058280249)  