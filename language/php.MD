**php**
- [定义](#定义)
- [使用](#使用)
  - [基础语法](#基础语法)
  - [数据类型](#数据类型)
  - [内存管理](#内存管理)
  - [架构](#架构)
  - [性能分析](#性能分析)

# 定义 #
超文本预处理器

# 使用 # 
## 基础语法 ##
```
输出
- echo  输出一个或多个字符串，非字符串值也会强制转换为字符串，没有返回值
- print  输出一个字符串，非字符串也会强制转换为字符串，始终返回1
- print_r  输出单个变量，只输出值
- var_dump  输出单个或多个变量，输出类型和值
- var_export 输出变量的可解析字符串表示

引号
- 单引号  不解析变量、转移字符直解析\\和\'
- 双引号  解析变量和转移字符
- 反引号  执行服务器命令
- 定界符  原样输出

isset & empty
- isset 检测变量是否已声明并且其值不为null
- empty 检查变量是否为空 不存在的变量、null值、或者零值

include&require
- include  文件不存在，报warning，程序继续执行，文件会多次解析
- require  文件不存在，报error，程序终止执行，文件只解析一次(文件内容替换了require语句)
- inclue_once  只加载一次
- require_once  只加载一次

$this & self & static
- $this  指向当前对象，只能访问非静态属性(不包括常量)和非静态方法，不能存在于静态方法中
- self   指向当前定义类，只能访问静态属性(包括常量)和方法
- static  指向调用定义类，只能访问静态属性(包括常量)和方法

预定义变量
- $GLOBALS  引用全局作用域中可用的全部变量
- $_SERVER  服务器和执行环境信息
- $_GET  HTTP GET变量
- $_POST  HTTP POST变量
- $_REQUEST  HTTP Request变量
- $_COOKIE HTTP Cookies
- $_SESSION Session 变量

魔术方法
- __construct
- __destruct
- __get  
- __set  
- __ call
- __callStatic
```

## 数据类型 ##
```
array
- 操作
  - array_keys
  - array_values
  - array_flip
  - array_merge
  - count
  - sort
  - array_splice
- array_merge vs 数组相加
  - 数组相加  不管索引是数字或者字符，相同索引只留先出现的
  - array_merge  索引是数字不会覆盖，索引是字符串只留后面出现的
```

## 内存管理 ##
```
内存分配
- 预分配
垃圾回收
- 引用计数
```

## 架构 ##
```
代码执行过程
- 语法&词法分析
- 编译
- 执行
```

## 性能分析 ##
```
工具
- xhprof
  - xhprof
  - xhgui
```