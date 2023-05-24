**GOLANG**
- [使用](#使用)
  - [特点](#特点)
  - [开发](#开发)
  - [语法](#语法)
    - [标识符](#标识符)
    - [变量](#变量)
    - [常量](#常量)
    - [数据类型](#数据类型)
    - [运算符](#运算符)
    - [流程控制](#流程控制)
    - [输入和输入](#输入和输入)


# 使用 #
## 特点 ##
- 高并发
  - 原生支持并发
- 高性能
  - 编译型语言
- 简单易学
  - 语法简单
  - 风格统一

## 开发 ##
**下载**

**配置**
export GOROOT=/usr/local/go  
export PATH=$PATH:$GOROOT/bin

**IDE**
visual studio  
goland

## 语法 ##
### 标识符 ###
标识符由字母数字和_(下划线)组成，并且只能以字母和_开头  

**关键字**  
break        default      func         interface    select  
case         defer        go           map          struct  
chan         else         goto         package      switch  
const        fallthrough  if           range        type  
continue     for          import       return       var  

**保留字**  
Constants:    true  false  iota  nil  
Types:    int  int8  int16  int32  int64   
          uint  uint8  uint16  uint32  uint64  uintptr  
          float32  float64  complex128  complex64  
          bool  byte  rune  string  error  
Functions:    make  len  cap  new  append  copy  close  delete  
              complex  real  imag  
              panic  recover  

### 变量 ###
**声明**  
var name [type] = value  
var name, name [type] = value, value  
var (  
    name1 type1  
    name2 type2  
)

**类型推导**  
根据等号右边的值来推导变量的类型完成初始化

**短变量声明**  
name := value

**匿名变量**  
_ 不会分配内存

### 常量 ###
**声明**  
常量数据类型只能是布尔型、数字型（整数型、浮点型和复数）和字符串型  
- const name [type] = value
- const (  
    name1 = value1  
    name2 = value2  
  )  

const同时声明多个常量时，如果省略了值则表示和上面一行的值相同  

**iota**    

### 数据类型 ###
- bool
- uint8 uint16 uint32 uint64 byte uint uintptr int8 int16 int32 int64 int rune
- float32 float64 complex64 complex128
- string
- array slice map channel struct interface func pointer

### 运算符 ###
- 算术运算符 + - * / % ++ --
- 关系运算符 == != > < >= <=
- 逻辑运算符 && || !
- 位运算符 & | ^  << >>
- 赋值运算符 =

### 流程控制 ###
- if else if else
- switch case fallthrough
- for range 
- break continue
- goto

### 输入和输入 ###
- print printf println
- scan scanf scanln

**占位符**  
格式化打印占位符：
- %v 原样输出
- %T 打印类型
- %t bool类型
- %s 字符串
- %f 浮点
- %d 10进制的整数
- %b 2进制的整数
- %o 8进制
- %x 16进制 0-9，a-f
- %X 16进制 0-9，A-F
- %c，打印字符
- %p，打印地址

