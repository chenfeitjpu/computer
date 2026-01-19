**消息队列**
- [定义](#定义)
- [使用](#使用)
  - [特点](#特点)

# 定义 #
消息队列是一种异步通信机制，生产者(Producer)发送消息，消息队列存储消息，消费者(Consumer)接收并处理消息

# 使用 #
## 特点 ##
```
使用场景
- 解耦
- 异步
- 削峰

模型
- 点对点  一条消息只能被一个消费者消费
- 发布/订阅  一条消息可以被多个消费者消费

可靠性
- 生产者  发送消息需要收到ack确认
- 消息队列  持久化和集群保存多副本
- 消费者  消息处理之后才回复ack 

幂等性
- 生产者
- 消费者
  业务控制

有序性

消息积压
- 增加消费者

kafka & rabbitmq
- 消费模型，rabbitmq是推模型(push)，kafka是拉模型(pull)
- 数据模型，rabbitmq是用完即删，kafka是长期追加
- 数据粒度，rabbitmq是以单条消息为最小粒度，kafka是以offset为粒度
- 投递控制，rabbitmq是exchange、queue、优先级队列，kafka是topic、partition
- 生命周期，rabbitmq可设置TTL，DLX，kafka是过期清理
```
