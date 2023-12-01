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
声明  
- var name []type
- name := make([]type, length, capacity)
切片表达式
a[low : high : max]  
0 <= low <= high <= max <= cap(a)
操作
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
1.17及以前
- 如果新申请容量比两倍原有容量大，那么扩容后容量大小为新申请容量
- 如果原有slice长度小于1024，那么每次就扩容为原来的2倍
- 如果原有slice长度大于等于1024，那么每次扩容就扩为原来的1.25倍  
1.18及以后
- 如果新申请容量比两倍原有容量大，那么扩容后容量大小为新申请容量
- 如果原有slice长度小于256，那么每次就扩容为原来的2倍
- 如果原有slice长度大于等于256，那么每次扩容就扩为原来的1.25 倍+3/4*256    

map
声明  
- var name map[type]type 
- name := make(map[type]type, [cap])  
删除
- delete(map, key)
线程安全
- map+sync.RWMutex
- sync.Map
  - sync.Map适用于读多、更新多、删多、写少的场景  
  - 倘若写操作过多，sync.Map基本等价于互斥锁+map  
  - sync.Map可能存在性能抖动问题

struct
声明
type name struct {  
    name type 
    name type  
}
嵌套结构体
- 匿名结构体

func 
声明  
func name(parameter type, parameter type) ([output] type, [output] type) {
    return value, value
}

defer
- 多个defer语句，按照先进后出的方式执行
- 延迟函数的参数在defer声明时就决定了
- return赋值 执行defer return返回

error&panic&recover

method
声明
func (name type) name(parameter type, parameter type) ([output] type, [output] type) {
    return value, value
}
使用
- object.method()
- 方法变量
- 方法表达式 

interface
声明
type name interface {  
    name(name type) type  
    name(name type) type  
}
使用
对于值接收者实现的接口，无论使用值类型还是指针类型都没有问题
对于指针接收者实现的接口，只能使用指针类型
断言
- 类型转换 i.(T)
- 类型查询 i.(type)

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
- unsafe.Pointer可以和普通指针进行相互转换
- unsafe.Pointer可以和uintptr进行相互转换
- uintptr是用于指针运算的，GC不把uintptr当指针，也就是说uintptr无法持有对象，uintptr类型的目标会被回收

context
作用
协程控制
使用
- Deadline()
- Done()
- Err()
- Value()
分类
- emptyCtx
- valueCtx
- cancelCtx
- timerCtx

reflect
作用 
自描述和自管理
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
- wg.Add(delta)
- wg.Done()
- wg.Wait()

channel
操作
| 操作 | nil的channel | 正常channel | 已关闭的channel |
| :--: | :--: | :--: | :--: |
| 读 <-ch | 阻塞 | 成功或阻塞 | 读到零值 |
| 写 ch<- | 阻塞 | 成功或阻塞 | panic |
| 关闭 close(ch) | panic | 成功 | panic |
选择
select

mutex
- 互斥锁  sync.Mutex
- 读写互斥锁  sync.RWMutex

GMP
- G  协程
- M  线程
- P  处理器
```

# 学习资料 #
https://github.com/yongxinz/gopher