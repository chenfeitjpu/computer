**RabbitMQ**
- [定义](#定义)
- [使用](#使用)
  - [架构](#架构)
  - [控制](#控制)

# 定义 #

# 使用 #
## 架构 ##
```
角色
- 生产者(producer)  投递消息  消息包括消息体(payload)和标签(label)
- 消费者(consumer)  接收消息  
- 服务节点(broker)  
- 交换器(exchange)  路由消息
  - fanout  会把发送到该交换器的消息路由到所有与该交换器绑定的队列中
  - direct  会把消息路由到BindingKey和RoutingKey完全匹配的队列中
  - topic  会把消息路由到BingingKey和RoutintKey模糊匹配的队列中 *匹配单个单词 #匹配多个(可以是零个)
  - headers  通过headers属性进行消息匹配 x-match all 所有都匹配 any 任意一个匹配
- 路由键(routingkey)  消息的路由规则
- 绑定键(bindingkey)  消息绑定到队列的路由规则
- 队列(queue)  存储消息

生产者发送消息
- 生产者连接到RabbitMQ Broker，建立一个连接(Connection)，开启一个信道(Channel)
- 生产者声明一个交换器，并设置相关属性
- 生产者声明一个队列，并设置相关属性
- 生产者通过路由键将交换器与队列绑定起来
- 生产者发送消息至RabbitMQ Broker
- 交换器根据路由键查找相匹配的队列
- 如果找到，将生产者发送过来的消息存入相应队列中
- 如果没找到，根据生产者配置的属性选择丢弃或者回退给生产者
- 关闭信道
- 关闭连接

消费者接收消息
- 消费者连接到RabbitMQ Broker，建立一个连接(Connection)，开启一个信道(Channel)
- 消费者向RabbitMQ Broker请求消费相应队列中的消息
- 等待RabbitMQ Broker回应并投递相应队列中的消息，消费者接收消息
- 消费者确认(ack)接收到的消息
- RabbitMQ从队列中删除已被确认的消息
- 关闭信道
- 关闭连接
```

## 控制 ##
```
发送消息
- mandatory  交换器无法找到符合条件的队列 true: 将消息返回给生产者 false: 将消息丢弃
- immediate  交换器将消息路由到队列时发现队列并不存在消费者，消息不会入队，路由键匹配的所有队列都没有消费者，则返回生产者
- alternate-exchange  备份交换器

消息的过期时间(TTL)
- x-message-ttl  通过队列设置过期时间
- expiration  通过消息设置过期时间

队列的过期时间(TTL)
- x-expires  

死信队列
- x-dead-letter-exchange  设置死信交换器

延迟队列

优先级队列
- x-max-priority  设置队列的优先级
- priority  设置消息的优先级

持久化
- 设置交换器持久化
- 设置队列持久化
- 设置消息持久化

生产者确认
- 事务机制
- 发送方确认

- 消费者确认
```