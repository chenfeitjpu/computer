MySql
- [定义](#定义)
- [内容](#内容)
  - [数据类型](#数据类型)
  - [SQL](#sql)
    - [DDL](#ddl)
    - [DML](#dml)
  - [查询](#查询)
    - [简单查询](#简单查询)
    - [分组查询](#分组查询)
    - [子查询](#子查询)
    - [连接查询](#连接查询)
    - [组合查询](#组合查询)
    - [运算符](#运算符)
    - [函数](#函数)
    - [视图](#视图)
  - [存储程序](#存储程序)
    - [语法](#语法)
    - [存储函数](#存储函数)
    - [存储过程](#存储过程)
    - [触发器](#触发器)
    - [事件](#事件)

# 定义 #
关系型数据库

# 内容 #
## 数据类型 ##
  - **整型**  
    | 类型 | 取值范围 | 存储空间 |
    | :--- | :--- | :--- | 
    | **tinyint** | 无符号 0\~2⁸-1 &nbsp;有符号 -2⁷\~2⁷-1 | 1个字节 |
    | **smallint** | 无符号 0\~2¹⁶-1 &nbsp;有符号 -2¹⁵\~2¹⁵-1 | 2个字节 |
    | **mediumint** | 无符号 0\~2²⁴-1 &nbsp;有符号 -2²³\~2²³-1 | 3个字节 |
    | **int** | 无符号 0\~2³²-1 &nbsp;有符号 -2³¹\~2³¹-1 | 4个字节 |
    | **longint** | 无符号 0\~2⁶⁴-1 &nbsp;有符号 -2⁶³\~2⁶³-1 | 8个字节 |
  - **浮点数**
    | 类型 | 存储空间 |
    | :--- | :--- |
    | **float** | 4个字节 | 
    | **double** | 8个字节 |  
  - **定点数**
    | 类型 | 取值范围 | 存储空间 |
    | :--- | :--- | :--- |
    | **decimal(M,D)** | M 1\~65 D 0\~30 | 取决于M和D 
  - **时间和日期**
    | 类型 | 取值范围 | 存储空间 |
    | :--- | :--- | :--- |
    | **year** | 4位 1901~2155 &nbsp;2位 1970－2069 | 1个字节 |
    | **date** | '1000-01-01'~'9999-12-31' | 3个字节 |
    | **time** | '-838:59:59[.000000]'~'838:59:59[.000000]' | 3个字节+小数秒的存储空间 |
    | **datetime** | '1000-01-01 00:00:00[.000000]'~'9999-12-31 23:59:59[.999999]' | 5个字节+小数秒的存储空间 |
    | **timestamp** | '1970-01-01 00:00:01[.000000]'~'2038-01-19 03:14:07[.999999]' | 4个字节+小数秒的存储空间 |
  - **字符串**
    | 类型 | 最大长度 | 取值范围 | 存储空间 |
    | :--- | :--- | :--- | :--- |
    | **char(M)** | M个字符 | 0~255 | M×W |
    | **varchar(M)** | M个字符 | 1~65535 | L+1或2 |
    | **tinytext** | 2⁸-1个字节 |  | L+1个字节 |
    | **text** | 2¹⁶-1个字节 |  | L+2个字节 |
    | **mediumtext** | 2²⁴-1个字节 |  | L+3个字节 |
    | **longtext** | 2³²-1个字节 |  | L+4个字节 |
    | **enum** |  |  |  |
    | **set** |  |  |  | 
  - **二进制**
    | 类型 | 最大长度 | 取值范围 | 存储空间 |
    | :--- | :--- | :--- | :--- |
    | bit(M) | M个比特位 | 1\~64 | (M+7)/8个字节 | 
    | binary(M) | M个字节 | 0~255 | M个字节 | 
    | varbinary(M) | M个字节 | 1~65535 | L+1或2个字节 | 
    | tinyblob | 2⁸-1个字节 |  | L+1个字节 | 
    | blob | 2¹⁶-1个字节 |  | L+2个字节 | 
    | mediumblob | 2²⁴-1个字节 |  | L+3个字节 | 
    | longblob | 2³²-1个字节 |  | L+4个字节 | 

## SQL ##
### DDL ###
  - database
    - show databases `查看所有数据库`
    - create database dbname 穿  
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

### 分组查询 ###
  - group by having

### 子查询 ###

### 连接查询 ###
  - inner join on
  - left join on 
  - right join on

### 组合查询 ###
  - union all
  - union

### 运算符 ###
  - 算术 +, -, *, /, %
  - 比较 \>, \>=, \<, \<=, =, !=, between and
  - 逻辑 and, or
  - 匹配 in, not in, is null, is not null
  - 通配 _, %

### 函数 ###
  - 文本
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

### 视图 ###
  - show tables 查看所有视图
  - desc viewname 查看视图描述
  - show create view viewname 查看视图创建语句
  - create view viewname as select 创建视图
  - drop view viewname 删除视图

## 存储程序 ##
### 语法 ###
  - 变量
    - declare name 类型 default value 定义局部变量
    - set name=value 变量赋值
    - into name, name 多个变量赋值
    - delimiter 结束分隔符
  - 选择语句
    - if then  
      elseif then  
      else  
      end if;  
  - 循环语句
    - while do  
      end while;
    - repeat  
      until end repeat;
    - loop  
      end loop;
  - 游标
    - declare cursorname cursor for select 创建游标 
    - declare continue handler for not found 事件响应
    - open cursorname 打开游标  
    - fetch cursorname into 移动游标
    - close cursorname 关闭游标
  
### 存储函数 ###
  - show function status like 查看所有函数
  - show create function functionname 查看函数定义
  - create function functionname(参数名 数据类型, 参数名 数据类型)  
    returns 返回值类型  
    begin  
        函数体内容  
    end  
  - drop function functionname 删除函数

### 存储过程 ###
  - show procedure status like 查看所有存储过程
  - show create procedure procedurename 查看存储过程定义
  - create procedure procedurename([in|out|inout]参数名 数据类型)  
    begin  
    end  
  - drop procedure procedurename 删除存储过程

### 触发器 ###
  - show triggers 查看所有触发器
  - show create trigger triggername 查看触发器定义
  - create trigger triggername  
    {before|after} on {insert|update|delete} on tablename  
    for each row  
    begin  
      {old|new}  
    end  
  - drop trigger triggername 删除触发器
  
### 事件 ###
  - show events 查看所有事件
  - show create event eventname 查看事件定义
  - create event eventname  
    on schedual  
    {  
      at 某个确定的时间点  
      every 期望的时间间隔 [STARTS datetime][END datetime]  
    }  
    do  
    begin  
    end  
  - drop event eventname 删除事件
