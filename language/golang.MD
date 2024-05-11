**golang**
- [定义](#定义)
- [使用](#使用)
  - [基础语法](#基础语法)
  - [数据结构](#数据结构)
  - [内存管理](#内存管理)
  - [并发控制](#并发控制)
  - [框架和库](#框架和库)
- [学习资料](#学习资料)

# 定义 #
静态、强类型、编译型语言

# 使用 #
## 基础语法 ##
```
优势
- 支持高并发，使用关键字go可以轻松的创建goroutine
- 高效的垃圾回收，GC与程序并发执行

常用命令
- go build  编译包和依赖
- go run  编译和运行程序
- go install  编译和安装包和依赖
- go get  下载和安装包和依赖
- go clean  移除对象文件和缓存文件
- go fmt pkg/...  格式化源码包
- go vet pkg/...  报告代码错误
- go test -v pkg/... -run method  运行测试包

常用包
- fmt  提供了输入输出的格式化功能
  - fmt.Print、fmt.Println、fmt.Printf  标准输出，%v、%+v、%#v、%s、%d、%p
  - fmt.Sprint、fmt.Sprintln、fmt.Sprintf  输出到字符串
  - fmt.Fprint、fmt.Fprintln、fmt.Fprintf  输出到文件
- math  提供了数学函数和常量的功能
- math/rand  提供了随机数生成的功能
- strings  提供了字符串处理的功能
- strconv  提供了基本数据类型与其字符串表示的转换功能
- time  提供了时间和日期的功能
  - time.Now()  获取当前时间
  -	time.Date()  根据日期生成时间
  - time.Unix()  根据时间戳生成时间
  - time.Parse()  根据字符串生时间
  - {time}.Format()  格式化时间
- sort  提供了排序的功能
- net  提供了网络通信的功能
- sync  提供了同步原语的功能，保证并发安全性
- runtime  Go语言的运行时系统，提供了与底层系统交互和控制的功能。它包含了与内存管理、垃圾回收、协程调度等相关的函数和变量
  - runtime.NumGoroutine()  获取当前运行的goroutine数量
  - runtime.GOMAXPROCS(0)  获取当前P的数量
- unsafe  提供了直接操作内存的工作
  - unsafe.SizeOf()  获取变量占用内存大小

变量
- 使用
  - var name [type] [= expression]  
  - var name, name [type] [= expression, expression]  
  - var (  
        name [type] [= expression]  
        name [type] [= expression]  
    )
  - name := value
  - _不会分配内存
- 注意事项
  - 变量类型转换时允许溢出

常量
常量数据类型只能是数值型(整数型、浮点型和复数)、字符串型、布尔型  
- 使用
  - const name [type] = expression
  - const name [type], [type] = expression, expression
  - const (  
        name [type] = expression  
        name [type] = expression    
    )
    常量定义与前一行的定义一致，则可以省略类型和值
  - iota    
- 注意事项
  - 无类型常量可通过字面量转换为对应类型的变量
  - 不能取址
  - 常量类型转换时不允许溢出

数据类型
- 分类
  - uint8、uint16、uint32、uint64、uint、int8、int16、int32、int64、int
  - float32、float64 
  - complex64、complex128
  - bool
  - byte、rune
  - string
  - array、slice、map、channel 
  - struct、func、interface 
  - pointer、uintptr
- 引用类型 
  slice、map、channel、func、interface、pointer
- 类型比较
  - 不同类型不能比较
  - 不可比较类型不能比较  slice、map、function，但可以与nil进行比较
  - 接口比较，一个接口覆盖另一个接口的所有方法，且实际类型不是同一种不可比较类型
- 线程安全的类型
  channel、sync.Map

运算符
- 算术运算符  +、-、*、/、%、++、--
- 关系运算符  >、>=、<、<=、==、!= 
- 逻辑运算符  &&、||、!
- 位运算符  &、|、^、&^、<<、>>

流程控制 
- 选择
  - if else if else
  - switch case default fallthrough
- 循环
  - for index continue break
  - for range continue break
- 跳转
  - goto 只能在函数内跳转，需要配合标签一起使用，不能跳过内部变量声明语句，只能跳到同级作用域或者上层作用域内，不能跳到内部作用域内
```

## 数据结构 ##
```
string 
- 运行时结构
  type StringHeader struct {
      Data uintptr
      Len  int
  }
- 注意事项
  - string对应的底层字节数组不能修改
  - 转换成[]byte会发生内存拷贝，不发生拷贝*(*[]byte)(unsafe.Pointer(&a))
  - 高效拼接
    - strings.Builder String()时不会另外申请内存
    - bytes.Buffer  String()时会另外申请内存

array
固定长度集合
- 使用
  - [size]T{}、[...]T{}、[...][size]T
  - for index、for range 
- 注意事项
  - 多维数组只有第一层可以使用[...]来让编译器推导数组长度
  - 数组是值类型，赋值和传参会复制整个数组

slice
动态长度集合
- 使用
  - []T{}、make([]T, len[, cap])
  - append、copy
  - a[low:high:max]  0 <= low <= high <= max <= cap(a)，high默认是len(a)
  - for index、for range在循环开始前会获取切片的长度，然后再执行len(切片)次数的循环  
- 结构
  type slice struct {
      array unsafe.Pointer
      len   int
      cap   int
  }
  slice占用24个字节  
  - array  指向底层数组的指针，占用8个字节  
  - len  切片的长度，占用8个字节  
  - cap  切片的容量，cap总是大于等于len的，占用8个字节  
- 扩容
  - 1.18以前
    - 如果新申请容量比两倍原有容量大，那么扩容后容量大小为新申请容量
    - 如果原有slice长度小于1024，那么就扩容为原来的2倍
    - 如果原有slice长度大于等于1024，那么每次扩容就扩为原来的1.25倍，直到新容量大于期望容量
    - 内存对齐(size_to_class&class_to_size)  CPU以字长访问内存，如果不进行内存对齐，很可能增加CPU访问内存的次数
  - 1.18及以后
    - 如果新申请容量比两倍原有容量大，那么扩容后容量大小为新申请容量
    - 如果原有slice长度小于256，那么就扩容为原来的2倍
    - 如果原有slice长度大于等于256，那么每次扩容就扩为原来的1.25倍+3/4*256，直到新容量大于期望容量
    - 内存对齐(size_to_class&class_to_size)  CPU以字长访问内存，如果不进行内存对齐，很可能增加CPU访问内存的次数
- 注意事项
  - 扩容前后的slice是否相同，原数组还有容量可以扩容则相同，原数组容量不够则不同
  - nil切片引用数组指针地址为0(无指向任何实际地址)，空切片引用数组指针地址是有的，且固定为一个值
  - 拷贝大切片跟小切片的代价是一样的

map
一种无序的键值对集合，也称为字典。map中的键必须是唯一的，而值可以重复。map提供了快速的查找和插入操作，适用于需要根据键快速检索值的场景
- 使用 
  - map[T]T、make(map[T]T[, cap])  
  - delete(map, key)
- 特点
  - 无序
    - 添加时无序
    - 扩容时发生key的搬迁
    - 读取时从一个随机序号的bucket开始遍历，并且是从这个bucket的一个随机序号的cell开始遍历
  - 有序实现
    创建切片保存键值，进行排序，然后遍历切片
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
- 定位
  - 查找
  - 计算key的hash值
  - 通过最后的B位来确定桶号
  - 根据key对应的hash值前8位快速确定是在这个桶的哪个位置
  - 对比key是否匹配
  - 如果都没有找到，就去连接的下一个溢出桶中找
- 扩容
  - 条件
    - 等量扩容(桶中空位过多)
      - 当B<15 时，overflow的bucket数量超过2^B
      - 当B>=15 时，overflow的bucket数量超过2^15
    - 双倍扩容(桶不够用了)
      - 装载因子>6.5
        装载因子=count/(2^B) map中元素的个数/map中当前桶的个数
  - 操作
    - minTopHash
      当一个cell的tophash值小于minTopHash时，标志这个cell的迁移状态
      - 0  空的cell，也是初始时bucket的状态
      - 1  cell已经搬迁完毕，空cell
      - 2  cell已经搬迁完毕，key在新bucket前半部分
      - 3  cell已经搬迁完毕，key在新bucket后半部分
    - 新增|修改
      定位到了某个bucket后，直接触发一次搬迁操作
    - 删除  
      定位到了某个bucket后，直接触发一次搬迁操作
    - 遍历
      定位到某个bucket后，通过新桶找旧桶，旧桶已经迁移，直接遍历新桶，旧桶没有迁移，遍历旧桶中会分到新桶中的元素
- 操作
  - 新增|修改
    查找key，进行修改或者新增
  - 删除  
    查找key，对key和value进行清空
  - 遍历
    遍历所有的bucket以及它后面挂的overflow bucket，遍历bucket中的所有cell  
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
  type entry struct {
      p unsafe.Pointer // *interface{}
  }
  - p的值
    - 当p == nil时，说明这个键值对已被删除，并且m.dirty == nil，或m.dirty[k]指向该entry
    - 当p == expunged时，说明这条键值对已被删除，并且m.dirty != nil，且m.dirty中没有这个key
    - 正常值
- 实现
  sync.Map设置了两个map(read map和dirty map)，read map并发读，dirty map并发读写，两个map的key指向同一个entry，通过CAS原子操作更新entry
  - 写入
    - 如果在read里能够找到待存储的key，并且对应的entry的值不为expunged，也就是没被删除时，直接更新对应的entry即可
    - 第一步没有成功，要么read中没有这个key，要么key被标记为删除。则先加锁，再进行后续的操作
    - 再次在read中查找是否存在这个key，也就是double check一下，这也是lock-free编程里的常见套路。如果read中存在该key，但p == expunged，说明m.dirty != nil并且m.dirty中不存在该key值，dirty map插入key，直接更新对应的value
    - 如果read中没有此key，那就查看dirty中是否有此key，如果有，则直接更新对应的value，这时read中还是没有此key
    - 最后一步，如果read和dirty中都不存在该key，如果dirty为空，则需要创建dirty，并从read中拷贝未被删除的元素，更新amended字段，标识dirty map中存在read map中没有的key，将k-v写入dirty map中
  - 删除
    - 先从read里查是否有这个key，如果有则执行entry.delete方法，将p置为nil，这样read和dirty都能看到这个变化
    - 如果没在read中找到这个key，并且dirty不为空，那么就要操作dirty了，操作之前，还是要先上锁。然后进行double check，如果仍然没有在read里找到此key，则从dirty中直接删掉这个key。
    - read中没有这个key，且amended为fase，说明dirty为空，那直接返回空和false
  - 读取
    - 直接在read中找，如果找到了直接调用entry的load方法，取出其中的值
    - 如果read中没有这个key，且amended为true，说明dirty中可能存在我们要找的key。当然要先上锁，再尝试去dirty中查找。在这之前，仍
      然有一个double check的操作。若还是没有在read中找到，那么就从dirty中找。不管dirty中有没有找到，都要"记一笔"，因为在dirty被提升为read之前，都会进入这条路径，直接将misses的值加1，表示一次未命中，如果misses值小于m.dirty 的长度，就直接返回。否则将m.dirty晋升为read，并清空dirty，清空misses计数值
    - read中没有这个key，且amended为fase，说明dirty为空，那直接返回空和false
  - 遍历
    - 当amended为true时，说明dirty中含有read中没有的key，将dirty提升为read
    - 遍历read，取出entry 中的值，调用f(k, v)      

struct
用于定义一组属性
- 使用
  type name struct {  
      name type 
      name type  
  }
  - tag  丰富语义
    - 转json  小写字段不能转，大写字段加了tag取别名，不加tag则json内的字段跟结构体字段原名一致
- 扩展
  - 嵌套结构体
  - 匿名结构体
  - 空结构体  不占内存，占位使用

func  
用户定义一组操作
- 使用
  func name(parameter type, parameter type) ([output] type, [output] type) {
      return value, value
  }
  - 返回值要么同时命名，要么不命名
- 闭包  函数及其相关引用环境的组合体  
- defer  延迟函数的执行，在函数退出前执行相应操作。defer通常用于解锁、关闭文件，释放资源等清理操作
  - 示例
    file, err := os.Open("test.txt")
	if err != nil {
		return
	}
	defer func() {
		err := file.Close()
		if err != nil {
			return
		}
	}()   
  - 注意事项
    - 参数在defer声明时就决定了
    - 多个defer语句，按照先进后出的方式执行
    - return赋值->执行defer->return返回
- init  
  import->const->var->init->main
  - 一个包里可以包含多个init函数
  - 程序运⾏时，先执⾏依赖包的init函数，再执⾏当前包内的init函数
  - init函数不可以被其他函数调⽤

method
- 使用
  func (name type) name(parameter type, parameter type) ([output] type, [output] type) {
      return value, value
  }
  - object.method()
- 注意事项
  - 对于不可寻址的类型T，不能调用*T的方法
  - 方法接受者不能是接口，或者本身就是指针类型

interface
用于定义一组方法
- 使用
  type name interface {  
      name(name type) type  
      name(name type) type  
  }
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
- 类型断言
  - i.(T)
  - i.(type)
- 注意事项
  - 对于T类型的接口，可以使用T类型的方法
  - 对于*T类型的接口，可以使用T和*T类型的方法

pointer
指针是一种变量，存储了另一个变量的内存地址。通过指针，我们可以直接访问和修改变量的值，而不是对变量进行拷贝
- 使用
  - &取址
    - 不可寻址的类型
      - 字面量
      - 常量
      - 字符串对应的字节数组
      - map对象中的元素
  - *取值
- 分类 
  - 普通指针  *T
  - 通用指针  unsafe.Pointer
  - 指针地址  uintptr
- 示例
  func swap(a, b *int) {
      *a, *b = *b, *a
  }
  func main() {
      x, y := 10, 20
      swap(&x, &y)
      fmt.Println(x, y)
  }
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

error&panic&recover
- error
- panic & recover
  当程序遇到无法处理的错误时，可以使用panic引发一个异常，中断程序的正常执行  
  recover用于捕获并处理panic引发的异常，使程序能够继续执行
  - 示例
    func divide(a, b int) int {
        defer func() {
            if err := recover(); err != nil {
                fmt.Println("Error: ", err)
            }
        }()
        if b == 0 {
            panic("division by zero")
        }
        return a / b
    }
  - 注意事项
    - 子协程的panic会导致主协程退出
    - 子协程的panic主协程无法捕获
  - 无法捕获panic的情况
    - defer需要在函数里直接调用recover
    - panic的信息为nil时无法捕获
    - 不同goroutine间无法捕获
```

## 内存管理 ##
```
make & new
- make  为slice、map、channel分配内存并初始化为非零值，返回值
- new  为任意类型分配内存并初始化为零值，返回指针

逃逸分析
在函数中分配的对象，由于其生命周期需要延长，导致编译器将其分配到堆区而不是栈区
- 场景
  - 指针被作用域之外所引用
  - 变量类型不确定(如接口)
  - 变量大小不确定(如slice长度或容量不定)
  - 变量较大(栈空间不足)

内存分配
- 核心思想(TCMalloc)  把内存分为多级管理，从而降低锁的粒度  
  - mheap  全局的内存起源，访问要加全局锁
  - mcentral  每种对象大小规格(全局共划分为68种)对应的缓存，锁的粒度也仅限于同一种规格以内
  - mcache  每个P(正是GMP中的P)持有一份的内存缓存，访问时无锁
- 内存划分
  - arena  512G 把内存分割成8KB大小的页
  - bitmap  16G  标识arena区域哪些地址保存了对象 一个byte大小的内存对应arena区域中4个指针大小(指针大小为8B)的内存
  - spans  512M  存放mspan指针，每个指针对应一页
- 内存管理组件
  - mspan  由一片连续的8KB的页组成的大块内存
  - mcache  每个工作线程都会绑定一个mcache，缓存可用的mspan资源，包含68*2个mspan
  - mcentral  为所有mcache提供mspan资源  
  - mheap  当mcentral没有空闲的mspan时，会向mheap申请, mheap没有资源时，会向操作系统申请新内存, mheap主要用于大对象的内存分配，以及管理未切割的mspan，用于给mcentral切割成小对象，包含68*2个mcentral
- 分配条件
  - 字面量
  - make(T)
  - new(T)
- 分配流程  
  - >32KB的对象  直接从mheap上分配  
  - <=16B的对象(不含指针)  使用mcache的tiny分配器分配  
  - (16B,32KB]的对象
    - 首先计算对象的规格大小，然后使用mcache中相应规格大小的mspan分配
    - 如果mcache没有相应规格大小的mspan，则向mcentral申请
    - 如果mcentral没有相应规格大小的mspan，则向mheap申请
    - 如果mheap中也没有合适大小的mspan，则向操作系统申请

垃圾回收
- 作用
  Go语言中的垃圾回收器是自动管理内存的机制，用于回收不再使用的内存。垃圾回收器会自动检测不再使用的对象，并释放其占用的内存空间。
- 示例
  func createObject() {
      for i := 0; i < 1000000; i++ {
          _ = make([]byte, 1024)
      }
  }
  func main() {
      go createObject()
      time.Sleep(1 * time.Second)
      var stats runtime.MemStats
      runtime.ReadMemStats(&stats)
      fmt.Println("alloc memory ", stats.Alloc)
  }
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

- 版本迭代
  - 1.3之前
    标记-清扫(全程需要STW)
    - 流程
      - 启动STW
      - 标记
        - 标记可达对象
        - 标记垃圾对象
      - 清扫
      - 停止STW
    - 缺点
      - STW程序会出现卡顿
      - 清除数据会产生碎片
  - 1.3之后
    标记-清扫(标记过程需要STW)
    - 流程
      - 启动STW
      - 标记
        - 标记可达对象
        - 标记垃圾对象
      - 停止STW
      - 清扫
    - 缺点
      - STW程序会出现卡顿
      - 清除数据会产生碎片
  - 1.5之后
    三色标记法+插入写屏障
    - 概念  
      - 对象分为三种颜色标记  黑、灰、白
      - 白对象代表，对象尙未被标记到，或者是垃圾对象
      - 灰对象代表，对象自身存活，但其指向对象还未标记完成
      - 黑对象代表，对象自身存活，且其指向对象都已标记完成
    - 流程
      - 所有对象放入白色集合(需要STW)
      - 从GC Root对象出发，扫描所有可达对象并标记为灰色
      - 从队列取出一个灰色对象并标记为黑色，将其引用对象标记为灰色放入队列
      - 重复上一步骤，直到灰色对象队列为空
      - 此时所有剩下的白色对象就是垃圾对象 
    - 并发问题
      用户协程运行时可能对对象间的引用关系进行调整，这会严重打乱GC三色标记时的标记秩序
      - 漏标
        - 产生条件
          - 灰、白对象删除了白色对象
          - 黑色对象指向了白色对象
        - 解决
          - 强三色不变式
            白色对象不能被黑色对象直接引用 
            - 实现
              - 插入写屏障
                保证当一个黑色对象指向一个白色对象前，会先触发屏障将白色对象置为灰色  
                - 栈上对象处理
                  STW扫描栈上对象，重新三色标记
          - 弱三色不变式
            白色对象可以被黑色对象引用，但要从某个灰对象出发仍然可达该白对象  
            - 实现  
              - 删除写屏障
                当一个白色对象即将被上游删除引用前，会触发屏障将其置灰，之后再删除上游指向其的引用
                - 栈上对象处理
                  STW扫描整个栈，保证所有堆上在用的对象都处于灰色保护下
      - 错标
        - 产生条件
          - 黑色对象删除了灰色对象
          - 灰色对象是垃圾对象
  - 1.8之后
    三色标记+混合写屏障
    - GC开始时栈上的对象并标记为黑色(逐个暂停，逐个扫描，每个栈单独扫描, 无需STW整个程序)
    - GC期间，栈上创建的新对象标记为黑色
    - 堆对象正常启用插入写屏障
    - 堆对象正常启用删除写屏障
    - 回收未标记对象
- 触发时机
  - 定期触发，默认每隔两分钟触发一次GC
  - 新建对象，检测内存分配如果到达阀值触发GC
  - 手动触发，runtime.GC()
- 注意事项
  - 小对象多了会造成GC压力  小对象过多会导致GC消耗过多的CPU
```

## 并发控制 ##
```
并发安全性
- 概念
  多个goroutine对共享资源的访问不会导致数据竞争
- 实现
  - Mutex & RWMutex
  - automic
  - channel

组件
- goroutine
  go语言的并发执行单元，可以同时执行多个goroutine，而不需要显式地管理线程的生命周期
  - 使用
    func test() {
        fmt.Println("hello test")
    }
    func main() {
        go test()
        fmt.Println("hello main")
        time.Sleep(time.Second)
    }

- 锁  并发编程中一种同步机制，用于保护共享资源的访问
  - 互斥锁(sync.Mutex)  同一时刻只能有一个线程持有锁
    - 示例
      var (
          counter int
          mu      sync.Mutex
      )
      func increment() {
          defer mu.Unlock()
          mu.Lock()
          counter++
      }
      func main() {
          wg := &sync.WaitGroup{}
          for i := 0; i < 1000; i++ {
              wg.Add(1)
              go func() {
                  defer wg.Done()
                  increment()
              }()
          }
          wg.Wait()
          fmt.Println(counter)
      }
    - 获取锁失败
      首先采用自旋+CAS的策略争夺锁，尝试持续受挫达到一定条件后，判定当前过于激烈，则由自旋转为阻塞模式
      自旋模式转为阻塞模式的具体条件
      - CPU单核或仅有单个P调度器(此时自旋，其他goroutine根本没机会释放锁，自旋纯属空转)
      - 当前P的执行队列中仍有待执行的G(避免因自旋影响到GMP调度效率)
      - 自旋累计达到4次仍未取得锁
    - 唤醒
      - 正常模式(性能较好)
        当有goroutine从阻塞队列被唤醒时，会和此时先进入抢锁流程的goroutine进行锁资源的争夺，假如抢锁失败，会重新回到阻塞队列头部.
        此时被唤醒的老goroutine相比新goroutine是处于劣势地位，因为新goroutine已经在占用CPU时间片，且新goroutine可能存在多个，从而形成多对一的人数优势，因此形势对老goroutine不利
        当阻塞队列存在goroutine等锁超过1ms而不得，则进入饥饿模式
      - 饥饿模式(严格公平)
        锁的所有权按照阻塞队列的顺序进行依次传递，新goroutine进行流程时不得抢锁，而是进入队列尾部排队
        当阻塞队列已清空，或取得锁的goroutine等锁时间已低于1ms时，则回到正常模式
    - 结构
      type Mutex struct {
          state int32
          sema  uint32
      }
      - state
        - 最右侧的一个bit位，标志是否上锁，0:未上锁，1:已上锁
        - 最右数第二个bit位，标志是否有goroutine从阻塞中被唤醒，0:没有，1:有
        - 最右数第三个bit位，标志Mutex是否处于饥饿模式，0:非饥饿，1:饥饿
        - 剩余的29位，记录当前阻塞队列goroutine的数量
  - 读写锁(sync.RWMutex)  同一时刻只能有一个线程持有写锁，或者多个线程持有读锁
    - 示例
      rmu := sync.RWMutex{}
	  defer rmu.RUnlock()
	  rmu.RLock()
    - 结构
      type RWMutex struct {
          w           Mutex        // held if there are pending writers
          writerSem   uint32       // semaphore for writers to wait for completing readers
          readerSem   uint32       // semaphore for readers to wait for completing writers
          readerCount atomic.Int32 // number of pending readers
          readerWait  atomic.Int32 // number of departing readers
      }

- atomic  并发编程中的一种同步机制，保证单个指令操作的原子性
  - 使用
  	- atomic.StoreInt64()
	- atomic.LoadInt64()
	- atomic.AddInt64()
	- atomic.SwapInt64()
	- atomic.CompareAndSwapInt64()
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

- channel  用于在goroutine之间进行通信和同步的机制
  - 使用
    - 只读通道  <- ch
    - 只写通道  ch <-
    - 双向通道  ch
  - 示例
    func fibonacci(n int, ch chan int) {
        x, y := 0, 1
        for i := 0; i < n; i++ {
            ch <- x
            x, y = y, x+y
        }
        close(ch)
    }
    func main() {
        ch := make(chan int)
        go fibonacci(10, ch)
        for num := range ch {
            fmt.Println(num)
        }
    }
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
    - buf  指向一个环形数组，用来实现循环队列
    - sendx  循环队列的队尾指针
    - recvx  循环队列的队头指针
    - recvq  等待从通道中接收数据的goroutine  双向链表
    - sendq  等待发送数据到通道的goroutine  双向链表
  - 操作
    - 发送
      - 空通道，阻塞
      - 加锁
      - 已关闭通道，直接panic
      - recvq不为空，移出第一个协程接收数据
      - 循环队列未满，数据添加到buf中
      - 当前队列阻塞，并放入sendq中
    - 读取
      - 空通道，阻塞
      - 加锁
      - 通道关闭且缓冲为空，返回空值
      - 发送队列不为空，发送者出队，通道是非缓冲类型通道，直接将发送者数据传送给接收者
      - 发送队列不为空，发送者出队，通道是缓冲类型通道，从循环队列取出一条数据，将发送者数据传递至循环队列
      - 通道缓冲有数据，从buf中取出值
      - 通道缓冲无数据，当前协程阻塞，并放入recvq中
    - 关闭
      - 空通道，直接panic
      - 加锁
      - 已关闭通道，直接panic
      - 唤醒接收者队列中所有接受者
      - 唤醒发送者队列中所有发送者
    |      操作      | nil的channel | 正常channel | 已关闭的channel |
    | :------------: | :----------: | :---------: | :-------------: |
    |    读 <-ch     |     阻塞     | 成功或阻塞  |    读到零值     |
    |    写 ch<-     |     阻塞     | 成功或阻塞  |      panic      |
    | 关闭 close(ch) |    panic     |    成功     |      panic      |

  - 注意事项
    - 优雅关闭channel
      - defer + recover
      - sync.Once
      - channel
        - 一个发送者，一个接收者，发送者关闭
        - 一个发送者，多个接收者，发送者关闭
        - 多个发送者，一个接收者，接收者关闭，发送者进行关闭通道的监控
        - 多个发送者，多个接收者，发送者和接收者把关闭请求发送给中间人，中间人进行关闭，发送者和接收者进行关闭通道的监控

- select  同时监听多个通道的读写操作，并在其中任意一个通道就绪时执行相应的操作
  - 示例
    func main() {
        ch1 := make(chan int)
        ch2 := make(chan int)
        go func() {
            ch1 <- 10
        }()
        go func() {
            ch2 <- 20
        }()
        select {
        case num := <-ch1:
            fmt.Println("receive from ch1 ", num)
        case num := <-ch2:
            fmt.Println("receive from ch2", num)
        }
    } 
  - 注意事项 
    - 通道关闭
      如果其中一个case通道已经关闭，则每次都会执行到这个case  
      如果select里边只有一个case，而这个case被关闭了，则会出现死循环  
    - 不读关闭后通道
      将关闭通道置为nil

- context  用于在单个请求下多个goroutine之间同步数据、取消信号、超时控制
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

- WaitGroup  同步等待组
  - 使用
    wg := sync.WaitGroup{}
    wg.Add()
    wg.Done()
    wg.Wait()

- sync.Cond  通常应用于等待某个条件的一组goroutine，当条件变为true的时候，其中一个goroutine或者所有的goroutine都会被唤醒执行
  - 使用
     - cond := sync.NewCond()  初始化
     - cond.Wait()  放入Cond的等待队列中并阻塞
     - cond.Singal()  唤醒一个等待此Cond的goroutine
     - cond.BroadCast()  唤醒所有等待此Cond的goroutine
  - 示例
    func main() {
        cond := sync.NewCond(&sync.Mutex{})
        var ready int
        for i := 0; i < 10; i++ {
            go func(i int) {
                time.Sleep(time.Duration(rand.Intn(10)) * time.Second)
                cond.L.Lock()
                ready++
                cond.L.Unlock()
                log.Printf("运动员%d就位", i)
                cond.Broadcast()
            }(i)
        }
        cond.L.Lock()
        for ready != 10 {
            cond.Wait()
            log.Println("裁判员收到")
        }
        cond.L.Unlock()
        log.Println("所有运动员全部就绪")
    }

- sync.Once  函数只执行一次
  - 使用
    - once := &sync.Once{}
    - once.Do(f func())
  - 示例
    func main() {
        once := &sync.Once{}
        for i := 0; i < 10; i++ {
            once.Do(func() {
                fmt.Println("hello, world")
            })
        }
    }
  - 结构
    type Once struct {
        done uint32
        m    Mutex
    } 
  - 注意事项
    - 高频使用的字段放在第一个，不用计算偏移量
    - 原子操作可以保证其它goroutine及时观察到的done值的变化

- Pool  对象缓冲池
  - 使用
    - New
    - Get
    - Put
  - 示例

- 自旋
  - 概念
    线程在等待某个条件满足时，不会进入阻塞状态，而是通过不断地检查条件是否满足来进行忙等待
    可以减少线程切换的开销，但会导致CPU资源的浪费

GMP
go语言的调度模型，把大量的goroutine分配到少量线程上去执行
- 概念
  - G  goroutine协程
  - P  processor处理器
  - M  thread线程
- 初始化
  - 进程启动，会新建M0和G0，并且互相绑定
  - 初始化p数组，P的个数和系统的CPU核数一致，把数组中第一个P和M0绑定
  - 把runtime.main函数作为groutine的执行函数，新建一个G，这个G会放到M0绑定的P的可执行队列上
- 调度
  - 全局队列  
    - 存放等待运行的G  
  - 本地队列  
    - 存放等待运行的G
    - 数量有限，不超过256个
    - 新创建的G优先放在P的本地队列中，如果队列满了，会把本地队列中一半的G移动到全局队列，在创建G时，如果没有自旋的M且有空闲的P，则唤醒M或新建M
  - P列表  
    - 程序启动时创建，有GOMAXPROCS个
    - 手动设置
      - 环境变量GOMAXPROCS
      - 在程序中通过runtime.GOMAXPROCS来设置
  - M 
    - 线程想运行G就得获取P，从P的本地队列获取G，P队列为空时，M也会尝试从全局队列拿一批G放到P的本地队列，或从其他P的本地队列偷一半放到自己P的本地队列。M运行G，G执行之后，M会从P获取下一个G，不断重复下去  
    - 数量限制
      - go语言本身的限制M的最大数量10000.
      - runtime/debug中的SetMaxThreads来设置
    - M执行完所有G，会进入自旋状态，系统中最多有忙碌P/2个自旋的线程，多余的线程会让它们休眠，长时间休眠等待GC回收销毁
- 策略  
  - work stealing
    当线程无可运行的G时，尝试从全局队列或者其他线程绑定的P偷取G，而不是销毁线程
  - hand off机制
    - M执行G发生了系统调用，M和P立即解绑，如果P本地队列有G，全局队列有G，P会绑定M，否则P则会加入到空闲列表
    - 当M系统调用结束时候，这个G会尝试获取一个空闲的P执行，并放入到这个P的本地队列。如果获取不到P，那么这个线程M变成休眠状态，加入到
      空闲线程中，然后这个G会被放入全局队列中

内存泄漏
- 原因
  - 读写nil通道
  - 遍历未关闭通道
  - 读写不同步
  - 资源无法释放  加锁/解锁未同步、网络访问超时、写入大文件、数据库读写产生死锁  
- 检测
  - goleak
    - defer goleak.VerifyNone(t)  单个测试用例集成
    - func TestMain(m *testing.M) {  单个测试包集成，一个包里面只能有一个TestMain方法
          goleak.VerifyTestMain(m)
      }
- 解决
  - 使用带超时的操作，比如select语句配合time.After
  - 使用context包来传递取消信号
  - 使用sync.WaitGroup等待所有的协程完成

数据竞争
- 检测
  - go build -race  在编译的时候检测DATA RACE
  - go run -race  在运行的时候检测DATA RACE
  - go test -race  在测试的时候检测DATA RACE
  - go install -race  在安装的时候检测DATA RACE
```

## 框架和库  ##
```
gin
beego
```

# 学习资料 #
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
内存管理  
[图解Go语言内存分配](https://juejin.cn/post/6844903795739082760)  
[Golang内存模型与分配机制](https://zhuanlan.zhihu.com/p/603335718)  
[1.9 我要在栈上。不，你应该在堆上](https://eddycjy.gitbook.io/golang/di-1-ke-za-tan/stack-heap)  
垃圾回收  
[Golang 垃圾回收原理分析](https://zhuanlan.zhihu.com/p/605315127)  
[golang 垃圾回收（五）混合写屏障](https://liqingqiya.github.io/golang/gc/%E5%9E%83%E5%9C%BE%E5%9B%9E%E6%94%B6/%E5%86%99%E5%B1%8F%E9%9A%9C/2020/07/24/gc5.html)  
并发  
[Go 语言如何进行竞态分析](https://liqiang.io/post/how-golang-detect-data-race)  
[goroutine 泄漏与检测](https://dbwu.tech/posts/golang_goroutine_leak/)  
sync.Once  
[通过 sync.Once 学习到 Go 的内存模型](https://studygolang.com/articles/25299)  
sync.Mutex  
[Golang 单机锁实现原理](https://zhuanlan.zhihu.com/p/599119674)