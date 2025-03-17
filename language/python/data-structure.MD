**数据结构**

- [基础类型](#基础类型)
- [str](#str)
- [list](#list)
- [tuple](#tuple)
- [set](#set)
- [frozenset](#frozenset)
- [dict](#dict)
- [函数](#函数)
- [类](#类)
- [json](#json)

## 基础类型 ##
**特性**  
- 基础类型都是不可变类型

```
print(0b10)             # 二进制整数 
print(0o10)             # 八进制整数
print(10)               # 十进制整数 int() 将一个数值或字符串转换成整数，可以指定进制
print(0x10)             # 十六进制整数  
print(123.456)          # 数学写法 float() 将一个字符串转换成浮点数
print(1.23456e2)        # 科学计数法 
print('hello world')    # 字符串 str() 将指定的对象转换成字符串形式，可以指定编码方式
print(True)             # bool  bool()
```

## str ##
**特性**  
- 字符串是不可变类型  

**定义**  
```
s1 = 'hello, world!'
s2 = "你好，世界"
s3 = '''hello,    # 多行字符串
wonderful
world!'''
```

**转义 & 原始字符串**  
```
a = r'a\r\nb'
```

**函数**  
```
- len  # 获取字符串长度
- capitalize  # 字符串首字母大写
- title  # 字符串每个单词首字母大写
- upper  # 字符串转大写
- lower  # 字符串转小写
- index  # 找不到指定的字符串会引发ValueError错误
- find  # 找不到指定的字符串会返回-1
- rindex # 逆向查找
- rfind  # 逆向查找
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
- f  # 格式化
- strip  # 修剪掉左右两端指定字符
- lstrip
- rstrip
- replace  # 用新的内容替换字符串中指定的内容
- split  # 字符串拆分
- join  # 字符串合并
- encode  # 编码
- decode  # 解码
```

## list ##
**定义**  
- 字面量
  ```
  a = [1, 'a', True]
  b = a[start:end:stride] # 切片运算 开始、结束、跨度
  ```
- 函数
  ```
  c = list('hello world')
  ```
- 生成式
  ```
  d = [i ** 2 for i in range(10)]
  ```

**函数**  
```
- append  # 尾部添加
- insert  # 指定位置添加
- remove  # 删除第一个, 要删除的元素并不在列表中，会引发ValueError
- pop  # 删除指定位置或者最后一个，如果索引的值超出了范围，会引发IndexError异常
- clear  # 清空列表
- index  # 可以查找某个元素在列表中的索引位置，如果找不到指定的元素，index方法会引发ValueError错误
- count  # 统计一个元素在列表中出现的次数
- sort  # 排序
- reverse  # 反转列表
```

## tuple ##
**特性**  
- 不可变类型  
  - 元素不能再添加或删除，元素的值不能修改  
 
**优点**  
- 不可变类型  
  - 适合多线程环境  
  - 在创建时间上优于对应的可变类型  

**定义**  
```
a = (1, 'a', True)
```

**打包&解包**  
```
a = 1, 'a', True, 100
b, *c, d = a
```

**tuple & list互相转化**  
```
fruit = ['apple', 'banana', 'orange']
a = tuple(fruit)
b = list(a)
```

## set ##
*特点*
- 要求
  - 无序
  - 互异
  - 确定  
- 集合中的元素必须是hashable类型
  - 不可变类型都是hashable类型

*定义*
- 字面量
  ```
  a = {1, 2, 3}
  ```
- 函数
  ```
  b = set('hello')
  c = set([1, 2, 3])
  ```
- 生成式
  ```
  d = {num for num in range(1, 20) if num % 3 == 0 or num % 7 == 0}
  ```

*使用*
```
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

## frozenset ##
*定义*
```
a = frozenset({1, 3, 5, 7})
```

## dict ##
*定义*
- 字面量
  ```
  a = {'name': '王大锤'}
  ```
- 函数
  ```
  b = dict(name='王大锤')
  ```
- 生成式
  ```
  c = {x: x ** 3 for x in range(1, 6)}
  ```

*使用*
```
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

## 函数 ##
*定义*  
```
def functionName(arg1, arg2):
    return 'hello'
```

*参数*  
- 位置参数
  ```
  def add(a, b, c):
      return a + b + c  
  add(1, 2, 3)
  - / 设置强制位置参数
  ```
- 关键字参数  
  ```
  def add(a, b, c):
      return a + b + c  
  add(b=1, a=2, c=3)
  - * 设置命名关键字参数
  ```
- 默认参数
  ```
  def add(a, b = 0, c = 0):
      return a + b + c  
  - 带默认值的参数必须放在不带默认值的参数之后
  ```
- 可变参数
  ```
  - *args  通过元祖接收
  - **kwargs  通过字典接收
  ```

*高阶函数*  
```
一个函数作为其他函数的参数或返回值
```

*lambda(匿名函数)*
```
定义
lambda n: n % 2 == 0
```

*偏函数*
```
指固定函数的某些参数，生成一个新的函数
- 定义
  int2 = functools.partial(int, base=2)
  print(int('1001'))    # 1001
```

*装饰器*
```
用一个函数装饰另外一个函数并为其提供额外的能力  

定义
- 原生
  def record_time(func):
      def wrapper(*args, **kwargs):
          start = time.time()
          result = func(*args, **kwargs)
          end = time.time()
          print(f'{func.__name__}执行时间: {end - start:.2f}秒')
          return result
      return wrapper


  def download(filename):
      print(f'开始下载{filename}.')
      time.sleep(random.random() * 6)
      print(f'{filename}下载完成.')

  download = record_time(download)
  download('test.txt') # 装饰器函数
- @
  def record_time(func):
      @functools.wraps(func)
      def wrapper(*args, **kwargs):
          start = time.time()
          result = func(*args, **kwargs)
          end = time.time()
          print(f'{func.__name__}执行时间: {end - start:.2f}秒')
          return result
      return wrapper


  @record_time
  def download(filename):
      print(f'开始下载{filename}.')
      time.sleep(random.random() * 6)
      print(f'{filename}下载完成.')

  download('test.txt') # 装饰器函数
  download.__wrapped__('test.txt') # 原函数
```

*常见函数*
```
- filter  筛选数据
- map  转换数据
- sorted  排序数据  # 新生成一个列表
- all 检查可迭代对象(如列表、元组、集合)中的所有元素是否都为True
- functools.reduce  累积计算
```

## 类 ##
*定义*
```
class Student:

    def __init__(self, name, age):
        self.name = name
        self.age = age

    def study(self, course_name):
        print(f'{self.name}正在学习{course_name}.')

    def play(self):
        print(f'{self.name}正在玩游戏.')
```

*属性*
- 可见性
  ```
  - _私有属性 
    - 只能在类内部访问，外部无法直接访问
    - 可以通过_类名__属性访问
  - __受保护属性
    - 约定上仅在子类中使用
    - 仍可在类外部访问
  ```
- 动态属性
  ```
  __slot__ = () # 限制实例能拥有的属性
  ```

*方法*
- 实例方法
  ```
  - 第一个参数必须是self，表示实例对象
  - 访问和修改实例属性
  - 只能通过实例对象调用
  - @property 通过属性直接访问方法
  ```
- 类方法
  ```
  - 使用 @classmethod 装饰器，第一个参数是 cls，代表类本身
  - 可以访问类属性（但不能访问实例属性）
  - 既可以通过类调用，也可以通过实例调用
  ```
- 静态方法
  ```
  - 使用 @staticmethod 装饰器，没有 self 或 cls 参数
  - 不能访问实例属性
  - 不能访问类属性
  - 既可以通过类调用，也可以通过实例调用
  ```

*继承*
```
class Person:
    """人"""

    def __init__(self, name, age):
        self.name = name
        self.age = age
    
    def eat(self):
        print(f'{self.name}正在吃饭.')
    
    def sleep(self):
        print(f'{self.name}正在睡觉.')


class Student(Person):
    """学生"""
    
    def __init__(self, name, age):
        super().__init__(name, age)
    
    def study(self, course_name):
        print(f'{self.name}正在学习{course_name}.')

```

## json ##
- dict转json  
  ```
  p = {
      'name': 'xiao',
      'age': 12
  }
  print(json.dumps(p))

  p = {
      'name': 'xiao',
      'age': 12
  }
  with open('example.txt', 'w') as file:
      json.dump(p, file)
  ```
- json转dict  
  ```
  p = json.loads('{"name": "xiao", "age": 12}')

  with open('example.txt', 'r') as file:
      p = json.load(file)
  ```
