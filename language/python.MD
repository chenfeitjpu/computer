**python**
- [定义](#定义)
- [使用](#使用)
  - [基础语法](#基础语法)
    - [运算符](#运算符)
    - [流程控制](#流程控制)
  - [数据结构](#数据结构)
    - [基础类型](#基础类型)
    - [list](#list)
    - [tuple](#tuple)

# 定义 #

# 使用 #
## 基础语法 ##
### 运算符 ###
<details>
<summary>detail</summary>

```
- 算术运算符  
  `+、-、*、/、//、%、**`
- 比较运算符  
  `>、>=、<、<=、==、!=`
- 逻辑运算符  
  `and、or、not`
- 位运算符  
  `&、｜、～、^、>>、<<`
- 成员运算符  
  `is、is not、in、not in`
- 赋值运算符  
  `=、:=`
```
</details>

### 流程控制 ###
<details>
<summary>detail</summary>

```
- 分支结构
  if condition :
  elif condition :
  else :

  match variable :  # python3.10
    case value :
    case _ :    
- 循环结构
  for value in list:
  while condition:
  
  continue 、break
  终止外层循环 使用变量标志
```
</details>

## 数据结构 ##
### 基础类型 ###
<details>
<summary>detail</summary>

```
print(0b100)            # 二进制整数
print(0o100)            # 八进制整数
print(100)              # 十进制整数
print(0x100)            # 十六进制整数
print(123.456)          # 数学写法
print(1.23456e2)        # 科学计数法
print('hello world')    # 字符串
print(True)             # bool
print(False)            # bool
```
</details>

### list ###
<details>
<summary>detail</summary>

```
- 定义
  - 字面量
    a = [1, 'a', True]
    b = a[start:end:stride] # 开始、结束、跨度
  - 生成式
    a = [i ** 2 for i in range(10)]
- 使用
  - append
  - insert
  - remove  # 删除第一个
  - pop
  - clear
  - index
  - count
  - sort
  - reverse
```
</details>

### tuple ###
<details>
<summary>detail</summary>

```
- 定义
  a = (1, 'a', True)
- 打包&解包
  a = 1, 'a', True, 100
  b, *c, d = a
- tuple & list互相转化
  fruit = ['apple', 'banana', 'orange']
  a = tuple(fruit)
  b = list(a)
```
</details>

特点  
- 不可变类型  
  - 元素不能再添加或删除，元素的值不能修改  
优点  
- 不可变类型  
  - 适合多线程环境  
  - 在创建时间上优于对应的可变类型  
