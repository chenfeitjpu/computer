**GOLANG**
- [内容](#内容)
  - [语法](#语法)
    - [变量](#变量)
    - [常量](#常量)
    - [数据类型](#数据类型)
    - [运算符](#运算符)
    - [输入和输入](#输入和输入)
    - [流程控制](#流程控制)


# 内容 #
## 语法 ##
### 变量 ###
- var name [type] = value
- name := value 只能声明局部变量
- var (  
    name1 type1  
    name2 type2  
  )  

### 常量 ###
常量数据类型只能是布尔型、数字型（整数型、浮点型和复数）和字符串型  
- const name [type] = value
- const (  
    name1 = value1  
    name2 = value2  
  )  
- iota  

### 数据类型 ###
- bool
- uint8 uint16 uint32 uint64 uint uintptr int8 int16 int32 int64 int byte rune
- float32 float64 complex64 complex128
- string
- array slice map channel struct interface func pointer

### 运算符 ###
- 算术运算符 + - * / % ++ --
- 关系运算符 == != > < >= <=
- 逻辑运算符 && || !
- 位运算符 & | ^ &^ << >>
- 赋值运算符 =

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

### 流程控制 ###
- if else if else
- switch case fallthrough .(type)
- for range break continue
- goto