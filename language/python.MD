**python**
- [定义](#定义)
- [使用](#使用)
  - [基础语法](#基础语法)
  - [数据结构](#数据结构)
    - [基础类型](#基础类型)
    - [str](#str)
    - [list](#list)
    - [tuple](#tuple)
    - [set](#set)
    - [frozenset](#frozenset)
    - [dict](#dict)
    - [函数](#函数)

# 定义 #

# 使用 #
## [基础语法](./python/syntax.MD)   ##


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

特点  
- 基础类型都是不可变类型

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
  - remove  # 删除第一个, 要删除的元素并不在列表中，会引发ValueError
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
<details>
<summary>detail</summary>

```
- 定义
  a = frozenset({1, 3, 5, 7})
```
</details>

### dict ###
<details>
<summary>detail</summary>

```
- 定义
  - 字面量
    a = {'name': '王大锤'}
  - 函数
    b = dict(name='王大锤')
  - 生成式
    c = {x: x ** 3 for x in range(1, 6)}
- 使用
  - []  # 通过索引运算获取字典中的值时，如指定的键没有在字典中，将会引发KeyError异常
  - get  # get方法在字典中没有指定的键时不会产生异常，而是返回None或指定的默认值
  - keys  # 获取字典中所有的键
  - values  # 获取字典中所有的值
  - items  # 获取字典中的键值对
  - update  # 合并两个字典
  - |   # 合并两个字典
  - pop  # 如果字典中不存在指定的键，会引发KeyError错误
  - popitem  # 用来移除字典中的最后一个键值对，并以元组的形式返回
  - clear  # 清除数据
  - del  # 删除元素  如果指定的键索引不到对应的值，会引发KeyError错误
```
</details>

### 函数 ###
<details>
<summary>detail</summary>

```
定义  
def functionName(arg1, arg2):
    return 'hello'

参数  
- 位置参数
  def add(a, b, c):
      return a + b + c  
  add(1, 2, 3)
  - / 设置强制位置参数
- 关键字参数  
  def add(a, b, c):
      return a + b + c  
  add(b=1, a=2, c=3)
  - * 设置命名关键字参数
- 默认参数
  def add(a, b = 0, c = 0):
      return a + b + c  
  - 带默认值的参数必须放在不带默认值的参数之后
- 可变参数
  - *args  通过元祖接收
  - **kwargs  通过字典接收
高阶函数
一个函数作为其他函数的参数或返回值

lambda(匿名函数)
- 定义
  lambda n: n % 2 == 0

偏函数
指固定函数的某些参数，生成一个新的函数
- 定义
  int2 = functools.partial(int, base=2)
  print(int('1001'))    # 1001

常见函数
- filter  筛选数据
- map  转换数据
- sorted  排序数据  # 新生成一个列表
- all 检查可迭代对象(如列表、元组、集合)中的所有元素是否都为True
- functools.reduce  累积计算
```
</details>



