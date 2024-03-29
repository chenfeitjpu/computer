*golang*
- [定义](#定义)
- [使用](#使用)
  - [基础语法](#基础语法)
  - [数据结构](#数据结构)
  - [内存管理](#内存管理)
  - [并发](#并发)
- [学习资料](#学习资料)

# 定义 #
静态、强类型、编译型语言

# 使用 #
## 基础语法 ##
```
变量  
- var name [type] [= expression]  
- var name, name [type] [= expression, expression]  
- var (  
    name [type] [= expression]  
    name [type] [= expression]  
  )
- name := value
- _ 不会分配内存

常量
常量数据类型只能是布尔型、数字型（整数型、浮点型和复数）和字符串型  
- const name [type] = expression
- const (  
    name [type] = expression  
    name [type] = expression    
  )  
- iota    

数据类型
- uint8 uint16 uint32 uint64 uint int8 int16 int32 int64 int
- byte rune
- uintptr
- float32 float64 
- complex64 complex128
- bool
- string
- array struct 
- slice map channel func pointer
- interface

运算符
- 算术运算符  + - * / % variable++ variable--
- 关系运算符  > >= < <= == != 
- 逻辑运算符  && || !
- 位运算符  & | ^  << >>
- 赋值运算符  =

流程控制 
- if else if else
- switch case fallthrough
- for range break continue
- goto
  - 只能在函数内跳转，需要配合标签一起使用
  - 不能跳过内部变量声明语句
  - 只能跳到同级作用域或者上层作用域内，不能跳到内部作用域内
```

## 数据结构 ##
```
array
- 声明
  - var name [size]type
  - var name = [...]type{value}
  - var name = [...]type{index:value}
- 遍历  
  - for index
  - for range
- 多维数组   
  - var name [size][size]type
- 注意事项
  - 多维数组只有第一层可以使用...来让编译器推导数组长度
  - 数组是值类型，赋值和传参会复制整个数组

slice
- 使用
  - 声明  
    - var name []type
    - name := make([]type, length, capacity)
  - 切片表达式
    - a[low : high : max]  
      0 <= low <= high <= max <= cap(a)   
  - append
  - copy
- 结构
  type slice struct {
      array unsafe.Pointer
      len   int
      cap   int
  }
  slice占用24个字节  
  - array 指向底层数组的指针，占用8个字节  
  - len 切片的长度，占用8个字节  
  - cap 切片的容量，cap 总是大于等于 len 的，占用8个字节  
- 扩容
  - 1.18以前
    - 如果新申请容量比两倍原有容量大，那么扩容后容量大小为新申请容量
    - 如果原有slice长度小于1024，那么就扩容为原来的2倍
    - 如果原有slice长度大于等于1024，那么每次扩容就扩为原来的1.25倍，直到新容量大于期望容量
    - 内存对齐(size_to_class&class_to_size)
      CPU始终以字长访问内存，如果不进行内存对齐，很可能增加CPU访问内存的次数
  - 1.18及以后
    - 如果新申请容量比两倍原有容量大，那么扩容后容量大小为新申请容量
    - 如果原有slice长度小于256，那么就扩容为原来的2倍
    - 如果原有slice长度大于等于256，那么每次扩容就扩为原来的1.25倍+3/4*256，直到新容量大于期望容量
    - 内存对齐(size_to_class&class_to_size)
      CPU始终以字长访问内存，如果不进行内存对齐，很可能增加CPU访问内存的次数

map
- 使用
  - 声明  
    - var name map[type]type 
    - name := make(map[type]type, [cap])  
  - 删除
    - delete(map, key)
- 特点
  - 无序
    - 添加时无序
    - 扩容时发生key的搬迁
    - 读取时从一个随机序号的bucket开始遍历，并且是从这个bucket的一个随机序号的cell开始遍历
- 结构
  type hmap struct {
      // 元素个数，调用 len(map) 时，直接返回此值
	  count     int
	  flags     uint8
	  // buckets 的对数 log_2
	  B         uint8
	  // overflow 的 bucket 近似数
	  noverflow uint16
      // 计算 key 的哈希的时候会传入哈希函数
	  hash0     uint32
      // 指向 buckets 数组，大小为 2^B
      // 如果元素个数为0，就为 nil
	  buckets    unsafe.Pointer
	  // 等量扩容的时候，buckets 长度和 oldbuckets 相等
	  // 双倍扩容的时候，buckets 长度会是 oldbuckets 的两倍
	  oldbuckets unsafe.Pointer
	  // 指示扩容进度，小于此地址的 buckets 迁移完成
	  nevacuate  uintptr
	  extra *mapextra // optional fields
  }
  type bmap struct {
      topbits  [8]uint8
      keys     [8]keytype
      values   [8]valuetype
      pad      uintptr
      overflow uintptr
  }
  type mapextra struct {
      // overflow[0] contains overflow buckets for hmap.buckets.
      // overflow[1] contains overflow buckets for hmap.oldbuckets.
      overflow [2]*[]*bmap

      // nextOverflow 包含空闲的 overflow bucket，这是预分配的 bucket
      nextOverflow *bmap
  }
- 扩容
  - 等量扩容(桶中空位过多)
    - 当B<15 时，overflow的bucket数量超过2^B
    - 当B>=15 时，overflow的bucket数量超过2^15
  - 双倍扩容(桶不够用了)
    装载因子>6.5
    装载因子=count/(2^B) map中元素的个数/map中当前桶的个数
  - minTopHash
    当一个cell的tophash值小于minTopHash时，标志这个cell的迁移状态
  - 遍历
    通过新桶找旧桶，旧桶已经迁移，直接遍历新桶，旧桶没有迁移，遍历旧桶中会分到新桶中的元素
  - 新增｜修改
    如果map处在扩容的过程中，那么当key定位到了某个bucket后，直接触发一次搬迁操作
  - 删除  
    如果map处在扩容的过程中，那么当key定位到了某个bucket后，直接触发一次搬迁操作
- 操作
  - 查找
    - 计算key的hash值
    - 通过最后的B位来确定桶号
    - 根据key对应的hash值前8位快速确定是在这个桶的哪个位置
    - 对比key是否匹配
    - 如果都没有找到，就去连接的下一个溢出桶中找
  - 遍历
    - 遍历所有的bucket以及它后面挂的overflow bucket  
    - 遍历bucket中的所有cell  
  - 赋值
    查找key，进行修改或者新增
  - 删除  
    查找key，对key和value进行清空
- 线程安全
  - map+sync.RWMutex
  - sync.Map
    - sync.Map适用于读多、更新多、删多、写少的场景  
    - 倘若写操作过多，sync.Map基本等价于互斥锁+map  

sync.map
- 使用
  - Store()  写入
  - Load()  读取
  - Delete()  删除
  - Range()  遍历
  - LoadOrStore()  key存在，就读取，否则写入
- 结构
  type Map struct {
      mu Mutex
      read atomic.Value
      dirty map[any]*entry
      misses int
  }
  value的值
  - 当p == nil时，说明这个键值对已被删除，并且m.dirty == nil，或m.dirty[k]指向该entry
  - 当p == expunged时，说明这条键值对已被删除，并且m.dirty != nil，且m.dirty中没有这个key
  - 正常值
- 实现
  sync.Map设置了两个map(read map和dirty map)，read map通过原子方式访问，dirty map通过加锁访问，两个map的key指向同一个value
  - 操作
    - 写入
      - 如果在read里能够找到待存储的key，并且对应的entry的值不为expunged，也就是没被删除时，直接更新对应的entry即可
      - 第一步没有成功，要么read中没有这个key，要么key被标记为删除。则先加锁，再进行后续的操作
      - 再次在read中查找是否存在这个key，也就是double check一下，这也是lock-free编程里的常见套路。如果read中存在该key，但p == expunged，说明m.dirty != nil并且m.dirty中不存在该key值
        - 将p的状态由expunged更改为nil
        - dirty map插入key
        - 直接更新对应的value
      - 如果read中没有此key，那就查看dirty中是否有此key，如果有，则直接更新对应的value，这时read中还是没有此key
      - 最后一步，如果read和dirty中都不存在该key
        - 如果dirty为空，则需要创建dirty，并从read中拷贝未被删除的元素
        - 更新amended字段，标识dirty map中存在read map中没有的key
        - 将k-v写入dirty map中
    - 读取
      - 直接在read中找，如果找到了直接调用entry的load方法，取出其中的值
      - 如果read中没有这个key，且amended为true，说明dirty中可能存在我们要找的key。当然要先上锁，再尝试去dirty中查找。在这之前，仍然有一个double check的操作。若还是没有在read中找到，那么就从dirty中找。不管dirty中有没有找到，都要"记一笔"，因为在dirty被提升为read之前，都会进入这条路径
        直接将misses的值加1，表示一次未命中，如果misses值小于m.dirty 的长度，就直接返回。否则，将m.dirty晋升为read，并清空dirty，清空misses计数值
      - read中没有这个key，且amended为fase，说明dirty为空，那直接返回空和false
    - 删除
      - 先从read里查是否有这个key，如果有则执行entry.delete方法，将p置为nil，这样read和dirty都能看到这个变化
      - 如果没在read中找到这个key，并且dirty不为空，那么就要操作dirty了，操作之前，还是要先上锁。然后进行double check，如果仍然没有在read里找到此key，则从dirty中直接删掉这个key。
      - read中没有这个key，且amended为fase，说明dirty为空，那直接返回空和false

func 
- 声明  
  func name(parameter type, parameter type) ([output] type, [output] type) {
      return value, value
  }
- 闭包
  - 函数内部变量离开其作用域后始终保持在内存中而不被销毁
- defer
  - 延迟函数的参数在defer声明时就决定了
  - 多个defer语句，按照先进后出的方式执行
  - return赋值 执行defer return返回

error&panic&recover

struct
- 声明
  type name struct {  
      name type 
      name type  
 }
- 嵌套结构体
  - 匿名结构体

method
- 声明
  func (name type) name(parameter type, parameter type) ([output] type, [output] type) {
      return value, value
  }
- 使用
  - object.method()
  - 方法变量
  - 方法表达式 
- 注意事项
  - 类型T只有接受者是T的方法
  - 类型*T拥有接受者是T和*T的方法

interface
- 声明
  type name interface {  
      name(name type) type  
      name(name type) type  
  }
- 使用
  - 对于T接收者实现的接口，无论使用T还是*T都没有问题
  - 对于*T接收者实现的接口，只能使用*T类型
- 类型断言
  - i.(T)
  - i.(type)
- 结构
  //非空接口
  type iface struct {
      tab  *itab
      data unsafe.Pointer
  }
  type itab struct {
      inter  *interfacetype // 接口类型
      _type  *_type  //实体类型
      link   *itab
      hash   uint32 // copy of _type.hash. Used for type switches.
      bad    bool   // type does not implement interface
      inhash bool   // has this itab been added to hash?
      unused [2]byte
      fun    [1]uintptr // variable sized
  }
  //空接口
  type eface struct {
      _type *_type  // 实体类型
      data  unsafe.Pointer
  }

pointer
- 使用
  - &取址
  - *取值
- 分类 
  - 普通指针  *T
  - 通用指针  unsafe.Pointer
  - 指针地址  uintptr
- 比较
  - unsafe.Pointer只是单纯的通用指针类型，用于转换不同类型指针，它不可以参与指针运算
  - uintptr是用于指针运算的，GC不把uintptr当指针，也就是说uintptr无法持有对象，uintptr类型的目标会被回收
  - unsafe.Pointer可以和普通指针进行相互转换
  - unsafe.Pointer可以和uintptr进行相互转换

reflect
- 作用 
  - 程序在运行的时候能够观察并且修改自己的行为
- 使用
  - reflect.TypeOf()
  - reflect.Type.Field()
  - reflect.Type.Method()
  - reflect.ValueOf()
  - reflect.Value.Field()
  - reflect.Value.Method()
  - reflect.Value.MethodByName()
  - reflect.Value.Call()
- reflect慢的主要原因
  - 涉及到内存分配以及后续的GC
  - reflect实现里面有大量的枚举，也就是for循环，比如类型之类的
```

## 内存管理 ##
```
make & new
- make 
  - 为slice、map、channel分配内存并初始化
  - 返回值类型
- new 
  - 为任意类型分配内存
  - 返回引用类型

内存分配(TCMalloc)
- 核心思想
  - 把内存分为多级管理，从而降低锁的粒度  
    - mheap  全局的内存起源，访问要加全局锁
    - mcentral  每种对象大小规格(全局共划分为68种)对应的缓存，锁的粒度也仅限于同一种规格以内
    - mcache  每个P(正是GMP中的P)持有一份的内存缓存，访问时无锁
- 内存划分
  - arena  512G 把内存分割成8KB大小的页
  - bitmap  16G  标识arena区域哪些地址保存了对象 一个byte大小的内存对应arena区域中4个指针大小(指针大小为8B)的内存
  - spans  512M  存放mspan指针，每个指针对应一页
- 内存管理单元
  - mspan
    - 作用 
      由一片连续的8KB的页组成的大块内存
    - 结构
      type mspan struct {
          //链表前向指针，用于将span链接起来
          next *mspan 
          //链表前向指针，用于将span链接起来
          prev *mspan 
          // 起始地址，也即所管理页的地址
          startAddr uintptr 
          // 管理的页数
          npages uintptr 
          // 块个数，表示有多少个块可供分配
          nelems uintptr 
          //分配位图，每一位代表一个块是否已分配
          allocBits *gcBits 
          // 已分配块的个数
          allocCount uint16 
          // class表中的class ID，和Size Classs相关
          spanclass spanClass  
          // class表中的对象大小，也即块大小
          elemsize uintptr 
      }
- 内存管理组件
  - mcache
    - 作用
      每个工作线程都会绑定一个mcache，缓存可用的mspan资源
    - 结构
      type mcache struct {
          alloc [numSpanClasses]*mspan 
      }
  - mcentral
    - 作用
      为所有mcache提供mspan资源  
    - 结构
      type mcentral struct {
          // 互斥锁
          lock mutex 
          // 规格
          sizeclass int32 
          // 尚有空闲object的mspan链表
          nonempty mSpanList 
          // 没有空闲object的mspan链表，或者是已被mcache取走的msapn链表
          empty mSpanList 
          // 已累计分配的对象个数
          nmalloc uint64 
      }
  - mheap
    - 作用
      - 当mcentral没有空闲的mspan时，会向mheap申请
      - mheap没有资源时，会向操作系统申请新内存
      - mheap主要用于大对象的内存分配，以及管理未切割的mspan，用于给mcentral切割成小对象
- 分配条件
  - new(T)
  - &T{}
  - make(T)
- 分配流程  
  - >32KB的对象
    直接从mheap上分配  
  - <=16B的对象
    使用mcache的tiny分配器分配  
  - (16B,32KB]的对象
    - 首先计算对象的规格大小，然后使用mcache中相应规格大小的mspan分配
    - 如果mcache没有相应规格大小的mspan，则向mcentral申请
    - 如果mcentral没有相应规格大小的mspan，则向mheap申请
    - 如果mheap中也没有合适大小的mspan，则向操作系统申请

逃逸分析
- 现象
  分析内存分配地址是栈还是堆
- 场景
  - 指针被作用域之外所引用
  - 无法确定其具体的类型
  - 变量大小不确定(如slice长度或容量不定)
  - 变量较大(栈空间不足)

垃圾回收
- 常见算法
  - 标记清扫
    - 流程
      - 标记  标记出当前还存活的对象
      - 清扫  清扫掉未被标记到的垃圾对象
    - 缺点
      - 会产生内存碎片
  - 标记压缩
    - 流程
      - 标记  标记出当前还存活的对象
      - 压缩  清扫掉未被标记到的垃圾对象，对存活对象进行压缩整合，使得整体空间更为紧凑，从而解决内存碎片问题
    - 缺点
      - 实现时会有很高的复杂度
  - 半空间复制
    - 流程
      - 分配两片相等大小的空间，称为fromspace和tospace
      - 每轮只使用fromspace空间，以GC作为分水岭划分轮次
      - GC时，将fromspace存活对象转移到tospace中，并以此为契机对空间进行压缩整合
      - GC后，交换fromspace和tospace，开启新的轮次
    - 缺点
      - 比较浪费空间
  - 引用计数
    - 流程
      - 对象每被引用一次，计数器加1
      - 对象每被删除引用一次，计数器减1
      - GC时，把计数器等于0的对象删除
    - 缺点
      - 无法解决循环引用或者自引用问题

三色标记法
- 流程
  - 对象分为三种颜色标记  黑、灰、白
  - 黑对象代表，对象自身存活，且其指向对象都已标记完成
  - 灰对象代表，对象自身存活，但其指向对象还未标记完成
  - 白对象代表，对象尙未被标记到，可能是垃圾对象
  - 标记开始前，将根对象（全局对象、栈上局部变量等）置黑，将其所指向的对象置灰
  - 标记规则是，从灰对象出发，将其所指向的对象都置灰. 所有指向对象都置灰后，当前灰对象置黑
  - 标记结束后，白色对象就是不可达的垃圾对象，需要进行清扫
- 并发垃圾回收
  - 流程
    - 1.5之前，GC时需要停止全局的用户协程，专注完成GC工作后，再恢复用户协程
    - 1.5及以后，用户协程和后台的GC协程并发运行
      - 用户协程运行时可能对对象间的引用关系进行调整，这会严重打乱GC三色标记时的标记秩序
        - 问题
          - 漏标
            - 灰、白对象删除了白色对象
            - 黑色对象指向了白色对象
          - 错标
            - 黑色对象删除了灰色对象
            - 灰色对象是垃圾对象
        - 解决
          - 强三色不变式
            白色对象不能被黑色对象直接引用 
            - 实现
              - 插入写屏障
                保证当一个黑色对象指向一个白色对象前，会先触发屏障将白色对象置为灰色  
              - 删除写屏障
                当一个白色对象即将被上游删除引用前，会触发屏障将其置灰，之后再删除上游指向其的引用.
          - 弱三色不变式
            白色对象可以被黑色对象引用，但要从某个灰对象出发仍然可达该白对象  
- 混合写屏障
  - GC开始时栈上的对象并标记为黑色(逐个暂停,逐个扫描,每个栈单独扫描, 无需STW整个程序)
  - GC期间，栈上创建的新对象标记为黑色，堆上创建的新对象标记为灰色，堆上删除的对象标记为灰色
  - 堆对象正常启用插入写屏障
  - 堆对象正常启用删除写屏障
  - 回收未标记对象
  - 标记过程中不再需要STW，标记准备和标记结束 还是需要STW的
```

## 并发 ##
```
组件
- goroutine
  - 使用
    - go func(){}
- waitGroup
  - wg := &sync.WaitGroup{}
  - wg.Add()
  - wg.Done()
  - wg.Wait()
- channel
  - 结构
    type hchan struct {
  	    qcount   uint           // total data in the queue
  	    dataqsiz uint           // size of the circular queue
  	    buf      unsafe.Pointer // points to an array of dataqsiz elements
  	    elemsize uint16
  	    closed   uint32
  	    elemtype *_type // element type
	    sendx    uint   // send index
 	    recvx    uint   // receive index
	    recvq    waitq  // list of recv waiters
	    sendq    waitq  // list of send waiters
	    lock mutex
    }
    - buf  指向一个数组，用来实现循环队列
    - sendx  循环队列的队尾指针
    - recvx  循环队列的队头指针
    - recvq  等待从通道中接收数据的goroutine
    - sendq  等待发送数据到通道的goroutine
  - 操作
    - 发送
      - 空通道，阻塞
      - 加锁
      - 已关闭通道，直接panic
      - recvq不为空，移出第一个协程接收数据
      - 循环队列未满，数据添加到buf中
      - 当前队列阻塞，并放入sendq中
    - 接收
      - 空通道，阻塞
      - 加锁
      - 通道关闭且缓冲为空，返回空值
      - 发送队列不为空，发送者出队，通道是非缓冲类型通道，直接将发送者数据传送给接收者
      - 发送队列不为空，发送者出队，通道是缓冲类型通道，从循环队列取出一条数据，将发送者数据传递至循环队列
      - 通道缓冲无数据，当前协程阻塞，并放入recvq中
      - 通道缓冲有数据，从buf中取出值
    - 关闭
      - 空通道，直接panic
      - 加锁
      - 已关闭通道，直接panic
      - 唤醒接收者队列中所有接受者
      - 唤醒发送者队列中所有发送者
    | 操作 | nil的channel | 正常channel | 已关闭的channel |
    | :--: | :--: | :--: | :--: |
    | 读 <-ch | 阻塞 | 成功或阻塞 | 读到零值 |
    | 写 ch<- | 阻塞 | 成功或阻塞 | panic |
    | 关闭 close(ch) | panic | 成功 | panic | 
  - 选择
    - select
      监听多个channel
- mutex
  - 互斥锁  sync.Mutex
  - 读写互斥锁  sync.RWMutex

context
- 作用
  - 解决goroutine之间退出通知、元数据传递
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
    type emptyCtx int
  - valueCtx
    type valueCtx struct {
        Context
        key, val any
    }
  - cancelCtx
    type cancelCtx struct {
        Context
        mu       sync.Mutex         
        done     atomic.Value          
        children map[canceler]struct{} 
        err      error                 
        cause    error                
    }
  - timerCtx
    type timerCtx struct {
        *cancelCtx
        timer *time.Timer
        deadline time.Time
    }

GMP
- 思想
  把大量的goroutine分配到少量线程上去执行
- 概念
  - G  goroutine协程
  - P  processor处理器
  - M  thread线程
- 流程
  - 全局队列  
    - 存放等待运行的G  
  - 本地队列  
    - 存放等待运行的G
    - 数量有限，不超过256个
    - 新创建的G优先放在P的本地队列中，如果队列满了，会把本地队列中一半的G移动到全局队列  
      - 在创建G时，有自旋状态的M，不做处理；如果没有，会寻找空闲的P，和M进行绑定
  - P列表  
    - 程序启动时创建
    - 有GOMAXPROCS个
    - 手动设置
      - 环境变量$GOMAXPROCS
      - 在程序中通过runtime.GOMAXPROCS来设置
  - M 
    - 线程想运行任务就得获取P，从P的本地队列获取G，P队列为空时，M也会尝试从全局队列拿一批G放到P的本地队列，或从其他P的本地队列偷一半放到自己P的本地队列。M运行G，G执行之后，M会从P获取下一个G，不断重复下去  
    - 数量限制
      - go语言本身的限制M的最大数量10000.
      - runtime/debug中的SetMaxThreads来设置
    - 系统中最多有GOMAXPROCS个自旋的线程，多余的线程会让它们休眠，长时间休眠等待GC回收销毁
- 策略  
  - 复用线程
    - work stealing机制
      当本线程无可运行的G时，尝试从其他线程绑定的P偷取G，而不是销毁线程
    - hand off机制
      当本线程因为G进行系统调用阻塞时，线程释放绑定的P，把P转移给其他空闲的线程执行
- 阻塞
  - M执行G发生了阻塞操作，M和P立即解绑，如果P本地队列有G，全局队列有G，P会绑定M，否则P则会加入到空闲列表
  - 当M系统调用结束时候，这个G会尝试获取一个空闲的P执行(非阻塞调用会优先获取之前绑定的P)，并放入到这个P的本地队列。如果获取不到P，那么这个线程M变成休眠状态，加入到空闲线程中，然后这个G会被放入全局队列中
```

# 学习资料 #
slice  
[Go slice新的扩容机制-你背的八股文过时啦](https://juejin.cn/post/7136774425415794719)  
map  
[深度解密Go语言之map](https://zhuanlan.zhihu.com/p/66676224)  
sync.map  
[深度解密Go语言之sync.map](https://zhuanlan.zhihu.com/p/344834329)  
channel  
[深度解密Go语言之channel](https://zhuanlan.zhihu.com/p/74613114)  
context  
[深度解密Go语言之context](https://zhuanlan.zhihu.com/p/68792989)  
gmp  
[Golang的协程调度器原理及GMP设计思想](https://github.com/aceld/golang/blob/main/2%E3%80%81Golang%E7%9A%84%E5%8D%8F%E7%A8%8B%E8%B0%83%E5%BA%A6%E5%99%A8%E5%8E%9F%E7%90%86%E5%8F%8AGMP%E8%AE%BE%E8%AE%A1%E6%80%9D%E6%83%B3%EF%BC%9F.md)  
[GMP原理与调度](https://www.topgoer.com/%E5%B9%B6%E5%8F%91%E7%BC%96%E7%A8%8B/GMP%E5%8E%9F%E7%90%86%E4%B8%8E%E8%B0%83%E5%BA%A6.html)  
[深入golang runtime的调度](https://zboya.github.io/post/go_scheduler/)  
内存管理  
[图解Go语言内存分配](https://juejin.cn/post/6844903795739082760)  
[Golang内存模型与分配机制](https://zhuanlan.zhihu.com/p/603335718)  
[https://eddycjy.gitbook.io/golang/di-1-ke-za-tan/stack-heap](https://eddycjy.gitbook.io/golang/di-1-ke-za-tan/stack-heap)  
垃圾回收  
[Golang 垃圾回收原理分析](https://zhuanlan.zhihu.com/p/605315127)  
[golang 垃圾回收（五）混合写屏障](https://liqingqiya.github.io/golang/gc/%E5%9E%83%E5%9C%BE%E5%9B%9E%E6%94%B6/%E5%86%99%E5%B1%8F%E9%9A%9C/2020/07/24/gc5.html)  