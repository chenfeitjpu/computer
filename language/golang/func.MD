**函数**
- [内容](#内容)
  - [使用](#使用)
  - [延迟函数](#延迟函数)
  - [高阶函数](#高阶函数)

# 内容 #
## 使用 ##
**声明**  
func funcName(parametername type1, parametername type2) (output1 type1, output2 type2) {
    return value1, value2
}


## 延迟函数 ##
**实现原理**  
- 多个defer语句，按照先进后出的方式执行
- 延迟函数的参数在defer声明时就决定了
- return赋值，执行defer，return返回

## 高阶函数 ##
**数据类型**  

**匿名函数**  

**回调函数**  

**封包**  