**kafka**
- [定义](#定义)
- [使用](#使用)
  - [架构](#架构)

# 定义 #

# 使用 #
## 架构 ##
```
角色
- zookeeper  管理集群元数据
- 生产者(producer)  发送消息
- 消费者(consumer)  接收消息
- 服务节点(broker)  存储消息  
- 主题  对消息进行归类  
- 分区  存储消息
  - 副本
    - AR  所有副本(leader+follower)
    - ISR  保持同步的副本 
    - OSR  滞后过多的副本
  - HW(高水位)  消费者只能拉取到这个offset之前的消息，所有ISR的最小LEO
  - LEO  副本下一条待写入消息的offset

生产者
- 创建生产者
  - bootstrap.servers  连接的kafka集群地址
  - key.serializer&value.serializer  key&value的序列化器
  - client.id  生产者对应的客户端id
  - acks  消息确认类型
    - 0  不需要服务端确认
    - 1  需要leader副本确认
    - -1  需要所有副本确认
  - max.request.size 消息的最大值
  - retries  重试次数
  - retry.backoff.ms  重试时间间隔
  - request.timeout.ms  请求超时时间
- 创建消息
- 发送消息
  发送方式
  - 发后即忘(fire-and-forget)
  - 同步(sync)
  - 异步(async)
  发送过程
  - 拦截器
  - 序列化器
  - 分区器
- 关闭生产者

消费者
- 创建消费者
  - bootstrap.servers  连接的kafka集群地址
  - key.serializer&value.serializer  key&value的序列化器
  - group.id  消费者隶属的消费组名称
- 订阅主题
- 拉取消息
- 提交消息位移
- 关闭消费者
```