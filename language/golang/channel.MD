**通道**  
- [内容](#内容)
  - [结构](#结构)

# 内容 #
## 结构 ##
```
type hchan struct {
    closed   uint32   // channel是否关闭的标志
    elemtype *_type   // channel中的元素类型

    // channel分为无缓冲和有缓冲两种。
    // 对于有缓冲的channel存储数据，使用了 ring buffer(环形缓冲区)来缓存写入的数据，本质是循环数组
    // 为啥是循环数组？普通数组不行吗，普通数组容量固定更适合指定的空间，弹出元素时，普通数组需要全部都前移
    // 当下标超过数组容量后会回到第一个位置，所以需要有两个字段记录当前读和写的下标位置
    buf      unsafe.Pointer // 指向底层循环数组的指针（环形缓冲区）
    qcount   uint           // 循环数组中的元素数量
    dataqsiz uint           // 循环数组的长度
    elemsize uint16                 // 元素的大小
    sendx    uint           // 下一次写下标的位置
    recvx    uint           // 下一次读下标的位置

    // 尝试读取channel或向channel写入数据而被阻塞的goroutine
    recvq    waitq  // 读等待队列
    sendq    waitq  // 写等待队列

    lock mutex //互斥锁，保证读写channel时不存在并发竞争问题
}
```
```
type waitq struct {
    first *sudog
    last  *sudog
}
type sudog struct {
    g *g
    next *sudog
    prev *sudog
    elem unsafe.Pointer 
    c        *hchan 
}
```
**创建**  
如果是无缓冲的 channel，会直接给 hchan 分配内存  
如果是有缓冲的 channel，并且元素不包含指针，那么会为 hchan 和底层数组分配一段连续的地址  
如果是有缓冲的 channel，并且元素包含指针，那么会为 hchan 和底层数组分别分配地址  

**发送**  
- 如果 channel 的读等待队列存在接收者goroutine
  - 将数据直接发送给第一个等待的 goroutine， 唤醒接收的 goroutine
- 如果 channel 的读等待队列不存在接收者goroutine
  - 如果循环数组buf未满，那么将会把数据发送到循环数组buf的队尾
  - 如果循环数组buf已满，这个时候就会走阻塞发送的流程，将当前 goroutine 加入写等待队列，并挂起等待唤醒

**接收**  
- 如果 channel 的写等待队列存在发送者goroutine
  - 如果是无缓冲 channel，直接从第一个发送者goroutine那里把数据拷贝给接收变量，唤醒发送的 goroutine
  - 如果是有缓冲 channel（已满），将循环数组buf的队首元素拷贝给接收变量，将第一个发送者goroutine的数据拷贝到 buf循环数组队尾，唤醒发送的 goroutine
- 如果 channel 的写等待队列不存在发送者goroutine
  - 如果循环数组buf非空，将循环数组buf的队首元素拷贝给接收变量
  - 如果循环数组buf为空，这个时候就会走阻塞接收的流程，将当前 goroutine 加入读等待队列，并挂起等待唤醒