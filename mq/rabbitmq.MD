**RabbitMQ**
- [定义](#定义)
- [使用](#使用)
  - [架构](#架构)
  - [读写](#读写)
  - [持久化](#持久化)
  - [高可用](#高可用)
- [学习资料](#学习资料)

# 定义 #
消息和流式代理

# 使用 #
## 架构 ##
```
术语
- 生产者(Publisher)  发布消息
- 消费者(Consumer)  接收消息  
- 虚拟主机(Virtual Host)  逻辑隔离
- 服务节点(Broker)  存储和转发消息
- 连接(Connection)
- 信道(Channel)
- 交换器(Exchange)  路由消息
- 路由键(Routingkey)  消息的路由规则
- 绑定键(Bindingkey)  消息绑定到队列的路由规则
- 队列(Queue)  存储消息

消息模型
- 简单模式(Simple)  一个生产者，一个消费者，通过队列直接消费
- 工作队列模式(Work Queue)  一个生产者，多个消费者，通过队列直接消费
- 发布/订阅模式(Publish/Subscribe)  会把消息路由到所有与该交换器绑定的队列中
- 路由模式(Routing) 会把消息路由到BindingKey和RoutingKey完全匹配的队列中
- 专题模式(Topic)  会把消息路由到BingingKey和RoutintKey模糊匹配的队列中 *匹配单个单词 #匹配多个(可以是零个)
- RPC  
```

## 读写 ##
```
生产者
- 发送过程
  - Producer创建连接
  - Producer开启信道
  - Producer声明交换器
  - Producer声明队列
  - Producer绑定队列和交换器
  - Producer发送消息至服务器
  - Exchange根据路由键查找匹配的队列
  - Producer关闭信道
  - Producer关闭连接
- 可靠性
  - 事务机制(同步)
  - confirm机制(异步)

消费者
- 接收过程
  - Consumer创建连接
  - Consumer开启通道
  - Consumer接收消息
  - Consumer确认消息
  - Broker从队列中删除消息
  - Consumer关闭信道
  - Consumer关闭连接
- 可靠性
  - ack机制

服务节点
- 交换器
  - 交换器无法根据自身类型和路由键找到符合条件队列
    - 返回消息给生产者
    - 直接丢弃
- 有效期
  - 消息
  - 队列
- 队列
  - 死信队列
    - 消息过期
    - 消息被消费者拒绝
    - 消息超过队列长度限制
  - 延迟队列
  - 优先级队列
```

## 持久化 ##

## 高可用 ##
```
复制集群  
- 普通模式  每个节点存储所有队列元数据，队列之间通过转发获取消息
- 镜像模式  每个节点存储所有队列元数据，所有的消息数据
```    

# 学习资料 #

