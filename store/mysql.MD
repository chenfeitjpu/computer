MySql

# 定义 #
关系型数据库

# 内容 #
## 数据类型 ##
  - 整型
    - tinyint 取值范围: 无符号0 ~ 2⁸-1 有符号-2⁷ ~ 2⁷-1; 存储空间: 1个字节
    - smallint 取值范围: 无符号0 ~ 2¹⁶-1 有符号 -2¹⁵ ~ 2¹⁵-1; 存贮空间: 2个字节
    - mediumint 取值范围: 无符号0 ~ 2²⁴-1 有符号-2²³ ~ 2²³-1; 存储空间: 3个字节
    - int 取值范围: 无符号0 ~ 2³²-1 有符号-2³¹ ~ 2³¹-1; 存储空间: 4个字节
    - longint 取值范围: 无符号0 ~ 2⁶⁴-1 有符号-2⁶³ ~ 2⁶³-1; 存储空间: 8个字节
  - 浮点数
    - float 存储空间: 4个字节
    - double 存储空间: 8个字节
  - 定点数
    - decimal(M,D) 取值范围: M1~65 D0~30 存储空间: 取决于M和D
  - 时间和日期
    - year 取值范围: 4位1901~2155 2位1970－2069; 存储空间: 1个字节
    - date 取值范围: '1000-01-01' ~ '9999-12-31'; 存储空间: 3个字节
    - time 取值范围: '-838:59:59[.000000]' ~ '838:59:59[.000000]'; 存储空间: 3个字节+小数秒的存储空间
    - datetime 取值范围: '1000-01-01 00:00:00[.000000]' ～ '9999-12-31 23:59:59'[.999999]; 存储空间: 5个字节+小数秒的存储空间
    - timestamp 取值范围: '1970-01-01 00:00:01[.000000]' ～ '2038-01-19 03:14:07'[.999999] 存储空间: 4个字节+小数秒的存储空间
  - 字符串
    - char(M) 最大长度: M个字符; 取值范围: 0~255; 存储空间: M×W
    - varchar(M) 最大长度: M个字符; 取值范围: 1~65535; 存储空间:L+1或2
    - tinytext 最大长度: 2⁸-1个字节; 存储空间: L+1个字节
    - text 最大长度: 2¹⁶-1个字节; 存储空间: L+2个字节
    - mediumtext 最大长度: 2²⁴-1个字节; 存储空间: L+3个字节
    - longtext 最大长度: 2³²-1个字节; 存储空间: L+4个字节
    - enum
    - set
  - 二进制
    - bit(M) 最大长度: M个比特位; 取值范围: 1~64; 存储空间: (M+7)/8个字节
    - binary(M) 最大长度: M个字节; 取值范围: 0~255; 存储空间: M个节
    - varbinary(M) 最大长度: M个字节; 取值范围: 1~65535; 存储空间:L+1或2个字节
    - tinyblob 最大长度: 2⁸-1个字节; 存储空间: L+1个字节
    - blob 最大长度: 2¹⁶-1个字节; 存储空间: L+2个字节
    - mediumblob 最大长度: 2²⁴-1个字节; 存储空间: L+3个字节
    - longblob 最大长度: 2³²-1个字节; 存储空间: L+4个字节

## SQL ##
### DDL ###
  - database
    - show databases 
    - create database dbname 
    - drop database dbname
    - use dbname
  - table
    - show tables
    - show create table tablename
    - desc tablename
    - create table tablename
    - alter table tablename [add column|modify column|alter column|change column|drop column|rename to]
    - drop table tablename
  - column
    - default
    - not null
    - auto_increament
    - zerofill
    - constraint
      - primary key
      - unique key
      - foreign key
### DML ### 
  - insert into tablename values
  - update tablename set 
  - delete from tablename
  - select [distinct] from [group by having] [order by] [limit start length]

## 查询 ##
### 简单查询 ###
  - where
  - order by asc, desc
  - limit start length
  - distinct

### 运算符 ###
  - 算术 +, -, *, /, %
  - 比较 \>, \>=, \<, \<=, =, !=, between and
  - 逻辑 and, or
  - 匹配 in, not in, is null, is not null
  - 通配 _, %

### 函数 ###
  - 文本处理
    - LEFT 从左边取指定长度的子串
    - RIGHT 从右边取指定长度的子串
    - LENGTH 获取字符串长度
    - UPPER 大写格式
    - LOWER 小写格式
    - LTRIM 去掉字符串左边空格
    - RTRIM 去掉字符串右边空格
    - SUBSTRING 字符串截取
    - CONCAT 字符串拼接
  - 时间
    - NOW 当前日期和时间
    - CURDATE 当前日期
    - CURTIME 当前时间
    - DATE 提取日期
    - DATE_ADD 添加指定的时间间隔
    - DATE_SUB 减去指定的时间间隔
    - DATE_DIFF 返回两个日期之间的天数
    - DATE_FORMAT 格式显示日期和时间
  - 数值
    - RAND 随机数
    - MOD 取余
    - ABS 绝对值
    - Pi 圆周率
    - EXP e的指定次方
    - SQRT 平方根
    - SIN 正弦
    - COS 余弦
    - TAN 正切
  - 聚集
    - COUNT 总数
    - MAX 最大值
    - MIN 最小值
    - SUM 求和
    - AVG 平均值

## 视图 ##
### 操作 ###
  - create view viewname as
  - drop view

## 游标 ##
### 操作 ###
  - 新建 declare cursorname cursor for
  - 打开 open cursorname
  - 读取 fetch cursorname into 
  - 异常处理 declare continue handler for not found
  - 关系 close cursorname

### 事务 ###
#### 特性 ####  
  - 原子性
  - 一致性
  - 隔离性
  - 持久性  
#### 状态 ####  
  - 活动
  - 部分提交
  - 提交
  - 失败
  - 中止
#### 操作 ####  
  - start transaction | begin
  - commit
  - rollback
  - savepoint pointname
  - release savepoint pointname
  - rollback to pointname
#### 并发问题 #### 
  - 脏写
  - 脏读
  - 不可重复读
  - 幻读  
#### 隔离级别 ####  
  - READ UNCOMMITTED
  - READ COMMITED
  - REPEATABLE READ
  - SERIALIZABLE
#### 日志 ####
redo日志  
undo日志   
#### 锁 ####
类型    
  - S锁
  - X锁

级别
  - 表锁
  - 行锁

### 查询 ###
#### 访问方式 ####
  - const
  - ref
  - ref_or_null
  - range
  - index
  - all
#### 多表查询 ####
  - 子查询
  - 连接查询
  - 组合查询
