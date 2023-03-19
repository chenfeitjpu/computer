**网络系统**
- [内容](#内容)
  - [IO](#io)
  - [文件传输](#文件传输)
  - [大文件传输](#大文件传输)
  - [I/O多路复用](#io多路复用)
  - [高性能网络模式](#高性能网络模式)
    - [Reactor](#reactor)
    - [Proactor](#proactor)

# 内容 #
## IO ##
**直接IO**  
![](./images/net_system/direct_io.webp)  

**DMA**  
![](./images/net_system/dma_io.webp)  


## 文件传输 ##
**read+write**  
![](./images/net_system/read_write.webp)

**mmap+write**  
![](./images/net_system/mmap_write.webp)

**sendfile+dma**  
![](./images/net_system/sendfile_dma.webp)

**sendfile+sg-dma**  
![](./images/net_system/sendfile_sg_dma.webp)

## 大文件传输 ##
**异步IO+直接IO**  
![](./images/net_system/big_file.webp)


## I/O多路复用 ##
**多进程**  
![](./images/net_system/multi_process.webp)

**多线程**  
![](./images/net_system/multi_thread.webp)

**多路复用**  
![](./images/net_system/epoll.webp)

## 高性能网络模式 ##
### Reactor ###  
Reactor 是非阻塞同步网络模式，感知的是就绪可读写事件

**单Reactor单进程/单线程**  
![](./images/net_system/single_reactor_single_process.webp)

**单Reactor多线程/多进程**  
![](./images/net_system/single_reactor_multi_process.webp)

**多Reactor多线程/多进程**  
![](./images/net_system/multi_reactor_multi_process.webp)

### Proactor ###
Proactor 是异步网络模式， 感知的是已完成的读写事件  
![](./images/net_system/proactor.webp)
