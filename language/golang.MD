**golang**
- [定义](#定义)
- [使用](#使用)
  - [简介](#简介)
  - [基础语法](#基础语法)
  - [数据结构](#数据结构)
  - [内存管理](#内存管理)
  - [并发控制](#并发控制)
  - [框架和库](#框架和库)

# 定义 #
静态、强类型、编译型语言

# 使用 #
## 简介 ##
```
特点
- 支持协程
- 支持并行垃圾回收
```

## 基础语法 ##
```
变量 & 常量
- 类型转换
  变量转换必须指明类型(允许溢出)
  有类型常量转换必须指明类型(不允许溢出)，无类型常量可直接转换为其它类型(不允许溢出)
- 取址
  变量允许取址，常量不能取址

数据类型
- 分类
  - uint8、uint16、uint32、uint64、uint、int8、int16、int32、int64、int
  - float32、float64 
  - complex64、complex128
  - bool
  - byte、rune
  - string
  - array、slice、map、channel 
  - func
  - struct、interface 
  - pointer、uintptr
- 引用类型 
  slice、map、channel、func、interface、pointer
- 类型比较
  - 不同类型不能比较
  - 同一类型且都是不可比较类型不能比较  slice、map、func，但可以与nil进行比较
  - 接口比较，看接口指向的实际类型
- 线程安全的类型
  channel、sync.Map
```

## 数据结构 ##
```
string 
- 结构
  // runtime/string.go
  type stringStruct struct {
      str unsafe.Pointer  // 指向底层字节数组的指针
      len int             // 字符串的长度(字节数)
  }
- 注意事项
  - string对应的底层字节数组不能修改
  - 转换成[]byte会发生内存拷贝，不发生拷贝*(*[]byte)(unsafe.Pointer(&a))
  - 高效拼接
    - strings.Builder  内部维护的是 []byte 的切片，String()时不会另外申请内存存储字节数组
    - bytes.Buffer  内部维护一个 []byte 的切片，String()时会另外申请内存存储字节数组
  - 获取长度
    - utf8.RuneCountInString()

array
- 结构
  // 数组在内存中是连续存储的
  var a [5]int  // 在栈上分配 5 * 8 字节(64位系统)的连续内存
- 注意事项
  - 固定长度集合
  - 多维数组只有第一层可以使用[...]来让编译器推导数组长度
  - 数组是值类型，赋值和传参会复制整个数组

slice
- 结构
  // runtime/slice.go
  type slice struct {
      array unsafe.Pointer  // 指向底层数组的指针
      len   int             // 切片长度
      cap   int             // 切片容量
  }
- 扩容
  - 1.18以前
    - 如果新申请容量比两倍原有容量大，那么扩容后容量大小为新申请容量
    - 如果原有slice长度小于1024，那么就扩容为原来的2倍
    - 如果原有slice长度大于等于1024，那么每次扩容就扩为原来的1.25倍
  - 1.18及以后
    - 如果新申请容量比两倍原有容量大，那么扩容后容量大小为新申请容量
    - 如果原有slice长度小于256，那么就扩容为原来的2倍
    - 如果原有slice长度大于等于256，那么每次扩容就扩为原来的1.25倍+3/4*256
  - 内存对齐(size_to_class&class_to_size)  CPU以字长访问内存，如果不进行内存对齐，很可能增加CPU访问内存的次数
- 切片表达式  
  a[low:high:max]  0 <= low <= high <= max <= cap(a)，high默认是len(a),max默认是len(a)
  len=high-low，不包括high
  cap=max-low，不包括max
- 注意事项
  - for range在循环开始前会获取切片的长度，然后再执行len(切片)次数的循环  
  - 扩容前后的slice是否相同，原数组还有容量可以扩容则相同，原数组容量不够则不同
  - nil切片引用数组指针地址为0(无指向任何实际地址)，空切片引用数组指针地址是有的，且固定为一个值
  - 拷贝大切片跟小切片的代价是一样的
  - 深拷贝copy()

map
- 结构
  // runtime/map.go
  type hmap struct {
      count     int    // map 中的元素个数
      flags     uint8  // 状态标志
      B         uint8  // buckets 数组的长度为 2^B
      noverflow uint16 // 溢出桶的数量
      hash0     uint32 // 哈希种子
      
      buckets    unsafe.Pointer // 指向 buckets 数组，长度为 2^B
      oldbuckets unsafe.Pointer // 扩容时指向旧的 buckets
      nevacuate  uintptr        // 扩容进度
      
      extra *mapextra // 溢出桶相关信息
  }
  // 每个 bucket 可以存储 8 个键值对
  type bmap struct {
      topbits  [8]uint8   // 存储每个 key 的哈希值的高 8 位
      keys     [8]keytype   // 后面是 8 个 key
      values   [8]valuetype  // 然后是 8 个 value
      overflow uintptr  // 最后是指向溢出桶的指针
  }
- 查找
  - 计算key的hash值，通过最后的B位来确定桶号，通过前8位快速确定是在这个桶的哪个位置
  - 对比key是否匹配，如果都没有找到，就去连接的下一个溢出桶中找
- 扩容
  - 条件
    - 等量扩容(桶中空位过多)
      - 当B<15时，overflow的bucket数量超过2^B
      - 当B>=15时，overflow的bucket数量超过2^15
    - 双倍扩容(桶不够用了)
      - 装载因子>6.5  装载因子=count/(2^B) map中元素的个数/map中当前桶的个数
  - 操作
    - minTopHash
      当一个cell的tophash值小于minTopHash时，标志这个cell的迁移状态
      - 0  空的cell，也是初始时bucket的状态
      - 1  cell已经搬迁完毕，空cell
      - 2  cell已经搬迁完毕，key在新bucket前半部分
      - 3  cell已经搬迁完毕，key在新bucket后半部分
    - crud  定位到了某个bucket后，通过新桶找旧桶，旧桶未迁移，触发一次搬迁操作(当前访问的桶 + nevacuate 指向的桶)，执行后续操作
    - 遍历  定位到某个bucket后，通过新桶找旧桶，旧桶已经迁移，直接遍历新桶，旧桶没有迁移，遍历旧桶中会分到新桶中的元素
- 注意事项
  - 一种无序的键值对集合。map中的键必须是唯一的，而值可以重复。map提供了快速的查找和插入操作。
  - 无序
    - 添加时无序
    - 扩容时发生key的搬迁
    - 读取时从一个随机序号的bucket开始遍历，并且是从这个bucket的一个随机序号的cell开始遍历
  - 有序实现  
    - 创建切片保存键值，进行排序，然后遍历切片
  - 线程不安全
    - map+锁
    - sync.Map
      - sync.Map适用于读多、更新多、删多、写少的场景  
      - 倘若写操作过多，sync.Map基本等价于map+互斥锁  

sync.map
- 实现
  read无锁访问，dirty加锁访问，entry使用 atomic操作，减少锁粒度
- 结构
  // sync/map.go
  type Map struct {
      mu Mutex  // 保护 dirty 的互斥锁
      
      // read 是只读 map，无锁访问
      read atomic.Value // 实际存储 readOnly 结构
      
      // dirty 是读写 map，需要加锁访问
      dirty map[interface{}]*entry
      
      // misses 记录 read 未命中的次数
      // 当 misses >= len(dirty) 时，将 dirty 提升为 read
      misses int
  }

  // read 中实际存储的结构
  type readOnly struct {
      m       map[interface{}]*entry  // 只读 map
      amended bool                     // dirty 中是否有 read 中没有的键
  }

  // entry 是实际存储值的结构
  type entry struct {
      // p 指向实际存储的值
      // p 有三种状态：
      // 1. p == nil: 键已被删除，且dirty == nil，或dirty != nil且在dirty中
      // 2. p == expunged: 键已被删除，且dirty != nil，且不在dirty中
      // 3. 其他: 正常值
      p unsafe.Pointer // *interface{}
  }
- 操作
  - 写入
    - key在read中，直接更新entry，entry的值为expunged，则不能更新
    - 先加锁，key在read中，且entry的值为expunged，把key添加到dirty，更新entry的值
    - key在dirty中，更新entry
    - read&dirty中都没有，如果dirty为空，从read中拷贝未被删除的元素到dirty，更新amended字段，将k-v写入dirty
  - 删除
    - 先从read中查找，如果read中没有，并且dirty有新数据，先上锁，双重检查，从dirty中直接删掉这key 
    - 将entry标记为nil
  - 读取
    - key在read中，直接返回
    - 如果read中没有，且dirty有新数据，先上锁，双重检查，防止在加锁期间dirty已提升为read，从dirty中读取
    - 记录miss，如果miss值等于dirty的长度，提升dirty为read，并清空dirty，清空miss
  - 遍历
    - 如果dirty有新数据，需要加锁并提升为read
    - 遍历read(此时包含所有数据)    

struct  
- 注意事项
  - tag 控制字段属性配置
  - 空结构体不占内存，内存地址都是同一个，常用于占位
  - json转结构体类型不同无法解析，超过表示范围无法解析
  - 结构体拷贝，可使用结构体赋值、json转换、指针转换

func  
- 注意事项
  - 返回值要么同时命名，要么不命名
- 闭包  
  - 函数及其相关引用环境形成的组合体  
  - 闭包可以保持状态
  - 闭包使用不当会造成内存泄漏
- defer  
  延迟函数的执行，在函数退出前执行相应操作。defer通常用于解锁、关闭文件，释放资源等清理操作
  - 参数在defer声明时就决定了  
  - 多个defer语句按照先进后出的方式执行  
  - return赋值(返回值没有命名，就赋值给临时变量)->执行defer->return返回  
- init  
  import->const->var->init->main
  - 程序运⾏时，先执⾏依赖包的init函数，再执⾏当前包内的init函数
  - 一个包里可以包含多个init函数
  - init函数不可以被其他函数调⽤

method
- 注意事项
  - 对于不可寻址的类型T，不能调用*T的方法
  - 方法接受者不能是接口，或者本身就是指针类型

interface
用于定义一组方法，可以由不同的类型实现，将抽象与实现分离
- 注意事项
  - 对于T类型的接口，可以使用T类型的方法
  - 对于*T类型的接口，可以使用T和*T类型的方法

pointer
指针是一种变量，存储了另一个变量的内存地址。通过指针，我们可以直接访问和修改变量的值。
- 使用
  - &取址
    - 不可寻址的类型  字面量、常量、字符串对应的字节数组、map对象中的元素
  - *取值 新建对象
- 分类 
  - 普通指针  *T  有类型约束，有GC管理
  - 通用指针  unsafe.Pointer  无类型约束，有GC管理
  - 指针地址  uintptr
- 比较
  - unsafe.Pointer只是单纯的通用指针类型，用于转换不同类型指针，它不可以参与指针运算
  - uintptr是用于指针运算的，uintptr不持有对象，会被GC回收
  - unsafe.Pointer可以和普通指针进行相互转换
  - unsafe.Pointer可以和uintptr进行相互转换

reflect
程序在运行的时候能够观察并且修改自己的行为
- reflect慢的主要原因
  - 涉及到内存分配以及后续的GC
  - reflect实现里面有大量的枚举，也就是for循环，比如类型之类的

error & panic & recover
- error
- panic & recover
  当程序遇到无法处理的错误时，可以使用panic引发一个异常，中断程序的正常执行  
  recover用于捕获并处理panic引发的异常，使程序能够继续执行
  - 注意事项
    - 子协程的panic会导致主协程退出
    - 子协程的panic主协程无法捕获
  - 无法捕获panic的情况
    - 需要在defer函数里直接调用recover
    - panic的信息为nil时无法捕获
    - 不同goroutine间无法捕获
```

## 内存管理 ##
```
拷贝
- 浅拷贝  值类型新建对象，引用类型复制地址
- 深拷贝  值类型新建对象，引用类型新建对象

make & new
- make  为slice、map、channel分配内存并初始化，返回的值
- new  为任意类型分配内存但不初始化，返回的是指针

内存分配
go的内存分配器基于TCMalloc(Thread-Caching Malloc)设计，采用多级缓存和分级管理策略
- 层级结构
  应用程序
      ↓
  mcache(线程缓存，每个P一个)
      ↓
  mcentral(中心缓存，每个spanClass一个)
      ↓
  mheap(堆内存管理器，全局唯一)
      ↓
  操作系统
- 概念
  - mspan  内存分配单元，由一片连续的8KB的页组成的大块内存
  - mcache  每个P持有一份的内存缓存，访问时无锁，包含68*2个mspan
  - mcentral  每种对象规格对应的缓存，锁的粒度也仅限于同一种规格以内，为所有mcache提供mspan资源  
  - mheap  全局的内存起源，访问要加全局锁，为所有mcentral提供mspan资源, 包含68*2个mcentral。mheap没有资源时，会向操作系统申请新内存, mheap主要用于大对象的内存分配，以及管理未切割的mspan。
- 分配流程  
  - <=16B的对象(不含指针)  使用mcache的tiny分配器分配  
  - (16B,32KB]的对象
    - 首先计算对象的规格大小，然后使用mcache中相应规格大小的mspan分配
    - 如果mcache没有相应规格大小的mspan，则向mcentral申请
    - 如果mcentral没有相应规格大小的mspan，则向mheap申请
    - 如果mheap中也没有合适大小的mspan，则向操作系统申请
  - >32KB的对象  直接从mheap上分配  

垃圾回收
三色标记法+混合写屏障
- 三色标记
  - 对象分为三种颜色标记  黑、灰、白
  - 白对象 未被扫描的对象(GC开始时)，或者是垃圾对象(GC结束时)
  - 灰对象，已被扫描，但其引用子对象还没扫描
  - 黑对象，已被扫描，且其引用子对象已被扫描
- 并发问题
  - 漏标
    一个已经扫描完成的黑对象，指向了一个被灰\白对象删除引用的白色对象，且该白色对象上游没有灰色对象，白色对象会被回收
    漏标的情况不能容忍，因为删除了程序正在使用的对象，会造成程序异常
  - 错标
    一个灰色对象被上游对象删除引用，灰色对象不会被回收
    错标对象在下一轮 GC 就会被正确回收
- 解决并发
  - 强弱三色不变式
    - 强三色不变式
      不允许黑色对象引用白色对象
    - 弱三色不变式
      黑色对象可以引用白色对象，但白色对象上游必须有灰色对象
  - 写屏障
    - 插入写屏障
      规则维护了强三色不变式，保证当一个黑色对象指向一个白色对象前，会先触发屏障，将白色对象置为灰色，再建立引用
    - 删除写屏障
      实现了弱三色不变式，保证当一个白色对象即将被上游删除引用前，会触发屏障将其置灰，之后再删除上游指向其的引用
- 实现
  - 初始事件
    - 暂停所有Goroutines
    - 开启混合写屏障机制
    - 扫描Goroutines栈帧，标记栈对象引用的堆对象为灰色，
    - 标记其他根对象引用的堆对象为灰色
      - 全局变量
      - 寄存器中的变量
    - 恢复所有Goroutines
  - 并发标记
    - 对象标记
      - 递归处理灰色对象
    - 混合写屏障
      - 记录对象引用的修改
    - 标记完成STW事件
      - 暂停所有Goroutines
      - 处理剩余的写屏障记录
      - 关闭混合写屏障机制
      - 恢复所有Goroutines
  - 并发清除
    - 遍历堆内存  垃圾回收器会遍历整个堆内存，查找所有未被标记的白色对象
    - 释放内存  垃圾回收器会释放所有未被标记的白色对象的内存
    - 更新空闲列表  在清除未标记的对象后，垃圾回收器会更新内存管理的数据结构
     
- 触发时机
  - 定期触发，默认每隔两分钟触发一次GC
  - 新建对象触发，检测内存分配如果到达阀值触发GC
  - 手动触发，runtime.GC()

逃逸分析
- 变量大小不确定
- 变量类型不确定
- 变量分配的内存超过用户栈最大值
- 变量暴露给了外部指针
```

## 并发控制 ##
```
goroutine 
go语言的并发执行单元，可以同时执行多个goroutine，由Go runtime调度
- 使用
  go func() {
	
  }()

WaitGroup  
同步等待组  
- 实现
  - Add 增加任务
  - Done 减少任务
  - Wait 等待任务完成

channel  
用于在goroutine之间进行通信和同步的机制
- 结构
  // runtime/chan.go
  type hchan struct {
      qcount   uint           // 当前队列中的元素个数
      dataqsiz uint           // 环形队列的大小（容量）
      buf      unsafe.Pointer // 指向环形队列的指针
      elemsize uint16         // 元素大小
      closed   uint32         // 是否关闭
      elemtype *_type         // 元素类型
      sendx    uint           // 发送索引
      recvx    uint           // 接收索引
      recvq    waitq          // 接收等待队列
      sendq    waitq          // 发送等待队列
      
      lock mutex              // 互斥锁，保护所有字段
  }
- 操作
  |      操作      | nil的channel | 正常channel | 已关闭的channel |
  | :------------: | :----------: | :---------: | :-------------: |
  |    读 <-ch     |     阻塞     | 成功或阻塞  |    读到零值     |
  |    写 ch<-     |     阻塞     | 成功或阻塞  |      panic      |
  |    close(ch)   |    panic     |    成功     |      panic      |
  - 发送
    - 空通道，阻塞
    - 加锁，已关闭通道，直接panic
    - recvq不为空，移出第一个协程接收数据
    - 循环队列未满，数据添加到buf中
    - 阻塞，并放入sendq中
  - 读取
    - 空通道，阻塞
    - 加锁，通道关闭且缓冲为空，返回空值
    - 发送队列不为空，发送者出队，通道是非缓冲类型通道，直接将发送者数据传送给接收者
    - 发送队列不为空，发送者出队，通道是缓冲类型通道，从循环队列取出一条数据，将发送者数据传递至循环队列
    - 通道缓冲有数据，从buf中取出值
    - 通道缓冲无数据，阻塞，并放入recvq中
  - 关闭
    - 空通道，直接panic
    - 加锁，已关闭通道，直接panic
    - 唤醒接收者队列中所有接受者
    - 唤醒发送者队列中所有发送者
- 优雅关闭channel
  - defer + recover
  - sync.Once
  - channel
    - 一个发送者，一个接收者，发送者关闭
    - 一个发送者，多个接收者，发送者关闭
    - 多个发送者，一个接收者，接收者关闭，发送者进行关闭通道的监控
    - 多个发送者，多个接收者，发送者和接收者把关闭请求发送给中间人，中间人进行关闭，发送者和接收者进行关闭通道的监控

select  
同时监听多个通道的读写操作，并在其中任意一个通道就绪时执行相应的操作
- 注意事项 
  - 通道关闭
    如果其中一个case通道已经关闭，则每次都会执行到这个case  
    如果select里边只有一个case，而这个case被关闭了，则会出现死循环  
  - 不读关闭后通道
    将关闭通道置为nil

锁
并发编程中一种同步机制，用于保护共享资源的访问
- 互斥锁(sync.Mutex)  
  同一时刻只能有一个锁操作
- 读写锁(sync.RWMutex)  
  同一时刻只能写操作，或者多个读操作

atomic  
并发编程中的一种同步机制，保证单个指令操作的原子性
- 与锁的区别
  - 访问粒度
    - 原子操作通常是针对单个变量或内存位置的操作
    - 锁通常是针对一段代码或一组操作的访问进行同步      
  - 使用方式
    - 原子操作是通过硬件指令或特定的原子操作函数来实现的，可以直接应用于变量或内存位置，而无需额外的代码
    - 锁是通过编程语言提供的锁机制来实现的，需要显式地使用锁的相关方法或语句来保护临界区的访问
  - 性能开销
    - 原子操作通常具有较低的性能开销，因为它们是在硬件级别上实现的，无需额外的同步机制
    - 锁通常具有较高的性能开销，因为它们需要进行上下文切换和线程同步等操作

sync.Cond  
通常应用于等待某个条件的一组goroutine，当条件变为true的时候，其中一个goroutine或者所有的goroutine都会被唤醒执行

context  
用于在单个请求下多个goroutine之间同步数据、取消信号、超时控制
- 结构
  type Context interface {
      // 当context被取消或者到了 deadline，返回一个被关闭的 channel
      Done() <-chan struct{}
      // 在 channel Done 关闭后，返回 context 取消原因
      Err() error
      // 返回context是否会被取消以及自动取消时间
      Deadline() (deadline time.Time, ok bool)
      // 获取 key 对应的 value
      Value(key interface{}) interface{}
  }
- 分类
  - emptyCtx
  - valueCtx
  - cancelCtx
  - timerCtx
  
sync.Once  
函数只执行一次

Pool  
对象缓冲池

GMP
GMP是Go运行时的调度器模型，把大量的goroutine分配到少量线程上去执行
- 概念
  - G  即goroutine，是golang中对协程的抽象，需要绑定在m上执行
  - P  即processor，是golang中的调度器， g的存储容器
  - M  即machine，是golang中对线程的抽象，需要和p进行结合，从而进入到gmp调度体系之中，m的运行目标始终在g0和g之间进行切换，寻找任务(执行g0)，执行任务(执行g)
- 初始化
  - 进程启动，会新建M0和G0，并且互相绑定
  - 初始化p数组，P的个数和系统的CPU核数一致，把数组中第一个P和M0绑定
  - 把runtime.main函数作为groutine的执行函数，新建一个G，这个G会放到M0绑定的P的可执行队列上
  - 创建新M时(动态生成g0)
- 调度
  - put g  当某个g中通过go func(){...}操作创建子g时，会先尝试将子g添加到当前所在p的lrq中(无锁化)；如果lrq满了，则会将g追加到grq中(全局锁). 此处采取的思路是“就近原则”
  - get g  gmp调度流程中，m和p结合后，运行的g0会不断寻找合适的g用于执行，此时会采取“负载均衡”的思路，遵循如下实施步骤：
    - 优先从当前p的lrq中获取g(无锁化-CAS)
    - 从全局的grq中获取g(全局锁)
    - 取io就绪的g(netpoll 机制)
    - 从其他p的lrq中窃取g(无锁化-CAS)
  - 阻塞
    - M执行G发生了系统调用，M和P立即解绑，如果P本地队列有G或者全局队列有G，P会绑定新的M，否则P则会加入到空闲列表
    - 当M系统调用结束时候，会尝试获取一个空闲的P执行，把G放入到这个P的本地队列。如果获取不到P，那么这个线程M变成休眠状态，加入到空闲线程中，然后这个G会被放入全局队列中
- 调度时机
  - 结束让渡  g顺利执行完成
  - 主动让渡  程序主动调用runtime.Gosched()
  - 阻塞让渡  g在执行过程中所依赖的外部条件没有达成，需要进入阻塞等待的状态
  - 抢占
    - 协助式抢占  针对G运行时间太长(一般是10ms)的情况，会设置抢占标志，随后由G进行栈扩张检查时，根据抢占标志触发抢占调度
    - 信号异步抢占  针对G运行时间太长(一般是10ms)的情况，会在支持异步抢占的系统内，直接发送信号给M，M收到信号后实施异步抢占

内存泄漏
- 原因
  - 读写nil通道
  - 遍历未关闭通道
  - 读写不同步
  - 资源无法释放  加锁/解锁未同步、网络访问超时、写入大文件、数据库读写产生死锁  
- 解决
  - 使用带超时的操作，比如select语句配合time.After
  - 使用context来控制生命周期
```

## 框架和库  ##
```
gin
beego
```

学习资料  
rune  
[深究字符串——从byte rune string到Unicode与UTF-8](http://www.randyfield.cn/post/2022-01-14-rune-unicode-utf8/)  
slice  
[Go slice新的扩容机制-你背的八股文过时啦](https://juejin.cn/post/7136774425415794719)  
map  
[深度解密Go语言之map](https://zhuanlan.zhihu.com/p/66676224)  
sync.map  
[深度解密Go语言之sync.map](https://zhuanlan.zhihu.com/p/344834329)  
channel  
[深度解密Go语言之channel](https://zhuanlan.zhihu.com/p/74613114)  
[08 - 如何优雅地关闭 channel](https://qcrao91.gitbook.io/go/channel/ru-he-you-ya-di-guan-bi-channel)  
context  
[深度解密Go语言之context](https://zhuanlan.zhihu.com/p/68792989)  
gmp  
[你不知道的runtime.GOMAXPROCS(1)](https://zhuanlan.zhihu.com/p/258759046)
[Golang的协程调度器原理及GMP设计思想](https://github.com/aceld/golang/blob/main/2%E3%80%81Golang%E7%9A%84%E5%8D%8F%E7%A8%8B%E8%B0%83%E5%BA%A6%E5%99%A8%E5%8E%9F%E7%90%86%E5%8F%8AGMP%E8%AE%BE%E8%AE%A1%E6%80%9D%E6%83%B3%EF%BC%9F.md)  
[GMP原理与调度](https://www.topgoer.com/%E5%B9%B6%E5%8F%91%E7%BC%96%E7%A8%8B/GMP%E5%8E%9F%E7%90%86%E4%B8%8E%E8%B0%83%E5%BA%A6.html)  
[深入golang runtime的调度](https://zboya.github.io/post/go_scheduler/) 
[GO：从进程启动到调度](https://zhuanlan.zhihu.com/p/607208932)  
[16. Go调度器系列解读（三）：GMP 模型调度时机](https://juejin.cn/post/7330052230472663055)
内存管理  
[图解Go语言内存分配](https://juejin.cn/post/6844903795739082760)  
[Golang内存模型与分配机制](https://zhuanlan.zhihu.com/p/603335718)  
[1.9 我要在栈上。不，你应该在堆上](https://eddycjy.gitbook.io/golang/di-1-ke-za-tan/stack-heap)  
垃圾回收  
[Golang 垃圾回收原理分析](https://zhuanlan.zhihu.com/p/605315127)  
[golang 垃圾回收（五）混合写屏障](https://liqingqiya.github.io/golang/gc/%E5%9E%83%E5%9C%BE%E5%9B%9E%E6%94%B6/%E5%86%99%E5%B1%8F%E9%9A%9C/2020/07/24/gc5.html)  
[Golang 垃圾回收：一次 GC 周期的详细过程](https://juejin.cn/post/7388842078798807049)
并发  
[Go 语言如何进行竞态分析](https://liqiang.io/post/how-golang-detect-data-race)  
[goroutine 泄漏与检测](https://dbwu.tech/posts/golang_goroutine_leak/)  
[温故知新——Golang GMP 万字洗髓经](https://zhuanlan.zhihu.com/p/869632834)
sync.Once  
[通过 sync.Once 学习到 Go 的内存模型](https://studygolang.com/articles/25299)  
sync.Mutex  
[Golang 单机锁实现原理](https://zhuanlan.zhihu.com/p/599119674)
[Golang Mutex 原理解析](https://juejin.cn/post/7086756462059323429)  
[Golang RWMutex 原理解析](https://juejin.cn/post/7091236529959338015)  
reflect  
[Go反射无敌了，彻底懂了](https://mp.weixin.qq.com/s/acu01W1Ch48OAjPRiZGKDw)  
[Go系列](https://lailin.xyz/)  