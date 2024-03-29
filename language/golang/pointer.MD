**指针**
- [内容](#内容)
  - [使用](#使用)
  - [分类](#分类)
    - [普通指针](#普通指针)
    - [通用指针](#通用指针)
    - [指针地址](#指针地址)
  - [比较](#比较)
  - [示例](#示例)
  - [make\&new](#makenew)

# 内容 #
## 使用 ##
& 取地址
* 取值

## 分类 ##
### 普通指针 ###
*T
 
### 通用指针 ###
unsafe.Pointer

### 指针地址 ###
uintptr

## 比较 ##
- unsafe.Pointer只是单纯的通用指针类型，用于转换不同类型指针，它不可以参与指针运算
- uintptr是用于指针运算的，GC不把uintptr当指针，也就是说uintptr无法持有对象，uintptr类型的目标会被回收
- unsafe.Pointer可以和普通指针进行相互转换
- unsafe.Pointer可以和uintptr进行相互转换

## 示例 ##
```
type W struct {
	b int32
	c int64
}

func main() {
	w := new(W)
	fmt.Println(w.b, w.c) // 0, 0
	b := unsafe.Pointer(uintptr(unsafe.Pointer(w)) + unsafe.Offsetof(w.b))
	*((*int32)(b)) = 10
	fmt.Println(w.b, w.c) //10, 0
}
```

## make&new ##
- 二者都是用来做内存分配的
- make只用于slice、map以及channel的初始化，返回的还是这三个引用类型本身
- 而new用于类型的内存分配，并且内存对应的值为类型零值，返回的是指向类型的指针