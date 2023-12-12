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
声明
- var name [size]type
- var name = [...]type{value}
- var name = [...]type{index:value}
遍历  
- for index
- for range
多维数组   
var name [size][size]type
注意事项
- 多维数组只有第一层可以使用...来让编译器推导数组长度
- 数组是值类型，赋值和传参会复制整个数组

slice
使用
- 声明  
  - var name []type
  - name := make([]type, length, capacity)
- 切片表达式
  - a[low : high : max]  
    0 <= low <= high <= max <= cap(a)
- append
- copy
结构
type slice struct {
    array unsafe.Pointer
    len   int
    cap   int
}
slice占用24个字节  
- array 指向底层数组的指针，占用8个字节  
- len 切片的长度，占用8个字节  
- cap 切片的容量，cap 总是大于等于 len 的，占用8个字节  
扩容
- 1.18以前
  - 如果新申请容量比两倍原有容量大，那么扩容后容量大小为新申请容量
  - 如果原有slice长度小于1024，那么就扩容为原来的2倍
  - 如果原有slice长度大于等于1024，那么每次扩容就扩为原来的1.25倍，直到新容量大于期望容量
  - 内存对齐(size_to_class&class_to_size)
- 1.18及以后
  - 如果新申请容量比两倍原有容量大，那么扩容后容量大小为新申请容量
  - 如果原有slice长度小于256，那么就扩容为原来的2倍
  - 如果原有slice长度大于等于256，那么每次扩容就扩为原来的1.25倍+3/4*256，直到新容量大于期望容量
  - 内存对齐(size_to_class&class_to_size)

map
使用
- 声明  
  - var name map[type]type 
  - name := make(map[type]type, [cap])  
- 删除
  - delete(map, key)
特点
- 无序
  - 扩容时发生key的搬迁
  - 读取时从一个随机序号的bucket开始遍历，并且是从这个bucket的一个随机序号的cell开始遍历
结构
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
扩容
- 等量扩容(桶中空位过多)
  - 当B<15 时，overflow的bucket数量超过2^B
  - 当B>=15 时，overflow的bucket数量超过2^15
- 双倍扩容( 桶不够用了)
  装载因子>6.5 双倍扩容
  装载因子=count/(2^B) map中元素的个数/map中当前桶的个数
操作
- 查找
  - 计算key的hash值
  - 通过最后的B位来确定桶号
  - 根据key对应的hash值前8位快速确定是在这个桶的哪个位置
  - 对比key是否匹配
  - 如果都没有找到，就去连接的下一个溢出桶中找
  扩容期间需要通过新桶找旧桶
- 遍历
  双重循环
- 赋值
  查找key，进行修改或者新增
- 删除  
  查找key，对key和value进行清空
线程安全
- map+sync.RWMutex
- sync.Map
  - sync.Map适用于读多、更新多、删多、写少的场景  
  - 倘若写操作过多，sync.Map基本等价于互斥锁+map  
  - sync.Map可能存在性能抖动问题

sync.map
使用
- Store()  写入
- Load()  读取
- Range()  遍历
- LoadOrStore()  读取或写入
结构
type Map struct {
    mu Mutex
    read atomic.Value
    dirty map[any]*entry
    misses int
}
实现
sync.Map设置了两个map(dirty map和read map)，read map通过原子方式访问，dirty map的访问需要加锁
操作
- 写入
  - 如果在read里能够找到待存储的key，并且对应的entry的p值不为expunged，也就是没被删除时，直接更新对应的entry即可
  - 第一步没有成功，要么read中没有这个key，要么key被标记为删除。则先加锁，再进行后续的操作
  - 再次在read中查找是否存在这个key，也就是double check一下，这也是lock-free编程里的常见套路。如果read中存在该 key，但 p == expunged，说明 m.dirty != nil 并且 m.dirty 中不存在该key值 此时: a. 将p的状态由 expunged更改为nil；b. dirty map插入 key。然后，直接更新对应的value
  - 如果 read 中没有此 key，那就查看 dirty 中是否有此 key，如果有，则直接更新对应的 value，这时 read 中还是没有此 key
  - 最后一步，如果 read 和 dirty 中都不存在该 key，则：a. 如果 dirty 为空，则需要创建 dirty，并从 read 中拷贝未被删除的元素；b. 更新 amended 字段，标识 dirty map 中存在 read map 中没有的 key；c. 将 k-v 写入 dirty map 中，read.m 不变。最后，更新此 key 对应的 value
- 读取
  - 直接在read中找，如果找到了直接调用entry的load方法，取出其中的值
  - 如果read中没有这个key，且amended为true，说明dirty中可能存在我们要找的key。当然要先上锁，再尝试去dirty中查找。在这之前，仍然有一个double check的操作。若还是没有在read中找到，那么就从dirty中找。不管 dirty 中有没有找到，都要"记一笔"，因为在dirty被提升为read之前，都会进入这条路径
  - read中没有这个key，且amended为fase，说明dirty为空，那直接返回空和false
- 删除
  - 先从read里查是否有这个key，如果有则执行entry.delete方法，将p置为nil，这样read和dirty都能看到这个变化
  - 如果没在read中找到这个key，并且dirty不为空，那么就要操作dirty了，操作之前，还是要先上锁。然后进行double check，如果仍然没有在read里找到此ke，则从 dirty中删掉这个key。但不是真正地从 dirty 中删除，而是更新 entry 的状态
  - read中没有这个key，且amended为fase，说明dirty为空，那直接返回空和false

func 
声明  
func name(parameter type, parameter type) ([output] type, [output] type) {
    return value, value
}
闭包
- 在函数外部访问函数内部变量成为可能
- 函数内部变量离开其作用域后始终保持在内存中而不被销毁

defer
- 延迟函数的参数在defer声明时就决定了
- 多个defer语句，按照先进后出的方式执行
- return赋值 执行defer return返回

error&panic&recover

struct
声明
type name struct {  
    name type 
    name type  
}
嵌套结构体
- 匿名结构体

method
声明
func (name type) name(parameter type, parameter type) ([output] type, [output] type) {
    return value, value
}
使用
- object.method()
- 方法变量
- 方法表达式 
注意事项
- 类型T只有接受者是T的方法；而类型*T拥有接受者是T和*T的方法

interface
声明
type name interface {  
    name(name type) type  
    name(name type) type  
}
使用
对于值接收者实现的接口，无论使用值类型还是指针类型都没有问题
对于指针接收者实现的接口，只能使用指针类型
类型断言
- i.(T)
- i.(type)
结构
// 非空接口
type iface struct {
    tab  *itab
    data unsafe.Pointer
}
type itab struct {
    inter  *interfacetype
    _type  *_type
    link   *itab
    hash   uint32 // copy of _type.hash. Used for type switches.
    bad    bool   // type does not implement interface
    inhash bool   // has this itab been added to hash?
    unused [2]byte
    fun    [1]uintptr // variable sized
}
// 空接口
type eface struct {
    _type *_type
    data  unsafe.Pointer
}

pointer
使用
- &取址
- *取值
分类 
- 普通指针  *T
- 通用指针  unsafe.Pointer
- 指针地址  uintptr
比较
- unsafe.Pointer只是单纯的通用指针类型，用于转换不同类型指针，它不可以参与指针运算
- uintptr是用于指针运算的，GC不把uintptr当指针，也就是说uintptr无法持有对象，uintptr类型的目标会被回收
- unsafe.Pointer可以和普通指针进行相互转换
- unsafe.Pointer可以和uintptr进行相互转换

reflect
作用 
程序在运行的时候能够观察并且修改自己的行为
使用
- reflect.TypeOf()
- reflect.Type.Field()
- reflect.Type.Method()
- reflect.ValueOf()
- reflect.Value.Field()
- reflect.Value.Method()
- reflect.Value.MethodByName()
- reflect.Value.Call()
reflect慢的主要原因
- 涉及到内存分配以及后续的GC
- reflect实现里面有大量的枚举，也就是for循环，比如类型之类的

```
## 内存管理 ##
```
make & new
- make 为slice、map、channel分配内存并初始化，返回值类型
- new 为任意类型分配内存，返回引用类型

内存分配(TCMalloc)
- page
- mspan
- mcache
- mcentral
- mheap

垃圾回收
标记清除法
- 启动STW
- Mark标记
- 清除垃圾
- 停止STW
升级
- 启动STW
- Mark标记
- 停止STW
- 清除垃圾

三色标记法
- 将所有对象标记为白色
- 从根节点集合出发，将第一次遍历到的节点标记为灰色放入集合列表中
- 遍历灰色集合，将灰色节点遍历到的白色节点标记为灰色，并把灰色节点标记为黑色
- 直到灰色节点集合为空，回收所有的白色节点

屏障机制
强三色不变式  不允许黑色对象引用白色对象
弱三色不变式  黑色对象可以引用白色，白色对象存在其他灰色对象对他的引用，或者他的链路上存在灰色对象
插入屏障  对象被引用时触发的机制，当白色对象被黑色对象引用时，白色对象被标记为灰色
删除屏障  对象被删除时触发的机制，如果灰色对象引用的白色对象被删除时，那么白色对象会被标记为灰色

三色标记+混合写屏障
- GC开始时将栈上可达对象全部标记为黑色
- GC 期间，任何栈上创建的新对象均为黑色
- 被删除引用的对象标记为灰色
- 被添加引用的对象标记为灰色
```
## 并发 ##
```
goroutine
- go func

waitGroup
- wg := &sync.WaitGroup{}
- wg.Add()
- wg.Done()
- wg.Wait()

channel
操作
| 操作 | nil的channel | 正常channel | 已关闭的channel |
| :--: | :--: | :--: | :--: |
| 读 <-ch | 阻塞 | 成功或阻塞 | 读到零值 |
| 写 ch<- | 阻塞 | 成功或阻塞 | panic |
| 关闭 close(ch) | panic | 成功 | panic |
结构
type hchan struct {
    // chan 里元素数量
    qcount   uint
    // chan 底层循环数组的长度
    dataqsiz uint
    // 指向底层循环数组的指针
    // 只针对有缓冲的 channel
    buf      unsafe.Pointer
    // chan 中元素大小
    elemsize uint16
    // chan 是否被关闭的标志
    closed   uint32
    // chan 中元素类型
    elemtype *_type // element type
    // 已发送元素在循环数组中的索引
    sendx    uint   // send index
    // 已接收元素在循环数组中的索引
    recvx    uint   // receive index
    // 等待接收的 goroutine 队列
    recvq    waitq  // list of recv waiters
    // 等待发送的 goroutine 队列
    sendq    waitq  // list of send waiters
    // 保护 hchan 中所有字段
    lock mutex
}

选择
select
监听多个channel

mutex
- 互斥锁  sync.Mutex
- 读写互斥锁  sync.RWMutex

context
作用
并发控制和超时控制
结构
type Context interface {
    // 当 context 被取消或者到了 deadline，返回一个被关闭的 channel
    Done() <-chan struct{}
    // 在 channel Done 关闭后，返回 context 取消原因
    Err() error
    // 返回 context 是否会被取消以及自动取消时间（即 deadline）
    Deadline() (deadline time.Time, ok bool)
    // 获取 key 对应的 value
    Value(key interface{}) interface{}
}
分类
- emptyCtx
- valueCtx
- cancelCtx
- timerCtx

GMP
- G  协程
- M  线程
- P  处理器
```

# 学习资料 #
https://github.com/yongxinz/gopher  
https://www.zhihu.com/people/raoquancheng