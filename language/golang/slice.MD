**切片**  
- [内容](#内容)
  - [使用](#使用)
  - [结构](#结构)
  - [特性](#特性)
  - [扩容](#扩容)

# 内容 #
## 使用 ##
**声明**  
var name []type = []type{}
name := make([]T, length, capacity)

**切片表达式**
a[low : high : max]  
0 <= low <= high <= max <= cap(a)

**添加**
- append
- copy

## 结构 ##
```
type slice struct {
    array unsafe.Pointer
    len   int
    cap   int
}
```
slice占用24个字节  
array 指向底层数组的指针，占用8个字节  
len 切片的长度，占用8个字节  
cap 切片的容量，cap 总是大于等于 len 的，占用8个字节  

## 特性 ##
**非线程安全**  

## 扩容 ##
**1.17及以前**
- 如果新申请容量比两倍原有容量大，那么扩容后容量大小 为 新申请容量
- 如果原有 slice 长度小于 1024， 那么每次就扩容为原来的 2 倍
- 如果原 slice 长度大于等于 1024， 那么每次扩容就扩为原来的 1.25 倍  
字节对齐  

**1.18及以后**  
- 如果新申请容量比两倍原有容量大，那么扩容后容量大小 为 新申请容量
- 如果原有 slice 长度小于 256 那么每次就扩容为原来的 2 倍
- 如果原 slice 长度大于等于 256 那么每次扩容就扩为原来的 1.25 倍 + 3/4 * 256  
字节对齐  
