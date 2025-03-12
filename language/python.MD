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
    - [str](#str)
    - [set](#set)
    - [frozenset](#frozenset)

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
  - 函数
    c = list('hello world')
  - 生成式
    d = [i ** 2 for i in range(10)]
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
  
### str ###
<details>
<summary>detail</summary>

```
- 定义
  s1 = 'hello, world!'
  s2 = "你好，世界"
  s3 = '''hello,    # 多行注释
  wonderful
  world!'''
- 转义 & 原始字符串
  a = r'a\r\nb'
- 使用
  - len  # 获取字符串长度
  - capitalize  # 字符串首字母大写
  - title  # 字符串每个单词首字母大写
  - upper  # 字符串转大写
  - lower  # 字符串转小写
  - find  # 找不到指定的字符串会返回-1
  - index  # 找不到指定的字符串会引发ValueError错误
  - rfind  # 逆向查找
  - rindex # 逆向查找
  - startswith  # 以某个字符串开头
  - endswith  # 以某个字符串结尾
  - isdigit  # 字符串是不是完全由数字构成的
  - isalpha  # 字符串是不是完全由字母构成的
  - isalnum  # 字符串是不是由字母和数字构成的
  - center  # 居中
  - ljust  # 左对齐
  - rjust  # 右对齐
  - zfill  # 左侧补零
  - %  # 格式化
  - format  # 格式化
  - f'  # 格式化
  - strip  # 修剪掉左右两端指定字符
  - lstrip
  - rstrip
  - replace  # 用新的内容替换字符串中指定的内容
  - split  # 字符串拆分
  - join  # 字符串合并
  - encode  # 编码
  - decode  # 解码
```
</details>

特点  
- 字符串是不可变类型  

### set ###
<details>
<summary>detail</summary>

```
-定义
  - 字面量
    a = {1, 2, 3}
  - 函数
    b = set('hello')
    c = set([1, 2, 3])
  - 生成式
    d = {num for num in range(1, 20) if num % 3 == 0 or num % 7 == 0}
- 使用
  - &  交集
  - |  并集
  - ～  差集
  - ^  对称差
  - == !=  相等
  - < <=  真子集|子集
  - > >=  真超集｜超集
  - issubset  子集
  - issuperset  超集
  - add  # 添加元素
  - remove # 删除元素，不存在报KeyError错误
  - discard  # 删除元素
  - clear  # 清空元素
  - isdisjoint  # 判断两个集合有没有相同的元素，如果没有相同元素，该方法返回True
```
</details>

特点
- 要求
  - 无序
  - 互异
  - 确定  
- 集合中的元素必须是hashable类型
  - 不可变类型都是hashable类型

### frozenset ###


