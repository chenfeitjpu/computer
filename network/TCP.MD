TCP

# 定义 #
面向连接、可靠的、基于字节流的传输层通信协议

# 内容 #
## 头部格式 ##
  - 序列号，当前数据包编号
  - 确认应答号，下一次期望收到的序列号
  - 控制位
    - SYN 建立连接
    - ACK 确认应答
    - FIN 断开连接
    - RST 强制断开连接

## 三次握手 ##
1.服务端(CLOSED状态)主动监听端口(LISTEN状态)  
2.客户端(CLOSED状态)发送SYN报文(SYN_SENT状态)  
3.服务端(Listend状态)发送SYN_ACK报文(SYN_RCVD状态)  
4.客户端(SYN_SENT状态)发送ACK报文(ESTABLISHED状态)  
5.服务端(SYN_RVCD状态)收到ACK报文(ESTABLISHED状态)  
