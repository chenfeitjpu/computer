**函数**
- [内容](#内容)
  - [使用](#使用)
    - [基本操作](#基本操作)
  - [高阶函数](#高阶函数)
    - [函数类型](#函数类型)
    - [参数函数](#参数函数)
    - [返回值函数](#返回值函数)
    - [匿名函数](#匿名函数)
    - [回调函数](#回调函数)
    - [闭包](#闭包)
    - [延迟函数](#延迟函数)
  - [内置函数](#内置函数)
    - [panic/recover](#panicrecover)

# 内容 #
## 使用 ##
### 基本操作 ###
**声明**  
func funcName(parametername type1, parametername type2) (output1 type1, output2 type2) {
    return value1, value2
}

## 高阶函数 ##
### 函数类型 ### 

### 参数函数 ###

### 返回值函数 ###  

### 匿名函数 ###

### 回调函数 ###  

### 闭包 ###  

### 延迟函数 ###
**实现原理**  
- 多个defer语句，按照先进后出的方式执行
- 延迟函数的参数在defer声明时就决定了
- return流程 return赋值 执行defer return返回

## 内置函数 ##
### panic/recover ###
- recover必须搭配defer使用。
- defer一定要在可能引发panic的语句之前定义
