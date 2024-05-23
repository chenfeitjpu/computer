**Kafka**
- [定义](#定义)
- [使用](#使用)
  - [架构](#架构)
  - [读写](#读写)
  - [存储](#存储)
  - [对比](#对比)

# 定义 #
Kafka是一个分布式事件流平台

# 使用 #
## 架构 ##
```
概念
- 术语
  - 消息(Record)  Kafka中的数据单元
  - 批次(BatchRecord)  一组消息，为了提高效率，消息会分批次写入Kafka
  - 主题(Topic)  消息分类  
  - 分区(Partition)  一个Topic可以包含多个Partition，Topic消息保存在各个Partition上，单一分区有序，主题中所有的分区是无序的  
  - 生产者(Producer)  发送消息
  - 消费者(Consumer)  读取消息
  - 消费者组(Consumer Group)  多个Consumer组成一个Group
  - 偏移量(Offset)  消息在分区的唯一标识  
    - LEO  副本log文件下一条要写入的消息的位移
    - HW  ISR集合中最小的LEO
  - 服务节点(Broker)  一个独立的Kafka服务器就被称为Broker，Broker接收来自生产者的消息，为消息设置偏移量，并提交消息到磁盘保存
  - Broker集群  Broker是集群的组成部分，Broker集群由一个或多个Broker组成，每个集群都有一个Broker同时充当了集群控制器的角色
  - Zookeeper  保存着集群Broker、Topic、Partition等meta数据；负责Broker故障发现，Partition Leader选举，负载均衡等功能
  - 副本(Replication)  同一Partition的数据可以在多Broker上存在多个副本
  - Leader  负责消息的读取
  - Follower  实时从Leader中同步数据，Leader发生故障时，某个Follow会成为新的Leader
  - 重平衡(Rebalance)  消费者组内某个消费者实例挂掉后，其他消费者实例自动重新分配订阅主题分区的过程

特点
- 优势
  - 多生产者
  - 多消费者
  - 基于磁盘存储  
  - 伸缩性  每个主题(Topic)包含多个分区(Partition)，主题中的分区可以分布在不同的主机(Broker)中
  - 高可用  某个节点宕机，Kafka集群能够正常工作
- 高性能
  - 分批发送
  - 消息压缩
  - 顺序读写
  - 页缓存  数据先写入Page Cache后写入磁盘
  - 零拷贝
- 消息有序
  - kafka只保证同一个分区内的消息有序
    - 生产有序  生产者顺序写入
    - 消费有序  同一个分区内的消息只能被一个Group里的一个Consumer消费
  - 超时重试时，不一定有序

语义
- 至多一次  
- 至少一次  
- 精确一次 
```

## 读写 ##
```
生产者
- 写入流程
  - Producer先从Zookeeper找到该Partition的Leader
  - producer将消息发送给该Leader
  - Leader将消息写入本地Log
  - Followers从Leader中Pull消息，写入本地Log后向Leader发送Ack
  - Leader收到所有ISR中的Replication的Ack后，增加HW并向Producer发送Ack
- acks & retries
  - 0  Producer不等待Broker的Ack
  - 1  Producer等待Broker的Ack，Partition的Leader写入成功后返回Ack
  - all  Producer等待Broker的Ack，Partition的Leader和Follower全部写入成功后才返回Ack
- 去重
  - 幂等性发送者(单一会话单一分区)
    Broker会根据(Producter, Topic, Partition)保存一个SeqNumber
  - 事务性发送者(跨会话跨分区)

消费者
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

服务节点
- 分区
  - 目的
    - 方便扩展  一个Topic可以有多个Partition，可以适应任意大小的数据
    - 提高并发  以Partition为单位读写
  - 选择
    - 指明Partition的情况下，直接使用
    - 没有指明Partition但有Key的情况下，将Key的Hash值与Topic的Partition数进行取余得到Partition  
    - 既没有指明Partition值又没有Key值的情况下，第一次调用时随机生成一个整数(后面每次调用在这个整数上自增)，将这个值与Topic可用的Partition总数取余得到Partition
- 副本
  - 目的  
    实现故障自动转移
  - 分类
    - ISR  和Leader保持同步进度的Follower
    - OSR  和Leader不保持同步进度的Follower
    - AR  所有的Follower
  - 判断
    - Follower的LEO与Leader的LEO相等时更新lastCaughtUpTimeMs，当前时间Now减去Follower的LastCaughtUpTimeMs大于replica.log.time.max.ms，ISR就会加入OSR
    - Follower的LEO等于Leader的LEO的时候，OSR会加入ISR
- 故障处理
    - Follower故障
      Follower发生故障后会被临时踢出ISR，待该Follower恢复后，Follower会读取本地磁盘记录的上次的HW，并将log文件高于HW的部分截取掉，从HW开始向leader进行同步。等该follower的LEO大于等于该Partition的HW，即follower追上leader之后，就可以重新加入ISR了  
    - Leader故障
      leader发生故障之后，会从ISR中选出一个新的leader，之后为保证多个副本之间的数据一致性，其余的follower会先将各自的log文件高于HW的部分截掉，然后从新的leader同步数据  
- 刷盘机制
  - 配置
    - log.flush.interval.messages  //写入多少消息刷盘一次
    - log.flush.interval.ms  //间隔多长时间刷盘一次
    - log.flush.scheduler.interval.ms  //多长时间进行一次检查
  - 操作系统刷新Page Cache
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

## 对比 ##
```
kafka & rabbitmq
- kafka配置复杂，吞吐量大，rabbitmq配置简单，吞吐量小
- kafka消息严格有序，rabbitmq不一定
- rabbitmq可灵活配置路由，kafka只能监控topic
- rabbitmq错误消息会重新入队，超时消息会进入死信队列
- kafka会保留历史消息，rabbitmq消费完即删除
```

学习资料  
[官网](https://kafka.apache.org/)  
[真的，Kafka入门一篇文章就够了](https://juejin.cn/post/6844903495670169607)  
[kafka是怎么实现顺序写磁盘的](https://www.zhihu.com/question/63408317/answer/3058280249)  