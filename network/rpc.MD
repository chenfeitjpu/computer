**RPC**
- [定义](#定义)
- [使用](#使用)

# 定义 #
远程调用

# 使用 #
```
组成
- client
- client stub
- server
- server stub

调用过程
- client以本地调用方式调用远程服务 
- client stub接收到调用后负责将方法、参数等组装成能够进行网络传输的消息体
- client stub找到服务地址，并将消息发送到服务端
- server端接收到消息
- server stub收到消息后进行解码
- server stub根据解码结果调用本地的服务
- 本地服务执行并将结果返回给server stub 
- server stub将返回结果打包成能够进行网络传输的消息体
- 按地址将消息发送至调用方
- client 端接收到消息
- client stub收到消息并进行解码 
- 调用方得到最终结果

- rpc和http区别
  - 通信协议  rpc使用自定义的TCP协议，可以让请求报文体积更小；http有较多的头部信息
  - 传输数据  rpc基于二进制进行序列化，大小更小，耗时更少；http基于文本进行序列化
  - 高可用  rpc自带服务发现、服务治理、负载均衡

grpc
- 使用http2作为网络传输层
- 使用protobuf这个高性能的数据包序列化协议
```