**切片**  
- [内容](#内容)
  - [使用](#使用)
  - [结构](#结构)

# 内容 #
## 使用 ##

**声明**  
var name []type
name := make([]T, length, capacity)

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